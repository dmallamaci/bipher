<?php
// Setear el informe de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Iniciar una sesión PHP
session_start();
// Incluir credenciales y funciones
include_once 'inc/constantes.inc.php';
include_once 'comun/funciones.php';
	if ( !isset($_SESSION['token']) || time()-$_SESSION['token_time']>=300 )
	{
		$_SESSION['token'] = md5(uniqid(rand(), TRUE));
		$_SESSION['token_time'] = time();
	}
// Crear la conexión a DB
    try {
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
        $db = new PDO($dsn, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        echo 'Falló conexion a base de datos: ' . $e->getMessage();
        exit;
    }
?>
