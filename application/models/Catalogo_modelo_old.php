<?php
	
class Catalogo_modelo extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}
	
	public function obtener_colores_disponibles($id_categoria, $id_subcategoria=null) {
		$sql = "SELECT DISTINCT(codigo_color) FROM 
				(SELECT CatalogoProductos.id_producto, 
						ColoresPorProducto.codigo_color 
				FROM CatalogoProductos 
				JOIN ColoresPorProducto ON ColoresPorProducto.id_producto=CatalogoProductos.id_producto 
				WHERE CatalogoProductos.id_categoria=".$id_categoria;
				if(!is_null($id_subcategoria)) $sql .= "AND CatalogoProductos.id_subcategoria=".$id_subcategoria;
				$sql .= " AND CatalogoProductos.estatus=1) AS Prods";
		$colores_res = $this->db->query($sql);
		if ($colores_res->num_rows() == 0) return null;
		$resultado = $colores_res->result();
		return $resultado;
	}
	
	public function obtener_marcas_disponibles() {
		$sql = "SELECT DISTINCT(CatalogoProductos.id_marca), Marcas.* FROM CatalogoProductos JOIN Marcas ON Marcas.id_marca=CatalogoProductos.id_marca WHERE CatalogoProductos.estatus=1 ORDER BY Marcas.nombre_marca ASC";
		$marcas_res = $this->db->query($sql);
		$resultado = $marcas_res->result();
		return $resultado;
	}
	
	public function obtener_categoria_por_slug($slug, $id_categoria_parent=0) {
		$categoria_res = $this->db->get_where('Categorias', array('nombre_categoria_slug' => $slug, 'id_categoria_parent' => $id_categoria_parent, 'estatus !=' => '33'));
		$resultado = $categoria_res->result();
		return $resultado[0];
	}
	
	public function obtener_minima_subcategoria($id_categoria_parent) {
		$this->db->select('*');
		$this->db->from('Categorias');
		$this->db->where('id_categoria_parent', $id_categoria_parent);
		$this->db->where('estatus !=', '33');
		$this->db->order_by('id_categoria', 'ASC');
		$this->db->limit(1, 0);
		$minima_res = $this->db->get();
		$resultado = $minima_res->result();
		
		return $resultado[0];
	}

	public function first_active_product_for_enhance()
	{
		$this->db->select('id_producto');
		$this->db->from('CatalogoProductos');
		$this->db->where('estatus', '1');
		$this->db->limit(1, 0);
		$query = $this->db->get();
		$row = $query->row();
		
		return "design/" . $row->id_producto;
	}
	
	/**
	 * hay_productos_disponibles Devuelve cantidad de productos por categoria
	 *
	 * Instead verify if obtener_productos is null
	 * @deprecated
	 * @param  [type] $id_categoria    [description]
	 * @param  [type] $id_subcategoria [description]
	 * @return [type]                  [description]
	 */
	public function hay_productos_disponibles($id_categoria, $id_subcategoria) {
		trigger_error("Deprecated function called.", E_USER_NOTICE);
	}

	/**
	 * hay_productos_disponibles Devuelve cantidad de colores  por categoria
	 *
	 * Instead verify if obtener_colores is null
	 * @deprecated
	 * @param  [type] $id_categoria    [description]
	 * @param  [type] $id_subcategoria [description]
	 * @return [type]                  [description]
	 */
	public function hay_colores_disponibles($id_categoria, $id_subcategoria) {
		trigger_error("Deprecated function called.", E_USER_NOTICE);
	}

	public function obtener_precios_tope($id_categoria)
	{
		if($id_categoria != 2) {
			$sql = "SELECT MIN(precio_producto*(1-(descuento_especifico/100))) AS minimo, MAX(precio_producto*(1-(descuento_especifico/100))) AS maximo FROM CatalogoProductos WHERE estatus=1 AND id_categoria=".$id_categoria;
		} else {
			$sql = "SELECT MIN(price) AS minimo, MAX(price) AS maximo FROM Enhance WHERE estatus=1";
		}
		$minimo_res = $this->db->query($sql);
		$resultado = $minimo_res->row();
		return $resultado;
	}
	
	public function obtener_precio_minimo($id_categoria, $id_subcategoria = null) {
		$sql = "SELECT MIN(precio_producto*(1-(descuento_especifico/100))) AS minimo FROM CatalogoProductos WHERE estatus=1 AND id_categoria=".$id_categoria;
		$minimo_res = $this->db->query($sql);
		$resultado = $minimo_res->result();
		
		$res_final = $resultado[0];
		return $res_final->minimo;
	}
	
	public function obtener_precio_maximo($id_categoria, $id_subcategoria) {
		$sql = "SELECT MAX(precio_producto) AS maximo FROM CatalogoProductos WHERE estatus=1 AND id_categoria=".$id_categoria;
		$minimo_res = $this->db->query($sql);
		$resultado = $minimo_res->result();
		
		$res_final = $resultado[0];
		return $res_final->maximo;
	}
	
	public function obtener_productos($id_categoria, $id_subcategoria = null) {
		
		$this->db->select('*, CatalogoProductos.id_producto as id, "producto" as type');
		$this->db->from('CatalogoProductos');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto=CatalogoProductos.id_producto');
		$this->db->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
		$this->db->join('ListasProductos', 'CatalogoProductos.id_producto=ListasProductos.id_producto', "left");
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color');
		$this->db->where('CatalogoProductos.id_categoria', $id_categoria);
		if( !is_null($id_subcategoria) ) $this->db->where('CatalogoProductos.id_subcategoria', $id_subcategoria);
		$this->db->where('CatalogoProductos.estatus', 1);
		$this->db->where('ColoresPorProducto.estatus', 1);
		$this->db->where('FotografiasPorProducto.estatus', 1);
		$this->db->where('FotografiasPorProducto.principal', 1);
		$this->db->order_by('RAND()');
		$this->db->group_by('CatalogoProductos.id_producto');

		$productos_res = $this->db->get();
		if ($productos_res->num_rows() == 0) return null;

		$resultado = $productos_res->result();
		
		foreach($resultado as $key=>$producto) {
			$resultado[$key]->id_producto = $resultado[$key]->id;
			if($resultado[$key]->descuento_especifico != 0.00) {
				$resultado[$key]->precio_descuento = $producto->precio_producto*(1-($producto->descuento_especifico/100));
			}
			$resultado[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
			$categoria = $this->categoria->obtener_categoria($producto->id_categoria);
			//$subcategoria = $this->categoria->obtener_categoria($producto->id_subcategoria);
			$resultado[$key]->vinculo_producto = $categoria->nombre_categoria_slug.'/'.$producto->nombre_producto_slug.'-'.$producto->id_producto;

		}
		
		return $resultado;
	}/* 

	public function obtener_enhanced($id_categoria = null, $id_subcategoria = null) {
		
		$this->db->select('*, CatalogoProductos.id_producto as id, "enhance" as type');
		$this->db->from('Enhance');
		$this->db->join('CatalogoProductos', 'CatalogoProductos.id_producto=Enhance.id_producto');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto=CatalogoProductos.id_producto');
		$this->db->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
		$this->db->join('ListasProductos', 'CatalogoProductos.id_producto=ListasProductos.id_producto', "left");
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color');
		if( !is_null($id_categoria) ) $this->db->where('CatalogoProductos.id_categoria', $id_categoria);
		if( !is_null($id_subcategoria) ) $this->db->where('CatalogoProductos.id_subcategoria', $id_subcategoria);
		$this->db->where('CatalogoProductos.estatus', 1);
		$this->db->where('ColoresPorProducto.estatus', 1);
		$this->db->where('FotografiasPorProducto.estatus', 1);
		$this->db->where('FotografiasPorProducto.principal', 1);
		$this->db->order_by('RAND()');
		$this->db->where("Enhance.estatus", 1);
		$this->db->group_by('Enhance.id_enhance');

		$productos_res = $this->db->get();

		if ($productos_res->num_rows() == 0) return null;

		$resultado = $productos_res->result();
		
		foreach($resultado as $key=>$producto) {
			$resultado[$key]->id_producto = $resultado[$key]->id;
			if($resultado[$key]->descuento_especifico != 0.00) {
				$resultado[$key]->precio_descuento = $producto->precio_producto*(1-($producto->descuento_especifico/100));
			}
			$resultado[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
			$categoria = $this->categoria->obtener_categoria($producto->id_categoria);
			$subcategoria = $this->categoria->obtener_categoria($producto->id_subcategoria);
			$url = trim($resultado[$key]->name);

	    $url = str_replace(" ","-",$url);
	    $url = str_replace("/","-slash-",$url);
	    $url = rawurlencode($url);

	    $resultado[$key]->name_slug = $url;

			$resultado[$key]->vinculo_producto = 'enhanced/'.$producto->name_slug.'-'.$producto->id_enhance;

		}
		
		return $resultado;
	} */

	public function obtener_enhanced($tipo_campana, $id_campana = null) {
		
		if($tipo_campana == 'social') {
			$slug = 'sociales';
		} else if($tipo_campana == 'lucrativa') {
			$slug = 'lucrativas';
		}

		$this->db->select('*, CatalogoProductos.id_producto as id, CatalogoProductos.id_categoria, CatalogoProductos.id_subcategoria');
		$this->db->from('Enhance');
		$this->db->join('CatalogoProductos', 'CatalogoProductos.id_producto=Enhance.id_producto');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto=CatalogoProductos.id_producto');
		$this->db->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
		$this->db->join('ListasProductos', 'CatalogoProductos.id_producto=ListasProductos.id_producto', "left");
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color');
		$this->db->where('CatalogoProductos.estatus', 1);
		$this->db->where('ColoresPorProducto.estatus', 1);
		$this->db->where('FotografiasPorProducto.estatus', 1);
		$this->db->where('FotografiasPorProducto.principal', 1);
		$this->db->where('Enhance.end_date >=', date("Y-m-d H:i:s"));
		$this->db->order_by('RAND()');
		$this->db->where("Enhance.estatus", 1);
		$this->db->where("Enhance.type", $tipo_campana);
		if($id_campana) {
			$this->db->where('Enhance.id_enhance', $id_campana);
		}
		$this->db->group_by('Enhance.id_enhance');
		
		$productos_res = $this->db->get();

		if ($productos_res->num_rows() == 0) return null;

		$resultado = $productos_res->result();
		
		foreach($resultado as $key=>$producto) {
			$resultado[$key]->id_producto = $resultado[$key]->id;
			/* if($resultado[$key]->descuento_especifico != 0.00) {
				$resultado[$key]->precio_descuento = $producto->precio_producto*(1-($producto->descuento_especifico/100));
			} */
			$resultado[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
			$categoria = $this->categoria->obtener_categoria($producto->id_categoria);
			//$subcategoria = $this->categoria->obtener_categoria($producto->id_subcategoria);

			$name_slug = strtolower(url_title(convert_accented_characters(trim($resultado[$key]->name))));
			
			$url = 'campanas/'.$slug.'/'.$name_slug.'-'.$resultado[$key]->id_enhance;

			$resultado[$key]->name_slug = $name_slug;
			$resultado[$key]->categoria = $categoria;
			$resultado[$key]->design_array = json_decode($resultado[$key]->design);
			$resultado[$key]->vinculo_producto = $url;

		}
		
		if($id_campana) {
			return $resultado[0];
		} else {
			return $resultado;
		}
	}
	
	public function obtener_string_colores_por_producto($id_producto) {
		$colores_res = $this->db->get_where('ColoresPorProducto', array('id_producto' => $id_producto, 'estatus' => 1));
		$colores = $colores_res->result();
		
		$textos = array();
		
		foreach($colores as $color) {
			array_push($textos, url_title($color->codigo_color, '-', TRUE));
		}
		
		foreach($textos as $indice=>$texto) {
			$textos[$indice] = ".color_".$texto;
		}
		
		return $textos;
	}

	public function obtener_string_tallas_por_producto($id_producto) {
		$this->db->select('*');
		$this->db->from('ColoresPorProducto');
		$this->db->join('CatalogoSkuPorProducto', 'ColoresPorProducto.id_color = CatalogoSkuPorProducto.id_color', 'left');
		$this->db->where(array('id_producto' => $id_producto));
		$tallas = $this->db->get()->result();
		
		$textos = array();
		
		foreach($tallas as $talla) {
			$talla->caracteristicas = json_decode($talla->caracteristicas);
			$talla->has_number = false;
			$talla->clean = ""; 
			foreach ($talla->caracteristicas as $key => $value) {
				if (is_numeric($value)) $talla->has_number = true;
				$talla->clean .= "$value";
			}
			$t = url_title($talla->clean, '-', TRUE);
			array_push($textos, ".talla_".$t);
		}

		return array_unique($textos);
	}

	public function obtener_tallas_por_producto($id_producto) {
		$this->db->select('*');
		$this->db->from('ColoresPorProducto');
		$this->db->join('CatalogoSkuPorProducto', 'ColoresPorProducto.id_color = CatalogoSkuPorProducto.id_color', 'left');
		$this->db->where(array('id_producto' => $id_producto));
		$tallas = $this->db->get()->result();
		
		foreach($tallas as $indice=>$talla) {
			$talla->caracteristicas = json_decode($talla->caracteristicas);
			$talla->has_number = false;
			$talla->clean = ""; 
			foreach ($talla->caracteristicas as $key => $value) {
				if (is_numeric($value)) $talla->has_number = true;
				$talla->clean .= "$value";
			}
			$t = url_title($talla->clean, '-', TRUE);
			$tallas[$indice]->string = ".talla_".$t;
		}

		return $tallas;
	}
	
	public function obtener_tallas_por_color($id_color) {
		$this->db->select('*');
		$this->db->from('CatalogoSkuPorProducto');
		$this->db->where('id_color', $id_color);
		
		$tallas = $this->db->get()->result();
		
		return $tallas;
	}

	public function obtener_string_caracteristicas_por_producto($id_producto) {
		$this->db->select('*');
		$this->db->from('CatalogoProductos');
		$this->db->where(array('id_producto' => $id_producto, 'estatus' => 1));
		$caracteristicas = $this->db->get()->result();
		
		$textos = array();
		
		foreach($caracteristicas as $caracteristica) {
			$caracteristica->caracteristicas_adicionales = json_decode($caracteristica->caracteristicas_adicionales);
			foreach ($caracteristica->caracteristicas_adicionales as $key => $value) {
				$caracteristica->clean = $key . "_" . $value;
				$c = url_title($caracteristica->clean, '-', TRUE);
				if (!is_null($caracteristica->caracteristicas_adicionales)) array_push($textos, ".".$c);
			}
		}

		return $textos;
	}
	
	public function obtener_colores_por_producto($id_producto) {
		$colores_res = $this->db->get_where('ColoresPorProducto', array('id_producto' => $id_producto));
		$colores = $colores_res->result();
		
		return $colores;
	}
	
	public function obtener_colores_activos_por_producto($id_producto) {
		$colores_res = $this->db->get_where('ColoresPorProducto', array('id_producto' => $id_producto, 'estatus' => 1));
		$colores = $colores_res->result();
		
		return $colores;
	}
	
	public function obtener_producto_con_md5($id_producto_md5) {
		$sql = "SELECT * FROM Productos JOIN Marcas ON Marcas.id_marca=Productos.id_marca WHERE MD5(id_producto)='".$id_producto_md5."'";
		$producto_res = $this->db->query($sql);
		$resultado = $producto_res->result();
		
		$resultado[0]->ubicacion_imagen = site_url('assets/images/demo/productos_ejemplo/'.$resultado[0]->imagen_producto);
		
		if($resultado[0]->descuento_especifico != 0.00) {
			$resultado[0]->precio_descuento = $resultado[0]->precio_producto*(1-$resultado[0]->descuento_especifico);
		}
		
		return $resultado[0];
	}
	
	public function obtener_metadatos_producto($id_producto) {
		$this->db->select('*, CatalogoProductos.id_producto as id');
		$this->db->from('CatalogoProductos');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto=CatalogoProductos.id_producto');
		$this->db->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color');
		$this->db->where('CatalogoProductos.estatus', 1);
		$this->db->where('ColoresPorProducto.estatus', 1);
		$this->db->where('CatalogoProductos.id_producto', $id_producto);
		$this->db->group_by('CatalogoProductos.id_producto');
		
		$producto_res = $this->db->get();
		$producto = $producto_res->result();
		
		$categoria = $this->categoria->obtener_categoria($producto[0]->id_categoria);
		
		$this->db->select("*");
		$this->db->from("FotografiasPorProducto");
		$this->db->where("id_color", $producto[0]->id_color);
		$this->db->where("estatus", 1);
		$this->db->order_by('principal', 'DESC');
		
		$fotografias_res = $this->db->get();
		$fotografias = $fotografias_res->result();
		
		$meta = '
			<meta property="og:url" content="'.site_url($categoria->nombre_categoria_slug.'/'.$producto[0]->nombre_producto_slug.'-'.$producto[0]->id_producto).'" />
			<meta property="og:type" content="product" />
			<meta property="og:title" content="'.$producto[0]->nombre_producto.'" />
			<meta property="og:description" content="'.$producto[0]->descripcion_producto.'" />
			<meta property="og:locale" content="es_LA" />
			<meta property="og:price:amount" content="'.number_format(floor(($producto[0]->precio_producto*(1-($producto[0]->descuento_especifico/100)))*(1+$this->configuracion_modelo->obtener_porcentaje_iva())), 2, ".", ",").'" />
			<meta property="og:price:currency" content="MXN" />';
				
			foreach($fotografias as $fotografia) {
				$meta.= '
					<meta property="og:image" content="'.site_url('assets/images/productos/producto'.$producto[0]->id_producto.'/'.$fotografia->fotografia_grande).'" />';
			}
		
		return $meta;
	}

	public function obtener_metadatos_enhance($id_enhance) {
		$this->db->select('*, CatalogoProductos.id_producto as id');
		$this->db->from('CatalogoProductos');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto=CatalogoProductos.id_producto');
		$this->db->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color');
		$this->db->where('CatalogoProductos.estatus', 1);
		$this->db->where('ColoresPorProducto.estatus', 1);
		$this->db->where('CatalogoProductos.id_producto', $id_enhance);
		$this->db->group_by('CatalogoProductos.id_producto');
		
		$producto_res = $this->db->get();
		$producto = $producto_res->result();
		
		$categoria = $this->categoria->obtener_categoria($producto[0]->id_categoria);
		
		$this->db->select("*");
		$this->db->from("FotografiasPorProducto");
		$this->db->where("id_color", $producto[0]->id_color);
		$this->db->where("estatus", 1);
		$this->db->order_by('principal', 'DESC');
		
		$fotografias_res = $this->db->get();
		$fotografias = $fotografias_res->result();
		
		$meta = '
			<meta property="og:url" content="'.site_url($categoria->nombre_categoria_slug.'/'.$producto[0]->nombre_producto_slug.'-'.$producto[0]->id_producto).'" />
			<meta property="og:type" content="product" />
			<meta property="og:title" content="'.$producto[0]->nombre_producto.'" />
			<meta property="og:description" content="'.$producto[0]->descripcion_producto.'" />
			<meta property="og:locale" content="es_LA" />
			<meta property="og:price:amount" content="'.number_format(floor(($producto[0]->precio_producto*(1-($producto[0]->descuento_especifico/100)))*(1+$this->configuracion_modelo->obtener_porcentaje_iva())), 2, ".", ",").'" />
			<meta property="og:price:currency" content="MXN" />';
				
			foreach($fotografias as $fotografia) {
				$meta.= '
					<meta property="og:image" content="'.site_url('assets/images/productos/producto'.$producto[0]->id_producto.'/'.$fotografia->fotografia_grande).'" />';
			}
		
		return $meta;
	}
	
	public function obtener_producto_con_id($id_producto) {
		
		$this->db->select('*, "producto" as type');
		$this->db->from('CatalogoProductos');
		$this->db->join('Marcas', 'Marcas.id_marca = CatalogoProductos.id_marca');
		$this->db->join('TiposDeProducto', 'TiposDeProducto.id_tipo = CatalogoProductos.id_tipo');
		$this->db->where('id_producto', $id_producto);

		$producto_res = $this->db->get();
		$resultado = $producto_res->result();
		
		$categoria = $this->categoria->obtener_categoria($resultado[0]->id_categoria);
		//$subcategoria = $this->categoria->obtener_categoria($resultado[0]->id_subcategoria);
		
		if($resultado[0]->descuento_especifico != 0.00) {
			$resultado[0]->precio_descuento = $resultado[0]->precio_producto*(1-($resultado[0]->descuento_especifico/100));
		}
		
		$resultado[0]->ubicacion_base = 'assets/images/productos/producto'.$resultado[0]->id_producto.'/';
		$resultado[0]->vinculo_producto = $categoria->nombre_categoria_slug.'/'.$resultado[0]->nombre_producto_slug.'-'.$resultado[0]->id_producto;
		
		return $resultado[0];
	}

	public function obtener_enhanced_con_id($id_producto) {
		
		$this->db->select('*, "enhance" as type');
		$this->db->from('Enhance');
		$this->db->join('CatalogoProductos', 'Enhance.id_producto = CatalogoProductos.id_producto');
		$this->db->join('Marcas', 'Marcas.id_marca = CatalogoProductos.id_marca');
		$this->db->join('TiposDeProducto', 'TiposDeProducto.id_tipo = CatalogoProductos.id_tipo');
		$this->db->where('id_enhance', $id_producto);
		//$this->db->where('Enhance.status', 1);

		$producto_res = $this->db->get();
		$resultado = $producto_res->result();

		$this->db->select('COUNT(id_ppp) as sold');
		$this->db->from('ProductosPorPedido');
		$this->db->join('Pedidos', 'ProductosPorPedido.id_pedido = Pedidos.id_pedido');
		$this->db->where('id_enhance', $id_producto);
		$this->db->where('Pedidos.estatus_pago', 'paid');

		$ventas = $this->db->get();

		$resultado[0]->sold_items = $ventas->row()->sold;

		
		$categoria = $this->categoria->obtener_categoria($resultado[0]->id_categoria);
		$subcategoria = $this->categoria->obtener_categoria($resultado[0]->id_subcategoria);
		
		if($resultado[0]->descuento_especifico != 0.00) {
			$resultado[0]->precio_descuento = $resultado[0]->precio_producto*(1-($resultado[0]->descuento_especifico/100));
		}
		
		$resultado[0]->ubicacion_base = 'assets/images/productos/producto'.$resultado[0]->id_producto.'/';
		$resultado[0]->vinculo_producto = $categoria->nombre_categoria_slug.'/'.$subcategoria->nombre_categoria_slug.'/'.$resultado[0]->nombre_producto_slug.'-'.$resultado[0]->id_producto;
		
		return $resultado[0];
	}

	public function obtener_producto_sku_por_id($id_sku, $quantity = 1) {
		
		$this->db->select('*');
		$this->db->from('CatalogoSkuPorProducto');
		$this->db->join('ColoresPorProducto', 'CatalogoSkuPorProducto.id_color = ColoresPorProducto.id_color');
		$this->db->join('CatalogoProductos', 'ColoresPorProducto.id_producto = CatalogoProductos.id_producto');
		$this->db->join('Marcas', 'Marcas.id_marca = CatalogoProductos.id_marca');
		$this->db->where('CatalogoSkuPorProducto.id_sku', $id_sku);

		$producto_res = $this->db->get();
		$resultado = $producto_res->row();
		$resultado->quantity = $quantity;
		
		
		return $resultado;
	}

	public function obtener_precio_minimo_por_producto($id_producto) {
		
		$this->db->select('min(precio) as precio');
		$this->db->from('CatalogoSkuPorProducto');
		$this->db->join('ColoresPorProducto', 'CatalogoSkuPorProducto.id_color = ColoresPorProducto.id_color');
		$this->db->join('CatalogoProductos', 'ColoresPorProducto.id_producto = CatalogoProductos.id_producto');
		$this->db->where('CatalogoProductos.id_producto', $id_producto);

		$query = $this->db->get();
		$resultado = $query->row();
		if (is_null($resultado)) {
			return 0;
		}
		
		return $resultado->precio;
	}

	public function obtener_disponibles_por_producto($id_producto)
	{
		$this->db->select('caracteristicas, cantidad_inicial, ColoresPorProducto.id_color, sku, id_sku');
		$this->db->from('CatalogoSkuPorProducto');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_color = CatalogoSkuPorProducto.id_color');
		$this->db->where('id_producto', $id_producto);

		$producto_res = $this->db->get();
		$resultado = $producto_res->result();


		$response =  array();

		foreach ($resultado as $item) {

			$response[$item->id_sku] = $item->cantidad_inicial;
		}


		return $response;


	}
	
	public function obtener_fotografias_por_producto($id_producto) {
		$sql = "SELECT * FROM FotografiasPorProducto WHERE id_producto=".$id_producto;
		$fotos_res = $this->db->query($sql);
		$fotos = $fotos_res->result();
		
		return $fotos;
	}
	
	public function obtener_fotografia_con_id($id_fotografia) {
		$foto_res = $this->db->get_where('FotografiasPorProducto', array('id_fotografia' => $id_fotografia));
		$foto = $foto_res->result();
		
		return $foto[0];
	}
	
	public function obtener_productos_en_promocion() {
		$this->db->select('*, CatalogoProductos.id_producto as id');
		$this->db->from('CatalogoProductos');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto=CatalogoProductos.id_producto');
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color');
		$this->db->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
		$this->db->join('ListasProductos', 'CatalogoProductos.id_producto=ListasProductos.id_producto', "left");
		$this->db->where('CatalogoProductos.estatus=1 AND (CatalogoProductos.descuento_especifico>0 OR CatalogoProductos.envio_gratis=1) AND ColoresPorProducto.estatus=1  AND FotografiasPorProducto.principal=1 AND FotografiasPorProducto.estatus=1');
		$this->db->order_by('RAND()');
		$this->db->group_by('CatalogoProductos.id_producto');
		$this->db->limit(6,0);
		
		$promo_res = $this->db->get();
		$num = $promo_res->num_rows();
		$promo = $promo_res->result();
		
		foreach($promo as $key=>$producto) {
			$promo[$key]->id_producto = $promo[$key]->id;
			if($promo[$key]->descuento_especifico != 0.00) {
				$promo[$key]->precio_descuento = $producto->precio_producto*(1-($producto->descuento_especifico/100));
			}
			$categoria = $this->categoria->obtener_categoria($producto->id_categoria);
			$subcategoria = $this->categoria->obtener_categoria($producto->id_subcategoria);
			$promo[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
			$promo[$key]->vinculo_producto = $categoria->nombre_categoria_slug.'/'.$producto->nombre_producto_slug.'-'.$producto->id_producto;
		}
		
		if($num == 0) {
			return false;
		} else {
			return $promo;
		}
	}
	
	public function obtener_seis_productos_random() {
		$this->db->select('*');
		$this->db->from('CatalogoProductos');
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_producto = CatalogoProductos.id_producto');
		$this->db->where('CatalogoProductos.estatus=1 AND (CatalogoProductos.descuento_especifico>0 OR CatalogoProductos.envio_gratis=1)');
		$this->db->order_by('RAND()');
		$this->db->limit(6,0);
		
		$promo_res = $this->db->get();
		$num = $promo_res->num_rows();
		$promo = $promo_res->result();
		
		foreach($promo as $key=>$producto) {
			if($promo[$key]->descuento_especifico != 0.00) {
				$promo[$key]->precio_descuento = $producto->precio_producto*(1-($producto->descuento_especifico/100));
			}
			$categoria = $this->categoria->obtener_categoria($producto->id_categoria);
			$subcategoria = $this->categoria->obtener_categoria($producto->id_subcategoria);
			$promo[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
			$promo[$key]->vinculo_producto = $categoria->nombre_categoria_slug.'/'.$subcategoria->nombre_categoria_slug.'/'.$producto->nombre_producto_slug.'-'.$producto->id_producto;
		}
		
		if($num == 0) {
			return false;
		} else {
			return $promo;
		}
	}
	
	public function obtener_productos_relacionados($array_ids) {
		
		if(sizeof($array_ids) == 1) {
			$producto = $this->catalogo_modelo->obtener_producto_con_id($array_ids[0]);
		}
		
		$this->db->select('*, CatalogoProductos.id_producto as id');
		$this->db->from('CatalogoProductos');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto=CatalogoProductos.id_producto');
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color');
		$this->db->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
		$this->db->join('ListasProductos', 'CatalogoProductos.id_producto=ListasProductos.id_producto', "left");
		$this->db->where('CatalogoProductos.estatus=1 AND ColoresPorProducto.estatus=1 AND FotografiasPorProducto.principal=1 AND FotografiasPorProducto.estatus=1');
		
		if(isset($producto)) {
			$this->db->where('CatalogoProductos.id_categoria', $producto->id_categoria);
		}
		
		foreach($array_ids as $id) {
			$this->db->where('CatalogoProductos.id_producto !=', $id);
		}
		$this->db->order_by('RAND()');
		$this->db->group_by('CatalogoProductos.id_producto');
		$this->db->limit(6,0);
		
		$promo_res = $this->db->get();
		$num = $promo_res->num_rows();
		$promo = $promo_res->result();
		
		foreach($promo as $key=>$producto) {
			$promo[$key]->id_producto = $promo[$key]->id;
			if($promo[$key]->descuento_especifico != 0.00) {
				$promo[$key]->precio_descuento = $producto->precio_producto*(1-($producto->descuento_especifico/100));
			}
			$categoria = $this->categoria->obtener_categoria($producto->id_categoria);
			$subcategoria = $this->categoria->obtener_categoria($producto->id_subcategoria);
			$promo[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
			$promo[$key]->vinculo_producto = $categoria->nombre_categoria_slug.'/'.$producto->nombre_producto_slug.'-'.$producto->id_producto;
		}
		
		if($num == 0) {
			return null;
		} else {
			return $promo;
		}
	}
	
	public function busqueda($b) {
		
	}
	
	public function obtener_productos_en_lista($id_producto) {
		$this->db->select('*');
		$this->db->from('ListasProductos');
		$this->db->join('CatalogoProductos', 'CatalogoProductos.id_producto =ListasProductos.id_producto', 'left');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto = CatalogoProductos.id_producto', 'left');
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color', 'left');
		$this->db->where('ListasProductos.id_producto',$id_producto);
		$this->db->group_by("ListasProductos.id_producto"); 

		$productos_res = $this->db->get();
		$num = $productos_res->num_rows();
		$lista = $productos_res->result();
		
		foreach($lista as $key=>$producto) {
			if($lista[$key]->descuento_especifico != 0.00) {
				$lista[$key]->precio_descuento = $producto->precio_producto*(1-($producto->descuento_especifico/100));
			}
			$categoria = $this->categoria->obtener_categoria($producto->id_categoria);
			$subcategoria = $this->categoria->obtener_categoria($producto->id_subcategoria);
			$lista[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
			$lista[$key]->vinculo_producto = $categoria->nombre_categoria_slug.'/'.$subcategoria->nombre_categoria_slug.'/'.$producto->nombre_producto_slug.'-'.$producto->id_producto;
		}
		
		if($num == 0) {
			return false;
		} else {
			return $lista;
		}
	}

	public function obtener_tallas_por_categoria($categoria_id)
	{
		$this->db->select('CatalogoSkuPorProducto.caracteristicas');
		$this->db->from('Categorias');
		$this->db->join('CatalogoProductos', 'Categorias.id_categoria = CatalogoProductos.id_categoria', 'left');
		$this->db->join('ColoresPorProducto', 'CatalogoProductos.id_producto = ColoresPorProducto.id_producto', 'left');
		$this->db->join('CatalogoSkuPorProducto', 'ColoresPorProducto.id_color = CatalogoSkuPorProducto.id_color', 'left');
		$this->db->where('Categorias.id_categoria',$categoria_id);

		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$results =  $query->result();

			$items = array();

			foreach ($results as $key => $result) {
				$result->caracteristicas = json_decode($result->caracteristicas);
				$result->clean= "";
				$result->has_number= false;
				foreach ($result->caracteristicas as $key => $value) {
					if (is_numeric($value)) $result->has_number = true;
					$result->clean .= "$value";
				}



				$items[$result->clean] = 1;

			}

			//funcion de ordenamiento

			return $items;
		}else{
			return NULL;
		}
	}

	public function getMaxPriceFromProduct($producto_id)
	{
		$this->db->select("MAX(CatalogoSkuPorProducto.precio) as max_precio");
		$this->db->from("CatalogoSkuPorProducto");
		$this->db->join('ColoresPorProducto', 'CatalogoSkuPorProducto.id_color = ColoresPorProducto.id_color');
		$this->db->where("ColoresPorProducto.id_producto", $producto_id);

		$query = $this->db->get();

		return $query->row()->max_precio;

	}

	public function obtener_caracteristicas_adicionales_por_categoria($categoria_id)
	{
		$this->db->select(
			't1.nombre_caracteristica_slug AS slug1, t1.nombre_caracteristica AS lev1, 
			t2.nombre_caracteristica_slug AS slug2, t2.nombre_caracteristica as lev2, 
			t3.nombre_caracteristica_slug AS slug3, t3.nombre_caracteristica as lev3, 
			t4.nombre_caracteristica_slug AS slug4, t4.nombre_caracteristica as lev4');
		$this->db->from('Categorias');
		$this->db->join('TipoPerteneceACategoria', 'Categorias.id_categoria =TipoPerteneceACategoria.id_categoria', 'left');
		$this->db->join('TiposDeProducto', 'TipoPerteneceACategoria.id_tipo =TiposDeProducto.id_tipo', 'left');
		$this->db->join('CaracteristicasAdicionales as t1', 't1.id_tipo = TiposDeProducto.id_tipo', 'left');
		$this->db->join('CaracteristicasAdicionales as t2', 't2.id_caracteristica_parent = t1.id_caracteristica', 'left');
		$this->db->join('CaracteristicasAdicionales as t3', 't3.id_caracteristica_parent = t2.id_caracteristica', 'left');	
		$this->db->join('CaracteristicasAdicionales as t4', 't4.id_caracteristica_parent = t3.id_caracteristica', 'left');	
		$this->db->where('Categorias.id_categoria',$categoria_id); 
		$this->db->where('t1.id_caracteristica_parent','0'); 

		

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$results =  $query->result();
			$items = array();

			foreach ($results as $key => $result) {
				if (!is_null($result->slug4)) {
					$items[$result->slug1]["items"][$result->slug2]["items"][$result->slug3]["items"][$result->slug4]["slug"] = $result->slug4;
					$items[$result->slug1]["items"][$result->slug2]["items"][$result->slug3]["items"][$result->slug4]["nombre"] = $result->lev4;
				}
				if (!is_null($result->slug3)) {
					$items[$result->slug1]["items"][$result->slug2]["items"][$result->slug3]["slug"] = $result->slug3;
					$items[$result->slug1]["items"][$result->slug2]["items"][$result->slug3]["nombre"] = $result->lev3;
				}
				if (!is_null($result->slug2)) {
					$items[$result->slug1]["items"][$result->slug2]["slug"] = $result->slug2;
					$items[$result->slug1]["items"][$result->slug2]["nombre"] = $result->lev2;
				}
				if (!is_null($result->slug1)) {
					$items[$result->slug1]["slug"] = $result->slug1;
					$items[$result->slug1]["nombre"] = $result->lev1;
				}
				
			}
			return $items;
		}else{
			return NULL;
		}
	}

	public function obtener_caracterisitcas_adicionales_por_categoria($categoria_id)
	{
		$this->db->select('
			t1.nombre_caracteristica_slug AS slug1, t1.nombre_caracteristica AS lev1, 
			t2.nombre_caracteristica_slug AS slug2, t2.nombre_caracteristica as lev2, 
			t3.nombre_caracteristica_slug AS slug3, t3.nombre_caracteristica as lev3, 
			t4.nombre_caracteristica_slug AS slug4, t4.nombre_caracteristica as lev4
		');
		$this->db->from('TiposDeProducto');
		//$this->db->join('TiposDeProducto', 'TipoPerteneceACategoria.id_tipo =TiposDeProducto.id_tipo', 'left');
		$this->db->join('CaracteristicasAdicionales as t1', 't1.id_tipo = TiposDeProducto.id_tipo', 'left');
		$this->db->join('CaracteristicasAdicionales as t2', 't2.id_caracteristica_parent = t1.id_caracteristica', 'left');
		$this->db->join('CaracteristicasAdicionales as t3', 't3.id_caracteristica_parent = t2.id_caracteristica', 'left');	
		$this->db->join('CaracteristicasAdicionales as t4', 't4.id_caracteristica_parent = t3.id_caracteristica', 'left');	
		$this->db->where('TiposDeProducto.id_tipo',$categoria_id); 
		$this->db->where('t1.id_caracteristica_parent','0'); 

		//echo $this->db->get_compiled_select();		

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$results =  $query->result();
			$items = array();

			foreach ($results as $key => $result) {
				if (!is_null($result->slug4)) {
					$items[$result->slug1]["items"][$result->slug2]["items"][$result->slug3]["items"][$result->slug4]["slug"] = $result->slug4;
					$items[$result->slug1]["items"][$result->slug2]["items"][$result->slug3]["items"][$result->slug4]["nombre"] = $result->lev4;
				}
				if (!is_null($result->slug3)) {
					$items[$result->slug1]["items"][$result->slug2]["items"][$result->slug3]["slug"] = $result->slug3;
					$items[$result->slug1]["items"][$result->slug2]["items"][$result->slug3]["nombre"] = $result->lev3;
				}
				if (!is_null($result->slug2)) {
					$items[$result->slug1]["items"][$result->slug2]["slug"] = $result->slug2;
					$items[$result->slug1]["items"][$result->slug2]["nombre"] = $result->lev2;
				}
				if (!is_null($result->slug1)) {
					$items[$result->slug1]["slug"] = $result->slug1;
					$items[$result->slug1]["nombre"] = $result->lev1;
				}
				
			}
			return $items;
		}else{
			return NULL;
		}
	}
}