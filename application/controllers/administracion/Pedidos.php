<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends MY_Admin {

	function __construct(){
		parent::__construct();
		$this->load->library('excel');		
	}


	public function index() {
		$datos['seccion_activa'] = 'pedidos';
		$contenido['accion'] = 'despliegue';
		//$contenido['pedidos'] = $this->pedidos_modelo->obtener_pedidos();
		$footer_datos['scripts'] = 'administracion/pedidos/scripts';


		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/pedidos/pedidos', $contenido);

		$this->load->view('administracion/footer', $footer_datos);
	}

	public function pedido_especifico($id_pedido) {
		$datos['seccion_activa'] = 'pedidos';

		$contenido['accion'] = 'despliegue';
		$contenido['pedidos'] = 'despliegue';
		$contenido['id_pedido'] = $id_pedido;
		$contenido['pedido'] = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$contenido['num_pedidos'] = $this->pedidos_modelo->obtener_cantidad_pedidos($contenido['pedido']->id_cliente)->cantidad_pedidos;
 		$contenido['cambios_pedido'] = $this->pedidos_modelo->obtener_cambios_pedido($id_pedido);
        $contenido['info_pedido'] = clasificar_productos_pedido($contenido['pedido']);
		$footer_datos['scripts'] = 'administracion/pedidos/scripts_pedido_especifico';

		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/pedidos/pedido_especifico', $contenido);

		$this->load->view('administracion/footer', $footer_datos);
	}

	public function imagen()
	{
		$contenido_imagen = new stdClass();
		$contenido_imagen->svg = addslashes($this->input->post('code'));
		$contenido_imagen->font_family = $this->input->post('font');
		$contenido_imagen->color_fondo = $this->input->post('color_fondo');
		$contenido_imagen->lado = $this->input->post('lado');

		$this->load->view('administracion/pedidos/generacion_imagen', $contenido_imagen);
	}

	public function cancelar_pedido($id_pedido)
	{
		$pedido = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$productos = $this->pedidos_modelo->obtener_productos_por_pedido($id_pedido);

		$actualizacion = new stdClass();
		$actualizacion->cronjob = 1;
		$actualizacion->estatus_pedido = 'Cancelado';
        $actualizacion->id_paso_pedido = 7;
		$actualizacion->observaciones = $this->input->post('motivo');

        $historial = new stdClass();
        $historial->id_pedido = $id_pedido;
        $historial->id_paso_pedido = 7;
        $historial->fecha_inicio = date("Y-m-d H:i:s");
        $historial->fecha_final = date("Y-m-d H:i:s");

        $this->db->insert('HistorialPedidos', $historial);

		$this->db->where('id_pedido', $pedido->id_pedido);
		$this->db->update('Pedidos', $actualizacion);

		foreach ($productos as $producto) {
			$cantidad = $producto->cantidad_producto;
			$sku = $producto->id_sku;

			if($producto->id_enhance != 0) {
				if($producto->estatus_pago == 'paid') {
					$query = $this->db->query('UPDATE Enhance SET sold=(sold-'.$cantidad.') WHERE id_enhance='.$producto->id_enhance);
				}
                $enhance = $this->enhance_modelo->obtener_enhance($producto->id_enhance);
                if($enhance->type == 'fijo') {
                    $query = $this->db->query("UPDATE CatalogoSkuPorProducto SET cantidad_inicial=(cantidad_inicial+".$cantidad.") WHERE id_sku='".$sku."'");
                }
			} else {
				$query = $this->db->query("UPDATE `CatalogoSkuPorProducto` SET `cantidad_inicial` = (`cantidad_inicial`+".$cantidad.") WHERE `id_sku` = '".$sku."'");
			}
		}

		$cliente_res = $this->db->get_where('Clientes', array('id_cliente' => $pedido->id_cliente));
		$cliente = $cliente_res->result();

		$datos_correo = new stdClass();
		$datos_correo->nombre = $cliente[0]->nombres.' '.$cliente[0]->apellidos;
		$datos_correo->email = $cliente[0]->email;
		$datos_correo->numero_pedido = str_pad($pedido->id_pedido, 8, '0', STR_PAD_LEFT);
		$datos_correo->motivo = $this->input->post('motivo');
		$datos_correo->total_pedido = $pedido->total;

        if($this->input->post('avisar')) {
            // Se inicializa Sendgrid
    		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
    		$email = new SendGrid\Email();
    		$email->addTo($datos_correo->email, $datos_correo->nombre)
    			  ->setFrom('administracion@printome.mx')
    			  ->setReplyTo('administracion@printome.mx')
    			  ->setFromName('printome.mx')
    			  ->setSubject('Lo sentimos, tu pedido ha sido cancelado | printome.mx')
    			  ->setHtml($this->load->view('plantillas_correos/administracion_pedido_cancelado', $datos_correo, TRUE))
    		;
    		$sendgrid->send($email);
        }

		redirect('administracion/pedidos/'.$id_pedido);
	}

    public function pedido_fraudulento($id_pedido)
    {
        $pedido = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$productos = $this->pedidos_modelo->obtener_productos_por_pedido($id_pedido);

		$actualizacion = new stdClass();
		$actualizacion->cronjob = 1;
		$actualizacion->estatus_pedido = 'Cancelado por fraude';
		$actualizacion->observaciones = $this->input->post('motivo');
        $actualizacion->id_paso_pedido = 8;

        $historial = new stdClass();
        $historial->id_pedido = $id_pedido;
        $historial->id_paso_pedido = 8;
        $historial->fecha_inicio = date("Y-m-d H:i:s");
        $historial->fecha_final = date("Y-m-d H:i:s");

        $this->db->insert('HistorialPedidos', $historial);

		$this->db->where('id_pedido', $pedido->id_pedido);
		$this->db->update('Pedidos', $actualizacion);

        $usuario_inactivo = new stdClass();
        $usuario_inactivo->token_activacion_correo = md5(sha1(date()));

        $this->db->where('id_cliente', $pedido->id_cliente);
        $this->db->update('Clientes', $usuario_inactivo);

        redirect('administracion/pedidos/'.$id_pedido);
    }

    public function cambiar_estatus_pedido($id_pedido)
    {
        $pedido_update = new stdClass();
        $pedido_update->id_paso_pedido = $this->input->post('cambiar_estatus');

        if($this->input->post('codigo_rastreo')) {
            $pedido_update->codigo_rastreo = $this->input->post('codigo_rastreo');
        }

        $this->db->where('id_pedido', $id_pedido);
        $this->db->update('Pedidos', $pedido_update);

        $this->db->select('*')
                 ->from('HistorialPedidos')
                 ->where('id_pedido', $id_pedido)
                 ->order_by('id_historial', 'DESC')
                 ->limit(1);
        $ultimo_historial = $this->db->get()->row();

        if(isset($ultimo_historial->id_historial)) {
            $this->db->query('UPDATE HistorialPedidos SET fecha_final=\''.date("Y-m-d H:i:s").'\' WHERE id_historial='.$ultimo_historial->id_historial);
        }

        $historial_pedido = new stdClass();
        $historial_pedido->id_pedido = $id_pedido;
        $historial_pedido->id_paso_pedido = $pedido_update->id_paso_pedido;
        $historial_pedido->fecha_inicio = date("Y-m-d H:i:s");
        $this->db->insert('HistorialPedidos', $historial_pedido);

        if($this->input->post('avisar_estatus')) {

            $datos_correo = new stdClass();
            $pedido = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
            $cliente_res = $this->db->get_where('Clientes', array('id_cliente' => $pedido->id_cliente));
    		$cliente = $cliente_res->result();

            if($pedido->id_paso_pedido == 3) {
                $asunto = 'Tu pedido ha pasado a producción';
                $plantilla = 'plantillas_correos/nuevas/cliente_pedido_estatus_pago_confirmado';
            } else if($pedido->id_paso_pedido == 4) {
                $asunto = 'Tu pedido está en proceso de impresión';
                $plantilla = 'plantillas_correos/nuevas/cliente_pedido_estatus_proceso_impresion';
            } else if($pedido->id_paso_pedido == 5) {
                $asunto = 'Tu pedido ha sido enviado';
                $plantilla = 'plantillas_correos/nuevas/admin_pedido_enviado';
        		$datos_correo->numero_pedido_corto = $pedido->id_pedido;
        		$datos_correo->codigo_rastreo = $this->input->post('codigo_rastreo');
            } else if($pedido->id_paso_pedido == 6) {
                $asunto = 'Tu pedido ha sido entregado';
                $plantilla = 'plantillas_correos/nuevas/cliente_pedido_estatus_recibido';
            } else if($pedido->id_paso_pedido == 2) {
                $asunto = 'Tu pedido ha sido confirmado';
                $plantilla = 'plantillas_correos/nuevas/cliente_pedido_estatus_pedido_confirmado';
            }

            $datos_correo->asunto = $asunto;
    		$datos_correo->nombre = $cliente[0]->nombres.' '.$cliente[0]->apellidos;
    		$datos_correo->email = $cliente[0]->email;
    		$datos_correo->numero_pedido = str_pad($pedido->id_pedido, 8, '0', STR_PAD_LEFT);
    		$datos_correo->total_pedido = $pedido->total;
    		$datos_correo->recibir = fecha_recepcion(date("N"));

            // Se inicializa Sendgrid
    		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
    		$email = new SendGrid\Email();
    		$email->addTo($datos_correo->email, $datos_correo->nombre)
    			  ->setFrom('administracion@printome.mx')
    			  ->setReplyTo('administracion@printome.mx')
    			  ->setFromName('printome.mx')
    			  ->setSubject($asunto.' | printome.mx')
    			  ->setHtml($this->load->view($plantilla, $datos_correo, TRUE))
    		;
    		$sendgrid->send($email);
        }

        redirect('administracion/pedidos/'.$id_pedido);
    }

    public function atraso($id_pedido, $atraso = 0)
    {
        $pedido_update = new stdClass();
        $pedido_update->atraso = $atraso;

        $this->db->where('id_pedido', $id_pedido);
        $this->db->update('Pedidos', $pedido_update);
    }

	public function pdf_pedido($id_pedido){
		$this->load->helper(array('dompdf', 'file'));
		$contenido['accion'] = 'despliegue';
		$contenido['pedidos'] = 'despliegue';
		$contenido['id_pedido'] = $id_pedido;
		$contenido['pedido'] = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		//$contenido['productos'] = $this->pedidos_modelo->obtener_productos_por_pedido($id_pedido);
        $contenido['cantidad_pedidos'] =  $this->pedidos_modelo->obtener_cantidad_pedidos($contenido['pedido']->id_cliente)->cantidad_pedidos;

		foreach($contenido['pedido']->productos as $indice => $producto) {
			if(!$producto->id_enhance) {
				$contenido['pedido']->productos[$indice]->diseno = json_decode($producto->diseno);
				$contenido['pedido']->productos[$indice]->imagen_principal = $contenido['pedido']->productos[$indice]->diseno->images->front;
				$contenido['pedido']->productos[$indice]->nombre_principal = $producto->nombre_producto.' personalizada';
			} else {
				$info_enhanced = $this->catalogo_modelo->obtener_enhanced_con_id($producto->id_enhance);
				$contenido['pedido']->productos[$indice]->imagen_principal = $info_enhanced->front_image;
				if($info_enhanced->type == 'fijo') {
					$contenido['pedido']->productos[$indice]->nombre_principal = 'Venta inmediata (Folio: '.($info_enhanced->id_parent_enhance == 0 ? $info_enhanced->id_enhance : $info_enhanced->id_parent_enhance).') - '.$info_enhanced->name;
				} else if($info_enhanced->type == 'limitado') {
					$contenido['pedido']->productos[$indice]->nombre_principal = 'Plazo definido (Folio: '.($info_enhanced->id_parent_enhance == 0 ? $info_enhanced->id_enhance : $info_enhanced->id_parent_enhance).') - '.$info_enhanced->name;
					$contenido['pedido']->productos[$indice]->especial = true;
					$contenido['pedido']->productos[$indice]->end_date = $info_enhanced->end_date;
				}
			}
		}

		$html = $this->load->view('administracion/pedidos/pdf_especifico', $contenido, true);

		pdf_create($html, 'pedido_printome_'.str_pad($id_pedido, 8, '0', STR_PAD_LEFT));
	}


	public function pdf_pedido_archivo($id_pedido){
		$this->load->helper(array('dompdf', 'file'));
		$contenido['accion'] = 'despliegue';
		$contenido['pedidos'] = 'despliegue';
		$contenido['id_pedido'] = $id_pedido;
		$contenido['pedido'] = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
        $contenido['cantidad_pedidos'] =  $this->pedidos_modelo->obtener_cantidad_pedidos($contenido['pedido']->id_cliente)->cantidad_pedidos;

		foreach($contenido['productos'] as $indice => $producto) {
			if(!$producto->id_enhance) {
				$contenido['pedido']->productos[$indice]->diseno = json_decode($producto->diseno);
				$contenido['pedido']->productos[$indice]->imagen_principal = $contenido['pedido']->productos[$indice]->diseno->images->front;
				$contenido['pedido']->productos[$indice]->nombre_principal = $producto->nombre_producto.' personalizada';
			} else {
				$info_enhanced = $this->catalogo_modelo->obtener_enhanced_con_id($producto->id_enhance);
				$contenido['pedido']->productos[$indice]->imagen_principal = $info_enhanced->front_image;
				if($info_enhanced->type == 'fijo') {
					$contenido['pedido']->productos[$indice]->nombre_principal = 'Venta inmediata (Folio: '.($info_enhanced->id_parent_enhance == 0 ? $info_enhanced->id_enhance : $info_enhanced->id_parent_enhance).') - '.$info_enhanced->name;
				} else if($info_enhanced->type == 'limitado') {
					$contenido['pedido']->productos[$indice]->nombre_principal = 'Plazo definido (Folio: '.($info_enhanced->id_parent_enhance == 0 ? $info_enhanced->id_enhance : $info_enhanced->id_parent_enhance).') - '.$info_enhanced->name;
					$contenido['pedido']->productos[$indice]->especial = true;
					$contenido['pedido']->productos[$indice]->end_date = $info_enhanced->end_date;
				}
			}
		}
		// page info here, db calls, etc.
		$html = $this->load->view('administracion/pedidos/pdf_especifico', $contenido, true);
		//echo $html;

		$nombre = pdf_create_file($html, 'pedido_printome_'.str_pad($id_pedido, 8, '0', STR_PAD_LEFT));

		return $nombre;
	}

	public function pdf_sku($id_ppp){
		// id_ppp = id_producto_por_pedido
    $this->load->helper(array('dompdf', 'file'));
    $contenido['accion'] = 'despliegue';
		$contenido['pedidos'] = 'despliegue';
		$contenido['id_pedido'] = $id_pedido;
		$contenido['producto'] = $this->pedidos_modelo->obtener_diseno_de_ppp($id_ppp);
    // page info here, db calls, etc.
    $html = $this->load->view('administracion/pedidos/pdf_diseno', $contenido, true);
    //echo $html;

    pdf_create($html, 'pedido_avanda_'.str_pad($id_pedido, 8, '0', STR_PAD_LEFT));

	}


	public function pdf_pedido_produccion($id_pedido){
		$this->load->helper(array('dompdf', 'file'));
		$contenido['accion'] = 'despliegue';
		$contenido['pedidos'] = 'despliegue';
		$contenido['id_pedido'] = $id_pedido;
		$contenido['pedido'] = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
        $contenido['info_pedido'] = clasificar_productos_pedido($contenido['pedido']);
		// page info here, db calls, etc.
		$html = $this->load->view('administracion/pedidos/pdf_especifico_produccion', $contenido, true);
		//echo $html;

		pdf_create($html, 'pedido_printome_'.str_pad($id_pedido, 8, '0', STR_PAD_LEFT));

	}

	public function asignar_guia($id_pedido) {
		$codigo_rastreo = $this->input->post('codigo_rastreo');

		if($codigo_rastreo == '') {
			redirect('administracion/pedidos/'.$id_pedido);
		}

		$actualizacion = new stdClass();
		$actualizacion->codigo_rastreo = $codigo_rastreo;
        $actualizacion->id_paso_pedido = 5;
		$actualizacion->estatus_pedido = 'Completo';

		$this->db->where('id_pedido', $id_pedido);
		$this->db->update('Pedidos', $actualizacion);

        $this->db->select('*')
                 ->from('HistorialPedidos')
                 ->where('id_pedido', $id_pedido)
                 ->order_by('id_historial', 'DESC')
                 ->limit(1);
        $ultimo_historial = $this->db->get()->row();

        if(isset($ultimo_historial->id_historial)) {
            $this->db->query('UPDATE HistorialPedidos SET fecha_final=\''.date("Y-m-d H:i:s").'\' WHERE id_historial='.$ultimo_historial->id_historial);
        }

        $historial_pedido = new stdClass();
        $historial_pedido->id_pedido = $id_pedido;
        $historial_pedido->id_paso_pedido = 5;
        $historial_pedido->fecha_inicio = date("Y-m-d H:i:s");
        $this->db->insert('HistorialPedidos', $historial_pedido);

		$pedido = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);

		$cliente_res = $this->db->get_where('Clientes', array('id_cliente' => $pedido->id_cliente));
		$cliente = $cliente_res->result();

		$datos_correo = new stdClass();
		$datos_correo->nombre = $cliente[0]->nombres.' '.$cliente[0]->apellidos;
		$datos_correo->email = $cliente[0]->email;
		$datos_correo->numero_pedido = str_pad($pedido->id_pedido, 8, '0', STR_PAD_LEFT);
		$datos_correo->numero_pedido_corto = $pedido->id_pedido;
		$datos_correo->codigo_rastreo = $pedido->codigo_rastreo;
		$datos_correo->total_pedido = $pedido->total;

		// Se inicializa Sendgrid
		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
		$email = new SendGrid\Email();
		$email->addTo($datos_correo->email, $datos_correo->nombre)
			  ->setFrom('administracion@printome.mx')
			  ->setReplyTo('administracion@printome.mx')
			  ->setFromName('printome.mx')
			  ->setSubject('Tu pedido ha sido enviado | printome.mx')
			  ->setHtml($this->load->view('plantillas_correos/nuevas/admin_pedido_enviado', $datos_correo, TRUE))
		;
		$sendgrid->send($email);

		redirect('administracion/pedidos/'.$id_pedido);
	}

	public function abrir_dhl($pedido_id){
		$pedido = $this->pedidos_modelo->obtener_pedido_especifico($pedido_id);
		redirect("http://www.dhl.com.mx/es/express/rastreo.html?AWB=" . $pedido->codigo_rastreo . "&brand=DHL");
	}

	public function abrir_dhl_limitado($codigo_rastreo){
		redirect("http://www.dhl.com.mx/es/express/rastreo.html?AWB=" . $codigo_rastreo . "&brand=DHL");
	}

	public function envio_unico($id_pedido)
	{
		$datos['pedido'] = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$datos['direccion'] = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $datos['pedido']->id_direccion))->row();
		$datos['cliente'] = $this->db->get_where('Clientes', array('id_cliente' => $datos['pedido']->id_cliente))->row();

		$this->load->view('administracion/pedidos/generar_xml_envio_unico', $datos);
	}

