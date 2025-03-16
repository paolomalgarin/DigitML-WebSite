<?php
$img = 'imgs/img404.png';
if (isset($_REQUEST['canvas-image'])) {
    $img = $_REQUEST['canvas-image'];
}

?>


<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigitML | Resoult</title>

    <link rel="shortcut icon" href="imgs/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="styles/elabora.css">
</head>

<body>
    <header id="navbar">
        <h1><a href="landing.html">DigitML</a></h1>
        <a href="ctrl_panel/" class="nav-btn left">ADMIN</a>
        <a href="app.html" class="nav-btn">APP</a>
    </header>

    <div class="resoult-container">
        <div class="box">
            <img src="<?= $img ?>" alt="img" id="canvas-image">
        </div>
        <div class="suspance">
            <span>è un ...</span>
            <a href="app.html" class="again-btn">RITENTA</a>
        </div>
        <div class="box">
            <span id="resoult">?</span>
        </div>

        <a href="app.html" class="again-btn">RITENTA</a>
    </div>

    <script src="scripts/elabora_img.js"></script>
    <script src="scripts/theme.js"></script>
    <script>
        <?php
        $hostname = gethostname();
        $ip = gethostbyname($hostname);
        ?>
        //elaborazione dati
        invertImage(img, "<?= $ip ?>", sendImage);
    </script>
</body>

</html>