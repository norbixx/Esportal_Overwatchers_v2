<?php
    $db_connect = startConnection();

    $getReport = $db_connect->query("SELECT id, link, repuser, report, repadmin, ban, admindesc, repdate, match_id, reporter FROM replays WHERE id=".$_GET['id']."");

    foreach($getReport as $row){

        $reportedUser = $row['repuser'];

        try{
            $file = file_get_contents("https://pl-api.esportal.se/user_profile/get?_=1556545362491&username=".$reportedUser."");
        }catch(Exception $e){
            // Handle exception
        }
        
        $user_info = json_decode($file, true);
        
        echo "
            <table cellspacing='0' cellpadding='0' class='report-list'>
            <thead>
                <tr>
                    <th colspan='2'><i class='fas fa-flag'></i> Zgłoszenie #".$row['id']."</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pobieranie demka: </td>
                    <td><a href='".$row['link']."'><button class='buttonDefault blueB'><i class='fas fa-download'></i> Pobierz</button></a></td>
                </tr>
                <tr>
                    <td>Logi czatu:</td>
                    <td><a target='_blank' href='https://s3.eu-central-1.wasabisys.com/demo-production/".$row['match_id'].".txt'><button class='buttonDefault blueB'><i class='fas fa-comment-dots'></i> Przejdź</button></a></td>
                </tr>
                <tr>
                    <td>Link do meczu:</td>
                    <td><a href='https://beta.esportal.pl/match/".$row['match_id']."' class='account-href'>Mecz #".$row['match_id']."</a></td>
                </tr>
                <tr>
                    <td>Zgłoszony przez: </td>
                    <td><a href='https://beta.esportal.pl/profile/".$row['reporter']."' class='account-href reporter'>".$row['reporter']."</a></td>
                </tr>
                <tr>
                    <td>Zgłaszany użytkownik: </td>
                    <td><a href='https://beta.esportal.pl/profile/".$row['repuser']."' class='account-href'>".$row['repuser']."</a></td>
                </tr>
                <tr>
                    <td>Oceny zgłaszanego:</td>
                    <td>
                        <i class='fas fa-thumbs-up'></i>".$user_info['thumbs_up']."
                        <i class='fas fa-thumbs-down'></i>".$user_info['thumbs_down']."
                    </td>
                </tr>
                <tr>
                    <td>Powód zgłoszenia: </td>
                    <td>".$row['report']."</td>
                </tr>
                <tr>
                    <td>Opis zgłoszenia: </td>
                    <td>".$row['admindesc']."</td>
                </tr>
                <tr>
                    <td>Zajmujący się zgłoszeniem: </td>
                    <td><a class='account-href' href='profile/".$row['repadmin']."'>".getPermissionImage(getLogin($row['repadmin'], $db_connect), $db_connect)."".$row['repadmin']." ".checkActive(getLogin($row['repadmin'], $db_connect), $db_connect)."</a></td>
                </tr>
                <tr>
                    <td>Status zgłoszenia: </td>
                    <td>".getReportBanStatus($row['id'], $db_connect)."</td>
                </tr>
                <tr>
                    <td>Data przyjęcia zgłoszenia: </td>
                    <td>".$row['repdate']."</td>
                </tr>
                <tr>
                    <td colspan='3'>";
        
            if($row['ban'] == 1 || $row['ban'] == 2 || $row['ban'] == 999){
                echo "
                            <a href='panel'><button class='buttonDefault blueB'><i class='fas fa-undo-alt'></i> Wróć do panelu</button></a>
                    ";
                if(getPermission($login, $db_connect) == 100){
                    echo "<a href='lib/php/delete-report.php?id=".$row['id']."'><button class='buttonDefault redB'><i class='fas fa-trash-alt'></i> Usuń zgłoszenie</button></a>";
                }else{
                    //...
                }
                
            }else if($row['ban'] == 100 && $row['repadmin'] == $name){
                echo "
                    <a href='report/".$row['id']."'><button class='buttonDefault greenB'><i class='fas fa-check-square'></i> Przejdź do zgłoszenia</button></a>
                    <a href='panel'><button class='buttonDefault blueB'><i class='fas fa-undo-alt'></i> Wróć do panelu</button></a>
                    ";
                if(getPermission($login, $db_connect) == 100){
                    echo "<a href='lib/php/delete-report.php?id=".$row['id']."'><button class='buttonDefault redB'><i class='fas fa-trash-alt'></i> Usuń zgłoszenie</button></a>";
                }else{
                    //...
                }
                
            }else if($row['ban'] == 0){
                echo "
                    <a href='report/".$row['id']."'><button class='buttonDefault greenB'><i class='fas fa-check-square'></i> Przyjmij zgłoszenie</button></a>
                    <a href='panel'><button class='buttonDefault blueB'><i class='fas fa-undo-alt'></i> Wróć do panelu</button></a>
                    ";
                if(getPermission($login, $db_connect) == 100){
                    echo "<a href='lib/php/delete-report.php?id=".$row['id']."'><button class='buttonDefault redB'><i class='fas fa-trash-alt'></i> Usuń zgłoszenie</button></a>";
                }else{
                    //...
                }
            }else{
                echo "
                <a href='panel'><button class='buttonDefault blueB'><i class='fas fa-undo-alt'></i> Wróć do panelu</button></a>";
                if(getPermission($login, $db_connect) == 100){
                    echo "<a href='lib/php/delete-report.php?id=".$row['id']."'><button class='buttonDefault redB'><i class='fas fa-trash-alt'></i> Usuń zgłoszenie</button></a>";
                }else{
                    //...
                }
            }
        
            echo "
                    </td>
                </tr>
            </tbody>
            </table>
            ";
    }

    $getUserHistory = $db_connect->query("SELECT id, repuser, report, repadmin, ban, archivedate FROM replays WHERE repuser='".$reportedUser."' AND archivedate IS NOT NULL");

    echo "
            <table cellspacing='0' cellpadding='0' class='history-list'>
                <thead>
                    <tr>
                        <th colspan='5'><i class='fas fa-clipboard-list'></i> Kartoteka użytkownika ".$reportedUser."</th>
                    </tr>
        ";


    if($getUserHistory->rowCount() > 0){
        echo "
            <tr>
                <th>Zgłaszany użytkownik: </th>
                <th>Powód zgłoszenia: </th>
                <th>Zajmujący się zgłoszeniem: </th>
                <th>Status zgłoszenia: </th>
                <th>Data zakończenia zgłoszenia: </th>
            </tr>
            </thead>
            <tbody>
            ";

        foreach($getUserHistory as $row){

            echo "
            <tr>
                <td>".$row['repuser']."</td>
                <td>".$row['report']."</td>
                <td><a class='account-href' href='profile/".$row['repadmin']."'>".getPermissionImage($row['repadmin'], $db_connect)."".$row['repadmin']." ".checkActive($row['repadmin'], $db_connect)."</a></td>
                <td>".getReportBanStatus($row['id'], $db_connect)."</td>
                <td>".$row['archivedate']."</td>
            </tr>
            ";

        }
    }else{

        echo "
            </thead>
            <tbody>
                <tr>
                    <td colspan='5'>Brak danych</td>
                </tr>
            ";

    }

    echo "
            </tbody>
            </table>
        ";

    $getReport->closeCursor();
    $getUserHistory->closeCursor();
    $db_connect = null;

?>