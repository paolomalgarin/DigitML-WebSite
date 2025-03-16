<?php
$error = isset($_REQUEST['error']) ? $_REQUEST['error'] : null;

//se ho mandato una richiesta di log out chiudo la sessione
if (isset($_REQUEST['logOut'])) {
    //carico i dati della sessione (o la creo se non c'è)
    session_start();
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigitML | Login</title>

    <link rel="shortcut icon" href="../imgs/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="styles/login.css">
</head>

<body>
    <header id="navbar">
        <h1><a href="../landing.html">DigitML</a></h1>
        <!-- <a href="app.html" class="nav-btn">APP</a> -->
    </header>

    <form action="./" method="post" autocomplete="off">
        <h2>LOGIN</h2>
        <input type="text" placeholder="username" name="username">
        <input type="password" placeholder="password" name="password">
        <input type="submit" value="LogIn">
        <?= $error ? "<div class='error'>$error</div>" : '' ?>

    </form>

    <script src="../scripts/theme.js"></script>
</body>

</html>