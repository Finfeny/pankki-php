<?php
include "dbyhteys.php";
session_start();

var_dump($_GET);

$isNewAcc = $conn->query(
    "SELECT IBAN 
    FROM tilit 
    WHERE tili_id = '" .$_GET["tili_id"]. "' 
    AND kayttaja_id = '" .$_SESSION["user_id"]. "'")->fetchAll();

//  katsotaan onko tili uusi
var_dump($isNewAcc);

// jos on niin poistetaan muuten menee arkistoon adminin hyväksynnän jälkeen
if ($isNewAcc[0]["IBAN"] == null) {
    $conn->query(
        "DELETE FROM tilit 
        WHERE tili_id = '" .$_GET["tili_id"]. "' 
        AND kayttaja_id = '" .$_SESSION["user_id"]. "'");
} else {

    $conn->query(
        "UPDATE tilit 
        SET deleted = 1
        WHERE tili_id = '" .$_GET["tili_id"]. "' 
        AND kayttaja_id = '" .$_SESSION["user_id"]. "'");
}
header("location: sivut/index.php");
?>