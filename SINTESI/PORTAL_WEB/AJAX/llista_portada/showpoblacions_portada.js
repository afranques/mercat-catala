function showPoblacionsPortada(str)
	{
	var url="AJAX/llista_portada/getpoblacions_portada.php";
	url=url+"?q="+str;
	url=url+"&sid="+Math.random();
	
	var url2="AJAX/llista_portada/getesdeveniments_portada.php";
	url2=url2+"?q="+str;
	url2=url2+"&sid="+Math.random();

	if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		xmlhttp2=new XMLHttpRequest();
		}
	else
		{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
	xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			}
		}
		
	xmlhttp2.onreadystatechange=function()
		{
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
			{
			document.getElementById("txtEsdevenimentHint").innerHTML=xmlhttp2.responseText;
			mostraesdeveniments();
			}
		}
		
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
	
	xmlhttp2.open("GET",url2,true);
	xmlhttp2.send();
	}
	
function showPoblacionsConcretesPortada(str)
	{
	if (str == '')
		{
		showPoblacionsPortada(document.getElementById('comarcaportada').value);
		}
	else
		{
		var url3="AJAX/llista_portada/getesdevenimentsconcrets_portada.php";
		url3=url3+"?q="+str;
		url3=url3+"&sid="+Math.random();

		if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp3=new XMLHttpRequest();
			}
		else
			{// code for IE6, IE5
			xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
			}
			
		xmlhttp3.onreadystatechange=function()
			{
			if (xmlhttp3.readyState==4 && xmlhttp3.status==200)
				{
				document.getElementById("txtEsdevenimentHint").innerHTML=xmlhttp3.responseText;
				mostraesdeveniments();
				}
			}
		
		xmlhttp3.open("GET",url3,true);
		xmlhttp3.send();
		}
	}