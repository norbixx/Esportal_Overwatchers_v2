<?php
    if(!empty($_GET['name'])){
        $db_connect = startConnection();

        $userData = $db_connect->query("SELECT id, login, email, lastlogin, active, realname, discord_id, esportal, steam FROM users WHERE realname='".$_GET['name']."'");


        foreach($userData as $row){

            $reportsBanned = intval(getUserReportsBanned($row['realname'], $db_connect));
            $reportsUnbanned = intval(getUserReportsUnbanned($row['realname'], $db_connect));

            $reportsAll = ($reportsBanned + $reportsUnbanned);

            if($reportsBanned != 0 && $reportsUnbanned != 0 && $reportsAll != 0){
                $reportsBannedPercent = round((($reportsBanned/$reportsAll)*100), 2);
                $reportsUnbannedPercent = round((($reportsUnbanned/$reportsAll)*100), 2);
            }else{
                if($reportsBanned == 0){
                    $reportsBannedPercent = (($reportsBanned)*100);
                    $reportsUnbannedPercent = round((($reportsUnbanned/$reportsAll)*100), 2);
                }
                if($reportsUnbanned == 0){
                    $reportsBannedPercent = round((($reportsBanned/$reportsAll)*100), 2);
                    $reportsUnbannedPercent = (($reportsUnbanned)*100);
                }
            }

            $userPermissionImage = getPermissionImage($row['login'], $db_connect);
            $userPermission = getPermissionText($row['login'], $db_connect);
            $userLogin = $row['login'];
            $userEmail = $row['email'];
            $userId = $row['id'];
            $userName = $row['realname'];

            echo "

                <table cellspacing='0' cellpadding='0' class='profile'>
                <thead>
                    <tr>
                        <th><i class='fas fa-user'></i> Profil użytkownika ".$row['realname']."</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src='lib/img/default.png' alt='avatar' class='avatar' /><br />
                            <a href='".$row['steam']."'><button class='buttonDefault blueB'><i class='fab fa-steam-symbol'></i> Steam</button></a>
                            <a href='".$row['esportal']."'><button class='buttonDefault blueB'><i class='fas fa-gamepad'></i> Esportal</button></a>
                        </td>
                    </tr>
                    <tr>
                        <td>(#".$row['id'].") ".$row['realname']." ".checkActive($row['login'], $db_connect)."</td>
                    </tr>
                    <tr>
                        <td>".$userPermissionImage."".$userPermission."</td>
                    </tr>
                    <tr>
                        <td><i class='fab fa-discord'></i> Discord (#".$row['discord_id'].")</td>
                    </tr>
                    <tr>
                        <td>Status konta: ".getUserStatus($row['login'], $db_connect)."</td>
                    </tr>
                    <tr>
                        <td>Ostatnio zalogowany: ".$row['lastlogin']."</td>
                    </tr>
                    <tr>
                        <td>Ilość zakończonych zgłoszeń: ".$reportsAll."</td>
                    </tr>
                    <tr>
                        <td>";

                    if($reportsBanned > 0 && $reportsUnbanned > 0){
                        echo "
                        <div class='reportBar'>
                            <div class='bannedBar' style='width: ".$reportsBannedPercent."%;'>".$reportsBannedPercent." % (zaakceptowane)</div>
                            <div class='unbannedBar' style='width: ".$reportsUnbannedPercent."%;'>(odrzucone) ".$reportsUnbannedPercent." %</div>
                        </div>";
                    }
                    if($reportsBanned > 0 && $reportsUnbanned == 0){
                        echo "
                        <div class='reportBar'>
                            <div class='bannedBar' style='width: ".$reportsBannedPercent."%;'>".$reportsBannedPercent." % (zaakceptowane)</div>
                        </div>";
                    }
                    if($reportsBanned == 0 && $reportsUnbanned > 0){
                        echo "
                        <div class='reportBar'>
                            <div class='unbannedBarSolo' style='width: ".$reportsUnbannedPercent."%;'>(odrzucone) ".$reportsUnbannedPercent." %</div>
                        </div>";
                    }
                    if($reportsBanned == 0 && $reportsUnbanned == 0){
                        echo "
                        <div class='reportBarNull'>
                            <div>Brak danych</div>
                        </div>";
                    }

                    echo "
                        </td>
                    </tr>
                </tbody>
                </table>

                ";

        }

        $userReportData = $db_connect->query("SELECT id, repuser, report, repadmin, ban, repdate, archivedate FROM replays WHERE repadmin='".getRealname($row['login'], $db_connect)."' AND archivedate IS NOT NULL ORDER BY archivedate DESC LIMIT 5");

        echo "
        <table cellspacing='0' cellpadding='0' class='history-user-list'>
        <thead>
            <tr>
                <th colspan='6'><i class='fas fa-flag'></i> Ostatnie zgłoszenia użytkownika ".$userName."</th>
            </tr>
            <tr>
                <th>Zgłoszenie: </th>
                <th>Zgłaszany użytkownik: </th>
                <th>Powód zgłoszenia: </th>
                <th>Status zgłoszenia: </th>
                <th>Data przyjęcia zgłoszenia: </th>
                <th>Data zakończenia zgłoszenia: </th>
            </tr>
        </thead>
        <tbody>";

        foreach($userReportData as $user){

            echo "
                <tr>  
                    <td>#".$user['id']."</td>
                    <td>".$user['repuser']."</td>
                    <td>".$user['report']."</td>
                    <td>".getReportBanStatus($user['id'], $db_connect)."</td>
                    <td>".$user['repdate']."</td>
                    <td>".$user['archivedate']."</td>
                </tr>
                ";

        }

        echo "
                </tr>
        </tbody>
        </table>";


        if($permission == 100){
            echo "
                <table cellspacing='0' cellpadding='0' class='profile'>
                <thead>
                    <tr>
                        <th><i class='fas fa-tools'></i> Czynności administracyjne</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Login użytkownika: ".$userLogin."</td>
                    </tr>
                    <tr>
                        <td>E-mail kontaktowy: ".$userEmail."</td>
                    </tr>
                    <tr>
                        <td>
                            <a href='lib/php/activate-account.php?id=".$userId."'><button class='buttonDefault greenB'><i class='fas fa-check-square'></i> Aktywuj konto</button></a>
                            <a href='lib/php/deactivate-account.php?id=".$userId."'><button class='buttonDefault redB'><i class='fas fa-window-close'></i> Dezaktywuj konto</button></a>
                            <a href='lib/php/reset-account.php?id=".$userId."'><button class='buttonDefault blueB'><i class='fas fa-key'></i> Resetuj hasło</button></a>
                        </td>
                    </tr>
                </tbody>
                </table>
                <form method='POST' action='lib/php/permission-account.php?id=".$userId."'>
                    <table cellspacing='0' cellpadding='0' class='profile'>
                    <tbody>
                        <tr>
                            <td>
                                <select name='newPermission' class='selectDefault' required>
                                    <option value='0'>Overwatcher</option>
                                    <option value='50'>Moderator turnieju</option>
                                    <option value='100'>Administrator</option>
                                </select><br />
                                <button type='submit' class='buttonDefault blueB'><i class='fas fa-user-edit'></i> Zmień uprawnienia</button>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </form>
                ";
        }

        $userData->closeCursor();
        $userReportData->closeCursor();
        $db_connect = null;
    }
?>