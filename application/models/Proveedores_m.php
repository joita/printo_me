<?php
class Proveedores_m extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function obtener_proveedores($pid = null)
	{
	//	$this->db->order_by('id', 'DESC');
		if(!$pid) {
			$proveedores = $this->db->get('proveedores')->result();
		} else {
			$proveedores = $this->db->get_where('proveedores', array('id' => $pid))->row();
		}
		return $proveedores;
	}

	public function obtener_proveedores_by_client($pid = null)
	{

		if(!$pid) {
			$proveedores = $this->db->get('proveedores')->result();
		} else {
			$proveedores = $this->db->get_where('proveedores', array('creator_id' => $pid))->result();
		}
		return $proveedores;
	}


	public function insert_data($data)
	{
		// print_r($data);
		// exit;
		$this->db->insert('proveedores',$data);
	}

	public function update_data($id,$data)
	{

		$this->db->where('id',$id);
		$this->db->update('proveedores',$data);
	}
}
?>