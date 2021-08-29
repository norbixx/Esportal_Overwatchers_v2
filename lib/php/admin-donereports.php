<?php

$db_connect = startConnection();
                
$reports = $db_connect->query("SELECT id, repuser, report, repadmin, replink, description FROM replays WHERE (ban=1 OR ban=2) AND done=0");

echo "
    <table cellspacing='0' cellpadding='0' class='admin-archive'>
    <thead>
        <tr>
            <th colspan='7'><i class='fas fa-flag'></i> Zakończone zgłoszenia do archiwizacji</th>
        </tr>
        <tr>
            <th>Zgłoszenie nr.:</th>
            <th>Zgłaszany użytkownik:</th>
            <th>Powód zgłoszenia:</th>
            <th>Przyjęte przez:</th>
            <th>Status:</th>
            <th>Dodatkowe uwagi:</th>
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
				<td>
					<a href='../profile/".$row['repadmin']."'>
						".getPermissionImage(getLogin($row['repadmin'], $db_connect), $db_connect)."".$row['repadmin']."
					</a>
				</td>
				<td>".getReportBanStatus($row['id'], $db_connect)."</td>
				<td>".$row['description']."</td>
				<td>
					<a href='".$row['replink']."'><button class='buttonDefault blueB'><i class='fas fa-link'></i> Esportal link</button></a>
					<a href='lib/php/admin-archive.php?id=".$row['id']."'><button class='buttonDefault redB'><i class='fas fa-archive'></i> Zakończ zgłoszenie</button></a>
				</td>
			</tr>
		";
	}
}
else
{
	echo "
	<tr>
		<td colspan='7'><br />Brak zgłoszeń do zamknięcia.<br /><br /></td>
	</tr>
	";
}


	echo "
		</tbody>
		</table>";

if($reports->rowCount() > 1)
{
	echo "
		<form action='lib/php/admin-done-all.php' onsubmit='return checkConfirm();'>
		<table>
		<thead>
		</thead>
		<tbody>
			<tr>
				<td>
				<button type='submit' class='buttonDefault redB'><i class='fas fa-archive'></i> Zamknij wszystkie zgłoszenia</button>
				</td>
			</tr>
		</tbody>
		</table>
		</form>

		";
}
else
{
	//
}


$reports->closeCursor();
$db_connect = null;
    
?>