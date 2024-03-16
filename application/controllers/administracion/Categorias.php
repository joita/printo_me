<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends MY_Admin {

	public function index() {
		$datos['seccion_activa'] = 'categorias';
		
		$footer_datos['scripts'] = 'administracion/categorias/scripts';
		
		$contenido['categorias'] = $this->categoria->obtener_categorias_admin();
		
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/categorias/categorias', $contenido);
		$this->load->view('administracion/footer', $footer_datos);
	}
	
	public function agregar_categoria() {
		$categoria['nombre_categoria'] = $this->input->post('nombre_categoria');
		$categoria['nombre_categoria_slug'] = url_title($this->input->post('nombre_categoria'), '-', TRUE);
		$categoria['id_categoria_parent'] = 0;
		$categoria['estatus'] = 1;
		
		$this->db->insert('Categorias', $categoria);
		
		redirect('administracion/categorias');
	}
	
	public function editar_categoria() {
		$categoria['nombre_categoria'] = $this->input->post('nombre_categoria');
		$categoria['nombre_categoria_slug'] = url_title($this->input->post('nombre_categoria'), '-', TRUE);

		$this->db->where('id_categoria', $this->input->post('id_categoria'));
		$this->db->update('Categorias', $categoria);
		
		redirect('administracion/categorias');
	}
	
	public function agregar_subcategoria() {
		$categoria['nombre_categoria'] = $this->input->post('nombre_categoria');
		$categoria['nombre_categoria_slug'] = url_title($this->input->post('nombre_categoria'), '-', TRUE);
		$categoria['id_categoria_parent'] = $this->input->post('id_categoria_parent');
		$categoria['estatus'] = 1;
		
		$this->db->insert('Categorias', $categoria);
		
		redirect('administracion/categorias');
	}
	
	public function editar_subcategoria() {
		$categoria['nombre_categoria'] = $this->input->post('nombre_categoria');
		$categoria['nombre_categoria_slug'] = url_title($this->input->post('nombre_categoria'), '-', TRUE);
		
		$this->db->where('id_categoria', $this->input->post('id_categoria'));
		$this->db->update('Categorias', $categoria);
		
		redirect('administracion/categorias');
	}
	
	public function estatus() {
		$id_categoria_parent = $this->input->post('id_categoria_parent');
		$id_categoria = $this->input->post('id_categoria');
		
		if($id_categoria_parent == 0) {			
			$categoria['estatus'] = $this->input->post('estatus');
			$this->db->where('id_categoria_parent', $id_categoria);
			$this->db->or_where('id_categoria', $id_categoria);
			$this->db->update('Categorias', $categoria);
			
		} else {
			$categoria['estatus'] = $this->input->post('estatus');
			$this->db->where('id_categoria', $id_categoria);
			$this->db->update('Categorias', $categoria);
		}
		
		redirect('administracion/categorias');
	}
	
	public function borrar_categoria() {
		$id_categoria = $this->input->post('id_categoria');
		
		$categoria['estatus'] = 33;
		$this->db->where('id_categoria', $id_categoria);
		$this->db->update('Categorias', $categoria);
		
		redirect('administracion/categorias');
	}
	
}
