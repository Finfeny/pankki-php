<?php
include '../dbyhteys.php';
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] != 1) {
    header("Location: login_sivu.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div id="admin">
        <a href="index.php">PHP pankki</a>
        <a id="logout" href="../logout.php">Kirjaudu ulos</a>
        <br><br>
        <br>
        <div id="tiliPyynnöt">
            <?php
                $pending_accounts = $conn->query(
                    "SELECT tilit.tilinimi, kayttajat.nimi 
                    FROM tilit, kayttajat
                    WHERE tilit.kayttaja_id = kayttajat.id 
                    AND IBAN = ''")->fetchAll();

                echo "<h1> </h1>";
                foreach ($pending_accounts as $pending_account) {
                    echo "<div class='pending_tiliTaulu'>".
                            $pending_account["nimi"]. " ". $pending_account["tilinimi"].
                        "</div>";
                }
            ?>
        </div>
</body>
</html>