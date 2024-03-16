<?php
	
class Productos_modelo extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}

	public function obtener_productos($id_categoria, $id_tipo) {
		
		$this->db->select('*');
		$this->db->from('CatalogoProductos');
		$this->db->where('id_categoria', $id_categoria);
		$this->db->where('id_tipo', $id_tipo);
		/* $this->db->where('id_subcategoria', $subcategoria->id_categoria); */
		$this->db->where('estatus !=', 33);
		$this->db->order_by('id_producto', 'DESC');
		$productos_res = $this->db->get();
		
		$productos = $productos_res->result();
		
		return $productos;
		
	}
	
	public function obtener_producto_con_id($id_producto) {
		$producto_res = $this->db->get_where('CatalogoProductos', array('id_producto' => $id_producto));
		$producto = $producto_res->result();
		
		return $producto[0];
	}
	
	public function obtener_imagen_producto($id_producto) {
		
		$this->db->order_by('id_color', 'ASC');
		$this->db->limit(1,0);
		$color_res = $this->db->get_where('ColoresPorProducto', array('id_producto' => $id_producto));
		$color = $color_res->result();
		
		$imagen_res = $this->db->get_where('FotografiasPorProducto', array('id_color' => $color[0]->id_color, 'principal' => 1));
		$imagen = $imagen_res->result();
		
		$imagen[0]->ubicacion_base = 'assets/images/productos/producto'.$id_producto.'/';
		
		return $imagen[0];
		
	}
	
	public function obtener_fotografias_producto($id_color, $id_producto) {
		$this->db->order_by('principal', 'DESC');
		$fotografias_res = $this->db->get_where('FotografiasPorProducto', array('id_color' => $id_color, 'estatus != ' => 33));
		$fotografias = $fotografias_res->result();
		
		foreach($fotografias as $indice=>$fotografia) {
			$fotografias[$indice]->ubicacion_base = 'assets/images/productos/producto'.$id_producto.'/';
		}
		
		return $fotografias;
	}
	
	public function obtener_skus_por_color($id_color) {
		$this->db->order_by('id_sku', 'ASC');
		$skus_res = $this->db->get_where('CatalogoSkuPorProducto', array('id_color' => $id_color));
		$skus = $skus_res->result();
		
		foreach($skus as $indice=>$sku) {
			$skus[$indice]->caracteristicas = json_decode($sku->caracteristicas);
			
			$talla_completa = array();
			foreach($skus[$indice]->caracteristicas as $caracteristica) {
				array_push($talla_completa, $caracteristica);
			}
			$talla_completa = implode("", $talla_completa);
			
			$skus[$indice]->talla_completa = $talla_completa;
		}
		
		return $skus;
	}
	
	public function obtener_skus_activos_por_color($id_color, $id_sku = null) {
		$this->db->order_by('id_sku', 'ASC');		
		if($id_sku) {
			$criterio = array('id_color' => $id_color, 'id_sku' => $id_sku, 'estatus' => 1);
		} else {
			$criterio = array('id_color' => $id_color, 'estatus' => 1);
		}
		$skus_res = $this->db->get_where('CatalogoSkuPorProducto', $criterio);
		$skus = $skus_res->result();
		
		foreach($skus as $indice=>$sku) {
			$skus[$indice]->caracteristicas = json_decode($sku->caracteristicas);
			
			$talla_completa = array();
			foreach($skus[$indice]->caracteristicas as $caracteristica) {
				array_push($talla_completa, $caracteristica);
			}
			$talla_completa = implode("", $talla_completa);
			
			$skus[$indice]->talla_completa = $talla_completa;
		}
		
		return $skus;
	}
	
	public function obtener_info_sku($id_sku) {
		$sku_res = $this->db->get_where('CatalogoSkuPorProducto', array('id_sku' => $id_sku));
		$sku = $sku_res->result();
		
		$sku[0]->caracteristicas = json_decode($sku[0]->caracteristicas);
		$talla_completa = array();
		foreach($sku[0]->caracteristicas as $caracteristica) {
			array_push($talla_completa, $caracteristica);
		}
		$talla_completa = implode("", $talla_completa);
		
		$sku[0]->talla_completa = $talla_completa;
		
		return $sku[0];
	}
	
	public function obtener_info_color($id_color) {
		$color_res = $this->db->get_where('ColoresPorProducto', array('id_color' => $id_color));
		$color = $color_res->result();
		return $color[0];
	}
	
	public function obtener_foto_principal_color($id_color, $id_producto) {
		$foto_res = $this->db->get_where('FotografiasPorProducto', array('id_color' => $id_color, 'principal' => 1));
		$foto = $foto_res->result();
		
		$foto[0]->ubicacion_base = 'assets/images/productos/producto'.$id_producto.'/';
		return $foto[0];
	}
	
	public function obtener_lista_colores_por_producto($id_producto) {
		$this->db->order_by('id_color', 'ASC');
		$colores_disponibles_res = $this->db->get_where('ColoresPorProducto', array('id_producto' => $id_producto));
		return $colores_disponibles_res->result();
	}
	
	
	public function obtener_iconos_de_colores_por_producto($id_producto) {
		
		$colores_disponibles_res = $this->db->get_where('ColoresPorProducto', array('id_producto' => $id_producto));
		$colores_disponibles = $colores_disponibles_res->result();
		
		$color_string = '';
		foreach($colores_disponibles as $color) {
			if($color->estatus == 0) { 
				$icon = 'fa fa-times-circle';
			} else {
				$icon = 'fa fa-check-circle';
			}
			$color_string .= '<i class="'.$icon.'" style="color:'.$color->codigo_color.';" title="'.$color->nombre_color.'"></i>';
		}
		
		return  $color_string;
		
	}
	
	public function obtener_colores_paleta() {
		
		$sql = "SELECT DISTINCT(codigo_color) AS hex FROM ColoresPorProducto";
		$colores_res = $this->db->query($sql);
		$colores = $colores_res->result();
		
		$cols = array();
		
		foreach($colores as $color) {
			array_push($cols, "'".$color->hex."'");
		}
		
		$resultado = '';
		
		$filas = array();
		for($i=0;$i<sizeof($cols); $i++) {
			
			$contador = $i;
			
			if($contador % 5 == 0) {
				$col_string = '';
				$string = '[';
			}
			
			$col_string .= $cols[$i].',';
			
			if(($contador % 5 == 4) or ($contador == sizeof($cols)-1)) {
				$string .= substr($col_string, 0, -1);
				$string .= ']';
				array_push($filas, $string);
			}
			
			
		}
		
		$colores = implode(', ', $filas);
		
		return $colores;
		
	}
}