<?php
/**
 * Maneja los remates y lotes con la aplicacion
 */
class BipherHacienda
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
*Agrega un remate
*/
	public function agregarRemate()
	{
		$fecha = darVueltaFecha($_POST['fecha_re']);
		$hora = $_POST['hora_re'];
		$orga = $_POST['organizador'];
		$meto = $_POST['metodo'];
		$logo = trim($_POST['logo_re']);
		$nomb = $_POST['nombre_re'];
		$info = $_POST['informes_re'];
		$stat = (int) $_POST['status_re'];
		$card = 0;

		$sql = "INSERT INTO remates (fecha_re, hora_re, organizador, metodo, logo_re, nombre_re, informes_re, status_re, cardinal_re) VALUES (:fecha, :hora, :orga, :meto, :logo, :nomb, :info, :stat, :card)";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':fecha', $fecha, PDO::PARAM_INT);
			$stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
			$stmt->bindParam(':orga', $orga, PDO::PARAM_STR);
			$stmt->bindParam(':meto', $meto, PDO::PARAM_STR);
			$stmt->bindParam(':logo', $logo, PDO::PARAM_STR);
			$stmt->bindParam(':nomb', $nomb, PDO::PARAM_STR);
			$stmt->bindParam(':info', $info, PDO::PARAM_STR);
			$stmt->bindParam(':stat', $stat, PDO::PARAM_INT);
			$stmt->bindParam(':card', $card, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
/*
* Incrementar Cardinalidad de Remate (Orden de lotes)
*/
	private function cardinalRemate($cardinal, $remate)
	{
	$misql = "UPDATE remates SET cardinal_re = :card WHERE remate_id = :reid";
		try
		{
			$stmt = $this->_db->prepare($misql);
			$stmt->bindParam(':card', $cardinal, PDO::PARAM_INT);
			$stmt->bindParam(':reid', $remate, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();

			return TRUE;
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
/*
* Agregar un lote
*/
	public function agregarLote()
	{
		$rei = $_POST['remate'];
		$car = (int) $_POST['cardinal_re'];
		$ord = $car + 1;
		$fec = $_POST['fecha'];
		$nlo = $_POST['numerolote'];
		$prv = $_POST['provincia'];
		$lok = $_POST['municipio'];
		$cat = $_POST['categoria'];
		$sub = $_POST['subcategoria'];
		$cab = $_POST['cabezas'];
		$raz = $_POST['raza1'].$_POST['raza2'];
		$pes = $_POST['peso'];
		$prc = $_POST['precio'];
		$plz = $_POST['plazo'];
		$nos = $_POST['ctr'].$_POST['str'].$_POST['cex'].$_POST['sco'].$_POST['csv'].$_POST['nsc'].$_POST['cmi'].$_POST['cgr'].$_POST['notas'];



		$sql = "INSERT INTO lotes (fecha_lo, provincia_lo, localidad_lo, categoria_lo, subcategoria, cabezas, raza, peso, precio, plazo, notas, remate_id, num_lo, orden_lo) VALUES (:fec, :prv, :lok, :cat, :sub, :cab, :raz, :pes, :prc, :plz, :nos, :rei, :nlo, :ord)";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':fec', $fec, PDO::PARAM_INT);
			$stmt->bindParam(':prv', $prv, PDO::PARAM_STR);
			$stmt->bindParam(':lok', $lok, PDO::PARAM_STR);
			$stmt->bindParam(':cat', $cat, PDO::PARAM_STR);
			$stmt->bindParam(':sub', $sub, PDO::PARAM_STR);
			$stmt->bindParam(':cab', $cab, PDO::PARAM_STR);
			$stmt->bindParam(':raz', $raz, PDO::PARAM_STR);
			$stmt->bindParam(':pes', $pes, PDO::PARAM_STR);
			$stmt->bindParam(':prc', $prc, PDO::PARAM_STR);
			$stmt->bindParam(':plz', $plz, PDO::PARAM_STR);
			$stmt->bindParam(':nos', $nos, PDO::PARAM_STR);
			$stmt->bindParam(':rei', $rei, PDO::PARAM_INT);
			$stmt->bindParam(':nlo', $nlo, PDO::PARAM_STR);
			$stmt->bindParam(':ord', $ord, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();

			}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}

		$c = $this->cardinalRemate($ord, $rei);
	}
/*
* Agregar una
*/
/*
*Recupera la lista de remates ordenados desc por fecha
*/
	public function listaRemates()
	{
//		$sql = "SELECT remate_id, fecha_re, organizador, status_re FROM remates WHERE fecha_re > DATE_ADD(CURDATE(), INTERVAL -200 DAY) ORDER BY fecha_re DESC;";
		$sql = "SELECT remate_id, fecha_re, hora_re, organizador, status_re, cardinal_re FROM remates ORDER BY fecha_re DESC";
	try
	{
		$stmt = $this->_db->prepare($sql);
		$stmt->execute();
		echo '<table class="ensayo" summary="Remates de hacienda cargados en Bipher" cellspacing="0">';
		echo '<tbody>';
		echo '<tr class="principal">';
		echo '<th>ID</th><th>Fecha</th><th>Hora</th><th>Organizador</th><th>Ámbito de Publicación</th><th>#Lotes</th><th></th><th></th><th></th>';
		echo '</tr>';
		echo '<tr>';
		while($row = $stmt->fetch())
		{
			$rid = $row['remate_id'];
			$fecha = $row['fecha_re'];
			$hora = $row['hora_re'];
			$orga = $row['organizador'];
			$stat = $row['status_re'];
			$card = $row['cardinal_re'];
			echo "<tr>";
			echo "<td>" .$rid."</td>";
			echo "<td>" .darVueltaFecha($fecha)."</td>";
			echo "<td>" .$hora."</td>";
			echo "<td>" .$orga."</td>";
			echo "<td>" .ambitoDePublicacion($stat)."</td>";
			echo "<td>" .$card."</td>";
			echo '<td><a href="editar-remate.php?subasta='.$rid.'">Editar</a></td>';
			echo '<td><a href="eliminar-remate.php?subasta='.$rid.'">Borrar</a></td>';
			echo '<td><a href="nuevo-lote.php?subasta='.$rid.'&lote=nuevo">Lotes</a></td>';
			echo "</tr>";
		}
		echo "<table>";
		$stmt->closeCursor();
	}
	catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
/*
* Recupera la lista de lotes ordenados desc por fecha
*/
	public function listaLotesPorRemate($re=NULL)
	{
		$sql = "SELECT localidades.localidad, provincias.provincia, lotes.categoria_lo, lotes.num_lo, lotes.orden_lo, lotes.lote_id FROM localidades, provincias, lotes WHERE lotes.remate_id =:re AND provincias.provincia_id = localidades.provincia_id AND lotes.localidad_lo = localidades.localidad_id AND lotes.fecha_lo > DATE_ADD(CURDATE(), INTERVAL -60 DAY) ORDER BY lote_id DESC";
	try
	{
		$stmt = $this->_db->prepare($sql);
		$stmt->bindParam(':re', $re, PDO::PARAM_INT);
		$stmt->execute();
		echo '<table class="ensayo" summary="Lotes cargados" cellspacing="0">';
		echo '<tbody>';
		echo '<tr class="principal">';
		echo '<th>ID</th><th>Lote</th><th>Orden</th><th>Localidad</th><th>Provincia</th><th>Categor&iacute;a</th><th></th><th></th>';
		echo '</tr>';
		echo '<tr>';
		while($row = $stmt->fetch())
		{
			$lok = $row['localidad'];
			$prv = $row['provincia'];
			$kat = $row['categoria_lo'];
			$nlo = $row['num_lo'];
			$ord = $row['orden_lo'];
			$lid = $row['lote_id'];
			echo "<tr>";
			echo "<td>" .$lid."</td>";
			echo "<td>" .$nlo."</td>";
			echo "<td>" .noMostrarSiEsCero($ord)."</td>";
			echo "<td>" .$lok."</td>";
			echo "<td>" .$prv."</td>";
			echo "<td>" .decirCategoria($kat)."</td>";
			echo '<td><a href="editar-lote.php?lote='.$lid.'">Editar</a></td>';
			echo '<td><a href="eliminar-lote.php?subasta='.$re.'&lote='.$lid.'&orden='.$ord.'">Borrar</a></td>';
			echo "</tr>";
		}
		echo "</table>";
		$stmt->closeCursor();
	}
	catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}

/*
*Cargar la info de un remate
*/
	public function cargarInfoRemate($subasta=NULL)
	{
		$subasta = $_GET['subasta'];
		$sql = "SELECT * FROM remates WHERE remate_id=:subasta";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':subasta', $subasta, PDO::PARAM_INT);
			$stmt->execute();
			$linea = $stmt->fetch();
			$stmt->closeCursor();
			return array($linea['remate_id'], $linea['fecha_re'], $linea['hora_re'], $linea['organizador'], $linea['metodo'], $linea['logo_re'], $linea['nombre_re'], $linea['informes_re'], $linea['status_re'], $linea['cardinal_re']);
		}
		catch(PDOException $e)
		{
			return FALSE;
		}
	}

/*
*  Cargar la info de un lote
*/
	public function cargarInfoLote($lote=NULL)
	{
		$lote = $_GET['lote'];
		$sql = "SELECT categoria_lo, subcategoria, cabezas, raza, peso, precio, plazo, notas, remate_id, num_lo FROM lotes WHERE lote_id=:lote";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':lote', $lote, PDO::PARAM_INT);
			$stmt->execute();
			$linea = $stmt->fetch();
			$stmt->closeCursor();
			return array($lote, $linea['categoria_lo'], $linea['subcategoria'], $linea['cabezas'], $linea['raza'], $linea['peso'], $linea['precio'], $linea['plazo'], $linea['notas'], $linea['remate_id'], $linea['num_lo']);
		}
		catch(PDOException $e)
		{
			return FALSE;
		}
	}

