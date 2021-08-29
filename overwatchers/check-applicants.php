<?php

if(isset($_GET['token'])){
	
	if($_GET['token'] == '8c4fe199529e08fc6c6927698c2f7626'){

		echo "<meta charset='utf-8'>";
		echo "<link rel='stylesheet' type='text/css' href='css/style.css'>";

		require_once("lib/Database.php");

		$db = new Database();

		$query 	= "SELECT * FROM applicants WHERE apply_accept IS NULL OR apply_accept = 1";
		$result = $db->getRows($query, []);

		foreach($result as $key=>$row){

			echo "
			<div class='apply-box'>
				<h3>Nr. zgłoszenia: ".$row['apply_id']."</h3>
				<p><b>Imię:</b> ".$row['apply_name']."</p>
				<p><b>Wiek:</b> ".$row['apply_age']."</p>
				<p><b>Staż w CS:GO:</b> ".$row['apply_hours']."</p>
				<p><b>Krótki opis:</b> ".$row['apply_about']."</p>
				<a target='_blank' rel='noopener noreferrer' href='https://beta.esportal.pl/profile/".$row['apply_esportal']."'><button class='buttonEsportal'>ESPORTAL</button></a>
			</div>
			";

		}
	}else{
		
		echo "Invalid token, access denied!";
		
	}
}else{
	
	echo "Invalid token, acces denied!";
	
}
//			<a href='applicants?id=".$row['apply_id']."&action=accept'>✔</a>
//			<a href='applicants?id=".$row['apply_id']."&action=deny'>✖</a>

?>