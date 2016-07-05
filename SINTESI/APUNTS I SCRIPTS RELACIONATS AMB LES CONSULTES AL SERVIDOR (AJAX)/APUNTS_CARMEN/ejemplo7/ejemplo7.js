// guarda la referencia al objetos XMLHttpRequest
var xmlHttp = createXmlHttpRequestObject();



// crea el objeto XMLHttpRequest
function createXmlHttpRequestObject()
{
	// almacenará la referencia al objeto XMLHttpRequest
	var xmlHttp;
	
	// Si se navega desde IE
	if(window.ActiveXObject)
	{
		try
		{
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp = false;
		}
	}
	
	// Si se navega desde Mozilla u otros navegadores
	else
	{
		try
		{
			xmlHttp = new XMLHttpRequest();
		}
		catch (e)
		{
			xmlHttp = false;
		}
	}
	
	// retorna el objeto creado o muestra un mensaje de error
	if (!xmlHttp)
		alert("Error al crear el objeto XMLHttpRequest.");
	else
		return xmlHttp;
}

// hace una llamada HTTP asícrona usando el objeto XMLHttpRequest
function process()
{
	// sigue si xmlHttp no está vacío
	if (xmlHttp)
	{
		// se ejecuta si no está vacío
		try
		{
			// para navegadores tipo Mozilla, pedimos permiso para acceder a servidores remotos
			try
			{
				//genera un error que ignoramos si el servidor no es mozilla
				netscape.security.PrivilegeManager.enablePrivilege('UniversalBrowserRead');
			}
			catch(e) {} // ignorar error
			// url de llamada al servidor remoto con sus parámetros necesarios
			var serverAddress = "proxy.php?min=1&max=100";
			//iniciamos el acceso a servidor
			xmlHttp.open("GET", serverAddress, true);
			xmlHttp.onreadystatechange = handleServerResponse;
			xmlHttp.send(null);
		}
		//mostramos el error en caso de fallo
		catch (e)
		{
			alert("No se puede conectar al servidor:\n" + e.toString());
		}
	}
}

function lTrim(sStr)
{	 
	while (sStr.charAt(0) != "0" && sStr.charAt(0) != "1" && sStr.charAt(0) != "2" && sStr.charAt(0) != "3" 
	&& sStr.charAt(0) != "4" && sStr.charAt(0) != "5" && sStr.charAt(0) != "6" && sStr.charAt(0) != "7" 
	&& sStr.charAt(0) != "8" && sStr.charAt(0) != "9" 	)
	{	
		sStr = sStr.substr(1, sStr.length - 1);	 
	}
	return sStr;	
}	

function rTrim(sStr)
{	
	while (sStr.charAt(0) != "0" && sStr.charAt(0) != "1" && sStr.charAt(0) != "2" && sStr.charAt(0) != "3" 
	&& sStr.charAt(0) != "4" && sStr.charAt(0) != "5" && sStr.charAt(0) != "6" && sStr.charAt(0) != "7" 
	&& sStr.charAt(0) != "8" && sStr.charAt(0) != "9" 	)
	{
		sStr = sStr.substr(0, sStr.length - 1);	 
	}
	return sStr;	
}

function allTrim(sStr)
{	 
	return rTrim(lTrim(sStr));	
}

function quitaBlancos(str)
{
	
	c_1 = new String(str);
	c_1 = c_1.replace(" ","");
	return c_1;
}
// Se ejecuta automáticamente cuando se recibe un mensaje del servidor
function handleServerResponse()
{
	// Se cumple sólo cuando la transacción (el envío del mensaje) se ha completado
	if (xmlHttp.readyState == 4)
	{
		// el status 200 indica que la transacción se completó correctamente
		if (xmlHttp.status == 200)
		{
			try
			{
				// lee el mensaje del servidor
				var response = allTrim(xmlHttp.responseText);
				// si la respuesta tiene más de 3 caracteres o es vacía, asumimos que es un error
				if(response.length > 3 || response.length == 0)
					throw(response.length == 0 ? "Error de servidor" : response);
				// obtenemos la referencia al elemento DIV
				myDiv = document.getElementById("elementoDIV");
				// sacamos la salida HTML
				myDiv.innerHTML = "Se recibió este número aleatorio del servidor:"
				+ response + "<br/>"+response.length;
			}
			catch(e)
			{
				// mostramos el mensaje de error
				alert("Error al leer la respuesta: " + e.toString());
			}
		}
		else
		{
			// mostramos el mensaje de error
			alert("Hubo un problema al recuperar los datos:\n" +
			xmlHttp.statusText);
		}
	}
}
