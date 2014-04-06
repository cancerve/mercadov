<?php
	require_once('../../../controller/sessionController.php');
	require_once '../../../includes/PHPExcel/PHPExcel.php';
	require_once '../../../includes/PHPExcel/PHPExcel/Writer/Excel2007.php';	

	require_once('../../../model/pedidoDetalleModel.php');
	require_once('../../../model/mercadoProductoModel.php');

	$NU_IdMercado = $_GET['NU_IdMercado'];
	
	$objPedidoDetalle 	= new PedidoDetalle();
	$objMercadoProducto = new MercadoProducto();
	
	////////// CONSULTAS ////////
	$RSPedidoDetalle		= $objPedidoDetalle->crearInventario2($objConexion,$NU_IdMercado);
	$cantRSPedidoDetalle	= $objConexion->cantidadRegistros($RSPedidoDetalle);
	
	$RSProducMercado 	= $objMercadoProducto->cantProducXmerc($objConexion,$NU_IdMercado);	
	$cantRSProducMercado= $objConexion->cantidadRegistros($RSProducMercado);
	
	///////////// CREACION DEL DOCUMENTO
	
	/** Error reporting */
	error_reporting(E_ALL);
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// PROPIEDADES DEL LIBRO
	$objPHPExcel->getProperties()->setCreator("Venezolana de Alimentos La Casa, VENALCASA S.A."); //Autor
	$objPHPExcel->getProperties()->setLastModifiedBy("Sistema elaborado por la Ofic. Asuntos Institucionales e Internacionales"); //ultimo cambio
	$objPHPExcel->getProperties()->setTitle("Inventario de Compras del Mercado Virtual");
	$objPHPExcel->getProperties()->setSubject("Inventario de Compras del Mercado Virtual");
	$objPHPExcel->getProperties()->setDescription("Inventario de Compras del Mercado Virtual");
	
	// Establecer la hoja activa, para que cuando se abra el documento se muestre primero
	$objPHPExcel->setActiveSheetIndex(0);
?>
<?php
	////// CUERPO DEL ARCHIVO DE EXCEL - CONTENIDO - ////////////
	$contador =0;
	$tituloSede ='';
	$tituloGerencia ='';
	$CantGerencia	 = 0;
	$fila = 1;
	$PriColumna = '';
	$UltColumna = '';
	
	$AF_RazonSocial 		= utf8_decode(strtoupper($objConexion->obtenerElemento($RSPedidoDetalle,0,"AF_RazonSocial")));
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', $AF_RazonSocial);
	
	for ($i=0;$i<$cantRSPedidoDetalle;$i++){
		
		$AL_NombreSede 		= strtoupper($objConexion->obtenerElemento($RSPedidoDetalle,$i,"AL_NombreSede"));
		$AL_NombreGerencia 	= $objConexion->obtenerElemento($RSPedidoDetalle,$i,"AL_NombreGerencia");
		$NU_Cantidad 		= $objConexion->obtenerElemento($RSPedidoDetalle,$i,"NU_Cantidad");
		
		if ($tituloSede != $AL_NombreSede){ 
			$CantGerencia=0;
			$fila = $fila + 3;
			$tituloSede = $AL_NombreSede; 
			$Columna = chr(65+$contador).$fila;
			$objPHPExcel->getActiveSheet()->SetCellValue($Columna, $AL_NombreSede);

			$fila++;
			$Columna = chr(65+$contador).$fila;
			$objPHPExcel->getActiveSheet()->SetCellValue($Columna, 'Nro');	
			$Columna = chr(66+$contador).$fila;
			$objPHPExcel->getActiveSheet()->SetCellValue($Columna, 'Ubicación');	
					
			for ($z=0;$z<$cantRSProducMercado;$z++){
				$Columna = chr(67+$z).$fila;
				$AF_NombreProducto 	= $objConexion->obtenerElemento($RSProducMercado,$z,"AF_NombreProducto");			
				$objPHPExcel->getActiveSheet()->SetCellValue($Columna, $AF_NombreProducto);			
			}
			$Columna = chr(67+$z).$fila;
			$objPHPExcel->getActiveSheet()->SetCellValue($Columna, 'TOTAL');			
		}

		if ($tituloGerencia != $AL_NombreGerencia){
			$fila++;
			$CantGerencia++;
			$tituloGerencia = $AL_NombreGerencia; 
			$Columna = chr(65+$contador).$fila;
			$objPHPExcel->getActiveSheet()->SetCellValue($Columna, $CantGerencia);
			$Columna = chr(66+$contador).$fila;
			$objPHPExcel->getActiveSheet()->SetCellValue($Columna, $AL_NombreGerencia);
		}
		
		$contador++;

		/////////// SUMA ULTIMA COLUMNA //////////
		$Columna = chr(66+$contador+1).$fila;
		$PriColumna	= 'C'.$fila;	
		$UltColumna	= chr(66+$cantRSProducMercado).$fila;	
		$objPHPExcel->getActiveSheet()->SetCellValue($Columna, '=SUM('.$PriColumna.':'.$UltColumna.')');
		
		/////////// CANTIDADES //////////
		$Columna = chr(66+$contador).$fila;
		$objPHPExcel->getActiveSheet()->SetCellValue($Columna, $NU_Cantidad);
		
		///////////  FIN CUERPO //////////
		if ($contador == $cantRSProducMercado){ 
			$contador=0;
		}   		
	}

	/////////////////CREACION DEL DOCUMENTO	
	// Orientacion y tamano de la pagina
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

	// Cambiar nombre de la Hoja
	$objPHPExcel->getActiveSheet()->setTitle('Inventario General');
	
	// Guardar Archivo en formato Excel 2007
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

	// Abrir Documento
	header("Location: documento_xls.xlsx");
?>
