<?php
include "dbyhteys.php";
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] != 1) {
    header("Location: sivut/index.php");
    exit();
}

var_dump($_POST);
echo "<br>";
var_dump($_GET);

// $conn->query("INSERT INTO tilit WHERE kayttaja_id");

?>