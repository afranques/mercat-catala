//funció shownumber per el login de la pagina login
function shownumber2(correu)
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
		document.getElementById('numero_user2').value = xmlhttp.responseText;
		document.getElementById('numero_user2').value = document.getElementById('numero_user2').value.trim();
		document.getElementById('pwd_user22').value = hex_md5(document.getElementById('loginpwd2').value);
		document.getElementById('pwd_user21').value = hex_md5(document.getElementById('numero_user2').value+document.getElementById('pwd_user22').value);
		document.getElementById('loginpwd2').value = 'contrasenya';
		document.forms["loginusers2"].submit();
		}
	  }
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	}
//FI funció shownumber per el login de la pagina login