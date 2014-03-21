<?php
function cambiarFormatoA($fecha1){
	$fecha2=date("d-m-Y",strtotime($fecha1));
	return $fecha2;
}

function cambiarFormatoE($fecha1){
	$valor = explode("/", $fecha1);
	$fecha2 = $valor[2].'-'.$valor[1].'-'.$valor[0];
	return $fecha2;
}

function cambiarFormatoE2($fecha1){
	$valor = explode("-", $fecha1);
	$fecha2 = $valor[2].'-'.$valor[1].'-'.$valor[0];
	return $fecha2;
}

function cambiarTime($time){
	$valor = explode(" ", $time);
	$valor2 = explode(":", $valor[0]);

	$hora = $valor2[0];
	$minu = $valor2[1];
	$AmPm = $valor[1];
	
	if ($AmPm == 'PM')
	{
		$hora = $hora + 12;
	}	
	
	$time2 = $hora.':'.$minu;
	return $time2;
}
?>