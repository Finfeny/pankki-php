<!-- "INSERT INTO tapahtumat (amount, sender_account_id, reciver_account_id, information) VALUES (:amount, :sender_account_id, :reciver_account_id, :information)"; -->
<?php
include 'dbyhteys.php';
session_start();
var_dump($_POST);

$amount = $_POST["amount"];
$sender_account_id = $_POST["sender_account_id"];

$sql = $conn->prepare(
    "SELECT tili_id FROM tilit WHERE IBAN = :reciver_account_id")->execute([
    "reciver_account_id" => $reciver_account_id
    ])->fetchAll();
var_dump($sql);

// $sender_account_id = $sql;
// if (is_int($reciver_account_id)) {
//     $reciver_account_id = $_POST["reciver_account_id"];
// } else {
    

$information = "Siirto";

$conn->prepare(
"INSERT INTO tapahtumat (amount, sender_account_id, reciver_account_id, information) 
VALUES (:amount, :sender_account_id, :reciver_account_id, :information)")->execute([
"amount" => $amount,
"sender_account_id" => $sender_account_id,
"reciver_account_id" => $reciver_account_id,
"information" => $information
]);

header("Location: index.php");