<?php
include 'auth.php';

//faccio partire la sessione
session_start();

//check del login
auth_validate();

//controllo se ha l'autorizzazione per la pagina
$required_lvl = 3;
if ($_SESSION['user']['level'] > $required_lvl)
    exit("Non puoi accedere a questa pagina,<br>richiesto livello $required_lvl o inferiore");




$options = [
    [
        'description' => 'Vedi le ultime 50 immagini',
        'required-lvl' => 2,
        'link' => 'response_list.php',
    ],
    [
        'description' => 'Modifica gli utenti',
        'required-lvl' => 1,
        'link' => 'userctrl.php',
    ],
];

$list = '';

for ($i = 0; $i < sizeof($options); $i++) {
    if ($_SESSION['user']['level'] <= $options[$i]['required-lvl'])
        $list .= "
            <a href='" . $options[$i]['link'] . "' class='card'>
                <h2>" . $options[$i]['description'] . "</h2>
            </a>
            ";
}

if ($list === '') {
    $list = "
        <a href='#' class='card error'>
            <h2>Non ci sono cose che puoi fare</h2>
        </a>
    ";
}
?>



<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigitML | Control Panel</title>

    <link rel="shortcut icon" href="../imgs/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="styles/index.css">
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
    </header>

    <div class="option-container">
        <?= $list ?>
    </div>

    <script src="../scripts/theme.js"></script>
</body>

</html>