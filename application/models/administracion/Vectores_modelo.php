<?php
	
class Vectores_modelo extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}
	
	public function obtener_categorias_vectores()
	{
		$this->db->order_by('nombre_categoria_vector_slug', 'ASC');
		$categorias_res = $this->db->get_where('CategoriasVectores', array('estatus !=' => 33));
		return $categorias_res->result();
	}
	
	public function obtener_primer_categoria()
	{
		$this->db->order_by('nombre_categoria_vector_slug', 'ASC');
		$this->db->limit(1);
		$categorias_res = $this->db->get_where('CategoriasVectores', array('estatus !=' => 33));
		$categoria = $categorias_res->result();
		if(isset($categoria[0])) {
			return $categoria[0];
		} else {
			return false;
		}
	}
	
	public function obtener_categoria_vectores_slug($nombre_categoria_vector_slug)
	{
		$categorias_res = $this->db->get_where('CategoriasVectores', array('estatus !=' => 33, 'nombre_categoria_vector_slug' => $nombre_categoria_vector_slug));
		$categoria = $categorias_res->result();
		return $categoria[0];
	}
	
	public function obtener_vectores_por_categoria($id_categoria_vector)
	{
		$this->db->order_by('clipart_id', 'DESC');
		$vectores_res = $this->db->get_where('cliparts', array('cate_id' => $id_categoria_vector, 'status !=' => -1));
		$vectores = $vectores_res->result();
		return $vectores;
	}
	
}