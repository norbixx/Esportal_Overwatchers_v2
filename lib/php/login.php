<?php    
    
    include_once "connect.php";
    
    if(!empty($_POST['login']) && !empty($_POST['password'])){
        
        $db_connect = startConnection();
        $time = date("Y-m-d H:i:s", time() + 94);
        
		$login = addslashes(strtolower($_POST['login']));
		$password = md5(addslashes($_POST['password']));
		
        $passQuery = $db_connect->query("SELECT id,login,password,permission,active,token FROM users WHERE login='$login'");
        
        foreach($passQuery as $row){
            
            if($row['login'] == $login && $row['password'] === $password){
                
                if($row['active'] == 1){
                    
                    setcookie("auth_token", $row['token'], time()+2592000, '/');
                    setcookie("auth_login", $row['login'], time()+2592000, '/');
                    setcookie("auth_id", $row['id'], time()+2592000, '/');
                    
                    $date = date("Y-m-d H:i:s", time() + 94);
                    
                    $setTime = $db_connect->query("UPDATE users SET lastlogin='".$date."' WHERE id=".$row['id']."");
                    
                    $setTime->closeCursor();
                    $passQuery->closeCursor();
                    $db_connect = null;
                    
                    header("Location: ../../panel");
                    
                }else{
                    
                    $passQuery->closeCursor();
                    $db_connect = null;
                    
                    header("Location: ../../index");
                }
                
                
            }else{
                
                $passQuery->closeCursor();
                $db_connect = null;
                
                header("Location: ../../index?login=wrong");
            }
            
        }
        
        header("Location: ../../index?login=wrong");
    }

?>