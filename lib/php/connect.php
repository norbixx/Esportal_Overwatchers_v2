<?php

require_once "config.php";

function startConnection(){
    try{
        if(empty($db_connect))
            return $db_connect = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET."", "".DB_USER."", "".DB_PASSWORD."");
        else
            exit();
            
    }catch(PDOException $e){
        echo 'Połączenie nie mogło zostać nawiązane: ' . $e->getMessage();
        die();
    }
}

?>