<html>
<head>

</head>
<body>
	<script src="2.2/md5-min.js" type="text/javascript"></script>
	<script src="2.2/sha1-min.js" type="text/javascript"></script>
	<script language="JavaScript">
	function submitnumero()
		{
		numero = Math.random()*1000;
		document.getElementById('numero').value = numero;
		}
	</script>

	<form action="prova.php" method="POST" name="login">
		Usuario: <input type="Text" name="usuario"><br>
		Password: <input type="Password" name="contrasenya" id="password"><br>
		<input type="text" readonly name="hash" id="hash" size="40"><br>
		<input type="text" readonly name="numero" id="numero" size="40">
		<input type="text" readonly name="numerohash" id="numerohash" size="40">
		<input type="button" onclick="document.getElementById('hash').value = hex_md5(document.getElementById('password').value); submitnumero(); document.getElementById('numerohash').value = hex_md5(document.getElementById('numero').value)" name="submitregistre" value="envia">
	</form>
	<?php
	if (isset($_POST['submitregistre']))
		{
		echo '<br>'.$_POST['usuario'];
		echo '<br>'.$_POST['contrasenya'];
		echo '<br>'.$_POST['hash'];
		echo '<br>'.$_POST['numero'];
		}
	?>
</body>
</html>