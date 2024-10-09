<?php
date_default_timezone_set('America/Mexico');

$dias = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
$meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

$dia_semana = $dias[strftime("%w")];
$dia_mes = strftime("%d");
$mes = $meses[strftime("%m") - 1]; // Los meses en strftime() van de 0 a 11
$año = strftime("%Y");

echo "$dia_semana $dia_mes de $mes del $año";
?>