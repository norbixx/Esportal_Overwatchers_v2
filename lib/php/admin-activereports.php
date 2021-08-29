<?php

$db_connect = startConnection();
                
$reports = $db_connect->query("SELECT id, repuser, report, repadmin, repdate, expiredate FROM replays WHERE (ban=100 AND done=0)");

echo "
    <table cellspacing='0' cellpadding='0' class='reports-list'>
    <thead>
        <tr>
            <th colspan='7'><i class='fas fa-flag'></i> Zgłoszenia w trakcie sprawdzania</th>
        </tr>
        <tr>
            <th>Zgłoszenie nr.:</th>
            <th>Zgłaszany użytkownik:</th>
            <th>Powód zgłoszenia:</th>
            <th>Przyjęte przez:</th>
            <th>Przyjęte:</th>
            <th>Wygasa:</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
";

if($reports->rowCount() > 0)
{
	foreach($reports as $row)
	{
		echo "
			<tr>
				<td>#".$row['id']."</td>
				<td>".$row['repuser']."</td>
				<td>".$row['report']."</td>
				<td>".getPermissionImage(getLogin($row['repadmin'], $db_connect), $db_connect)."".$row['repadmin']."</td>
				<td>".$row['repdate']."</td>
				<td>".$row['expiredate']."</td>
				<td>
					<a href='report/".$row['id']."/view'><button class='buttonDefault blueB'><i class='fas fa-search'></i> Przejdź</button></a>
					<a href='lib/php/admin-restore.php?id=".$row['id']."'><button class='buttonDefault redB'><i class='fas fa-trash-restore-alt'></i> Wycofaj</button></a>
				</td>
			</tr>
		";
	}
}
else
{
	echo "
	<tr>
		<td colspan='7'><br />Brak aktywnych zgłoszeń.<br /><br /></td>
	</tr>
	";
}

echo "
    </tbody>
    </table>";


$reports->closeCursor();
$db_connect = null;
    
?>