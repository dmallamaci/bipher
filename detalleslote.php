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
</head>
<body>
<!-- Acciones Públicas -->
        <h2>Detalles del lote</h2>
            <br/>
<?php
$unLote = new BipherPublico($db);
$unLote->detallesLote($lot);
?>
<p>
    <input type="button" class="button" value="Volver a la lista" onclick="history.back()"></input>
    <a href="index.php" class="button">Nueva búsqueda</a>
</p>               
</body>
</html>