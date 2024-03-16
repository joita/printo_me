<?php

class Cart_modelo extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper("cart");
	}

	/*
	 * Esta función checa si existe un carrito en la base de datos
	 * si existe devuelve true, si no devuelve false
	*/
	public function tiene_carrito_cliente($id_cliente)
	{
		$this->db->select('carrito_en_sesion, carrito_fecha_actualizacion')
				 ->from('Clientes')
				 ->where('id_cliente', $id_cliente);
		$carrito_res = $this->db->get();
		$carrito = $carrito_res->result();

		if($carrito[0]->carrito_en_sesion != '') {
			return $carrito[0];
		} else {
			return false;
		}
	}

	/*
	 * Esta función obtiene el carrito que existe en la base de datos
	 * y lo mezcla con el que está en sesión
	*/
	public function mezclar_carrito($id_cliente)
	{
		$carrito = $this->tiene_carrito_cliente($id_cliente);

		if($carrito) {

			// Decodificamos el carrito de la base de datos
			$carrito->carrito_en_sesion = json_decode($carrito->carrito_en_sesion);

            //print_r($carrito->carrito_en_sesion);

			// Lo mezclamos con el carrito en sesion
			foreach($this->cart->contents() as $cart_item) {
				$item = array(
					'id'		=> $cart_item['id'],
					'qty'		=> $cart_item['qty'],
					'price'		=> $cart_item['price'],
					'name'		=> $cart_item['name'],
					'options'	=> $cart_item['options']
				);

				$item = json_encode($item);
				$item = json_decode($item);

				array_push($carrito->carrito_en_sesion, $item);
			}

			$customs = $this->recuperar_customs($carrito->carrito_en_sesion);
			$campanas = $this->recuperar_campanas($carrito->carrito_en_sesion);

			// Destruimos el carrito existente
			$this->cart->destroy();

			foreach($customs as $custom) {
				$this->agregar_interno_custom($custom);
			}

			foreach($campanas as $campana) {
				$this->agregar_interno_campana($campana);
			}

			$this->actualizar_carrito($id_cliente);

		} else {

			$this->actualizar_carrito($id_cliente);
		}
	}

	/*
	 * Esta función actualiza el carrito en la base de datos
	 * cuando se agrega un nuevo producto o cuando se mezcla
	*/
	public function actualizar_carrito($id_cliente)
	{
		$items = array();

		foreach($this->cart->contents() as $cart_item) {
			$item = array(
				'id'		=> $cart_item['id'],
				'qty'		=> $cart_item['qty'],
				'price'		=> $cart_item['price'],
				'name'		=> $cart_item['name'],
				'options'	=> $cart_item['options']
			);

			array_push($items, $item);
		}

		$this->db->where('id_cliente', $id_cliente);
		$db_cart = new stdClass();
		$db_cart->carrito_en_sesion = json_encode($items);
		$db_cart->carrito_fecha_actualizacion = date("Y-m-d H:i:s");
		$db_cart->abandono_fecha_envio = NULL;
		$db_cart->abandono_numero_envio = 0;

		$this->db->update('Clientes', $db_cart);
	}

	/*
	 * Esta función actualiza el carrito en la base de datos
	 * cuando se agrega un nuevo producto o cuando se mezcla
	 * funciona para invitados
	*/
	public function actualizar_carrito_invitado($email)
	{
		$items = array();

		foreach($this->cart->contents() as $cart_item) {
			$item = array(
				'id'		=> $cart_item['id'],
				'qty'		=> $cart_item['qty'],
				'price'		=> $cart_item['price'],
				'name'		=> $cart_item['name'],
				'options'	=> $cart_item['options']
			);

			array_push($items, $item);
		}

		$this->db->where('email_cliente', $email);
		$db_cart = new stdClass();
		$db_cart->carrito_en_sesion = json_encode($items);
		$db_cart->carrito_fecha_actualizacion = date("Y-m-d H:i:s");

		$this->db->update('ClientesInvitados', $db_cart);
	}

	/*
	 * Esta función elimina el carrito guardado de la base de datos
	 * se usa o cuando se termina una compra o cuando se queda activa demasiado tiempo
	*/
	public function borrar_carrito($id_cliente, $total = 0.00, $saldo_a_favor_anterior = 0.00, $metodo_pago = 0)
	{
		$this->db->where('id_cliente', $id_cliente);
		$db_cart = new stdClass();
		$db_cart->carrito_en_sesion = NULL;
		$db_cart->carrito_fecha_actualizacion = NULL;

		$this->db->update('Clientes', $db_cart);

		//resta a saldo a favor
        if($metodo_pago != 0) {
            $saldo = new stdClass();
            $saldo->cantidad = ($saldo_a_favor_anterior + $total) * (-1);
            $saldo->fecha = date("Y-m-d H:i:s");
            $saldo->id_cliente = $id_cliente;
            $saldo->motivo = "Saldo utilizado en Pedido";

            $this->db->insert("HistorialSaldo", $saldo);
        }

	}

	public function borrar_carrito_invitado($email)
	{
		$this->db->where('email_cliente', $email);
		$this->db->delete('ClientesInvitados');
	}

	private function recuperar_customs($sesion)
	{
		$customs = array();
		$item_id = '';

		foreach($sesion as $item) {
			$options = $item->options;
			if(isset($options->id_diseno)) {
				//echo 'id_diseno: '.$options->id_diseno;
				//array_push($unique_designs, $options->id_diseno);
				if($options->id_diseno != $item_id) {

					$cliparts = array();
					foreach($item->options->disenos->vector as $lado=>$vectores) {
						if(count($item->options->disenos->vector->$lado) > 0) {
							foreach($item->options->disenos->vector->$lado as $vector) {
								if(isset($vector->clipart_id)) {
									$cliparts[$lado][] = $vector->clipart_id;
								}
							}
						}
					}

					$customs[] = array(
						'product_id' 		=> $item->id,
						'colors'			=> array($options->disenos->color),
						'quantity'			=> 0,
						'design'			=> array(
							'vectors' => json_encode($item->options->disenos->vector),
							'images'  => (array)$item->options->disenos->images,
							'colores' => (isset($item->options->disenos->colores) ? $item->options->disenos->colores : array())
						),
						'design_id'			=> $options->id_diseno,
						'fonts'				=> '',
						'cliparts'			=> $cliparts,
						'total_colors'		=> (array)$options->calculadora->colores_totales
					);

					$item_id = $options->id_diseno;
				}
			}
		}

		$item_id = '';
		foreach($customs as $indice=>$custom) {
			foreach($sesion as $item) {
				$options = $item->options;
				if(isset($options->id_diseno)) {
					if($options->id_diseno == $custom['design_id']) {
						$customs[$indice]['quantity'] += $item->qty;
						$customs[$indice]['sizes'][] = array(
							'talla' => $options->sku,
							'cantidad' => $item->qty
						);
					}

				}
			}
		}

		foreach($customs as $indice => $custom) {
			$customs[$indice]['precio'] = $this->cotizar_interno($custom);
		}

		return $customs;
	}

	private function recuperar_campanas($sesion)
	{
		$campanas = array();
		foreach($sesion as $item) {
			$options = $item->options;
			if(isset($options->id_enhance)) {
                if($options->id_enhance != 0) {
                    $campana = array(
    					'id_producto'	=> $item->id,
    					'id_sku'		=> $item->options->sku,
    					'cantidad'		=> $item->qty,
    					'id_enhance'	=> $item->options->id_enhance,
    					'tipo_enhance'	=> $item->options->tipo_enhance,
                        'id_parent_enhance' => $item->options->id_parent_enhance
    				);
    				array_push($campanas, $campana);
                }
			}
		}

		return $campanas;
	}

	// Cotizar interno
	// funcion que se usa para recotizar
	// 1. recuperacion de carrito de sesion
	// 2. cambio de cantidades en el carrito
	private function cotizar_interno($data)
	{
		// Tallas
		$tallas   = $data['sizes'];
		$quantity = 0;
		$skus = array();

		//buscamos los productos por sku
		foreach ($tallas as $talla) {
			$item = $this->catalogo_modelo->obtener_producto_sku_por_id($talla["talla"], $talla["cantidad"]);
			$item->precio_base = $item->precio;
			$quantity += $item->quantity;

			if($item->quantity > 0) array_push($skus, $item);
		}

		$colors     = $data['colors'];

		$esBlanca = false;

		if(isset($colors[0])) {
			if ($colors[0] == "FFFFFF" || $colors[0] == "FFF" || $colors[0] == "ffffff" || $colors[0] == "fff") {
				$esBlanca = true;
			}
		}

		if ($quantity < 1 ) $quantity = 1;
		foreach ($skus as $cantidad) {
			if ($quantity < $cantidad->cantidad_inicial) {
				break;
			}
		}

		$total_colors = $data['total_colors'];
		//$print = $data['print'];

		$finals = array();

		$texts = array();

		$next = getNextQuotes($quantity);

		for ($i=0; $i < count($skus); $i++) {
			$talla = json_decode($skus[$i]->caracteristicas)->talla;
			$final = new stdClass;
			$final->talla = $talla;
			$final->precio_next = null;
			$final->precio_second = null;
			$final->precio = getCost($total_colors, $esBlanca, $quantity, $skus[$i]);
			$finals[]  = $final;
		}

		$cotizado = new stdClass;
		$cotizado->original = array();
		$cotizado->first = array();
		$cotizado->second = array();

		foreach ($finals as $key => $value) {
			$cotizado->original[] = $value->precio;
			$cotizado->first[]    = $value->precio_next;
			$cotizado->second[]   = $value->precio_second;
		}

		$original = array_sum($cotizado->original) / count($cotizado->original);
		$first = array_sum($cotizado->first) / count($cotizado->first);
		$second = array_sum($cotizado->second) / count($cotizado->second);

		return $this->cart->format_number($original);
	}

	// Funcion para agregar a carrito
	// 1. Recuperación de carrito de sesión
	// 2. Modificar cantidades
	private function agregar_interno_custom($data) {

		$fonts = array();

		//we process te vector for being able to be saved in the database
		$vectors = json_decode($data['design']['vectors']);

		foreach (get_object_vars($vectors) as $key => $value) {
			$new_side = [];
			foreach (get_object_vars((object)$value) as $k => $v) {
				if(isset($v->{'fontFamily'})) {
					if($v->{'fontFamily'} != "") $fonts[] = $v->{'fontFamily'};
				}
				$v->{'svg'} = htmlentities($v->{'svg'});
				$new_side[] = $v;
			}
			$vectors->{$key} = $new_side;
		}

		//$vectors = json_encode($vectors);

		$data['fonts'] = $fonts;
		$data['design']['vectors'] = $vectors;


		// get data post
		$product_id   = $data['product_id'];

		//buscamos el producto
		$product = $this->catalogo_modelo->obtener_producto_con_id($product_id);
		$nombre = $product->nombre_producto;

		// Tallas
		$tallas   = $data['sizes'];
		$quantity = 0;
		$skus = array();

		//buscamos los productos por sku
		foreach ($tallas as $talla) {
			$item = $this->catalogo_modelo->obtener_producto_sku_por_id($talla["talla"], $talla["cantidad"]);
			$item->precio_base = $item->precio;
			$quantity += $item->quantity;

			if($item->quantity > 0) array_push($skus, $item);
		}

		$colors     = $data['colors'];
		$esBlanca = false;
		if(isset($colors[0])) {
			if ($colors[0] == "FFFFFF" || $colors[0] == "FFF" || $colors[0] == "ffffff" || $colors[0] == "fff") {
				$esBlanca = true;
			}
		}

		if ($quantity < 1 ) $quantity = 1;
		foreach ($skus as $cantidad) {
			if ($quantity < $cantidad->cantidad_inicial) {
				break;
			}
		}

		$total_colors = $data['total_colors'];

		for ($i=0; $i < count($skus); $i++) {
			$skus[$i]->precio_final = getCost($total_colors, $esBlanca, $quantity, $skus[$i]);
		}

		if(isset($data['design_id'])) {
			$mismo_diseno = $data['design_id'];
		} else {
			$mismo_diseno = md5(time());
		}

		foreach ($skus as $sku) {

			$caracteristicas = json_decode($sku->caracteristicas);
			$talla = "";

			foreach ($caracteristicas as $key => $value) {
				$talla.= $value;
			}



			// add cart
			$item   = array(
				'id'          => $sku->id_producto,
				'qty'         => $sku->quantity,
				'name'        => $nombre,
				'price'       => $sku->precio_final,
				'options'     => array(
					'sku'       => $sku->id_sku,
					'id_diseno'      => $mismo_diseno,
					'calculadora' => array(
						'precio_base'   => $sku->precio_base,
						'esBlanca' => $esBlanca,
						'colores_totales' => $total_colors,
					),
					'talla'  => $talla,
					'enhance'  => false,
					'price'  => $sku->precio_final,
					'marca'  => $sku->nombre_marca,
					'codigo_color' => color_awesome($sku->codigo_color),
					'disenos' => array(
						'color' => $data['colors'][key($data['colors'])],
						'colores' => (isset($data['design']['colores']) ? $data['design']['colores'] : array()),
						'images' => $data['design']['images'],
						'vector' => $data['design']['vectors'],
						'fonts' => $data['fonts']
					)
				)
			);

			$this->cart->insert($item);
		}

		return true;

		//redirect('carrito');
	}

	private function agregar_interno_campana($datos) {

		$id_producto = $datos['id_producto'];
		$id_sku = $datos['id_sku'];
		$opciones = array();

		$has_enhance = true;
		$id_enhance = $datos['id_enhance'];
		$producto = $this->catalogo_modelo->obtener_enhanced_con_id($id_enhance);
		$id_producto = $producto->id_enhance;

		$opciones["precio_producto"] = $producto->price;

		$sku = $this->productos_modelo->obtener_info_sku($id_sku);
		$color = $this->productos_modelo->obtener_info_color($sku->id_color);
		$fotografia = $this->productos_modelo->obtener_foto_principal_color($sku->id_color, $id_producto);

		$cantidad = $datos['cantidad'];

		$opciones['imagen'] = $fotografia->ubicacion_base.$fotografia->fotografia_chica;
		$opciones['peso'] = $producto->peso_producto;
		$opciones['devolucion'] = $producto->aplica_devolucion;
		$opciones['envio_gratis'] = $producto->envio_gratis;
		$opciones['marca'] = $producto->nombre_marca;
		$opciones['sku'] = $id_sku;
		$opciones['talla'] = $sku->talla_completa;
		$opciones['color'] = $color->nombre_color;
		$opciones['enhance'] = $has_enhance;
		//$opciones['time'] = strtotime("now");
		$opciones['images'] = array(
			"front" => $producto->front_image,
			"back" => $producto->back_image,
			"left" => $producto->left_image,
			"right" => $producto->right_image
		);
		$opciones['codigo_color'] = $color->codigo_color;
		$opciones["id_enhance"] = $id_enhance;
        $opciones['id_parent_enhance'] = $producto->id_parent_enhance;
		$opciones["tipo_enhance"] = $producto->type;

		$producto_por_agregar = array(
			'id' => $producto->id_producto,
			'qty' => $cantidad,
			'price' => $producto->price,
			'name' => convert_accented_characters($producto->name),
			'options' => $opciones
		);

		$this->cart->insert($producto_por_agregar);
		return true;
		//redirect('carrito');
	}

}
