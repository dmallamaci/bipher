<?php
include_once 'comun/privado.php';
htmlDoc();
?>
<html <?php xm();?>>
<head>
<?php headPublico();?>
<script src="js/cambiar-logo.js" type="text/javascript"></script>
</head>
<body>
<?php include_once 'comun/abre-body-usuario.php';?>
<?php if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['username'])): ?>
<!-- ACCIONES CON HACIENDA -->
<?php
//$rid = $_GET['subasta'];
	include_once 'inc/class.hacienda.inc.php';
	$rema = new BipherHacienda($db);
	list($rid, $fecha, $hora, $organizador, $metodo, $logo, $nombre, $info, $sta, $cardinal) = $rema->cargarInfoRemate();
		$op0 = '';
		$op1 = '';
		$op2 = '';
	switch ($sta)
	{
		case 0:
			$op0 = 'selected="selected"';
		break;
		case 1:
			$op1 = 'selected="selected"';
		break;
		case 2:
			$op2 = 'selected="selected"';
		break;
	}
?>
		<h2>Editar un remate</h2>
			<br />
		<form method="post" action="db-interaccion/hacienda.php"
			id="editar-remate-form">
			<div>
				<input type="hidden" name="action" value="editar-remate" />
				<input type="hidden" name="remate_id" id="remate_id" value="<?php echo $rid; ?>" />
				<label for="status_re">Ámbito de Publicación</label>
				<select id="status_re" name="status_re" class="desplazado">
					<option value="0" <?php echo $op0; ?>><?php echo ambitoDePublicacion(0)?></option>
					<option value="1" <?php echo $op1; ?>><?php echo ambitoDePublicacion(1)?></option>
					<option value="2" <?php echo $op2; ?>><?php echo ambitoDePublicacion(2)?></option>
				</select>
					<br /><br /><br />
				<label for="fecha_re">Fecha en formato DD-MM-AAAA </label>
				<input type="text" name="fecha_re" id="nueva-fecha" value="<?php echo darVueltaFecha($fecha); ?>" />
					<br /><br />
				<label for="hora_re">Hora en formato HH:MM </label>
				<input type="text" name="hora_re" id="nueva-hora" value="<?php echo $hora; ?>" />
					<br /><br />
				<label for="organizador">Organizador del Remate</label>
				<input type="text" name="organizador" id="organizador" value="<?php echo $organizador; ?>"  />
					<br />
<?php include_once 'comun/logos-select.php';?>
					<br /><br />
				<label for="metodo">Método de Venta</label>
				<input type="text" name="metodo" id="metodo" value="<?php echo $metodo; ?>" />
					<br /><br />
				<label for="nombre_re">Nombre o frase de promoción </label>
				<input type="text" name="nombre_re" id="nombre_re" value="<?php echo $nombre; ?>" />
					<br /><br />
				<label for="informes_re">Informes sobre el remate</label>
				<input type="text" name="informes_re" id="informes_re" value="<?php echo $info; ?>" />
					<br /><br />
				<input type="submit" name="editarremate" id="editarremate" value="Editar Remate" class="button" />

				<input type="submit" name="atras" id="atras" value="Volver" class="button" />
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
