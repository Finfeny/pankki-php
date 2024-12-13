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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <a class="backarrow" href="index.php" style="position: absolute; left: 20px;">&#8592;</a>
    <a id="title" href="index.php">PHP pankki</a>
    <br><br>
    <form method="POST" action="../omasiirto.php" style='display: flex; flex-direction: column; gap: 10px'>
        <?php
            
            echo "<div style='display: flex; 
                    gap: 10px;'>Tilitä<select name='sender_account_id' 
                    onChange='tiliSaldo(this)'>";

            foreach ($_SESSION["userData"] as $data) {
                echo "<option value='".$data["tili_id"]."'>".$data["tilinimi"]."</option>";
            }
            echo "</select><div id='tilinSaldo'>Saldo</div></div>";

            echo "<div style='display: flex;
                    gap: 10px;'>Tilille<select name='reciver_account_id'
                    onChange='tiliSaldo(this)'>";

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
                echo $_SESSION["error"];
            }
        ?>
    </div>
</body>
<script>

    function tiliSaldo(e) {
        console.log($("#tilinSaldo", e.parentElement))
    }
    
</script>
</html>