/*
* Eliminar un remate
*/
	public function eliminaRemate()
	{
		$rid = $_POST['remate'];
		// primero elimino los lotes del remate
		$sql  ="DELETE FROM lotes WHERE remate_id=:rid";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':rid', $rid, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();
		}
		catch(PDOException $e)
			{
				die($e->getMessage());
			}
		// ahora elimino el remate
		$sql  ="DELETE FROM remates WHERE remate_id=:rid";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':rid', $rid, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();
		}
		catch(PDOException $e)
			{
				die($e->getMessage());
			}
		// Ahora elimino el directorio del remate con todo su contenido.
//		$ruta = '../images/'.$rid;
//		eliminarDirectorio($ruta);
	}
/*
* Eliminar un lote
*/
	public function eliminaLote()
	{
		$reid = $_POST['remate'];
		$leid = $_POST['lote_id'];
		$orde = $_POST['orden_lo'];
		$sql  ="DELETE FROM lotes WHERE lote_id=:leid LIMIT 1";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':leid', $leid, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();
			//Ahora cambio el orden de los lotes siguientes al que borré
			$consulta ="UPDATE lotes SET orden_lo = orden_lo-1 WHERE remate_id =:reid AND orden_lo>:orde";
			try
			{
				$stmt = $this->_db->prepare($consulta);
				$stmt->bindParam(':reid', $reid, PDO::PARAM_INT);
				$stmt->bindParam(':orde', $orde, PDO::PARAM_INT);
				$stmt->execute();
				$stmt->closeCursor();
				//Ahora cambio la cardinalidad del remate
				$consul ="UPDATE remates SET cardinal_re = cardinal_re-1 WHERE remate_id =:reid";
				try
				{
					$stmt = $this->_db->prepare($consul);
					$stmt->bindParam(':reid', $reid, PDO::PARAM_INT);
					$stmt->execute();
					$stmt->closeCursor();
					return "Exito al cambiar!";
				}
				catch(PDOException $e)
				{
					return $e->getMessage();
				}
			}
			catch(PDOException $e)
			{
				return $e->getMessage();
			}
		}
		catch(PDOException $e)
			{
				die($e->getMessage());
			}
	}
