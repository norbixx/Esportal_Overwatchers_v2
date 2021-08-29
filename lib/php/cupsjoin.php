<?php

    if(!empty($_GET['tournament_id']) || $_GET['permission'] == 0 && !empty($_GET['user_id']) && !empty($_GET['permission'])){
        include_once("connect.php");

        $db_connect = startConnection();

        $join = $db_connect->query("INSERT INTO tournaments_users(tournament_id, user_id, permission) VALUES(".$_GET['tournament_id'].", ".$_GET['user_id'].", ".$_GET['permission'].")");
        
        $join->closeCursor();
        $db_connect = null;
        
        header('Location: ../../cups?join=true');
        
    }else{
        
        header('Location: ../../cups?join=false');
        
    }

?>