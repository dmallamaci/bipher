    var map      = null;
    var geocoder = null;

    function load() {                                      // Abre LLAVE 1.
      if (GBrowserIsCompatible()) {						   // Abre LLAVE 2.
        map = new GMap2(document.getElementById("map"));

        map.setCenter(new GLatLng(37.567236,-1.803499), 4);
        map.addControl(new GSmallMapControl());
	   	map.addControl(new GMapTypeControl());

        geocoder = new GClientGeocoder();

        //---------------------------------//
        //   MARCADOR AL HACER CLICK
		//---------------------------------//
		GEvent.addListener(map, "click",
			function(marker, point) {
 		 		if (marker) {
               		null;
              		} else {
          			map.clearOverlays();
					var marcador = new GMarker(point);
					map.addOverlay(marcador);
					//marcador.openInfoWindowHtml("<b><br>Coordenadas:<br></b>Latitud : "+point.y+"<br>Longitud : "+point.x+"<a href=http://www.mundivideo.com/fotos_pano.htm?lat="+point.y+"&lon="+point.x+"&mapa=3 TARGET=fijo><br><br>Fotografias</a>");
					//marcador.openInfoWindowHtml("<b>Coordenadas:</b> "+point.y+","+point.x);
					document.form_mapa.coordenadas.value = point.y+","+point.x;
					}
  			}
			);
        //---------------------------------//
        //   FIN MARCADOR AL HACER CLICK
		//---------------------------------//

      } // Cierra LLAVE 1.
    }   // Cierra LLAVE 2.

    //---------------------------------//
    //           GEOCODER
	//---------------------------------//
    function showAddress(address, zoom) {
    	if (geocoder) {
        	geocoder.getLatLng(address,
          		function(point) {
            		if (!point) {
            			alert(address + " not found");
            		} else {
            			map.setCenter(point, zoom);
            			var marker = new GMarker(point);
            			map.addOverlay(marker);
       			      document.form_mapa.coordenadas.value = point.y+","+point.x;
               		}
               	}
        	);
      	}}
    //---------------------------------//
    //     FIN DE GEOCODER
	//---------------------------------//

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
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
			document.form_mapa.coordenadas.value = point.y+","+point.x;
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
