<?php
	
class Configuracion_modelo extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}
	
	/*public function obtener_configuracion() {
		$this->db->order_by('id_configuracion', 'ASC');
		$configuracion_res = $this->db->get('Configuracion');
		$row = $configuracion_res->row();
		return (!is_null($row)) ? $row: null; 
	}
	
	public function obtener_envio_minimo() {
		$envio_minimo_res = $this->db->get_where('Configuracion', array('nombre_configuracion_slug' => 'envio_gratis'));
		$row = $envio_minimo_res->row();
		return (!is_null($row)) ? $row->valor_configuracion: null; 
		
	}
	
	public function obtener_porcentaje_iva() {
		$iva_res = $this->db->get_where('Configuracion', array('nombre_configuracion_slug' => 'iva'));
		$row = $iva_res->row();
		return (!is_null($row)) ? $row->valor_configuracion: null; 
		
	}
	
	public function obtener_dias_para_devolucion() {
		$devolucion_res = $this->db->get_where('Configuracion', array('nombre_configuracion_slug' => 'devolucion'));
		$row = $devolucion_res->row();
		return (!is_null($row)) ? $row->valor_configuracion: null; 
		
	}*/
	public function obtener_configuracion_de($id = "") {
		$query = $this->db->get_where('Configuracion', array('nombre_configuracion_slug' => $id));
		$result = $query->row();

		if (!is_null($result)) {
			return $result->valor_configuracion;
		}

		return "0";
	}

	public function obtener_configuracion() {
		$this->db->order_by('id_configuracion', 'ASC');
		$configuracion_res = $this->db->get('Configuracion');
		return $configuracion_res->result();
	}
	
	public function obtener_envio_minimo() {
		$envio_minimo_res = $this->db->get_where('Configuracion', array('nombre_configuracion_slug' => 'envio_gratis'));
		$envio_minimo = $envio_minimo_res->result();
		
		return $envio_minimo[0]->valor_configuracion;
	}
	
	public function obtener_porcentaje_iva() {
		$iva_res = $this->db->get_where('Configuracion', array('nombre_configuracion_slug' => 'iva'));
		$iva = $iva_res->result();
		
		return $iva[0]->valor_configuracion;
	}
	
	public function obtener_dias_para_devolucion() {
		$devolucion_res = $this->db->get_where('Configuracion', array('nombre_configuracion_slug' => 'devolucion'));
		$devolucion = $devolucion_res->result();
		
		return $devolucion[0]->valor_configuracion;
	}
	
	
}