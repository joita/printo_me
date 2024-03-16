<?php

if (! function_exists('clasificar_productos_pedido'))
{
    function clasificar_productos_pedido($pedido)
    {
        $CI =& get_instance();

        $informacion_pedido = array();
        $informacion_pedido['customs'] = array();
        $informacion_pedido['group_customs'] = array();
    	$informacion_pedido['design_ids'] = array();
    	$informacion_pedido['inmediatas'] = array();
    	$informacion_pedido['enhances'] = array();
    	$informacion_pedido['ventas_inmediatas'] = array();

    	$item_id = '';
    	$enhance_id = 0;

    	$i = 0;

    	// Customs
    	foreach($pedido->productos as $item) {
    		if($item->diseno != $item_id && !$item->id_enhance) {
    			$informacion_pedido['customs'][$i] = new stdClass();
    			$informacion_pedido['customs'][$i]->diseno = $item->diseno;
    			$informacion_pedido['customs'][$i]->id_producto = $item->id_producto;
    			$informacion_pedido['customs'][$i]->id_color = $item->id_color;
                $informacion_pedido['customs'][$i]->nombre_producto = $item->nombre_producto;
    			$item_id = $item->diseno;
    			$i++;
    		}
    	}

    	foreach($informacion_pedido['customs'] as $indice=>$custom) {

    		if(isset($custom->diseno)) {
    			$diseno = $custom->diseno;
    			$informacion_pedido['customs'][$indice]->tallas = array();

    			foreach($pedido->productos as $item) {
    				if($item->diseno == $diseno) {
    					$talla_cantidad = new stdClass();
    					$talla_cantidad->talla = $item->caracteristicas;
    					$talla_cantidad->cantidad = $item->cantidad_producto;
        				$talla_cantidad->id_sku = $item->id_sku;
    					array_push($informacion_pedido['customs'][$indice]->tallas, $talla_cantidad);
    				}
    			}
    		}
    	}

    	foreach($informacion_pedido['customs'] as $indice=>$custom) {
    		if(isset($custom->diseno)) {
    			$informacion_pedido['customs'][$indice]->diseno = json_decode($informacion_pedido['customs'][$indice]->diseno);
    			if(isset($informacion_pedido['customs'][$indice]->diseno->images->front)) {
    				$informacion_pedido['customs'][$indice]->front_image = $informacion_pedido['customs'][$indice]->diseno->images->front;
    			}
    			if(isset($informacion_pedido['customs'][$indice]->diseno->images->back)) {
    				$informacion_pedido['customs'][$indice]->back_image = $informacion_pedido['customs'][$indice]->diseno->images->back;
    			}
    			if(isset($informacion_pedido['customs'][$indice]->diseno->images->left)) {
    				$informacion_pedido['customs'][$indice]->left_image = $informacion_pedido['customs'][$indice]->diseno->images->left;
    			}
    			if(isset($informacion_pedido['customs'][$indice]->diseno->images->right)) {
    				$informacion_pedido['customs'][$indice]->right_image = $informacion_pedido['customs'][$indice]->diseno->images->right;
    			}
    		}
    	}

    	foreach($informacion_pedido['customs'] as $indice=>$custom) {
    		if(!isset($custom->diseno)) {
    			unset($informacion_pedido['customs'][$indice]);
    		}
    	}

    	// Enhances
    	foreach($pedido->productos as $item) {
    		if(!$item->diseno && $item->id_enhance != $enhance_id) {
    			$enhance = $CI->enhance_modelo->obtener_enhance($item->id_enhance);

                if(isset($enhance)) {
                    if($enhance->type == 'fijo') {

                        if(!in_array($item->id_enhance, $informacion_pedido['ventas_inmediatas'])){
                            array_push($informacion_pedido['ventas_inmediatas'], $item->id_enhance);
                        }
                    } else if($enhance->type == 'limitado') {
                        if(!in_array($item->id_enhance, $informacion_pedido['design_ids'])){
                            array_push($informacion_pedido['design_ids'], $item->id_enhance);
                        }

                    }
                }
    		}
    	}

    	$informacion_pedido['design_ids'] = array_unique($informacion_pedido['design_ids']);

    	$i = 0;

    	foreach($informacion_pedido['design_ids'] as $indice=>$did) {
            $pd_especifico = $CI->enhance_modelo->obtener_enhance($did);
            $corte_pd_especifico = $CI->enhance_modelo->obtener_corte($did);
    		$informacion_pedido['enhances'][$i] = new stdClass();
    		$informacion_pedido['enhances'][$i]->id_enhance = $did;
    		$informacion_pedido['enhances'][$i]->id_parent_enhance = $pd_especifico->id_parent_enhance;
    		$informacion_pedido['enhances'][$i]->estatus = $pd_especifico->estatus;
    		$informacion_pedido['enhances'][$i]->end_date = $pd_especifico->end_date;
    		$informacion_pedido['enhances'][$i]->tallas = array();
    		$informacion_pedido['enhances'][$i]->decision_produccion = (isset($corte_pd_especifico->id_corte) ? ($corte_pd_especifico->decision_produccion ? $corte_pd_especifico->decision_produccion : 0) : 0);

    		foreach($pedido->productos as $item) {
    			if($item->id_enhance == $informacion_pedido['enhances'][$i]->id_enhance) {
    				$talla_cantidad = new stdClass();
    				$talla_cantidad->talla = $item->caracteristicas;
    				$talla_cantidad->cantidad = $item->cantidad_producto;
    				$talla_cantidad->id_sku = $item->id_sku;
    				array_push($informacion_pedido['enhances'][$i]->tallas, $talla_cantidad);
    			}
    		}

    		$i++;
    	}

    	$informacion_pedido['inmediatas'] = array_unique($informacion_pedido['inmediatas']);

    	$i = 0;

    	foreach($informacion_pedido['ventas_inmediatas'] as $indice=>$did) {
    		$vi_especifica = $CI->enhance_modelo->obtener_enhance($did);
    		$informacion_pedido['inmediatas'][$i] = new stdClass();
    		$informacion_pedido['inmediatas'][$i]->id_enhance = $did;
    		$informacion_pedido['inmediatas'][$i]->id_parent_enhance = $vi_especifica->id_parent_enhance;
    		$informacion_pedido['inmediatas'][$i]->estatus = $vi_especifica->estatus;
    		$informacion_pedido['inmediatas'][$i]->tallas = array();

    		foreach($pedido->productos as $item) {
    			if($item->id_enhance == $informacion_pedido['inmediatas'][$i]->id_enhance) {
    				$talla_cantidad = new stdClass();
    				$talla_cantidad->talla = $item->caracteristicas;
    				$talla_cantidad->cantidad = $item->cantidad_producto;
    				$talla_cantidad->id_sku = $item->id_sku;
                    $talla_cantidad->nombre_producto = $item->nombre_producto;
    				array_push($informacion_pedido['inmediatas'][$i]->tallas, $talla_cantidad);
    			}
    		}

    		$i++;
    	}

        $custom_design = '';
        $k = 0;
        $lastk = 0;
        foreach($informacion_pedido['customs'] as $indice_custom => $custom) {
            if($custom_design != $custom->diseno->vector) {
                $informacion_pedido['group_customs'][$k] = array();
                array_push($informacion_pedido['group_customs'][$k], $indice_custom);
                $lastk = $k;
                $k++;
                $custom_design = $custom->diseno->vector;
            } else {
                array_push($informacion_pedido['group_customs'][$lastk], $indice_custom);
            }
        }

        return $informacion_pedido;
    }
}
