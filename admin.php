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
        
            
        if(!empty($_GET['request']) && !empty($_GET['list'])){
            
            echo "<base href='./''>";
            
        }
        else if(!empty($_GET['request'])){
            
            echo "<base href='../''>";
            
        }else{
            
            echo "<base href='./''>";
            
        }
    
        getHead("Panel administracyjny - ");
    
    ?>
    
</head>
<body onload="startTime()">
    
    <div class='container-block'>
        
        <?php
        
        if(checkCookie($db_connect)){
        
            getNav($img, $name, $permission, "admin");
        
                echo "<section class='content'>";
            
                if($permission == 100){
                    echo "
                        <div class='admin-list'>
                            <ul>
                                <a href='admin'><li class='".checkNavbarActive("admin")."'><i class='fas fa-home'></i> Główny panel</li></a>
                                <a href='admin/addreports'><li class='".checkNavbarActive("addreports")."'><i class='fas fa-plus-square'></i> Dodaj zgłoszenia</li></a>
                                <a href='admin/activereports?killcache=".rand()."'><li class='".checkNavbarActive("activereports")."'><i class='fas fa-folder-open'></i> Aktywne zgłoszenia</li></a>
                                <a href='admin/donereports?killcache=".rand()."'><li class='".checkNavbarActive("donereports")."'><i class='fas fa-check-square'></i> Zakończone zgłoszenia</li></a>
                                <a href='admin/userslist?killcache=".rand()."'><li class='".checkNavbarActive("userslist")."'><i class='fas fa-users'></i> Lista użytkowników</li></a>
                                <a href='admin/stats?killcache=".rand()."'><li class='".checkNavbarActive("stats")."'><i class='fas fa-table'></i> Statystyki zgłoszeń</li></a>
                                <a href='admin/logs?killcache=".rand()."'><li class='".checkNavbarActive("logs")."'><i class='fas fa-file'></i> Logi administracyjne</li></a>
                            </ul>
                        </div>
                    ";

                    if(!empty($_GET['request'])){
                        
                        if($_GET['request'] == "addreports"){
                            
                            include_once("lib/php/admin-addreports.php");
                            
                        }
                        if($_GET['request'] == "activereports"){
                            
                            include_once("lib/php/admin-activereports.php");
                            
                        }
                        if($_GET['request'] == "donereports"){
                            
                            include_once("lib/php/admin-donereports.php");
                            
                        }
                        if($_GET['request'] == "userslist"){
                            
                            include_once("lib/php/admin-userslist.php");
                            
                        }
                        if($_GET['request'] == "stats"){
                            
                            underConstruction();
                            
                            echo "<br /><br /><p><center>ETA > 24.05.2019</center></p>";
                            
                        }
                        if($_GET['request'] == "logs"){
                            
                            underConstruction();
                            
                            echo "<br /><br /><p><center>ETA > 24.05.2019</center></p>";
                            
                        }
                        
                    }else{
                        
                        include_once("lib/php/admin-panel.php");
                        
                    }
                    
                }else{

                    noAdminPermission();

                }
            
                echo "</section>";
        
            getFooter();
            
        }else{
            
            noPermission();
            
        }
        
        ?>
        
    </div>

</body>
</html>