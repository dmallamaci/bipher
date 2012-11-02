var peticion = null; 
function inicializa_xhr() {
  if (window.XMLHttpRequest) {
    return new XMLHttpRequest(); 
  } else if (window.ActiveXObject) {
    return new ActiveXObject("Microsoft.XMLHTTP"); 
  }
}
function muestraProvincias() {
  if (peticion.readyState == 4) {
    if (peticion.status == 200) {
      var lista = document.getElementById("provincia");
      var provincias = eval('(' + peticion.responseText + ')');

      lista.options[0] = new Option("Seleccione una Provincia");
      var i=1;
      for(var codigo in provincias) {
        lista.options[i] = new Option(provincias[codigo], codigo);
        i++;
      }
    }
  }
}
function cargaMunicipios() {
  var lista = document.getElementById("provincia");
  var provincia = lista.options[lista.selectedIndex].value;
  if(!isNaN(provincia)) {
    peticion = inicializa_xhr();
    if (peticion) {
      peticion.onreadystatechange = muestraMunicipios;
      peticion.open("POST", "carga-municipios.php?nocache=" + Math.random(), true);
      peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      peticion.send("provincia=" + provincia);
    }
  }
}
function muestraMunicipios() {
  if (peticion.readyState == 4) {
    if (peticion.status == 200) {
      var lista = document.getElementById("municipio");
      var municipios = eval('(' + peticion.responseText + ')');
      lista.options.length = 0;
      var i=0;
      for(var codigo in municipios) {
        lista.options[i] = new Option(municipios[codigo], codigo);
        i++;
      }
    }
  }
}
window.onload = function() {
	peticion = inicializa_xhr(); 
  if(peticion) {
    peticion.onreadystatechange = muestraProvincias;
    peticion.open("GET", "comun/carga-provincias.php?nocache="+Math.random(), true);
    peticion.send(null);
  }

  document.getElementById("provincia").onchange = cargaMunicipios;  
}