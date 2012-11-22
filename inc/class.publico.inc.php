<?php
/**
 * Interacción de los usuarios públicos con la aplicacion
 */
class BipherPublico
{
    /**
    * The database object
    * @var objectg
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
 * Cargar la info de proximos remates y mostrarla en la cartelera (index)
 * según su ambito de publicacion y su fecha.
 * Recibe como parametros: un entero que es el ambito, y usa CURDATE()
*/
    public function ventaIndex($ambito) {
        switch($ambito) {
            //Solo Buscador (Remates Pasados)
            // levanta registros donde la fecha del remate es menor a hoy
            // y el ámbito (status_re) == 0
            case 0:
                $sql = "SELECT * FROM remates WHERE status_re =:ambito AND fecha_re<CURDATE() ORDER BY fecha_re DESC LIMIT 5";
            break;
            //Agenda de Remates - Sin enlace a lotes.
            // levanta registros donde la fecha de remate es mayor a ayer
            // y el ámbito es == 1 (Los formatea sin enlace a los lotes)
            case 1:
                $sql = "SELECT * FROM remates WHERE status_re =:ambito AND fecha_re>=CURDATE() ORDER BY fecha_re ASC LIMIT 5";
            break;
            //Catalogo (Destacado)
            // levanta registros donde la fecha de remate es mayor a ayer
            // y el ámbito es == 2 (Los formatea CON enlace al Catálogo
            // y los lotes)
            case 2:
                $sql = "SELECT * FROM remates WHERE status_re =:ambito AND fecha_re>=CURDATE() ORDER BY fecha_re ASC LIMIT 5";
            break;
            //Banners Top, Middle y Bottom respectivamente
            case 3:
            case 5:
            case 6:
                $sql = "SELECT ruta_banner, enlace_banner FROM controles WHERE ambito_banner =:ambito AND visible_banner = 1 ORDER BY orden_banner ASC LIMIT 1";
            break;
            //Banners LEFT
            case 4:
                $sql = "SELECT ruta_banner, enlace_banner FROM controles WHERE ambito_banner =:ambito AND visible_banner = 1 ORDER BY orden_banner ASC";
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
	// Discrimino si son remates o banners
		if($ambito < 3) // es un remate
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
			  // Es el encabezado de una lista de lotes
			  case -1:
				$dia = new DateTimeArgento($fec);
				$diaSemana = $dia->format('l');
				$abre = '<div style="padding-top: 20px;">';
				$venta = '<h2 class="centrado">Organizador: '.$org.'</h2>';
				$venta = $venta.'<div class="logotipo izquierda centrado"><img src="'.$log.'" alt="Logo de '.$org.'" /></div>';
				$venta = $venta.'<div id="datosubasta" class="centrado"><p><strong>'.$nom.'</strong></p>';
				$venta = $venta.'<p class="centrado">'.$car.' lotes a la venta. '.$met.'.</p>';
				$venta = $venta.'<p>Informes: '.$inf.'</p></div>';
				$venta = $venta.'<div class="fechagrande">'.$diaSemana.'<br />'.darVueltaFecha($fec).'<br />'.$hor.'hs.</div>';
				$cierra = '</div>';
			  break;
            //Solo Buscador
            case 0:
                $abre = '<div class="buscador">';
                $venta = '<span><a href="lista-lotes.php?subasta='.$rid.'" class="sindecorar"><img src="'.$log.'" width="50" height="35" class="centradovertical" /> &nbsp;'.darVueltaFecha($fec).' &nbsp; &nbsp;<strong>'.$org.'</strong>  &nbsp; &nbsp; '.$car.' lotes subastados</a></span>';
                $cierra = '</div>';
            break;
            // Agenda de Remates
            case 1:
                $abre = '<div class="despublicado">';
                $venta = '<div><span><img src="images/vineta-vaca.png" /> &nbsp;'.darVueltaFecha($fec).' &nbsp; &nbsp;<strong>'.$org.'</strong>  &nbsp; &nbsp; Informes:'.$inf.'</span></div>';
                $cierra = '</div>';
            break;
            // Catalogo Publicado
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
            //Por default solo el buscador
            default:
                $abre = '<div>';
                $cierra = '</div>';
            break;
            }
        return $abre.$venta.$cierra;
       }
       else // es un banner
       {
		 $ruta = $row['ruta_banner'];
		 $enlace = $row['enlace_banner'];
		 $venta = '<a href="'.$enlace.'" style="border:0px" target="_blank">';
		 $venta = $venta.'<img src="'.$ruta.'" alt="banner" />';
		 $venta = $venta.'</a>';
		 $cierra = '</div>';
		 switch($ambito)
			{
				case 3:
				case 5:
				$abre = '<div class="banner720">';
					break;
				case 6:
				$abre = '<div class="banner720">';
					break;
				case 4:
				$abre = '<div class="bannerleft">';
					break;
			}
			return $abre.$venta.$cierra;
		}
    }
