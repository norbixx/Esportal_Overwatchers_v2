<?php

    require_once("lib/php/handler.php");
    
    $db_connect = startConnection();

    if(isset($_COOKIE['auth_login'])){
        $login = $_COOKIE['auth_login'];
        $name = getRealname($login, $db_connect);
        $img = getPermissionImage($login, $db_connect);
        $permission = getPermission($login, $db_connect);
        setActive($login, $db_connect);
        
        $limit = 20;
        $page = 1;
        
        if(!empty($_GET['page'])){
            $page = $_GET['page'];
            $site = getNumberOfPages($limit, "replays", "ban=0 and done=0", $db_connect);
        }else{
            $page = 1;
            $site = getNumberOfPages($limit, "replays", "ban=0 and done=0", $db_connect);
        }
        
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
    
    
        getHead("Zgłoszenia - ");
    
    ?>
    
</head>
<body onload="startTime()">
    
    <div class='container-block'>
        
        <?php
        
        if(checkCookie($db_connect)){
        
            getNav($img, $name, $permission, "panel");
        
                echo "<section class='content'>";
            
                include_once("lib/php/demos-list.php");
                
                generatePageButtons("panel", $page, $site);
            
                echo "</section>";
        
            getFooter();
            
        }else{
            
            noPermission();
            
        }
        
        ?>
        
    </div>

</body>
</html>