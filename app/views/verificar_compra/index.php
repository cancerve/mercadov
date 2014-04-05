<?php 
require_once('../../controller/sessionController.php'); 
require_once('../../model/mercadoModel.php');

$objMercado 			= new Mercado();


	///// CONVIERTE FECHA 04/07/1980 A 1980-07-04 (FORMATO MYSQL)
	function setFechaNoSQL($FE_FechaNac)
	{
		$partes = explode("-", $FE_FechaNac);
		$FE_FechaNac = $partes[2].'/'.$partes[1].'/'.$partes[0];
		return $FE_FechaNac;
	}
	//////////////////////////////////////////////////////////////
		///////////// CONVERTIR DECIMALES A ESPANOL ///////////
	function setDecimalEsp($numero){
		$numero = str_replace(".", ",", $numero);
		return $numero;
	}
?>
<html>
<link rel="stylesheet" type="text/css" href="../../css/estilo.css">
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>
<script type="text/javascript" src="../../js/mensajes.js"></script>	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../../css/jquery-ui.css" />
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
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
      <td height="25" align="left" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VERIFICAR ORDENES DE COMPRA</td>
    </tr>
    <tr>
      <td><img src="../../images/blank.gif" width="20" height="5"></td>
    </tr>
    <tr>
      <td height="25" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" align="center"><form name="form1" method="post" action="index2.php">
        <table width="350" border="0" cellspacing="2" cellpadding="2" class="Textonegro">
          <tr>
            <td colspan="2" align="left">Escoja el Mercado de su interes:              </td>
          </tr>
          <tr>
            <td align="left"><select name="mercado_NU_IdMercado" required id="mercado_NU_IdMercado">
              <option selected="selected">[ Seleccione ]</option>
              <?php 
					$RSMercado 		= $objMercado->listarMercado($objConexion);
					$cantRSMercado 	= $objConexion->cantidadRegistros($RSMercado);
					for($i=0;$i<$cantRSMercado;$i++){
						  $value=$objConexion->obtenerElemento($RSMercado,$i,"NU_IdMercado");
						  $des = 'DGRH-GBS-M0';
						  $des.=$objConexion->obtenerElemento($RSMercado,$i,"NU_IdMercado");
						  $selected="";

						  echo "<option value=".$value." ".$selected.">".$des."</option>";
					}  
				?>
            </select></td>
            <td align="center"><input type="submit" name="button" id="button" value="[ Ver ]" class="BotonRojo"></td>
          </tr>
        </table>
      </form></td>
    </tr>

    <tr>
      <td height="25" align="center">&nbsp;</td>
    </tr>
  </table>
</body>
</html>