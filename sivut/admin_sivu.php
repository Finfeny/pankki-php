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
                                    <button onClick="GenerateUserIBAN(this)">Generate</button>
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
        <div id="pendigAccountDeletions">
            <?php
                $pending_account_deletions = $conn->query(
                    "SELECT tilit.tilinimi, kayttajat.nimi, tilit.tili_id 
                    FROM tilit, kayttajat
                    WHERE tilit.kayttaja_id = kayttajat.id 
                    AND deleted = 1")->fetchAll();
            ?>
                <h2>pending account deletions</h2>
                <div id='pendAccHeader'>
                    <h3>nimi</h3>
                    <h3>tilinimi</h3>
                    <h3>IBAN</h3>
                </div>
            <?php       //listataan tilit ja niiden tiedot
                if ($pending_account_deletions) {
                    foreach ($pending_account_deletions as $pending_account_deletion) {
                        ?>
                            <div class='pendingDel_tiliTaulu'>
                                <div class='pendAccDelNimi'><?php echo $pending_account_deletion["nimi"]; ?></div>
                                <div class='pendAccDelTili'><?php echo $pending_account_deletion["tilinimi"]; ?></div>
                                <div style="display: flex; gap: 20px">
                                    <button onClick="AcceptAccountDeletion(this)">Hyväksy</button>
                                    <input class='pendAccId' style="display: none" value="<?php echo $pending_account_deletion["tili_id"]; ?>">
                                </div>
                            </div>
                        <?php
                    }
                } else {
                    echo "No pending account deletions";
                }
            ?>
    </div>
        <!--degub -->
        <form method="POST" action="index.php">
            <input name="user_id" placeholder="<?php echo $_SESSION["user_id"] ?>">
            <button type="submit">id</button>
        </form>
</body>
<script>
    function GenerateUserIBAN(e) {
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

    function AcceptAccountDeletion(e){
        tili_id = $(".pendAccId", e.parentElement).val();
        window.location.href=`../accept_account_deletion.php?tili_id=${tili_id}`
    }
</script>
</html>