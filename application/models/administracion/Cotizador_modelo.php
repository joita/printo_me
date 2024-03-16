<?php
	
class Cotizador_modelo extends CI_Model {

	private $_table = 'Cotizador';
	private $_id = 'id_cotizador';

	public function __construct()
	{
		parent::__construct();
	}

	public function obtener_datos($tipo = '', $estampado = '')
	{
		return $this->db->select('*')->where('estatus !=', '33')->where('tipo_estampado', $estampado)->where('tipo_tinta', $tipo)->order_by('cantidad_min ASC, cantidad_max DESC')->get($this->_table)->result();
	}

	public function obtener_tipo_estampado_1()
	{
		$data = new stdClass();
		$result_query = $this->db->select('distinct(tipo_tinta),tipo_estampado')->where('estatus !=', '33')->where('tipo_estampado', '1')->order_by('tipo_tinta ASC, cantidad_min ASC, cantidad_max DESC')->get($this->_table)->result();
		foreach ($result_query as $key => $value) {
			$data->$key = new stdClass();
			$data->$key->titulo = titulo_cotizador($value->tipo_tinta);
			$data->$key->tipo_tinta = $value->tipo_tinta;
			$data->$key->tipo_estampado = 1;
			$data->$key->data = $this->db->where('tipo_tinta', $value->tipo_tinta)->where('estatus !=', '33')->where('tipo_estampado', $value->tipo_estampado)->order_by('cantidad_min ASC, cantidad_max DESC')->get($this->_table)->result();
		}
		return $data;
	}

	public function obtener_tipo_estampado_2()
	{
		$data = new stdClass();
		$result_query = $this->db->select('distinct(tipo_tinta),tipo_estampado')->where('estatus !=', '33')->where('tipo_estampado', '2')->order_by('tipo_tinta ASC, cantidad_min ASC, cantidad_max DESC')->get($this->_table)->result();
		foreach ($result_query as $key => $value) {
			$data->$key = new stdClass();
			$data->$key->titulo = titulo_cotizador($value->tipo_tinta);
			$data->$key->tipo_tinta = $value->tipo_tinta;
			$data->$key->tipo_estampado = 2;
			$data->$key->data = $this->db->where('tipo_tinta', $value->tipo_tinta)->where('estatus !=', '33')->where('tipo_estampado', $value->tipo_estampado)->order_by('cantidad_min ASC, cantidad_max ASC')->get($this->_table)->result();
		}
		return $data;
	}
} 
?>