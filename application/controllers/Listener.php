<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listener extends MY_Controller {

	public function index() {

		try {
            // Inicializar Sendgrid
            $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
            // Inicializar Conekta
            \Conekta\Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
            \Conekta\Conekta::setLocale('es');
            \Conekta\Conekta::setApiVersion("1.0.0");

			$body = @file_get_contents('php://input');

			if($body != '') {
				$info_aviso = json_decode($body);

				$id_pago = $info_aviso->data->object->id;
                if ($info_aviso->type == 'charge.paid') {
                    $id_pago_nuevo = $info_aviso->id;

                    $info_pago_res = $this->db->get_where('Pedidos', array('id_pago' => $id_pago));
                    $info_pago = $info_pago_res->result();

                    if (isset($info_pago[0]->id_pago) && $info_pago[0]->metodo_pago == 'cash_payment') {
                        $pago = new stdClass();
                        $pago->id_pago = $id_pago_nuevo;
                        $pago->fecha_pago = date("Y-m-d H:i:s", $info_aviso->created_at);
                        $pago->estatus_pago = 'paid';

                        $this->db->where('id_pedido', $info_pago[0]->id_pedido);
                        $this->db->update('Pedidos', $pago);

                        $this->db->select('*')->from('HistorialPedidos')->where('id_pedido', $info_pago[0]->id_pedido)->where('id_paso_pedido', 1)->order_by('id_historial')->limit(1);
                        $historial = $this->db->get()->row();

                        if (isset($historial->id_historial)) {
                            $this->db->query('UPDATE HistorialPedidos SET fecha_final=\'' . $pago->fecha_pago . '\' WHERE id_historial=' . $historial->id_historial);
                        }

                        $segundo_historial = new stdClass();
                        $segundo_historial->id_pedido = $info_pago[0]->id_pedido;
                        $segundo_historial->id_paso_pedido = 2;
                        $segundo_historial->fecha_inicio = $pago->fecha_pago;

                        $this->db->insert('HistorialPedidos', $historial_pedido);

                        $productos_por_pedido = $this->pedidos_modelo->obtener_productos_por_pedido($info_pago[0]->id_pedido);

                        foreach ($productos_por_pedido as $producto) {
                            $cantidad = $producto->cantidad_producto;

                            if ($producto->id_enhance != 0) {
                                $query = $this->db->query('UPDATE Enhance SET sold=(sold+' . $cantidad . ') WHERE id_enhance=' . $producto->id_enhance);
                            }
                        }

                        $cliente_res = $this->db->get_where('Clientes', array('id_cliente' => $info_pago[0]->id_cliente));
                        $cliente = $cliente_res->result();

                        $datos_correo = new stdClass();
                        $datos_correo->nombre = $cliente[0]->nombres . ' ' . $cliente[0]->apellidos;
                        $datos_correo->email = $cliente[0]->email;
                        $datos_correo->numero_pedido = str_pad($info_pago[0]->id_pedido, 8, '0', STR_PAD_LEFT);
                        $datos_correo->total_pedido = $info_pago[0]->total;
                        $datos_correo->nombres = $cliente[0]->nombres;
                        $datos_correo->apellidos = $cliente[0]->apellidos;
                        $datos_correo->recibir = fecha_recepcion(date("N"));

                        // E-mail confirmación de compra por PayPal
                        $email_confirmacion = new SendGrid\Email();
                        $email_confirmacion->addSmtpapiTo($datos_correo->email, $datos_correo->nombre)
                            ->setFrom('administracion@printome.mx')
                            ->setReplyTo('administracion@printome.mx')
                            ->setFromName('printome.mx')
                            ->setSubject('Confirmación de pago en OXXO | printome.mx')
                            ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_oxxo_confirmado', $datos_correo, TRUE));
                        $sendgrid->send($email_confirmacion);

                        // Email administracion
                        $email_administracion = new SendGrid\Email();
                        $email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
                            ->setFrom('no-reply@printome.mx')
                            ->setReplyTo('administracion@printome.mx')
                            ->setFromName('Tienda en línea printome.mx')
                            ->setSubject('Pago en OXXO realizado | printome.mx')
                            ->setHtml($this->load->view('plantillas_correos/nuevas/admin_confirmacion_pago_oxxo', $datos_correo, TRUE))
                            ->addAttachment('assets/pdf/' . $this->pdf_pedido_archivo($info_pago[0]->id_pedido), 'pedido_printome_' . $datos_correo->numero_pedido . '.pdf');
                        $sendgrid->send($email_administracion);
                    }
                }
			}
		} catch(Exception $e) {
			// Mandrill errors are thrown as exceptions
			echo 'A sendgrid error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			// A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
			throw $e;
		}

	}

    public function oxxopay()
    {
        // Inicializar Sendgrid
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        // Inicializar Conekta
        \Conekta\Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
        \Conekta\Conekta::setLocale('es');
        \Conekta\Conekta::setApiVersion("2.0.0");

        $body = @file_get_contents('php://input');

        if($body != '') {
            $info_aviso = json_decode($body);

            $id_pago = $info_aviso->data->object->id;

            if($info_aviso->type == 'order.paid') {

                $info_pago_res = $this->db->get_where('Pedidos', array('id_pago' => $id_pago));
                $info_pago = $info_pago_res->result();

                if(isset($info_pago[0]->id_pago) && $info_pago[0]->metodo_pago == 'cash_payment') {
                    $pago = new stdClass();
                    $pago->fecha_pago = date("Y-m-d H:i:s", $info_aviso->created_at);
                    $pago->estatus_pago = 'paid';
                    $pago->id_paso_pedido = 2;

                    $this->db->where('id_pedido', $info_pago[0]->id_pedido);
                    $this->db->update('Pedidos', $pago);

                    //sistema de puntos para pedidios de pago oxxo
                    $pedido = $this->db->get_where('Pedidos', array('id_pedido' => $info_pago[0]->id_pedido))->row();
                    $cupon = $this->db->get_where('Cupones', array('id' => $pedido->id_cupon))->row();
                    if($cupon->tipo == 5) {
                        $ref = $this->db->get_where('Referencias', array('id_cupon' => $pedido->id_cupon))->row();
                        $experiencia = $pedido->subtotal;

                        $referencia = new stdClass();
                        $referencia->id_comprador = $pedido->id_cliente;
                        $referencia->id_referenciado = $ref->id_cliente;
                        $referencia->id_pedido = $pedido->id_pedido;
                        $referencia->id_cupon = $cupon->id;
                        $referencia->fecha = date("Y-m-d H:i:s");
                        $referencia->experiencia = $experiencia;
                        $referencia->puntos = number_format($this->referencias_modelo->obtener_puntos_referenciado($ref->id_cliente, $experiencia), 2, '.', '');
                        $this->db->insert('HistorialReferencias', $referencia);

                        $historial_saldo = new stdClass();
                        $historial_saldo->cantidad = $referencia->puntos;
                        $historial_saldo->fecha = $referencia->fecha;
                        $historial_saldo->id_cliente = $referencia->id_referenciado;
                        $historial_saldo->motivo = "Saldo por Cupón de Referencia: " . $cupon->cupon;
                        $this->db->insert('HistorialSaldo', $historial_saldo);

                        $subio_nivel = $this->referencias_modelo->verificar_nivel($referencia->id_referenciado);
                        if($subio_nivel){
                            $ref = $this->db->get_where('Referencias', array('id_cupon' => $pedido->id_cupon))->row();
                            $this->correo_subir_nivel($ref);
                        }
                    }

                    $productos_por_pedido = $this->pedidos_modelo->obtener_productos_por_pedido($info_pago[0]->id_pedido);

                    foreach ($productos_por_pedido as $producto) {
                        $cantidad = $producto->cantidad_producto;

                        if($producto->id_enhance != 0) {
                            $query = $this->db->query('UPDATE Enhance SET sold=(sold+'.$cantidad.') WHERE id_enhance='.$producto->id_enhance);
                        }
                    }

                    $cliente_res = $this->db->get_where('Clientes', array('id_cliente' => $info_pago[0]->id_cliente));
                    $cliente = $cliente_res->result();

                    $datos_correo = new stdClass();
                    $datos_correo->nombre = $cliente[0]->nombres.' '.$cliente[0]->apellidos;
                    $datos_correo->email = $cliente[0]->email;
                    $datos_correo->numero_pedido = str_pad($info_pago[0]->id_pedido, 8, '0', STR_PAD_LEFT);
                    $datos_correo->total_pedido = $info_pago[0]->total;
                    $datos_correo->nombres       = $cliente[0]->nombres;
                    $datos_correo->apellidos     = $cliente[0]->apellidos;
                    $datos_correo->recibir       = fecha_recepcion(date("N"));

                    // E-mail confirmación de compra por PayPal
                    $email_confirmacion = new SendGrid\Email();
                    $email_confirmacion->addSmtpapiTo($datos_correo->email, $datos_correo->nombre)
                                       ->setFrom('administracion@printome.mx')
                                       ->setReplyTo('hello@printome.mx')
                                       ->setFromName('printome.mx')
                                       ->setSubject('Confirmación de pago en OXXO | printome.mx')
                                       ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_oxxo_confirmado', $datos_correo, TRUE))
                    ;
                    $sendgrid->send($email_confirmacion);

                    // Email administracion
                    $email_administracion = new SendGrid\Email();
                    $email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
                                         ->setFrom('no-reply@printome.mx')
                                         ->setReplyTo('administracion@printome.mx')
                                         ->setFromName('Tienda en línea printome.mx')
                                         ->setSubject('Pago en OXXO Pay realizado | printome.mx')
                                         ->setHtml($this->load->view('plantillas_correos/nuevas/admin_confirmacion_pago_oxxo', $datos_correo, TRUE))
                                         ->addAttachment('assets/pdf/'.$this->pdf_pedido_archivo($info_pago[0]->id_pedido), 'pedido_printome_'.$datos_correo->numero_pedido.'.pdf')
                    ;
                    $sendgrid->send($email_administracion);

//                    if($this->cart->obtener_subtotal() > 999.00){
//                        $this->cupones_modelo->promocion_cm($this->session->login['id_cliente']);
//                    }

                    ac_agregar_etiqueta($datos_correo->email, 'oxxo-pagado');
                }
            }
        }
    }

    public function oxxopayextra()
    {
        // Inicializar Sendgrid
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        // Inicializar Conekta
        \Conekta\Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
        \Conekta\Conekta::setLocale('es');
        \Conekta\Conekta::setApiVersion("2.0.0");

        $body = @file_get_contents('php://input');

        if($body != '') {
            $info_aviso = json_decode($body);

            $id_pago = $info_aviso->data->object->id;

            if($info_aviso->type == 'order.paid') {

                $info_pago_res = $this->db->get_where('CargosExtra', array('id_pago' => $id_pago));
                $info_pago = $info_pago_res->result();
                $pedido_id = $this->cargos_extra_m->obtener_pedido_shopify($id_pago);

                $total_resultado = count($pedido_id);





                if(isset($info_pago[0]->id_pago) && $info_pago[0]->metodo_pago == 'cash_payment') {
                    $pago = new stdClass();
                    $pago->fecha_pago = date("Y-m-d H:i:s", $info_aviso->created_at);
                    $pago->estatus_pago = 'paid';

                    $this->db->where('id_cargo', $info_pago[0]->id_cargo);
                    $this->db->update('CargosExtra', $pago);

                    $cliente_res = $this->db->get_where('Clientes', array('id_cliente' => $info_pago[0]->id_cliente));
                    $cliente = $cliente_res->result();

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




                    $datos_correo = new stdClass();
                    $datos_correo->nombre = $cliente[0]->nombres.' '.$cliente[0]->apellidos;
                    $datos_correo->email = $cliente[0]->email;
                    $datos_correo->total_pedido = $info_pago[0]->total;
                    $datos_correo->nombres       = $cliente[0]->nombres;
                    $datos_correo->apellidos     = $cliente[0]->apellidos;

                    // E-mail confirmación de compra por PayPal
                    $email_confirmacion = new SendGrid\Email();
                    $email_confirmacion->addSmtpapiTo($datos_correo->email, $datos_correo->nombre)
                        ->setFrom('administracion@printome.mx')
                        ->setReplyTo('hello@printome.mx')
                        ->setFromName('printome.mx')
                        ->setSubject('Confirmación de pago en OXXO | printome.mx')
                        ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_oxxo_confirmado_extra', $datos_correo, TRUE))
                    ;
                    $sendgrid->send($email_confirmacion);

                    // Email administracion
                    $email_administracion = new SendGrid\Email();
                    $email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
                        ->setFrom('no-reply@printome.mx')
                        ->setReplyTo('administracion@printome.mx')
                        ->setFromName('Tienda en línea printome.mx')
                        ->setSubject('Pago en OXXO Pay realizado | printome.mx')
                        ->setHtml($this->load->view('plantillas_correos/nuevas/admin_confirmacion_pago_oxxo_extra', $datos_correo, TRUE))
                    ;
                    $sendgrid->send($email_administracion);

                    ac_agregar_etiqueta($datos_correo->email, 'oxxo-pagado');
                }
            }
        }
    }

    public function speipayextra()
    {
        // Inicializar Sendgrid
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        // Inicializar Conekta
        \Conekta\Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
        \Conekta\Conekta::setLocale('es');
        \Conekta\Conekta::setApiVersion("2.0.0");

        $body = @file_get_contents('php://input');

        if($body != '') {
            $info_aviso = json_decode($body);

            $id_pago = $info_aviso->data->object->id;

            if($info_aviso->type == 'order.paid') {

                $info_pago_res = $this->db->get_where('CargosExtra', array('id_pago' => $id_pago));
                $info_pago = $info_pago_res->result();
                $pedido_id = $this->cargos_extra_m->obtener_pedido_shopify($id_pago);

                $total_resultado = count($pedido_id);

                if(isset($info_pago[0]->id_pago) && $info_pago[0]->metodo_pago == 'spei') {
                    $pago = new stdClass();
                    $pago->fecha_pago = date("Y-m-d H:i:s", $info_aviso->created_at);
                    $pago->estatus_pago = 'paid';

                    $this->db->where('id_cargo', $info_pago[0]->id_cargo);
                    $this->db->update('CargosExtra', $pago);

                    $cliente_res = $this->db->get_where('Clientes', array('id_cliente' => $info_pago[0]->id_cliente));
                    $cliente = $cliente_res->result();

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

                    $datos_correo = new stdClass();
                    $datos_correo->nombre = $cliente[0]->nombres.' '.$cliente[0]->apellidos;
                    $datos_correo->email = $cliente[0]->email;
                    $datos_correo->total_pedido = $info_pago[0]->total;
                    $datos_correo->nombres       = $cliente[0]->nombres;
                    $datos_correo->apellidos     = $cliente[0]->apellidos;

                    // E-mail confirmación de compra por PayPal
                    $email_confirmacion = new SendGrid\Email();
                    $email_confirmacion->addSmtpapiTo($datos_correo->email, $datos_correo->nombre)
                        ->setFrom('administracion@printome.mx')
                        ->setReplyTo('hello@printome.mx')
                        ->setFromName('printome.mx')
                        ->setSubject('Confirmación de pago SPEI | printome.mx')
                        ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_spei_confirmado_extra', $datos_correo, TRUE))
                    ;
                    $sendgrid->send($email_confirmacion);

                    // Email administracion
                    $email_administracion = new SendGrid\Email();
                    $email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
                        ->setFrom('no-reply@printome.mx')
                        ->setReplyTo('administracion@printome.mx')
                        ->setFromName('Tienda en línea printome.mx')
                        ->setSubject('Pago SPEI realizado | printome.mx')
                        ->setHtml($this->load->view('plantillas_correos/nuevas/admin_confirmacion_pago_spei_extra', $datos_correo, TRUE))
                    ;
                    $sendgrid->send($email_administracion);

                    ac_agregar_etiqueta($datos_correo->email, 'spei-pagado');
                }
            }
        }
    }

    public function speipay()
    {
        // Inicializar Sendgrid
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        // Inicializar Conekta
        \Conekta\Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
        \Conekta\Conekta::setLocale('es');
        \Conekta\Conekta::setApiVersion("2.0.0");

        $body = @file_get_contents('php://input');

        if($body != '') {
            $info_aviso = json_decode($body);

            $id_pago = $info_aviso->data->object->id;

            if($info_aviso->type == 'order.paid') {

                $info_pago_res = $this->db->get_where('Pedidos', array('id_pago' => $id_pago));
                $info_pago = $info_pago_res->result();

                if(isset($info_pago[0]->id_pago) && $info_pago[0]->metodo_pago == 'spei') {
                    $pago = new stdClass();
                    $pago->fecha_pago = date("Y-m-d H:i:s", $info_aviso->created_at);
                    $pago->estatus_pago = 'paid';
                    $pago->id_paso_pedido = 2;

                    $this->db->where('id_pedido', $info_pago[0]->id_pedido);
                    $this->db->update('Pedidos', $pago);

                    //sistema de puntos para pedidios de pago spei
                    $pedido = $this->db->get_where('Pedidos', array('id_pedido' => $info_pago[0]->id_pedido))->row();
                    $cupon = $this->db->get_where('Cupones', array('id' => $pedido->id_cupon))->row();
                    if($cupon->tipo == 5) {
                        $ref = $this->db->get_where('Referencias', array('id_cupon' => $pedido->id_cupon))->row();
                        $experiencia = $pedido->subtotal;

                        $referencia = new stdClass();
                        $referencia->id_comprador = $pedido->id_cliente;
                        $referencia->id_referenciado = $ref->id_cliente;
                        $referencia->id_pedido = $pedido->id_pedido;
                        $referencia->id_cupon = $cupon->id;
                        $referencia->fecha = date("Y-m-d H:i:s");
                        $referencia->experiencia = $experiencia;
                        $referencia->puntos = number_format($this->referencias_modelo->obtener_puntos_referenciado($ref->id_cliente, $experiencia), 2, '.', '');
                        $this->db->insert('HistorialReferencias', $referencia);

                        $historial_saldo = new stdClass();
                        $historial_saldo->cantidad = $referencia->puntos;
                        $historial_saldo->fecha = $referencia->fecha;
                        $historial_saldo->id_cliente = $referencia->id_referenciado;
                        $historial_saldo->motivo = "Saldo por Cupón de Referencia: " . $cupon->cupon;
                        $this->db->insert('HistorialSaldo', $historial_saldo);

                        $subio_nivel = $this->referencias_modelo->verificar_nivel($referencia->id_referenciado);

                        if($subio_nivel){
                            $ref = $this->db->get_where('Referencias', array('id_cupon' => $pedido->id_cupon))->row();
                            $this->correo_subir_nivel($ref);
                        }
                    }

                    $productos_por_pedido = $this->pedidos_modelo->obtener_productos_por_pedido($info_pago[0]->id_pedido);

                    foreach ($productos_por_pedido as $producto) {
                        $cantidad = $producto->cantidad_producto;

                        if($producto->id_enhance != 0) {
                            $query = $this->db->query('UPDATE Enhance SET sold=(sold+'.$cantidad.') WHERE id_enhance='.$producto->id_enhance);
                        }
                    }

                    $cliente_res = $this->db->get_where('Clientes', array('id_cliente' => $info_pago[0]->id_cliente));
                    $cliente = $cliente_res->result();

                    $datos_correo = new stdClass();
                    $datos_correo->nombre = $cliente[0]->nombres.' '.$cliente[0]->apellidos;
                    $datos_correo->email = $cliente[0]->email;
                    $datos_correo->numero_pedido = str_pad($info_pago[0]->id_pedido, 8, '0', STR_PAD_LEFT);
                    $datos_correo->total_pedido = $info_pago[0]->total;
                    $datos_correo->nombres       = $cliente[0]->nombres;
                    $datos_correo->apellidos     = $cliente[0]->apellidos;
                    $datos_correo->recibir       = fecha_recepcion(date("N"));

                    // E-mail confirmación de compra por PayPal
                    $email_confirmacion = new SendGrid\Email();
                    $email_confirmacion->addSmtpapiTo($datos_correo->email, $datos_correo->nombre)
                                       ->setFrom('administracion@printome.mx')
                                       ->setReplyTo('hello@printome.mx')
                                       ->setFromName('printome.mx')
                                       ->setSubject('Confirmación de pago SPEI | printome.mx')
                                       ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_spei_confirmado', $datos_correo, TRUE))
                    ;
                    $sendgrid->send($email_confirmacion);

                    // Email administracion
                    $email_administracion = new SendGrid\Email();
                    $email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
                                         ->setFrom('no-reply@printome.mx')
                                         ->setReplyTo('administracion@printome.mx')
                                         ->setFromName('Tienda en línea printome.mx')
                                         ->setSubject('Pago SPEI realizado | printome.mx')
                                         ->setHtml($this->load->view('plantillas_correos/nuevas/admin_confirmacion_pago_spei', $datos_correo, TRUE))
                                         ->addAttachment('assets/pdf/'.$this->pdf_pedido_archivo($info_pago[0]->id_pedido), 'pedido_printome_'.$datos_correo->numero_pedido.'.pdf')
                    ;
                    $sendgrid->send($email_administracion);

                    ac_agregar_etiqueta($datos_correo->email, 'spei-pagado');

//                    if($this->cart->obtener_subtotal() > 999.00){
//                        $this->cupones_modelo->promocion_cm($this->session->login['id_cliente']);
//                    }
                }
            }
        }
    }

	public function pdf_pedido_archivo($id_pedido){
        $this->load->helper(array('dompdf', 'file'));
		$contenido['accion'] = 'despliegue';
		$contenido['pedidos'] = 'despliegue';
		$contenido['id_pedido'] = $id_pedido;
		$contenido['pedido'] = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
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

		$nombre = pdf_create_file($html, 'pedido_printome_'.str_pad($id_pedido, 8, '0', STR_PAD_LEFT));

		return $nombre;
	}

    public function correo_subir_nivel($referencia){
        $nivel = $this->db->get_where("NivelesReferencias" , array("id_nivel" => $referencia->id_nivel))->row();
        $cupon = $this->db->get_where("Cupones" , array("id" => $referencia->id_cupon))->row();
        $cliente = $this->db->get_where("Clientes", array("id_cliente" => $referencia->id_cliente))->row();
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);

        $datos_correo                       = new stdClass();
        $datos_correo->email                = $cliente->email;
        $datos_correo->nombre_completo      = $cliente->nombres." ".$cliente->apellidos;
        $datos_correo->nombre               = $cliente->nombres;
        $datos_correo->nombre_nivel         = $nivel->nombre_nivel;
        $datos_correo->porcentaje_ganancias = $nivel->porcentaje_ganancia;
        $datos_correo->minimo_ventas        = $nivel->minimo_ventas;
        $datos_correo->meta_ventas          = $nivel->maximo_ventas;
        $datos_correo->baja_diaria          = $nivel->baja_diaria;
        $datos_correo->puntos_actuales      = $referencia->puntos;
        $datos_correo->experiencia_actual   = $referencia->experiencia;
        $datos_correo->cupon                = $cupon->cupon;
        $datos_correo->slug_imagen          = $nivel->nombre_nivel_slug;

        $email_compra = new SendGrid\Email();
        $email_compra->addTo($datos_correo->email, $datos_correo->nombre_completo)
            ->setFrom('administracion@printome.mx')
            ->setReplyTo('administracion@printome.mx')
            ->setReplyTo('javier.quijano@printome.mx')
            ->setFromName('printome.mx')
            ->setSubject('Confirmación de pago con saldo a favor | printome.mx')
            ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_nuevo_nivel', $datos_correo, TRUE));
        $sendgrid->send($email_compra);
    }
}
