<?php
include "dbyhteys.php";
session_start();
var_dump($_POST);

if($_POST["userID"] == "" || $_POST["name"] == "" || $_POST["password"] == "") {
    $_SESSION["login_status"] = "Täytä kaikki kentät";
    header("Location: sivut/login_sivu.php");
    die;
}

// jos halutaa tsekata et onko samanimine ja salasanane käyttäjä jo olemas ni sit pitää vissii tehä viel yks sql pyyntö
$sql = $conn->prepare("SELECT id FROM kayttajat WHERE kayttajatunnus = :userID");
$sql->execute(["userID" => $_POST["userID"]]);
$user = $sql->fetch();
if ($user) {
    $_SESSION["login_status"] = "Nää et voi tehrä kahta käyttäjää samoil tunnuksil ku se ei nyt vaa toimi jostai kumma syyst ku mul ei makseta täst tarpeeks";
    header("Location: sivut/login_sivu.php");
    die;
}

try {
$conn->prepare(
    "INSERT INTO kayttajat (kayttajatunnus, salasana, nimi) 
    VALUES (:userID, :password, :name)")->execute([
        "userID" => $_POST["userID"],
        "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
        "name" => $_POST["name"]
    ]);
// nyt esimerkkisyistä ku luo käyttäjä ni tulee tili mis 100£
    $conn->prepare(
        "INSERT INTO tilit (kayttaja_id, tilinimi, IBAN, amount) 
        VALUES (:id, 'käyttötili', :IBAN1, 0), (:id, 'etutili', :IBAN2, 100)")->execute([
            "id" => $conn->lastInsertId(),
            "IBAN1" => "FI" .rand(1000000000000000, 9999999999999999),
            "IBAN2" => "FI" .rand(1000000000000000, 9999999999999999)
    ]);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

header("Location: login.php?userID=" .urlencode($_POST["userID"]). "&password=" .urlencode($_POST["password"]));
exit;
?>