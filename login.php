
<?php
include 'dbyhteys.php';
session_start();

if ($_POST != []) {
    $username = $_POST["userID"];
    $password = $_POST["password"];
} else {
    var_dump($_GET);
    $username = $_GET["userID"];
    $password = $_GET["password"];
}


$sql = $conn->prepare("SELECT id, salasana FROM kayttajat WHERE kayttajatunnus = :userID");
$sql->execute(["userID" => $username]);

$user = $sql->fetch();

var_dump($user);

if ($user && password_verify($password, $user["salasana"])) {
    $_SESSION["user_id"] = $user["id"];
    header("Location: sivut/index.php");
} else {
    $_SESSION["login_status"] = "Käyttäjätunnus tai salasana väärin";
    header("Location: sivut/login_sivu.php");
    die;
}