<?php
    echo "<section class='content'>
            <div class='cups'>
                <p class='heading'><i class='fas fa-trophy'></i> Aktualne turnieje</p>";

    function checkTournamentStatus($tournament_id, $user_id){

        $db_connect = startConnection();

        $check = $db_connect->query("SELECT tournament_id, user_id FROM tournaments_users WHERE tournament_id=".$tournament_id." AND user_id=".$user_id." GROUP BY tournament_id, user_id");

        $count = $check->rowCount();

        if($count == 1)
            return true;
        else
            return false;

        $db_connect = null;

    }

    function checkTournamentAdmin($tournament_id, $user_id){

        $db_connect = startConnection();

        $check = $db_connect->query("SELECT tournament_id, user_id FROM tournaments_users WHERE tournament_id=".$tournament_id." AND user_id=".$user_id." GROUP BY tournament_id, user_id");

        $count = $check->rowCount();

        if($count == 1)
            return true;
        else
            return false;

        $db_connect = null;

    }

    $db_connect = startConnection();

    $tournaments = $db_connect->query("SELECT id, name, date, time, slots, active, winner FROM tournaments WHERE active=1 ORDER BY date ASC");

    echo "
        <table cellspacing='0' cellpadding='0' class='cups-list'>
        <thead>
            <tr>
                <th></th>
                <th>Nazwa turnieju:</th>
                <th>Data:</th>
                <th>Godzina:</th>
                <th>Ilość slotów:</th>
                <th>Ilość administratorów:</th>
                <th>Zapisany:</th>
            </tr>
        </thead>
        <tbody>";

    if($tournaments->rowCount() > 0){
        foreach($tournaments as $row){

            if($row['slots'] == 256 || $row['slots'] == 128 || $row['slots'] == 16 || $row['slots'] == 8)
                $slots = $row['slots']." slotów";
            else if($row['slots'] == 64 || $row['slots'] == 32)
                $slots = $row['slots']." sloty";

            $tournament_id = $row['id'];

            $users = $db_connect->query("SELECT tournament_id, user_id FROM tournaments_users WHERE tournament_id=".$row['id']." GROUP BY tournament_id, user_id ORDER BY permission DESC, user_id ASC ");

            $counter = $users->rowCount();

            if($counter < 10)
                $adminsCounter = "<span class='success'>".$counter."/10</span>";
            else
                $adminsCounter = "<span class='failed'>".$counter."/10</span>";

            if(checkTournamentAdmin($row['id'], $_COOKIE['auth_id']))
                $adminStatus = "<span class='success'>Tak</span>";
            else
                $adminStatus = "<span class='failed'>Nie</span>";

            echo "
                <tr onclick='cupsToggler(".$row['id'].");' class='cup-bar'>
                    <td><i class='fas fa-caret-up caret-".$row['id']."' id='caret-".$row['id']."'></i></td>
                    <td> ".$row['name']."</td>
                    <td>".$row['date']."</td>
                    <td>".$row['time']."</td>
                    <td>".$slots."</td>
                    <td>".$adminsCounter."</td>
                    <td>".$adminStatus."</td>
                </tr>";

            if($counter == 0){
                for($j = 0; $j < (10 - $counter); $j++){
                    echo "
                        <tr class='toggler toggle-".$row['id']."' id='cups-toggler' style='display: none;'>
                            <td colspan='7'>&nbsp;</td>
                        </tr>
                        ";
                }
            }else{

                foreach($users as $user){

                    $user_id = $user['user_id'];
                    $getUser = $db_connect->query("SELECT login, realname FROM users WHERE id=".$user_id."");

                    foreach($getUser as $userList){

                        echo "
                            <tr class='toggler toggle-".$row['id']."' id='cups-toggler' style='display: none;'>
                                <td colspan='7'>".getPermissionImage($userList['login'])."".$userList['realname']."</td>
                            </tr>
                        ";

                    }


                }

            $users->closeCursor();
            $getUser->closeCursor();

                    if($counter < 10){
                        for($j = 0; $j < (10 - $counter); $j++){
                            echo "
                        <tr class='toggler toggle-".$row['id']."' id='cups-toggler' style='display: none;'>
                            <td colspan='7'>&nbsp;</td>
                        </tr>
                        ";
                        }
                    }

            }

            if(checkTournamentStatus($tournament_id, $_COOKIE['auth_id'])){
                echo "
                <tr class='toggler toggle-".$row['id']."' id='cups-toggler' style='display: none;'>
                    <td colspan='7'><span class='bold'>DZIAŁANIA: 
                        </span>
                        <a href='lib/php/cupsexit.php?tournament_id=".$tournament_id."&user_id=".$_COOKIE['auth_id']."'><button class='buttonDefault redB'><i class='fas fa-sign-out-alt'></i> Wypisz się</button></a>
                    </td>
                </tr>";
            }else if($counter < 10){
                echo "
                <tr class='toggler toggle-".$row['id']."' id='cups-toggler' style='display: none;'>
                    <td colspan='7'>
                        <span class='bold'>DZIAŁANIA: </span>
                        <a href='lib/php/cupsjoin.php?tournament_id=".$tournament_id."&user_id=".$_COOKIE['auth_id']."&permission=".$permission."'><button class='buttonDefault joinB'><i class='fas fa-check-square'></i> Zapisz się</button></a>
                    </td>
                </tr>";
            }

        }
    }else{
        echo "
        <tr>
            <td colspan='7'><br />Brak aktualnych turniejów.<br /><br /></td>
        </tr>";
    }


    echo "
        </tbody>
        </table>";


    echo "
    <p class='heading'><i class='fas fa-archive'></i> Archiwalne turnieje</p>";

    $archive = $db_connect->query("SELECT name, date, time, slots, winner FROM tournaments WHERE active=0 ORDER BY date DESC LIMIT ".($page-1)*$limit.",".$limit."");

    echo "
        <table cellspacing='0' cellpadding='0' class='archive-list'>
        <thead>
            <tr>
                <th>Nazwa:</th>
                <th>Data:</th>
                <th>Godzina:</th>
                <th>Ilość slotów:</th>
                <th>Zwycięzca:</th>
            </tr>
        </thead>
        <tbody>";

    foreach($archive as $row){
    echo "    
                <tr>
                    <td>".$row['name']."</td>
                    <td>".$row['date']."</td>
                    <td>".$row['time']."</td>
                    <td>".$row['slots']."</td>
                    <td>".$row['winner']."</td>
                </tr>
        ";
    }

    echo    "     
        </tbody>
        </table>";

    $tournaments->closeCursor();
    $archive->closeCursor();
    $db_connect = null;

?>