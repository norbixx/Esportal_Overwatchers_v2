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
    <title>Rejestracja - Overwatchers Panel</title>
    
    <!-- CSS -->
    <link rel='stylesheet' type='text/css' href='lib/css/style_15052019.css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    
    <!-- JS -->
    <script src="lib/js/jquery-3.3.1.min.js"></script>
    <script>
        function startTime() {
          var today = new Date();
          var h = today.getHours();
          var m = today.getMinutes();
          var s = today.getSeconds();
          m = checkTime(m);
          s = checkTime(s);
          document.getElementById('time').innerHTML =
          h + ":" + m + ":" + s;
          var t = setTimeout(startTime, 500);
        }
        function checkTime(i) {
          if (i < 10) {i = "0" + i};
          return i;
        }
        
        function unlockPass() {
          var x = document.getElementById("passInput");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
        }
        
        function checkPasswordMatch() {
            var password = $("#password").val();
            var confirmPassword = $("#repeat_password").val();

            if(password != confirmPassword){
                $("#password").removeClass("successInput");
                $("#repeat_password").removeClass("successInput");
                
                $("#password").addClass("failedInput");
                $("#repeat_password").addClass("failedInput");
            }else{
                $("#password").removeClass("failedInput");
                $("#repeat_password").removeClass("failedInput");
                
                $("#password").toggleClass("successInput");
                $("#repeat_password").toggleClass("successInput");
            }
        }

        $(document).ready(function () {
           $("#repeat_password").keyup(checkPasswordMatch);
        });

    </script>
</head>
<body onload="startTime()">
    
    <div class='container'>
        
        <header class="header">
            <a href='index'><img src="lib/img/esportal_white.png" alt="esportal_logo" /></a>
            <div class="title">
                <h1>Rejestracja konta</h1>
            </div>
        </header>
        
        <section class="register">
            
            <?php
            
                getFailed("reg", "false", "Wystąpił błąd podczas rejestracji, być może podałeś złe dane");
                getSuccess("reg", "true", "Twoje konto zostało utworzone, poinformuj o tym administratora, który je aktywuje");
            
            
            ?>
            
            <form method='POST' action='lib/php/register_true.php'>
                
                <table>
                    <tbody>
                        <tr>
                            <td>Twój unikalny login: </td>
                            <td><input type='text' name='login' placeholder='Login' class='inputRegister' required></td>
                        </tr>
                        <tr>
                            <td>Hasło: </td>
                            <td><input type='password' name='password' placeholder='Hasło' id='password' class='inputRegister' required></td>
                        </tr>
                        <tr>
                            <td>Powtórz hasło: </td>
                            <td><input type='password' name='password_repeat' placeholder='Powtórz hasło' id='repeat_password' class='inputRegister' required></td>
                        </tr>
                        <tr>
                            <td>E-mail kontaktowy: </td>
                            <td><input type="email" name='email' placeholder='email@domena.pl' class='inputRegister' required></td>
                        </tr>
                        <tr>
                            <td>Wyświetlana nazwa: <br /><span class='helper'>(Taka jak na slack'u)</span></td>
                            <td><input type='text' name='realname' placeholder='Wyświetlana nazwa' class='inputRegister' required></td>
                        </tr>
                        <tr>
                            <td>Discord ID: <br /><span class='helper'>(Przykład: 4213)</span></td>
                            <td><input type='text' name='discord' placeholder='Discord ID' class='inputRegister' required></td>
                        </tr>
                        <tr>
                            <td>Link do profilu Esportal: </td>
                            <td><input type='text' name='esportal' placeholder='https://beta.esportal.pl/profile/profil' class='inputRegister' required></td>
                        </tr>
                        <tr>
                            <td>Link do profilu Steam: </td>
                            <td><input type='text' name='steam' placeholder='https://steamcommunity.com/id/profil' class='inputRegister' required></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class='rules'>Oświadczam, że akceptuję <a href=''>regulamin</a> <input type='checkbox' required></td>
                        </tr>
                    </tbody>
                </table>
                <div id='checkPassword'></div><br />
                <button type='reset' class='buttonDefault redB'><i class="fas fa-eraser"></i> Wyczyść dane</button>
                <button type='submit' class='buttonDefault greenB'><i class="fas fa-check-square"></i> Zarejestruj się</button>
            </form>
            
            
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