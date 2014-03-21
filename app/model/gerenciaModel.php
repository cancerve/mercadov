<?php 
class Gerencia{
	private $NU_IdGerencia;
	private $sede_NU_IdSede;
	private $AL_NombreGerencia;
	private $AL_Gerente;
	private $AL_Ubicacion;
	private $NU_Activo;	
	private $FE_Registro;		
	
	/*
	function insertar($objConexion,$pais_AL_CodPais,$AL_Ciudad){
		$this->generarNuevo($objConexion);
		$this->pais_AL_CodPais=$pais_AL_CodPais;
		$this->AL_Ciudad=$AL_Ciudad;

		$query="INSERT INTO ciudad
				(AF_CodCiudad,pais_AL_CodPais,AL_Ciudad)
				VALUES
				('".$this->AF_CodCiudad."','".$this->pais_AL_CodPais."','".$this->AL_Ciudad."')";
		$resultado=$objConexion->ejecutar($query);
		return true;
	}
	
	function actualizar($objConexion,$AF_CodCiudad,$pais_AL_CodPais,$AL_Ciudad){
		$this->pais_AL_CodPais=$pais_AL_CodPais;
		$this->AL_Ciudad=$AL_Ciudad;
		
		$query="UPDATE ciudad SET
				pais_AL_CodPais='".$this->pais_AL_CodPais."',
				AL_Ciudad='".$this->AL_Ciudad."',
				WHERE AF_CodCiudad=".$this->AF_CodCiudad;
		$resultado=$objConexion->ejecutar($query);
		return true;
	}
	
	private function generarNuevo($objConexion){
		$this->AF_CodCiudad=0;
		$query="SELECT MAX(AF_CodCiudad) as AF_CodCiudad
				FROM ciudad";
		$resultado=$objConexion->ejecutar($query);
		if($objConexion->cantidadRegistros($resultado)>0){
			$this->AF_CodCiudad=$objConexion->obtenerElemento($resultado,0,0);
		}
		$this->AF_CodCiudad++;
		return;
	}
	
	function buscar($objConexion,$AF_CodCiudad){
		$this->AF_CodCiudad=$AF_CodCiudad;
		$query="SELECT *
				FROM ciudad
				WHERE AF_CodCiudad=".$this->AF_CodCiudad;
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
	
	function listar($objConexion){
		$query="SELECT *
				FROM ciudad
				ORDER BY AL_Ciudad ASC";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}
	
	function getLibCodigo(){
		return $this->AF_CodCiudad;
	}	
*/
	function buscarGerencia($objConexion,$sede_NU_IdSede){
		$this->sede_NU_IdSede=$sede_NU_IdSede;
		$query="SELECT *
				FROM gerencia
				WHERE sede_NU_IdSede='".$this->sede_NU_IdSede."'
				ORDER BY AL_NombreGerencia ASC";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}

}
?>