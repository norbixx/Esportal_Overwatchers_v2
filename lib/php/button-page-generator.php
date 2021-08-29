<?php

function generatePageButtons($link, $page, $site){

echo "<div class='buttons'>";    

    if($page > 1)
            echo "<a href='".$link."/".($page-1)."'><button class='buttonDefault blueB'><i class='fas fa-angle-left'></i></button></a>
            ";
    else
        echo "<button class='buttonDefault blueB'><i class='fas fa-angle-left'></i></button>
        ";

        for($k = 1; $k < $site + 1; $k++){

            if($k == $page)
                echo "<a href='".$link."/".$k."'><button class='buttonDefault activeB'>".$k."</button></a>";
            else
                echo "<a href='".$link."/".$k."'><button class='buttonDefault blueB'>".$k."</button></a>";
        }


    if($page > $site)    
        echo "
        <button class='buttonDefault blueB'><i class='fas fa-angle-right'></i></button>";
    else
        echo "
        <a href='".$link."/".($page+1)."'><button class='buttonDefault blueB'><i class='fas fa-angle-right'></i></button></a>";   

echo "</div>";
}
    
?>