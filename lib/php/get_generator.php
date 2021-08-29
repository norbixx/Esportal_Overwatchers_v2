<?php

function getFailed($index, $value, $text){
    
    if(!empty($_GET[''.$index.''])){
        if($_GET[''.$index.''] == ''.$value.''){
            echo "<i class='fas fa-exclamation-triangle'></i><span class='failed'> ".$text." </span><i class='fas fa-exclamation-triangle'></i>";
        }
    }
    
}

function getSuccess($index, $value, $text){
    
    if(!empty($_GET[''.$index.''])){
        if($_GET[''.$index.''] == ''.$value.''){
            echo "<i class='fas fa-exclamation-triangle'></i><span class='success'> ".$text." </span><i class='fas fa-exclamation-triangle'></i>";
        }
    }
    
}

?>