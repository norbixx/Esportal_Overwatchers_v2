<?php

    require_once("lib/php/handler.php");
    
    $db_connect = startConnection();

    if(isset($_COOKIE['auth_login'])){
        $login = $_COOKIE['auth_login'];
        $name = getRealname($login, $db_connect);
        $img = getPermissionImage($login, $db_connect);
        $permission = getPermission($login, $db_connect);
        setActive($login, $db_connect);
        
        
    }else{
        
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    
    <?php
    
        if(!empty($_POST['date']))
            echo "<base href='../''>";
        else
            echo "<base href='./''>";
    
    
        getHead("Hero League - ");
    
    ?>
    
</head>
<body onload="startTime()">
    
    <div class='container-block'>
        
        <?php
        
        if(checkCookie($db_connect)){
        
            getNav($img, $name, $permission, "panel");
        
                echo "<section class='content'>";
            
                $db_connect = startConnection();
            
                echo "
                <form action='lib/php/add-heropoints.php' method='POST' class='hero-table'>
                    <table cellspacing='0' cellpadding='0'>
                    <thead>
                        <tr>
                            <th colspan='2'><i class='fas fa-calendar-plus'></i> Wprowadzanie punktów do tabeli Hero League</th>
                        </tr>
                    </thead>
                    <tbody>";
                
                if(!empty($_GET['add'])){
                    echo "<tr><td>";    
                    
                    getSuccess("add", "true", "Punkty zostały wprowadzone pomyślnie");
                    getFailed("add", "false", "Wystąpił błąd podczas wprowadzania punktów");
                    
                    echo "</td></tr>";
                }
            
                for($k = 0; $k < 10; $k++){
                
                if($k == 0){
                    $points = 10;
                    $select_10 = "selected";
                    $select_6 = "";
                    $select_4 = "";
                    $select_3 = "";
                    $select_2 = "";
                    $select_1 = "";
                }else if($k == 1){
                    $points = 6;
                    $select_10 = "";
                    $select_6 = "selected";
                    $select_4 = "";
                    $select_3 = "";
                    $select_2 = "";
                    $select_1 = "";
                }else if($k == 2){
                    $points = 4;
                    $select_10 = "";
                    $select_6 = "";
                    $select_4 = "selected";
                    $select_3 = "";
                    $select_2 = "";
                    $select_1 = "";
                }else if($k == 3){
                    $points = 3;
                    $select_10 = "";
                    $select_6 = "";
                    $select_4 = "";
                    $select_3 = "selected";
                    $select_2 = "";
                    $select_1 = "";
                }else if($k == 4){
                    $points = 2;
                    $select_10 = "";
                    $select_6 = "";
                    $select_4 = "";
                    $select_3 = "";
                    $select_2 = "selected";
                    $select_1 = "";
                }else{
                    $points = 1;
                    $select_10 = "";
                    $select_6 = "";
                    $select_4 = "";
                    $select_3 = "";
                    $select_2 = "";
                    $select_1 = "selected";
                }
                    
                echo "    
                        <tr>
                            <td  class='selector'>
                                <input type='text' name='user_".$k."' placeholder='Nazwa użytkownika' class='inputDefault'>
                                <select name='points_".$k."' class='selectNumberDefault'>
                                    <option value='10' ".$select_10.">10 pkt.</option>
                                    <option value='6' ".$select_6.">6 pkt.</option>
                                    <option value='4' ".$select_4.">4 pkt.</option>
                                    <option value='3' ".$select_3.">3 pkt.</option>
                                    <option value='2' ".$select_2.">2 pkt.</option>
                                    <option value='1' ".$select_1.">1 pkt.</option>
                                </select>
                            </td>
                        </tr>
                    ";
                }
                            
                echo "
                        <tr>
                            <td>
                                <select name='league' class='selectLeagueDefault'>";

                $leagues = $db_connect->query("SELECT l_id, name, active FROM league ORDER BY l_id ASC, active DESC");
            
                foreach($leagues as $league){
                    
                    if($league['active'] == 1)
                        echo "<option value='".$league['l_id']."'>".$league['name']."</option>";
                    else
                        echo "<option value='".$league['l_id']."' disabled>".$league['name']."</option>";
                    
                }
            
                $leagues->closeCursor();
            
                echo "
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type='submit' class='buttonDefault greenB'><i class='fas fa-upload'></i> Prześlij wyniki</button>
                            </td>
                        </tr>
                        </tbody>
                        </table>
                    </form>";
                
            
                $types = array("ZMIANA ELO", "KILLE", "AK-47", "M4A1-M4A4", "AWP");
            
                if(!empty($_POST['date'])){
                    $date = $_POST['date'];
                }
                else{
                    $date = date("Y-m-d", time() - (60*60*24));
                }
                    
                echo "
                    <table cellpadding='0' cellspacing='0' class='hero-league'>
                    <thead>
                        <tr>
                            <th colspan='5'><i class='fas fa-calendar-day'></i> Statystyki dzienne z dnia ".$date."</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    </table>
                    <form method='POST' action='hero-league/".$date."'>
                        <table>
                        <tbody>
                            <tr>
                                <td><br />
                                    <input type='date' name='date' value='".$date."' class='inputDefault' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}'><br />
                                    <button type='submit' class='buttonDefault blueB'><i class='fas fa-file-download'></i> Pobierz wyniki</button><br /><br />
                                </td>
                        </tbody>
                    </form>
                    
                ";
                    
                    for($i = 0; $i < count($types); $i++){
                        
                        $dailyStats = $db_connect->query("SELECT user, score FROM heroleague where type='".$types[$i]."' and last_update='".$date."' ORDER BY score DESC LIMIT 10");
                        
                        echo "
                            <table cellpadding='0' cellspacing='0' class='daily-stats'>
                            <thead>
                                <tr>
                                    <th colspan='3' class='centered'>
                                        <img src='lib/img/".$types[$i].".png' alt='".$types[$i]."' class='dailyimg' />".$types[$i].":
                                    </th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Gracz:</th>
                                    <th>Punkty:</th>
                                </tr>
                            </thead>
                            <tbody>
                        ";
                        
                        $j = 1;
                        
                        foreach($dailyStats as $row){
                            
                            echo "
                            <tr>
                                <td>".$j."</td>
                                <td>".$row['user']."</td>
                                <td>".$row['score']."</td>
                            </tr>
                            ";
                            
                            $j++;
                        }
                        
                        echo "
                            </tbody>
                            </table>
                        ";
                        
                    }
                
                $dailyStats->closeCursor();
                $db_connect = null;
            
                echo "</section>";
        
            getFooter();
            
        }else{
            
            noPermission();
            
        }
        
        ?>
        
    </div>

</body>
</html>