<?php

getSuccess("add", "true", "Zgłoszenia zostały pomyślnie dodane");
getFailed("add", "false", "Błąd podczas dodawania zgłoszeń");



echo "
    
    <form action='lib/php/add-reports_auto.php' method='POST'>
        <table cellpadding='0' cellspacing='0' class='reports-list'>
        <thead>
            <tr>
                <th colspan='2'>Dodawanie automatyczne</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type='number' name='amount' placeholder='Wybierz ilość' min='1' max='10' class='inputDefaultReport marginInput'>
                </td>
            <tr>
                <td>
                    <select name='category' class='selectReport'>
                        <option disabled selected>Wybierz powód</option>
                        <option value='0'>Złe zachowanie / Griefing</option>
                        <option value='' disabled>Podejrzenie oszustwa</option>
                        <option value='3'>Nadużycie czatu tekstowego</option>
                        <option value='4'>Nadużycie czatu głosowego</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan='2'>
                    <button type='submit' class='buttonDefault greenB'><i class='fas fa-plus-square'></i> Dodaj zgłoszenia</button>
                </td>
            </tr>
        </tbody>
        </table>
    </form>

    <form action='lib/php/add-reports_id.php' method='POST' class='add-reports'>
        <table cellpadding='0' cellspacing='0'>
        <thead>
            <tr>
                <th colspan='5'>Dodawanie manualne po ID</th>
            </tr>
        </thead>
        <tbody id='addition-box'>";


//DODAWANIE PO ID...
if(!empty($_GET['list']))
{
    if($_GET['list'] == true)
    {
        for($i = 1; $i < 11; $i++)
        {
            echo "
            <span >
            <tr>
                <td>
                    <input type='text' name='report_id_".$i."' placeholder='Podaj ID reportu' class='inputDefaultReport'>
                </td>
                <td>
                </td>";
        }
    }
    else
    {
        //...
    }
}
else
{
    echo "
    <span >
    <tr>
        <td>
            <input type='text' name='report_id_1' placeholder='Podaj ID reportu' class='inputDefaultReport'>
        </td>
        <td id='addition-button'>
            <i class='fas fa-plus-square addition' id='add_1' onClick='addInput();'></i>
        </td>
    </tr>
    ";
}
                    
echo "
        </tbody>
        <tbody>";

if(!empty($_GET['list']))
{
    if($_GET['list'] == 'true')
    {    
        echo "        
        <tr>
            <td colspan='2'>
                <p><a href='admin/addreports' class='account-href'>Zwiń listę dodawania</a></p>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
                <p>Zanim wprowadzisz ID, wybierz ile pól do wpisania potrzebujesz! (max 10)</p>
            </td>
        </tr>"; 
    }
    else
    {
        //...
    }
}
else
{
    echo "        
    <tr>
        <td colspan='2'>
            <p><a href='admin?request=addreports&list=true' class='account-href'>Rozwiń listę dodawania do maksimum</a></p>
        </td>
    </tr>
    <tr>
        <td colspan='2'>
            <p>Zanim wprowadzisz ID, wybierz ile pól do wpisania potrzebujesz! (max 10)</p>
        </td>
    </tr>";    
}


echo "        

        <tr>
            <td colspan='5'>
                <button type='submit' class='buttonDefault greenB'><i class='fas fa-plus-square'></i> Dodaj zgłoszenia</button>
            </td>
        </tr>
        </tbody>
        </table>
    </form>";

?>