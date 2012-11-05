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
		$stat = $_POST['status_re'];

		$sql = "INSERT INTO remates (fecha_re, hora_re, organizador, metodo, status_re) VALUES (:fecha, :hora, :orga, :meto, :stat)";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':fecha', $fecha, PDO::PARAM_INT);
			$stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
			$stmt->bindParam(':orga', $orga, PDO::PARAM_STR);
			$stmt->bindParam(':meto', $meto, PDO::PARAM_STR);
			$stmt->bindParam(':stat', $stat, PDO::PARAM_INT);
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
		$sql = "SELECT remate_id, fecha_re, organizador, status_re FROM remates WHERE fecha_re > DATE_ADD(CURDATE(), INTERVAL -200 DAY) ORDER BY fecha_re DESC;";

	try
	{
		$stmt = $this->_db->prepare($sql);
		$stmt->execute();

		echo '<table class="ensayo" summary="Remates de hacienda cargados en Bipher" cellspacing="0">';
		echo '<tbody>';
		echo '<tr class="principal">';
		echo '<th>ID</th><th>Fecha</th><th>Organizador</th><th>&Aacute;mbito de Publicaci&oacute;n</th><th></th><th></th><th></th><th></th>';
		echo '</tr>';
		echo '<tr>';

		while($row = $stmt->fetch())
		{
			$rid = $row['remate_id'];
			$fecha = $row['fecha_re'];
			$orga = $row['organizador'];
			$stat = $row['status_re'];

			echo "<tr>";
			echo "<td>" .$rid."</td>";
			echo "<td>" .darVueltaFecha($fecha)."</td>";
			echo "<td>" .$orga."</td>";
			echo "<td>" .ambitoDePublicacion($stat)."</td>";
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
		$sql = "SELECT fecha_re, hora_re, organizador, metodo, status_re, cardinal_re FROM remates WHERE remate_id=:subasta";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':subasta', $subasta, PDO::PARAM_INT);
			$stmt->execute();
			$linea = $stmt->fetch();
			$stmt->closeCursor();
			return array($subasta, $linea['fecha_re'], $linea['hora_re'], $linea['organizador'], $linea['metodo'], $linea['status_re'], $linea['cardinal_re']);
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

		$statu = $_POST['status_re'];
		$fecha = darVueltaFecha($_POST['fecha_re']);
		$hora = $_POST['hora_re'];
		$orga = $_POST['organizador'];
		$meto = $_POST['metodo'];

		$sql = "UPDATE remates SET fecha_re = :fecha, hora_re = :hora, organizador = :orga, metodo = :meto, status_re = :statu WHERE remate_id = :rid";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':rid', $rid, PDO::PARAM_INT);
			$stmt->bindParam(':fecha', $fecha, PDO::PARAM_INT);
			$stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
			$stmt->bindParam(':orga', $orga, PDO::PARAM_STR);
			$stmt->bindParam(':meto', $meto, PDO::PARAM_STR);
			$stmt->bindParam(':statu', $statu, PDO::PARAM_INT);
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
		echo '<th>ID</th><th>Lote</th><th>Orden</th><th>Localidad</th><th>Categor&iacute;a</th><th>Precio</th><th></th><th></th><th></th>';
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
			echo '<td><a href="c-ordenar.php?rid='.$re.'&ord='.$ord.'&lid='.$lid.'">Cat&aacute;logo</a></td>';
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
	public function eliminarDirectorio($tmp_path)
	{
	  if(!is_writeable($tmp_path) && is_dir($tmp_path)){chmod($tmp_path,0777);}
		$handle = opendir($tmp_path);
	  while($tmp=readdir($handle)){
		if($tmp!='..' && $tmp!='.' && $tmp!=''){
			 if(is_writeable($tmp_path.DS.$tmp) && is_file($tmp_path.DS.$tmp)){
					 unlink($tmp_path.DS.$tmp);
			 }elseif(!is_writeable($tmp_path.DS.$tmp) && is_file($tmp_path.DS.$tmp)){
				 chmod($tmp_path.DS.$tmp,0666);
				 unlink($tmp_path.DS.$tmp);
			 }
			 if(is_writeable($tmp_path.DS.$tmp) && is_dir($tmp_path.DS.$tmp)){
					delete_folder($tmp_path.DS.$tmp);
			 }elseif(!is_writeable($tmp_path.DS.$tmp) && is_dir($tmp_path.DS.$tmp)){
					chmod($tmp_path.DS.$tmp,0777);
					delete_folder($tmp_path.DS.$tmp);
			 }
		}
	  }
	  closedir($handle);
	  rmdir($tmp_path);
	  if(!is_dir($tmp_path)){return true;}
	  else{return false;}
	}
}
?>
