<?php

/**
 * Questo script avvia la sessione e se l'utente è loggato, salva i 
 * campi username e password nella sessione, altrimenti riporta
 * al login.
 * 
 * Questo è uno script di setup.
 */
// session_start();  //faccio partire la sessione


// ------------------------------------------------------------------- FUNZIONI -------------------------------------------------------------------
function auth_redirect($url, $statusCode = 303)
{
    header('Location: ' . $url, true, $statusCode);
    exit('<h1 style="text-align: center;">Tu non puoi passare!</h1>');
}


function auth_validate($deleteSessionIfNotAuth = false)
{
    // ------------------------------------------------------------------- VARIABILI -------------------------------------------------------------------
    $USERS = json_decode(file_get_contents('data/users.json'), true); //prendo gli utenti dal json

    $user = isset($_REQUEST['username']) ? $_REQUEST['username'] : null;
    $pwd = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;

    $s_user = isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : null;


    // ------------------------------------------------------------------- CODIFICO -------------------------------------------------------------------
    if (!$USERS) {
        exit('Errore durante il caricamento degli utenti');
    }

    if ($s_user && $USERS[$s_user]['username'] === $s_user) {
        //se l'utente è loggato nella sessione, faccio andare avanti (if in caso di bisogno di operazioni specifiche future)

    } else if ($user && $pwd && $USERS[$user]['password'] === $pwd) {
        //se l'utente non è loggato nella sessione ma si sta loggando con la form, faccio andare avanti (if in caso di bisogno di operazioni specifiche future)

    } else {
        //se non è loggato da nessuna parte, ridireziono al login (index.html) e blocco lo script (exit) per sicurezza
        if ($deleteSessionIfNotAuth) {
            //carico i dati della sessione (o la creo se non c'è)
            session_start();
            // remove all session variables
            session_unset();
            // destroy the session
            session_destroy();
        }

        if ($user || $pwd)
            auth_redirect('login.php?error=Email+o+password+errati');
        else
            auth_redirect('login.php');
        exit('Unauthorized!');
    }


    //c'e l'utente
    //tolgo la password x non salvarla sulla sessione (Best Practice)
    unset($USERS[$s_user]['password']);
    //aggiorno l'utente (nel caso in cui cambiassero password e livello di accesso o si fosse appena loggato)
    if ($s_user)
        $_SESSION['user'] = $USERS[$s_user];
    else if ($user)
        $_SESSION['user'] = $USERS[$user];



    // echo 'Tu puoi passare!<br>';
}
