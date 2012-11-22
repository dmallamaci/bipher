<?php
include_once 'comun/publico.php';
include_once 'inc/class.publico.inc.php';
// Recibo el número del lote
$lot = $_GET['lote'];
htmlDoc();
?>
<html <?php xm();?>>
<head>
<?php headPublico();?>
	<link rel="stylesheet" href="js/highslide/highslide.css" type="text/css" />
	<script src="js/highslide/highslide.js" type="text/javascript"></script>
	<script type="text/javascript">
		hs.graphicsDir = 'js/highslide/graphics/';
		hs.outlineType = 'rounded-white';
	</script>
</head>
<body>
	<div id="page-wrap">
        <div class="clear"></div>
<!-- Acciones Públicas -->
<?php
	$lid = $_GET['lote'];
	$detalles = new BipherPublico($db);
	$detalles->detallesDelLote($lid);
?>
	<p>
    <input type="button" class="button" value="Volver a la lista" onclick="history.back()"></input>
    <a href="index.php" class="button">Nueva búsqueda</a>
	</p>
	</div>
</body>
</html>
