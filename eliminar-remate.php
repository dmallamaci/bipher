<?php
include_once 'comun/privado.php';
$rid = $_GET['subasta'];
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
<h2>Eliminar un remate.</h2>
	<div class='message bad'>Se borrará el Remate <?php echo '# '.$rid; ?> y TODOS los Lotes que contiene.</div>
	<form method="post" action="db-interaccion/hacienda.php" id="eliminar-remate-form">
		<div>
		<input type="hidden" name="action" value="eliminar-remate" />
		<input type="hidden" name="remate" id="remate" value="<?php echo $rid; ?>" />
		<input type="submit" name="borraremate"	id="borraremate" value="Borrar el Remate y los Lotes" class="button" />
		<label class="blanco"><a class="button" href="login.php">Volver a la lista</a></label>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
		</div>
	</form>
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
