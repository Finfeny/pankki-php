<?php
include '../dbyhteys.php';
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] != 1) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style.css">
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div id="admin">
        <a id="title" href="index.php">PHP pankki</a>
        <a id="logout" href="../logout.php">Kirjaudu ulos</a>
        <br><br>
        <div id="tiliPyynnöt">
            <?php
                $pending_accounts = $conn->query(
                    "SELECT tilit.tilinimi, kayttajat.nimi, tilit.tili_id 
                    FROM tilit, kayttajat
                    WHERE tilit.kayttaja_id = kayttajat.id 
                    AND IBAN = ''")->fetchAll();
            ?>
                <h2>pending accounts</h2>
                <div id='pendAccHeader'>
                    <h3>nimi</h3>
                    <h3>tilinimi</h3>
                    <h3>IBAN</h3>
                </div>
            <?php       //listataan tilit ja niiden tiedot
                if ($pending_accounts) {
                    foreach ($pending_accounts as $pending_account) {
                        ?>
                            <div class='pending_tiliTaulu'>
                                <div class='pendAccNimi'><?php echo $pending_account["nimi"]; ?></div>
                                <div class='pendAccTili'><?php echo $pending_account["tilinimi"]; ?></div>
                                <div style="display: flex; gap: 20px">
                                    <button onClick="GenerateUser(this)">Generate</button>
                                    <input class='pendAccIBAN'>
                                    <button onClick="AcceptAccount(this)">Hyväksy</button>
                                    <input class='pendAccId' style="display: none" value="<?php echo $pending_account["tili_id"]; ?>">
                                </div>
                            </div>
                        <?php
                    }
                } else {
                    echo "No pending accounts";
                }
            ?>
        </div>
</body>
<script>
    function GenerateUser(e) {
        console.log(e);
        let IBAN = "FI";
        for (let i = 0; i < 16; i++) {
            IBAN += Math.floor(Math.random() * 10);
        }
        $(".pendAccIBAN", e.parentElement).val(IBAN);
    }

    function AcceptAccount(e){
        IBAN = $(".pendAccIBAN", e.parentElement).val();
        tili_id = $(".pendAccId", e.parentElement).val();
        console.log(IBAN);
        window.location.href=`../accept_account.php?tili_id=${tili_id}&IBAN=${IBAN}`
    }
</script>
</html>