<?php 

    require_once("connect.php");
    
    ini_set("memory_limit", "256M");
    
    if(isset($_COOKIE['auth_login']) && isset($_COOKIE['auth_token']))
    {
        require_once("handler.php");
        
        $db_connect = startConnection();
        
        $login = $_COOKIE['auth_login'];
        $permission = getPermission($login, $db_connect);

        if($permission == 100)
        {

            $file = file_get_contents("");

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

                    if($match > 1000000)
                    {
                        
                        $reporter = json_encode($value["reporter"], true);
                        $reported = json_encode($value["reported"], true);

                        $reporterUser = json_decode($reporter, true);
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
                                        
                                        $desc_file = file_get_contents("https://pl-api.esportal.se/admin/report/get?_=1557097531003&report_id=".$report_id[$i]."&_u=289650248&_t=%26%22)Lq%3DVj(ED%5D%2FR%2FLhdotW-%23%3DP%5C_%5EX%27%40r%22lZjJm%26c");
                                        $report_desc = json_decode($desc_file, true);
                                        $ustr = array('\u0104','\u0106','\u0118','\u0141','\u0143','\u00d3','\u015a','\u0179','\u017b','\u0105','\u0107','\u0119','\u0142','\u0144','\u00f3','\u015b','\u017a','\u017c');
                                        $plstr = array('Ą','Ć','Ę','Ł','Ń','Ó','Ś','Ź','Ż','ą','ć','ę','ł','ń','ó','ś','ź','ż');
                                        $description[$i] = str_replace($ustr,$plstr, ltrim(rtrim(json_encode($report_desc['description']), '"'), '"'));
                                        
                                        $reporterUsername[$i] = $reporterUser["username"];

                                        if($category[$i] == 0)
                                            $rString = "Złe zachowanie / Griefing";
                                        if($category[$i] == 1)
                                            $rString = "Podejrzenie oszustwa";
                                        if($category[$i] == 3)
                                            $rString = "Nadużycie czatu tekstowego";
                                        if($category[$i] == 4)
                                            $rString = "Nadużycie czatu głosowego";

                                        //echo $report_id[$i]." | ".$username[$i]." | "."#".$match_id[$i]." | ".$accepted[$i]." | ".$category[$i]." | "."https://s3.eu-central-1.wasabisys.com/demo-production/".$match_id[$i].".dem"."<br/>";

                                        $link = addslashes("https://s3.eu-central-1.wasabisys.com/demo-production/".$match_id[$i].".dem");
                                        $repuser = addslashes($username[$i]);
                                        $report = addslashes($rString);
                                        $replink = addslashes("https://beta.esportal.pl/admin/report/".$report_id[$i]);
                                        $expireTime = date("Y-m-d H:i:s", (time() + (61*24*60*60) + 94));

                                        $insertScore = $db_connect->query("INSERT INTO replays(link, repuser, report, admindesc, replink, expiredate, match_id, reporter) VALUES ('".$link."', '".$repuser."', '".$report."', '".$description[$i]."', '".$replink."', '".$expireTime."', ".$match_id[$i].", '".$reporterUsername[$i]."')");
                                        
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
            $db_connect = null;
            
            header("Location: ../../admin/addreports?add=true");
            
        }
        else
        {
            
            header("Location: ../../panel?killcache=".rand().""); 
            
        }
    }
    else
    {
        
        header("Location: ../../index");
        
    }
    
?>