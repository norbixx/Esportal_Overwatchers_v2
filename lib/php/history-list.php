<?php
    $db_connect = startConnection();
            
    $history = $db_connect->query("SELECT id, repuser, report, repadmin, ban, repdate, archivedate FROM replays WHERE done=1 ORDER BY archivedate DESC LIMIT ".($page-1)*$limit.",".$limit."");

    echo "
	<table cellspacing='0' cellpadding='0' class='history-list'>
        <thead>
            <tr>
                <th colspan='7'><i class='fas fa-history'></i> Zakończone zgłoszenia</th>
            </tr>
            <tr>
                <th>Zgłoszenie:</th>
                <th>Zgłaszany użytkownik:</th>
                <th>Powód zgłoszenia:</th>
                <th>Status zgłoszenia:</th>
                <th>Zajmujący się zgłoszeniem:</th>
                <th>Data rozpoczęcia:</th>
                <th>Data zakończenia:</th>
            </tr>
        </thead>
        <tbody>";

    foreach($history as $row){
        echo "
            <tr>
                <td><a class='account-href' href='report/".$row['id']."/view'>#".$row['id']."</a></td>
                <td>".$row['repuser']."</td>
                <td>".$row['report']."</td>
                <td>".getReportBanStatus($row['id'], $db_connect)."</td>
                <td><a class='account-href' href='profile/".$row['repadmin']."'>".getPermissionImage(getLogin($row['repadmin'], $db_connect), $db_connect)."".$row['repadmin']."</a></td>
                <td>".$row['repdate']."</td>
                <td>".$row['archivedate']."</td>
            </tr>
            ";
    }

    echo    "                     
        </tbody>
    </table>";

    $history->closeCursor();
    $db_connect = null;
?>