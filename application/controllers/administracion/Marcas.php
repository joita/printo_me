<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marcas extends MY_Admin {

	public function index() {
		$datos['seccion_activa'] = 'marcas';
		
		$footer_datos['scripts'] = 'administracion/marcas/scripts';
		
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/marcas/marcas');
		$this->load->view('administracion/footer', $footer_datos);
	}
	
	public function agregar() {
		
		$marca = new stdClass();
		$marca->nombre_marca = $this->input->post('nombre_marca');
		$marca->nombre_marca_slug = url_title($this->input->post('nombre_marca'), '-', TRUE);
		$marca->estatus = 1;
		
		$this->db->insert('Marcas', $marca);
		
		redirect('administracion/marcas');
	}
	
	public function modificar() {
		
		$marca = new stdClass();
		$marca->nombre_marca = $this->input->post('nombre_marca');
		$marca->nombre_marca_slug = url_title($this->input->post('nombre_marca'), '-', TRUE);
		
		$id_marca = $this->input->post('id_marca');
		
		$this->db->where('id_marca', $id_marca);
		$this->db->update('Marcas', $marca);
		
		redirect('administracion/marcas');
	}
	
	public function borrar() {
		$id_marca = $this->input->post('id_marca');
		
		$marca['estatus'] = 33;
		$this->db->where('id_marca', $id_marca);
		$this->db->update('Marcas', $marca);
		
		redirect('administracion/marcas');
	}
	
	public function estatus() {
		$id_marca = $this->input->post('id_marca');
		
		$marca['estatus'] = $this->input->post('estatus');
		$this->db->where('id_marca', $id_marca);
		$this->db->update('Marcas', $marca);
		
		return true;
	}
	
}
