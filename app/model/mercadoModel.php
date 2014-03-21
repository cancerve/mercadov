<?php 
class Mercado{
	private $NU_IdMercado;
	private $empresa_NU_IdEmpresa;	
	private $FE_FechaMercado;
	private $FE_Inicio;
	private $FE_Fin;	
	private $NU_Activo;			
	private $FE_Registro;	

	function insertar($objConexion,$empresa_NU_IdEmpresa,$FE_FechaMercado,$FE_Inicio,$FE_Fin){
		$this->empresa_NU_IdEmpresa	= $empresa_NU_IdEmpresa;
		$this->FE_FechaMercado		= $FE_FechaMercado;
		$this->FE_Inicio			= $FE_Inicio;				
		$this->FE_Fin				= $FE_Fin;

		$query="INSERT INTO mercado (empresa_NU_IdEmpresa,FE_FechaMercado,FE_Inicio,FE_Fin)
				VALUES
				(".$this->empresa_NU_IdEmpresa.",'".$this->FE_FechaMercado."','".$this->FE_Inicio."','".$this->FE_Fin."')";
		$resultado=$objConexion->ejecutar($query);
		return true;
	}
	
	function buscar($objConexion,$NU_IdMercado){
		$this->NU_IdMercado=$NU_IdMercado;
		$query="SELECT *
				FROM mercado
				WHERE NU_IdMercado=".$this->NU_IdMercado;
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
	
	function obtenerUltimo($objConexion){
		$query="SELECT MAX(NU_IdMercado) as id
				FROM mercado";
		$resultado=$objConexion->ejecutar($query);	
		//return $resultado;

		if($objConexion->cantidadRegistros($resultado)>0){
			$this->id=$objConexion->obtenerElemento($resultado,0,'id');
		}
		return $this->id;	
	}
	
	function listarMercado($objConexion){
		$query="SELECT M.*, E.AF_RazonSocial, count(*) AS producto
				FROM mercado AS M
				LEFT JOIN mercado_producto AS MP ON (MP.NU_IdMercado=M.NU_IdMercado)
				LEFT JOIN empresa AS E ON (E.NU_IdEmpresa=M.empresa_NU_IdEmpresa)
                GROUP BY M.NU_IdMercado
				ORDER BY M.NU_IdMercado DESC";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
	
	function verificarActivo($objConexion,$empresa_NU_IdEmpresa){
		$this->empresa_NU_IdEmpresa=$empresa_NU_IdEmpresa;
		$query="SELECT *
				FROM mercado
				WHERE empresa_NU_IdEmpresa=".$this->empresa_NU_IdEmpresa." and NU_Activo=1";
		$resultado=$objConexion->ejecutar($query);

		return $resultado;
		
	}	

	function actualizarActivo($objConexion,$NU_IdMercado,$FE_Inicio,$FE_Fin){
		$this->NU_IdMercado	= $NU_IdMercado;
		$this->FE_Inicio	= $FE_Inicio;
		$this->FE_Fin		= $FE_Fin;

		if ((date("Y-m-d") <= $this->FE_Fin) and (date("Y-m-d") >= $this->FE_Inicio)){
			$query="UPDATE mercado 
					SET NU_Activo=1
					WHERE NU_IdMercado=".$this->NU_IdMercado;
			$resultado=$objConexion->ejecutar($query);		
		}else{
			$query="UPDATE mercado 
					SET NU_Activo=0
					WHERE NU_IdMercado=".$this->NU_IdMercado;
			$resultado=$objConexion->ejecutar($query);		
		}
		return true;
	}			
/*	
	function listarMercado($objConexion){
		$query="SELECT EMP.*,E.nombre AS estado,M.nombre AS municipio,P.nombre AS parroquia
				FROM empresa AS EMP
				LEFT JOIN estado AS E ON (E.id=EMP.estado_NU_IdEstado)
				LEFT JOIN municipio AS M ON (M.id=EMP.municipio_NU_IdMunicipio)				
				LEFT JOIN parroquia AS P ON (P.id=EMP.parroquia_NU_IdParroquia)				
				ORDER BY AF_RazonSocial ASC";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}

	
	function actualizar($objConexion,$AF_RIF,$ciudad_AF_CodCiudad,$pais_AL_CodPais,$AF_Clasificacion_Empresa,$AF_Razon_Social,$AF_Direccion,$AL_Web,$AF_Correo_Electronico,$AF_Telefono,$AF_Fax){
		$this->AF_RIF					= $AF_RIF;
		$this->ciudad_AF_CodCiudad		= $ciudad_AF_CodCiudad;				
		$this->pais_AL_CodPais			= $pais_AL_CodPais;
		$this->AF_Clasificacion_Empresa	= $AF_Clasificacion_Empresa;
		$this->AF_Razon_Social			= $AF_Razon_Social;
		$this->AF_Direccion				= $AF_Direccion;
		$this->AL_Web					= $AL_Web;
		$this->AF_Correo_Electronico	= $AF_Correo_Electronico;
		$this->AF_Telefono				= $AF_Telefono;
		$this->AF_Fax					= $AF_Fax;
		
		$query="UPDATE empresa SET
				ciudad_AF_CodCiudad='".$this->ciudad_AF_CodCiudad."',				
				pais_AL_CodPais='".$this->pais_AL_CodPais."',
				AF_Clasificacion_Empresa='".$this->AF_Clasificacion_Empresa."',
				AF_Razon_Social='".$this->AF_Razon_Social."',
				AF_Direccion='".$this->AF_Direccion."',
				AL_Web='".$this->AL_Web."',
				AF_Correo_Electronico='".$this->AF_Correo_Electronico."',
				AF_Telefono='".$this->AF_Telefono."',
				AF_Fax='".$this->AF_Fax."'				
				WHERE AF_RIF='".$this->AF_RIF."'";
		$resultado=$objConexion->ejecutar($query);
		return true;
	}
	
	

*/		

}
?>