<?php

    require_once("lib/php/handler.php");

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <!-- META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Esportal Overwatchers Panel - Beta">
    <meta name="author" content="Norbert 'Norbix' Grudzień">
    <title>Strona główna - Overwatchers Panel</title>
    
    <!-- CSS -->
    <link rel='stylesheet' type='text/css' href='lib/css/style_15052019.css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    
    <!-- JS -->
    <script type="text/javascript" src="lib/js/script.js"></script>
    
</head>
<body onload="startTime()">
    
    <div class='container'>
        
        <header class="header">
            <img src="lib/img/esportal_white.png" alt="esportal_logo" />
            <div class="title">
                <h1>Overwatchers Panel</h1>
            </div>
        </header>
        
        <section class="login">
            
            <?php
            
            if(isset($_COOKIE['auth_token'])){
                //...
            }else{
                getFailed("login", "wrong", "Błąd podczas logowania. Niepoprawny login lub hasło");
                getFailed("login", "noactive", "Twoje konto jest nieaktywne. Jeżeli nie wiesz dlaczego tak się dzieje to skontaktuj się z administratorem");
                getSuccess("changepass", "true", "Twoje hasło zostało pomyślnie zmienione");
                getFailed("changepass", "false", "Wystapił nieznany błąd podczas zmiany hasła");
            }
                include_once("lib/php/cookie_checker.php");
            ?>
            
        </section>
        
        <footer class="footer">
            <p>
                <span id="time"></span>
                <?php 
                    date_default_timezone_set('Europe/Warsaw');
                    echo $timestamp = date(' - d/m/Y').' / (GMT0100)';
                    
                    echo " | ";
                    include_once("lib/php/version.php")
                ?>
            </p>
        </footer>
        
    </div>
    
</body>
</html>