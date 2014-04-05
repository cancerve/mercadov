<?php 
	require_once('../../../controller/sessionController.php');
	require('../../../includes/pdf/fpdf.php'); 
	require_once('../../../model/pedidoModel.php');

	$objPedido = new Pedido();
	
	$NU_IdMercado = $_GET['NU_IdMercado'];
	
	$RS 		= $objPedido->buscarDescuentoN($objConexion,$NU_IdMercado);
	$cantRS 	= $objConexion->cantidadRegistros($RS);
?>
<?php

		$_SESSION['fecha'] = $objConexion->obtenerElemento($RS,0,"FE_FechaMercado");
		
		$FE_FechaMercado = explode("-",$_SESSION['fecha']);
		$mes1 = $FE_FechaMercado[1];
		
		$meses = array('01' => 'Enero','02' => 'Febrero','03' => 'Marzo','04' => 'Abril','05' => 'Mayo','06' => 'Junio','07' => 'Julio','08' => 'Agosto','09' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre');
		
		$_SESSION['$mes'] = $meses[$mes1];
		$_SESSION['$anio'] = $FE_FechaMercado[0];
			
		$_SESSION['mercado_NU_IdMercado'] = $NU_IdMercado;

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
		$this->Image('../../../images/head.jpg',10,10,280,0);
		$this->Ln(15);
		$this->SetFillColor(232,232,232);	
		$this->Cell(0,0,'',1,0,'C');
		$this->Image('../../../images/logo.jpg',20,28,53,0);
		$this->SetLeftMargin(65);
		$this->Ln(4);
		$this->SetFont('Arial','',8);
		$this->Ln(10);
		$this->SetFont('Arial','B',14);
		$this->Cell(0,0,'CONSOLIDADO DE DESCUENTO MERCADO OBRERO',0,0,'C');
		$this->Ln(5);
		$this->Cell(0,0,'DEL MES DE '.strtoupper($_SESSION['$mes']).' '.$_SESSION['$anio'],0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',10);
		$this->Cell(0,0,'Dirección General de Recursos Humanos',0,0,'C');
		$this->Ln(5);
		$this->Cell(0,0,setFechaNOSQL($_SESSION['fecha']),0,0,'C');
		$this->SetLeftMargin(10);				
		$this->Ln(6);
		$this->Cell(0,0,'',1,0,'C');
		$this->SetFont('Arial','B',10);
		$this->Ln(6);
		$this->Cell(0,0,'Correspondiente al Mercado Nro.: DGRH-GBS-M0'.$_SESSION['mercado_NU_IdMercado'],0,0,'C');		
		$this->Ln(5);		
		$this->Cell(0,0,'',1,0,'C');
		$this->SetFont('Arial','B',10);
		$this->Ln(5);
		$this->SetLeftMargin(10);
		$this->SetFillColor(232,232,232);		
		$this->Ln(1);
		
		$this->SetFont('Arial','B',10);
		//ESPACIO 100% DE LA TABLA = 190 EN VERTICAL////////////////////////
		//ESPACIO 100% DE LA TABLA = 277 EN VERTICAL////////////////////////
		$this->Cell(8,7,'Nro',1,0,'C',1);
		$this->Cell(40,7,'Orden',1,0,'C',1);
		$this->Cell(25,7,'Cedula',1,0,'C',1);
		$this->Cell(99,7,'Nombre y Apellido',1,0,'C',1);
		$this->Cell(25,7,'Productos',1,0,'C',1);	
		$this->Cell(25,7,'Monto Bruto',1,0,'C',1);	
		$this->Cell(25,7,'Nota Credito',1,0,'C',1);	
		$this->Cell(30,7,'Monto Descontar',1,0,'C',1);
		$this->Ln(7);			
	}
	function Footer()	{
		$this->SetY(-20);
		$this->SetFont('Arial','B',9);
		$this->Ln(5);
		$this->SetFont('Arial','B',8);
		$this->Cell(0,0,'Sistema elaborado por la Oficina de Asuntos Institucionales e Internacionales de VENALCASA, S.A. G-20008504-5',0,0,'C');
		$this->Ln(5);
		$this->Cell(0,0,'Este sistema fue desarrollado cumpliendo los lineamientos del Decreto N° 3.390.',0,0,'C');		
		$this->Ln(5);		
		$this->SetFont('Arial','I',8);
		$this->Cell(0,0,'Página '.$this->PageNo().' de {nb}',0,0,'C');
//		$this->Cell(0,0,'Página Única',0,0,'C');
		$this->Image('../../../images/footer.jpg',10,191,277,1);
						
	}
}

