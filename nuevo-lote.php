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
		$remat = new BipherHacienda($db);
		list($id, $fe, $ho, $or, $met, $st, $ca) = $remat->cargarInfoRemate();
		$nombre_lote =  $ca + 1;
		if($_GET['lote']=="changed")
		{
			echo "<br /><div class='message good'>El lote ha sido modificado con éxito.</div>";
		}
		elseif($_GET['lote']=="borrado")
		{
			echo "<br /><div class='message good'>El lote ha sido eliminado con éxito.</div>";
		}
?>
<h2>Agregar o editar lotes en el remate de <?php echo $or; ?> del <?php echo darVueltaFecha($fe); ?></h2>
			<p>Los campos en verde pueden quedar en blanco cuando se cargan datos solamente para el buscador.</p>


<br></br>
		<form method="post" action="db-interaccion/hacienda.php" id="agregar-lote-form" name="fvalida">
			<div>
				<input type="hidden" name="action" value="agregar-lote" />
				<input type="hidden" name="remate" id="remate" value="<?php echo $id; ?>" />
				<input type="hidden" name="fecha" id="fecha" value="<?php echo $fe; ?>" />
				<input type="hidden" name="organizador" id="organizador" value="<?php echo $or; ?>" />
				<input type="hidden" name="metodo" id="metodo" value="<?php echo $met; ?>" />

			<label for="numerolote" class="catalogo">Designación de Lote (alfanumérico, hasta 25 caracteres)</label>
			<input type="text" name="numerolote" id="numerolote" value="Lote <?php echo $nombre_lote; ?>" />
				<br />
			<label class="selec" for="categoria">Categoría</label>
			<?php include 'comun/categorias-select.php'; ?>
				<br/><br/>
			<label for="subcategoria" class="catalogo">Subcategoría (Opcional Catálogo)</label>
			<input type="text" name="subcategoria"	id="subcategoria" />
				<br />
			<label class="selec" for="provincia">Provincia </label>
		  	<select id="provincia" name="provincia">
		    	<option>Cargando...</option>
			</select>
		  		<br/><br/>
			<label class="selec" for="municipio">Municipio</label>
			<select id="municipio" name="municipio">
		  		<option>- seleccione una provincia -</option>
			</select> <span class="juntoacombo"><a href="nuevo-municipio.php" title="Antes verificar que no esta en la lista">Agregar Municipio</a></span>
				<br /><br />
			<label for="cabezas">Cabezas</label>
			<input type="text" name="cabezas" id="cabezas" />
				<br />
			<?php include 'comun/razas-select.txt'; ?>
				<br/><br/>
			<label for="peso">Peso</label>
			<input type="text" name="peso" id="peso" />
				<br />
			<label for="precio">Precio - Solo números y el punto, ej: 12.99</label>
			<input type="text" name="precio" id="precio" />
				<br />
			<label for="plazo">Plazo</label>
			<input type="text" name="plazo" value="Contado"	id="plazo" />
				<br />
		<!-- CASILLAS DE VERIFICACION -->
