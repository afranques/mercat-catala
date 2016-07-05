<?php
	// cargamos el php que trata los errores
	require('ejemplo5_manejoErrores.php');
	// especificamos que la salida es un documento XML
	header('Content-Type: text/xml');
	// calculamos el resultado
	$numero1 = $_GET['numero1'];
	$numero2 = $_GET['numero2'];
	$result = $numero1 / $numero2;
	// Creamos un documento XML nuevo
	$dom = new DOMDocument();
	// Creamos el nodo <response> y lo añadimos al documento
	$response = $dom->createElement('response');
	$dom->appendChild($response);
	// Añadimos el valos calculado como un nodo de testo hijo del nodo <response>
	$responseText = $dom->createTextNode($result);
	$response->appendChild($responseText);
	// Pasamos la estructura XML a una variable string
	$xmlString = $dom->saveXML();
	// mostramos el texto XML
	echo $xmlString;
?>

