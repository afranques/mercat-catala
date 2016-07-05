<?php
$connection = mysql_connect('localhost', 'root', '') or die ('No se puede establecer conexión!');
mysql_select_db('Agenda') or die ('No se puede seleccionar base de datos!');
$query = "SELECT * FROM esdeveniment WHERE true";
if (isset($_GET['clau']))
	{
	$tags = explode(' ', $_GET['clau']);
	foreach($tags as $tag)
		{
		$query = $query." and (lower(titol_activitat) like lower('%".$tag."%') or lower(descripcio) like lower('%".$tag."%'))";
		}
	}
$resultsimple = mysql_query($query) or die ('<br>Error en la consulta: $query. ' . mysql_error());
mysql_close($connection);
if (mysql_num_rows($resultsimple)!=0) //si s'han trobat alguns resultats...
	{?>
	<div id="contentcerca">
		<h3 class="titlecerca">Destaquem les teves propostes</h3><?php
		echo '<a href="portada.php?portada=agenda">Tornar al buscador</a><h4>Resultats (cerca simple):</h4><hr>';
		//els titols es classifiquen en una taula
		echo '<table border="0" width="100%"><tr>
		<td><b>Id:</b></td>
		<td><b>Data:</b></td>
		<td><b>Titol de l\'activitat:</b></td>
		<td><b>lloc:</b></td>
		<td><b>població:</b></td>
		</tr>';
		//FI els titols es classifiquen en una taula
		while($rowsimple = mysql_fetch_assoc($resultsimple)) //les files d'aquesta taula...
			{
			$connection = mysql_connect("localhost", "root", "");
			mysql_select_db("agenda");
			$consulta=mysql_query("SELECT l.lloc as lloc,p.nom_poblacio as poblacio FROM llocs_celebracio l,poblacions p WHERE l.id_poblacio=p.id_poblacio and l.id_esdeveniment=".$rowsimple['id_esdeveniment']);
			mysql_close($connection);
			echo '<tr>'; /*CADA FILA*/
				echo '<td width="5%">'.$rowsimple['id_esdeveniment'].'</td>'; /*columna*/
				echo '<td width="18%">'.$rowsimple['dates'].'</td>'; /*columna*/
				echo '<td width="25%"><a href="portada.php?portada=agenda&fitxa_id='.$rowsimple['id_esdeveniment'].'">'.$rowsimple['titol_activitat'].'</a></td>'; /*columna*/
				echo '<td width="18%">';/*columna*/
				if (mysql_num_rows($consulta)>1) echo '[+]';
				$rowslloc = mysql_fetch_assoc($consulta);
				echo $rowslloc['lloc'];
				echo '</td>'; 
				echo '<td width="18%">'.$rowslloc['poblacio'].'</td>'; /*columna*/
			echo '</tr>'; /*CADA FILA*/				
			}
		echo '</table>';?>
	</div><?php
	}
else //i si la cerca no ha tornat cap resultat...
	{
	echo 'no s\'ha trobat cap esdeveniment amb aquests paràmetres';
	}
?>