<?php 
	session_start();
	
	require_once("../../../includes/constantes.php");
	require_once("../../../includes/conexion.class.php");
	require_once('../../../model/empresaModel.php'); 
	
	$objConexion= new conexion(SERVER,USER,PASS,DB);
	$objEmpresa = new Empresa();
?>
<?php
	$dia			= substr($_GET['FE_FechaNac'],-2);		 
	$mes			= substr($_GET['FE_FechaNac'],4,-2);		 
	$anio			= substr($_GET['FE_FechaNac'],0,-4);		 		
	$FE_FechaNac 	= $dia.'/'.$mes.'/'.$anio;
?>
<html>
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<link rel="shortcut icon" href="../../../images/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="../../../css/estilo.css">
<link rel="stylesheet" href="../../../css/jquery-ui.css" />

<script type="text/javascript" src="../../../js/jquery.js"></script>
<script type="text/javascript" src="../../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../../js/funciones.js"></script>
<script type="text/javascript" src="../../../js/select_dependientes.js"></script>
<script type="text/javascript" src="../../../js/jquery.validate.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body><tr bordercolor="#FFFFFF" bgcolor="#FFFFFF"><td colspan="5"><tr><td valign="bottom"><tr><td>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" colspan="2" align="center"><img src="../../../images/head.jpg" width="963" height="43"  alt=""/></td>
  </tr>
  <tr bgcolor="#ffffff" >
    <td height="1" colspan="2" align="center"><img src="../../../images/blank.gif" width="100" height="1"  alt=""/></td>
  </tr>
  <tr bgcolor="#ffffff" >
    <td height="1" colspan="2" align="center" bgcolor="#FF0000"><img src="../../../images/blank.gif" width="100" height="1"  alt=""/></td>
  </tr>
  <tr bgcolor="#ffffff" >
    <td height="1" colspan="2" align="center"><img src="../../../images/blank.gif" width="100" height="1"  alt=""/></td>
  </tr>
  <tr bgcolor="#ffffff" >
    <td width="75%" height="107" align="right" bgcolor="#ffffff"><table width="966" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="107" class="Blanquita" style="font-size:18px" background="../../../images/head4.png">&nbsp;</td>
      </tr>
    </table></td>
    <td width="23%" align="center" bgcolor="#ff000b">&nbsp;</td>
  </tr>
  <tr bgcolor="#ffffff" >
    <td height="1" colspan="2" align="center"><img src="../../../images/blank.gif" width="100" height="1"  alt=""/></td>
  </tr>
  <tr bgcolor="#ffffff" >
    <td height="1" colspan="2" align="center" bgcolor="#FF0000"><img src="../../../images/blank.gif" width="100" height="1"  alt=""/></td>
  </tr>
  <tr bgcolor="#ffffff" >
    <td height="1" colspan="2" align="center"><img src="../../../images/blank.gif" width="100" height="1"  alt=""/></td>
  </tr>
