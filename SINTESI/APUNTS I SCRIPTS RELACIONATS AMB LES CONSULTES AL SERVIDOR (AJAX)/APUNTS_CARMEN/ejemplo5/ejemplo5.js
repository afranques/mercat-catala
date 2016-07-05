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
	// sigue si xmlHttp no est� vac�o
	if (xmlHttp)
	{
		// se ejecuta si no est� vac�o
		try
		{
			// obtiene los dos n�meros dados por el usuario
			var numero1 = document.getElementById("numero1").value;
			
			var numero2 = document.getElementById("numero2").value;
			// Creamos el querystring
			var params = "numero1=" + numero1 +	"&numero2=" + numero2;
			// hacemos la llamada as�ncrona
			xmlHttp.open("GET", "ejemplo5.php?" + params, true);
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

// Se ejecuta autom�ticamente cuando se recibe un mensaje del servidor
function handleServerResponse()
{
	// Se cumple s�lo cuando la transacci�n (el env�o del mensaje) se ha completado
	if (xmlHttp.readyState == 4)
	{
		// el status 200 indica que la transacci�n se complet� correctamente
		if (xmlHttp.status == 200)
		{
			try
			{
				// lee el mensaje del servidor
				var xmlResponse = xmlHttp.responseXML;
				// captura de errores si no hay respuesta --> IE y Opera
				if (!xmlResponse || !xmlResponse.documentElement)
					throw("XML no v�lido:\n" + xmlHttp.responseText);
				// captura de errores con Firefox
				var rootNodeName = xmlResponse.documentElement.nodeName;
				if (rootNodeName == "parsererror")
					throw("XML no v�lido:\n" + xmlHttp.responseText);
				// se obtiene el elemento ra�z del XML
				xmlRoot = xmlResponse.documentElement;
				// comprobamos que hemos recibido el documento XML que esper�bamos
				if (rootNodeName != "response" || !xmlRoot.firstChild)
					throw("XML no v�lido:\n" + xmlHttp.responseText);
				// El elemento hijo de <response> es el resultado que tenemos que mostrar.
				responseText = xmlRoot.firstChild.data;
				// mostramos el mensaje al usuario
				myDiv = document.getElementById("elementoDIV");
				myDiv.innerHTML = "Resultado dado por el servidor: " + responseText;
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
