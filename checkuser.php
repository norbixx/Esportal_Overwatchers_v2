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
    
        getHead("Kartoteka - ");
    
    ?>
    
</head>
<body onload="startTime()">
    
    <div class='container-block'>
        
        <?php
        
        if(checkCookie($db_connect)){
        
            getNav($img, $name, $permission, "checkuser");
        
                echo "<section class='content'>";
                
                include_once("lib/php/user-check.php");
            
                echo "</section>";
        
            getFooter();
            
        }else{
            
            noPermission();
            
        }
        
        ?>
        
        
    </div>

</body>
</html>