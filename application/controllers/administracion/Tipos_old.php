<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipos extends MY_Admin {

	public function index() {
		$datos['seccion_activa'] = 'tipos';
		
		$footer_datos['scripts'] = 'administracion/tipos/scripts';
		
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/tipos/tipos');
		$this->load->view('administracion/footer', $footer_datos);
	}
	
	public function agregar() {
		
		$tipo = new stdClass();
		$tipo->nombre_tipo = $this->input->post('nombre_tipo');
		$tipo->nombre_tipo_slug = url_title($this->input->post('nombre_tipo'), '-', TRUE);
		
		$caracteristicas = array();
			
		$datos_tipo = $this->input->post('tipo');
		
		for($i=0;$i<sizeof($datos_tipo['caracteristicas']);$i++) {
				
			$titulo_url = url_title($datos_tipo["caracteristicas"][$i], '_', TRUE);
			
			$caracteristicas[$titulo_url] = array();
			$caracteristicas[$titulo_url]['titulo'] = $datos_tipo["caracteristicas"][$i];
			
			$opciones = $datos_tipo['valores'][$i];
			$opciones = preg_replace('/\s+/', '', $opciones);
			$opciones = explode(",", $opciones);
			
			$caracteristicas[$titulo_url]['opciones'] = $opciones;
			
		}
		
		$outside_car = json_encode($caracteristicas);
		$tipo->caracteristicas_tipo = $outside_car;
		
		$tipo->estatus = 1;
		
		$this->db->insert('TiposDeProducto', $tipo);
		
		redirect('administracion/tipos');
	}
	
	public function modificar() {
		$tipo = new stdClass();
		$id_tipo = $this->input->post('id_tipo');
		
		$caracteristicas = array();
			
		$datos_tipo = $this->input->post('tipo');
		
		foreach($datos_tipo['caracteristicas'] as $slug=>$titulo) {
			
			$caracteristicas[$slug] = array();
			$caracteristicas[$slug]['titulo'] = $titulo;
			
			$opciones = $datos_tipo['valores'][$slug];
			$opciones = preg_replace('/\s+/', '', $opciones);
			$opciones = explode(",", $opciones);
			
			$caracteristicas[$slug]['opciones'] = $opciones;
			
		}		
		
		$outside_car = json_encode($caracteristicas);
		$tipo->caracteristicas_tipo = $outside_car;
	
		$this->db->where('id_tipo', $id_tipo);
		$this->db->update('TiposDeProducto', $tipo);
		
		redirect('administracion/tipos');
	} 
	
	public function borrar() {
		$tipo = new stdClass();
		$tipo->estatus = 33;
		
		$this->db->where('id_tipo', $this->input->post('id_tipo'));
		$this->db->update('TiposDeProducto', $tipo);
		
		redirect('administracion/tipos');
	}
	
	public function estatus() {
		
	}
	
}
