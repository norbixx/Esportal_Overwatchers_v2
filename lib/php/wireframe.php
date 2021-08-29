<?php

require_once("connect.php");

function getHead($webName){
    echo "
        <!-- META -->
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
        <meta name='description' content='Esportal Overwatchers Panel - Beta'>
        <meta name='author' content='Norbert 'Norbix' Grudzień'>
        <title>".$webName."Overwatchers Panel</title>

        <!-- CSS -->
        <link rel='stylesheet' type='text/css' href='lib/css/style_15052019.css'>
        <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' integrity='sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr' crossorigin='anonymous'>

        <!-- JS -->
        <script type='text/javascript' src='lib/js/script.js'></script>
    ";
}

function getNav($img, $name, $permission, $active){
    
    if($permission == 100 && $active == 'admin')
        $admin = "<a href='admin?killcache=".rand()."' class='active'><li><i class='fas fa-user-secret'></i> Admin</li></a>";
    else if($permission == 100 && $active != 'admin')
        $admin = "<a href='admin?killcache=".rand()."'><li><i class='fas fa-user-secret'></i> Admin</li></a>";
    else
        $admin = null;
    
    if($active == 'panel')
        $panel = "<a href='panel?killcache=".rand()."' class='active'><li><i class='fas fa-flag'></i> Zgłoszenia</li></a>";
    else
        $panel = "<a href='panel?killcache=".rand()."'><li><i class='fas fa-flag'></i> Zgłoszenia</li></a>";
    
    if($active == 'checkuser')
        $checker = "<a href='checkuser?killcache=".rand()."' class='active'><li><i class='fas fa-address-book'></i> Kartoteka</li></a>";
    else
        $checker = "<a href='checkuser?killcache=".rand()."'><li><i class='fas fa-address-book'></i> Kartoteka</li></a>";
    
    if($active == 'stats')
        $stats = "<a href='stats?killcache=".rand()."' class='active'><li><i class='fas fa-table'></i> Statystyki</li></a>";
    else
        $stats = "<a href='stats?killcache=".rand()."'><li><i class='fas fa-table'></i> Statystyki</li></a>";
    
    if($active == 'history')
        $history = "<a href='history?killcache=".rand()."' class='active'><li><i class='fas fa-history'></i> Historia</li></a>";
    else
        $history = "<a href='history?killcache=".rand()."'><li><i class='fas fa-history'></i> Historia</li></a>";
    
    echo "    
    
    <nav>
            <div class='nav-content'>
                <div class='left-nav'>

                    <ul>
                        <a href='#' class='brand'><img src='lib/img/esportal_white.png' alt='esportal-logo' /></a>
                        ";
                
                
                echo $panel;
                echo $checker;
                echo $stats;
                echo $history;
                echo $admin;
    
    echo "
                    </ul>

                </div>
                <div class='right-nav'>
                    <ol>
                        <li onclick='toggleNotification();'><i class='fas fa-bell notification' id='notification-bell'></i>
                            <ul class='notification-bar' id='notification-bar' style='display: none;'>
                                ";
    
                                include_once("notification-list.php");
                                    
    echo "
                            </ul>
                        </li>
                        <li onclick='toggleDisplay();' id='account'><span class='account'>";
    
    echo $img.$name;
    
    echo "
        </span><span class='carret'><i class='fas fa-caret-up' id='carret'></i></span>

                            <ul class='account-bar' id='account-bar' style='display: none;'>
        ";
    
    
                                if($permission == 100){
                                echo 
                                    "
                                        <a href='admin?killcache=".rand()."'><li><i class='fas fa-user-secret'></i> Admin</li></a>
                                    ";
                                }
                                if($permission == 100 || $permission == 50){
                                    //echo 
                                    //"
                                    //    <a href='hero-league'><li><i class='fas fa-trophy'></i> Heroleague</li></a>
                                    //";
                                }else{

                                    //...

                                }

    echo "
                                    <a href='profile/".$name."'><li><i class='fas fa-user'></i> Profil</li></a>
                                    <a href='myreports?killcache=".rand()."'><li><i class='fas fa-flag'></i> Moje zgłoszenia</li></a>
                                    <a href='settings?killcache=".rand()."'><li><i class='fas fa-cog'></i> Ustawienia</li></a>
                                    <a href='lib/php/logout.php'><li><i class='fas fa-sign-out-alt'></i> Wyloguj</li></a>
                            </ul>

                        </li>
                    </ol>

                </div>
            </div>
        </nav>
        
        <header class='site-header'>
            <div class='header-content'>
                <div class='info-block'>
                    <p><i class='fas fa-exclamation-triangle'></i> Wszelkie błędy związane ze stroną zgłaszajcie tutaj: <a href='https://docs.google.com/spreadsheets/u/1/d/1eHGm4yZysk6jNiitopo9JYrh_ALSgNwlUVSIRy37Cww/edit#gid=0'>KLIK</a> <i class='fas fa-exclamation-triangle'></i></p>
                </div>
                <img src='lib/img/header.png' alt='header' />
            </div>
        </header>
        ";
}


