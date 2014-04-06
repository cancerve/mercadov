<?php 
class PedidoDetalle{
	private $NU_IdPedidoDetalle;
	private $producto_NU_IdProducto;	
	private $pedido_NU_IdPedido;
	private $sede_NU_IdSede;	
	private $gerencia_NU_IdGerencia;	
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
	
	function buscarSolicituInv($objConexion,$mercado_NU_IdMercado){
		$this->mercado_NU_IdMercado = $mercado_NU_IdMercado;
		$query="SELECT MM.FE_FechaMercado, P.AF_NombreProducto, P.NU_Contenido, M.AL_Medida, PD.BS_PrecioUnitario, PD.NU_Max, count(*) AS solicitudes, SUM(PD.NU_Cantidad) AS Solicitantes
				FROM pedido_detalle AS PD
				LEFT JOIN producto AS P ON (P.NU_IdProducto=PD.producto_NU_IdProducto)
				LEFT JOIN pedido AS PE ON (PE.NU_IdPedido=PD.pedido_NU_IdPedido)
				LEFT JOIN medida AS M ON (M.NU_IdMedida=P.medida_NU_IdMedida)
                LEFT JOIN mercado AS MM ON (MM.NU_IdMercado=PE.mercado_NU_IdMercado)
				WHERE PE.mercado_NU_IdMercado=".$this->mercado_NU_IdMercado."
				GROUP BY producto_NU_IdProducto";
			
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
	
	function crearInventario($objConexion,$mercado_NU_IdMercado){
		$this->mercado_NU_IdMercado = $mercado_NU_IdMercado;
		$query="SELECT E.AF_RazonSocial AS empresa, S.NU_IdSede, S.AL_NombreSede, G.NU_IdGerencia, G.AL_NombreGerencia, PR.AF_NombreProducto, SUM(PD.NU_Cantidad) AS cantidad
				FROM pedido_detalle AS PD
				LEFT JOIN pedido AS P ON (P.NU_IdPedido=PD.pedido_NU_IdPedido)
				LEFT JOIN usuario AS U ON (U.NU_IdUsuario=P.usuario_NU_IdUsuario)
				LEFT JOIN empresa AS E ON (E.NU_IdEmpresa=U.empresa_NU_IdEmpresa)
				LEFT JOIN sede AS S ON (S.NU_IdSede=U.sede_NU_IdSede)
				LEFT JOIN gerencia AS G ON (G.NU_IdGerencia=U.gerencia_NU_IdGerencia)
				LEFT JOIN producto AS PR ON (PR.NU_IdProducto=PD.producto_NU_IdProducto)
				WHERE P.mercado_NU_IdMercado=".$this->mercado_NU_IdMercado."
				GROUP BY U.sede_NU_IdSede, U.gerencia_NU_IdGerencia, PD.producto_NU_IdProducto
				ORDER BY S.AL_NombreSede ASC, G.AL_NombreGerencia ASC, PR.AF_NombreProducto ASC";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}	
	
	function crearInventario2($objConexion,$mercado_NU_IdMercado){
		$this->mercado_NU_IdMercado = $mercado_NU_IdMercado;
		$query="SELECT E.AF_RazonSocial, S.AL_NombreSede, G.AL_NombreGerencia, PR.AF_NombreProducto, SUM(PD.NU_Cantidad) AS NU_Cantidad
		FROM pedido AS P
		LEFT JOIN usuario AS U ON (U.NU_IdUsuario=P.usuario_NU_IdUsuario)
		LEFT JOIN pedido_detalle AS PD ON (PD.pedido_NU_IdPedido=P.NU_IdPedido)
		LEFT JOIN empresa AS E ON (E.NU_IdEmpresa=U.empresa_NU_IdEmpresa)
		LEFT JOIN sede AS S ON (U.sede_NU_IdSede=S.NU_IdSede)
		LEFT JOIN gerencia AS G ON (U.gerencia_NU_IdGerencia=G.NU_IdGerencia)
		LEFT JOIN producto AS PR ON (PD.producto_NU_IdProducto=PR.NU_IdProducto)
		WHERE mercado_NU_IdMercado=".$this->mercado_NU_IdMercado."
		GROUP BY U.sede_NU_IdSede, U.gerencia_NU_IdGerencia, PD.producto_NU_IdProducto
		ORDER BY S.AL_NombreSede ASC, G.AL_NombreGerencia ASC, P.NU_IdPedido ASC, PR.AF_NombreProducto ASC";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
		
	function listar($objConexion,$NU_IdMercado){
		$this->NU_IdMercado = $NU_IdMercado;
		$query="SELECT PD.pedido_NU_IdPedido, PD.producto_NU_IdProducto, COUNT(*) AS CANT
FROM pedido_detalle AS PD
LEFT JOIN pedido AS P ON (PD.pedido_NU_IdPedido=P.NU_IdPedido)
WHERE P.mercado_NU_IdMercado=".$this->NU_IdMercado."
GROUP BY PD.pedido_NU_IdPedido
ORDER BY PD.pedido_NU_IdPedido ASC";

		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}

	function listar2($objConexion,$NU_IdMercado){
		$this->NU_IdMercado = $NU_IdMercado;
		$query="SELECT PD.*
FROM pedido_detalle AS PD
LEFT JOIN pedido AS P ON (PD.pedido_NU_IdPedido=P.NU_IdPedido)
WHERE P.mercado_NU_IdMercado=".$this->NU_IdMercado."
ORDER BY PD.pedido_NU_IdPedido ASC";

		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
		
	function update2($objConexion,$NU_IdPedidoDetalle,$sede_NU_IdSede,$gerencia_NU_IdGerencia){
		$this->NU_IdPedidoDetalle	= $NU_IdPedidoDetalle;
		$this->sede_NU_IdSede			= $sede_NU_IdSede;	
		$this->gerencia_NU_IdGerencia			= $gerencia_NU_IdGerencia;				

		$query="UPDATE pedido_detalle SET
				sede_NU_IdSede =".$this->sede_NU_IdSede.",
				gerencia_NU_IdGerencia =".$this->gerencia_NU_IdGerencia."
				WHERE NU_IdPedidoDetalle=".$this->NU_IdPedidoDetalle;
		
		$resultado=$objConexion->ejecutar($query);
		return true;
	}		
/*
	function crearInventario($objConexion,$mercado_NU_IdMercado){
		$this->mercado_NU_IdMercado = $mercado_NU_IdMercado;
		$query="SELECT E.AF_RazonSocial AS empresa, S.AL_NombreSede, G.AL_NombreGerencia, PR.AF_NombreProducto, count(*) AS cantidad
				FROM pedido_detalle AS PD
				LEFT JOIN pedido AS P ON (P.NU_IdPedido=PD.pedido_NU_IdPedido)
				LEFT JOIN usuario AS U ON (U.NU_IdUsuario=P.usuario_NU_IdUsuario)
				LEFT JOIN empresa AS E ON (E.NU_IdEmpresa=U.empresa_NU_IdEmpresa)
				LEFT JOIN sede AS S ON (S.NU_IdSede=U.sede_NU_IdSede)
				LEFT JOIN gerencia AS G ON (G.NU_IdGerencia=U.gerencia_NU_IdGerencia)
				LEFT JOIN producto AS PR ON (PR.NU_IdProducto=PD.producto_NU_IdProducto)
				WHERE P.mercado_NU_IdMercado=".$this->mercado_NU_IdMercado." AND U.sede_NU_IdSede=4
				GROUP BY U.sede_NU_IdSede, U.gerencia_NU_IdGerencia, PD.producto_NU_IdProducto";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
/**/				
}
?>