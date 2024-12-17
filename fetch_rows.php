<?php
include 'dbyhteys.php';
session_start();

header('Content-Type: application/json');

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

$query = "SELECT information, date FROM tapahtumat WHERE (";

$conditions = [];
$params = [];
foreach ($_SESSION["userData"] as $index => $data) {
    $conditions[] = "reciver_account_id = :account_id_$index";
    $conditions[] = "sender_account_id = :account_id_$index";
    $params["account_id_$index"] = $data["tili_id"];
}

$query .= implode(" OR ", $conditions) . ") ORDER BY date DESC LIMIT :limit OFFSET :offset";

$tapahtumat = $conn->prepare($query);
$tapahtumat->bindValue(":limit", $limit, PDO::PARAM_INT);
$tapahtumat->bindValue(":offset", $offset, PDO::PARAM_INT);

foreach ($params as $key => $value) {
    $tapahtumat->bindValue(":$key", $value, PDO::PARAM_INT);
}

$tapahtumat->execute();
$data = $tapahtumat->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
exit;
?>