function getFooter(){
    
    echo "
        <footer class='footer'>
            <div class='footer-content'>
            
                <p>
                    <span id='time'></span>
        ";
                        date_default_timezone_set('Europe/Warsaw');
                        echo $timestamp = date(' - d/m/Y').' / (GMT0100)';

                        echo " | ";
                        include_once("lib/php/version.php");
    echo "
            / Copyright by <a href='#' class='account-href'>Norbix</a>.
                </p>
                
            </div>
        </footer>
    ";
}

function noPermission(){
    
    echo "
    
        <div class='permissionFailed'>
            
            <img src='lib/img/esportal_white.png' alt='esportal-logo' />
            
            <h3>Nie posiadasz uprawnień do przeglądania tej strony. Zaloguj się ponownie.</h3>
            
            <a href='lib/php/logout.php'><button class='buttonDefault blueB'><i class='fas fa-home'></i> Strona główna</button></a>
            
        </div>
        
        ";
    
}

function noAdminPermission(){
    
    echo "
    
        <div class='permissionFailed'>
            
            <img src='lib/img/esportal_white.png' alt='esportal-logo' />
            
            <h3>Nie posiadasz uprawnień do przeglądania tej strony.</h3>
            
            <a href='panel'><button class='buttonDefault blueB'><i class='fas fa-flag'></i> Panel zgłoszeń</button></a>
            
        </div>
        
        ";
    
}

function underConstruction(){
    
    echo "
    <br /><p><center><i class='fas fa-tools' style='font-size: 24px;'></i> Panel w trakcie budowy <i class='fas fa-tools' style='font-size: 24px;'></i></center></p>";
    
}

function checkNavbarActive($activeBar){
    
    if(!empty($_GET['request'])){
        if($activeBar == $_GET['request']){
            return "active";
        }else{
            return "";
        }
    }else if($activeBar == "admin"){
        return "active";
    }
    
}

function makeDate($s)
{
    if (date("l, d F Y", $s) == date("l, d F Y", time())) { $today = true; }

    if ($today) {
      $date = date("F", $s);
    } else {
      $date = date("F", $s);
    }

    $date = str_replace('January', 'STYCZEŃ', $date);
    $date = str_replace('February', 'LUTY', $date);
    $date = str_replace('March', 'MARZEC', $date);
    $date = str_replace('April', 'KWIECIEŃ', $date);
    $date = str_replace('May', 'MAJ', $date);
    $date = str_replace('June', 'CZERWIEC', $date);
    $date = str_replace('July', 'LIPIEC', $date);
    $date = str_replace('August', 'SIERPIEŃ', $date);
    $date = str_replace('September', 'WRZESIEŃ', $date);
    $date = str_replace('October', 'PAŹDZIERNIK', $date);
    $date = str_replace('November', 'LISTOPAD', $date);
    $date = str_replace('December', 'GRUDZIEŃ', $date);

    return $date;
}


?>