<?php 
require_once('../../../controller/sessionController.php'); 
require_once('../../../model/eventoModel.php'); 

$objEvento = new Evento();
?>
<html>
<link rel="stylesheet" type="text/css" href="../../../css/estilo.css">
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<script type="text/javascript" src="../../../js/mensajes.js"></script>	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../../../css/jquery-ui.css" />
<script type="text/javascript" src="../../../js/jquery.js"></script>
<script type="text/javascript" src="../../../js/jquery-ui.js"></script>
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
    <p><?php echo $_GET['mensaje']; ?></p>
</div>
  <table class="Textonegro" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EVENTOS</td>
    </tr>
    <tr>
      <td><img src="../../../images/blank.gif" width="20" height="5"></td>
    </tr>
    <tr>
      <td height="25" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="center"><a href="addView.php"><img src="../../../images/bton_add.gif" width="35" height="31">&nbsp;Agregar un nuevo registro</a></td>
    </tr>
    <tr>
      <td height="25">&nbsp;</td>
    </tr>
    <tr>
      <td height="25">
    <?php
		$rsEvento=$objEvento->listar($objConexion);
		if($objConexion->cantidadRegistros($rsEvento)>0){
	?>      
      <table width="95%" class="TablaRojaGrid" align="center">
      <thead>
        <tr class="TablaRojaGridTRTitulo">
          <th scope="col" align="center">PAIS</th>
          <th scope="col" align="center">CIUDAD</th>
          <th scope="col" align="center">NOMBRE EVENTO</th>
          <th scope="col" align="center">DESDE</th>
          <th scope="col" align="center"> HASTA</th>
          <th scope="col" align="center">EDITAR</th>
          <th scope="col" align="center">BORRAR</th>
        </tr>
	  </thead>
      <tbody>
	<?php
    	while($evento=$objConexion->obtenerArreglo($rsEvento,MYSQL_ASSOC)){
    ?>
        <tr>
          <td align="center" class="TablaRojaGridTD"><?php echo $evento["AL_Pais"]; ?>&nbsp;</td>
          <td align="center" class="TablaRojaGridTD"><?php echo $evento["AL_Ciudad"]; ?>&nbsp;</td>
          <td class="TablaRojaGridTD"><?php echo $evento["AF_Nombre_Evento"]; ?>&nbsp;</td>
          <td align="center" class="TablaRojaGridTD"><?php echo $evento["FE_Fecha_Desde"]; ?>&nbsp;</td>
          <td align="center" class="TablaRojaGridTD"><?php echo $evento["FE_Fecha_Hasta"]; ?>&nbsp;</td>
          <td align="center" class="TablaRojaGridTD">
          	<a href="editView.php?id=<?php echo $evento['id']; ?>" onClick="return confirmEdit()">
            <img src="../../../images/bton_edit.gif" width="35" height="31"></a>
          </td>
          <td align="center" class="TablaRojaGridTD">
          	<a href="delView.php?id=<?php echo $evento['id']; ?>" onClick="return confirmBorrar()">
            <img src="../../../images/bton_del.gif" width="35" height="31"></a>
          </td>
        </tr>
	<?php
	    }
    ?>          
        </tbody>
      </table>
	<?php
	    }else{ echo 'No se encontraron registros.'; }
    ?>       
      </td>
    </tr>
    <tr>
      <td height="25" >&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="center"><input name="button2" type="button" class="BotonRojo" id="button2" value="[ Atras ]" onClick="javascript:window.location='../index.php'" /></td>
    </tr>
  </table>
</body>
</html>