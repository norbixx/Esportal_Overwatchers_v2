<?php

if(!empty($_COOKIE['auth_token']) && !empty($_COOKIE['auth_login']) && !empty($_COOKIE['auth_id'])){
    if(!empty($_POST['steam'])){

        include_once("connect.php");

        $db_connect = startConnection();


        $token = addslashes($_COOKIE['auth_token']);
        $steam = addslashes($_POST['steam']);

        $change = $db_connect->query("UPDATE users SET steam='".$steam."' WHERE token='".$token."'");

        $change->closeCursor();
        $db_connect = null;

        header("Location: ../../settings?steam=true");
        
    }else{

    header("Location: ../../settings?steam=false");
        
    }
    
}else{
    
    header("Location: ../../index");
    
}



?>