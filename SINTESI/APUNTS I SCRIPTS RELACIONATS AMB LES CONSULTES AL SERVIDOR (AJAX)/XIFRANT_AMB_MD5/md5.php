<?

$password = 'hola';

if (!isset($password)) 
	{?>
	<html>
	<head>
		<script language="JavaScript" src="md5.js"></script>
		<script language="JavaScript">
		numero = Math.random().toString();
		function calculaMD5()
			{
			var pw = document.forms["login"].elements["password"].value
			pw += numero
			return calcMD5(pw)
			}
		function enviaMD5(hash)
			{
			document.forms["login"].elements["password"].value = hash;
			document.forms["login"].elements["numero"].value = numero;
			document.forms["login"].submit();
			}
		</script>
	</head>
	<body>
	<form action="md5.php" method="POST" name="login">
		Usuario: <input type="Text" name="usuario"><br>
		Password: <input type="Password" name="password"><br>
		<input type="Hidden" name="numero" value="">
		<input type="Submit" value=" Login " onClick="enviaMD5(calculaMD5())">
	</form>
	</body>
	</html><?
	}
else if($password) 
	{?>
	<html>
	<head>
	</head>
	<body><?
	
	$password_ori = "hola";

	$serverpassword = strtolower(md5($password_ori.$numero));
	$clientpassword = strtolower($password);

	if ($serverpassword==$clientpassword)
		{
		print "<p>Correcto!";
		}
	else
		{
		print "<p>Acceso denegado!";
		}?>
	</body>
	</html><?
	}?>