<?php 
	require_once("app/includes/constantes.php");
	require_once("app/includes/conexion.class.php");
	require_once('app/model/pedidoModel.php');
	
	$objConexion= new conexion(SERVER,USER,PASS,DB);
	$objPedido = new Pedido();
	
	$RSPedido 	= $objPedido->listarRep($objConexion);
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
    <td>usuario_NU_IdUsuario</td>
    <td>cantidad</td>
  </tr>
<?php
	for($i=0;$i<$cantRS;$i++){
		$NU_IdPedido			= $objConexion->obtenerElemento($RSPedido,$i,"NU_IdPedido");						
		$usuario_NU_IdUsuario	= $objConexion->obtenerElemento($RSPedido,$i,"usuario_NU_IdUsuario");						
		$cantidad				= $objConexion->obtenerElemento($RSPedido,$i,"cantidad");						
?>
  <tr>
    <td>&nbsp;<?php echo $NU_IdPedido; ?></td>
    <td>&nbsp;<?php echo $usuario_NU_IdUsuario; ?></td>
    <td>&nbsp;<?php echo $cantidad; ?></td>
  </tr>
<?php
	if ($cantidad>1){
		$objPedido->delete($objConexion,$usuario_NU_IdUsuario,$NU_IdPedido);
	}

?>  
<?php } ?>  
</table>
</body>
</html>