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
<?php
$currentPage = $_SERVER["PHP_SELF"];
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

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (($_POST[campo]!='') and ($_POST[valor]!='')){
	$filtro = 'and '.$_POST[campo].' LIKE "%'.$_POST[valor].'%"';
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$maxRows_RS_U = 15;
$pageNum_RS_U = 0;
if (isset($_GET['pageNum_RS_U'])) {
  $pageNum_RS_U = $_GET['pageNum_RS_U'];
}
$startRow_RS_U = $pageNum_RS_U * $maxRows_RS_U;

mysql_select_db($database_conexion, $conexion);
$query_RS_U = "SELECT U.*, D.dependencia FROM usuario AS U LEFT JOIN dependencia AS D ON (U.id_dependencia=D.id) WHERE U.borrado!=1 $filtro ORDER BY U.nombre ASC";
$query_limit_RS_U = sprintf("%s LIMIT %d, %d", $query_RS_U, $startRow_RS_U, $maxRows_RS_U);
$RS_U = mysql_query($query_limit_RS_U, $conexion) or die(mysql_error());
$row_RS_U = mysql_fetch_assoc($RS_U);

if (isset($_GET['totalRows_RS_U'])) {
  $totalRows_RS_U = $_GET['totalRows_RS_U'];
} else {
  $all_RS_U = mysql_query($query_RS_U);
  $totalRows_RS_U = mysql_num_rows($all_RS_U);
}
$totalPages_RS_U = ceil($totalRows_RS_U/$maxRows_RS_U)-1;

$queryString_RS_U = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_U") == false && 
        stristr($param, "totalRows_RS_U") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_U = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_U = sprintf("&totalRows_RS_U=%d%s", $totalRows_RS_U, $queryString_RS_U);
?>
<html>
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<link rel="stylesheet" type="text/css" href="../../default/GAnzoategui.css">
<script type="text/javascript" language="JavaScript1.2" src="../../default/GAnzoategui.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } 
	
	if (document.form1.campo.value == ''){
	   errors += '- Debe escoger un criterio de busqueda.\n'; 
	}
	if (document.form1.valor.value == ''){
	   errors += '- No ha escrito que desea buscar.\n'; 
	}
  if (errors) alert('Se ha encontrado los siguientes errores:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
<script LANGUAGE="JavaScript">
	function confirmEdit()
	{
	var agree=confirm("¿Estas seguro de editar?");
	if (agree)
		return true ;
	else
		return false ;
	}

	function confirmBorrar()
	{
	var agree=confirm("¿Estas seguro de borrar?");
	if (agree)
		return true ;
	else
		return false ;
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;USUARIOS</td>
    </tr>
  </table>
  <br>
<form method="POST" name="form1" id="form1">
	  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#D90F0F" id="jefefamilia2">
      <tr>
        <td>
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
		<? if ($row_SESSION['usuario_add'] == '1'){ ?>            
            <tr>
              <td width="100%" colspan="2" class="Textonegro">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="add.php"><img src="../../default/Img/bton_add.gif" width="35" height="31" border="0">Agregar un Usuario </a></td>
            </tr>
            <tr>
              <td height="31" class="Textonegro">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="Negrita">Buscar Usuario por: 
                <select name="campo" id="campo">
                  <option value="" selected>[ Seleccionar ]</option>
                  <option value="cedula">C&eacute;dula</option>
                  <option value="nombre">Nombre y/o Apellido</option>
                  <option value="usuario">Usuario</option>
                </select>
                <input name="valor" type="text" id="valor">
                <input name="Submit" type="submit" class="BotonRojo"  value="[ Buscar ]">
              </span></td>
              <td align="right" class="Textonegro"><input name="button2" type="button" class="BotonRojo" id="button2" value="      [ Atr&aacute;s ]      " onClick="javascript:window.location='../index.php'" /></td>
            </tr>
		<? } ?>			
            <tr>
              <td colspan="2" align="center" class="Textonegro">
			  <? if ($totalRows_RS_U > 0){ ?>
			  <table width="95%" border="1" cellpadding="2" cellspacing="2" bordercolor="#F8F8F8">
                <tr>
                  <td bordercolor="#CCCCCC" bgcolor="#CCCCCC" class="Negrita">Nombre y Apellido </td>
				  <td bordercolor="#CCCCCC" bgcolor="#CCCCCC" class="Negrita">Usuario</td>
				  <td bordercolor="#CCCCCC" bgcolor="#CCCCCC" class="Negrita">Dependencia</td>
				  <? if ($row_SESSION['usuario_edit'] == '1'){ ?>
                  <td width="6%" bordercolor="#CCCCCC" bgcolor="#CCCCCC" class="Negrita">Editar</td>
				<? } ?>
				<? if ($row_SESSION['usuario_del'] == '1'){ ?>
                  <td width="7%" bordercolor="#CCCCCC" bgcolor="#CCCCCC" class="Negrita">Borrar</td>
				<? } ?>				  
                </tr>
                <?php do { ?>
                 <tr class="Textonegro">
                    <td bordercolor="#CCCCCC">&nbsp;<? echo $row_RS_U['nombre']; ?></td>
				    <td bordercolor="#CCCCCC">&nbsp;<? echo $row_RS_U['usuario']; ?></td>
				    <td bordercolor="#CCCCCC">&nbsp;<? echo $row_RS_U['dependencia']; ?></td>
				    <? if ($row_SESSION['usuario_edit'] == '1'){ ?>
                    <td bordercolor="#CCCCCC"><div align="center"><a href="edit.php?id=<?php echo $row_RS_U['id']; ?>" onClick="return confirmEdit()"><img src="../../default/Img/bton_edit.gif" width="35" height="31" border="0"></a></div></td>
				<? } ?>
				<? if ($row_SESSION['usuario_del'] == '1'){ ?>
                    <td bordercolor="#CCCCCC"><div align="center"><a href="del.php?id=<?php echo $row_RS_U['id']; ?>" onClick="return confirmBorrar()"><img src="../../default/Img/bton_del.gif" width="35" height="31" border="0"></a></div></td>
                  </tr>
				<? } ?>				  
                <?php } while ($row_RS_U = mysql_fetch_assoc($RS_U)); ?>
                  <tr class="Textonegro">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                  <tr class="Textonegro">
                    <td colspan="5" align="center">&nbsp;
                      <table border="0" width="50%" align="center">
                        <tr>
                          <td colspan="4" align="center" class="Textonegro">Usuarios   del <?php echo ($startRow_RS_U + 1) ?> al <?php echo min($startRow_RS_U + $maxRows_RS_U, $totalRows_RS_U) ?> de <?php echo $totalRows_RS_U ?> </td>
                        </tr>
                        <tr>
                          <td width="23%" align="center"><?php if ($pageNum_RS_U > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_RS_U=%d%s", $currentPage, 0, $queryString_RS_U); ?>"><img src="../../default/Img/First.gif" width="71" height="44" border=0></a>
                              <?php } // Show if not first page ?>                          </td>
                          <td width="31%" align="center"><?php if ($pageNum_RS_U > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_RS_U=%d%s", $currentPage, max(0, $pageNum_RS_U - 1), $queryString_RS_U); ?>"><img src="../../default/Img/Previous.gif" width="71" height="44" border=0></a>
                              <?php } // Show if not first page ?>                          </td>
                          <td width="23%" align="center"><?php if ($pageNum_RS_U < $totalPages_RS_U) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_RS_U=%d%s", $currentPage, min($totalPages_RS_U, $pageNum_RS_U + 1), $queryString_RS_U); ?>"><img src="../../default/Img/Next.gif" width="71" height="44" border=0></a>
                              <?php } // Show if not last page ?>                          </td>
                          <td width="23%" align="center"><?php if ($pageNum_RS_U < $totalPages_RS_U) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_RS_U=%d%s", $currentPage, $totalPages_RS_U, $queryString_RS_U); ?>"><img src="../../default/Img/Last.gif" width="71" height="44" border=0></a>
                              <?php } // Show if not last page ?>                          </td>
                        </tr>
                      </table></td>
                  </tr>
              </table>
			    <? }else{ ?>
                <br>
                <br>
                <br>
                <table width="90%" border="0" cellpadding="2" cellspacing="2" class="Textonegro">
                <tr>
                  <td class="Negrita"><div align="center">No se encontrar&oacute;n Usuarios </div></td>
                </tr>
              </table>
			  <? } ?>			  </td>
            </tr>
          </table>
        </td>
      </tr>
  </table>
  <tr>
    <td></td>
  </tr>
</table>
</form>			
</body>
</html>
<?php
mysql_free_result($SESSION);

mysql_free_result($RS_U);
?>
