<?php

    if(isset($_COOKIE['auth_token']) && isset($_COOKIE['auth_login']) && isset($_COOKIE['auth_id'])){
        unset($_COOKIE['auth_token']);
        unset($_COOKIE['auth_login']);
        unset($_COOKIE['auth_id']);
        setcookie('auth_token', null, time() - 3600, '/');
        setcookie('auth_login', null, time() - 3600, '/');
        setcookie('auth_id', null, time() - 3600, '/');
        
        $login = $_COOKIE['auth_login'];
        $token = $_COOKIE['auth_token'];
    }
    
    header("Location: ../../index");

?>