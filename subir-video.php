<?php
include_once 'comun/privado.php';
// SUBIR UN VIDEO
		$lid = $_POST['lote_id'];
		$rid = $_POST['remate_id'];
		$od = $_POST['orden_lo'];
//	compruebo que tenga el formato adecuado
if(!($_FILES['video']['type'] == 'video/mp4' OR $_FILES['video']['type'] == 'video/x-mp4')){
	die('El video no tiene el formato adecuado, debe ser mp4. <input type="button" class="button" value="Volver al formulario" onclick="history.back()"></input>');
}
//	compruebo que no se hayan producido errores
if($_FILES['video']['error'] != 0){
	die('Se ha producido un error. <input type="button" class="button" value="Volver al formulario" onclick="history.back()"></input>');
}
//se intenta guardar y se comprueba que se guarde bien
		$video = $_FILES['video']['tmp_name'];
		$destino = 'images/'.$rid.'/'.$lid.'.mp4';
if(move_uploaded_file($video, $destino)){
	//cambio la ruta del video
	include_once 'inc/class.hacienda.inc.php';
	$video = new BipherHacienda($db);
	$video->guardarRutaVideo($destino, $lid);
} else {
	die('El video no se pudo guardar. <input type="button" class="button" value="Volver al formulario" onclick="history.back()"></input>');
}
echo '<meta http-equiv="refresh" content="0;ordenar-lotes.php?rid='.$rid.'&ord='.$od.'&lid='.$lid.'">';
// FIN DE SUBIR UN VIDEO
?>
