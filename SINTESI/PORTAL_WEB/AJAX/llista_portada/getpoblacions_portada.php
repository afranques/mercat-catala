<?php
$q=$_GET["q"];

if ($q == '')
	{?>
	<select disabled="disabled" id="poblacioportada" name="poblacioportada">
		<option value="">Selecciona poblaci&oacute;...</option>
	</select><?php
	}
else
	{
	$con = mysql_connect('localhost', 'root', '');
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

	mysql_select_db('Agenda') or die ('No se puede seleccionar base de datos!');

	$sql="SELECT * FROM poblacions WHERE id_comarca = '".$q."'";

	$result = mysql_query($sql) or die('Query error: ' . mysql_error()); ;

	echo "<select id='poblacioportada' name='poblacioportada' onchange='showPoblacionsConcretesPortada(this.value)';>
			<option value=''></option>";
	while($row = mysql_fetch_assoc($result))
	  {
	  echo "<option value='".$row['id_poblacio']."'>".utf8_encode($row['nom_poblacio'])."</option>";
	  }
	echo "</select>";

	mysql_close($con);
	}
?> 