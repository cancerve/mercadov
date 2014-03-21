<?php require_once('../../controller/sessionController.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../../css/estilo.css">
<link rel="shortcut icon" href="../../images/favicon.ico"/>
<link rel="stylesheet" href="../../css/jquery-ui.css" />
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript">
    function abrir_dialog() {
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
    };
</script>
</head>

<body>
    <div id="dialog" title="Mensaje" style="display:none;">
    <p>En Construccion!!.</p>
</div>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" bgcolor="#CCCCCC" class="Negrita" align="left">&nbsp;&nbsp;&nbsp;&nbsp;CONFIGURACI&oacute;N</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="Textonegro" align="left">El M&oacute;dulo de Configuraci&oacute;n permite la definici&oacute;n de aspectos de funcionamiento interno del Sistema.<br>
      <br>      
    <br></td>
  </tr>
  <tr>
    <td class="Negrita">
    <table width="42%" border="0" cellspacing="0" cellpadding="0" style="border-color:#b3b1b2" align="center" bgcolor="#FFFFFF">
      <tr>
        <td>
        <table class="TablaRojaGrid" width="100%">
          <tr class="TablaRojaGridTRTitulo">
            <td>Elija el m&oacute;dulo que desea configurar </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: justify"><a href="evento/index.php">&nbsp;- Evento </a></td>
          </tr>
          <tr>
            <td style="text-align: justify"><a href="#" onclick="abrir_dialog()">&nbsp;- Codigo Arancelario</a></td>
          </tr>
          <tr>
            <td style="text-align: justify"><a href="#" onclick="abrir_dialog()">&nbsp;- Paises </a></td>
          </tr>
          <tr>
            <td style="text-align: justify"><a href="#" onclick="abrir_dialog()">&nbsp;- Ciudades</a></td>
          </tr>
          <tr>
            <td style="text-align: justify"><a href="#" onclick="abrir_dialog()">&nbsp;- Oficinas Comerciales</a></td>
          </tr>
          <tr>
            <td style="text-align: justify"><a href="#" onclick="abrir_dialog()">&nbsp;- Usuarios</a></td>
          </tr>
          <tr>
            <td style="text-align: justify">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="Negrita">&nbsp;</td>
  </tr>
  <tr>
    <td class="Negrita" align="center"><input name="button" type="button" class="BotonRojo" id="button" value="[ Cancelar ]" onClick="javascript:window.location='../centralView.php'" /></td>
  </tr>
</table>
</body>
</html>