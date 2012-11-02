<?php
/**
 * Interacción de los usuarios públicos con la aplicacion
 */
class BipherPublico
{
    /**
    * The database object
    * @var object
    */
    private $_db;
    /**
    * Chequea un database object y lo crea si no lo encuentra
    * @param object $db
    * @return void
    */
    public function __construct($db=NULL)
    {
        if(is_object($db))
        {
            $this->_db = $db;
        }
        else
        {
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
            $this->_db = new PDO($dsn, DB_USER, DB_PASS);
        }
    }
/*
*Recupera la lista de remates ordenados desc por fecha
*/
    public function listaRemates()
    {
        $sql = "SELECT remate_id, fecha_re, organizador, status_re FROM remates WHERE fecha_re > DATE_ADD(CURDATE(), INTERVAL -300 DAY) ORDER BY fecha_re DESC;";
    try {
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();
        echo '<table class="ensayo" summary="Remates de hacienda cargados en Bipher" cellspacing="0">';
        echo '<tbody>';
        echo '<tr class="principal">';
        echo '<th>ID</th><th>Fecha</th><th>Organizador</th><th>&Aacute;mbito de Publicaci&oacute;n</th><th></th><th></th><th></th><th></th>';
        echo '</tr>';
        echo '<tr>';
        while($row = $stmt->fetch()) {
            $rid = $row['remate_id'];
            $fecha = $row['fecha_re'];
            $orga = $row['organizador'];
            $stat = $row['status_re'];
            echo "<tr>";
            echo "<td>" .$rid."</td>";
            echo "<td>" .$fecha."</td>";
            echo "<td>" .$orga."</td>";
            echo "<td>" .$stat."</td>";
            echo '<td><a href="editar-remate.php?subasta='.$rid.'">Editar</a></td>';
            echo '<td><a href="eliminar-remate.php?subasta='.$rid.'">Borrar</a></td>';
            echo '<td><a href="c-editar.php?subasta='.$rid.'">Catálogo</a></td>';
            echo '<td><a href="nuevo-lote.php?subasta='.$rid.'&lote=nuevo">Lotes</a></td>';
            echo "</tr>";
        }
        echo "<table>";
        $stmt->closeCursor();
    }
    catch(PDOException $e)
        {
            print_r($e->getMessage());
        }
    }
/*
 * Enuncia los criterios de búsqueda y muestra los resultados
 * @param municipio
 * @param provincia
 * @param categoria
 * @param radio
 * @return Una cadena con los criterios seleccionados y una tabla
 *         con todos los lotes encontrados
 */
    public function buscarLotesEnMiRadio($municipio, $provincia, $categoria, $radio)
    {
        $sql = "SELECT localidad, latitud, longitud, categoria FROM localidades, categorias WHERE localidad_id= :municipio AND categoria_id= :categoria LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':municipio', $municipio, PDO::PARAM_INT);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            $stmt->execute();
            foreach ($stmt as $row) {
                $long = $row['longitud'];
                $lato = $row['latitud'];
                echo '<ul class="tabular"><li>Punto de Referencia: <strong>' .$row['localidad'].'</strong></li>';
                echo '<li>Categor&iacute;a buscada: <strong>'.$row['categoria'].'</strong></li>';
                if ($radio == 4000) {
                    echo '<li>Radio de b&uacute;squeda: <strong>Todo el pa&iacute;s</strong></li>';
                } else {
                    echo '<li>Radio de b&uacute;squeda: <strong>'.$radio.' km.</strong></li>';
                }
                echo '</ul>';
            }
            $stmt->closeCursor();
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
        //recuperar localidades en km de radio
        switch($radio) {
            case 150:
        $sql = "SELECT lotes.lote_id, lotes.fecha_lo, lotes.raza, lotes.peso, lotes.precio, lotes.categoria_lo, lotes.localidad_lo, localidades.localidad_id, localidades.localidad, localidades.latitud, localidades.longitud, remates.organizador FROM lotes, localidades, remates WHERE latitud BETWEEN ($lato - 1.3513) AND ($lato + 1.3513) AND longitud BETWEEN ($long - 1.3513) AND ($long + 1.3513) AND localidad_lo = localidad_id AND categoria_lo= :categoria AND lotes.remate_id = remates.remate_id AND lotes.fecha_lo > DATE_ADD(CURDATE(), INTERVAL -60 DAY) AND lotes.precio > 0 ORDER BY lotes.fecha_lo DESC";
            break;
            case 250:
        $sql = "SELECT lotes.lote_id, lotes.fecha_lo, lotes.raza, lotes.peso, lotes.precio, lotes.categoria_lo, lotes.localidad_lo, localidades.localidad_id, localidades.localidad, localidades.latitud, localidades.longitud, remates.organizador FROM lotes, localidades, remates WHERE latitud BETWEEN ($lato - 2.25225) AND ($lato + 2.25225) AND longitud BETWEEN ($long - 2.25225) AND ($long + 2.25225) AND localidad_lo = localidad_id AND categoria_lo= :categoria AND lotes.remate_id = remates.remate_id AND lotes.fecha_lo > DATE_ADD(CURDATE(), INTERVAL -60 DAY) AND lotes.precio > 0 ORDER BY lotes.fecha_lo DESC";
            break;
            case 350:
        $sql = "SELECT lotes.lote_id, lotes.fecha_lo, lotes.raza, lotes.peso, lotes.precio, lotes.categoria_lo, lotes.localidad_lo, localidades.localidad_id, localidades.localidad, localidades.latitud, localidades.longitud, remates.organizador FROM lotes, localidades, remates WHERE latitud BETWEEN ($lato - 3.15315) AND ($lato + 3.15315) AND longitud BETWEEN ($long - 3.15315) AND ($long + 3.15315) AND localidad_lo = localidad_id AND categoria_lo= :categoria AND lotes.remate_id = remates.remate_id AND lotes.fecha_lo > DATE_ADD(CURDATE(), INTERVAL -60 DAY) AND lotes.precio > 0 ORDER BY lotes.fecha_lo DESC";
            break;
            case 4000:
        $sql = "SELECT lotes.lote_id, lotes.fecha_lo, lotes.raza, lotes.peso, lotes.precio, lotes.categoria_lo, lotes.localidad_lo, localidades.localidad_id, localidades.localidad, localidades.latitud, localidades.longitud, remates.organizador FROM lotes, localidades, remates WHERE localidad_lo = localidad_id AND categoria_lo= :categoria AND lotes.remate_id = remates.remate_id AND lotes.fecha_lo > DATE_ADD(CURDATE(), INTERVAL -60 DAY) AND lotes.precio > 0 ORDER BY lotes.fecha_lo DESC";
            break;
            default:
        $sql = "SELECT lotes.lote_id, lotes.fecha_lo, lotes.raza, lotes.peso, lotes.precio, lotes.categoria_lo, lotes.localidad_lo, localidades.localidad_id, localidades.localidad, localidades.latitud, localidades.longitud, remates.organizador FROM lotes, localidades, remates WHERE localidad_lo = localidad_id AND categoria_lo = :categoria AND lotes.remate_id = remates.remate_id AND lotes.fecha_lo > DATE_ADD(CURDATE(), INTERVAL -60 DAY) AND lotes.precio > 0 ORDER BY lotes.fecha_lo DESC";
            break;
        }
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            $stmt->execute();
            $recuperarTodos = $stmt->fetchAll();
            $totalRegistros = count($recuperarTodos);
            echo 'Hay '.$totalRegistros.' registros.';
            if($totalRegistros==0) {
                echo "<h2>No se encontraron lotes</h2>"."<p>Intente de nuevo ampliando los criterios de búsqueda.</p>";
                $stmt->closeCursor();
            } else {
                $stmt->execute();
                echo '<table class="ensayo" summary="Lotes de hacienda comercializados durante estos 60 dias" cellspacing="0">';
                echo '<tbody>';
                echo '<tr class="principal">';
                echo '<th>Fecha</th><th>Origen</th><th>Organizador</th><th>Raza</th><th>Peso</th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Precio</th><th></th>';
                echo '</tr>';
                echo '<tr>';
                    foreach ($stmt as $v) {
                        $lid = $v['lote_id'];
                        echo '<td>'.darVueltaFecha($v['fecha_lo']).'</td><td>'.$v['localidad'].'</td><td>'.$v['organizador'].'</td><td>'.$v['raza'].'</td><td>'.$v['peso'].'</td><th>'.'$ '.$v['precio'].'</th><td><a href="detalleslote.php?lote='.$lid.'">Ver</a></td>';
                        echo '</tr>';
                    }
                echo '</tbody>';
                echo '</table>';
                $stmt->closeCursor();
            }
    }
/*
 *Cargar la info de proximos remates y mostrarla en la cartelera
 *según su ambito de publicacion y su fecha.
 *Recibe como parametros: un entero que es el ambito, y usa CURDATE()
*/
    public function ventaCatalogo($ambito) {
        switch($ambito) {
            //Solo Buscador (Remates Pasados)
            case 0:
                $sql = "SELECT * FROM remates WHERE status_re =:ambito AND fecha_re<CURDATE() ORDER BY fecha_re DESC LIMIT 5";
            break;
            //Catalogo Despublicado (Agenda de Remates) - Sin enlace a lotes.
            case 1:
                $sql = "SELECT * FROM remates WHERE status_re =:ambito AND fecha_re>=CURDATE() ORDER BY fecha_re ASC";
            break;
            //Catalogo Publicado (Destacado)
            case 2:
                $sql = "SELECT * FROM remates WHERE status_re =:ambito AND fecha_re>=CURDATE() ORDER BY fecha_re ASC LIMIT 3";
            break;
            //Subasta Hoy (un destacado para el remate de hoy)
            case 3:
                $sql = "SELECT * FROM remates WHERE status_re =:ambito AND fecha_re=CURDATE() LIMIT 1";
            break;
            //Por default solo el buscador
            default:
                $sql = "SELECT * FROM remates WHERE status_re =:ambito AND fecha_re<CURDATE() ORDER BY fecha_re DESC LIMIT 5";
            break;
        }
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':ambito', $ambito, PDO::PARAM_INT);
            $stmt->execute();
        //Cuento los resultados y si no hay cierro el cursor
            $recuperarTodos = $stmt->fetchAll();
            $totalRegistros = count($recuperarTodos);
            if($totalRegistros>0) {
                $stmt->execute();
                while($row = $stmt->fetch()) {
                echo $this->formatearVenta($row, $ambito);
                }
            $stmt->closeCursor();
            } else {
                $stmt->closeCursor();
            }
        }
        catch(PDOException $e)
        {
            return FALSE;
        }
    }
