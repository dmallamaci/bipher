<?php
session_start();
include_once "../inc/constantes.inc.php";
include_once "../comun/funciones.php";
include_once "../inc/class.banners.inc.php";
$bannerObj = new BipherBanners();
if ( $_POST['token'] == $_SESSION['token']
	&& !empty($_POST['action'])
	&& isset($_SESSION['LoggedIn'])
	&& $_SESSION['LoggedIn']==1)
{
	switch($_POST['action'])
	{
		case 'editar-orden':
			$status = $bannerObj->cambiarOrdenBanners();
			header("Location: ../banners.php");
			break;
		case 'editar-banner':
			$status = $bannerObj->editarBanner();
			header("Location: ../banners.php");
			break;
		case 'eliminar-banner':
			$status = $bannerObj->eliminarGrafico();
			$status = $bannerObj->eliminarBanner();
			header("Location: ../banners.php");
			break;
		case 'atras':
			header("Location: ../login.php");
			break;
		default:
			header("Location: ../login.php");
			break;
	}
}
else
{
	header("Location: ../index.php");
	exit;
}
?>
