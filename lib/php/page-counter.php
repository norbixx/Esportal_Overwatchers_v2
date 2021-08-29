<?php

function getNumberOfPages($limit, $from, $where, $db){
    
    $countQuery = $db->query("SELECT count(*) as count FROM ".$from." WHERE ".$where."");
    
    foreach($countQuery as $row)
        $count = $row['count'];
        
    $countQuery->closeCursor();
    
    return $site = ($count/$limit);
}

?>