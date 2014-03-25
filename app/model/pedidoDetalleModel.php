<?php 
class PedidoDetalle{
	private $NU_IdPedidoDetalle;
	private $producto_NU_IdProducto;	
	private $pedido_NU_IdPedido;
	private $NU_Cantidad;	
	private $BS_PrecioUnitario;
	private $NU_Max;			

	function insertar($objConexion,$producto_NU_IdProducto,$pedido_NU_IdPedido,$NU_Cantidad,$BS_PrecioUnitario,$NU_Max){
		$this->producto_NU_IdProducto	= $producto_NU_IdProducto;
		$this->pedido_NU_IdPedido		= $pedido_NU_IdPedido;				
		$this->NU_Cantidad				= $NU_Cantidad;
		$this->BS_PrecioUnitario		= $BS_PrecioUnitario;
		$this->NU_Max					= $NU_Max;		

		$query="INSERT INTO pedido_detalle (producto_NU_IdProducto,pedido_NU_IdPedido,NU_Cantidad,BS_PrecioUnitario,NU_Max)
				VALUES
				(".$this->producto_NU_IdProducto.",".$this->pedido_NU_IdPedido.",".$this->NU_Cantidad.",".$this->BS_PrecioUnitario.",".$this->NU_Max.")";

		$resultado=$objConexion->ejecutar($query);
		return true;
	}
	
	function listarPedido($objConexion,$NU_IdPedido){
		$this->pedido_NU_IdPedido = $NU_IdPedido;
		$query="SELECT PD.*, P.AF_NombreProducto, P.NU_Contenido, M.AL_Medida
				FROM pedido_detalle AS PD
				LEFT JOIN producto AS P ON (P.NU_IdProducto=PD.producto_NU_IdProducto)
				LEFT JOIN medida AS M ON (M.NU_IdMedida=P.medida_NU_IdMedida)
				WHERE pedido_NU_IdPedido=".$this->pedido_NU_IdPedido;

		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}		

	function verificarDetalle($objConexion,$pedido_NU_IdPedido,$producto_NU_IdProducto){
		$this->pedido_NU_IdPedido 		= $pedido_NU_IdPedido;
		$this->producto_NU_IdProducto 	= $producto_NU_IdProducto;		
		$query="SELECT *
				FROM pedido_detalle
				WHERE pedido_NU_IdPedido=".$this->pedido_NU_IdPedido." AND producto_NU_IdProducto=".$this->producto_NU_IdProducto;
		$resultado=$objConexion->ejecutar($query);
		$cantidad = $objConexion->cantidadRegistros($resultado);

		return $cantidad;
	}
	
	function buscarProducPedido($objConexion,$pedido_NU_IdPedido,$producto_NU_IdProducto){
		$this->pedido_NU_IdPedido	 	= $pedido_NU_IdPedido;
		$this->producto_NU_IdProducto 	= $producto_NU_IdProducto;
		$query="SELECT PD.*
				FROM pedido_detalle AS PD
				WHERE pedido_NU_IdPedido=".$this->pedido_NU_IdPedido." and producto_NU_IdProducto=".$this->producto_NU_IdProducto;

		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
	
	function update($objConexion,$NU_IdPedidoDetalle,$NU_Cantidad){
		$this->NU_IdPedidoDetalle	= $NU_IdPedidoDetalle;
		$this->NU_Cantidad			= $NU_Cantidad;				

		$query="UPDATE pedido_detalle 
				SET NU_Cantidad =".$this->NU_Cantidad."
				WHERE NU_IdPedidoDetalle=".$this->NU_IdPedidoDetalle;

		$resultado=$objConexion->ejecutar($query);
		return true;
	}	
	
	function delete($objConexion,$NU_IdPedidoDetalle){
		$this->NU_IdPedidoDetalle	= $NU_IdPedidoDetalle;

		$query="DELETE FROM pedido_detalle
				WHERE NU_IdPedidoDetalle=".$this->NU_IdPedidoDetalle;

		$resultado=$objConexion->ejecutar($query);
		return true;
	}		
}
?>