/*
* Mostrar los detalles del lote
*/
	public function detallesDelLote($lid)
	{
		$sql ="SELECT * FROM lotes, localidades, provincias, remates, categorias WHERE lote_id =:lid AND localidad_lo = localidades.localidad_id AND provincia_lo = provincias.provincia_id AND lotes.remate_id = remates.remate_id AND categoria_lo = categorias.categoria_id LIMIT 1";
		try
		{
		$stmt = $this->_db->prepare($sql);
		$stmt->bindParam(':lid', $lid, PDO::PARAM_INT);
		$stmt->execute();
		while($w = $stmt->fetch())
			{
			echo '<div id="contenedor-de-lote" class="guarda">';
			echo '<div id="fotos">';
			echo $this->formatearFotosLote($w['foto_1'],$w['foto_2'],$w['foto_3'],$w['foto_4']);

			echo $this->embeberVideoLote($w['video']);
			echo '</div>';
			echo $this->formatearDetallesLote($w);

			echo $this->llamarMapa($w['latitud'],$w['longitud']);
			echo '<div class="clear"><br /></div>';
			echo '</div>';
			}
		$stmt->closeCursor();
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
/*
* Dar formato a las fotos del lote
*/
	private function formatearFotosLote($f1,$f2,$f3,$f4)
	{

		echo '<ul id="galeria">';
		echo '<li><a href="'.$f1.'" class="highslide" onclick="return hs.expand(this)"><img src="'.$f1.'" alt="Clic para ampliar" /></a></li>';
		echo '<li><a href="'.$f2.'" class="highslide" onclick="return hs.expand(this)"><img src="'.$f2.'" alt="Clic para ampliar" /></a></li>';
		echo '<li><a href="'.$f3.'" class="highslide" onclick="return hs.expand(this)"><img src="'.$f3.'" alt="Clic para ampliar" /></a></li>';
		echo '<li><a href="'.$f4.'" class="highslide" onclick="return hs.expand(this)"><img src="'.$f4.'" alt="Clic para ampliar" /></a></li>';

	}
/*
* Formatear Detalles del Lote
*/
	private function formatearDetallesLote($w)
	{
		echo '<div id="datalote">';
		echo '<div id="certificador"><img src="'.$w['logo_re'].'" /><p>Organizador: <strong>'.$w['organizador'].'</strong></p></div>';
			echo '<ul>';
					echo '<li class="lysta">Fecha de comercialización: <strong>'.darVueltaFecha($w['fecha_lo']).'</strong></li>';
//					echo '<br></br>';
					echo '<li class="lysta">Origen de la hacienda: <strong>'.$w['localidad'].' - '.$w['provincia'].'</strong></li>';
					echo '<li class="lysta">Certificado/Designación: <strong>'.$w['num_lo'].'</strong></li>';
					echo '<li class="lysta">Categoría: <strong>'.$w['categoria'].'</strong></li>';
					echo '<li>Detalles: <strong>'.$w['subcategoria'].'</strong></li>';
//					echo '<br></br>';
					echo '<li class="lysta">Método de comercialización: <strong>'.$w['metodo'].'</strong></li>';
//					echo '<br></br>';
					echo '<li class="lysta">Cabezas: <strong>'.$w['cabezas'].'</strong></li>';
//					echo '<br></br>';
					echo '<li class="lysta">Raza: <strong>'.$w['raza'].'</strong></li>';
//					echo '<br></br>';
					echo '<li class="lysta">Peso: <strong>'.$w['peso'].'</strong></li>';
//					echo '<br></br>';
					echo '<li class="lysta">Precio: <strong>'.'$ '.$w['precio'].'</strong></li>';
//					echo '<br></br>';
					echo '<li class="lysta">Plazo: <strong>'.$w['plazo'].'</strong></li>';
//					echo '<br></br>';
					echo '<li class="lysta">Observaciones: <strong>'.$w['notas'].'</strong></li>';
					echo '</ul>';
			echo '</div>';
			echo '<div class="clear"><br /></div>';
	}
/*
* Formatea el mapa de google
*/
	private function llamarMapa($lat,$lon)
	{
		$la = ($lat * (-1));
		$lo = ($lon * (-1));
		echo '<div id="mapa">';
		echo '<img src="http://maps.google.com/maps/api/staticmap?center='.$la.','.$lo.'&zoom=10&size=800x360&markers=size:mid|color:blue|label:L|'.$la.','.$lo.'&sensor=false" />';
		echo '</div>';
	}
/*
* Embeber el video del lote
*/
	private function embeberVideoLote($vid)
	{
		echo '<div id="videolote">';
		echo '<object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="340" height="279">
		<param name="movie" value="files/player.swf" />
		<param name="allowfullscreen" value="true" />
		<param name="allowscriptaccess" value="always" />';
		echo '<param name="flashvars" value="../'.$vid.'&image=images/000.jpg" />';
		echo '<embed
			type="application/x-shockwave-flash"
			id="player2"
			name="player2"
			src="files/player.swf"
			width="352"
			height="288"
			allowscriptaccess="always"
			allowfullscreen="true"
			flashvars="file=../'.$vid.'&image=images/000.jpg"
		/>
	</object>';
		echo '</div>';
	}
/*
* Cargar datos de un remate para su catálogo
*/
	public function cargaDatosRemate($ri, $ambito)
	{
		$sql = "SELECT * FROM remates WHERE remate_id =:ri LIMIT 1";
			try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':ri', $ri, PDO::PARAM_INT);
			$stmt->execute();
		//Muestra la venta de la cartelera con formato
			while($row = $stmt->fetch())
			{
				echo $this->formatearVenta($row, $ambito);
			}
			$stmt->closeCursor();
		}
		catch(PDOException $e)
		{
			return FALSE;
		}
	}
