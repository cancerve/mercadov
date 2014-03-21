<?php 
require_once('../../controller/sessionController.php'); 
require_once("../../model/usuarioModel.php");

$objUsuario = new Usuario();

$RS = $objUsuario->buscarUsuario($objConexion,$_SESSION["NU_Cedula"]);
if ($objConexion->cantidadRegistros($RS)>0){

	$NU_Cedula 		= $objConexion->obtenerElemento($RS,0,'NU_Cedula');
	$AF_Clave 			= $objConexion->obtenerElemento($RS,0,'AF_Clave');
	$AL_NombreApellido 	= $objConexion->obtenerElemento($RS,0,'AL_NombreApellido');
	$AF_Correo 			= $objConexion->obtenerElemento($RS,0,'AF_Correo');
}

?>
<html>
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<link rel="stylesheet" type="text/css" href="../../css/estilo.css">
<link rel="stylesheet" href="../../css/jquery-ui.css" />

<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/funciones.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PERFIL DEL USUARIO</td>
    </tr>
  </table>
  <br>
  <div id="tabs" style="width:730; margin-left:10px" align="center">
  <ul>
    <li><a href="#tabs-1" class="Negrita">Datos Generales</a></li>   
  </ul>
  <form name="form1" id="form1" method="post" action="">
  <div id="tabs-1">
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bordercolor="#F8F8F8">
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="Textonegro">
            <tr>
              <td colspan="2" class="BlancoGris">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Llene el formulario para Registrar su Empresa</td>
            </tr>
            <tr>
              <td colspan="2" class="BlancoGrisClaro">&nbsp;Todos los campos con asteriscos (<span class="Rojita">&nbsp;*&nbsp;</span>) son de car&aacute;cter obligatorio.</td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td class="NegritaMayor">&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td width="212" align="right" nowrap="nowrap">Usuario:</td>
              <td width="73%" class="NegritaMayor">&nbsp;<?=$NU_Cedula?></td>
            </tr>
            <tr valign="baseline" bgcolor="#FFFFFF">
              <td nowrap="nowrap" align="right">Clave:</td>
              <td><input type="password" name="AF_Clave" value="<?=$AF_Clave?>" size="32" id="AF_Clave" /></td>
            </tr>
            <tr valign="baseline" bgcolor="#FFFFFF">
              <td align="right" nowrap="nowrap">Repita la Clave:</td>
              <td><input name="AF_Clave2" type="password" id="AF_Clave2" value="<?=$AF_Clave?>" size="32"/></td>
            </tr>
            <tr valign="baseline" bgcolor="#FFFFFF">
              <td nowrap="nowrap" align="right">Nombre y Apellido del Responsable del Registro:</td>
              <td><input type="text" name="AL_NombreApellido" value="<?=$AL_NombreApellido?>" size="32" id="AL_NombreApellido" /></td>
            </tr>
            <tr valign="baseline" bgcolor="#FFFFFF">
              <td nowrap="nowrap" align="right">Correo_Electronico:</td>
              <td><input type="email" name="AF_Correo" value="<?=$AF_Correo?>" size="32" id="AF_Correo" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><input name="Evento" type="button" class="BotonRojo"  value="[ Guardar ]" id="Evento" onClick="javascript:alert('En Construccion...')">
                <input name="button" type="button" class="BotonRojo" id="button" value="[ Cancelar ]" onClick="javascript:window.location='../centralView.php'" /></td>
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