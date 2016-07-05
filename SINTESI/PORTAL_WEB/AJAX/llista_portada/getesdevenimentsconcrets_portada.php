<?php
$q=$_GET["q"];

if ($q == '')
	{?>
	<h3>Has de seleccionar una poblacio!</h3><?php
	}
else
	{
	$con = mysql_connect('localhost', 'root', '') or die('Could not connect: ' . mysql_error());
	mysql_select_db('Agenda') or die ('No se puede seleccionar base de datos!');
	$sql="SELECT e.id_esdeveniment,e.tipus_acte,e.titol_activitat,ll.lloc,p.nom_poblacio FROM esdeveniment e,llocs_celebracio ll,poblacions p 
	WHERE e.id_esdeveniment=ll.id_esdeveniment and ll.id_poblacio=p.id_poblacio and p.id_poblacio='".$q."'";
	$result = mysql_query($sql) or die('Query error: ' . mysql_error());
	mysql_close($con);
	
	$numrows = mysql_num_rows($result);
	
	if ($numrows > 0)
		{
		$numentrada = 0;
		$i = $numrows;
		
		echo '<div id="numerodefiles" style="display: none">'.$numrows.'</div>';
		
		while($row = mysql_fetch_assoc($result))
			{
			$numentrada = $numrows-$i;
			echo '<div id="entrada'.$numentrada.'" class="entry" style="display: none;">';
				echo'<div id="myimage'.$numentrada.'" style="display: none; border-bottom: 1px #B0E0E6 dashed;">';
					echo '<a href="portada.php?portada=agenda&fitxa_id='.$row['id_esdeveniment'].'"><p><b>'.utf8_encode($row['titol_activitat']).'</b><br><i>'.utf8_encode($row['tipus_acte']).'</i><br>
					'.utf8_encode($row['lloc']).' ('.utf8_encode($row['nom_poblacio']).')</p></a>';
				echo '</div>';
			echo '</div>';
			$i--;
			}
		}
	else echo '<h3>No s\'han trobat esdeveniments amb aquesta cerca tant concreta, prova-ho tan sols amb la comarca!</h3>';
	}
?> 