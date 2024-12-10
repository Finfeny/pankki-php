<?php
include 'dbyhteys.php';
session_start();
// var_dump($_POST);

$amount = $_POST["amount"];
$sender_account_id = $_POST["sender_account_id"];
$reciver_account_IBAN = $_POST["reciver_account_IBAN"];


$sql = $conn->prepare("SELECT tili_id FROM tilit WHERE IBAN = :reciver_account_IBAN");
$sql->execute(["reciver_account_IBAN" => $reciver_account_IBAN]);
$reciver_account_id = $sql->fetchAll()[0]["tili_id"];

var_dump($reciver_account_id);

//etsitään sender tilin nimi userDatasta id:n perusteella
foreach ($_SESSION["userData"] as $data) {

    if ($data["tili_id"] == $sender_account_id) {
        $sender_account_name = $data["tilinimi"];
    }
}

$information = $_SESSION["userData"][0]["nimi"] . " Siirsi " . $amount . "£ tililtä " . $sender_account_name . " tilille " . $reciver_account_IBAN;
echo $information;

$conn->prepare(
"INSERT INTO tapahtumat (amount, sender_account_id, reciver_account_id, information) 
VALUES (:amount, :sender_account_id, :reciver_account_id, :information)")->execute([
"amount" => $amount,
"sender_account_id" => $sender_account_id,
"reciver_account_id" => $reciver_account_id,
"information" => $information
]);

header("Location: index.php");