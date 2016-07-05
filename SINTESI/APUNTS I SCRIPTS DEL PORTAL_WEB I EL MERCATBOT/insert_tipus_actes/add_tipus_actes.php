<?php

	$connection = mysql_connect('localhost', 'root', '') or die ('No se puede establecer conexión!');
	mysql_select_db('Agenda') or die ('No se puede seleccionar base de datos!');
	
	$acte[0]='Altres';
	$acte[1]='Altres accions escèniques';
	$acte[2]='Aplecs i ballades';
	$acte[3]='Cicles musicals';
	$acte[4]='Concerts';
	$acte[5]='Conferències, xerrades i tertúlies';
	$acte[6]='Cursos, tallers i seminaris';
	$acte[7]='Espectacles';
	$acte[8]='Exhibició castellera';
	$acte[9]='Exposicions i instal·lacions';
	$acte[10]='Festes';
	$acte[11]='Festivals i mostres d’arts escèniques i de carrer';
	$acte[12]='Festivals i mostres de cinema i vídeo';
	$acte[13]='Festivals musicals';
	$acte[14]='Festivals pluridisciplinaris';
	$acte[15]='Fires i salons';
	$acte[16]='Jornades i congressos';
	$acte[17]='Narracions, lectures i recitals';
	$acte[18]='Parcs infantils i juvenils';
	$acte[19]='Performances';
	$acte[20]='Portes obertes';
	$acte[21]='Presentacions';
	$acte[22]='Projeccions';
	$acte[23]='Rutes i itineraris';
	$acte[24]='Taules rodones i debats';
	$acte[25]='Trobades';
	$acte[26]='Visites';
	
	for($i=0; $i <= 26; $i++)
		{
		$query = "INSERT INTO tipus_actes VALUES($i,'".$acte[$i]."')";
		mysql_query($query) or die ('<br>Error en la consulta: $query. ' . mysql_error());
		}

?>