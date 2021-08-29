<?php

if(isset($_COOKIE['auth_login']) && isset($_COOKIE['auth_token']))
{
        require_once("handler.php");
    
        $db_connect = startConnection();

        $login = $_COOKIE['auth_login'];
        $permission = getPermission($login, $db_connect);

        if($permission == 100)
        {
            for($i = 1; $i < 11; $i++)
            {
                if(!empty($_POST['report_id_'.$i]))
                {
                    $id = $_POST['report_id_'.$i];
                    
                    $reportFile = file_get_contents("");
                    $report = json_decode($reportFile, true);
                    
                    $ustr = array('\u0104','\u0106','\u0118','\u0141','\u0143','\u00d3','\u015a','\u0179','\u017b','\u0105','\u0107','\u0119','\u0142','\u0144','\u00f3','\u015b','\u017a','\u017c');
                    $plstr = array('Ą','Ć','Ę','Ł','Ń','Ó','Ś','Ź','Ż','ą','ć','ę','ł','ń','ó','ś','ź','ż');
                    
                    
                    $match_id[$i] = $report['match_id'];
                    $category[$i] = $report['category'];
                    $description[$i] = $report['description'];
                    $demoLink[$i] = "https://s3.eu-central-1.wasabisys.com/demo-production/".$match_id[$i].".dem";
                    $reportLink[$i] = "https://beta.esportal.pl/admin/report/".$id;
                    $expireTime = date("Y-m-d H:i:s", (time() + (61*24*60*60) + 94));
                    
                    if($category[$i] == 0)
                        $rString = "Złe zachowanie / Griefing";
                    if($category[$i] == 1)
                        $rString = "Podejrzenie oszustwa";
                    if($category[$i] == 3)
                        $rString = "Nadużycie czatu tekstowego";
                    if($category[$i] == 4)
                        $rString = "Nadużycie czatu głosowego";
                    
                    foreach($report as $key => $value)
                    {
                        $reporterArray = json_encode($report["reporter"], true);
                        $reportedArray = json_encode($report["reported"], true);
                        
                        $reporterUser = json_decode($reporterArray, true);
                        $reportedUser = json_decode($reportedArray, true);
                        
                        $reporter[$i] = $reporterUser["username"];
                        $reported[$i] = $reportedUser["username"];
                        
                    }
                    
                    $insertScore = $db_connect->query("INSERT INTO replays(link, repuser, report, admindesc, replink, expiredate, match_id, reporter) VALUES('".addslashes($demoLink[$i])."', '".addslashes($reported[$i])."', '".$rString."', '".addslashes($description[$i])."', '".addslashes($reportLink[$i])."', '".$expireTime."', ".$match_id[$i].", '".addslashes($reporter[$i])."')");
                }
                else
                {
                    break;
                    header("Location: ../../admin/addreports?killcache=".rand()."");
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