<!--Creado por Fabiola Medina
Fecha 20/04/2021
Descripción sección Comprar del nuevo diseño 2021 Adivor-->

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comprar extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){

        // Config
        $datos_header['seccion_activa'] = 'comprar';
        $datos_header['meta']['title'] = '¡Personaliza tus playeras con Printome!';
        $datos_header['meta']['description'] = 'Si no sabes que diseño poner en tu playera y necesitas ayuda profesional, nosotros te apoyamos.';
        $datos_header['meta']['imagen'] = '';
        $datos_seccion['slidescomprar'] = $this->slider_modelo->obtener_slidersactivos_comprar();
        $datos_seccion['wowwinner'] = $this->wowwinners_modelo->obtener_campanas_wow();
        $datos_seccion['masvendidos'] = $this->masvendidos_modelo->obtener_masvendidos_usuario();
        $datos_seccion['tiendas'] = $this->tienda_m->obtener_tiendas_vip();

        $this->load->view('header', $datos_header);
        $this->load->view('comprar/index',$datos_seccion);
        $this->load->view('reveals/contacto_page',array('asunto' => 'Contacto desde printome.mx', 'lugar' => current_url(), 'placeholder' => 'Contáctanos y resolveremos cualquier duda que pudieras tener sobre nuestro servicio.'));
        $this->load->view('footer');
    }
}
