<?php 
	require_once('../../controller/sessionController.php'); 
	require_once('../../model/pedidoModel.php');
	require_once('../../model/pedidoDetalleModel.php');
	require_once('../../model/usuarioModel.php');
	require('../../includes/pdf/fpdf.php'); 
	
	$objPedido 			= new Pedido();
	$objPedidoDetalle	= new PedidoDetalle();
	$objUsuario 		= new Usuario();
	

?>
<?php
	$NU_IdPedido = $_GET['pedido_NU_IdPedido'];
	$_SESSION['NU_IdPedido'] = $NU_IdPedido;
	
	$RSPedido	= $objPedido->buscar($objConexion,$NU_IdPedido);
	$cantRS 	= $objConexion->cantidadRegistros($RSPedido);
	
	if ($cantRS>0){
		$_SESSION['AF_CodPedido'] 		= $objConexion->obtenerElemento($RSPedido,0,"AF_CodPedido");		
		$_SESSION['NU_IdMercado'] 		= $objConexion->obtenerElemento($RSPedido,0,"mercado_NU_IdMercado");	
		
		$_SESSION['AL_Nombre'] 			= ucwords(strtolower($objConexion->obtenerElemento($RSPedido,0,"AL_Nombre")));
		$_SESSION['AL_Apellido'] 		= ucwords(strtolower($objConexion->obtenerElemento($RSPedido,0,"AL_Apellido")));
		$_SESSION['cedula'] 			= $objConexion->obtenerElemento($RSPedido,0,"NU_Cedula");
		if ($_SESSION['cedula']!=''){
			$_SESSION['cedula'] 			= number_format($objConexion->obtenerElemento($RSPedido,0,"NU_Cedula"),0,'','.');
		}
		$_SESSION['AF_RazonSocial'] 	= $objConexion->obtenerElemento($RSPedido,0,"AF_RazonSocial");	
		$_SESSION['AL_NombreSede'] 		= $objConexion->obtenerElemento($RSPedido,0,"AL_NombreSede");			
		$_SESSION['AL_NombreGerencia'] 	= $objConexion->obtenerElemento($RSPedido,0,"AL_NombreGerencia");			
		$_SESSION['FE_FechaPedido'] 	= $objConexion->obtenerElemento($RSPedido,0,"FE_FechaPedido");	
		$_SESSION['AL_AutorizoCedula'] 	= $objConexion->obtenerElemento($RSPedido,0,"AL_AutorizoCedula");			
		if ($_SESSION['AL_AutorizoCedula']!=''){
			$_SESSION['AL_AutorizoCedula'] 	= number_format($objConexion->obtenerElemento($RSPedido,0,"AL_AutorizoCedula"),0,'','.');			
		}
		$_SESSION['AL_AutorizoNombre'] 	= $objConexion->obtenerElemento($RSPedido,0,"AL_AutorizoNombre");	
	}
	
	$RSPedidoDetalle 	= $objPedidoDetalle->listarPedido($objConexion,$NU_IdPedido);
	$cantPedidoDetalle 	= $objConexion->cantidadRegistros($RSPedidoDetalle);	

	///// CONVIERTE FECHA 1980-07-04 A 04/07/1980 (FORMATO ESPANOL)
	function setFechaNOSQL($FE_FechaNac)
	{
		$partes = explode("-", $FE_FechaNac);
		$FE_FechaNac = $partes[2].'/'.$partes[1].'/'.$partes[0];
		return $FE_FechaNac;
	}
	///////////// CONVERTIR DECIMALES A ESPANOL ///////////
	function setDecimalEsp($numero){
		$numero = str_replace(".", ",", $numero);
		return $numero;
	}
?>
<?php
//////////////////////[ CONVERSION A PDF ]///////////////////////////////

class PDF extends FPDF{
	function Header(){
		$this->Image('../../images/head.jpg',10,10,193,0);
		$this->Ln(10);
		$this->SetFillColor(232,232,232);	
		$this->Cell(0,0,'',1,0,'C');
		$this->Image('../../images/logo.jpg',10,24,80,0);
		$this->SetLeftMargin(95);
		$this->Ln(6);								
		$this->SetFont('Arial','',10);
		$this->Cell(0,0,'MERCADO NRO.: DGRH-GBS-M0'.$_SESSION['NU_IdMercado'],0,0,'L');
		$this->Ln(5);
		$this->Cell(0,0,'ORDEN DE COMPRA NRO.: '.$_SESSION['AF_CodPedido'],0,0,'L');		
		$this->Ln(5);
		$this->Cell(0,0,'FECHA DEL PEDIDO: '.setFechaNOSQL($_SESSION['FE_FechaPedido']),0,0,'L');
		$this->Ln(5);
		$this->Cell(0,0,'EMPRESA: '.utf8_decode($_SESSION['AF_RazonSocial']),0,0,'L');
		$this->Ln(3);
		$this->MultiCell(0,5,utf8_decode('UBICACIÓN: '.$_SESSION['AL_NombreSede'].', '.$_SESSION['AL_NombreGerencia']),0,'L',0);
		$this->Ln(3);
		$this->Cell(0,0,'NOMBRE Y APELLIDO: '.utf8_decode($_SESSION['AL_Nombre'].' '.$_SESSION['AL_Apellido']),0,0,'L');
		$this->Ln(5);
		$this->Cell(0,0,utf8_decode('CÉDULA DE IDENTIDAD: ').$_SESSION['cedula'],0,0,'L');
		$this->SetLeftMargin(10);				
		$this->Ln(5);
		$this->Cell(0,0,'',1,0,'C');
		$this->Ln(7);								
		$this->SetFont('Arial','B',15);
		$this->Cell(0,0,'ORDEN DE COMPRA - MERCADO VIRTUAL',0,0,'C');		
		$this->Ln(7);		
		$this->Cell(0,0,'',1,0,'C');
		$this->Cell(70);
		$this->Ln(5);
	}
	function Footer()	{
		$this->SetY(-30);
		$this->SetFont('Arial','B',9);
		$this->MultiCell(0,7,utf8_decode('NOTA: Declaro estar de acuerdo que sea descontado de mi próxima quincena, el monto total a pagar de BsF. ').number_format($_SESSION['total_pedido'],2,',','.').'.',1,'C',1);
		$this->Ln(5);
		$this->SetFont('Arial','B',8);
		$this->Cell(0,0,utf8_decode('Sistema elaborado por la Oficina de Asuntos Institucionales e Internacionales de VENALCASA, S.A. G-20008504-5'),0,0,'C');
		$this->Ln(5);
		$this->Cell(0,0,utf8_decode('Este sistema fue desarrollado cumpliendo los lineamientos del Decreto N° 3.390.'),0,0,'C');		
		$this->Ln(5);		
		$this->SetFont('Arial','I',8);
//		$this->Cell(0,0,'Página '.$this->PageNo(),0,0,'C');
		$this->Cell(0,0,utf8_decode('Página Única'),0,0,'C');
		$this->Image('../../images/footer.jpg',10,274,190,1);
						
	}
}

