<?php
include 'dbyhteys.php';
session_start();

if (isset($_POST["user_id"])) {
        $_SESSION["user_id"] = $_POST["user_id"];
    
} else {
    $_POST["user_id"] = "23";
    // var_dump($_SESSION);
}
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>                   <!--   haetaan käyttäjän tiedot ja tilit -->

<?php
    $userData = $conn->prepare(
        "SELECT id, nimi, varat, tili_id, tilinimi, amount FROM kayttajat LEFT JOIN tilit ON kayttaja_id = id WHERE id = :id");
        $userData->execute(["id" => $_SESSION["user_id"]]);
        $userData = $userData->fetchAll();

        // laitettaa sessioon käyttäjän tiedot ja tilit
        $_SESSION["nimi"] = $userData[0]["nimi"];
        $_SESSION["varat"] = $userData[0]["varat"];
        $_SESSION["userData"] = $userData;
    ?>


    <!-- pankki -->
    <a href="index.php">PHP pankki</a>
    <h2>kirjautunut <?php echo $_SESSION["nimi"] ?> käyttäjänä<h2>

    <div id="toiminnot">                   <!-- toiminnot -->
         <a class="toiminto" href="omasiirto_sivu.php">Oma Siirto</a>
         <a class="toiminto" href="tilisiirto_sivu.php">Tilisiirto</a>
    
    </div>


    <div id="Tilit">                        <!-- tilit -->
        <p>Tilit<p>
        <p>Tileilläsi on realpath_cache_get <?php echo $_SESSION["varat"] ?>€</p>

            <?php foreach ($userData as $data)
                echo "<div class='tili'>" .$data["tilinimi"]. "   " .$data["amount"]."€". "</div><br>";
            ?>
    </div>

    <p>Tapahtumat<p>
    <div id="Tapahtumat">                   <!-- tapahtumat -->
        <?php
            $tapahtumat = $conn->prepare(
                "SELECT information FROM tapahtumat WHERE reciver_account_id = :reciver_account_id");
                $tapahtumat->execute(["reciver_account_id" => $userData[0]["tili_id"]]);
                $tapahtumat = $tapahtumat->fetchAll();
                
                foreach ($tapahtumat as $tapahtuma)
                    echo "<div class='tapahtuma'>" .$tapahtuma["information"]. "</div><br>";
        ?>
    </div>

    <!--degub -->
    <form method="POST" action="index.php">
        <input name="user_id" placeholder="<?php echo $_SESSION["user_id"] ?>">
        <button type="submit">h</button>
</body>
</html>