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
        <div id="logocartelera">
            <div id="bipher" class="centrado">
    <form method="post" action="res-lotes.php" id="filtrarlotes">
                <div>
        <input type="hidden" name="action" value="ver" />
        <?php include 'comun/categorias-select.php'; ?>
            <br/>
        <select id="provincia" name="provincia">
            <option>Cargando...</option>
        </select>
            <br/>
        <select id="municipio" name="municipio">
            <option>Seleccione una Localidad</option>
        </select>
            <br />
        <select id="radio" name="radio">
            <option value="150">Buscar en 150 km de radio</option>
            <option value="250">Buscar en 250 km de radio</option>
            <option value="350">Buscar en 350 km de radio</option>
            <option value="4000">Buscar en todo el País</option>
        </select>
            <br/>
        <input type="submit" name="centrocoord" id="filtrarlotes" value="Buscar Lotes" class="button" />
                </div>
    </form>
            </div>
        </div>
<?php
// Venta del remate de Hoy y enlace a TX en Vivo
$ca3 = new BipherPublico($db);
$ca3->ventaCatalogo(3);
?>
<!--
comienzan LOS BANNERS DE PUBLICIDAD
-->
    <div class="avisos">Aqui va publicidad<img src="images/lart.png" /></div>
    <div class="avisos">Aqui va publicidad<img src="images/lart.png" /></div>
    <div class="avisos">Aqui va publicidad<img src="images/lart.png" /></div>
<!-- Termina la publicidad -->
</div>
<!-- Comienza la columna de Próximos remates -->
        <div id="proximosremates">
<?php
$ca2 = new BipherPublico($db);
$ca2->ventaCatalogo(2);
$ca1 = new BipherPublico($db);
$ca1->ventaCatalogo(1);
?>
        </div>
    </div>
</body>
</html>
