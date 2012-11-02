<?php
// Setear el informe de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Incluir credenciales y funciones
include_once 'inc/constantes.inc.php';
include_once 'comun/funciones.php';
// Crear la conexión a DB
    try {
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
        $db = new PDO($dsn, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        echo 'Falló conexion a base de datos: ' . $e->getMessage();
        exit;
    }
?>