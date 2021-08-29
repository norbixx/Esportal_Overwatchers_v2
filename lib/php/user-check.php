<?php

echo "
	<form action='checkuser' method='POST'>
	<table cellpadding='0' cellspacing='0'>
	<thead>
		<tr>
			<th><i class='fas fa-clipboard-list'></i> Wyszukiwanie kartoteki użytkownika</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
			<br />
			<input type='text' name='nickname' placeholder='Podaj nazwę użytkownika' class='inputDefaultReport'><br />
			<p>Pamiętaj aby podać dokładną nazwę użytkownika uwzględniając przy tym wielkość liter.</p>
			<button type='submit' class='buttonDefault greenB'><i class='fas fa-search'></i> Wyszukaj użytkownika</button><br /><br />
			</td>
		</tr>
	</tbody>
	</table>
	</form>
";

if(!empty($_POST['nickname'])){
	$nickname = $_POST["nickname"];

	$searchUser = json_decode(file_get_contents("https://pl-api.esportal.se/admin/user/search?_=1562596234052&query=".$nickname."&_u=289650248&_t=%26%22)Lq%3DVj(ED%5D%2FR%2FLhdotW-%23%3DP%5C_%5EX%27%40r%22lZjJm%26c", true), true);


	if($searchUser != null)
	{
		foreach($searchUser as $key => $value)
		{
			$userID = $value["id"];
			break;
		}

		$searchBans = json_decode(file_get_contents("https://pl-api.esportal.se/admin/user/get?_=1562598153206&id=".$userID."&_u=289650248&_t=%26%22)Lq%3DVj(ED%5D%2FR%2FLhdotW-%23%3DP%5C_%5EX%27%40r%22lZjJm%26c", true), true);

		$i = 0;

		$encodeBans = json_encode($searchBans["user_bans"], true);

		$bans = json_decode($encodeBans, true);

		if($bans != null)
		{
			echo "
				<table cellpadding='0' cellspacing='0' class='reports-list'>
				<thead>
					<tr>
						<th colspan='4'><i class='fas fa-clipboard'></i> ".$nickname."</th>
					</tr>
					<tr>
						<th>Powód</th>
						<th>Nadany</th>
						<th>Wygasa</th>";

			if($permission == 100 || $permission == 50)
				echo "<th>Zbanowany przez</th>";

			echo "
					</tr>
				</thead>
				<tbody>";

			foreach($bans as $key => $value)
			{
				echo "
					<tr>
						<td>".$value["reason"]."</td>
						<td>".date("Y-m-d", $value["inserted"])."</td>
						<td>".date("Y-m-d", $value["expires"])."</td>";

				if($permission == 100 || $permission == 50)
					echo "<td>".$value["banned_by_username"]."</td>";
			}

			echo "
						</tbody>
				</table>
			";
		}
		else
		{
			echo "
			<table cellpadding='0' cellspacing='0' class='reports-list'>
			<thead>
				<tr>
					<th><i class='fas fa-clipboard'></i> ".$nickname."</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Użytkownik nie był jeszcze nigdy banowany.</td>
				</tr>
			</tbody>
			</table>";
		}
	}
	else
	{
		echo "
			<table cellpadding='0' cellspacing='0' class='reports-list'>
			<thead>
				<tr>
					<th><i class='fas fa-clipboard'></i> ".$nickname."</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Brak użytkownika w bazie danych.</td>
				</tr>
			</tbody>
			</table>";
	}
}

?>