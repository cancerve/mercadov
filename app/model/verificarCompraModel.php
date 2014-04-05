<?php 
class VerificarCompra{
	private $NU_IdVerificacion;
	private $pedido_NU_IdPedido;	
	private $BI_Aprobado;
	private $NU_VerificadoPor;
	private $FE_Registro;

	function insertar($objConexion,$pedido_NU_IdPedido,$BI_Aprobado,$NU_VerificadoPor){
		$this->pedido_NU_IdPedido	= $pedido_NU_IdPedido;
		$this->BI_Aprobado			= $BI_Aprobado;
		$this->NU_VerificadoPor		= $NU_VerificadoPor;

		$query="INSERT INTO verificacion_compra (pedido_NU_IdPedido,BI_Aprobado,NU_VerificadoPor)
				VALUES
				(".$this->pedido_NU_IdPedido.",".$this->BI_Aprobado.",".$this->NU_VerificadoPor.")";
		$resultado=$objConexion->ejecutar($query);
		
		return true;
	}
/*	
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
	
	function crearCodigo($objConexion,$NU_IdPedido,$AF_CodPedido){
		$this->NU_IdPedido	= $NU_IdPedido;
		$this->AF_CodPedido	= $AF_CodPedido;

		$query="UPDATE pedido 
				SET AF_CodPedido='".$this->AF_CodPedido."'
				WHERE NU_IdPedido=".$this->NU_IdPedido;
		$resultado=$objConexion->ejecutar($query);		

		return true;
	}
	
	function listarPedidos($objConexion){
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
*/
}
?>