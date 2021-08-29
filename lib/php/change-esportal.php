<?php

if(!empty($_COOKIE['auth_token']) && !empty($_COOKIE['auth_login']) && !empty($_COOKIE['auth_id'])){
    if(!empty($_POST['esportal'])){

        include_once("connect.php");

        $db_connect = startConnection();


        $token = addslashes($_COOKIE['auth_token']);
        $esportal = addslashes($_POST['esportal']);

        $change = $db_connect->query("UPDATE users SET esportal='".$esportal."' WHERE token='".$token."'");

        $change->closeCursor();
        $db_connect = null;

        header("Location: ../../settings?esportal=true");
        
    }else{

    header("Location: ../../settings?esportal=false");
        
    }
    
}else{
    
    header("Location: ../../index");
    
}



?>