<?php

/*======================================================================*\
	Objectiu:	Denunciar un comentari.
\*======================================================================*/

if(isset($_GET['fitxa_id']) && isset($_GET['proposta']) && isset($_GET['denuncia']))
	{
	if (isset($_SESSION['userlogued']['nom']) && isset($_SESSION['userlogued']['cognoms']))
		{
		$connection = mysql_connect("localhost", "root", "");
		mysql_select_db("agenda");
		$selectdenuncies = 'SELECT id_denuncia FROM denuncies WHERE id_esdeveniment=\''.trim($_GET['fitxa_id']).'\' and id_modificacio=\''.trim($_GET['proposta']).'\' 
		and usuari=\''.$_SESSION['userlogued']['correu'].'\'';
		$querydenuncies = mysql_query($selectdenuncies);
		if (mysql_num_rows($querydenuncies)>0) header('Location:portada.php?portada=agenda&fitxa_id='.$_GET['fitxa_id'].'&proposta='.$_GET['proposta'].'');
		else
			{
			$insertdenuncia= 'INSERT INTO denuncies (id_esdeveniment,id_modificacio,usuari) VALUES(\''.$_GET['fitxa_id'].'\', \''.$_GET['proposta'].'\', \''.$_SESSION['userlogued']['correu'].'\')';
			$querydenuncia = mysql_query($insertdenuncia);
			}
		mysql_close($connection);
		}
	else header('Location:portada.php?portada=login');
	}
	
/*======================================================================*\
	Objectiu:	Votar un comentari.
\*======================================================================*/

if(isset($_GET['fitxa_id']) && isset($_GET['proposta']) && isset($_GET['okproposta']))
	{
	if (isset($_SESSION['userlogued']['nom']) && isset($_SESSION['userlogued']['cognoms']))
		{
		$connection = mysql_connect("localhost", "root", "");
		mysql_select_db("agenda");
		$selectvotspositius = 'SELECT id_votpositiu FROM votspositius WHERE id_esdeveniment=\''.trim($_GET['fitxa_id']).'\' and id_modificacio=\''.trim($_GET['proposta']).'\' 
		and usuari=\''.$_SESSION['userlogued']['correu'].'\'';
		$queryvotspositius = mysql_query($selectvotspositius);
		if (mysql_num_rows($queryvotspositius)>0) header('Location:portada.php?portada=agenda&fitxa_id='.$_GET['fitxa_id'].'&proposta='.$_GET['proposta'].'');
		else
			{
			$insertdenuncia= 'INSERT INTO votspositius (id_esdeveniment,id_modificacio,usuari) VALUES(\''.$_GET['fitxa_id'].'\', \''.$_GET['proposta'].'\', \''.$_SESSION['userlogued']['correu'].'\')';
			$querydenuncia = mysql_query($insertdenuncia);
			}
		mysql_close($connection);
		}
	else header('Location:portada.php?portada=login');
	}

/*======================================================================*\
	Objectiu:	Proporcionar informació sobre l'esdeveniment registre.
\*======================================================================*/

if (isset($_POST['submitregistre']))
	{
	$connection = mysql_connect("localhost", "root", "");
	mysql_select_db("agenda");
	$consulta= "INSERT INTO users (name_user,cognoms,email,sexe,data_neixement,numero,contrasenya) VALUES(\"".$_POST['nomuser']."\", \"".$_POST['cognomuser']."\", 
	\"".$_POST['emailuser']."\", \"".$_POST['sexeuser']."\", \"".$_POST['dataneix']."\", 
	\"".$_POST['hashnumero2']."\", \"".$_POST['contrasenya_user']."\")";
	$resultat_insert = mysql_query($consulta);
	mysql_close($connection);
	if($resultat_insert == true) //si el registre ha anat bé es posa l'user en sessió.
		{
		$_SESSION['userlogued']['nom']=$_POST['nomuser'];
		$_SESSION['userlogued']['cognoms']=$_POST['cognomuser'];
		$_SESSION['userlogued']['correu']=$_POST['emailuser'];
		header('Location:portada.php?portada=poblacio');
		}
	}

/*======================================================================*\
	Objectiu:	Destruir la sessió del usuari loguejat
\*======================================================================*/

if (isset($_GET['logout']) && $_GET['logout'] == 'true')
	{
	if (isset($_SESSION['userlogued']['nom']) && isset($_SESSION['userlogued']['cognoms']))
		{
		session_destroy();
		header('Location:portada.php?portada=poblacio');
		}
	}
	
/*======================================================================*\
	Funció:		MenuActivo (es per tema de CSS)
	Objectiu:	En el menú de navegació, comprova l'apartat	en que ens 
				trobem i el marca com a actiu.
\*======================================================================*/

function MenuActivo($apartado)
	{
	if (isset($_GET['portada']) && $_GET['portada']==$apartado)
		{
		echo 'class="current_page_item"';
		}
	if (!isset($_GET['portada']) && $apartado=='poblacio')
		{
		echo 'class="current_page_item"';
		}
	}
	
/*======================================================================*\
	Funció:		ApartadoActivo
	Objectiu:	Determina el contingut a mostrar segons l'apartat
				en que es troba.
\*======================================================================*/
	
function ApartadoActivo($apartado)
	{
	if (isset($_GET['portada']) && $_GET['portada']==$apartado)
		{
		return true;
		}
	if (!isset($_GET['portada']) && $apartado=='poblacio')
		{
		return true;
		}
	}
	
