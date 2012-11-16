<?php
/*
 * Desplegable de Logos. Puede recibir o no la variable $logo, que es el
 * path del logo. Si existe $logo muestra el desplegable con ese
 * logo seleccionado.
 */
// Variables vacías para el atributo "selected" del desplegable
$opcion = array();
$i = 1;
    while($i<17){
        $opcion[$i]='';
        $i++;
    }
// Si recibo la variable $logo imprimo el "selected"
if(isset($logo))
{
    switch($logo)
    {
	case 0:
        $opcion[0] = ' selected="selected"';
        break;
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
	//~ case 17:
        //~ $opcion[17] = ' selected="selected"';
        //~ break;
	//~ case 18:
        //~ $opcion[18] = ' selected="selected"';
        //~ break;
    //~ case 19:
        //~ $opcion[19] = ' selected="selected"';
        //~ break;
    //~ case 20:
        //~ $opcion[20] = ' selected="selected"';
        //~ break;
    //~ case 21:
        //~ $opcion[21] = ' selected="selected"';
        //~ break;
    //~ case 22:
        //~ $opcion[22] = ' selected="selected"';
        //~ break;
    //~ case 23:
        //~ $opcion[24] = ' selected="selected"';
        //~ break;
    default:
        return '';
        break;
    }
}
?>
	<label for="logo_re">Logo </label>
	<select name="logo_re" id="logo_re" onchange="cambiaLogo(this.options[this.selectedIndex].value)">
		<option value="images/logos/102x70.png"<?php echo $opcion[0] ?>>Ninguno</option>
		<option value="images/logos/rural.png"<?php echo $opcion[1] ?>>Generico - Rural</option>
		<option value="images/logos/abelenda.png"<?php echo $opcion[2] ?>>Abelenda</option>
		<option value="images/logos/afa.png"<?php echo $opcion[3] ?>>A.F.A.</option>
		<option value="images/logos/campos-y-ganados.png"<?php echo $opcion[4] ?>>Campos y Ganados</option>
		<option value="images/logos/colombo-ganados.png"<?php echo $opcion[5] ?>>Colombo Ganados</option>
		<option value="images/logos/colombo-y-magliano.png"<?php echo $opcion[6] ?>>Colombo y Magliano</option>
		<option value="images/logos/egana.png"<?php echo $opcion[7] ?>>Egaña</option>
		<option value="images/logos/ernesto-j-duarte.png"<?php echo $opcion[8] ?>>Ernesto J. Duarte</option>
		<option value="images/logos/hasenkamp.png"<?php echo $opcion[9] ?>>Hasenkamp</option>
		<option value="images/logos/ivan-ofarrell.png"<?php echo $opcion[10] ?>>Ivan Ofarrell</option>
		<option value="images/logos/lartirigoyen.png"<?php echo $opcion[11] ?>>Lartirigoyen</option>
		<option value="images/logos/llorente.png"<?php echo $opcion[12] ?>>Grupo Llorente</option>
		<option value="images/logos/rosgan.png"<?php echo $opcion[13] ?>>Rosgan</option>
		<option value="images/logos/saenz-valiente-bullrich.png"<?php echo $opcion[14] ?>>Saenz Valiente Bullrich</option>
		<option value="images/logos/subastar-colombia.png"<?php echo $opcion[15] ?>>Subastar Colombia</option>
		<option value="images/logos/umc.png"<?php echo $opcion[16] ?>>UMC</option>
	</select>
	<span>&nbsp;</span>
	<img id="logo-consignataria" src="<?php if(isset($logo)){echo $logo;}else{echo 'images/logos/102x70.png';} ;?>" alt="Logo" />