//	public function generar_envio($id_pedido)
//	{
//
//		$pedido = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
//		$direccion = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $pedido->id_direccion))->row();
//		$cliente = $this->db->get_where('Clientes', array('id_cliente' => $pedido->id_cliente))->row();
//
//		require(APPPATH.'/../vendor/alfallouji/dhl_api/init.php');
//
//		// DHL settings
//		$dhl = $config['dhl'];
//
//		// Test a ShipmentRequest using DHL XML API
//		$sample = new DHL\Entity\GB\ShipmentRequest();
//
//		// Assuming there is a config array variable with id and pass to DHL XML Service
//		$sample->SiteID = $dhl['id'];
//		$sample->Password = $dhl['pass'];
//
//		// Set values of the request
//		$sample->MessageTime = date('c');
//		$sample->MessageReference = date("YmdHis").str_pad($pedido->id_pedido, 16, '0', STR_PAD_LEFT);
//		$sample->RegionCode = 'AM';
//		$sample->RequestedPickupTime = 'Y';
//		$sample->NewShipper = 'Y';
//		$sample->LanguageCode = 'en';
//		$sample->PiecesEnabled = 'Y';
//
//		$sample->Billing->ShipperAccountNumber = $dhl['shipperAccountNumber'];
//		$sample->Billing->ShippingPaymentType = 'S';
//		$sample->Billing->BillingAccountNumber = $dhl['billingAccountNumber'];
//
//		$sample->Consignee->CompanyName = strtoupper(convert_accented_characters($cliente->nombres.' '.$cliente->apellidos));
//		$sample->Consignee->addAddressLine(strtoupper(convert_accented_characters($direccion->linea1)));
//		$sample->Consignee->addAddressLine(strtoupper(convert_accented_characters($direccion->linea2)));
//		$sample->Consignee->addAddressLine(strtoupper(convert_accented_characters($direccion->ciudad)));
//		$sample->Consignee->City = strtoupper(convert_accented_characters($direccion->ciudad));
//		$sample->Consignee->PostalCode = $direccion->codigo_postal;
//		$sample->Consignee->CountryCode = 'MX';
//		$sample->Consignee->CountryName = 'MEXICO';
//
//		$sample->Consignee->Contact->PersonName = strtoupper(convert_accented_characters($cliente->nombres.' '.$cliente->apellidos));
//		$sample->Consignee->Contact->PhoneNumber = $direccion->telefono;
//		$sample->Consignee->Contact->Email = $cliente->email;
//
//		$piece = new DHL\Datatype\GB\Piece();
//		$piece->PieceID = '1';
//		$piece->PackageType = 'EE';
//		$piece->Weight = '5.0';
//
//		$sample->ShipmentDetails->addPiece($piece);
//
//		$sample->ShipmentDetails->NumberOfPieces = 1;
//		$sample->ShipmentDetails->Weight = '5.0';
//		$sample->ShipmentDetails->WeightUnit = 'K';
//		$sample->ShipmentDetails->GlobalProductCode = 'N';
//		$sample->ShipmentDetails->LocalProductCode = 'N';
//		$sample->ShipmentDetails->Date = date('Y-m-d');
//		$sample->ShipmentDetails->Contents = 'DOCUMENTO NACIONAL';
//		$sample->ShipmentDetails->DoorTo = 'DD';
//		$sample->ShipmentDetails->DimensionUnit = 'C';
//		$sample->ShipmentDetails->InsuredAmount = '0.00';
//		$sample->ShipmentDetails->PackageType = 'EE';
//		$sample->ShipmentDetails->IsDutiable = 'N';
//		$sample->ShipmentDetails->CurrencyCode = 'MXN';
//
//		$sample->Shipper->ShipperID = '980009077';
//		$sample->Shipper->CompanyName = 'PRINTOME';
//		$sample->Shipper->RegisteredAccount = '980009077';
//		$sample->Shipper->addAddressLine('CALLE 133-A NO EXT 815 INT 55');
//		$sample->Shipper->addAddressLine('CRUZAMIENTOS 46-A Y 46-I');
//		$sample->Shipper->addAddressLine('FRACC. VILLA MAGNA DEL SUR');
//		$sample->Shipper->City = 'MERIDA';
//		$sample->Shipper->Division = 'YUCATAN';
//		$sample->Shipper->DivisionCode = 'YUC';
//		$sample->Shipper->PostalCode = '97285';
//		$sample->Shipper->CountryCode = 'MX';
//		$sample->Shipper->CountryName = 'MEXICO';
//		$sample->Shipper->Contact->PersonName = 'GABRIELA CRUZ HERNANDEZ';
//		$sample->Shipper->Contact->PhoneNumber = '9992595995';
//		$sample->Shipper->Contact->Email = 'administracion@printome.mx';
//
//		$sample->EProcShip = 'N';
//		$sample->LabelImageFormat = 'PDF';
//
//		// CAMBIAR A PRODUCCION
//		$client = new DHL\Client\Web('staging');
//
//		// Obtener respuesta
//		$respuesta = $client->call($sample);
//
//		$respuesta_array = simplexml_load_string($respuesta);
//
//		if($respuesta_array->Note->ActionNote == 'Success') {
//			$codigo = json_decode(json_encode($respuesta_array->AirwayBillNumber));
//
//			$pedido = new stdClass();
//			$pedido->codigo_rastreo = $codigo->{0};
//			$pedido->xml_envio_dhl = $respuesta;
//
//			$this->db->where('id_pedido', $id_pedido);
//			$this->db->update('Pedidos', $pedido);
//
//            redirect('administracion/pedidos/'.$id_pedido);
//		} else {
//		    print_r($respuesta_array);
//			redirect('administracion/pedidos/'.$id_pedido.'?error=1');
//		}
//	}

	public function pdf_dhl($id_pedido)
	{
		$pedido = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);

		$response = simplexml_load_string($pedido->xml_envio_dhl);
		//file_put_contents('dhl_etiqueta_'.$id_pedido.'.pdf', base64_decode($response->LabelImage->OutputImage));

		// If you want to display it in the browser
		$data = base64_decode($response->LabelImage->OutputImage);
		if ($data)
		{
			header('Content-Disposition: inline; filename="dhl_etiqueta_'.$id_pedido.'.pdf"');
			header('Content-Type: application/pdf');
			header('Content-Length: ' . strlen($data));
			echo $data;
		}
	}

	public function generar_xml_prueba($id_pedido)
	{
		$pedido = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$direccion = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $pedido->id_direccion))->row();
		$cliente = $this->db->get_where('Clientes', array('id_cliente' => $pedido->id_cliente))->row();

		require(APPPATH.'/../vendor/alfallouji/dhl_api/init.php');

		// DHL settings
		$dhl = $config['dhl'];

		// Test a ShipmentRequest using DHL XML API
		$sample = new DHL\Entity\GB\ShipmentRequest();

		// Assuming there is a config array variable with id and pass to DHL XML Service
		$sample->SiteID = $dhl['id'];
		$sample->Password = $dhl['pass'];

		// Set values of the request
		$sample->MessageTime = date('c');
		$sample->MessageReference = date("YmdHis").str_pad($pedido->id_pedido, 16, '0', STR_PAD_LEFT);
		$sample->RegionCode = 'AM';
		$sample->RequestedPickupTime = 'Y';
		$sample->NewShipper = 'Y';
		$sample->LanguageCode = 'en';
		$sample->PiecesEnabled = 'Y';

		$sample->Billing->ShipperAccountNumber = $dhl['shipperAccountNumber'];
		$sample->Billing->ShippingPaymentType = 'S';
		$sample->Billing->BillingAccountNumber = $dhl['billingAccountNumber'];

		$sample->Consignee->CompanyName = strtoupper(convert_accented_characters($cliente->nombres.' '.$cliente->apellidos));
		$sample->Consignee->addAddressLine(strtoupper(convert_accented_characters($direccion->linea1)));
		$sample->Consignee->addAddressLine(strtoupper(convert_accented_characters($direccion->linea2)));
		$sample->Consignee->addAddressLine(strtoupper(convert_accented_characters($direccion->ciudad)));
		$sample->Consignee->City = strtoupper(convert_accented_characters($direccion->ciudad));
		$sample->Consignee->PostalCode = $direccion->codigo_postal;
		$sample->Consignee->CountryCode = 'MX';
		$sample->Consignee->CountryName = 'MEXICO';

		$sample->Consignee->Contact->PersonName = strtoupper(convert_accented_characters($cliente->nombres.' '.$cliente->apellidos));
		$sample->Consignee->Contact->PhoneNumber = $direccion->telefono;
		$sample->Consignee->Contact->Email = $cliente->email;

		$piece = new DHL\Datatype\GB\Piece();
		$piece->PieceID = '1';
		$piece->PackageType = 'EE';
		$piece->Weight = '5.0';

		$sample->ShipmentDetails->addPiece($piece);

		$sample->ShipmentDetails->NumberOfPieces = 1;
		$sample->ShipmentDetails->Weight = '5.0';
		$sample->ShipmentDetails->WeightUnit = 'K';
		$sample->ShipmentDetails->GlobalProductCode = 'N';
		$sample->ShipmentDetails->LocalProductCode = 'N';
		$sample->ShipmentDetails->Date = date('Y-m-d');
		$sample->ShipmentDetails->Contents = 'DOCUMENTO NACIONAL';
		$sample->ShipmentDetails->DoorTo = 'DD';
		$sample->ShipmentDetails->DimensionUnit = 'C';
		$sample->ShipmentDetails->InsuredAmount = '0.00';
		$sample->ShipmentDetails->PackageType = 'EE';
		$sample->ShipmentDetails->IsDutiable = 'N';
		$sample->ShipmentDetails->CurrencyCode = 'MXN';

		$sample->Shipper->ShipperID = '980009077';
		$sample->Shipper->CompanyName = 'PRINTOME';
		$sample->Shipper->RegisteredAccount = '980009077';
		$sample->Shipper->addAddressLine('CALLE 133-A NO EXT 815 INT 55');
		$sample->Shipper->addAddressLine('CRUZAMIENTOS 46-A Y 46-I');
		$sample->Shipper->addAddressLine('FRACC. VILLA MAGNA DEL SUR');
		$sample->Shipper->City = 'MERIDA';
		$sample->Shipper->Division = 'YUCATAN';
		$sample->Shipper->DivisionCode = 'YUC';
		$sample->Shipper->PostalCode = '97285';
		$sample->Shipper->CountryCode = 'MX';
		$sample->Shipper->CountryName = 'MEXICO';
		$sample->Shipper->Contact->PersonName = 'GABRIELA CRUZ HERNANDEZ';
		$sample->Shipper->Contact->PhoneNumber = '9992595995';
		$sample->Shipper->Contact->Email = 'administracion@printome.mx';

		$sample->EProcShip = 'N';
		$sample->LabelImageFormat = 'PDF';

		header ("Content-Type:text/xml");
		echo $sample->toXML();
	}

	// Generacion imagen de texto
	public function svgme() {

		$code = stripslashes(html_entity_decode($this->input->post('code')));
		$code = '<?xml version="1.0" encoding="iso-8859-1"?>'.$code;
		$temp_dir = 'media/assets/temporaryvectors';
		if(!is_file($temp_dir) && !file_exists($temp_dir)) {
			mkdir($temp_dir);
		}

		$filename = time().rand(111,888).'.svg';
		file_put_contents($temp_dir.'/'.$filename, $code);

		$font = $this->input->post('font');
		$color_fondo = $this->input->post('color_fondo');

		try {
			ob_start();
			if($font != 'Arial') {
				$url_font = 'https://fonts.googleapis.com/css?family='.str_replace(' ','+',$font);
				$font_code = file_get_contents($url_font);

				$start_string = 'url(';
				$start_string_length = strlen($start_string);
				$start = strpos($font_code, $start_string) + $start_string_length;
				$end = strpos($font_code, ')', $start);

				$ttf_url = substr($font_code, $start, $end - $start);
				$fonts_dir = 'media/assets/fonts';
				if(!is_file($fonts_dir) && !file_exists($fonts_dir)) {
					mkdir($fonts_dir);
				}

				if(!file_exists($fonts_dir.'/'.$font.'.ttf') && !is_dir($fonts_dir.'/'.$font.'.ttf')) {
					file_put_contents($fonts_dir.'/'.$font.'.ttf', file_get_contents($ttf_url));
				}
			}

			$img1 = new \Imagick();
			$img1->setResolution(800, 800);
			$img1->setBackgroundColor($color_fondo);
			$img1->readImage($temp_dir.'/'.$filename);
			if($font != 'Arial') {
				$img1->setFont('/var/www/printome.mx/public/media/assets/fonts/'.$font.'.ttf');
			}
			$img1->setImageFormat('png32');




			$thumbnail = $img1->getImageBlob();
			echo $thumbnail;
			$contents =  ob_get_contents();
			ob_end_clean();

			echo '<img src="data:image/png;base64,'.base64_encode($contents).'" />';

		} catch(ImagickException $e) {
			$e->getMessage();
		}

	}
	public function desplegar_pedidos(){
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');
        $orden = $this->input->post('order');
        $pedidos = $this->pedidos_modelo->obtener_pedidos_datatable($limit, $offset, $orden, $search);
        $info = new stdClass();
        $info->draw = $this->input->post('draw');
        $info->recordsTotal = $this->pedidos_modelo->contar_pedidos_datatable(null);
        $info->recordsFiltered = $this->pedidos_modelo->contar_pedidos_datatable($search);

        $info->data = array();

        foreach($pedidos as $pedido){
             $inner_info = new stdClass();
             //seccion $inner_info->num_pedido;
             $inner_info->num_pedido .= $pedido->id_pedido;
             //seccion $inner_info->estatus;
             if(sizeof($pedido->info_pedido['customs']) == 0 && sizeof($pedido->info_pedido['ventas_inmediatas']) == 0 && sizeof($pedido->info_pedido['enhances']) > 0) {
                 $inner_info->estatus .= '<i class="fa fa-info-circle" style="color:darkblue;" title="Productos de plazo definido"> Productos de plazo definido</i>';
             } else {
                 $inner_info->estatus .= '<span style="white-space:nowrap;">'.$pedido->fa_icon.' '.$pedido->nombre_paso.'</span>';
             }
             //seccion $inner_info->clientes;
             $inner_info->clientes .= $pedido->nombres.' '.$pedido->apellidos;
             //seccion $inner_info->fecha;
             $inner_info->fecha .= date("Y/m/d H:i", strtotime($pedido->fecha_creacion));
             //seccion $inner_info->items_totales;
             $inner_info->items_totales .= "<div class='text-center'>".$pedido->numero_productos."</div>";
             //seccion $inner_info->total_pago;
             $inner_info->total_pago .= "<div class='text-right' style='white-space:nowrap;'>$".$this->cart->format_number($pedido->total)."</div>";
             //seccion $inner_info->metodo_pago;
             if($pedido->metodo_pago == 'paypal') {
                 $inner_info->metodo_pago .= '<span class="hide">PayPal</span><img class="payimg" src="'.site_url('assets/images/paypal.svg').'" alt="PayPal" />';
             } else if($pedido->metodo_pago == 'card_payment') {
                 $inner_info->metodo_pago .= '<span class="hide">Tarjeta</span><img class="payimg" src="'.site_url('assets/images/visa_mc_amex.svg').'" alt="Tarjeta" />';
             } else if($pedido->metodo_pago == 'cash_payment') {
                 $inner_info->metodo_pago .= '<span class="hide">OXXO</span><img class="payimg" src="'.site_url('assets/images/oxxo.svg').'" alt="OXXO" />';
             } else if($pedido->metodo_pago == 'spei') {
                 $inner_info->metodo_pago .= '<span class="hide">SPEI</span><img class="payimg" src="'.site_url('assets/nimages/spei.png').'" alt="SPEI" />';
             } else if($pedido->metodo_pago == 'saldo') {
                 $inner_info->metodo_pago .= '<span class="hide">Saldo</span><img class="payimg" src="'.site_url('assets/images/icon.png').'" alt="Saldo a favor" />';
             } else if($pedido->metodo_pago == 'PPP'){
                 $inner_info->metodo_pago .= '<span class="hide">PayPalPlus</span><img class="payimg" src="'.site_url('assets/images/paypalplus.svg').'" alt="PayPal Plus" />';
             }else if($pedido->metodo_pago == 'stripe'){
                 $inner_info->metodo_pago .= '<span class="hide">Stripe</span><img class="payimg" src="'.site_url('assets/images/stripe.png').'" alt="Stripe" />';
             }else if($pedido->metodo_pago == 'shopify_payment'){
                 $inner_info->metodo_pago .= '<span class="hide">Shopify_payment</span><img class="payimg" src="'.site_url('assets/images/shopify.png').'" alt="Stripe" />';
             }
             //seccion $inner_info->pago;
             $inner_info->pago .= "<div class='text-center'>";
             if($pedido->estatus_pedido != 'Cancelado' && $pedido->estatus_pedido != 'Cancelado por fraude' && $pedido->id_paso_pedido < 7) {
                 $inner_info->pago .= ($pedido->estatus_pago == 'paid' ? '<i class="fa fa-check"></i> <span style="display:block;">Completo</span>' : '<i class="fa fa-cog fa-spin fa-fw" style="color:#ffa05a"></i> <span style="display:block;">Pendiente</span>');
             } else {
                 $inner_info->pago .='<i class="fa fa-times"></i> <span style="display:block;">Cancelado</span>';
             }
             $inner_info->pago .= "</div>";
             //seccion $inner_info->envio;
             $inner_info->envio .= "<div class='text-center'>";
             if(sizeof($pedido->info_pedido['customs']) == 0 && sizeof($pedido->info_pedido['ventas_inmediatas']) == 0 && sizeof($pedido->info_pedido['enhances']) > 0) {
                 $inner_info->envio .= '<i class="fa fa-info-circle" style="color:darkblue;" title="Productos de plazo definido"></i> P/D';
             } else {
                 if($pedido->estatus_pedido != 'Cancelado' && $pedido->estatus_pedido != 'Cancelado por fraude' && $pedido->id_paso_pedido < 7) {
                     $inner_info->envio .= ($pedido->codigo_rastreo ? '<i class="fa fa-truck"></i> <span style="display:block;">Enviado</span>' : $pedido->fa_icon.' <span style="display:block;">Entrega Física</span>');
                 } else {
                     $inner_info->envio .= '<i class="fa fa-times"></i> <span style="display:block;">Cancelado</span>';
                 }
             }
             $inner_info->envio .= "</div>";
             //seccion $inner_info->factura;
             $inner_info->factura .= "<div class='text-center'>".($pedido->id_direccion_fiscal ? '<i class="fa fa-check"></i>' : '')."</div>";
             //seccion $inner_info->boton;
             $inner_info->boton .= "<div class='text-right'><a href='".site_url('administracion/pedidos/'.$pedido->id_pedido)."' class='action button'><i class='fa fa-search'></i></a></td>";
             array_push($info->data, $inner_info);
		}
        echo json_encode($info);
    }

    public function cambio_direccion_envio($id_pedido, $id_cliente, $dir_anterior){
	    $nueva = $this->input->post('switch_nueva');
        $editar = $this->input->post('switch_editar');
        $cambio_pedido = new stdClass();
        $cambio_pedido->valor_anterior = $dir_anterior;
        $cambio_pedido->fecha_cambio = date('Y-m-d H:i:s');
        $cambio_pedido->id_pedido = $id_pedido;
        $cambio_pedido->id_tipo_cambio = 1;
	    if($nueva){
	        $nueva_dir = new stdClass();
	        $nueva_dir->identificador_direccion = $this->input->post('identificador_dir');
            $nueva_dir->linea1 = $this->input->post('linea1_dir');
            $nueva_dir->codigo_postal = $this->input->post('cp_dir');
            $nueva_dir->linea2 = $this->input->post('linea2_dir');
            $nueva_dir->ciudad = $this->input->post('ciudad_dir');
            $nueva_dir->estado = $this->input->post('estado_dir');
            $nueva_dir->pais = 'México';
            $nueva_dir->principal = 0;
            $nueva_dir->telefono = $this->input->post('tel_dir');
            $nueva_dir->fecha_creacion = date('Y-m-d H:i:s');
            $nueva_dir->estatus = 1;
            $nueva_dir->id_cliente = $id_cliente;

            $this->db->insert('DireccionesPorCliente', $nueva_dir);
            $nueva_dire = new stdClass();
            $nueva_dire->id_direccion = $this->db->insert_id();
            $this->db->where('id_pedido', $id_pedido)
                ->update('Pedidos', $nueva_dire);

            $cambio_pedido->valor_actual = $nueva->id_direccion;
        }elseif ($editar) {
            $identificador_direccion = $this->input->post('direccion_cliente');
            $ed_nueva_dir = new stdClass();
            $ed_nueva_dir->identificador_direccion = $this->input->post('ed_identificador_dir');
            $ed_nueva_dir->linea1 = $this->input->post('ed_linea1_dir');
            $ed_nueva_dir->codigo_postal = $this->input->post('ed_cp_dir');
            $ed_nueva_dir->linea2 = $this->input->post('ed_linea2_dir');
            $ed_nueva_dir->ciudad = $this->input->post('ed_ciudad_dir');
            $ed_nueva_dir->estado = $this->input->post('ed_estado_dir');
            $ed_nueva_dir->telefono = $this->input->post('ed_tel_dir');

            $this->db->where('id_direccion', $identificador_direccion)
                ->update('DireccionesPorCliente', $ed_nueva_dir);

            $nueva_dir = new stdClass();
            $nueva_dir->id_direccion = $identificador_direccion;
            $this->db->where('id_pedido', $id_pedido)
                ->update('Pedidos', $nueva_dir);
        }else {
            $id_nueva_dir = $this->input->post('direccion_cliente');
            $nueva_dir = new stdClass();
            $nueva_dir->id_direccion = $id_nueva_dir;
            $this->db->where('id_pedido', $id_pedido)
                ->update('Pedidos', $nueva_dir);

            $cambio_pedido->valor_actual = $id_nueva_dir;
        }

	    $this->db->insert('HistorialCambiosPedidos', $cambio_pedido);

        redirect(base_url('administracion/pedidos/'.$id_pedido));
    }