<table class="opciones">
	<tr class="non">
		<td class="etiqueta">Trazabilidad</td>
		<td><input name="ctr" type="radio" value="" /> <span class="box">Desactivado</span></td>
		<td><input name="ctr" type="radio" checked="checked" value="Con Trazabilidad. " /> <span class="box">Con Trazabilidad</span></td>
		<td><input name="ctr" type="radio" value="Sin Trazabilidad. " /> <span class="box">Sin Trazabilidad</span></td>
	</tr>
	<tr>
		<td class="etiqueta">Estado</td>
	<td><input name="str" type="radio" checked="checked" value="" /> <span class="box">Desactivado</span></td>
	<td><input name="str" type="radio" value="Estado bueno. " /> <span class="box">Bueno</span></td>
	<td><input name="str" type="radio" value="Estado muy bueno. " /> <span class="box">Muy bueno</span></td>
	</tr>
	<tr class="non">
	<td class="etiqueta">Calidad</td>
	<td><input name="cex" type="radio" checked="checked" value="" /> <span class="box">Desactivado</span></td>
	<td><input name="cex" type="radio" value="Calidad Exportacion. " /> <span class="box">Calidad Exportación</span></td>
	<td><input name="cex" type="radio" value="Lote desparejo. " /> <span class="box">Lote desparejo</span></td>
	</tr>
	<tr>
	<td class="etiqueta">En Bateas</td>
	<td><input name="sco" type="radio" checked="checked" value="" /> <span class="box">Desactivado</span></td>
	<td><input name="sco" type="radio" value="Saben comer. " /> <span class="box">Saben comer</span></td>
	<td><input name="sco" type="radio" value="No saben comer. " /> <span class="box">No saben comer</span></td>
		</tr>
		<tr class="non">
	<td class="etiqueta">Servicio</td>
	<td><input name="csv" type="radio" checked="checked" value="" /> <span class="box">Desactivado</span></td>
	<td><input name="csv" type="radio" value="Con servicio. " /> <span class="box">Con servicio</span></td>
	<td><input name="csv" type="radio" value="Sin servicio. " /> <span class="box">Sin servicio</span></td>
		</tr>
		<tr>
	<td class="etiqueta">Mio Mio</td>
	<td><input name="cmi" type="radio" checked="checked" value="" /> <span class="box">Desactivado</span></td>
	<td><input name="cmi" type="radio" value="Conocen mio mio. " /> <span class="box">Conocen mio mio</span></td>
	<td><input name="cmi" type="radio" value="No conocen mio mio. " /> <span class="box">No conocen mio mio</span></td>
		</tr>
		<tr class="non">
	<td class="etiqueta">Zona</td>
	<td><input name="cgr" type="radio" checked="checked" value="" /> <span class="box">Desactivado</span></td>
	<td><input name="cgr" type="radio" value="Conocen garrapata. " /> <span class="box">Conocen garrapata</span></td>
	<td><input name="cgr" type="radio" value="Sanidad completa. " /> <span class="box">Sanidad completa</span></td>
		</tr>
		<tr>
	<td class="etiqueta">Hembras</td>
	<td><input name="nsc" type="radio" checked="checked" value="" /> <span class="box">Desactivado</span></td>
	<td><input name="nsc" type="radio" value="Vacias por tacto. " /> <span class="box">Vacias por tacto</span></td>
	<td><input name="nsc" type="radio" value="Para entorar. " /> <span class="box">Para entorar</span></td>
		</tr>
</table>
		<br /><br />
<!-- FIN CASILLAS DE VERIFICACION -->
			<label for="notas" class="catalogo">Notas </label>
			<textarea rows="2" name="notas" id="notas" /></textarea>
				<br /><br />
			<input type="hidden" name="cardinal_re" id="cardinal_re" value="<?php echo $ca ?>" />
			<input type="submit" name="agregar-lote" id="agregarlote" value="Agregar Lote" class="button" onclick="return valida()"/>
			<label class="blanco"><a class="button" href="login.php">Volver a la lista sin agregar</a></label>
			<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
		</div>
	</form>
			<hr />
		<h2 id="lotes">Últimos lotes agregados a este remate</h2>
		<p><strong>Modificar todos los precios a la vez: </strong> Completar el campo "Precio" para cada lote y click en el botón "Cambiar precios a todos los lotes" en el fondo de la pantalla.</p>
		<p>Enlace <strong>Editar</strong>: Permite cambiar la designación del lote y su descripción general</p>
		<p>Enlace <strong>Catálogo</strong>: Permite cambiar el orden de venta del lote y agregar fotos y videos</p>
<?php
	$listalot = new BipherHacienda($db);
	$listalot->listaLotesPorRemateEditable($id);
?>

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
