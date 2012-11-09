<?php
/**
 * Interacción de los usuarios públicos con la aplicacion
 */
class BipherBanners
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
 * Subir un BANNER desde un formulario
 */
	public function guardarRutaBanner($ambit, $orden, $visible, $destino, $enlace)
	{
		$sql = "INSERT INTO controles (ambito_banner, orden_banner, visible_banner, ruta_banner, enlace_banner) VALUES (:am, :od, :vi, :de, :en)";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':am', $ambit, PDO::PARAM_INT);
			$stmt->bindParam(':od', $orden, PDO::PARAM_INT);
			$stmt->bindParam(':vi', $visible, PDO::PARAM_INT);
			$stmt->bindParam(':de', $destino, PDO::PARAM_STR);
			$stmt->bindParam(':en', $enlace, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
/*
 * MOSTRAR LOS BANNERS EXISTENTES EN UNA TABLA
 * @param ambito INT
 */
	public function mostrarBanners($ambito)
	{
		$sql = "SELECT * FROM controles WHERE ambito_banner=:am ORDER BY orden_banner ASC";
		$intervalo = NULL;
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(':am', $ambito, PDO::PARAM_INT);
			$stmt->execute();
			echo '<form method="post" action="db-interaccion/avisos.php" id="cambiar-orden-form">';
		echo '<input type="hidden" name="action" value="editar-orden" />';
		echo '<table class="ensayo" summary="Banners cargados" cellspacing="0">';
		echo '<tbody>';
		echo '<tr class="principal">';
		echo '<th>ID</th><th>Banner</th><th>Orden</th><th></th><th></th><th></th>';
		echo '</tr>';
		echo '<tr>';
		$i = 1;
		while($row = $stmt->fetch())
		{
			$bid = $row['id_banner'];
			$ban = $row['ruta_banner'];
			$ord = $row['orden_banner'];
			$vis = $row['visible_banner'];
			echo '<tr>';
			echo '<td><input type="hidden" name="banner'.$i.'" value="'.$bid.'" />'.$bid. '</td>';
			echo '<td><img src="'.$ban.'" alt="Banner" /></td>';
			echo '<td><input id="entabla" type="text" name="orden'.$i.'" value="'.$ord.'"/></td>';
			echo '<td>';
			if($vis!=0){echo 'Publicado';}else{echo 'No Publicado';}
			echo '</td>';
			echo '<td><a href="editar-banner.php?banner='.$bid.'">Editar</a></td>';
			echo '<td><a href="eliminar-banner.php?banner='.$bid.'">Borrar</a></td>';
			echo "</tr>";
			$intervalo = $i++;
		}
		echo '</table>';
		echo '<input type="hidden" name="ambito" value="'.$ambito.'" />';
		//envio el intervalo para el bucle
		echo '<input type="hidden" name="intervalo" value="'.$intervalo.'" />';
		echo '<input type="hidden" name="token" value="'.$_SESSION["token"].'" />';
		if($intervalo != NULL)
		{
		echo '<input type="submit" name="cambiar-orden" id="cambiar-orden" value="Cambiar orden" class="button" />';
		echo '&nbsp;';
		echo '<input type="button" class="button" value="Volver sin cambiar" onclick="history.back()"></input>';
		}
		echo '</form>';
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
