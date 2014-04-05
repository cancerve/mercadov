<?php 
	require_once("app/includes/constantes.php");
	require_once("app/includes/conexion.class.php");
	require_once('app/model/pedidoDetalleModel.php');
	require_once('app/model/mercadoProductoModel.php');	
	
	$objConexion		= new conexion(SERVER,USER,PASS,DB);
	$objPedidoDetalle 	= new PedidoDetalle();
	$objMercadoProducto = new MercadoProducto();

	$NU_IdMercado = $_GET['NU_IdMercado'];

	$RSPedido 	= $objPedidoDetalle->listar($objConexion,$NU_IdMercado);
	$cantRS		= $objConexion->cantidadRegistros($RSPedido);
?>
<html>
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<table width="100%" border="1" cellspacing="2" cellpadding="2">
  <tr>
    <td>pedido_NU_IdPedido</td>  
    <td>producto_NU_IdProducto</td>
    <td>CANT</td> 
    <td>PRODUCTOS</td> 
  </tr>
<?php
	for($i=0;$i<$cantRS;$i++){
		$pedido_NU_IdPedido		= $objConexion->obtenerElemento($RSPedido,$i,"pedido_NU_IdPedido");						
		$producto_NU_IdProducto	= $objConexion->obtenerElemento($RSPedido,$i,"producto_NU_IdProducto");						
		$CANT					= $objConexion->obtenerElemento($RSPedido,$i,"CANT");
?>
  <tr>
    <td valign="top">&nbsp;<?php echo $pedido_NU_IdPedido; ?></td>
    <td valign="top">&nbsp;<?php echo $producto_NU_IdProducto; ?></td>
    <td valign="top">&nbsp;<?php echo $CANT; ?></td>
    <td valign="top"><table width="100" border="1" cellspacing="0" cellpadding="2">
        <tr><td>NU_IdProducto</td><td>NombreProducto</td><td>cantidad</td><td>BS_PrecioUnitario</td><td>NU_Max</td></tr>
		<?php 
			$RSMercadoProducto 	= $objMercadoProducto->listarMercadoProducto($objConexion,$NU_IdMercado);
			$cantMercadoProducto= $objConexion->cantidadRegistros($RSMercadoProducto);
			for($j=0; $j<$cantMercadoProducto; $j++){
				$AF_NombreProducto	= $objConexion->obtenerElemento($RSMercadoProducto,$j,"AF_NombreProducto");						
				$NU_IdProducto		= $objConexion->obtenerElemento($RSMercadoProducto,$j,"NU_IdProducto");	
				$BS_PrecioUnitario	= $objConexion->obtenerElemento($RSMercadoProducto,$j,"BS_PrecioUnitario");						
				$NU_Max				= $objConexion->obtenerElemento($RSMercadoProducto,$j,"NU_Max");						
				
				$RSProducto 	= $objPedidoDetalle->buscarProducPedido($objConexion,$pedido_NU_IdPedido,$NU_IdProducto);
				$cantRSProducto	= $objConexion->cantidadRegistros($RSProducto);
				
				if ($cantRSProducto>0){
					$cantidad = $objConexion->obtenerElemento($RSProducto,0,"NU_Cantidad");						
				}else{
					$cantidad ='';
					//INSERTAR REGISTRO
					$NU_Cantidad = 0;
					$objPedidoDetalle->insertar($objConexion,$NU_IdProducto,$pedido_NU_IdPedido,$NU_Cantidad,$BS_PrecioUnitario,$NU_Max);
				}
				echo '<tr><td>'.$NU_IdProducto.'</td><td>'.$AF_NombreProducto.'</td><td>'.$cantidad.'</td><td>'.$BS_PrecioUnitario.'</td><td>'.$NU_Max.'</td></tr>';
			}
		?>
      </table>
    </td>
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