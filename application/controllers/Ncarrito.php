<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ncarrito extends MY_Controller {

    public $datos = array();

    public function __construct()
    {
        parent::__construct();
    }

    /*
    * este paso es cuando el usuario llega a ver su carrito
    */
    public function index($nombre_tienda_slug = null) {

        if($nombre_tienda_slug) {
            if (strpos(uri_string(), 'carrito') !== false && strpos(uri_string(), 'carrito/vacio') === false &&  $this->cart->total_items() == 0) {
                redirect('tienda/'.$nombre_tienda_slug.'/carrito/vacio');
            }
        } else {
            if(uri_string() == 'carrito' && $this->cart->total_items() == 0) {
                ac_actualizar_total_persona($email_persona, 0);
                redirect('carrito/vacio');
            }
        }

        // Config
        $datos_header['seccion_activa'] = 'carrito';
        $datos_header['nombre_tienda_slug'] = $nombre_tienda_slug;
        if($nombre_tienda_slug) {
            $datos_header['tienda'] = $this->tienda_m->obtener_tienda_por_id_dueno($this->tienda_m->obtener_id_dueno($nombre_tienda_slug));
            $datos_header['meta']['title'] = 'Carrito de compras | '.$datos_header['tienda']->nombre_tienda;
            $datos_header['meta']['description'] = 'Tu carrito diseña y personaliza tu producto en línea, envío exprés a todo México. | '.$datos_header['tienda']->nombre_tienda;
        } else {
            $datos_header['meta']['title'] = 'Tu carrito de compras | printome.mx';
            $datos_header['meta']['description'] = 'Tu carrito - diseña y personaliza tu producto en línea, envío exprés a todo México.';
        }

        $datos_header['meta']['imagen'] = '';
        $datos_header['recibir'] = fecha_recepcion(date("N"));
        $datos_footer['scripts'] = 'nuevo_carrito/ajax_ac';

        if(isset($datos_header['tienda'])) {
            $this->load->view('tienda/header', $datos_header);
        } else {
            $this->load->view('header', $datos_header);
        }
        if($this->cart->total_items() > 0) {
            $this->load->view('nuevo_carrito/despliegue');
        } else {
            $this->load->view('nuevo_carrito/vacio');
        }
        //$this->load->view('inicio/loquedicen');

        if(isset($datos_header['tienda'])) {
            $this->load->view('footer', $datos_footer);
        } else {
            $this->load->view('footer', $datos_footer);
        }
    }

    public function post_total_ac(){
        if($this->session->has_userdata('login')) {
            ac_actualizar_total_persona($this->session->login['email'], $this->cart->obtener_total());
        }
        if($this->session->has_userdata('correo_temporal')) {
            ac_actualizar_total_persona($this->session->correo_temporal, $this->cart->obtener_total());
        }
    }

    /*
    * este paso se despliega al terminar la compra-segura
    */
    public function pedido_completado($metodo_pago, $nombre_tienda_slug = null)
    {
        // Config
        $datos_header['seccion_activa'] = 'carrito';
        $datos_header['nombre_tienda_slug'] = $nombre_tienda_slug;
        if($nombre_tienda_slug) {
            $datos_header['tienda'] = $this->tienda_m->obtener_tienda_por_id_dueno($this->tienda_m->obtener_id_dueno($nombre_tienda_slug));
            $datos_header['meta']['title'] = '¡Gracias por su compra! | '.$datos_header['tienda']->nombre_tienda;
            $datos_header['meta']['description'] = 'Tu carrito diseña y personaliza tu producto en línea, envío exprés a todo México. | '.$datos_header['tienda']->nombre_tienda;
        } else {
            $datos_header['meta']['title'] = '¡Gracias por tu compra! | printome.mx';
            $datos_header['meta']['description'] = '¡Gracias por comprar en printome, donde puedes diseñar y personalizar tu producto en línea, envío exprés a todo México!';
        }

        $datos_header['meta']['imagen'] = '';
        $datos_header['recibir'] = fecha_recepcion(date("N"));
        $datos_header['metodo_pago'] = $metodo_pago;

        if(isset($datos_header['tienda'])) {
            $this->load->view('tienda/header', $datos_header);
        } else {
            $this->load->view('header', $datos_header);
        }
        $this->load->view('nuevo_carrito/carrito_paso_3_agradecimiento');
        //$this->load->view('inicio/loquedicen');

        if(isset($datos_header['tienda'])) {
            $this->load->view('footer');
        } else {
            $this->load->view('footer');
        }
    }

    /*
    * este paso es cuando el usuario llega a la parte de seleccionar su carrito
    */
    public function direccion($nombre_tienda_slug = null) {

        if($nombre_tienda_slug) {
            if($this->cart->total_items() == 0) {
                redirect('tienda/'.$nombre_tienda_slug.'/carrito/vacio');
            }
        } else {
            if($this->cart->total_items() == 0) {
                redirect('carrito/vacio');
            }
        }
        // Config
        $datos_header['seccion_activa'] = 'carrito';
        $datos_header['nombre_tienda_slug'] = $nombre_tienda_slug;
        if($nombre_tienda_slug) {
            $datos_header['tienda'] = $this->tienda_m->obtener_tienda_por_id_dueno($this->tienda_m->obtener_id_dueno($nombre_tienda_slug));
            $datos_header['meta']['title'] = 'Selecciona tu dirección | '.$datos_header['tienda']->nombre_tienda;
            $datos_header['meta']['description'] = 'Tu carrito diseña y personaliza tu producto en línea, envío exprés a todo México. | '.$datos_header['tienda']->nombre_tienda;
        } else {
            $datos_header['meta']['title'] = 'Selecciona tu dirección de envío | printome.mx';
            $datos_header['meta']['description'] = 'Selecciona la dirección de envío para tu compra - diseña y personaliza tu producto en línea, envío exprés a todo México.';
        }
        $datos_header['meta']['imagen'] = '';
        $datos_header['recibir'] = fecha_recepcion(date("N"));
        $footer_datos['scripts'] = 'nuevo_carrito/direcciones/script_direccion';

        $datos_header['is_client'] = !is_null($this->session->login['id_cliente']);
        if($datos_header['is_client']) {
            $datos_header['direcciones'] = $this->cuenta_modelo->obtener_direcciones($this->session->login['id_cliente']);
            $datos_header['direcciones_fiscales'] = $this->cuenta_modelo->obtener_direcciones_fiscales($this->session->login['id_cliente']);
        }

        $log = new stdClass();
        if($datos_header['is_client']) {
            $log->id_cliente = $this->session->login['id_cliente'];
        }else{
            $log->id_cliente = 0;
        }
        $log->proceso = 'Seleccionar dirección';
        $this->db->insert('Log_proceso', $log);


        if(isset($datos_header['tienda'])) {
            $this->load->view('tienda/header', $datos_header);
        } else {
            $this->load->view('header', $datos_header);
        }
        $this->load->view('nuevo_carrito/carrito_paso_1_datos_generales');
        //$this->load->view('inicio/loquedicen');

        if(isset($datos_header['tienda'])) {
            $this->load->view('footer', $footer_datos);
        } else {
            $this->load->view('footer', $footer_datos);
        }
    }

    public function obtener_datos_direccion(){
        $codigo_postal = $this->input->get('codigo_postal');
        $datos_direcciones = $this->asentamientos_m->obtener_cp_ciudades_estados($codigo_postal);
        echo json_encode($datos_direcciones);
    }

    /*
    * este es el ajax que se usa para actualizar la dirección en sesión
    */
    public function sesion_direccion()
    {
        if($this->input->post('direccion')) {
            $direccion = $this->input->post('direccion');
            $this->session->set_userdata('direccion_temporal', $direccion);

            if(isset($this->input->post('direccion')['id_direccion'])) {
                $this->session->set_userdata('id_direccion_pedido', $this->input->post('direccion')['id_direccion']);
            }
        }

        if($this->input->post('cancelar_direccion_fiscal') == 1) {
            $this->session->unset_userdata('direccion_fiscal_temporal');

        } else {
            if($this->input->post('direccion_fiscal')) {
                $direccion_fiscal = $this->input->post('direccion_fiscal');
                $this->session->set_userdata('direccion_fiscal_temporal', $direccion_fiscal);

                if(isset($this->input->post('direccion_fiscal')['id_direccion_fiscal'])) {
                    $this->session->set_userdata('id_direccion_fiscal_pedido', $this->input->post('direccion_fiscal')['id_direccion_fiscal']);
                }
            }
        }
    }

    /*
    * esta funcion checa si el usuario ya está en sesión y si no, crea un nuevo usuario
    * lo registra, inicia sesión y ya tiene dados de alta su dirección y datos fiscales
    */
    public function procesar_direccion($nombre_tienda_slug = null)
    {
        $direccion = json_decode($this->input->post('direccion'), true);
        $redireccion = new stdClass();

        if (!$this->session->has_userdata('login')) {
            if (trim($direccion['nombre']) == '' || trim($direccion['apellidos']) == ''
                || trim($direccion['email']) == '' || trim($direccion['telefono']) == ''
                || trim($direccion['telefono']) == '' || trim($direccion['codigo_postal']) == ''
                || trim($direccion['linea1']) == '' || trim($direccion['linea2']) == ''
                || trim($direccion['ciudad']) == '' || trim($direccion['estado']) == '') {
                $this->session->set_flashdata('error_direccion', 'Hay problemas con los datos de la dirección, por favor revisa el formulario e intenta nuevamente.');
                $redireccion->error = true;
                $redireccion->url = site_url(($nombre_tienda_slug ? 'tienda/' . $nombre_tienda_slug . '/' : '') . 'carrito/seleccionar-direccion');
                $redireccion->login = false;
                $redireccion->nueva_dir = true;
            }

            $email = $direccion['email'];
            $name = $direccion['nombre'];

            // Checamos si existe el cliente
            $cliente_res = $this->db->get_where('Clientes', array('email' => $email));
            $usuario = $cliente_res->row();

            if (!is_null($usuario)) {
                // Si existe, el id_cliente es el del existente
                $id_cliente = $usuario->id_cliente;
            } else {
                // Si no existe, creamos uno nuevo
                $password_puro = uniqid();

                $usuario = new stdClass();
                $usuario->nombres = $direccion['nombre'];
                $usuario->apellidos = $direccion['apellidos'];
                $usuario->email = $direccion['email'];
                $usuario->password = $this->encryption->encrypt($password_puro);
                $usuario->fecha_registro = date('Y-m-d H:i:s');
                $usuario->token_activacion_correo = 'activado';
                $usuario->telefono = $direccion['telefono'];
                $usuario->fecha_nacimiento = NULL;
                $usuario->genero = 'X';

                $this->db->insert('Clientes', $usuario);
                $id_cliente = $this->db->insert_id();

                $tienda = new stdClass();
                $tienda->nombre_tienda = 'Tienda de ' . $usuario->nombres;
                $tienda->nombre_tienda_slug = uniqid($id_cliente, true);
                $tienda->descripcion_tienda = 'Esta es la tienda de ' . $usuario->nombres;
                $tienda->id_cliente = $id_cliente;

                $this->db->insert('Tiendas', $tienda);

                // Se registra usuario en active campaign
                $contact = array(
                    "email" => $usuario->email,
                    "first_name" => $usuario->nombres,
                    "last_name" => $usuario->apellidos,
                    "phone" => $usuario->telefono,
                    "p[16]" => "16",
                    "status[16]" => 1,
                    "tags" => "registro-durante-compra, bienvenida-pendiente",
                    "field[5,0]" => $password_puro
                );
                $contact_sync = $this->ac->api("contact/sync", $contact);
            }

            $usuario_nuevo['login'] = array(
                'id_cliente' => $id_cliente,
                'nombre' => $usuario->nombres,
                'apellidos' => $usuario->apellidos,
                'email' => $usuario->email,
                'telefono' => $usuario->telefono,
                'logged_in' => TRUE,
                'facebook' => FALSE
            );

            $this->cart_modelo->mezclar_carrito($id_cliente);

            $this->session->set_userdata($usuario_nuevo);
            if ($this->session->has_userdata('correo_temporal')) {
                $this->cart_modelo->borrar_carrito_invitado($this->session->correo_temporal);
                $this->session->unset_userdata('correo_temporal');
            }
        } else {
            $id_cliente = $this->session->login['id_cliente'];
            $redireccion->error = false;
            $redireccion->login = true;
        }

        /*$cliente_ac = $this->active->obtener_clientes(array('email' => $this->session->login['email'], 'connectionid' => 1));

        if (!isset($cliente_ac->ecomCustomers[0]->id)) {
            $this->active->crear_cliente(1, $this->session->login['id_cliente'], $this->session->login['email']);
        }*/

        if (!isset($direccion['id_direccion'])) {
            $nueva_direccion = array();
            $nueva_direccion['identificador_direccion'] = (isset($direccion['identificador_direccion']) ? $direccion['identificador_direccion'] : 'Principal');
            $nueva_direccion['linea1'] = $direccion['linea1'];
            if ($direccion['linea2'] == "Otro") {
                if (trim($direccion['linea2_otro']) == '') {
                    $this->session->set_flashdata('error_direccion', 'Hay problemas con los datos de la dirección, por favor revisa el formulario e intenta nuevamente.');
                    redirect(($nombre_tienda_slug ? 'tienda/' . $nombre_tienda_slug . '/' : '') . 'carrito/seleccionar-direccion');
                }else {
                    $nueva_direccion['linea2'] = $direccion['linea2_otro'];
                }
            } else {
                $nueva_direccion['linea2'] = $direccion['linea2'];
            }
            $nueva_direccion['codigo_postal'] = $direccion['codigo_postal'];
            $nueva_direccion['ciudad'] = $direccion['ciudad'];
            $nueva_direccion['estado'] = $direccion['estado'];
            $nueva_direccion['telefono'] = $direccion['telefono'];
            $nueva_direccion['tipo_telefono'] = $direccion['tipo_tel'];
            $nueva_direccion['pais'] = 'México';
            $nueva_direccion['id_cliente'] = $id_cliente;
            $nueva_direccion['fecha_creacion'] = date('Y-m-d H:i:s');

            $this->db->insert('DireccionesPorCliente', $nueva_direccion);
            $nueva_direccion['id_direccion'] = $this->db->insert_id();

            $this->session->set_userdata('direccion_temporal', $nueva_direccion);

            $this->session->set_userdata('id_direccion_pedido', $nueva_direccion['id_direccion']);

            $redireccion->error = false;
            $redireccion->url = site_url(($nombre_tienda_slug ? 'tienda/' . $nombre_tienda_slug . '/' : '') . 'carrito/pagar');
            $redireccion->nueva_dir = true;
        } else {
            if ($direccion['id_direccion'] != '') {
                $id_direccion = $direccion['id_direccion'];
                $this->session->set_userdata('id_direccion_pedido', $id_direccion);

                $redireccion->error = false;
                $redireccion->url = site_url(($nombre_tienda_slug ? 'tienda/' . $nombre_tienda_slug . '/' : '') . 'carrito/pagar');
                $redireccion->nueva_dir = false;
            } else {
                $this->session->set_flashdata('error_direccion', 'Hay problemas con los datos de la dirección, por favor revisa el formulario e intenta nuevamente.');

                $redireccion->error = true;
                $redireccion->url = site_url(($nombre_tienda_slug ? 'tienda/' . $nombre_tienda_slug . '/' : '') . 'carrito/seleccionar-direccion');
                $redireccion->nueva_dir = true;
                //redirect(($nombre_tienda_slug ? 'tienda/' . $nombre_tienda_slug . '/' : '') . 'carrito/seleccionar-direccion');
            }
        }

        $direccion_f = json_decode($this->input->post('direccion_fiscal'), true);
        if ($direccion_f != '') {
            if ($direccion_f['id_direccion_fiscal'] != '') {
                $id_direccion_fiscal = $direccion_f['id_direccion_fiscal'];
                $this->session->set_userdata('id_direccion_fiscal_pedido', $id_direccion_fiscal);
            } else {

                $nueva_direccion_fiscal = array();
                $nueva_direccion_fiscal['razon_social'] = $direccion_f['razon_social'];
                $nueva_direccion_fiscal['rfc'] = $direccion_f['rfc'];
                $nueva_direccion_fiscal['linea1'] = $direccion_f['linea1'];
                $linea2 = $direccion_f['linea2'];
                if ($linea2 == "Otro") {
                    $nueva_direccion_fiscal['linea2'] = $direccion_f['linea2_otro'];
                } else {
                    $nueva_direccion_fiscal['linea2'] = $linea2;
                }
                $nueva_direccion_fiscal['codigo_postal'] = $direccion_f['codigo_postal'];
                $nueva_direccion_fiscal['ciudad'] = $direccion_f['ciudad'];
                $nueva_direccion_fiscal['estado'] = $direccion_f['estado'];
                $nueva_direccion_fiscal['telefono'] = $direccion_f['telefono'];
                $nueva_direccion_fiscal['correo_electronico_facturacion'] = $direccion_f['correo_electronico_facturacion'];
                $nueva_direccion_fiscal['pais'] = 'México';
                $nueva_direccion_fiscal['id_cliente'] = $id_cliente;
                $nueva_direccion_fiscal['fecha_creacion'] = date('Y-m-d H:i:s');

                $this->db->insert('DireccionesFiscalesPorCliente', $nueva_direccion_fiscal);
                $nueva_direccion_fiscal['id_direccion_fiscal'] = $this->db->insert_id();

                $this->session->set_userdata('direccion_fiscal_temporal', $nueva_direccion_fiscal);

                $this->session->set_userdata('id_direccion_fiscal_pedido', $nueva_direccion_fiscal['id_direccion_fiscal']);
            }
        }
        if($redireccion->error === false){
            $log = new stdClass();
            if($id_cliente) {
                $log->id_cliente = $this->session->login['id_cliente'];
            }else{
                $log->id_cliente = 0;
            }
            $log->proceso = 'Seleccionar método de pago';
            $this->db->insert('Log_proceso', $log);
        }
        echo json_encode($redireccion);
    }

    /*
    * funcion para actualizar los items del carrito
    */
    public function actualizar($nombre_tienda_slug = null)
    {
        $data = $this->input->post();

        $this->cart->update($data);
        //Si hay sesión activa se actualiza el carrito en la base de datos
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

    /*
    * funcion para vaciar el carrito
    */
    public function vaciar($nombre_tienda_slug = null) {
        $this->cart->destroy();

        $this->session->unset_userdata('envio_gratis');
        $this->session->unset_userdata('direccion_temporal');
        $this->session->unset_userdata('direccion_fiscal_temporal');
        $this->session->unset_userdata('descuento_global');
        $this->session->unset_userdata('diseno_temp');
        $this->session->unset_userdata('id_direccion_pedido');

        $id_cliente = $this->session->login['id_cliente'];
        $es_cliente = (!is_null($id_cliente));
        if($es_cliente) {
            $this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
            ac_quitar_etiqueta($this->session->login['email'], 'abandono-carrito');
            usleep(250000);
            ac_quitar_etiqueta($this->session->login['email'], 'comenzo-personalizacion');
            usleep(250000);

            $params = [
                'email' => $this->session->login['email'],
                'field[1,0]' => ''
            ];
            $persona_update = $this->ac->api('contact/sync', $params);
        }
        if($this->session->has_userdata('correo_temporal')) {
            $this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
            ac_quitar_etiqueta($this->session->correo_temporal, 'abandono-carrito');
            usleep(250000);
            ac_quitar_etiqueta($this->session->correo_temporal, 'comenzo-personalizacion');
            usleep(250000);
            $params = [
                'email' => $this->session->correo_temporal,
                'field[1,0]' => ''
            ];
            $persona_update = $this->ac->api('contact/sync', $params);
        }

        if($nombre_tienda_slug) {
            redirect('tienda/'.$nombre_tienda_slug.'/carrito');
        } else {
            redirect('carrito');
        }
    }

    /*
    * funcion para elegir metodo de pago
    */
    public function sincronizar_direccion_ac(){
        if($this->session->has_userdata('login')) {
            ac_agregar_etiqueta($this->session->login['email'], 'carrito-pagar');
            $direccion = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $this->session->id_direccion_pedido))->row();
            $campo_direccion = $direccion->linea1.', '.$direccion->linea2.
                ', CP: '.$direccion->codigo_postal.', Tel: '.$direccion->telefono.
                ', '.$direccion->ciudad.', '.$direccion->estado.', '.$direccion->pais;
            $contact = array(
                "email"              => $this->session->login['email'],
                "field[7,0]"         => $campo_direccion
            );
            $contact_sync = $this->ac->api("contact/sync", $contact);
        }
    }

    public function pagar($nombre_tienda_slug = null)
    {
        if(!$this->session->id_direccion_pedido) {
            $this->session->set_flashdata('error_direccion', 'Hay problemas con los datos de la dirección, por favor revisa el formulario e intenta nuevamente.');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/seleccionar-direccion');
        }
        if($nombre_tienda_slug) {
            if($this->cart->total_items() == 0) {
                redirect('tienda/'.$nombre_tienda_slug.'/carrito/vacio');
            }
        } else {
            if($this->cart->total_items() == 0) {
                redirect('carrito/vacio');
            }
        }

        if($this->session->has_userdata('login')) {
            ac_agregar_etiqueta($this->session->login['email'], 'carrito-pagar');
            $direccion = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $this->session->id_direccion_pedido))->row();
            $campo_direccion = $direccion->linea1.', '.$direccion->linea2.
                ', CP: '.$direccion->codigo_postal.', Tel: '.$direccion->telefono.
                ', '.$direccion->ciudad.', '.$direccion->estado.', '.$direccion->pais;
            $contact = array(
                "email"              => $this->session->login['email'],
                "field[7,0]"         => $campo_direccion
            );
            $contact_sync = $this->ac->api("contact/sync", $contact);
        }

        if($this->session->has_userdata('correo_temporal')) {
            ac_agregar_etiqueta($this->session->correo_temporal, 'carrito-pagar');
        }
        // Config
        $datos_header['seccion_activa'] = 'carrito';
        $datos_header['nombre_tienda_slug'] = $nombre_tienda_slug;
        if($nombre_tienda_slug) {
            $datos_header['tienda'] = $this->tienda_m->obtener_tienda_por_id_dueno($this->tienda_m->obtener_id_dueno($nombre_tienda_slug));
            $datos_header['meta']['title'] = 'Ya casi terminas tu compra - diseña y personaliza tu producto en línea, envío exprés a todo México. | '.$datos_header['tienda']->nombre_tienda;
        } else {
            $datos_header['meta']['title'] = '¡Ya casi terminas! | printome.mx';
            $datos_header['meta']['description'] = 'Ya casi terminas tu compra - diseña y personaliza tu producto en línea, envío exprés a todo México.';
        }

        $datos_header['meta']['imagen'] = '';
        $datos_header['recibir'] = fecha_recepcion(date("N"));
        $footer_datos['scripts'] = 'nuevo_carrito/pago/script_pago';

        if(isset($datos_header['tienda'])) {
            $this->load->view('tienda/header', $datos_header);
        } else {
            $this->load->view('header', $datos_header);
        }
