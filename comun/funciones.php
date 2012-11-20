<?php
class DateTimeArgento extends DateTime {
    public function format($format){
        $english = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $argento = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
        return str_replace($english, $argento, parent::format($format));
    }
}
/*
 * Dar vuelta las fechas
 */
function darVueltaFecha($date) {
    if (empty($date)) {
        return "";
        } else {
        $date = strtr($date, "/", "-");
        $i = 0;
        $tmp = strtok($date, "-");
        while ($tmp) {
            $dateok[$i] = "$tmp";
            $i++;
            $tmp = strtok("-");
            }
        return ($dateok[2]."-".$dateok[1]."-".$dateok[0]);
        }
}
/*
 * Convertir una cadena en número positivo
 */
function cadenaToReal($str) {
    // caracteres válidos, sin negativos
    $legal = "%[^0-9\.]%";
    $str = preg_replace($legal, "", $str);
    return $str;
}
/*
 * Convertir a cadena el Status del Catálogo
 */
function ambitoDePublicacion($entero) {
    switch($entero) {
        case 0:
            return 'Buscador';
            break;
        case 1:
            return 'Agenda';
            break;
        case 2:
            return 'Catálogo';
            break;
        default:
            return 'Sin Ámbito de Publicación';
            break;
    }
}
/*
 * Convertir a cadena la Categoria del Lote
 */
function decirCategoria($ent) {
    switch($ent) {
        case 1:
            return 'Terneros para Faena';
            break;
        case 2:
            return 'Novillos para Faena';
            break;
        case 3:
            return 'Terneras Hembras';
            break;
        case 4:
            return 'Terneros Machos';
            break;
        case 5:
            return 'Terneros Machos y Hembras';
            break;
        case 6:
            return 'Toros';
            break;
        case 7:
            return 'Vacas con Cría';
            break;
        case 8:
            return 'Varios';
            break;
        case 9:
            return 'Vacas para Faena';
            break;
        case 10:
            return 'Vaquillonas';
            break;
        case 11:
            return 'Vaquillonas Preñadas';
            break;
        case 12:
            return 'Vacas Preñadas';
            break;
        case 13:
            return 'Novillitos';
            break;
        case 14:
            return 'Vacas de Invernada';
            break;
        default:
            return 'Sin Categoria';
            break;
    }
}
/*
 * Convertir a cadena la el Enterro de la Provincia
 */
function decirProvincia($ent) {
    switch($ent) {
        case 1:
            return 'Buenos Aires';
            break;
        case 2:
            return 'Catamarca';
            break;
        case 3:
            return 'Chaco';
            break;
        case 4:
            return 'Chubut';
            break;
        case 5:
            return 'Cordoba';
            break;
        case 6:
            return 'Corrientes';
            break;
        case 7:
            return 'Entre Rios';
            break;
        case 8:
            return 'Formosa';
            break;
        case 9:
            return 'Jujuy';
            break;
        case 10:
            return 'La Pampa';
            break;
        case 11:
            return 'La Rioja';
            break;
        case 12:
            return 'Mendoza';
            break;
        case 13:
            return 'Misiones';
            break;
        case 14:
            return 'Neuquen';
            break;
        case 15:
            return 'Rio Negro';
            break;
        case 16:
            return 'Salta';
            break;
        case 17:
            return 'San Juan';
            break;
        case 18:
            return 'San Luis';
            break;
        case 19:
            return 'Santa Cruz';
            break;
        case 20:
            return 'Santa Fe';
            break;
        case 21:
            return 'Santiago del Estero';
            break;
        case 22:
            return 'Tierra del Fuego';
            break;
        case 23:
            return 'Tucuman';
            break;
        default:
            return 'No Disponible';
            break;
    }
}
/*
 * No mostrar si Vale Cero
 */
function noMostrarSiEsCero($algo) {
    if($algo == 0 || $algo == '0') {
        return "";
    } else {
        return $algo;
    }
}
/*
 * Retornar Cadenas comunes para HTML.
 * Defino un salto de línea para el código HTML
*/
define('SALTO', chr(13).chr(10));
function htmlDoc() {echo('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');}
function xm() {echo('xmlns="http://www.w3.org/1999/xhtml"');}
function headPublico() {
    $head = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.SALTO;
    $head .= '<title>Buscador Ganadero de ELRURAL.COM</title>'.SALTO;
    $head .= '<link rel="stylesheet" href="comun/frente.css" type="text/css" />'.SALTO;
        echo($head);
}
?>
