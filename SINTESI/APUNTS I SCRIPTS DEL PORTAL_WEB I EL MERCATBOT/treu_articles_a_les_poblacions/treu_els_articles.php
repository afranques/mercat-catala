<?php/*

	$connection = mysql_connect('localhost', 'root', '') or die ('No se puede establecer conexión!');
	mysql_select_db('Agenda') or die ('No se puede seleccionar base de datos!');
	$query = "SELECT * FROM poblacions WHERE lower(nom_poblacio) LIKE '%, les'";
	$result = mysql_query($query) or die ('<br>Error en la consulta: $query. ' . mysql_error());
	
	$c=0;
	
	while ($row = mysql_fetch_assoc($result))
		{
		$c++;
		$net = substr($row['nom_poblacio'], 0, (strlen($row['nom_poblacio'])-5));
		$net = trim($net);
		echo '<br>'.$c.' - '.$row['id_poblacio'].' - '.$net;
		$query_update = "update poblacions set nom_poblacio=\"Les ".$net."\" WHERE id_poblacio=".$row['id_poblacio'];
		mysql_query($query_update) or die ('<br>Error en el update: $query. ' . mysql_error());
		}
*/
?>