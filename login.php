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
<!-- COMIENZAN HERRAMIENTAS PARA EL OPERADOR -->
	<p><a href="nuevoremate.php" class="button">Agregar un Remate</a>&nbsp;<a href="nuevomunicipio.php" class="button">Agregar una Localidad</a></p>
			<br />
<!--	BOTONES COMENTADOS
		<p><a href="c-lista.php" class="button">Vacio - Lista de Cat&aacute;logos</a>&nbsp;<a href="c-lista.php" class="button">Boton vacio</a></p>
			<br />
-->
		<h2>Últimos remates agregados</h2>
<?php
	include_once 'inc/class.hacienda.inc.php';
	$listarem = new BipherHacienda($db);
	$listarem->listaRemates();
?>
<!-- FIN HERRAMIENTAS DEL OPERADOR -->
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
