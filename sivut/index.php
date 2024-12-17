<?php
include '../dbyhteys.php';
session_start();

if (isset($_POST["user_id"])) {
        $_SESSION["user_id"] = $_POST["user_id"];
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login_sivu.php");
    exit();
}

if ($_SESSION["user_id"] == 1) {
    header("Location: admin_sivu.php");
    exit();
}

if (!isset($_SESSION["limit"]) || $_SESSION["limit"] == null) {
    $_SESSION["limit"] = "10";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pankki</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>                   <!--   haetaan käyttäjän tiedot ja tilit -->

<?php
    // tän vois pistää queryy ku bindataa $_SESSION muuttuja joho käyttäjä ei pääse käsiks ni ei sillee oo välii katenoidaaks
    $userData = $conn->prepare(
        "SELECT id, nimi, varat, deleted, tili_id, tilinimi, amount, IBAN
        FROM kayttajat
        LEFT JOIN tilit
        ON kayttaja_id = id 
        WHERE id = :id AND tilit.deleted != 2");
        $userData->execute(["id" => $_SESSION["user_id"]]);
        $userData = $userData->fetchAll();
        
        echo '<a id="title" href="index.php">PHP pankki</a>'.
        '<a id="logout" href="../logout.php">Kirjaudu ulos</a>';

        // jos käyttäjää ei löydy
        echo $userData == null ? "<br><br>Käyttäjää ei löytynyt" : "";
        if ($userData != null) {
            
            // laitettaa sessioon käyttäjän tiedot ja tilit
            $_SESSION["nimi"] = $userData[0]["nimi"];
            $_SESSION["varat"] = $userData[0]["varat"];
            $_SESSION["userData"] = $userData;
        }
    ?>


    <!--degub -->
    <!-- <form method="POST" action="index.php">
        <input name="user_id" placeholder="<?php echo $_SESSION["user_id"] ?>">
        <button type="submit">id</button>
    </form> -->

    <!-- pankki -->
    <div id="container" class="<?php echo $userData==null ? 'hidden' : ''; ?>">
        <h2>kirjautunut <?php echo $_SESSION["nimi"] ?> käyttäjänä</h2>

        <div id="toiminnot">                   <!-- toiminnot -->
            <a class="toiminto" href="omasiirto_sivu.php">Oma Siirto</a>
            <a class="toiminto" href="tilisiirto_sivu.php">Tilisiirto</a>
        </div>


        <div id="TilitBox">                        <!-- tilit -->
            <div id="tilitOtsikkoWlisäys">Tilit
                <button
                    class="nappi1"
                    id="lisääTiliNappiPlus" 
                    onClick="
                    $('#tilitForm, #lisääTiliNappiMiinus').css('display', 'inline-block'); 
                    $(this).css('display', 'none')"
                    > +
                </button>
                <button 
                    class="nappi1"
                    id="lisääTiliNappiMiinus" 
                    style="display: none; padding-inline: 6px;"
                    onClick="$('#tilitForm').css('display', 'none');
                    $(this).css('display', 'none');
                    $('#lisääTiliNappiPlus').css('display', 'inline-block')" 
                    > -
                </button>
            </div>
            <p>Tileilläsi on realpath_cache_get <?php echo $_SESSION["varat"] ?>£</p>
            <div id="Tilit">
                <?php foreach ($userData as $data)
                if ($data["tilinimi"])
                    echo "<div class='tili' onClick='window.location.href=`näytä_tili.php?tili_id=".$data["tili_id"]."`'>" .
                    $data["tilinimi"]. " " .
                    $data["amount"]."£<br>". 
                    (!empty($data["IBAN"]) ? $data["IBAN"] : "Tilillä ei ole numeroa. Odotetaan adminin hyväksyntää...
                        <script>
                            document.querySelector('.tili:last-child').style.color = '#b0f4fff2';
                        </script>").
                        // poista tili nappi jos tilillä ei ole rahaa ja jos tili ei ole poistettu
                    ($data["amount"] != 0 || $data["deleted"] != 0 ? "" :
                        "<button id='PoistaTili' onClick='event.stopPropagation(); window.location.href=`../poista_tili.php?tili_id=".$data["tili_id"]."`'>
                            poista
                        </button>").
                        // kumoa poisto nappi jos tili on poistettu
                    ($data["deleted"] == 0 ? "" :
                        " Tili poistettu. Odotetaan adminin hyväksyntää...
                        <script>
                            document.querySelector('.tili:last-child').style.color = '#5d5d68';
                        </script>
                        <button id='PeruTilinPoistaminen' onClick='event.stopPropagation(); window.location.href=`../peru_tilin_poistaminen.php?tili_id=".$data["tili_id"]."`'>
                            kumoa
                        </button>").
                    "</div>";       // stopPropagation käytettää ettei kutsu näytä_tili vaa menee suoraa posita_tili
                ?>
            </div>                      <!-- tilin lisäys formi -->
            <div id="tilitForm" style="display: none; position: relative;">
                <form action="../luo_tili.php" method="POST">
                    <input id="uusiTiliInput" type="text" name="tilinimi" placeholder="tilinimi">
                    <input id="uusiTiliSubmit" type="submit" value="Luo tili">
                </form>
            </div>
        </div>
        <div id="TopTapahtumat">
            <p id="Tapahtumat_teksti">Tapahtumat</p>
            <form action="../fetch.php" method="POST" style="padding-top: 20px;">
                <select name="limit" id="Tapahtumat_valinta" onChange="this.form.submit()">
                    <option value="" selected>max</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </form>
        </div>
        <!--        kokeilen tälläst systeemii et ladataan tapahtumat ku scrollataan ni sitä mukaa       -->

        <div id="Tapahtumat">              <!-- tapahtumat -->
            <!-- Rows will be dynamically loaded here -->
        </div>
        <div id="loading" style="display: none;">Loading...</div>
    </div>
</body>
<script>
    
    // vaihtaa tilin luonnin napiksi "+" tai "Luo tili" riippuen onko näyttö pieni vai ei
    const mediaQuery = window.matchMedia('(min-width: 900px)');
    
    function updateSubmitValue() {
        $("#uusiTiliSubmit").val(mediaQuery.matches ? "Luo tili" : "+");
    }
    
    mediaQuery.addEventListener('change', updateSubmitValue);
    
    updateSubmitValue(mediaQuery);

    
    // lataa tapahtumat ku scrollataan nopeuden perusteella

    let offset = 0; // Tracks how many rows have been loaded
    let isLoading = false; // Prevents overlapping requests
    let allDataLoaded = false; // Stops fetching when no more data is available
    let lastScrollY = 0; // Stores the previous scroll position
    let lastTime = Date.now(); // Tracks the last time the scroll event fired

    const container = document.getElementById("Tapahtumat");

    async function fetchRows(limit) {
        if (isLoading || allDataLoaded) return; // Stop if already loading or all data is loaded
        isLoading = true;

        document.getElementById("loading").style.display = "block";

        try {
            // Fetch rows from server
            const response = await fetch(`../fetch_rows.php?offset=${offset}&limit=${limit}`);
            const data = await response.json();

            // If no data is returned or fewer rows than limit, mark all data as loaded
            if (data.length < limit) {
                allDataLoaded = true;
                console.log("All rows have been fetched!");
            }

            // Append rows to container
            data.forEach(row => {
                const div = document.createElement("div");
                div.className = "tapahtumaDesc";
                if (!row.date) {
                    row.date = "tuntematon ajankohta";
                }
                div.innerHTML = `
                    ${row.information}
                    <div>${row.date}</div>
                `;
                container.appendChild(div);
            });

            offset += data.length; // Update offset
        } catch (error) {
            console.error("Error fetching rows:", error);
        }

        document.getElementById("loading").style.display = "none";
        isLoading = false;
    }

    function calculateDynamicLimit() {
        const currentScrollY = window.scrollY; // Current scroll position
        const currentTime = Date.now(); // Current time in milliseconds

        // Calculate distance and time difference
        const distanceScrolled = Math.abs(currentScrollY - lastScrollY);
        const timeElapsed = currentTime - lastTime;

        // Scroll speed = distance per unit time (pixels per 100ms for simplicity)
        const scrollSpeed = (distanceScrolled * 10) / (timeElapsed || 1);

        console.log("Scroll Speed:", scrollSpeed);

        // Update the last position and time
        lastScrollY = currentScrollY;
        lastTime = currentTime;

        if (scrollSpeed > 90) return 0; // Reloading the page causes sometimes high scroll speed

        // Determine the number of rows to fetch based on scroll speed
        if (scrollSpeed > 25) return 40; // Really Fast scroll → fetch 40 rows
        if (scrollSpeed > 20) return 20; // Fast scroll → fetch 20 rows
        if (scrollSpeed > 15) return 15; // Medium scroll → fetch 15 rows
        if (scrollSpeed > 10) return 10; // Slow Medium scroll → fetch 10 rows
        if (scrollSpeed > 5) return 5; // Slow scroll → fetch 5 rows
        return 3; // Really slow scroll → fetch 3 rows
    }

    function throttle(func, delay) {
        let timeout = null;
        return (...args) => {
            if (!timeout) {
                timeout = setTimeout(() => {
                    func.apply(this, args);
                    timeout = null;
                }, delay);
            }
        };
    }

    window.addEventListener("scroll", throttle(() => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
        const limit = calculateDynamicLimit();
        fetchRows(limit);
    }
    }, 200)); // Throttle to fire once every 200ms

    // Initial load
    fetchRows(10);


</script>
</html>