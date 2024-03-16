<?php

if ( ! function_exists('fecha'))
{
	function fecha($fecha = null)
	{
		// Traducir meses y días
		$meses['1']	= 'Enero';
		$meses['2']	= 'Febrero';
		$meses['3']	= 'Marzo';
		$meses['4']	= 'Abril';
		$meses['5']	= 'Mayo';
		$meses['6']	= 'Junio';
		$meses['7']	= 'Julio';
		$meses['8']	= 'Agosto';
		$meses['9']	= 'Septiembre';
		$meses['10']	= 'Octubre';
		$meses['11']	= 'Noviembre';
		$meses['12']	= 'Diciembre';

		$dias['1']	= 'Lunes';
		$dias['2']	= 'Martes';
		$dias['3']	= 'Miércoles';
		$dias['4']	= 'Jueves';
		$dias['5']	= 'Viernes';
		$dias['6']	= 'Sábado';
		$dias['7']	= 'Domingo';

		if(!$fecha) {
			echo $dias[date('N')].', '.date("j").' de '.$meses[date('n')].' de '.date("Y");
		} else {
			echo $dias[date('N', strtotime($fecha))].', '.date("j", strtotime($fecha)).' de '.$meses[date('n', strtotime($fecha))].' de '.date("Y", strtotime($fecha));
		}
	}
}

if( ! function_exists('fecha_recepcion'))
{
    function fecha_recepcion($fecha_actual)
    {
		switch($fecha_actual) {
			case 1:
				return date("Y-m-d H:i:s", strtotime("+8 days"));
			break;

			case 2:
				return date("Y-m-d H:i:s", strtotime("+8 days"));
			break;

			case 3:
				return date("Y-m-d H:i:s", strtotime("+8 days"));
			break;

			case 4:
				return date("Y-m-d H:i:s", strtotime("+8 days"));
			break;

			case 5:
				return date("Y-m-d H:i:s", strtotime("+10 days"));
			break;

			case 6:
				return date("Y-m-d H:i:s", strtotime("+9 days"));
			break;

			case 7:
				return date("Y-m-d H:i:s", strtotime("+8 days"));
			break;
		}
    }
}