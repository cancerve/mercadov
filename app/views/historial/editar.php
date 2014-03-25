<?php 
	require_once('../../controller/sessionController.php'); 
	require_once('../../model/mercadoProductoModel.php'); 	
	require_once('../../model/pedidoModel.php'); 		
	require_once('../../model/pedidoDetalleModel.php'); 			

	$objMercadoProducto	= new MercadoProducto();
	$objPedido	 		= new Pedido();	
	$objpedidoDetalle	= new PedidoDetalle();
	
	$NU_IdPedido = $_GET['NU_IdPedido'];

	$RSPedido 		= $objPedido->buscar($objConexion,$NU_IdPedido);
	
	$NU_IdMercado		= $objConexion->obtenerElemento($RSPedido,0,"mercado_NU_IdMercado");
	$AL_AutorizoNombre	= $objConexion->obtenerElemento($RSPedido,0,"AL_AutorizoNombre");	
	$AL_AutorizoCedula	= $objConexion->obtenerElemento($RSPedido,0,"AL_AutorizoCedula");
?>

<html><head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<link rel="stylesheet" href="../../css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="../../css/estilo.css">
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/funciones.js"></script>
<script>
$(document).ready(function() {
	
	var default_message_for_dialog='<p align="center"><b>LISTA DE PRODUCTOS </b></p>';
	//var default_message_for_dialog = nombre;
	
	$("#dialog").dialog({
 	    show: "blind",
	    hide: "explode",		
		modal: true,
		bgiframe: true,
		width: 320,
		height: 460,
		autoOpen: false,
		title: 'Confirme su Compra'
		});

	// FORMS
	$('input.confirm').click(function(theINPUT){
		theINPUT.preventDefault();
		var precio = 0;
		var cantidad = 0;
		var valor = 0;
		var indice = 0;
		var total = 0;
		var res2 = '';
		default_message_for_dialog += '<p align="left">';
<?php 
	$rsMercadoProducto2		= $objMercadoProducto->listarMercadoProducto($objConexion,$NU_IdMercado);
	$cantMercadoProducto2	= $objConexion->cantidadRegistros($rsMercadoProducto2);
	
	for($a=0;$a<$cantMercadoProducto2;$a++){
?>
		indice = document.form.NU_Cantidad<?=$a?>.selectedIndex;
		cantidad = document.form.NU_Cantidad<?=$a?>.options[indice].value;
		
		if (cantidad!=0){
<?php			
			$AF_NombreProducto2	= $objConexion->obtenerElemento($rsMercadoProducto2,$a,"AF_NombreProducto");	
			$BS_PrecioUnitario2	= $objConexion->obtenerElemento($rsMercadoProducto2,$a,"BS_PrecioUnitario");
?>

			precio = cantidad * parseFloat(<?=$BS_PrecioUnitario2?>);
			precio = ''+precio+'';
			res2 = precio.replace(".",",");			
			default_message_for_dialog += '- '+'(<b>'+cantidad+'</b>) <?=$AF_NombreProducto2?> = <b>'+res2+' Bsf.</b> </br>';
			
			total = parseFloat(total) + parseFloat(precio);
		}
<?php
		
	} 
?>
		default_message_for_dialog += '</p>';
		
		var total = ''+total+'';
		//var totalres = total.toFixed(3);
		var res = total.replace(".",",");
		

		default_message_for_dialog +='<b>TOTAL A PAGAR = '+res+' BsF.</b></br></br>';
		default_message_for_dialog +='<b style="color:#F00">Si confirma esta compra, estará aceptando que el monto total a pagar sea descontado de su próxima quincena.</b>';
				
		var theFORM = $(theINPUT.target).closest("form");
		var theREL = $(this).attr("rel");
		var theMESSAGE = (theREL == undefined || theREL == '') ? default_message_for_dialog : theREL;
		var theICON = '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span>';
		
		$('#dialog').html('<P align="left">' + theICON + theMESSAGE + '</P>');
		$("#dialog").dialog('option', 'buttons', {
                "Confirmar" : function() {
					theFORM.submit();
                    },
                "Cancelar" : function() {
					default_message_for_dialog = 'Lista de Productos: </br></br>';
                    $(this).dialog("close");
                    }
                });
		$("#dialog").dialog("open");
		});

});
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<div id="dialog"></div>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EDITAR ESTA ORDEN DE COMPRA</td>
    </tr>
  </table>
  <br>
  <div id="tabs" style="width:920; margin-left:10px" align="center">
  <ul>
    <li><a href="#tabs-1" class="Negrita">Datos Generales</a></li>
  </ul>
  <form name="form" id="form" method="post" action="../../controller/pedidoController.php">
  <div id="tabs-1">
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bordercolor="#F8F8F8">
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="Textonegro">
            <tr>
              <td colspan="4" align="left">
                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="BlancoGris" align="left">&nbsp;&nbsp;&nbsp;Modifique las cantidades de los productos a comprar</td>
                    </tr>
                </table></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td colspan="4" align="left" nowrap="nowrap">
                <table width="100%" border="0" cellspacing="0" cellpadding="2" class="Textonegro">
                  <?php 
					$k=0;
					$rsMercadoProducto		= $objMercadoProducto->listarMercadoProducto($objConexion,$NU_IdMercado);
					$cantMercadoProducto	= $objConexion->cantidadRegistros($rsMercadoProducto);
					
					for($i=0;$i<$cantMercadoProducto;$i++){
						$NU_IdProducto		= $objConexion->obtenerElemento($rsMercadoProducto,$i,"NU_IdProducto");						
						$AF_NombreProducto	= $objConexion->obtenerElemento($rsMercadoProducto,$i,"AF_NombreProducto");
						$AL_Medida			= $objConexion->obtenerElemento($rsMercadoProducto,$i,"AL_Medida");
						$NU_Contenido		= number_format($objConexion->obtenerElemento($rsMercadoProducto,$i,"NU_Contenido"),3,',','.');
						$BS_PrecioUnitario	= $objConexion->obtenerElemento($rsMercadoProducto,$i,"BS_PrecioUnitario");
						$NU_Max				= $objConexion->obtenerElemento($rsMercadoProducto,$i,"NU_Max");
						$NU_Min				= $objConexion->obtenerElemento($rsMercadoProducto,$i,"NU_Min");						  
						$NU_Salto			= $objConexion->obtenerElemento($rsMercadoProducto,$i,"NU_Salto");						  
						$AF_Foto			= $objConexion->obtenerElemento($rsMercadoProducto,$i,"AF_Foto");
						  
						if ($k==0){ echo '<tr>'; } 
				?>
                    <td width="240" align="left" valign="middle">
                  	  <img src="../../images/producto/<?php if ($AF_Foto==''){ echo 'sin_imagen.jpg'; }else{ echo $AF_Foto; } ?>" width="124" height="85"  alt="" style="border:solid 1px #EFEFEF"/>
                    </td>
                    <td width="664" align="left" valign="middle"><b><?php echo $AF_NombreProducto; ?></b><br><?php echo 'Contenido: '.$NU_Contenido.' '.$AL_Medida;?><br><?php echo 'Precio: '.number_format($BS_PrecioUnitario,2,',','.').' BsF'; ?><br>
                    
                    
                    <?php
                    	$RSPedidoDetalle	= $objpedidoDetalle->buscarProducPedido($objConexion,$NU_IdPedido,$NU_IdProducto);
						$cantPedidoDetalle	= $objConexion->CantidadRegistros($RSPedidoDetalle);
						
						if ($cantPedidoDetalle>0){
							$NU_Cantidad 		= $objConexion->obtenerElemento($RSPedidoDetalle,0,"NU_Cantidad");
							$NU_IdPedidoDetalle = $objConexion->obtenerElemento($RSPedidoDetalle,0,"NU_IdPedidoDetalle");			
						}else{
							$NU_Cantidad 		= '';
							$NU_IdPedidoDetalle = '';
						}
					?>
                    
                      <select name="<?php echo 'NU_Cantidad'.$i; ?>" id="<?php echo 'NU_Cantidad'.$i; ?>" style="width:50px">
                        <option selected="selected" value=""> </option>
                        <?php for ($j=$NU_Min; $j<=$NU_Max; $j=$j+$NU_Salto){ ?>
                        	<option <?php if ($NU_Cantidad==$j){ echo 'selected="selected"'; } ?> value="<?php echo $j; ?>"><?php echo $j; ?></option>
                      	<?php } ?>
                      </select>
                      <input name="<?php echo 'NU_IdProducto'.$i; ?>" type="hidden" id="<?php echo 'NU_IdProducto'.$i; ?>" value="<?php echo $NU_IdProducto; ?>">
                      <input  name="<?php echo 'BS_PrecioUnitario'.$i; ?>" type="hidden" id="<?php echo 'BS_PrecioUnitario'.$i; ?>" value="<?php echo number_format($BS_PrecioUnitario,2,'.',','); ?>">
                      <input name="<?php echo 'NU_Max'.$i; ?>" type="hidden" id="<?php echo 'NU_Max'.$i; ?>" value="<?=$NU_Max?>">
                      <input name="<?php echo 'NU_IdPedidoDetalle'.$i; ?>" type="hidden" id="<?php echo 'NU_IdPedidoDetalle'.$i; ?>" value="<?=$NU_IdPedidoDetalle?>"></td>
                    <?php $k++; ?>
                    <?php 
						if ($k==3){ echo '</tr>'; $k=0; }
					}  ?>              
                  </table>
                </td>
            </tr>
            <tr valign="baseline">
              <td colspan="4" align="left">
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="BlancoGris" align="left">&nbsp;&nbsp;&nbsp;Si usted desea autorizar a otra persona con el fin de retirar su compra, llene el siguiente formulario</td>
                    </tr>
                </table></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">Nombre y Apellido de quién Retira:</td>
              <td align="left" nowrap="nowrap"><input name="AL_AutorizoNombre" type="text" id="AL_AutorizoNombre" value="<?=$AL_AutorizoNombre?>"></td>
              <td align="right" nowrap="nowrap">Cédula de Identidad de quién Retira:</td>
              <td align="left" nowrap="nowrap"><input name="AL_AutorizoCedula" type="number" id="AL_AutorizoCedula" value="<?=$AL_AutorizoCedula?>"></td>
            </tr>
            <tr valign="baseline">
              <td colspan="4" align="right" nowrap="nowrap">&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td colspan="4" align="right" nowrap="nowrap"><span class="Textonegro" style="text-align:center">
                <input name="Comprar" type="submit" class="confirm"  value="[ Guardar ]" id="Comprar">
                <input name="button2" type="button" class="BotonRojo" id="button2" value="[ Cancelar ]" onClick="javascript:window.location='../centralView.php'" />
                <input name="origen" type="hidden" id="origen" value="pedido_edit">
                <input name="cantProducto" type="hidden" id="cantProducto" value="<?php echo $cantMercadoProducto; ?>">
                <input name="NU_IdPedido" type="hidden" id="NU_IdPedido" value="<?php echo $NU_IdPedido; ?>">
              </span></td>
            </tr>
            </table>
        </td>
      </tr>
</table>
</div>
</form>
</div>
</body>
</html>