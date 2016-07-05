<?php
if (ApartadoActivo('poblacio')) //Secció Portada
	{?>
	<script type="text/javascript">
	function mostraesdeveniments()
		{		
		var numerorows = document.getElementById('numerodefiles').innerHTML;
		
		if (numerorows > 0) //si hi ha un resultat
			{
			document.getElementById('titledestacatsportada').innerHTML = 'Destaquem les teves propostes | <span id="titledestacats">llistant '+numerorows+' propostes...</span>';
			new Effect.Shake('titledestacats');
			contador = numerorows-1;
			setTimeout("Effect.BlindDown('entrada"+contador+"')", 0);
			setTimeout("ShowImage('myimage"+contador+"')", 2000);
			if (numerorows > 1) //si hi han dos resultats
				{
				entrada = contador-1;
				setTimeout("Effect.SlideDown('entrada"+entrada+"')", 5000);
				setTimeout("ShowImage('myimage"+entrada+"')", 7000);
				if (numerorows > 2) //si hi han tres resultats
					{
					entrada2 = contador-2;
					setTimeout("Effect.SlideDown('entrada"+entrada2+"')", 10000);
					setTimeout("ShowImage('myimage"+entrada2+"')", 12000);
					if (numerorows > 3) //a partir de cuatre resultats...
						{
						entra = entrada2-1;
						
						temps1 = 15000;
						temps2 = 15000;
						temps3 = 17000;
						
						while (entra >= 0)
							{
							setTimeout("Effect.SlideDown('entrada"+entra+"');", temps1);
							setTimeout("DropOutEffect('entrada"+contador+"')", temps2);
							setTimeout("ShowImage('myimage"+entra+"')", temps3);
							
							temps1 = temps1+5000;
							temps2 = temps2+5000;
							temps3 = temps3+5000;
							entra = entra-1;
							contador = contador-1;
							}
						}
					}
				}
			}
		}
	</script>
	<div id="content">
		<h3 class="title" id="titledestacatsportada">Destaquem les teves propostes</h3>
		<div id="txtEsdevenimentHint">
			<h3>Has de seleccionar una comarca!</h3>
		</div>
	</div>
	
	<div id="sidebar">
		<ul>
			<li>
				<h3>L'agenda de població i comarca</h3>
			</li>
			<?php //si no està creada la sessió ens mostrarà una pantalla de benvinguda.
			if (!isset($_SESSION['userlogued']['nom']) && !isset($_SESSION['userlogued']['cognoms']))
			{?>
			<div id="benvinguda" style="display: none;">
				<h2>Hola!</h2>
				<p><b id="pbenvingut">Benvingut a Mercat Català.cat</b><br>
				Prova a seleccionar la teva comarca o concreta indicant la població i veuràs
				els esdeveniments de la teva zona! (logueja't per a que aquest cuadre no surti al refrescar la pàgina)
				<a onClick="new Effect.Fade('benvinguda'); new Effect.BlindUp('benvinguda', {duration:0.2});">tanca...</a></p>
			</div><?php
			}?>
			<div id="capscalen">
				<li>
					<img id="imgcat" src="estils/images/mapcat.png" />
					<b id="titolcerca">ALGUN PLAN PER AVUI?<br>
					<a href="portada.php?portada=agenda">busca'l i comenta-ho!</a></b>
					
					<form action="portada.php?portada=poblacio" method="post" id="cercaesdeveniments_portada">
						<select id="comarcaportada" name="comarcaportada" onchange="showPoblacionsPortada(this.value);"><?php
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
						</select><br>
						<span id="txtHint">
							<select disabled="disabled" id="poblacioportada" name="poblacioportada">
								<option value="">Selecciona comarca...</option>
							</select>
						</span>
						<b id="infocercaportada">PROVA-HO!</b>
					</form>
				</li>
			</div>
			<li style="clear:both;">
				<ul>
					<li>Concert AC/DC. PAVELLÓ DE L'ESPLUGA DE FRANCOLÍ.</li>
					<li>Exposició Romana. MUSEU DE LA VIDA RURAL A L'ESPLUGA DE FRANCOLÍ.</li>
					<li>Sopar popular. A LA PLAÇA DEL CASAL DE L'ESPLUGA DE FRANCOLÍ.</li>
				</ul>
			</li>
		</ul>
	</div>
	<div style="clear: both;">&nbsp;</div>
	<?php
	}//FI Secció Portada
?>