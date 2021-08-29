<?php


$db_connect = startConnection();

$users = $db_connect->query("SELECT id, login, email, permission, lastlogin, active, realname, discord_id, esportal, steam FROM users WHERE realname not like 'testerek' ORDER BY active DESC, permission DESC, activitytime DESC, realname ASC, id ASC");

echo "
    <table cellspacing='0' cellpadding='0' class='users-list'>
    <thead>
        <tr>
            <th>Użytkownik:</th>
            <th>E-mail kontaktowy:</th>
            <th>Status konta:</th>
            <th>Ostatnie logowanie:</th>
            <th>Discord ID:</th>
            <th>Odnośniki:</th>
        </tr>
    </thead>
    <tbody>";

foreach($users as $row){
    
    echo "
        <tr>
            <td>".getPermissionImage($row['login'], $db_connect)."<a href='profile/".$row['realname']."' class='account-href'>".$row['realname']." ".checkActive($row['login'], $db_connect)."</a></td>
            <td>".$row['email']."</td>
            <td>".getUserStatus($row['login'], $db_connect)."</td>
            <td>".$row['lastlogin']."</td>
            <td>#".$row['discord_id']."</td>
            <td>
                <a href='profile/".$row['realname']."'><button class='buttonDefault blueB'><i class='fas fa-user'></i>  Profil użytkownika</button></a>
                <a href='".$row['esportal']."'><button class='buttonDefault blueB'><i class='fas fa-gamepad'></i> Esportal</button></a>
                <a href='".$row['steam']."'><button class='buttonDefault blueB'><i class='fab fa-steam-symbol'></i>  Steam</button></a>
            </td>
        </tr>";
    
}

echo "
    </tbody>
    </table>
";

$users->closeCursor();
$db_connect = null;

?>