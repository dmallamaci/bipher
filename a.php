<?php
//Enlazar a transmisión en vivo de CR
            case 3:
                $dia = new DateTimeArgento($fec);
                $diaSemana = $dia->format('l');
                $abre = '<div id="subastaahora">';
                $venta = '<p><strong>'.$nom.'</strong></p>';
                $venta = $venta.'<div class="logotipo"><img src="'.$log.'" alt="Logo de '.$org.'" /></div>';
                $venta = $venta.'<div class="fechagrande">'.$diaSemana.'<br />'.darVueltaFecha($fec).'<br />'.$hor.'hs.</div>';
                $venta = $venta.'<p>Organiza: <strong>'.$org.'</strong></p>';
                $venta = $venta.'<p><a class="vercatalogo" href="#">+ Ver Remate</a><p>';
                $cierra = '</div>';
            break;
            //XXX Es la cabecera del catalogo para este remate
            case 7:
                $dia = new DateTimeArgento($fec);
                $diaSemana = $dia->format('l');
                $abre = '<div>';
                $venta = '<h2 class="centrado">Organiza: '.$org.'</h2>';
                $venta = $venta.'<div class="logotipo izquierda centrado"><img src="'.$log.'" alt="Logo de '.$org.'" /></div>';
                $venta = $venta.'<div id="datosubasta" class="izquierda"><p><strong>'.$nom.'</strong></p>';
                $venta = $venta.'<p>Son '.$car.' lotes a la venta. '.$met.'.</p>';
                $venta = $venta.'<p>Informes: '.$inf.'</p></div>';

                $venta = $venta.'<div class="fechagrande">'.$diaSemana.'<br />'.darVueltaFecha($fec).'<br />'.$hor.'hs.</div>';
                $cierra = '</div>';
            break;
            //XXX Es la cabecera del detalle de lote para este remate
            case 8:
                $abre = '<div class="xxxxxxxx">';
                $venta = '<h2>'.$nom.'</h2>';
                $venta = $venta.'<div class="logotipo"><img src="'.$log.'" alt="Logo de '.$org.'" /></div>';
                $venta = $venta.'<div class="fechagrande">'.darVueltaFecha($fec).' - '.$hor.'hs.</div>';
                $venta = $venta.'<p>Organiza: <strong>'.$org.'</strong></p>';
                $venta = $venta.'<p>Son '.$car.' lotes a la venta en '.$met.'.<p>';
                $venta = $venta.'<p>Informes: '.$inf.'<p>';
                $cierra = '</div>';
            break;
?>














<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="js/desplegable.js" type="text/javascript"></script>
</head>
<body>
    <h1>Conexión</h1>
    <form>
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
                <option value="4000">Buscar en todo el Pa&iacute;s</option>
         </select>
        <br/>
                <input type="submit" name="centrocoord"
                    id="filtrarlotes" value="Buscar Lotes"
                    class="button" />

    </form>
    <?php
/*
        echo 'hola';
        $listarem = new BipherPublico($db);
        $listarem->listaRemates();
*/


    ?>
</body>
</html>
