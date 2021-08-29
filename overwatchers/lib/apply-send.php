<?php

	require_once("Database.php");

	$db = new Database();
	
	if(!empty($_POST['apply_name']) && !empty($_POST['apply_age']) && !empty($_POST['apply_esportal']) && !empty($_POST['apply_hours']) && !empty($_POST['apply_about'])){
		
		$apply_name 	= addslashes($_POST['apply_name']);
		$apply_age 		= $_POST['apply_age'];
		$apply_esportal = addslashes($_POST['apply_esportal']);
		$apply_hours 	= $_POST['apply_hours'];
		$apply_about 	= addslashes($_POST['apply_about']);
		
		$query 	= "SELECT count(*) AS counter FROM applicants WHERE apply_esportal = ?";
		$result = $db->getRow($query, ["$apply_esportal"]);
		
		if($result['counter'] > 0){
			header("Location: apply?send=already");
		}else{
			
			if($db->insertRow("INSERT INTO applicants(apply_name, apply_age, apply_esportal, apply_hours, apply_about) VALUE(?, ?, ?, ?, ?)", ["$apply_name", "$apply_age", "$apply_esportal", "$apply_hours", "$apply_about"])){
			
			header("Location: apply?send=true");
			
			}else{

				header("Location: apply?send=false");

			}
			
		}
		
	}else{
		
	}

?>