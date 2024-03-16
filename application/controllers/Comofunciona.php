<!--Creado por Fabiola Medina
Fecha 13/04/2021
Descripción sección cómo funciona del nuevo diseño 2021 Adivor-->

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comofunciona extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){

        // Config
        $datos_header['seccion_activa'] = 'funciona';
        $datos_header['meta']['title'] = '¡Personaliza tus playeras con Printome!';
        $datos_header['meta']['description'] = 'Si no sabes que diseño poner en tu playera y necesitas ayuda profesional, nosotros te apoyamos.';
        $datos_header['meta']['imagen'] = '';
        $datos_seccion['testimonios'] = $this->enhance_modelo->obtener_publicaciones_blog_printome(6);

        $this->load->view('header', $datos_header);
        $this->load->view('como_funciona/index',$datos_seccion);
        $this->load->view('como_funciona/contactanos');
        $this->load->view('reveals/contacto_page',array('asunto' => 'Contacto desde printome.mx', 'lugar' => current_url(), 'placeholder' => 'Contáctanos y resolveremos cualquier duda que pudieras tener sobre nuestro servicio.'));
        $this->load->view('footer');
    }
}
