<?php

if(isset($_COOKIE['auth_login']) && isset($_COOKIE['auth_token'])){
    
    require_once("handler.php");

    $db_connect = startConnection();
    
    $login = $_COOKIE['auth_login'];
    $permission = getPermission($login, $db_connect);

    if($permission == 100){
        
        if($_GET['id']){
            
            $archiveDate = date("Y-m-d H:i:s", (time() + 94));

            $archive = $db_connect->query("UPDATE replays SET done=1, archivedate='".$archiveDate."', archiveuser='".getRealname($login, $db_connect)."' WHERE id=".$_GET['id']."");
            
            $archive->closeCursor();
            $db_connect = null;

            header("Location: ../../admin/donereports?killcache=".rand()."");
            
        }else{
            
            header("Location: ../../admin/donereports?killcache=".rand()."");
            
        }

    }else{

        header("Location: ../../panel?killcache=".rand()."");

    }
    
}else{
    
    header("Location: ../../index");
    
}

?>