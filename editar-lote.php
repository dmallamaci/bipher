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
include_once 'inc/class.hacienda.inc.php';
$elote = new BipherHacienda($db);
list($lid, $cat, $sub, $cab, $raz, $pes, $pre, $pla, $nos, $rid, $nlo) = $elote->cargarInfoLote();
echo '<br /><h2>Editar el lote '.$lid.' de la categoria: '.decirCategoria($cat).'</h2><br />';
?>
<form method="post" action="db-interaccion/hacienda.php" id="editar-lote-form">
<div>
	<input type="hidden" name="action" value="editar-lote" />
	<input type="hidden" name="lote_id" id="lote_id" value="<?php echo $lid; ?>" />
	<input type="hidden" name="remate_id" id="remate_id" value="<?php echo $rid; ?>" />
	<label for="num_lo">Designación del Lote</label>
	<input type="text" name="num_lo" id="num_lo" value="<?php echo $nlo; ?>" />
		<br />
	<label for="categoria">Categoría</label>
	<?php include_once 'comun/categorias-select.php'; ?>
		<br/><br/>
	<label for="subcategoria">Subcategoría</label>
	<input type="text" name="subcategoria" id="subcategoria" value="<?php echo $sub; ?>" />
		<br/>
	<label for="cabezas">Cabezas</label>
	<input type="text" name="cabezas" id="cabezas" value="<?php echo $cab; ?>" />
		 <br/>
	<label for="raza">Raza</label>
	<input type="text" name="raza" id="raza" value="<?php echo $raz; ?>" />
		 <br/>
	<label for="peso">Peso</label>
	<input type="text" name="peso" id="peso" value="<?php echo $pes; ?>" />
		 <br/>
	<label for="precio">Precio</label>
	<input type="text" name="precio" id="precio" value="<?php echo $pre; ?>" />
		 <br/>
	<label for="plazo">Plazo</label>
	<input type="text" name="plazo" id="plazo" value="<?php echo $pla ?>" />
		 <br/>
	<label for="notas">Notas</label>
	<textarea rows="2" name="notas" id="notas"><?php echo $nos; ?></textarea>
		 <br/>
	<input type="submit" name="editar-lote" id="editarlote" value="Editar Lote" class="button" />
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