/*
 * Editar un remate
*/
	public function editaRemate()
	{
		$rid = $_POST['remate_id'];
		$fech = darVueltaFecha($_POST['fecha_re']);
		$hora = $_POST['hora_re'];
		$orga = $_POST['organizador'];
		$meto = $_POST['metodo'];
		$logo = $_POST['logo_re'];
		$nomb = $_POST['nombre_re'];
		$info = $_POST['informes_re'];
		$stat = $_POST['status_re'];
		$sql = "UPDATE remates SET fecha_re = :fech, hora_re = :hora, organizador = :orga, metodo = :meto, logo_re = :logo, nombre_re = :nomb, informes_re = :info, status_re = :stat WHERE remate_id = :rid";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':rid', $rid, PDO::PARAM_INT);
			$stmt->bindParam(':fech', $fech, PDO::PARAM_INT);
			$stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
			$stmt->bindParam(':orga', $orga, PDO::PARAM_STR);
			$stmt->bindParam(':meto', $meto, PDO::PARAM_STR);
			$stmt->bindParam(':logo', $logo, PDO::PARAM_STR);
			$stmt->bindParam(':nomb', $nomb, PDO::PARAM_STR);
			$stmt->bindParam(':info', $info, PDO::PARAM_STR);
			$stmt->bindParam(':stat', $stat, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();
			return TRUE;
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
/*
 * Editar un lote
*/
	public function editarLote()
	{
		$lid = $_POST['lote_id'];

		$cat = $_POST['categoria'];
		$sub = $_POST['subcategoria'];
		$cab = $_POST['cabezas'];
		$raz = $_POST['raza'];
		$pes = $_POST['peso'];
		$pre = $_POST['precio'];
		$pla = $_POST['plazo'];
		$nos = $_POST['notas'];
		$nlo = $_POST['num_lo'];

		$sql = "UPDATE lotes SET categoria_lo =:cat, subcategoria =:sub, cabezas = :cab, raza = :raz, peso = :pes, precio = :pre, plazo = :pla, notas = :nos, num_lo = :nlo WHERE lote_id = :lid";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':lid', $lid, PDO::PARAM_INT);
			$stmt->bindParam(':cat', $cat, PDO::PARAM_INT);
			$stmt->bindParam(':sub', $sub, PDO::PARAM_STR);
			$stmt->bindParam(':cab', $cab, PDO::PARAM_STR);
			$stmt->bindParam(':raz', $raz, PDO::PARAM_STR);
			$stmt->bindParam(':pes', $pes, PDO::PARAM_STR);
			$stmt->bindParam(':pre', $pre, PDO::PARAM_STR);
			$stmt->bindParam(':pla', $pla, PDO::PARAM_STR);
			$stmt->bindParam(':nos', $nos, PDO::PARAM_STR);
			$stmt->bindParam(':nlo', $nlo, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();

			return TRUE;
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}

	}
