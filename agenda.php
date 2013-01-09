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
		</div>
<!-- ACCIONES CON HACIENDA -->
<?php
	$agenda = new BipherPublico($db);
	//uso ambito -1 para formatear la salida
	$agenda->ventaIndex(1);
?>
    </div>
</body>
</html>
