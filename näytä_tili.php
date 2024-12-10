<?php
include 'dbyhteys.php';
session_start();
var_dump($_GET); // array(1) { ["tili_id"]=> string(1) "1" }
echo "<br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tili</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php">PHP pankki</a>
    <br><br>
    <h2><?php echo $_GET["tili_id"] ?></h2>
</body>
</html>