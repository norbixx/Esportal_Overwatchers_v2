<?php 

    require_once("connect.php");
    
    ini_set("memory_limit", "256M");
    
    /*
    $db_connect = startConnection();

    $tmp = $db_connect->query("select * from users");

    foreach($tmp as $row)
        echo $row['login']."<br/>";

    $tmp->closeCursor();
    closeConnection($db_connect);

    $steamid = "STEAM_0:0:144825124";
    $split = explode(":", $steamid); //
    $x = substr($split[0], 6, 1);
    $y = $split[1];
    $z = $split[2];
    $id = ($z * 2) + 0x0110000100000000 + $y;

    echo "<a href='http://steamcommunity.com/profiles/$id'>Profil STEAM</a>";
    */

    /*$username = "Quali";

    try{

        $file = file_get_contents("https://pl-api.esportal.se/user_profile/get?_=1556545362491&username=".$username."");

    }catch(Exception $e){
        // Handle exception
    }

        $user_info = json_decode($file, true);


        echo $user_info['username']."<br/>".$user_info['thumbs_up']."<br/>".$user_info['thumbs_down']."<br/>";

        print_r($user_info);
    */

    $db_connect = startConnection();

    echo
        "
        <form action='test.php' method='POST'>
            <input type='number' name='amount' placeholder='Wybierz ilość' min='1' max='20'>
            <select name='category'>
                <option value='0'>Złe zachowanie / Griefing</option>
                <option value='3'>Nadużycie czatu tekstowego</option>
                <option value='4'>Nadużycie czatu głosowego</option>
            </select>
            <button type='submit'>Dodaj zgłoszenia</button>
        </form>
        ";
    

    $file = file_get_contents("https://pl-api.esportal.se/admin/report/list?_=1556548044835&_u=289650248&_t=%26%22)Lq%3DVj(ED%5D%2FR%2FLhdotW-%23%3DP%5C_%5EX%27%40r%22lZjJm%26c");

    $report = json_decode($file, true);
    
    $i = 0;
        
    if(isset($_POST['category']) && !empty($_POST['amount']))
    {
        $category_post = $_POST['category'];
        $amount = $_POST['amount'];
    }
    else
    {
        $category_post = 0;
        $amount = 0;
    }

    echo $amount;
        
        foreach($report as $key => $value)
        {

            $match = json_encode($value["match_id"], true);

            if($match > 800000)
            {

                $reported = json_encode($value["reported"], true);

                $reportedUser = json_decode($reported, true);

                foreach($reportedUser as $secondKey => $secondValue)
                {

                    $username[$i] = $reportedUser["username"];
                    $country_id = $reportedUser["country_id"];

                    if($country_id == 173)
                    {

                        $accepted = json_encode($value["accepted"], true);
                        $category = json_encode($value["category"], true);

                        if($category == $category_post)
                        {
                            if($i < $amount)
                            {
                                $report_id[$i] = json_encode($value["id"], true);
                                $match_id[$i] = json_encode($value["match_id"], true);
                                $accepted[$i] = json_encode($value["accepted"], true);
                                $category[$i] = json_encode($value["category"], true);
                                
                                if($category[$i] == 0)
                                    $rString = "Złe zachowanie / Griefing";
                                if($category[$i] == 3)
                                    $rString = "Nadużycie czatu tekstowego";
                                if($category[$i] == 4)
                                    $rString = "Nadużycie czatu głosowego";

                                echo $report_id[$i]." | ".$username[$i]." | "."#".$match_id[$i]." | ".$accepted[$i]." | ".$category[$i]." | "."https://s3.eu-central-1.wasabisys.com/demo-production/".$match_id[$i].".dem"."<br/>";
                                
                                $link = addslashes("https://s3.eu-central-1.wasabisys.com/demo-production/".$match_id[$i].".dem");
                                $repuser = addslashes($username[$i]);
                                $report = addslashes($rString);
                                $replink = addslashes("https://beta.esportal.pl/admin/report/".$report_id[$i]);
                                $expireTime = date("Y-m-d H:i:s", (time() + (61*24*60*60) + 94));
                                
                                $insertScore = $db_connect->query("INSERT INTO replays(link, repuser, report, admindesc, replink, expiredate, match_id) VALUES ('".$link."', '".$repuser."', '".$report."', null, '".$replink."', '".$expireTime."', ".$match_id[$i].")");
                                
                                $i++;
                                break;
                            }
                            else
                            {
                                break;   
                            }
                        }

                    }

                }

            }

        }
    
    $insertScore->closeCursor();
    closeConnection($db_connect);
    
    //asort($match_id);

    //print_r($match_id);

    
?>