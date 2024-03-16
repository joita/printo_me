<?php

if ( ! function_exists('getCustomImage'))
{
    function getCustomImage($product)
    {
        if ($product["enhance"]) {
            return site_url($product['images']["front"]);
        } else {
            $imagen = "";

            if ($product["disenos"]["images"]["front"]){
                $imagen = "front";
            } elseif ($product["disenos"]["images"]["back"]) {
                $imagen = "back";
            } elseif ($product["disenos"]["images"]["right"]) {
                $imagen = "right";
            } elseif ($product["disenos"]["images"]["left"]) {
                $imagen = "left";
            }

            return site_url($product["disenos"]["images"][$imagen]);
        }
    }
}

if ( ! function_exists('super_unique'))
{
    function super_unique($array)
    {
        $id_producto = 0;
        $id_color    = 0;
        $id_diseno   = '';
        foreach($array as $indice=>$valor) {
            if($valor['product_id'] == $id_producto && $valor['color_id'] == $id_color) {
                unset($array[$indice]);
            } else {
                $id_producto = $valor['product_id'];
                $id_color = $valor['color_id'];
            }
        }

        return $array;
    }
}

/**
 * Function Name
 *
 * Function description
 *
 * @access  public
 * @param  type  name
 * @return  type
 */

if (! function_exists('getNextQuotes'))
{
	function getNextQuotes($quantity)
	{
		// Construccion de la matriz de multiplicadores
		$CI =& get_instance();

		$CI->db->order_by('cantidad_min', 'ASC');
		$datos_res = $CI->db->get_where('Cotizador', array('tipo_tinta' => 1, 'tipo_estampado' => 1, 'estatus' => 1));
		$datos = $datos_res->result();

		$cantidades = array();
		foreach($datos as $dato) {
			array_push($cantidades, $dato->cantidad_min);
		}

		//$cantidades = array(1, 2, 3, 4, 5, 6, 10, 20, 30, 40, 50, 100, 200, 500, 1000, 1500, 2000, 2500, 3000);

		$items = count($cantidades)-1;

		foreach ($cantidades as $key => $cantidad) {
			if ($cantidad > $quantity) break;
		}

		if ($key != $items) $key--;

		if ($key < 0) $key = 0;

		if ($items == $key) {
			if ($cantidades[$key] > $quantity) {
				return array("first" => $cantidades[$key]);
			}else{
				return array();
			}
		} else if($key+1 == $items) {
			return array("first" => $cantidades[$key+1]);
		} else if($key+2 <= $items) {
			return array("first" => $cantidades[$key+1],  "second" => $cantidades[$key+2]);
		}

		return array();
	}
}