//Creacin del objeto de la clase heredada

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetFillColor(232,232,232);		
$pdf->Ln(1);
$pdf->SetFont('Arial','B',13);
//ESPACIO 100% DE LA TABLA = 190 EN VERTICAL////////////////////////

$pdf->Cell(12,7,'Nro',1,0,'C',1);
$pdf->Cell(83,7,'Productos',1,0,'C',1);
$pdf->Cell(25,7,'Cantidad',1,0,'C',1);
$pdf->Cell(35,7,'Precio Unitario',1,0,'C',1);
$pdf->Cell(35,7,'Precio Total',1,0,'C',1);	
//SELECT PD.*, P.AF_NombreProducto, P.NU_Contenido, M.AL_Medida
$pdf->Ln(7);	
$pdf->SetFont('Arial','',10);

$color=0;
$total_productos 	= 0;
$total_pedido 		= 0;

for($i=0;$i<$cantPedidoDetalle;$i++){
	$AF_NombreProducto 	= $objConexion->obtenerElemento($RSPedidoDetalle,$i,"AF_NombreProducto");
	$NU_Contenido 		= $objConexion->obtenerElemento($RSPedidoDetalle,$i,"NU_Contenido");
	$AL_Medida 			= $objConexion->obtenerElemento($RSPedidoDetalle,$i,"AL_Medida");
	$NU_Cantidad 		= $objConexion->obtenerElemento($RSPedidoDetalle,$i,"NU_Cantidad");
	$BS_PrecioUnitario 	= $objConexion->obtenerElemento($RSPedidoDetalle,$i,"BS_PrecioUnitario");
	$BS_PrecioTotal		= $NU_Cantidad * $BS_PrecioUnitario;
	
	$pdf->SetFillColor(232,232,232);		
	$pdf->Cell(12,7,$i+1,1,0,'C',1);
	if($color==1){
		$pdf->SetFillColor(248,248,248);			
		$color=0;
	}else{
		$pdf->SetFillColor(255,255,255);					
		$color=1;	
	}
	$pdf->Cell(83,7,ucwords(strtolower(utf8_decode($AF_NombreProducto.' ('.setDecimalEsp($NU_Contenido).' '.$AL_Medida.')'))),1,0,'L',1);
	$pdf->Cell(25,7,$NU_Cantidad,1,0,'C',1);
	$pdf->Cell(35,7,number_format($BS_PrecioUnitario,2,',','.').' BsF.',1,0,'R',1);	
	$pdf->Cell(35,7,number_format($BS_PrecioTotal,2,',','.').' BsF.',1,0,'R',1);
	$pdf->Ln(7);
	
	$total_productos 	= $total_productos + $NU_Cantidad;
	$total_pedido 		= $total_pedido + $BS_PrecioTotal;
}
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(232,232,232);		
$pdf->Cell(95,7,'Total Productos:',0,0,'R');
$pdf->Cell(25,7,$total_productos,1,0,'C',1);
$pdf->Cell(35,7,'Monto Total',0,0,'R');
$pdf->Cell(35,7,number_format($total_pedido,2,',','.').' BsF.',1,0,'R',1);

$_SESSION['total_pedido'] = $total_pedido;

$pdf->SetLeftMargin(30);
$pdf->Ln(10);
$pdf->Cell(0,10,'______________________',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(0,10,'   Firma del Beneficiario',0,0,'L');
$pdf->Ln(5);
$pdf->SetLeftMargin(10);
$pdf->Ln(5);
if ($_SESSION['AL_AutorizoCedula']!='' and $_SESSION['AL_AutorizoNombre']!=''){
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(0,5,'Yo, '.utf8_decode(strtoupper($_SESSION['AL_Nombre'].' '.$_SESSION['AL_Apellido']).', portador@ de la Cédula de Identidad N° '.$_SESSION['cedula'].', autorizo a '.strtoupper($_SESSION['AL_AutorizoNombre']).' portador@ de la Cédula de Identidad N° '.$_SESSION['AL_AutorizoCedula'].', a efectuar el retiro del Mercado que aqui se detalla.'),0,'J',0);
	$pdf->Ln(5);
}
$pdf->Ln(3);
$pdf->Output();
?>