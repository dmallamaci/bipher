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
			<input type="hidden" name="MAX_FILE_SIZE" value="200000" />
		    <label for="banner">Banner</label>
		    <input type="file" name="banner" id="banner" />
		    <select id="ambito" name="ambito">
				<option value="4" selected="selected">300px - Left</option>
				<option value="3">720px - Top</option>
				<option value="5">720px - Middle</option>
				<option value="6">720px - Bottom</option>
		    </select>
		    	<br /><br />
			<input type="submit" name="subirbanner" value="Subir Banner" class="button" />
			<input type="button" class="button" value="Volver a la lista sin cambiar" onclick="history.back()"></input>
			<input type="hidden" name="token" value="<?php $_SESSION["token"]?>" />
	</form>
</div>
		<hr />
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
