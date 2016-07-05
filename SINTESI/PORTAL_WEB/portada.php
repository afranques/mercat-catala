<?php
session_start(); /*Iniciem sessió*/

include("funcions_portada.php");

//vigila que no entrin un valor buit!
if (ComprovaCercaSimple()) header('Location:portada.php?portada=agenda'.html_entity_decode(ComprovaCercaSimple()).'');
if (ComprovaCercaAvan()) header('Location:portada.php?portada=agenda'.html_entity_decode(ComprovaCercaAvan().''));

/*======================================================*/
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<script src="registre_users_validation/scriptaculous/lib/prototype.js" type="text/javascript"></script>
	<script src="registre_users_validation/validation.js" type="text/javascript"></script>
	<script src="registre_users_validation/scriptaculous/src/effects.js" type="text/javascript"></script>
	<link href="registre_users_validation/style.css" rel="stylesheet" type="text/css">
	<script src="MD5_scripts/md5-min.js" type="text/javascript"></script>
	<script src="MD5_scripts/sha1-min.js" type="text/javascript"></script>
	<script src="AJAX/llista_poblacions/showpoblacions.js" type="text/javascript"></script>
	<script src="AJAX/llista_portada/showpoblacions_portada.js" type="text/javascript"></script>
	<script src="AJAX/obtain_number/shownumber.js" type="text/javascript"></script>
	<script src="AJAX/obtain_number/shownumberlogin2.js" type="text/javascript"></script>
	<link href="estils/style.css" rel="stylesheet" type="text/css">
	<title>Mercat Català</title>
	<script type="text/javascript">
	function SlideDownEffect(element)
		{
		new Effect.SlideDown(element);
		}
	
	function DropOutEffect(element)
		{
		new Effect.DropOut(element, {duration:1});
		}

	function ShowImage(element)
		{
		new Effect.Appear(element,{duration:1});
		}
	</script>
</head>
<body onload="new Effect.BlindDown('benvinguda', {duration:0.2}); new Effect.Appear('benvinguda');">
<div id="wrapper">
	<!--**************--CAPÇALERA--*******************-->
	<div id="header">	
		<div id="logo">
			<h1><a href="portada.php?portada=poblacio"><img src="estils/images/logoportal.png" border="0"></a></h1>
			<p>estigues al dia!</p>
		</div>
		<!--###--LOGIN--######################-->
		<div id="search">
			<?php	//si està creada la sessió ens mostrarà el nom i cognoms del usuari loguejat.
			if (isset($_SESSION['userlogued']['nom']) && isset($_SESSION['userlogued']['cognoms']))
				{?>
				<p class="userloguejat"><b><?php echo $_SESSION['userlogued']['nom'].', '.$_SESSION['userlogued']['cognoms'];?></b><br>
				<?php echo $_SESSION['userlogued']['correu'];?>
				<a href="portada.php?logout=true">Sortir?</a></p><?php
				}
			else	//i sino ens mostrarà el formulari de login.
				{?>
				<script src="estils/infocamps.js" type="text/javascript"></script>
				<form action="portada.php?portada=login" method="post" name="loginusers" id="loginusers" class="campsloginportada">
					<a href="portada.php?portada=registre">Encara no ets mercatcatalà?</a><br />
					<input type="text" name="loginuser" id="loginuser" size="22" onFocus="buidacorreu();" onBlur="omplecorreu()" value="correu electrònic"><br />
					<input type="text" name="loginpwd" id="loginpwd" size="22" onFocus="buidapwd();" onBlur="omplepwd()" value="contrasenya">
					<input type="hidden" readonly name="pwd_user" id="pwd_user" size="40">
					<input type="button" id="submitlogin" name="submitlogin" value="Entrar" onclick="shownumber(document.getElementById('loginuser').value);">				
				</form>
					<input type="hidden" readonly name="numero_user" id="numero_user" size="40">
					<input type="hidden" readonly name="pwd_user2" id="pwd_user2" size="40"><?php
				}?>
			<div id="searchsimple">
				<span id="infosearchsimple">Busca per paraules o frases...</span>
				<form action="portada.php?portada=agenda" method="post" class="formsearchsimple">
					<input type="text" name="cercasimple" id="campcercasimpleportada">
					<input type="submit" value="Cercar" name="submitcercasimple" id="submitcercasimpleportada">
				</form>
		</div>
		</div>
		<!--###--LOGIN--######################-->
	</div>
	<!--**************--CAPÇALERA--*******************-->
	
	<!--**************--MENÚ DE NAVEGACIÓ--***********-->	
	<!--###--APARTATS--###################-->
	<div id="menu">
		<ul class="menu">
			<li><a <?php MenuActivo('poblacio'); ?> href="portada.php?portada=poblacio">POBLACIÓ</a></li>
			<li><a <?php MenuActivo('agenda'); ?> href="portada.php?portada=agenda">L'AGENDA</a></li>
			<li><a <?php MenuActivo('mercat'); ?> href="portada.php?portada=mercat">EL MERCAT</a></li>
		</ul>
	</div>
	<!--###--APARTATS--###################-->
	<!--**************--MENÚ DE NAVEGACIÓ--***********-->
	
	<!--**************--CONTINGUT VARIABLE--**********-->
	<div id="page">
	<div id="page-bgtop">
	<div id="page-bgbtm">
		<?php
		//Secció Portada
		include("seccio_portada.php");
		//FI Secció Portada?>

		<?php
		//Secció Agenda
		include("seccio_agenda.php");
		//FI Secció Agenda?>


		<?php
		//Secció Login
		include("seccio_login.php");
		//FI Secció Login?>
		
		<?php
		//Secció Registre
		include("seccio_registre.php");
		//FI Secció Registre?>
	</div>
	</div>
	</div>
	<!--**************--CONTINGUT VARIABLE--**********-->
</div>
<div id="footer">
	<p>footer</p>
</div>
</body>
</html>