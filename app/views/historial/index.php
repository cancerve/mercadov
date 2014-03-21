<?php 
require_once('../../controller/sessionController.php'); 
require_once('../../model/pedidoModel.php');

$objPedido = new Pedido();

$RS 	= $objPedido->listarPedidoIndiv($objConexion,$_SESSION["NU_IdUsuario"]);
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
      <td height="25" align="left" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MIS COMPRAS</td>
    </tr>
    <tr>
      <td><img src="../../images/blank.gif" width="20" height="5"></td>
    </tr>
    <tr>
      <td height="25" align="center">&nbsp;</td>
    </tr>
    <?php if ($cantRS>0){ ?>
    <tr>
      <td height="25">
      <table width="95%" class="TablaRojaGrid" align="center">
      <thead>
        <tr class="TablaRojaGridTRTitulo">
          <th width="100" align="center" scope="col">DIA DEL<br>
            MERCADO</th>
          <th width="100" align="center" scope="col">NRO.<br>
            MERCADO</th>
          <th width="100" align="center" scope="col">            ORDEN DE<br>
            COMPRA</th>
          <th width="100" align="center" scope="col">CANTIDAD<br>
            PRODUCTOS</th>
          <th width="100" align="center" scope="col">MONTO<br>
            BRUTO</th>
          <th width="100" align="center" scope="col">NOTA DE<br>
            CREDITO</th>
          <th width="100" align="center" scope="col">MONTO A<br>
            PAGAR</th>
          <th width="60" align="center" scope="col">EDITAR</th>
          <!--<th width="60" align="center" scope="col">BORRAR</th>-->
        </tr>
	  </thead>
      <tbody>
	<?php
    	for($i=0; $i<$cantRS; $i++){
			$FE_FechaMercado 	= $objConexion->obtenerElemento($RS,$i,'FE_FechaMercado');
			$mercado_NU_IdMercado	= $objConexion->obtenerElemento($RS,$i,'mercado_NU_IdMercado');			
			$NU_IdPedido 		= $objConexion->obtenerElemento($RS,$i,'NU_IdPedido');			
			$CantProductos 		= $objConexion->obtenerElemento($RS,$i,'CantProductos');
			$MontoBruto 		= $objConexion->obtenerElemento($RS,$i,'MontoBruto');			
			$BS_NotaCredito		= $objConexion->obtenerElemento($RS,$i,'BS_NotaCredito');
			$MontoPagar 		= $MontoBruto - $BS_NotaCredito;
    ?>
        <tr>
          <td align="center" class="TablaRojaGridTD"><?php echo setFechaNoSQL($FE_FechaMercado); ?></td>
          <td align="center" class="TablaRojaGridTD"><?='DGRH-GBS-M0'.$mercado_NU_IdMercado?></td>
          <td align="center" class="TablaRojaGridTD"><?=$NU_IdPedido?></td>
          <td align="center" class="TablaRojaGridTD"><?=$CantProductos?></td>
          <td align="right" class="TablaRojaGridTD"><?=$MontoBruto.' BsF.'?></td>
          <td align="right" class="TablaRojaGridTD"><?=$BS_NotaCredito.' BsF.'?></td>
          <td align="right" class="TablaRojaGridTD"><?=$MontoPagar.' BsF.'?></td>
          <td align="center" class="TablaRojaGridTD">
            <a href="edit.php?NU_IdPedido=<?=$NU_IdPedido?>">
              <img src="../../images/bton_edit.gif" width="35" height="31"></a>
          </td>
          <!--<td align="center" class="TablaRojaGridTD">
          	<a href="index.php?mensaje='En Construccion'">
            <img src="../../images/bton_del.gif" width="35" height="31"></a>
          </td>-->
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