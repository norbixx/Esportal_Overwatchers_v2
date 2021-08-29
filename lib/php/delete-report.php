<?php

if(isset($_COOKIE['auth_login']) && isset($_COOKIE['auth_token'])){
    if($_GET['id']){
        require_once("handler.php");
        
        $db_connect = startConnection();

        $login = $_COOKIE['auth_login'];
        $permission = getPermission($login, $db_connect);

        if($permission == 100){

            $delete = $db_connect->query("UPDATE replays SET ban=999, done=999 WHERE id=".$_GET['id']."");
            
            $delete->closeCursor();
            $db_connect = null;
            
            header("Location: ../../panel?delete=true");

        }else{
            header("Location: ../../panel?delete=false");
        }
        header("Location: ../../panel");
    }
    
}else{
    header("Location: ../../index");
}

?>