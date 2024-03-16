<?php
	
class Ofertas_modelo extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}

	public function obtener_ofertas($admin = false) {
		
		if(!$admin) {
			$where = array('estatus' => 1);
			$this->db->limit(3,0);
		} else {
			$where = array('estatus !=' => 33);
		}
		
		$this->db->order_by('id_oferta', 'DESC');
		$tipo_res = $this->db->get_where('Ofertas', $where);
		$result = $tipo_res->result();
		
		foreach($result as $indice=>$slide) {
			$result[$indice]->ubicacion_base = 'assets/images/ofertas/';
		}
		
		return $result;
		
	}
	
}