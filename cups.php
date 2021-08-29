<?php

    require_once("lib/php/handler.php");
    
    if(isset($_COOKIE['auth_login'])){
        $login = $_COOKIE['auth_login'];
        $name = getRealname($login);
        $img = getPermissionImage($login);
        $permission = getPermission($login);
        setActive($login);
        
        $limit = 20;
        $page = 1;
        
        if(!empty($_GET['page'])){
            $page = $_GET['page'];
            $site = getNumberOfPages($limit, "tournaments", "active=0");
        }else{
            $page = 1;
            $site = getNumberOfPages($limit, "tournaments", "active=0");
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
    
    
        getHead("Turnieje - ");
    
    ?>
    
</head>
<body onload="startTime()">
    
    <div class='container-block'>
        
        <?php
        
        if(checkCookie()){
        
            getNav($img, $name, $permission, "cups");
        
            include_once("lib/php/cups-list.php");
            
            generatePageButtons("cups", $page, $site);
            
                echo "
                </div>
            </section>";
        
            getFooter();
            
        }else{
            
            noPermission();
            
        }
        
        ?>
        
    </div>

</body>
</html>