<?php
include_once 'comun/publico.php';
//include_once 'inc/class.publico.inc.php';
//comentario
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="js/desplegable.js" type="text/javascript"></script>
</head>
<body>
    <h1>Conexión</h1>
    <form>
        <?php include 'comun/categorias-select.php'; ?>
       <br/>     
          <select id="provincia" name="provincia">
                <option>Cargando...</option>
          </select>
          <br/>       
          <select id="municipio" name="municipio">
                <option>Seleccione una Localidad</option>
           </select>
            <br />          
            <select id="radio" name="radio">
                <option value="150">Buscar en 150 km de radio</option>
                <option value="250">Buscar en 250 km de radio</option>
                <option value="350">Buscar en 350 km de radio</option>
                <option value="4000">Buscar en todo el Pa&iacute;s</option>
         </select>
        <br/>
                <input type="submit" name="centrocoord"
                    id="filtrarlotes" value="Buscar Lotes"
                    class="button" />
        
    </form>
    <?php 
/*
        echo 'hola';
        $listarem = new BipherPublico($db);
        $listarem->listaRemates();
*/


    ?>
</body>
</html>
