<?php
include_once 'comun/publico.php';
$provincia = trim($_POST["provincia"]);
        $sql  ="SELECT localidad_id, provincia_id, localidad FROM localidades WHERE provincia_id = :provincia ORDER BY localidad ASC";    
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':provincia', $provincia, PDO::PARAM_INT);
            $stmt->execute();           
            $jason = '{';
            foreach ($stmt as $c)
            {
            $lid = $c['localidad_id'];
            // COMENTAR EN SERVIDOR
            $lok =  utf8_encode($c['localidad']);
            // sin utf8_encode COMENTAR EN LOCALHOST
//            $lok = $c['localidad'];            
            $jason.= '"'.$lid.'": "'.$lok.'",';
            }
            //eliminar la ultima coma
            $jason = substr($jason, 0, strlen($jason)-1);   
            //cerrar el vector
            $jason .= "}";            
            echo $jason;
?>