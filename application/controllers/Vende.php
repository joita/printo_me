<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vende extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index(){

		// Config
		$datos_header['seccion_activa'] = 'vende';
		$datos_header['meta']['title'] = '¡Vende tus diseños con Printome!';
		$datos_header['meta']['description'] = 'Nunca había sido tan fácil vender tus diseños de playera, aprovecha el crowd funding para vender camisetas y hacer dinero sin tener que invertir un centavo.';
		$datos_header['meta']['imagen'] = '';

		$this->load->view('header', $datos_header);
		$this->load->view('vende/video_vende');
		$this->load->view('vende/contenido_vende');
		//$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
	}

	public function asociaciones()
    {

		// Config
		$datos_header['seccion_activa'] = 'asociaciones';
		$datos_header['meta']['title'] = '¡Recauda fondos con Printome!';
		$datos_header['meta']['description'] = '¿Eres una Asociación Civil y necesitas recaudar fondos para una causa? Mira lo que Printome puede hacer por ti';
		$datos_header['meta']['imagen'] = '';

		$this->load->view('header', $datos_header);
		$this->load->view('vende/video_ac');
		$this->load->view('vende/contenido_ac');
		$this->load->view('inicio/loquedicen');
		$this->load->view('reveals/contacto_ac');
		$this->load->view('footer');
	}

	public function servicios()
    {

		// Config
		$datos_header['seccion_activa'] = 'servicios';
		$datos_header['meta']['title'] = '¡Te apoyamos para diseñar tu playera en Printome!';
		$datos_header['meta']['description'] = 'Si no sabes que diseño poner en tu playera y necesitas ayuda profesional, nosotros te apoyamos.';
		$datos_header['meta']['imagen'] = '';

		$this->load->view('header', $datos_header);
		$this->load->view('vende/video_servicios');
        $this->load->view('vende/contenido_servicios');
		$this->load->view('footer');
	}

    public function cotiza()
    {
		// Config
		$datos_header['seccion_activa'] = 'cotiza';
		$datos_header['meta']['title'] = '¡Cotiza tus playeras con un agente especializado!';
		$datos_header['meta']['description'] = 'Si no sabes que diseño poner en tu playera y necesitas ayuda profesional, nosotros te apoyamos.';
		$datos_header['meta']['imagen'] = '';

		$this->load->view('header', $datos_header);
		$this->load->view('vende/video_cotiza');
        $this->load->view('vende/contenido_cotiza');
		$this->load->view('footer');
    }

	public function contacto_ac()
	{
		$datos = new stdClass();
		$datos->nombre = $this->input->post('nombre');
		$datos->nombre_ac = $this->input->post('nombre_ac');
		$datos->email = $this->input->post('email');
		$datos->telefono = $this->input->post('telefono');
		$datos->mensaje = $this->input->post('mensaje');

		if($datos->email != '' && valid_email($datos->email)) {
			$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);

			$email = new SendGrid\Email();
			$email->addTo('hello@printome.mx', 'printome.mx')
				  ->setFrom('no-reply@printome.mx')
				  ->setReplyTo($datos->email)
				  ->setFromName($datos->nombre)
				  ->setSubject('Contacto de asociaciones civiles | printome.mx')
				  ->setHtml($this->load->view('plantillas_correos/nuevas/contacto_ac', $datos, TRUE))
			;

			$contact = array(
				"email"              => $datos->email,
				"first_name"         => $datos->nombre,
				"last_name"          => '',
				"phone"				 => $datos->telefono,
				"orgname"			 => $datos->nombre_ac,
				"p[10]"              => '10',
				"status[10]"         => 1,
				"tags"				 => "asociacion-civil"
			);
			$contact_sync = $this->ac->api("contact/sync", $contact);

			if($sendgrid->send($email)) {
				echo json_encode(array('resultado' => 'exito'));
			} else {
				echo json_encode(array('resultado' => 'error'));
			}
		} else {
			echo json_encode(array('resultado' => 'error'));
		}
	}

}
