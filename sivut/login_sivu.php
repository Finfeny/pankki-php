<?php
include '../dbyhteys.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body style="margin-top: 40vh;">
    <div style="display : grid; min-height: 200px; margin-bottom: 20px">
        <a id="title">PHP pankki</a>
        <form class="InputBox" method="POST" action="../login.php" style='display: grid; justify-content: center; gap: 10px'>
            <input class="loginInput" type="text" name="userID" placeholder="Käyttäjätunnus">
            <input class="loginInput" type="password" name="password" placeholder="Salasana">
            <input class="loginButton" type="submit" value="Kirjaudu">
        </form>
    </div>
    <?php
        if (isset($_SESSION["login_status"])) {
            echo $_SESSION["login_status"];
        }
    ?>
</body>
</html>