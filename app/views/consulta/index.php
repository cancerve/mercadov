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
    <td height="25" bgcolor="#CCCCCC" class="Negrita" align="left">&nbsp;&nbsp;&nbsp;&nbsp;CONSULTAS</td>
  </tr>
  <tr>
    <td><p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td class="Negrita">&nbsp;</td>
  </tr>
  <tr>
    <td class="Negrita">
    <table width="450" border="0" cellspacing="0" cellpadding="0" style="border-color:#b3b1b2" align="center" bgcolor="#FFFFFF">
      <tr>
        <td>
        <table class="TablaRojaGrid" width="100%">
          <tr class="TablaRojaGridTRTitulo">
            <td>Elija la consulta que desea visualizar</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: justify"><a href="1/index.php">&nbsp;- Solicitud de Inventario a la Vicepresidencia de Operaciones</a></td>
          </tr>
          <tr>
            <td style="text-align: justify"> <a href="2/index.php">&nbsp;- Consolidado de Descuesto Mercado Obrero</a></td>
          </tr>
          <tr>
            <td style="text-align: justify"><a href="3/index.php">&nbsp;- Inventario</a></td>
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
</table>
</body>
</html>