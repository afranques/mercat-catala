<?php
	// Indicamos que la salida de este PHP no es HTML, sino XML
	header('Content-Type: text/xml');
	// Creamos un XML nuevo
	$dom = new DOMDocument();
	// creamos el nodo <response> 
	$response = $dom->createElement('response');
	$dom->appendChild($response);
	// creamos el elemento <libros> y lo añadimos como hijo de <response>
	$books = $dom->createElement('libros');
	$response->appendChild($books);
	// creamos el elemento título del libro
	$title = $dom->createElement('titulo');
	$titleText = $dom->createTextNode
	('PHP and MySQL for Dummies');
	$title->appendChild($titleText);
	//creamos el elemento ISBN de libro
	$isbn = $dom->createElement('isbn');
	$isbnText = $dom->createTextNode('1-934811-82-5');
	$isbn->appendChild($isbnText);
	//creamos el elemento libro
	$book = $dom->createElement('libro');
	$book->appendChild($title);
	$book->appendChild($isbn);
	// añadimos el elemento libro a la lista de libros.
	$books->appendChild($book);
	// build the XML structure in a string variable
	$xmlString = $dom->saveXML();
	// output the XML string
	echo $xmlString;
?>



