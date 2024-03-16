<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonios extends MY_Admin {

	public function index($categoria_slug = null) {
		$datos_header['seccion_activa'] = 'testimonios';
        $datos['testimonios'] = $this->testimonios_m->obtener_testimonios_admin();
        $datos_footer['scripts'] = 'administracion/testimonios/scripts';

		$this->load->view('administracion/header', $datos_header);
        $this->load->view('administracion/testimonios/index', $datos);
		$this->load->view('administracion/footer', $datos_footer);
	}

    public function aprobar($id_testimonio)
    {
        $this->db->query("UPDATE CalificacionesPrintome SET estatus=1 WHERE id_calificacion=".$id_testimonio);

        redirect('administracion/testimonios');
    }

    public function borrar($id_testimonio)
    {
        $this->db->query("UPDATE CalificacionesPrintome SET estatus=33 WHERE id_calificacion=".$id_testimonio);

        redirect('administracion/testimonios');
    }

    public function responder($id_testimonio){
	    redirect('administracion/respuestas/'.$id_testimonio);
    }

    public function desaprobar($id_testimonio)
    {
        $this->db->query("UPDATE CalificacionesPrintome SET estatus=0 WHERE id_calificacion=".$id_testimonio);

        redirect('administracion/testimonios');
    }

}
