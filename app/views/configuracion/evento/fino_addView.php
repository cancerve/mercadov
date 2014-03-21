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
<link rel="stylesheet" type="text/css" href="../../../css/style.css">


<script type="text/javascript" src="../../../js/jquery.js"></script>
<script type="text/javascript" src="../../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../../js/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="../../../js/funciones.js"></script>
<script type="text/javascript" src="../../../js/select_dependientes.js"></script>
<script type="text/javascript" src="../../../js/jquery.treeview.js"></script>
<script type="text/javascript" src="../../../js/demo.js"></script>
<script type="text/javascript" src="../../../js/sliding.form.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EVENTO - Agregar Nuevo Registro</td>
    </tr>
  </table>
  <div id="content">
            <div id="wrapper">
                <div id="steps">
  <form name="form1" id="form1" method="post" action="../../../controller/eventoController.php" enctype="multipart/form-data">                
                        <fieldset class="step">
                            <legend>Datos </legend>
                            <table width="100%" border="0" cellpadding="2" cellspacing="2" class="Textonegro">
                              <tr bgcolor="#CCCCCC">
                                <td height="25" colspan="2" bgcolor="#666666" class="Blanquita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Llene el formulario para Agregar un nuevo Evento</td>
                              </tr>
                              <tr bgcolor="#CCCCCC">
                                <td colspan="2" bgcolor="#CCCCCC" class="Negrita">&nbsp;Todos los campos con asteriscos (<span class="Rojita">&nbsp;*&nbsp;</span>) son de car&aacute;cter obligatorio.</td>
                              </tr>
                              <tr>
                                <td width="27%" class="Textonegro">&nbsp;</td>
                                <td width="73%">&nbsp;</td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">pais_AL_CodPais:</td>
                                <td><select name="pais_AL_CodPais" id="pais_AL_CodPais" onChange="cargaContenido(this.id)">
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
                                </select></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">ciudad_AF_CodCiudad:</td>
                                <td><select id="ciudad_AF_CodCiudad" name="ciudad_AF_CodCiudad" disabled="disabled">
                                  <option value="0" >[ Seleccione ]</option>
                                </select></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">AF_Nombre_Evento:</td>
                                <td><input type="text" name="AF_Nombre_Evento" id="AF_Nombre_Evento" value="" size="32" required></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right" valign="top">AF_Lugar:</td>
                                <td onfocus="MM_validateForm('AF_Nombre_Evento','','R','FE_Fecha_Desde','','R','FE_Fecha_Hasta','','R','AF_Lugar','','R');return document.MM_returnValue"><textarea name="AF_Lugar" id="AF_Lugar" cols="50" rows="5"></textarea></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">FE_Fecha_Desde:</td>
                                <td><input type="text" name="FE_Fecha_Desde" value="" size="32" id="FE_Fecha_Desde" ></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">FE_Fecha_Hasta:</td>
                                <td><input type="text" name="FE_Fecha_Hasta" value="" size="32" id="FE_Fecha_Hasta" ></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">NU_Cantidad_Mesa:</td>
                                <td><input type="number" name="NU_Cantidad_Mesa" id="NU_Cantidad_Mesa" value="" size="32" style="width:212px">
                                  <input name="BI_Activo" type="hidden" id="BI_Activo" value="1"></td>
                              </tr>
                            </table>
                        </fieldset>
        <fieldset class="step">
          <legend>Pa&iacute;ses </legend>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Textonegro">
                              <tr bgcolor="#CCCCCC">
                                <td height="25" colspan="2" bgcolor="#666666" class="Blanquita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Seleccione los Paises que participaran en el Evento</td>
                              </tr>
                              <tr bgcolor="#CCCCCC">
                                <td colspan="2" bgcolor="#CCCCCC" class="Negrita">&nbsp;Todos los campos con asteriscos (<span class="Rojita">&nbsp;*&nbsp;</span>) son de car&aacute;cter obligatorio.</td>
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
        </fieldset>
		<fieldset class="step">
          <legend>C&oacute;digos </legend>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Textonegro">
                              <tr bgcolor="#CCCCCC">
                                <td height="25" colspan="2" bgcolor="#666666" class="Blanquita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Seleccione los codigos arancelarios que correspondan con las actividades del Evento</td>
                              </tr>
                              <tr bgcolor="#CCCCCC">
                                <td colspan="2" bgcolor="#CCCCCC" class="Negrita">&nbsp;Todos los campos con asteriscos (<span class="Rojita">&nbsp;*&nbsp;</span>) son de car&aacute;cter obligatorio.</td>
                              </tr>
                              <tr>
                                <td width="27%" class="Textonegro">&nbsp;</td>
                                <td width="73%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="2" class="Textonegro"><?php echo hacerlistaCodArancel(); ?></td>
                              </tr>
                              <tr>
                                <td colspan="2" class="Textonegro">&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="2" class="Textonegro" align="right"><input name="Evento" type="submit" class="BotonRojo"  value="[ Guardar ]" id="Evento" onclick="javascript:validarAddEvento()">
                                  <input name="button2" type="button" class="BotonRojo" id="button2" value="[ Cancelar ]" onClick="javascript:window.location='index.php'" />
                                  <input type="hidden" name="origen2" value="Evento" id="origen2"></td>
                              </tr>
                              <tr>
                                <td colspan="2" class="Textonegro">&nbsp;</td>
                              </tr>
                            </table>
		</fieldset>                        
						<fieldset class="step">
                            <legend>Confirmar Envio</legend>
                           
						  <p>
							Todo en el formulario fue llenado correctamente si todos los pasos tienen un icono de marca de verificaci&oacute;n verde. Un icono de marca de verificaci&oacute;n roja indica que alg&uacute;n campo no se encuentra o fue llenado con datos no v&aacute;lidos. En este &uacute;ltimo paso, confirma el envio de toda la informaci&oacute;n suministrada haciendo clic en el bot&oacute;n &quot;Enviar&quot;, en el caso que desee volver al men&uacute; haga clic en el bot&oacute;n &quot;Cancelar&quot;.</p>
                          <p class="submit">
<input name="Evento" type="submit" class="BotonRojo" value="[ Guardar ]" id="Evento">
&nbsp;
<input name="button" type="button" class="BotonRojo" id="button" value="[ Cancelar ]" onClick="javascript:window.location='index.php'" />
<input name="origen" type="hidden" id="origen" value="Evento">
                            </p>
                        </fieldset>
                    </form>
                </div>

  <div id="navigation" style="display:none;">
      <ul>
        <li class="selected"><a href="#">Datos </a></li>
        <li><a href="#">Paises</a></li>
        <li><a href="#">Codigo </a></li>
        <li><a href="#">Confirmar</a></li>    
      </ul>
  </div>
  </div>
  </div>
</table>
</body>
</html>
