<?php


function getReportBanStatus($id, $db){
    
    $status = $db->query("SELECT ban FROM replays WHERE id=".$id."");
    
    foreach($status as $row){
        
        if($row['ban'] == 0)
            return $banStatus = "<span class='white'>Oczekujące</span>";
        else if($row['ban'] == 1)
            return $banStatus = "<span class='success'>Zaakceptowane</span>";
        else if($row['ban'] == 2)
            return $banStatus = "<span class='failed'>Niewystarczające dowody</span>";
        else if($row['ban'] == 100)
            return $banStatus = "<span class='orange'>W trakcie sprawdzania</span>";
        else if($row['ban'] == 999)
            return $banStatus = "<span class='failed'>Wygasłe...</span>";
    }
    
    $status->closeCursor();
    
}

function getReportStatus($id, $db){
    
    $status = $db->query("SELECT done FROM replays WHERE id=".$id."");
    
    foreach($status as $row){
        
        if($row['done'] == 0)
            return $reportStatus = "Zakończony";
        else if($row['done'] == 1)
            return $reportStatus = "Zaarchiwizowany";
        
    }
    
    $status->closeCursor();
    
}

?>