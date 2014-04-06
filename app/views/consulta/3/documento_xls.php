<?php
	require_once('../../../controller/sessionController.php');
	require_once '../../../includes/PHPExcel/PHPExcel.php';
	require_once '../../../includes/PHPExcel/PHPExcel/Writer/Excel2007.php';	

	require_once('../../../model/pedidoDetalleModel.php');
	require_once('../../../model/mercadoProductoModel.php');

	$NU_IdMercado = $_GET['NU_IdMercado'];
	
	$objPedidoDetalle 	= new PedidoDetalle();
	$objMercadoProducto = new MercadoProducto();

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
	
	//////////// AGREGAR HEAD1
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Logo');
	$objDrawing->setDescription('Logo');
	$objDrawing->setPath('../../../images/head1.jpg');
	$objDrawing->setHeight(30);
	$objDrawing->setCoordinates('A1');
	$objDrawing->setOffsetX(0);
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

	//////////// AGREGAR HEAD2
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Logo');
	$objDrawing->setDescription('Logo');
	$objDrawing->setPath('../../../images/head2.jpg');
	$objDrawing->setHeight(30);
	$objDrawing->setCoordinates('Q1');
	$objDrawing->setOffsetX(0);
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

	//////////// LOGO VENALCASA
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Logo');
	$objDrawing->setDescription('Logo');
	$objDrawing->setPath('../../../images/logo.jpg');
	$objDrawing->setHeight(80);
	$objDrawing->setCoordinates('A3');
	$objDrawing->setOffsetX(0);
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

	////////// CONSULTAS ////////
	$RSPedidoDetalle		= $objPedidoDetalle->crearInventario($objConexion,$NU_IdMercado);
	$cantRSPedidoDetalle	= $objConexion->cantidadRegistros($RSPedidoDetalle);
	
	$RSProducMercado 	= $objMercadoProducto->cantProducXmerc($objConexion,$NU_IdMercado);	
	$cantRSProducMercado= $objConexion->cantidadRegistros($RSProducMercado);

	/////////INICIALIZACION DE VARIABLES //////////////
	$fila 			= 5;
	$BI_Sede 		= '';
	$BI_Gerencia 	= '';
	$BI_Producto 	= '';
	$contador 		= 0;
	$contarG 		= '';
	/*
	for($z=0; $z<$cantRSProducMercado+1; $z++){
		$ColFinal[$z] = '';
	}
	*/
	///////// ESTILOS DE CELDAS ///////
	$NegritaGrande = array(
		'font'    	=> array(
			'bold'      => true,
			'size'		=> 14,
		),
		'alignment' => array(
			'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,	
		)
	);
	
	$Negrita = array(
		'font'    	=> array(
			'bold'      => true,
		),
		'alignment' => array(
			'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,				
		),
		'borders' 	=> array(
			'allborders' 	=> array(
				'style' 		=> PHPExcel_Style_Border::BORDER_THIN,
			),
		),
		'fill' => array(
			'type'       	=> PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' 	=> array(
				'argb' 			=> 'CCCCCC'
			)
		)
	);
	
	$Negrita2 = array(
		'font'    	=> array(
			'bold'      => true,
		),
		'alignment' => array(
			'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,				
		),
		'borders' 	=> array(
			'allborders' 	=> array(
				'style' 		=> PHPExcel_Style_Border::BORDER_THIN,
			),
		),
		'fill' => array(
			'type'       	=> PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' 	=> array(
				'argb' 			=> 'CCCCCC'
			)
		)
	);
	
	$Borde = array(
		'borders' 	=> array(
			'allborders' 	=> array(
				'style' 		=> PHPExcel_Style_Border::BORDER_THIN,
			),
		)
	);

	$Total = array(
		'font'    	=> array(
			'bold'      	=> true
		),
		'alignment' => array(
			'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,				
		)	
	);
	/////// FIN DE ESTILOS


	////// CUERPO DEL ARCHIVO DE EXCEL - CONTENIDO - ////////////
	for ($b=0; $b<($cantRSProducMercado+3); $b++){
		$letra = chr(65+$b);
		$objPHPExcel->getActiveSheet()->getStyle($letra)->getFont()->setName('Arial');
		$objPHPExcel->getActiveSheet()->getStyle($letra)->getFont()->setSize(8);
	}

	for ($a=0;$a<$cantRSPedidoDetalle;$a++){
		$fila++;
		$empresa 			= $objConexion->obtenerElemento($RSPedidoDetalle,0,"empresa");
		$NU_IdSede 			= strtoupper($objConexion->obtenerElemento($RSPedidoDetalle,$a,"NU_IdSede"));
		$AL_NombreSede 		= strtoupper($objConexion->obtenerElemento($RSPedidoDetalle,$a,"AL_NombreSede"));
		$NU_IdGerencia 	= $objConexion->obtenerElemento($RSPedidoDetalle,$a,"NU_IdGerencia");
		$AL_NombreGerencia 	= $objConexion->obtenerElemento($RSPedidoDetalle,$a,"AL_NombreGerencia");
	
		///////////// NOMBRE SEDES ///////////////////
		if ($BI_Sede != $NU_IdSede){
			if ($fila!=6){
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$fila.':B'.$fila);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($Total);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, 'TOTAL');

				////////////// SUMATORIA POR PRODUCTOS ////////////////////
				for($z=0; $z<$cantRSProducMercado+1; $z++){
					$Columna3		= chr(67+$z).$fila;
					$PriColumna3	= chr(67+$z).($fila-$contarG);	
					$UltColumna3	= chr(67+$z).($fila-1);	
					$objPHPExcel->getActiveSheet()->getStyle($Columna3)->applyFromArray($Negrita2);
					$objPHPExcel->getActiveSheet()->getStyle($Columna3)->applyFromArray($Borde);						
					$objPHPExcel->getActiveSheet()->SetCellValue($Columna3, '=SUM('.$PriColumna3.':'.$UltColumna3.')');
					/*
					if ($ColFinal[$z]==''){
						$ColFinal[$z] = $Columna3;
					}else{
						$ColFinal[$z] .= ','.$Columna3;
					}
					*/
				}
				$contarG = 0;
			}
			$fila 		= $fila+2;
			$UltColumna	= chr(65+$cantRSProducMercado+2).$fila;		
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$fila.':'.$UltColumna);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':'.$UltColumna)->applyFromArray($Negrita);					
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, $AL_NombreSede);
			$BI_Sede 	= $NU_IdSede;
			$fila++;

			////////////// FILA NOMBRES DE PRODUCTOS ////////////////////
			$Columna	= chr(65).$fila;
			$objPHPExcel->getActiveSheet()->SetCellValue($Columna, 'Nro');
			$Columna	= chr(66).$fila;
			$objPHPExcel->getActiveSheet()->SetCellValue($Columna, 'Ubicación');
			
			for($i=0; $i<$cantRSProducMercado; $i++){
				$AF_NombreProducto 	= $objConexion->obtenerElemento($RSProducMercado,$i,"AF_NombreProducto");
				$Columna			= chr(67+$i).$fila;                 
				$objPHPExcel->getActiveSheet()->getStyle($Columna)->getAlignment()->setWrapText(true);																				
				$objPHPExcel->getActiveSheet()->SetCellValue($Columna, $AF_NombreProducto);
			} 
			
			$Columna	= chr(67+$i).$fila;
			$objPHPExcel->getActiveSheet()->getStyle($Columna)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($Columna)->applyFromArray($Borde);													
			$objPHPExcel->getActiveSheet()->SetCellValue($Columna, 'TOTAL');
			$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':'.$Columna)->applyFromArray($Negrita);					
		}else{
			$fila--;	
		}
		////////////// NOMBRE GERENCIAS /////////////
		$fila++;	
		
		if ($BI_Gerencia != $NU_IdGerencia){
			$contarG++;	
			$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($Negrita);													
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, $contarG);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray($Borde);													
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$fila, $AL_NombreGerencia);
			$BI_Gerencia = $NU_IdGerencia;
		}else{
			$fila--;	
		}
		$contador++;
		$cantidad	= $objConexion->obtenerElemento($RSPedidoDetalle,$a,"cantidad"); 
		$Columna 	= chr(66+$contador).$fila;
		$objPHPExcel->getActiveSheet()->getStyle($Columna)->applyFromArray($Borde);
		$objPHPExcel->getActiveSheet()->SetCellValue($Columna, $cantidad);
		$Columna2 	= chr(66+$contador+1).$fila;
		$UltColumna2= chr(66+$cantRSProducMercado).$fila;	
		$objPHPExcel->getActiveSheet()->getStyle($Columna2)->applyFromArray($Borde);
		$objPHPExcel->getActiveSheet()->SetCellValue($Columna2, '=SUM(C'.$fila.':'.$UltColumna2.')');

		if ($contador == $cantRSProducMercado){
			$contador = 0;
		}
	}// FIN FOR

	////////////// SUMATORIA ULTIMA FILA ////////////////////
	$fila++;
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$fila.':B'.$fila);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($Total);
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, 'TOTAL');
		
	
	for($z=0; $z<$cantRSProducMercado+1; $z++){
		$Columna3	= chr(67+$z).$fila;
		$PriColumna3= chr(67+$z).($fila-$contarG);	
		$UltColumna3= chr(67+$z).($fila-1);	
		$objPHPExcel->getActiveSheet()->getStyle($Columna3)->applyFromArray($Negrita2);
		$objPHPExcel->getActiveSheet()->getStyle($Columna3)->applyFromArray($Borde);
		$objPHPExcel->getActiveSheet()->SetCellValue($Columna3, '=SUM('.$PriColumna3.':'.$UltColumna3.')');
/*		
		if ($ColFinal[$z]==''){
			$ColFinal[$z] = $Columna3;
		}else{
			$ColFinal[$z] .= ';'.$Columna3;
		}		
*/	
	}
