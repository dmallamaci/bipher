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
		<h2>Encuentre lor precios de referencia cerca de su localidad</h2>
		<p>Seleccione los criterios de su búsqueda indicando la categoría de hacienda de su interés, la localidad o punto de referencia y el área de búsqueda. <strong>ELRURAL.COM</strong> devolverá todos los lotes comercializados en esa zona durante los últimos 60 días.</p>
		<div id="barrabuscalotes"><h2 class="barratit">Buscar lotes</h2></div>
            <div id="bipher">
    <form method="post" action="res-lotes.php" id="filtrarlotes">
                <div id="combos">
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
            <option value="4000">Buscar en todo el País</option>
            <option value="350">Buscar en 350 km de radio</option>
            <option value="250">Buscar en 250 km de radio</option>
            <option value="150">Buscar en 150 km de radio</option>
        </select>
            </div>
            <div id="botonbuscar">
        <input type="image" src="images/boton_buscalotes.png" name="centrocoord" id="filtrarlotes" />
                </div>
    </form>
            </div>
        </div>
<?php
// Banner TOP, si existe
$ca3 = new BipherPublico($db);
$ca3->ventaIndex(3);
?>
<div id="contenedor">
<!-- comienzan LOS BANNERS DE LEFT -->
    <div class="avisos">
<?php
// Banners LEFT
$ca4 = new BipherPublico($db);
$ca4->ventaIndex(4);
?>
    </div>
<!-- Terminan LOS BANNERS DE LEFT -->

<!-- Comienza la columna de Próximos remates -->
		<div id="proximosremates">
			<h2 class="barratit blanco">Próximos Remates Destacados</h2>
<?php
$ca2 = new BipherPublico($db);
$ca2->ventaIndex(2);

	echo '<div id="agenda">';
	echo '<h2 class="barratit blanco">Agenda de futuras subastas</h2>';
	echo '</div>';
$ca1 = new BipherPublico($db);
$ca1->ventaIndex(1);
?>
	<div id="botonagenda">
	<a href="agenda.php" class="sinborde"><img src="images/boton_veragenda.png" /></a>
	</div>
        </div>
<!-- Termina la columna de Próximos remates -->
</div>
<div class="clear"></div>
<?php
// Banner MIDDLE si existe
$ca5 = new BipherPublico($db);
$ca5->ventaIndex(5);
?>
<div id="ultimosremates">
<h2 class="barratit blanco">Últimos remates televisados</h2>
</div>
<?php
// Lista de Remates Pasados (Buscador)
$ca0 = new BipherPublico($db);
$ca0->ventaIndex(0);
// Banner BOTTOM, si existe
$ca6 = new BipherPublico($db);
$ca6->ventaIndex(6);
?>
<!-- Fin de los contenidos -->
    </div>
</body>
</html>
