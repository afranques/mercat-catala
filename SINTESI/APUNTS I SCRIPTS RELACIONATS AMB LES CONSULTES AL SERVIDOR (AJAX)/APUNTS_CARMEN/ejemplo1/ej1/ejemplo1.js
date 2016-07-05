// guarda la referencia al objetos XMLHttpRequest
var xmlHttp = createXmlHttpRequestObject();

// crea el objeto XMLHttpRequest
function createXmlHttpRequestObject()
{
	// almacenar� la referencia al objeto XMLHttpRequest
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

// hace una llamada HTTP as�crona usando el objeto XMLHttpRequest
function process()
{
	// Comprueba que el objeto xmlHttp no est� ocupado
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
	{
		// recupera el nombre que ha introducido el usuario
		name = encodeURIComponent(document.getElementById("myName").value);
		// hace la llamada al servidor (a ejemplo1.php) 
		xmlHttp.open("GET", "ejemplo1.php?name=" + name, true);
		// indica qu� m�todo recoger� la respuesta del servidor
		xmlHttp.onreadystatechange = handleServerResponse;
		// se hace la petici�n al servidor
		xmlHttp.send(null);
	}
	else
		// si la conexi�n est� ocupada, se reintenta al cabo de 1 seg.
		setTimeout('process()', 1000);
}

// Se ejecuta autom�ticamente cuando se recibe un mensaje del servidor
function handleServerResponse()
{
	// Se cumple s�lo cuando la transacci�n (el env�o del mensaje) se ha completado
	if (xmlHttp.readyState == 4)
	{
		// el status 200 indica que la transacci�n se complet� correctamente
		if (xmlHttp.status == 200)
		{
			// leemos el mensaje del servidor (es un XML)
			xmlResponse = xmlHttp.responseXML;
			// extraemos el elemento ra�z del XML, que es la respuesta del servidor.
			xmlDocumentElement = xmlResponse.documentElement;
			helloMessage = xmlDocumentElement.firstChild.data;
			// colocamos en el XML el mensaje que recibimos del servidor
			document.getElementById("divMessage").innerHTML ='<i>' + helloMessage + '</i>';
			// ponemos el process a la escucha
			setTimeout('process()', 1000);
		}
		// si el HTTP status no es 200, significa que hubo un error
		else
		{
			alert("Problemas al acceder al servidor: " + xmlHttp.statusText);
		}
	}
}