<html>
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<link rel="shortcut icon" href="../../../images/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="../../../css/estilo.css">
<link rel="stylesheet" href="../../../css/jquery-ui.css" />

<script type="text/javascript" src="../../../js/jquery.js"></script>
<script type="text/javascript" src="../../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../../js/funciones.js"></script>
<script type="text/javascript" src="../../../js/jquery.ui.datepicker-es.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td><table width="966" border="0" align="center" cellpadding="8" cellspacing="8">
                <tr>
                  <td width="100%" valign="top" scope="col">
                  
                  
                  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#F8F8F8" bgcolor="#FFFFFF">

  <tr>
    <td valign="top" bordercolor="#000000" width="100%" height="500">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RECUPERACIÓN DE CLAVE</td>
    </tr>
  </table>
  <br>
  <div id="tabs" style="width:900; margin-left:10px" align="center">
  <ul>
    <li><a href="#tabs-1" class="Negrita">Datos Generales</a></li>
  </ul>
  
  <div id="tabs-1">
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bordercolor="#F8F8F8">
        <?php if (isset($_GET['AF_Correo'])){ ?>
        <table width="42%" border="0" cellspacing="0" cellpadding="0" style="border-color:#b3b1b2" align="center" bgcolor="#FFFFFF">
          <tr>
            <td><table class="TablaRojaGrid" width="100%">
              <tr class="TablaRojaGridTRTitulo">
                <td>Proceso Culminado con exito!</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><p>Hemos enviado un mensaje con su nueva clave de acceso a su correo: <strong><?php echo $_GET['AF_Correo']?></strong></p>
                  <p>Ya puede realizar el ingreso y actualización de datos en el sistema.</p>
                  <p>En caso de no recibir el mensaje enviado por el <strong>Sistema de Mercado Virtual de VENALCASA </strong>en su bandeja de entrada del correo que nos suministr&oacute;, se le recomienda revisar la carpeta de<strong> Correos no Deseados (Spam)</strong>.</p>
                  <p>En última instancia se puede comunicar con nosotros al correo: <a href="mailto:mercadovirtual@venalcasa.net.ve">mercadovirtual@venalcasa.net.ve</a><a href="mailto:mercadovirtual@venalcasa.net.ve"></a> indicando su problema.</p></td>
              </tr>
              <tr>
                <td style="text-align: justify">&nbsp;</td>
              </tr>
              <tr>
                <td align="center"><input name="button2" type="button" class="BotonRojo" id="button2" value="[ Iniciar Sesion ]" onClick="javascript:window.location='../../../../index.php'" /></td>
              </tr>
              <tr>
                <td style="text-align: justify">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>
        <?php }else{ ?>
          <table width="42%" border="0" cellspacing="0" cellpadding="0" style="border-color:#b3b1b2" align="center" bgcolor="#FFFFFF">
            <tr>
              <td><table class="TablaRojaGrid" width="100%">
                <tr class="TablaRojaGridTRTitulo">
                  <td>ERROR</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><p>Los datos suministrados por usted NO estan registrados en nuestra Base de Datos. Verifique haber introducido los datos correctamente y vuelva a intentarlo.</p>
                    <p>En última instancia se puede comunicar con nosotros al correo: <a href="mailto:mercadovirtual@venalcasa.net.ve">mercadovirtual@venalcasa.net.ve</a><a href="mailto:mercadovirtual@venalcasa.net.ve"></a> indicando su problema.</p></td>
                </tr>
                <tr>
                  <td style="text-align: justify">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center"><input name="button" type="button" class="BotonRojo" id="button" value="[ Reintentar ]" onClick="javascript:window.location='index.php'" /></td>
                </tr>
                <tr>
                  <td style="text-align: justify">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table>
          <?php } ?>
          </td>
      </tr>
</table>
</div>

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