<?php

function getUserReportsBanned($name, $db){
    
    $userDataCount = $db->query("SELECT u.login AS login, u.permission AS permission, count(case when r.repadmin = u.realname then 1 else null end) AS repCount FROM users AS u, replays AS r WHERE r.ban = 1 AND u.realname='".$name."' GROUP BY u.login ORDER BY repCount DESC");
    
    foreach($userDataCount as $row)
        $userReportsBanned = $row['repCount'];
    
    $userDataCount->closeCursor();
    
    return $userReportsBanned;
}

function getUserReportsUnbanned($name, $db){
    
    $userDataCount = $db->query("SELECT u.login AS login, u.permission AS permission, count(case when r.repadmin = u.realname then 1 else null end) AS repCount FROM users AS u, replays AS r WHERE r.ban = 2 AND u.realname='".$name."' GROUP BY u.login ORDER BY repCount DESC");
    
    foreach($userDataCount as $row)
        $userReportsUnbanned = $row['repCount'];
    
    $userDataCount->closeCursor();
    
    return $userReportsUnbanned;
}


?>