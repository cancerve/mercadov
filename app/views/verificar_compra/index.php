<?php 
require_once('../../controller/sessionController.php'); 
require_once('../../model/pedidoModel.php');
require_once('../../model/verificarCompraModel.php');
require_once('../../model/usuarioModel.php');

$objPedido 			= new Pedido();
$objVerificarCompra = new VerificarCompra();
$objUsuario			= new Usuario();

if (isset($_GET['BI_Aprobado']) and $_GET['BI_Aprobado'] != ''){
	if ($_GET['BI_Aprobado'] == '1'){
		$objVerificarCompra->insertar($objConexion,$_GET['NU_IdPedido'],1,$_SESSION["NU_IdUsuario"]);		
	}else{
		$objVerificarCompra->insertar($objConexion,$_GET['NU_IdPedido'],0,$_SESSION["NU_IdUsuario"]);				
	}
}

//////////////////////////////// PAGINACION ////////////////////////////////////
//Limito la busqueda 
/*
$TamanoPag 	= 10;

if (isset($_GET['Pagina'])){ 
	$Pagina		= $_GET['Pagina'];
}else{
	$Pagina		= 0;
}
//examino la página a mostrar y el inicio del registro a mostrar 
/*
if ($_GET['Pagina']!=0) { 
   	 $Pagina=0; 
} 
else { 
   	$inicio = ($Pagina - 1) * $TamanoPag; 
}
*/
///////////////////////////////////////////////////////////////////////////////	

//$RSPedido		= $objPedido->listarPedidos($objConexion,$Pagina,$TamanoPag);
$RSPedido		= $objPedido->listarPedidos($objConexion);
$cantRSPedido	= $objConexion->cantidadRegistros($RSPedido);

	///////////// CONVERTIR DECIMALES A ESPANOL ///////////
	function setDecimalEsp($numero){
		$numero = str_replace(".", ",", $numero);
		return $numero;
	}
	

?>
<html>
<link rel="stylesheet" type="text/css" href="../../css/estilo.css">
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<script type="text/javascript" src="../../js/mensajes.js"></script>	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../../css/jquery-ui.css" />
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript">
    function abrir_dialog() {
		var mensaje = "<?php echo $_GET['mensaje']; ?>";
		if(mensaje){
		  $( "#dialog" ).dialog({
			  show: "blind",
			  hide: "explode",
			  modal: true,
 			  width: 450,
			  height: 215,			  
			  buttons: {
				Aceptar: function() {
				  $( this ).dialog( "close" );
				}
			  }
		  });
		}
    };
</script>
</head>
<body onLoad="abrir_dialog();">
<div id="dialog" title="Perfil" style="display:none;">
    <p align="left">
	<?php if ($_GET['mensaje']=='Perfil'){
		$RSUsuario		= $objUsuario->buscarUsuario($objConexion,$_GET['NU_Cedula']);
		$cantRSUsuario	= $objConexion->cantidadRegistros($RSUsuario);

			if ($cantRSUsuario>0){
				$AF_RazonSocial 	= $objConexion->obtenerElemento($RSUsuario,0,'AF_RazonSocial');			
				$AL_NombreSede 		= $objConexion->obtenerElemento($RSUsuario,0,'AL_NombreSede');			
				$AL_NombreGerencia 	= $objConexion->obtenerElemento($RSUsuario,0,'AL_NombreGerencia');			
				$NU_Cedula 			= $objConexion->obtenerElemento($RSUsuario,0,'NU_Cedula');			
				$AL_Nombre 			= $objConexion->obtenerElemento($RSUsuario,0,'AL_Nombre');			
				$AL_Apellido 		= $objConexion->obtenerElemento($RSUsuario,0,'AL_Apellido');																		
				$AF_Correo 			= $objConexion->obtenerElemento($RSUsuario,0,'AF_Correo');			
				$AF_Telefono 		= $objConexion->obtenerElemento($RSUsuario,0,'AF_Telefono');			
			
				echo '<b>CEDULA: </b>'.ucwords(strtolower($NU_Cedula)).'</br>';
				echo '<b>NOMBRE: </b>'.ucwords(strtolower($AL_Nombre)).'</br>';
				echo '<b>APELLIDO: </b>'.ucwords(strtolower($AL_Apellido)).'</br>';
				echo '<b>CORREO: </b>'.strtolower($AF_Correo).'</br>';
				echo '<b>TELEFONO: </b>'.ucwords(strtolower($AF_Telefono)).'</br>';
				echo '<b>EMPRESA: </b>'.ucwords(strtolower($AF_RazonSocial)).'</br>';
				echo '<b>UBICACION: </b>'.ucwords(strtolower($AL_NombreSede)).'</br>';
				echo '<b>GERENCIA: </b>'.ucwords(strtolower($AL_NombreGerencia));
			}
		}
	?>
    </p>
