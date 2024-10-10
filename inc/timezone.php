<?php
// Establecer la zona horaria correcta
date_default_timezone_set('America/Mexico_City');

// Definir los días y meses
$dias = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
$meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

// Obtener el día de la semana, el día del mes y el mes actual
$dia_semana = $dias[date("w")];
$dia_mes = date("d");
$mes = $meses[date("m") - 1];
$año = date("Y");

// Imprimir la fecha en el formato deseado
echo "$dia_semana $dia_mes de $mes del $año";
?>
