<?php

if(!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['realname']) && !empty($_POST['discord']) && !empty($_POST['esportal']) && !empty($_POST['steam'])){
    
    include_once("connect.php");
    
    $db_connect = startConnection();
    $regLogin = addslashes(strtolower($_POST['login']));
    $regPassword = addslashes(md5($_POST['password']));
    $regEmail = addslashes($_POST['email']);
    $regRealname = addslashes($_POST['realname']);
    $regDiscord = addslashes($_POST['discord']);
    $regEsportal = addslashes($_POST['esportal']);
    $regSteam = addslashes($_POST['steam']);
    $regToken = addslashes(md5(time()));
    
    $register = $db_connect->query("INSERT INTO users(login, password, email, permission, active, token, realname, discord_id, esportal, steam) VALUES( '".$regLogin."', '".$regPassword."', '".$regEmail."', 0, 0, '".$regToken."', '".$regRealname."', '".$regDiscord."', '".$regEsportal."', '".$regSteam."')");
    
    $db_connect = null;
    
    header("Location: ../../index?register=true");
}

?>