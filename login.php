<?php
include 'dbyhteys.php';
session_start();

$username = $_POST["userID"];
$password = $_POST["password"];

$sql = $conn->prepare("SELECT id FROM kayttajat WHERE kayttajatunnus = :userID AND salasana = :password");
$sql->execute(["userID" => $username, "password" => $password]);
$user_id = $sql->fetchAll()[0]["id"];

if ($user_id) {
    $_SESSION["user_id"] = $user_id;
    header("Location: index.php");
} else {
    $_SESSION["login_status"] = "Käyttäjätunnus tai salasana väärin";
    header("Location: login_sivu.php");
}