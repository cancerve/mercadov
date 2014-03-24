<?php 
class Pedido{
	private $NU_IdPedido;
	private $usuario_NU_IdUsuario;	
	private $mercado_NU_IdMercado;
	private $AF_CodPedido;
	private $AL_AutorizoCedula;
	private $AL_AutorizoNombre;	
	private $FE_FechaPedido;			
	private $FE_Registro;	

	function insertar($objConexion,$usuario_NU_IdUsuario,$mercado_NU_IdMercado,$AL_AutorizoCedula,$AL_AutorizoNombre,$FE_FechaPedido){
		$this->usuario_NU_IdUsuario	= $usuario_NU_IdUsuario;
		$this->mercado_NU_IdMercado	= $mercado_NU_IdMercado;
		$this->AL_AutorizoCedula	= $AL_AutorizoCedula;
		$this->AL_AutorizoNombre	= $AL_AutorizoNombre;
//		$this->AF_CodPedido			= $AF_CodPedido;
		$this->FE_FechaPedido		= $FE_FechaPedido;		

		$query="INSERT INTO pedido (usuario_NU_IdUsuario,mercado_NU_IdMercado,AL_AutorizoCedula,AL_AutorizoNombre,FE_FechaPedido)
				VALUES
				(".$this->usuario_NU_IdUsuario.",".$this->mercado_NU_IdMercado.",'".$this->AL_AutorizoCedula."','".$this->AL_AutorizoNombre."','".$this->FE_FechaPedido."')";
		$resultado=$objConexion->ejecutar($query);
		return true;
	}
	
	function obtenerUltimo($objConexion){
		$query="SELECT MAX(NU_IdPedido) as id
				FROM pedido";
		$resultado=$objConexion->ejecutar($query);	
		//return $resultado;

		if($objConexion->cantidadRegistros($resultado)>0){
			$this->id=$objConexion->obtenerElemento($resultado,0,'id');
		}
		return $this->id;	
	}	
	
	function buscar($objConexion,$NU_IdPedido){
		$this->NU_IdPedido=$NU_IdPedido;
		$query="SELECT P.*, U.AL_Nombre, U.AL_Apellido, U.NU_Cedula, E.AF_RazonSocial, G.AL_NombreGerencia, S.AL_NombreSede
				FROM pedido AS P
				LEFT JOIN usuario AS U ON (U.NU_IdUsuario=P.usuario_NU_IdUsuario)
				LEFT JOIN empresa AS E ON (E.NU_IdEmpresa=U.empresa_NU_IdEmpresa)
				LEFT JOIN gerencia AS G ON (G.NU_IdGerencia=U.gerencia_NU_IdGerencia)
				LEFT JOIN sede AS S ON (S.NU_IdSede=U.sede_NU_IdSede)
				WHERE P.NU_IdPedido=".$this->NU_IdPedido;
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
	
	function verificarPedido($objConexion,$usuario_NU_IdUsuario,$mercado_NU_IdMercado){
		$this->usuario_NU_IdUsuario = $usuario_NU_IdUsuario;
		$this->mercado_NU_IdMercado = $mercado_NU_IdMercado;		
		$query="SELECT *
				FROM pedido AS P
				WHERE P.usuario_NU_IdUsuario=".$this->usuario_NU_IdUsuario." and mercado_NU_IdMercado=".$this->mercado_NU_IdMercado;
		$resultado=$objConexion->ejecutar($query);
		$cantidad = $objConexion->cantidadRegistros($resultado);

		return $cantidad;
	}
	
	function crearCodigo($objConexion,$NU_IdPedido,$AF_CodPedido){
		$this->NU_IdPedido	= $NU_IdPedido;
		$this->AF_CodPedido	= $AF_CodPedido;

		$query="UPDATE pedido 
				SET AF_CodPedido='".$this->AF_CodPedido."'
				WHERE NU_IdPedido=".$this->NU_IdPedido;
		$resultado=$objConexion->ejecutar($query);		

		return true;
	}
	
//	function listarPedidos($objConexion,$Pagina,$TamanoPag){
	function listarPedidos($objConexion){
		/*
		$this->Pagina 		= $Pagina;
		$this->TamanoPag 	= $TamanoPag;
		*/
		//$limite = 'LIMIT '.$Pagina.','.$TamanoPag;
		$limite = '';
		
		$query="SELECT P.*, U.NU_Cedula, U.AL_Nombre, U.AL_Apellido, SUM(NU_Cantidad) AS CantProductos, SUM(NU_Cantidad*BS_PrecioUnitario) AS MontoPagar, V.BI_Aprobado
				FROM pedido AS P
				LEFT JOIN usuario AS U ON (U.NU_IdUsuario=P.usuario_NU_IdUsuario)
				LEFT JOIN pedido_detalle AS PD ON (PD.pedido_NU_IdPedido=P.NU_IdPedido)
				LEFT JOIN verificacion_compra AS V ON (V.pedido_NU_IdPedido=P.NU_IdPedido)
				WHERE V.BI_Aprobado IS NULL
                GROUP BY P.NU_IdPedido
				ORDER BY P.NU_IdPedido DESC";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
	
	function listarPedidoIndiv($objConexion,$NU_IdUsuario){		
		$this->NU_IdUsuario = $NU_IdUsuario;
		$query="SELECT P.*, M.FE_FechaMercado,U.NU_Cedula, U.AL_Nombre, U.AL_Apellido, SUM(NU_Cantidad) AS CantProductos, SUM(NU_Cantidad*BS_PrecioUnitario) AS MontoBruto, V.BI_Aprobado
				FROM pedido AS P
                                LEFT JOIN mercado AS M ON (M.NU_IdMercado=P.mercado_NU_IdMercado)
				LEFT JOIN usuario AS U ON (U.NU_IdUsuario=P.usuario_NU_IdUsuario)
				LEFT JOIN pedido_detalle AS PD ON (PD.pedido_NU_IdPedido=P.NU_IdPedido)
				LEFT JOIN verificacion_compra AS V ON (V.pedido_NU_IdPedido=P.NU_IdPedido)
				WHERE usuario_NU_IdUsuario=".$this->NU_IdUsuario."
                GROUP BY P.NU_IdPedido
				ORDER BY P.NU_IdPedido DESC";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}	
	
	function listarRep($objConexion){		
		$query="SELECT *, count(*) AS cantidad 
				FROM (SELECT * 
					  FROM pedido
					  ORDER BY NU_IdPedido DESC) AS t 
				GROUP BY usuario_NU_IdUsuario";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
	
	function delete($objConexion,$usuario_NU_IdUsuario,$NU_IdPedido){
		$this->usuario_NU_IdUsuario = $usuario_NU_IdUsuario;
		$this->NU_IdPedido = $NU_IdPedido;
		
		$query="DELETE 
				FROM pedido
				WHERE usuario_NU_IdUsuario=".$this->usuario_NU_IdUsuario." AND NU_IdPedido!=".$this->NU_IdPedido."";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;
	}
						
}
?>