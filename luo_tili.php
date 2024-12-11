<?php
include 'dbyhteys.php';
session_start();

if (trim($_POST["tilinimi"]) == "") {
    header("location: sivut/index.php");
    die;
}

$conn->prepare(
    "INSERT INTO tilit (tilinimi, kayttaja_id, amount) 
    VALUES (:tilinimi, :kayttaja_id, amount)")->
    execute([
        "tilinimi" => $_POST["tilinimi"],
        "kayttaja_id" => $_SESSION["user_id"],
    ]);

    header("location: sivut/index.php");
?>