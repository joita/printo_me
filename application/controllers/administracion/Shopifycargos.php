<?php
/**
 * Created by PhpStorm.
 * User: Javier
 * Date: 25/02/2019
 * Time: 10:26
 */

class Shopifycargos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $datos['seccion_activa'] = 'cargos_extra';
        $datos['scripts'] = 'administracion/cargos/scripts';

        $this->load->view('administracion/header', $datos);
        $this->load->view('administracion/cargos/index');
        $this->load->view('administracion/footer');
    }

    public function verificar_usuario(){
        $email_cliente = $this->input->post('email_cliente');
        $info_cliente = $this->cuenta_modelo->obtener_usuario_email($email_cliente);
        $info_direcciones = $this->cuenta_modelo->obtener_direcciones($info_cliente[0]->id_cliente);
        $html_direcciones = "";
        foreach ($info_direcciones as $direccion){
            $html_direcciones .= "<option value='".json_encode($direccion, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)."'>".$direccion->identificador_direccion."(".$direccion->linea1." ,".$direccion->linea2."...)</option>";
        }
        $respuesta = new stdClass();
        if(!$info_cliente){
            $respuesta->respuesta = false;
            echo json_encode($respuesta);
        }else{
            $respuesta->direcciones = $html_direcciones;
            $respuesta->respuesta = true;
            $respuesta->id_cliente = $info_cliente[0]->id_cliente;
            $respuesta->email = $info_cliente[0]->email;
            $respuesta->nombre = $info_cliente[0]->nombres. ' '. $info_cliente[0]->apellidos;
            echo json_encode($respuesta);
        }
    }

    public function agregar_nuevo_cargo(){
        $id_cliente = $this->input->post('id_cliente');
        $concepto = $this->input->post('concepto');
        $metodo_pago = $this->input->post('metodo_pago');
        $cantidad = $this->input->post('cantidad');
        $direccion = json_decode($this->input->post('direccion_cliente'));
        $id_pedido = $this->input->post('num_pedido');

        if($metodo_pago == 'card_payment'){
            $this->enviar_correo_tarjeta($id_cliente, $concepto, $cantidad, $direccion->id_direccion, $id_pedido);
        }elseif ($metodo_pago == 'cash_payment'){
            $this->pagar_oxxo($id_cliente, $concepto, $cantidad, $direccion, $id_pedido);
        }elseif ($metodo_pago == 'spei'){
            $this->pagar_spei($id_cliente, $concepto, $cantidad, $direccion, $id_pedido);
        }
    }

    public function desplegar_cargos(){
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');
        $orden = $this->input->post('order');
        $cargos = $this->cargos_extra_m->obtener_cargos_datatable($limit, $offset, $orden, $search);
        $info = new stdClass();
        $info->draw = $this->input->post('draw');
        $info->recordsTotal = $this->cargos_extra_m->contar_cargos_datatable(null);
        $info->recordsFiltered = $this->cargos_extra_m->contar_cargos_datatable($search);
        $info->data = array();

        foreach($cargos as $cargo){
            $inner_info = new stdClass();
            //$inner_info->id_cargo
            $inner_info->id_cargo .= "<div class='text-center'>".$cargo->id_cargo."</div>";
            //$inner_info->id_pedido
            $inner_info->id_pedido .= "<div class='text-center'>".$cargo->id_pedido."</div>";
            //$inner_info->cliente
            $inner_info->cliente .= $cargo->nombres." ". $cargo->apellidos;
            //$inner_info->fecha
            $inner_info->fecha .= date("Y/m/d H:i", strtotime($cargo->fecha_creacion));
            //$inner_info->total
            $inner_info->total .= "$".$cargo->total;
            //$inner_info->metodo_pago
            if($cargo->metodo_pago == 'card_payment') {
                $inner_info->metodo_pago .= '<span class="hide">Tarjeta</span><img class="payimg" src="'.site_url('assets/images/visa_mc_amex.svg').'" alt="Tarjeta" />';
            } else if($cargo->metodo_pago == 'cash_payment') {
                $inner_info->metodo_pago .= '<span class="hide">OXXO</span><img class="payimg" src="'.site_url('assets/images/oxxo.svg').'" alt="OXXO" />';
            } else if($cargo->metodo_pago == 'spei') {
                $inner_info->metodo_pago .= '<span class="hide">SPEI</span><img class="payimg" src="'.site_url('assets/nimages/spei.png').'" alt="SPEI" />';
            }
            //$inner_info->estatus
            $inner_info->estatus .= "<div class='text-center'>";
            if($cargo->estatus_pago != 'Cancelado' && $cargo->estatus_pago != 'Cancelado por fraude') {
                $inner_info->estatus .= ($cargo->estatus_pago == 'paid' ? '<i class="fa fa-check"></i> <span style="display:block;">Completo</span>' : '<i class="fa fa-cog fa-spin fa-fw" style="color:#ffa05a"></i> <span style="display:block;">Pendiente</span>');
            } else {
                $inner_info->estatus .='<i class="fa fa-times"></i> <span style="display:block;">Cancelado</span>';
            }
            $inner_info->estatus .= "</div>";

            array_push($info->data, $inner_info);
        }
        echo json_encode($info);
    }

    private function pagar_spei($id_cliente, $concepto, $cantidad, $direccion, $id_pedido){
        // Inicializar Sendgrid
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        // Inicializar Conekta
        \Conekta\Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
        \Conekta\Conekta::setLocale('es');
        \Conekta\Conekta::setApiVersion("2.0.0");

        $forma_pago = 'spei';
        $reference_id = "PTOME-".strtoupper($forma_pago)."-".date("YmdHis")."-".$id_cliente;

        $cliente = $this->db->get_where('Clientes', array('id_cliente' => $id_cliente))->row();

        // Crear un array con los items para mandar a Conekta
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
                    'unit_price' => number_format($cantidad, 2, '.', '') * 100,
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
                    'amount' => number_format($cantidad, 2, '.', '') * 100,
                    'payment_method' => array(
                        'type' => 'spei',
                        'expires_at' => strtotime(date("Y-m-d H:i:s", strtotime("+120 hours")))
                    )
                )
            )
        );
        try {
            // Funcion de cargo, si es exitoso todo se ejecuta aqui
            $orden = \Conekta\Order::create($info_cargo);
            // Guardar pedido en la base de datos
            $referencia_pago = $orden->charges[0]->payment_method->receiving_account_number;
            $datos_cargo = $this->guardar_cargo_extra($orden, 'spei', $referencia_pago, $id_cliente, $concepto, $cantidad, $cliente->email, $id_pedido);
            $id_cargo = $datos_cargo->id_cargo;

            // Preparar la información de los correos
            $datos_correo                = new stdClass();
            $datos_correo->total_pedido  = $datos_cargo->total;
            $datos_correo->banco         = $orden->charges[0]->payment_method->receiving_account_bank;
            $datos_correo->referencia    = $orden->charges[0]->payment_method->receiving_account_number;
            $datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
            $datos_correo->nombres       = $cliente->nombres;
            $datos_correo->apellidos     = $cliente->apellidos;
            $datos_correo->email         = $cliente->email;

            $email_oxxo = new SendGrid\Email();
            $email_oxxo->addTo($datos_correo->email, $datos_correo->nombre)
                ->setFrom('fabiola.medina@verticalknits.com')
                ->setFromName('printome.mx')
                ->setSubject('Ficha de transferencia SPEI | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_stub_spei_extra', $datos_correo, TRUE));
            $sendgrid->send($email_oxxo);

            $email_omar = new SendGrid\Email();
            $email_omar->addTo('fabiola.medina@verticalknits.com', 'Administración Printome')
                ->setFrom('no-reply@printome.mx')
                ->setFromName('Tienda en línea printome.mx')
                ->setSubject('Se ha generado un nuevo cargo de SPEI | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/admin_aviso_ficha_spei_extra', $datos_correo, TRUE));
            $sendgrid->send($email_omar);

            $this->session->set_flashdata(number_format($cantidad, 2, '.', ''));
            $this->session->set_flashdata('tracking_id_pedido', $id_cargo);

            ac_agregar_etiqueta($datos_correo->email, 'pedido-completado-spei');
            ac_quitar_etiqueta($datos_correo->email, 'error-pago-spei');

            redirect('administracion/cargos_extra');

        } catch (\Conekta\ProccessingError $error) {
            $this->session->set_flashdata('error_pago', $error);
            $this->bugsnag->notifyError('Error de procesamiento SPEI', $error);
            ac_agregar_etiqueta($datos_correo->email, 'pedido-completado-spei');
            ac_quitar_etiqueta($datos_correo->email, 'error-pago-spei');
            redirect('administracion/cargos_extra');
        } catch (\Conekta\ParameterValidationError $error) {
            $this->session->set_flashdata('error_pago', $error);
            $this->bugsnag->notifyError('Error de validación SPEI', $error);
            ac_agregar_etiqueta($datos_correo->email, 'pedido-completado-spei');
            ac_quitar_etiqueta($datos_correo->email, 'error-pago-spei');
            redirect('administracion/cargos_extra');
        } catch (\Conekta\Handler $error) {
            $this->session->set_flashdata('error_pago', $error);
            $this->bugsnag->notifyError('Error de manejo SPEI', $error);
            ac_agregar_etiqueta($datos_correo->email, 'pedido-completado-spei');
            ac_quitar_etiqueta($datos_correo->email, 'error-pago-spei');
            redirect('administracion/cargos_extra');
        }
    }

    private function pagar_oxxo($id_cliente, $concepto, $cantidad, $direccion, $id_pedido){
        // Inicializar Sendgrid
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        // Inicializar Conekta
        \Conekta\Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
        \Conekta\Conekta::setLocale('es');
        \Conekta\Conekta::setApiVersion("2.0.0");

        $forma_pago = 'oxxo';
        $reference_id = "PTOME-".strtoupper($forma_pago)."-".date("YmdHis")."-".$id_cliente;

        $cliente = $this->cargos_extra_m->obtener_cliente($id_cliente);

        // Crear un array con los items para mandar a Conekta
        $info_cargo = array(
            'currency' => 'MXN',
            'description' => $concepto,
            'customer_info' => array(
                'name' => $cliente->nombres.' '.$cliente->apellidos,
                'email' => $cliente->email,
                'phone' => $cliente->telefono
            ),
            'line_items' => array(
                array(
                    'name' => 'Cargo Extra',
                    'unit_price' => number_format($cantidad, 2, '.', '') * 100,
                    'quantity' => 1
                )
            ),
            'shipping_contact' => array(
                'receiver' => $cliente->nombres.' '.$cliente->apellidos,
                'phone' => $cliente->telefono,
                'address' => array(
                    'street1' => $direccion->linea1,
                    'street2' => $direccion->linea2,
                    'city' => $direccion->ciudad,
                    'state' => $direccion->estado,
                    'postal_code' => $direccion->codigo_postal,
                    'country' => 'MX'
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
                    'amount' => number_format($cantidad, 2, '.', '') * 100,
                    'payment_method' => array(
                        'type' => 'oxxo_cash',
                        'expires_at' => strtotime(date("Y-m-d H:i:s", strtotime("+120 hours")))
                    )
                )
            )
        );

        try {
            // Funcion de cargo, si es exitoso todo se ejecuta aqui
            $orden = \Conekta\Order::create($info_cargo);
            $referencia_pago = $orden->charges[0]->payment_method->reference;
            $datos_cargo = $this->guardar_cargo_extra($orden, 'cash_payment', $referencia_pago, $id_cliente, $concepto, $cantidad, $cliente->email, $id_pedido);
            $id_cargo = $datos_cargo->id_cargo;

            // Preparar la información de los correos
            $datos_correo                = new stdClass();
            $datos_correo->total_pedido  = number_format($cantidad, 2, '.', '');
            $datos_correo->referencia_oxxo = $orden->charges[0]->payment_method->reference;
            $datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
            $datos_correo->nombres       = $cliente->nombres;
            $datos_correo->apellidos     = $cliente->apellidos;
            $datos_correo->email         = $cliente->email;

            $email_oxxo = new SendGrid\Email();
            $email_oxxo->addTo($datos_correo->email, $datos_correo->nombre)
                ->setFrom('fabiola.medina@verticalknits.com')
                ->setFromName('printome.mx')
                ->setSubject('Ficha de pago en OXXO | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_stub_oxxo_extra', $datos_correo, TRUE));
            $sendgrid->send($email_oxxo);

            $email_omar = new SendGrid\Email();
            $email_omar->addTo('fabiola.medina@verticalknits.com', 'Administración Printome')
                ->setFrom('no-reply@printome.mx')
                ->setFromName('Tienda en línea printome.mx')
                ->setSubject('Se ha generado un nuevo cargo en OXXO | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/admin_aviso_ficha_oxxo_extra', $datos_correo, TRUE));
            $sendgrid->send($email_omar);

            $this->session->set_flashdata(number_format($cantidad, 2, '.', ''));
            $this->session->set_flashdata('tracking_id_pedido', $id_cargo);

            ac_agregar_etiqueta($datos_correo->email, 'pedido-completado-oxxo');
            ac_quitar_etiqueta($datos_correo->email, 'error-pago-oxxo');

            redirect('administracion/cargos_extra');

        } catch (\Conekta\ProccessingError $error) {
            $this->session->set_flashdata('error_pago', $error);
            $this->bugsnag->notifyError('Error de pago OXXO', $error);
            ac_agregar_etiqueta($cliente->email, 'pedido-completado-oxxo');
            ac_quitar_etiqueta($cliente->email, 'error-pago-oxxo');
            redirect('administracion/cargos_extra');
        } catch (\Conekta\ParameterValidationError $error) {
            $this->session->set_flashdata('error_pago', $error);
            $this->bugsnag->notifyError('Error de validación OXXO', $error);
            ac_agregar_etiqueta($cliente->email, 'pedido-completado-oxxo');
            ac_quitar_etiqueta($cliente->email, 'error-pago-oxxo');
            redirect('administracion/cargos_extra');
        } catch (\Conekta\Handler $error) {
            $this->session->set_flashdata('error_pago', $error);
            $this->bugsnag->notifyError('Error de manejo OXXO', $error);
            ac_agregar_etiqueta($cliente->email, 'pedido-completado-oxxo');
            ac_quitar_etiqueta($cliente->email, 'error-pago-oxxo');
            redirect('administracion/cargos_extra');
        }
    }

    private function enviar_correo_tarjeta($id_cliente, $concepto, $cantidad, $id_direccion, $id_pedido){
        //meter a la bd un pago preliminar
        $id_pago_tarjeta = uniqid("CE", true);
        $cargo = array(
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "fecha_pago" => NULL,
            "estatus_pago" => 'por_realizar',
            "concepto" => $concepto,
            "id_pago" => NULL,
            "metodo_pago" => 'card_payment',
            "referencia_pago" => NULL,
            "total" => number_format($cantidad, 2, '.', ''),
            "id_cliente" => $id_cliente,
            "id_pago_tarjeta" => $id_pago_tarjeta,
            "id_pedido" => $id_pedido
        );
        $this->db->insert("CargosExtra", $cargo);
        $fecha = new DateTime();
        $timestamp_actual = $fecha->getTimestamp();
        $url_cargo = site_url("cargos-extra/pagar/".md5($id_cliente)."/".$timestamp_actual."/".md5($id_pago_tarjeta)."/".md5($id_direccion));
        // Inicializar Sendgrid
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        $cliente = $this->cargos_extra_m->obtener_cliente($id_cliente);

        // Preparar la información de los correos
        $datos_correo                = new stdClass();
        $datos_correo->total_pedido  = number_format($cantidad, 2, '.', '');
        $datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
        $datos_correo->nombres       = $cliente->nombres;
        $datos_correo->concepto      = $concepto;
        $datos_correo->link          = $url_cargo;
        $datos_correo->apellidos     = $cliente->apellidos;
        $datos_correo->email         = $cliente->email;

        // Email de aviso de la compra
        $email_compra = new SendGrid\Email();
        $email_compra->addTo($datos_correo->email, $datos_correo->nombre)
            ->setFrom('administracion@printome.mx')
            ->setReplyTo('hello@printome.mx')
            ->setFromName('printome.mx')
            ->setSubject('Enlace cargo extra | printome.mx')
            ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_extra_tarjeta_link', $datos_correo, TRUE));
        $sendgrid->send($email_compra);

        redirect('administracion/cargos_extra');

    }

    private function guardar_cargo_extra($orden, $metodo_pago, $referencia_pago, $id_cliente, $concepto, $cantidad, $email, $id_pedido){
        // Formar pedido
        if($metodo_pago == 'cash_payment' || $metodo_pago == 'spei') {
            $cargo = array(
                "fecha_creacion" => date("Y-m-d H:i:s", $orden->created_at),
                "fecha_pago" => date("Y-m-d H:i:s", $orden->updated_at),
                "estatus_pago" => $orden->payment_status,
                "concepto" => $concepto,
                "id_pago" => $orden->id,
                "metodo_pago" => $metodo_pago,
                "referencia_pago" => $referencia_pago,
                "fecha_vencimiento_oxxo_spei" => date("Y-m-d H:i:s", $orden->charges[0]->payment_method->expires_at),
                "total" => number_format($cantidad, 2, '.', ''),
                "id_cliente" => $id_cliente,
                "id_pedido" => $id_pedido
            );
        }else{
            $cargo = array(
                "fecha_creacion" => date("Y-m-d H:i:s", $orden->created_at),
                "fecha_pago" => date("Y-m-d H:i:s", $orden->updated_at),
                "estatus_pago" => $orden->payment_status,
                "concepto" => $concepto,
                "id_pago" => $orden->id,
                "metodo_pago" => $metodo_pago,
                "referencia_pago" => $referencia_pago,
                "fecha_vencimiento_oxxo_spei" => date("Y-m-d H:i:s", $orden->charges[0]->payment_method->expires_at),
                "total" => number_format($cantidad, 2, '.', ''),
                "id_cliente" => $id_cliente,
                "id_pedido" => $id_pedido
            );
        }

        $this->db->insert("CargosExtra", $cargo);
        $id_cargo = $this->db->insert_id();

        $cliente_ac = $this->active->obtener_clientes(array('email' => $email, 'connectionid' => 1));

        if(!isset($cliente_ac->ecomCustomers[0]->id)) {
            $this->active->crear_cliente(1, $id_cliente, $email);
        }

        // Guardar pedido en active campaign
        $cargo_para_ac = $this->cargos_extra_m->obtener_cargo_especifico($id_cargo);
        $cliente_ac = $this->active->obtener_clientes(array('email' => $email, 'connectionid' => 1));
        $this->active->crear_cargo(1, $cliente_ac->ecomCustomers[0]->id, 1 /* 0 - sync, 1 - live */, $cargo_para_ac);

        $datos_pedido = new stdClass();
        $datos_pedido->id_pedido = $id_cargo;
        $datos_pedido->total = $cantidad;

        return $datos_pedido;
    }
}