</table>
  <table width="966" border="0" align="center" cellpadding="8" cellspacing="8">
                <tr>
                  <td width="100%" valign="top" scope="col">
                  
                  
                  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#F8F8F8" bgcolor="#FFFFFF">

  <tr>
    <td valign="top" bordercolor="#000000" width="100%" height="500">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CREACIÓN DE USUARIO</td>
    </tr>
  </table>
  <br>
  <div id="tabs" style="width:900; margin-left:10px" align="center">
  <ul>
    <li><a href="#tabs-1" class="Negrita">Datos Generales</a></li>
  </ul>
  <form name="form1" id="form1" method="post" action="../../../controller/usuarioController.php">
  <div id="tabs-1">
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bordercolor="#F8F8F8">
          <table width="100%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td class="BlancoGris">&nbsp;Llene el formulario para Crear su Usuario</td>
            </tr>
            <tr>
              <td class="BlancoGrisClaro">&nbsp;Todos los campos con asteriscos (<span class="Rojita">&nbsp;*&nbsp;</span>) son de car&aacute;cter obligatorio.</td>
            </tr>
          </table>
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="Textonegro" bgcolor="#FFFFFF">
            <tr>
              <td width="56" class="Textonegro">&nbsp;</td>
              <td width="382">&nbsp;</td>
              <td width="158">&nbsp;</td>
              <td width="278">&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Cédula:</td>
              <td align="left"><input name="NU_Cedula" type="text" id="NU_Cedula" value="<?php echo $_SESSION["NU_Cedula"]; ?>" size="40" readonly /></td>
              <td align="right" nowrap="nowrap">Teléfono: (<span class="Rojita">*</span>)</td>
              <td align="left"><input name="AF_Telefono" type="tel" required id="AF_Telefono" style="width:260" size="40"/></td>
              </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Nombre:</td>
              <td align="left"><input name="AL_Nombre" type="text" id="AL_Nombre" value="<?php echo $_GET['AL_Nombre']; ?>" size="40" readonly /></td>
              <td align="right" nowrap="nowrap">Clave: (<span class="Rojita">*</span>)</td>
              <td align="left"><input name="AF_Clave" type="password" required id="AF_Clave" value="" size="40"/></td>
              </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">Apellido:</td>
              <td align="left"><input name="AL_Apellido" type="text" id="AL_Apellido" value="<?php echo $_GET['AL_Apellido']; ?>" size="40" readonly /></td>
              <td align="right" nowrap="nowrap">Repita la Clave: (<span class="Rojita">*</span>)</td>
              <td align="left"><input name="AF_Clave2" type="password" required id="AF_Clave2" value="" size="40"/></td>
              </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">Fecha de Nacimiento:</td>
              <td align="left"><input name="FE_FechaNac" type="text" id="FE_FechaNac" value="<?php echo $FE_FechaNac; ?>" size="40" readonly /></td>
              <td align="right" nowrap="nowrap">Correo Electrónico: (<span class="Rojita">*</span>)</td>
              <td align="left"><input name="AF_Correo" type="email" required id="AF_Correo" autocomplete="off" value="" size="40" /></td>
              </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Empresa:</td>
              <td align="left"><input name="empresa_NU_IdEmpresa" type="text" id="empresa_NU_IdEmpresa" value="<?php if(isset($_GET['AF_RazonSocial'])){ echo $_GET['AF_RazonSocial']; } ?>" size="40" readonly></td>
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td align="left">&nbsp;</td>
              </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">Sede:</td>
              <td align="left"><input name="sede_NU_IdSede" type="text" id="sede_NU_IdSede" value="<?php if(isset($_GET['AL_NombreSede'])){ echo $_GET['AL_NombreSede']; } ?>" size="40" readonly></td>
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td align="left">&nbsp;</td>
              </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">Gerencia:</td>
              <td align="left"><input name="gerencia_NU_IdGerencia" type="text" id="gerencia_NU_IdGerencia" value="<?php if(isset($_GET['AL_NombreGerencia'])){ echo $_GET['AL_NombreGerencia']; } ?>" size="40" readonly></td>
              <td align="right" nowrap="nowrap"><input name="rol_NU_IdRol" type="hidden" id="rol_NU_IdRol" value="1"></td>
              <td align="left">&nbsp;</td>
              </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
            <tr valign="baseline">
              <td colspan="4" align="right" nowrap="nowrap"><input name="Enviar" type="submit" class="BotonRojo"  value="[ Registrar ]" id="Enviar">
                <input name="button2" type="button" class="BotonRojo" id="button2" value="[ Cancelar ]" onClick="javascript:window.location='../../salirView.php'" />
                <input name="origen" type="hidden" id="origen" value="UserCrear2">              </td>
            </tr>
            </table></td>
      </tr>
</table>
</div>
</form>
</div>
                  
                  
              </td>
                  </tr>
                </table></td>
            </tr>
 </table>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr bgcolor="#ffffff" >
            <td height="1" colspan="2" align="center"><img src="../../../images/blank.gif" width="100" height="1"  alt=""/></td>
        </tr>
  <tr bgcolor="#FF0000" >
    <td height="1" colspan="2" align="center"><img src="../../../images/blank.gif" width="100" height="1"  alt=""/></td>
        </tr>
                <tr bgcolor="#ffffff" >
                  <td height="1" colspan="2" align="center"><img src="../../../images/blank.gif" width="100" height="1"  alt=""/></td>
        </tr>  
    <tr valign="middle">
      <td height="50" colspan="2" align="center" valign="middle" background="../../../images/footer.jpg" class="Blanquita"><p>Venezolana de Alimentos La CASA, S.A. Este sistema fue desarrollado cumpliendo los lineamientos del Decreto N&deg; 3390.</p></td>
    </tr>
  </table>

</body>
</html>