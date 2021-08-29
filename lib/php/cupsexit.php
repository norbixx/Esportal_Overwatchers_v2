<?php

    if(!empty($_GET['tournament_id']) && !empty($_GET['user_id'])){
        include_once("connect.php");

        $db_connect = startConnection();

        $exit = $db_connect->prepare("DELETE FROM tournaments_users WHERE tournament_id=".$_GET['tournament_id']." AND user_id=".$_GET['user_id']."");
        
        $exit->execute();
        $db_connect = null;
        
        header('Location: ../../cups?exit=true');
        
    }else{
        
        header('Location: ../../cups?exit=false');
        
    }

?>