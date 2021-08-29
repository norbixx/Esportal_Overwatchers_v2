<?php

if(isset($_COOKIE['auth_login']) && isset($_COOKIE['auth_token'])){
        require_once("handler.php");

        $login = $_COOKIE['auth_login'];
        $name = getRealname($login);
        $permission = getPermission($login);

        if($permission == 100 || $permission == 50){

            $db_connect = startConnection();
            
            $date = date("Y-m-d", time() - (60*60*24));
            $time = date("Y-m-d H:i:s", time() + 94);
            
            for($i = 0; $i < 10; $i++){
                
                if(!empty($_POST['user_'.$i]) && !empty($_POST['points_'.$i]) && !empty($_POST['league'])){
                
                    $user = addslashes($_POST['user_'.$i]);
                    $points = addslashes($_POST['points_'.$i]);
                    $league = addslashes($_POST['league']);
                    
                    $insertScore = $db_connect->query("INSERT INTO league_score(user, points, l_id, date, add_date, admin) VALUES('".$user."', '".$points."', ".$league.", '".$date."', '".$time."', '".$name."')");
                    
                    
                }else{
                    header("Location: ../../hero-league?add=false");
                }
                
            }
            
            $insertScore->closeCursor();
            $db_connect = null;
            
            header("Location: ../../hero-league?add=true");
            
        }else{
            
           header("Location: ../../panel"); 
            
        }

}else{
    
    header("Location: ../../index");
}

?>