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
<!-- ACCIONES CON BANNERS -->
	<h2>Gestionar Banners</h2>
	<br />
	<h3>Subir un banner</h3>
	<p>El banner debe tener extensión JPG, GIF ó PNG.</p>
<div>
	<form method="post" action="subir-banner.php" id="banner-form" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="250000" />
		    <label for="banner">Banner</label>
		    <input type="file" name="banner" id="banner" />
				<br />
<?php include_once 'comun/ambitos-select.php';?>
		    	<br /><br />
		    <label for="enlace">Enlace Externo (sin <em>http:// </em>) </label>
			<input type="text" name="enlace" id="enlace" />
		    	<br />
			<input type="submit" name="subirbanner" value="Subir Banner" class="button" />
			<input type="button" class="button" value="Volver sin cambiar" onclick="history.back()"></input>
			<input type="hidden" name="token" value="<?php $_SESSION["token"]?>" />
	</form>
</div>
		<hr />
		<h3>Gestionar Banners en LEFT - 300px</h3>
		<p>Para reordenar los banners asigne a cada uno un número entre 1 y 99 y luego pulse el botón <strong>Cambiar Orden</strong>.</p>
<?php
include_once 'inc/class.banners.inc.php';
	$avisos4 = new BipherBanners($db);
	$avisos4->mostrarBanners(4);
?>
	<hr />
		<h3>Gestionar Banners en TOP - 780px</h3>
		<p>Solo aparece publicado el banner que tenga marcada la casilla <strong>Publicado</strong> con el número de orden más bajo. Para reordenar los banners asigne a cada uno un número entre 1 y 99 y luego pulse el botón <strong>Cambiar Orden</strong>.</p>
<?php
	$avisos3 = new BipherBanners($db);
	$avisos3->mostrarBanners(3);
?>
	<hr />
		<h3>Gestionar Banners en MIDDLE - 780px</h3>
		<p>Solo aparece publicado el banner que tenga marcada la casilla <strong>Publicado</strong> con el número de orden más bajo. Para reordenar los banners asigne a cada uno un número entre 1 y 99 y luego pulse el botón <strong>Cambiar Orden</strong>.</p>
<?php
	$avisos5 = new BipherBanners($db);
	$avisos5->mostrarBanners(5);
?>
	<hr />
		<h3>Gestionar Banners en BOTTOM - 780px</h3>
		<p>Solo aparece publicado el banner que tenga marcada la casilla <strong>Publicado</strong> con el número de orden más bajo. Para reordenar los banners asigne a cada uno un número entre 1 y 99 y luego pulse el botón <strong>Cambiar Orden</strong>.</p>
<?php
	$avisos6 = new BipherBanners($db);
	$avisos6->mostrarBanners(6);
?>
<!-- FIN DE ACCIONES CON BANNERS -->
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
