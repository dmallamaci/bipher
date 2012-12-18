<?php
include_once 'comun/privado.php';
include_once 'inc/class.hacienda.inc.php';
// SUBIR FOTOS
		$lid = $_POST['lote_id'];
		$rid = $_POST['remate_id'];
		$od = $_POST['orden_lo'];
//  cuento el numero de elementos de la matriz "fotos"
//	$cardinal = count($_FILES['fotos']['tmp_name']);
//  en realidad no hace falta pues siempre es 4
	$urls = array();
	$foto = new BipherHacienda($db);
//recorro los campos comprobando la propiedad name. Si es "" es que no se subio foto.
	for($contador=1; $contador<5; $contador++){
		if(!$_FILES['fotos']['name'][$contador]==""){
			$urls[$contador] = 'images/'.$rid.'/'.$lid.'-'.$contador.'.jpg';
			$nombre_campo = 'foto_'.$contador;
			//compruebo que tenga el formato adecuado
//			echo $_FILES['fotos']['type'][$contador];
				if($_FILES['fotos']['type'][$contador] != 'image/jpeg'){
					die('La imagen que trata de subir a '.$nombre_campo.' no tiene formato JPG. <input type="button" class="button" value="Volver al formulario" onclick="history.back()"></input>');
				}
				//compruebo que no se hayan producido errores
				if($_FILES['fotos']['error'][$contador] != 0){
					die('Se ha producido un error al subir la imagen a '.$nombre_campo.'.  <input type="button" class="button" value="Volver al formulario" onclick="history.back()"></input>');
				}
				//se intenta guardar y se comprueba que se guarde bien
						$imagen = $_FILES['fotos']['tmp_name'][$contador];
						$destino = $urls[$contador];
				if(move_uploaded_file($imagen, $destino)){
					//cambio la ruta de la foto
					$foto->guardarRutaFoto($destino, $nombre_campo, $lid);
				} else {
					die('La imagen que trata de subir a '.$nombre_campo.' no se pudo guardar. <input type="button" class="button" value="Volver al formulario" onclick="history.back()"></input>');
				}
			echo $urls[$contador].'<br />';
		}
	}
// FIN DE SUBIR FOTOS
echo '<meta http-equiv="refresh" content="0;ordenar-lotes.php?rid='.$rid.'&ord='.$od.'&lid='.$lid.'">';
?>
