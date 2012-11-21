<?php
include_once 'comun/publico.php';
include_once 'inc/class.publico.inc.php';
htmlDoc();
?>
<html <?php xm();?>>
<head>
<?php headPublico();?>
	<script src="js/desplegable.js" type="text/javascript"></script>
</head>
<body>
    <div id="page-wrap">
        <div class="clear"></div>
<!-- ACCIONES CON HACIENDA -->
<?php
$ri = $_GET['subasta'];
	$remate = new BipherPublico($db);
	//uso ambito -1 para formatear la salida
	$remate->cargaDatosRemate($ri, -1);
?>
		<div><img src="images/guarda.png" /></div>
<?php
$lotes = new BipherPublico($db);
$lotes->ordenaLotesPorCategoria($ri);
?>

    </div>
</body>
</html>
