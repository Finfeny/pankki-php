<?php
    session_start();
    if (isset($_POST["limit"])) {
        $_SESSION["limit"] = $_POST["limit"];
    }
    var_dump($_SESSION["limit"]);
    var_dump($_POST);
    
    if ($_POST["pageButton"] == "next") {
        $_SESSION["offset"] += $_SESSION["limit"];
    } else if ($_POST["pageButton"] == "last") {
        $_SESSION["offset"] -= $_SESSION["limit"];
    }
    header("Location: sivut/index.php");
?>