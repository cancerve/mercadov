<?php 
class solicitudInventario{
	private $NU_IdSolicitudInventario;
	private $mercado_NU_IdMercado;	
	private $NU_RealizadoPor;

	function insertar($objConexion,$mercado_NU_IdMercado,$NU_RealizadoPor){
		$this->mercado_NU_IdMercado	= $mercado_NU_IdMercado;
		$this->NU_RealizadoPor		= $NU_RealizadoPor;				

		$query="INSERT INTO solicitud_inventario (mercado_NU_IdMercado,NU_RealizadoPor)
				VALUES
				(".$this->mercado_NU_IdMercado.",".$this->NU_RealizadoPor.")";

		$resultado=$objConexion->ejecutar($query);
		return true;
	}
	
	function obtenerUltimo($objConexion){
		$query="SELECT MAX(NU_IdSolicitudInventario) as id
				FROM solicitud_inventario
				ORDER BY NU_IdSolicitudInventario DESC";
		$resultado=$objConexion->ejecutar($query);	
		//return $resultado;

		if($objConexion->cantidadRegistros($resultado)>0){
			$this->id=$objConexion->obtenerElemento($resultado,0,'id');
		}
		return $this->id;	
	}

/*	function obtenerMercado($objConexion,$NU_IdSolicitudInventario){
		$this->NU_IdSolicitudInventario=$NU_IdSolicitudInventario;
		$query="SELECT *
				FROM solicitud_inventario
				WHERE NU_IdSolicitudInventario=".$this->NU_IdSolicitudInventario;
		$resultado=$objConexion->ejecutar($query);
		$cantRS	= $objConexion->cantidadRegistros($resultado);
	
		if ($cantRS>0){
			$NU_IdMercado = $objConexion->obtenerElemento($resultado,0,"mercado_NU_IdMercado");		
		}
		return $NU_IdMercado;		
	}	*/
	
	function buscarSolicituInv($objConexion,$NU_IdSolicitudInventario){
		$this->NU_IdSolicitudInventario=$NU_IdSolicitudInventario;
		$query="SELECT SI.*, M.FE_FechaMercado, SUM(PD.NU_Cantidad*PD.BS_PrecioUnitario) AS TotalCompra
				FROM solicitud_inventario AS SI
				LEFT JOIN mercado AS M ON (M.NU_IdMercado=SI.mercado_NU_IdMercado)
				LEFT JOIN pedido AS P ON (P.mercado_NU_IdMercado=M.NU_IdMercado)
				LEFT JOIN pedido_detalle AS PD ON (PD.pedido_NU_IdPedido=P.NU_IdPedido)
				WHERE SI.NU_IdSolicitudInventario=".$this->NU_IdSolicitudInventario;
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}	
	
	function listarSolicitudInventario($objConexion,$NU_IdSolicitudInventario){
		$this->NU_IdSolicitudInventario = $NU_IdSolicitudInventario;
		$query="SELECT P.AF_NombreProducto, P.NU_Contenido, M.AL_Medida, PD.BS_PrecioUnitario, PD.NU_Max, count(*) AS Solicitantes
				FROM pedido_detalle AS PD
				LEFT JOIN producto AS P ON (P.NU_IdProducto=PD.producto_NU_IdProducto)
				LEFT JOIN pedido AS PE ON (PE.NU_IdPedido=PD.pedido_NU_IdPedido)
				LEFT JOIN medida AS M ON (M.NU_IdMedida=P.medida_NU_IdMedida)
				LEFT JOIN solicitud_inventario AS SI ON (SI.mercado_NU_IdMercado=PE.mercado_NU_IdMercado)
				WHERE SI.NU_IdSolicitudInventario=".$this->NU_IdSolicitudInventario."
				GROUP BY producto_NU_IdProducto
";

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
}
?>