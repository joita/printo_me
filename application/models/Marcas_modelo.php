<?php
	
class Marcas_modelo extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}

	public function obtener_marcas_admin() {
		$this->db->order_by('nombre_marca', 'ASC');
		$marcas_res = $this->db->get_where('Marcas', array('estatus !=' => 33));
		return $marcas_res->result();
	}
	
	public function obtener_marcas_activas() {
		$this->db->order_by('nombre_marca', 'ASC');
		$marcas_res = $this->db->get_where('Marcas', array('estatus' => 1));
		return $marcas_res->result();
	}

}