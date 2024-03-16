<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion extends MY_Admin {

	public function index() {
		$datos['seccion_activa'] = 'configuracion';
		
		$footer_datos['scripts'] = 'administracion/configuracion/scripts';
		
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/configuracion/configuracion');
		$this->load->view('administracion/footer', $footer_datos);
	}
	
	public function agregar() {
		
	}
	
	public function modificar() {
		foreach($this->input->post('configuracion') as $id_configuracion=>$valor) {
			$sql = "UPDATE Configuracion SET valor_configuracion='".$valor."' WHERE id_configuracion=".$id_configuracion;
			$this->db->query($sql);
		}
		redirect('administracion/configuracion');
	}
	
	public function borrar() {
		
	}
	
	public function estatus() {
		
	}
	
}
