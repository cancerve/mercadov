<?php require_once('../controller/sessionController.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../css/estilo.css" >
<link rel="shortcut icon" href="../images/favicon.ico"/>
<link rel="stylesheet" href="../css/jquery-ui.css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>
<script type="text/javascript">
    function abrir_dialog() {
		var mensaje = "<?php echo $_GET['mensaje']; ?>";
		if(mensaje){
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
		}
    };
</script>
</head>

<body onLoad="abrir_dialog();">
<div id="dialog" title="Mensaje" style="display:none;">
    <span class="ui-icon ui-icon-circle-check"></span>
    <p><?php echo $_GET['mensaje']; ?></p>
</div>
<p>&nbsp;</p>
<table width="300"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="Negrita">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
      <p>&nbsp;</p>
      <p class="Textonegro" align="center">Escoja una acci&oacute;n en el listado de botones presentados en la parte superior. </p>
    </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
