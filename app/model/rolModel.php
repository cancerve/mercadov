<?php 
class Rol{
	private $NU_IdRol;
	private $AF_Rol;	
	
	function listarRoles($objConexion){
		$query="SELECT *
				FROM rol
				ORDER BY AF_Rol ASC";
		$resultado=$objConexion->ejecutar($query);
		return $resultado;		
	}			

}
?>