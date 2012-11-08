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
	$ambit = (int) $_POST['ambito'];
	$orden = 1;
	$visible = 1;
// SUBIR UN BANNER
//	compruebo que tenga el formato adecuado
if(!($_FILES['banner']['type'] =="image/jpeg" OR $_FILES['banner']['type'] =="image/gif" OR $_FILES['banner']['type'] =="image/png")){
	die('El video no tiene el formato adecuado. <input type="button" class="button" value="Volver al formulario" onclick="history.back()"></input>');
}
//	compruebo que no se hayan producido errores
if($_FILES['banner']['error'] != 0){
	die('Se ha producido un error. <input type="button" class="button" value="Volver al formulario" onclick="history.back()"></input>');
}
//se intenta guardar y se comprueba que se guarde bien
		$banner = $_FILES['banner']['tmp_name'];
		$destino = 'images/banners';
if(move_uploaded_file($banner, $destino)){
	//cambio la ruta del video
	$banner = new BipherHacienda($db);
	$banner->guardarRutaBanner($ambit, $orden, $visible, $destino);
} else {
	die('El banner no se pudo guardar. <input type="button" class="button" value="Volver al formulario" onclick="history.back()"></input>');
}
header("Location: banners.php?");
// FIN DE SUBIR UN BaNNER
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
