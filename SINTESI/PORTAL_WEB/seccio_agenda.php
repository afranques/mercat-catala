<?php
if (ApartadoActivo('agenda')) //Secció Agenda
	{
	/*CERCA SIMPLE======================================================*/
	if (isset($_GET['cerca']) && $_GET['cerca']=='simple')
		{
		include("cerca_simple_agenda.php");
		}
	/*FI CERCA SIMPLE===================================================*/
	
	/*CERCA AVANÇADA====================================================*/
	else if (isset($_GET['cerca']) && $_GET['cerca']=='avan')
		{
		include("cerca_avan_agenda.php");
		}
	/*FI CERCA AVANÇADA=================================================*/
	
	/*INFO FITXA========================================================*/
	else if(isset($_GET['fitxa_id']))
		{
		//selecciona tot el contingut de la fitxa
		$connection = mysql_connect("localhost", "root", "");
		mysql_select_db("agenda");
		$esdeveniment=mysql_query("SELECT * FROM esdeveniment WHERE id_esdeveniment=".$_GET['fitxa_id']);
		mysql_close($connection);
		//FI selecciona tot el contingut de la fitxa
		
		if(mysql_num_rows($esdeveniment)!=0 && isset($_GET['fitxa_id']) && isset($_GET['proposta']))
			{//en cas que volem veure una proposta...
			include("veure_proposta_agenda.php");
			}//FI en cas que volem veure una proposta...
		else
			{//en cas que volem veure la fitxa...
			include("veure_fitxa_agenda.php");
			}//FI en cas que volem veure la fitxa...
		}
	/*FI INFO FITXA=====================================================*/
	
	/*FORMULARIS DE CERCA===============================================*/
	else
		{?>
		<div id="sidebar">
		<ul>
			<li>
				<h3>L'agenda de població i comarca</h3>
			</li>
			<div id="capscalen">
				<li>
					<img id="imgcalendari" src="estils/images/calendari.jpg" style="width: 50%;"/>
					<b id="titolcalendari">ALGUN PLAN PER AVUI?<br>
					<a href="portada.php?portada=agenda">busca'l i comenta-ho!</a></b>
				</li>
			</div>
		</ul>
		</div>
		
		<div id="content">
			<h3 class="title">Destaquem les teves propostes</h3>
			<!--###--FORMULARI CERCA SIMPLE--#####-->
			<h4>Cerca simple:</h4>
			<form action="portada.php?portada=agenda" method="post" class="cercasimple">
				<input type="text" name="cercasimple"><br>
				<b>OBLIGATORI PER AQUESTA CERCA.</b> Paraula/es del nom o la descripció de l'activitat<br>
				Exemples: Festival del Mil·lenni, sardanes, concert...
				<input type="submit" value="Cercar" name="submitcercasimple">
			</form>
			<!--###--FORMULARI CERCA SIMPLE--#####-->

			<!--###--FORMULARI CERCA AVANÇADA--###-->
			<hr><h4>Cerca avançada:</h4>	
			<form action="portada.php?portada=agenda" method="post" class="cercaavan">
				Paraula/es clau de l'activitat<br>
				<input type="text" name="clauactivitat"><br><br>
				<input type="radio" name="dataesdeveniment" value="dataentre" checked>
				Data - entre <input type="text" name="datainici"> i 
				<input type="text" name="datafi"> AAAA/MM/DD<br>
				<!--<input type="radio" name="dataesdeveniment" value="avuiidema">
				 Avui i demà<br>
				<input type="radio" name="dataesdeveniment" value="nextweekend">
				 El cap de setmana vinent--><br><br>
				Cercar per tipus d'acte<br>
				<select name="tipusacte">
					<option value=""></option>
					<option VALUE="0">Altres</option>
					<option VALUE="1">Altres accions escèniques</option>
					<option VALUE="2">Aplecs i ballades</option>
					<option VALUE="3">Cicles musicals</option>
					<option VALUE="4">Concerts</option>
					<option VALUE="5">Conferències, xerrades i tertúlies</option>
					<option VALUE="6">Cursos, tallers i seminaris</option>
					<option VALUE="7">Espectacles</option>
					<option VALUE="8">Exhibició castellera</option>
					<option VALUE="9">Exposicions i instal·lacions</option>
					<option VALUE="10">Festes</option>
					<option VALUE="11">Festivals i mostres d’arts escèniques i de carrer</option>
					<option VALUE="12">Festivals i mostres de cinema i vídeo</option>
					<option VALUE="13">Festivals musicals</option>
					<option VALUE="14">Festivals pluridisciplinaris</option>
					<option VALUE="15">Fires i salons</option>
					<option VALUE="16">Jornades i congressos</option>
					<option VALUE="17">Narracions, lectures i recitals</option>
					<option VALUE="18">Parcs infantils i juvenils</option>
					<option VALUE="19">Performances</option>
					<option VALUE="20">Portes obertes</option>
					<option VALUE="21">Presentacions</option>
					<option VALUE="22">Projeccions</option>
					<option VALUE="23">Rutes i itineraris</option>
					<option VALUE="24">Taules rodones i debats</option>
					<option VALUE="25">Trobades</option>
					<option VALUE="26">Visites</option>
				</select><br><br>
				Comarca-Població<br>
				<select name="comarca" onchange="showPoblacions(this.value)"><?php
					$connection = mysql_connect("localhost", "root", "");
					mysql_select_db("agenda");
					$consulta=mysql_query("SELECT * FROM comarques order by id_comarca");
					mysql_close($connection);
					
					echo "<option value=''>tria...</option>";
					while($row=mysql_fetch_assoc($consulta))
						{
						echo "<option value='".$row['id_comarca']."'>".$row['nom_comarca']."</option>";
						}
					echo "</select>";?>
				</select>
				<span id="txtHint">
					<select disabled="disabled" name="poblacio">
						<option value="">Selecciona comarca...</option>
					</select>
				</span>
				<input type="submit" value="Cercar" name="submitcercaavan"> 
				<input type="submit" value="Buidar">
			</form>
			<!--###--FORMULARI CERCA AVANÇADA--###-->
		</div>
		<div style="clear: both;">&nbsp;</div><?php
		}
	/*FI FORMULARIS DE CERCA============================================*/
	}//FI Secció Agenda
?>