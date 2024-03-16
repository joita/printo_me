<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrito extends MY_Controller {

	public $datos = array();

	public function __construct()
	{
		parent::__construct();
		$this->datos['mouseflow'] = true;
		$this->load->helper("cart");
	}

	public function index() {

		if(uri_string() == 'carrito' && $this->cart->total_items() == 0) {
			redirect('carrito/vacio');
		}
		// Config
		$datos_header['seccion_activa'] = 'carrito';
		$datos_header['meta']['title'] = 'Tu carrito de compras | printome.mx';
		$datos_header['meta']['description'] = 'Tu carrito - diseña y personaliza tu producto en línea, envío exprés a todo México.';
		$datos_header['meta']['imagen'] = '';
        $datos_header['recibir'] = fecha_recepcion(date("N"));

		$this->load->view('header', $datos_header);

		if($this->cart->total_items() > 0) {
			$this->load->view('carrito/despliegue');
			//$this->load->view('carrito/similares', array('ids_producto' => $this->cart->obtener_ids_en_carrito(), 'titulo' => 'También te pueden interesar', "descuento_global" => $this->descuento_global));
		} else {
			$this->load->view('carrito/vacio');
			//$this->load->view('carrito/similares', array( 'ids_producto' => array(), 'titulo' => 'Productos que te pueden interesar', "descuento_global" => $this->descuento_global));
		}

		$this->load->view('footer');
	}

	public function agregar($nombre_tienda_slug = null) {

		$id_producto = $this->input->post('id_producto');
		$id_sku = $this->input->post('id_sku');
		$opciones = array();

		$has_enhance = true;
		$id_enhance = $this->input->post('id_enhance');
		$producto = $this->catalogo_modelo->obtener_enhanced_con_id($id_enhance);
		$id_producto = $producto->id_enhance;
		$id_color = $producto->id_color;

		$opciones["precio_producto"] = $producto->price;

		$sku = $this->productos_modelo->obtener_info_sku($id_sku);
		$color = $this->productos_modelo->obtener_info_color($sku->id_color);
		$fotografia = $this->productos_modelo->obtener_foto_principal_color($sku->id_color, $id_producto);

		$cantidad = $this->input->post('cantidad');

		$opciones['imagen'] = $fotografia->ubicacion_base.$fotografia->fotografia_chica;
		$opciones['peso'] = $producto->peso_producto;
		$opciones['devolucion'] = $producto->aplica_devolucion;
		$opciones['envio_gratis'] = $producto->envio_gratis;
		$opciones['marca'] = $producto->nombre_marca;
		$opciones['sku'] = $id_sku;
		$opciones['talla'] = $sku->talla_completa;
		$opciones['color'] = $color->nombre_color;
		$opciones['enhance'] = $has_enhance;
		$opciones['images'] = array(
			"front" => $producto->front_image,
			"back" => $producto->back_image,
			"left" => $producto->left_image,
			"right" => $producto->right_image
		);
		$opciones['codigo_color'] = $color->codigo_color;
		$opciones["id_enhance"] = $id_enhance;
        $opciones["id_producto"] = $producto->id_producto;
		$opciones['id_parent_enhance'] = $producto->id_parent_enhance;
		$opciones['tipo_enhance'] = $this->input->post('tipo_enhance');

		$producto_por_agregar = array(
			'id' => $producto->id_producto,
			'qty' => $cantidad,
			'price' => $producto->price,
			'name' => convert_accented_characters($producto->name),
			'options' => $opciones
		);

		$producto_flash = new stdClass();
		$producto_flash->nombre_producto = 'Producto de plazo definido: '.$producto->name.', SKU: '.$sku->sku;
		$producto_flash->id_producto = $id_enhance;
		$producto_flash->precio = $producto->price;
		$producto_flash->numero_items = $cantidad;
        $productos_flash = array();
        array_push($productos_flash, $producto_flash);
		//$this->session->set_flashdata('producto_flash', $producto_flash);
		$this->session->set_tempdata('productos_flash', $productos_flash, 5);

		$this->cart->insert($producto_por_agregar);

		// Si hay sesión activa se actualiza el carrito en la base de datos
		$id_cliente = $this->session->login['id_cliente'];
		$es_cliente = (!is_null($id_cliente));
		if($es_cliente) {
			$this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
		}
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
		}

        if($nombre_tienda_slug) {
            redirect('tienda/'.$nombre_tienda_slug.'/carrito');
        } else {
            redirect('carrito');
        }
	}

	public function actualizar_envio()
	{
		$po = $this->input->post('recoger');

		if($po == 1) {
			$this->session->set_userdata('recoger', 'gratis');
		} else if($po == 0) {
			$this->session->unset_userdata('recoger', 'pagado');
		}

		$resultado = array();
		$resultado['envio'] = ($this->cart->obtener_costo_envio() == 0 ? '<strong class="verde">GRATIS</strong>' : "$".$this->cart->format_number($this->cart->obtener_costo_envio()));
		$resultado['total'] = "$".$this->cart->format_number($this->cart->obtener_total());

		echo json_encode($resultado);
	}

	public function quitar($rowid, $nombre_tienda_slug = null)
	{
		$this->cart->remove($rowid);
		// Si hay sesión activa se actualiza el carrito en la base de datos
		$id_cliente = $this->session->login['id_cliente'];
		$es_cliente = (!is_null($id_cliente));
		if($es_cliente) {
			$this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
            $this->session->unset_userdata('direccion_temporal');
		}
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
            $this->session->unset_userdata('direccion_temporal');
		}

        if($nombre_tienda_slug) {
            redirect('tienda/'.$nombre_tienda_slug.'/carrito');
        } else {
            redirect('carrito');
        }
	}

	public function cupon() {
		$name = $this->input->post("cupon");
		$this->cart->add_coupon($name);
	}

	public function quitar_cupon() {
		$this->session->unset_userdata('descuento_global');
        $this->session->unset_userdata('envio_gratis');
	}





	public function generar_link_paypal()
	{
		// Generacion de link de PayPal
		$apiContext = new \PayPal\Rest\ApiContext(
			new \PayPal\Auth\OAuthTokenCredential(
				$_ENV['PAYPAL_CLIENT'],
				$_ENV['PAYPAL_SECRET']
			)
		);

		$apiContext->setConfig(
			array(
				'mode' => $_ENV['PAYPAL_MODE']
			)
		);

		$payer = new \PayPal\Api\Payer();
		$payer->setPaymentMethod("paypal");
		$paypal_items = array();

		foreach($this->cart->contents() as $item_cart) {
			$options = $item_cart['options'];

			$item = new \PayPal\Api\Item();
			$item->setName($item_cart['name'].($options["enhance"] != 'enhance' ? ' personalizada' : ''))
				  ->setCurrency('MXN')
				  ->setQuantity($item_cart['qty'])
				  ->setSku((isset($options['talla']) ? 'Talla: '.$options['talla'] : ''))
				  ->setPrice($item_cart['price']);
			array_push($paypal_items, $item);
		}

		$itemList = new \PayPal\Api\ItemList();
		$itemList->setItems($paypal_items);

		if($this->input->post('direccion')) {

			$direccion = $this->input->post('direccion');

			$this->session->set_userdata('direccion_temporal', $direccion);

			$shipping_address = new \PayPal\Api\ShippingAddress();
			$shipping_address->setCity($direccion['ciudad']);
			$shipping_address->setPhone($direccion['telefono']);
			$shipping_address->setCountryCode('MX');
			$shipping_address->setPostalCode($direccion['codigo_postal']);
			$shipping_address->setLine1($direccion['linea1']);
			$shipping_address->setLine2($direccion['linea2']);
			$shipping_address->setState($direccion['estado']);
			$shipping_address->setRecipientName($direccion['identificador_direccion']);
			$itemList->setShippingAddress($shipping_address);
		}

		if($this->input->post('direccion_fiscal')) {

			$direccion_fiscal = $this->input->post('direccion_fiscal');
			$this->session->set_userdata('direccion_fiscal_temporal', $direccion_fiscal);

		}

		if($this->input->post('cancelar_direccion_fiscal') == 1) {

			$this->session->unset_userdata('direccion_fiscal_temporal');

		}

		$details = new \PayPal\Api\Details();
		$details->setShipping($this->cart->obtener_costo_envio())
				->setTax(0)
				->setSubtotal($this->cart->obtener_subtotal());

		// Si hay descuento
		if($this->cart->obtener_saldo_a_favor() > 0) {
			if($this->session->descuento_global) {
				$details->setShippingDiscount(($this->cart->obtener_costo_envio()+$this->cart->obtener_subtotal())-$this->cart->obtener_total());
			} else {
				$details->setShippingDiscount($this->cart->obtener_saldo_a_favor());
			}
		}

		if($this->session->descuento_global) {
			$details->setShippingDiscount(($this->cart->obtener_costo_envio()+$this->cart->obtener_subtotal())-$this->cart->obtener_total());
		}

		$amount = new \PayPal\Api\Amount();
		$amount->setCurrency("MXN")
			   ->setTotal($this->cart->obtener_total())
			   ->setDetails($details);

		$transaction = new \PayPal\Api\Transaction();
		$unique_id = uniqid();
		$transaction->setAmount($amount)
					->setItemList($itemList)
					->setDescription("Carrito de compras printome.mx")
					->setInvoiceNumber($unique_id);

		$redirectUrls = new \PayPal\Api\RedirectUrls();
		$redirectUrls->setReturnUrl(site_url('carrito/terminar_paypal'))
					 ->setCancelUrl(site_url('carrito/pagar'));

		$webhookUrl = new \PayPal\Api\Webhook();
		$webhookUrl->setUrl(site_url('paypal_listener'));

		$payment = new \PayPal\Api\Payment();
		$payment->setIntent("sale")
				->setPayer($payer)
				->setRedirectUrls($redirectUrls)
				/* ->setWebhook($webhookUrl) */
				->setTransactions(array($transaction));

		$payment->create($apiContext);

		if($this->input->post('direccion')) {
			echo $payment->getApprovalLink();
		} else {
			return $payment->getApprovalLink();
		}
	}

	public function terminar_paypal()
	{
		if(!$this->input->get('paymentId') && !$this->input->get('token') && !$this->input->get('PayerID')) {
			redirect('carrito/error-pago');
		} else {

			// Generacion de link de PayPal
			$apiContext = new \PayPal\Rest\ApiContext(
				new \PayPal\Auth\OAuthTokenCredential(
					$_ENV['PAYPAL_CLIENT'],
					$_ENV['PAYPAL_SECRET']
				)
			);

			$apiContext->setConfig(
				array(
					'mode' => $_ENV['PAYPAL_MODE']
				)
			);

			$payment_id = $this->input->get('paymentId');
			$token		= $this->input->get('token');
			$payer_id	= $this->input->get('PayerID');

			$pago = \PayPal\Api\Payment::get($payment_id, $apiContext);

			$ejecucion_pago = new \PayPal\Api\PaymentExecution();
			$ejecucion_pago->setPayerId($payer_id);

			$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);

			try {
				$resultado = $pago->execute($ejecucion_pago, $apiContext);

				$id_cliente = $this->session->login['id_cliente'];
				$is_client = !is_null($id_cliente);

				if($is_client) {
					if($this->session->direccion_temporal['id_direccion'] != '') {
						$id_direccion = $this->session->direccion_temporal['id_direccion'];
					} else {
						$direccion = $this->session->direccion_temporal;
						$nueva_direccion = new stdClass();
						$nueva_direccion->identificador_direccion = $direccion['identificador_direccion'];
						$nueva_direccion->linea1 = $direccion['linea1'];
						$nueva_direccion->linea2 = $direccion['linea2'];
						$nueva_direccion->codigo_postal = $direccion['codigo_postal'];
						$nueva_direccion->ciudad = $direccion['ciudad'];
						$nueva_direccion->estado = $direccion['estado'];
						$nueva_direccion->telefono = $direccion['telefono'];
						$nueva_direccion->pais = 'México';
						$nueva_direccion->id_cliente = $id_cliente;
						$nueva_direccion->fecha_creacion = date('Y-m-d H:i:s');

						$this->db->insert('DireccionesPorCliente', $nueva_direccion);
						$id_direccion = $this->db->insert_id();
					}

					if($this->session->direccion_fiscal_temporal) {
						if($this->session->direccion_fiscal_temporal['id_direccion_fiscal'] != '') {
							$id_direccion_fiscal = $this->session->direccion_fiscal_temporal['id_direccion_fiscal'];
						} else {
							$direccion = $this->session->direccion_fiscal_temporal;
							$nueva_direccion_fiscal = new stdClass();
							$nueva_direccion_fiscal->razon_social = $direccion['razon_social'];
							$nueva_direccion_fiscal->rfc = $direccion['rfc'];
							$nueva_direccion_fiscal->linea1 = $direccion['linea1'];
							$nueva_direccion_fiscal->linea2 = $direccion['linea2'];
							$nueva_direccion_fiscal->codigo_postal = $direccion['codigo_postal'];
							$nueva_direccion_fiscal->ciudad = $direccion['ciudad'];
							$nueva_direccion_fiscal->estado = $direccion['estado'];
							$nueva_direccion_fiscal->telefono = $direccion['telefono'];
							$nueva_direccion_fiscal->correo_electronico_facturacion = $direccion['correo_electronico_facturacion'];
							$nueva_direccion_fiscal->pais = 'México';
							$nueva_direccion_fiscal->id_cliente = $id_cliente;
							$nueva_direccion_fiscal->fecha_creacion = date('Y-m-d H:i:s');

							$this->db->insert('DireccionesFiscalesPorCliente', $nueva_direccion_fiscal);
							$id_direccion_fiscal = $this->db->insert_id();
						}
					} else {
						$id_direccion_fiscal = 0;
					}
				} else {

					$direccion = $this->session->direccion_temporal;

					$email = $this->session->direccion_temporal['email'];

					$cliente_res = $this->db->get_where('Clientes', array('email' => $email));
					$cliente = $cliente_res->row();

					if(!is_null($cliente)) {
						$id_cliente = $cliente->id_cliente;
					} else {
						// FALTA ACTIVE COLLAB

						$password_puro = uniqid();

						$usuario                          = new stdClass();
						$usuario->nombres                 = $direccion['nombre'];
						$usuario->apellidos               = $direccion['apellidos'];
						$usuario->email                   = $direccion['email'];
						$usuario->password                = $this->encryption->encrypt($password_puro);
						$usuario->fecha_registro          = date('Y-m-d H:i:s');
						$usuario->token_activacion_correo = 'activado';
						$usuario->fecha_nacimiento        = NULL;
						$usuario->genero                  = 'X';

						$this->db->insert('Clientes', $usuario);
						$id_cliente = $this->db->insert_id();

						$tienda = new stdClass();
						$tienda->nombre_tienda = 'Tienda de '.$usuario->nombres;
						$tienda->nombre_tienda_slug = uniqid($id_cliente, true);
						$tienda->descripcion_tienda = 'Esta es la tienda de '.$usuario->nombres;
						$tienda->id_cliente = $id_cliente;

						$this->db->insert('Tiendas', $tienda);

						// Se envía correo de bienvenida
						$datos_correo = new stdClass();
						$datos_correo->nombre = $usuario->nombres.' '.$usuario->apellidos;
						$datos_correo->email = $usuario->email;
						$datos_correo->contra = $password_puro;

						// Se registra usuario en active campaign
						$contact = array(
							"email"              => $usuario->email,
							"first_name"         => $usuario->nombres,
							"last_name"          => $usuario->apellidos,
							"p[16]"               => "16",
							"status[16]"          => 1,
							"tags"				 => "registro, durante-compra, printome.mx"
						);
						$contact_sync = $this->ac->api("contact/sync", $contact);

						// Se inicializa Sendgrid
						$email_bienvenida = new SendGrid\Email();
						$email_bienvenida->addTo($datos_correo->email, $datos_correo->nombre)
										 ->setFrom('hello@printome.mx')
										 ->setReplyTo('hello@printome.mx')
										 ->setFromName('printome.mx')
										 ->setSubject('Tus datos de acceso a printome.mx')
										 ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_bienvenida_nuevo_usuario', $datos_correo, TRUE))
						;
						$sendgrid->send($email_bienvenida);
					}

					$direccion = $this->session->direccion_temporal;
					$nueva_direccion                          = new stdClass();
					$nueva_direccion->identificador_direccion = "Principal";
					$nueva_direccion->linea1                  = $direccion['linea1'];
					$nueva_direccion->linea2                  = $direccion['linea2'];
					$nueva_direccion->codigo_postal           = $direccion['codigo_postal'];
					$nueva_direccion->ciudad                  = $direccion['ciudad'];
					$nueva_direccion->estado                  = $direccion['estado'];
					$nueva_direccion->telefono                = $direccion['telefono'];
					$nueva_direccion->pais                    = 'México';
					$nueva_direccion->id_cliente              = $id_cliente;
					$nueva_direccion->fecha_creacion          = date('Y-m-d H:i:s');

					$this->db->insert('DireccionesPorCliente', $nueva_direccion);
					$id_direccion = $this->db->insert_id();

					if($this->session->direccion_fiscal_temporal) {
						if($this->session->direccion_fiscal_temporal['id_direccion_fiscal'] != '') {
							$id_direccion_fiscal = $this->session->direccion_fiscal_temporal['id_direccion_fiscal'];
						} else {
							$direccion = $this->session->direccion_fiscal_temporal;
							$nueva_direccion_fiscal = new stdClass();
							$nueva_direccion_fiscal->razon_social = $direccion['razon_social'];
							$nueva_direccion_fiscal->rfc = $direccion['rfc'];
							$nueva_direccion_fiscal->linea1 = $direccion['linea1'];
							$nueva_direccion_fiscal->linea2 = $direccion['linea2'];
							$nueva_direccion_fiscal->codigo_postal = $direccion['codigo_postal'];
							$nueva_direccion_fiscal->ciudad = $direccion['ciudad'];
							$nueva_direccion_fiscal->estado = $direccion['estado'];
							$nueva_direccion_fiscal->telefono = $direccion['telefono'];
							$nueva_direccion_fiscal->correo_electronico_facturacion = $direccion['correo_electronico_facturacion'];
							$nueva_direccion_fiscal->pais = 'México';
							$nueva_direccion_fiscal->id_cliente = $id_cliente;
							$nueva_direccion_fiscal->fecha_creacion = date('Y-m-d H:i:s');

							$this->db->insert('DireccionesFiscalesPorCliente', $nueva_direccion_fiscal);
							$id_direccion_fiscal = $this->db->insert_id();
						}
					} else {
						$id_direccion_fiscal = 0;
					}

				}

				$pedido_array = array(
					"fecha_creacion"  => date("Y-m-d H:i:s", strtotime($resultado->getCreateTime())),
					"fecha_pago"      => date("Y-m-d H:i:s", strtotime($resultado->getUpdateTime())),
					"estatus_pago"    => 'paid',
					"id_pago"         => $resultado->getId(),
					"metodo_pago"     => 'paypal',
					"referencia_pago" => $resultado->getId(),
					"subtotal"        => $this->cart->obtener_subtotal(),
					"iva"             => $this->cart->obtener_iva(),
					"total"           => $this->cart->obtener_total(),
					"costo_envio"     => $this->cart->obtener_costo_envio(),
					"descuento"		  => $this->cart->obtener_saldo_a_favor(),
					"id_cliente"      => $id_cliente,
					"id_direccion"    => $id_direccion,
					"id_direccion_fiscal"    => $id_direccion_fiscal,
					//"id_cupon"        => $this->cart->get_discount_id(),
					"paypal_payer_email" => $resultado->getPayer()->getPayerInfo()->getEmail(),
					"paypal_payer_id" => $resultado->getPayer()->getPayerInfo()->getPayerId()
				);

				if($this->session->descuento_global->descuento) {
					$pedido_array['id_cupon'] = $this->session->descuento_global->id_cupon;
					$this->db->query("UPDATE Cupones SET cantidad=cantidad-1 WHERE id=".$pedido_array['id_cupon']);
				}

				$pedido = $this->db->insert("Pedidos", $pedido_array);
				$id_pedido = $this->db->insert_id();

				$sku_items = array();

				foreach($this->cart->contents() as $item){
					$options = $this->cart->product_options($item['rowid']);

					$sku_item = array(
						"id_sku"=> $options['sku'],
						"precio_producto"=> $item['price'],
						"descuento_especifico" => 0,
						"cantidad_producto"=> $item['qty'],
						"aplica_devolucion"=> (isset($options['devolucion']) ? $options['devolucion']: 0),
						"id_pedido" => $id_pedido,
						"diseno" => (isset($options['disenos']) ? json_encode($options['disenos']) : NULL),
						"id_enhance" => (isset($options['id_enhance']) ? $options['id_enhance'] : 0)
					);

					if($sku_item['id_enhance'] == 0) {
						$query = $this->db->query("UPDATE CatalogoSkuPorProducto SET cantidad_inicial=(cantidad_inicial-".$item['qty'].") WHERE id_sku='".$options['sku']."'");
					} else {
						$enhance = $this->enhance_modelo->obtener_enhance($sku_item['id_enhance']);
						if($enhance->type == 'fijo') {
							$query = $this->db->query("UPDATE CatalogoSkuPorProducto SET cantidad_inicial=(cantidad_inicial-".$item['qty'].") WHERE id_sku='".$options['sku']."'");
						}
						$query = $this->db->query('UPDATE Enhance SET sold=(sold+'.$item['qty'].') WHERE id_enhance='.$sku_item['id_enhance']);
					}

					$sku_items[] = $sku_item;
				}

				$pedido = $this->db->insert_batch("ProductosPorPedido", $sku_items);

				$query = $this->db->get_where('Clientes', array('id_cliente' => $id_cliente));
				$cliente = $query->row();

				$datos_correo                = new stdClass();
				$datos_correo->numero_pedido = str_pad($id_pedido, 8, '0', STR_PAD_LEFT);
				$datos_correo->total_pedido  = $this->cart->obtener_total();
				$datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
				$datos_correo->nombre_solo   = $cliente->nombres;
				$datos_correo->apellido      = $cliente->apellidos;
				$datos_correo->email         = $cliente->email;
				$datos_correo->cupon         = (isset($this->session->descuento_global) ? $this->session->descuento_global->cupon : null);

				$email = new SendGrid\Email();
				$email->addTo($datos_correo->email, $datos_correo->nombre)
					  ->setFrom('administracion@printome.mx')
					  ->setReplyTo('administracion@printome.mx')
					  ->setFromName('printome.mx')
					  ->setSubject('Confirmación de pago con PayPal | printome.mx')
					  ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_paypal_confirmado', $datos_correo, TRUE))
				;
				$sendgrid->send($email);

				$email_administracion = new SendGrid\Email();
				$email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
									 ->setFrom('no-reply@printome.mx')
									 ->setReplyTo('administracion@printome.mx')
									 ->setFromName('Tienda en línea printome.mx')
									 ->setSubject('Pago con PayPal realizado | printome.mx')
									 ->setHtml($this->load->view('plantillas_correos/nuevas/admin_confirmacion_pago_paypal', $datos_correo, TRUE))
									 ->addAttachment('assets/pdf/'.$this->pdf_pedido_archivo($id_pedido), 'pedido_printome_'.$datos_correo->numero_pedido.'.pdf');
				$sendgrid->send($email_administracion);

				$this->session->set_flashdata('total_pedido', $this->cart->obtener_total());
				$this->session->set_flashdata('tracking_id_pedido', $id_pedido);
				$this->session->set_flashdata('tracking_shipping', $this->cart->obtener_costo_envio());
				$this->session->set_flashdata('tracking_iva', $this->cart->obtener_iva());

				if($this->session->has_userdata('correo_temporal')) {
					$this->cart_modelo->borrar_carrito_invitado($this->session->correo_temporal);
					$this->session->unset_userdata('correo_temporal');
					ac_agregar_etiqueta($this->session->correo_temporal, 'pedido-completado');
				} else {
					ac_agregar_etiqueta($datos_correo->email, 'pedido-completado');
				}

				$this->cart->destroy();
				$this->session->unset_userdata('direccion_temporal');
				$this->session->unset_userdata('direccion_fiscal_temporal');
				$this->session->unset_userdata('descuento_global');
                $this->session->unset_userdata('envio_gratis');
                $this->session->unset_userdata('id_direccion_pedido');

				$this->cart_modelo->borrar_carrito($id_cliente);

				redirect('carrito/pedido-completado-paypal');

			} catch(Exception $e) {
				if($this->session->has_userdata('correo_temporal')) {
					ac_quitar_etiqueta($this->session->correo_temporal, 'pedido-completado');
				} else {
					ac_quitar_etiqueta($datos_correo->email, 'pedido-completado');
				}

				redirect('carrito/error-pago');
			}
		}

	}

	public function pagar() {

		try {
			$datos_header['link_paypal'] = $this->generar_link_paypal();
		} catch (Exception $ex) {
			//$ex->getMessage();
			//redirect('carrito');
			//print_r($ex);
			//redirect('carrito/pagar', 'refresh');
			$datos_header['link_paypal'] = '';
		}

		if($this->session->has_userdata('login')) {
			ac_agregar_etiqueta($this->session->login['email'], 'carrito-pagar');
		}

		if($this->session->has_userdata('correo_temporal')) {
			ac_agregar_etiqueta($this->session->correo_temporal, 'carrito-pagar');
		}

		// Config
		$datos_header['seccion_activa'] = 'carrito';
		$datos_header['meta']['title'] = '¡Ya casi terminas! | printome.mx';
		$datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
		$datos_header['meta']['imagen'] = '';
		$datos_header['mouseflow'] = true;

		$footer_datos['scripts'] = 'carrito/script_pago';

		$this->load->view('header', $datos_header);

		if($this->cart->total_items() > 0) {
			$this->load->view('carrito/pago');
			//$this->load->view('carrito/similares', array('ids_producto' => $this->cart->obtener_ids_en_carrito(), 'titulo' => '¿No te hizo falta algo?', "descuento_global" => $this->descuento_global));
			//$this->load->view('reveals/nueva_direccion.reveal.php');
		} else {
			redirect('carrito');
		}
		$this->load->view('footer', $footer_datos);
	}

	public function terminar() {

		// Se inicializa Sendgrid
		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
		$direccion_conekta = new stdClass();

		$id_cliente = $this->session->login['id_cliente'];
		$is_client = !is_null($id_cliente);

		if($is_client) {
			if($this->session->direccion_temporal['id_direccion'] != '') {
				$id_direccion = $this->session->direccion_temporal['id_direccion'];

				$direccion_cliente = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $id_direccion))->row();

				$direccion_conekta->linea1 = $direccion_cliente->linea1;
				$direccion_conekta->linea2 = $direccion_cliente->linea2;
				$direccion_conekta->ciudad = $direccion_cliente->ciudad;
				$direccion_conekta->estado = $direccion_cliente->estado;
				$direccion_conekta->pais = 'México';
				$direccion_conekta->codigo_postal = $direccion_cliente->codigo_postal;
				$direccion_conekta->telefono = $direccion_cliente->telefono;

			} else {
				$direccion = $this->session->direccion_temporal;
				$nueva_direccion = new stdClass();
				$nueva_direccion->identificador_direccion = $direccion['identificador_direccion'];
				$nueva_direccion->linea1 = $direccion['linea1'];
				$nueva_direccion->linea2 = $direccion['linea2'];
				$nueva_direccion->codigo_postal = $direccion['codigo_postal'];
				$nueva_direccion->ciudad = $direccion['ciudad'];
				$nueva_direccion->estado = $direccion['estado'];
				$nueva_direccion->telefono = $direccion['telefono'];
				$nueva_direccion->pais = 'México';
				$nueva_direccion->id_cliente = $id_cliente;
				$nueva_direccion->fecha_creacion = date('Y-m-d H:i:s');

				$this->db->insert('DireccionesPorCliente', $nueva_direccion);
				$id_direccion = $this->db->insert_id();

				$direccion_conekta->linea1 = $nueva_direccion->linea1;
				$direccion_conekta->linea2 = $nueva_direccion->linea2;
				$direccion_conekta->ciudad = $nueva_direccion->ciudad;
				$direccion_conekta->estado = $nueva_direccion->estado;
				$direccion_conekta->pais = 'México';
				$direccion_conekta->codigo_postal = $nueva_direccion->codigo_postal;
				$direccion_conekta->telefono = $nueva_direccion->telefono;
			}

			if($this->session->direccion_fiscal_temporal) {
				if($this->session->direccion_fiscal_temporal['id_direccion_fiscal'] != '') {
					$id_direccion_fiscal = $this->session->direccion_fiscal_temporal['id_direccion_fiscal'];
				} else {
					$direccion = $this->session->direccion_fiscal_temporal;
					$nueva_direccion_fiscal = new stdClass();
					$nueva_direccion_fiscal->razon_social = $direccion['razon_social'];
					$nueva_direccion_fiscal->rfc = $direccion['rfc'];
					$nueva_direccion_fiscal->linea1 = $direccion['linea1'];
					$nueva_direccion_fiscal->linea2 = $direccion['linea2'];
					$nueva_direccion_fiscal->codigo_postal = $direccion['codigo_postal'];
					$nueva_direccion_fiscal->ciudad = $direccion['ciudad'];
					$nueva_direccion_fiscal->estado = $direccion['estado'];
					$nueva_direccion_fiscal->telefono = $direccion['telefono'];
					$nueva_direccion_fiscal->correo_electronico_facturacion = $direccion['correo_electronico_facturacion'];
					$nueva_direccion_fiscal->pais = 'México';
					$nueva_direccion_fiscal->id_cliente = $id_cliente;
					$nueva_direccion_fiscal->fecha_creacion = date('Y-m-d H:i:s');

					$this->db->insert('DireccionesFiscalesPorCliente', $nueva_direccion_fiscal);
					$id_direccion_fiscal = $this->db->insert_id();
				}
			} else {
				$id_direccion_fiscal = 0;
			}

			$name = $this->session->login['nombre'];
			$email = $this->session->login['email'];

		} else {
			$direccion = $this->session->direccion_temporal;
			$email = $this->session->direccion_temporal['email'];
			$name = $direccion['nombre'];

			$cliente_res = $this->db->get_where('Clientes', array('email' => $email));
			$cliente = $cliente_res->row();

			if(!is_null($cliente)) {
				$id_cliente = $cliente->id_cliente;
			} else {

				$password_puro = uniqid();

				$usuario                          = new stdClass();
				$usuario->nombres                 = $direccion['nombre'];
				$usuario->apellidos               = $direccion['apellidos'];
				$usuario->email                   = $direccion['email'];
				$usuario->password                = $this->encryption->encrypt($password_puro);
				$usuario->fecha_registro          = date('Y-m-d H:i:s');
				$usuario->token_activacion_correo = 'activado';
				$usuario->fecha_nacimiento        = NULL;
				$usuario->genero                  = 'X';

				$this->db->insert('Clientes', $usuario);
				$id_cliente = $this->db->insert_id();

				// Se registra usuario en active campaign
				$contact = array(
					"email"              => $usuario->email,
					"first_name"         => $usuario->nombres,
					"last_name"          => $usuario->apellidos,
					"p[16]"               => "16",
					"status[16]"          => 1,
					"tags"				 => "registro-durante-compra, printome.mx"
				);
				$contact_sync = $this->ac->api("contact/sync", $contact);

				// Se envía correo de bienvenida
				$datos_correo = new stdClass();
				$datos_correo->nombre = $usuario->nombres.' '.$usuario->apellidos;
				$datos_correo->email = $usuario->email;
				$datos_correo->contra = $password_puro;

				// Se inicializa Sendgrid
				$email_bienvenida = new SendGrid\Email();
				$email_bienvenida->addTo($datos_correo->email, $datos_correo->nombre)
								 ->setFrom('hello@printome.mx')
								 ->setReplyTo('hello@printome.mx')
								 ->setFromName('printome.mx')
								 ->setSubject('Tus datos de acceso a printome.mx')
								 ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_bienvenida_nuevo_usuario', $datos_correo, TRUE)
				);
				$sendgrid->send($email_bienvenida);
			}

			$nueva_direccion                          = new stdClass();
			$nueva_direccion->identificador_direccion = "Principal";
			$nueva_direccion->linea1                  = $direccion['linea1'];
			$nueva_direccion->linea2                  = $direccion['linea2'];
			$nueva_direccion->codigo_postal           = $direccion['codigo_postal'];
			$nueva_direccion->ciudad                  = $direccion['ciudad'];
			$nueva_direccion->estado                  = $direccion['estado'];
			$nueva_direccion->telefono                = $direccion['telefono'];
			$nueva_direccion->pais                    = 'México';
			$nueva_direccion->id_cliente              = $id_cliente;
			$nueva_direccion->fecha_creacion          = date('Y-m-d H:i:s');

			$this->db->insert('DireccionesPorCliente', $nueva_direccion);
			$id_direccion = $this->db->insert_id();

			$direccion_conekta->linea1 = $nueva_direccion->linea1;
			$direccion_conekta->linea2 = $nueva_direccion->linea2;
			$direccion_conekta->ciudad = $nueva_direccion->ciudad;
			$direccion_conekta->estado = $nueva_direccion->estado;
			$direccion_conekta->pais = 'México';
			$direccion_conekta->codigo_postal = $nueva_direccion->codigo_postal;
			$direccion_conekta->telefono = $nueva_direccion->telefono;

			if($this->session->direccion_fiscal_temporal) {
				if($this->session->direccion_fiscal_temporal['id_direccion_fiscal'] != '') {
					$id_direccion_fiscal = $this->session->direccion_fiscal_temporal['id_direccion_fiscal'];
				} else {
					$direccion = $this->session->direccion_fiscal_temporal;
					$nueva_direccion_fiscal = new stdClass();
					$nueva_direccion_fiscal->razon_social = $direccion['razon_social'];
					$nueva_direccion_fiscal->rfc = $direccion['rfc'];
					$nueva_direccion_fiscal->linea1 = $direccion['linea1'];
					$nueva_direccion_fiscal->linea2 = $direccion['linea2'];
					$nueva_direccion_fiscal->codigo_postal = $direccion['codigo_postal'];
					$nueva_direccion_fiscal->ciudad = $direccion['ciudad'];
					$nueva_direccion_fiscal->estado = $direccion['estado'];
					$nueva_direccion_fiscal->telefono = $direccion['telefono'];
					$nueva_direccion_fiscal->correo_electronico_facturacion = $direccion['correo_electronico_facturacion'];
					$nueva_direccion_fiscal->pais = 'México';
					$nueva_direccion_fiscal->id_cliente = $id_cliente;
					$nueva_direccion_fiscal->fecha_creacion = date('Y-m-d H:i:s');

					$this->db->insert('DireccionesFiscalesPorCliente', $nueva_direccion_fiscal);
					$id_direccion_fiscal = $this->db->insert_id();
				}
			} else {
				$id_direccion_fiscal = 0;
			}
		}

		// OCULTAR LA CREACION DE CUPONES
		//$own_cupon =$this->cupones_modelo->crear_cupon($cliente->nombres . " " . $cliente->apellidos, $id_cliente);

		// TOKEN CONEKTA
		$token_card = $this->input->post('conektaTokenId');
		// Inicializar Conekta
		Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
		Conekta::setLocale('es');
		Conekta::setApiVersion("1.0.0");

		$forma_pago = $this->input->post('pago');
		$reference_id = "PTOME-".strtoupper($forma_pago)."-".date("YmdHis")."-".$id_cliente;

		if($forma_pago == 'tdc') {
			try {

				// Crear un array con los items para mandar a Conekta
				$items = array();
				foreach($this->cart->contents() as $item){
					$options = $this->cart->product_options($item['rowid']);

					$new_item = array(
						'name' => $item['name'],
						'sku' => $options['sku'],
						'unit_price' => $item['price']*100,
						'description' => $item['name'].($options["enhance"] != 'enhance' ? ' personalizada' : '').(isset($options['talla']) ? ' - Talla: '.$options['talla'] : ''),
						'quantity' => $item['qty'],
						'type' => 'Producto vendido por printome.mx'
					);

					array_push($items, $new_item);
				}

				// Se realiza el cargo de Conekta
				$charge = Conekta_Charge::create(array(
					"amount" => $this->cart->obtener_total()*100,
					"currency" => "MXN",
					"description" => "Carrito de compras printome.mx",
					"reference_id" => $reference_id,
					"card" => $token_card,
					"details" => array(
						"name" => $name,
						"email" => $email,
						"phone" => $direccion_conekta->telefono,
						"line_items" => $items,
						"shipment"=> array(
							"carrier"=>"DHL",
							"service"=>"national",
							"price"=> $this->cart->obtener_costo_envio()*100,
							"address"=> array(
								"street1"=> $direccion_conekta->linea1,
								"street2"=> $direccion_conekta->linea2,
								"city"=> $direccion_conekta->ciudad,
								"state"=> $direccion_conekta->estado,
								"zip"=> $direccion_conekta->codigo_postal,
								"country"=> $direccion_conekta->pais
							)
						)
					)
				));

				// Se inicializa el array para guardar el pedido en la base de datos y se inserta
				$pedido = array(
					"fecha_creacion"  => date("Y-m-d H:i:s",$charge->created_at),
					"fecha_pago"      => date("Y-m-d H:i:s",$charge->created_at),
					"estatus_pago"    => $charge->status,
					"id_pago"         => $charge->id,
					"metodo_pago"     => $charge->payment_method->object,
					"referencia_pago" => $reference_id,
					"subtotal"        => $this->cart->obtener_subtotal(),
					"iva"             => $this->cart->obtener_iva(),
					"descuento"		  => $this->cart->obtener_saldo_a_favor(),
					"total"           => $this->cart->obtener_total(),
					"costo_envio"     => $this->cart->obtener_costo_envio(),
					"id_cliente"      => $id_cliente,
					"id_direccion"    => $id_direccion,
					"id_direccion_fiscal"    => $id_direccion_fiscal,
					//"id_cupon"        => $this->cart->get_discount_id()
				);

				if($this->session->descuento_global->descuento) {
					$pedido['id_cupon'] = $this->session->descuento_global->id_cupon;
					$this->db->query("UPDATE Cupones SET cantidad=cantidad-1 WHERE id=".$pedido['id_cupon']);
				}

				$pedido = $this->db->insert("Pedidos", $pedido);

				$id_pedido = $this->db->insert_id();

				$sku_items = array();

				foreach($this->cart->contents() as $item){
					$options = $this->cart->product_options($item['rowid']);

					$sku_item = array(
						"id_sku"=> $options['sku'],
						"precio_producto"=> $item['price'],
						"descuento_especifico" => 0,
						"cantidad_producto"=> $item['qty'],
						"aplica_devolucion"=> (isset($options['devolucion']) ? $options['devolucion'] : 0),
						"id_pedido" => $id_pedido,
						"diseno" => (isset($options['disenos']) ? json_encode($options['disenos']) : NULL),
						"id_enhance" => (isset($options['id_enhance']) ? $options['id_enhance'] : 0)
					);

					if($sku_item['id_enhance'] == 0) {
						$query = $this->db->query("UPDATE CatalogoSkuPorProducto SET cantidad_inicial=(cantidad_inicial-".$item['qty'].") WHERE id_sku='".$options['sku']."'");
					} else {
						$enhance = $this->enhance_modelo->obtener_enhance($sku_item['id_enhance']);
						if($enhance->type == 'fijo') {
							$query = $this->db->query("UPDATE CatalogoSkuPorProducto SET cantidad_inicial=(cantidad_inicial-".$item['qty'].") WHERE id_sku='".$options['sku']."'");
						}
						$query = $this->db->query('UPDATE Enhance SET sold=(sold+'.$item['qty'].') WHERE id_enhance='.$sku_item['id_enhance']);
					}

					$sku_items[] = $sku_item;
				}

				$pedido = $this->db->insert_batch("ProductosPorPedido", $sku_items);

				$query = $this->db->get_where('Clientes', array('id_cliente' => $id_cliente));
				$cliente = $query->row();

				// Envio de correo de aviso al cliente de que se hizo el pago con tarjeta
				$datos_correo                = new stdClass();
				$datos_correo->numero_pedido = str_pad($id_pedido, 8, '0', STR_PAD_LEFT);
				$datos_correo->total_pedido  = $this->cart->obtener_total();
				$datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
				$datos_correo->nombres       = $cliente->nombres;
				$datos_correo->apellidos     = $cliente->apellidos;
				$datos_correo->email         = $cliente->email;
				$datos_correo->cupon         = (isset($this->session->descuento_global) ? $this->session->descuento_global->cupon : null);


				$email_compra = new SendGrid\Email();
				$email_compra->addTo($datos_correo->email, $datos_correo->nombre)
							 ->setFrom('administracion@printome.mx')
							 ->setReplyTo('administracion@printome.mx')
							 ->setFromName('printome.mx')
							 ->setSubject('Confirmación de pago con tarjeta | printome.mx')
							 ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_tarjeta_confirmado', $datos_correo, TRUE))
				;
				$sendgrid->send($email_compra);

				// Email administracion
				$email_administracion = new SendGrid\Email();
				$email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
									 ->setFrom('no-reply@printome.mx')
									 ->setReplyTo('administracion@printome.mx')
									 ->setFromName('Tienda en línea printome.mx')
									 ->setSubject('Pago con tarjeta realizado | printome.mx')
									 ->setHtml($this->load->view('plantillas_correos/nuevas/admin_confirmacion_pago_tarjeta', $datos_correo, TRUE))
									 ->addAttachment('assets/pdf/'.$this->pdf_pedido_archivo($id_pedido), 'pedido_printome_'.$datos_correo->numero_pedido.'.pdf')
				;
				$sendgrid->send($email_administracion);

				$this->session->set_flashdata('total_pedido', $this->cart->obtener_total());
				$this->session->set_flashdata('tracking_id_pedido', $id_pedido);
				$this->session->set_flashdata('tracking_shipping', $this->cart->obtener_costo_envio());
				$this->session->set_flashdata('tracking_iva', $this->cart->obtener_iva());

				if($this->session->has_userdata('correo_temporal')) {
					$this->cart_modelo->borrar_carrito_invitado($this->session->correo_temporal);
					$this->session->unset_userdata('correo_temporal');
					ac_agregar_etiqueta($this->session->correo_temporal, 'pedido-completado');
				} else {
					ac_agregar_etiqueta($datos_correo->email, 'pedido-completado');
				}

				$this->cart->destroy();
				$this->session->unset_userdata('direccion_temporal');
				$this->session->unset_userdata('direccion_fiscal_temporal');
				$this->session->unset_userdata('descuento_global');
                $this->session->unset_userdata('envio_gratis');
                $this->session->unset_userdata('id_direccion_pedido');

				$this->cart_modelo->borrar_carrito($id_cliente);

				redirect('carrito/pedido-completado-tarjeta');

			} catch (Conekta_Error $e) {
				$this->session->set_flashdata('error_pago', $e);
				if($this->session->has_userdata('correo_temporal')) {
					ac_quitar_etiqueta($this->session->correo_temporal, 'pedido-completado');
				} else {
					ac_quitar_etiqueta($datos_correo->email, 'pedido-completado');
				}

				redirect('carrito/error-pago');
			}
		} else if($forma_pago == 'oxxo') {

			try {

				// Crear un array con los items para mandar a Conekta
				$items = array();

				foreach($this->cart->contents() as $item){
					$options = $this->cart->product_options($item['rowid']);

					$new_item = array(
						'name' => $item['name'],
						'sku' => $options['sku'],
						'unit_price' => $item['price']*100,
						'description' => $item['name'].($options["enhance"] != 'enhance' ? ' personalizada' : '').(isset($options['talla']) ? ' - Talla: '.$options['talla'] : ''),
						'quantity' => $item['qty'],
						'type' => 'Producto vendido por printome.mx'
					);

					array_push($items, $new_item);
				}

				$subtotal    = $this->cart->obtener_subtotal()*100/100;
				$iva         = $this->cart->obtener_iva()*100/100;
				$total       = $this->cart->obtener_total()*100/100;
				$costo_envio = $this->cart->obtener_costo_envio()*100/100;

				$expira_el = date("Y-m-d H:i:s", strtotime("+120 hours"));

				// Se realiza el cargo de Conekta
				$charge = Conekta_Charge::create(array(
					"amount" => $total*100,
					"currency" => "MXN",
					"description" => "Carrito de Compras Printome",
					"reference_id" => $reference_id,
					"cash" => array(
						"type" =>"oxxo",
						"expires_at" => $expira_el
					),
					"details" => array(
						"name" => $name,
						"email" => $email,
						"phone" => $direccion_conekta->telefono,
						"line_items" => $items,
						"shipment"=> array(
							"carrier"=>"DHL",
							"service"=>"national",
							"price"=> $this->cart->obtener_costo_envio()*100,
							"address"=> array(
								"street1"=> $direccion_conekta->linea1,
								"street2"=> $direccion_conekta->linea2,
								"city"=> $direccion_conekta->ciudad,
								"state"=> $direccion_conekta->estado,
								"zip"=> $direccion_conekta->codigo_postal,
								"country"=> $direccion_conekta->pais
							)
						)
					)
				));

				// Se inicializa el array de pedido para insertar en la base de datos y se inserta
				$pedido = array(
					"fecha_creacion"         => date("Y-m-d H:i:s",$charge->created_at),
					"fecha_pago"             => date("Y-m-d H:i:s",$charge->created_at),
					"estatus_pago"           => $charge->status,
					"id_pago"                => $charge->id,
					"metodo_pago"            => $charge->payment_method->object,
					"referencia_pago"        => $reference_id,
					"subtotal"               => $subtotal,
					"iva"                    => $iva,
					"descuento"		 		 => $this->cart->obtener_saldo_a_favor(),
					"total"                  => $total,
					"costo_envio"            => $costo_envio,
					"id_cliente"             => $id_cliente,
					"id_direccion"           => $id_direccion,
					"id_direccion_fiscal"           => $id_direccion_fiscal,
					"oxxo_fecha_vencimiento" => $expira_el,
					//"id_cupon"               => $this->cart->get_discount_id()
				);

				if($this->session->descuento_global->descuento) {
					$pedido['id_cupon'] = $this->session->descuento_global->id_cupon;
					$this->db->query("UPDATE Cupones SET cantidad=cantidad-1 WHERE id=".$pedido['id_cupon']);
				}

				$pedido = $this->db->insert("Pedidos", $pedido);
				$id_pedido = $this->db->insert_id();

				$sku_items = array();

				foreach($this->cart->contents() as $item){
					$options = $this->cart->product_options($item['rowid']);

					$sku_item = array(
						"id_sku"=> $options['sku'],
						"precio_producto"=> $item['price'],
						"descuento_especifico" => 0,
						"cantidad_producto"=> $item['qty'],
						"aplica_devolucion"=> (isset($options['devolucion']) ? $options['devolucion']: 0),
						"id_pedido" => $id_pedido,
						"diseno" => (isset($options['disenos']) ? json_encode($options['disenos']) : NULL),
						"id_enhance" => (isset($options['id_enhance']) ? $options['id_enhance'] : 0)
					);

					if($sku_item['id_enhance'] == 0) {
						$query = $this->db->query("UPDATE CatalogoSkuPorProducto SET cantidad_inicial=(cantidad_inicial-".$item['qty'].") WHERE id_sku='".$options['sku']."'");
					} else {
						$enhance = $this->enhance_modelo->obtener_enhance($sku_item['id_enhance']);
						if($enhance->type == 'fijo') {
							$query = $this->db->query("UPDATE CatalogoSkuPorProducto SET cantidad_inicial=(cantidad_inicial-".$item['qty'].") WHERE id_sku='".$options['sku']."'");
						}
						//$query = $this->db->query('UPDATE Enhance SET sold=(sold+'.$item['qty'].') WHERE id_enhance='.$sku_item['id_enhance']);
					}

					$sku_items[] = $sku_item;
				}

				$pedido = $this->db->insert_batch("ProductosPorPedido", $sku_items);

				$query = $this->db->get_where('Clientes', array('id_cliente' => $id_cliente));
				$cliente = $query->row();

				$datos_correo                = new stdClass();
				$datos_correo->numero_pedido = str_pad($id_pedido, 8, '0', STR_PAD_LEFT);
				$datos_correo->total_pedido  = $this->cart->obtener_total();
				$datos_correo->codigo_barras = $charge->payment_method->barcode_url;
				$datos_correo->numero_barras = $charge->payment_method->barcode;
				$datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
				$datos_correo->nombre_solo   = $cliente->nombres;
				$datos_correo->apellido      = $cliente->apellidos;
				$datos_correo->email         = $cliente->email;
				$datos_correo->cupon         = (isset($this->session->descuento_global) ? $this->session->descuento_global->cupon : null);

				$this->session->set_flashdata('barcode', $charge->payment_method->barcode_url);
				$this->session->set_flashdata('pedido_id', $id_pedido);

				$email_oxxo = new SendGrid\Email();
				$email_oxxo->addTo($datos_correo->email, $datos_correo->nombre)
						   ->setFrom('administracion@printome.mx')
						   ->setReplyTo('administracion@printome.mx')
						   ->setFromName('printome.mx')
						   ->setSubject('Ficha de pago en OXXO | printome.mx')
						   ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_oxxo_ficha', $datos_correo, TRUE))
						   ->addAttachment('assets/pdf/'.$this->pdf_oxxo_archivo($id_pedido), 'ficha_pago_oxxo_'.$id_pedido.'.pdf');

				$sendgrid->send($email_oxxo);

				$email_omar = new SendGrid\Email();
				$email_omar->addTo('administracion@printome.mx', 'Administración Printome')
						   ->setFrom('no-reply@printome.mx')
						   ->setReplyTo('administracion@printome.mx')
						   ->setFromName('Tienda en línea printome.mx')
						   ->setSubject('Se ha generado un nuevo cargo en OXXO | printome.mx')
						   ->setHtml($this->load->view('plantillas_correos/nuevas/admin_aviso_ficha_oxxo.php', $datos_correo, TRUE))
				;

				$sendgrid->send($email_omar);

				$this->session->set_flashdata('total_pedido', $this->cart->obtener_total());
				$this->session->set_flashdata('tracking_id_pedido', $id_pedido);
				$this->session->set_flashdata('tracking_shipping', $this->cart->obtener_costo_envio());
				$this->session->set_flashdata('tracking_iva', $this->cart->obtener_iva());

				if($this->session->has_userdata('correo_temporal')) {
					$this->cart_modelo->borrar_carrito_invitado($this->session->correo_temporal);
					$this->session->unset_userdata('correo_temporal');
					ac_agregar_etiqueta($this->session->correo_temporal, 'pedido-completado');
				} else {
					ac_agregar_etiqueta($datos_correo->email, 'pedido-completado');
				}

				$this->cart->destroy();
				$this->session->unset_userdata('direccion_temporal');
				$this->session->unset_userdata('direccion_fiscal_temporal');
				$this->session->unset_userdata('descuento_global');
                $this->session->unset_userdata('envio_gratis');
                $this->session->unset_userdata('id_direccion_pedido');

				$this->cart_modelo->borrar_carrito($id_cliente);

				redirect('carrito/pedido-completado-oxxo');
			} catch (Conekta_Error $e) {
				if($this->session->has_userdata('correo_temporal')) {
					ac_quitar_etiqueta($this->session->correo_temporal, 'pedido-completado');
				} else {
					ac_quitar_etiqueta($datos_correo->email, 'pedido-completado');
				}
				//$this->bugsnag->notifyException($e);

				redirect('carrito/error-pago');
			}

		}

	}

	public function actualizar()
	{
		$data = $this->input->post();

		$this->cart->update($data);
		// Si hay sesión activa se actualiza el carrito en la base de datos
		$id_cliente = $this->session->login['id_cliente'];
		$es_cliente = (!is_null($id_cliente));
		if($es_cliente) {
			$this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
		}
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
		}
		redirect('carrito');
	}

	public function vaciar() {
		$this->cart->destroy();

		$id_cliente = $this->session->login['id_cliente'];
		$es_cliente = (!is_null($id_cliente));
		if($es_cliente) {
			$this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
			ac_quitar_etiqueta($this->session->login['email'], 'abandono-carrito');
			usleep(333000);
			ac_quitar_etiqueta($this->session->login['email'], 'comenzo-personalizacion');
			usleep(333000);
			ac_agregar_etiqueta($this->session->login['email'], 'vacio-carrito');
			usleep(333000);

			$params = [
				'email' => $this->session->login['email'],
				'field[1,0]' => ''
			];
			$persona_update = $this->ac->api('contact/sync', $params);
		}
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
			ac_quitar_etiqueta($this->session->correo_temporal, 'abandono-carrito');
			usleep(333000);
			ac_quitar_etiqueta($this->session->correo_temporal, 'comenzo-personalizacion');
			usleep(333000);
			ac_agregar_etiqueta($this->session->correo_temporal, 'vacio-carrito');
			usleep(333000);
			$params = [
				'email' => $this->session->correo_temporal,
				'field[1,0]' => ''
			];
			$persona_update = $this->ac->api('contact/sync', $params);
		}

		redirect('carrito');
	}


	public function pedido_completado($metodo_pago) {
		if(!$metodo_pago) {
			redirect('/');
		}

		$barcode["barcode"] = $this->session->flashdata('barcode');
		$barcode["pedido_id"] = $this->session->flashdata('pedido_id');
		$barcode["metodo_pago"] = $metodo_pago;

		// Config
		$datos_header['seccion_activa'] = 'carrito';
		$datos_header['meta']['title'] = '¡Gracias por tu compra! | printome.mx';
		$datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
		$datos_header['meta']['imagen'] = '';
		$datos_header['mouseflow'] = true;

		$this->load->view('header', $datos_header);
		$this->load->view('carrito/gracias', $barcode);
		$this->load->view('footer');
	}

	public function pdf_oxxo($id_pedido){
		$this->load->helper(array('dompdf', 'file'));

		Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
		Conekta::setLocale('es');
		Conekta::setApiVersion("1.0.0");

		$contenido['id_pedido']      = $id_pedido;
		$contenido['pedido']         = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$reference                   = $contenido['pedido']->referencia_pago;
		$charges                     = Conekta_Charge::where(array('reference_id'=>$reference));
		$charges                     = json_decode($charges->__toJSON());
		$charge                      = $charges[0];
		$barcode                     = $charge->payment_method->barcode_url;
		$barcode_number              = $charge->payment_method->barcode;
		$expiration                  = $charge->payment_method->expires_at;
		$amount                      = $charge->amount / 100;
		$im                          = file_get_contents($barcode);
		$barcode                     = "data:image/png;base64," . base64_encode($im);
		$contenido['barcode']        = $barcode;
		$contenido['barcode_number'] = $barcode_number;
		$contenido['expiration']     = $expiration;
		$contenido['amount']         = $amount;

		$html = $this->load->view('carrito/pdf', $contenido, true);

		pdf_create($html, 'pago_'.str_pad($reference, 8, '0', STR_PAD_LEFT));
	}

	public function pdf_oxxo_archivo($id_pedido){
		$this->load->helper(array('dompdf', 'file'));

		Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
		Conekta::setLocale('es');
		Conekta::setApiVersion("1.0.0");

		$contenido['id_pedido']      = $id_pedido;
		$contenido['pedido']         = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$reference                   = $contenido['pedido']->referencia_pago;
		$charges                     = Conekta_Charge::where(array('reference_id'=>$reference));
		$charges                     = json_decode($charges->__toJSON());
		$charge                      = $charges[0];
		$barcode                     = $charge->payment_method->barcode_url;
		$barcode_number              = $charge->payment_method->barcode;
		$expiration                  = $charge->payment_method->expires_at;
		$amount                      = $charge->amount / 100;
		$im                          = file_get_contents($barcode);
		$barcode                     = "data:image/png;base64," . base64_encode($im);
		$contenido['barcode']        = $barcode;
		$contenido['barcode_number'] = $barcode_number;
		$contenido['expiration']     = $expiration;
		$contenido['amount']         = $amount;

		$html = $this->load->view('carrito/pdf', $contenido, true);

		$nombre = pdf_create_file($html, 'pago_'.str_pad($reference, 8, '0', STR_PAD_LEFT), TRUE);

		return $nombre;
	}

	public function pdf_pedido_archivo($id_pedido){
		$this->load->helper(array('dompdf', 'file'));
		$contenido['accion'] = 'despliegue';
		$contenido['pedidos'] = 'despliegue';
		$contenido['id_pedido'] = $id_pedido;
		$contenido['pedido'] = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$contenido['productos'] = $this->pedidos_modelo->obtener_productos_por_pedido($id_pedido);

		foreach($contenido['productos'] as $indice => $producto) {
			if(!$producto->id_enhance) {
				$contenido['productos'][$indice]->diseno = json_decode($producto->diseno);
				$contenido['productos'][$indice]->imagen_principal = $contenido['productos'][$indice]->diseno->images->front;
				$contenido['productos'][$indice]->nombre_principal = $producto->nombre_producto.' personalizada';
			} else {
				$info_enhanced = $this->catalogo_modelo->obtener_enhanced_con_id($producto->id_enhance);
				$contenido['productos'][$indice]->imagen_principal = $info_enhanced->front_image;
				if($info_enhanced->type == 'fijo') {
					$contenido['productos'][$indice]->nombre_principal = 'Venta inmediata (Folio: '.($info_enhanced->id_parent_enhance == 0 ? $info_enhanced->id_enhance : $info_enhanced->id_parent_enhance).') - '.$info_enhanced->name;
				} else if($info_enhanced->type == 'limitado') {
					$contenido['productos'][$indice]->nombre_principal = 'Plazo definido (Folio: '.($info_enhanced->id_parent_enhance == 0 ? $info_enhanced->id_enhance : $info_enhanced->id_parent_enhance).') - '.$info_enhanced->name;
					$contenido['productos'][$indice]->especial = true;
					$contenido['productos'][$indice]->end_date = $info_enhanced->end_date;
				}
			}
		}

		$html = $this->load->view('administracion/pedidos/pdf_especifico', $contenido, true);

		$nombre = pdf_create_file($html, 'pedido_printome_'.str_pad($id_pedido, 8, '0', STR_PAD_LEFT));

		return $nombre;
	}

	public function pdf_pedido($id_pedido){
		$this->load->helper(array('dompdf', 'file'));
		$contenido['accion'] = 'despliegue';
		$contenido['pedidos'] = 'despliegue';
		$contenido['id_pedido'] = $id_pedido;
		$contenido['pedido'] = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$contenido['productos'] = $this->pedidos_modelo->obtener_productos_por_pedido($id_pedido);

		foreach($contenido['productos'] as $indice => $producto) {
			if(!$producto->id_enhance) {
				$contenido['productos'][$indice]->diseno = json_decode($producto->diseno);
				$contenido['productos'][$indice]->imagen_principal = $contenido['productos'][$indice]->diseno->images->front;
				$contenido['productos'][$indice]->nombre_principal = $producto->nombre_producto.' personalizada';
			} else {
				$info_enhanced = $this->catalogo_modelo->obtener_enhanced_con_id($producto->id_enhance);
				$contenido['productos'][$indice]->imagen_principal = $info_enhanced->front_image;
				if($info_enhanced->type == 'fijo') {
					$contenido['productos'][$indice]->nombre_principal = 'Venta inmediata (Folio: '.($info_enhanced->id_parent_enhance == 0 ? $info_enhanced->id_enhance : $info_enhanced->id_parent_enhance).') - '.$info_enhanced->name;
				} else if($info_enhanced->type == 'limitado') {
					$contenido['productos'][$indice]->nombre_principal = 'Plazo definido (Folio: '.($info_enhanced->id_parent_enhance == 0 ? $info_enhanced->id_enhance : $info_enhanced->id_parent_enhance).') - '.$info_enhanced->name;
					$contenido['productos'][$indice]->especial = true;
					$contenido['productos'][$indice]->end_date = $info_enhanced->end_date;
				}
			}
		}

		$html = $this->load->view('administracion/pedidos/pdf_especifico', $contenido, true);

		pdf_create($html, 'pedido_avanda_'.str_pad($id_pedido, 8, '0', STR_PAD_LEFT));
	}


	// Copia desde Pedidos para que se pueda usar publicamente
	public function abrir_dhl($pedido_id) {
		$pedido = $this->pedidos_modelo->obtener_pedido_especifico($pedido_id);
		redirect('http://www.dhl.com.mx/es/express/rastreo.html?AWB='.$pedido->codigo_rastreo.'&brand=DHL');
	}

	// Copia desde Pedidos para que se pueda usar publicamente
	public function abrir_dhl_movil($pedido_id) {
		$pedido = $this->pedidos_modelo->obtener_pedido_especifico($pedido_id);
		redirect('http://m.dhl.com.mx/es/rastreo.html?trackingType=express&trackingInput='.$pedido->codigo_rastreo.'&brand=DHL');
	}


	// Copia desde Pedidos para que se pueda usar publicamente
	public function abrir_dhl_limitado($codigo_rastreo){
		redirect("http://www.dhl.com.mx/es/express/rastreo.html?AWB=" . $codigo_rastreo . "&brand=DHL");
	}

	// Copia desde Pedidos para que se pueda usar publicamente
	public function abrir_dhl_movil_limitado($codigo_rastreo){
		redirect("http://m.dhl.com.mx/es/rastreo.html?trackingType=express&trackingInput=" . $codigo_rastreo . "&brand=DHL");
	}

	public function precios(){

		/* $data   = $this->input->post();

		$product_id   = $data['product_id'];

		$colors     = str_replace("#", "", $data['colors']);
		$esBlanca = false;
		if ($colors[0] == "FFFFFF" || $colors[0] == "FFF" || $colors[0] == "ffffff" || $colors[0] == "fff") {
			$esBlanca = true;
		}

		$print      = $data['print'];
		$quantity   = $data['quantity'];
		$print['colors'] = json_decode($print['colors']);

		$total_colors = array("front"=>0,"back"=>0,"left"=>0,"right"=>0);

		if(isset($cantidades)) {
			foreach ($cantidades as $cantidad) {
				if ($quantity < $cantidad) {
					break;
				}
			}
		}

		foreach ($print['colors'] as $key => $value) {
			$total_colors[$key] = count($value);
		}

		if ($quantity < 1 ) $quantity = 50; */

		//echo json_encode( getCost($total_colors, $esBlanca, $quantity) );
		//echo getCost($total_colors, $esBlanca, $quantity);
		echo 0.00;
	}



	// add to cart in designer
	public function addToCart($datos = null) {

		if(!$datos) {
			$data = $this->input->post();
		} else {
			$data = $datos;
		}

		$fonts = array();

		//we process te vector for being able to be saved in the database
		$vectors = json_decode($data['design']['vectors']);

		foreach (get_object_vars($vectors) as $key => $value) {
			$new_side = [];
			foreach (get_object_vars($value) as $k => $v) {
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

		$total_colors = array("front" => 0, "back" => 0, "left" => 0, "right" => 0);
		$print = $data['print'];
		$print['colors'] = json_decode($print['colors']);
		foreach ($print['colors'] as $key => $value) {
			$total_colors[$key] = count($value);
		}

		for ($i=0; $i < count($skus); $i++) {
			$skus[$i]->precio_final = getCost($total_colors, $esBlanca, $quantity, $skus[$i]);
		}

		$mismo_diseno = md5(time());

		// save file image design
		$design = array();
		if (isset($data['design']['images']['front']))
			$design['images']['front']  = createFile($data['design']['images']['front'], 'front', $mismo_diseno);
            $design['dibujos']['front']  = createFile($data['design']['dibujos']['front'], 'dis_front', $mismo_diseno);

		if (isset($data['design']['images']['back']))
			$design['images']['back']   = createFile($data['design']['images']['back'], 'back', $mismo_diseno);
			$design['dibujos']['back']   = createFile($data['design']['dibujos']['back'], 'dis_back', $mismo_diseno);

		if (isset($data['design']['images']['left']))
			$design['images']['left']   = createFile($data['design']['images']['left'], 'left', $mismo_diseno);
			$design['dibujos']['left']   = createFile($data['design']['dibujos']['left'], 'dis_left', $mismo_diseno);

		if (isset($data['design']['images']['right']))
			$design['images']['right']  = createFile($data['design']['images']['right'], 'right', $mismo_diseno);
			$design['dibujos']['right']  = createFile($data['design']['dibujos']['right'], 'dis_right', $mismo_diseno);

		$productos_flash = array();

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
                    'id_color'       => $sku->id_color,
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
						'colores' => $print['colors'],
						'images' => $design['images'],
						'vector' => $data['design']['vectors'],
						'fonts' => $data['fonts']
					)
				)
			);

			$this->cart->insert($item);

			$producto_flash = new stdClass();
			$producto_flash->nombre_producto = 'Producto personalizado: '.$nombre.', SKU: '.$sku->sku;
			$producto_flash->id_producto = $sku->sku;
			$producto_flash->precio = $sku->precio_final;
			$producto_flash->numero_items = $sku->quantity;

			array_push($productos_flash, $producto_flash);
		}

		//$this->session->set_flashdata('productos_flash', $productos_flash);
		$this->session->set_tempdata('productos_flash', $productos_flash, 5);

		// Si hay sesión activa se actualiza el carrito en la base de datos
		$id_cliente = $this->session->login['id_cliente'];
		$es_cliente = (!is_null($id_cliente));
		if($es_cliente) {
			$this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
		}
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
		}
		echo json_encode(array("url" => site_url("carrito") ));

	}

	public function addToCartMultiple($datos = null)
    {
        if(!$datos) {
            $productos = $this->input->post('productos');
        } else {
            $productos = $datos;
        }

        $cantidad_total = 0;
        foreach($productos as $indice=>$producto) {
            foreach ($producto['sizes'] as $talla) {
                $cantidad_total += $talla["cantidad"];
            }
        }

        $mismo_diseno = md5(time());

        if(isset($productos[0]['dibujo_front'])) {
            $dibujo_front = createFile($productos[0]['dibujo_front'], 'dibujo_front', $mismo_diseno);
        }
        if(isset($productos[0]['dibujo_back'])) {
            $dibujo_back = createFile($productos[0]['dibujo_back'], 'dibujo_back', $mismo_diseno);
        }
        if(isset($productos[0]['dibujo_left'])) {
            $dibujo_left = createFile($productos[0]['dibujo_left'], 'dibujo_left', $mismo_diseno);
        }
        if(isset($productos[0]['dibujo_right'])) {
            $dibujo_right = createFile($productos[0]['dibujo_right'], 'dibujo_right', $mismo_diseno);
        }

        $items_a_insertar = array();

        $productos_flash = array();

        foreach($productos as $indice=>$data) {

            $fonts = array();

            //we process te vector for being able to be saved in the database
            $vectors = json_decode($data['design']['vectors']);

            foreach (get_object_vars($vectors) as $key => $value) {
                $new_side = [];
                foreach (get_object_vars($value) as $k => $v) {
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
                $item = $this->catalogo_modelo->obtener_producto_sku_por_id($talla["id_sku"], $talla["cantidad"]);
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

            $total_colors = array("front" => 0, "back" => 0, "left" => 0, "right" => 0);
            $print = $data['print'];
            $print['colors'] = json_decode($print['colors']);
            foreach ($print['colors'] as $key => $value) {
                $total_colors[$key] = count($value);
            }

            for ($i=0; $i < count($skus); $i++) {
                $skus[$i]->precio_final = getCost($total_colors, $esBlanca, $cantidad_total, $skus[$i]);
            }

            // save file image design
            // Trabajar aqui en la generacion de imagenes despues del indice 0
            if($indice == 0) {
                $design = array();
                $design['images'] = array();
                if (isset($data['design']['images']['front']))
                    $design['images']['front']  = createFile($data['design']['images']['front'], 'front', $mismo_diseno);

                if (isset($data['design']['images']['back']))
                    $design['images']['back']   = createFile($data['design']['images']['back'], 'back', $mismo_diseno);

                if (isset($data['design']['images']['left']))
                    $design['images']['left']   = createFile($data['design']['images']['left'], 'left', $mismo_diseno);

                if (isset($data['design']['images']['right']))
                    $design['images']['right']  = createFile($data['design']['images']['right'], 'right', $mismo_diseno);
            } else {
                $design = array();
                $design['images'] = array();

                if (isset($data['design']['dibujo_front'])){
                    $dibujo = createFile($data['design']['dibujo_front'], 'front', $mismo_diseno."_".$indice);
                }
                if (isset($data['design']['dibujo_back'])){
                    $dibujoback = createFile($data['design']['dibujo_back'], 'back', $mismo_diseno."_".$indice);
                }
                if (isset($data['design']['dibujo_left'])){
                    $dibujoleft = createFile($data['design']['dibujo_left'], 'left', $mismo_diseno."_".$indice);
                }
                if (isset($data['design']['dibujo_right'])){
                    $dibujoright = createFile($data['design']['dibujo_right'], 'right', $mismo_diseno."_".$indice);
                }


                $product_id = $data['product_id'];
                $this->db->select('*')->from('DisenoProductos')->where('id_producto', $product_id);
                $design_info_res = $this->db->get()->result();
                $design_info = $design_info_res[0];

                $design_info->color_hex = json_decode($design_info->color_hex);
                $design_info->color_title = json_decode($design_info->color_title);
                $design_info->front = json_decode($design_info->front);
                $design_info->back = json_decode($design_info->back);
                $design_info->left = json_decode($design_info->left);
                $design_info->right = json_decode($design_info->right);

                $mi_indice = 0;

                foreach($data['colors'] as $indice_data => $mi_color) {
                    foreach($design_info->color_hex as $indice_color_hex => $color_hex) {
                        if($color_hex == $mi_color) {
                            $mi_indice = $indice_color_hex;
                        }
                    }
                }

                foreach($data['colors'] as $indice_data => $mi_color) {
                    foreach($design_info->color_hex as $indice_color_hex => $color_hex) {
                        if($color_hex != $mi_color) {
                            unset($design_info->color_hex[$indice_color_hex]);
                            unset($design_info->color_title[$indice_color_hex]);
                            unset($design_info->front[$indice_color_hex]);
                            unset($design_info->back[$indice_color_hex]);
                            unset($design_info->left[$indice_color_hex]);
                            unset($design_info->right[$indice_color_hex]);
                        }
                    }
                }

                $design_info->front[$mi_indice] = json_decode(str_replace("'",'"',$design_info->front[$mi_indice]));
                $design_info->back[$mi_indice] = json_decode(str_replace("'",'"',$design_info->back[$mi_indice]));
                $design_info->left[$mi_indice] = json_decode(str_replace("'",'"',$design_info->left[$mi_indice]));
                $design_info->right[$mi_indice] = json_decode(str_replace("'",'"',$design_info->right[$mi_indice]));
                $design_info->area = json_decode($design_info->area);
                $design_info->area->front = json_decode(str_replace("'",'"',$design_info->area->front));
                $design_info->area->back = json_decode(str_replace("'",'"',$design_info->area->back));
                $design_info->area->left = json_decode(str_replace("'",'"',$design_info->area->left));
                $design_info->area->right = json_decode(str_replace("'",'"',$design_info->area->right));
                $design_info->params = json_decode($design_info->params);

                if(isset($dibujo_front)) {
                    // Imagen frontal
                    $img_front = new \Imagick();
                    $img_front->readImage(realpath($design_info->front[$mi_indice]->{1}->img));
                    $img_front->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);
                    $filename_dis_front = "media/assets/system/".date("Y")."/".date("m")."/dis_front_".$mismo_diseno."_".$indice.".jpg";

                    $img_dis_front = new \Imagick();
                    $img_dis_front->readImage(realpath($dibujo_front));
                    $img_dis_front->writeImage($filename_dis_front);
                    $img_dis_front->resizeimage($design_info->area->front->width, $design_info->area->front->height, \Imagick::FILTER_LANCZOS, 1);

                    $img_front->compositeImage($img_dis_front, \Imagick::COMPOSITE_ATOP, str_replace("px", "", $design_info->area->front->left), str_replace("px", "", $design_info->area->front->top));

                    $filename_front = "media/assets/system/".date("Y")."/".date("m")."/front_".$mismo_diseno."_".$indice.".jpg";
                    $img_front->writeImage($filename_front);

                    $design['images']['front'] = $filename_front;
                } else {
                    // Imagen frontal
                    if(isset($dibujo)){

                        $img_front = new \Imagick();
                        $img_front->readImage(realpath($design_info->front[$mi_indice]->{1}->img));
                        $img_front->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);
                        $filename_dis_front = "media/assets/system/".date("Y")."/".date("m")."/dis_front_".$mismo_diseno."_".$indice.".jpg";

                        $img_dis_front = new \Imagick();
                        $img_dis_front->readImage(realpath($dibujo));
                        $img_dis_front->writeImage($filename_dis_front);
                        $img_dis_front->resizeimage($design_info->area->front->width, $design_info->area->front->height, \Imagick::FILTER_LANCZOS, 1);

                        $img_front->compositeImage($img_dis_front, \Imagick::COMPOSITE_ATOP, str_replace("px", "", $design_info->area->front->left), str_replace("px", "", $design_info->area->front->top));

                        $filename_front = "media/assets/system/".date("Y")."/".date("m")."/front_".$mismo_diseno."_".$indice.".jpg";
                        $img_front->writeImage($filename_front);

                        $design['images']['front'] = $filename_front;
                    }else{
                        $img_front = new \Imagick();
                        $img_front->readImage(realpath($design_info->front[$mi_indice]->{1}->img));
                        $img_front->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);

                        $filename_front = "media/assets/system/".date("Y")."/".date("m")."/front_".$mismo_diseno."_".$indice.".jpg";
                        $img_front->writeImage($filename_front);

                        $design['images']['front'] = $filename_front;
                    }

                }
                if(isset($dibujo_back)) {
                    // Imagen back
                    $img_back = new \Imagick();
                    $img_back->readImage(realpath($design_info->back[$mi_indice]->{1}->img));
                    $img_back->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);
                    $filename_dis_back = "media/assets/system/".date("Y")."/".date("m")."/dis_back_".$mismo_diseno."_".$indice.".jpg";

                    $img_dis_back = new \Imagick();
                    $img_dis_back->readImage(realpath($dibujo_back));
                    $img_dis_back->writeImage($filename_dis_back);
                    $img_dis_back->resizeimage($design_info->area->back->width, $design_info->area->back->height, \Imagick::FILTER_LANCZOS, 1);

                    $img_back->compositeImage($img_dis_back, \Imagick::COMPOSITE_ATOP, str_replace("px", "", $design_info->area->back->left), str_replace("px", "", $design_info->area->back->top));

                    $filename_back = "media/assets/system/".date("Y")."/".date("m")."/back_".$mismo_diseno."_".$indice.".jpg";
                    $img_back->writeImage($filename_back);

                    $design['images']['back'] = $filename_back;
                } else {

                    if(isset($dibujoback)){
                        // Imagen back
                        $img_back = new \Imagick();
                        $img_back->readImage(realpath($design_info->back[$mi_indice]->{1}->img));
                        $img_back->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);
                        $filename_dis_back = "media/assets/system/".date("Y")."/".date("m")."/dis_back_".$mismo_diseno."_".$indice.".jpg";

                        $img_dis_back = new \Imagick();
                        $img_dis_back->readImage(realpath($dibujoback));
                        $img_dis_back->writeImage($filename_dis_back);
                        $img_dis_back->resizeimage($design_info->area->back->width, $design_info->area->back->height, \Imagick::FILTER_LANCZOS, 1);

                        $img_back->compositeImage($img_dis_back, \Imagick::COMPOSITE_ATOP, str_replace("px", "", $design_info->area->back->left), str_replace("px", "", $design_info->area->back->top));

                        $filename_back = "media/assets/system/".date("Y")."/".date("m")."/back_".$mismo_diseno."_".$indice.".jpg";
                        $img_back->writeImage($filename_back);

                        $design['images']['back'] = $filename_back;
                    }else{
                        $img_back = new \Imagick();
                        $img_back->readImage(realpath($design_info->back[$mi_indice]->{1}->img));
                        $img_back->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);

                        $filename_back = "media/assets/system/".date("Y")."/".date("m")."/back_".$mismo_diseno."_".$indice.".jpg";
                        $img_back->writeImage($filename_back);

                        $design['images']['back'] = $filename_back;

                    }

                }
                if(isset($dibujo_left)) {
                    // Imagen left

                    $img_left = new \Imagick();

                    $img_left->readImage(realpath($design_info->left[$mi_indice]->{1}->img));
                    $img_left->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);
                    $filename_dis_left = "media/assets/system/".date("Y")."/".date("m")."/dis_left_".$mismo_diseno."_".$indice.".jpg";

                    $img_dis_left = new \Imagick();
                    $img_dis_left->readImage(realpath($dibujo_left));
                    $img_dis_left->writeImage($filename_dis_left);
                    $sizes = $img_dis_left->getImageGeometry();
                    $new_height = ($design_info->area->left->width * $sizes['height'])/$sizes['width'];

                    $img_dis_left->resizeimage($design_info->area->left->width, $new_height, \Imagick::FILTER_LANCZOS, 1);

                    $img_left->compositeImage($img_dis_left, \Imagick::COMPOSITE_ATOP, str_replace("px", "", $design_info->area->left->left), str_replace("px", "", $design_info->area->left->top));

                    $filename_left = "media/assets/system/".date("Y")."/".date("m")."/left_".$mismo_diseno."_".$indice.".jpg";
                    $img_left->writeImage($filename_left);

                    $design['images']['left'] = $filename_left;
                } else {
                    // Imagen left
                    if(isset($dibujoleft)){
                        // Imagen left

                        $img_left = new \Imagick();

                        $img_left->readImage(realpath($design_info->left[$mi_indice]->{1}->img));
                        $img_left->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);
                        $filename_dis_left = "media/assets/system/".date("Y")."/".date("m")."/dis_left_".$mismo_diseno."_".$indice.".jpg";

                        $img_dis_left = new \Imagick();
                        $img_dis_left->readImage(realpath($dibujoleft));
                        $img_dis_left->writeImage($filename_dis_left);
                        $sizes = $img_dis_left->getImageGeometry();
                        $new_height = ($design_info->area->left->width * $sizes['height'])/$sizes['width'];

                        $img_dis_left->resizeimage($design_info->area->left->width, $new_height, \Imagick::FILTER_LANCZOS, 1);

                        $img_left->compositeImage($img_dis_left, \Imagick::COMPOSITE_ATOP, str_replace("px", "", $design_info->area->left->left), str_replace("px", "", $design_info->area->left->top));

                        $filename_left = "media/assets/system/".date("Y")."/".date("m")."/left_".$mismo_diseno."_".$indice.".jpg";
                        $img_left->writeImage($filename_left);

                        $design['images']['left'] = $filename_left;
                    }else{
                        if(empty($design_info->left[$mi_indice])){
                            $design['images']['left'] = '';
                            //print_r('vacio');
                        }else{
                            //print_r('no vacio');
                            $img_left = new \Imagick();

                            $img_left->readImage(realpath($design_info->left[$mi_indice]->{1}->img));
                            $img_left->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);

                            $filename_left = "media/assets/system/".date("Y")."/".date("m")."/left_".$mismo_diseno."_".$indice.".jpg";
                            $img_left->writeImage($filename_left);

                            $design['images']['left'] = $filename_left;
                        }

                    }

                }
                if(isset($dibujo_right)) {
                    // Imagen right
                    $img_right = new \Imagick();
                    $img_right->readImage(realpath($design_info->right[$mi_indice]->{1}->img));
                    $img_right->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);
                    $filename_dis_right = "media/assets/system/".date("Y")."/".date("m")."/dis_right_".$mismo_diseno."_".$indice.".jpg";

                    $img_dis_right = new \Imagick();
                    $img_dis_right->readImage(realpath($dibujo_right));
                    $img_dis_right->writeImage($filename_dis_right);

                    $sizes = $img_dis_right->getImageGeometry();
                    $new_height = ($design_info->area->right->width * $sizes['height'])/$sizes['width'];

                    $img_dis_right->resizeimage($design_info->area->right->width, $new_height, \Imagick::FILTER_LANCZOS, 1);

                    $img_right->compositeImage($img_dis_right, \Imagick::COMPOSITE_ATOP, str_replace("px", "", $design_info->area->right->left), str_replace("px", "", $design_info->area->right->top));

                    $filename_right = "media/assets/system/".date("Y")."/".date("m")."/right_".$mismo_diseno."_".$indice.".jpg";
                    $img_right->writeImage($filename_right);

                    $design['images']['right'] = $filename_right;
                } else {
                    // Imagen right
                    if(isset($dibujoright)){
                        // Imagen right
                        $img_right = new \Imagick();
                        $img_right->readImage(realpath($design_info->right[$mi_indice]->{1}->img));
                        $img_right->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);
                        $filename_dis_right = "media/assets/system/".date("Y")."/".date("m")."/dis_right_".$mismo_diseno."_".$indice.".jpg";

                        $img_dis_right = new \Imagick();
                        $img_dis_right->readImage(realpath($dibujoright));
                        $img_dis_right->writeImage($filename_dis_right);

                        $sizes = $img_dis_right->getImageGeometry();
                        $new_height = ($design_info->area->right->width * $sizes['height'])/$sizes['width'];

                        $img_dis_right->resizeimage($design_info->area->right->width, $new_height, \Imagick::FILTER_LANCZOS, 1);

                        $img_right->compositeImage($img_dis_right, \Imagick::COMPOSITE_ATOP, str_replace("px", "", $design_info->area->right->left), str_replace("px", "", $design_info->area->right->top));

                        $filename_right = "media/assets/system/".date("Y")."/".date("m")."/right_".$mismo_diseno."_".$indice.".jpg";
                        $img_right->writeImage($filename_right);

                        $design['images']['right'] = $filename_right;
                    }else{
                        if(empty($design_info->right[$mi_indice])){
                            $design['images']['right'] = '';
                        }else{
                            $img_right = new \Imagick();
                            $img_right->readImage(realpath($design_info->right[$mi_indice]->{1}->img));
                            $img_right->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);

                            $filename_right = "media/assets/system/".date("Y")."/".date("m")."/right_".$mismo_diseno."_".$indice.".jpg";
                            $img_right->writeImage($filename_right);

                            $design['images']['right'] = $filename_right;
                        }

                    }

                }
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
                        'id_color'      => $sku->id_color,
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
                            'colores' => $print['colors'],
                            'images' => $design['images'],
                            'vector' => $data['design']['vectors'],
                            'fonts' => $data['fonts']
                        )
                    )
                );

                array_push($items_a_insertar, $item);

                $producto_flash = new stdClass();
                $producto_flash->nombre_producto = 'Producto personalizado: '.$nombre.', SKU: '.$sku->sku;
                $producto_flash->id_producto = $sku->sku;
                $producto_flash->precio = $sku->precio_final;
                $producto_flash->numero_items = $sku->quantity;

                array_push($productos_flash, $producto_flash);

            }
        }

        $this->session->set_tempdata('productos_flash', $productos_flash, 5);

        $this->cart->insert($items_a_insertar);

        //Si hay sesión activa se actualiza el carrito en la base de datos
        $id_cliente = $this->session->login['id_cliente'];
        $es_cliente = (!is_null($id_cliente));
        if($es_cliente) {
            $this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
        }
        if($this->session->has_userdata('correo_temporal')) {
            $this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
        }
        echo json_encode(array("url" => site_url("carrito") ));
    }

	public function cotizar()
	{

		$data   = $this->input->post();

		//print_r($data);

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

		if($quantity > 0) {

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

			$total_colors = array("front" => 0, "back" => 0, "left" => 0, "right" => 0);
			$print = $data['print'];
			$print['colors'] = json_decode($print['colors']);
			foreach ($print['colors'] as $key => $value) {
				$total_colors[$key] = count($value);
			}

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
				if (isset($next["first"])) {
					$final->precio_next  = getCost($total_colors, $esBlanca, $next["first"], $skus[$i]);
				}

				if (isset($next["second"])) {
					$final->precio_second  = getCost($total_colors, $esBlanca, $next["second"], $skus[$i]);
				}

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

			$resultado = new stdClass();
			$resultado->original = new stdClass();
			$resultado->original->precio = '$'.$this->cart->format_number($original);
			$resultado->original->total = '$'.$this->cart->format_number($original * $quantity);

			if (isset($next["first"])) {
				$resultado->first = new stdClass();
				$resultado->first->cantidad = $next["first"];
				$resultado->first->precio = '$'.$this->cart->format_number($this->cart->format_number($first));
				$resultado->first->total = '$'.$this->cart->format_number($this->cart->format_number($first) * $next["first"]);
			}

			if (isset($next["second"])) {
				$resultado->second = new stdClass();
				$resultado->second->cantidad = $next["second"];
				$resultado->second->precio = '$'.$this->cart->format_number($this->cart->format_number($second));
				$resultado->second->total = '$'.$this->cart->format_number($this->cart->format_number($second) * $next["second"]);
			}

			$resultado->colores = $total_colors;

			echo json_encode($resultado);
		}
	}

	public function cotizar_multiples()
	{
		$data   = $this->input->post();

		//print_r($data);

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

		if(isset($data['print'])) {

			$total_colors = array("front" => 0, "back" => 0, "left" => 0, "right" => 0);
			$print = $data['print'];
			$print['colors'] = json_decode($print['colors']);
			foreach ($print['colors'] as $key => $value) {
				$total_colors[$key] = count($value);
			}
		} else {
			$total_colors = json_decode(json_decode($data['total_colors'], TRUE), TRUE);
		}

		$finals = array();

		$texts = array();


		for ($i=0; $i < count($skus); $i++) {
			$talla = json_decode($skus[$i]->caracteristicas)->talla;
			$final = new stdClass;
			$final->talla = $talla;
			$final->precio = getCost($total_colors, $esBlanca, $data['cantidad_total'], $skus[$i]);

			$finals[]  = $final;
		}

		$cotizado = new stdClass;
		$cotizado->original = array();

		foreach ($finals as $key => $value) {
			$cotizado->original[] = $value->precio;
		}

		if(count($cotizado->original) > 0) {
			$original = array_sum($cotizado->original) / count($cotizado->original);
		} else {
			$original = 0;
		}

		$resultado = new stdClass();
		$resultado->original = new stdClass();
		if($original != 0) {
			$resultado->original->precio = '$'.$this->cart->format_number($original);
			$resultado->original->total = '$'.$this->cart->format_number($original * $quantity);
		} else {
			$resultado->original->precio = '$ -';
			$resultado->original->total = '$ -';
		}

		echo json_encode($resultado);

	}

	public function obtener_custom_especifico()
	{
		$id_diseno = $this->input->post('id_diseno');
		$cart_contents = $this->cart->contents();

		foreach($cart_contents as $indice_cart => $cart_content) {
			$options = $cart_content['options'];
			if(isset($options['id_diseno'])) {
				if($options['id_diseno'] != $id_diseno) {
					unset($cart_contents[$indice_cart]);
				}
			} else {
				unset($cart_contents[$indice_cart]);
			}
		}

		$customs = array();
		$item_id = 0;
        $id_color = 0;


		$product_ids = array();

		foreach($cart_contents as $item) {
			$options = $item['options'];
			if(isset($options['id_diseno'])) {
				if($options['id_diseno'] == $id_diseno) {
					if($id_color != $options['id_color']) {
                        $id_color = $options['id_color'];
                        $prod = array(
                            'id_producto' => $item['id'],
                            'id_color'    => $options['id_color']
                        );
						array_push($product_ids, $prod);
					}
				}
			}
		}

		if(sizeof($product_ids) == 1) {

			foreach($cart_contents as $item) {
				$options = $item['options'];
				if(isset($options['id_diseno'])) {
					if($item['id'] != $item_id) {

						$cliparts = array();
						foreach($item['options']['disenos']['vector'] as $lado=>$vectores) {
							if(count($item['options']['disenos']['vector']->$lado) > 0) {
								foreach($item['options']['disenos']['vector']->$lado as $vector) {
									if(isset($vector->clipart_id)) {
										$cliparts[$lado][] = $vector->clipart_id;
									}
								}
							}
						}

						$customs[] = array(
							'nombre'			=> $item['name'],
							'product_id' 		=> $item['id'],
							'colors'			=> array($item['options']['disenos']['color']),
							'quantity'			=> 0,
							'design'			=> array(
								'vectors' => json_encode($item['options']['disenos']['vector']),
								'images'  => $item['options']['disenos']['images'],
								'colores' => (isset($item['options']['disenos']['colores']) ? $item['options']['disenos']['colores'] : array())
							),
							'design_id'			=> $options['id_diseno'],
							'fonts'				=> '',
							'cliparts'			=> $cliparts,
							'total_colors'		=> (array)$item['options']['calculadora']['colores_totales']
						);

						$item_id = $item['id'];
					}
				}
			}

			foreach($customs as $indice=>$custom) {
				foreach($cart_contents as $item) {
					$options = $item['options'];
					if(isset($options['id_diseno'])) {
						if($options['id_diseno'] == $custom['design_id']) {
							$customs[$indice]['quantity'] += $item['qty'];
							$customs[$indice]['sizes'][] = array(
								'talla' => $options['sku'],
								'cantidad' => $item['qty']
							);
						}
					}
				}
			}

			foreach($customs as $indice=>$custom) {
				if($custom['design_id'] == $id_diseno) {
					$el_diseno = $customs[$indice];
				}
			}

			echo '<p class="aceptamos" style="color:#555">Selecciona el número de playeras por talla que quieras para cotizar tu pedido.</p>
			<div class="row  estilo_completo" data-did="'.$el_diseno['design_id'].'">
				<div class="small-18 medium-3 large-4 columns">
					<div class="secondary-img-container">
						<img src="'.site_url($el_diseno['design']['images']['front']).'" alt="">
					</div>
				</div>
				<div class="small-18 medium-15 large-14 columns">
					<div class="row ">
						<div class="medium-11 columns">
							<div class="row">
								<div class="small-18 columns">
									<span class="custom-prod-title">'.$el_diseno['nombre'].' personalizada</span>
								</div>
							</div>
							<div class="clearfix tallitas">';
								foreach($this->catalogo_modelo->obtener_tallas_por_producto_y_hex($el_diseno['product_id'], '#'.$el_diseno['colors'][0]) as $key=>$color) {
									$aqui_si = false;
									foreach($el_diseno['sizes'] as $size) {
										if($size['talla'] == $color->id_sku) {
											$aqui_si = true;
											$cantidad = $size['cantidad'];
											$talla = $size['talla'];
										}
									}

									echo '<div class="color_'.url_title($color->nombre_color).' tallita">
										<label for="input_'.$color->id_sku.'">'.$color->caracteristicas->talla.'</label>
										<select data-did="'.$el_diseno['design_id'].'" data-cantidad-talla class="text-center" name="sku['.$color->id_sku.']" id="input_'.$color->id_sku.'">
											<option value="0">0</option>';
											for($i=1;$i<=$color->cantidad_inicial;$i++) {
											//for($i=1;$i<=100;$i++) {
											echo '<option value="'.$i.'"'; if($aqui_si && ($color->id_sku == $talla) && ($cantidad == $i)) { echo ' selected'; }  echo '>'.$i.'</option>';
											}
									echo '</select>
								</div>';
								}
						echo '</div>
							<div class="row">
								<div class="small-18 columns">
									<span class="cantidad">Cantidad: <span class="cantidad_lote" data-cantidad_lote data-did="'.$el_diseno['design_id'].'">'.$el_diseno['quantity'].'</span></span>
								</div>
							</div>
						</div>
						<div class="small-9 medium-3 columns">
							<label class="text-center custom-prod-title custom-price-new">Precio unidad</label>
							<span class="custom-prod-price-text" data-did="'.$el_diseno['design_id'].'" data-unidad>$ -</span>
						</div>
						<div class="small-9 medium-4 columns">
							<label class="text-center custom-prod-title custom-price-new">Subtotal</label>
							<span class="custom-prod-price-text" data-did="'.$el_diseno['design_id'].'" data-subtotal>$ -</span>
						</div>
					</div>
				</div>
				<div class="small-18 columns">
					<input type="hidden" id="d_vectors" value=\''.json_encode($el_diseno['design']['vectors']).'\'>
					<input type="hidden" id="d_colors" value=\''.json_encode($el_diseno['colors']).'\'>
					<input type="hidden" id="d_sizes" value=\''.json_encode($el_diseno['sizes']).'\'>
					<input type="hidden" id="d_totalcolors" value=\''.json_encode($el_diseno['total_colors']).'\'>
					<div id="cotizacion">

					</div>
				</div>
			</div>';
		} else {

			foreach($product_ids as $id) {
                $item_id = $id['id_producto'];
                $color_id = $id['id_color'];

				foreach($cart_contents as $item) {
					$options = $item['options'];
					if(isset($options['id_diseno'])) {
						if($item['id'] == $item_id && $options['id_color'] == $color_id) {

							$cliparts = array();
							foreach($item['options']['disenos']['vector'] as $lado=>$vectores) {
								if(count($item['options']['disenos']['vector']->$lado) > 0) {
									foreach($item['options']['disenos']['vector']->$lado as $vector) {
										if(isset($vector->clipart_id)) {
											$cliparts[$lado][] = $vector->clipart_id;
										}
									}
								}
							}

							$customs[] = array(
								'nombre'			=> $item['name'],
								'product_id' 		=> $item['id'],
                                'color_id'          => $item['options']['id_color'],
								'colors'			=> array($item['options']['disenos']['color']),
								'quantity'			=> 0,
								'design'			=> array(
									'vectors' => json_encode($item['options']['disenos']['vector']),
									'images'  => $item['options']['disenos']['images'],
									'colores' => (isset($item['options']['disenos']['colores']) ? $item['options']['disenos']['colores'] : array())
								),
								'design_id'			=> $options['id_diseno'],
								'fonts'				=> '',
								'cliparts'			=> $cliparts,
								'total_colors'		=> (array)$item['options']['calculadora']['colores_totales']
							);
						}
					}
				}
			}

			$cantidades_array = array();
			foreach($product_ids as $id) {
                $item_id = $id['id_producto'];
                $color_id = $id['id_color'];

				foreach($cart_contents as $item) {
					$options = $item['options'];
					if(isset($options['id_diseno'])) {
						if($item['id'] == $item_id && $item['options']['id_diseno'] && $color_id == $item['options']['id_color']) {
							$cantidades_array[$item_id.'_'.$color_id] = array();
						}
					}
				}
			}

			foreach($product_ids as $id) {
                $item_id = $id['id_producto'];
                $color_id = $id['id_color'];

				foreach($cart_contents as $item) {

					$options = $item['options'];
					if(isset($options['id_diseno'])) {
						if($options['id_diseno'] == $id_diseno && $item['id'] == $id['id_producto'] && $color_id == $item['options']['id_color']) {
							$cantidades_array[$item_id.'_'.$color_id][$options['sku']] = array(
								'talla' => $options['sku'],
								'cantidad' => $item['qty']
							);
						}
					}
				}
			}
            $customs = super_unique($customs);

			foreach($customs as $indice=>$custom) {
				foreach($cart_contents as $item) {
					$options = $item['options'];
					if(isset($options['id_diseno'])) {
						if($options['id_diseno'] == $custom['design_id'] && $options['id_color'] == $custom['color_id']) {
							$customs[$indice]['quantity'] += $item['qty'];
							$customs[$indice]['sizes'] = $cantidades_array[$custom['product_id'].'_'.$custom['color_id']];
						}
					}
				}

				$customs[$indice]['cantidad_especifica'] = 0;
				foreach($customs[$indice]['sizes'] as $size) {
					$customs[$indice]['cantidad_especifica'] += $size['cantidad'];
				}
			}


			echo '<p class="aceptamos" style="color:#555">Selecciona el número de playeras por talla que quieras para cotizar tu pedido.</p>';
			foreach($customs as $custom) {
				//echo '<pre>'; print_r($custom); echo '</pre>';
			?>
			<div class="row  estilo_completo" data-did="<?php echo $custom['design_id']; ?>" data-id_producto="<?php echo $custom['product_id']; ?>" data-id_color="<?php $info_color = $this->catalogo_modelo->obtener_id_color_con_id_producto_y_hex($custom['product_id'], $custom['colors'][0]); echo $info_color->id_color; ?>" data-color="<?php echo $custom['colors'][0]; ?>">
				<div class="small-18 medium-3 large-4 columns">
					<div class="secondary-img-container" data-can_otro="15">
						<img src="<?php echo site_url($custom['design']['images']['front']); ?>" alt="">
					</div>
				</div>
				<div class="small-18 medium-15 large-14 columns">
					<div class="row ">
						<div class="medium-11 columns">
							<div class="row">
								<div class="small-18 columns">
									<span class="custom-prod-title"><?php echo $custom['nombre']; ?> personalizada</span>
								</div>
							</div>
							<div class="clearfix tallitas">
							<?php foreach($this->catalogo_modelo->obtener_tallas_por_producto_y_hex($custom['product_id'], '#'.$custom['colors'][0]) as $key=>$color) {
								$aqui_si = false;
								foreach($custom['sizes'] as $size) {
									if($size['talla'] == $color->id_sku) {
										$aqui_si = true;
										$cantidad = $size['cantidad'];
										$talla = $size['talla'];
									}
								}

								echo '<div class="color_'.url_title($color->nombre_color).' tallita">
										<label for="input_'.$color->id_sku.'">'.$color->caracteristicas->talla.'</label>
										<select data-cantidad-talla-multiple class="text-center" name="sku['.$color->id_sku.']" id="input_'.$color->id_sku.'">
											<option value="0">0</option>';
											for($i=1;$i<=$color->cantidad_inicial;$i++) {
											echo '<option value="'.$i.'"'; if($aqui_si && ($color->id_sku == $talla) && ($cantidad == $i)) { echo ' selected'; }  echo '>'.$i.'</option>';
											}
									echo '</select>
								</div>';
							} ?>
							</div>
							<div class="row">
								<div class="small-18 columns">
									<span class="cantidad">Cantidad: <span class="cantidad_lote" data-cantidad_lote><?php echo $custom['cantidad_especifica']; ?></span></span>
								</div>
								<input type="hidden" class="d_vectors" value='<?php echo json_encode($custom['design']['vectors']); ?>'>
								<input type="hidden" class="d_colors" value='<?php echo json_encode($custom['colors']); ?>'>
								<input type="hidden" class="d_sizes" value='<?php echo json_encode($custom['sizes']); ?>'>
								<input type="hidden" class="d_totalcolors" value='<?php echo json_encode($custom['total_colors']); ?>'>

								<input type="hidden" class="tallas_nuevas" value=''>
							</div>
						</div>
						<div class="small-9 medium-3 columns">
							<label class="text-center custom-prod-title custom-price-new">Precio unidad</label>
							<span class="custom-prod-price-text" data-unidad>$ -</span>
						</div>
						<div class="small-9 medium-4 columns">
							<label class="text-center custom-prod-title custom-price-new">Subtotal</label>
							<span class="custom-prod-price-text" data-subtotal>$ -</span>
						</div>
					</div>
				</div>
			</div>


			<?php
			}
		}

	}

	public function reinsertar_custom_en_carrito()
	{
		$sizes = json_decode($this->input->post('sizes'), TRUE);

		$id_diseno = $this->input->post('design_id');

		$cart_contents = $this->cart->contents();

		foreach($cart_contents as $indice_cart => $cart_content) {
			$options = $cart_content['options'];
			if(isset($options['id_diseno'])) {
				if($options['id_diseno'] != $id_diseno) {
					unset($cart_contents[$indice_cart]);
				}
			} else {
				unset($cart_contents[$indice_cart]);
			}
		}

		$customs = array();
		$item_id = 0;

		foreach($cart_contents as $item) {
			$options = $item['options'];
			if(isset($options['id_diseno'])) {
				if($item['id'] != $item_id) {

					$cliparts = array();
					foreach($item['options']['disenos']['vector'] as $lado=>$vectores) {
						if(count($item['options']['disenos']['vector']->$lado) > 0) {
							foreach($item['options']['disenos']['vector']->$lado as $vector) {
								if(isset($vector->clipart_id)) {
									$cliparts[$lado][] = $vector->clipart_id;
								}
							}
						}
					}

					$customs[] = array(
						'product_id' 		=> $item['id'],
                        'color_id'          => $item['options']['id_color'],
						'colors'			=> array($item['options']['disenos']['color']),
						'quantity'			=> 0,
						'design'			=> array(
							'vectors' => json_encode($item['options']['disenos']['vector']),
							'images'  => $item['options']['disenos']['images'],
							'colores' => (isset($item['options']['disenos']['colores']) ? $item['options']['disenos']['colores'] : array())
						),
						'design_id'			=> $options['id_diseno'],
						'fonts'				=> '',
						'cliparts'			=> $cliparts,
						'total_colors'		=> (array)$item['options']['calculadora']['colores_totales']
					);

					$item_id = $item['id'];
				}
			}
		}

		foreach($customs as $indice=>$custom) {
			foreach($cart_contents as $item) {
				$options = $item['options'];
				if(isset($options['id_diseno'])) {
					if($options['id_diseno'] == $custom['design_id']) {
						$customs[$indice]['quantity'] += $item['qty'];
						$customs[$indice]['sizes'][] = array(
							'talla' => $options['sku'],
							'cantidad' => $item['qty']
						);
					}
				}
			}
		}

		foreach($customs as $indice=>$custom) {
			if($custom['design_id'] == $id_diseno) {
				$el_diseno = $customs[$indice];
			}
		}

		$el_diseno['sizes'] = $sizes;

		foreach($cart_contents as $indice_carrito => $item) {
			$options = $item['options'];
			if(isset($options['id_diseno'])) {
				if($id_diseno == $options['id_diseno']) {

					$data = array(
						'rowid' => $indice_carrito,
						'qty'   => 0
					);

					$this->cart->update($data);

				}
			}
		}

		$id_cliente = $this->session->login['id_cliente'];
		$es_cliente = (!is_null($id_cliente));
		if($es_cliente) {
			$this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
		}
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
		}

		$fonts = array();

		$data = $el_diseno;

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
                    'id_color'      => $sku->id_color,
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

		$id_cliente = $this->session->login['id_cliente'];
		$es_cliente = (!is_null($id_cliente));
		if($es_cliente) {
			$this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
		}
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
		}

	}

	public function reinsertar_custom_multiple_en_carrito() {

		$id_diseno = $this->input->post('id_diseno');
		$cart_contents = $this->cart->contents();

		foreach($cart_contents as $indice_cart => $cart_content) {
			$options = $cart_content['options'];
			if(isset($options['id_diseno'])) {
				if($options['id_diseno'] != $id_diseno) {
					unset($cart_contents[$indice_cart]);
				}
			} else {
				unset($cart_contents[$indice_cart]);
			}
		}

		$customs = array();
		$item_id = 0;
        $id_color = 0;

		foreach($cart_contents as $item) {

			$options = $item['options'];
			if(isset($options['id_diseno'])) {
				if($options['id_color'] != $id_color) {

					$cliparts = array();
					foreach($item['options']['disenos']['vector'] as $lado=>$vectores) {
						if(count($item['options']['disenos']['vector']->$lado) > 0) {
							foreach($item['options']['disenos']['vector']->$lado as $vector) {
								if(isset($vector->clipart_id)) {
									$cliparts[$lado][] = $vector->clipart_id;
								}
							}
						}
					}

					$customs[] = array(
						'product_id' 		=> $item['id'],
						'color_id' 		    => $item['options']['id_color'],
						'colors'			=> array($item['options']['disenos']['color']),
						'quantity'			=> 0,
						'design'			=> array(
							'vectors' => json_encode($item['options']['disenos']['vector']),
							'images'  => $item['options']['disenos']['images'],
							'colores' => (isset($item['options']['disenos']['colores']) ? $item['options']['disenos']['colores'] : array())
						),
						'design_id'			=> $options['id_diseno'],
						'fonts'				=> '',
						'cliparts'			=> $cliparts,
						'total_colors'		=> (array)$item['options']['calculadora']['colores_totales']
					);

					$item_id = $item['id'];
                    $id_color = $item['options']['id_color'];

				}
			}
		}

		foreach($customs as $indice=>$custom) {
			$id_producto = $custom['product_id'];
            $id_color = $custom['color_id'];
			foreach($this->input->post('estilos') as $estilo) {
				if($id_color == $estilo['id_color']) {
					$customs[$indice]['quantity'] = $estilo['cantidad_multiple'];
					$customs[$indice]['sizes'] = json_decode($estilo['sizes'], TRUE);
				}
			}
		}

		foreach($cart_contents as $indice_carrito => $item) {
			$options = $item['options'];
			if(isset($options['id_diseno'])) {
				if($id_diseno == $options['id_diseno']) {

					$data = array(
						'rowid' => $indice_carrito,
						'qty'   => 0
					);

					$this->cart->update($data);

				}
			}
		}

		$id_cliente = $this->session->login['id_cliente'];
		$es_cliente = (!is_null($id_cliente));
		if($es_cliente) {
			$this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
		}
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
		}

		$items_a_insertar = array();

		foreach($customs as $indice=>$custom) {
			$vectors = json_decode($custom['design']['vectors']);

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

			$customs[$indice]['fonts'] = array();
			$customs[$indice]['design']['vectors'] = $vectors;

			$product_id = $custom['product_id'];

			//buscamos el producto
			$product = $this->catalogo_modelo->obtener_producto_con_id($product_id);
			$nombre = $product->nombre_producto;

			// Tallas
			$tallas   = $custom['sizes'];
			$quantity = $custom['quantity'];
			$skus = array();

			//buscamos los productos por sku
			foreach ($tallas as $talla) {
				$item = $this->catalogo_modelo->obtener_producto_sku_por_id($talla["talla"], $talla["cantidad"]);
				$item->precio_base = $item->precio;

				if($item->quantity > 0) array_push($skus, $item);
			}

			$colors     = $custom['colors'];
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

			$total_colors = $custom['total_colors'];

			for ($i=0; $i < count($skus); $i++) {
				$skus[$i]->precio_final = getCost($total_colors, $esBlanca, $quantity, $skus[$i]);
			}

			if(isset($custom['design_id'])) {
				$mismo_diseno = $custom['design_id'];
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
                        'id_color'      => $sku->id_color,
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
							'color' => $custom['colors'][key($custom['colors'])],
							'colores' => (isset($custom['design']['colores']) ? $custom['design']['colores'] : array()),
							'images' => $custom['design']['images'],
							'vector' => $customs[$indice]['design']['vectors'],
							'fonts' => $custom['fonts']
						)
					)
				);

				array_push($items_a_insertar, $item);
			}
		}

		$this->cart->insert($items_a_insertar);

		$id_cliente = $this->session->login['id_cliente'];
		$es_cliente = (!is_null($id_cliente));
		if($es_cliente) {
			$this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
		}
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
		}

	}

	public function borrar_custom_en_carrito($id_fila, $id_diseno)
	{
		$data = array(
			'rowid' => $id_fila,
			'qty'   => 0
		);

		$this->cart->update($data);

		$id_cliente = $this->session->login['id_cliente'];
		$es_cliente = (!is_null($id_cliente));
		if($es_cliente) {
			$this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
		}
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
		}

		$customs = array();
		$item_id = 0;

		$cart_contents = $this->cart->contents();

		foreach($cart_contents as $indice_cart => $cart_content) {
			$options = $cart_content['options'];
			if(isset($options['id_diseno'])) {
				if($options['id_diseno'] != $id_diseno) {
					unset($cart_contents[$indice_cart]);
				}
			} else {
				unset($cart_contents[$indice_cart]);
			}
		}

		foreach($cart_contents as $item) {
			$options = $item['options'];
			if(isset($options['id_diseno'])) {
				if($item['id'] != $item_id) {

					$cliparts = array();
					foreach($item['options']['disenos']['vector'] as $lado=>$vectores) {
						if(count($item['options']['disenos']['vector']->$lado) > 0) {
							foreach($item['options']['disenos']['vector']->$lado as $vector) {
								if(isset($vector->clipart_id)) {
									$cliparts[$lado][] = $vector->clipart_id;
								}
							}
						}
					}

					$customs[] = array(
						'product_id' 		=> $item['id'],
						'colors'			=> array($item['options']['disenos']['color']),
						'quantity'			=> 0,
						'design'			=> array(
							'vectors' => json_encode($item['options']['disenos']['vector']),
							'images'  => $item['options']['disenos']['images'],
							'colores' => (isset($item['options']['disenos']['colores']) ? $item['options']['disenos']['colores'] : array())
						),
						'design_id'			=> $options['id_diseno'],
						'fonts'				=> '',
						'cliparts'			=> $cliparts,
						'total_colors'		=> (array)$item['options']['calculadora']['colores_totales']
					);

					$item_id = $item['id'];
				}
			}
		}

		foreach($customs as $indice=>$custom) {
			foreach($cart_contents as $item) {
				$options = $item['options'];

				if($options['id_diseno'] == $custom['design_id'] && $item['id'] == $custom['product_id'] && $item['options']['disenos']['color'] == $custom['colors'][0]) {
					$customs[$indice]['quantity'] += $item['qty'];
					$customs[$indice]['sizes'][] = array(
						'talla' => $options['sku'],
						'cantidad' => $item['qty']
					);
				}
			}
		}

		if(sizeof($customs) == 0) {
			redirect('carrito');
		}

		foreach($cart_contents as $indice_carrito => $item) {
			$options = $item['options'];
			if(isset($options['id_diseno'])) {
				if($id_diseno == $options['id_diseno']) {

					$data = array(
						'rowid' => $indice_carrito,
						'qty'   => 0
					);

					$this->cart->update($data);

				}
			}
		}

		$id_cliente = $this->session->login['id_cliente'];
		$es_cliente = (!is_null($id_cliente));
		if($es_cliente) {
			$this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
		}
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
		}

		$items_a_insertar = array();

		foreach($customs as $indice=>$custom) {
			$vectors = json_decode($custom['design']['vectors']);

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

			$customs[$indice]['fonts'] = array();
			$customs[$indice]['design']['vectors'] = $vectors;

			$product_id = $custom['product_id'];

			//buscamos el producto
			$product = $this->catalogo_modelo->obtener_producto_con_id($product_id);
			$nombre = $product->nombre_producto;

			// Tallas
			$tallas   = $custom['sizes'];
			$quantity = $custom['quantity'];
			$skus = array();

			//buscamos los productos por sku
			foreach ($tallas as $talla) {
				$item = $this->catalogo_modelo->obtener_producto_sku_por_id($talla["talla"], $talla["cantidad"]);
				$item->precio_base = $item->precio;

				if($item->quantity > 0) array_push($skus, $item);
			}

			$colors     = $custom['colors'];
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

			$total_colors = $custom['total_colors'];

			for ($i=0; $i < count($skus); $i++) {
				$skus[$i]->precio_final = getCost($total_colors, $esBlanca, $quantity, $skus[$i]);
			}

			if(isset($custom['design_id'])) {
				$mismo_diseno = $custom['design_id'];
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
                        'id_color'      => $sku->id_color,
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
							'color' => $custom['colors'][key($custom['colors'])],
							'colores' => (isset($custom['design']['colores']) ? $custom['design']['colores'] : array()),
							'images' => $custom['design']['images'],
							'vector' => $customs[$indice]['design']['vectors'],
							'fonts' => $custom['fonts']
						)
					)
				);

				array_push($items_a_insertar, $item);
			}
		}

		$this->cart->insert($items_a_insertar);

		$id_cliente = $this->session->login['id_cliente'];
		$es_cliente = (!is_null($id_cliente));
		if($es_cliente) {
			$this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
		}
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
		}

		redirect('carrito');
	}

	public function obtener_vectores_por_fila($id_fila)
	{
		$diseno = $this->input->post('sesion');
		$diseno['vectors'] = json_decode(json_encode($this->cart->contents()[$id_fila]['options']['disenos']['vector']), true);

		if(isset($diseno['vectors']['front'])) {
			foreach($diseno['vectors']['front'] as $indice => $vector) {
				$diseno['vectors']['front'][$indice]['svg'] = html_entity_decode($vector['svg']);
			}
		}

		if(isset($diseno['vectors']['back'])) {
			foreach($diseno['vectors']['back'] as $indice => $vector) {
				$diseno['vectors']['back'][$indice]['svg'] = html_entity_decode($vector['svg']);
			}
		}

		if(isset($diseno['vectors']['left'])) {
			foreach($diseno['vectors']['left'] as $indice => $vector) {
				$diseno['vectors']['left'][$indice]['svg'] = html_entity_decode($vector['svg']);
			}
		}

		if(isset($diseno['vectors']['right'])) {
			foreach($diseno['vectors']['right'] as $indice => $vector) {
				$diseno['vectors']['right'][$indice]['svg'] = html_entity_decode($vector['svg']);
			}
		}

		if(!isset($this->session->diseno_temp)) {
			$this->session->set_userdata('diseno_temp', $diseno);
		} else {
			$this->session->diseno_temp = $diseno;
		}

		$filas = $this->input->post('filas');

		foreach($filas as $id_fila) {
			$data = array(
				'rowid' => $id_fila,
				'qty'   => 0
			);

			$this->cart->update($data);
		}

		$id_cliente = $this->session->login['id_cliente'];
		$es_cliente = (!is_null($id_cliente));
		if($es_cliente) {
			$this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
		}
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
		}

		return true;
	}

	public function cotizar_json()
	{

		$data   = $this->input->post();

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

		$colors     = json_decode(json_decode($data['colors'], TRUE), TRUE);

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

		$total_colors = json_decode(json_decode($data['total_colors'], TRUE), TRUE);

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
			if (isset($next["first"])) {
				$final->precio_next  = getCost($total_colors, $esBlanca, $next["first"], $skus[$i]);
			}

			if (isset($next["second"])) {
				$final->precio_second  = getCost($total_colors, $esBlanca, $next["second"], $skus[$i]);
			}

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

		$resultado = new stdClass();
		$resultado->original = new stdClass();
		$resultado->original->precio = '$'.$this->cart->format_number($original);
		$resultado->original->total = '$'.$this->cart->format_number($original * $quantity);

		if (isset($next["first"])) {
			$resultado->first = new stdClass();
			$resultado->first->cantidad = $next["first"];
			$resultado->first->precio = '$'.$this->cart->format_number($this->cart->format_number($first));
			$resultado->first->total = '$'.$this->cart->format_number($this->cart->format_number($first) * $next["first"]);
		}

		if (isset($next["second"])) {
			$resultado->second = new stdClass();
			$resultado->second->cantidad = $next["second"];
			$resultado->second->precio = '$'.$this->cart->format_number($this->cart->format_number($second));
			$resultado->second->total = '$'.$this->cart->format_number($this->cart->format_number($second) * $next["second"]);
		}

		echo json_encode($resultado);

	}


	public function reenviar_confirmacion_paypal($id_pedido)
	{
		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);

		$pedido = $this->db->get_where('Pedidos', array('id_pedido' => $id_pedido))->row();

		$cliente = $this->db->get_where('Clientes', array('id_cliente' => $pedido->id_cliente))->row();

		$datos_correo                = new stdClass();
		$datos_correo->numero_pedido = str_pad($id_pedido, 8, '0', STR_PAD_LEFT);
		$datos_correo->total_pedido  = $pedido->total;
		$datos_correo->subtotal_pedido = $pedido->subtotal;
		$datos_correo->costo_envio = $pedido->costo_envio;
		$datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
		$datos_correo->nombre_solo   = $cliente->nombres;
		$datos_correo->apellido      = $cliente->apellidos;
		$datos_correo->email         = $cliente->email;
		$datos_correo->id_pedido	 = $id_pedido;

		//$this->load->view('plantillas_correos/confirmacion_paypal_custom', $datos_correo);

		$email = new SendGrid\Email();
		$email->addTo($datos_correo->email, $datos_correo->nombre)
			  ->setFrom('administracion@printome.mx')
			  ->setReplyTo('administracion@printome.mx')
			  ->setFromName('printome.mx')
			  ->setSubject('Confirmación de pago con PayPal | printome.mx')
			  ->setHtml($this->load->view('plantillas_correos/confirmacion_paypal_custom', $datos_correo, TRUE))
		;
		$sendgrid->send($email);
	}



	public function error() {
		// Config
		$datos_header['seccion_activa'] = 'carrito';
		$datos_header['meta']['title'] = 'Ocurrió algún error con tu pago | printome.mx';
		$datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
		$datos_header['meta']['imagen'] = '';

		if($this->session->has_userdata('login')) {
			ac_agregar_etiqueta($this->session->login['email'], 'error-pago');
		}

		if($this->session->has_userdata('correo_temporal')) {
			ac_agregar_etiqueta($this->session->correo_temporal, 'error-pago');
		}

		$this->load->view('header', $datos_header);
		$this->load->view('carrito/error', array());
		//$this->load->view('carrito/similares', array('ids_producto' => array(), 'titulo' => 'Productos que te pueden interesar'));
		$this->load->view('footer');
	}

	public function prueba() {
		$matriz = array();

		$sql = "SELECT DISTINCT(tipo_tinta) as tipo FROM Cotizador ORDER BY tipo_tinta ASC";
		$tipos_res = $this->db->query($sql);
		$tipos = $tipos_res->result();

		foreach($tipos as $tipo) {
			$matriz[$tipo->tipo] = array();
		}

		foreach($matriz as $tipo_tinta=>$arreglo) {

			$datos_res = $this->db->get_where('Cotizador', array('tipo_tinta' => $tipo_tinta, 'tipo_estampado' => 1));
			$datos = $datos_res->result();

			foreach($datos as $dato) {
				$matriz[$tipo_tinta][$dato->cantidad_min] = array(
					'blanca' => $dato->costo_blanca,
					'color' => $dato->costo_color,
					'ladoA' => $dato->multiplicador_1,
					'ladoB' => $dato->multiplicador_2
				);
			}

			$datos_lado_res = $this->db->get_where('Cotizador', array('tipo_tinta' => $tipo_tinta, 'tipo_estampado' => 2));
			$datos_lado = $datos_lado_res->result();

			foreach($datos_lado as $dato) {
				$matriz[$tipo_tinta][$dato->cantidad_min]['manga_blanca'] = $dato->costo_blanca;
				$matriz[$tipo_tinta][$dato->cantidad_min]['manga_color'] = $dato->costo_color;
				$matriz[$tipo_tinta][$dato->cantidad_min]['mangaA'] = $dato->multiplicador_1;
				$matriz[$tipo_tinta][$dato->cantidad_min]['mangaB'] = $dato->multiplicador_2;

			}
		}

		print_r($matriz);
	}

	public function prueba_bien() {
		/* $datos_correo = new stdClass();
		$datos_correo->nombre = 'Mirley Parra';
		$datos_correo->email = 'mirley@printome.mx';
		$datos_correo->contra = uniqid(); */

		$datos_correo                = new stdClass();
		$datos_correo->numero_pedido = str_pad(123, 8, '0', STR_PAD_LEFT);
		$datos_correo->total_pedido  = $this->cart->obtener_total();
		$datos_correo->nombre        = 'Mirley Parra';
		$datos_correo->nombre_solo   = 'Mirley';
		$datos_correo->apellido      = 'Parra';
		$datos_correo->email         = 'mirley@printome.mx';

		// Se inicializa Sendgrid
		$this->load->view('plantillas_correos/confirmacion_paypal', $datos_correo);
	}

	public function get_paypal_info()
	{
		// Generacion de link de PayPal
		$apiContext = new \PayPal\Rest\ApiContext(
			new \PayPal\Auth\OAuthTokenCredential(
				$_ENV['PAYPAL_CLIENT'],
				$_ENV['PAYPAL_SECRET']
			)
		);

		$apiContext->setConfig(
			array(
				'mode' => 'sandbox'
			)
		);

		$payment_id = 'PAY-16W0207798453110TK5VRIRY';

		$pago = \PayPal\Api\Payment::get($payment_id, $apiContext);

		echo '<pre>';
		print_r($pago);
		echo '</pre>';

		//echo $pago->getId();
		//echo $pago->getState();
		//echo $pago->getPayer()->getPayerInfo()->getEmail();
		//echo $pago->getPayer()->getPayerInfo()->getPayerId();

		$id_cliente = $this->session->login['id_cliente'];
		$is_client = !is_null($id_cliente);

		$direccion_res = $this->db->get_where('DireccionesPorCliente', array('identificador_direccion' => $pago->getPayer()->getPayerInfo()->getShippingAddress()->getRecipientName(), 'linea1' => $pago->getPayer()->getPayerInfo()->getShippingAddress()->getLine1(), 'id_cliente' => $id_cliente));
		$direccion = $direccion_res->result();

		$id_direccion = $direccion[0]->id_direccion;

		$pedido = array(
			"fecha_creacion"  => date("Y-m-d H:i:s", strtotime($pago->getCreateTime())),
			"fecha_pago"      => date("Y-m-d H:i:s", strtotime($pago->getUpdateTime())),
			"estatus_pago"    => 'paid',
			"id_pago"         => $pago->getId(),
			"metodo_pago"     => 'paypal',
			"referencia_pago" => $pago->getId(),
			"subtotal"        => $this->cart->obtener_subtotal(),
			"iva"             => $this->cart->obtener_iva(),
			"total"           => $this->cart->obtener_total(),
			"costo_envio"     => $this->cart->obtener_costo_envio(),
			"id_cliente"      => $id_cliente,
			"id_direccion"    => $id_direccion,
			//"id_cupon"        => $this->cart->get_discount_id(),
			"paypal_payer_email" => $pago->getPayer()->getPayerInfo()->getEmail(),
			"paypal_payer_id" => $pago->getPayer()->getPayerInfo()->getPayerId()
		);

		//$id_sale = $pago->getTransactions()[0]->getRelatedResources()[0]->getSale()->getId();
		//$sale = \PayPal\Api\Sale::get($id_sale, $apiContext);


		echo '<pre>';
		//print_r($sale);

		print_r($pedido);
		print_r($pago);
		echo '</pre>';
	}


	public function nay()
	{
		echo '<pre>';

		print_r($this->cart->contents());

		//$this->cart_modelo->mezclar_carrito($this->session->login['id_cliente']);

		echo '</pre>';
	}


}