if (! function_exists('getCost'))
{
    function getCost(
		$colors_per_sides = array("front" => 0, "back" => 0, "left" => 0, "right" => 0),
		$shirtWhite = true,
		$quantity = 1,
		$sku = null
	)
    {
		$CI =& get_instance();

		$datos_res = $CI->db->get_where('Cotizador', array('tipo_tinta' => 1, 'tipo_estampado' => 1, 'estatus' => 1));
		$datos = $datos_res->result();

		$cantidades = array();
		foreach($datos as $dato) {
			array_push($cantidades, $dato->cantidad_min);
		}

		$sides = array("front", "back", "left", "right");
		$used = array("front" => false, "back" => false, "right" => false,  "left" => false);
		$used_anyone = false;
		$costs = array("front" => 0, "back" => 0, "left" => 0, "right" => 0);
		$precio = 0;

		// Construccion de la matriz de multiplicadores
		$matriz = array();

		$sql = "SELECT DISTINCT(tipo_tinta) as tipo FROM Cotizador WHERE estatus=1 ORDER BY tipo_tinta ASC";
		$tipos_res = $CI->db->query($sql);
		$tipos = $tipos_res->result();

		foreach($tipos as $tipo) {
			$matriz[$tipo->tipo] = array();
		}

		foreach($matriz as $tipo_tinta=>$arreglo) {

			$datos_res = $CI->db->get_where('Cotizador', array('tipo_tinta' => $tipo_tinta, 'tipo_estampado' => 1, 'estatus' => 1));
			$datos = $datos_res->result();

			foreach($datos as $dato) {
				$matriz[$tipo_tinta][$dato->cantidad_min] = array(
					'blanca' => $dato->costo_blanca,
					'color' => $dato->costo_color,
					'ladoA' => $dato->multiplicador_1,
					'ladoB' => $dato->multiplicador_2
				);
			}

			$datos_lado_res = $CI->db->get_where('Cotizador', array('tipo_tinta' => $tipo_tinta, 'tipo_estampado' => 2, 'estatus' => 1));
			$datos_lado = $datos_lado_res->result();

			foreach($datos_lado as $dato) {
				$matriz[$tipo_tinta][$dato->cantidad_min]['manga_blanca'] = $dato->costo_blanca;
				$matriz[$tipo_tinta][$dato->cantidad_min]['manga_color'] = $dato->costo_color;
				$matriz[$tipo_tinta][$dato->cantidad_min]['mangaA'] = $dato->multiplicador_1;
				$matriz[$tipo_tinta][$dato->cantidad_min]['mangaB'] = $dato->multiplicador_2;

			}
		}

		$tempkey =0;
		$comparativo = $quantity;

		foreach ($cantidades as $key => $cantidad) {
			if ($comparativo >= $cantidad) {
				$tempkey = $key;
			}else{
				break;
			}
		}

		$key = $tempkey;

		if (is_object($sku)) {
			$quantity = $sku->quantity;
			$valor_base = $sku->precio;
		} else {
			$valor_base = $sku;
		}

		$cantidad = $cantidades[$key];


		$tipoPlayera = "color";
		$tipoManga = "manga_color";
		if ($shirtWhite) {
			$tipoPlayera = "blanca";
			$tipoManga = "manga_blanca";
		}

		// Precio base de la playera sin importar
		// $precio = $valor_base * $matriz[1][1]["ladoA"];
		if($colors_per_sides['front'] == 0 && $colors_per_sides['back'] == 0 && $colors_per_sides['left'] == 0 && $colors_per_sides['right'] == 0) {
			$precio = $valor_base * $matriz[1][1]["ladoA"];
		} else {
			// Condicion colores_front ^ colores_back ^ colores_left ^ colores_right
			if($colors_per_sides['front'] > 0 && $colors_per_sides['back'] > 0 && $colors_per_sides['left'] > 0 && $colors_per_sides['right'] > 0) {
				// V V V V
				$colores_para_costo = ($colors_per_sides['front'] > 3 ? 4 : $colors_per_sides['front']);
			} else if($colors_per_sides['front'] > 0 && $colors_per_sides['back'] > 0 && $colors_per_sides['left'] > 0 && $colors_per_sides['right'] == 0) {
				// V V V F
				$colores_para_costo = ($colors_per_sides['front'] > 3 ? 4 : $colors_per_sides['front']);
			} else if($colors_per_sides['front'] > 0 && $colors_per_sides['back'] > 0 && $colors_per_sides['left'] == 0 && $colors_per_sides['right'] > 0) {
				// V V F V
				$colores_para_costo = ($colors_per_sides['front'] > 3 ? 4 : $colors_per_sides['front']);
			} else if($colors_per_sides['front'] > 0 && $colors_per_sides['back'] > 0 && $colors_per_sides['left'] == 0 && $colors_per_sides['right'] == 0) {
				// V V F F
				$colores_para_costo = ($colors_per_sides['front'] > 3 ? 4 : $colors_per_sides['front']);
			} else if($colors_per_sides['front'] > 0 && $colors_per_sides['back'] == 0 && $colors_per_sides['left'] > 0 && $colors_per_sides['right'] > 0) {
				// V F V V
				$colores_para_costo = ($colors_per_sides['front'] > 3 ? 4 : $colors_per_sides['front']);
			} else if($colors_per_sides['front'] > 0 && $colors_per_sides['back'] == 0 && $colors_per_sides['left'] > 0 && $colors_per_sides['right'] == 0) {
				// V F V F
				$colores_para_costo = ($colors_per_sides['front'] > 3 ? 4 : $colors_per_sides['front']);
			} else if($colors_per_sides['front'] > 0 && $colors_per_sides['back'] == 0 && $colors_per_sides['left'] == 0 && $colors_per_sides['right'] > 0) {
				// V F F V
				$colores_para_costo = ($colors_per_sides['front'] > 3 ? 4 : $colors_per_sides['front']);
			} else if($colors_per_sides['front'] > 0 && $colors_per_sides['back'] == 0 && $colors_per_sides['left'] == 0 && $colors_per_sides['right'] == 0) {
				// V F F F
				$colores_para_costo = ($colors_per_sides['front'] > 3 ? 4 : $colors_per_sides['front']);
			} else if($colors_per_sides['front'] == 0 && $colors_per_sides['back'] > 0 && $colors_per_sides['left'] > 0 && $colors_per_sides['right'] > 0) {
				// F V V V
				$colores_para_costo = ($colors_per_sides['back'] > 3 ? 4 : $colors_per_sides['back']);
			} else if($colors_per_sides['front'] == 0 && $colors_per_sides['back'] > 0 && $colors_per_sides['left'] > 0 && $colors_per_sides['right'] == 0) {
				// F V V F
				$colores_para_costo = ($colors_per_sides['back'] > 3 ? 4 : $colors_per_sides['back']);
			} else if($colors_per_sides['front'] == 0 && $colors_per_sides['back'] > 0 && $colors_per_sides['left'] == 0 && $colors_per_sides['right'] > 0) {
				// F V F V
				$colores_para_costo = ($colors_per_sides['back'] > 3 ? 4 : $colors_per_sides['back']);
			} else if($colors_per_sides['front'] == 0 && $colors_per_sides['back'] > 0 && $colors_per_sides['left'] == 0 && $colors_per_sides['right'] == 0) {
				// F V F F
				$colores_para_costo = ($colors_per_sides['back'] > 3 ? 4 : $colors_per_sides['back']);
			} else if($colors_per_sides['front'] == 0 && $colors_per_sides['back'] == 0 && $colors_per_sides['left'] > 0 && $colors_per_sides['right'] > 0) {
				// F F V V
				$colores_para_costo = ($colors_per_sides['left'] > 3 ? 4 : $colors_per_sides['left']);
			} else if($colors_per_sides['front'] == 0 && $colors_per_sides['back'] == 0 && $colors_per_sides['left'] > 0 && $colors_per_sides['right'] == 0) {
				// F F V F
				$colores_para_costo = ($colors_per_sides['left'] > 3 ? 4 : $colors_per_sides['left']);
			} else if($colors_per_sides['front'] == 0 && $colors_per_sides['back'] == 0 && $colors_per_sides['left'] == 0 && $colors_per_sides['right'] > 0) {
				// F F F V
				$colores_para_costo = ($colors_per_sides['right'] > 3 ? 4 : $colors_per_sides['right']);
			}

			$precio = $valor_base * $matriz[$colores_para_costo][$cantidad]["ladoA"];
		}

		// Escaneo de lados
		if($colors_per_sides['front'] > 0 && $colors_per_sides['back'] > 0) {
			// Se suma el lado delantero con el primer multiplicador
			$colors_front = ($colors_per_sides['front'] > 3 ? 4 : $colors_per_sides['front']);
			$precio += $matriz[$colors_front][$cantidad][$tipoPlayera] * $matriz[$colors_front][$cantidad]["ladoA"];

			// Se suma el lado trasero con el segundo multiplicador
			$colors_back = ($colors_per_sides['back'] > 3 ? 4 : $colors_per_sides['back']);

			$precio += $matriz[$colors_back][$cantidad][$tipoPlayera] * $matriz[$colors_back][$cantidad]["ladoB"];
		} else if($colors_per_sides['front'] > 0 && $colors_per_sides['back'] == 0) {
			// Se suma el lado delantero con el primer multiplicador
			$colors_front = ($colors_per_sides['front'] > 3 ? 4 : $colors_per_sides['front']);
			$precio += $matriz[$colors_front][$cantidad][$tipoPlayera] * $matriz[$colors_front][$cantidad]["ladoA"];
		} else if($colors_per_sides['front'] == 0 && $colors_per_sides['back'] > 0) {
			// Se suma el lado trasero con el segundo multiplicador
			$colors_back = ($colors_per_sides['back'] > 3 ? 4 : $colors_per_sides['back']);
			$precio += $matriz[$colors_back][$cantidad][$tipoPlayera] * $matriz[$colors_back][$cantidad]["ladoA"];
		} else {
			$precio += 0.00;
		}
		// Escaneo de lados
		if($colors_per_sides['left'] > 0 && $colors_per_sides['right'] > 0) {
			// Se suma la manga izquierda con el primer multiplicador
			$colors_left = ($colors_per_sides['left'] > 3 ? 4 : $colors_per_sides['left']);
			$precio += $matriz[$colors_left][$cantidad][$tipoManga] * $matriz[$colors_left][$cantidad]["mangaA"];

			// Se suma la segunda manga con el segundo multiplicador
			$colors_right = ($colors_per_sides['right'] > 3 ? 4 : $colors_per_sides['right']);
			$precio += $matriz[$colors_right][$cantidad][$tipoManga] * $matriz[$colors_right][$cantidad]["mangaB"];

		} else if($colors_per_sides['left'] > 0 && $colors_per_sides['right'] == 0) {
			// Se suma la manga izquierda con el primer multiplicador
			$colors_left = ($colors_per_sides['left'] > 3 ? 4 : $colors_per_sides['left']);
			$precio += $matriz[$colors_left][$cantidad][$tipoManga] * $matriz[$colors_left][$cantidad]["mangaA"];
		} else if($colors_per_sides['left'] == 0 && $colors_per_sides['right'] > 0) {
			// Se suma el lado trasero con el segundo multiplicador
			$colors_right = ($colors_per_sides['right'] > 3 ? 4 : $colors_per_sides['right']);
			$precio += $matriz[$colors_right][$cantidad][$tipoManga] * $matriz[$colors_right][$cantidad]["mangaA"];
		} else {
			$precio += 0.00;
		}


		if ($precio == 0) {
			$precio = $valor_base * $matriz[1][1]["ladoA"];
		}

		return  number_format($precio, 2, ".", ",");
    }
}


