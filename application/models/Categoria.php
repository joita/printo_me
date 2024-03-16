<?php
	
class Categoria extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}

	public function obtener_categoria($id_categoria) {
		
		$categoria_res = $this->db->get_where('Categorias', array('id_categoria' => $id_categoria));
		$result = $categoria_res->result();
		
		return $result[0];
		
	}

	public function obtener_categoria_por_nombre($nombre_categoria_slug) {
		
		$categoria_res = $this->db->get_where('Categorias', array('nombre_categoria_slug' => $nombre_categoria_slug));
		$result = $categoria_res->result();
		return $result[0];
		
	}
	
	public function obtener_categorias_no_enhance() {
		$this->db->select("*");
		$this->db->from('Categorias');
		$this->db->where('id_categoria_parent', 0);
		$this->db->where('id_categoria !=', 11);
		$this->db->where('estatus', 1);
		$this->db->where('custom', 0);
		$this->db->order_by('id_categoria', 'ASC');
		
		$categorias_res = $this->db->get();
		$categorias = $categorias_res->result();
		
		return $categorias;
	}
	
	
	// Obtener todas las categorías de manera jerárquica y almacenarlas en un array	
	public function obtener_categorias() {
		$this->db->order_by('id_categoria', 'ASC'); 
		$categorias_res = $this->db->get_where('Categorias', array('id_categoria_parent' => 0, 'estatus' => 1));

		$categorias = array();
		
		foreach ($categorias_res->result() as $categoria) {
			
			$categoria_n = json_decode(json_encode($categoria), true);
			
			$categorias[$categoria->id_categoria] = $categoria_n;
			
			$this->db->select('*');
			$this->db->from('Categorias');
			$this->db->where('id_categoria_parent', $categoria->id_categoria);
			$this->db->where('estatus', 1);
			
			$cantidad_subcategorias = $this->db->count_all_results();
			
			if($cantidad_subcategorias > 0) {
				
				$categorias[$categoria->id_categoria]['subcategorias'] = array();
				
				$subcategorias_res = $this->db->get_where('Categorias', array('id_categoria_parent' => $categoria->id_categoria));
				//$this->db->order_by('id_categoria', 'ASC');
				
				foreach($subcategorias_res->result() as $subcategoria) {
					$subcategoria_n = json_decode(json_encode($subcategoria), true);
					$categorias[$categoria->id_categoria]['subcategorias'][$subcategoria->id_categoria] = $subcategoria_n;
				}
			}
		}
		
		return $categorias;
	}
	
	public function obtener_subcategorias($id_categoria_parent) {
		
		$subcategorias_res = $this->db->get_where('Categorias', array('id_categoria_parent' => $id_categoria_parent));
		//$this->db->order_by('id_categoria', 'ASC');
		return $subcategorias_res->result();
		
	}
	
	public function obtener_categorias_admin() {
		$this->db->order_by('id_categoria', 'ASC');
		$categorias_res = $this->db->get_where('Categorias', array('id_categoria_parent' => 0, 'estatus !=' => 33, 'custom' => 0));
		$categorias = $categorias_res->result();
		
		foreach($categorias as $i=>$categoria) {
			
			$this->db->order_by('id_categoria', 'ASC');
			$subcategorias_res = $this->db->get_where('Categorias', array('id_categoria_parent' => $categoria->id_categoria, 'estatus !=' => 33, 'custom' => 0));
			$subcategorias = $subcategorias_res->result();
			
			if(sizeof($subcategorias) > 0) {
				$categorias[$i]->subcategorias = $subcategorias;
			}
		}		
		
		return $categorias;
	}
	
	public function obtener_min_categoria() {
		$this->db->order_by('id_categoria', 'ASC');
		$categorias_res = $this->db->get_where('Categorias', array('id_categoria_parent' => 0, 'estatus !=' => 33, 'custom' => 0));
		$categorias = $categorias_res->result();
		
		if(isset($categorias[0])) {
			return $categorias[0];
		} else {
			return 0;
		}
	}
	
	public function obtener_categorias_activas_admin() {
		
		$this->db->select("*");
		$this->db->from('Categorias');
		$this->db->where('id_categoria_parent', 0);
		$this->db->where('estatus', 1);
		$this->db->where('custom', 0);
		$this->db->order_by('id_categoria', 'ASC');
		
		$categorias_res = $this->db->get();
		$categorias = $categorias_res->result();
		
		foreach($categorias as $i=>$categoria) {
			
			$this->db->select("*");
			$this->db->from('Categorias');
			$this->db->where('id_categoria_parent', $categoria->id_categoria);
			$this->db->where('estatus', 1);
			$this->db->where('custom', 0);
			$this->db->order_by('id_categoria', 'ASC');
			
			$subcategorias_res = $this->db->get();
			$subcategorias = $subcategorias_res->result();
			
			if(sizeof($subcategorias) > 0) {
				$categorias[$i]->subcategorias = $subcategorias;
			}
			
			
		}		
		
		return $categorias;
	}
}