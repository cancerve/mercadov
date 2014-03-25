<?php
	require_once('../controller/sessionController.php'); 
	require_once('../model/pedidoModel.php');
	require_once('../model/pedidoDetalleModel.php');	
	require_once('../model/usuarioModel.php'); 

	$objPedido 			= new Pedido();
	$objUsuario 		= new Usuario();	
	$objPedidoDetalle 	= new PedidoDetalle();		
?>
<?php
////////////////////// CASO DE USO REALIZAR PEDIDO ///////
	if ($_POST['origen']=='pedido')
	{
		$RSUsuario 		= $objUsuario->buscarUsuario($objConexion,$_SESSION['NU_Cedula']);
		$cantRSUsuario 	= $objConexion->cantidadRegistros($RSUsuario);
		if($cantRSUsuario>0){
			$usuario_NU_IdUsuario = $objConexion->obtenerElemento($RSUsuario,0,'NU_IdUsuario');
			$NU_IdEmpresa		  = $objConexion->obtenerElemento($RSUsuario,0,'empresa_NU_IdEmpresa');
			$NU_IdUsuario		  = $objConexion->obtenerElemento($RSUsuario,0,'NU_IdUsuario');
		}

		$mercado_NU_IdMercado	= $_POST["NU_IdMercado"];
		$FE_FechaPedido			= date("Y-m-d");
		$NU_AutorizoCedula		= $_POST['AL_AutorizoCedula'];
		$NU_AutorizoNombre		= $_POST['AL_AutorizoNombre'];

		//////////////// VERIFICAR SI YA EXISTE ESTE INSERT PARA EVITAR DUPLICAR PEDIDO ///////////////////
		$RSVerificar 	= $objPedido->verificarPedido($objConexion,$usuario_NU_IdUsuario,$mercado_NU_IdMercado);
		$cantVerificar 	= $objConexion->cantidadRegistros($RSVerificar);
		///////////////////////////////////////////////////////////////
		if ($cantVerificar==0){
			$objPedido->insertar($objConexion,$usuario_NU_IdUsuario,$mercado_NU_IdMercado,$NU_AutorizoCedula,$NU_AutorizoNombre,$FE_FechaPedido);
		}
		
		$AF_CodPedido = '0'.$NU_IdEmpresa.'-0'.$NU_IdUsuario.'-';

		//////////////// BUSCAR PEDIDO CORRESPONDIENTE A ESTE MERCADO ///////////////////
		$RSVerificar 	= $objPedido->verificarPedido($objConexion,$usuario_NU_IdUsuario,$mercado_NU_IdMercado);
		$cantVerificar 	= $objConexion->cantidadRegistros($RSVerificar);
		///////////////////////////////////////////////////////////////
//		$pedido_NU_IdPedido = $objPedido->obtenerUltimo($objConexion);
		$pedido_NU_IdPedido = $objConexion->obtenerElemento($RSVerificar,0,'NU_IdPedido');

		$cantDigPedido = 6-(strlen($pedido_NU_IdPedido));

		for ($b=0;$b<$cantDigPedido;$b++){
			$AF_CodPedido .= '0';
		}

		$AF_CodPedido .= $pedido_NU_IdPedido;

		$objPedido->crearCodigo($objConexion,$pedido_NU_IdPedido,$AF_CodPedido);

		for($k=0;$k<=$_POST['cantProducto'];$k++){
			if ($_POST["NU_Cantidad".$k]!=''){
				$producto_NU_IdProducto	= $_POST['NU_IdProducto'.$k];
				$pedido_NU_IdPedido 	= $pedido_NU_IdPedido;
				$NU_Cantidad 			= $_POST["NU_Cantidad".$k];
				$BS_PrecioUnitario		= $_POST["BS_PrecioUnitario".$k];
				$NU_Max					= $_POST["NU_Max".$k];

				if ($NU_Cantidad!=''){
					//////////////// VERIFICAR SI YA EXISTE ESTE INSERT PARA EVITAR DUPLICAR PEDIDO DETALLES ///////////////////
					$RSVerificar2 	= $objPedidoDetalle->verificarDetalle($objConexion,$pedido_NU_IdPedido,$producto_NU_IdProducto);
					$cantVerificar2	= $objConexion->cantidadRegistros($RSVerificar2);
					///////////////////////////////////////////////////////////////
					if ($cantVerificar2==0){
						$objPedidoDetalle->insertar($objConexion,$producto_NU_IdProducto,$pedido_NU_IdPedido,$NU_Cantidad,$BS_PrecioUnitario,$NU_Max);
					}
				}
			}
		}

		header("Location: ../views/pedido/orden_compra.php?pedido_NU_IdPedido=$pedido_NU_IdPedido");
	}
	
////////////////////// CASO DE USO EDITAR PEDIDO ///////
	if ($_POST['origen']=='pedido_edit')
	{
		$NU_IdPedido		= $_POST['NU_IdPedido'];
		$NU_AutorizoCedula	= $_POST['AL_AutorizoCedula'];
		$NU_AutorizoNombre	= $_POST['AL_AutorizoNombre'];
		$FE_FechaPedido		= date("Y-m-d");
	
		$objPedido->update($objConexion,$NU_IdPedido,$NU_AutorizoCedula,$NU_AutorizoNombre,$FE_FechaPedido);
		
		for($k=0;$k<=$_POST['cantProducto'];$k++){
//			if (isset($_POST["NU_Cantidad".$k])){
			if ($_POST["NU_Cantidad".$k]!=''){	
				$producto_NU_IdProducto	= $_POST['NU_IdProducto'.$k];
				$pedido_NU_IdPedido 	= $NU_IdPedido;
				$NU_Cantidad 			= $_POST["NU_Cantidad".$k];
				$BS_PrecioUnitario		= $_POST["BS_PrecioUnitario".$k];
				$NU_Max					= $_POST["NU_Max".$k];
				$NU_IdPedidoDetalle		= $_POST['NU_IdPedidoDetalle'.$k];

				if ($NU_Cantidad!=''){
					if ($NU_IdPedidoDetalle==''){
						$objPedidoDetalle->insertar($objConexion,$producto_NU_IdProducto,$pedido_NU_IdPedido,$NU_Cantidad,$BS_PrecioUnitario,$NU_Max);
					}else{
						$objPedidoDetalle->update($objConexion,$NU_IdPedidoDetalle,$NU_Cantidad);	
					}
				}
			}else{
				$NU_IdPedidoDetalle		= $_POST['NU_IdPedidoDetalle'.$k];
				if ($NU_IdPedidoDetalle!=''){
					$objPedidoDetalle->delete($objConexion,$NU_IdPedidoDetalle);
				}
			}
		}

		header("Location: ../views/pedido/orden_compra.php?pedido_NU_IdPedido=$NU_IdPedido");
	}	
	
?>