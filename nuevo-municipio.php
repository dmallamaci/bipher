<?php
include_once 'comun/privado.php';
htmlDoc();
?>
<html <?php xm();?>>
<head>
<?php headPublico();?>
	<script type="text/javascript"
    src="https://maps.google.com/maps/api/js?sensor=false">
	</script>
	<script type="text/javascript">
  var geocoder;
  var map;
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-38.416097,-63.616672);
    var myOptions = {
      zoom: 4,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  }
  function codeAddress() {

    var address = document.getElementById("address").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        document.getElementById("coordenadas").value = results[0].geometry.location;
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
</script>
<script type="text/javascript">
function validar(){
	if (document.lok.provincia.selectedIndex==0){
		alert("Falta elegir la Provincia. \nComplete el formulario o use \nel boton Volver sin Guardar");
		document.lok.provincia.focus();
		return false;
		}
	if (document.lok.localidad.value.length==0 || document.form_mapa.coordenadas.value.length==0){
		alert('Falta la Localidad o las Coordenadas. \nComplete el formulario o use \nel boton Volver sin Guardar');
		document.lok.localidad.focus();
		return false;
		}
	return true;
}
</script>
<script type="text/javascript">
    function conMayusculas(field) {
            field.value = field.value.toUpperCase()
}
</script>
</head>
<body onload="initialize()">
<?php include_once 'comun/abre-body-usuario.php';?>
<?php if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['username'])): ?>
<!-- ACCIONES CON MAPAS -->
     <h2>Obtener coordenadas de una localidad</h2>
		<p>Para obtener mejores resultados escriba la localidad a buscar seguida de la provincia y el pais, separados por comas.<br />Por ejemplo, para buscar <em>Pergamino</em> escriba: <em>Pergamino, Buenos Aires, Argentina</em>.</p>
	<br />
	<label for="address">Localidad a Buscar </label>
    <input id="address" type="textbox" size="38" value="" />
    <input type="button" value="Obtener Coordenadas" onclick="codeAddress()" />
	<br />
	<hr />
<h2>Guardar el resultado en la base de datos</h2>
<p>Si obtuvo como resultado un par de coordenadas debe guardar el resultado en la base de datos.<br /> Vuelva a escribir el nombre de la localidad y seleccione la provincia a la que pertenece.</p>

<form method="post" action="db-interaccion/hacienda.php" id="lok" name="lok">
	<input type="hidden" name="action" value="agregar-localidad" />
	<label for="coordenadas">Coordenadas </label>
	<input type="text" id="coordenadas" name="coordenadas" value="" />
	<br />
	<label for="localidad">Nombre de Localidad </label>
	<input type="text" id="localidad" name="localidad" onchange="conMayusculas(this)" />
	<?php include_once 'comun/provincias-select.php';?>
	<br /><br />
		<p>El mapa sirve para verificar que las coordenadas obtenidas corresponden con la localidad buscada.<br />Si la marca en el mapa no es correcta, no guarde las coordenadas. Repita la búsqueda ampliando los criterios.</p>
		<p>Se puede ampliar, reducir y mover el mapa pero <strong>es solo una guia visual</strong>.<br />Hacer click en el mapa <strong>no modifica las coordenadas</strong>.</p>
	<input type="submit" name="agregalocalidad" id="agregalocalidad" value="Agregar nueva Localidad" onclick="return validar()" class="button" />
	<input type="submit" name="atras" id="atras" value="Volver sin Guardar" class="button" />
	<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
</form>
<div style="height: 18px;"></div>

<div style="width: 700px; border-width: 1px; border-style: solid; border-color: #979797; padding:8px 8px 8px 8px;">
        <div id="map_canvas" style="width: 700px; height: 500px"></div>
       	</div>

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
