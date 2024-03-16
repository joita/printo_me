<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Cart extends CI_Cart {

	public function __construct($params = array())
	{
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();

		// Are any config settings being passed manually?  If so, set them
		$config = is_array($params) ? $params : array();

		// Load the Sessions class
		$this->CI->load->driver('session', $config);

		// Grab the shopping cart array from the session table
		$this->_cart_contents = $this->CI->session->userdata('cart_contents');
		if ($this->_cart_contents === NULL)
		{
			// No cart exists so we'll set some base values
			$descuento             = new stdClass;
			$descuento->descuento  = 0;
			$descuento->id_cupon   = null;
			$descuento->id_cliente = null;
			$descuento->tipo       = null;
			$descuento->cupon      = null;
			$this->_cart_contents  = array('cart_total' => 0, 'total_items' => 0, "discounts" => $descuento);
		}

		log_message('info', 'Cart Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Save the cart array to the session DB
	 *
	 * @return	bool
	 */
	protected function _save_cart()
	{
		// Let's add up the individual prices and set the cart sub-total
		$this->_cart_contents['total_items'] = $this->_cart_contents['cart_total'] = 0;
		foreach ($this->_cart_contents as $key => $val)
		{
			// We make sure the array contains the proper indexes
			if ( ! is_array($val) OR ! isset($val['price'], $val['qty']))
			{
				continue;
			}

			$this->_cart_contents['cart_total'] += ($val['price'] * $val['qty']);
			$this->_cart_contents['total_items'] += $val['qty'];
			$this->_cart_contents[$key]['subtotal'] = ($this->_cart_contents[$key]['price'] * $this->_cart_contents[$key]['qty']);
		}

		// Is our cart empty? If so we delete it from the session
		if (count($this->_cart_contents) <= 3)
		{
			$this->CI->session->unset_userdata('cart_contents');

			// Nothing more to do... coffee time!
			return FALSE;
		}

		// If we made it this far it means that our cart has data.
		// Let's pass it to the Session class so it can be stored
		$this->CI->session->set_userdata(array('cart_contents' => $this->_cart_contents));

		// Woot!
		return TRUE;
	}

	protected function _save_cart_session()
	{
		if ($this->CI->session->has_userdata('login')) {
			$id_cliente = $this->CI->session->userdata('login')['id_cliente'];
			$this->CI->cart_modelo->save_cart($this->_cart_contents, $id_cliente);
			return TRUE;
		}
		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Total
	 *
	 * @return	int
	 */
	public function total()
	{
		return $this->_cart_contents['cart_total'];
	}

	// ------------------------------------------------------------------------

	/**
	 * Add Discount
	 *
	 * @return	bool
	 */
	public function add_coupon($name = NULL)
	{
		$query = $this->CI->db->get_where('Cupones', array('cupon' => $name));

		if ($query->num_rows() > 0) {
			$row = $query->row();
			$fecha_expirada = (strtotime($row->expira) >= strtotime(date("now")));
			$cantidad_restante = ($row->cantidad == NULL || $row->cantidad > 0);
			$cupon = ($this->CI->pedidos_modelo->use_cupon($this->CI->session->login['id_cliente'], $row->id));

			if (($fecha_expirada || $cantidad_restante ) && $cupon) {
				$descuento = new stdClass;
				$descuento->descuento  = $row->descuento;
				$descuento->id_cupon   = $row->id;
				$descuento->id_cliente = $row->id_cliente;
				$descuento->tipo       = $row->tipo;
				$descuento->cupon      = $row->cupon;

				$this->_cart_contents['discounts'] = $descuento;
				$this->_save_cart();
				$this->_update_cart_prices();
				return TRUE;
			}
		}

		$descuento = new stdClass;
		$descuento->descuento  = 0;
		$descuento->id_cupon   = null;
		$descuento->id_cliente = null;
		$descuento->tipo       = null;
		$descuento->cupon      = null;

		$this->_cart_contents['discounts'] = $descuento;
		$this->_save_cart();
		$this->_update_cart_prices();
		
		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Contents
	 *
	 * Returns the entire cart array
	 *
	 * @param	bool
	 * @return	array
	 */
	public function contents($newest_first = FALSE)
	{
		// do we want the newest first?
		$cart = ($newest_first) ? array_reverse($this->_cart_contents) : $this->_cart_contents;

		// Remove these so they don't create a problem when showing the cart table
		unset($cart['total_items']);
		unset($cart['cart_total']);
		unset($cart['discounts']);

		return $cart;
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Contents
	 *
	 * Returns the entire cart array
	 *
	 * @param	bool
	 * @return	array
	 */
	public function has_discount()
	{
		return ($this->_cart_contents['discounts']->descuento != 0);
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Contents
	 *
	 * Returns the entire cart array
	 *
	 * @param	bool
	 * @return	array
	 */
	public function get_discount()
	{
		return $this->_cart_contents['discounts']->descuento;
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Contents
	 *
	 * Returns the entire cart array
	 *
	 * @param	bool
	 * @return	array
	 */
	public function is_percentage()
	{
		return ($this->_cart_contents['discounts']->descuento < 1);
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Contents
	 *
	 * Returns the entire cart array
	 *
	 * @param	bool
	 * @return	array
	 */
	public function get_discount_total()
	{

		if ($this->_cart_contents['discounts']->descuento < 1) {
			 $discounts = $this->format_number( $this->total() - ($this->total() / (1 - $this->_cart_contents['discounts']->descuento)) );
			if ($discounts < 0) {
			 	return ($discounts * -1);
			}
			return $discounts ;
		}

		return $this->format_number($this->_cart_contents['discounts']->descuento );
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Contents
	 *
	 * Returns the entire cart array
	 *
	 * @param	bool
	 * @return	array
	 */
	public function get_discount_name()
	{
		return $this->_cart_contents['discounts']->cupon;
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Contents
	 *
	 * Returns the entire cart array
	 *
	 * @param	bool
	 * @return	array
	 */
	public function get_discount_id()
	{
		return $this->_cart_contents['discounts']->id_cupon;
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Contents
	 *
	 * Returns the entire cart array
	 *
	 * @param	bool
	 * @return	array
	 */
	public function get_discount_owner()
	{
		return $this->_cart_contents['discounts']->id_cliente;
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Contents
	 *
	 * Returns the entire cart array
	 *
	 * @param	bool
	 * @return	array
	 */
	public function get_discount_type()
	{
		$tipo = $this->_cart_contents['discounts']->tipo;
		switch ($tipo) {
			case 0:
				return "PROMO";
				break;

			case 1:
				return "REF";
				break;

			case 2:
				return "INFLUENCER";
				break;
			
			default:
				return "NONE";
				break;
		}
	}

	// ------------------------------------------------------------------------

	public function insert($items = array()){
		$result = parent::insert($items);

		if ($result) {
			$this->_update_cart_prices();

			$this->_save_cart_session();
			return TRUE;
		}
		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Update the cart
	 *
	 * This function permits the quantity of a given item to be changed.
	 * Typically it is called from the "view cart" page if a user makes
	 * changes to the quantity before checkout. That array must contain the
	 * product ID and quantity for each item.
	 *
	 * @param	array
	 * @return	bool
	 */
	public function update($items = array())
	{
		// Was any cart data passed?
		if ( ! is_array($items) OR count($items) === 0)
		{
			return FALSE;
		}


		// You can either update a single product using a one-dimensional array,
		// or multiple products using a multi-dimensional one.  The way we
		// determine the array type is by looking for a required array key named "rowid".
		// If it's not found we assume it's a multi-dimensional array

		$save_cart = FALSE;
		if (isset($items['rowid']))
		{
			if ($this->_update($items) === TRUE)
			{
				$save_cart = TRUE;
			}
		}
		else
		{
			if (isset($items[0]['rowid']))
			{
				foreach ($items as $val)
				{
					if (is_array($val) && isset($val['rowid']))
					{
						if ($this->_update($val) === TRUE)
						{
							$save_cart = TRUE;
						}
					}
				}
			}else{
				foreach ($items as $item) {
					$quantity = 0;
					foreach ($item as $val) {
						$quantity += $val['qty'];
					}
					foreach ($item as $val) {
						$row = $this->get_item($val['rowid']);

						if (!$row["options"]["enhance"]) {
							$sku = new stdClass();
							$sku->quantity = $val['qty'];
							$sku->precio_base = $row["options"]["calculadora"]["precio_base"];
							$shirtWhite = $row["options"]["calculadora"]["esBlanca"];
							$colors_per_sides = $row["options"]["calculadora"]["colores_totales"];
							$val["price"] = getCost($colors_per_sides, $shirtWhite, $quantity, $sku);
							$val["options"] = $row["options"];
							$val["options"]["price"] = $val["price"];
						}
						
						if ($this->_update($val) === TRUE)
						{
							$save_cart = TRUE;
						}else{
							$save_cart = FALSE;
						}
					}
				}
			}
		}

		// Save the cart data if the insert was successful
		if ($save_cart === TRUE)
		{
			$this->_save_cart();
			$this->_update_cart_prices();
			
			$this->_save_cart_session();
			return TRUE;
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	protected function _update_cart_prices()
	{

		if (!$this->has_discount()){
			foreach ($this->contents() as $rowid => $item) {
				// $product_discount = $item['options']['descuento'] / 100;
				if (isset($item['options']['precio_producto'])) {
					$product_price = $item['options']['precio_producto'] /100 * 100;
				}else{
					$product_price = $item['options']['price'] /100 * 100;
				}
				$final_price = $product_price;
				$type = "NONE";

				/* if ($product_discount != 0) {
					$final_price = $product_price - ($product_price * $product_discount);
					$type = "PRODUCT";

				} */

				if((isset($final_price) AND is_float($final_price)) || (isset($final_price) AND is_numeric($final_price))){
		    	$this->_cart_contents[$rowid]['options']["tipo_descuento"] = $type;
			    $this->_cart_contents[$rowid]['price'] = $final_price;
			  } 
			  $this->_save_cart();
		  } 

			return;
		} 

		// $discount = $this->get_discount();
		$porcentual = $this->is_percentage();
		$discount_to_use = $discount;

		foreach ($this->contents() as $rowid => $item) {
			
			//$product_discount = $item['options']['descuento'] / 100;
			$product_price = $item['options']['precio_producto'] /100 * 100;
			$final_price = $product_price;
			$type = "NONE";

			/* if ($porcentual) {

				if ($product_discount > $discount) {
					$discount_to_use = $product_discount;
					$type = "PRODUCT";
				}else{
					$discount_to_use = $discount;
					$type = "CART";
				}

				$final_price = $product_price - ($product_price * $discount_to_use);

			}else{

				switch (descuento($product_price, $product_discount, $discount)) {
					case 'CART':
						$final_price = $product_price - $discount;
						$type = "CART";
						break;
					case 'PRODUCT':
						$final_price = $product_price - ($product_price * $product_discount);
						$type = "PRODUCT";
						break;
					default:
						$final_price = $product_price;
						break;
				}

			} */

			if((isset($final_price) AND is_float($final_price)) || (isset($final_price) AND is_numeric($final_price))){
		    $this->_cart_contents[$rowid]['options']["tipo_descuento"] = $type;
		    $this->_cart_contents[$rowid]['price'] = $final_price;
		  }  
		}

		$this->_save_cart();
	}

	// --------------------------------------------------------------------

	/**
	 * Remove Item
	 *
	 * Removes an item from the cart
	 *
	 * @param	int
	 * @return	bool
	 */

	public function remove($rowid)
	{
		$save_cart = FALSE;

		$item_to_delete = $this->get_item($rowid);
		//$time = $item_to_delete["options"]["time"];
		unset($this->_cart_contents[$rowid]);
		if (!isset($this->_cart_contents[$rowid])) {
			$save_cart = TRUE;
		}
		$same_design = array();
		$quantity = 0;
		foreach ($this->contents() as $key => $row) {
			if ($row["options"]["time"] == $time && $row["rowid"] != $rowid) {
				$same_design[] = $row;
				$quantity += $row['qty'];
			}
		}

		foreach ($same_design as $key => $row) {
			
			$val = array();
			$val["rowid"] = $row["rowid"];
			$sku = new stdClass();
			$sku->quantity = $row['qty'];
			$sku->precio_base = $row["options"]["calculadora"]["precio_base"];
			$shirtWhite = $row["options"]["calculadora"]["esBlanca"];
			$colors_per_sides = $row["options"]["calculadora"]["colores_totales"];
			$val["price"] = getCost($colors_per_sides, $shirtWhite, $quantity, $sku);

			if ($this->_update($val) === TRUE){
				$save_cart = TRUE;
			}else{
				$save_cart = FALSE;
			}
		}

		// Save the cart data if the insert was successful
		if ($save_cart === TRUE)
		{
			$this->_save_cart();
			return TRUE;
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	
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
		
		return ($this->_cart_contents['cart_total']+$this->obtener_costo_envio())*$iva;
	}
	
	public function obtener_total($points = 0) {
		
		if (!is_null($this->CI->session->login['id_cliente'])) {
			$points = $this->CI->creditos_modelo->total_credito_cliente($this->CI->session->login['id_cliente'], $this->CI->cart->obtener_subtotal())->pagable;
		}else{
			$points = $this->CI->cart->obtener_subtotal();
		}

		$subtotal = ($this->obtener_costo_envio()*1 + $points);

		if ($subtotal < $this->obtener_costo_envio()) {
			$subtotal = $this->obtener_costo_envio();
		}

		return $subtotal;
		
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

	/**
		
	*/
	
	public function obtener_costo_envio() {
		
		$CI =& get_instance();
		 
		/* $configuracion_minimo_envio_res = $CI->db->get_where('Configuracion', array('nombre_configuracion_slug' => 'envio_gratis'));
		$configuracion_minimo_envio = $configuracion_minimo_envio_res->result();
		$minimo_gratis = $configuracion_minimo_envio[0]->valor_configuracion;
		
		$configuracion_costo_envio_res = $CI->db->get_where('Configuracion', array('nombre_configuracion_slug' => 'costo_envio'));
		$configuracion_costo_envio = $configuracion_costo_envio_res->result();
		$costo_envio = $configuracion_costo_envio[0]->valor_configuracion; */
		$costo_envio = 100;
		 
		$envio_gratis = false;

		$todos_envios_enhance = true;

		$envios_por_pagar = [0]; // Dejamos un envio de cajón qué es el grupal.

		foreach($this->contents() as $rowid => $content) {

			if ($content['options']['enhance']) {
				if (!in_array($content['options']['id_enhance'], $envios_por_pagar)) {
					$envios_por_pagar[] = $content['options']['id_enhance'];
				}
			}else{
				$todos_envios_enhance = false;
			}
		}

		if (!$todos_envios_enhance) {
			$total_envios = count($envios_por_pagar);
		}else{
			$total_envios = count($envios_por_pagar)-1;
		}
		
		return (($costo_envio*100)/100)*$total_envios;
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