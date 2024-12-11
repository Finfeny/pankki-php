<?php
include '../dbyhteys.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tili</title>
    <link rel="stylesheet" href="../style.css"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <a class="backarrow" href="index.php" style="position: absolute; left: 20px;">&#8592;</a>
    <a href="index.php">PHP pankki</a>
    <br><br>
    <?php 
        $tiliData = $conn->query(
            "SELECT tilinimi, IBAN, amount
            FROM tilit 
            WHERE tili_Id = '" . $_GET["tili_id"] . "' 
            AND kayttaja_id = '" .$_SESSION["user_id"]. "'"
            )->fetch();
            
            // var_dump($tiliData);
            
    ?>
    <div id="tilitiedot">
        <div id="tilinimiBox">
            <h2 id="tilinimi"><?php echo $tiliData["tilinimi"] ?></h2>
            <button onClick="$('#tilinimi').attr('contentEditable', 'true').css('color', '#b2f4ff').focus()">Muokkaa</button>
        </div>
        <!-- formi joka lähettää muokatun tilinimen kun poistutaan contentEditable elementistä-->
        <form action="muokkaa_tili.php" method="post">
            <input type="hidden" name="newName" id="newName">
            <input type="hidden" name="tili_id" value="<?php echo $_GET["tili_id"] ?>">
            <input type="submit" value="Tallenna" style="display: none;">
        </form>
        <p><?php echo $tiliData["IBAN"] ?></p>
        <p>realpath_cache_get: <?php echo $tiliData["amount"] ?>£</p>
    </div>
    <br>
    <div id="Tapahtumat">                   <!-- tapahtumat -->
        <?php
            $tapahtumat = $conn->prepare(
                "SELECT information
                FROM tapahtumat
                WHERE (reciver_account_id = :account_id OR sender_account_id = :account_id)");
                $tapahtumat->execute(["account_id" => $_GET["tili_id"]]);
                $tapahtumat = $tapahtumat->fetchAll();
                
            if ($tapahtumat) {
                foreach ($tapahtumat as $tapahtuma)
                    echo "<div class='tapahtuma'>" .$tapahtuma["information"]. "</div><br>";
            
            } else {//      piilotetaan tapahtumat jos niitä ei ole
                echo "<script>document.getElementById('Tapahtumat_teksti').style.display = 'none';</script>";
            }
        ?>
    </div>
</body>
<script>
    
    const tilinimi = document.getElementById("tilinimi");

    tilinimi.addEventListener('blur', () => {
        document.getElementById("newName").value = tilinimi.innerText;
        document.querySelector("input[type='submit']").click();
    });

    tilinimi.addEventListener('keydown', (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            document.getElementById("newName").value = tilinimi.innerText;
            document.querySelector("input[type='submit']").click();
        }
    });
    
</script>

</html>