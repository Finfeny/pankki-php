<?php
include 'dbyhteys.php';
session_start();

var_dump($_POST);

$amount = $_POST["amount"];
$sender_account_IBAN = explode("/", $_POST["sender_account_IBAN"])[1];
$reciver_account_IBAN = $_POST["reciver_account_IBAN"];
$sender_account_id = explode("/", $_POST["sender_account_IBAN"])[0];

$sql = $conn->prepare("SELECT tili_id FROM tilit WHERE (IBAN = :reciver_account_IBAN)");
$sql->execute(["reciver_account_IBAN" => $reciver_account_IBAN]);
$reciver_account_id = $sql->fetch();

if (!$reciver_account_id) {
    $_SESSION["error"] = "Tilinumeroa ei löytynyt";
    header("Location: sivut/tilisiirto_sivu.php");
    die();
}

$reciver_account_id = $reciver_account_id["tili_id"];

//etsitään sender tilin nimi userDatasta id:n perusteella
foreach ($_SESSION["userData"] as $data) {

    if ($data["tili_id"] == $sender_account_IBAN) {
        $sender_account_name = $data["tilinimi"];
    }
}

$information = $_SESSION["userData"][0]["nimi"] . " Siirsi " . $amount . "£ tililtä " . $sender_account_IBAN . " tilille " . $reciver_account_IBAN;
// echo $information;

echo "<br>";
echo "<br>";
echo "<br>";

$conn->prepare(
"INSERT INTO tapahtumat (amount, sender_account_id, reciver_account_id, information, date)
VALUES (:amount, :sender_account_id, :reciver_account_id, :information, NOW())"
)->execute([
    "amount" => $amount, 
    "sender_account_id" => $sender_account_id, 
    "reciver_account_id" => $reciver_account_id, 
    "information" => $information
]);

header("Location: sivut/index.php");