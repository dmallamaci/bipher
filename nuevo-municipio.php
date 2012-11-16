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
</head>
<body onload="initialize()">

<?php include_once 'comun/abre-body-usuario.php';?>
<?php if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['username'])): ?>
<!-- ACCIONES CON MAPAS -->
     <h2>Obtener coordenadas de una localidad</h2>
		<br />
<form id="form_mapa">
    <input id="address" type="textbox" value="Sydney, NSW" />
    <input type="button" value="Encode" onclick="codeAddress()" />
	<input type="text" id="coordenadas" name="coordenadas" value="" />
</form>

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
