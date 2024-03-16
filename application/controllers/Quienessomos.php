<!--Creado por Fabiola Medina
Fecha 20/04/2021
Descripción sección Quienes somos del nuevo diseño 2021 Adivor-->

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quienessomos extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){

        // Config
        $datos_header['seccion_activa'] = 'quienessomos';
        $datos_header['meta']['title'] = '¡Personaliza tus playeras con Printome!';
        $datos_header['meta']['description'] = 'Si no sabes que diseño poner en tu playera y necesitas ayuda profesional, nosotros te apoyamos.';
        $datos_header['meta']['imagen'] = '';

        $this->load->view('header', $datos_header);
        $this->load->view('quienes_somos/index');
        $this->load->view('reveals/contacto_page',array('asunto' => 'Contacto desde printome.mx', 'lugar' => current_url(), 'placeholder' => 'Contáctanos y resolveremos cualquier duda que pudieras tener sobre nuestro servicio.'));
        $this->load->view('footer');
    }
}
