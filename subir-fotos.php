<?php
include_once 'comun/privado.php';
htmlDoc();
?>
<html <?php xm();?>>
<head>
<?php headPublico();?>
</head>
<body>
<?php include_once 'comun/abre-body-usuario.php';?>
<?php if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['username'])): ?>
<!-- ACCIONES CON HACIENDA -->
<?php
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
			$urls[$contador] = 'images/'.$rid.'/'.$lid.'_'.$contador.'.jpg';
			$nombre_campo = 'foto_'.$contador;
			//compruebo que tenga el formato adecuado
//			echo $_FILES['fotos']['type'][$contador];
				if($_FILES['fotos']['type'][$contador] != 'image/jpeg'){
					die('La imagen que trata de subir a '.$nombre_campo.' no tiene formato JPG');
				}
				//compruebo que no se hayan producido errores
				if($_FILES['fotos']['error'][$contador] != 0){
					die('Se ha producido un error al subir la imagen a '.$nombre_campo);
				}
				//se intenta guardar y se comprueba que se guarde bien
						$imagen = $_FILES['fotos']['tmp_name'][$contador];
						$destino = $urls[$contador];
				if(move_uploaded_file($imagen, $destino)){
					//cambio la ruta de la foto
					$foto->guardarRutaFoto($destino, $nombre_campo, $lid);
				} else {
					die('La imagen que trata de subir a '.$nombre_campo.' no se pudo guardar');
				}
			echo $urls[$contador].'<br />';
		}
	}
	header("Location: ordenar-lotes.php?rid=$rid&ord=$od&lid=$lid");
// FIN DE SUBIR FOTOS
?>
<!-- FIN DE ACCIONES CON HACIENDA -->
<?php
	elseif(!empty($_POST['username']) && !empty($_POST['password'])):
		include_once 'inc/class.usuarios.inc.php';
		$users = new BipherUsuario($db);
		if($users->accountLogin()===TRUE):
			echo "<meta http-equiv='refresh' content='0;login.php'>";
			exit;
		else:
?>
	<h2>Falló el inicio de sesión. Intente de nuevo</h2>
<?php
		include_once 'comun/form-loguearse.txt';
		endif;
	else:
?>
	<h2>Inicie Sesión...</h2>
<?php
	include_once 'comun/form-loguearse.txt';
	endif;
?>
		<div style="clear: both;"></div>
<!-- Este /div cierra el div id="page-wrap" de abre-usuario.php-->
	</div>
</body>
</html>