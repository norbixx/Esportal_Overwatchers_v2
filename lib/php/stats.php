<?php

    $db_connect = startConnection();

    $top = array
    (
        "MAY" => array
        (
            "top1_user" => "Pyrkens",
            "top1_score" => 176,
            "top2_user" => "JeffVanB",
            "top2_score" => 173,
            "top3_user" => "Ania",
            "top3_score" => 93,
            "top4_user" => "r0xx",
            "top4_score" => 84,
            "top5_user" => "ojania",
            "top5_score" => 44,
        ),
		"JUNE" => array
        (
            "top1_user" => "r0xx",
            "top1_score" => 108,
            "top2_user" => "JeffVanB",
            "top2_score" => 92,
            "top3_user" => "Pyrkens",
            "top3_score" => 51,
            "top4_user" => "ojania",
            "top4_score" => 24,
            "top5_user" => "PRZ3M01",
            "top5_score" => 14,
        ),
    );

    //MONTH-TIME
    $time = date("Y-m", time() + 94);

    //MONTH STATS
    $statsMonth = $db_connect->query("SELECT repadmin AS user, count(CASE WHEN users.realname = replays.repadmin AND replays.archivedate LIKE '".$time."%' THEN 1 ELSE null END) AS reports FROM replays, users WHERE (replays.ban = 1 OR replays.ban = 2 AND done = 1) AND (users.permission = 0 OR users.permission = 50) GROUP BY repadmin ORDER BY reports DESC, user ASC");
    
    //GLOBAL STATS
    $statsGlobal = $db_connect->query("SELECT repadmin AS user, count(CASE WHEN users.realname = replays.repadmin THEN 1 ELSE null END) AS reports FROM replays, users WHERE (replays.ban = 1 OR replays.ban = 2 AND done = 1) AND (users.permission = 0 OR users.permission = 50) GROUP BY repadmin ORDER BY reports DESC, user ASC");

    echo "
        <table cellspacing='0' cellpadding='0'>
        <thead>
            <tr>
                <th colspan='3'><i class='fas fa-trophy'></i> Wyróżnieni w tym miesiącu <i class='fas fa-trophy'></i></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan='2'>
                <img src='lib/img/top1.png' alt='top1' class='top-image' />
                <span class='top-text'> ".$top['JUNE']['top1_user']." - ".$top['JUNE']['top1_score']."</span>
                </td>
            </tr>
            <tr>
                <td>
                <img src='lib/img/top2.png' alt='top2' class='top-image' />
                <span class='top-text'> ".$top['JUNE']['top2_user']." - ".$top['JUNE']['top2_score']."</span>
                </td>
            </tr>
            <tr>
                <td>
                <img src='lib/img/top3.png' alt='top3' class='top-image' />
                <span class='top-text'> ".$top['JUNE']['top3_user']." - ".$top['JUNE']['top3_score']."</span>
                </td>
            </tr>
            <tr>
                <td>
				<img src='lib/img/top4.png' alt='top4' class='top-image' />
                <span class='top-text'> ".$top['JUNE']['top4_user']." - ".$top['JUNE']['top4_score']."</span>
                </td>
            </tr>
            <tr>
                <td>
				<img src='lib/img/top5.png' alt='top5' class='top-image' />
                <span class='top-text'> ".$top['JUNE']['top5_user']." - ".$top['JUNE']['top5_score']."</span>
                </td>
            </tr>
        </tbody>
        </table>
    ";


    echo "
        <table cellspacing='0' cellpadding='0' class='top-stats'>
        <thead>
            <tr>
                <th colspan='4'><i class='fas fa-table'></i> Statystyki zgłoszeń <i class='fas fa-table'></i></th>
            </tr>
            <tr>
                <th colspan='2'>Statystyki na miesiąc ".strtolower(makeDate(time())).":</th>
                <th colspan='2'>Statystyki globalne:</th>
            </tr>
            <tr>
                <th>Użytkownik:</th>
                <th>Ilość zgłoszeń:</th>
                <th>Użytkownik:</th>
                <th>Ilość zgłoszeń:</th>
            </tr>
        </thead>
        <tbody>
    ";

    $i = 0;
    $j = 0;

    if($statsMonth->rowCount() > 0 && $statsGlobal->rowCount() > 0)
    {
        
        foreach($statsMonth as $row)
        {
            
            $statsMonthUser[$i] = $row['user'];
            $statsMonthReports[$i] = $row['reports'];
            
            $i++;
        }
        
        foreach($statsGlobal as $row)
        {
            
            $statsGlobalUser[$j] = $row['user'];
            $statsGlobalReports[$j] = $row['reports'];
            
            $j++;
        }
            
    }
    else
    {
        
    }
    
    for($k = 0; $k < sizeof($statsMonthUser); $k++)
    {
        echo "
            <tr>
                <td>
                    ".getPermissionImage(getLogin($statsMonthUser[$k], $db_connect), $db_connect)."<a href='profile/".$statsMonthUser[$k]."' class='account-href'>".$statsMonthUser[$k]."</a>
                </td>
                <td>
                    ".$statsMonthReports[$k]."
                </td>
                <td>
                    ".getPermissionImage(getLogin($statsGlobalUser[$k], $db_connect), $db_connect)."<a href='profile/".$statsGlobalUser[$k]."' class='account-href'>".$statsGlobalUser[$k]."</a>
                </td>
                <td>    
                    ".$statsGlobalReports[$k]."
                </td>
            </tr>
        ";
    }


    echo "
    </tbody>
    </table>
    ";
    
    $statsMonth->closeCursor();
    $statsGlobal->closeCursor();
    $db_connect = null;

?>