<?php
	// aseguramos que el navegador no tiene nada en caché
	header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	
	// recuperamos los parámetros
	$num = 1; // forzado por nosotros
	$min = $_GET['min'];
	$max = $_GET['max'];
	
	$serverAddress = "http://www.random.org/integers/";
	$serverParams = "num=" . $num . "&min=". $min . "&max=". $max . "&base=10&col=1&format=plain";
			
	// recuperar el número generado por el servidor externo
	$randomNumber = file_get_contents($serverAddress . '?' . $serverParams);
	
	// da el número aleatorio
	echo $randomNumber;
?>