/*======================================================================*\
	Objectiu:	Agafa la contrasenya que l'hi passen per POST i la
				comprova amb la de la BD, si és correcte es crea una
				sessió amb el nom i els cognoms.
\*======================================================================*/

//login barra menús
if (ApartadoActivo('login') && isset($_POST['loginuser']) && isset($_POST['loginpwd']))
	{
	$connection = mysql_connect("localhost", "root", "");
	mysql_select_db("agenda");
	$consulta=mysql_query("SELECT name_user,cognoms,email,contrasenya FROM users WHERE email=\"".$_POST['loginuser']."\"");
	mysql_close($connection);

	if (mysql_num_rows($consulta)!=0)
		{
		$row=mysql_fetch_assoc($consulta);
		if (trim($_POST['pwd_user']) == trim($row['contrasenya']))
			{
			$_SESSION['userlogued']['nom']=$row['name_user'];
			$_SESSION['userlogued']['cognoms']=$row['cognoms'];
			$_SESSION['userlogued']['correu']=$row['email'];
			header('Location:portada.php?portada=poblacio');
			}
		else
			{
			header('Location:portada.php?portada=login&login_attempt=failed');
			}
		}
	else header('Location:portada.php?portada=login&mail_attempt=failed');
	}
//FI login barra menús

//login pàgina login
if (ApartadoActivo('login') && isset($_POST['loginuser2']) && isset($_POST['loginpwd2']))
	{
	$connection = mysql_connect("localhost", "root", "");
	mysql_select_db("agenda");
	$consulta=mysql_query("SELECT name_user,cognoms,email,contrasenya FROM users WHERE email=\"".$_POST['loginuser2']."\"");
	mysql_close($connection);

	if (mysql_num_rows($consulta)!=0)
		{
		$row=mysql_fetch_assoc($consulta);
		if (trim($_POST['pwd_user21']) == trim($row['contrasenya']))
			{
			$_SESSION['userlogued']['nom']=$row['name_user'];
			$_SESSION['userlogued']['cognoms']=$row['cognoms'];
			$_SESSION['userlogued']['correu']=$row['email'];
			header('Location:portada.php?portada=poblacio');
			}
		else
			{
			header('Location:portada.php?portada=login&login_attempt=failed');
			}
		}
	else header('Location:portada.php?portada=login&mail_attempt=failed');
	}
//FI login pàgina login
	
/*======================================================================*\
	Funció:		logincorrecte
	Objectiu:	Indicar que ha fallat en el login.
\*======================================================================*/

function logincorrecte()
	{
	if (ApartadoActivo('login') && isset($_GET['login_attempt']))
		{
		echo 'contrasenya no vàlida';
		}
	else if (ApartadoActivo('login') && isset($_GET['mail_attempt']))
		{
		echo 'adreça de correu no vàlida';
		}
	}

/*======================================================================*\
	Funció:		ComprovaCercaSimple
	Objectiu:	Si han clicat el submit de cerca simple, comprova que
				el camp no sigui buit. (S'HA DE FER AMB JAVASCRIPT!!)
\*======================================================================*/

function ComprovaCercaSimple()
	{
	if (isset($_POST['submitcercasimple']))
		{
		$_SESSION['paramscerca'] = '';
		$cercasimple=htmlentities($_POST['cercasimple']);
		$parametres='&cerca=simple';
		if ($cercasimple!='') $parametres=$parametres."&clau=$cercasimple";
		$_SESSION['paramscerca'] = $parametres;
		return $parametres;
		}
	return false;
	}				
	
/*======================================================================*\
	Funció:		ComprovaCercaAvan
	Objectiu:	Passar els paràmetres de la cerca per GET però tant
				sols aquells que no estiguin buits.
\*======================================================================*/

function ComprovaCercaAvan()
	{
	if (isset($_POST['submitcercaavan']))
		{
		$_SESSION['paramscerca'] = '';
		$clauactivitat=htmlentities($_POST['clauactivitat']);
		$tipusacte=htmlentities($_POST['tipusacte']);
		$dataesdeveniment=htmlentities($_POST['dataesdeveniment']);
		$datainici=htmlentities($_POST['datainici']);
		$datafi=htmlentities($_POST['datafi']);
		$comarca=htmlentities($_POST['comarca']);
		$poblacio=htmlentities($_POST['poblacio']);
		$lloc=htmlentities($_POST['lloc']);
		$parametres='&cerca=avan';
		if ($clauactivitat!='')	$parametres=$parametres."&clau=$clauactivitat";
		if ($tipusacte!='')	$parametres=$parametres."&acte=$tipusacte";
		if (($datainici!='' || $datafi!='') && $dataesdeveniment=='dataentre')
			{
			$parametres=$parametres."&data=entre&datainici=$datainici&datafi=$datafi";
			}
		/*if ($dataesdeveniment=='avuiidema')
			{
			$parametres=$parametres."&data=avuiidema";
			}
		if ($dataesdeveniment=='nextweekend')
			{
			$parametres=$parametres."&data=proxim";
			}*/
		if ($comarca!='') $parametres=$parametres."&comarca=$comarca";
		if ($poblacio!='') $parametres=$parametres."&poblacio=$poblacio";
		if ($lloc!='') $parametres=$parametres."&lloc=$lloc";
		$_SESSION['paramscerca'] = $parametres;
		return $parametres;
		}
	return false;
	}	

?>