</div>
  <table class="Textonegro" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" align="left" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VERIFICAR ORDENES DE COMPRA</td>
    </tr>
    <tr>
      <td><img src="../../images/blank.gif" width="20" height="5"></td>
    </tr>
    <tr>
      <td height="25" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="center"><table width="95%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td class="BlancoGris">&nbsp; Verifique la información y posteriormente apruebe o rechace una orden de compra.</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="25">&nbsp;</td>
    </tr>
    <?php if ($cantRSPedido>0){ ?>
    <tr>
      <td height="25">
      <table width="95%" class="TablaRojaGrid" align="center">
      <thead>
        <tr class="TablaRojaGridTRTitulo">
          <th width="30" align="center" scope="col">NRO</th>
          <th width="130" align="center" scope="col">ORDEN DE <br>
            COMPRA NRO.</th>
          <th width="85" align="center" scope="col">CÉDULA</th>
          <th align="center" scope="col">NOMBRE Y APELLIDO</th>
          <th width="76" align="center" scope="col">CANT. <br>
            PRODUCTOS</th>
          <th width="67" align="center" scope="col">MONTO A<br>
            PAGAR</th>
          <th width="67" align="center" scope="col">VER<br>
            PERFIL</th>
          <th width="67" align="center" scope="col">VER<br>
            ORDEN</th>
<!--          <th width="67" align="center" scope="col">APROBAR</th>
          <th width="67" align="center" scope="col">RECHAZAR</th>-->
        </tr>
	  </thead>
      <tbody>
	<?php
    	for($i=0; $i<$cantRSPedido; $i++){
			$NU_IdPedido 	= $objConexion->obtenerElemento($RSPedido,$i,'NU_IdPedido');
			$AF_CodPedido 	= $objConexion->obtenerElemento($RSPedido,$i,'AF_CodPedido');
			$NU_Cedula		= $objConexion->obtenerElemento($RSPedido,$i,'NU_Cedula');			
			$AL_Nombre 		= $objConexion->obtenerElemento($RSPedido,$i,'AL_Nombre');
			$AL_Apellido 	= $objConexion->obtenerElemento($RSPedido,$i,'AL_Apellido');			
			$CantProductos 	= $objConexion->obtenerElemento($RSPedido,$i,'CantProductos');
			$MontoPagar 	= $objConexion->obtenerElemento($RSPedido,$i,'MontoPagar');						
    ?>
        <tr>
          <td align="center" class="TablaRojaGridTD; Blanquita" bgcolor="#cf0f1b"><?php echo $i+1; ?></td>
          <td align="center" class="TablaRojaGridTD"><?php echo $AF_CodPedido; ?></td>
          <td align="center" class="TablaRojaGridTD"><?php echo $NU_Cedula; ?></td>
          <td align="left"   class="TablaRojaGridTD"><?php echo $AL_Nombre.'</br>'.$AL_Apellido; ?></td>
          <td align="center" class="TablaRojaGridTD"><?php echo $CantProductos; ?></td>
          <td align="center" class="TablaRojaGridTD"><?php echo setDecimalEsp($MontoPagar).' BsF.'; ?></td>
          <td align="center" class="TablaRojaGridTD"><a href="index.php?mensaje=Perfil&NU_Cedula=<?=$NU_Cedula?>"><img src="../../images/bton_ver.gif" width="31" height="31"></a></td>
          <!--<td align="center" class="TablaRojaGridTD"><a href="../pedido/orden_compra.php?pedido_NU_IdPedido=<?=$NU_IdPedido?>" target="_blank"><img src="../../images/bton_ver.gif" width="31" height="31"></a></td>
          <td align="center" class="TablaRojaGridTD">
          	<a href="index.php?NU_IdPedido=<?=$NU_IdPedido?>&BI_Aprobado=1&&NU_IdPedido=<?=$NU_IdPedido?>">
            <img src="../../images/bton_Aprobado.gif" width="35" height="31">
            </a>
          </td>-->
          <td align="center" class="TablaRojaGridTD">
          	<a href="index.php?NU_IdPedido=<?=$NU_IdPedido?>&BI_Aprobado=0&&NU_IdPedido=<?=$NU_IdPedido?>">
            <img src="../../images/bton_del.gif" width="35" height="31"></a>
          </td>
        </tr>
	<?php
	    }
    ?>          
        </tbody>
      </table>
	<?php
	    }else{ echo 'No se encontraron registros.'; }
    ?>       
      </td>
    </tr>
    <tr>
      <td height="25"><!--<table width="50" border="0" align="center" cellpadding="2" cellspacing="0">
        <tr>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><a href="index.php"><img src="../../images/First.gif" width="71" height="44"></a></td>
          <td align="center"><a href="index.php"><img src="../../images/Previous.gif" width="71" height="44"></a></td>
          <td align="center"><a href="index.php"><img src="../../images/Next.gif" width="71" height="44"></a></td>
          <td align="center"><a href="index.php"><img src="../../images/Last.gif" width="71" height="44"></a></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
      </table-->></td>
    </tr>
  </table>
</body>
</html>