/*
* Recupera la lista de lotes ordenados asc por fecha y permite editar el precio y el nombre
*esta muy incompleto. Ver si el I es necesario, se podria reemplazar con el id del lote. Hay que armar un metodo para actualizar la lista.
*/
	public function listaLotesPorRemateEditable($re=NULL)
	{
		$sql = "SELECT localidades.localidad, provincias.provincia, lotes.categoria_lo, lotes.precio, lotes.num_lo, lotes.orden_lo, lotes.lote_id FROM localidades, provincias, lotes WHERE lotes.remate_id =:re AND provincias.provincia_id = localidades.provincia_id AND lotes.localidad_lo = localidades.localidad_id AND lotes.fecha_lo > DATE_ADD(CURDATE(), INTERVAL -60 DAY) ORDER BY orden_lo ASC";
		$intervalo = NULL;
	try
	{
		$stmt = $this->_db->prepare($sql);
		$stmt->bindParam(':re', $re, PDO::PARAM_INT);
		$stmt->execute();
		echo '<form method="post" action="db-interaccion/hacienda.php" id="cambiar-precios-form">';
		echo '<input type="hidden" name="action" value="editar-precios" />';
		echo '<table class="ensayo" summary="Lotes cargados" cellspacing="0">';
		echo '<tbody>';
		echo '<tr class="principal">';
		echo '<th>ID</th><th>Lote</th><th>Orden</th><th>Localidad</th><th>Categoría</th><th>Precio</th><th></th><th></th><th></th>';
		echo '</tr>';
		echo '<tr>';
		$i = 1;
		while($row = $stmt->fetch())
		{
			$lok = $row['localidad'];
			$prv = $row['provincia'];
			$kat = $row['categoria_lo'];
			$pre = $row['precio'];
			$nlo = $row['num_lo'];
			$ord = $row['orden_lo'];
			$lid = $row['lote_id'];
			echo '<tr>';
			echo '<td><input type="hidden" name="lote'.$i.'" value="'.$lid.'" />'.$lid. '</td>';
			echo '<td>'.$nlo.'</td>';
			echo '<td><strong> &nbsp; &nbsp;' .noMostrarSiEsCero($ord).'</strong></td>';
			echo '<td>' .$lok. ' - '.$prv.'</td>';
			echo '<td>' .decirCategoria($kat).'</td>';
			echo '<td><input id="entabla" type="text" name="precio'.$i.'" value="'.$pre.'"/></td>';
			echo '<td><a href="editar-lote.php?lote='.$lid.'">Editar</a></td>';
			echo '<td><a href="ordenar-lotes.php?rid='.$re.'&ord='.$ord.'&lid='.$lid.'">Cat&aacute;logo</a></td>';
			echo '<td><a href="eliminar-lote.php?subasta='.$re.'&lote='.$lid.'&orden='.$ord.'">Borrar</a></td>';
			echo "</tr>";
			$intervalo = $i++;
		}
		echo '</table>';
		echo '<input type="hidden" name="remate_id" value="'.$re.'" />';
		//envio el intervalo para el bucle
		echo '<input type="hidden" name="intervalo" value="'.$intervalo.'" />';
		echo '<input type="hidden" name="token" value="'.$_SESSION["token"].'" />';
		if($intervalo != NULL)
		{
		echo '<input type="submit" name="cambiar-precios" id="cambiar-precios" value="Cambiar precios a todos los lotes" class="button" />';
		}
		echo '</form>';
		$stmt->closeCursor();
	}
	catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
/*
 * Editar precios masivamente en un remate
*/
	public function editarPrecios()
	{
		$i = (int) $_POST['intervalo'];
//		$i = TOMO EL VALOR CARDINAL DE LOTES EN LA LISTA;
		$sql = "UPDATE lotes SET precio = :precio WHERE lote_id = :loteid";
// Hago un bucle restando 1 al cardinal y actualizando cada registro
			try
			{
				while($i > 0)
				{
				$loteid = (int) $_POST['lote'.$i];
				$precio = $_POST['precio'.$i];
				$stmt = $this->_db->prepare($sql);
				$stmt->bindParam(':loteid', $loteid, PDO::PARAM_INT);
				$stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
				$stmt->execute();
				$i = $i-1;
				}
				$stmt->closeCursor();
				return TRUE;
			}
			catch(PDOException $e)
			{
				return $e->getMessage();
			}

	}
/*
 *Crear un directorio para el remate
 */
	public function crearDirectorio()
	{
		$sql = "SELECT MAX(remate_id) AS dire FROM remates";
		foreach($this->_db->query($sql) as $row);
		$carpeta = $row['dire'];
		mkdir('../images/'.$carpeta, 0775);
	}
/*
 *	Eliminar el directorio del remate y su contenido
 */
	public function eliminarDirectorio($directorio)
	{
		if ($handle = opendir("$directorio")) {
		while (false !== ($item = readdir($handle))) {
		  if ($item != "." && $item != "..") {
			if (is_dir("$directorio/$item")) {
			  remove_directory("$directorio/$item");
			} else {
			  unlink("$directorio/$item");
			}
		  }
		}
		closedir($handle);
		rmdir($directorio);
		}
	}
/*
* Cargar Orden de Venta de un Lote para cambiarlo
*/
	public function cargarOrdenDeVenta($subasta, $orden)
	{
		$sql = "SELECT remates.cardinal_re, lotes.num_lo FROM remates, lotes WHERE remates.remate_id = :subasta AND lotes.orden_lo = :orden AND lotes.remate_id = :subasta LIMIT 1";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':subasta', $subasta, PDO::PARAM_INT);
			$stmt->bindParam(':orden', $orden, PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch();
			$cardinal = $row['cardinal_re'];
			$nombre = $row['num_lo'];
			echo '<div><form method="post" action="db-interaccion/hacienda.php" id="ordenar-lote-form">';
			echo '<input type="hidden" name="action" value="ordenar-lotes" />';
			echo '<input type="hidden" name="remate_id" value="'.$subasta.'" />';
			echo '<input type="hidden" name="cardinal_re" value="'.$cardinal.'" />';
			echo '<input type="hidden" name="origen" value="'.$orden.'" />';
			echo '<p>Para el lote <strong>'.$nombre.'</strong> el Orden de Venta actual es <strong>'.$orden.'</strong></p>';
			echo '<p>Escriba el número de la nueva posición en el Orden de Venta.</p>';
			echo '<p>Para este remate, el número de la nueva posición debe estar entre <strong>1</strong> y <strong>'.$cardinal.'</strong></p><br />';
			echo '<label for="destino">Nuevo Orden de Venta</label><input type="text" name="destino" id="destino" value="'.$orden.'" /> <br />';
			echo '<input type="submit" name="ordenar" id="ordenar" value="Asignar Nuevo Orden de Venta" class="button" />
	<input type="button" class="button" value="Volver a la lista sin cambiar" onclick="history.back()"></input>
	<input type="hidden" name="token" value="'.$_SESSION["token"].'" />';
			echo '</form></div>';
			$stmt->closeCursor();
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
/*
* CAMBIAR EL ORDEN DE UN LOTE EN LA LISTA DE LOTES
*/
	public function cambiarOrdenDeVenta()
	{
		$rid = (int) $_POST['remate_id']; //debe ser el id del remate
		$lugar_inicial = (int) $_POST['origen'];
		$lugar_actual = (int) $_POST['destino'];
		$cardinalidad = (int) $_POST['cardinal_re'];
		if($lugar_actual <= $cardinalidad && $lugar_actual > 0)
		{
			if($lugar_actual < $lugar_inicial)
			{
				/*
				 * La consulta modifica todas las posiciones de los lotes
				 * entre la posicion original y la que fue movido.
				 */
				$sql = "UPDATE lotes SET orden_lo=(CASE WHEN orden_lo+1>$lugar_inicial THEN $lugar_actual ELSE orden_lo+1 END) WHERE remate_id=$rid AND orden_lo BETWEEN $lugar_actual AND $lugar_inicial";
			}
			else
			{
				// Se decrementa la posicion del lote
				$sql = "UPDATE lotes SET orden_lo=(CASE WHEN orden_lo-1<$lugar_inicial THEN $lugar_actual ELSE orden_lo-1 END) WHERE remate_id=$rid AND orden_lo BETWEEN $lugar_inicial AND $lugar_actual";
			}
		$rows = $this->_db->exec($sql);
		echo "Consulta realizada con exito. ", "Filas afectadas: $rows";
		}
		else
		{
			$ri = $rid;
			$ch = "nuevo";
			header("Location: ../nuevo-lote.php?subasta=$ri&lote=$ch");
			exit;
		}
	}
/*
* Cargar Fotos, Video y Certificador del lote
*/
	public function cargarArchivosDelLote($loteid)
	{
		$sql = "SELECT remate_id, foto_1, foto_2, foto_3, foto_4, video, certificador_id FROM lotes WHERE lote_id = :loteid LIMIT 1";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':loteid', $loteid, PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch();
			$f1 = $row['foto_1'];
			$f2 = $row['foto_2'];
			$f3 = $row['foto_3'];
			$f4 = $row['foto_4'];
			$vi = $row['video'];
			$ci = $row['certificador_id'];
			$remate = $row['remate_id'];
			echo '<div><form method="post" action="db-interaccion/hacienda.php" id="archivos-lote-form">';
			echo '<input type="hidden" name="action" value="guardar-rutas" />';
			echo '<input type="hidden" name="lote_id" value="'.$loteid.'" />';
			echo '<input type="hidden" name="remate_id" value="'.$remate.'" />';
//			echo '<input type="hidden" name="origen" value="'.$orden.'" />';
//			echo '<p>Para el lote <strong>'.$nombre.'</strong> el Orden de Venta actual es <strong>'.$orden.'</strong></p>';
//			echo '<p>Escriba el n&uacute;mero de la nueva posici&oacute;n en el Orden de Venta.</p>';
//			echo '<p>Para este remate, el n&uacute;mero de la nueva posici&oacute;n debe estar entre <strong>1</strong> y <strong>'.$cardinal.'</strong></p><br />';
			echo '<label for="foto_1">Foto 1</label><input type="text" name="foto_1" id="foto_1" value="'.$f1.'" /> <br />';
			echo '<label for="foto_2">Foto 2</label><input type="text" name="foto_2" id="foto_2" value="'.$f2.'" /> <br />';
			echo '<label for="foto_3">Foto 3</label><input type="text" name="foto_3" id="foto_3" value="'.$f3.'" /> <br />';
			echo '<label for="foto_4">Foto 4</label><input type="text" name="foto_4" id="foto_4" value="'.$f4.'" /> <br />';
			echo '<label for="video">Video</label><input type="text" name="video" id="video" value="'.$vi.'" /> <br />';
			//XXX Hacer combo de certificadores
//			echo '<label for="certificador_id">Certificador</label><input type="text" name="certificador_id" id="certificador_id" value="'.$ci.'" /> <br />';
			echo '<input type="submit" name="cambiar" id="ordenar" value="Asignar Nuevas Rutas" class="button" />
	<input type="button" class="button" value="Volver a la lista sin cambiar" onclick="history.back()"></input>
	<input type="hidden" name="token" value="'.$_SESSION["token"].'" />';
			echo '</form></div>';
			$stmt->closeCursor();
		}
	catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
/*
* Modificar las rutas a los archivos del lote
*/
	public function cambiarRutasDelLote()
	{
		$sql ="UPDATE lotes SET foto_1 =:f1, foto_2 =:f2, foto_3 =:f3, foto_4 =:f4, video =:vi, certificador_id =:ci WHERE lote_id =:li";

		$li = $_POST['lote_id'];
		$f1 = trim($_POST['foto_1']);
		$f2 = trim($_POST['foto_2']);
		$f3 = trim($_POST['foto_3']);
		$f4 = trim($_POST['foto_4']);
		$vi = trim($_POST['video']);
		$ci = $_POST['certificador_id'];
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':li', $li, PDO::PARAM_INT);
			$stmt->bindParam(':f1', $f1, PDO::PARAM_STR);
			$stmt->bindParam(':f2', $f2, PDO::PARAM_STR);
			$stmt->bindParam(':f3', $f3, PDO::PARAM_STR);
			$stmt->bindParam(':f4', $f4, PDO::PARAM_STR);
			$stmt->bindParam(':vi', $vi, PDO::PARAM_STR);
			$stmt->bindParam(':ci', $ci, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();
			return TRUE;
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
/*
* Subir un video desde un formulario
*/
	public function guardarRutaVideo($ruta, $lid)
	{
		$sql = "UPDATE lotes SET video =:ruta WHERE lote_id =:lid";
			try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':lid', $lid, PDO::PARAM_INT);
			$stmt->bindParam(':ruta', $ruta, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();
			return TRUE;
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
/*
* Subir una foto desde un formulario
*/
	public function guardarRutaFoto($ruta, $campo, $lid)
	{
		$sql = "UPDATE lotes SET $campo =:ruta WHERE lote_id =:lid";
			try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':lid', $lid, PDO::PARAM_INT);
			$stmt->bindParam(':ruta', $ruta, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();
			return TRUE;
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
/*
 *	AGREGAR UNA LOCALIDAD
 */
	public function agregarLocalidad()
	{
		$pid = $_POST['provincia']*1;
// sin  utf8_decode COMENTAR EN LOCALHOSTH
//		$lok = strtoupper(trim($_POST['localidad']));
// con  utf8_decode COMENTAR EN SERVIDOR
		$lok = utf8_decode(trim($_POST['localidad']));
		$coo = $_POST['coordenadas'];
		list($cox, $coy) = explode(",", $coo);
		$lat = cadenaToReal($cox)*1;
		$lon = cadenaToReal($coy)*1;

		$sql = "INSERT INTO localidades (localidad, latitud, longitud, provincia_id) VALUES (:lok, :lat, :lon, :pid)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
		$stmt->bindParam(':lok', $lok, PDO::PARAM_STR);
		$stmt->bindParam(':lat', $lat);
		$stmt->bindParam(':lon', $lon);
		$stmt->execute();
		$stmt->closeCursor();
	}
// FIN DE LA CLASE
}
?>
