<?php
include 'auth.php';

//faccio partire la sessione
session_start();

//check del login
auth_validate();

//controllo se ha l'autorizzazione per la pagina
$required_lvl = 1;
if ($_SESSION['user']['level'] > $required_lvl)
    exit("Non puoi accedere a questa pagina,<br>richiesto livello $required_lvl o inferiore");



$error = isset($_REQUEST['error']) ? $_REQUEST['error'] : null;
$username = isset($_REQUEST['user']) ? $_REQUEST['user'] : null;
$user_list = json_decode(file_get_contents('data/users.json'), true); //prendo gli utenti dal json

//non puoi auto modificarti
if ($username === $_SESSION['user']['username'])
    auth_redirect('userctrl.php');

if (!isset($user_list[$username]))
    $username = null;

if ($username) {
    //carico le info dell'utente su $user
    $user = $user_list[$username];
} else {
    //creo un nuovo utente
    $user = [
        'username' => '',
        'password' => '',
        'level' => '',
    ];
}

?>



<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigitML | <?= $username ? "EDIT - $username" : 'ADD' ?></title>

    <link rel="shortcut icon" href="../imgs/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="styles/usercard.css">
</head>

<body>
    <header id="navbar">
        <h1><a href="../landing.html">DigitML</a></h1>
        <h2>
            <div>Pannello Utente - <?= $username ? $username : 'New' ?></div>
        </h2>
        <a href="./" class="nav-btn">PANEL</a>
        <form action="login.php" method="POST" id="log-out">
            <input type="submit" value="LOG OUT" name="logOut" class="nav-btn">
        </form>
    </header>

    <form action="userctrl.php" method="post" id="user-data" autocomplete="off">
        <h2><?= $username ? 'EDIT' : 'ADD' ?> USER</h2>

        <input type="text" name="username" value="<?= $user['username'] ?>" placeholder="Username" <?= $username ? '' : 'required' ?>>
        <input type="text" name="password" value="<?= $user['password'] ?>" placeholder="Password" <?= $username ? '' : 'required' ?>>
        <input type="text" name="level" value="<?= $user['level'] ?>" placeholder="Level" <?= $username ? '' : 'required' ?>>

        <div class="operation-container">
            <input type="hidden" name="user-opr" value="<?= $username ? 'edit' : 'add' ?>">
            <input type="submit" value="ESEGUI">
            <a href="userctrl.php" class="annulla">Annulla</a>
            <?= $username ? "<input type='submit' id='delete' name='delete' value='ELIMINA'>" : '' ?>
        </div>

        <?= $error ? "<div class='error'> $error </div>" : '' ?>
    </form>

    <script src="../scripts/theme.js"></script>
</body>

</html>