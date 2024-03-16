<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caracteristicas extends MY_Admin {

	protected $_folder = 'caracteristicas';
	protected $_table = 'CaracteristicasAdicionales';
	protected $_id = 'id_caracteristica';
	protected $_idRel = 'id_caracteristica_parent';

	public function __construct()
	{
		parent::__construct();
		$this->class = strtolower(get_class());
	}

	public function index() {
		$datos['seccion_activa'] = 'caracteristicas';
		
		$footer_datos['scripts'] = 'administracion/'.$this->_folder.'/scripts';
		$contenido['class'] = $this->class;
		$contenido['tipos'] = $this->db->get_where('TiposDeProducto', array('estatus' => 1));
		$contenido['caracteristicas'] = $this->caracteristica_modelo->obtener_caracteristica();
		
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/'.$this->_folder.'/list', $contenido);
		$this->load->view('administracion/footer', $footer_datos);
	}
	
	public function agregar($categoria_slug) {
		$data['nombre_caracteristica'] = $this->input->post('nombre');
		$data['id_tipo'] = $this->input->post('id_tipo');
		$data['nombre_caracteristica_slug'] = url_title($this->input->post('nombre'), '-', TRUE);
		$data['id_caracteristica_parent'] = 0;
		$data['estatus'] = 1;
		$this->db->insert($this->_table, $data);
		redirect('administracion/tipos/'.$categoria_slug);
	}
	
	public function editar($categoria_slug) {
		$data['nombre_caracteristica'] = $this->input->post('nombre');
		//$data['id_tipo'] = $this->input->post('id_tipo');
		$data['nombre_caracteristica_slug'] = url_title($this->input->post('nombre'), '-', TRUE);
		$this->db->where($this->_id, $this->input->post('id'));
		$this->db->update($this->_table, $data);
		//$this->db->where($this->_idRel, $this->input->post('id'));
		//$update_tipo = array('id_tipo' => $this->input->post('id_tipo'));
		//$this->db->update($this->_table, $update_tipo);
		redirect('administracion/tipos/'.$categoria_slug);
	}
	
	public function agregar_sub($categoria_slug) {
		$data['nombre_caracteristica'] = $this->input->post('nombre');
		$data['id_tipo'] = $this->input->post('id_tipo');
		$data['nombre_caracteristica_slug'] = url_title($this->input->post('nombre'), '-', TRUE);
		$data['id_caracteristica_parent'] = $this->input->post('id_parent');
		$data['estatus'] = 1;
		$this->db->insert($this->_table, $data);
		redirect('administracion/tipos/'.$categoria_slug);
	}
	
	public function editar_sub($categoria_slug) {
		$data['nombre_caracteristica'] = $this->input->post('nombre');
		$data['nombre_caracteristica_slug'] = url_title($this->input->post('nombre'), '-', TRUE);
		$this->db->where($this->_id, $this->input->post('id'));
		$this->db->update($this->_table, $data);
		redirect('administracion/tipos/'.$categoria_slug);
	}
	
	public function estatus() {
		$id_parent = $this->input->post('id_parent');
		$id = $this->input->post('id');
		if($id_parent == 0) {			
			$data['estatus'] = $this->input->post('estatus');
			$this->db->where($this->_idRel, $id);
			$this->db->or_where($this->_id, $id);
			$this->db->update($this->_table, $data);
		} else {
			$data['estatus'] = $this->input->post('estatus');
			$this->db->where($this->_id, $id);
			$this->db->update($this->_table, $data);
		}
		
		redirect('administracion/tipos');
	}
	
	public function borrar($categoria_slug) {
		$id = $this->input->post('id');
		$data['estatus'] = 33;
		$this->db->where($this->_id, $id);
		$this->db->update($this->_table, $data);
		redirect('administracion/tipos/'.$categoria_slug);
	}
	
}