if (! function_exists('getMultiplicador'))
{
    function getMultiplicador( $colors_per_sides = array("front" => 0, "back" => 0, "left" => 0, "right" => 0), $shirtWhite = true, $quantity = 1 )
    {
		$cantidades = array(1, 2, 3, 4, 5, 6, 10, 20, 30, 40, 50, 100, 200, 500, 1000);
		$sides = array("front", "back", "left", "right");
		$used = array("front" => false, "back" => false, "right" => false,  "left" => false);
		$used_anyone = false;
		$costs = array("front" => 0, "back" => 0, "left" => 0, "right" => 0);
		$precio = 0;

		$CI =& get_instance();
		$matriz = array();

		$sql = "SELECT DISTINCT(tipo_tinta) as tipo FROM Cotizador ORDER BY tipo_tinta ASC";
		$tipos_res = $CI->db->query($sql);
		$tipos = $tipos_res->result();

		// Generar matriz de tabla de cotizacion
		foreach($tipos as $tipo) {
			$matriz[$tipo->tipo] = array();
		}

		foreach($matriz as $tipo_tinta=>$arreglo) {

			$datos_res = $CI->db->get_where('Cotizador', array('tipo_tinta' => $tipo_tinta, 'tipo_estampado' => 1));
			$datos = $datos_res->result();

			foreach($datos as $dato) {
				$matriz[$tipo_tinta][$dato->cantidad_min] = array(
					'blanca' => $dato->costo_blanca,
					'color' => $dato->costo_color,
					'ladoA' => $dato->multiplicador_1,
					'ladoB' => $dato->multiplicador_2
				);
			}

			$datos_lado_res = $CI->db->get_where('Cotizador', array('tipo_tinta' => $tipo_tinta, 'tipo_estampado' => 2));
			$datos_lado = $datos_lado_res->result();

			foreach($datos_lado as $dato) {
				$matriz[$tipo_tinta][$dato->cantidad_min]['manga_blanca'] = $dato->costo_blanca;
				$matriz[$tipo_tinta][$dato->cantidad_min]['manga_color'] = $dato->costo_color;
				$matriz[$tipo_tinta][$dato->cantidad_min]['mangaA'] = $dato->multiplicador_1;
				$matriz[$tipo_tinta][$dato->cantidad_min]['mangaB'] = $dato->multiplicador_2;
			}
		}

		$tempkey =0;

		$comparativo = $quantity;

		foreach ($cantidades as $key => $cantidad) {
			if ($comparativo >= $cantidad) {
				$tempkey = $key;
			} else {
				break;
			}
		}

		$key = $tempkey;

		/* if (is_object($sku)) {
			$quantity = $sku->quantity;
			$valor_base = $sku->precio;
		}else{
			$valor_base = $sku;
		} */

		// Precio base de la playera sin importar
		$precio = $valor_base * $matriz[1][1]["ladoA"];

		$tipoPlayera = "color";
		if ($shirtWhite) {
			$tipoPlayera = "blanca";
		}

		// Escaneo de lados
		if($colors_per_sides['front'] > 0 && $colors_per_sides['back'] > 0) {
			// Se suma el lado delantero con el primer multiplicador
			$colors_front = ($colors_per_sides['front'] > 3 ? 4 : $colors_per_sides['front']);
			$precio += $matriz[$colors_front][$cantidad][$tipoPlayera] * $matriz[$colors_front][$cantidad]["ladoA"];

			// Se suma el lado trasero con el segundo multiplicador
			$colors_back = ($colors_per_sides['back'] > 3 ? 4 : $colors_per_sides['back']);
			$precio += $matriz[$colors_back][$cantidad][$tipoPlayera] * $matriz[$colors_back][$cantidad]["ladoB"];
		} else if($colors_per_sides['front'] > 0 && $colors_per_sides['back'] == 0) {
			// Se suma el lado delantero con el primer multiplicador
			$colors_front = ($colors_per_sides['front'] > 3 ? 4 : $colors_per_sides['front']);
			$precio += $matriz[$colors_front][$cantidad][$tipoPlayera] * $matriz[$colors_front][$cantidad]["ladoA"];
		} else if($colors_per_sides['front'] == 0 && $colors_per_sides['back'] > 0) {
			// Se suma el lado trasero con el segundo multiplicador
			$colors_back = ($colors_per_sides['back'] > 3 ? 4 : $colors_per_sides['back']);
			$precio += $matriz[$colors_back][$cantidad][$tipoPlayera] * $matriz[$colors_back][$cantidad]["ladoA"];
		} else {
			$precio += 0.00;
		}
		// Escaneo de lados
		if($colors_per_sides['left'] > 0 && $colors_per_sides['right'] > 0) {
			// Se suma la manga izquierda con el primer multiplicador
			$colors_left = ($colors_per_sides['left'] > 3 ? 4 : $colors_per_sides['left']);
			$precio += $matriz[$colors_left][$cantidad][$tipoPlayera] * $matriz[$colors_left][$cantidad]["mangaA"];

			// Se suma el lado trasero con el segundo multiplicador
			$colors_right = ($colors_per_sides['right'] > 3 ? 4 : $colors_per_sides['right']);
			$precio += $matriz[$colors_right][$cantidad][$tipoPlayera] * $matriz[$colors_back][$cantidad]["mangaB"];
		} else if($colors_per_sides['left'] > 0 && $colors_per_sides['right'] == 0) {
			// Se suma la manga izquierda con el primer multiplicador
			$colors_left = ($colors_per_sides['left'] > 3 ? 4 : $colors_per_sides['left']);
			$precio += $matriz[$colors_left][$cantidad][$tipoPlayera] * $matriz[$colors_left][$cantidad]["mangaA"];
		} else if($colors_per_sides['left'] == 0 && $colors_per_sides['right'] > 0) {
			// Se suma el lado trasero con el segundo multiplicador
			$colors_right = ($colors_per_sides['right'] > 3 ? 4 : $colors_per_sides['right']);
			$precio += $matriz[$colors_right][$cantidad][$tipoPlayera] * $matriz[$colors_back][$cantidad]["mangaA"];
		} else {
			$precio += 0.00;
		}


		if ($precio == 0) {
			$precio = $valor_base * $matriz[1][1]["ladoA"];
		}

		return number_format($precio, 2, ".", ",");

    }
}

