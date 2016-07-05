<?php
$q=$_GET["q"];

if ($q == '')
	{
	echo 'el camp correu no pot ser buit';
	}
else
	{
	$connect = mysql_connect('localhost', 'root', '') or die('Could not connect: ' . mysql_error());
	mysql_select_db('agenda') or die ('No se puede seleccionar base de datos!');
	$sql="SELECT numero FROM users WHERE email = '".$q."'";
	$result = mysql_query($sql) or die('Query error: ' . mysql_error());
	if(mysql_num_rows($result) != 0)
		{
		$row = mysql_fetch_assoc($result);
		echo trim($row['numero']);
		}
	else echo 'aquest correu no existeix';
	mysql_close($connect);
	}
?> 