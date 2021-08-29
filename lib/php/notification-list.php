<?php

    $db_connect = startConnection();
    $user_id = $_COOKIE['auth_id'];

    $notifications = $db_connect->query("SELECT * from notifications WHERE user_id=".$user_id." GROUP BY text ORDER BY date DESC, time DESC LIMIT 20");
    
    if($notifications->rowCount() > 0)
    {
        foreach($notifications as $row)
        {
            echo "

                <li>
                    <div class='notification-box'>
                        <div class='notification-text'>
                            ".$row['text']."
                        </div>
                        <div class='notification-date'>
                            ".$row['date'].", ".$row['time']."
                        </div>
                    </div>
                </li>

            ";
        }
    }
    else
    {
        echo "
            <li>
                <span class='nothing'><center>Brak powiadomień (w trakcie tworzenia)</center></span>
            </li>
        ";
    }

    $db_connect = null;
?>