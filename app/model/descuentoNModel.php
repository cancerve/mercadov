<?php 
class DescuentoN{
	private $NU_IdDescuento;
	private $mercado_NU_IdMercado;	
	private $NU_RealizadoPor;
	private $FE_Registro;

	function insertar($objConexion,$mercado_NU_IdMercado,$NU_RealizadoPor){
		$this->mercado_NU_IdMercado	= $mercado_NU_IdMercado;
		$this->NU_RealizadoPor		= $NU_RealizadoPor;				

		$query="INSERT INTO descuento_nomina (mercado_NU_IdMercado,NU_RealizadoPor)
				VALUES
				(".$this->mercado_NU_IdMercado.",".$this->NU_RealizadoPor.")";

		$resultado=$objConexion->ejecutar($query);
		return true;
	}
	
	function obtenerUltimo($objConexion){
		$query="SELECT MAX(NU_IdDescuento) as id
				FROM descuento_nomina
				ORDER BY NU_IdDescuento DESC";
		$resultado=$objConexion->ejecutar($query);	
		//return $resultado;

		if($objConexion->cantidadRegistros($resultado)>0){
			$this->id=$objConexion->obtenerElemento($resultado,0,'id');
		}
		return $this->id;	
	}
	
	function listarDescuentoN($objConexion,$NU_IdDescuento){
		$this->NU_IdDescuento = $NU_IdDescuento;
		$query="SELECT DN.*, P.NU_idPedido, U.NU_Cedula, U.AL_Nombre, U.AL_Apellido, count(*) AS CantProducto, SUM(PD.NU_Cantidad*PD.BS_PrecioUnitario) AS MontoBruto, P.BS_NotaCredito
				FROM descuento_nomina AS DN
				LEFT JOIN pedido AS P ON (P.mercado_NU_IdMercado=DN.mercado_NU_IdMercado)
				LEFT JOIN usuario AS U ON (U.NU_IdUsuario=usuario_NU_IdUsuario)
				LEFT JOIN pedido_detalle AS PD ON (PD.pedido_NU_IdPedido=P.NU_IdPedido)
				WHERE DN.NU_IdDescuento=".$this->NU_IdDescuento."
				GROUP BY PD.pedido_NU_IdPedido
				ORDER BY U.NU_Cedula ASC";

		$resultado=$objConexion->ejecutar($query);
		return $resultado;	
			
	}
	
	function listarDescuentoN2($objConexion){
		
		$query="SELECT DN.*, M.FE_FechaMercado, SUM(PD.NU_Cantidad*PD.BS_PrecioUnitario) AS MontoBruto, SUM(P.BS_NotaCredito) AS NotaCredito
				FROM descuento_nomina AS DN
                                LEFT JOIN mercado AS M ON (M.NU_IdMercado=DN.mercado_NU_IdMercado)
                                LEFT JOIN pedido AS P ON (P.mercado_NU_IdMercado=DN.mercado_NU_IdMercado)
                                LEFT JOIN pedido_detalle AS PD ON (PD.pedido_NU_IdPedido=P.NU_IdPedido)
				GROUP BY DN.mercado_NU_IdMercado
				ORDER BY DN.NU_IdDescuento DESC";

		$resultado=$objConexion->ejecutar($query);
		return $resultado;	
			
	}		
/*	
	function buscarDescuentoN($objConexion,$NU_IdDescuento){
		$this->NU_IdDescuento=$NU_IdDescuento;
		$query="SELECT SI.*, M.FE_FechaMercado, SUM(PD.NU_Cantidad*PD.BS_PrecioUnitario) AS TotalCompra
				FROM descuento_nomina AS SI
				LEFT JOIN mercado AS M ON (M.NU_IdMercado=SI.mercado_NU_IdMercado)
				LEFT JOIN pedido AS P ON (P.mercado_NU_IdMercado=M.NU_IdMercado)
				LEFT JOIN pedido_detalle AS PD ON (PD.pedido_NU_IdPedido=P.NU_IdPedido)
				WHERE SI.NU_IdSolicitudInventario=".$this->NU_IdDescuento;
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}	
	
		

	function listarSolicitudInventario2($objConexion){
		$query="SELECT SI.*, M.FE_FechaMercado,SUM(PD.NU_Cantidad) AS TotalProduc, SUM(PD.NU_Cantidad*PD.BS_PrecioUnitario) AS TotalCompra
				FROM solicitud_inventario AS SI
				LEFT JOIN mercado AS M ON (M.NU_IdMercado=SI.mercado_NU_IdMercado)
				LEFT JOIN pedido AS P ON (P.mercado_NU_IdMercado=M.NU_IdMercado)
				LEFT JOIN pedido_detalle AS PD ON (PD.pedido_NU_IdPedido=P.NU_IdPedido)
                GROUP BY SI.NU_IdSolicitudInventario
				ORDER BY SI.NU_IdSolicitudInventario DESC";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
*/	
}
?>