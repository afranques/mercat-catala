//funci� shownumber per el login de la barra men�s
function shownumber(correu)
	{
	var url="AJAX/obtain_number/shownumberuser.php";
	url=url+"?q="+correu;
	url=url+"&sid="+Math.random();

	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 || xmlHttp.readyState=="complete")
		{
		document.getElementById('numero_user').value = xmlhttp.responseText;
		document.getElementById('numero_user').value = document.getElementById('numero_user').value.trim();
		document.getElementById('pwd_user2').value = hex_md5(document.getElementById('loginpwd').value);
		document.getElementById('pwd_user').value = hex_md5(document.getElementById('numero_user').value+document.getElementById('pwd_user2').value);
		document.getElementById('loginpwd').value = 'contrasenya';
		document.forms["loginusers"].submit();
		}
	  }
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}
//FI funci� shownumber per el login de la barra men�s