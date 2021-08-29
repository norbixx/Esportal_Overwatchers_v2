<?php

    function getRealname($login, $db){

        $loginQuery = $db->query("SELECT realname FROM users WHERE login='".$login."'");

        foreach($loginQuery as $row)
            return $row['realname'];

        $loginQuery->closeCursor();
        
    }

    function getUserStatus($login, $db){

        $statusQuery = $db->query("SELECT active FROM users WHERE login='".$login."'");

        foreach($statusQuery as $row){
            if($row['active'] == 0)
                return "<span class='failed'>Nieaktywne</span>";
            else
                return "<span class='success'>Aktywne</span>";
        }

        $statusQuery->closeCursor();
    }

?>