<?php
include_once 'comun/publico.php';
include_once 'inc/class.publico.inc.php';
    $kid = $_POST['municipio'];
    $prv = $_POST['provincia'];
    $cat = $_POST['categoria'];
    $rio = $_POST['radio'];
// si se olvidan de marcar la categoria o la provincia
    if ($prv == 0) $kid = 1;
    if ($cat == 0) $cat = 2;
htmlDoc();
?>
<html <?php xm();?>>
<head>
<?php headPublico();?>
</head>
<body>
	<div id="page-wrap">
        <div class="clear"></div>
<!-- Acciones Públicas -->
<?php
$listaLotes = new BipherPublico($db);
$listaLotes->buscarLotesEnMiRadio($kid, $prv, $cat, $rio);
?>
	<p>&nbsp;</p>
    <p><a href="index.php" class="button">Nueva búsqueda</a></p>

        </div>
</body>
</html>
