<?php require_once('../../default/Connections/conexion.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../default/salir.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  $insertSQL = sprintf("INSERT INTO usuario (nombre, cedula, usuario, clave, id_dependencia, solicitud_add, solicitud_edit, solicitud_del, solicitud_asociar, corres_add, corres_edit, corres_del, corres_reporte, corres_buscar, dependencia_add, dependencia_edit, dependencia_del, usuario_add, usuario_edit, usuario_del, municipio_add, municipio_edit, municipio_del, parroquia_add, parroquia_edit, parroquia_del, config, consulta, correspondencia) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['cedula'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString(md5($_POST['clave']), "text"),
                       GetSQLValueString($_POST['id_dependencia'], "text"),
                       GetSQLValueString($_POST['solicitud_add'], "text"),
                       GetSQLValueString($_POST['solicitud_edit'], "text"),
                       GetSQLValueString($_POST['solicitud_del'], "text"),
                       GetSQLValueString($_POST['solicitud_asociar'], "text"),					   
                       GetSQLValueString($_POST['corres_add'], "text"),
                       GetSQLValueString($_POST['corres_edit'], "text"),
                       GetSQLValueString($_POST['corres_del'], "text"),
                       GetSQLValueString($_POST['corres_reporte'], "text"),
                       GetSQLValueString($_POST['corres_buscar'], "text"),
                       GetSQLValueString($_POST['dependencia_add'], "text"),
                       GetSQLValueString($_POST['dependencia_edit'], "text"),
                       GetSQLValueString($_POST['dependencia_del'], "text"),
                       GetSQLValueString($_POST['usuario_add'], "text"),
                       GetSQLValueString($_POST['usuario_edit'], "text"),
                       GetSQLValueString($_POST['usuario_del'], "text"),
                       GetSQLValueString($_POST['municipio_add'], "text"),
                       GetSQLValueString($_POST['municipio_edit'], "text"),
                       GetSQLValueString($_POST['municipio_del'], "text"),
                       GetSQLValueString($_POST['parroquia_add'], "text"),
                       GetSQLValueString($_POST['parroquia_edit'], "text"),
                       GetSQLValueString($_POST['parroquia_del'], "text"),
                       GetSQLValueString($_POST['config'], "text"),
                       GetSQLValueString($_POST['consulta'], "text"),
                       GetSQLValueString($_POST['correspondencia'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "index.php";  
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<? 
session_start();
$sessionid = session_id();
?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_SESSION = "SELECT U.* FROM sessiones AS S LEFT JOIN usuario AS U ON (S.usuario=U.usuario) WHERE `Session` = '$sessionid'";
$SESSION = mysql_query($query_SESSION, $conexion) or die(mysql_error());
$row_SESSION = mysql_fetch_assoc($SESSION);
$totalRows_SESSION = mysql_num_rows($SESSION);
?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_RS_P = "SELECT * FROM usuario_privilegio ORDER by grupo ASC, etiqueta ASC";
$RS_P = mysql_query($query_RS_P, $conexion) or die(mysql_error());
$row_RS_P = mysql_fetch_assoc($RS_P);
$totalRows_RS_P = mysql_num_rows($RS_P);

mysql_select_db($database_conexion, $conexion);
$query_RS_D = "SELECT * FROM dependencia WHERE borrado!=1 ORDER by dependencia ASC";
$RS_D = mysql_query($query_RS_D, $conexion) or die(mysql_error());
$row_RS_D = mysql_fetch_assoc($RS_D);
$totalRows_RS_D = mysql_num_rows($RS_D);
?>
<html>
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<link rel="stylesheet" type="text/css" href="../../default/GAnzoategui.css">
<script type="text/javascript" language="JavaScript1.2" src="../../default/GAnzoategui.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;USUARIOS</td>
    </tr>
  </table>
  <br>
  <form method="POST" name="form1" id="form1" action="<?php echo $editFormAction; ?>">	
	  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#D90F0F" id="jefefamilia2">
      <tr>
        <td bordercolor="#F8F8F8">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr bgcolor="#CCCCCC">
              <td height="25" colspan="2" bgcolor="#666666" class="Blanquita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Llene el formulario para agregar un Usuario </td>
            </tr>
            <tr bgcolor="#CCCCCC">
              <td colspan="2" bgcolor="#CCCCCC" class="Negrita">&nbsp;Todos los campos con asteriscos (<span class="Rojita">&nbsp;*&nbsp;</span>) son de car&aacute;cter obligatorio.</td>
            </tr>
            <tr>
              <td width="35%" class="Textonegro">&nbsp;</td>
              <td width="65%">&nbsp;</td>
            </tr>
								
            <tr>
              <td colspan="2" class="Textonegro"><table width="100%" border="0" cellpadding="2" cellspacing="2" class="Textonegro">
                <tr>
                  <td class="Negrita">Nombre y Apellido: </td>
                  <td><input name="nombre" type="text" id="nombre"></td>
                  <td class="Negrita">Nro. C&eacute;dula: </td>
                  <td><input name="cedula" type="text" id="cedula" maxlength="8"></td>
                </tr>
                <tr>
                  <td class="Negrita">Usuario:</td>
                  <td><input name="usuario" type="text" id="usuario"></td>
                  <td class="Negrita">Clave:</td>
                  <td><input name="clave" type="text" id="clave"></td>
                </tr>
                <tr>
                  <td class="Negrita">Dependencia:</td>
                  <td colspan="3">
				  <select name="id_dependencia" id="id_dependencia">
					  <option value="">[Seleccione]</option>
					  <?php	do {  ?>
					  <option value="<?php echo $row_RS_D['id']?>"><?php echo utf8_decode($row_RS_D['dependencia'])?></option>
					  <?php
						} while ($row_RS_D = mysql_fetch_assoc($RS_D));
						  $rows = mysql_num_rows($RS_D);
						  if($rows > 0) {
							  mysql_data_seek($RS_D, 0);
							  $row_RS_D = mysql_fetch_assoc($RS_D);
						  }
						?>
				  </select>				  </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="25" colspan="2" class="Negrita">&nbsp;Escoja los Privilegios para este Usuario:</td>
            </tr>
            <tr>
              <td colspan="2" class="Textonegro">
			  <table width="100%" border="0" cellspacing="2" cellpadding="2">
			  <? do{ ?>
			  	<? if ($grupo_anterior!=$row_RS_P[grupo]){ $grupo_anterior = $row_RS_P[grupo]; ?>
                <tr>
                  <td colspan="2" bgcolor="#CCCCCC" class="Negrita">&nbsp;<?=$row_RS_P[grupo]?></td>
                </tr>
				<? } ?>
                <tr>
                  <td width="3%"><input type="checkbox" name="<?=$row_RS_P[campo]?>" value="1"></td>
                  <td width="97%">&nbsp;<?=$row_RS_P[etiqueta]?></td>
                </tr>
              <?php } while ($row_RS_P = mysql_fetch_assoc($RS_P)); ?>			
              </table>
			  </td>
            </tr>
            <tr>
              <td class="Textonegro">&nbsp;</td>
              <td class="Textonegro">&nbsp;</td>
            </tr>
            <tr>
              <td class="Textonegro"><input name="Submit" type="submit" class="BotonRojo" value="[ Agregar ]">
                <input name="button2" type="button" class="BotonRojo" id="button2" value="[ Cancelar ]" onClick="javascript:window.location='index.php'" />
<input name="MM_insert" type="hidden" id="MM_insert" value="form1"></td>
              <td class="Textonegro">&nbsp;</td>
            </tr>
</form>	
</body>
</html>
<?php
mysql_free_result($RS_D);

mysql_free_result($RS_P);

mysql_free_result($SESSION);
?>
