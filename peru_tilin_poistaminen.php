<?php
include "dbyhteys.php";
session_start();

var_dump($_GET);

$conn->query(
    "UPDATE tilit 
    SET deleted = 0 
    WHERE tili_id = '" .$_GET["tili_id"]. "' 
    AND kayttaja_id = '" .$_SESSION["user_id"]. "'");

header("location: sivut/index.php");
?>