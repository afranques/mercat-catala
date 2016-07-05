<?php
$con = mysql_connect('localhost', 'root', ''); 
mysql_select_db('agenda');
$sql=mysql_query("SELECT * FROM users",$con);

$row = mysql_fetch_array($sql);
echo "<p>".$row['contrasenya']."</p>";
?>