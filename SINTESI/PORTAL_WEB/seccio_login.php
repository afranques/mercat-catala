<?php
if (ApartadoActivo('login')) //Secció login
	{
	if (isset($_SESSION['userlogued']['nom']) && isset($_SESSION['userlogued']['cognoms'])) //si estan loguejats
		{?>
		<script type="text/javascript">
		function redireccionar(){window.location="portada.php?portada=poblacio";}  
		setTimeout("redireccionar()", 10000); //temps expresat en milisegons 
		</script>
		<h2>OOupps!!</h2><h3><a href="#" onclick="redireccionar()">Has caigut aquí per equivocació?</a></h3>
		<h3><a href="portada.php?logout=true">Sortir de la sessió actual o efectuar el registre per a un usuari nou.</a></h3><?php
		}
	else //si no estan loguejats
		{
		/*FORMULARI LOGIN PAGINA LOGIN======================================*/?>
		<div id="formulari_login">
			<ul>
				<li>
				<h3>Identifica't amb les teves dades</h3>
				</li>
				<li class="titolcamp"><?php
					if (!isset($_GET['mail_attempt']) && !isset($_GET['login_attempt'])) echo '<br><p><b id="lemalogin">Entrar a Mercat Català</b></p><p>
					&nbsp;<br><br>
					¿T\'has oblidat de la teva contrasenya? <a href="portada.php?portada=login&reset=pwd">Demana\'n una de nova.</a></p>';
					
					if (isset($_GET['mail_attempt'])) echo '<p><big>No hem trobat cap correu que correspongui amb el que ens indiques.</big></p><p>
					L\'adreça de correu no ha sigut trobada. Siusplau, assegura\'t de que el bloqueig de Majúscules no està activat i intenta-ho novament.<br><br>
					¿T\'has oblidat de la teva contrasenya? <a href="portada.php?portada=login&reset=pwd">Demana\'n una de nova.</a></p>';
					
					if (isset($_GET['login_attempt'])) echo '<p><big>Siusplau, torna a introduïr la teva contrasenya.</big></p><p>
					La contraseña no es vàlida. Siusplau, assegura\'t de que el bloqueig de Majúscules no està activat i intenta-ho novament.<br><br>
					¿T\'has oblidat de la teva contrasenya? <a href="portada.php?portada=login&reset=pwd">Demana\'n una de nova.</a></p>';?>
					
					<form action="portada.php?portada=login" method="post" name="loginusers2" id="loginusers2">
						<p><input type="text" name="loginuser2" id="loginuser2" onFocus="buidacorreu2();" onBlur="omplecorreu2()" value="correu electrònic"><br>
						<input type="text" name="loginpwd2" id="loginpwd2" onFocus="buidapwd2();" onBlur="omplepwd2()" value="contrasenya">
						<input type="hidden" readonly name="pwd_user21" id="pwd_user21" size="40">
						<input type="button" id="submitlogin2" name="submitlogin2" value="Entrar" onclick="shownumber2(document.getElementById('loginuser2').value);"></p>		
					</form>
					<input type="hidden" readonly name="numero_user2" id="numero_user2" size="40">
					<input type="hidden" readonly name="pwd_user22" id="pwd_user22" size="40">
				</li>
				<li class="titolregistre">
				<p><p class="lemaregistra"><b>Mercat Català</b> et posa al dia de tots els esdeveniments catalans i t'ajuda a que els comparteixis amb els teus amics.</p></p>
				<p><p class="lemaregistra"><a href="portada.php?portada=registre" class="linkregistra"><input type="button" class="entraregistre" value="Registra't!" onclick=""></a></p></p>
				</li>
			</ul>
			
		</div>
		<div style="clear: both;">&nbsp;</div><?php
		/*FI FORMULARI LOGIN PAGINA LOGIN===================================*/
		}//FI si no estan loguejats
	}//FI Secció login
?>