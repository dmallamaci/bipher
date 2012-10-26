<?php
$provincias["1"] = "BUENOS AIRES";
$provincias["2"] = "CATAMARCA";
$provincias["3"] = "CHACO";
$provincias["4"] = "CHUBUT";
$provincias["5"] = "CORDOBA";
$provincias["6"] = "CORRIENTES";
$provincias["7"] = "ENTRE RIOS";
$provincias["8"] = "FORMOSA";
$provincias["9"] = "JUJUY";
$provincias["10"] = "LA PAMPA";
$provincias["11"] = "LA RIOJA";
$provincias["12"] = "MENDOZA";
$provincias["13"] = "MISIONES";
$provincias["14"] = "NEUQUEN";
$provincias["15"] = "RIO NEGRO";
$provincias["16"] = "SALTA";
$provincias["17"] = "SAN JUAN";
$provincias["18"] = "SAN LUIS";
$provincias["19"] = "SANTA CRUZ";
$provincias["20"] = "SANTA FE";
$provincias["21"] = "SANTIAGO DEL ESTERO";
$provincias["22"] = "TIERRA DEL FUEGO";
$provincias["23"] = "TUCUMAN";
foreach($provincias as $codigo => $nombre) {
  $elementos_json[] = "\"$codigo\": \"$nombre\"";
}
echo "{".implode(",", $elementos_json)."}"
?>