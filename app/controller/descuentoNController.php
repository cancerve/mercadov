<?php
	require_once('../controller/sessionController.php'); 
	require_once('../model/descuentoNModel.php');

	$objDescuentoN = new DescuentoN();
?>
<?php	
////////////////////// RECUPERAR CLAVE DE USUARIO /////////////////////////////////
	if ($_POST['origen']=='descuento_nomina')
	{
		$mercado_NU_IdMercado = $_POST['mercado_NU_IdMercado'];
		
		$objDescuentoN->insertar($objConexion,$mercado_NU_IdMercado,$_SESSION['NU_IdUsuario']);
		
		$NU_IdDescuento = $objDescuentoN->obtenerUltimo($objConexion);

		header("Location: ../views/consulta/2/documento.php?NU_IdDescuento=$NU_IdDescuento");
	}
	
?>