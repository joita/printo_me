<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devoluciones extends MY_Admin {

	public function index() {
		$datos['seccion_activa'] = 'devoluciones';
		$contenido['accion'] = 'despliegue';
		$contenido['devoluciones'] = $this->devoluciones_modelo->all();

		
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/devoluciones/devoluciones', $contenido);
	
		$this->load->view('administracion/footer', array());
	}
	
	function devolucion($id_devolucion){
		$datos['seccion_activa'] = 'devoluciones';
		$contenido['accion'] = 'despliegue';
		$contenido['devoluciones'] = 'despliegue';
		$contenido['id_devolucion'] = $id_devolucion;
		$contenido['productos'] = $this->devoluciones_modelo->get($id_devolucion);

		$contenido['estatus'] = $contenido['productos'][0]->estatus;

		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/devoluciones/devolucion', $contenido);
	
		$this->load->view('administracion/footer', array());

	}

	public function actualizar($id_devolucion)
	{
		$nuevos_datos = new stdClass();
		if ($this->input->post('action')['aprobar']) {
			$nuevos_datos->estatus = 1;
		}else{
			$nuevos_datos->estatus = 2;
		}
		
		
		$this->db->where('id_devolucion', $id_devolucion);
		$this->db->update('Devoluciones', $nuevos_datos);

		
		redirect('administracion/devoluciones');
	}

}
