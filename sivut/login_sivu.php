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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body style="margin-top: 40vh;">
    <div id="content" style="display : grid; min-height: 240px; margin-bottom: 20px">
        <a id="title">PHP pankki</a>
        <form id="loginForm" class="InputBox" method="POST" action="../default.php" style='display: grid; justify-content: center; gap: 10px'>
            <input 
                class="loginPageInput" 
                type="text"
                name="userID" 
                placeholder="Käyttäjätunnus"
                >
            <input 
                class="loginPageInput" 
                type="password" 
                name="password" 
                placeholder="Salasana"
                >
            <input 
                class="loginPageInput" 
                type="text"
                name="name" 
                id="nameInput" 
                placeholder="Nimi" 
                style="display: none"
            >
            <div id="buttons">
                <input 
                    id="LoginButton" 
                    class="loginPageButton" 
                    type="submit"
                    value="Kirjaudu"
                    onClick="$('#loginForm').attr('action', '../login.php')"
                >
                <button
                    id="ShowRegisterInputButton"
                    class="loginPageButton"
                    type="button"
                    onClick="showRegister()"
                    > Uusi käyttäjä
                </button>
                <input
                    id="RegisterButton"
                    class="loginPageButton"
                    style="display: none"
                    type="submit"
                    value="Luo käyttäjä"
                    onClick="$('#loginForm').attr('action', '../register.php')"
                    >
                </input>
            </div>
        </form>
    </div>
    <div id="loginStatus">
        <?php
            if (isset($_SESSION["login_status"])) {
                echo $_SESSION["login_status"];
            }
        ?>
    </div>
</body>
<script>

    function showRegister() {
        $("#content").css(
            "minHeight", "290px");

        $("#nameInput").css(
            "display", "block");

        $("#title").css(
            "height", "26px");

        $("#ShowRegisterInputButton").css(
            "display", "none");

        $("#RegisterButton").css(
            "display", "block");
    }

</script>
</html>