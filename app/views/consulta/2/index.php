<?php 
require_once('../../../controller/sessionController.php'); 
require_once('../../../model/mercadoModel.php');
require_once('../../../model/descuentoNModel.php');

$objMercado 	= new Mercado();
$objDescuentoN 	= new DescuentoN();

$RS 		= $objDescuentoN->listarDescuentoN2($objConexion);
$cantRS 	= $objConexion->cantidadRegistros($RS);


	///// CONVIERTE FECHA 04/07/1980 A 1980-07-04 (FORMATO MYSQL)
	function setFechaNoSQL($FE_FechaNac)
	{
		$partes = explode("-", $FE_FechaNac);
		$FE_FechaNac = $partes[2].'/'.$partes[1].'/'.$partes[0];
		return $FE_FechaNac;
	}
	//////////////////////////////////////////////////////////////
		///////////// CONVERTIR DECIMALES A ESPANOL ///////////
	function setDecimalEsp($numero){
		$numero = str_replace(".", ",", $numero);
		return $numero;
	}
?>
<html>
<link rel="stylesheet" type="text/css" href="../../../css/estilo.css">
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<script type="text/javascript" src="../../../js/mensajes.js"></script>	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../../../css/jquery-ui.css" />
<script type="text/javascript" src="../../../js/jquery.js"></script>
<script type="text/javascript" src="../../../js/jquery-ui.js"></script>
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
      <td height="25" align="left" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CONSULTAS / CONSOLIDADO DE DESCUESTO MERCADO OBRERO</td>
    </tr>
    <tr>
      <td><img src="../../../images/blank.gif" width="20" height="5"></td>
    </tr>
    <tr>
      <td height="25" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="center"><form name="form1" method="post" action="../../../controller/descuentoNController.php">
        <table width="430" border="0" cellspacing="2" cellpadding="2" class="Textonegro">
          <tr>
            <td colspan="2" align="left">Escoja el Mercado al cual desea crearle el Consolidado de Descuento:
              <input name="origen" type="hidden" id="origen" value="descuento_nomina"></td>
          </tr>
          <tr>
            <td align="left"><select name="mercado_NU_IdMercado" required id="mercado_NU_IdMercado">
              <option selected="selected">[ Seleccione ]</option>
              <?php 
					$RSMercado 		= $objMercado->listarMercado($objConexion);
					$cantRSMercado 	= $objConexion->cantidadRegistros($RSMercado);
					for($i=0;$i<$cantRSMercado;$i++){
						  $value=$objConexion->obtenerElemento($RSMercado,$i,"NU_IdMercado");
						  $des = 'DGRH-GBS-M0';
						  $des.=$objConexion->obtenerElemento($RSMercado,$i,"NU_IdMercado");
						  $selected="";

						  echo "<option value=".$value." ".$selected.">".$des."</option>";
					}  
				?>
            </select></td>
            <td align="center"><input type="submit" name="button" id="button" value="[ Crear ]" class="BotonRojo"></td>
          </tr>
        </table>
      </form></td>
    </tr>
    <tr>
      <td height="25">&nbsp;</td>
    </tr>
    <?php 
	//$NU_IdSolicitudInventario 	= $objConexion->obtenerElemento($RS,0,'NU_IdSolicitudInventario');
	if ($cantRS>0){ ?>
    <tr>
      <td height="25">
      <table width="772" class="TablaRojaGrid" align="center">
      <thead>
        <tr class="TablaRojaGridTRTitulo">
          <th width="100" align="center" scope="col">NRO. CONSOLIDADO DE DESCUENTO</th>
          <th width="100" align="center" scope="col">NRO. <br>
            MERCADO</th>
          <th width="100" align="center" scope="col">FECHA DEL<br>
            MERCADO</th>
          <th width="100" align="center" scope="col">TOTAL<br>
            MONTO BRUTO</th>
          <th width="100" align="center" scope="col">TOTAL
            NOTAS DE CRÉDITO</th>
          <th width="100" align="center" scope="col">TOTAL A<br>
            DESCONTAR</th>
          <th width="60" align="center" scope="col">VER</th>
          <th width="60" align="center" scope="col">BORRAR</th>
        </tr>
	  </thead>
      <tbody>
	<?php
    	for($i=0; $i<$cantRS; $i++){
			$NU_IdDescuento 		= $objConexion->obtenerElemento($RS,$i,'NU_IdDescuento');
			$mercado_NU_IdMercado	= $objConexion->obtenerElemento($RS,$i,'mercado_NU_IdMercado');			
			$FE_FechaMercado		= $objConexion->obtenerElemento($RS,$i,'FE_FechaMercado');			
			$MontoBruto 			= $objConexion->obtenerElemento($RS,$i,'MontoBruto');
			$NotaCredito 			= $objConexion->obtenerElemento($RS,$i,'NotaCredito');
			$totalDescontar			= $MontoBruto - $NotaCredito;
					
    ?>
        <tr>
          <td align="center" class="TablaRojaGridTD"><?php echo '0'.$NU_IdDescuento; ?></td>
          <td align="center" class="TablaRojaGridTD"><?php echo 'DGRH-GBS-M0'.$mercado_NU_IdMercado; ?></td>
          <td align="center" class="TablaRojaGridTD"><?php echo setFechaNoSQL($FE_FechaMercado); ?></td>
          <td align="center" class="TablaRojaGridTD"><?php echo number_format($MontoBruto,2,',','.').' Bsf.'; ?></td>
          <td align="right" class="TablaRojaGridTD"><?php echo number_format($NotaCredito,2,',','.').' Bsf.'; ?></td>
          <td align="right" class="TablaRojaGridTD"><?php echo number_format($totalDescontar,2,',','.').' Bsf.'; ?></td>
          <td align="center" class="TablaRojaGridTD"><a href="documento.php?NU_IdDescuento=<?=$NU_IdDescuento?>" target="_blank"><img src="../../../images/bton_ver.gif" width="31" height="31"></a></td>
          <td align="center" class="TablaRojaGridTD">
            <a href="index.php?mensaje='En Construccion'">
              <img src="../../../images/bton_del.gif" width="35" height="31"></a>
          </td>
        </tr>
	<?php
	    }
    ?>          
        </tbody>
      </table>
	<?php
	    }
    ?>       
      </td>
    </tr>
    <tr>
      <td height="25">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="center"><input name="button2" type="button" class="BotonRojo" id="button2" value="[ Atrás ]" onClick="javascript:window.location='../index.php'" /></td>
    </tr>
  </table>
</body>
</html>