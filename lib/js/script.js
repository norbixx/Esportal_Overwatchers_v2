
function startTime()
{
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('time').innerHTML =
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}

function checkTime(i)
{
    if(i < 10) {i = "0" + i};
    return i;
}

function unlockPass()
{
    var x = document.getElementById("passInput");
    
    if(x.type === "password")
    {
        x.type = "text";
    }
    else
    {
        x.type = "password";
    }
}

function toggleDisplay()
{
    var x = document.getElementById("account-bar");
    var y = document.getElementById("account");
    var carret = document.getElementById("carret");
    
    if(x.style.display === "none")
    {
        
        x.style.display = "block";
        x.style.minWidth =  "" + (y.offsetWidth) + "px";
        x.style.position = "absolute";
        
        y.style.backgroundColor = "#005574";
        
        carret.classList.remove('fa-caret-up');
        carret.classList.add('fa-caret-down');
    }
    else
    {
        x.style.display = "none";
        
        y.style.backgroundColor = "transparent";
        
        carret.classList.remove('fa-caret-down');
        carret.classList.add('fa-caret-up');
    }
}


function toggleNotification()
{
    var x = document.getElementById("notification-bar");
    var bell = document.getElementById("notification-bell");
    
    if(x.style.display === "none")
    {
        
        x.style.display = "block";
        x.style.position = "absolute";
        
        bell.style.color = "#08a8e5";
        
    }
    else
    {
        x.style.display = "none";
        
        bell.style.color = "#ffffff";
        
    }
}

var repNumber = 2;

function addInput()
{
    if(repNumber < 11)
    {
        var input = "<tr><td><input type='text' name='report_id_" + repNumber + "' placeholder='Podaj ID reportu' class='inputDefaultReport'></td><td><i class='fas fa-plus-square addition' id='add_" + repNumber + "' onClick='addInput();'></i></td></tr>";
        
        document.getElementById('addition-box').innerHTML += input;
        
        var addButton = document.getElementById("add_" + (repNumber - 1) );
        addButton.parentNode.removeChild(addButton);
        
        repNumber++;
    }
    else
    {
        //...    
    }
    
}


function cupsToggler(id)
{
    var x = document.getElementsByClassName("toggle-" + id + "");
    var caret = document.getElementById("caret-" + id + "");
        
        for (var i=0; i < x.length; i+=1)
        {
            
            if(x[i].style.display === "none")
            { 
                x[i].style.display = "table-row";
                caret.classList.remove('fa-caret-up');
                caret.classList.add('fa-caret-down');

            }
            else
            {
                x[i].style.display = "none";
                caret.classList.remove('fa-caret-down');
                caret.classList.add('fa-caret-up');
            }
        }
}


function checkConfirm()
{
	return (confirm("Czy na pewno chcesz zamknąć wszystkie zgłoszenia?"));
	
	/*if(c == true)
		return (window.location.replace = "lib/php/admin-done-all.php");
	else
		return (window.location.replace = "admin/donereports?killcache=" + Math.random());*/
}