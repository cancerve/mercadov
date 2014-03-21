<?php 
require_once('../../../controller/sessionController.php'); 
require_once('../../../model/paisModel.php'); 
require_once('../../../includes/hacerlista.php');

$objPais = new Pais();
?>
<html>
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<link rel="stylesheet" type="text/css" href="../../../css/estilo.css">
<link rel="stylesheet" href="../../../css/jquery-ui.css" />
<link rel="stylesheet" href="../../../css/jquery.treeview.css" />


<script type="text/javascript" src="../../../js/jquery.js"></script>
<script type="text/javascript" src="../../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../../js/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="../../../js/funciones.js"></script>
<script type="text/javascript" src="../../../js/select_dependientes.js"></script>
<script type="text/javascript" src="../../../js/jquery.treeview.js"></script>
<script type="text/javascript" src="../../../js/demo.js"></script>
<script type="text/javascript" src="../../../js/validar.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EVENTO - Agregar Nuevo Registro</td>
    </tr>
  </table>
  <br>
  <div id="tabs" style="width:730; margin-left:10px" align="center">
  <ul>
    <li><a href="#tabs-1">Datos Evento</a></li>
    <li><a href="#tabs-2">Cronograma del Evento</a></li>    
    <li><a href="#tabs-3">Paises Participantes</a></li>
    <li><a href="#tabs-4">Codigo Arancelario</a></li>
  </ul>
  <form name="form1" id="form1" method="post" action="../../../controller/eventoController.php">
  <div id="tabs-1">
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="">
      <tr>
        <td bordercolor="#F8F8F8">
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="Textonegro">
            <tr>
              <td colspan="2" class="BlancoGris">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Llene el formulario para Agregar un nuevo Evento</td>
            </tr>
            <tr>
              <td colspan="2" class="BlancoGrisClaro">&nbsp;Todos los campos con asteriscos (<span class="Rojita">&nbsp;*&nbsp;</span>) son de car&aacute;cter obligatorio.</td>
            </tr>
            <tr>
              <td width="27%" class="Textonegro">&nbsp;</td>
              <td width="73%">&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td>pais_AL_CodPais:</td>
              <td>
              <select name="pais_AL_CodPais" id="pais_AL_CodPais" onChange="cargaContenido(this.id)">
                <option selected="selected">[ Seleccione ]</option>
				<?php 
					$rsPais=$objPais->listar($objConexion);
					$objConexion->cantidadRegistros($rsPais)>0;
					for($i=0;$i<$objConexion->cantidadRegistros($rsPais);$i++){
						  $value=$objConexion->obtenerElemento($rsPais,$i,"AL_CodPais");
						  $des=$objConexion->obtenerElemento($rsPais,$i,"AL_Pais");
						  echo "<option value=".$value.">".$des."</option>";
					}  
				?>               
              </select>
                      
               </td>
            </tr>
            <tr valign="baseline">
              <td>ciudad_AF_CodCiudad:</td>
              <td>
              <select id="ciudad_AF_CodCiudad" name="ciudad_AF_CodCiudad" disabled="disabled">
                	<option value="0" >[ Seleccione ]</option>
              </select></td>
            </tr>
            <tr valign="baseline">
              <td>AF_Nombre_Evento:</td>
              <td><input type="text" name="AF_Nombre_Evento" id="AF_Nombre_Evento" value="" size="32" required></td>
            </tr>
            <tr valign="baseline">
              <td valign="top">AF_Lugar:</td>
              <td ><textarea name="AF_Lugar" id="AF_Lugar" cols="50" rows="5"></textarea></td>
            </tr>
            <tr valign="baseline">
              <td>NU_Cantidad_Mesa:</td>
              <td><input type="number" name="NU_Cantidad_Mesa" id="NU_Cantidad_Mesa" value="" size="32" style="width:212px">
                <input name="BI_Activo" type="hidden" id="BI_Activo" value="1"></td>
            </tr>
          </table>
        </td>
      </tr>
