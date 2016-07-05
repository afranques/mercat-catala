<?php
$connection = mysql_connect("localhost", "root", "");
mysql_select_db("agenda");
$selectpropostes = 'SELECT u.name_user,u.cognoms,p.data_insert,p.contingut FROM users u, propostes p WHERE p.usuari=u.email and 
p.id_esdeveniment=\''.trim($_GET['fitxa_id']).'\' and p.id_modificacio=\''.trim($_GET['proposta']).'\'';
$querypropostes = mysql_query($selectpropostes);
mysql_close($connection);
if(mysql_num_rows($querypropostes)!=0)
	{?>
	<div id="sidebarfitxa">
		<ul id="sidebarfitxaul">
			<li id="sidebarfitxali"><?php
			$row = mysql_fetch_assoc($querypropostes);
			echo '<h3>Proposta de modificació de l\'usuari: <i><u>'.$row['name_user'].' '.$row['cognoms'].'</u></i></h3>';?>
			</li>
			<div id="contingutfitxa"><?php
				echo '<a class="fitxaorigen" href="portada.php?portada=agenda&fitxa_id='.$_GET['fitxa_id'].'">Tornar a la fitxa d\'origen</a> | '.$row['data_insert'].'
				<div id="fitxaproposta">'.html_entity_decode($row['contingut']).'</div>';?>
			</div>
		</ul>
	</div>
	<div id="comentarisfitxa">
		<ul><?php
			//votacions i denuncies
			$connection = mysql_connect("localhost", "root", "");
			mysql_select_db("agenda");
			$selectdenuncies = 'SELECT id_denuncia FROM denuncies WHERE id_esdeveniment=\''.trim($_GET['fitxa_id']).'\' and id_modificacio=\''.trim($_GET['proposta']).'\' 
			and usuari=\''.$_SESSION['userlogued']['correu'].'\'';
			$querydenuncies = mysql_query($selectdenuncies);
			$comptadenuncies = 'SELECT count(id_denuncia)-1 as ndenuncies FROM denuncies WHERE id_esdeveniment=\''.trim($_GET['fitxa_id']).'\' and id_modificacio=\''.trim($_GET['proposta']).'\'';
			$querycomptadenuncies = mysql_query($comptadenuncies);
			$numerodenuncies = mysql_fetch_assoc($querycomptadenuncies);
			$denunciestotal = $numerodenuncies['ndenuncies']+1;
			
			$selectvotspositius = 'SELECT id_votpositiu FROM votspositius WHERE id_esdeveniment=\''.trim($_GET['fitxa_id']).'\' and id_modificacio=\''.trim($_GET['proposta']).'\' 
			and usuari=\''.$_SESSION['userlogued']['correu'].'\'';
			$queryvotspositius = mysql_query($selectvotspositius);
			$comptavotspositius = 'SELECT count(id_votpositiu)-1 as nvotspositius FROM votspositius WHERE id_esdeveniment=\''.trim($_GET['fitxa_id']).'\' and id_modificacio=\''.trim($_GET['proposta']).'\'';
			$querycomptavotspositius = mysql_query($comptavotspositius);
			$numerovotspositius = mysql_fetch_assoc($querycomptavotspositius);
			$votstotal = $numerovotspositius['nvotspositius']+1;
			mysql_close($connection);
			
			if(mysql_num_rows($querydenuncies)!=0)
				{
				echo '<li><p><br><b>Tu i '.$numerodenuncies['ndenuncies'].' més</b> heu denunciat aquest comentari';
				if($votstotal>0) echo'<br><b>'.$votstotal.'</b> l\'han votat<br>&nbsp;</p></li>';
				else echo '<br>&nbsp;</p></li>';
				}
			elseif(mysql_num_rows($queryvotspositius)!=0)
				{
				echo '<li><p><br><b>Tu i '.$numerovotspositius['nvotspositius'].' més</b> heu votat aquest comentari';
				if($denunciestotal>0) echo'<br><b>'.$denunciestotal.'</b> l\'han denunciat<br>&nbsp;</p></li>';
				else echo '<br>&nbsp;</p></li>';
				}
			else
				{
				echo '<li><p><a href="portada.php?portada=agenda&fitxa_id='.$_GET['fitxa_id'].'&proposta='.$_GET['proposta'].'&denuncia=true">Denunciar aquest comentari</a>';
				if($denunciestotal>0) echo ' ('.$denunciestotal.' més ho han fet)';
				echo '<br><a href="portada.php?portada=agenda&fitxa_id='.$_GET['fitxa_id'].'&proposta='.$_GET['proposta'].'&okproposta=true">Voto a favor!</a>';
				if($votstotal>0) echo ' ('.$votstotal.' persones més ho han fet)';
				echo '</p></li>';
				}
			//FI votacions i denuncies?>
		</ul>
	</div>
	<div style="clear: both;">&nbsp;</div><?php
	}
else echo 'No s\'ha trobat cap proposta per aquest esdeveniment...';
?>