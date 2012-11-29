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
		<h2>Agregar un remate</h2>
			<br />
		<form method="post" action="db-interaccion/hacienda.php"
			id="agrega-remate-form">
			<div>
				<label for="status_re">Ámbito de Publicación</label>
				<select id="status_re" name="status_re">
					<option value="0" selected="selected"><?php echo ambitoDePublicacion(0)?></option>
					<option value="1"><?php echo ambitoDePublicacion(1)?></option>
					<option value="2"><?php echo ambitoDePublicacion(2)?></option>
				</select>
					<br /><br />
				<input type="hidden" name="action" value="agregar-remate" />
				<label for="fecha_re">Fecha en formato DD-MM-AAAA</label>
				<input type="text" name="fecha_re" id="nueva-fecha" />

				<label for="horaa_re">Hora en formato HH:MM</label>
				<input type="text" name="hora_re" id="nueva-hora" value="14:00" />

				<label for="organizador">Organizador del Remate</label>
				<input type="text" name="organizador" id="organizador" />

				<label for="metodo">Método de Venta</label>
				<input type="text" name="metodo" id="metodo" />

<?php include_once 'comun/logos-select.php';?>
					 <br /><br />
				<label for="nombre_re">Nombre o frase de promoción  </label>
				<input type="text" name="nombre_re" id="nombre_re" />

				<label for="informes_re">Información  </label>
				<input type="text" name="informes_re" id="informes_re" />

				<input type="submit" name="nuevoremate" id="nuevoremate" value="Agregar Remate" class="button" />
				<label class="blanco"><a class="button" href="login.php">Volver a la lista sin agregar</a></label>
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
