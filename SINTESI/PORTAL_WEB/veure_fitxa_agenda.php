<?php
if (mysql_num_rows($esdeveniment)!=0)
	{
	//scripts per a editar la fitxa
	if (isset($_SESSION['userlogued']['nom']) && isset($_SESSION['userlogued']['cognoms']))
		{?>
		<script src="nicEdit/nicEdit.js" type="text/javascript"></script>
		<script src="nicEdit/configuracio_nicEdit.js" type="text/javascript"></script><?php
		}
	//FI scripts per a editar la fitxa ?>
	
	<div id="sidebarfitxa">
		<ul id="sidebarfitxaul">
			<li id="sidebarfitxali">
				<h3>Contingut de la fitxa</h3>
			</li>
			<div id="contingutfitxa">
				<?php echo '<a class="resultatsorigen" href="portada.php?portada=agenda'.$_SESSION['paramscerca'].'">Tornar als resultats</a>'; ?>
				<!--###--CONTINGUT DE LA FITXA EDITABLE--######-->
				<div id="myArea2"><?php
					$row = mysql_fetch_assoc($esdeveniment);
					//------------------------------------------//
					echo '<b>Tipus Acte: </b><u>'.$row['tipus_acte'].'</u>';
					//------------------------------------------//
					echo '<h4><big>'.$row['titol_activitat'].'</big></h4>';
					//------------------------------------------//
					if($row['descripcio'] != 'descripcio was not found')
						{
						echo '<b>Descripcio de l\'activitat:</b><br><big><i>'.$row['descripcio'].'</i></big><br><br>';
						}
					//------------------------------------------//
					echo '<b>Dates:</b><hr>'.$row['dates'].'<br>';
					//------------------------------------------//
					if($row['horari'] != 'horari was not found')
						{
						echo '<b>Horari:</b><hr>'.$row['horari'].'<br>';
						}
					//------------------------------------------//
					echo '<br><b>Llocs de celebració:</b><hr>'.$row['llocs_celebracio'];
					//------------------------------------------(HAS DE REVISAR AIXÒ!!!!!!!)//
					if($row['entitat_organitzadora'] != 'entitat was not found')
						{
						echo '<br><b>Entitat organitzadora:</b><hr>'.htmlentities($row['entitat_organitzadora']).'<br><br>';
						}
					//------------------------------------------//
					if($row['mesinfo'] != 'mes info was not found')
						{
						echo '<b>Més informació:</b><hr>'.$row['mesinfo'].'<br>';
						}
					//------------------------------------------//?>
				</div>
				<!--###--CONTINGUT DE LA FITXA EDITABLE--######-->
				
				<h4>Necessitem que ens ajudis si has trobat algun error!</h4>				
				<?php
				//botons per a editar la fitxa
				if (isset($_SESSION['userlogued']['nom']) && isset($_SESSION['userlogued']['cognoms']))
					{?>
					<!--###--MODIFICACIÓ QUE PASSAREM PER POST--###-->
					<form name="modificacions_fitxa" method="post">
						<input name="valor_modificacio" type="hidden" id="p1" value="" readonly>
						<input type="button" id="addeditor" onClick="addArea2();" value="Alguna modificació <?php echo $_SESSION['userlogued']['nom'];?>?">
						<input type="button" id="removeeditor" disabled onClick="removeArea2();" value="Proposa els teus canvis!">
						<input type="button" id="canceleditor" style="display: none;" onClick="window.location='portada.php?portada=agenda&fitxa_id=<?php echo $_GET['fitxa_id'];?>';" value="OOups, CANCELA!">
					</form>
					<!--###--MODIFICACIÓ QUE PASSAREM PER POST--###--><?php
					}
				//FI botons per a editar la fitxa?>
			</div>
		</ul>
	</div>
	
	<?php
	//Inserint la modificació a la BD
	if (isset($_SESSION['userlogued']['correu']) && isset($_POST['valor_modificacio']))
		{
		$ara = getdate();
		$dia_ara = $ara['mday'];
		$mesos_cat = array(0=>"de Gener",1=>"de Febrer",2=>"de Març",3=>"d'Abril",4=>"de Maig",5=>"de Juny",6=>"de Juliol",7=>"d'Agost",
		8=>"de Setembre",9=>"d'Octubre",10=>"de Novembre",11=>"de Desembre");
		$mes_ara = $mesos_cat[$ara['mon']-1];
		$hora_ara = $ara['hours'];
		$minuts_ara = $ara['minutes'];
		if ($minuts_ara < 10) $minuts_ara = '0'.$minuts_ara;
		
		$connection = mysql_connect("localhost", "root", "");
		mysql_select_db("agenda");
		$insert = 'INSERT INTO propostes (id_esdeveniment, usuari, data_insert, contingut) 
		VALUES (\''.trim($_GET['fitxa_id']).'\', \''.$_SESSION['userlogued']['correu'].'\', \''.$dia_ara.' '.$mes_ara.' a les '.$hora_ara.':'.$minuts_ara.'\',
		"'.htmlentities(trim($_POST['valor_modificacio'])).'")';
		$insert_modificacio=mysql_query($insert) or die ('Ha fallat la query: '.$insert.'<br>Error: '.mysql_error());
		mysql_close($connection);
		}
	//FI Inserint la modificació a la BD
	
	//Llistat de modificacions de la fitxa
	$connection = mysql_connect("localhost", "root", "");
	mysql_select_db("agenda");
	$select = 'SELECT u.name_user,u.cognoms,p.id_modificacio,p.data_insert FROM users u, propostes p WHERE p.usuari=u.email and 
	p.id_esdeveniment=\''.trim($_GET['fitxa_id']).'\' order by p.id_modificacio';
	$select_modificacions = mysql_query($select);
	mysql_close($connection);?>
	<div id="comentarisfitxa"><?php
		if (mysql_num_rows($select_modificacions)!=0)
			{
			echo '<ul>';
			while($row = mysql_fetch_assoc($select_modificacions))
				{
				echo '<li><p><b>'.$row['name_user'].' '.$row['cognoms'].'</b><br>
				Proposa una modificació, '.$row['data_insert'].'<br>
				<a style="color: #FFFFFF;" href="portada.php?portada=agenda&fitxa_id='.$_GET['fitxa_id'].'&proposta='.$row['id_modificacio'].'">
				vull veure-la!</a></p></li>';
				}
			echo '</ul>';
			}
		elseif(mysql_num_rows($select_modificacions)==0 && isset($_SESSION['userlogued']))
			{
			echo '<ul><li><p><big>tu pots ser el primer en comentar o modificar aquest esdeveniment.</big></p></li></ul>';
			}
		elseif(mysql_num_rows($select_modificacions)==0 && !isset($_SESSION['userlogued']))
			{
			echo '<ul><li><p><big>tu pots ser el primer en <a href="portada.php?portada=login">comentar o modificar aquest esdeveniment.</big></p></p></li></ul>';
			}?>
	</div>
	<div style="clear: both;">&nbsp;</div><?php
	//FI Llistat de modificacions de la fitxa
	}
else
	{
	echo "no s'ha trobat cap esdeveniment amb aquest id de fitxa";
	}
?>