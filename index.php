<?php
include 'dbyhteys.php';
session_start();

if (isset($_POST["user_id"])) {
        $_SESSION["user_id"] = $_POST["user_id"];
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login_sivu.php");
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
    <link rel="stylesheet" href="style.css">
</head>
<body>                   <!--   haetaan käyttäjän tiedot ja tilit -->

<?php
    // tän vois pistää queryy ku bindataa $_SESSION muuttuja joho käyttäjä ei pääse käsiks ni ei sillee oo välii katenoidaaks
    $userData = $conn->prepare(
        "SELECT id, nimi, varat, tili_id, tilinimi, amount, IBAN
        FROM kayttajat
        LEFT JOIN tilit
        ON kayttaja_id = id
        WHERE id = :id");
        $userData->execute(["id" => $_SESSION["user_id"]]);
        $userData = $userData->fetchAll();
        
        echo '<a href="index.php">PHP pankki</a>'.
        '<a id="logout" href="logout.php">Kirjaudu ulos</a>';

        // jos käyttäjää ei löydy
        echo $userData==null ? "<br><br>Käyttäjää ei löytynyt" : "";
        if ($userData==null) {
            echo "<script defer>document.getElementById('toiminnot').style.display = 'none';</script>";
        } else {
            
            // laitettaa sessioon käyttäjän tiedot ja tilit
            $_SESSION["nimi"] = $userData[0]["nimi"];
            $_SESSION["varat"] = $userData[0]["varat"];
            $_SESSION["userData"] = $userData;
        }
    ?>


    <!-- pankki -->
    <div id="container" class="<?php echo $userData==null ? 'hidden' : ''; ?>">
        <h2>kirjautunut <?php echo $_SESSION["nimi"] ?> käyttäjänä</h2>

        <div id="toiminnot">                   <!-- toiminnot -->
            <a class="toiminto" href="omasiirto_sivu.php">Oma Siirto</a>
            <a class="toiminto" href="tilisiirto_sivu.php">Tilisiirto</a>
        
        </div>


        <div id="TilitBox">                        <!-- tilit -->
        <p>Tilit</p>
            <p>Tileilläsi on realpath_cache_get <?php echo $_SESSION["varat"] ?>£</p>
            <div id="Tilit">
                <?php foreach ($userData as $data)
                if ($data["tilinimi"])
                    echo "<div class='tili' onClick='window.location.href=`näytä_tili.php?tili_id=".$data["tili_id"]."`'>" .
                    $data["tilinimi"]. " " .
                    $data["amount"]."£<br>". 
                    (!empty($data["IBAN"]) ? $data["IBAN"] : "Tilillä ei ole numeroa
                        <script>
                            document.querySelector('.tili:last-child').style.color = 'red';
                        </script>"). 
                    "</div>";
                ?>
            </div>
        </div>
        <div id="TopTapahtumat">
            <p id="Tapahtumat_teksti">Tapahtumat</p>
            <form action="fetch.php" method="POST" style="padding-top: 20px;">
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
        <div id="Tapahtumat">                   <!-- tapahtumat -->
            <?php
                $tapahtumat = $conn->prepare(
                    "SELECT information 
                    FROM tapahtumat 
                    WHERE (reciver_account_id = :account_id OR sender_account_id = :account_id) 
                    LIMIT :limit");
                    $tapahtumat->bindParam("limit", $_SESSION["limit"], PDO::PARAM_INT);
                    $tapahtumat->bindParam("account_id", $userData[0]["tili_id"], PDO::PARAM_INT);
                    $tapahtumat->execute();
                    $tapahtumat = $tapahtumat->fetchAll();
                    
                if ($tapahtumat) {
                    foreach ($tapahtumat as $tapahtuma)
                        echo "<div class='tapahtuma'>" .$tapahtuma["information"]. "</div><br>";
                
                } else {//      piilotetaan tapahtumat jos niitä ei ole
                    echo "<script>document.getElementById('Tapahtumat_teksti').style.display = 'none';</script>";
                }
            ?>
        </div>
    </div>

    <!--degub -->
    <form method="POST" action="index.php">
        <input name="user_id" placeholder="<?php echo $_SESSION["user_id"] ?>">
        <button type="submit">h</button>
</body>
</html>