if (! function_exists('check_team'))
{
    function check_team($options)
    {
        $team = array();
        if(is_array($options)) {
            if(isset($options['disenos']['vector']->front)) {
                $team['front'] = false;
                foreach($options['disenos']['vector']->front as $indice_front => $imagen) {
                    if($imagen->type == 'team') {
                        $team['front'] = true;
                    }
                }
            }

            if(isset($options['disenos']['vector']->back)) {
                $team['back'] = false;
                foreach($options['disenos']['vector']->back as $indice_back => $imagen) {
                    if($imagen->type == 'team') {
                        $team['back'] = true;
                    }
                }
            }

            if(isset($options['disenos']['vector']->left)) {
                $team['left'] = false;
                foreach($options['disenos']['vector']->left as $indice_left => $imagen) {
                    if($imagen->type == 'team') {
                        $team['left'] = true;
                    }
                }
            }

            if(isset($options['disenos']['vector']->right)) {
                $team['right'] = false;
                foreach($options['disenos']['vector']->right as $indice_right => $imagen) {
                    if($imagen->type == 'team') {
                        $team['right'] = true;
                    }
                }
            }

            $tiene_team = false;
            foreach($team as $indice_team => $valor) {
                if($valor) {
                    $tiene_team = true;
                }
            }

            return $tiene_team;
        }
    }
}
