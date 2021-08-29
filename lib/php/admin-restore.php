<?php

if(isset($_COOKIE['auth_login']) && isset($_COOKIE['auth_token'])){
    
    require_once("handler.php");
    
    $db_connect = startConnection();
    
    $login = $_COOKIE['auth_login'];
    $permission = getPermission($login, $db_connect);

    if($permission == 100){
        
        if($_GET['id']){

            $restore = $db_connect->query("UPDATE replays SET ban=0, repadmin=NULL, repdate=NULL WHERE id=".$_GET['id']."");

            $restore->closeCursor();
            $db_connect = null;

            header("Location: ../../admin/activereports?killcache=".rand()."");
            
        }else{
            
            header("Location: ../../admin/activereports?killcache=".rand()."");
            
        }

    }else{

        header("Location: ../../panel?killcache=".rand()."");

    }
    
}else{
    
    header("Location: ../../index");
    
}

?>