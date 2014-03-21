<?php 
	require_once('../../../controller/sessionController.php'); 
	require_once('../../../model/empresaModel.php'); 
	require_once('../../../model/productoModel.php'); 	

	$objEmpresa 	= new Empresa();
	$objProducto 	= new Producto();	
?>
<html>
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<link rel="stylesheet" href="../../../css/jquery-ui.css" />
<link rel="stylesheet" href="../../../css/jquery.treeview.css" />
<link rel="stylesheet" type="text/css" href="../../../css/estilo.css">
<script type="text/javascript" src="../../../js/jquery.js"></script>
<script type="text/javascript" src="../../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../../js/funciones.js"></script>
<script type="text/javascript" src="../../../js/select_dependientes.js"></script>
<script type="text/javascript" src="../../../js/jquery.treeview.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body onLoad="cargaContenido('pais_AL_CodPais',<?=$ciudad_AF_CodCiudad?>)">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;APERTURA DE MERCADO</td>
    </tr>
  </table>
  <br>
  <div id="tabs" style="width:920; margin-left:10px" align="center">
  <ul>
    <li><a href="#tabs-1" class="Negrita">Datos Generales</a></li>
  </ul>
  <form name="form1" id="form1" method="post" action="../../../controller/mercadoController.php">
  <div id="tabs-1">
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bordercolor="#F8F8F8">
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="Textonegro">
            <tr>
              <td colspan="4" align="left" class="BlancoGris">&nbsp;&nbsp;&nbsp;Llene el formulario para Aperturar un Mercado Virtual para una Empresa</td>
            </tr>
            <tr>
              <td colspan="4" align="left" class="BlancoGrisClaro">&nbsp;&nbsp;&nbsp;Todos los campos con asteriscos (<span class="Rojita">&nbsp;*&nbsp;</span>) son de car&aacute;cter obligatorio.</td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">Destinado a la Empresa:</td>
              <td align="left">
              <select name="empresa_NU_IdEmpresa" required id="empresa_NU_IdEmpresa">
                <option selected="selected">[ Seleccione ]</option>
                <?php 
					$rsEmpresa=$objEmpresa->listarEmpresa($objConexion);
					for($i=0;$i<$objConexion->cantidadRegistros($rsEmpresa);$i++){
						  $value=$objConexion->obtenerElemento($rsEmpresa,$i,"NU_IdEmpresa");
						  $des=$objConexion->obtenerElemento($rsEmpresa,$i,"AF_RazonSocial");
						  $selected="";
/*						  if($pais_AL_CodPais==$value){
							  $selected="selected='selected'";
						  }*/
						  echo "<option value=".$value." ".$selected.">".$des."</option>";
					}  
				?>
              </select></td>
              <td align="right">Solicitudes del Mercado Inician:</td>
              <td align="left"><input name="FE_Inicio" type="text" id="FE_Inicio" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Realización del Mercado:</td>
              <td align="left"><input name="FE_FechaNac1" type="text" id="FE_FechaNac1" size="32" /></td>
              <td align="right">Solicitudes del Mercado Finalizan:</td>
              <td align="left"><input name="FE_Fin" type="text" id="FE_Fin" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" align="left" class="BlancoGris">&nbsp;&nbsp;&nbsp;Seleccione los productos que estaran disponibles en este Mercado Virtual</td>
            </tr>
            <tr valign="baseline">
              <td colspan="4" align="left" nowrap="nowrap">
                <table width="100%" border="0" cellspacing="0" cellpadding="2" class="Textonegro">
                  <?php 
					$k=0;
					$rsProducto		= $objProducto->listarProducto($objConexion);
					$cantProducto	= $objConexion->cantidadRegistros($rsProducto);
					for($i=0;$i<$cantProducto;$i++){
						  $NU_IdProducto		= $objConexion->obtenerElemento($rsProducto,$i,"NU_IdProducto");						
						  $AF_NombreProducto	= $objConexion->obtenerElemento($rsProducto,$i,"AF_NombreProducto");
						  $AL_Medida			= $objConexion->obtenerElemento($rsProducto,$i,"AL_Medida");
						  $NU_Contenido			= $objConexion->obtenerElemento($rsProducto,$i,"NU_Contenido");
						  $BS_PrecioUnitario	= $objConexion->obtenerElemento($rsProducto,$i,"BS_PrecioUnitario");

						if ($k==0){ echo '<tr>'; }
				?>
                  <td width="3" align="left" valign="middle">
                  <input type="checkbox" name="<?php echo 'chk'.$i; ?>" id="<?php echo 'chk'.$i; ?>" value="<?php echo $NU_IdProducto; ?>">
                  </td>
                    <td align="left" valign="middle"><b><?php echo $AF_NombreProducto; ?></b><br><?php echo $NU_Contenido.' '.$AL_Medida.' = '.$BS_PrecioUnitario.' BsF.';?></td>
                    <?php $k++; ?>
                    <?php 
						if ($k==3){ echo '</tr>'; $k=0; }
					}  ?>              
                  </table>
                
                </td>
            </tr>
            <tr valign="baseline">
              <td colspan="4" align="right" nowrap="nowrap"><span class="Textonegro" style="text-align:center">
                <input name="Evento" type="submit" class="BotonRojo"  value="[ Aperturar ]" id="Evento">
                <input name="button2" type="button" class="BotonRojo" id="button2" value="[ Cancelar ]" onClick="javascript:window.location='../centralView.php'" />
                <input name="origen" type="hidden" id="origen" value="apertura_mercado">
                <input name="cantProducto" type="hidden" id="cantProducto" value="<?php echo $cantProducto; ?>">
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