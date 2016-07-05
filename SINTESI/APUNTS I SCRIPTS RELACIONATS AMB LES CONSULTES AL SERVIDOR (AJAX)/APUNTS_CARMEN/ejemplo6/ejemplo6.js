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
			// para navegadores tipo Mozilla, pedimos permiso para acceder a servidores remotos
			try
			{
				//genera un error que ignoramos si el servidor no es mozilla
				netscape.security.PrivilegeManager.enablePrivilege('UniversalBrowserRead');
			}
			catch(e) {} // ignorar error
			// url de llamada al servidor remoto con sus par�metros necesarios
			var serverAddress = "http://www.random.org/integers/";
			var serverParams = "num=1" + // cu�ntos n�meros se quieren generar
			"&min=1" + // desde este n�mero 
			"&max=100"+ // hasta este otro
			"&base=10&col=1&format=plain";
			//iniciamos el acceso a servidor
			xmlHttp.open("GET", serverAddress + "?" + serverParams, true);
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
				var response = xmlHttp.responseText;
				// obtenemos la referencia al elemento DIV
				myDiv = document.getElementById("elementoDIV");
				// sacamos la salida HTML
				myDiv.innerHTML = "Se recibi� este n�mero aleatorio del servidor: "
				+ response + "<br/>";
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
