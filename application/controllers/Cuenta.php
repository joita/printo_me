<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuenta extends MY_Controller {

    public $tienda;

    public function __construct() {
        parent::__construct();

        if(!$this->session->has_userdata('login')) {
            redirect('');
        }
    }

    public function datos() {
        // Config
        $datos_header['seccion_activa'] = 'mi-cuenta';
        $datos_header['subseccion_activa'] = 'datos';
        $datos_header['meta']['title'] = 'Mis Datos | Mi Cuenta | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';

        $datos_seccion['lugar'] = 'Mis Datos';
        $datos_seccion['info'] = $this->cuenta_modelo->obtener_info_cliente($this->session->login['id_cliente']);

        $this->load->view('header', $datos_header);
        $this->load->view('mi-cuenta/despliegue_base', $datos_seccion);
        $this->load->view('footer');
    }

    public function actualizar_datos() {
        $nuevos_datos = new stdClass();
        $nuevos_datos->nombres = $this->input->post('nombres');
        $nuevos_datos->apellidos = $this->input->post('apellidos');
        $nuevos_datos->fecha_nacimiento = $this->input->post('fecha_nacimiento');
        $nuevos_datos->genero = $this->input->post('genero');
        $nuevos_datos->telefono = $this->input->post('telefono');

        if($nuevos_datos->genero == 'M') {
            $opcion = 'Masculino';
        } else if($nuevos_datos->genero == 'F') {
            $opcion = 'Femenino';
        } else if($nuevos_datos->genero == 'X') {
            $opcion = 'Prefiero no decir';
        } else {
            $opcion = '';
        }

        $contact = array(
            "email"              => $this->session->login['email'],
            "first_name"         => $nuevos_datos->nombres,
            "last_name"          => $nuevos_datos->apellidos,
            "phone"          	 => $nuevos_datos->telefono,
            "p[16]"              => "16",
            "status[16]"         => 1,
            "field[2,0]"         => $nuevos_datos->fecha_nacimiento,
            "field[3,0]"         => $opcion
        );
        $contact_sync = $this->ac->api("contact/sync", $contact);

        $this->db->where('id_cliente', $this->input->post('id_cliente'));
        $this->db->update('Clientes', $nuevos_datos);

        $this->session->set_flashdata('update_datos', 'ok');

        redirect('mi-cuenta/datos');
    }

    public function tienda() {
        // Config
        $datos_header['seccion_activa'] = 'mi-cuenta';
        $datos_header['subseccion_activa'] = 'tienda';
        $datos_header['meta']['title'] = 'Mi Tienda | Mi Cuenta | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';
        $datos_footer['scripts'] = 'mi-cuenta/scripts_tienda';

        $datos_seccion['lugar'] = 'Mi Tienda';

        $this->load->view('header', $datos_header);
        $this->load->view('mi-cuenta/despliegue_base', $datos_seccion);
        $this->load->view('footer',$datos_footer);
    }

    public function actualizar_datos_tienda() {
        $nuevos_datos = new stdClass();
        $nuevos_datos->nombre_tienda = $this->input->post('nombre_tienda');
        $nuevos_datos->descripcion_tienda = $this->input->post('descripcion_tienda');
        $nuevos_datos->facebook = $this->input->post('facebook_tienda');
        $nuevos_datos->twitter = $this->input->post('twitter_tienda');
        $nuevos_datos->instagram = $this->input->post('instagram_tienda');
        $nuevos_datos->youtube = $this->input->post('youtube_tienda');

        $this->db->where('id_cliente', $this->input->post('id_cliente'));
        $this->db->update('Tiendas', $nuevos_datos);

        $this->session->set_flashdata('update_datos', 'ok');

        $directorio = 'assets/images/logos';
        $directorioAcercade = 'assets/images/acercade';
        $directorioSlide = 'assets/images/slider_clientes';

        if(!file_exists($directorio) and !is_dir($directorio)) {
            mkdir($directorio);
            chmod($directorio, 0755);
        }

        if(!file_exists($directorioAcercade) and !is_dir($directorioAcercade)) {
            mkdir($directorioAcercade);
            chmod($directorioAcercade, 0755);
        }

        if(!file_exists($directorioSlide) and !is_dir($directorioSlide)) {
            mkdir($directorioSlide);
            chmod($directorioSlide, 0755);
        }

        $config['upload_path'] = $directorio;

        $config['file_ext_tolower'] = TRUE;
        $config['allowed_types'] = 'jpg|png|jpeg|jpe';
        //Logo
        if(isset($_FILES['logo'])) {
            if($_FILES['logo']['size'] > 0 && $_FILES['logo']['error'] == 0) {

                $config['file_name'] = time();
                $this->upload->initialize($config);

                $_FILES['userfile']['name'] 		= $_FILES['logo']['name'];
                $_FILES['userfile']['type'] 		= $_FILES['logo']['type'];
                $_FILES['userfile']['tmp_name'] 	= $_FILES['logo']['tmp_name'];
                $_FILES['userfile']['error'] 		= $_FILES['logo']['error'];
                $_FILES['userfile']['size'] 		= $_FILES['logo']['size'];

                $this->upload->do_upload();
                $data = $this->upload->data();

                $config['source_image'] = $data['full_path'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;

                $configs = array(
                    array('width' => 1000, 'height' => 1000, 'quality' => 90, 'new_image' => $data['file_path'].'1000_'.$data['file_name'], 'new_file' => '1000_'.$data['file_name']),
                    array('width' => 500, 'height' => 500, 'quality' => 90, 'new_image' => $data['file_path'].'500_'.$data['file_name'], 'new_file' => '500_'.$data['file_name']),
                    array('width' => 250, 'height' => 250, 'quality' => 90, 'new_image' => $data['file_path'].'250_'.$data['file_name'], 'new_file' => '250_'.$data['file_name'])
                );

                foreach($configs as $conf) {
                    $config['width'] = $conf['width'];
                    $config['height'] = $conf['height'];
                    $config['quality'] = $conf['quality'];
                    $config['new_image'] = $conf['new_image'];

                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }

                $image_info_db = new stdClass();
                $image_info_db->logotipo_original = $data['file_name'];
                $image_info_db->logotipo_grande = $configs[0]['new_file'];
                $image_info_db->logotipo_mediano = $configs[1]['new_file'];
                $image_info_db->logotipo_chico = $configs[2]['new_file'];

                $this->db->where('id_cliente', $this->input->post('id_cliente'));
                $this->db->update('Tiendas', $image_info_db);
            }
        }
        //Imagen acerca de
        $configAcercade['upload_path'] = $directorioAcercade;

        $configAcercade['file_ext_tolower'] = TRUE;
        $configAcercade['allowed_types'] = 'jpg|png|jpeg|jpe';

        if(isset($_FILES['acercade'])) {
            if($_FILES['acercade']['size'] > 0 && $_FILES['acercade']['error'] == 0) {

                $configAcercade['file_name'] = time();
                $this->upload->initialize($configAcercade);

                $_FILES['userfile']['name'] 		= $_FILES['acercade']['name'];
                $_FILES['userfile']['type'] 		= $_FILES['acercade']['type'];
                $_FILES['userfile']['tmp_name'] 	= $_FILES['acercade']['tmp_name'];
                $_FILES['userfile']['error'] 		= $_FILES['acercade']['error'];
                $_FILES['userfile']['size'] 		= $_FILES['acercade']['size'];

                $this->upload->do_upload();
                $dataAcercade = $this->upload->data();

                $configAcercade['source_image'] = $dataAcercade['full_path'];
                $configAcercade['create_thumb'] = FALSE;
                $configAcercade['maintain_ratio'] = TRUE;


                $image_acercade_db = new stdClass();
                $image_acercade_db->imagen_acercade = $dataAcercade['file_name'];


                $this->db->where('id_cliente', $this->input->post('id_cliente'));
                $this->db->update('Tiendas', $image_acercade_db);
            }
        }
        //Slider
        $configSlide['upload_path'] = $directorioSlide;

        $configSlide['file_ext_tolower'] = TRUE;
        $configSlide['allowed_types'] = 'jpg|png|jpeg|jpe';


        $nombre_tienda = $this->input->post('nombre_tienda');
        $sliders = new stdClass();

        if($_FILES['slideruno']['error'] == 0 && $_FILES['slideruno']['size'] > 0) {

            $configSlide['file_name'] = time() . '_' . trim($nombre_tienda) .'_uno'. '_' . rand(111, 999);
            $this->upload->initialize($configSlide);

            $_FILES['userfile']['name'] = $_FILES['slideruno']['name'];
            $_FILES['userfile']['type'] = $_FILES['slideruno']['type'];
            $_FILES['userfile']['tmp_name'] = $_FILES['slideruno']['tmp_name'];
            $_FILES['userfile']['error'] = $_FILES['slideruno']['error'];
            $_FILES['userfile']['size'] = $_FILES['slideruno']['size'];

            $this->upload->do_upload();
            $datauno = $this->upload->data();

            $configSlide['source_image'] = $datauno['full_path'];
            $configSlide['create_thumb'] = FALSE;
            $configSlide['maintain_ratio'] = TRUE;

            $configs = array(
                array('width' => 480, 'height' => 179, 'quality' => 65, 'new_image' => $datauno['file_path'] . '480_' . $datauno['file_name'], 'new_file' => '480_' . $datauno['file_name'])
            );

            foreach ($configs as $conf) {
                $configSlide['width'] = $conf['width'];
                $configSlide['height'] = $conf['height'];
                $configSlide['quality'] = $conf['quality'];
                $configSlide['new_image'] = $conf['new_image'];

                $this->image_lib->initialize($configSlide);
                $this->image_lib->resize();
            }
            $sliders->slider_uno = $datauno['file_name'];
            $sliders->slider_uno_chico = $configs[0]['new_file'];



        }

        if($_FILES['sliderdos']['error'] == 0 && $_FILES['sliderdos']['size'] > 0) {
            $configSlide['file_name'] = time() . '_' . trim($nombre_tienda) .'_dos'. '_' . rand(111, 999);
            $this->upload->initialize($configSlide);

            $_FILES['userfile']['name'] = $_FILES['sliderdos']['name'];
            $_FILES['userfile']['type'] = $_FILES['sliderdos']['type'];
            $_FILES['userfile']['tmp_name'] = $_FILES['sliderdos']['tmp_name'];
            $_FILES['userfile']['error'] = $_FILES['sliderdos']['error'];
            $_FILES['userfile']['size'] = $_FILES['sliderdos']['size'];

            $this->upload->do_upload();
            $datados = $this->upload->data();

            $configSlide['source_image'] = $datados['full_path'];
            $configSlide['create_thumb'] = FALSE;
            $configSlide['maintain_ratio'] = TRUE;

            $configs = array(
                array('width' => 480, 'height' => 179, 'quality' => 65, 'new_image' => $datados['file_path'] . '480_' . $datados['file_name'], 'new_file' => '480_' . $datados['file_name'])
            );

            foreach ($configs as $conf) {
                $configSlide['width'] = $conf['width'];
                $configSlide['height'] = $conf['height'];
                $configSlide['quality'] = $conf['quality'];
                $configSlide['new_image'] = $conf['new_image'];

                $this->image_lib->initialize($configSlide);
                $this->image_lib->resize();
            }
            $sliders->slider_dos = $datados['file_name'];
            $sliders->slider_dos_chico = $configs[0]['new_file'];



        }

        if($_FILES['slidertres']['error'] == 0 && $_FILES['slidertres']['size'] > 0) {
            $configSlide['file_name'] = time() . '_' . trim($nombre_tienda) .'_tres'. '_' . rand(111, 999);
            $this->upload->initialize($configSlide);

            $_FILES['userfile']['name'] = $_FILES['slidertres']['name'];
            $_FILES['userfile']['type'] = $_FILES['slidertres']['type'];
            $_FILES['userfile']['tmp_name'] = $_FILES['slidertres']['tmp_name'];
            $_FILES['userfile']['error'] = $_FILES['slidertres']['error'];
            $_FILES['userfile']['size'] = $_FILES['slidertres']['size'];

            $this->upload->do_upload();
            $datados = $this->upload->data();

            $configSlide['source_image'] = $datados['full_path'];
            $configSlide['create_thumb'] = FALSE;
            $configSlide['maintain_ratio'] = TRUE;

            $configs = array(
                array('width' => 480, 'height' => 179, 'quality' => 65, 'new_image' => $datados['file_path'] . '480_' . $datados['file_name'], 'new_file' => '480_' . $datados['file_name'])
            );

            foreach ($configs as $conf) {
                $configSlide['width'] = $conf['width'];
                $configSlide['height'] = $conf['height'];
                $configSlide['quality'] = $conf['quality'];
                $configSlide['new_image'] = $conf['new_image'];

                $this->image_lib->initialize($configSlide);
                $this->image_lib->resize();
            }
            $sliders->slider_tres = $datados['file_name'];
            $sliders->slider_tres_chico = $configs[0]['new_file'];



        }
        $uno  = $this->input->post('id_slideuno');
        $dos  = $this->input->post('id_slidedos');
        $tres  = $this->input->post('id_slidetres');
        if($uno <> 0){
            $sliders->slider_uno = null;
            $sliders->slider_uno_chico = null;
        }
        if($dos <> 0){
            $sliders->slider_dos = null;
            $sliders->slider_dos_chico = null;
        }

        if($tres <> 0){
            $sliders->slider_tres = null;
            $sliders->slider_tres_chico = null;
        }


        $contador = 0;
        foreach($sliders as $key){
            $contador++;
        }


        if($contador > 0){
            $this->db->where('id_cliente', $this->input->post('id_cliente'));
            $this->db->update('Tiendas', $sliders);
        }

        //print_r($this->input->post('id_cliente'));
        redirect('mi-cuenta/tienda');
    }

    public function cambiar_c() {
        // Config
        $datos_header['seccion_activa'] = 'mi-cuenta';
        $datos_header['subseccion_activa'] = 'cambiar-contrasena';
        $datos_header['meta']['title'] = 'Cambiar mi contraseña | Mi Cuenta | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';

        $datos_seccion['lugar'] = 'Cambiar Contraseña';

        $this->load->view('header', $datos_header);
        $this->load->view('mi-cuenta/despliegue_base', $datos_seccion);
        $this->load->view('footer');
    }

    public function cambiar_c_procesar() {
        if(!$this->input->post('contrasena_actual') || !$this->input->post('contrasena_nueva') || !$this->input->post('repetir_contrasena_nueva')) {
            $this->session->set_flashdata('error_datos', 'datos');
            redirect('mi-cuenta/cambiar-contrasena');
        } else {
            $password_actual = $this->input->post('contrasena_actual');

            $cliente_res = $this->db->get_where('Clientes', array('id_cliente' => $this->session->login['id_cliente']));
            $cliente = $cliente_res->result();

            if($password_actual != $this->encryption->decrypt($cliente[0]->password)) {
                $this->session->set_flashdata('error_datos', 'datos');
                redirect('mi-cuenta/cambiar-contrasena');
            } else {
                if($this->input->post('contrasena_nueva') != $this->input->post('repetir_contrasena_nueva')) {
                    $this->session->set_flashdata('error_datos', 'datos');
                    redirect('mi-cuenta/cambiar-contrasena');
                } else {
                    $cliente = new stdClass();
                    $cliente->password = $this->encryption->encrypt($this->input->post('contrasena_nueva'));

                    $this->db->where('id_cliente', $this->input->post('id_cliente'));
                    $this->db->update('Clientes', $cliente);

                    $contact = array(
                        "email"              => $this->session->login['email'],
                        "field[4,0]"         => $this->input->post('contrasena_nueva')
                    );
                    $contact_sync = $this->ac->api("contact/sync", $contact);

                    $this->session->set_flashdata('update_datos', 'ok');
                    redirect('mi-cuenta/cambiar-contrasena');
                }
            }
        }
    }

    public function direcciones() {
        // Config
        $datos_header['seccion_activa'] = 'mi-cuenta';
        $datos_header['subseccion_activa'] = 'direcciones';
        $datos_header['meta']['title'] = 'Mis Direcciones | Mi Cuenta | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';

        $datos_seccion['lugar'] = 'Mis Direcciones';
        $datos_seccion['direcciones'] = $this->cuenta_modelo->obtener_direcciones($this->session->login['id_cliente']);;

        $this->load->view('header', $datos_header);
        $this->load->view('mi-cuenta/despliegue_base', $datos_seccion);
        $this->load->view('footer');
    }

    public function agregar_direccion($pagar='', $nombre_tienda_slug = null) {
        $direccion = new stdClass();
        $direccion->identificador_direccion = $this->input->post('identificador_direccion');
        $direccion->linea1 = $this->input->post('linea1');
        $linea2 = $this->input->post('linea2');
        $linea2_otro = $this->input->post('linea2_otro');
        if($linea2_otro){
            if($linea2 == 'Otro') {
                $direccion->linea2 = $linea2_otro;
            }else{
                $direccion->linea2 = $linea2;
            }
        }else{
            $direccion->linea2 = $linea2;
        }
        $direccion->codigo_postal = $this->input->post('codigo_postal');
        $direccion->ciudad = $this->input->post('ciudad');
        $direccion->estado = $this->input->post('estado');
        $direccion->pais = 'México';
        $direccion->telefono = $this->input->post('telefono');
        $direccion->tipo_telefono = $this->input->post('tipo_telefono');
        $direccion->id_cliente = $this->input->post('id_cliente');
        $direccion->fecha_creacion = date('Y-m-d H:i:s');

        $this->db->insert('DireccionesPorCliente', $direccion);

        $redireccion = new stdClass();

        if($pagar == '') {
            $redireccion->url = site_url('mi-cuenta/direcciones');
        } else if($pagar == 'pagar') {
            if($nombre_tienda_slug) {
                $redireccion->url = site_url('tienda/'.$nombre_tienda_slug.'/carrito/seleccionar-direccion');
            } else {
                $redireccion->url = site_url('carrito/seleccionar-direccion');
            }
        }
        echo json_encode($redireccion);
    }

    public function editar_direccion() {
        $direccion_vieja = new stdClass();
        $direccion_vieja->estatus = 33;

        $this->db->where('id_direccion', $this->input->post('id_direccion'));
        $this->db->update('DireccionesPorCliente', $direccion_vieja);

        $direccion = new stdClass();
        $direccion->identificador_direccion = $this->input->post('identificador_direccion');
        $direccion->linea1 = $this->input->post('linea1');
        $linea2 = $this->input->post('linea2');
        $linea2_otro = $this->input->post('linea2_otro');
        if($linea2_otro){
            if($linea2 == "Otro") {
                $direccion->linea2 = $linea2_otro;
            }else{
                $direccion->linea2 = $linea2;
            }
        }else{
            $direccion->linea2 = $linea2;
        }
        $direccion->codigo_postal = $this->input->post('codigo_postal');
        $direccion->ciudad = $this->input->post('ciudad');
        $direccion->estado = $this->input->post('estado');
        $direccion->pais = 'México';
        $direccion->telefono = $this->input->post('telefono');
        $direccion->id_cliente = $this->input->post('id_cliente');
        $direccion->fecha_creacion = date('Y-m-d H:i:s');

        $this->db->insert('DireccionesPorCliente', $direccion);
        redirect('mi-cuenta/direcciones');
    }

    public function borrar_direccion() {
        $direccion_vieja = new stdClass();
        $direccion_vieja->estatus = 33;
        $id_direccion = $this->input->post('id_direccion');
        $this->db->where('id_direccion', $id_direccion);
        $this->db->update('DireccionesPorCliente', $direccion_vieja);

        if($this->session->has_userdata('direccion_temporal')){
            $this->session->unset_userdata('direccion_temporal');
        }

        redirect('mi-cuenta/direcciones');
    }

    public function pedidos($periodo = 1) {
        // Config
        $datos_header['seccion_activa'] = 'mi-cuenta';
        $datos_header['subseccion_activa'] = 'pedidos';
        $datos_header['meta']['title'] = 'Mis Pedidos | Mi Cuenta | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';

        $datos_seccion['lugar'] = 'Mis Pedidos';
        $datos_seccion['periodo'] = $periodo;
        if($periodo == 0) {
            $periodo = null;
        }
        //$datos_seccion['pedidos'] = $this->pedidos_modelo->obtener_pedidos($this->session->login['id_cliente']);
        $datos_seccion['pedidos'] = $this->pedidos_modelo->obtener_pedidos_por_cliente($this->session->login['id_cliente'], $periodo);
        $datos_seccion['direcciones_facturacion'] = $this->cuenta_modelo->obtener_direcciones_fiscales($this->session->login['id_cliente']);;

        $this->load->view('header', $datos_header);
        $this->load->view('mi-cuenta/despliegue_base', $datos_seccion);
        $this->load->view('footer');
    }

    public function solicitar_factura($id_pedido)
    {
        $id_direccion_fiscal = $this->input->post('id_direccion_fiscal');

        $cambio_pedido = new stdClass();
        $cambio_pedido->id_direccion_fiscal = $id_direccion_fiscal;

        $this->db->where('id_pedido', $id_pedido);
        $this->db->update('Pedidos', $cambio_pedido);

        $datos_correo = new stdClass();
        $datos_correo->numero_pedido = str_pad($id_pedido, 8, '0', STR_PAD_LEFT);

        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        $email_administracion = new SendGrid\Email();
        $email_administracion->addTo('administracion@printome.mx', 'Print-o-Me')
            ->setFrom('no-reply@printome.mx')
            ->setReplyTo('administracion@printome.mx')
            ->setFromName('printome.mx')
            ->setSubject('Solicitud de factura | printome.mx')
            ->setHtml($this->load->view('plantillas_correos/fyi_omar_solicitud_factura', $datos_correo, TRUE));
        $sendgrid->send($email_administracion);

        redirect('mi-cuenta/pedidos');
    }

    public function productos() {
        // Config
        $datos_header['seccion_activa'] = 'mi-cuenta';
        $datos_header['subseccion_activa'] = 'productos';
        $datos_header['meta']['title'] = 'Mis Productos | Mi Cuenta | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';

        $datos_seccion['lugar'] = 'Venta Inmediata';
        $datos_seccion['campanas'] = $this->enhance_modelo->obtener_mis_campanas($this->session->login['id_cliente'], 'fijo');

        $datos_footer['scripts'] = 'mi-cuenta/scripts';

        $this->load->view('header', $datos_header);
        $this->load->view('mi-cuenta/despliegue_base', $datos_seccion);
        $this->load->view('footer', $datos_footer);
    }

    public function productos_plazo_definido(){
        $datos_header['seccion_activa'] = 'mi-cuenta';
        $datos_header['subseccion_activa'] = 'productos_plazo_definido';
        $datos_header['meta']['title'] = 'Mis Productos | Mi Cuenta | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';

        $datos_seccion['lugar'] = 'Plazo Definido';
        $datos_seccion['campanas'] = $this->enhance_modelo->obtener_mis_campanas($this->session->login['id_cliente'], 'limitado');

        $datos_footer['scripts'] = 'mi-cuenta/scripts';

        $this->load->view('header', $datos_header);
        $this->load->view('mi-cuenta/despliegue_base', $datos_seccion);
        $this->load->view('footer', $datos_footer);
    }

    public function obtener_inmediata(){

        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');
        $orden = $this->input->post('order');

        $campanas = $this->enhance_modelo->obtener_mis_campanas_datatable($this->session->login['id_cliente'], $limit, $offset, $orden, $search, "fijo");
        $tienda = $this->tienda_m->obtener_tienda_por_id_dueno($this->session->login['id_cliente']);

        $info = new stdClass();
        $info->draw = $this->input->post('draw');
        $info->recordsTotal = $this->enhance_modelo->contar_campanas(null, $this->session->login['id_cliente'], "fijo");
        $info->recordsFiltered = $this->enhance_modelo->contar_campanas($search, $this->session->login['id_cliente'], "fijo");

        $info->data = array();

        foreach($campanas as $campana) {
            $inner_info = new stdClass();
            $name_slug = strtolower(url_title(convert_accented_characters(trim($campana->name))));
            $url = 'tienda/'.$tienda->nombre_tienda_slug.'/'.($campana->type == 'fijo' ? 'venta-inmediata' : 'plazo-definido').'/'.$name_slug.'-'.$campana->id_enhance;

            //ASIGNACION DE APARTADO DE COLUMNA PARA LA RESPONSIVIDAD $inner_info->despliegue
            $inner_info->despliegue .= '<div class="row despliegue">
                                            <div class="center">
                                                <!--Aquí debe de ir el boton-->
                                            </div>
                                        </div>';
            //ASIGNACION DE APARTADO IMAGEN DE PRODUCTOS $inner_info->imagen
            $inner_info->imagen = '<span class="hide">'.$campana->id_enhance.'</span>';
            if($campana->front_image != ""){
                $inner_info->imagen .=
                    '<a '.($campana->estatus == 1 ? 'href="'.site_url($url).'"' : ' ').'>
                    <img class="imagen-producto" src="'.site_url($campana->front_image).'" alt="Fotografía delantera" width="64" height="64"/>
                    
                </a>';
            }
            //ASIGNACION DE APARTADO DATOS DE CAMPAÑA $inner_info->campana
            $inner_info->campana .= '<div class="row">
                                        <div>
                                            <span class="titulo-campana">
                                                <a style="color: #025573" target="_blank"  '.($campana->estatus == 1 ? 'href="'.site_url($url).'"' : ' ').'">
                                                    '.$campana->name.'
                                                </a>
                                            </span>
                                            <span style="color: #FF4D00;"  class="tipo-campana">('.($campana->type == 'fijo' ? 'Venta inmediata' : 'Plazo definido').')</span>
                                        </div>
                                    </div>';

            //ASIGNACION DE APARTADO PRECIO TOTAL $inner_info->precio_total
            $inner_info->precio_total = '<div class="row">
                                            <div>
                                                <span style="color: #025573" class="data-info">$'.redondeo($campana->price).'</span>
                                            </div>';
            $inner_info->precio_total .= '</div>';

            //ASIGNACION DE APARTADO GANANCIA POR PLAYERA $inner_info->ganancia
            $ganancia = (($campana->price - $campana->costo)/(1 + $this->iva))*0.75*1;
            $inner_info->ganancia = '<div class="row">
                                            <div class="text-center">
                                                <span style="color: #025573" class="data-info">$'.number_format($ganancia, 2, '.', ',').'</span>
                                                <span style="color: #FF4D00;" class="data-title">Por Venta</span>
                                            </div>
                                        </div>';

            //ASIGNACION DE APARTADO VENDIDOS POR DISEÑO $inner_info->vendidos
            $vendidos = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
            $inner_info->vendidos = '<div class="row">
                                            <div class="text-center">
                                                <span style="color: #025573" class="data-info">'.$vendidos.'</span>
                                            </div>
                                        </div>';

            //ASIGNACION DE APARTADO TOTAL_GANANCIA $inner_info->total_ganancia
            $total_ganancia = $vendidos * $ganancia;
            $inner_info->total_ganancia = '<div class="row">
                                            <div class="text-center">
                                                <span style="color: #025573" class="data-info">$'.number_format($total_ganancia, 2, '.', ',').'</span>
                                            </div>
                                        </div>';

            //ASIGNACION DE APARTADO AVANCE $inner_info->avance
            if($campana->estatus == 1){
                $inner_info->avance .= '<span class="estatus-campana activa" style="color: #025573"><i class="fa fa-line-chart"></i> Activa</span>';
            }elseif($campana->estatus == 2){
                $inner_info->avance .= '<span class="estatus-campana negativo" style="color: #025573"><i class="fa fa-times"></i> Rechazada</span>';
            }elseif($campana->estatus == 3){
                $inner_info->avance .= '<span class="estatus-campana negativo" style="color: #025573"><i class="fa fa-ban"></i> Terminada por printome.mx</span>';
            }else{
                $inner_info->avance .= '<span class="estatus-campana revision" style="color: #025573"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i>En revisión</span>';
            }

            array_push($info->data, $inner_info);
        }

        echo json_encode($info);
    }

    public function obtener_limitada(){
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');
        $orden = $this->input->post('order');

        $campanas = $this->enhance_modelo->obtener_mis_campanas_datatable($this->session->login['id_cliente'], $limit, $offset, $orden, $search, "limitado");

        $info = new stdClass();
        $info->draw = $this->input->post('draw');
        $info->recordsTotal = $this->enhance_modelo->contar_campanas(null, $this->session->login['id_cliente'], "limitado");
        $info->recordsFiltered = $this->enhance_modelo->contar_campanas($search, $this->session->login['id_cliente'], "limitado");

        $info->data = array();
        $tienda = $this->tienda_m->obtener_tienda_por_id_dueno($this->session->login['id_cliente']);
        foreach($campanas as $campana) {
            $inner_info = new stdClass();
            $name_slug = strtolower(url_title(convert_accented_characters(trim($campana->name))));
            $url = 'tienda/'.$tienda->nombre_tienda_slug.'/'.($campana->type == 'fijo' ? 'venta-inmediata' : 'plazo-definido').'/'.$name_slug.'-'.$campana->id_enhance;
            //ASIGNACION DE APARTADO DE COLUMNA PARA LA RESPONSIVIDAD $inner_info->despliegue
            $inner_info->despliegue .= '<div class="row despliegue">
                                            <div class="center">
                                                <!--Aquí debe de ir el boton-->
                                            </div>
                                        </div>';
            //ASIGNACION DE APARTADO IMAGEN DE PRODUCTOS $inner_info->imagen
            $inner_info->imagen = '<span class="hide">'.$campana->id_enhance.'</span>';
            if($campana->front_image != ""){
                if($campana->end_date >= date("Y-m-d H:i:s")){
                    $inner_info->imagen .= '<a href="'.site_url($url).'">';
                }
                $inner_info->imagen .= '<img class="imagen-producto" src="'. site_url($campana->front_image).'" alt="Fotografía delantera" width="64" height="64">';
                if($campana->end_date >= date("Y-m-d H:i:s")){
                    $inner_info->imagen .= '</a>';
                }
            }

            //ASIGNACION DE APARTADO DATOS DE CAMPAÑA $inner_info->campana
            $inner_info->campana .= '<div class="row">
                                    <div>
                                    <span style="color: #025573" class="text-center titulo-campana">';
            if($campana->end_date >= date("Y-m-d H:i:s")){
                $inner_info->campana .= '<a href="'.site_url($url).'">';
            }
            $inner_info->campana .= $campana->name;
            if($campana->end_date >= date("Y-m-d H:i:s")){
                $inner_info->campana .= '</a>';
            }
            $inner_info->campana .= '</span>
                                    <span style="color: #FF4D00;" class="tipo-campana">('.($campana->type == 'fijo' ? 'Venta inmediata' : 'Plazo definido').')</span>
                                    </div>
                                    <div class="small-9 columns hide">
                                    <span style="color: #FF4D00;" class="data-title">Inicio</span>';
            if(!$campana->estatus){
                $inner_info->campana .= '<span style="color: #FF4D00;" class="data-info pend">Pendiente</span>';
            }else{
                $inner_info->campana .= '<span style="color: #FF4D00;" class="data-info">"'.date("d/m/Y H:i", strtotime($campana->date)).'"</span>';
            }
            $inner_info->campana .= '</div>
                                    <div class="small-9 columns hide">
                                    <span style="color: #FF4D00;" class="data-title">Fin</span>';
            if(!$campana->estatus){
                $inner_info->campana .= '<span style="color: #FF4D00;" class="data-info pend">Pendiente</span>';
            }else{
                $inner_info->campana .= '<span style="color: #FF4D00;" class="data-info">"'.date("d/m/Y H:i", strtotime($campana->end_date)).'"</span>';
            }
            $inner_info->campana .= '</div>
                                    <div class="text-center">';
            if($campana->estatus != 1){
                $inner_info->campana .= '<span style="color: #FF4D00;" class="data-info pend time">Pendiente</span>';
            }else{
                if($campana->end_date < date("Y-m-d H:i:s")){
                    $inner_info->campana .= '<span style="color: #FF4D00;" class="data-info pend time">Finalizada</span>';
                }else{
                    if(date("d", strtotime($campana->end_date)) != '01') {
                        $inner_info->campana .= '<span class="data-info time" style="color: #94D60A">Quedan: ' . date("d", strtotime($campana->end_date)) . ' días</span>';
                    }else{
                        $inner_info->campana .= '<span class="data-info time" style="color: #FF4C00">Hoy finaliza la campaña.</span>';
                    }
                }
            }
            $inner_info->campana .= '</div>
                                    </div>';

            //ASIGNACION DE APARTADO PRECIO TOTAL $inner_info->precio_total
            $inner_info->precio_total = '<div class="row">
                                            <div>
                                                <span style="color: #025573" class="data-info">$'.redondeo($campana->price).'</span>
                                            </div>';
            $inner_info->precio_total .= '</div>';

            //ASIGNACION DE APARTADO GANANCIA POR PLAYERA $inner_info->ganancia
            $ganancia = (($campana->price - $campana->costo)/(1 + $this->iva))*0.75*1;
            $inner_info->ganancia = '<div class="row">
                                            <div class="text-center">
                                                <span style="color: #025573" class="data-info">$'.number_format($ganancia, 2, '.', ',').'</span>
                                                <span style="color: #FF4D00;"  class="data-title">Por Venta</span>
                                            </div>
                                        </div>';

            //ASIGNACION DE APARTADO VENDIDOS POR DISEÑO $inner_info->vendidos
            $vendidos = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
            $inner_info->vendidos .= '<div class="row">
                                        <div>
                                            <span style="color: #025573" class="data-info">'.redondeo($vendidos).' / '. redondeo($campana->quantity).'</span>
                                        </div>
                                    </div>';

            //ASIGNACION DE APARTADO TOTAL_GANANCIA $inner_info->total_ganancia
            $total_ganancia = $vendidos * $ganancia;
            $inner_info->total_ganancia = '<div class="row">
                                            <div class="text-center">
                                                <span style="color: #025573" class="data-info">$'.number_format($total_ganancia, 2, '.', ',').'</span>
                                            </div>
                                        </div>';

            //ASIGNACION DE APARTADO AVANCE $inner_info->avance
            if($campana->estatus == 1){
                if($campana->end_date < date("Y-m-d H:i:s")){
                    $inner_info->avance .= '<span style="color: #025573" class="estatus-campana activa"><i class="fa fa-check"></i> Finalizada</span>';
                }else{
                    $inner_info->avance .= '<span style="color: #025573" class="estatus-campana activa"><i class="fa fa-line-chart"></i> Activa</span>';
                }
            }elseif($campana->estatus == 2){
                $inner_info->avance .= '<span style="color: #025573" class="estatus-campana negativo"><i class="fa fa-times"></i> Rechazada</span>';
            }elseif($campana->estatus == 3){
                $inner_info->avance .= '<span style="color: #025573" class="estatus-campana negativo"><i class="fa fa-ban"></i> Terminada por printome.mx</span>';
            }else{
                $inner_info->avance .= '<span style="color: #025573" class="estatus-campana revision"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i>En revisión</span>';
            }

            array_push($info->data, $inner_info);
        }

        echo json_encode($info);
    }

    public function bancarios() {
        // Config
        $datos_header['seccion_activa'] = 'mi-cuenta';
        $datos_header['subseccion_activa'] = 'datos-bancarios';
        $datos_header['meta']['title'] = 'Mis Datos de Depósito | Mi Cuenta | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';

        $datos_seccion['lugar'] = 'Mis Datos de Depósito';
        $datos_seccion['dato_deposito'] = $this->cuenta_modelo->obtener_dato_deposito_reciente($this->session->login['id_cliente']);
        $datos_footer['scripts'] = 'mi-cuenta/scripts';

        $this->load->view('header', $datos_header);
        $this->load->view('mi-cuenta/despliegue_base', $datos_seccion);
        $this->load->view('footer', $datos_footer);
    }

    public function bancarios_actualizar() {
        $info = $this->input->post('info_pago');

        if(!isset($info['tipo_pago']) || $info['tipo_pago'] == '') {
            redirect('mi-cuenta/datos-bancarios');
        } else {
            // Obtener el ultimo registro de ese cliente
            $ultimo_dato = $this->cuenta_modelo->obtener_dato_deposito_reciente($this->session->login['id_cliente']);

            if(isset($ultimo_dato->tipo_pago)) {
                $actualizacion = true;
            } else {
                $actualizacion = false;
            }

            $info_pago_nuevo = new stdClass();

            if($info['tipo_pago'] == 'banco') {
                $info_pago_nuevo->tipo_pago = 'banco';
                $info_pago_nuevo->datos_json = new stdClass();
                $info_pago_nuevo->datos_json->nombre_cuentahabiente = $info['nombre_cuentahabiente'];
                $info_pago_nuevo->datos_json->nombre_banco = $info['nombre_banco'];
                $info_pago_nuevo->datos_json->clabe = $info['clabe'];
                $info_pago_nuevo->datos_json->cuenta = $info['cuenta'];
                $info_pago_nuevo->datos_json->ciudad = $info['ciudad'];
                $info_pago_nuevo->datos_json->sucursal = $info['sucursal'];
                $info_pago_nuevo->estatus = 1;
                $info_pago_nuevo->fecha_agregado = date("Y-m-d H:i:s");
                if($actualizacion) {
                    $info_pago_nuevo->fecha_modificado = date("Y-m-d H:i:s");
                }
                $info_pago_nuevo->id_cliente = $this->session->login['id_cliente'];

                $info_pago_nuevo->datos_json = json_encode($info_pago_nuevo->datos_json);
            } else if($info['tipo_pago'] == 'paypal') {
                $info_pago_nuevo->tipo_pago = 'paypal';
                $info_pago_nuevo->datos_json = new stdClass();
                $info_pago_nuevo->datos_json->cuenta_paypal = $info['cuenta_paypal'];
                $info_pago_nuevo->estatus = 1;
                $info_pago_nuevo->fecha_agregado = date("Y-m-d H:i:s");
                if($actualizacion) {
                    $info_pago_nuevo->fecha_modificado = date("Y-m-d H:i:s");
                }
                $info_pago_nuevo->id_cliente = $this->session->login['id_cliente'];

                $info_pago_nuevo->datos_json = json_encode($info_pago_nuevo->datos_json);
            } else {
                redirect('mi-cuenta/datos-bancarios');
            }

            $this->db->insert('DatosDepositoPorCliente', $info_pago_nuevo);
            $id_dato_deposito = $this->db->insert_id();

            $this->db->query("UPDATE DatosDepositoPorCliente SET estatus=0 WHERE id_cliente=".$this->session->login['id_cliente']." AND id_dato_deposito<".$id_dato_deposito);

            redirect('mi-cuenta/datos-bancarios');
        }
    }

    public function favoritos(){
        // Config
        $datos_header['seccion_activa'] = 'mi-cuenta';
        $datos_header['subseccion_activa'] = 'favoritos';
        $datos_header['meta']['title'] = 'Mis Favoritos | Mi Cuenta | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';

        $datos_seccion['lugar'] = 'Mis Favoritos';
        $datos_seccion['favoritos'] = $this->cuenta_modelo->obtener_lista($this->session->login['id_cliente']);
        $datos_footer['scripts'] = 'mi-cuenta/scripts';

        $this->load->view('header', $datos_header);
        $this->load->view('mi-cuenta/despliegue_base', $datos_seccion);
        $this->load->view('footer', $datos_footer);
    }

    public function agregar_favorito($id_enhance, $id_producto){
        $this->db->select('*');
        $this->db->from('ListasProductos');
        $this->db->where('id_producto', $id_producto);
        $this->db->where('id_enh', $id_enhance);
        $this->db->where('id_cliente', $this->session->login['id_cliente']);
        $producto_res = $this->db->get();
        $producto = $producto_res->result();

        if (sizeof($producto)>0) {
            redirect('mi-cuenta/favoritos');
        }else{
            $lista = new stdClass();
            $lista->id_producto = $id_producto;
            $lista->id_cliente = $this->session->login['id_cliente'];
            $lista->fecha_agregado = date('Y-m-d H:i:s');
            $lista->id_enh = $id_enhance;

            $this->db->insert('ListasProductos', $lista);
            redirect('mi-cuenta/favoritos');
        }
    }

    public function quitar_favorito($id_enhance, $id_producto){
        $this->db->where('id_producto', $id_producto);
        $this->db->where('id_enh', $id_enhance);
        $this->db->where('id_cliente', $this->session->login['id_cliente']);
        $this->db->delete('ListasProductos');

        redirect('mi-cuenta/favoritos');
    }

    public function devolver()
    {
        $devolucion = new stdClass();
        $devolucion->id_pedido = $this->input->post('pedido');
        $devolucion->fecha_devolucion = date('Y-m-d H:i:s');

        $this->db->insert('Devoluciones', $devolucion);

        $productos = $this->input->post('devolver');

        $devolucion->id= $this->db->insert_id();

        $data = [];

        foreach ($productos as $key => $value) {
            $data[] = array(
                "id_ppp" => $value,
                "id_devolucion" => $devolucion->id
            );
        }

        $this->db->insert_batch('ProductosDevueltos', $data);

        $this->load->library('email');

        $this->db->select('*');
        $this->db->from('Pedidos');
        $this->db->join('Clientes', 'Pedidos.id_cliente=Clientes.id_cliente', "left");
        $this->db->where('id_pedido', $devolucion->id_pedido);
        $query = $this->db->get();

        $client = $query->result()[0];

        $this->db->select('CatalogoProductos.nombre_producto');
        $this->db->from('ProductosPorPedido');
        $this->db->join('CatalogoSkuPorProducto', 'ProductosPorPedido.id_sku=CatalogoSkuPorProducto.id_sku', "left");
        $this->db->join('ColoresPorProducto', 'CatalogoSkuPorProducto.id_color=ColoresPorProducto.id_color', "left");
        $this->db->join('CatalogoProductos', 'ColoresPorProducto.id_producto=CatalogoProductos.id_producto', "left");
        foreach ($productos as $key => $value) {
            $this->db->where('id_ppp', $value);
        }
        $query = $this->db->get();
        $productos = $query->result();

        $str_productos = "";

        foreach ($productos as $producto) {
            $str_productos .= $producto->nombre_producto . ", ";
        }
        $str_productos = trim($str_productos);

        $this->email->from('no-reply@Print-o-Me.com.mx', 'Print-o-Me');
        $this->email->to("devoluciones@Print-o-Me.com.mx");

        $this->email->subject('Pedido Actualizado');
        $this->email->message('Usuario '. $client->nombres. ' ' . $client->apellidos .' ha solicitado una devolución en la orden ' . $client->id_pedido .', para los productos : ' . $str_productos);

        $this->email->send();

        redirect('mi-cuenta/pedidos');
    }

    public function facturacion() {
        // Config
        $datos_header['seccion_activa'] = 'mi-cuenta';
        $datos_header['subseccion_activa'] = 'facturacion';
        $datos_header['meta']['title'] = 'Mis Datos de Facturación | Mi Cuenta | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';

        $datos_seccion['lugar'] = 'Mis Datos de Facturación';
        $datos_seccion['direcciones'] = $this->cuenta_modelo->obtener_direcciones_fiscales($this->session->login['id_cliente']);;

        $this->load->view('header', $datos_header);
        $this->load->view('mi-cuenta/despliegue_base', $datos_seccion);
        $this->load->view('footer');
    }

    public function agregar_facturacion($pagar='', $nombre_tienda_slug = null) {
        $direccion = new stdClass();
        $direccion->razon_social = $this->input->post('razon_social');
        $direccion->rfc = $this->input->post('rfc');
        $direccion->cfdi = $this->input->post('cfdi');
        $direccion->linea1 = $this->input->post('linea1');
        $linea2 = $this->input->post('linea2');
        $linea2_otro = $this->input->post('linea2_otro');
        if($linea2_otro){
            if($linea2 == "Otro") {
                $direccion->linea2 = $linea2_otro;
            }else{
                $direccion->linea2 = $linea2;
            }
        }else{
            $direccion->linea2 = $linea2;
        }
        $direccion->codigo_postal = $this->input->post('codigo_postal');
        $direccion->ciudad = $this->input->post('ciudad');
        $direccion->estado = $this->input->post('estado');
        $direccion->pais = 'México';
        $direccion->id_cliente = $this->input->post('id_cliente');
        $direccion->fecha_creacion = date('Y-m-d H:i:s');
        $direccion->correo_electronico_facturacion = $this->input->post('correo_electronico_facturacion');
        $direccion->telefono = $this->input->post('telefono');

        $this->db->insert('DireccionesFiscalesPorCliente', $direccion);

        $redireccion = new stdClass();
        if($pagar == '') {
            $redireccion->url = site_url('mi-cuenta/facturacion');
        } else if($pagar == 'pagar') {
            if($nombre_tienda_slug) {
                $redireccion->url = site_url('tienda/'.$nombre_tienda_slug.'/carrito/seleccionar-direccion');
            } else {
                $redireccion->url = site_url('carrito/seleccionar-direccion');
            }
        }
        echo json_encode($redireccion);
    }

    public function editar_facturacion() {
        $direccion_vieja = new stdClass();
        $direccion_vieja->estatus = 33;

        $this->db->where('id_direccion_fiscal', $this->input->post('id_direccion_fiscal'));
        $this->db->update('DireccionesFiscalesPorCliente', $direccion_vieja);

        $direccion = new stdClass();
        $direccion->razon_social = $this->input->post('razon_social');
        $direccion->rfc = $this->input->post('rfc');
        $direccion->cfdi = $this->input->post('cfdi');
        $direccion->linea1 = $this->input->post('linea1');
        $linea2 = $this->input->post('linea2');
        $linea2_otro = $this->input->post('linea2_otro');
        if($linea2_otro){
            if($linea2 == "Otro") {
                $direccion->linea2 = $linea2_otro;
            }else{
                $direccion->linea2 = $linea2;
            }
        }else{
            $direccion->linea2 = $linea2;
        }
        $direccion->codigo_postal = $this->input->post('codigo_postal');
        $direccion->ciudad = $this->input->post('ciudad');
        $direccion->estado = $this->input->post('estado');
        $direccion->pais = 'México';
        $direccion->id_cliente = $this->input->post('id_cliente');
        $direccion->fecha_creacion = date('Y-m-d H:i:s');
        $direccion->correo_electronico_facturacion = $this->input->post('correo_electronico_facturacion');
        $direccion->telefono = $this->input->post('telefono');

        $this->db->insert('DireccionesFiscalesPorCliente', $direccion);
        redirect('mi-cuenta/facturacion');
    }

    public function borrar_facturacion() {
        $direccion_vieja = new stdClass();
        $direccion_vieja->estatus = 33;

        $this->db->where('id_direccion_fiscal', $this->input->post('id_direccion_fiscal'));
        $this->db->update('DireccionesFiscalesPorCliente', $direccion_vieja);

        if($this->session->has_userdata('direccion_fiscal_temporal')){
            $this->session->unset_userdata('direccion_fiscal_temporal');
        }

        redirect('mi-cuenta/facturacion');
    }

    public function puntos_printome(){
        $datos_header['seccion_activa'] = 'mi-cuenta';
        $datos_header['subseccion_activa'] = 'puntos';
        $datos_header['meta']['title'] = 'Mis Puntos Printome | Mi Cuenta | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';

        $referencia = $this->referencias_modelo->obtener_referencia_cliente($this->session->login['id_cliente']);
        $cupon = $this->referencias_modelo->obtener_cupon_referencia($referencia->id_cupon);
        $nivel_usuario = $this->referencias_modelo->obtener_nivel_referencia($referencia->id_nivel);
        $experiencia_actual = number_format($referencia->experiencia, 0, '', '');
        $experiencia_meta = number_format($nivel_usuario->maximo_ventas + 0.01, 0, '', '');

        $porcentaje_experiencia = ($experiencia_actual * 100)/$experiencia_meta;
        if($nivel_usuario->id_nivel != 6) {
            $siguiente_nivel = $this->referencias_modelo->obtener_nivel_referencia($referencia->id_nivel + 1);
        }else{
            $siguiente_nivel = "max";
        }

        $datos_seccion['nombre_nivel'] = $nivel_usuario->nombre_nivel;
        $datos_seccion['referencias'] = $this->referencias_modelo->obtener_referencias_cliente($this->session->login['id_cliente']);
        $datos_seccion['porcentaje_experiencia'] = $porcentaje_experiencia;
        $datos_seccion['experiencia_actual'] = $experiencia_actual;
        $datos_seccion['experiencia_meta'] = $experiencia_meta;
        $datos_seccion['experiencia_faltante'] = $experiencia_meta - $experiencia_actual;
        $datos_seccion['cupon'] = $cupon->cupon;

        $datos_seccion['lugar'] = 'Mis Puntos Printome';
        $datos_seccion['imagen'] = 'assets/niveles/'.$nivel_usuario->nombre_nivel_slug.'.gif';
        $datos_seccion['puntos'] = $this->cart->obtener_saldo_a_favor();
        $datos_seccion['siguiente_nivel'] = $siguiente_nivel;

        $datos_footer['scripts'] = 'mi-cuenta/scripts';

        $this->load->view('header', $datos_header);
        $this->load->view('mi-cuenta/despliegue_base', $datos_seccion);
        $this->load->view('footer', $datos_footer);
    }

    public function obtener_referencias_cliente(){
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');
        $orden = $this->input->post('order');

        $referencias = $this->referencias_modelo->obtener_referencias_datatable($this->session->login['id_cliente'], $limit, $offset, $orden);

        $info = new stdClass();
        $info->draw = $this->input->post('draw');
        $info->recordsTotal = $this->referencias_modelo->contar_referencias($this->session->login['id_cliente']);
        $info->recordsFiltered = $this->referencias_modelo->contar_referencias($this->session->login['id_cliente']);

        $info->data = array();

        foreach($referencias as $indice => $referencia) {
            $inner_info = new stdClass();
            //$inner_info->fecha
            $inner_info->fecha .= "<div style='text-align: center'>".date("Y-m-d", strtotime($referencia->fecha))."</div>";
            //$inner_info->experiencia
            $inner_info->experiencia .= "<div style='text-align: center'>".number_format($referencia->experiencia, 0, '', '')."</div>";
            //$inner_info->puntos
            $inner_info->puntos .= "<div style='text-align: center'>".number_format($referencia->puntos, 0, '', '')."</div>";
            if($referencia->experiencia > 0) {
                array_push($info->data, $inner_info);
            }
        }
        echo json_encode($info);
    }

    public function cambiar_codigo_referencia(){
        $nuevo_codigo = $this->input->post('nuevo_cupon');
        $id_cliente = $this->input->post('id_cliente');
        $viejo_codigo = $this->input->post('viejo_cupon');
        $nuevo_codigo = preg_replace('/\s*/', '', $nuevo_codigo);
        $nuevo_codigo = strtoupper($nuevo_codigo);
        if($nuevo_codigo == $viejo_codigo){
            $this->session->set_flashdata('update_referencia', 'success');
        }else{
            $verificacion = $this->cuenta_modelo->verificar_nueva_referencia($nuevo_codigo);
            if($verificacion){
                $this->session->set_flashdata('update_referencia', 'existe');

            }else{
                $this->cuenta_modelo->guardar_nueva_referencia($id_cliente, $nuevo_codigo, $viejo_codigo);
                $this->session->set_flashdata('update_referencia', 'success');
            }
        }
        redirect('mi-cuenta/datos');
    }

}
