<?php
	require_once('../controller/sessionController.php'); 
?>
<?php	
////////////////////// RECUPERAR CLAVE DE USUARIO /////////////////////////////////

	if ($_POST['origen']=='inventario')
	{
		$NU_IdMercado = $_POST['mercado_NU_IdMercado'];
		$formato 	  = $_POST['formato'];
		
		switch($formato){
			case 'pdf':  header("Location: ../views/consulta/3/documento_pdf.php?NU_IdMercado=".$NU_IdMercado); break;
			case 'txt':  header("Location: ../views/consulta/3/documento_txt.php?NU_IdMercado=".$NU_IdMercado); break;
			case 'xls':  header("Location: ../views/consulta/3/documento_xls.php?NU_IdMercado=".$NU_IdMercado); break;
		}		
	}
	
?>