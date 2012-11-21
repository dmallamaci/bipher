<?php
/*
 * Desplegable de Categorías. Puede recibir o no la variable $cat, que es el
 * número de categoría. Si existe $cat muestra el desplegable con esa
 * categoría seleccionada.
 */
// Variables vacías para el atributo "selected" del desplegable
$opcion = array();
$i = 1;
    while($i<7){
        $opcion[$i]='';
        $i++;
    }
// Si recibo la variable $ambito (entero de la Ambito) imprimo el "selected"
If(isset($amb))
{
    switch($amb)
    {
    case 3:
        $opcion[3] = ' selected="selected"';
        break;
    case 4:
        $opcion[4] = ' selected="selected"';
        break;
    case 5:
        $opcion[5] = ' selected="selected"';
        break;
    case 6:
        $opcion[6] = ' selected="selected"';
        break;
    default:
        return '';
        break;
    }
}
?>
		    <label for="ambito">Posición </label>
		    <select id="ambito" name="ambito">
				<option value="4"<?php echo $opcion[4] ?>>300px - Left</option>
				<option value="3"<?php echo $opcion[3] ?>>780px - Top</option>
				<option value="5"<?php echo $opcion[5] ?>>780px - Middle</option>
				<option value="6"<?php echo $opcion[6] ?>>780px - Bottom</option>
		    </select>
