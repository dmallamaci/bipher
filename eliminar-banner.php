<?php
include_once 'comun/privado.php';
$bid = $_GET['banner'];
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
<h2>Eliminar un banner.</h2>
	<div class='message bad'>Se borrará el Banner <?php echo '# '.$bid; ?> de la base de datos y el archivo de imagen del disco.</div>
	<form method="post" action="db-interaccion/avisos.php" id="eliminar-banner-form">
		<div>
		<input type="hidden" name="action" value="eliminar-banner" />
		<input type="hidden" name="id_banner" id="id_banner" value="<?php echo $bid; ?>" />
		<input type="submit" name="borrarbanner" id="borrarbanner" value="Borrar el Banner" class="button" />
		<label class="blanco"><a class="button" href="banners.php">Volver a la lista</a></label>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
		</div>
	</form>
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
