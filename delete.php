<?php 
	require_once("app/includes/constantes.php");
	require_once("app/includes/conexion.class.php");
	require_once('app/model/pedidoDetalleModel.php');
	
	$objConexion= new conexion(SERVER,USER,PASS,DB);
	$objPedidoDetalle = new PedidoDetalle();
	
	$NU_IdMercado = $_GET['NU_IdMercado'];
	
	$RSPedido 	= $objPedidoDetalle->listar2($objConexion,$NU_IdMercado);
	$cantRS		= $objConexion->cantidadRegistros($RSPedido);
?>
<html>
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<table width="300" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>NU_IdPedido</td>  
    <td>producto_NU_IdProducto</td>

  </tr>
<?php
	for($i=0;$i<$cantRS;$i++){
		$pedido_NU_IdPedido		= $objConexion->obtenerElemento($RSPedido,$i,"pedido_NU_IdPedido");						
		$producto_NU_IdProducto	= $objConexion->obtenerElemento($RSPedido,$i,"producto_NU_IdProducto");						
		$NU_IdPedidoDetalle		= $objConexion->obtenerElemento($RSPedido,$i,"NU_IdPedidoDetalle");						
?>
  <tr>
    <td>&nbsp;<?php echo $pedido_NU_IdPedido; ?></td>
    <td>&nbsp;<?php echo $producto_NU_IdProducto; ?></td>

  </tr>
<?php
	$cantVerificar2 	= $objPedidoDetalle->verificarDetalle($objConexion,$pedido_NU_IdPedido,$producto_NU_IdProducto);
	if ($cantVerificar2>1){
		//$objPedidoDetalle->delete($objConexion,$NU_IdPedidoDetalle);
	}

?>  
<?php } ?>  
</table>
</body>
</html>