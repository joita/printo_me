<?php

if ( ! function_exists('slugger'))
{
    function slugger($a)
    {
        return strtolower(url_title(convert_accented_characters($a)));
    }
}

if ( ! function_exists('historial_pedido_tiempo'))
{
    function historial_pedido_tiempo($historial, $paso)
    {
        if(sizeof($historial)) {
            foreach($historial as $h) {
                if($h->id_paso_pedido == $paso) {

                    $date_inicio = new DateTime($h->fecha_inicio);
                    if($h->fecha_final != '' && $h->fecha_final != '0000-00-00 00:00:00') {
                        $date_final = new DateTime($h->fecha_final);
                        $duracion = $date_final->diff($date_inicio);

                        if($duracion->d > 0) {
                            $tiempo_transcurrido = $duracion->format('%dd %hhrs %imin');
                        } else {
                            if($duracion->h > 0) {
                                $tiempo_transcurrido = $duracion->format('%hhrs %imin');
                            } else {
                                $tiempo_transcurrido = $duracion->format('%imin');
                            }
                        }
                    } else {
                        $date_final = new DateTime();
                        $duracion = $date_final->diff($date_inicio);

                        if($duracion->d > 0) {
                            $tiempo_transcurrido = $duracion->format('%dd %hhrs %imin');
                        } else {
                            if($duracion->h > 0) {
                                $tiempo_transcurrido = $duracion->format('%hhrs %imin');
                            } else {
                                $tiempo_transcurrido = $duracion->format('%imin');
                            }
                        }
                    }

                    echo '<table class="stepbystep">';
                    echo '<tr>
                        <th class="text-right" width="40%">Inicio</th>
                        <th class="text-center" width="20%"> </th>
                        <th class="text-left" width="40%">Final</th>
                    </tr>
                    <tr>
                        <td class="text-right" width="40%">'.historial_pedido_tiempo_inicio($h, $paso).'</td>
                        <td class="text-center" width="20%">-</td>
                        <td class="text-left" width="40%">'.historial_pedido_tiempo_final($h, $paso).'</td>
                    </tr>';
                    if(isset($h->fecha_final)) {
                        echo '<tr>
                            <th colspan="3" class="text-center">Duración</th>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="3"><strong>'.$tiempo_transcurrido.'</strong></td>
                        </tr>';
                    } else {
                        echo '<tr>
                            <th colspan="3" class="text-center">Lleva</th>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="3"><strong>'.$tiempo_transcurrido.'</strong></td>
                        </tr>';
                    }
                    echo '</table>';
                }
            }
        } else {
            echo '';
        }
    }
}

if ( ! function_exists('historial_pedido_entrega'))
{
    function historial_pedido_entrega($historial, $paso)
    {
        if(sizeof($historial)) {
            foreach($historial as $h) {
                if($h->id_paso_pedido == $paso) {

                    echo '<table class="stepbystep" style="width:100%;">';
                    echo '<tr>
                        <th class="text-center" width="100%">Fecha de entrega</th>
                    </tr>
                    <tr>
                        <td class="text-center" width="20%">'.$h->fecha_inicio.'</td>
                    </tr>';
                    echo '</table>';
                }
            }
        } else {
            echo '';
        }
    }
}

if ( ! function_exists('historial_pedido_tiempo_inicio'))
{
    function historial_pedido_tiempo_inicio($historial, $paso)
    {
        if($historial->id_paso_pedido == $paso) {
            if($historial->fecha_inicio != '' && $historial->fecha_inicio != '0000-00-00 00:00:00') {
                return date("d-m-Y H:i", strtotime($historial->fecha_inicio));
            }
        }
    }
}

if ( ! function_exists('historial_pedido_tiempo_final'))
{
    function historial_pedido_tiempo_final($historial, $paso)
    {
        if($historial->id_paso_pedido == $paso) {
            if($historial->fecha_final != '' && $historial->fecha_final != '0000-00-00 00:00:00') {
                return date("d-m-Y H:i", strtotime($historial->fecha_final));
            }
        }
    }
}