</table>
</div>
<div id="tabs-2">
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="Textonegro">
    <tr>
      <td width="710" class="BlancoGris">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Llene el formulario con los intervalos en dias, de cada Fase segun el Cronograma del Evento</td>
    </tr>
    <tr>
      <td class="BlancoGrisClaro">&nbsp;Todos los campos con asteriscos (<span class="Rojita">&nbsp;*&nbsp;</span>) son de car&aacute;cter obligatorio.</td>
    </tr>
    <tr>
      <td class="Textonegro">&nbsp;</td>
      </tr>
    <tr>
      <td class="Textonegro">
      <table width="100%" class="TablaRojaGrid">
        <tr class="TablaRojaGridTRTitulo">
          <td>Fecha Desde: </td>
          <td>Fecha Hasta: </td>
          <td>Descripci&oacute;n de la Fase</td>
        </tr>
        <tr class="Textonegro">
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="Textonegro">
          <td align="center"><input type="text" name="F1_FechaDesde" value="" size="32" id="F1_FechaDesde" style="width:100px" ></td>
          <td align="center"><input type="text" name="F1_FechaHasta" value="" size="32" id="F1_FechaHasta" style="width:100px" ></td>
          <td>Contactar Oficinas Comerciales y Registrar Empresas</td>
        </tr>
        <tr  class="Textonegro">
          <td align="center"><input type="text" name="F2_FechaDesde" value="" size="32" id="F2_FechaDesde" style="width:100px" ></td>
          <td align="center"><input type="text" name="F2_FechaHasta" value="" size="32" id="F2_FechaHasta" style="width:100px" ></td>
          <td>Contactar Empresas</td>
        </tr>
        <tr  class="Textonegro">
          <td align="center"><input type="text" name="F3_FechaDesde" value="" size="32" id="F3_FechaDesde" style="width:100px" ></td>
          <td align="center"><input type="text" name="F3_FechaHasta" value="" size="32" id="F3_FechaHasta" style="width:100px" ></td>
          <td>Postular Empresas</td>
        </tr>
        <tr  class="Textonegro">
          <td align="center"><input type="text" name="F4_FechaDesde" value="" size="32" id="F4_FechaDesde" style="width:100px" ></td>
          <td align="center"><input type="text" name="F4_FechaHasta" value="" size="32" id="F4_FechaHasta" style="width:100px" ></td>
          <td>Seleccionar Empresas (Comite de Seleccion)</td>
        </tr>
        <tr  class="Textonegro">
          <td align="center"><input type="text" name="F5_FechaDesde" value="" size="32" id="F5_FechaDesde" style="width:100px" ></td>
          <td align="center"><input type="text" name="F5_FechaHasta" value="" size="32" id="F5_FechaHasta" style="width:100px" ></td>
          <td>Confirmar Participaci&oacute;n, Pago y Agendaci&oacute;n de Citas de Negocio</td>
        </tr>
        <tr  class="Textonegro">
          <td align="center"><input type="text" name="FE_Fecha_Desde" value="" size="32" id="FE_Fecha_Desde" style="width:100px"></td>
          <td align="center"><input type="text" name="FE_Fecha_Hasta" value="" size="32" id="FE_Fecha_Hasta"style="width:100px" ></td>
          <td>Realizaci&oacute;n del Evento</td>
        </tr>
        <tr  class="Textonegro">
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        </table></td>
    </tr>
  </table>
</div>
<div id="tabs-3">
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="Textonegro">
            <tr>
              <td colspan="2" class="BlancoGris">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Llene el formulario para Agregar un nuevo Evento</td>
            </tr>
            <tr>
              <td colspan="2" class="BlancoGrisClaro">&nbsp;Todos los campos con asteriscos (<span class="Rojita">&nbsp;*&nbsp;</span>) son de car&aacute;cter obligatorio.</td>
            </tr>
  <tr>
    <td width="27%" class="Textonegro">&nbsp;</td>
    <td width="73%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="Textonegro"><?php echo hacerlistaPaises(); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="Textonegro">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="Textonegro">&nbsp;</td>
  </tr>
</table>
</div>
<div id="tabs-4">
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="Textonegro">
            <tr>
              <td colspan="2" class="BlancoGris">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Llene el formulario para Agregar un nuevo Evento</td>
            </tr>
        <tr>
              <td colspan="2" class="BlancoGrisClaro">&nbsp;Todos los campos con asteriscos (<span class="Rojita">&nbsp;*&nbsp;</span>) son de car&aacute;cter obligatorio.</td>
        </tr>
  <tr>
    <td width="27%" class="Textonegro">&nbsp;</td>
    <td width="73%">&nbsp;</td>
  </tr>              
  <tr>
    <td colspan="2" class="Textonegro"><?php echo hacerlistaCodArancel(0); ?>
      </td>
  </tr>
  <tr>
    <td colspan="2" class="Textonegro">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="Textonegro" align="right">
    <input name="Evento" type="submit" class="BotonRojo"  value="[ Guardar ]" id="Evento" onclick="javascript:validarAddEvento()">
      <input name="button2" type="button" class="BotonRojo" id="button2" value="[ Cancelar ]" onClick="javascript:window.location='index.php'" />
      <input type="hidden" name="origen" value="Evento" id="origen"></td>
  </tr>
  <tr>
    <td colspan="2" class="Textonegro">&nbsp;</td>
  </tr>
</table>
</div>
</form>
</div>
</table>
</body>
</html>
