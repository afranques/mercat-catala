<?php
// vamos a crear una contestación basada en XML
header('Content-Type: text/xml');
// Creamos la cabecera XML
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
// Añadimos el elemento <response> al XML
echo '<response>';
// recuperamos el nombre del usuario
$name = $_GET['name'];
// generamos la salida a partir del nombre que nos haya dado el usuario
$userNames = array('CARMEN', 'YODA');
if (in_array(strtoupper($name), $userNames))
echo 'Hola, administrador ' . htmlentities($name) . '!';
else
echo htmlentities($name) . ', no se quien eres!';

// cerramos el elementos <response> del XML
echo '</response>';
?>