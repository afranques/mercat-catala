<?php

include("snoopy.class.php"); //demanem la classe snoopy, encarregada d'obtenir una resposta del servidor.

function CorreFitxes($fitxa_id)
	{
	$snoopy = new Snoopy;
	//associem les dades:
	if($snoopy->fetchtext("http://cultura.gencat.cat/agenda/fitxa.asp?fitxa_id=$fitxa_id"))
		{ 
		// resposta a la petició http:
		if (stristr($snoopy->response_code, '404') == true || stristr($snoopy->response_code, 'Not Found') == true)
			{
			print "$fitxa_id Not Found!<br>";
			$archivo_buit = "fitxes_buides/$fitxa_id(buida).csv";
			$fp_buit = fopen($archivo_buit, "w");

			fwrite($fp_buit, "$fitxa_id no trobada") or die('fitxa id impossible d\'escriure!');
			fclose($fp_buit);
			}
		else
			{
			$mystring = file_get_contents('http://cultura.gencat.cat/agenda/fitxa.asp?fitxa_id='.$fitxa_id);
			
			$archivo = "fitxes/$fitxa_id.csv";
			$fp = fopen($archivo, "w");

			fwrite($fp, "$fitxa_id(saltdecamp)") or die('fitxa id impossible d\'escriure!');

			//àrea temàtica
			$tematica = '&Agrave;rea tem&agrave;tica:';
			$final_tematica = strpos($mystring, $tematica)+(strlen($tematica)+5);
			$final_tematica_br = strpos($mystring, '<br>', $final_tematica);

			//tipus d'acte
			$acte = "Tipus d'acte:";
			$final_acte = strpos($mystring, $acte)+(strlen($acte)+5);
			$final_acte_div = strpos($mystring, '</div>', $final_acte);

			//títol de l'activitat
			$titol = '<span class="titulo">';
			$final_titol = strpos($mystring, $titol, $final_acte)+(strlen($titol));
			$final_titol_span = strpos($mystring, '</span>', $final_titol);

			//descripció de l'activitat
			$descripcio = '<div style="width: 100%;" >';
			$final_descripcio = strpos($mystring, $descripcio, $final_titol_span)+(strlen($descripcio));
			$final_descripcio_div = strpos($mystring, '</div>', $final_descripcio);

			//data
			$dates = 'Dat';
			$final_dates = strpos($mystring, $dates, $final_descripcio_div)+(strlen($dates));
			$final_dates_div = strpos($mystring, '<div>', $final_dates)+(strlen('<div>'));
			$final_DeLaData = strpos($mystring, '</div>', $final_dates_div);


			#####################################
			#	Fins aquí es localitzen els		#
			#	trossos que hem d'agafar		#
			#	i els if's s'encarreguen de		#
			#	que si es troba ho agafin per	#
			#	posar-ho en variables.			#
			#####################################


			//if àrea temàtica	(NO S'UTILITZE)-----------------------------------------------------------
			if (strpos($mystring, $tematica) == false) echo "<hr>The string '$tematica' was not found in the string.";
			else 
				{
				echo "<hr><code>Posició: $final_tematica</code>";
				echo "<br><b>$tematica</b> ";
				$dada_tematica = substr($mystring, $final_tematica, ($final_tematica_br-$final_tematica));
				echo '<i>'.$dada_tematica.'</i>';
				}
				
			//if tipus d'acte	-----------------------------------------------------------
			if (strpos($mystring, $acte) == false)
				{
				echo "<hr>The string '$acte' was not found in the string.";
				fwrite($fp, "tipus d'acte was not found(saltdecamp)") or die('Tipus d\'acte impossible d\'escriure!');
				}
			else 
				{
				echo "<hr><code>Posició: $final_acte</code>";
				echo "<br><b>$acte</b> ";
				$dada_acte = substr($mystring, $final_acte, ($final_acte_div-$final_acte));
				echo '<i>'.$dada_acte.'</i>';
				$dada_acte = trim($dada_acte);
				
				$connection = mysql_connect('localhost', 'root', '') or die ('No se puede establecer conexión!');
				mysql_select_db('Agenda') or die ('No se puede seleccionar base de datos!');
				$query = "SELECT id_acte FROM tipus_actes WHERE tipus_acte='".$dada_acte."'";
				$result = mysql_query($query) or die ('Error en la consulta: $query. ' . mysql_error());;
				$row = mysql_fetch_assoc($result);
				fwrite($fp, $row['id_acte']."(saltdecamp)") or die('ID Tipus d\'acte impossible d\'escriure!');
				mysql_free_result($result);
				mysql_close($connection);
				
				fwrite($fp, "$dada_acte(saltdecamp)") or die('Tipus d\'acte impossible d\'escriure!');
				}
				
			//if títol de l'activitat	-----------------------------------------------------------
			if (strpos($mystring, $titol) == false)
				{
				echo "<hr>The string '$titol' was not found in the string.";
				fwrite($fp, "titol was not found(saltdecamp)") or die('titol impossible d\'escriure!');
				}
			else 
				{
				echo "<hr><code>Posició: $final_titol</code>";
				echo "<br><b>Títol de l'activitat:</b><br>";
				$dada_titol = substr($mystring, $final_titol, ($final_titol_span-$final_titol));
				echo '<i>'.$dada_titol.'</i>';
				$dada_titol = trim($dada_titol);
				$dada_titol = html_entity_decode($dada_titol);
				fwrite($fp, "$dada_titol(saltdecamp)") or die('titol impossible d\'escriure!');
				}
				
			//if descripció de l'activitat	-----------------------------------------------------------
			if (strpos($mystring, $descripcio, $final_titol_span) == false)
				{
				echo "<hr>Descripció was not found in the string.";
				fwrite($fp, "descripcio was not found(saltdecamp)") or die('descripcio impossible d\'escriure!');
				}
			else 
				{
				echo "<hr><code>Posició: $final_descripcio</code>";
				echo "<br><b>Descripció de l'activitat:</b><br>";
				$dada_descripcio = substr($mystring, $final_descripcio, ($final_descripcio_div-$final_descripcio));
				echo '<i>'.$dada_descripcio.'</i>';
				$dada_descripcio = trim($dada_descripcio);
				$dada_descripcio = html_entity_decode($dada_descripcio);
				fwrite($fp, "$dada_descripcio(saltdecamp)") or die('descripcio impossible d\'escriure!');
				}
				
			//if data-dates	-----------------------------------------------------------
			if (strpos($mystring, $dates) == false)
				{
				echo "<hr>Dat was not found in the string.";
				fwrite($fp, "data was not found(saltdecamp)") or die('data impossible d\'escriure!');
				}
			else
				{
				echo "<hr><code>Posició: $final_dates_div</code>";
				echo "<br><b>Data:</b><br>";
				$lesdates = substr($mystring, $final_dates_div, ($final_DeLaData-$final_dates_div));
				echo '<i>'.$lesdates.'</i>';
				$lesdates = trim($lesdates);
				
				$archivo_dates = "dates_celebracio/$fitxa_id.csv";
				$fp_dates = fopen($archivo_dates, "w");
				
				if (strpos($lesdates, 'Del ') !== false)
					{
					$datainici = substr($lesdates, strpos($lesdates, 'Del ')+4, 10);
					$array_datainici = explode('/', $datainici);
					$dia_mes = trim($array_datainici[0]);
					$mes = trim($array_datainici[1]);
					$any = trim($array_datainici[2]);
					fwrite($fp, $any.'-'.$mes.'-'.$dia_mes."(saltdecamp)") or die('data_inici impossible d\'escriure!');
					
					fwrite($fp_dates, $fitxa_id."(saltdecamp)") or die('fitxa id impossible d\'escriure!');
					fwrite($fp_dates, $any.'-'.$mes.'-'.$dia_mes."(saltdecamp)(saltdelinea)") or die('data Del impossible d\'escriure!');
					
					$datafi = substr($lesdates, strpos($lesdates, 'al ')+3, 10);
					$array_datafi = explode('/', $datafi);
					$dia_mes = trim($array_datafi[0]);
					$mes = trim($array_datafi[1]);
					$any = trim($array_datafi[2]);
					fwrite($fp, $any.'-'.$mes.'-'.$dia_mes."(saltdecamp)") or die('data_fi impossible d\'escriure!');
					
					fwrite($fp_dates, $fitxa_id."(saltdecamp)") or die('fitxa id impossible d\'escriure!');
					fwrite($fp_dates, $any.'-'.$mes.'-'.$dia_mes."(saltdecamp)(saltdelinea)") or die('data al impossible d\'escriure!');
					
					echo $datainici.'-'.$datafi;
					fwrite($fp, "(saltdecamp)") or die('dates_inici buit impossible d\'escriure!');
					}
				else if (strpos($lesdates, 'De l') !== false)
					{
					$datainici = substr($lesdates, strpos($lesdates, 'De l')+5, 10);
					$array_datainici = explode('/', $datainici);
					$dia_mes = trim($array_datainici[0]);
					$mes = trim($array_datainici[1]);
					$any = trim($array_datainici[2]);
					fwrite($fp, $any.'-'.$mes.'-'.$dia_mes."(saltdecamp)") or die('data_inici impossible d\'escriure!');
					
					fwrite($fp_dates, $fitxa_id."(saltdecamp)") or die('fitxa id impossible d\'escriure!');
					fwrite($fp_dates, $any.'-'.$mes.'-'.$dia_mes."(saltdecamp)(saltdelinea)") or die('data Del impossible d\'escriure!');

					$datafi = substr($lesdates, strpos($lesdates, 'al ')+3, 10);
					$array_datafi = explode('/', $datafi);
					$dia_mes = trim($array_datafi[0]);
					$mes = trim($array_datafi[1]);
					$any = trim($array_datafi[2]);
					fwrite($fp, $any.'-'.$mes.'-'.$dia_mes."(saltdecamp)") or die('data_fi impossible d\'escriure!');
					
					fwrite($fp_dates, $fitxa_id."(saltdecamp)") or die('fitxa id impossible d\'escriure!');
					fwrite($fp_dates, $any.'-'.$mes.'-'.$dia_mes."(saltdecamp)(saltdelinea)") or die('data Del impossible d\'escriure!');
					
					echo $datainici.'-'.$datafi;
					fwrite($fp, "(saltdecamp)") or die('dates_inici buit impossible d\'escriure!');
					}
				else
					{
					$array_dates = explode(',', $lesdates);
					if (count($array_dates)==1)
						{
						$datainici = trim($array_dates[0]);
						$array_datainici = explode('/', $datainici);
						$dia_mes = trim($array_datainici[0]);
						$mes = trim($array_datainici[1]);
						$any = trim($array_datainici[2]);
						fwrite($fp, $any.'-'.$mes.'-'.$dia_mes."(saltdecamp)") or die('data_inici impossible d\'escriure!');
						fwrite($fp, $any.'-'.$mes.'-'.$dia_mes."(saltdecamp)") or die('data_inici impossible d\'escriure!');
						
						fwrite($fp_dates, $fitxa_id."(saltdecamp)") or die('fitxa id impossible d\'escriure!');
						fwrite($fp_dates, $any.'-'.$mes.'-'.$dia_mes."(saltdecamp)(saltdelinea)") or die('data Del impossible d\'escriure!');
						
						fwrite($fp, "(saltdecamp)") or die('dates_inici buit impossible d\'escriure!');
						}
					else if (count($array_dates)>1)
						{
						$dia=array();
						fwrite($fp, "(saltdecamp)") or die('data_inici buit impossible d\'escriure!');
						fwrite($fp, "(saltdecamp)") or die('data_fi buit impossible d\'escriure!');
						
						foreach($array_dates as $data)
							{
							$trobant_dates = explode('/', $data);
							
							if (count($trobant_dates)==3)
								{
								if(count($dia)>=1)
									{
									foreach($dia as $dia_trobat)
										{
										echo '<br>'.trim($trobant_dates[2]).'-'.trim($trobant_dates[1]).'-'.trim($dia_trobat);
										fwrite($fp, trim($trobant_dates[2]).'-'.trim($trobant_dates[1]).'-'.trim($dia_trobat).",") or die('dates_inici impossible d\'escriure!');
										
										fwrite($fp_dates, $fitxa_id."(saltdecamp)") or die('fitxa id impossible d\'escriure!');
										fwrite($fp_dates, trim($trobant_dates[2]).'-'.trim($trobant_dates[1]).'-'.trim($dia_trobat)."(saltdecamp)(saltdelinea)") or die('data Del impossible d\'escriure!');
										}
									$dia=array();
									}
								$dia_mes = trim($trobant_dates[0]);
								$mes = trim($trobant_dates[1]);
								$any = trim($trobant_dates[2]);
								echo '<br>'.$any.'-'.$mes.'-'.$dia_mes;
								fwrite($fp, $any.'-'.$mes.'-'.$dia_mes.",") or die('dates_inici impossible d\'escriure!');
								
								fwrite($fp_dates, $fitxa_id."(saltdecamp)") or die('fitxa id impossible d\'escriure!');
								fwrite($fp_dates, $any.'-'.$mes.'-'.$dia_mes."(saltdecamp)(saltdelinea)") or die('data Del impossible d\'escriure!');
								}
							else if (count($trobant_dates)==1)
								{
								$dia[]=$trobant_dates[0];
								}
							}
						fwrite($fp, "(saltdecamp)") or die('data_fi buit impossible d\'escriure!');
						}
					}
				fwrite($fp, "$lesdates(saltdecamp)") or die('data impossible d\'escriure!');
				
				fclose($fp_dates);
				}
				
			//if horari	-----------------------------------------------------------
			if (strpos($mystring, 'Horari', $final_DeLaData) == false)
				{
				echo "<hr>Horari was not found in the string.";
				fwrite($fp, "horari was not found(saltdecamp)") or die('horari impossible d\'escriure!');
				}
			else 
				{
				$principi_horari_div = strpos($mystring, '<div>', $final_DeLaData)+(strlen('<div>'));
				$final_horari_div = strpos($mystring, '</div>', $principi_horari_div);
				echo "<hr><code>Posició: $principi_horari_div</code>";
				echo "<br><b>Horari:</b><br>";
				$dada_horari = substr($mystring, $principi_horari_div, ($final_horari_div-$principi_horari_div));
				echo '<i>'.$dada_horari.'</i>';
				$dada_horari = trim($dada_horari);
				fwrite($fp, "$dada_horari(saltdecamp)") or die('horari impossible d\'escriure!');
				}

			//llocs de celebració	-----------------------------------------------------------
			$llocs = '<div style="overflow: hidden;">';
			$ultim_llocs = '<div class="titol_seccio_fitxa">';
			$principi_agafa_lloc = '<img src="icones/fletxa_fitxa_vermell.gif" ALT=" " />';

			echo "<hr><b>LLocs de celebració:</b><br>";

			$compta_llocs = 0;
			$posicio_lloc = $final_DeLaData;
			
			$archivo_llocs = "llocs_celebracio/$fitxa_id.csv";
			$fp_llocs = fopen($archivo_llocs, "w");
			
			do
				{
				$compta_llocs++;
				$principi_llocs = strpos($mystring, $principi_agafa_lloc, $posicio_lloc)+(strlen($principi_agafa_lloc));
				$final_llocs_div = strpos($mystring, '</div>', $principi_llocs);
				$dada_llocs = substr($mystring, $principi_llocs, ($final_llocs_div-$principi_llocs));
				
				echo "<br><code>Posició del lloc de celebració nº$compta_llocs: $principi_llocs</code><br>";
				echo '<i>'.$dada_llocs.'</i>';
				
				fwrite($fp_llocs, "$fitxa_id(saltdecamp)") or die('fitxa id impossible d\'escriure!');
				
				$principi_lloc_celebracio = strpos($dada_llocs, '<b>')+3;
				$final_lloc_celebracio = strpos($dada_llocs, '</b>');
				$lloc_celebracio = substr($dada_llocs, $principi_lloc_celebracio, $final_lloc_celebracio-$principi_lloc_celebracio);
				/**/$lloc_celebracio = trim($lloc_celebracio);
				echo trim($lloc_celebracio);
				
				$buscant_poblacio = explode('<br>', $dada_llocs);
				foreach ($buscant_poblacio as $linea)
					{
					$paren_esq = strpos($linea, '(');
					$paren_dret = strpos($linea, ')', $paren_esq);
					if ($paren_esq !== false && $paren_dret !== false)
						{
						$municipi_str = 'Municipi: ';
						$municipi_de = strpos($linea, $municipi_str)+strlen($municipi_str);
						if (strpos($linea, $municipi_str) == false)
							{
							$poblacio_celebracio = substr($linea, 0, ($paren_esq-1));
							}
						else
							{
							$poblacio_celebracio = substr($linea, $municipi_de, (($paren_esq-1)-$municipi_de));
							}
						$comarca_celebracio = substr($linea, ($paren_esq+1), ($paren_dret-($paren_esq+1)));
						}
					}
				
				/**/$poblacio_celebracio = trim($poblacio_celebracio);
				echo '<br>'.trim($poblacio_celebracio);
				/**/$comarca_celebracio = trim($comarca_celebracio);
				echo '<br>'.trim($comarca_celebracio);
				
				$connection = mysql_connect('localhost', 'root', '') or die ('No se pudo establecer conexión.');
				mysql_select_db('agenda') or die ('Incapaz de seleccionar base de datos.');
				$query = "SELECT * FROM poblacions WHERE lower(nom_poblacio)=lower(\"".$poblacio_celebracio."\")";
				$result = mysql_query($query) or die ('Error en la consulta: '.$query. '<br>' . mysql_error());
				mysql_close($connection);
				
				$row = mysql_fetch_assoc($result);
				fwrite($fp_llocs, $row['id_comarca']."(saltdecamp)") or die('id comarca impossible d\'escriure!');
				fwrite($fp_llocs, $row['id_poblacio']."(saltdecamp)") or die('id població impossible d\'escriure!');
				fwrite($fp_llocs, $lloc_celebracio."(saltdecamp)") or die('lloc impossible d\'escriure!');
				fwrite($fp_llocs, "(saltdelinea)") or die('saltdelinea impossible d\'escriure!');
				
				$dada_llocs = trim($dada_llocs);
				fwrite($fp, "$dada_llocs") or die("lloc $compta_llocs impossible d'escriure!");
				
				$posicio_lloc = $final_llocs_div;
				}while((strpos($mystring, $llocs, $posicio_lloc) == true) && (strpos($mystring, $llocs, $posicio_lloc) < (strpos($mystring, $ultim_llocs, $posicio_lloc))));
			
			fclose($fp_llocs);
			
			fwrite($fp, "(saltdecamp)") or die("salt de camp a llocs impossible d'escriure!");
			
			//if entitat organitzadora	-----------------------------------------------------------
			if (strpos($mystring, 'Entitat organitzadora', $posicio_lloc) !== false)
				{
				$principi_entitat_div = strpos($mystring, '<div>', $posicio_lloc)+(strlen('<div>'));
				$final_entitat_div = strpos($mystring, '</div>', $principi_entitat_div);
				echo "<hr><code>Posició: $principi_entitat_div</code>";
				echo "<br><b>Entitat organitzadora:</b><br>";
				$dada_entitat = substr($mystring, $principi_entitat_div, ($final_entitat_div-$principi_entitat_div));
				echo '<i>'.$dada_entitat.'</i>';
				$dada_entitat = trim($dada_entitat);
				fwrite($fp, "$dada_entitat(saltdecamp)") or die('horari impossible d\'escriure!');
				}
			else if (strpos($mystring, 'Entitats organitzadores', $posicio_lloc) !== false)
				{
				echo "<br><br><hr><b>Entitats organitzadores:</b><br>";
				$final_entitats = strpos($mystring, '<div style="float:right'); //on acaben les entitats (no varie)
				$dada_entitat_acumulada = ''; //les dades acumulades es posen buides
				$troba_divs = $final_llocs_div; //teoricament agafe l'ultim lloc de celebració
				
				while ((strpos($mystring, '<div style="overflow : hidden', $troba_divs) !== false) && ($troba_divs < $final_entitats))
					{
					$principi_entitat_div = strpos($mystring, '<div>', $troba_divs)+(strlen('<div>'));
					$final_entitat_div = strpos($mystring, '</div>', $principi_entitat_div);
					$dada_entitat = substr($mystring, $principi_entitat_div, ($final_entitat_div-$principi_entitat_div));
					$dada_entitat_acumulada = $dada_entitat_acumulada.trim($dada_entitat).'</div><br>';
					$troba_divs = $final_entitat_div;
					}
				echo $dada_entitat_acumulada;
				
				fwrite($fp, "$dada_entitat_acumulada(saltdecamp)") or die('horari impossible d\'escriure!');
				}
			else 
				{
				echo "<hr>Entitat organitzadora was not found in the string.";
				fwrite($fp, "entitat was not found(saltdecamp)") or die('entitat impossible d\'escriure!');
				}
				
			//if més informació	-----------------------------------------------------------
			$mesinformacio = '<b>M&eacute;s informaci&oacute;</b>';
			$mesinfo = 'id="mesinformacio">';
			$principi_mesinfo = strpos($mystring, $mesinfo, $mesinformacio)+(strlen($mesinfo));
			$final_mesinfo_div = strpos($mystring, '</div>', $principi_mesinfo);
			
			if (strpos($mystring, $mesinfo, $mesinformacio) == false)
				{
				echo "<hr>Més informació was not found in the string.";
				fwrite($fp, "mes info was not found(saltdecamp)") or die('mes info impossible d\'escriure!');
				}
			else 
				{
				echo "<hr><code>Posició: $principi_mesinfo</code>";
				echo "<br><b>Més informació:</b><br>";
				$dada_mesinfo = substr($mystring, $principi_mesinfo, ($final_mesinfo_div-$principi_mesinfo));
				echo '<i>'.$dada_mesinfo.'</i>';
				$dada_mesinfo = trim($dada_mesinfo);
				fwrite($fp, "$dada_mesinfo(saltdecamp)") or die('mes informacio impossible d\'escriure!');
				}	
			
			//tanquem el document i insertem les dades del fitxer CSV a la nostra BD.
			fwrite($fp, "(saltdelinea)") or die("salt de linea finalitzant el document impossible d'escriure!");
			fclose($fp);
			
			$connection = mysql_connect('localhost', 'root', '') or die ('No se pudo establecer conexión.');
			mysql_select_db('agenda') or die ('Incapaz de seleccionar base de datos.');
			$sql = "LOAD DATA INFILE 'c:/xampp/htdocs/proves_php/Sintesi/get_contents/fitxes/$fitxa_id.csv' INTO TABLE esdeveniment
						FIELDS TERMINATED BY '(saltdecamp)'
						LINES TERMINATED BY '(saltdelinea)'";
			$result = mysql_query($sql) or die ('<br>Error en la inserció fitxa: '.$sql. '<br><br>' . mysql_error());
			
			$sql_llocs = "LOAD DATA INFILE 'c:/xampp/htdocs/proves_php/Sintesi/get_contents/llocs_celebracio/$fitxa_id.csv' INTO TABLE llocs_celebracio
						FIELDS TERMINATED BY '(saltdecamp)'
						LINES TERMINATED BY '(saltdelinea)'";
			$result_llocs = mysql_query($sql_llocs) or die ('<br>Error en la inserció llocs_celebracio: '.$sql_llocs. '<br><br>' . mysql_error());
			
			$sql_dates = "LOAD DATA INFILE 'c:/xampp/htdocs/proves_php/Sintesi/get_contents/dates_celebracio/$fitxa_id.csv' INTO TABLE dates_esdeveniment
						FIELDS TERMINATED BY '(saltdecamp)'
						LINES TERMINATED BY '(saltdelinea)'";
			$result_dates = mysql_query($sql_dates) or die ('<br>Error en la inserció dates_esdeveniment: '.$sql_dates. '<br><br>' . mysql_error());
			
			$query = 'SELECT dates_inici FROM esdeveniment WHERE id_esdeveniment='.$fitxa_id.' and data_inici is null and data_fi is null';
			$result = mysql_query($query) or die ('Error en la consulta: '.$query. '<br>' . mysql_error());
			if (mysql_num_rows($result)!=0)
				{
				$row = mysql_fetch_assoc($result);
				$dates_array = explode(',' , $row['dates_inici']);
				$c = count($dates_array)-2;
				$insert = "UPDATE esdeveniment SET data_inici='".$dates_array[0]."',data_fi='".$dates_array[$c]."' WHERE id_esdeveniment=$fitxa_id";
				mysql_query($insert) or die ('Error en la consulta: '.$insert. '<br>' . mysql_error());
				}
			mysql_close($connection);
			}
		}
	else 
		{
		print "Snoopy: error mentre associàvem les dades: ".$snoopy->error."<br>";
		}
	}

?>