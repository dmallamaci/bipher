<?php
session_start();
include_once "../inc/constantes.inc.php";
include_once "../comun/funciones.php";
include_once "../inc/class.hacienda.inc.php";
$haciendaObj = new BipherHacienda();
if ( $_POST['token'] == $_SESSION['token']
	&& !empty($_POST['action'])
	&& isset($_SESSION['LoggedIn'])
	&& $_SESSION['LoggedIn']==1)
{
	switch($_POST['action'])
	{
		case 'agregar-remate':
			$status = $haciendaObj->agregarRemate(); //OK
			$directorio = new BipherHacienda($db);
			$directorio->crearDirectorio();
			header("Location: ../login.php");
			break;
		case 'editarremate':
			$status = $haciendaObj->editaRemate(); //OK
			header("Location: ../login.php");
			break;
		case 'agregarlote':
			$status = $haciendaObj->agregarLote(); //OK
			$ri = $_POST['remate'];
			$ch = "nuevo";
//			$orn = 0; //un lote nuevo aparece en posición cero
			header("Location: ../nuevo-lote.php?subasta=$ri&lote=$ch");
			break;
		case 'editarlote':
			$status = $haciendaObj->editarLote(); //OK
			$ri = $_POST['remate_id'];
			$ch = "changed";
//			$orn = 0;	//no uso el orden verdadero, no lo necesito aqui
			header("Location: ../nuevo-lote.php?subasta=$ri&lote=$ch");
			break;
		case 'editarprecios':
			$status = $haciendaObj->editarPrecios();
			$ri = $_POST['remate_id'];
			$ch = "changed";
//			$orn = 0;	//no uso el orden verdadero, no lo necesito aqui
			header("Location: ../nuevo-lote.php?subasta=$ri&lote=$ch");
			break;
		case 'eliminar-remate':
			$haciendaObj->eliminaRemate(); //OK
			$ri = $_POST['remate'];
			$ruta = '../images/'.$ri;
			$directorio = new BipherHacienda($db);
			$directorio->eliminarDirectorio($ruta);
			header("Location: ../login.php");
			break;
		case 'eliminalote':
			$status = $haciendaObj->eliminaLote(); //OK
			$ri = $_POST['remate'];
			$ch = "borrado";
			$orn = $_POST['orden_lo'];
			header("Location: ../nuevo-lote.php?subasta=$ri&lote=$ch&orden=$orn");
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
