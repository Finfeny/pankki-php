<?php
include '../dbyhteys.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>omasiirto</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <a class="backarrow" href="index.php" style="position: absolute; left: 20px;">&#8592;</a>
    <a href="index.php">PHP pankki</a>
    <br><br>
    <form method="POST" action="../omasiirto.php" style='display: flex; flex-direction: column; gap: 10px'>
        <?php
            
            echo "<div style='display: flex; gap: 10px;'>Tilitä<select name='sender_account_id'>";

            foreach ($_SESSION["userData"] as $data) {
                echo "<option value='".$data["tili_id"]."'>".$data["tilinimi"]."</option>";
            }
            echo "</select></div>";

            echo "<div style='display: flex; gap: 10px;'>Tilille<select name='reciver_account_id'>";

            foreach ($_SESSION["userData"] as $data) {
                echo "<option value='".$data["tili_id"]."'>".$data["tilinimi"]."</option>";
            }
            echo "</select></div>";
        ?>
            <input type="number" name="amount" placeholder="Määrä" style="">
            <input type="submit" value="Siirrä">
    </form>
    <div class="errormsg">
        <?php
            if (isset($_GET["error"]) && $_GET["error"] == 1) {
                echo "Tilillä ei ole tarpeeksi varoja";
            }
        ?>
    </div>
</body>
</html>