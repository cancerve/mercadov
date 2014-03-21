<?php 
require_once('../../../controller/sessionController.php'); 
require_once('../../../model/eventoModel.php'); 
include_once('../../../includes/fecha.php');

$objEvento = new Evento();

$rsEvento=$objEvento->buscar($objConexion,$_GET['AF_CodEvento']);
$AF_CodEvento=$objConexion->obtenerElemento($rsEvento,0,"AF_CodEvento");
$AF_Nombre_Evento=$objConexion->obtenerElemento($rsEvento,0,"AF_Nombre_Evento");
$FE_Fecha_Desde=$objConexion->obtenerElemento($rsEvento,0,"FE_Fecha_Desde");
$FE_Fecha_Hasta=$objConexion->obtenerElemento($rsEvento,0,"FE_Fecha_Hasta");

$segundos=strtotime($FE_Fecha_Hasta) - strtotime($FE_Fecha_Desde);
$dias_evento=(intval($segundos/60/60/24))+1;
?>
<html>
<head>
<title>MERCADO VIRTUAL DE VENALCASA</title>

<link rel="stylesheet" type="text/css" href="../../../css/estilo.css">
<link rel="stylesheet" href="../../../css/jquery-ui.css" />
<link rel="stylesheet" href="../../../css/jquery.ptTimeSelect.css" />
<script type="text/javascript" src="../../../js/jquery.js"></script>
<script type="text/javascript" src="../../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../../js/jquery.ptTimeSelect.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php for($k=0; $k<$dias_evento; $k++){ ?>
<script type="text/javascript">
		$(document).ready(function(){
			$('input[name="TI_Hora_Inicio_Am<?=$k?>"]').ptTimeSelect({
				hoursLabel: 'Horas',
				minutesLabel: 'Minutos',
				setButtonLabel: 'Escoger'
			});
		});
		$(document).ready(function(){
			$('input[name="TI_Hora_Final_Am<?=$k?>"]').ptTimeSelect({
				hoursLabel: 'Horas',
				minutesLabel: 'Minutos',
				setButtonLabel: 'Escoger'
			});
		});		
		$(document).ready(function(){
			$('input[name="TI_Hora_Inicio_Pm<?=$k?>"]').ptTimeSelect({
				hoursLabel: 'Horas',
				minutesLabel: 'Minutos',
				setButtonLabel: 'Escoger'
			});
		});		
		$(document).ready(function(){
			$('input[name="TI_Hora_Final_Pm<?=$k?>"]').ptTimeSelect({
				hoursLabel: 'Horas',
				minutesLabel: 'Minutos',
				setButtonLabel: 'Escoger'
			});
		});		
</script>
<?php } ?>
</head>
<body>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="25" bgcolor="#CCCCCC" class="Negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EVENTO - Establecimiento de Horarios</td>
    </tr>
  </table>

  <form name="form1" id="form1" method="post" action="../../../controller/eventoHorarioController.php">
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="">
      <tr>
        <td bordercolor="#F8F8F8">
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="Textonegro">
            <tr>
              <td colspan="2" class="BlancoGris">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Llene el formulario para Agregar un nuevo Evento</td>
            </tr>
            <tr>
              <td colspan="2" class="BlancoGrisClaro">&nbsp;Todos los campos con asteriscos (<span class="Rojita">&nbsp;*&nbsp;</span>) son de car&aacute;cter obligatorio.</td>
            </tr>
            <tr>
              <td class="Textonegro">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td width="27%" align="right" nowrap class="Negrita">Nombre del Evento:</td>
              <td width="73%">&nbsp;<?php echo $AF_Nombre_Evento; ?></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap class="Negrita">Fecha Desde:</td>
              <td>&nbsp;<?php echo cambiarFormatoA($FE_Fecha_Desde); ?></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap class="Negrita">Fecha Hasta:</td>
              <td>&nbsp;<?php echo cambiarFormatoA($FE_Fecha_Hasta); ?></td>
            </tr>
            <tr>
              <td colspan="2" class="Textonegro">
              <table width="95%" class="TablaRojaGrid" align="center">
                <tr class="TablaRojaGridTRTitulo">
                  <th scope="col">Fecha</th>
                  <th scope="col">Hora Inicial AM</th>
                  <th scope="col">Hora Final AM</th>
                  <th scope="col">Hora Inicial PM</th>
                  <th scope="col">Hora Final PM</th>
                  <th scope="col">Min. x Cita</th>
                  <th scope="col">Min. &divide; Cita</th>
                </tr>
                <tr>
                  <td colspan="7">&nbsp;</td>
                </tr>
                <tr>                
                <?php for($i=0; $dias_evento > $i; $i++){ ?>

                  <td>&nbsp;
				  <?php
						$fecha = new DateTime($FE_Fecha_Desde);
						$fecha->add(new DateInterval('P'.$i.'D'));
						$fechaG = $fecha->format('d-m-Y');
						echo $fechaG;
					?>
                  </td>
                  <td align="center"><input name="TI_Hora_Inicio_Am<?php echo $i; ?>" type="text" id="TI_Hora_Inicio_Am<?php echo $i; ?>" style="width:80px" onClick="javascript:tiempo();" value="08:00 AM"></td>
                  <td align="center"><input name="TI_Hora_Final_Am<?php echo $i; ?>" type="text" id="TI_Hora_Final_Am<?php echo $i; ?>" style="width:80px" max="12:00:00" min="08:00:00" value="11:00 AM"></td>
                  <td align="center"><input name="TI_Hora_Inicio_Pm<?php echo $i; ?>" type="text" id="TI_Hora_Inicio_Pm<?php echo $i; ?>" style="width:80px" max="07:00:00" min="02:00:00" autocomplete="off" value="02:00 PM"></td>
                  <td align="center"><input name="TI_Hora_Final_Pm<?php echo $i; ?>" type="text" id="TI_Hora_Final_Pm<?php echo $i; ?>" style="width:80px" value="05:00 PM"></td>
                  <td align="center"><input type="number" name="NU_Minutos_x_Cita<?php echo $i; ?>" id="NU_Minutos_x_Cita<?php echo $i; ?>" style="width:80px"></td>
                  <td align="center"><input type="number" name="NU_Minutos_Entre_Cita<?php echo $i; ?>" id="NU_Minutos_Entre_Cita<?php echo $i; ?>" style="width:80px">
                  <input name="FE_Fecha<?php echo $i; ?>" type="hidden" id="FE_Fecha<?php echo $i; ?>" value="<?php echo $fechaG; ?>"></td>
                </tr>

                <?php } ?>
                <tr>
                  <td colspan="7">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2" class="Textonegro">&nbsp;</td>
            </tr>
           <tr align="center">
              <td colspan="2" class="Textonegro" align="center"><div align="center"><input name="dias_evento" type="hidden" id="dias_evento" value="<?php echo $dias_evento; ?>">
                <input type="hidden" name="MM_insert" value="form1">
                <input name="AF_CodEvento" type="hidden" id="AF_CodEvento" value="<?=$AF_CodEvento?>">
                <input name="EventoHorario" type="submit" class="BotonRojo"  value="[ Guardar ]" id="EventoHorario"></div></td>
            </tr>            
          </table>
        </td>
      </tr>
</table>
</form>
</body>
</html>