/*
	//////////TOTAL GENERAL //////////
	$fila = $fila + 2;
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$fila.':B'.$fila);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($Total);
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, 'TOTAL GENERAL');
		
	for($z=0; $z<$cantRSProducMercado+1; $z++){
		$Columna3	= chr(67+$z).$fila;
		$PriColumna3= chr(67+$z).($fila);	
		$UltColumna3= chr(67+$z).($fila-1);	
		$objPHPExcel->getActiveSheet()->getStyle($Columna3)->applyFromArray($Negrita2);
		$objPHPExcel->getActiveSheet()->getStyle($Columna3)->applyFromArray($Borde);
//		for($x=0; $x<$cantRSProducMercado+1; $x++){
//			echo $ColFinal[$z];
//			echo '</br>';
			$objPHPExcel->getActiveSheet()->SetCellValue($Columna3, '=SUMA('.$ColFinal[$z].')');
//		}															 //=SUMA(C119;C113;C96;C70;C60)
	}
//die();
*/
	//////////ESCRIBIR TITULO //////////
	$UltColumna		= chr(66+$cantRSProducMercado).'5';
	$tituloReporte 	= strtoupper("Inventario Total de las Compras del Mercado Virtual: DGRH-GBS-M0").$NU_IdMercado." - ".$empresa;
	$objPHPExcel->getActiveSheet()->mergeCells('C3:'.$UltColumna);
	$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($NegritaGrande);
	$objPHPExcel->getActiveSheet()->SetCellValue('C3', $tituloReporte);	

	///////// PIE DE PAGINA
	$fila 		= $fila +3;
	$UltColumna = chr(65+$cantRSProducMercado+1).$fila;	
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$fila.':'.$UltColumna);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getFont()->setSize(6);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);																				
	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, 'Sistema elaborado por la Oficina de Asuntos Institucionales e Internacionales de VENALCASA, S.A. G-20008504-5');	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);

	for ($b=0; $b<($cantRSProducMercado+2); $b++){
		$letra = chr(67+$b);	
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(8);	
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