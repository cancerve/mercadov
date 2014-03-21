<?php 
	require_once("../includes/constantes.php");
	require_once("../includes/conexion.class.php");
	require_once('../model/sedeModel.php');
	require_once('../model/gerenciaModel.php');
	
	$objConexion= new conexion(SERVER,USER,PASS,DB);
?>
<?php
	if ($_GET['accion']==1){
		$objSede	= new Sede;
		$rsSede		= $objSede->buscarSede($objConexion,$_GET["opcion"]);
		$cant 		= $objConexion->cantidadRegistros($rsSede);
		// Comienzo a imprimir el select
	
		$sel = '<select name="sede_NU_IdSede" id="sede_NU_IdSede" onChange="cargaContenido(2,this.id,';
		$sel.= "'gerencia_NU_IdGerencia'";
		$sel.= ')">';
	
		echo $sel;
		echo "<option value=''>[ Seleccione ]</option>";
		
		for($i=0;$i<$cant;$i++){
			  $value	= $objConexion->obtenerElemento($rsSede,$i,"NU_IdSede");
			  $des		= $objConexion->obtenerElemento($rsSede,$i,"AL_NombreSede");
 
			  echo "<option value=".$value." ".$selected.">".$des."</option>";
		}  
		echo "</select>";
		
	}else{
		$objGerencia	= new Gerencia;
		$rsGerencia		= $objGerencia->buscarGerencia($objConexion,$_GET["opcion"]);
		$cant 			= $objConexion->cantidadRegistros($rsGerencia);
		// Comienzo a imprimir el select

		echo '<select name="gerencia_NU_IdGerencia" id="gerencia_NU_IdGerencia"';
		echo '<option value="">[ Seleccione ]</option>';
		echo '<option value="">[ Seleccione ]</option>';
		for($i=0;$i<$cant;$i++){
			  $value	= $objConexion->obtenerElemento($rsGerencia,$i,"NU_IdGerencia");
			  $des		= $objConexion->obtenerElemento($rsGerencia,$i,"AL_NombreGerencia");
			  /*
			  $selected = "";
			  
			  if($_GET['valor_ciudad']==$value){
				  $selected="selected='selected'";
			  }
			  */
			  echo "<option value=".$value." ".$selected.">".$des."</option>";
		}  
		echo "</select>";		
	}
?>


