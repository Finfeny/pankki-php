<?php
include 'dbyhteys.php';
session_start();
$amount = $_POST["amount"];
$sender_account_id = explode("|", $_POST["sender_account_id"])[0];
$reciver_account_id = explode("|", $_POST["reciver_account_id"])[0];

//etsitään tilien nimet userDatasta id:n perusteella
foreach ($_SESSION["userData"] as $data) {

    if ($data["tili_id"] == $sender_account_id) {
        $sender_account_name = $data["tilinimi"];
    }
    if ($data["tili_id"] == $reciver_account_id) {
        $reciver_account_name = $data["tilinimi"];
    }
}

// Jos koettaa siirtää rahaa samalle tilille
if ($reciver_account_id == $sender_account_id) {
    $_SESSION["error"] = "Et voi siirtää rahaa samalle tilille";
    header("Location: sivut/omasiirto_sivu.php?error=1");
    die;
}

$information = $_SESSION["userData"][0]["nimi"] . " Siirsi " . $amount . "£ tililtä " . $sender_account_name . " tilille " . $reciver_account_name;
try {
    $conn->prepare(
    "INSERT INTO tapahtumat (amount, sender_account_id, reciver_account_id, information, date)
    VALUES (:amount, :sender_account_id, :reciver_account_id, :information, NOW())"
    )->execute([
        "amount" => $amount, 
        "sender_account_id" => $sender_account_id, 
        "reciver_account_id" => $reciver_account_id, 
        "information" => $information
    ]);
    // jos ei riitä rahat
} catch (PDOException $e) {
    if ($e->getCode() == '45000') {
        $_SESSION["error"] = explode("1644", $e->getMessage())[1];
        header("Location: sivut/omasiirto_sivu.php?error=1");
        die;
    }
}
header("Location: sivut/index.php");
