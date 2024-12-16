<?php
include "dbyhteys.php";
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] != 1) {
    header("Location: sivut/index.php");
    exit();
}

$conn->query("UPDATE tilit SET deleted = 2 WHERE tili_id = '" .$_GET["tili_id"]. "'");
header("location: sivut/admin_sivu.php");