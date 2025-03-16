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



$users = json_decode(file_get_contents('data/users.json'), true); //prendo gli utenti dal json



// --------------------------------------------------------------------- AGGIUNGO O MODIFICO UN UTENTE FACENDO I CONTROLLI ---------------------------------------------------------------------
//controllo se devo fare operazioni sugli utenti
if (isset($_REQUEST['user-opr'])) {
    $isNew = $_REQUEST['user-opr'] === 'add' ? true : false;
    $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : null;
    $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
    $level = isset($_REQUEST['level']) ? $_REQUEST['level'] : null;

    if ($isNew) {
        //controlli specifici
        if (!$username || !$password || !$level)  //controllo che i campi siano tutti compilati
            auth_redirect("usercard.php?user=$username&error=Tutti+i+campi+devono+essere+compilati");  //funzione gia presente in auth
        if (isset($users[$username]))
            auth_redirect("usercard.php?error=Il+nome+utente+è+già+in+uso");
    }

    if (!is_numeric($level))
        auth_redirect("usercard.php?user=$username&error=Il+livello+deve+essere+un+numero");
    else if (0 + $level > 3 || 0 + $level < 1)
        auth_redirect("usercard.php?user=$username&error=Il+livello+deve+essere+compreso+tra+1+e+3");

    //aggiungo/modifico/elimino l'utente
    if (isset($_REQUEST['delete'])) {
        unset($users[$username]);
    } else {
        $users[$username]['username'] = $username;
        $users[$username]['password'] = $password;
        $users[$username]['level'] = 0 + $level;
    }

    //aggiorno il file
    file_put_contents('data/users.json', json_encode($users), true);

    //riscarico gli utenti
    $users = json_decode(file_get_contents('data/users.json'), true);
}


// ---

$list = '';

foreach ($users as $user => $data) {
    if ($data['level'] > 0 && $data['username'] !== $_SESSION['user']['username'])
        $list .= "
        <form method='post' action='usercard.php' class='card' onclick='this.submit();'>
            <div class='lvl'>" . $data['level'] . "</div>
            <h2>" . $data['username'] . "</h2>
            <input type='hidden' name='user' value='" . $data['username'] . "'>
        </form>
        ";
    else
        $list .= "
        <div class='card locked'>
            <div class='lvl'>" . $data['level'] . "</div>
            <h2>" . $data['username'] . "</h2>
        </div>
        ";
}

if ($list === '') {
    $list = "
        <div class='card locked error'>
            <h2>Non ci sono utenti che puoi modificare</h2>
        </div>
    ";
}
?>



<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigitML | User Panel</title>

    <link rel="shortcut icon" href="../imgs/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="styles/userctrl.css">
</head>

<body>
    <header id="navbar">
        <h1><a href="../landing.html">DigitML</a></h1>
        <h2>
            <div>Pannello Utenti</div>
        </h2>
        <a href="./" class="nav-btn">PANEL</a>
        <form action="login.php" method="POST" id="log-out">
            <input type="submit" value="LOG OUT" name="logOut" class="nav-btn">
        </form>
    </header>

    <div class="sidebar">
        <a href="usercard.php" id='adduser-btn'>ADD</a>
    </div>

    <div class="option-container">
        <?= $list ?>
        <a href="usercard.php" class='card add'>
            <h2>+</h2>
        </a>
    </div>

    <script src="../scripts/theme.js"></script>
</body>

</html>