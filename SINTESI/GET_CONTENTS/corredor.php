<?php

include("mercatbot.php");

$fitxa_id = 0; //establim l'id de la fitxa

while ($fitxa_id <= 9999) //recorrem totes les fitxes de la 0 a la 9999
	{
	CorreFitxes($fitxa_id);
	$fitxa_id++;
	}

?>