/*
* Muestra los lotes en tabla agrupados por categoria
* recibe el ID de remate y el entero de la categoría
*/
	public function ordenaLotesPorCategoria($ri)
	{
		$sql = "SELECT localidades.localidad, provincias.provincia, lotes.categoria_lo, lotes.subcategoria, lotes.num_lo, lotes.orden_lo, lotes.lote_id FROM localidades, provincias, lotes WHERE lotes.remate_id =:re AND provincias.provincia_id = localidades.provincia_id AND lotes.localidad_lo = localidades.localidad_id ORDER BY orden_lo ASC";
	try
	{
		$stmt = $this->_db->prepare($sql);
		$stmt->bindParam(':re', $ri, PDO::PARAM_INT);
		$stmt->execute();
			echo '<table class="ensayo" summary="Lotes cargados" cellspacing="0">';
			echo '<tbody>';
			echo '<tr class="principal">';
			echo '<th></th><th>Lote</th><th>Orden</th><th>Origen</th><th>Categoría</th><th>Detalles</th><th></th>';
			echo '</tr>';
			echo '<tr>';
			while($row = $stmt->fetch())
			{
				$lok = $row['localidad'];
				$prv = $row['provincia'];
				$kat = $row['categoria_lo'];
				$sbk = $row['subcategoria'];
				$nlo = $row['num_lo'];
				$ord = $row['orden_lo'];
				$lid = $row['lote_id'];
				echo '<tr>';
				echo '<td><a class="sinborde desplazarpoco" href="detalleslote.php?lote='.$lid.'"><img src="images/vineta-vaca.png" /></a></td>';
				echo '<td>'.$nlo.'</td>';
				echo '<td><strong>&nbsp; &nbsp;'.noMostrarSiEsCero($ord).'</strong></td>';
				echo '<td>'.$lok.' - '.$prv.'</td>';
				echo '<td>'.decirCategoria($kat).'</td>';
				echo '<td>'.$sbk.'</td>';
				echo '<td><a href="detalleslote.php?lote='.$lid.'">Ver</a></td>';
				echo '</tr>';
			}
			echo '</table>';
			$stmt->closeCursor();
		}
	catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
// FIN DE LA CLASE
}
?>
