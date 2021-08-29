<?php

if(!empty($_GET['id'])){
    
    if(!empty($_POST['newPermission']) || $_POST['newPermission'] == 0){
 
        include_once("permission_checker.php");
        include_once("connect.php");
        
        $db_connect = startConnection();

        $permission = getPermission($_COOKIE['auth_login'], $db_connect);

        if($permission == 100){    

            $activate = $db_connect->query("UPDATE users SET permission=".$_POST['newPermission']." WHERE id=".$_GET['id']."");
            $username = $db_connect->query("SELECT realname FROM users WHERE id=".$_GET['id']."");

            foreach($username as $row)
                $name = $row['realname'];

            $username->closeCursor();
            $activate->closeCursor();
            $db_connect = null;

            header("Location: ../../profile/".$name."");

        }else{
            header("Location: ../../panel");
        }
    }
    
}

?>