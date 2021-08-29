<?php

    require_once("lib/php/handler.php");

    $db_connect = startConnection();

    if(isset($_COOKIE['auth_login'])){
        $login = $_COOKIE['auth_login'];
        $name = getRealname($login, $db_connect);
        $img = getPermissionImage($login, $db_connect);
        $permission = getPermission($login, $db_connect);
        setActive($login, $db_connect);
        

        
    }else{
        
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    
    <?php
    
        if(!empty($_GET['page']))
            echo "<base href='../''>";
        else
            echo "<base href='./''>";
    
    
        getHead("Ustawienia - ");
    
    ?>
    <script src="lib/js/jquery-3.3.1.min.js"></script>
    <script>
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
    
    <div class='container-block'>
        
        <?php
        
        if(checkCookie($db_connect)){
        
            getNav($img, $name, $permission, "none");
        
                echo "<section class='content'>";
            
                $userinfo = $db_connect->query("SELECT email, discord_id, steam, esportal FROM users WHERE id=".$_COOKIE['auth_id']."");
                
                foreach($userinfo as $row){
                    $email = $row['email'];
                    $discord = $row['discord_id'];
                    $steam = $row['steam'];
                    $esportal = $row['esportal'];
                }
            
                $userinfo->closeCursor();
            
                echo "
                    
                    <form action='lib/php/change-pass.php' method='POST'>
                        <table cellspacing='0' cellpadding='0'>
                        <thead>
                            <tr>
                                <th><i class='fas fa-key'></i> Hasło</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>";
            
                getFailed("change", "false", "Błąd podczas zmiany hasła");
                getSuccess("change", "true", "Twoje hasło zostało pomyślnie zmienione");
            
                echo "<br />
                                    <input type='password' name='password' placeholder='Hasło' id='password' class='inputDefault'><br />
                                    <input type='password' name='password_repeat' placeholder='Powtórz hasło' id='repeat_password' class='inputDefault'><br />
                                    <button type='submit' class='buttonDefault greenB'><i class='fas fa-save'></i> Zapisz</button>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </form>
                    
                    <form action='lib/php/change-email.php' method='POST'>
                        <table cellspacing='0' cellpadding='0'>
                        <thead>
                            <tr>
                                <th><i class='fas fa-envelope'></i> Adres e-mail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>";
            
                getFailed("email", "false", "Błąd podczas zmiany adresu e-mail");
                getSuccess("email", "true", "Twój adres e-mail został pomyślnie zmieniony");
            
                echo "<br />
                                    <input type='email' name='email' class='inputDefault' placeholder='przyklad@domena.pl' value='".$email."'><br />
                                    <button type='submit' class='buttonDefault greenB'><i class='fas fa-save'></i> Zapisz</button>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </form>
                    
                    <form action='lib/php/change-discord.php' method='POST'>
                        <table cellspacing='0' cellpadding='0'>
                        <thead>
                            <tr>
                                <th><i class='fab fa-discord'></i> Discord</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>";
            
                getFailed("discord", "false", "Błąd podczas zmiany ID Discorda");
                getSuccess("discord", "true", "Twoje ID Discorda zostało zmienione pomyślnie");
            
                echo "<br />
                                    <input type='text' name='discord' class='inputDefault' placeholder='4321' value='".$discord."'><br />
                                    <button type='submit' class='buttonDefault greenB'><i class='fas fa-save'></i> Zapisz</button>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </form>
                    
                    <form action='lib/php/change-steam.php' method='POST'>
                        <table cellspacing='0' cellpadding='0'>
                        <thead>
                            <tr>
                                <th><i class='fab fa-steam-symbol'></i> Profil Steam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>";
            
                getFailed("steam", "false", "Błąd podczas zmiany adresu Steam");
                getSuccess("steam", "true", "Twój adres Steam został zmieniony pomyślnie");
            
                echo "<br />
                                    <input type='text' name='steam' class='inputDefault' placeholder='https://steamcommunity.com/id/przyklad' value='".$steam."'><br />
                                    <button type='submit' class='buttonDefault greenB'><i class='fas fa-save'></i> Zapisz</button>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </form>
                    
                    <form action='lib/php/change-esportal.php' method='POST'>
                        <table cellspacing='0' cellpadding='0'>
                        <thead>
                            <tr>
                                <th><i class='fas fa-user'></i> Profil Esportal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>";
            
                getFailed("esportal", "false", "Błąd podczas zmiany adresu profilu Esportal");
                getSuccess("esportal", "true", "Twój adres profilu Esportal został pomyślnie zmieniony");
            
                echo "<br />
                                    <input type='text' name='esportal' class='inputDefault' placeholder='https://beta.esportal.pl/profile/przyklad' value='".$esportal."'><br />
                                    <button type='submit' class='buttonDefault greenB'><i class='fas fa-save'></i> Zapisz</button>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </form>
                
                ";
            
                $lastLogin = $db_connect->query("SELECT action, actiondate, ip FROM logs WHERE u_id=".$_COOKIE['auth_id']." ORDER BY actiondate DESC LIMIT 10");
                
                echo "
                    <table cellspacing='0' cellpadding='0' class='logs-table'>
                    <thead>
                        <tr>
                            <th colspan='3'><i class='fas fa-file'></i> Twoje ostatnie działania (w trakcie tworzenia)</th>
                        </tr
                        <tr>
                            <th>Akcja:</th>
                            <th>Data:</th>
                            <th>Adres ip:</th>
                        </tr>
                    </thead>
                    <tbody>
                ";
            
                foreach($lastLogin as $row){
                    echo "
                        <tr>
                            <td>".$row['action']."</td>
                            <td>".$row['actiondate']."</td>
                            <td>".$row['ip']."</td>
                        </tr>
                    ";
                }
                
                echo "
                    </tbody>
                    </table>
                ";
                
                $lastLogin->closeCursor();
                $db_connect = null;
            
            
                echo "</section>";
        
            getFooter();
            
        }else{
            
            noPermission();
            
        }
        
        ?>
        
    </div>

</body>
</html>