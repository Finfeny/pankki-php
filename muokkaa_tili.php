<?php
include 'dbyhteys.php';
if (!isset($_POST["newName"]) || !isset($_POST["tili_id"]) || trim($_POST["newName"]) == "") {
    header("location: näytä_tili.php?tili_id=". $_POST["tili_id"] ."");
    exit();
}

$conn->prepare("UPDATE tilit SET tilinimi = :newName WHERE tili_id = :tili_id")->execute(["newName" => trim($_POST["newName"]), "tili_id" => $_POST["tili_id"]]);

header("location: sivut/näytä_tili.php?tili_id=". $_POST["tili_id"] ."");
?>