<?php

if(!empty($_COOKIE['auth_token']) && !empty($_COOKIE['auth_login']) && !empty($_COOKIE['auth_id'])){
    if(!empty($_POST['email'])){

        include_once("connect.php");

        $db_connect = startConnection();


        $token = addslashes($_COOKIE['auth_token']);
        $email = addslashes($_POST['email']);

        $change = $db_connect->query("UPDATE users SET email='".$email."' WHERE token='".$token."'");

        $change->closeCursor();
        $db_connect = null;

        header("Location: ../../settings?email=true");
        
    }else{

    header("Location: ../../settings?email=false");
        
    }
    
}else{
    
    header("Location: ../../index");
    
}



?>