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

	////////// CONSULTAS ////////
	$RSPedidoDetalle		= $objPedidoDetalle->crearInventario2($objConexion,$NU_IdMercado);
	$cantRSPedidoDetalle	= $objConexion->cantidadRegistros($RSPedidoDetalle);
	
	$RSProducMercado 	= $objMercadoProducto->cantProducXmerc($objConexion,$NU_IdMercado);	
	$cantRSProducMercado= $objConexion->cantidadRegistros($RSProducMercado);

?>
<table width="50%" border="1" cellspacing="2" cellpadding="2">
  <tr>
<?php
	////// CUERPO DEL ARCHIVO DE EXCEL - CONTENIDO - ////////////
	$contador =0;
	$tituloSede ='';
	$tituloGerencia ='';	
	
	for ($i=0;$i<$cantRSPedidoDetalle;$i++){
		$AL_NombreSede 		= utf8_decode(strtoupper($objConexion->obtenerElemento($RSPedidoDetalle,$i,"AL_NombreSede")));
		$AL_NombreGerencia 	= utf8_decode($objConexion->obtenerElemento($RSPedidoDetalle,$i,"AL_NombreGerencia"));
		$AF_NombreProducto 	= utf8_decode($objConexion->obtenerElemento($RSPedidoDetalle,$i,"AF_NombreProducto"));
		$NU_Cantidad 		= utf8_decode($objConexion->obtenerElemento($RSPedidoDetalle,$i,"NU_Cantidad"));
		
		if ($contador==0){ echo '<tr>'; }
			
			if ($tituloSede != $AL_NombreSede){ 
				echo '<tr><td>&nbsp;';
				$tituloSede=$AL_NombreSede; 
				echo $AL_NombreSede;
				echo '</td></tr>';
			}
			
			
			if ($tituloGerencia != $AL_NombreGerencia){
				 echo '</tr><td>&nbsp;';
				$tituloGerencia=$AL_NombreGerencia; 
				echo $AL_NombreGerencia;
				echo '</td></tr>';
				//echo '<td>&nbsp;</td>';
			}else{
				//echo '<td>&nbsp;</td>';
			}
						

?>
        
        <td>&nbsp;<?=$NU_Cantidad?></td>
<?php	
		$contador++;
		if ($contador==$cantRSProducMercado){ 
			echo '</tr>'; $contador=0;
		}             
	}
?>

  <?php
die();
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
</p>
<p>&nbsp;</p>
<table width="100" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>SEDE</td>
    <td>GERENCIA</td>
    <td>PEDIDOS</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><table width="100" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td>NRO</td>
        <td>EMPLEADO</td>
        <td>PRODUCTO</td>
        <td>CANTIDAD</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp; </p>
