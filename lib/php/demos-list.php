<?php


    $db_connect = startConnection();

    $reports = $db_connect->query("SELECT id, repuser, report, description, expiredate FROM replays WHERE done=0 and ban=0 ORDER BY expiredate LIMIT ".($page-1)*$limit.",".$limit."");

    echo    
        "<table cellspacing='0' cellpadding='0'>
            <thead>
                <tr>
                    <th>Zgłoszenie nr.:</th>
                    <th>Zgłaszany użytkownik:</th>
                    <th>Powód zgłoszenia:</th>
                    <th>Opis:</th>
                    <th>Wygasa:</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
        ";


    if($reports->rowCount() > 0){
        
        foreach($reports as $row){

            echo "
                    <tr>
                        <td>#".$row['id']."</td>
                        <td>".$row['repuser']."</td>
                        <td>".$row['report']."</td>
                        <td>".$row['description']."</td>
                        <td>".$row['expiredate']."</td>
                        <td>
                            <a href='report/".$row['id']."'><button class='buttonDefault greenB'><i class='fas fa-check-square'></i> Przyjmij</button></a>
                            <a href='report/".$row['id']."/view'><button class='buttonDefault blueB'><i class='fas fa-search'></i> Przejrzyj</button></a>";

            if($permission == 100)
                echo "<a href='lib/php/delete-report.php?id=".$row['id']."'><button class='buttonDefault redB'><i class='fas fa-trash-alt'></i> Usuń</button></a>";

            echo "
                        </td>
                    </tr>
                ";
        }
        
    }else{
        
        echo "
            <tr>
                <td colspan='6'><br />Brak zgłoszeń, poproś administratora o dodanie.<br /><br /></td>
            </tr>
        ";
        
    }

    echo    "
            </tbody>
        </table>
        ";


    $reports->closeCursor();
    $db_connect = null;

?>