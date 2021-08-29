<?php

if(isset($_COOKIE['auth_login']) && isset($_COOKIE['auth_token']))
{
    
    require_once("handler.php");

    $db_connect = startConnection();
    
    $login = $_COOKIE['auth_login'];
    $permission = getPermission($login, $db_connect);

    if($permission == 100)
	{  
		$archiveDate = date("Y-m-d H:i:s", (time() + 94));

		$archiveAll = $db_connect->query("UPDATE replays SET done=1, archivedate='".$archiveDate."', archiveuser='".getRealname($login, $db_connect)."' WHERE done=0 AND (ban=1 OR ban=2)");
            
		$archiveAll->closeCursor();
		$db_connect = null;

		header("Location: ../../admin/donereports?killcache=".rand()."");
    }
	else
	{
        header("Location: ../../panel?killcache=".rand()."");
    }
    
}

else
{
    header("Location: ../../index");
}

?>