<?php

if(isset($_COOKIE['auth_login']) && isset($_COOKIE['auth_token'])){
    
    if($_GET['id'] && $_GET['user']){
        
        require_once("connect.php");

        $db_connect = startConnection();

        $restore = $db_connect->query("UPDATE replays SET ban=0, repadmin=NULL, repdate=NULL WHERE id=".$_GET['id']." AND repadmin='".$_GET['user']."'");

        $restore->closeCursor();
        $db_connect = null;

        header("Location: ../../myreports?restore=true");

        }
    
    header("Location: ../../myreports?restore=false");
    
}else{
    
    header("Location: ../../index");
    
}

?>