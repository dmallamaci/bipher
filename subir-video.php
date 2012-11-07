<?php
include_once 'comun/privado.php';
htmlDoc();
?>
<html <?php xm();?>>
<head>
<?php headPublico();?>
</head>
<body>
<?php include_once 'comun/abre-body-usuario.php';?>
<?php if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['username'])): ?>
<!-- ACCIONES CON HACIENDA -->
<?php
include_once 'inc/class.hacienda.inc.php';
// SUBIR UN VIDEO
		$lid = $_POST['lote_id'];
		$rid = $_POST['remate_id'];
		$od = $_POST['orden_lo'];
//	compruebo que tenga el formato adecuado
if($_FILES['video']['type'] != 'video/x-flv'){
	die('El video no tiene el formato adecuado');
}
//	compruebo que no se hayan producido errores
if($_FILES['video']['error'] != 0){
	die('Se ha producido un error');
}
//se intenta guardar y se comprueba que se guarde bien
		$video = $_FILES['video']['tmp_name'];
		$destino = 'images/'.$rid.'/'.$lid.'.flv';
if(move_uploaded_file($video, $destino)){
	//cambio la ruta del video
	include_once 'inc/class.hacienda.inc.php';
	$video = new BipherHacienda($db);
	$video->guardarRutaVideo($destino, $lid);
} else {
	die('El video no se pudo guardar');
}
header("Location: ordenar-lotes.php?rid=$rid&ord=$od&lid=$lid");
// FIN DE SUBIR UN VIDEO
?>
<!-- FIN DE ACCIONES CON HACIENDA -->
<?php
	elseif(!empty($_POST['username']) && !empty($_POST['password'])):
		include_once 'inc/class.usuarios.inc.php';
		$users = new BipherUsuario($db);
		if($users->accountLogin()===TRUE):
			echo "<meta http-equiv='refresh' content='0;login.php'>";
			exit;
		else:
?>
	<h2>Falló el inicio de sesión. Intente de nuevo</h2>
<?php
		include_once 'comun/form-loguearse.txt';
		endif;
	else:
?>
	<h2>Inicie Sesión...</h2>
<?php
	include_once 'comun/form-loguearse.txt';
	endif;
?>
		<div style="clear: both;"></div>
<!-- Este /div cierra el div id="page-wrap" de abre-usuario.php-->
	</div>
</body>
</html>
