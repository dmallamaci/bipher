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
<?php
include_once 'inc/class.banners.inc.php';
$banid = (int) $_GET['banner'];
$elbanner = new BipherBanners($db);
list($bid, $amb, $ord, $vis, $rut, $enl) = $elbanner->cargarInfoBanner($banid);
echo '<br /><h2>Editar la información del banner '.$bid.':</h2>';
?>
<p><img src="<?php echo $rut;?>"></p>
<form method="post" action="db-interaccion/avisos.php" id="editar-banner-form">
<div>
	<input type="hidden" name="action" value="editar-banner" />
	<input type="hidden" name="id_banner" id="id_banner" value="<?php echo $bid; ?>" />
<?php include_once 'comun/ambitos-select.php';?>
		<br /> <br />
	<label for="orden_banner">Número de Orden</label>
	<input type="text" name="orden_banner" id="orden_banner" value="<?php echo $ord; ?>" />
		<br />
<?php
If(isset($vis))
{
    switch($vis)
    {
    case 0:
        $opcion[0] = ' selected="selected"';
        break;
    case 1:
        $opcion[1] = ' selected="selected"';
        break;
    default:
        return '';
        break;
    }
}
?>
		    <label for="visible">Estado de Publicación  </label>
		    <select id="visible" name="visible">
				<option value="0"<?php echo $opcion[0] ?>>No Publicado</option>
				<option value="1"<?php echo $opcion[1] ?>>Publicado</option>
		    </select>
		<br/><br />
	<label for="enlace_banner">Enlace externo (Incluir <em>http://</em>) </label>
	<input type="text" name="enlace_banner" id="enlace_banner" value="<?php echo $enl; ?>" />
		 <br/>
	<input type="submit" name="editar-banner" id="editarbanner" value="Editar Banner" class="button" />
	<input type="button" class="button" value="Volver a la lista" onclick="history.back()"></input>
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
