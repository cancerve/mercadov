<?php 
class conexion{
	private $servidor;
	private $usuario;
	private $clave;
	private $basedatos;
	private $id;

	function __construct($servidor,$usuario,$clave,$basedatos){
		$this->servidor=$servidor;
		$this->usuario=$usuario;
		$this->clave=$clave;
		$this->basedatos=$basedatos;
		
		//@Mysql_connect ESTO ES PARA QUE LOS ERRORES NO LOS MANEJES EL SI NO LO MANEJE YO.
		$this->id=@mysql_connect($this->servidor,$this->usuario,$this->clave);
		if($this->id===false){
			throw new Exception("ERROR ".mysql_error());
		}
		$bd=@mysql_select_db($this->basedatos,$this->id);
		if($bd===false){
			throw new Exception("ERROR ".mysql_error());
		}
		return true;
	}
	
	function ejecutar($query){
		mysql_query("SET NAMES 'utf8'"); // PARA CAMBIAR LOS DATOS A ESPANOL
		$resultado=@mysql_query($query,$this->id);
		if($resultado===false){
			throw new Exception("ERROR ".mysql_error());
		}
		return $resultado;
	}
	
	function cantidadRegistros($recurso){
		$cantidad=@mysql_num_rows($recurso);
		if($cantidad===false){
			throw new Exception("ERROR ".mysql_error());
		}		
		return $cantidad;
	}
	
	function obtenerArreglo($recurso,$tipo){
		$arreglo=mysql_fetch_array($recurso,$tipo);
		return $arreglo;
	}
	
	function obtenerElemento($recurso,$fila,$campo){
		$elemento=mysql_result($recurso,$fila,$campo);
		return $elemento;
	}
	
	function __destruct(){
		mysql_close($this->id);
	}
}
?>