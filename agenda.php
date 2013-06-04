<?php
include_once 'comun/publico.php';
include_once 'inc/class.publico.inc.php';
htmlDoc();
?>
<html <?php xm();?>>
<head>
<?php headPublico();?>
</head>
<body>
    <div id="page-wrap">
        <div class="clear"></div>
        <div id="agendagrande">
			<h2 class="barratit blanco">Agenda de futuras subastas</h2>
			<p></p>
			<p></p>
			<p><strong>Las fechas publicadas quedan sujetas a posibles modificaciones. Al acercarse las fechas de cada remate publicaremos m&aacute;s informaci&oacute;n y detalles sobre los mismos.</strong></p>
		</div>
<!-- ACCIONES CON HACIENDA -->
<?php
	$agenda = new BipherPublico($db);
	//uso ambito -2 para formatear la salida
	$agenda->ventaAgenda(-2);
?>
		<div id="botonagenda">
	<a href="index.php" class="sinborde"><img src="images/boton_volver.png" /></a>
		</div>
    </div>
</body>
</html>