/**
 * crea_excel_pedido funcion para llamar la vista html con CI
 * @return descarga excel
 */
function crea_excel_pedido($fecha_inicio,$fecha_fin){
	$pedidos = $this->pedidos_modelo->obtener_pedidos_datatable_excel($fecha_inicio,$fecha_fin);
	$BStyle = array(
	  'borders' => array(
		'outline' => array(
		  'style' => PHPExcel_Style_Border::BORDER_MEDIUM
		)
	  )
	);
	

	$BStyledatos = array(
	  'borders' => array(
		'outline' => array(
		  'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	  )
	);
	 $contador = 4;
	$this->excel->setActiveSheetIndex(0);

	$this->excel->getActiveSheet()->setCellValue('A2', 'Relación pedidos en las fechas '. $fecha_inicio.' - '.$fecha_fin);
	$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
	$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);

	$this->excel->getActiveSheet()->setTitle('Pedidos');
	$this->excel->getActiveSheet()->setCellValue('A'.$contador, 'No');
	$this->excel->getActiveSheet()->getStyle('A'.$contador)->getFont()->setSize(14);
	$this->excel->getActiveSheet()->getStyle('A'.$contador)->getFont()->setBold(true);
	$this->excel->getActiveSheet()->setCellValue('C'.$contador, 'Nombre');
	$this->excel->getActiveSheet()->getStyle('C'.$contador)->getFont()->setSize(14);
	$this->excel->getActiveSheet()->getStyle('C'.$contador)->getFont()->setBold(true);
	 $this->excel->getActiveSheet()->setCellValue('H'.$contador, 'Fecha creacion');
	$this->excel->getActiveSheet()->getStyle('H'.$contador)->getFont()->setSize(14);
	$this->excel->getActiveSheet()->getStyle('H'.$contador)->getFont()->setBold(true);
	 $this->excel->getActiveSheet()->setCellValue('J'.$contador, 'Items');
	$this->excel->getActiveSheet()->getStyle('J'.$contador)->getFont()->setSize(14);
	$this->excel->getActiveSheet()->getStyle('J'.$contador)->getFont()->setBold(true);  
	 $this->excel->getActiveSheet()->setCellValue('K'.$contador, 'Monto Total');
	$this->excel->getActiveSheet()->getStyle('K'.$contador)->getFont()->setSize(14);
	$this->excel->getActiveSheet()->getStyle('K'.$contador)->getFont()->setBold(true); 
	 $this->excel->getActiveSheet()->setCellValue('M'.$contador, 'Estatus');
	$this->excel->getActiveSheet()->getStyle('M'.$contador)->getFont()->setSize(14);
	$this->excel->getActiveSheet()->getStyle('M'.$contador)->getFont()->setBold(true); 
	 $this->excel->getActiveSheet()->setCellValue('P'.$contador, 'Envio');
	$this->excel->getActiveSheet()->getStyle('P'.$contador)->getFont()->setSize(14);
	$this->excel->getActiveSheet()->getStyle('P'.$contador)->getFont()->setBold(true);  
	 $this->excel->getActiveSheet()->setCellValue('R'.$contador, 'Metodo de Pago');
	$this->excel->getActiveSheet()->getStyle('R'.$contador)->getFont()->setSize(14);
	$this->excel->getActiveSheet()->getStyle('R'.$contador)->getFont()->setBold(true);  

	
	$this->excel->getActiveSheet()->getStyle('A'.$contador.':'.'T'.$contador)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('8497B0'); 
	$this->excel->getActiveSheet()->getStyle('A'.$contador.':'.'B'.$contador)->applyFromArray($BStyle);
	$this->excel->getActiveSheet()->getStyle('C'.$contador.':'.'G'.$contador)->applyFromArray($BStyle);
	$this->excel->getActiveSheet()->getStyle('H'.$contador.':'.'I'.$contador)->applyFromArray($BStyle);
	$this->excel->getActiveSheet()->getStyle('J'.$contador.':'.'J'.$contador)->applyFromArray($BStyle);
	$this->excel->getActiveSheet()->getStyle('K'.$contador.':'.'L'.$contador)->applyFromArray($BStyle);
	$this->excel->getActiveSheet()->getStyle('M'.$contador.':'.'O'.$contador)->applyFromArray($BStyle);
	$this->excel->getActiveSheet()->getStyle('P'.$contador.':'.'Q'.$contador)->applyFromArray($BStyle);
	$this->excel->getActiveSheet()->getStyle('R'.$contador.':'.'T'.$contador)->applyFromArray($BStyle);
 
	$this->excel->getActiveSheet()->getStyle('A'.$contador.':'.'T'.$contador)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('8497B0'); 
	$this->excel->getActiveSheet()->getStyle('A'.$contador.':'.'T'.$contador)->applyFromArray($BStyle);
		// $this->excel->getActiveSheet()->getStyle('R'.$contador.':'.'S'.$contador)->applyFromArray($BStyle);

		if(empty($pedidos)){
			$this->excel->getActiveSheet()->setCellValue("A5", 'No se tiene registros en el rango de fechas '. $fecha_inicio.' - '.$fecha_fin .' favor de intentar con otras');				
			$this->excel->getActiveSheet()->mergeCells('A5:Q5');
			$this->excel->getActiveSheet()->getStyle('A5:Q5')->applyFromArray($BStyledatos);				
		}else{
			foreach ($pedidos as $e) {
				$contador++;
				$this->excel->getActiveSheet()->setCellValue("A{$contador}", $e->id_pedido);
				$this->excel->getActiveSheet()->setCellValue("C{$contador}", $e->nombres. ' ' .$e->apellidos);
				$fecha_modificada = preg_split("/[\s-]/", $e->fecha_creacion);
				$ano = $fecha_modificada[0];
				$mes = $fecha_modificada[1];
				$dia = $fecha_modificada[2];
				$fechanueva = $ano. '-' .$mes. '-' .$dia;
				$this->excel->getActiveSheet()->setCellValue("H{$contador}", $fechanueva);
				$this->excel->getActiveSheet()->setCellValue("J{$contador}", $e->numero_productos);
				$this->excel->getActiveSheet()->setCellValue("K{$contador}", '$'.$e->total);
				$this->excel->getActiveSheet()->setCellValue("M{$contador}", $e->nombre_paso);
				$this->excel->getActiveSheet()->setCellValue("P{$contador}", $e->estatus_pedido);
				$this->excel->getActiveSheet()->setCellValue("R{$contador}", $e->metodo_pago);
				

				// $this->excel->getActiveSheet()->setCellValue("R{$contador}", "$".$datosDepto['efectivo']);
				
				$this->excel->getActiveSheet()->mergeCells('A'.$contador.':B'.$contador.'');
				$this->excel->getActiveSheet()->mergeCells('C'.$contador.':G'.$contador.'');
				$this->excel->getActiveSheet()->mergeCells('H'.$contador.':I'.$contador.'');
				$this->excel->getActiveSheet()->mergeCells('J'.$contador.':J'.$contador.'');
				$this->excel->getActiveSheet()->mergeCells('K'.$contador.':L'.$contador.'');
				$this->excel->getActiveSheet()->mergeCells('M'.$contador.':O'.$contador.'');
				$this->excel->getActiveSheet()->mergeCells('P'.$contador.':Q'.$contador.'');
				$this->excel->getActiveSheet()->mergeCells('R'.$contador.':T'.$contador.'');
				// $this->excel->getActiveSheet()->mergeCells('R'.$contador.':S'.$contador.'');

				$this->excel->getActiveSheet()->getStyle('A'.$contador.':B'.$contador.'')->applyFromArray($BStyledatos);
				$this->excel->getActiveSheet()->getStyle('C'.$contador.':G'.$contador.'')->applyFromArray($BStyledatos);
				   $this->excel->getActiveSheet()->getStyle('H'.$contador.':I'.$contador.'')->applyFromArray($BStyledatos); 
				   $this->excel->getActiveSheet()->getStyle('J'.$contador.':J'.$contador.'')->applyFromArray($BStyledatos);     
				   $this->excel->getActiveSheet()->getStyle('K'.$contador.':L'.$contador.'')->applyFromArray($BStyledatos);     
				   $this->excel->getActiveSheet()->getStyle('M'.$contador.':O'.$contador.'')->applyFromArray($BStyledatos);     
				   $this->excel->getActiveSheet()->getStyle('P'.$contador.':Q'.$contador.'')->applyFromArray($BStyledatos); 
				$this->excel->getActiveSheet()->getStyle('R'.$contador.':T'.$contador.'')->applyFromArray($BStyledatos);    
			   // $this->excel->getActiveSheet()->getStyle('R'.$contador.':S'.$contador.'')->applyFromArray($BStyledatos);
		   }
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="pedido.xls"');
		header('Cache-Control: max-age=0'); //no cache
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		// Forzamos a la descarga
		$objWriter->save('php://output'); 	

	}

}
