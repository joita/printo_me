<?php

class Busqueda_modelo extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function resultados_busqueda($palabra_clave) {
		
		
		if($palabra_clave == ' ' or $palabra_clave == " ") {
			redirect(site_url('busqueda/?b=Print-o-Me'));
		}
		/* 
		$this->load->library('stemm_es');
		
		$criterios_busqueda = explode(" ",$palabra_clave);
		
		if(sizeof($criterios_busqueda) <= 1) {
			$b = $this->stemm_es->stemm($criterios_busqueda[0])."* ";
		} else {
			$b_aux = array();
			
			foreach($criterios_busqueda as $i => $valor) {
				$b_aux[$i] = $this->stemm_es->stemm($valor)."* ";
			} 
			
			$b = implode($b_aux);
		} 
		
		$b = $this->db->escape($b);*/
		$b = $palabra_clave;

		/* $this->db->select('*');
		$this->db->from('CatalogoProductos');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto=CatalogoProductos.id_producto');
		$this->db->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color');
		$this->db->where('CatalogoProductos.estatus', 1);
		$this->db->where('ColoresPorProducto.estatus', 1);
		$this->db->where('FotografiasPorProducto.estatus', 1);
		$this->db->where('FotografiasPorProducto.principal', 1);
		$this->db->like('CatalogoProductos.nombre_producto', $b);
		$this->db->or_like('CatalogoProductos.descripcion_producto', $b);
		$this->db->order_by('RAND()');
		$this->db->group_by('CatalogoProductos.id_producto'); */

				
		$busqueda_res = $this->db->query("SELECT * FROM `CatalogoProductos` 
			JOIN `ColoresPorProducto` ON `ColoresPorProducto`.`id_producto`=`CatalogoProductos`.`id_producto` 
			JOIN `Marcas` ON `Marcas`.`id_marca`=`CatalogoProductos`.`id_marca` 
			JOIN `FotografiasPorProducto` ON `FotografiasPorProducto`.`id_color` = `ColoresPorProducto`.`id_color` 
			WHERE (`CatalogoProductos`.`estatus` = 1 AND `ColoresPorProducto`.`estatus` = 1 AND `FotografiasPorProducto`.`estatus` = 1 AND `FotografiasPorProducto`.`principal` = 1)
			AND (`CatalogoProductos`.`nombre_producto` LIKE '%".$b."%' ESCAPE '!' OR `CatalogoProductos`.`descripcion_producto` LIKE '%".$b."%' ESCAPE '!')
			GROUP BY `CatalogoProductos`.`id_producto` ORDER BY RAND()");

		$busqueda = $busqueda_res->result();
		
		foreach($busqueda as $key => $resultado) {
			if($busqueda[$key]->descuento_especifico != 0.00) {
				$busqueda[$key]->precio_descuento = $resultado->precio_producto*(1-($resultado->descuento_especifico/100));
			}
			$busqueda[$key]->ubicacion_base = 'assets/images/productos/producto'.$resultado->id_producto.'/';
			$categoria = $this->categoria->obtener_categoria($resultado->id_categoria);
			$subcategoria = $this->categoria->obtener_categoria($resultado->id_subcategoria);
			$busqueda[$key]->vinculo_producto = $categoria->nombre_categoria_slug.'/'.$resultado->nombre_producto_slug.'-'.$resultado->id_producto;
		}
		
		return $busqueda;
	}
	
	
	public function contar_resultados_busqueda($palabra_clave) {
		
		if($palabra_clave == ' ' or $palabra_clave == " ") {
			redirect(site_url('busqueda'));
		}
		/* 
		$this->load->library('stemm_es');
		
		$criterios_busqueda = explode(" ",$palabra_clave);
		
		if(sizeof($criterios_busqueda) <= 1) {
			$b = $this->stemm_es->stemm($criterios_busqueda[0])."* ";
		} else {
			$b_aux = array();
			
			foreach($criterios_busqueda as $i => $valor) {
				$b_aux[$i] = $this->stemm_es->stemm($valor)."* ";
			}
			
			$b = implode($b_aux);
		}
		
		$b = $this->db->escape($b); */
		
		$b = $palabra_clave;
		
		/* $this->db->select('*');
		$this->db->from('CatalogoProductos');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto=CatalogoProductos.id_producto');
		$this->db->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color');
		$this->db->where('CatalogoProductos.estatus = 1 AND ColoresPorProducto.estatus = 1 AND FotografiasPorProducto.estatus = 1 AND FotografiasPorProducto.principal = 1');
		$this->db->like('CatalogoProductos.nombre_producto', $b);
		$this->db->or_like('CatalogoProductos.descripcion_producto', $b);
		$this->db->order_by('RAND()');
		$this->db->group_by('CatalogoProductos.id_producto'); */
		
		$busqueda_res = $this->db->query("SELECT * FROM `CatalogoProductos` 
			JOIN `ColoresPorProducto` ON `ColoresPorProducto`.`id_producto`=`CatalogoProductos`.`id_producto` 
			JOIN `Marcas` ON `Marcas`.`id_marca`=`CatalogoProductos`.`id_marca` 
			JOIN `FotografiasPorProducto` ON `FotografiasPorProducto`.`id_color` = `ColoresPorProducto`.`id_color` 
			WHERE (`CatalogoProductos`.`estatus` = 1 AND `ColoresPorProducto`.`estatus` = 1 AND `FotografiasPorProducto`.`estatus` = 1 AND `FotografiasPorProducto`.`principal` = 1)
			AND (`CatalogoProductos`.`nombre_producto` LIKE '%".$b."%' ESCAPE '!' OR `CatalogoProductos`.`descripcion_producto` LIKE '%".$b."%' ESCAPE '!')
			GROUP BY `CatalogoProductos`.`id_producto` ORDER BY RAND()");

		$busqueda = $busqueda_res->result();
		
		foreach($busqueda as $key => $resultado) {
			if($busqueda[$key]->descuento_especifico != 0.00) {
				$busqueda[$key]->precio_descuento = $resultado->precio_producto*(1-($resultado->descuento_especifico/100));
			}
			$busqueda[$key]->ubicacion_base = 'assets/images/productos/producto'.$resultado->id_producto.'/';
			$categoria = $this->categoria->obtener_categoria($resultado->id_categoria);
			$subcategoria = $this->categoria->obtener_categoria($resultado->id_subcategoria);
			$busqueda[$key]->vinculo_producto = $categoria->nombre_categoria_slug.'/'.$resultado->nombre_producto_slug.'-'.$resultado->id_producto;
		}
		
		if(sizeof($busqueda) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
}