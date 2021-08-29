<?php

if(!empty($_COOKIE['auth_token']) && !empty($_COOKIE['auth_login']) && !empty($_COOKIE['auth_id'])){
    if(!empty($_POST['discord'])){

        include_once("connect.php");

        $db_connect = startConnection();


        $token = addslashes($_COOKIE['auth_token']);
        $discord = addslashes($_POST['discord']);

        $change = $db_connect->query("UPDATE users SET discord_id='".$discord."' WHERE token='".$token."'");

        $change->closeCursor();
        $db_connect = null;

        header("Location: ../../settings?discord=true");
        
    }else{

    header("Location: ../../settings?discord=false");
        
    }
    
}else{
    
    header("Location: ../../index");
    
}



?>