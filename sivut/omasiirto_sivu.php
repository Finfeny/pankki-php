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

                //jos tili on poistettu ni ei sit pysty siirtää rahaa sinn
                if ($data["deleted"] == 1)
                    continue;
                // tä o iha kätevä tapa laittaa paljo parametrei ja value="2|3214310" täs
                echo "<option 
                        value='"
                        .$data["tili_id"]."|"
                        .$data["amount"]."'>"
                        .$data["tilinimi"].
                    "</option>";
            }
            echo "</select><div class='tilinSaldo'>Saldo: " .$_SESSION["userData"][0]["amount"]. "</div></div>";


            echo "<div style='display: flex;
                    gap: 10px;'>Tilille<select name='reciver_account_id'
                    onChange='tiliSaldo(this)'>";

            foreach ($_SESSION["userData"] as $data) {

                if ($data["deleted"] == 1)
                    continue;
                echo 
                "<option 
                    value='"
                    .$data["tili_id"]."|"
                    .$data["amount"]."'>"
                    .$data["tilinimi"].
                "</option>";
            }
            echo "</select><div class='tilinSaldo'>Saldo: " .$_SESSION["userData"][0]["amount"]. "</div></div>";
        ?>
            <input type="number" name="amount" placeholder="Määrä" style="padding: 5px">
            <input type="submit" value="Siirrä" style="padding: 5px">
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
    // sit sen voi purkaa tällee kivasti :)
    function tiliSaldo(e) {
        const [tiliId, amount] = e.value.split("|"); 
        $(".tilinSaldo", e.parentElement).text(`Saldo: ${amount}`);
    }
    
</script>
</html>