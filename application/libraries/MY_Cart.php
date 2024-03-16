<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Cart extends CI_Cart {

	var $product_name_rules = '\d\D';

	public function obtener_subtotal() {
		return $this->total();
	}

	public function iva() {
		return 1;
	}

	public function obtener_iva() {

		$CI =& get_instance();

		$iva_res = $CI->db->get_where('Configuracion', array('nombre_configuracion_slug' => 'iva'));
		$iva = $iva_res->result();
		$iva = $iva[0]->valor_configuracion;

		return number_format(($this->_cart_contents['cart_total']+$this->obtener_costo_envio())*$iva, 2, '.', '');
	}

	public function obtener_saldo_a_favor()
	{
		if (!is_null($this->CI->session->login['id_cliente'])) {
		    $this->CI->db->select("SUM(cantidad) AS saldo_a_favor")
                    ->from("HistorialSaldo")
                    ->where("id_cliente", $this->CI->session->login['id_cliente']);
			$info = $this->CI->db->get()->row();

			if($info->saldo_a_favor > 0.00) {
				$descuento = $info->saldo_a_favor;
			} else {
				$descuento = 0;
			}
		} else {
			$descuento = 0;
		}

		return number_format($descuento, 2, '.', '');
	}

    public function add_coupon($name = NULL)
    {
        $query = $this->CI->db->get_where('Cupones', array('cupon' => $name, 'estatus' => 1));

        if ($query->num_rows() > 0) {
            $row = $query->row();

            //Condiciones
            $cupon_vigente = strtotime($row->expira) - time();
            $cantidad_restante = ($row->cantidad > 0);
            $cupon = ($this->CI->pedidos_modelo->use_cupon($this->CI->session->login['id_cliente'], $row->id));
            $flag_producto = true;
            $flag_usuario = true;

            if($row->tipo != 5) {
                if (!is_null($row->id_cliente) && $row->id_cliente != 0) {
                    $flag_usuario = false;
                    foreach ($this->contents() as $content) {
                        $id_enhance = $content['options']['id_enhance'];
                        $result = $this->CI->cupones_modelo->obtener_usuario_de_enhance($id_enhance);
                        if ($row->id_cliente != $result->id_cliente) {
                            $flag_usuario = false;
                            break;
                        } else {
                            $flag_usuario = true;
                        }
                    }
                }
            }else{
                $cupon_vigente = 100;
                $cantidad_restante = true;
                //$cupon = true;
            }

            if($row->flag_producto == 1){
                $flag_producto = false;
                $qty = 0;
                foreach ($this->contents() as $content){
                    $qty += $content['qty'];
                }
                if($qty == 1){
                    $flag_producto = true;
                }
            }
            $producto_no_especial = true;
            $campanas = array();
            foreach ($this->contents() as $rowid => $content) {
                if ($content['options']['enhance']) {
                    if (!in_array($content['options']['id_enhance'], $campanas)) {
                        $campanas[] = $content['options']['id_enhance'];
                    }
                }
            }
            //aqui para productos especiales
            foreach($campanas as $campana){
                if($campana != 34924 && $campana != 34925){
                    $producto_no_especial = true;
                    break;
                }
                $producto_no_especial = false;
            }

            if (($cupon_vigente > 0 && $cantidad_restante) && $cupon && $flag_producto && $flag_usuario &&($this->obtener_subtotal() > $row->monto_minimo) && $producto_no_especial) {
                if($row->tipo == 4 && $this->obtener_subtotal() > 999 && $row->descuento == 0.00){
                    $mensaje = array('exito' => false, 'error' => 'No puede aplicar este cupón ya que en la compra mayor a $999.00 se cuenta con envío gratis');
                }elseif($row->tipo != 5){
                    $descuento = new stdClass();

                    if ($row->tipo == 3) {
                        $precio_total_customs = 0.00;
                        foreach ($this->contents() as $rowid => $content) {
                            if (!$content['options']['enhance']) {
                                $precio_total_customs += $content['qty'] * $content['price'];
                            }
                        }
                        $descuento->descuento = $precio_total_customs * $row->descuento;
                        $descuento->id_cupon = $row->id;
                        $descuento->id_cliente = $row->id_cliente;
                        $descuento->tipo = $row->tipo;
                        $descuento->cupon = $row->cupon;

                    }else {
                        $descuento->descuento = $row->descuento;
                        $descuento->id_cupon = $row->id;
                        $descuento->id_cliente = $row->id_cliente;
                        $descuento->tipo = $row->tipo;
                        $descuento->cupon = $row->cupon;
                    }

                    $this->CI->session->set_userdata('descuento_global', $descuento);

                    $mensaje = array('exito' => true, 'descuento' => $descuento);
                }else{
                    if(isset($this->CI->session->login['id_cliente']) && ($row->id_cliente != $this->CI->session->login['id_cliente'])){
                        $descuento = new stdClass();

                        if ($row->tipo == 3) {
                            $precio_total_customs = 0.00;
                            foreach ($this->contents() as $rowid => $content) {
                                if (!$content['options']['enhance']) {
                                    $precio_total_customs += $content['qty'] * $content['price'];
                                }
                            }
                            $descuento->descuento = $precio_total_customs * $row->descuento;
                            $descuento->id_cupon = $row->id;
                            $descuento->id_cliente = $row->id_cliente;
                            $descuento->tipo = $row->tipo;
                            $descuento->cupon = $row->cupon;

                        } else {
                            $descuento->descuento = $row->descuento;
                            $descuento->id_cupon = $row->id;
                            $descuento->id_cliente = $row->id_cliente;
                            $descuento->tipo = $row->tipo;
                            $descuento->cupon = $row->cupon;
                        }

                        $this->CI->session->set_userdata('descuento_global', $descuento);

                        $mensaje = array('exito' => true, 'descuento' => $descuento);
                    }else{
                        $mensaje = array();
                        do {
                            if ($row->id_cliente == $this->CI->session->login['id_cliente']) {
                                $mensaje['error'] = 'Lo sentimos no puedes utilizar tu propio cupón.';
                                break;
                            }

                            if (!isset($this->CI->session->login['id_cliente'])) {
                                $mensaje['error'] = 'Por favor inicie sesion antes de utilizar este cupón.';
                                break;
                            }
                            $mensaje['exito'] = false;
                        } while (0);

                        $descuento = new stdClass;
                        $descuento->descuento = 0;
                        $descuento->id_cupon = null;
                        $descuento->id_cliente = null;
                        $descuento->tipo = null;
                        $descuento->cupon = null;

                        $this->CI->session->unset_userdata('descuento_global', $descuento);
                        $this->CI->session->unset_userdata('envio_gratis');
                    }
                }

            }else {
                $mensaje = array();
                do {
                    if (!$cupon) {
                        $mensaje['error'] = 'Lo sentimos pero ya has usado este cupón.';
                        break;
                    }

                    if (!$flag_usuario) {
                        $mensaje['error'] = 'Lo sentimos todos los productos del pedido tienen que ser de '.$this->CI->cupones_modelo->obtener_nombre_tienda($row->id_cliente)->nombre_tienda;
                        break;
                    }

                    if (!$flag_producto) {
                        $mensaje['error'] = 'Lo sentimos pero el pedido contiene más de los productos permitidos por el cupón.';
                        break;
                    }

                    if ($this->obtener_subtotal() < $row->monto_minimo) {
                        $mensaje['error'] = 'Lo sentimos pero el monto mímimo subtotal aplicable para este cupón es de $' . $this->format_number($row->monto_minimo) . '.';
                        break;
                    }

                    if ($cupon_vigente < 0) {
                        $mensaje['error'] = 'Lo sentimos pero este cupón ha expirado.';
                        break;
                    }

                    if (!$cantidad_restante) {
                        $mensaje['error'] = 'Lo sentimos pero este cupón ya no está disponible.';
                        break;
                    }
                    if(!$producto_no_especial){
                        $mensaje['error'] = 'Lo sentimos pero este cupón no puede ser utilizado con productos especiales.';
                        break;
                    }
                    $mensaje['exito'] = false;
                } while (0);

                $descuento = new stdClass;
                $descuento->descuento = 0;
                $descuento->id_cupon = null;
                $descuento->id_cliente = null;
                $descuento->tipo = null;
                $descuento->cupon = null;

                $this->CI->session->unset_userdata('descuento_global', $descuento);
                $this->CI->session->unset_userdata('envio_gratis');
            }

        } else {
            $mensaje['error'] = 'Lo sentimos pero este cupón no existe.';
            $mensaje['exito'] = false;

            $descuento = new stdClass;
            $descuento->descuento  = 0;
            $descuento->id_cupon   = null;
            $descuento->id_cliente = null;
            $descuento->tipo       = null;
            $descuento->cupon      = null;

            $this->CI->session->unset_userdata('descuento_global', $descuento);
            $this->CI->session->unset_userdata('envio_gratis');
        }

        //$this->_cart_contents['discounts'] = $descuento;
        echo json_encode($mensaje);
    }

	public function obtener_total($points = 0) {

		if($this->CI->session->descuento_global) {
            $cupon = $this->CI->db->get_where('Cupones', array('id' => $this->CI->session->descuento_global->id_cupon, 'estatus' => 1))->row();

            // Condiciones
            if($cupon->tipo != 5) {
                $cupon_vigente = strtotime($cupon->expira) - time();
                $cantidad_restante = ($cupon->cantidad > 0);
                $cupon_usado = ($this->CI->pedidos_modelo->use_cupon($this->CI->session->login['id_cliente'], $cupon->id));
            }else{
                $cupon_vigente = 100;
                $cantidad_restante = true;
                $cupon_usado = true;
            }
            if (($cupon_vigente > 0 && $cantidad_restante) && $cupon_usado && ($this->obtener_subtotal() > $cupon->monto_minimo)) {
                if($cupon->tipo != '4') {
                    if ($this->CI->session->descuento_global->descuento > 0 && $this->CI->session->descuento_global->descuento < 1 && $cupon->tipo != 3) {
                        if (($this->obtener_subtotal() * (1 - $cupon->descuento)) != ($this->obtener_subtotal() * (1 - $this->CI->session->descuento_global->descuento))) {
                            $descuento = new stdClass();
                            $descuento->descuento = $cupon->descuento;
                            $descuento->id_cupon = $cupon->id;
                            $descuento->id_cliente = $cupon->id_cliente;
                            $descuento->tipo = $cupon->tipo;
                            $descuento->cupon = $cupon->cupon;

                            $this->CI->session->set_userdata('descuento_global', $descuento);
                        }
                        
                        if($cupon->tipo == '1' && $this->obtener_subtotal()>999){
                            //para aplicar cupon
                            return ($this->obtener_subtotal()  * (1 - $this->CI->session->descuento_global->descuento)) - $this->obtener_saldo_a_favor();
                        }else{
                            return ($this->obtener_subtotal()  * (1 - $this->CI->session->descuento_global->descuento)) - $this->obtener_saldo_a_favor() + $this->obtener_costo_envio();
                        }
                        
                    } else {
                        if ($cupon->tipo != 3) {
                            $monto_descuento = number_format($this->obtener_subtotal() - $cupon->descuento, 2, '.', '');
                            if ($monto_descuento != $this->obtener_subtotal() - $this->CI->session->descuento_global->descuento) {
                                $descuento = new stdClass();
                                $descuento->descuento = $cupon->descuento;
                                $descuento->id_cupon = $cupon->id;
                                $descuento->id_cliente = $cupon->id_cliente;
                                $descuento->tipo = $cupon->tipo;
                                $descuento->cupon = $cupon->cupon;

                                $this->CI->session->set_userdata('descuento_global', $descuento);
                            }

                        } else {

                            $precio_total_customs = 0.00;
                            foreach ($this->contents() as $rowid => $content) {
                                if (!$content['options']['enhance']) {
                                    $precio_total_customs += $content['qty'] * $content['price'];
                                }
                            }

                            if ($precio_total_customs == 0) {
                                $this->CI->session->unset_userdata('descuento_global');
                                $this->CI->session->unset_userdata('envio_gratis');

                                return $this->obtener_subtotal() + $this->obtener_costo_envio() - $this->obtener_saldo_a_favor();
                            } else if ($precio_total_customs > 0) {
                                $monto_descuento = number_format($precio_total_customs * $cupon->descuento, 2, '.', '');

                                if ($monto_descuento != $this->obtener_subtotal() * $this->CI->session->descuento_global->descuento) {
                                    $descuento = new stdClass();
                                    $descuento->descuento = $monto_descuento;
                                    $descuento->id_cupon = $cupon->id;
                                    $descuento->id_cliente = $cupon->id_cliente;
                                    $descuento->tipo = $cupon->tipo;
                                    $descuento->cupon = $cupon->cupon;

                                    $this->CI->session->set_userdata('descuento_global', $descuento);
                                }
                            }

                        }
                        if($this->obtener_subtotal() > 999 || $cupon->tipo == '1' && $this->obtener_subtotal() > 999){
                            $this->CI->session->set_userdata('envio_gratis', 'gratis');
                            return ($this->obtener_subtotal() - $this->obtener_saldo_a_favor() - $this->CI->session->descuento_global->descuento); 
                        }else{
                            $this->CI->session->unset_userdata('envio_gratis');
                            return ($this->obtener_subtotal() - $this->obtener_saldo_a_favor() - $this->CI->session->descuento_global->descuento) + $this->obtener_costo_envio();
                        }
                    }
                }else{
                    if($cupon->tipo == '4' && $cupon_usado){
                        if($this->CI->session->descuento_global->descuento > 0 && $this->CI->session->descuento_global->descuento < 1){
                            $this->CI->session->set_userdata('envio_gratis', 'gratis');
                            $this->CI->session->set_userdata('envio_descuento', 'enviodescuento');
                            return ($this->obtener_subtotal()  * (1 - $this->CI->session->descuento_global->descuento)) - $this->obtener_saldo_a_favor();
                        }elseif($this->obtener_subtotal() < 999){
                            $this->CI->session->set_userdata('envio_gratis', 'gratis');
                            $this->CI->session->unset_userdata('envio_descuento');
                            return ($this->obtener_subtotal() - $this->obtener_saldo_a_favor() - $this->CI->session->descuento_global->descuento);                                 
                        }else{
                            $this->CI->session->set_userdata('envio_gratis', 'gratis');
                            $this->CI->session->unset_userdata('envio_descuento');
                            return ($this->obtener_subtotal() - $this->obtener_saldo_a_favor() - $this->CI->session->descuento_global->descuento);       
                        }                
                    }else{
                        $this->CI->session->unset_userdata('envio_gratis');
                        $this->CI->session->unset_userdata('envio_descuento');
                        return $this->obtener_subtotal() - $this->obtener_saldo_a_favor();
                    }
                }
            } else {
                $this->CI->session->unset_userdata('descuento_global');
                $this->CI->session->unset_userdata('envio_descuento');
                return $this->obtener_subtotal() + $this->obtener_costo_envio() - $this->obtener_saldo_a_favor();
            }
		} else {
            /*if($this->obtener_subtotal() > 999){
                $this->CI->session->set_userdata('envio_gratis', 'gratis');
                return $this->obtener_subtotal() - $this->obtener_saldo_a_favor();
            }else{*/
               $this->CI->session->unset_userdata('envio_gratis');
               $this->CI->session->unset_userdata('envio_descuento');
                return $this->obtener_subtotal() + $this->obtener_costo_envio() - $this->obtener_saldo_a_favor();
            //}
		} 
	}

	public function obtener_peso_total() {
		$peso = 0.00;
		foreach($this->_cart_contents as $rowid => $content) {
			if($rowid != 'cart_total' && $rowid != 'total_items') {
				$peso += $content['options']['peso']*$content['qty'];
			}
		}
		return $peso;
	}

	public function obtener_costo_envio() {

		$CI =& get_instance();
        $direccion = $CI->db->get_where('DireccionesPorCliente', array('id_direccion' => $CI->session->id_direccion_pedido))->row();
        $CI->db->select('ciudad_asentamiento');
        $CI->db->from('Asentamientos');
        $CI->db->where('MATCH(codigo_postal) AGAINST ("'.$direccion->codigo_postal.'")', NULL, false);
        $CI->db->where('MATCH(nombre_asentamiento) AGAINST ("'.$direccion->linea2.'")', NULL, false);
        $verificacion = $CI->db->get()->result();
        $test = false;
        if($verificacion[0]->ciudad_asentamiento == 'Mérida'){
            $test = true;
        }
        $campanas = array();
        foreach ($this->contents() as $rowid => $content) {
            if ($content['options']['enhance']) {
                if (!in_array($content['options']['id_enhance'], $campanas)) {
                    $campanas[] = $content['options']['id_enhance'];
                }
            }
        }
        //productos especiales
        $especial = false;
        foreach($campanas as $campana){
            if($campana != 34924 && $campana != 34925){
                $especial = false;
                break;
            }
            $especial = true;
        }
        foreach ($this->contents() as $content) {
            if ($content['options']['id_producto'] == 42) {
                $especial = true;
                break;
            }
            $especial = false;
        }
        if($especial){
            return 0;
        }


        if ($test) {
            $customs = 0;
            foreach ($this->contents() as $rowid => $content) {
                if (!$content['options']['enhance']) {
                    $customs += $content['qty'];
                }
            }

            if(sizeof($campanas) == 0 && $customs == 0){
                return 0;
            }else{
                return 150;
            }


        } else {
            if ($CI->session->recoger == 'gratis') {
                return 0;
            } else {

                //$envios_por_pagar = array();

                //Contar productos custom
                $customs = 0;
                foreach ($this->contents() as $rowid => $content) {
                    if (!$content['options']['enhance']) {
                        $customs += $content['qty'];
                    }
                }


                $campanas = array();
                // Asignar indices de campana
                foreach ($this->contents() as $rowid => $content) {
                    if ($content['options']['enhance']) {
                        if (!in_array($content['options']['id_enhance'], $campanas)) {
                            $campanas[] = $content['options']['id_enhance'];
                        }
                    }
                }

                if(sizeof($campanas) == 0 && $customs == 0){
                    return 0;
                }else{
                    return 150;
                }
                    /*$costos_separados_campanas = array();
                    if (sizeof($campanas) > 0) {
                        foreach ($campanas as $id_enhance) {
                            $productos_campana = 0;
                            foreach ($this->contents() as $rowid => $content) {
                                if ($content['options']['enhance']) {
                                    if ($id_enhance == $content['options']['id_enhance'] && $content['options']['tipo_enhance'] != 'fijo') {
                                        if ($content['options']['id_parent_enhance'] == 0) {
                                            $productos_campana += $content['qty'];
                                        } else {
                                            if (!in_array($content['options']['id_parent_enhance'], $campanas)) {
                                                $productos_campana += $content['qty'];
                                            }
                                        }
                                    }
                                }
                            }

                            foreach ($this->contents() as $rowid => $content) {
                                if ($content['options']['enhance']) {
                                    if ($id_enhance == $content['options']['id_enhance'] && $content['options']['tipo_enhance'] == 'fijo') {
                                        $customs += $content['qty'];
                                    }
                                }
                            }

                            if ($productos_campana > 0) {
                                if ($productos_campana <= 25) {
                                    $costos_separados_campanas[$id_enhance] = 135;
                                } else {
                                    $costos_separados_campanas[$id_enhance] = 135 + (($productos_campana - 25) * 0);
                                }
                            } else {
                                $costos_separados_campanas[$id_enhance] = 0;
                            }
                        }

                        $envios_por_pagar['campanas'] = 0;
                        foreach ($costos_separados_campanas as $costo_campana) {
                            $envios_por_pagar['campanas'] += $costo_campana;
                        }

                    } else {
                        $envios_por_pagar['campanas'] = 0;
                    }

                    // Calcular costo de envio de productos custom
                    if ($customs > 0) {
                        if ($customs <= 25) {
                            $envios_por_pagar['customs'] = 135;
                        } else {
                            $envios_por_pagar['customs'] = 135 + (($customs - 25) * 0);
                        }
                    } else {
                        $envios_por_pagar['customs'] = 0;
                    }

                    return number_format(((($envios_por_pagar['customs'] + $envios_por_pagar['campanas']) * 100) / 100), 2, '.', '');
                }*/


            }
        }

	}

	public function hay_productos_envio_gratis() {
		$envio_gratis = false;
		foreach($this->contents() as $rowid => $content) {
			if(isset($content['options']['envio_gratis'])) {
				if($content['options']['envio_gratis'] == 1) {
					$envio_gratis = true;
				}
			}
		}

		return $envio_gratis;
	}

	public function obtener_ids_en_carrito() {
		$ids_productos = array();
		foreach($this->contents() as $row => $item) {
			array_push($ids_productos, $item['id']);
		}
		return $ids_productos;
	}
}
