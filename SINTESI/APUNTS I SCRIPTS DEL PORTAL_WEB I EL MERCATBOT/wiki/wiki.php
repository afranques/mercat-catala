<?
// Ruta del archivo de texto
// donde se guarda el contenido
// del textarea
$fichero = 'wiki.txt'; 
$texto = $_POST["texto"]; 
if( isset($_POST["guardar"]) && $texto != '')
	{ 
	if($fp = fopen($fichero, "w+"))
		{ 
		fwrite($fp, stripslashes($texto)); 
		} 
	fclose($fp); 
	}
$fp = fopen($fichero, "r"); 
$contenido = fread($fp, filesize($fichero)); 
fclose($fp);?>
<script language="javascript">
function abrir(pagina)
	{
	window.open(pagina,'window','params');
	}
</script>
<?
echo '<form method="POST">';
echo '<textarea rows="20" cols="90" name="texto">';
echo $contenido.'</textarea><br>';
echo '<input type="Submit" value="Guardar" name="guardar"><a href="wiki.txt" onclick="abrir(this.href);return false">Veure l\'original</a>';
echo '</form>'; 
?>
