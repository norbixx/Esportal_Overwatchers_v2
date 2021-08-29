<?php

if(!empty($_POST['description']) && !empty($_POST['ban']) && !empty($_GET['id'])){
    
    include_once("connect.php");
    
    $description = addslashes($_POST['description']);
    
    $db_connect = startConnection();
    
    $send = $db_connect->query("UPDATE replays SET description='".$description."', ban=".$_POST['ban'].", expiredate=NULL WHERE id=".$_GET['id']."");
    
    $db_connect = null;
    
    header("Location: ../../panel?reportsend=true");
    
}else{
    
    header("Location: ../../panel?reportsend=false");
    
}


?>