//Creacin del objeto de la clase heredada

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L');

$color=0;
$contador =0;

for($i=0;$i<$cantRS;$i++){
	
	if ($contador==15){
		$pdf->AddPage('L');
		$contador=0;
	}	
	
	$contador++;
	$pdf->SetFont('Arial','',10);
	$NU_idPedido 		= $objConexion->obtenerElemento($RS,$i,"NU_idPedido");
	$NU_Cedula 			= $objConexion->obtenerElemento($RS,$i,"NU_Cedula");
	$AL_NombreApellido 	= $objConexion->obtenerElemento($RS,$i,"AL_Nombre").' '.$objConexion->obtenerElemento($RS,$i,"AL_Apellido");
	$CantProducto 		= $objConexion->obtenerElemento($RS,$i,"CantProducto");
	$MontoBruto 		= $objConexion->obtenerElemento($RS,$i,"MontoBruto");
	$BS_NotaCredito 	= $objConexion->obtenerElemento($RS,$i,"BS_NotaCredito");
	$MontoDescontar		= $MontoBruto - $BS_NotaCredito;
	/*
	$totalKg 			= $NU_Max*$Solicitantes;
	$totalBs			= $totalKg*$BS_PrecioUnitario;
*/
	$pdf->SetFillColor(232,232,232);		
	$pdf->Cell(8,7,$i+1,1,0,'C',1);
	if($color==1){
		$pdf->SetFillColor(248,248,248);			
		$color=0;
	}else{
		$pdf->SetFillColor(255,255,255);					
		$color=1;	
	}
	$pdf->Cell(40,7,'DGRH-GBS-M0'.$NU_idPedido,1,0,'C',1);
	$pdf->Cell(25,7,number_format($NU_Cedula,0,'','.'),1,0,'R',1);
	$pdf->Cell(99,7,ucwords(strtolower(utf8_decode($AL_NombreApellido))),1,0,'L',1);	
	$pdf->Cell(25,7,$CantProducto,1,0,'C',1);
	$pdf->Cell(25,7,number_format($MontoBruto,2,',','.').' BsF.',1,0,'R',1);	
	$pdf->Cell(25,7,number_format($BS_NotaCredito,2,',','.').' BsF.',1,0,'R',1);
	$pdf->Cell(30,7,number_format($MontoDescontar,2,',','.').' BsF.',1,0,'R',1);	
	$pdf->Ln(7);
	/*
	$total_NU_Max 		+= $NU_Max;
	$total_Solicitantes += $Solicitantes ;
	$total_totalBs 		+= $totalBs;
	*/
}
/*
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(93,7,'TOTAL PRODUCTOS Y MONTO TOTAL DE LA COMPRA',0,0,'R',0);
$pdf->Cell(25,7,$total_NU_Max,1,0,'R',1);
$pdf->Cell(25,7,$total_Solicitantes,1,0,'R',1);	
$pdf->Cell(20,7,$total_NU_Max*$total_Solicitantes,1,0,'R',1);	
$pdf->Cell(27,7,setDecimalEsp($total_totalBs).' BsF.',1,0,'R',1);
$pdf->Ln(5);
$pdf->Ln(30);
$pdf->Cell(0,10,'LDA. YURISMAR MEDINA',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(0,10,'DIRECTORA GENERAL DE RECURSOS HUMANOS',0,0,'C');
*/
$pdf->SetLeftMargin(10);
$pdf->Ln(5);


$pdf->Ln(3);
$pdf->Output();
?>