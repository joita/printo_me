<?php 

class Caracteristica_modelo extends CI_Model {

	private $_table = 'CaracteristicasAdicionales';
	private $_id = 'id_caracteristica';

	public function __construct()
	{
			parent::__construct();
	}

	public function obtener_caracteristica() {
		$this->db->order_by($this->nombre_caracteristica, 'ASC');
		$result = $this->db->get_where($this->_table, array('id_caracteristica_parent' => 0, 'estatus !=' => 33));
		$caracteristicas = $result->result();
		//print_m($caracteristicas);
		foreach($caracteristicas as $i=>$caracteristica) {
			$this->db->order_by($this->_id, 'ASC');
			$subresult = $this->db->get_where($this->_table, array('id_caracteristica_parent' => $caracteristica->id_caracteristica, 'estatus !=' => 33));
			$subcaracteristicas = $subresult->result();
			if(sizeof($subcaracteristicas) > 0) {
				$caracteristicas[$i]->subcaracteristicas = $subcaracteristicas;
			}
		}
		return $caracteristicas;
	}
}
?>