/*
*  FORMATEAR LAS VENTAS DE LA CARTELERA
*/
    private function formatearVenta($row, $ambito)
    {
        $rid = $row['remate_id'];
        $fec = $row['fecha_re'];
        $hor = $row['hora_re'];
        $org = $row['organizador'];
        $met = $row['metodo'];
        $log = $row['logo_re'];
        $nom = $row['nombre_re'];
        $car = $row['cardinal_re'];
        $inf = $row['informes_re'];
        $salto = '<br />';

        switch($ambito)
            {
            //Solo Buscador
            case 0:
                $abre = '<div class="buscador">';
                $venta = '<div><span><a href="p-catalogo.php?subasta='.$rid.'" class="sindecorar"><img src="images/vineta-vaca.png" /> &nbsp;'.darVueltaFecha($fec).' &nbsp; &nbsp;<strong>'.$org.'</strong>  &nbsp; &nbsp; '.$car.' lotes subastados</a></span></div>';
                $cierra = '<br /></div>';
            break;
            //Catalogo Despublicado (Equivale a Agenda de Remates)
            case 1:
                $abre = '<div class="despublicado">';
                $venta = '<div><span><img src="images/vineta-vaca.png" /> &nbsp;'.darVueltaFecha($fec).' &nbsp; &nbsp;<strong>'.$org.'</strong>  &nbsp; &nbsp; Informes:'.$inf.'</span></div>';
                $cierra = '</div>';
            break;
            //Catalogo Publicado
            case 2:
                $dia = new DateTimeArgento($fec);
                $diaSemana = $dia->format('l');
                $abre = '<div class="televisado">';
                $venta = '<p><strong>'.$nom.'</strong></p>';
                $venta = $venta.'<div class="fechagrande">'.$diaSemana.'<br />'.darVueltaFecha($fec).'<br />'.$hor.' hs</div>';
                $venta = $venta.'<div class="verlotes"><a class="sinborde" href="p-catalogo.php?subasta='.$rid.'"><img src="images/verlotes.png" alt="Logo de '.$org.'" /></a></div>';
                $venta = $venta.'<div class="logotipo izquierda"><a class="sinborde" href="p-catalogo.php?subasta='.$rid.'"><img src="'.$log.'" alt="Logo de '.$org.'" /></a></div>';
                $venta = $venta.'<div class="clear"></div>';
                $venta = $venta.'<p>Organiza: <strong>'.$org.'</strong></p>';
                $venta = $venta.'<p>'.$met.'</p>';
                $cierra = '</div>';
            break;
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
            //Por default solo el buscador
            default:
                $abre = '<div class="buscador">';
                $cierra = '</div>';
            break;
            }
        return $abre.$venta.$cierra;
    }
