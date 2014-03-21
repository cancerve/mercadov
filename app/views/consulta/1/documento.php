<?php 
	require_once('../../../controller/sessionController.php');
	require('../../../includes/pdf/fpdf.php'); 
	require_once('../../../model/solicitudInventarioModel.php');

	$objsolicitudInventario = new solicitudInventario();
	
	$NU_IdSolicitudInventario = $_GET['NU_IdSolicitudInventario'];
	
	$RS 		= $objsolicitudInventario->listarSolicitudInventario($objConexion,$NU_IdSolicitudInventario);
	$cantRS 	= $objConexion->cantidadRegistros($RS);
?>
<?php
	$RSSolicitud	= $objsolicitudInventario->buscarSolicituInv($objConexion,$NU_IdSolicitudInventario);
	$cantRSSolicitud= $objConexion->cantidadRegistros($RSSolicitud);
	
	if ($cantRSSolicitud>0){
		$_SESSION['NU_IdSolicitudInventario'] = $objConexion->obtenerElemento($RSSolicitud,0,"NU_IdSolicitudInventario");
		$FE_Registro = explode(" ",$objConexion->obtenerElemento($RSSolicitud,0,"FE_Registro"));
		$_SESSION['fecha'] = $FE_Registro[0];
		$mes = explode("-",$_SESSION['fecha']);
		$mes1 = $mes[1];
		
		$meses = array('01' => 'Enero','02' => 'Febrero','03' => 'Marzo','04' => 'Abril','05' => 'Mayo','06' => 'Junio','07' => 'Julio','08' => 'Agosto','09' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre');
		$_SESSION['$mes'] = $meses[$mes1];
		$_SESSION['$anio'] = $mes[0];
	}

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
		$this->Image('../../../images/head.jpg',10,10,193,0);
		$this->Ln(10);
		$this->SetFillColor(232,232,232);	
		$this->Cell(0,0,'',1,0,'C');
		$this->Image('../../../images/logo.jpg',20,23,53,0);
		$this->SetLeftMargin(65);
		$this->Ln(4);
		$this->SetFont('Arial','',8);
		$this->Cell(0,0,'Solicitud de Inventario Nro.: 0'.$_SESSION['NU_IdSolicitudInventario'],0,0,'R');		
		$this->Ln(7);
		$this->SetFont('Arial','B',14);
		$this->Cell(0,0,'SOLICITUD DE INVENTARIO A LA',0,0,'C');
		$this->Ln(5);
		$this->Cell(0,0,'VICEPRESIDENCIA DE OPERACIONES',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',10);
		$this->Cell(0,0,'Dirección General de Recursos Humanos',0,0,'C');
		$this->Ln(5);
		$this->Cell(0,0,setFechaNOSQL($_SESSION['fecha']),0,0,'C');
		$this->SetLeftMargin(10);				
		$this->Ln(5);
		$this->Cell(0,0,'',1,0,'C');
		$this->SetFont('Arial','B',15);
		$this->Ln(6);
		$this->Cell(0,0,'ORDEN DE COMPRA MERCADO VENALCASA MES DE '.strtoupper($_SESSION['$mes']).' '.$_SESSION['$anio'],0,0,'C');		
		$this->Ln(5);		
		$this->Cell(0,0,'',1,0,'C');
		$this->Cell(70);
		$this->Ln(5);
	}
	function Footer()	{
		$this->SetY(-25);
		$this->SetFont('Arial','B',9);
		$this->Ln(5);
		$this->SetFont('Arial','B',8);
		$this->Cell(0,0,'Sistema elaborado por la Oficina de Asuntos Institucionales e Internacionales de VENALCASA, S.A. G-20008504-5',0,0,'C');
		$this->Ln(5);
		$this->Cell(0,0,'Este sistema fue desarrollado cumpliendo los lineamientos del Decreto N° 3.390.',0,0,'C');		
		$this->Ln(5);		
		$this->SetFont('Arial','I',8);
//		$this->Cell(0,0,'Página '.$this->PageNo(),0,0,'C');
		$this->Cell(0,0,'Página Única',0,0,'C');
		$this->Image('../../../images/footer.jpg',10,274,190,1);
						
	}
}

//Creacin del objeto de la clase heredada

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetFillColor(232,232,232);		
$pdf->Ln(1);
$pdf->SetFont('Arial','B',10);
//ESPACIO 100% DE LA TABLA = 190 EN VERTICAL////////////////////////
$pdf->Cell(8,7,'Nro',1,0,'C',1);
$pdf->Cell(60,7,'Productos',1,0,'C',1);
$pdf->Cell(25,7,'Precio Unit.',1,0,'C',1);
$pdf->Cell(25,7,'Cant. Max.',1,0,'C',1);
$pdf->Cell(25,7,'Solicitantes',1,0,'C',1);	
$pdf->Cell(20,7,'Total KG',1,0,'C',1);	
$pdf->Cell(27,7,'Total Bs.',1,0,'C',1);	

//SELECT PD.*, P.AF_NombreProducto, P.NU_Contenido, M.AL_Medida
$pdf->Ln(7);	
$pdf->SetFont('Arial','',10);

$color=0;
$total_NU_Max = 0;
$total_Solicitantes = 0;
$total_totalBs = 0;

for($i=0;$i<$cantRS;$i++){
	$AF_NombreProducto 	= $objConexion->obtenerElemento($RS,$i,"AF_NombreProducto");
	$BS_PrecioUnitario 	= $objConexion->obtenerElemento($RS,$i,"BS_PrecioUnitario");
	$NU_Contenido 		= $objConexion->obtenerElemento($RS,$i,"NU_Contenido");
	$AL_Medida 			= $objConexion->obtenerElemento($RS,$i,"AL_Medida");
	$NU_Max 			= $objConexion->obtenerElemento($RS,$i,"NU_Max");
	$Solicitantes 		= $objConexion->obtenerElemento($RS,$i,"Solicitantes");
	$totalKg 			= $NU_Max*$Solicitantes;
	$totalBs			= $totalKg*$BS_PrecioUnitario;
	

	$pdf->SetFillColor(232,232,232);		
	$pdf->Cell(8,7,$i+1,1,0,'C',1);
	if($color==1){
		$pdf->SetFillColor(248,248,248);			
		$color=0;
	}else{
		$pdf->SetFillColor(255,255,255);					
		$color=1;	
	}
	$pdf->Cell(60,7,ucwords(strtolower(utf8_decode($AF_NombreProducto.' ('.setDecimalEsp($NU_Contenido).' '.$AL_Medida.')'))),1,0,'L',1);
	$pdf->Cell(25,7,setDecimalEsp($BS_PrecioUnitario).' BsF.',1,0,'R',1);
	$pdf->Cell(25,7,$NU_Max,1,0,'R',1);	
	$pdf->Cell(25,7,$Solicitantes,1,0,'R',1);
	$pdf->Cell(20,7,$totalKg,1,0,'R',1);	
	$pdf->Cell(27,7,setDecimalEsp($totalBs).' BsF.',1,0,'R',1);
	$pdf->Ln(7);
	
	$total_NU_Max 		+= $NU_Max;
	$total_Solicitantes += $Solicitantes ;
	$total_totalBs 		+= $totalBs;
}
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

$pdf->SetLeftMargin(10);
$pdf->Ln(5);


$pdf->Ln(3);
$pdf->Output();
?>