if ( ! function_exists('paso_pedido_class'))
{
	function paso_pedido_class($paso_especifico, $paso_actual)
	{
        if($paso_especifico < $paso_actual) {
            echo ' past';
        } else if($paso_especifico == $paso_actual) {
            echo ' current';
        }
	}
}

if ( ! function_exists('paso_pedido_filter'))
{
	function paso_pedido_filter($paso_especifico, $paso_actual, $id_pedido)
	{
        if($paso_especifico > $paso_actual) {
            echo ' filter="url('.current_url().'#grayscale_'.$id_pedido.')"';
        }
	}
}

if ( ! function_exists('activar'))
{
	function activar($a, $b)
	{
		echo ($a == $b ? ' class="active"' : '');
	}
}

if ( ! function_exists('activar_alt'))
{
	function activar_alt($a, $b)
	{
		echo ($a == $b ? ' active' : '');
	}
}

if ( ! function_exists('activar_alt_open'))
{
	function activar_alt_open($a, $b)
	{
		echo ($a == $b ? ' active open' : ' closed');
	}
}

if(! function_exists('print_m'))
{
	function print_m($data)
	{
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
}

if(! function_exists('titulo_cotizador'))
{
	function titulo_cotizador($data)
	{
		switch ($data) {
			case '1':
				$titulo = 'Una Tinta';
				break;
			case '2':
				$titulo = 'Dos Tintas';
				break;
			case '3':
				$titulo = 'Tres Tintas';
				break;
			case '4':
				$titulo = 'Separación de Tintas';
				break;

		}
		return $titulo;
	}
}

if(! function_exists('selected_opcion'))
{
	function selected_opcion($a = '', $b = '')
	{
		echo ($a == $b) ? 'selected' : '';
	}
}

if ( ! function_exists('curly'))
{
	function curly($url, $input_xml)
	{
		$result = "";
		$response = true;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "qry_str_xml=" . $input_xml);

		$result = curl_exec($ch);
		curl_close($ch);

		echo $result;
	}
}


if ( ! function_exists('estrellitas'))
{
	function estrellitas($rating) {

        if($rating >= 0 && $rating < 0.3) {
            $full = 0; $semi = 0; $empty = 5;
        } else if($rating >= 0.3 && $rating < 0.8) {
            $full = 0; $semi = 1; $empty = 4;
        } else if($rating >= 0.8 && $rating < 1.3) {
            $full = 1; $semi = 0; $empty = 4;
        } else if($rating >= 1.3 && $rating < 1.8) {
            $full = 1; $semi = 1; $empty = 3;
        } else if($rating >= 1.8 && $rating < 2.3) {
            $full = 2; $semi = 0; $empty = 3;
        } else if($rating >= 2.3 && $rating < 2.8) {
            $full = 2; $semi = 1; $empty = 2;
        } else if($rating >= 2.8 && $rating < 3.3) {
            $full = 3; $semi = 0; $empty = 2;
        } else if($rating >= 3.3 && $rating < 3.8) {
            $full = 3; $semi = 1; $empty = 1;
        } else if($rating >= 3.8 && $rating < 4.3) {
            $full = 4; $semi = 0; $empty = 1;
        } else if($rating >= 4.3 && $rating < 4.8) {
            $full = 4; $semi = 1; $empty = 0;
        } else if($rating >= 4.8) {
            $full = 5; $semi = 0; $empty = 0;
        }

		$star_rating = '';

		for($i=0;$i<$full;$i++) {
			$star_rating .= '<span class="fa fa-star fa-lg checked"></span>';
		}

		for($i=0;$i<$semi;$i++) {
			$star_rating .= '<span class="fa fa-star-half-o fa-lg checked"></span>';
		}

		for($i=0;$i<$empty;$i++) {
			$star_rating .= '<span class="fa fa-star-o fa-lg checked"></span>';
		}

		return $star_rating;
	}
}
