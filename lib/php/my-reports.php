<?php
$db_connect = startConnection();
                
$reports = $db_connect->query("SELECT id, repuser, report, repadmin, admindesc, expiredate FROM replays WHERE (ban=100 AND done=0) AND (repadmin='".$name."' OR repadmin='".$login."')");
$reportsArchive = $db_connect->query("SELECT id, repuser, report, repadmin, ban, repdate, archivedate, archiveuser FROM replays WHERE done=1 AND (repadmin='".$name."' OR repadmin='".$login."') ORDER BY archivedate DESC LIMIT ".($page-1)*$limit.",".$limit."");

echo "
    <table cellspacing='0' cellpadding='0' class='reports-list'>
    <thead>
        <tr>
            <th colspan='6'><i class='fas fa-flag'></i> Twoje aktualne zgłoszenia</th>
        </tr>
        <tr>
            <th>Zgłoszenie nr.:</th>
            <th>Zgłaszany użytkownik:</th>
            <th>Powód zgłoszenia:</th>
            <th>Opis:</th>
            <th>Wygasa:</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
";

foreach($reports as $row){
    echo "
        <tr>
            <td>#".$row['id']."</td>
            <td>".$row['repuser']."</td>
            <td>".$row['report']."</td>
            <td>".$row['admindesc']."</td>
            <td>".$row['expiredate']."</td>
            <td>
                <a href='report/".$row['id']."'><button class='buttonDefault greenB'><i class='fas fa-caret-square-up'></i> Przejdź</button></a>
                <a href='lib/php/restore-report.php?id=".$row['id']."&user=".$row['repadmin']."'><button class='buttonDefault redB'><i class='fas fa-trash-restore-alt'></i> Wycofaj</button></a>
            </td>
        </tr>
    ";
}

echo "
    </tbody>
    </table>

    <table cellspacing='0' cellpadding='0' class='reports-list' id='reports-archive'>
        <thead>
            <tr>
                <th colspan='7'><i class='fas fa-archive'></i> Twoje archiwalne zgłoszenia</th>
            </tr>
            <tr>
                <th>Zgłoszenie: </th>
                <th>Zgłaszany użytkownik: </th>
                <th>Powód zgłoszenia: </th>
                <th>Status zgłoszenia: </th>
                <th>Data przyjęcia zgłoszenia: </th>
                <th>Data zakończenia zgłoszenia: </th>
                <th>Zaarchiwizowany przez: </th>
            </tr>
        </thead>
    <tbody>
";

foreach($reportsArchive as $archive){
    echo "
        <tr>
            <td>#".$archive['id']."</td>
            <td>".$archive['repuser']."</td>
            <td>".$archive['report']."</td>
            <td>".getReportBanStatus($archive['id'], $db_connect)."</td>
            <td>".$archive['repdate']."</td>
            <td>".$archive['archivedate']."</td>
            <td>".$archive['archiveuser']."</td>
        </tr>
    ";
}

echo "
    </tbody>
    </table>
";

$reports->closeCursor();
$reportsArchive->closeCursor();
$db_connect = null;
?>