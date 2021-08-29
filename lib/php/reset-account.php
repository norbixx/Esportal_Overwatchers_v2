<?php

function uniquePass($l){
    return substr(uniqid(mt_rand(), true), 0, $l);
}

if(!empty($_GET['id'])){
 
    include_once("permission_checker.php");
    include_once("connect.php");
    
    $permission = getPermission($_COOKIE['auth_login']);
    
    if($permission == 100){
        
        $db_connect = startConnection();
        
        $newPass = uniquePass(16);
        
        $activate = $db_connect->query("UPDATE users SET password='".md5($newPass)."' WHERE id=".$_GET['id']."");
        $username = $db_connect->query("SELECT realname FROM users WHERE id=".$_GET['id']."");
        
        foreach($username as $row)
            $name = $row['realname'];
            
        $username->closeCursor();
        $activate->closeCursor();
        $db_connect = null;
        
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=../../profile/".$name."\"> <script>alert('Nowe haslo uzytkownika: ".$newPass."');</script>";
        
    }else{
        header("Location: ../../panel");
    }
    
}

?>