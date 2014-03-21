<?php 
require_once('../../controller/sessionController.php'); 
require_once('../../model/mercadoModel.php');

$objMercado = new Mercado();

$RS 	= $objMercado->listarMercado($objConexion);
$cantRS = $objConexion->cantidadRegistros($RS);

	///// CONVIERTE FECHA 04/07/1980 A 1980-07-04 (FORMATO MYSQL)
	function setFechaNoSQL($FE_FechaNac)
	{
		$partes = explode("-", $FE_FechaNac);
		$FE_FechaNac = $partes[2].'/'.$partes[1].'/'.$partes[0];
		return $FE_FechaNac;
	}
	//////////////////////////////////////////////////////////////
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
<div id="dialog" title="Mensaje" style="display:none;">
    <p><?php echo $_GET['mensaje']; ?></p>
</div>
  <table class="Textonegro" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" align="left" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;APERTURA DE MERCADO VIRTUAL</td>
    </tr>
    <tr>
      <td><img src="../../images/blank.gif" width="20" height="5"></td>
    </tr>
    <tr>
      <td height="25" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="center"><a href="apertura/index.php"><img src="../../images/bton_add.gif" width="35" height="31">Aperturar Nuevo Mercado Virtual</a></td>
    </tr>
    <tr>
      <td height="25">&nbsp;</td>
    </tr>
    <?php if ($cantRS>0){ ?>
    <tr>
      <td height="25">
      <table width="95%" class="TablaRojaGrid" align="center">
      <thead>
        <tr class="TablaRojaGridTRTitulo">
          <th width="30" align="center" scope="col">ID.</th>
          <th width="100" align="center" scope="col">INICIO<br>
            SOLICITUD</th>
          <th width="100" align="center" scope="col">FIN<br>
            SOLICITUD</th>
          <th width="100" align="center" scope="col">DIA DEL<br>
            MERCADO</th>
          <th scope="col" align="center">EMPRESA</th>
          <th width="80" align="center" scope="col">PRODUCTOS</th>
          <th width="60" align="center" scope="col">ACTIVO</th>
          <th width="60" align="center" scope="col">EDITAR</th>
          <th width="60" align="center" scope="col">BORRAR</th>
        </tr>
	  </thead>
      <tbody>
	<?php
    	for($i=0; $i<$cantRS; $i++){
			$NU_IdMercado 	= $objConexion->obtenerElemento($RS,$i,'NU_IdMercado');
			$AF_RazonSocial	= $objConexion->obtenerElemento($RS,$i,'AF_RazonSocial');			
			$FE_FechaMercado 		= $objConexion->obtenerElemento($RS,$i,'FE_FechaMercado');			
			$FE_Inicio 		= $objConexion->obtenerElemento($RS,$i,'FE_Inicio');
			$FE_Fin 		= $objConexion->obtenerElemento($RS,$i,'FE_Fin');			
			$producto 		= $objConexion->obtenerElemento($RS,$i,'producto');
			$NU_Activo 		= $objConexion->obtenerElemento($RS,$i,'NU_Activo');

	////////////// ACTUALIZAR MERCADOS ACTIVOS Y DESACTIVADOS /////////
			$objMercado->actualizarActivo($objConexion,$NU_IdMercado,$FE_Inicio,$FE_Fin);
	///////////////////////////////////////////////////////////////////						
    ?>
        <tr>
          <td align="center" class="TablaRojaGridTD"><?php echo $NU_IdMercado; ?></td>
          <td align="center" class="TablaRojaGridTD"><?php echo setFechaNoSQL($FE_Inicio); ?></td>
          <td align="center" class="TablaRojaGridTD"><?php echo setFechaNoSQL($FE_Fin); ?></td>
          <td align="center" class="TablaRojaGridTD"><?php echo setFechaNoSQL($FE_FechaMercado); ?></td>
          <td align="left" class="TablaRojaGridTD"><?php echo $AF_RazonSocial; ?></td>
          <td align="center" class="TablaRojaGridTD"><?php echo $producto; ?></td>
          <td align="center" class="TablaRojaGridTD"><?php if ($NU_Activo==1){ echo 'Si'; }else{ echo 'No'; } ?></td>
          <td align="center" class="TablaRojaGridTD">
          	<a href="index.php?mensaje='En Construccion'">
            <img src="../../images/bton_edit.gif" width="35" height="31"></a>
          </td>
          <td align="center" class="TablaRojaGridTD">
          	<a href="index.php?mensaje='En Construccion'">
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
  </table>
</body>
</html>