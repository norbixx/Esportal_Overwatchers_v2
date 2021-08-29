<?php

function getPermission($login, $db){
    
    $permissionQuery = $db->query("SELECT permission FROM users WHERE login='".$login."'");
    
    foreach($permissionQuery as $row)
        return $row['permission'];
    
    $permissionQuery->closeCursor();
    
}

function getPermissionImage($login, $db){
    
    $permissionQuery = $db->query("SELECT permission FROM users WHERE login='".$login."'");
    
    foreach($permissionQuery as $row){
        $permission = $row['permission'];
        
        if($permission == 100)
            return $img = "<img src='lib/img/admin.png' alt='admin' class='permissionImage' />";
        else if($permission == 50)
            return $img = "<img src='lib/img/cupmod.png' alt='cupmod' class='permissionImage' />";
        else
            return $img = "<img src='lib/img/overwatcher.png' alt='overwatcher' class='permissionImage' />";
    }
    
    $permissionQuery->closeCursor();
    
}

function getPermissionText($login, $db){
    
    $permissionQuery = $db->query("SELECT permission FROM users WHERE login='".$login."'");
    
    foreach($permissionQuery as $row){
        $permission = $row['permission'];
        
        if($permission == 100)
            return $text = "Administrator";
        else if($permission == 50)
            return $text = "Moderator turnieju";
        else
            return $text = "Overwatcher";
    }
    
    $permissionQuery->closeCursor();
    
}

function getLogin($name, $db){
    
    $loginQuery = $db->query("SELECT login FROM users WHERE realname='".$name."'");
    
    foreach($loginQuery as $row){
        return $row['login'];
    }
    
    $loginQuery->closeCursor();
    
}

?>