/*
 * Mostrar los detalles de un lote
 * @param lid : un entero que es el id del lote
 * @return : una lista con los datos del lote
 */
    public function detallesLote($idLote)
    {
        $sql ="SELECT * FROM lotes, localidades, provincias, remates, categorias WHERE lote_id = :lot AND localidad_lo = localidad_id AND provincia_lo = provincias.provincia_id AND lotes.remate_id = remates.remate_id AND categoria_lo= categoria_id LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->bindParam(':lot', $idLote, PDO::PARAM_INT);
            $stmt->execute();
            foreach ($stmt as $w) {
                    echo '<ul class="tabular">';
                    echo '<li class="lysta">Fecha de comercializaci&oacute;n: <strong>'.darVueltaFecha($w['fecha_lo']).'</strong></li>';
//                  echo '<br></br>';
                    echo '<li class="lysta">Origen de la hacienda: <strong>'.$w['localidad'].' - '.$w['provincia'].'</strong></li>';
//                  echo '<br></br>';
                    echo '<li class="lysta">Categor&iacute;a: <strong>'.$w['categoria'].'</strong></li>';
//                  echo '<br></br>';
                    echo '<li class="lysta">Organizador de la subasta: <strong>'.$w['organizador'].'</strong></li>';
//                  echo '<br></br>';
                    echo '<li class="lysta">M&eacute;todo de comercializaci&oacute;n: <strong>'.$w['metodo'].'</strong></li>';
//                  echo '<br></br>';
                    echo '<li class="lysta">Cabezas: <strong>'.$w['cabezas'].'</strong></li>';
//                  echo '<br></br>';
                    echo '<li class="lysta">Raza: <strong>'.$w['raza'].'</strong></li>';
//                  echo '<br></br>';
                    echo '<li class="lysta">Peso: <strong>'.$w['peso'].'</strong></li>';
//                  echo '<br></br>';
                    echo '<li class="lysta">Precio: <strong>'.'$ '.$w['precio'].'</strong></li>';
//                  echo '<br></br>';
                    echo '<li class="lysta">Plazo: <strong>'.$w['plazo'].'</strong></li>';
//                  echo '<br></br>';
                    echo '<li class="lysta">Observaciones: <strong>'.$w['notas'].'</strong></li>';
                    echo '</ul>';
                    echo '<br></br>';
            }
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
    }
// FIN DE LA CLASE
}
?>
