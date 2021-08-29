<?php
    if(isset($_COOKIE['auth_token'])){

        $token = $_COOKIE['auth_token'];

        $db_connect = startConnection();
        $userQuery = $db_connect->query("SELECT login, realname, permission, lastlogin FROM users where token='".$token."'");

        foreach($userQuery as $row){
            $login = $row['login'];
            $realName = $row['realname'];
            $permission = $row['permission'];
            $lastLogin = $row['lastlogin'];
        }

        $authDate = new DateTime($lastLogin);
        $authDate->modify("+2 week");
        $remainingDate = strtotime($authDate->format("Y-m-d H:i:s"));
        $remaining = $remainingDate - time();
        $daysRemaining = floor($remaining / 86400);

        if($daysRemaining > 7)
            $days = "za <span class='green'>".$daysRemaining."</span> dni";
        else if($daysRemaining > 3)
            $days = "za <span class='orange'>".$daysRemaining."</span> dni";
        else if($daysRemaining > 1)
            $days = "za <span class='red'>".$daysRemaining."</span> dni";
        else
            $days = "<span class='red'>DZIŚ</span>!";

        echo "
            <div id='auth-true'>
                <p>Zalogowany jako ".getPermissionImage($login, $db_connect)."<span class='accTheme'>".$realName."</span></p>
                <p>Twoja sesja wygasa ".$days."</p>
                <p>Data ostatniego logowania: ".$lastLogin."</p>
                <a href='panel?killcache=".rand()."'><button class='buttonDefault blueB'><i class='fas fa-angle-double-up'></i> Przejdź do panelu</button></a>
                <a href='lib/php/logout'><button class='buttonDefault redB'><i class='fa fa-sign-out-alt'></i> Wyloguj</button></a>
            </div>
            ";

        $userQuery->closeCursor();
        $db_connect = null;

    }else{
        echo "            
            <form method='POST' action='lib/php/login'>
            <table cellspacing='0' cellpadding='0' class='login-table'>
            <thead>
            </thead>
            <tbody>
                <tr>
                    <td><input type='text' name='login' placeholder='Login' class='inputLogin'></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><input type='password' name='password' placeholder='Hasło' id='passInput' class='inputLogin correct'></td>
                    <td><input type='checkbox' onclick='unlockPass()' class='css-checkbox'></td>
                </tr>
                <tr colspan='2'>
                    <td><button type='submit' class='buttonDefault blueB'>ZALOGUJ <i class='fas fa-sign-in-alt'></i> </button></td>
                </tr>
            </tbody>
            </table>
            </form>

            <p>Jeżeli zapomniałeś hasła skontaktuj się z administratorem.</p>
            "; 
    }

?>