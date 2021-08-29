<?php

function checkCookie($db){
    
    if(isset($_COOKIE['auth_token']) && isset($_COOKIE['auth_login']) && isset($_COOKIE['auth_id'])){
        
        $checkCookie = $db->query("SELECT id, login, token FROM users where token='".$_COOKIE['auth_token']."' AND login='".$_COOKIE['auth_login']."'");
        
        foreach($checkCookie as $row){
            
            if($_COOKIE['auth_id'] == $row['id'] && $_COOKIE['auth_login'] == $row['login'] && $_COOKIE['auth_token'] == $row['token'])
                return true;
            else
                return false;
        }
        
        $checkCookie->closeCursor();
        
    }
    
}

?>