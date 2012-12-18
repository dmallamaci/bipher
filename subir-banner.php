<?php
include_once 'comun/privado.php';
include_once 'inc/class.banners.inc.php';
	$ambit = (int) $_POST['ambito'];
	$orden = 1;
	$visible = 1;
	$enlace = 'http://'.trim($_POST['enlace']);
// SUBIR UN BANNER
//	compruebo que tenga el formato adecuado
if(!($_FILES['banner']['type'] =="image/jpeg" OR $_FILES['banner']['type'] =="image/gif" OR $_FILES['banner']['type'] =="image/png")){
	die('El banner no tiene el formato adecuado. <input type="button" class="button" value="Volver al formulario" onclick="history.back()"></input>');
}
//	compruebo que no se hayan producido errores
if($_FILES['banner']['error'] != 0){
	die('Se ha producido un error. <input type="button" class="button" value="Volver al formulario" onclick="history.back()"></input>');
}
//se intenta guardar y se comprueba que se guarde bien
		$banner = $_FILES['banner']['tmp_name'];
		$nombre = $_FILES['banner']['name'];
		$destino = 'images/banners/'.$nombre;
if(move_uploaded_file($banner, $destino)){
	//cambio la ruta del video
	$banner = new BipherBanners($db);
	$banner->guardarRutaBanner($ambit, $orden, $visible, $destino, $enlace);
} else {
	die('El banner no se pudo guardar <input type="button" class="button" value="Volver al formulario" onclick="history.back()"></input>');
}
echo '<meta http-equiv="refresh" content="0;banners.php">';
// FIN DE SUBIR UN BaNNER
?>
