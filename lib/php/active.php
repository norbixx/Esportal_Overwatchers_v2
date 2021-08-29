<?php

function setActive($login, $db){
    if (time() > (time() - (5*60) + 94)){
        
        $setActive = $db->query("UPDATE users SET activitytime=NOW() WHERE login='".$login."'");
        
        $setActive->closeCursor();
        
    }
}

function checkActive($login, $db){
        
    $aTime = date("Y-m-d H:i:s", (time() - (5*60) + 94));

    $checkActive = $db->query("SELECT activitytime FROM users WHERE login='".$login."'");
                
    foreach($checkActive as $row){
        if($row['activitytime'] > $aTime)
            return "<span class='dot online'></span>";
        else
            return "<span class='dot offline'></span>";
    }
    
    $checkActive->closeCursor();
    
}

?>