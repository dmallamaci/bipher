<?php
include_once 'comun/privado.php';
htmlDoc();
?>
<html <?php xm();?>>
<head>
<?php headPublico();?>
	<script src="js/desplegable.js" type="text/javascript"></script>
	<script src="js/fvalida.js" type="text/javascript"></script>
</head>
<body>
<?php include_once 'comun/abre-body-usuario.php';?>
<?php if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['username'])): ?>
<!-- ACCIONES CON HACIENDA -->
<?php
	$rid = $_GET['subasta'];
	$lid = $_GET['lote'];
	$orden = $_GET['orden'];
?>
	<h2>Eliminar un lote.</h2>
	<form method="post" action="db-interaccion/hacienda.php" id="eliminar-lote-form">
		<div>
		<input type="hidden" name="action" value="eliminar-lote" />
		<input type="hidden" name="remate" id="remate" value="<?php echo $rid; ?>" />
		<input type="hidden" name="lote_id" id="lote_id" value="<?php echo $lid; ?>" />
		<input type="hidden" name="orden_lo" id="orden_lo" value="<?php echo $orden; ?>" />
		<input type="submit" name="borrarlote"	id="borrarlote" value="Borrar el Lote" class="button" />
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
