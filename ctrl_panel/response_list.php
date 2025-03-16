<?php
include 'auth.php';

//faccio partire la sessione
session_start();

//check del login
auth_validate();

//controllo se ha l'autorizzazione per la pagina
$required_lvl = 2;
if ($_SESSION['user']['level'] > $required_lvl)
    exit("Non puoi accedere a questa pagina,<br>richiesto livello $required_lvl o inferiore");

?>



<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigitML | Last Resoults</title>

    <link rel="shortcut icon" href="../imgs/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="styles/response_list.css">
</head>

<body>
    <header id="navbar">
        <h1><a href="../landing.html">DigitML</a></h1>
        <h2>
            <div>Ben tornato <?= $_SESSION['user']['username'] ?></div>
        </h2>
        <a href="./" class="nav-btn">PANEL</a>
        <form action="login.php" method="POST" id="log-out">
            <input type="submit" value="LOG OUT" name="logOut" class="nav-btn">
        </form>

        <div class="options">
            <h3>Order By</h3>
            <div class="buttons">
                <div class="btn" onclick="orderBy('date', LIST, printList);">Date</div>
                <div class="btn" onclick="orderBy('number', LIST, printList);">Number</div>
            </div>
        </div>
    </header>

    <div id="list-container">
    </div>

    <script src="../scripts/theme.js"></script>
    <script src="../scripts/fetch_response_list.js"></script>
    <script>
        <?php
        $hostname = gethostname();
        $ip = gethostbyname($hostname);
        ?>
        //elaborazione dati
        getResponseList('<?= $ip ?>');
    </script>
</body>

</html>