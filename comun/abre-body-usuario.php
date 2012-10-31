<div id="page-wrap-ancho">
	<div id="userheader">
		<h1><a href="login.php">Buscador de índices de precios en remates de hacienda</a></h1>
		<div id="control">
<?php
// Si está logueado muestra los botones del usuario Cerrar Sesión y Volver
	if(isset($_SESSION['LoggedIn']) && isset($_SESSION['username'])
		&& $_SESSION['LoggedIn']==1):
?>
		<p><a href="logout.php" class="button">Cerrar sesi&oacute;n</a> <a href="login.php" class="button">Volver sin Guardar</a>
<!-- Este botón conduce al seteo de Mi Cuenta
	<a href="account.php" class="button">Mi cuenta</a>
-->		</p>
<?php
// Si no está logueado muestra los botones de Registro e Iniciar Sesión
	else:
?>
		<p><a class="button" href="signup.php">Registrarse</a> &nbsp; <a class="button" href="login.php">Iniciar sesi&oacute;n</a></p>
<?php endif; ?>
		</div>
			<div class="clear"></div>
	</div>
