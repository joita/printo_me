<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends MY_Controller {

	public function index()
	{
		// Config
		$datos_header['seccion_activa'] = 'inicio';
		$datos_header['meta']['title'] = 'Diseñar y personalizar playeras en minutos | printome.mx';
		$datos_header['meta']['description'] = 'Imprime camisetas personalizadas con tu diseño para uso personal o cualquier evento. Máxima calidad de estampado digital y veloz entrega a domicilio.';
		$datos_header['meta']['imagen'] = '';

		//$datos_seccion['acabantes'] = $this->enhance_modelo->obtener_campanas_acabantes();
        //$datos_seccion['populares'] = $this->catalogo_modelo->obtener_enhanced_mas_popular(4);

        $datos_banners['banners'] = $this->slider_modelo->obtener_sliders_usuario();
        $datos_banners['creadores'] = $this->destacadosinicio_modelo->obtener_creadores_usuario();

        //$datos_perso['modelos'] = $this->productos_model->obtener_modelos();

		$this->load->view('header', $datos_header);
		$this->load->view('inicio/inicio', $datos_banners);
		//$this->load->view('inicio/video_banners', $datos_banners);
		//$this->load->view('inicio/creadores_inicio', $datos_creadores);
		//$this->load->view('inicio/carrusel_prods');

        //$this->load->view('inicio/perso_prods');
        //$this->load->view('inicio/pasos_descriptivos');
		//$this->load->view('inicio/new_pasos_descriptivos');
		//$this->load->view('inicio/disenos_mas_populares');
        //$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
	}

	public function ayuda()
	{
		// Config
		$datos_header['seccion_activa'] = 'dudas';
		$datos_header['meta']['title'] = 'Preguntas frecuentes  y ayuda | printome.mx';
		$datos_header['meta']['description'] = 'Contáctanos vía email a hello@printome.mx, chatea con uno de nuestros representantes o llama/escribe vía WhatsApp al +52 (999) 259 59 95';
		$datos_header['meta']['imagen'] = '';

		$this->load->view('header', $datos_header);
		$this->load->view('inicio/ayuda');
		//$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
	}

	public function error_404()
	{
		// Config
		$datos_header['seccion_activa'] = 'error_404';
		$datos_header['meta']['title'] = 'El estampado que buscas no está aqui | printome.mx';
		$datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
		$datos_header['meta']['imagen'] = '';

		$this->load->view('header', $datos_header);
		$this->load->view('errors/php/404');
		//$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
	}

	public function terminos()
	{
		// Config
		$datos_header['seccion_activa'] = 'terminos-y-condiciones';
		$datos_header['meta']['title'] = 'Revisa nuestros términos y condiciones. | printome.mx';
		$datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
		$datos_header['meta']['imagen'] = '';

		$this->load->view('header', $datos_header);
		$this->load->view('inicio/terminos');
		//$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
	}

	public function politicas()
	{
		// Config
		$datos_header['seccion_activa'] = 'politicas-de-compra';
		$datos_header['meta']['title'] = 'Revisa nuestras políticas de compra. | printome.mx';
		$datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
		$datos_header['meta']['imagen'] = '';

		$this->load->view('header', $datos_header);
		$this->load->view('inicio/politicas');
		//$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
	}

	public function aviso()
	{
		// Config
		$datos_header['seccion_activa'] = 'aviso-de-privacidad';
		$datos_header['meta']['title'] = 'Revisa nuestro aviso de privacidad. | printome.mx';
		$datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
		$datos_header['meta']['imagen'] = '';

		$this->load->view('header', $datos_header);
		$this->load->view('inicio/aviso');
		//$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
	}

    public function testimonios($pagina = 1)
    {
        // Config
        $this->load->library('pagination');
        $datos_header['seccion_activa'] = 'testimonios';
		$datos_header['meta']['title'] = 'Ve como los demás han calificado a printome.mx';
		$datos_header['meta']['description'] = 'Los testimonios de las personas que han aprovechado el servicio de impresión de camisetas personalizadas con tu propio diseño para uso personal o cualquier evento';
		$datos_header['meta']['imagen'] = '';

        $config['base_url'] = site_url('testimonios').'/pagina/';
        $numero = $this->testimonios_m->contar_testimonios();
        $config['total_rows'] = $numero[0]->numero_testimonios;;
        $config['first_url'] = site_url('testimonios');
        $config['per_page'] = 21;
        $this->pagination->initialize($config);

        $start = (($pagina - 1) * $config['per_page']) + 1;
        $offset = $config['per_page'];

        $datos_seccion['testimonios'] = $this->testimonios_m->obtener_testimonios_con_respuestas($start, $offset);
        $datos_seccion['paginacion'] = $this->pagination->create_links();

		$this->load->view('header', $datos_header);
		$this->load->view('inicio/testimonios_nuevo', $datos_seccion);
		/*$this->load->view('inicio/testimonios_listado', $datos_seccion);*/
		//$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
    }

    public function nuevo_testimonio()
    {
        // Config
        $datos_header['seccion_activa'] = 'testimonios';
		$datos_header['meta']['title'] = 'Califica a printome.mx';
		$datos_header['meta']['description'] = 'Cuéntanos sobre tu impresión de printome.mx';
		$datos_header['meta']['imagen'] = '';

		$this->load->view('header', $datos_header);
		$this->load->view('inicio/nuevo_testimonio');
		//$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
    }

    public function respuesta_usuario($email_encrip,$timestamp,$id_testimonio_encrip){
	    $verificacion = $this->testimonios_m->verificar_email_con_testimonio($email_encrip, $id_testimonio_encrip);
	    if($id_testimonio_encrip){
	        if($verificacion) {
                $fecha_limite = new DateTime();
                $fecha_actual = new DateTime();
                $fecha_limite->setTimestamp($timestamp);
                $diff = $fecha_actual->diff($fecha_limite);
                $diferencia = (int)$diff->format('%R%a');
                if ($diferencia <= 10 && $diferencia >= 0) {
                    $datos_header['seccion_activa'] = 'testimonios';
                    $datos_header['meta']['title'] = 'Responde a printome.mx';
                    $datos_header['meta']['description'] = 'Responde a Printome.mx';
                    $datos_header['meta']['imagen'] = '';

                    $testimonio = $this->testimonios_m->obtener_testimonio_respuestas_encrip($id_testimonio_encrip);
                    $respuestas = array_reverse($testimonio[0]->respuestas);
                    foreach ($respuestas as $respuesta) {
                        if ($respuesta->tipo_usuario == 'admin') {
                            $datos_seccion['ultimo_comentario_admin'] = $respuesta;
                            break;
                        } else {
                            $datos_seccion['ultimo_comentario_admin'] = null;
                        }
                    }
                    foreach ($respuestas as $respuesta) {
                        if ($respuesta->tipo_usuario == 'user') {
                            $datos_seccion['ultimo_comentario_usuario'] = $respuesta;
                            break;
                        } else {
                            $datos_seccion['ultimo_comentario_usuario'] = null;
                        }
                    }
                    $ultimo_orden = (int)$respuestas[0]->orden;
                    $datos_seccion['nuevo_orden'] = $ultimo_orden + 1;
                    $datos_seccion['testimonio'] = $testimonio;

                    $footer_datos['scripts'] = 'inicio/scripts_respuesta_testimonio';

                    $this->load->view('header', $datos_header);
                    $this->load->view('inicio/respuesta_testimonio', $datos_seccion);
                    //$this->load->view('inicio/loquedicen');
                    $this->load->view('footer', $footer_datos);
                } else {
                    redirect('inicio/respuesta_expirado');
                }
            }else{
                redirect('404_override');
            }
        }else{
	        redirect('inicio');
        }
    }

    public function testimonio_recibido()
    {
        // Config
        $datos_header['seccion_activa'] = 'testimonios';
		$datos_header['meta']['title'] = 'Gracias por calificar a printome.mx';
		$datos_header['meta']['description'] = 'Te agradecemos por tomarte el tiempo para calificar a printome.mx';
		$datos_header['meta']['imagen'] = '';

		$this->load->view('header', $datos_header);
		$this->load->view('inicio/testimonio_recibido');
		//$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
    }

    public function respuesta_expirado()
    {
        // Config
        $datos_header['seccion_activa'] = 'testimonios';
        $datos_header['meta']['title'] = 'El link de respuesta ha expirado!';
        $datos_header['meta']['description'] = 'Te agradecemos por tomarte el tiempo para calificar a printome.mx';
        $datos_header['meta']['imagen'] = '';

        $this->load->view('header', $datos_header);
        $this->load->view('inicio/link_respuesta_expirado');
        $this->load->view('inicio/loquedicen');
        $this->load->view('footer');
    }

    public function nuevo_testimonio_procesar()
    {
        try {
            $recaptcha = new \ReCaptcha\ReCaptcha('6LclRioUAAAAAIdaBM1c6KhAVn1a87wASy-nccn1');
            $captcha = $this->input->post('g-recaptcha-response');
            $ip_persona = $_SERVER['REMOTE_ADDR'];

            if($captcha == '') {
                throw new Exception('Datos invalidos, por favor intenta nuevamente.');
            } else {
                $resp = $recaptcha->verify($captcha, $ip_persona);

                if ($resp->isSuccess()) {
                    $calif = $this->input->post('calificacion_testimonio');
                    $testimonio = new stdClass();
                    $testimonio->monto_calificacion = $calif;
                    $testimonio->monto_calificacion_inicial = $calif;
                    $testimonio->fecha_calificacion = date("Y-m-d H:i:s");
                    $testimonio->nombre             = $this->input->post('nombre_testimonio');
                    $testimonio->email              = $this->input->post('email_testimonio');
                    $testimonio->comentario         = $this->input->post('mensaje_testimonio');
                    $testimonio->estatus            = 0;
                    $testimonio->direccion_ip       = $ip_persona;

                    $contact = array(
						"email"              => $testimonio->email,
						"first_name"         => $testimonio->nombre,
						"p[19]"               => "19",
						"status[19]"          => 1,
						"tags"				 => "testimonio",
                        "field[8,0]"         => $testimonio->monto_calificacion,
                        "field[9,0]"         => $testimonio->comentario
					);
					$contact_sync = $this->ac->api("contact/sync", $contact);


                    $this->db->insert('CalificacionesPrintome', $testimonio);

                    redirect('testimonios/recibido');
                } else {
                    $mensaje = '';
                    foreach ($resp->getErrorCodes() as $err) {
                        $mensaje .= $err;
                    }
                    throw new Exception($mensaje);
                }
            }
        } catch(Exception $e) {
            $this->session->set_flashdata('error_testimonio', $e);
            redirect('testimonios/nuevo');
        }

    }

    public function nueva_respuesta_usuario()
    {
        try {
            $recaptcha = new \ReCaptcha\ReCaptcha('6LclRioUAAAAAIdaBM1c6KhAVn1a87wASy-nccn1');
            $captcha = $this->input->post('g-recaptcha-response');
            $ip_persona = $_SERVER['REMOTE_ADDR'];

            if($captcha == '') {
                throw new Exception('Datos invalidos, por favor intenta nuevamente.');
            } else {
                $resp = $recaptcha->verify($captcha, $ip_persona);

                if ($resp->isSuccess()) {
                    $id_calificacion = $this->input->post('id_calificacion');
                    $respuesta = new stdClass();
                    $testimonio = new stdClass();
                    if($this->input->post('check-cambiar')){
                        $respuesta->cambio_calif = '1';
                        $testimonio->monto_calificacion = $this->input->post('calificacion_testimonio');
                        $this->db->where('id_calificacion', $id_calificacion);
                        $this->db->update('CalificacionesPrintome', $testimonio);
                    }else{
                        $respuesta->cambio_calif = '0';
                    }
                    $respuesta->id_respuesta = 'NULL';
                    $respuesta->id_calificacion = $id_calificacion;
                    $respuesta->respuesta       = $this->input->post('mensaje_respuesta');
                    $respuesta->tipo_usuario    = 'user';
                    $respuesta->orden           = $this->input->post('orden');
                    $respuesta->fecha = date("Y-m-d H:i:s");

                    $this->db->insert('RespuestasCalificaciones', $respuesta);

                    $datos_correo['respuesta'] = $respuesta->respuesta;
                    $datos_correo['nombre_usuario'] = $this->input->post('nombre_testimonio');
                    $datos_correo['link'] = site_url('administracion/respuestas/'.$id_calificacion);

                    $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
                    $email = new SendGrid\Email();
                    $email->addTo('hello@printome.mx', "Samantha Mendez")
                        ->setFrom('no-reply@printome.mx')
                        ->setFromName('Sitio web printome.mx')
                        ->setSubject('Usuario respondio al comentario de su testimonio. | printome.mx')
                        ->setHtml($this->load->view('plantillas_correos/nuevas/admin_aviso_respuesta_testimonio', $datos_correo, TRUE))
                    ;
                    $sendgrid->send($email);

                    redirect('testimonios/recibido');
                } else {
                    $mensaje = '';
                    foreach ($resp->getErrorCodes() as $err) {
                        $mensaje .= $err;
                    }
                    throw new Exception($mensaje);
                }
            }
        } catch(Exception $e) {
            $this->session->set_flashdata('error_testimonio', $e);
            redirect('testimonios/recibido');
        }

    }

    public function cargos_extra($md5_id_cliente, $timestamp, $md5_id_tarjeta, $md5_id_direccion){
        $info_cargo = $this->cargos_extra_m->obtener_info_cargo($md5_id_cliente, $md5_id_tarjeta);
        if($md5_id_tarjeta) {
            if ($info_cargo[0]->estatus_pago == 'por_realizar') {
                if (sizeof($info_cargo) > 0) {
                    $fecha_limite = new DateTime();
                    $fecha_actual = new DateTime();
                    $fecha_limite->setTimestamp($timestamp);
                    $diff = $fecha_actual->diff($fecha_limite);
                    $diferencia = (int)$diff->format('%R%a');
                    if ($diferencia <= 5 && $diferencia >= 0) {
                        $datos_header['seccion_activa'] = 'cargos-extra';
                        $datos_header['meta']['title'] = 'Cargos Extra';
                        $datos_header['meta']['description'] = 'Cargos Extra';
                        $datos_header['meta']['imagen'] = '';

                        $datos_seccion['info_cargo'] = $info_cargo[0];
                        $datos_seccion['id_direccion'] = $md5_id_direccion;
                        $datos_seccion['timestamp'] = $timestamp;

                        $footer_datos['scripts'] = 'inicio/scripts_cargos_extra';

                        $this->load->view('header', $datos_header);
                        $this->load->view('inicio/cargo_extra', $datos_seccion);
                        //$this->load->view('inicio/loquedicen');
                        $this->load->view('footer', $footer_datos);
                    } else {
                        redirect('cargo-extra-expirado');
                    }
                } else {
                    redirect('404_override');
                }
            }else{
                redirect('cargo-completado-tarjeta');
            }
        }else{
            redirect('404_override');
        }
    }

    public function pagar_tarjeta(){
        // Inicializar Sendgrid
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        // Inicializar Conekta
        \Conekta\Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
        \Conekta\Conekta::setLocale('es');
        \Conekta\Conekta::setApiVersion("2.0.0");
        // Recibir token de Conekta
        $token_card = $this->input->post('conektaTokenId');
        $id_cargo = $this->input->post('id_cargo');
        $id_direccion = $this->input->post('id_direccion');
        $timestamp = $this->input->post('time');

        $cargo = $this->cargos_extra_m->obtener_cargo_especifico($id_cargo);
        $cliente = $this->cargos_extra_m->obtener_cliente($cargo->id_cliente);
        $direccion = $this->cargos_extra_m->obtener_info_direccion($id_direccion);

        $forma_pago = 'tdc';
        $pedido_id = $this->cargos_extra_m->obtener_pedido_shopify_cargo($id_cargo);

        $total_resultado = count($pedido_id);

        $info_cargo = array(
            'currency' => 'MXN',
            'description' => 'Compra desde printome.mx',
            'customer_info' => array(
                'name' => $cliente->nombres.' '.$cliente->apellidos,
                'phone' => $direccion->telefono,
                'email' => $cliente->email
            ),
            'shipping_contact' => array(
                'receiver' => $cliente->nombres.' '.$cliente->apellidos,
                'phone' => $direccion->telefono,
                'address' => array(
                    'street1' => $direccion->linea1,
                    'street2' => $direccion->linea2,
                    'city' => $direccion->ciudad,
                    'state' => $direccion->estado,
                    'postal_code' => $direccion->codigo_postal,
                    'country' => 'MX'
                )
            ),
            'line_items' => array(
                array(
                    'name' => 'Cargo Extra',
                    'unit_price' => number_format($cargo->total, 2, '.', '') * 100,
                    'quantity' => 1
                )
            ),
            'shipping_lines' => array(
                array(
                    'amount' => 0,
                    'carrier' => 'No Aplica'
                )
            ),
            'charges' => array(
                array(
                    'amount' => number_format($cargo->total, 2, '.', '') * 100,
                    'payment_method' => array(
                        'type' => 'card',
                        'token_id' => $token_card
                    )
                )
            )
        );

        try{
            // Funcion de cargo, si es exitoso todo se ejecuta aqui
            $orden = \Conekta\Order::create($info_cargo);
            // Guardar pedido en la base de datos

            $datos_cargo = $this->cargos_extra_m->guardar_cargos_extra_tarjeta($orden, 'card_payment', $cliente->email, $cargo);
            $id_cargo = $datos_cargo->id_cargo;

            if($total_resultado >0){
                $historial_pedido = new stdClass();
                $historial_pedido->id_pedido = $pedido_id->id_pedido;
                $historial_pedido->id_paso_pedido = 1;
                $historial_pedido->fecha_inicio = date("Y-m-d H:i:s");
                $historial_pedido->fecha_final = date("Y-m-d H:i:s");
                $this->db->insert('HistorialPedidos', $historial_pedido);

                $segundo_historial = new stdClass();
                $segundo_historial->id_pedido = $pedido_id->id_pedido;
                $segundo_historial->id_paso_pedido = 2;
                $segundo_historial->fecha_inicio = date("Y-m-d H:i:s");

                $this->db->insert('HistorialPedidos', $segundo_historial);


                $pedido_completo = new StdClass();
                $pedido_completo->estatus_pago = "paid";
                $pedido_completo->id_paso_pedido = 2;

                $this->db->where("id_pedido", $pedido_id->id_pedido);
                $this->db->update("Pedidos", $pedido_completo);
            }

            // Preparar la información de los correos
            $datos_correo                = new stdClass();
            $datos_correo->total_pedido  = $datos_cargo->total;
            $datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
            $datos_correo->nombres       = $cliente->nombres;
            $datos_correo->apellidos     = $cliente->apellidos;
            $datos_correo->email         = $cliente->email;
            $datos_correo->num_pedido    = $datos_cargo->id_pedido;

            // Email de aviso de la compra
            $email_compra = new SendGrid\Email();
            $email_compra->addTo($datos_correo->email, $datos_correo->nombre)
                ->setFrom('administracion@printome.mx')
                ->setReplyTo('administracion@printome.mx')
                ->setFromName('printome.mx')
                ->setSubject('Confirmación de pago con tarjeta | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_tarjeta_confirmado_extra', $datos_correo, TRUE));
            $sendgrid->send($email_compra);

            // Email de aviso para administracion
            $email_administracion = new SendGrid\Email();
            $email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
                ->setFrom('no-reply@printome.mx')
                ->setReplyTo('administracion@printome.mx')
                ->setFromName('Tienda en línea printome.mx')
                ->setSubject('Pago con tarjeta realizado | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/admin_confirmacion_pago_tarjeta_extra', $datos_correo, TRUE));
            $sendgrid->send($email_administracion);

            ac_agregar_etiqueta($datos_correo->email, 'pedido-completado');
            ac_quitar_etiqueta($datos_correo->email, 'error-pago-tarjeta');

            redirect('cargo-completado-tarjeta');

        } catch (\Conekta\ProccessingError $error) {
            // Error de procesamiento
            $this->bugsnag->notifyError('Error de procesamiento tarjeta', $error);
            $this->session->set_flashdata('error_pago', $error);
            ac_agregar_etiqueta($datos_correo->email, 'pedido-completado');
            ac_quitar_etiqueta($datos_correo->email, 'error-pago-tarjeta');
            redirect('cargos/error-tarjeta'."/".md5($cliente->id_cliente)."/".$timestamp."/".md5($cargo->id_pago_tarjeta)."/".md5($direccion->id_direccion));
        } catch (\Conekta\ParameterValidationError $error) {
            // Error de validacion
            $this->bugsnag->notifyError('Error de validación tarjeta', $error);
            $this->session->set_flashdata('error_pago', $error);
            ac_agregar_etiqueta($datos_correo->email, 'pedido-completado');
            ac_quitar_etiqueta($datos_correo->email, 'error-pago-tarjeta');;
            redirect('cargos/error-tarjeta'."/".md5($cliente->id_cliente)."/".$timestamp."/".md5($cargo->id_pago_tarjeta)."/".md5($direccion->id_direccion));
        } catch (\Conekta\Handler $error) {
            // Error general
            $this->bugsnag->notifyError('Error de manejo tarjeta', $error);
            $this->session->set_flashdata('error_pago', $error);
            ac_agregar_etiqueta($datos_correo->email, 'pedido-completado');
            ac_quitar_etiqueta($datos_correo->email, 'error-pago-tarjeta');
            redirect('cargos/error-tarjeta'."/".md5($cliente->id_cliente)."/".$timestamp."/".md5($cargo->id_pago_tarjeta)."/".md5($direccion->id_direccion));
        }
    }

    public function cargo_extra_expirado(){
        $datos_header['seccion_activa'] = 'cargos-extra';
        $datos_header['meta']['title'] = 'Cargos Extra';
        $datos_header['meta']['description'] = 'Cargos Extra';
        $datos_header['meta']['imagen'] = '';

        $this->load->view('header', $datos_header);
        $this->load->view('inicio/cargo_extra_expirado');
        $this->load->view('inicio/loquedicen');
        $this->load->view('footer');
    }

    public function cargo_extra_pagado(){
        $datos_header['seccion_activa'] = 'cargos-extra';
        $datos_header['meta']['title'] = 'Cargos Extra';
        $datos_header['meta']['description'] = 'Cargos Extra';
        $datos_header['meta']['imagen'] = '';

        $this->load->view('header', $datos_header);
        $this->load->view('inicio/cargo_extra_pagado');
        $this->load->view('inicio/loquedicen');
        $this->load->view('footer');
    }
    public function faqs()
    {
        // Config
        $datos_header['seccion_activa'] = 'faqs';
        $datos_header['meta']['title'] = 'Preguntas frecuentes  y ayuda | printome.mx';
        $datos_header['meta']['description'] = 'Contáctanos vía email a hello@printome.mx, chatea con uno de nuestros representantes o llama/escribe vía WhatsApp al +52 (999) 259 59 95';
        $datos_header['meta']['imagen'] = '';

        $this->load->view('header', $datos_header);
        $this->load->view('inicio/faq');
        $this->load->view('footer');
    }
}
