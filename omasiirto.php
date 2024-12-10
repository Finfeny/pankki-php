<?php
include 'dbyhteys.php';
session_start();
$amount = $_POST["amount"];
$sender_account_id = $_POST["sender_account_id"];
$reciver_account_id = $_POST["reciver_account_id"];

//etsitään tilien nimet userDatasta id:n perusteella
foreach ($_SESSION["userData"] as $data) {

    if ($data["tili_id"] == $sender_account_id) {
        $sender_account_name = $data["tilinimi"];
    }
    if ($data["tili_id"] == $reciver_account_id) {
        $reciver_account_name = $data["tilinimi"];
    }
}

$information = $_SESSION["userData"][0]["nimi"] . " Siirsi " . $amount . "£ tililtä " . $sender_account_name . " tilille " . $reciver_account_name;

$conn->prepare(
"INSERT INTO tapahtumat (amount, sender_account_id, reciver_account_id, information) 
VALUES (:amount, :sender_account_id, :reciver_account_id, :information)")->execute([
"amount" => $amount,
"sender_account_id" => $sender_account_id,
"reciver_account_id" => $reciver_account_id,
"information" => $information
]);

header("Location: index.php");