//        if(!$this->session->tempdata("ganador")) {
//            $conekta = array();
//            $stripe = array();
//            for ($i = 0; $i < 500000; $i++) {
//                $random = rand(1, 2);
//                if ($random == 1) {
//                    array_push($conekta, $random);
//                } else {
//                    array_push($stripe, $random);
//                }
//            }
//            if (max($conekta, $stripe) == $conekta) {
//                $ganador = 'conekta';
//            } else {
//                $ganador = 'stripe';
//            }
//            $this->session->set_tempdata('ganador', $ganador, 300);
//        }else{
//            $ganador = $this->session->tempdata("ganador");
//        }
        $idempotency_key = uniqid("idem-order_");
        $this->load->view('nuevo_carrito/carrito_paso_2_metodos_de_pago', array('direccion_recibir' => $direccion, 'ganador' => 'ppp', 'idempotency_key' => $idempotency_key));
        //$this->load->view('inicio/loquedicen');

        if(isset($datos_header['tienda'])) {
            $this->load->view('footer', $footer_datos);
        } else {
            $this->load->view('footer', $footer_datos);
        }
    }

    /**
     * funcion para pagar con tarjeta a traves de Conekta VIEJA FUNCION DE PAGO CON TARJETA
     * SUSTITUIDA POR PAGO CON PAYPALPLUS (pagar_ppp y terminar_pago_ppp) y Stripe...
     **/
    public function pagar_tarjeta($nombre_tienda_slug = null)
    {
        $log = new stdClass();
        $id_cliente = $this->session->login['id_cliente'];
        if($id_cliente) {
            $log->id_cliente = $id_cliente;
        }else{
            $log->id_cliente = 0;
        }
        $log->proceso = 'Pagar tarjeta';
        $this->db->insert('Log_proceso', $log);
        // Inicializar Sendgrid
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        // Inicializar Conekta
        \Conekta\Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
        \Conekta\Conekta::setLocale('es');
        \Conekta\Conekta::setApiVersion("2.0.0");
        // Recibir token de Conekta
        $token_card = $this->input->post('conektaTokenId');

        $cliente = $this->db->get_where('Clientes', array('id_cliente' => $this->session->login['id_cliente']))->row();
        $direccion = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $this->session->id_direccion_pedido))->row();
        if($this->session->has_userdata('id_direccion_fiscal_pedido')) {
            $direccion_fiscal = $this->db->get_where('DireccionesFiscalesPorCliente', array('id_direccion_fiscal' => $this->session->id_direccion_fiscal_pedido))->row();
        }

        $forma_pago = 'tdc';
        $reference_id = "PTOME-".strtoupper($forma_pago)."-".date("YmdHis")."-".$this->session->login['id_cliente'];

        // Crear un array con los items para mandar a Conekta
        $items = $this->agrupar_items_conekta();

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
            'line_items' => $items,
            'shipping_lines' => array(
                array(
                    'amount' => $this->cart->obtener_costo_envio()*100,
                    'carrier' => 'DHL'
                )
            ),
            'charges' => array(
                array(
                    'amount' => (int)number_format($this->cart->obtener_total()*100,0,'',''),
                    'payment_method' => array(
                        'type' => 'card',
                        'token_id' => $token_card
                    )
                )
            )
        );

        $info_cargo['discount_lines'] = $this->calcular_lineas_descuento_conekta();
        if(!$info_cargo['discount_lines']) {
            unset($info_cargo['discount_lines']);
        }

        try{
            // Funcion de cargo, si es exitoso todo se ejecuta aqui
            $orden = \Conekta\Order::create($info_cargo);
            // Guardar pedido en la base de datos
            $datos_direccion_pedido = array(
                'id_direccion' => $direccion->id_direccion
            );
            if(isset($direccion_fiscal)) {
                $datos_direccion_pedido['id_direccion_fiscal'] = $direccion_fiscal->id_direccion_fiscal;
            }
            $datos_pedido = $this->guardar_pedido($orden, 'card_payment', $reference_id, $datos_direccion_pedido);
            $id_pedido = $datos_pedido->id_pedido;

            if(isset($datos_pedido->id_cupon)) {
                $cupon = $this->db->get_where('Cupones', array('id' => $this->session->descuento_global->id_cupon, 'estatus' => 1))->row();
            }

            // Preparar la información de los correos
            $datos_correo                = new stdClass();
            $datos_correo->numero_pedido = str_pad($id_pedido, 8, '0', STR_PAD_LEFT);
            $datos_correo->total_pedido  = $datos_pedido->total;
            $datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
            $datos_correo->nombres       = $cliente->nombres;
            $datos_correo->apellidos     = $cliente->apellidos;
            $datos_correo->email         = $cliente->email;
            $datos_correo->cupon         = (isset($datos_pedido->id_cupon) ? $cupon->cupon : null);
            $datos_correo->recibir       = fecha_recepcion(date("N"));

            // Email de aviso de la compra
            $email_compra = new SendGrid\Email();
            $email_compra->addTo($datos_correo->email, $datos_correo->nombre)
                ->setFrom('administracion@printome.mx')
                ->setReplyTo('hello@printome.mx')
                ->setFromName('printome.mx')
                ->setSubject('Confirmación de pago con tarjeta | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_tarjeta_confirmado', $datos_correo, TRUE));
            $sendgrid->send($email_compra);

            // Email de aviso para administracion
            $email_administracion = new SendGrid\Email();
            $email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
                ->setFrom('no-reply@printome.mx')
                ->setReplyTo('administracion@printome.mx')
                ->setFromName('Tienda en línea printome.mx')
                ->setSubject('Pago con tarjeta realizado | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/admin_confirmacion_pago_tarjeta', $datos_correo, TRUE))
                ->addAttachment('assets/pdf/'.$this->pdf_pedido_archivo($id_pedido), 'pedido_printome_'.$datos_correo->numero_pedido.'.pdf');
            $sendgrid->send($email_administracion);

            $this->session->set_flashdata('pedido_completado_metodo', "conekta");
            $this->session->set_flashdata('total_pedido', $this->cart->obtener_total());
            $this->session->set_flashdata('tracking_id_pedido', $id_pedido);
            $this->session->set_flashdata('tracking_shipping', $this->cart->obtener_costo_envio());
            $this->session->set_flashdata('tracking_iva', $this->cart->obtener_iva());

            ac_agregar_etiqueta($datos_correo->email, 'pedido-completado');
            ac_quitar_etiqueta($this->session->login['email'], 'error-pago-tarjeta');

            $this->cart->destroy();
            $this->session->unset_userdata('direccion_temporal');
            $this->session->unset_userdata('direccion_fiscal_temporal');
            $this->session->unset_userdata('descuento_global');
            $this->session->unset_userdata('envio_gratis');
            $this->session->unset_userdata('diseno_temp');
            $this->session->unset_userdata('id_direccion_pedido');
            $this->session->unset_userdata('id_direccion_fiscal_pedido');

            $this->cart_modelo->borrar_carrito($this->session->login['id_cliente']);

            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pedido-completado-tarjeta');

        } catch (\Conekta\ProccessingError $error) {
            // Error de procesamiento
            $this->bugsnag->notifyError('Error de procesamiento tarjeta', $error);
            $this->session->set_flashdata('error_pago', $error);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-tarjeta');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-tarjeta');
        } catch (\Conekta\ParameterValidationError $error) {
            // Error de validacion
            $this->bugsnag->notifyError('Error de validación tarjeta', $error);
            $this->session->set_flashdata('error_pago', $error);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-tarjeta');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-tarjeta');
        } catch (\Conekta\Handler $error) {
            // Error general
            $this->bugsnag->notifyError('Error de manejo tarjeta', $error);
            $this->session->set_flashdata('error_pago', $error);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-tarjeta');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-tarjeta');
        }
    }

    public function pagar_stripe($idempotency_key, $nombre_tienda_slug = null){
        $log = new stdClass();
        $id_cliente = $this->session->login['id_cliente'];
        if($id_cliente) {
            $log->id_cliente = $id_cliente;
        }else{
            $log->id_cliente = 0;
        }
        $log->proceso = 'Pagar stripe';
        $this->db->insert('Log_proceso', $log);
        //print_r($idempotency_key);
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);

        $stripeToken = $this->input->post("stripeToken");


        if(isset($stripeToken)) {
            $this->load->library("stripe_lib");

            $cliente = $this->db->get_where('Clientes', array('id_cliente' => $this->session->login['id_cliente']))->row();
            $direccion = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $this->session->id_direccion_pedido))->row();
            if ($this->session->has_userdata('id_direccion_fiscal_pedido')) {
                $direccion_fiscal = $this->db->get_where('DireccionesFiscalesPorCliente', array('id_direccion_fiscal' => $this->session->id_direccion_fiscal_pedido))->row();
            }

            $forma_pago = 'stripe';
            $reference_id = "PTOME-" . strtoupper($forma_pago) . "-" . date("YmdHis") . "-" . $this->session->login['id_cliente'];

            if (!$cliente->id_stripe) {
                $id_cus_stripe = $this->stripe_lib->crear_cliente($cliente, $direccion);
            } else {
                $id_cus_stripe = $cliente->id_stripe;
            }

            $item_array = array();
            $product_flashdata = array();
            foreach ($this->cart->contents() as $i => $item_cart) {
                $options = $item_cart['options'];
                if ($options['enhance']) {
                    $this->db->select("ids_stripe")
                        ->from("Enhance")
                        ->where("id_enhance", $options['id_enhance']);
                    $sku_stripe = $this->db->get()->row();
                    $sku_db = json_decode($sku_stripe->ids_stripe);

                    if (isset($sku_db->{$options['talla']})) {
                        $sku_item = $sku_db->{$options['talla']};
                    } else {
                        $sku_item = $this->stripe_lib->crear_sku_tienda($item_cart);
                        $sku_db->{$options['talla']} = $sku_item;

                        $this->db->where("id_enhance", $options['id_enhance'])
                            ->update("Enhance", array('ids_stripe' => json_encode($sku_db)));
                    }
                } else {
                    $sku_item = $this->stripe_lib->crear_sku_personalizado($item_cart);
                }

                $item = array(
                    'description' => $item_cart['name'] . ($options["enhance"] != 'enhance' ? ' personalizada' : ''),
                    'amount' => number_format($item_cart['qty'] * $item_cart['price'], 2, '', ''),
                    'currency' => 'MXN',
                    'parent' => $sku_item,
                    'type' => 'sku',
                    'quantity' => $item_cart['qty']
                );
                $product_data = new stdClass();
                if ($options['enhance']) {
                    $product_data->id_producto = $options['id_enhance'];
                }else{
                    $product_data->id_producto = "13";
                }
                $product_data->nombre_producto = $item_cart['name'];
                $product_data->numero_items = $item_cart['qty'];
                $product_data->precio = $item_cart['price'];
                array_push($item_array, $item);
                array_push($product_flashdata, $product_data);
            }

            $descuento = array(
                'description' => '',
                'amount' => 0,
                'currency' => 'MXN',
                'type' => 'discount'
            );


            if ($this->cart->obtener_saldo_a_favor() > 0) {
                if ($this->session->has_userdata('descuento_global') ) {
                    if ($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1) {
                        $descuento['amount'] = number_format((-1) * (($this->cart->obtener_subtotal() * $this->session->descuento_global->descuento) + $this->cart->obtener_saldo_a_favor()), 2, '', '');
                        $descuento['description'] = "Saldo a favor + " . $this->session->descuento_global->cupon;
                        array_push($item_array, $descuento);
                    } else {
                        $descuento['amount'] = number_format((-1) * ($this->cart->obtener_saldo_a_favor() + $this->session->descuento_global->descuento), 2, '', '');
                        $descuento['description'] = "Saldo a favor + " . $this->session->descuento_global->cupon;
                        array_push($item_array, $descuento);
                    }
                } else {
                    $descuento['amount'] = number_format((-1) * ($this->cart->obtener_saldo_a_favor()), 2, '', '');
                    $descuento['description'] = "Saldo a favor";
                    array_push($item_array, $descuento);
                }
            } else {
                if ($this->session->has_userdata('descuento_global') ) {
                    if ($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1) {
                        $descuento['amount'] = number_format((-1) * ($this->cart->obtener_subtotal() * $this->session->descuento_global->descuento), 2, '', '');
                        $descuento['description'] = $this->session->descuento_global->cupon;
                        array_push($item_array, $descuento);
                    } else {
                        $descuento['amount'] = number_format((-1) * $this->session->descuento_global->descuento, 2, '', '');
                        $descuento['description'] = $this->session->descuento_global->cupon;
                        array_push($item_array, $descuento);
                    }
                }
            }

            $envio = array(
                'description' => 'Envio',
                'amount' => number_format($this->cart->obtener_costo_envio(), 2, '', ''),
                'currency' => 'MXN',
                'type' => 'sku',
                'parent' => 'ENVIOREGULAR'
            );
            if ($envio['amount'] == 4900) {
                $envio['parent'] = 'ENVIOMID';
            }
            if ($this->session->envio_gratis == 'gratis'|| $envio['amount'] == 0) {
                $envio['description'] = "Envio Gratis";
                $envio['amount'] = 0;
                $envio['parent'] = 'ENVIOFREE';
            }
            array_push($item_array, $envio);
            try {
                $id_ord_stripe = $this->stripe_lib->crear_orden($id_cus_stripe, $item_array, $direccion, $cliente, $idempotency_key);
                $idempotency_key = str_replace("idem-order_", "idem-charge_", $idempotency_key);
                $pago_stripe = $this->stripe_lib->pagar_orden($id_ord_stripe, $stripeToken, $idempotency_key);

                $datos_direccion_pedido = array(
                    'id_direccion' => $direccion->id_direccion
                );
                if(isset($direccion_fiscal)) {
                    $datos_direccion_pedido['id_direccion_fiscal'] = $direccion_fiscal->id_direccion_fiscal;
                }
                $datos_pedido = $this->guardar_pedido($pago_stripe, 'stripe', $reference_id, $datos_direccion_pedido);
                $id_pedido = $datos_pedido->id_pedido;

                if(isset($datos_pedido->id_cupon)) {
                    $cupon = $this->db->get_where('Cupones', array('id' => $this->session->descuento_global->id_cupon, 'estatus' => 1))->row();
                }

                // Preparar la información de los correos
                $datos_correo                = new stdClass();
                $datos_correo->numero_pedido = str_pad($id_pedido, 8, '0', STR_PAD_LEFT);
                $datos_correo->total_pedido  = $datos_pedido->total;
                $datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
                $datos_correo->nombres       = $cliente->nombres;
                $datos_correo->apellidos     = $cliente->apellidos;
                $datos_correo->email         = $cliente->email;
                $datos_correo->cupon         = (isset($datos_pedido->id_cupon) ? $cupon->cupon : null);
                $datos_correo->recibir       = fecha_recepcion(date("N"));

                // Email de aviso de la compra
                $email_compra = new SendGrid\Email();
                $email_compra->addTo($datos_correo->email, $datos_correo->nombre)
                    ->setFrom('administracion@printome.mx')
                    ->setReplyTo('hello@printome.mx')
                    ->setFromName('printome.mx')
                    ->setSubject('Confirmación de pago con tarjeta | printome.mx');

                $paymentDate = date('Y-m-d');
                $paymentDate=date('Y-m-d', strtotime($paymentDate));
                $firstDateBegin = date('Y-m-d', strtotime("04/01/2020"));
                $firstDateEnd = date('Y-m-d', strtotime("05/31/2020"));
                $secondDateBegin = date('Y-m-d', strtotime("12/21/2019"));
                $secondDateEnd = date('Y-m-d', strtotime("01/07/2020"));
                if (($paymentDate >= $firstDateBegin) && ($paymentDate <= $firstDateEnd) && $envio['amount'] != 0){
                    $email_compra->setHtml($this->load->view('plantillas_correos/nuevas/ausencia_pandemia/auc_15_05_tarjeta_confirmado', $datos_correo, TRUE));
                }else if(($paymentDate >= $secondDateBegin) && ($paymentDate <= $secondDateEnd)){
                    $email_compra->setHtml($this->load->view('plantillas_correos/nuevas/ausencia_decembrina/aud_21-07_tarjeta_confirmado', $datos_correo, TRUE));
                }else{
                    $email_compra->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_tarjeta_confirmado', $datos_correo, TRUE));
                }
                $sendgrid->send($email_compra);

                // Email de aviso para administracion
                $email_administracion = new SendGrid\Email();
                $email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
                    ->setFrom('no-reply@printome.mx')
                    ->setReplyTo('administracion@printome.mx')
                    ->setFromName('Tienda en línea printome.mx')
                    ->setSubject('Pago con tarjeta realizado | printome.mx')
                    ->setHtml($this->load->view('plantillas_correos/nuevas/admin_confirmacion_pago_tarjeta', $datos_correo, TRUE))
                    ->addAttachment('assets/pdf/'.$this->pdf_pedido_archivo($id_pedido), 'pedido_printome_'.$datos_correo->numero_pedido.'.pdf');
                $sendgrid->send($email_administracion);

                $this->session->set_tempdata('pedido_completado_metodo', "stripe", 5);
                $this->session->set_tempdata('total_pedido', $this->cart->obtener_total(), 5);
                $this->session->set_tempdata('tracking_id_pedido', $id_pedido, 5);
                $this->session->set_tempdata('tracking_shipping', $this->cart->obtener_costo_envio(), 5);
                $this->session->set_tempdata('tracking_iva', $this->cart->obtener_iva(), 5);

                $productos_flash = array();
                foreach($this->cart->contents() as $item_cart) {
                    $options = $this->cart->product_options($item_cart['rowid']);

                    $producto_flash = new stdClass();
                    $producto_flash->nombre_producto = $item_cart['name'].', SKU: '.$options['sku'];
                    $producto_flash->id_producto = (isset($options['id_enhance']) ? $options['id_enhance'] : $options['sku']);
                    $producto_flash->precio = $item_cart['price'];
                    $producto_flash->numero_items = $item_cart['qty'];
                    array_push($productos_flash, $producto_flash);
                    if(isset($options['id_enhance'])){
                        $enhance_venta = $this->db->get_where('Enhance', array('id_enhance' => $options['id_enhance']))->row();
                        $vendedor = $this->db->get_where('Clientes', array('id_cliente' => $enhance_venta->id_cliente))->row();
                        if($vendedor->id_cliente != 341){
                            $datos_correo_venta = new stdClass();
                            $datos_correo_venta->enhance_name = $enhance_venta->name;
                            $datos_correo_venta->vendedor_name = $vendedor->nombres." ".$vendedor->apellidos;

                            $email_venta = new SendGrid\Email();
                            $email_venta->addTo($vendedor->email, $vendedor->nombres)
                                ->setFrom('administracion@printome.mx')
                                ->setReplyTo('hello@printome.mx')
                                ->setFromName('printome.mx')
                                ->setSubject('¡Venta realizada! | printome.mx')
                                ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_aviso_venta_diseno', $datos_correo_venta, TRUE));
                            $sendgrid->send($email_venta);
                        }
                    }
                }
                $this->session->set_tempdata('productos_flash', $productos_flash, 5);

                ac_agregar_etiqueta($datos_correo->email, 'pedido-completado');
                ac_quitar_etiqueta($this->session->login['email'], 'error-pago-tarjeta');

                $this->cart->destroy();
                $this->session->unset_userdata('direccion_temporal');
                $this->session->unset_userdata('direccion_fiscal_temporal');
                $this->session->unset_userdata('descuento_global');
                $this->session->unset_userdata('envio_gratis');
                $this->session->unset_userdata('diseno_temp');
                $this->session->unset_userdata('id_direccion_pedido');
                $this->session->unset_userdata('id_direccion_fiscal_pedido');

                $this->cart_modelo->borrar_carrito($this->session->login['id_cliente']);

                redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pedido-completado-tarjeta');

            } catch (\Stripe\Exception\RateLimitException $error) {
                // Too many requests made to the API too quickly
                $this->bugsnag->notifyError('Error requests de Stripe', $error);
                $this->session->set_flashdata('error_pago', $error->getError()->message);
                ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
                ac_agregar_etiqueta($this->session->login['email'], 'error-pago-tarjeta');
                redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-tarjeta');
            } catch (\Stripe\Exception\InvalidRequestException $error) {
                // Invalid parameters were supplied to Stripe's API
                $this->bugsnag->notifyError('Error de parametros Stripe', $error);
                $this->session->set_flashdata('error_pago', $error->getError()->message);
                ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
                ac_agregar_etiqueta($this->session->login['email'], 'error-pago-tarjeta');
                redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-tarjeta');
            } catch (\Stripe\Exception\AuthenticationException $error) {
                // Authentication with Stripe's API failed
                // (maybe you changed API keys recently)
                $this->bugsnag->notifyError('Error de autentificación Stripe', $error);
                $this->session->set_flashdata('error_pago', $error->getError()->message);
                ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
                ac_agregar_etiqueta($this->session->login['email'], 'error-pago-tarjeta');
                redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-tarjeta');
            } catch (\Stripe\Exception\ApiConnectionException $error) {
                // Network communication with Stripe failed
                $this->bugsnag->notifyError('Error de comunicación Stripe', $error);
                $this->session->set_flashdata('error_pago', $error->getError()->message);
                ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
                ac_agregar_etiqueta($this->session->login['email'], 'error-pago-tarjeta');
                redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-tarjeta');
            } catch (\Stripe\Exception\ApiErrorException $error) {
                // Display a very generic error to the user, and maybe send
                // yourself an email
                $notificacion = 'Ha ocurrido un error general, verifique sus datos, si el problem persiste comuniquese con su banco para autorizar el pago.';

                switch ($error->getError()->code){
                    case 'processing_error':
                        $notificacion = 'El cargo se ha rechazado, comuniquese con su banco.';
                        break;
                    case 'incorrect_cvc':
                        $notificacion = 'El código CVC, es incorrecto';
                        break;
                    case 'expired_card':
                        $notificacion = 'La tarjeta ha expirado, verifique su información con el banco';
                        break;
                    case 'card_declined':
                        $notificacion = 'Su tarjeta fue declinada, comuniquese con su banco.';
                        break;
                    case 'risk_level':
                        $notificacion = 'Su cargo se ha bloqueado por que se considera fraudulento.';
                        break;
                    default:
                        $notificacion = 'Ha ocurrido un error general, verifique sus datos, si el problema persiste comuniquese con su banco para autorizar el pago.';


                }
                $this->bugsnag->notifyError('Error de API Stripe', $error);
                $this->session->set_flashdata('error_pago', $notificacion);
                ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
                ac_agregar_etiqueta($this->session->login['email'], 'error-pago-tarjeta');
                redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-tarjeta');
            } catch (Exception $error) {
                $this->bugsnag->notifyError('Error General de Stripe', $error);
                $this->session->set_flashdata('error_pago', $error->getError()->message);
                ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
                ac_agregar_etiqueta($this->session->login['email'], 'error-pago-tarjeta');
                redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-tarjeta');
            }
        }else{
            $this->session->set_flashdata('error_pago', 'Ocurrio un problema con su tarjeta');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-tarjeta');
        }
    }

    public function generar_link_ppp(){


        $this->load->library('paypalplus');

        $cliente = $this->db->get_where('Clientes', array('id_cliente' => $this->session->login['id_cliente']))->row();
        $direccion = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $this->session->id_direccion_pedido))->row();
        if($this->session->has_userdata('id_direccion_fiscal_pedido')) {
            $direccion_fiscal = $this->db->get_where('DireccionesFiscalesPorCliente', array('id_direccion_fiscal' => $this->session->id_direccion_fiscal_pedido))->row();

        }


        $item_array = array();
        foreach ($this->cart->contents() as $i => $item_cart){
            $options = $item_cart['options'];
            $item = array (
                'name' => $item_cart['name'].($options["enhance"] != 'enhance' ? ' personalizada' : ''),
                'description' => $item_cart['description'],
                'quantity' => $item_cart['qty'],
                'price' => number_format($item_cart['price'], 2,'.',''),
                'sku' => (isset($options['talla']) ? 'Talla: '.$options['talla'] : ''),
                'currency' => 'MXN'
            );
            array_push($item_array, $item);
        }

        $unique_id = uniqid();
        $payment = array (
            'intent' => 'sale',
            'application_context' => array (
                'shipping_preference' => 'SET_PROVIDED_ADDRESS',
            ),
            'payer' => array (
                'payment_method' => 'paypal',
                'payer_info' => array (
                    'billing_address' => array (
                        'line1' => $direccion->linea1,
                        'line2' => $direccion->linea2,
                        'city' => $direccion->ciudad,
                        'country_code' => 'MX',
                        'postal_code' => $direccion->codigo_postal,
                        'state' => $direccion->estado,
                    ),
                ),
            ),
            'transactions' => array (
                0 => array (
                    'amount' => array (
                        'currency' => 'MXN',
                        'total' => number_format($this->cart->obtener_total(), 2,'.',''),
                        'details' => array (
                            'subtotal' => number_format($this->cart->obtener_subtotal(), 2,'.',''),
                            'shipping' => $this->cart->obtener_costo_envio()
                        ),
                    ),
                    'description' => 'Compra desde printome.mx',
                    'payment_options' => array (
                        'allowed_payment_method' => 'IMMEDIATE_PAY',
                    ),
                    'invoice_number' => $unique_id,
                    'item_list' => array (
                        'items' => $item_array,
                        'shipping_address' => array (
                            'recipient_name' => $direccion->identificador_direccion,
                            'line1' => $direccion->linea1,
                            'line2' => $direccion->linea2,
                            'city' => $direccion->ciudad,
                            'country_code' => 'MX',
                            'postal_code' => $direccion->codigo_postal,
                            'state' => $direccion->estado,
                            'phone' => $direccion->telefono,
                        ),
                    ),
                ),
            ),
            'redirect_urls' => array (
                'cancel_url' => base_url('carrito'),
                'return_url' => base_url('carrito'),
            ),
        );

        /*area de descuentos, de envio y en general ********************************************************************
        envio: $payment['transactions'][0]['amount']['details']['shipping_discount'] = $this->cart->obtener_costo_envio()
        descuento general: array_push($payment['transactions'][0]['item_list']['items'], $descuento)
        ****************************************************************************************************************/

        $descuento = array(
            'name' => 'descuento',
            'description' => 'descuento',
            'quantity' => 1,
            'sku' => 'DSCO',
            'price' => 0.00,
            'currency' => 'MXN');

        if($this->cart->obtener_saldo_a_favor() > 0) {
            //if($this->session->has_userdata('descuento_global') && $this->session->descuento_global->tipo != 4) {

            if ($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1) {
                $descuento['price'] = (-1) * (($this->cart->obtener_subtotal() * $this->session->descuento_global->descuento) + $this->cart->obtener_saldo_a_favor());
                $payment['transactions'][0]['amount']['details']['subtotal'] = number_format($this->cart->obtener_subtotal() + (double)$descuento['price'], 2, '.','');
                array_push($payment['transactions'][0]['item_list']['items'], $descuento);
            } else {
                $descuento['price'] = (-1) * ($this->cart->obtener_saldo_a_favor() + $this->session->descuento_global->descuento);
                $payment['transactions'][0]['amount']['details']['subtotal'] = number_format($this->cart->obtener_subtotal() + (double)$descuento['price'], 2, '.','');
                array_push($payment['transactions'][0]['item_list']['items'], $descuento);
            }
            /*} else {
                $descuento['price'] = (-1) * ($this->cart->obtener_saldo_a_favor());
                $payment['transactions'][0]['amount']['details']['subtotal'] = number_format($this->cart->obtener_subtotal() + (double)$descuento['price'], 2, '.','');
                array_push($payment['transactions'][0]['item_list']['items'], $descuento);
            }*/
        } else {
            //if($this->session->has_userdata('descuento_global') && $this->session->descuento_global->tipo != 4) {
            if ($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1) {
                $descuento['price'] = (-1) * ($this->cart->obtener_subtotal() * $this->session->descuento_global->descuento);
                $payment['transactions'][0]['amount']['details']['subtotal'] = number_format($this->cart->obtener_subtotal() + (double)$descuento['price'], 2, '.', '');
                array_push($payment['transactions'][0]['item_list']['items'], $descuento);
            } else {
                $descuento['price'] = (-1) * $this->session->descuento_global->descuento;
                $payment['transactions'][0]['amount']['details']['subtotal'] = number_format($this->cart->obtener_subtotal() + (double)$descuento['price'], 2, '.', '');
                array_push($payment['transactions'][0]['item_list']['items'], $descuento);
            }
            //}
        }

        //si hay envio gratis
        if($this->session->envio_gratis == 'gratis'){
            $payment['transactions'][0]['amount']['details']['shipping_discount'] = $this->cart->obtener_costo_envio();
        }

        $payment = json_encode($payment);


        try {
            $token = $this->db->get_where('TokensPayPal', array('estatus' => 1))->row();
            $result_info_pago = $this->paypalplus->send_payment_information($payment, $token->token);
        }catch(Exception $e){
            $this->session->set_flashdata('error_pago', $e);
            $this->bugsnag->notifyError('Error de generación de link PayPal', $e);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-paypal');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-paypal');
        }

        $info_cliente = new stdClass();
        $info_cliente->nombre_cliente = $cliente->nombres;
        $info_cliente->apellido_cliente = $cliente->apellidos;
        $info_cliente->email_cliente = $cliente->email;
        $info_cliente->telefono_cliente = ($cliente->telefono ? $cliente->telefono : '9999999999');
        $info_cliente->id_cliente = $cliente->id_cliente;
        $info_cliente->hash_paypal = $cliente->hash_paypal;

        $result_info_pago->info_cliente = $info_cliente;
        echo json_encode($result_info_pago);
    }
    /**
     * Funcion para finalizar el pago por tarjeta de PPP
     **/
    public function finalizar_pago_paypal(){
        $log = new stdClass();
        $id_cliente = $this->session->login['id_cliente'];
        if($id_cliente) {
            $log->id_cliente = $id_cliente;
        }else{
            $log->id_cliente = 0;
        }
        $log->proceso = 'Pagar paypal plus';
        $this->db->insert('Log_proceso', $log);
        $payerID = $this->input->post('payerID');
//        $rememberedCard = $this->input->post('rememberedCard');
        $id_cliente = $this->input->post('id_cliente');
        $paymentID = $this->input->post('paymentID');
        $this->load->library('paypalplus');
        $confirmacion = false;
//            $hash = new stdClass();
//            $hash->hash_paypal = $rememberedCard;
//            $this->db->where('id_cliente', $id_cliente)
//                ->update('Clientes', $hash);
        $token =  $this->db->get_where('TokensPayPal', array('estatus' => 1))->row();
        $resultado = $this->paypalplus->finalizar_pago($payerID, $paymentID, $token->token);
        $confirmacion = $resultado->estatus;

        if($confirmacion){
            $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
            try {
                $cliente = $this->db->get_where('Clientes', array('id_cliente' => $this->session->login['id_cliente']))->row();
                $direccion = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $this->session->id_direccion_pedido))->row();
                if($this->session->has_userdata('id_direccion_fiscal_pedido')) {
                    $direccion_fiscal = $this->db->get_where('DireccionesFiscalesPorCliente', array('id_direccion_fiscal' => $this->session->id_direccion_fiscal_pedido))->row();
                }
                // Guardar pedido en la base de datos
                $datos_direccion_pedido = array(
                    'id_direccion' => $direccion->id_direccion
                );
                if(isset($direccion_fiscal)) {
                    $datos_direccion_pedido['id_direccion_fiscal'] = $direccion_fiscal->id_direccion_fiscal;
                }
                $datos_pedido = $this->guardar_pedido($resultado, 'PPP', $paymentID, $datos_direccion_pedido);
                $id_pedido = $datos_pedido->id_pedido;

                if(isset($datos_pedido->id_cupon)) {
                    $cupon = $this->db->get_where('Cupones', array('id' => $this->session->descuento_global->id_cupon, 'estatus' => 1))->row();
                }

                // Preparar la información de los correos
                $datos_correo                = new stdClass();
                $datos_correo->numero_pedido = str_pad($id_pedido, 8, '0', STR_PAD_LEFT);
                $datos_correo->total_pedido  = $datos_pedido->total;
                $datos_correo->referencia_oxxo = $paymentID;
                $datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
                $datos_correo->nombres       = $cliente->nombres;
                $datos_correo->apellidos     = $cliente->apellidos;
                $datos_correo->email         = $cliente->email;
                $datos_correo->cupon         = (isset($datos_pedido->id_cupon) ? $cupon->cupon : null);
                $datos_correo->recibir       = fecha_recepcion(date("N"));

                $email = new SendGrid\Email();
                $email_compra = new SendGrid\Email();
                $email_compra->addTo($datos_correo->email, $datos_correo->nombre)
                    ->setFrom('administracion@printome.mx')
                    ->setReplyTo('hello@printome.mx')
                    ->setFromName('printome.mx')
                    ->setSubject('Confirmación de pago con tarjeta | printome.mx')
                    ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_tarjeta_confirmado', $datos_correo, TRUE));
                $sendgrid->send($email_compra);

                // Email de aviso para administracion
                $email_administracion = new SendGrid\Email();
                $email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
                    ->setFrom('no-reply@printome.mx')
                    ->setReplyTo('administracion@printome.mx')
                    ->setFromName('Tienda en línea printome.mx')
                    ->setSubject('Pago con tarjeta realizado | printome.mx')
                    ->setHtml($this->load->view('plantillas_correos/nuevas/admin_confirmacion_pago_tarjeta', $datos_correo, TRUE))
                    ->addAttachment('assets/pdf/'.$this->pdf_pedido_archivo($id_pedido), 'pedido_printome_'.$datos_correo->numero_pedido.'.pdf');
                $sendgrid->send($email_administracion);

                $this->session->set_tempdata('pedido_completado_metodo', "PayPalPlus", 5);
                $this->session->set_tempdata('total_pedido', $this->cart->obtener_total(), 5);
                $this->session->set_tempdata('tracking_id_pedido', $id_pedido, 5);
                $this->session->set_tempdata('tracking_shipping', $this->cart->obtener_costo_envio(), 5);
                $this->session->set_tempdata('tracking_iva', $this->cart->obtener_iva(), 5);

                $productos_flash = array();
                foreach($this->cart->contents() as $item_cart) {
                    $options = $this->cart->product_options($item_cart['rowid']);

                    $producto_flash = new stdClass();
                    $producto_flash->nombre_producto = $item_cart['name'].', SKU: '.$options['sku'];
                    $producto_flash->id_producto = (isset($options['id_enhance']) ? $options['id_enhance'] : $options['sku']);
                    $producto_flash->precio = $item_cart['price'];
                    $producto_flash->numero_items = $item_cart['qty'];
                    array_push($productos_flash, $producto_flash);
                    if(isset($options['id_enhance'])){
                        $enhance_venta = $this->db->get_where('Enhance', array('id_enhance' => $options['id_enhance']))->row();
                        $vendedor = $this->db->get_where('Clientes', array('id_cliente' => $enhance_venta->id_cliente))->row();
                        if($vendedor->id_cliente != 341) {
                            $datos_correo_venta = new stdClass();
                            $datos_correo_venta->enhance_name = $enhance_venta->name;
                            $datos_correo_venta->vendedor_name = $vendedor->nombres . " " . $vendedor->apellidos;

                            $email_venta = new SendGrid\Email();
                            $email_venta->addTo($vendedor->email, $vendedor->nombres)
                                ->setFrom('administracion@printome.mx')
                                ->setReplyTo('hello@printome.mx')
                                ->setFromName('printome.mx')
                                ->setSubject('¡Venta realizada! | printome.mx')
                                ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_aviso_venta_diseno', $datos_correo_venta, TRUE));
                            $sendgrid->send($email_venta);
                        }
                    }
                }
                $this->session->set_tempdata('productos_flash', $productos_flash, 5);

                ac_agregar_etiqueta($datos_correo->email, 'pedido-completado');
                ac_quitar_etiqueta($this->session->login['email'], 'error-pago-paypal');

                $this->cart->destroy();
                $this->session->unset_userdata('direccion_temporal');
                $this->session->unset_userdata('direccion_fiscal_temporal');
                $this->session->unset_userdata('descuento_global');
                $this->session->unset_userdata('envio_gratis');
                $this->session->unset_userdata('id_direccion_pedido');
                $this->session->unset_userdata('id_direccion_fiscal_pedido');

                $this->cart_modelo->borrar_carrito($this->session->login['id_cliente']);

                echo base_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pedido-completado-tarjeta');

            } catch(Exception $e) {
                $this->session->set_flashdata('error_pago', $e);
                $this->bugsnag->notifyError('Error de pago PPP', $e);
                ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
                ac_agregar_etiqueta($this->session->login['email'], 'error-pago-paypal');
                echo base_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-tarjeta');
            } 
        }else{
            $this->session->set_flashdata('error_pago', $resultado->error);
            $this->bugsnag->notifyError('Error de pago PPP', json_encode($resultado));
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-paypal');
            echo base_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-tarjeta');
            die();
        }
    }
    /*
    * funcion para pagar con oxxo a traves de Conekta
    */
    public function pagar_oxxo($nombre_tienda_slug = null)
    {
        $log = new stdClass();
        $id_cliente = $this->session->login['id_cliente'];
        if($id_cliente) {
            $log->id_cliente = $id_cliente;
        }else{
            $log->id_cliente = 0;
        }
        $log->proceso = 'Pagar oxxo';
        $this->db->insert('Log_proceso', $log);


        $this->load->helper(array('dompdf', 'file'));
        // Inicializar Sendgrid
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);


        // Inicializar Conekta
        \Conekta\Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
        \Conekta\Conekta::setLocale('es');
        \Conekta\Conekta::setApiVersion("2.0.0");

        $forma_pago = 'oxxo';
        $reference_id = "PTOME-".strtoupper($forma_pago)."-".date("YmdHis")."-".$this->session->login['id_cliente'];

        $cliente = $this->db->get_where('Clientes', array('id_cliente' => $this->session->login['id_cliente']))->row();
        $direccion = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $this->session->id_direccion_pedido))->row();
        if($this->session->has_userdata('id_direccion_fiscal_pedido')) {
            $direccion_fiscal = $this->db->get_where('DireccionesFiscalesPorCliente', array('id_direccion_fiscal' => $this->session->id_direccion_fiscal_pedido))->row();
        }

        // Crear un array con los items para mandar a Conekta
        $items = $this->agrupar_items_conekta();

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
            'line_items' => $items,
            'shipping_lines' => array(
                array(
                    'amount' => $this->cart->obtener_costo_envio()*100,
                    'carrier' => 'DHL'
                )
            ),
            'charges' => array(
                array(
                    'amount' => (int)number_format($this->cart->obtener_total()*100, 0, '', ''),
                    'payment_method' => array(
                        'type' => 'oxxo_cash',
                        'expires_at' => strtotime(date("Y-m-d H:i:s", strtotime("+120 hours")))
                    )
                )
            )
        );

        $info_cargo['discount_lines'] = $this->calcular_lineas_descuento_conekta();
        if(!$info_cargo['discount_lines']) {
            unset($info_cargo['discount_lines']);
        }

        try {
            // Funcion de cargo, si es exitoso todo se ejecuta aqui
            $orden = \Conekta\Order::create($info_cargo);
            // Guardar pedido en la base de datos
            $datos_direccion_pedido = array(
                'id_direccion' => $direccion->id_direccion
            );
            if(isset($direccion_fiscal)) {
                $datos_direccion_pedido['id_direccion_fiscal'] = $direccion_fiscal->id_direccion_fiscal;
            }
            $datos_pedido = $this->guardar_pedido($orden, 'cash_payment', $reference_id, $datos_direccion_pedido);
            $id_pedido = $datos_pedido->id_pedido;

            if(isset($datos_pedido->id_cupon)) {
                $cupon = $this->db->get_where('Cupones', array('id' => $this->session->descuento_global->id_cupon, 'estatus' => 1))->row();
            }

            // Preparar la información de los correos
            $datos_correo                = new stdClass();
            $datos_correo->numero_pedido = str_pad($id_pedido, 8, '0', STR_PAD_LEFT);
            $datos_correo->total_pedido  = $datos_pedido->total;
            $datos_correo->referencia_oxxo = $orden->charges[0]->payment_method->reference;
            $datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
            $datos_correo->nombres       = $cliente->nombres;
            $datos_correo->apellidos     = $cliente->apellidos;
            $datos_correo->email         = $cliente->email;
            $datos_correo->cupon         = (isset($datos_pedido->id_cupon) ? $cupon->cupon : null);
            $datos_correo->recibir       = fecha_recepcion(date("N"));

            $email_oxxo = new SendGrid\Email();
            $email_oxxo->addTo($datos_correo->email, $datos_correo->nombre)
                ->setFrom('administracion@printome.mx')
                ->setReplyTo('hello@printome.mx')
                ->setReplyTo('javier.quijano@printome.mx')
                ->setFromName('printome.mx')
                ->setSubject('Ficha de pago en OXXO | printome.mx');

            $paymentDate = date('Y-m-d');
            $paymentDate=date('Y-m-d', strtotime($paymentDate));
            $firstDateBegin = date('Y-m-d', strtotime("04/01/2020"));
            $firstDateEnd = date('Y-m-d', strtotime("05/31/2020"));
            $secondDateBegin = date('Y-m-d', strtotime("12/21/2019"));
            $secondDateEnd = date('Y-m-d', strtotime("01/07/2020"));
            if (($paymentDate >= $firstDateBegin) && ($paymentDate <= $firstDateEnd)){
                $email_oxxo->setHtml($this->load->view('plantillas_correos/nuevas/ausencia_pandemia/auc_15_05_oxxo_stub', $datos_correo, TRUE));
            }else if(($paymentDate >= $secondDateBegin) && ($paymentDate <= $secondDateEnd)){
                $email_oxxo->setHtml($this->load->view('plantillas_correos/nuevas/ausencia_decembrina/aud_21-07_oxxo_stub', $datos_correo, TRUE));
            }else {
                $email_oxxo->setHtml($this->load->view('plantillas_correos/nuevas/cliente_stub_oxxo', $datos_correo, TRUE));
                $html = $this->load->view('plantillas_correos/nuevas/cliente_stub_oxxo', $datos_correo, TRUE);
                $pdf_oxxo = pdf_create_file($html, 'pdf_oxxo_'.str_pad($id_pedido, 8, '0', STR_PAD_LEFT));
                $this->session->set_tempdata('filename_oxxo', $pdf_oxxo, 5);
            }
            $sendgrid->send($email_oxxo);

            $email_omar = new SendGrid\Email();
            $email_omar->addTo('administracion@printome.mx', 'Administración Printome')
                ->setFrom('no-reply@printome.mx')
                ->setReplyTo('administracion@printome.mx')
                ->setFromName('Tienda en línea printome.mx')
                ->setSubject('Se ha generado un nuevo cargo en OXXO | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/admin_aviso_ficha_oxxo', $datos_correo, TRUE));
            $sendgrid->send($email_omar);

            $this->session->set_tempdata('pedido_completado_metodo', "Oxxo", 5);
            $this->session->set_tempdata('total_pedido', $this->cart->obtener_total(), 5);
            $this->session->set_tempdata('tracking_id_pedido', $id_pedido, 5);
            $this->session->set_tempdata('tracking_shipping', $this->cart->obtener_costo_envio(), 5);
            $this->session->set_tempdata('tracking_iva', $this->cart->obtener_iva(), 5);

            $productos_flash = array();
            foreach($this->cart->contents() as $item_cart) {
                $options = $this->cart->product_options($item_cart['rowid']);

                $producto_flash = new stdClass();
                $producto_flash->nombre_producto = $item_cart['name'].', SKU: '.$options['sku'];
                $producto_flash->id_producto = (isset($options['id_enhance']) ? $options['id_enhance'] : $options['sku']);
                $producto_flash->precio = $item_cart['price'];
                $producto_flash->numero_items = $item_cart['qty'];
                array_push($productos_flash, $producto_flash);
            }
            $this->session->set_tempdata('productos_flash', $productos_flash, 5);

            ac_agregar_etiqueta($datos_correo->email, 'pedido-completado-oxxo');
            ac_quitar_etiqueta($this->session->login['email'], 'error-pago-oxxo');

            $this->cart->destroy();
            $this->session->unset_userdata('direccion_temporal');
            $this->session->unset_userdata('direccion_fiscal_temporal');
            $this->session->unset_userdata('descuento_global');
            $this->session->unset_userdata('envio_gratis');
            $this->session->unset_userdata('diseno_temp');
            $this->session->unset_userdata('id_direccion_pedido');
            $this->session->unset_userdata('id_direccion_fiscal_pedido');

            $this->cart_modelo->borrar_carrito($this->session->login['id_cliente']);

            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pedido-completado-oxxo');

        } catch (\Conekta\ProccessingError $error) {
            $this->session->set_flashdata('error_pago', $error);
            $this->bugsnag->notifyError('Error de pago OXXO', $error);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-oxxo');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-oxxo');
        } catch (\Conekta\ParameterValidationError $error) {
            $this->session->set_flashdata('error_pago', $error);
            $this->bugsnag->notifyError('Error de validación OXXO', $error);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-oxxo');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-oxxo');
        } catch (\Conekta\Handler $error) {
            $this->session->set_flashdata('error_pago', $error);
            $this->bugsnag->notifyError('Error de manejo OXXO', $error);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-oxxo');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-oxxo');
        }
    }

    /*
    * funcion para pagar con spei a traves de Conekta
    */
    public function pagar_spei($nombre_tienda_slug = null)
    {
        // Inicializar Sendgrid
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        // Inicializar Conekta
        \Conekta\Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
        \Conekta\Conekta::setLocale('es');
        \Conekta\Conekta::setApiVersion("2.0.0");

        $forma_pago = 'spei';
        $reference_id = "PTOME-".strtoupper($forma_pago)."-".date("YmdHis")."-".$this->session->login['id_cliente'];

        $cliente = $this->db->get_where('Clientes', array('id_cliente' => $this->session->login['id_cliente']))->row();
        $direccion = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $this->session->id_direccion_pedido))->row();
        if($this->session->has_userdata('id_direccion_fiscal_pedido')) {
            $direccion_fiscal = $this->db->get_where('DireccionesFiscalesPorCliente', array('id_direccion_fiscal' => $this->session->id_direccion_fiscal_pedido))->row();
        }

        // Crear un array con los items para mandar a Conekta
        $items = $this->agrupar_items_conekta();

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
            'line_items' => $items,
            'shipping_lines' => array(
                array(
                    'amount' => $this->cart->obtener_costo_envio()*100,
                    'carrier' => 'DHL'
                )
            ),
            'charges' => array(
                array(
                    'amount' => (int)number_format($this->cart->obtener_total()*100, 0, '', ''),
                    'payment_method' => array(
                        'type' => 'spei',
                        'expires_at' => strtotime(date("Y-m-d H:i:s", strtotime("+120 hours")))
                    )
                )
            )
        );

        $info_cargo['discount_lines'] = $this->calcular_lineas_descuento_conekta();
        if(!$info_cargo['discount_lines']) {
            unset($info_cargo['discount_lines']);
        }

        try {
            // Funcion de cargo, si es exitoso todo se ejecuta aqui
            $orden = \Conekta\Order::create($info_cargo);
            // Guardar pedido en la base de datos
            $datos_direccion_pedido = array(
                'id_direccion' => $direccion->id_direccion
            );
            if(isset($direccion_fiscal)) {
                $datos_direccion_pedido['id_direccion_fiscal'] = $direccion_fiscal->id_direccion_fiscal;
            }
            $datos_pedido = $this->guardar_pedido($orden, 'spei', $reference_id, $datos_direccion_pedido);
            $id_pedido = $datos_pedido->id_pedido;

            if(isset($datos_pedido->id_cupon)) {
                $cupon = $this->db->get_where('Cupones', array('id' => $this->session->descuento_global->id_cupon, 'estatus' => 1))->row();
            }

            // Preparar la información de los correos
            $datos_correo                = new stdClass();
            $datos_correo->numero_pedido = str_pad($id_pedido, 8, '0', STR_PAD_LEFT);
            $datos_correo->total_pedido  = $datos_pedido->total;
            $datos_correo->banco         = $orden->charges[0]->payment_method->receiving_account_bank;
            $datos_correo->referencia    = $orden->charges[0]->payment_method->receiving_account_number;
            $datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
            $datos_correo->nombres       = $cliente->nombres;
            $datos_correo->apellidos     = $cliente->apellidos;
            $datos_correo->email         = $cliente->email;
            $datos_correo->cupon         = (isset($datos_pedido->id_cupon) ? $cupon->cupon : null);
            $datos_correo->recibir       = fecha_recepcion(date("N"));

            $email_oxxo = new SendGrid\Email();
            $email_oxxo->addTo($datos_correo->email, $datos_correo->nombre)
                ->setFrom('administracion@printome.mx')
                ->setReplyTo('hello@printome.mx')
                ->setFromName('printome.mx')
                ->setSubject('Ficha de transferencia SPEI | printome.mx');

            $paymentDate = date('Y-m-d');
            $paymentDate=date('Y-m-d', strtotime($paymentDate));
            $firstDateBegin = date('Y-m-d', strtotime("04/01/2020"));
            $firstDateEnd = date('Y-m-d', strtotime("05/31/2020"));
            $secondDateBegin = date('Y-m-d', strtotime("12/21/2019"));
            $secondDateEnd = date('Y-m-d', strtotime("01/07/2020"));
            if (($paymentDate >= $firstDateBegin) && ($paymentDate <= $firstDateEnd)){
                $email_oxxo->setHtml($this->load->view('plantillas_correos/nuevas/ausencia_pandemia/auc_15_05_spei_stub', $datos_correo, TRUE));
            }else if(($paymentDate >= $secondDateBegin) && ($paymentDate <= $secondDateEnd)){
                $email_oxxo->setHtml($this->load->view('plantillas_correos/nuevas/ausencia_decembrina/aud_21-07_spei_stub', $datos_correo, TRUE));
            }else {
                $email_oxxo->setHtml($this->load->view('plantillas_correos/nuevas/cliente_stub_spei', $datos_correo, TRUE));
            }
            $sendgrid->send($email_oxxo);

            $email_omar = new SendGrid\Email();
            $email_omar->addTo('administracion@printome.mx', 'Administración Printome')
                ->setFrom('no-reply@printome.mx')
                ->setReplyTo('administracion@printome.mx')
                ->setFromName('Tienda en línea printome.mx')
                ->setSubject('Se ha generado un nuevo cargo de SPEI | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/admin_aviso_ficha_spei', $datos_correo, TRUE));
            $sendgrid->send($email_omar);

            $this->session->set_tempdata('pedido_completado_metodo', "SPEI", 5);
            $this->session->set_tempdata('total_pedido', $this->cart->obtener_total(), 5);
            $this->session->set_tempdata('tracking_id_pedido', $id_pedido);
            $this->session->set_tempdata('tracking_shipping', $this->cart->obtener_costo_envio(), 5);
            $this->session->set_tempdata('tracking_iva', $this->cart->obtener_iva(), 5);

            $productos_flash = array();
            foreach($this->cart->contents() as $item_cart) {
                $options = $this->cart->product_options($item_cart['rowid']);

                $producto_flash = new stdClass();
                $producto_flash->nombre_producto = $item_cart['name'].', SKU: '.$options['sku'];
                $producto_flash->id_producto = (isset($options['id_enhance']) ? $options['id_enhance'] : $options['sku']);
                $producto_flash->precio = $item_cart['price'];
                $producto_flash->numero_items = $item_cart['qty'];
                array_push($productos_flash, $producto_flash);
            }
            $this->session->set_tempdata('productos_flash', $productos_flash, 5);

            ac_agregar_etiqueta($datos_correo->email, 'pedido-completado-spei');
            ac_quitar_etiqueta($this->session->login['email'], 'error-pago-spei');

            $this->cart->destroy();
            $this->session->unset_userdata('direccion_temporal');
            $this->session->unset_userdata('direccion_fiscal_temporal');
            $this->session->unset_userdata('descuento_global');
            $this->session->unset_userdata('envio_gratis');
            $this->session->unset_userdata('diseno_temp');
            $this->session->unset_userdata('id_direccion_pedido');
            $this->session->unset_userdata('id_direccion_fiscal_pedido');

            $this->cart_modelo->borrar_carrito($this->session->login['id_cliente']);

            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pedido-completado-spei');

        } catch (\Conekta\ProccessingError $error) {
            $this->session->set_flashdata('error_pago', $error);
            $this->bugsnag->notifyError('Error de procesamiento SPEI', $error);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-spei');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-spei');
        } catch (\Conekta\ParameterValidationError $error) {
            $this->session->set_flashdata('error_pago', $error);
            $this->bugsnag->notifyError('Error de validación SPEI', $error);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-spei');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-spei');
        } catch (\Conekta\Handler $error) {
            $this->session->set_flashdata('error_pago', $error);
            $this->bugsnag->notifyError('Error de manejo SPEI', $error);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-spei');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-spei');
        }
    }

    /*
    * funcion para pagar con saldo a favor
    */
    public function pagar_saldo($nombre_tienda_slug = null)
    {
        // Inicializar Sendgrid
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);

        $forma_pago = 'saldo';
        $reference_id = "PTOME-".strtoupper($forma_pago)."-".date("YmdHis")."-".$this->session->login['id_cliente'];

        $cliente = $this->db->get_where('Clientes', array('id_cliente' => $this->session->login['id_cliente']))->row();
        $direccion = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $this->session->id_direccion_pedido))->row();
        if($this->session->has_userdata('id_direccion_fiscal_pedido')) {
            $direccion_fiscal = $this->db->get_where('DireccionesFiscalesPorCliente', array('id_direccion_fiscal' => $this->session->id_direccion_fiscal_pedido))->row();
        }

        try {
            $datos_direccion_pedido = array(
                'id_direccion' => $direccion->id_direccion
            );
            if(isset($direccion_fiscal)) {
                $datos_direccion_pedido['id_direccion_fiscal'] = $direccion_fiscal->id_direccion_fiscal;
            }

            $orden = new stdClass();
            $orden->created_at = strtotime(date("Y-m-d H:i:s"));
            $orden->updated_at = strtotime(date("Y-m-d H:i:s"));
            $orden->payment_status = 'paid';
            $orden->id_pago = 'pago-saldo';

            $datos_pedido = $this->guardar_pedido($orden, 'saldo', $reference_id, $datos_direccion_pedido);
            $id_pedido = $datos_pedido->id_pedido;

            if(isset($datos_pedido->id_cupon)) {
                $cupon = $this->db->get_where('Cupones', array('id' => $this->session->descuento_global->id_cupon, 'estatus' => 1))->row();
            }

            // Preparar la información de los correos
            $datos_correo                = new stdClass();
            $datos_correo->numero_pedido = str_pad($id_pedido, 8, '0', STR_PAD_LEFT);
            $datos_correo->total_pedido  = $datos_pedido->total;
            $datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
            $datos_correo->nombres       = $cliente->nombres;
            $datos_correo->apellidos     = $cliente->apellidos;
            $datos_correo->email         = $cliente->email;
            $datos_correo->cupon         = (isset($datos_pedido->id_cupon) ? $cupon->cupon : null);
            $datos_correo->recibir       = fecha_recepcion(date("N"));

            // Email de aviso de la compra
            $email_compra = new SendGrid\Email();
            $email_compra->addTo($datos_correo->email, $datos_correo->nombre)
                ->setFrom('administracion@printome.mx')
                ->setReplyTo('hello@printome.mx')
                ->setReplyTo('javier.quijano@printome.mx')
                ->setFromName('printome.mx')
                ->setSubject('Confirmación de pago con saldo a favor | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_saldo_confirmado', $datos_correo, TRUE));
            $sendgrid->send($email_compra);

            // Email de aviso para administracion
            $email_administracion = new SendGrid\Email();
            $email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
                ->setFrom('no-reply@printome.mx')
                ->setReplyTo('administracion@printome.mx')
                ->setFromName('Tienda en línea printome.mx')
                ->setSubject('Pago con saldo a favor realizado | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/admin_confirmacion_pago_tarjeta', $datos_correo, TRUE))
                ->addAttachment('assets/pdf/'.$this->pdf_pedido_archivo($id_pedido), 'pedido_printome_'.$datos_correo->numero_pedido.'.pdf');
            $sendgrid->send($email_administracion);

            $this->session->set_tempdata('pedido_completado_metodo', "saldo", 5);
            $this->session->set_tempdata('total_pedido', $this->cart->obtener_total(), 5);
            $this->session->set_tempdata('tracking_id_pedido', $id_pedido, 5);
            $this->session->set_tempdata('tracking_shipping', $this->cart->obtener_costo_envio(), 5);
            $this->session->set_tempdata('tracking_iva', $this->cart->obtener_iva(), 5);

            $productos_flash = array();
            foreach($this->cart->contents() as $item_cart) {
                $options = $this->cart->product_options($item_cart['rowid']);

                $producto_flash = new stdClass();
                $producto_flash->nombre_producto = $item_cart['name'].', SKU: '.$options['sku'];
                $producto_flash->id_producto = (isset($options['id_enhance']) ? $options['id_enhance'] : $options['sku']);
                $producto_flash->precio = $item_cart['price'];
                $producto_flash->numero_items = $item_cart['qty'];
                array_push($productos_flash, $producto_flash);
                if(isset($options['id_enhance'])){
                    $enhance_venta = $this->db->get_where('Enhance', array('id_enhance' => $options['id_enhance']))->row();
                    $vendedor = $this->db->get_where('Clientes', array('id_cliente' => $enhance_venta->id_cliente))->row();
                    if($vendedor->id_cliente != 341) {
                        $datos_correo_venta = new stdClass();
                        $datos_correo_venta->enhance_name = $enhance_venta->name;
                        $datos_correo_venta->vendedor_name = $vendedor->nombres . " " . $vendedor->apellidos;

                        $email_venta = new SendGrid\Email();
                        $email_venta->addTo($vendedor->email, $vendedor->nombres)
                            ->setFrom('administracion@printome.mx')
                            ->setReplyTo('hello@printome.mx')
                            ->setFromName('printome.mx')
                            ->setSubject('¡Venta realizada! | printome.mx')
                            ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_aviso_venta_diseno', $datos_correo_venta, TRUE));
                        $sendgrid->send($email_venta);
                    }
                }
            }
            $this->session->set_tempdata('productos_flash', $productos_flash, 5);

            ac_agregar_etiqueta($datos_correo->email, 'pedido-completado');
            ac_quitar_etiqueta($this->session->login['email'], 'error-pago-saldo');

            $saldo_pendiente = $this->cart->obtener_total();
            $saldo_anterior = $this->cart->obtener_saldo_a_favor();

            $this->cart->destroy();
            $this->session->unset_userdata('direccion_temporal');
            $this->session->unset_userdata('direccion_fiscal_temporal');
            $this->session->unset_userdata('descuento_global');
            $this->session->unset_userdata('envio_gratis');
            $this->session->unset_userdata('diseno_temp');
            $this->session->unset_userdata('id_direccion_pedido');
            $this->session->unset_userdata('id_direccion_fiscal_pedido');

            $this->cart_modelo->borrar_carrito($this->session->login['id_cliente'], $saldo_pendiente, $saldo_anterior, 1);

            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pedido-completado-saldo');

        } catch(Exception $e) {
            $this->session->set_flashdata('error_pago', $e);
            $this->bugsnag->notifyError('Error de pago saldo', $e);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-saldo');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-saldo');
        }
    }

    public function pagar_paypal($nombre_tienda_slug = null)
    {

        $log = new stdClass();
        $id_cliente = $this->session->login['id_cliente'];
        if($id_cliente) {
            $log->id_cliente = $id_cliente;
        }else{
            $log->id_cliente = 0;
        }
        $log->proceso = 'Pagar paypal';
        $this->db->insert('Log_proceso', $log);
        // Generacion de link de PayPal
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $_ENV['PAYPAL_CLIENT'],
                $_ENV['PAYPAL_SECRET']
            )
        );

        $apiContext->setConfig(array(
            'mode' => $_ENV['PAYPAL_MODE']
        ));

        $cliente = $this->db->get_where('Clientes', array('id_cliente' => $this->session->login['id_cliente']))->row();
        $direccion = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $this->session->id_direccion_pedido))->row();
        if($this->session->has_userdata('id_direccion_fiscal_pedido')) {
            $direccion_fiscal = $this->db->get_where('DireccionesFiscalesPorCliente', array('id_direccion_fiscal' => $this->session->id_direccion_fiscal_pedido))->row();
        }

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
                ->setPrice(number_format($item_cart['price'], 2,'.',''));
            array_push($paypal_items, $item);
        }

        $itemList = new \PayPal\Api\ItemList();
        $itemList->setItems($paypal_items);
        $shipping_address = new \PayPal\Api\ShippingAddress();
        $shipping_address->setCity($direccion->ciudad);
        $shipping_address->setPhone((isset($direccion->telefono) ? ($direccion->telefono != '' ? $direccion->telefono : '0000000000') : '0000000000'));
        $shipping_address->setCountryCode('MX');
        $shipping_address->setPostalCode($direccion->codigo_postal);
        $shipping_address->setLine1($direccion->linea1);
        $shipping_address->setLine2($direccion->linea2);
        $shipping_address->setState($direccion->estado);
        $shipping_address->setRecipientName($direccion->identificador_direccion);
        $itemList->setShippingAddress($shipping_address);

        $details = new \PayPal\Api\Details();
        $details->setShipping($this->cart->obtener_costo_envio())
            ->setTax(0)
            ->setSubtotal($this->cart->obtener_subtotal());

        // Si hay descuento
        $descuento = new \PayPal\Api\Item();
        $descuento->setName('DESCUENTO')
            ->setCurrency('MXN')
            ->setQuantity(1)
            ->setSku('DSTO')
            ->setPrice(0.00);

        if($this->cart->obtener_saldo_a_favor() > 0) {
            if($this->session->has_userdata('descuento_global') && $this->session->descuento_global->tipo != 4) {
                if ($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1) {
                    $descuento->setPrice((-1) * (($this->cart->obtener_subtotal() * $this->session->descuento_global->descuento) + $this->cart->obtener_saldo_a_favor()));
                    $details->setSubtotal(number_format($this->cart->obtener_subtotal() + (double)$descuento->getPrice(), 2, '.', ''));
                    array_push($paypal_items, $descuento);
                    $itemList->setItems($paypal_items);
                } else {
                    $descuento->setPrice((-1) * ($this->cart->obtener_saldo_a_favor() + $this->session->descuento_global->descuento));
                    $details->setSubtotal(number_format($this->cart->obtener_subtotal() + (double)$descuento->getPrice(), 2, '.', ''));
                    array_push($paypal_items, $descuento);
                    $itemList->setItems($paypal_items);
                }
            }elseif($this->session->envio_gratis == 'gratis' && $this->session->descuento_global->tipo == 4 && $this->session->has_userdata('descuento_global')){
                // add para cupon + envio 
                    $descuento->setPrice((-1) * (($this->cart->obtener_subtotal() * $this->session->descuento_global->descuento) + $this->cart->obtener_saldo_a_favor()));
                    $details->setSubtotal(number_format($this->cart->obtener_subtotal() + (double)$descuento->getPrice(), 2, '.', ''));
                    array_push($paypal_items, $descuento);
                    $itemList->setItems($paypal_items);
            } else {
                $descuento->setPrice((-1) * ($this->cart->obtener_saldo_a_favor()));
                $details->setSubtotal(number_format($this->cart->obtener_subtotal() + (double)$descuento->getPrice(), 2, '.', ''));
                array_push($paypal_items, $descuento);
                $itemList->setItems($paypal_items);
            }
        } else {
            if($this->session->has_userdata('descuento_global') && $this->session->descuento_global->tipo != 4) {
                if ($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1) {
                    $descuento->setPrice((-1) * ($this->cart->obtener_subtotal() * $this->session->descuento_global->descuento));
                    $details->setSubtotal(number_format($this->cart->obtener_subtotal() + (double)$descuento->getPrice(), 2, '.', ''));
                    array_push($paypal_items, $descuento);
                    $itemList->setItems($paypal_items);
                } else {
                    $descuento->setPrice((-1) * $this->session->descuento_global->descuento);
                    $details->setSubtotal(number_format($this->cart->obtener_subtotal() + (double)$descuento->getPrice(), 2, '.', ''));
                    array_push($paypal_items, $descuento);
                    $itemList->setItems($paypal_items);
                }
            }elseif($this->session->envio_gratis == 'gratis' && $this->session->descuento_global->tipo == 4 && $this->session->has_userdata('descuento_global')){
                // add para cupon + envio 
                    $descuento->setPrice((-1) * (($this->cart->obtener_subtotal() * $this->session->descuento_global->descuento) + $this->cart->obtener_saldo_a_favor()));
                    $details->setSubtotal(number_format($this->cart->obtener_subtotal() + (double)$descuento->getPrice(), 2, '.', ''));
                    array_push($paypal_items, $descuento);
                    $itemList->setItems($paypal_items);
            }else{
                $descuento->setPrice((-1) * ($this->cart->obtener_saldo_a_favor()));
                $details->setSubtotal(number_format($this->cart->obtener_subtotal() + (double)$descuento->getPrice(), 2, '.', ''));
                array_push($paypal_items, $descuento);
                $itemList->setItems($paypal_items);  
            }
        }

        //si hay envio gratis
        if($this->session->envio_gratis == 'gratis'){
            $details->setShippingDiscount($this->cart->obtener_costo_envio());
        }

        $amount = new \PayPal\Api\Amount();
        $amount->setCurrency("MXN")
            ->setTotal(number_format($this->cart->obtener_total(),2,'.',''))
            ->setDetails($details);

        $transaction = new \PayPal\Api\Transaction();
        $unique_id = uniqid();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Carrito de compras printome.mx")
            ->setInvoiceNumber($unique_id);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(site_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/terminar-paypal'))
            ->setCancelUrl(site_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar'));

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($apiContext);
        } catch (Exception $ex) {
            $this->session->set_flashdata('error_pago', $e);
            $this->bugsnag->notifyError('Error de generación de link PayPal', $e);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-paypal');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-paypal');
        }

        try {
            $link = $payment->getApprovalLink();
            redirect($link);
        } catch(Exception $e) {
            $this->session->set_flashdata('error_pago', $e);
            $this->bugsnag->notifyError('Error de generación de link PayPal', $e);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-paypal');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-paypal');
        }
    }

    public function terminar_paypal($nombre_tienda_slug = null)
    {
        // Inicializar Sendgrid
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        try {
            if(!$this->input->get('paymentId') && !$this->input->get('token') && !$this->input->get('PayerID')) {
                // Si no recibo los datos del pago, regreso a error
                throw new Exception('Ha ocurrido algún error con PayPal, no se te ha cobrado nada, por favor intenta nuevamente.');
            } else {
                // Conexion con PayPal
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

                $cliente = $this->db->get_where('Clientes', array('id_cliente' => $this->session->login['id_cliente']))->row();
                $direccion = $this->db->get_where('DireccionesPorCliente', array('id_direccion' => $this->session->id_direccion_pedido))->row();
                if($this->session->has_userdata('id_direccion_fiscal_pedido')) {
                    $direccion_fiscal = $this->db->get_where('DireccionesFiscalesPorCliente', array('id_direccion_fiscal' => $this->session->id_direccion_fiscal_pedido))->row();
                }

                try {
                    // Se intenta hacer el pago
                    $resultado = $pago->execute($ejecucion_pago, $apiContext);
                    if(!$resultado->getId()) {
                        // Si no recibo los datos del pago, regreso a error
                        throw new Exception('Ha ocurrido algún error con PayPal, no se te ha cobrado nada, por favor intenta nuevamente.');
                    }
                    // Guardar pedido en la base de datos
                    $datos_direccion_pedido = array(
                        'id_direccion' => $direccion->id_direccion
                    );
                    if(isset($direccion_fiscal)) {
                        $datos_direccion_pedido['id_direccion_fiscal'] = $direccion_fiscal->id_direccion_fiscal;
                    }
                    $datos_pedido = $this->guardar_pedido($resultado, 'paypal', $resultado->getId(), $datos_direccion_pedido);
                    $id_pedido = $datos_pedido->id_pedido;

                    if(isset($datos_pedido->id_cupon)) {
                        $cupon = $this->db->get_where('Cupones', array('id' => $this->session->descuento_global->id_cupon, 'estatus' => 1))->row();
                    }


                    // Preparar la información de los correos
                    $datos_correo                = new stdClass();
                    $datos_correo->numero_pedido = str_pad($id_pedido, 8, '0', STR_PAD_LEFT);
                    $datos_correo->total_pedido  = $datos_pedido->total;
                    $datos_correo->referencia_oxxo = $resultado->getId();
                    $datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
                    $datos_correo->nombres       = $cliente->nombres;
                    $datos_correo->apellidos     = $cliente->apellidos;
                    $datos_correo->email         = $cliente->email;
                    $datos_correo->cupon         = (isset($datos_pedido->id_cupon) ? $cupon->cupon : null);
                    $datos_correo->recibir       = fecha_recepcion(date("N"));

                    $email = new SendGrid\Email();
                    $email->addTo($datos_correo->email, $datos_correo->nombre)
                        ->setFrom('administracion@printome.mx')
                        ->setReplyTo('hello@printome.mx')
                        ->setFromName('printome.mx')
                        ->setSubject('Confirmación de pago con PayPal | printome.mx');

                    $paymentDate = date('Y-m-d');
                    $paymentDate=date('Y-m-d', strtotime($paymentDate));
                    $firstDateBegin = date('Y-m-d', strtotime("04/01/2020"));
                    $firstDateEnd = date('Y-m-d', strtotime("05/31/2020"));
                    $secondDateBegin = date('Y-m-d', strtotime("12/21/2019"));
                    $secondDateEnd = date('Y-m-d', strtotime("01/07/2020"));
                    if (($paymentDate >= $firstDateBegin) && ($paymentDate <= $firstDateEnd)){
                        $email->setHtml($this->load->view('plantillas_correos/nuevas/ausencia_pandemia/auc_15_05_paypal_confirmado', $datos_correo, TRUE));
                    }else if(($paymentDate >= $secondDateBegin) && ($paymentDate <= $secondDateEnd)){
                        $email->setHtml($this->load->view('plantillas_correos/nuevas/ausencia_decembrina/aud_21-07_paypal_confirmado', $datos_correo, TRUE));
                    }else{
                        $email->setHtml($this->load->view('plantillas_correos/nuevas/cliente_pedido_paypal_confirmado', $datos_correo, TRUE));
                    }
                    $sendgrid->send($email);

                    $email_administracion = new SendGrid\Email();
                    $email_administracion->addTo('administracion@printome.mx', 'printome.mx')
                        ->setFrom('no-reply@printome.mx')
                        ->setReplyTo('administracion@printome.mx')
                        ->setFromName('Tienda en línea printome.mx')
                        ->setSubject('Pago con PayPal realizado | printome.mx')
                        ->setHtml($this->load->view('plantillas_correos/nuevas/admin_confirmacion_pago_paypal', $datos_correo, TRUE))
                        ->addAttachment('assets/pdf/'.$this->pdf_pedido_archivo($id_pedido), 'pedido_printome_'.$datos_correo->numero_pedido.'.pdf');
                    $sendgrid->send($email_administracion);

                    $this->session->set_tempdata('pedido_completado_metodo', "PayPal",5);
                    $this->session->set_tempdata('total_pedido', $this->cart->obtener_total(),5);
                    $this->session->set_tempdata('tracking_id_pedido', $id_pedido,5);
                    $this->session->set_tempdata('tracking_shipping', $this->cart->obtener_costo_envio(),5);
                    $this->session->set_tempdata('tracking_iva', $this->cart->obtener_iva(),5);

                    $productos_flash = array();
                    foreach($this->cart->contents() as $item_cart) {
                        $options = $this->cart->product_options($item_cart['rowid']);

                        $producto_flash = new stdClass();
                        $producto_flash->nombre_producto = $item_cart['name'].', SKU: '.$options['sku'];
                        $producto_flash->id_producto = (isset($options['id_enhance']) ? $options['id_enhance'] : $options['sku']);
                        $producto_flash->precio = $item_cart['price'];
                        $producto_flash->numero_items = $item_cart['qty'];
                        array_push($productos_flash, $producto_flash);
                        if(isset($options['id_enhance'])){
                            $enhance_venta = $this->db->get_where('Enhance', array('id_enhance' => $options['id_enhance']))->row();
                            $vendedor = $this->db->get_where('Clientes', array('id_cliente' => $enhance_venta->id_cliente))->row();
                            if($vendedor->id_cliente != 341) {
                                $datos_correo_venta = new stdClass();
                                $datos_correo_venta->enhance_name = $enhance_venta->name;
                                $datos_correo_venta->vendedor_name = $vendedor->nombres . " " . $vendedor->apellidos;

                                $email_venta = new SendGrid\Email();
                                $email_venta->addTo($vendedor->email, $vendedor->nombres)
                                    ->setFrom('administracion@printome.mx')
                                    ->setReplyTo('hello@printome.mx')
                                    ->setFromName('printome.mx')
                                    ->setSubject('¡Venta realizada! | printome.mx')
                                    ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_aviso_venta_diseno', $datos_correo_venta, TRUE));
                                $sendgrid->send($email_venta);
                            }
                        }
                    }
                    $this->session->set_tempdata('productos_flash', $productos_flash, 5);

                    ac_agregar_etiqueta($datos_correo->email, 'pedido-completado');
                    ac_quitar_etiqueta($this->session->login['email'], 'error-pago-paypal');

                    $this->cart->destroy();
                    $this->session->unset_userdata('direccion_temporal');
                    $this->session->unset_userdata('direccion_fiscal_temporal');
                    $this->session->unset_userdata('descuento_global');
                    $this->session->unset_userdata('envio_gratis');
                    $this->session->unset_userdata('id_direccion_pedido');
                    $this->session->unset_userdata('id_direccion_fiscal_pedido');

                    $this->cart_modelo->borrar_carrito($this->session->login['id_cliente']);

                    redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pedido-completado-paypal');

                } catch(Exception $e) {
                    //print_r($e);
                    $this->session->set_flashdata('error_pago', $e);
                    ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
                    ac_agregar_etiqueta($this->session->login['email'], 'error-pago-paypal');
                    redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-paypal');
                }
            }
        } catch(Exception $e) {
            $this->session->set_flashdata('error_pago', $e);
            $this->bugsnag->notifyError('Error de pago PayPal', $e);
            ac_quitar_etiqueta($this->session->login['email'], 'pedido-completado');
            ac_agregar_etiqueta($this->session->login['email'], 'error-pago-paypal');
            redirect(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar/error-pago-paypal');
        }
    }

    public function guardar_pedido($orden, $metodo_pago, $referencia_pago, $datos_direccion_pedido)
    {
        // Formar pedido
        switch($metodo_pago){
            case 'paypal':
                $pedido = array(
                    "fecha_creacion"        => date("Y-m-d H:i:s", strtotime($orden->getCreateTime())),
                    "fecha_pago"            => date("Y-m-d H:i:s", strtotime($orden->getUpdateTime())),
                    "estatus_pago"          => 'paid',
                    "id_pago"               => $orden->getId(),
                    "metodo_pago"           => $metodo_pago,
                    "referencia_pago"       => $orden->getId(),
                    "subtotal"              => $this->cart->obtener_subtotal(),
                    "iva"                   => $this->cart->obtener_iva(),
                    "descuento"		        => $this->cart->obtener_saldo_a_favor(),
                    "total"                 => $this->cart->obtener_total(),
                    "costo_envio"           => $this->cart->obtener_costo_envio(),
                    "id_cliente"            => $this->session->login['id_cliente'],
                    "id_direccion"          => $datos_direccion_pedido['id_direccion'],
                    "id_direccion_fiscal"   => (isset($datos_direccion_pedido['id_direccion_fiscal']) ? $datos_direccion_pedido['id_direccion_fiscal'] : 0),
                    "paypal_payer_email"    => $orden->getPayer()->getPayerInfo()->getEmail(),
                    "paypal_payer_id"       => $orden->getPayer()->getPayerInfo()->getPayerId(),
                    "id_paso_pedido"        => 2
                );
                break;
            case 'PPP':
                $pedido = array(
                    "fecha_creacion"        => date("Y-m-d H:i:s", strtotime($orden->transactions[0]->related_resources[0]->sale->create_time)),
                    "fecha_pago"            => date("Y-m-d H:i:s", strtotime($orden->transactions[0]->related_resources[0]->sale->update_time)),
                    "estatus_pago"          => 'paid',
                    "id_pago"               => $orden->id,
                    "metodo_pago"           => $metodo_pago,
                    "referencia_pago"       => $orden->id,
                    "subtotal"              => $this->cart->obtener_subtotal(),
                    "iva"                   => $this->cart->obtener_iva(),
                    "descuento"		        => $this->cart->obtener_saldo_a_favor(),
                    "total"                 => $this->cart->obtener_total(),
                    "costo_envio"           => $this->cart->obtener_costo_envio(),
                    "id_cliente"            => $this->session->login['id_cliente'],
                    "id_direccion"          => $datos_direccion_pedido['id_direccion'],
                    "id_direccion_fiscal"   => (isset($datos_direccion_pedido['id_direccion_fiscal']) ? $datos_direccion_pedido['id_direccion_fiscal'] : 0),
                    "paypal_payer_email"    => $orden->payer->payer_info->email,
                    "paypal_payer_id"       => $orden->payer->payer_info->payer_id,
                    "id_paso_pedido"        => 2
                );
                break;
            case 'stripe':
                $pedido = array(
                    "fecha_creacion"        => date("Y-m-d H:i:s"),
                    "fecha_pago"            => date("Y-m-d H:i:s"),
                    "estatus_pago"          => $orden->status,
                    "id_pago"               => $orden->id,
                    "metodo_pago"           => $metodo_pago,
                    "referencia_pago"       => $referencia_pago,
                    "subtotal"              => $this->cart->obtener_subtotal(),
                    "iva"                   => $this->cart->obtener_iva(),
                    "descuento"		        => $this->cart->obtener_saldo_a_favor(),
                    "total"                 => $this->cart->obtener_total(),
                    "costo_envio"           => $this->cart->obtener_costo_envio(),
                    "id_cliente"            => $this->session->login['id_cliente'],
                    "id_direccion"          => $datos_direccion_pedido['id_direccion'],
                    "id_direccion_fiscal"   => (isset($datos_direccion_pedido['id_direccion_fiscal']) ? $datos_direccion_pedido['id_direccion_fiscal'] : 0),
                    "id_paso_pedido"        => 2
                );
                break;
            default:
                $pedido = array(
                    "fecha_creacion"        => date("Y-m-d H:i:s", $orden->created_at),
                    "fecha_pago"            => date("Y-m-d H:i:s", $orden->updated_at),
                    "estatus_pago"          => $orden->payment_status,
                    "id_pago"               => $orden->id,
                    "metodo_pago"           => $metodo_pago,
                    "referencia_pago"       => $referencia_pago,
                    "subtotal"              => $this->cart->obtener_subtotal(),
                    "iva"                   => $this->cart->obtener_iva(),
                    "descuento"		        => $this->cart->obtener_saldo_a_favor(),
                    "total"                 => $this->cart->obtener_total(),
                    "costo_envio"           => $this->cart->obtener_costo_envio(),
                    "id_cliente"            => $this->session->login['id_cliente'],
                    "id_direccion"          => $datos_direccion_pedido['id_direccion'],
                    "id_direccion_fiscal"   => (isset($datos_direccion_pedido['id_direccion_fiscal']) ? $datos_direccion_pedido['id_direccion_fiscal'] : 0),
                    "id_paso_pedido"        => ($metodo_pago == 'card_payment' ? 2 : ($metodo_pago == 'saldo' ? 2 : 1))
                );
                break;
        }

        if($this->session->has_userdata('descuento_global')) {
            if($this->session->descuento_global->descuento) {
                if($this->session->descuento_global->tipo != 5) {
                    $pedido['id_cupon'] = $this->session->descuento_global->id_cupon;
                    $this->db->query("UPDATE Cupones SET cantidad=cantidad-1 WHERE id=" . $pedido['id_cupon']);
                }else{
                    $pedido['id_cupon'] = $this->session->descuento_global->id_cupon;
                }
            }
        }

        if($metodo_pago == 'cash_payment') {
            $pedido['oxxo_codigo_barras'] = $orden->charges[0]->payment_method->reference;
            $pedido['oxxo_fecha_vencimiento'] = date("Y-m-d H:i:s", $orden->charges[0]->payment_method->expires_at);
        }
        if($metodo_pago != 'saldo'){
            $pedido['fecha_terminos']=date("Y-m-d H:i:s");
            $pedido['terminos']=1;
        }
        $this->db->insert("Pedidos", $pedido);
        $id_pedido = $this->db->insert_id();

        if($metodo_pago != 'cash_payment' && $metodo_pago != 'spei') {
            if ($this->session->descuento_global->tipo == 5) {
                $referencia = new stdClass();
                $referencia->id_comprador = $this->session->login['id_cliente'];
                $referencia->id_referenciado = $this->session->descuento_global->id_cliente;
                $referencia->id_pedido = $id_pedido;
                $referencia->id_cupon = $this->session->descuento_global->id_cupon;
                $referencia->fecha = date("Y-m-d H:i:s");
                $referencia->experiencia = $this->cart->obtener_subtotal();
                $referencia->puntos = $this->referencias_modelo->obtener_puntos_referenciado($this->session->descuento_global->id_cliente, $this->cart->obtener_subtotal());
                $this->db->insert('HistorialReferencias', $referencia);

                $cupon = $this->db->get_where("Cupones", array("id" => $this->session->descuento_global->id_cupon))->row();
                $historial_saldo = new stdClass();
                $historial_saldo->cantidad = $referencia->puntos;
                $historial_saldo->fecha = $referencia->fecha;
                $historial_saldo->id_cliente = $referencia->id_referenciado;
                $historial_saldo->motivo = "Saldo por Cupón de Referencia: ".$cupon->cupon;
                $this->db->insert('HistorialSaldo', $historial_saldo);

                $subio_nivel = $this->referencias_modelo->verificar_nivel($referencia->id_referenciado);
                if($subio_nivel){
                    $ref = $this->db->get_where("Referencias", array("id_cliente" => $referencia->id_referenciado))->row();
                    $this->correo_subir_nivel($ref);
                }
            }

//            $paymentDate = date('Y-m-d');
//            $paymentDate = date('Y-m-d', strtotime($paymentDate));
//            $compareDate = date('Y-m-d', strtotime("12/02/2019"));
//            if ($paymentDate == $compareDate){
//                if($this->cart->obtener_subtotal() > 999.00){
//                    $this->cupones_modelo->promocion_cm($this->session->login['id_cliente']);
//                }
//            }
        }

        if($metodo_pago != 'saldo' && ($this->cart->obtener_saldo_a_favor() > 0)) {
            $saldo = new stdClass();
            $saldo->cantidad = $this->cart->obtener_saldo_a_favor() * (-1);
            $saldo->fecha = date("Y-m-d H:i:s");
            $saldo->id_cliente = $this->session->login['id_cliente'];
            $saldo->motivo = "Saldo utilizado en Pedido";

            $this->db->insert("HistorialSaldo", $saldo);
        }

        $historial_pedido = new stdClass();
        $historial_pedido->id_pedido = $id_pedido;
        $historial_pedido->id_paso_pedido = 1;
        $historial_pedido->fecha_inicio = date("Y-m-d H:i:s");
        if($pedido['id_paso_pedido'] == 2) {
            $historial_pedido->fecha_final = $pedido['fecha_pago'];
        }
        $this->db->insert('HistorialPedidos', $historial_pedido);

        if($pedido['id_paso_pedido'] == 2) {
            $segundo_historial = new stdClass();
            $segundo_historial->id_pedido = $id_pedido;
            $segundo_historial->id_paso_pedido = 2;
            $segundo_historial->fecha_inicio = $pedido['fecha_pago'];

            $this->db->insert('HistorialPedidos', $segundo_historial);
        }

        // Formar los productos del pedido
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
            }else if($options['id_producto'] == 42){
                $this->db->where('id_enhance', $sku_item['id_enhance']);
                $query = $this->db->query("UPDATE StockProducts SET ".$options["talla"]."_stock = (".$options["talla"]."_stock-".$item['qty'].") WHERE id_enhance='".$sku_item['id_enhance']."'");
            }
            else {
                $enhance = $this->enhance_modelo->obtener_enhance($sku_item['id_enhance']);
                if($enhance->type == 'fijo') {
                    $query = $this->db->query("UPDATE CatalogoSkuPorProducto SET cantidad_inicial=(cantidad_inicial-".$item['qty'].") WHERE id_sku='".$options['sku']."'");
                }
                if($metodo_pago != 'cash_payment') {
                    $query = $this->db->query('UPDATE Enhance SET sold=(sold+'.$item['qty'].') WHERE id_enhance='.$sku_item['id_enhance']);
                }
            }
            $sku_items[] = $sku_item;
        }
        $this->db->insert_batch("ProductosPorPedido", $sku_items);

        //$cliente_ac = $this->active->obtener_clientes(array('email' => $this->session->login['email'], 'connectionid' => 1));

        //if(!isset($cliente_ac->ecomCustomers[0]->id)) {
        //$this->active->crear_cliente(1, $this->session->login['id_cliente'], $this->session->login['email']);
        //}

        // Guardar pedido en active campaign
        $pedido_para_ac = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
        //$cliente_ac = $this->active->obtener_clientes(array('email' => $this->session->login['email'], 'connectionid' => 1));
        //$this->active->crear_pedido(1, $cliente_ac->ecomCustomers[0]->id, 1 /* 0 - sync, 1 - live */, $pedido_para_ac, $pedido_para_ac->productos);

        if($metodo_pago == 'cash_payment'){
            //$contacto = $this->active->obtener_contacto(array('email' => $this->session->login['email']));
            //$this->active->actualizar_campo_personalizado_cliente($contacto->contacts[0]->id, 10, $orden->charges[0]->payment_method->reference);
        }

        $datos_pedido = new stdClass();
        $datos_pedido->id_pedido = $id_pedido;
        $datos_pedido->total = $pedido['total'];
        if($this->session->has_userdata('descuento_global')) {
            if($this->session->descuento_global->descuento) {
                $datos_pedido->id_cupon = $this->session->descuento_global->id_cupon;
            }
        }

        return $datos_pedido;
    }

    public function calcular_lineas_descuento_conekta()
    {
        if($this->cart->obtener_saldo_a_favor() > 0) {
            if($this->session->has_userdata('descuento_global')) {
                if($this->session->envio_gratis == 'gratis'){
                    return array(
                        array(
                            'code' => 'Saldo a favor + ' .$this->session->descuento_global->cupon,
                            'amount' => (int)number_format(($this->cart->obtener_saldo_a_favor() + $this->cart->obtener_costo_envio()) * 100, 0, '', ''),
                            'type' => 'coupon'
                        )
                    );
                }else {
                    if ($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1) {
                        // Funciona
                        return array(
                            array(
                                'code' => 'Saldo a favor + ' . $this->session->descuento_global->cupon,
                                'amount' => (int)number_format(($this->cart->obtener_subtotal() - (($this->cart->obtener_subtotal()  * (1 - $this->session->descuento_global->descuento)) - $this->cart->obtener_saldo_a_favor())) * 100, 0, '', ''),
                                'type' => 'coupon'
                            )
                        );
                    } else {
                        // Funciona
                        return array(
                            array(
                                'code' => 'Saldo a favor + ' . $this->session->descuento_global->cupon,
                                'amount' => (int)number_format(($this->cart->obtener_saldo_a_favor() + $this->session->descuento_global->descuento) * 100, 0, '', ''),
                                'type' => 'coupon'
                            )
                        );
                    }
                }
            } else {
                // Funciona
                return array(
                    array(
                        'code' => 'Saldo a favor',
                        'amount' => (int)number_format($this->cart->obtener_saldo_a_favor() * 100, 0, '', ''),
                        'type' => 'coupon'
                    )
                );
            }
        } else {
            if($this->session->has_userdata('descuento_global')) {
                if($this->session->envio_gratis == 'gratis'){
                    $descuento_adicional = 0;
                    if ($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1) {
                        $descuento_adicional = (int)number_format(($this->cart->obtener_subtotal() * $this->session->descuento_global->descuento) * 100, 0, '', '');
                    }else{
                        $descuento_adicional = (int)number_format($this->session->descuento_global->descuento * 100, 0, '', '');
                    }
                    return array(
                        array(
                            'code' => $this->session->descuento_global->cupon,
                            'amount' => $descuento_adicional+(int)number_format(($this->cart->obtener_costo_envio()) * 100, 0, '', ''),
                            'type' => 'coupon'
                        )
                    );
                }else {
                    if ($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1) {
                        return array(
                            array(
                                'code' => $this->session->descuento_global->cupon,
                                'amount' => (int)number_format(($this->cart->obtener_subtotal() * $this->session->descuento_global->descuento) * 100, 0, '', ''),
                                'type' => 'coupon'
                            )
                        );
                    } else {
                        // Funciona
                        return array(
                            array(
                                'code' => $this->session->descuento_global->cupon,
                                'amount' => (int)number_format($this->session->descuento_global->descuento * 100, 0, '', ''),
                                'type' => 'coupon'
                            )
                        );
                    }
                }
            } else {
                if($this->cart->obtener_subtotal() > 499){
                    return array(
                        array(
                            'code' => 'ENVIO_GRATIS',
                            'amount' => (int)number_format(($this->cart->obtener_costo_envio()) * 100, 0, '', ''),
                            'type' => 'coupon'
                        )
                    );
                }else{
                    return null;
                }

            }
        }
    }

    public function agrupar_items_conekta()
    {
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
        return $items;
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
                    $contenido['pedido']->productos[$indice]->id_producto = $info_enhanced->id_producto;
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

    public function pdf_pedido($id_pedido){
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

        pdf_create($html, 'pedido_avanda_'.str_pad($id_pedido, 8, '0', STR_PAD_LEFT));
    }

    /*
    * funcion para volver a generar pedidos
    */
    public function reordenar($id_pedido)
    {
        $info = clasificar_productos_pedido($this->pedidos_modelo->obtener_pedido_especifico($id_pedido));

        foreach($info['inmediatas'] as $venta_inmediata) {
            if($venta_inmediata->estatus == 1) {
                $this->reordenar_agregar_enhances($venta_inmediata);
            }
        }

        foreach($info['enhances'] as $plazo_definido) {
            if($plazo_definido->estatus == 1 && $plazo_definido->end_date >= date("Y-m-d H:i:s")) {
                $this->reordenar_agregar_enhances($plazo_definido);
            }
        }

        foreach($info['group_customs'] as $indice_custom_group => $custom_group) {
            if(sizeof($custom_group) == 1) {
                $custom_a_insertar = $info['customs'][$custom_group[0]];
                $this->reordenar_agregar_custom($custom_a_insertar);
            } else if(sizeof($custom_group) > 1) {
                $customs_a_insertar = array();
                foreach($custom_group as $cg) {
                    array_push($customs_a_insertar, $info['customs'][$cg]);
                }
                $this->reordenar_agregar_custom_multiple($customs_a_insertar);
            }
        }

        redirect('carrito');
    }

    public function reordenar_agregar_enhances($item)
    {
        $enhance    = $this->catalogo_modelo->obtener_enhanced_con_id($item->id_enhance);
        $color      = $this->productos_modelo->obtener_info_color($enhance->id_color);
        $fotografia = $this->productos_modelo->obtener_foto_principal_color($enhance->id_color, $enhance->id_producto);

        $producto = array(
            'id'        => $enhance->id_producto,
            'price'     => $enhance->price,
            'name'      => convert_accented_characters($enhance->name),
            'options'   => array(
                'precio_producto'   => $enhance->price,
                'imagen'            => $fotografia->ubicacion_base.$fotografia->fotografia_chica,
                'peso'              => $enhance->peso_producto,
                'devolucion'        => $enhance->aplica_devolucion,
                'envio_gratis'      => $enhance->envio_gratis,
                'marca'             => $enhance->nombre_marca,
                'color'             => $color->nombre_color,
                'codigo_color'      => $color->codigo_color,
                'enhance'           => true,
                'id_enhance'        => $enhance->id_enhance,
                'id_parent_enhance' => $enhance->id_parent_enhance,
                'tipo_enhance'      => $enhance->type,
                'images'            => array(
                    'front'     => $enhance->front_image,
                    'back'      => $enhance->back_image,
                    'left'      => $enhance->left_image,
                    'right'     => $enhance->right_image
                )
            )
        );

        foreach($item->tallas as $sku_info) {
            $sku = $this->productos_modelo->obtener_info_sku($sku_info->id_sku);
            if($sku_info->cantidad <= $sku->cantidad_inicial) {
                $producto['qty'] = $sku_info->cantidad;
            } else {
                if($sku->cantidad_inicial <= 0) {
                    $producto['qty'] = 0;
                } else {
                    $producto['qty'] = $sku->cantidad_inicial;
                }
            }
            $producto['options']['sku'] = $sku_info->id_sku;
            $producto['options']['talla'] = $sku->talla_completa;

            $this->cart->insert($producto);

            $producto_flash = new stdClass();
            if($enhance->type == 'fijo') {
                $producto_flash->nombre_producto = 'Producto de venta inmediata: '.$producto['name'].', SKU: '.$sku->sku;
            } else if($enhance->type == 'limitado') {
                $producto_flash->nombre_producto = 'Producto de plazo definido: '.$producto['name'].', SKU: '.$sku->sku;
            }
            $producto_flash->id_producto = $producto['id'];
            $producto_flash->precio = $producto['price'];
            $producto_flash->numero_items = $producto['qty'];

            //$this->session->set_flashdata('producto_flash', $producto_flash);
            $this->session->set_tempdata('productos_flash', $producto_flash, 5);

        }
    }

    public function reordenar_agregar_custom($producto)
    {
        $info_producto = $this->catalogo_modelo->obtener_producto_con_id($producto->id_producto);
        $mismo_diseno = md5(time());
        $productos_flash = array();

        foreach($producto->diseno->images as $ind => $img) {
            $producto->diseno->images->{$ind} = str_replace(base_url(), '', $img);
        }

        // Contar cuantos son en total y juntar los skus
        $quantity = 0;
        $skus = array();

        foreach ($producto->tallas as $talla) {
            $sku = $this->catalogo_modelo->obtener_producto_sku_por_id($talla->id_sku, $talla->cantidad);
            $sku->precio_base = $sku->precio;

            if($talla->cantidad <= $sku->cantidad_inicial) {
                $sku->quantity = $talla->cantidad;
                $quantity += $sku->quantity;
                array_push($skus, $sku);
            } else {
                if($sku->cantidad_inicial <= 0) {
                    $sku->quantity = 0;
                } else {
                    $sku->quantity = $sku->cantidad_inicial;
                    $quantity += $sku->quantity;
                    array_push($skus, $sku);
                }
            }
        }

        $esBlanca = false;
        if ($producto->diseno->color == "FFFFFF" || $producto->diseno->color == "FFF" || $producto->diseno->color == "ffffff" || $producto->diseno->color == "fff") {
            $esBlanca = true;
        }

        $total_colors = array("front" => 0, "back" => 0, "left" => 0, "right" => 0);
        foreach ($producto->diseno->colores as $key => $value) {
            $total_colors[$key] = count($value);
        }

        foreach($skus as $indice_sku=>$s) {
            $skus[$indice_sku]->precio_final = getCost($total_colors, $esBlanca, $quantity, $s);
        }

        foreach ($skus as $sku) {
            $caracteristicas = json_decode($sku->caracteristicas);
            $talla = "";
            foreach ($caracteristicas as $key => $value) {
                $talla.= $value;
            }

            // Preparar para agregar a carrito
            $item   = array(
                'id'          => $info_producto->id_producto,
                'qty'         => $sku->quantity,
                'name'        => $info_producto->nombre_producto,
                'price'       => $sku->precio_final,
                'options'     => array(
                    'sku'          => $sku->id_sku,
                    'id_diseno'    => $mismo_diseno,
                    'id_color'     => $sku->id_color,
                    'calculadora'  => array(
                        'precio_base'     => $sku->precio_base,
                        'esBlanca'        => $esBlanca,
                        'colores_totales' => $total_colors,
                    ),
                    'talla'        => $talla,
                    'enhance'      => false,
                    'price'        => $sku->precio_final,
                    'marca'        => $sku->nombre_marca,
                    'codigo_color' => color_awesome($sku->codigo_color),
                    'disenos'      => array(
                        'color'           => $producto->diseno->color,
                        'colores'         => $producto->diseno->colores,
                        'images'          => json_decode(json_encode($producto->diseno->images), TRUE),
                        'vector'          => $producto->diseno->vector,
                        'fonts'           => $producto->diseno->fonts
                    )
                )
            );

            $this->cart->insert($item);

            $producto_flash = new stdClass();
            $producto_flash->nombre_producto = 'Producto personalizado: '.$info_producto->nombre_producto.', SKU: '.$sku->sku;
            $producto_flash->id_producto     = 'Custom - SKU: '.$sku->sku;
            $producto_flash->precio          = $sku->precio_final;
            $producto_flash->numero_items    = $sku->quantity;

            array_push($productos_flash, $producto_flash);
        }

        //$this->session->set_flashdata('productos_flash', $productos_flash);
        $this->session->set_tempdata('productos_flash', $productos_flash, 5);
        //
        // // Si hay sesión activa se actualiza el carrito en la base de datos
        $id_cliente = $this->session->login['id_cliente'];
        $es_cliente = (!is_null($id_cliente));
        if($es_cliente) {
            $this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
        }
        if($this->session->has_userdata('correo_temporal')) {
            $this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
        }
    }

    public function reordenar_agregar_custom_multiple($productos)
    {
        $cantidad_total = 0;
        $mismo_diseno = md5(time()+rand(1000,2000));
        $items_a_insertar = array();
        $productos_flash = array();

        foreach($productos as $indice=>$producto) {

            foreach ($producto->tallas as $talla) {
                $sku = $this->catalogo_modelo->obtener_producto_sku_por_id($talla->id_sku, $talla->cantidad);

                if($talla->cantidad <= $sku->cantidad_inicial) {
                    $cantidad_total += $sku->quantity;
                } else {
                    if($sku->cantidad_inicial <= 0) {

                    } else {
                        $cantidad_total += $sku->quantity;
                    }
                }
            }
        }

        foreach($productos as $indice=>$producto) {
            foreach($producto->diseno->images as $ind => $img) {
                $productos[$indice]->diseno->images->{$ind} = str_replace(base_url(), '', $img);
            }

            $info_producto = $this->catalogo_modelo->obtener_producto_con_id($producto->id_producto);

            // Contar cuantos son en total y juntar los skus
            $quantity = 0;
            $skus = array();

            foreach ($producto->tallas as $talla) {
                $sku = $this->catalogo_modelo->obtener_producto_sku_por_id($talla->id_sku, $talla->cantidad);
                $sku->precio_base = $sku->precio;

                if($talla->cantidad <= $sku->cantidad_inicial) {
                    $sku->quantity = $talla->cantidad;
                    $quantity += $sku->quantity;
                    array_push($skus, $sku);
                } else {
                    if($sku->cantidad_inicial <= 0) {
                        $sku->quantity = 0;
                    } else {
                        $sku->quantity = $sku->cantidad_inicial;
                        $quantity += $sku->quantity;
                        array_push($skus, $sku);
                    }
                }
            }

            $esBlanca = false;
            if ($producto->diseno->color == "FFFFFF" || $producto->diseno->color == "FFF" || $producto->diseno->color == "ffffff" || $producto->diseno->color == "fff") {
                $esBlanca = true;
            }

            $total_colors = array("front" => 0, "back" => 0, "left" => 0, "right" => 0);
            foreach ($producto->diseno->colores as $key => $value) {
                $total_colors[$key] = count($value);
            }

            foreach($skus as $indice_sku=>$s) {
                $skus[$indice_sku]->precio_final = getCost($total_colors, $esBlanca, $cantidad_total, $s);
            }

            foreach($skus as $sku) {

                $caracteristicas = json_decode($sku->caracteristicas);
                $talla = "";
                foreach ($caracteristicas as $key => $value) {
                    $talla.= $value;
                }

                // Preparar para agregar a carrito
                $item   = array(
                    'id'          => $info_producto->id_producto,
                    'qty'         => $sku->quantity,
                    'name'        => $info_producto->nombre_producto,
                    'price'       => $sku->precio_final,
                    'options'     => array(
                        'sku'          => $sku->id_sku,
                        'id_diseno'    => $mismo_diseno,
                        'id_color'     => $sku->id_color,
                        'calculadora'  => array(
                            'precio_base'     => $sku->precio_base,
                            'esBlanca'        => $esBlanca,
                            'colores_totales' => $total_colors,
                        ),
                        'talla'        => $talla,
                        'enhance'      => false,
                        'price'        => $sku->precio_final,
                        'marca'        => $sku->nombre_marca,
                        'codigo_color' => color_awesome($sku->codigo_color),
                        'disenos'      => array(
                            'color'           => $producto->diseno->color,
                            'colores'         => $producto->diseno->colores,
                            'images'          => json_decode(json_encode($producto->diseno->images), TRUE),
                            'vector'          => $producto->diseno->vector,
                            'fonts'           => $producto->diseno->fonts
                        )
                    )
                );

                array_push($items_a_insertar, $item);

                $producto_flash = new stdClass();
                $producto_flash->nombre_producto = 'Producto personalizado: '.$info_producto->nombre_producto.', SKU: '.$sku->sku;
                $producto_flash->id_producto = $sku->id_producto;
                $producto_flash->precio = $sku->precio_final;
                $producto_flash->numero_items = $sku->quantity;

                array_push($productos_flash, $producto_flash);

            }
        }

        $this->cart->insert($items_a_insertar);

        //$this->session->set_flashdata('productos_flash', $productos_flash);
        $this->session->set_tempdata('productos_flash', $productos_flash, 5);

        //Si hay sesión activa se actualiza el carrito en la base de datos
        $id_cliente = $this->session->login['id_cliente'];
        $es_cliente = (!is_null($id_cliente));
        if($es_cliente) {
            $this->cart_modelo->actualizar_carrito($this->session->login['id_cliente']);
        }
        if($this->session->has_userdata('correo_temporal')) {
            $this->cart_modelo->actualizar_carrito_invitado($this->session->correo_temporal);
        }
    }

    public function probando()
    {
        $mp = new MP($this->config->item('mercadopago_client_id'), $this->config->item('mercadopago_client_secret'));

        $items = array();
        foreach($this->cart->contents() as $item){
            $options = $this->cart->product_options($item['rowid']);

            $new_item = array(
                'title'         => $item['name'].($options["enhance"] != 'enhance' ? ' personalizada' : '').(isset($options['talla']) ? ' - Talla: '.$options['talla'] : ''),
                'quantity'      => $item['qty'],
                'currency_id'   => 'MXN',
                'unit_price'    => $item['price']
            );

            array_push($items, $new_item);
        }

        $preference_data = array(
            "items" => $items
        );

        $preference = $mp->create_preference($preference_data);

        echo '<!DOCTYPE html>
        <html>
        	<head>
        		<title>Pay</title>
        	</head>
        	<body>
        		<a href="'.$preference['response']['init_point'].'">Pay</a>
        	</body>
        </html>';
    }

    public function cambiar_direccion_dinamico(){
        $codigo_postal = $this->input->post('codigo_postal');
        $nombre_asentamiento = $this->input->post('nombre_asentamiento');
        $total_envio = $this->input->post('total_envio');
        $id_direccion = $this->input->post('id_direccion');

        $this->db->select('ciudad_asentamiento');
        $this->db->from('Asentamientos');
        $this->db->where('MATCH(codigo_postal) AGAINST ("'.$codigo_postal.'")', NULL, false);
        $this->db->where('MATCH(nombre_asentamiento) AGAINST ("'.$nombre_asentamiento.'")', NULL, false);

        $verificacion = $this->db->get()->result();

        $html_completo = new stdClass();
        if($this->session->envio_gratis){
            $html_completo->html_envio = "<strong class='verde'>GRATIS</strong>";
            $html_completo->html_total = "<strong>". $total_envio ."</strong>";;
        }else{
            if($verificacion[0]->ciudad_asentamiento == "Mérida"){
                $html_completo->html_envio = "$150.00";
                $this->session->id_direccion_pedido = $id_direccion;
                $html_completo->html_total = "<strong>$". $this->cart->format_number($this->cart->obtener_total()) ."</strong>";
            }else{
                $html_completo->html_envio = "$150.00";
                $this->session->id_direccion_pedido = $id_direccion;
                $html_completo->html_total = "<strong>$". $this->cart->format_number($this->cart->obtener_total()) ."</strong>";
            }
        }

        echo json_encode($html_completo);
    }

    public function correo_subir_nivel($referencia){
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        $nivel = $this->referencias_modelo->obtener_nivel_referencia($referencia->id_nivel);
        $cupon = $this->referencias_modelo->obtener_cupon_referencia($referencia->id_cupon);
        $cliente = $this->referencias_modelo->obtener_cliente_referencia($referencia->id_cliente);

        $datos_correo                       = new stdClass();
        $datos_correo->email                = $cliente->email;
        $datos_correo->nombre_completo      = $cliente->nombres." ".$cliente->apellidos;
        $datos_correo->nombre               = $cliente->nombres;
        $datos_correo->nombre_nivel         = $nivel->nombre_nivel;
        $datos_correo->porcentaje_ganancia = $nivel->porcentaje_ganancia;
        $datos_correo->meta_ventas          = $nivel->maximo_ventas;
        $datos_correo->slug_imagen          = $nivel->nombre_nivel_slug;
        $datos_correo->puntos_actuales      = $referencia->puntos;
        $datos_correo->experiencia_actual   = $referencia->experiencia;
        $datos_correo->cupon                = $cupon->cupon;


        $email_compra = new SendGrid\Email();
        $email_compra->addTo($datos_correo->email, $datos_correo->nombre_completo)
            ->setFrom('administracion@printome.mx')
            ->setReplyTo('hello@printome.mx')
            ->setFromName('printome.mx')
            ->setSubject('Has subido de nivel! | printome.mx')
            ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_nuevo_nivel', $datos_correo, TRUE));
        $sendgrid->send($email_compra);
    }
}
