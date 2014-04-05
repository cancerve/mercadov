<?php 
	require_once("app/includes/constantes.php");
	require_once("app/includes/conexion.class.php");
	require_once('app/model/pedidoDetalleModel.php');
	require_once('app/model/usuarioModel.php');	
	
	$objConexion= new conexion(SERVER,USER,PASS,DB);
	$objPedidoDetalle = new PedidoDetalle();
	$objUsuario = new Usuario();

	$RSPedido 	= $objPedidoDetalle->listar($objConexion);
	$cantRS		= $objConexion->cantidadRegistros($RSPedido);
?>
<html>
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>NU_IdPedido</td>  
    <td>usuario_NU_IdUsuario</td>
    <td>mercado_NU_IdMercado</td>
    <td>NU_IdPedidoDetalle</td>
    <td>gerencia_NU_IdGerencia</td>
    <td>sede_NU_IdSede</td>   
  </tr>
<?php
	for($i=0;$i<$cantRS;$i++){
		$NU_IdUsuario			= $objConexion->obtenerElemento($RSPedido,$i,"NU_IdUsuario");						
		$SEDE					= $objConexion->obtenerElemento($RSPedido,$i,"SEDE");						
		$GERENCIA				= $objConexion->obtenerElemento($RSPedido,$i,"GERENCIA");
		$NU_IdPedidoDetalle		= $objConexion->obtenerElemento($RSPedido,$i,"NU_IdPedidoDetalle");						
		$sede_NU_IdSede			= $objConexion->obtenerElemento($RSPedido,$i,"sede_NU_IdSede");						
		$gerencia_NU_IdGerencia	= $objConexion->obtenerElemento($RSPedido,$i,"gerencia_NU_IdGerencia");	
?>
  <tr>
    <td>&nbsp;<?php echo $NU_IdUsuario; ?></td>
    <td>&nbsp;<?php echo $SEDE; ?></td>
    <td>&nbsp;<?php echo $GERENCIA; ?></td>
    <td>&nbsp;<?php echo $NU_IdPedidoDetalle; ?></td>
    <td>&nbsp;<?php echo $sede_NU_IdSede; ?></td>
    <td>&nbsp;<?php echo $gerencia_NU_IdGerencia; ?></td>
  </tr>
<?php
/*
	if ($sede_NU_IdSede != 0){
		
	}else{
		$objPedidoDetalle->update2($objConexion,$NU_IdPedidoDetalle,$SEDE,$GERENCIA);
	}
*/	
?>  
<?php } ?>  
</table>
</body>
</html>