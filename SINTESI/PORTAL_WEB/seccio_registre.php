<?php
if (ApartadoActivo('registre')) //Secció Registre
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
		/*REGISTRE D'USUARIS NOUS===========================================*/?>
		<div id="formulari_registre">
			<ul>
				<li>
					<h3>Uneix-te a MercatCatalà!</h3>
				</li>
				<li id="contingutregistre">
					<?php 
					if(isset($_POST['submitregistre']) && !$resultat_insert) //si el registre surt malament...
						{
						echo 'Hi ha agut un problema amb el registre (inserció).';
						}?>
					<!--###--FORMULARI REGISTRE--###-->
					<form id="registre" action="portada.php?portada=login" method="post" name="registre">
						<div class="field-label"><div class="titolcampregistre">Nom</div><div class="field-widget"><input type="text" name="nomuser" id="nomuser" size="30" class="required" title="Nom, OBLIGATORI."></div></div>
						<div class="field-label"><div class="titolcampregistre">Cognoms</div><div class="field-widget"><input type="text" name="cognomuser" id="cognomuser" size="30" class="required" title="Cognoms, OBLIGATORI."></div></div>
						<div class="field-label"><div class="titolcampregistre">Correu electrònic</div><div class="field-widget"><input type="text" name="emailuser" id="emailuser" size="30" class="required validate-email" title="Correu electrònic, OBLIGATORI."></div></div>
						<div class="field-label"><div class="titolcampregistre">Contrasenya</div><div class="field-widget"><input type="password" name="newPass1" id="newPass1" size="30" class="required validate-password" title="Contrasenya, OBLIGATORI."></div></div>
						<div class="field-label"><div class="titolcampregistre">Contrasenya2</div><div class="field-widget"><input type="password" name="newPass2" id="newPass2" size="30" class="required validate-password-confirm" title="Contrasenya2, OBLIGATORI."></div></div>
						<div class="field-label"><div class="titolcampregistre">Sexe</div><div class="field-widget">
							<select name="sexeuser" id="sexeuser" class="required" title="Sexe, OBLIGATORI.">
								<option value="">trii...
								<option value="home">Home
								<option value="dona">Dona
							</select>
						</div></div>
						<div class="field-label"><div class="titolcampregistre">Data de naixement</div><div class="field-widget">
							<select name="diauser" id="diauser" class="datesregistre" title="Data de naixement, OBLIGATORI.">
								<option value="">Dia:
								<option value="01">1
								<option value="02">2
								<option value="03">3
								<option value="04">4
								<option value="05">5
								<option value="06">6
								<option value="07">7
								<option value="08">8
								<option value="09">9
								<option value="10">10
								<option value="11">11
								<option value="12">12
								<option value="13">13
								<option value="14">14
								<option value="15">15
								<option value="16">16
								<option value="17">17
								<option value="18">18
								<option value="19">19
								<option value="20">20
								<option value="21">21
								<option value="22">22
								<option value="23">23
								<option value="24">24
								<option value="25">25
								<option value="26">26
								<option value="27">27
								<option value="28">28
								<option value="29">29
								<option value="30">30
								<option value="31">31
							</select>
							<select name="mesuser" id="mesuser" class="datesregistre" title="Data de naixement, OBLIGATORI.">
								<option value="">Mes:
								<option value="01">Gener
								<option value="02">Febrer
								<option value="03">Març
								<option value="04">Abril
								<option value="05">Maig
								<option value="06">Juny
								<option value="07">Juliol
								<option value="08">Agost
								<option value="09">Septembre
								<option value="10">Octubre
								<option value="11">Novembre
								<option value="12">Desembre
							</select>
							<input type="text" name="anyuser" id="anyuser" class="datesregistre" maxlength="4" size="5" title="Data de naixement, OBLIGATORI.">
							<input type="hidden" readonly name="dataneix" id="dataneix" class="required validate-date-au">
						</div></div>
						
						<script type="text/javascript">
						function submitnumero()
							{
							numero = Math.random()*1000;
							document.getElementById('hashnumero').value = numero;
							document.getElementById('hashnumero2').value = hex_md5(document.getElementById('hashnumero').value);
							document.getElementById('contrasenya_user').value = hex_md5(document.getElementById('hashnumero2').value+document.getElementById('hashcontrasenya').value);
							document.getElementById('newPass1').value = 'contrasenya';
							document.getElementById('newPass2').value = 'contrasenya';
							}

						function getdataneix()
							{
							var dataneixement = '';
							dataneixement = dataneixement+document.getElementById("diauser").value;
							dataneixement = dataneixement+'/'+document.getElementById("mesuser").value;
							dataneixement = dataneixement+'/'+document.getElementById("anyuser").value;
							document.getElementById("dataneix").value=dataneixement;
							}

						function formCallback(result, form) 
							{
							window.status = "valiation callback for form '" + form.id + "': result = " + result;
							}

						var valid = new Validation('registre', {immediate : true, onFormValidate : formCallback});
					
						Validation.addAllThese([
						['validate-password', 'La seva contrasenya ha de constar de més de 6 caràcters, ha de ser diferent que \'PASSWORD\' i també del seu nom!', {
							minLength : 7,
							notOneOf : ['password','PASSWORD','1234567','0123456'],
							notEqualToField : 'nomuser'
							}],
						['validate-password-confirm', 'La contrasenya de seguretat ha de contenir el mateix que l\'anterior, siusplau torni-ho a provar.', {
							equalToField : 'newPass1'
							}]
						]);
						</script>
						<input type="hidden" readonly name="hashnumero2" id="hashnumero2" size="40">
						<input type="hidden" readonly name="contrasenya_user" id="contrasenya_user" size="40">
						<div class="field-label"><div class="titolcampregistre">&nbsp;</div><div class="field-widget"><input type="submit" class="entraregistre" name="submitregistre" value="Registra't!" onclick="document.getElementById('hashcontrasenya').value = hex_md5(document.getElementById('newPass1').value); submitnumero(); getdataneix();"></div></div>
					</form>
					<input type="hidden" readonly name="hashnumero" id="hashnumero" size="40">
					<input type="hidden" readonly name="hashcontrasenya" id="hashcontrasenya" size="40"><br>
					<!--###--FORMULARI REGISTRE--###-->
				</li>
			</ul>
		</div>
		<div style="clear: both;">&nbsp;</div><?php
		/*FI REGISTRE D'USUARIS NOUS========================================*/
		}//FI si no estan loguejats
	}//FI Secció Registre
?>