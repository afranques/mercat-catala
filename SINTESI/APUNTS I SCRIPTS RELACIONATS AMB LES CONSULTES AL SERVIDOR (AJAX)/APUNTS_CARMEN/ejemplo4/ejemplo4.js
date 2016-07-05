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
	// se ejecuta si no está vacío
	if (xmlHttp)
	{
		// Se intenta conectar al servidor
		try
		{
			//Empezamos a leer el xml
			xmlHttp.open("GET", "libros.xml", true);
			xmlHttp.onreadystatechange = handleServerResponse;
			xmlHttp.send(null);
		}
		// se muestra error en caso de fallo
		catch (e)
		{
			alert("Imposible conectar al servidor:\n" + e.toString());
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
			// lee el mensaje del servidor
			var xmlResponse = xmlHttp.responseXML;
			// se obtiene el elemento raíz del XML
			var xmlRoot = xmlResponse.documentElement;
			//Sacamos el array de libros
			titleArray = xmlRoot.getElementsByTagName("titulo");
			isbnArray = xmlRoot.getElementsByTagName("isbn");
			// generamos la salida HTML
			var html = "";
			for (var i=0; i<titleArray.length; i++)
				html += titleArray.item(i).firstChild.data +", " 
				+ isbnArray.item(i).firstChild.data + "<br/>";
			// obtenemos la referencia del elemento DIV
			myDiv = document.getElementById("elementoDIV");
			// mostramos la salida
			myDiv.innerHTML = "Contestación: <br />" + html;
		}
		// si el HTTP status no es 200, significa que hubo un error
		else
		{
			alert("Problemas al acceder al servidor: " + xmlHttp.statusText);
		}
	}
}