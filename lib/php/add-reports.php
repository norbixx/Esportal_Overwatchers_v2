<?php

if(isset($_COOKIE['auth_login']) && isset($_COOKIE['auth_token'])){
        require_once("handler.php");
    
        $db_connect = startConnection();

        $login = $_COOKIE['auth_login'];
        $permission = getPermission($login, $db_connect);

        if($permission == 100){  
            
            for($i = 0; $i < 12; $i++){
                
                if(!empty($_POST['link_'.$i]) && !empty($_POST['repuser_'.$i]) && !empty($_POST['report_'.$i]) && !empty($_POST['replink_'.$i])){
                
                    $link = addslashes($_POST['link_'.$i]);
                    $repuser = addslashes($_POST['repuser_'.$i]);
                    $report = addslashes($_POST['report_'.$i]);
                    $replink = addslashes($_POST['replink_'.$i]);
                    $expireTime = date("Y-m-d H:i:s", (time() + (61*24*60*60) + 94));
                    
                    if(!empty($_POST['admindesc_'.$i])){
                        $admindesc = addslashes($_POST['admindesc_'.$i]);
                        
                        $insertScore = $db_connect->query("INSERT INTO replays(link, repuser, report, admindesc, replink, expiredate) VALUES ('".$link."', '".$repuser."', '".$report."', '".$admindesc."', '".$replink."', '".$expireTime."')");
                    }else{
                        $insertScore = $db_connect->query("INSERT INTO replays(link, repuser, report, admindesc, replink, expiredate) VALUES ('".$link."', '".$repuser."', '".$report."', NULL, '".$replink."', '".$expireTime."')");
                    }
                    
                    
                }else{
                    
                    header("Location: ../../admin/addreports?add=false");
                    
                }
                
            }
            
            $insertScore->closeCursor();
            $db_connect = null;
            
            header("Location: ../../admin/addreports?add=true");
            
        }else{
            
           header("Location: ../../panel"); 
            
        }

}else{
    
    header("Location: ../../index");
}

?>