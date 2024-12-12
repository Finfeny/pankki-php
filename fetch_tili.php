<?php
    session_start();
    $_SESSION["limit"] = $_POST["limit"];
    var_dump($_SESSION);
    var_dump($_POST);
    header("Location: sivut/index.php");
?>