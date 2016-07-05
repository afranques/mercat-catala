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
			// obtiene los dos números dados por el usuario
			var numero1 = document.getElementById("numero1").value;
			
			var numero2 = document.getElementById("numero2").value;
			// Creamos el querystring
			var params = "numero1=" + numero1 +	"&numero2=" + numero2;
			// hacemos la llamada asíncrona
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
				var xmlResponse = xmlHttp.responseXML;
				// captura de errores si no hay respuesta --> IE y Opera
				if (!xmlResponse || !xmlResponse.documentElement)
					throw("XML no válido:\n" + xmlHttp.responseText);
				// captura de errores con Firefox
				var rootNodeName = xmlResponse.documentElement.nodeName;
				if (rootNodeName == "parsererror")
					throw("XML no válido:\n" + xmlHttp.responseText);
				// se obtiene el elemento raíz del XML
				xmlRoot = xmlResponse.documentElement;
				// comprobamos que hemos recibido el documento XML que esperábamos
				if (rootNodeName != "response" || !xmlRoot.firstChild)
					throw("XML no válido:\n" + xmlHttp.responseText);
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
