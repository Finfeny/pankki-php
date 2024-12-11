<?php
include "dbyhteys.php";
session_start();

//query o maholline riski mut en usko koska käyttäjä ei pääs käsisk session_id:hen
$conn->query(
    "DELETE FROM tilit 
    WHERE tili_id = '" .$_GET["tili_id"]. "' 
    AND kayttaja_id = '" .$_SESSION["user_id"]. "'");

header("location: index.php");
?>