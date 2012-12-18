<?php
include_once 'comun/privado.php';
htmlDoc();
?>
<html <?php xm();?>>
<head>
<?php headPublico();?>
	<script src="js/fvalida.js" type="text/javascript"></script>
</head>
<body>
<?php include_once 'comun/abre-body-usuario.php';?>
<?php if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['username'])): ?>
<!-- ACCIONES CON HACIENDA -->
<?php
include_once 'inc/class.hacienda.inc.php';
	$su = (int) $_GET['rid'];
	$od = (int) $_GET['ord'];
	$li = (int) $_GET['lid'];
?>
	<h2>Modificar el Orden de Venta de un Lote</h2>
<?php
// CARGAR un formulario para cambiar el orden de venta de un lote
	$lotes = new BipherHacienda($db);
	$lotes->cargarOrdenDeVenta($su, $od);
?>
		<hr />
	<h2>Fotos y videos para este lote</h2>
	<p>Se pueden subir fotos y videos de dos maneras: En forma Manual o por FTP.</p>
	<h3>Subir las fotos en forma MANUAL</h3>
	<p>Las fotos deben medir 640x480 y tener extension JPG</p>
<div>
	<form method="post" action="subir-fotos.php" id="fotos-lote-form" enctype="multipart/form-data">
			<input type="hidden" name="lote_id" value="<?php echo $li; ?>" />
			<input type="hidden" name="remate_id" value="<?php echo $su; ?>" />
			<input type="hidden" name="orden_lo" value="<?php echo $od; ?>" />
		    <label for="foto_1">Foto 1</label>
		    <input type="file" size="38" name="fotos[1]" />
		    	<br /><br />
		    <label for="foto_2">Foto 2</label>
		    <input type="file" size="38" name="fotos[2]" />
		    	<br /><br />
		    <label for="foto_3">Foto 3</label>
		    <input type="file" size="38" name="fotos[3]" />
		    	<br /><br />
		    <label for="foto_4">Foto 4</label>
		    <input type="file" size="38" name="fotos[4]" />
		    	<br /><br />
			<input type="submit" name="subirfotos" value="Subir Fotos" class="button" />
			<input type="button" class="button" value="Volver a la lista sin cambiar" onclick="history.back()"></input>
			<a href="detalleslote.php?lote=<?php echo $li; ?>"> Ver el lote </a>
			<input type="hidden" name="token" value="<?php $_SESSION["token"]?>" />
	</form>
</div>
		<hr />
	<h3>Subir el video en forma MANUAL</h3>
	<p>El video debe medir 320x240 ó 480x360 y ser MP4</p>
<div>
	<form method="post" action="subir-video.php" id="video-lote-form" enctype="multipart/form-data">
			<input type="hidden" name="lote_id" value="<?php echo $li; ?>" />
			<input type="hidden" name="remate_id" value="<?php echo $su; ?>" />
			<input type="hidden" name="orden_lo" value="<?php echo $od; ?>" />
		    <label for="video">Video</label>
		    <input type="file" name="video" size="38" id="video<?php echo $li; ?>" />
		    	<br /><br />
			<input type="submit" name="subirvideo" value="Subir Video" class="button" />
			<input type="button" class="button" value="Volver a la lista sin cambiar" onclick="history.back()"></input>
			<a href="detalleslote.php?lote=<?php echo $li; ?>"> Ver el lote </a>
			<input type="hidden" name="token" value="<?php $_SESSION["token"]?>" />
	</form>
</div>
		<hr />
	<h3>Subir las fotos y el video por FTP</h3>
	<p>Subir los archivos por FTP a la carpeta <strong>images/<?php echo $su; ?></strong> y usar este formulario para cambiar los nombres de las rutas a los archivos. Se debe escribir la ruta completa y la extension del archivo, por ejemplo: <strong>images/<?php echo $su; ?>/nombre-foto.jpg</strong></p>
<?php
		$fotos = new BipherHacienda($db);
		$fotos->cargarArchivosDelLote($li);
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
