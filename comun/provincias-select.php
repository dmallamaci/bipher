<?php
/*
 * Desplegable de Provincias. Puede recibir o no la variable $prov, que es el
 * número de provincia. Si existe $prov muestra el desplegable con esa
 * provincia seleccionada.
 */
// Variables vacías para el atributo "selected" del desplegable
$opcion = array();
$i = 1;
    while($i<24){
        $opcion[$i]='';
        $i++;
    }
// Si recibo la variable $prov (entero de la Provincia) imprimo el "selected"
If(isset($prov))
{
    switch($prov)
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
    case 15:
        $opcion[15] = ' selected="selected"';
        break;
    case 16:
        $opcion[16] = ' selected="selected"';
        break;
    case 17:
        $opcion[17] = ' selected="selected"';
        break;
    case 18:
        $opcion[18] = ' selected="selected"';
        break;
    case 19:
        $opcion[19] = ' selected="selected"';
        break;
    case 20:
        $opcion[20] = ' selected="selected"';
        break;
    case 21:
        $opcion[21] = ' selected="selected"';
        break;
    case 22:
        $opcion[22] = ' selected="selected"';
        break;
    case 23:
        $opcion[23] = ' selected="selected"';
        break;
    default:
        return '';
        break;
    }
}
?>
<label for="provincia">Seleccione la Provincia </label>
	<select id="provincia" name="provincia">
		<option> - seleccione - </option>
		<option value="1"<?php echo $opcion[1] ?>><?php echo decirProvincia(1)?></option>
		<option value="2"<?php echo $opcion[2] ?>><?php echo decirProvincia(2)?></option>
		<option value="3"<?php echo $opcion[3] ?>><?php echo decirProvincia(3)?></option>
		<option value="4"<?php echo $opcion[4] ?>><?php echo decirProvincia(4)?></option>
		<option value="5"<?php echo $opcion[5] ?>><?php echo decirProvincia(5)?></option>
		<option value="6"<?php echo $opcion[6] ?>><?php echo decirProvincia(6)?></option>
		<option value="7"<?php echo $opcion[7] ?>><?php echo decirProvincia(7)?></option>
		<option value="8"<?php echo $opcion[8] ?>><?php echo decirProvincia(8)?></option>
		<option value="9"<?php echo $opcion[9] ?>><?php echo decirProvincia(9)?></option>
		<option value="10"<?php echo $opcion[10] ?>><?php echo decirProvincia(10)?></option>
		<option value="11"<?php echo $opcion[11] ?>><?php echo decirProvincia(11)?></option>
		<option value="12"<?php echo $opcion[12] ?>><?php echo decirProvincia(12)?></option>
		<option value="13"<?php echo $opcion[13] ?>><?php echo decirProvincia(13)?></option>
		<option value="14"<?php echo $opcion[14] ?>><?php echo decirProvincia(14)?></option>
		<option value="15"<?php echo $opcion[15] ?>><?php echo decirProvincia(15)?></option>
		<option value="16"<?php echo $opcion[16] ?>><?php echo decirProvincia(16)?></option>
		<option value="17"<?php echo $opcion[17] ?>><?php echo decirProvincia(17)?></option>
		<option value="18"<?php echo $opcion[18] ?>><?php echo decirProvincia(18)?></option>
		<option value="19"<?php echo $opcion[19] ?>><?php echo decirProvincia(19)?></option>
		<option value="20"<?php echo $opcion[20] ?>><?php echo decirProvincia(20)?></option>
		<option value="21"<?php echo $opcion[21] ?>><?php echo decirProvincia(21)?></option>
		<option value="22"<?php echo $opcion[22] ?>><?php echo decirProvincia(22)?></option>
		<option value="23"<?php echo $opcion[23] ?>><?php echo decirProvincia(23)?></option>
	</select>
