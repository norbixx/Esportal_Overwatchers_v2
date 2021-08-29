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
    
        if(isset($_GET['id'])){
            if(!empty($_GET['id'] && empty($_GET['view']))){
                echo "<base href='../'>";
                getHead("Zgłoszenie #".$_GET['id']." - ");
            }else if(!empty($_GET['view']) && !empty($_GET['id'])){
                echo "<base href='../../'>";
                getHead("Zgłoszenie #".$_GET['id']." (tryb podglądu) - ");
            }else{
                echo "<base href='../'>";
                getHead("Zgłoszenia - ");
            }
        }else{
            echo "<base href='./'>";
            getHead("Zgłoszenia - ");
        }
    ?>
    
</head>
<body onload="startTime()">
    
    <div class='container-block'>
        
        <?php
        
        if(checkCookie($db_connect)){
        
            getNav($img, $name, $permission, "report");
        
                echo "<section class='content'>";
            
                if(!empty($_GET['id']) && empty($_GET['view'])){
                    
                    include_once("lib/php/report-admin.php");
                    
                }
                if(!empty($_GET['id']) && !empty($_GET['view'])){
                    
                    include_once("lib/php/report-view.php");
                    
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