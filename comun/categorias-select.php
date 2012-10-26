<?php
/*
 * Desplegable de Categorías. Puede recibir o no la variable $cat, que es el
 * número de categoría. Si existe $cat muestra el desplegable con esa
 * categoría seleccionada.
 */
// Variables vacías para el atributo "selected" del desplegable
$opcion = array();
$i = 1;
    while($i<15){
        $opcion[$i]='';
        $i++;
    }
// Si recibo la variable $cat (entero de la Categoría) imprimo el "selected"
If(isset($cat))
{
    switch($cat)
    {
    case 1:
        $opcion[1] = ' selected="selected"';
        break;
    case 2:
        $opcion[2] = ' selected="selected"';
        break;
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
    case 7:
        $opcion[7] = ' selected="selected"';
        break;
    case 8:
        $opcion[8] = ' selected="selected"';
        break;
    case 9:
        $opcion[9] = ' selected="selected"';
        break;
    case 10:
        $opcion[10] = ' selected="selected"';
        break;
    case 11:
        $opcion[11] = ' selected="selected"';
        break;
    case 12:
        $opcion[12] = ' selected="selected"';
        break;
    case 13:
        $opcion[13] = ' selected="selected"';
        break;
    case 14:
        $opcion[14] = ' selected="selected"';
        break;
    default:
        return '';
        break;
    }
}
?>
<select id="categoria" name="categoria">
    <optgroup label="HACIENDA PARA FAENA">
        <option value="2"<?php echo $opcion[2] ?>><?php echo decirCategoria(2)?></option>
        <option value="1"<?php echo $opcion[1] ?>><?php echo decirCategoria(1)?></option>
        <option value="9"<?php echo $opcion[9] ?>><?php echo decirCategoria(9)?></option>
    </optgroup>
    <optgroup label="INVERNADA Y CRIA">
        <option value="4"<?php echo $opcion[4] ?>><?php echo decirCategoria(4)?></option>
        <option value="3"<?php echo $opcion[3] ?>><?php echo decirCategoria(3)?></option>
        <option value="5"<?php echo $opcion[5] ?>><?php echo decirCategoria(5)?></option>
        <option value="13"<?php echo $opcion[13] ?>><?php echo decirCategoria(13)?></option>
        <option value="10"<?php echo $opcion[10] ?>><?php echo decirCategoria(10)?></option>
        <option value="11"<?php echo $opcion[11] ?>><?php echo decirCategoria(11)?></option>
        <option value="14"<?php echo $opcion[14] ?>><?php echo decirCategoria(14)?></option>
        <option value="12"<?php echo $opcion[12] ?>><?php echo decirCategoria(12)?></option>
        <option value="7"<?php echo $opcion[7] ?>><?php echo decirCategoria(7)?></option>
        <option value="6"<?php echo $opcion[6] ?>><?php echo decirCategoria(6)?></option>
    </optgroup>
    <optgroup label="VARIOS">
        <option value="8"<?php echo $opcion[8] ?>><?php echo decirCategoria(8)?></option>
    </optgroup>
</select>