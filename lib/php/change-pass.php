<?php

if(!empty($_COOKIE['auth_token']) && !empty($_COOKIE['auth_login']) && !empty($_COOKIE['auth_id'])){
    if(!empty($_POST['password']) && !empty($_POST['password_repeat'])){

        include_once("connect.php");

        $db_connect = startConnection();


        $token = addslashes($_COOKIE['auth_token']);
        $password = addslashes(md5($_POST['password']));

        $change = $db_connect->query("UPDATE users SET password='".$password."' WHERE token='".$token."'");

        $change->closeCursor();
        $db_connect = null;

        header("Location: ../../settings?change=true");
        
    }else{

    header("Location: ../../settings?change=false");
        
    }
    
}else{
    
    header("Location: ../../index");
    
}



?>