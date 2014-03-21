<?php
	require_once('../controller/sessionController.php'); 
	require_once('../model/solicitudInventarioModel.php');

	$objsolicitudInventario = new solicitudInventario();
?>
<?php	
////////////////////// RECUPERAR CLAVE DE USUARIO /////////////////////////////////
	if ($_POST['origen']=='crear_solicitud')
	{
		$mercado_NU_IdMercado = $_POST['mercado_NU_IdMercado'];
		
		$objsolicitudInventario->insertar($objConexion,$mercado_NU_IdMercado,$_SESSION['NU_IdUsuario']);
		
		$NU_IdSolicitudInventario = $objsolicitudInventario->obtenerUltimo($objConexion);

		header("Location: ../views/consulta/1/documento.php?NU_IdSolicitudInventario=$NU_IdSolicitudInventario");
	}
	
?>