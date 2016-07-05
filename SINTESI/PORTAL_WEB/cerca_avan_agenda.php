<?php
$connection = mysql_connect('localhost', 'root', '') or die ('No se puede establecer conexión!');
mysql_select_db('Agenda') or die ('No se puede seleccionar base de datos!');
$query = 'SELECT * FROM esdeveniment WHERE true';
//PARAULES CLAU
if (isset($_GET['clau']))
	{
	$tags = explode(' ', $_GET['clau']);
	foreach($tags as $tag)
		{
		$query = $query." and (lower(titol_activitat) like lower('%".$tag."%') or lower(descripcio) like lower('%".$tag."%'))";
		}
	}
//PARAULES CLAU

//TIPUS D'ACTE
if (isset($_GET['acte'])) $query=$query." and id_acte=".$_GET['acte'];
//TIPUS D'ACTE

//DATA ENTRE
if (isset($_GET['data']) && $_GET['data']=='entre')
	{
	if ($_GET['datainici']!='' && $_GET['datafi']!='')
		{
		$query=$query." and id_esdeveniment IN (
		select id_esdeveniment from dates_esdeveniment where data>='".$_GET['datainici']."' and data<='".$_GET['datafi']."')";
		}
	else if ($_GET['datainici']!='' && $_GET['datafi']=='')
		{
		$query=$query." and id_esdeveniment IN (
		select id_esdeveniment from dates_esdeveniment where data>='".$_GET['datainici']."')";
		}
	else if ($_GET['datainici']=='' && $_GET['datafi']!='')
		{
		$query=$query." and id_esdeveniment IN (
		select id_esdeveniment from dates_esdeveniment where data<='".$_GET['datafi']."')";
		}
	}
//DATA ENTRE

/*if (isset($_GET['data']) && $_GET['data']=='avuiidema')
	{
	$query=$query." and id_esdeveniment IN (
		select id_esdeveniment from dates_esdeveniment where data>='".$_GET['datainici']."' and data<='".$_GET['datafi']."')";
	}
if (isset($_GET['data']) && $_GET['data']=='proxim')
	{
	$query=$query." and id_esdeveniment IN (
		select id_esdeveniment from dates_esdeveniment where data>='".$_GET['datainici']."' and data<='".$_GET['datafi']."')";
	}*/
	
//COMARCA I POBLACIÓ
if (isset($_GET['comarca']) && isset($_GET['poblacio']))
	{
	$query=$query." and id_esdeveniment IN (select id_esdeveniment from llocs_celebracio where id_comarca=".$_GET['comarca']." and id_poblacio=".$_GET['poblacio'].")";
	}
//COMARCA I POBLACIÓ

//COMARCA
else if (isset($_GET['comarca']) && $_GET['poblacio'] == '')
	{
	$query=$query." and id_esdeveniment IN (select id_esdeveniment from llocs_celebracio where id_comarca=".$_GET['comarca'].")";
	}
//COMARCA

$query = $query.' order by id_esdeveniment';
$resultavan = mysql_query($query) or die ('<br>Error en la consulta: $queryavan. ' . mysql_error());
mysql_close($connection);
if (mysql_num_rows($resultavan)!=0) //si s'han trobat alguns resultats...
	{?>
	<div id="contentcerca">
		<h3 class="titlecerca">Destaquem les teves propostes</h3><?php
		echo '<a href="portada.php?portada=agenda">Tornar al buscador</a><h4>Resultats (cerca avançada):</h4><hr>';
		//els titols es classifiquen en una taula
		echo '<table border="0" width="100%"><tr>
		<td><b>Id:</b></td>
		<td><b>Data:</b></td>
		<td><b>Titol de l\'activitat:</b></td>
		<td><b>lloc:</b></td>
		<td><b>població:</b></td>
		</tr>';
		while($rowavan = mysql_fetch_assoc($resultavan)) //les files d'aquesta taula...
			{
			$connection = mysql_connect("localhost", "root", "");
			mysql_select_db("agenda");
			$consulta=mysql_query("SELECT l.lloc as lloc,p.nom_poblacio as poblacio FROM llocs_celebracio l,poblacions p WHERE l.id_poblacio=p.id_poblacio and l.id_esdeveniment=".$rowavan['id_esdeveniment']);
			mysql_close($connection);
			echo '<tr>'; /*CADA FILA*/
				echo '<td width="5%">'.$rowavan['id_esdeveniment'].'</td>'; /*columna*/
				echo '<td width="18%">'.$rowavan['dates'].'</td>'; /*columna*/
				echo '<td width="25%"><a href="portada.php?portada=agenda&fitxa_id='.$rowavan['id_esdeveniment'].'">'.$rowavan['titol_activitat'].'</a></td>'; /*columna*/
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
	echo '<tr><td colspan="5">no s\'ha trobat cap esdeveniment amb aquests paràmetres</td></tr>';
	}
?>