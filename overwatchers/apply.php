<?php

include_once("lib/apply-send.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<meta name="description" content="Esportal Overwatchers Formularz Aplikacyjny">
  	<meta name="keywords" content="Esportal, Polska, Overwatch, Overwatcher, Overwatchers, Aplikacja, Aplikuj">
  	<meta name="author" content="Norbix">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel='stylesheet' type='text/css' href='css/style.css'>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
	$(function () {
       $(".numeric").change(function() {
          var max = parseInt($(this).attr('max'));
          var min = parseInt($(this).attr('min'));
          if ($(this).val() > max)
          {
              $(this).val(max);
          }
          else if ($(this).val() < min)
          {
              $(this).val(min);
          }       
        }); 
    });
	</script>
	<title>Esportal Overwatchers - Aplikuj</title>
</head>
<body>
	
	<div id='bg-image'></div>
	
	<div id='con'>
		
		<div id='apply'>
			 
		<form action='apply.php' method='POST' id='apply-form'>
			<table cellspacing='0' cellpadding='0'>
				<thead>
				</thead>
				<tbody>
					<tr>
						<td id='leftTable'>
						</td>
						<td>
							<table id='secondTable'>
							<thead>
								<tr>
									<th><img src='img/esportal_effects.png' alt='esportal-logo' id='esportal' /></th>
								</tr>	
							</thead>
							<tbody>
								<tr>
									<td>
										<input type='text' name='apply_name' placeholder='Imię' class='defaultInput' required>
									</td>
								</tr>
								<tr>
									<td>
										<input type='number' name='apply_age' placeholder='Wiek' min='10' max='99' class='numeric defaultInput' required>
									</td>
								</tr>
								<tr>
									<td>
										<input type='text' name='apply_esportal' placeholder='Nick na platformie Esportal' class='defaultInput' required>
									</td>
								</tr>
								<tr>
									<td>
										<input type='number' name='apply_hours' placeholder='Staż w CS:GO (godziny)' min='100' max='20000' class='numeric defaultInput' required>
									</td>
								</tr>
								<tr>
									<td>
										<textarea name='apply_about' placeholder='Dlaczego chcesz do nas dołączyć(krótki opis - max 255 znaków)' class='textInput' required></textarea>
									</td>
								</tr>
								<tr>
									<td>
										<button type='submit' class='defaultButton'>Prześlij aplikację</button>
									</td>
								</tr>
								<?php
								
								if(!empty($_GET['send'])){
									if($_GET['send'] == 'true'){
										echo "
										<tr>
											<td class='success request'>Aplikacja została pomyślnie przesłana!</td>
										</tr>";
									}else if($_GET['send'] == 'false'){
										echo "
										<tr>
											<td class='error request'>Wystąpił błąd podczas przesyłania aplikacji!</td>
										</tr>";
									}else if($_GET['send'] == 'already'){
										echo "
										<tr>
											<td class='error request'>Aplikacja z tego konta została już wysłana!</td>
										</tr>";
									}
								}
								
								?>
							</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		
		</div>	
			
	</div>
	
</body>
</html>