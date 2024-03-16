<?php

class Catalogo_modelo extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}

	public function obtener_colores_disponibles($id_categoria, $id_tipo) {
		$sql = "SELECT DISTINCT(codigo_color) FROM
				(SELECT CatalogoProductos.id_producto,
						ColoresPorProducto.codigo_color
				FROM CatalogoProductos
				JOIN ColoresPorProducto ON ColoresPorProducto.id_producto=CatalogoProductos.id_producto
				WHERE CatalogoProductos.id_categoria=".$id_categoria."
				AND CatalogoProductos.id_tipo=".$id_tipo."
				AND CatalogoProductos.estatus=1) AS Prods";
		$colores_res = $this->db->query($sql);
		//if ($colores_res->num_rows() == 0) return null;
		$resultado = $colores_res->result();
		return $resultado;
	}

	public function obtener_colores_adicionales($id_producto, $id_color)
	{
		$this->db->select('*')
				 ->from('ColoresPorProducto')
				 ->where('ColoresPorProducto.id_producto', $id_producto)
				 ->where('ColoresPorProducto.id_color !=', $id_color)
				 ->where('ColoresPorProducto.codigo_color !=', '#FFFFFF')
				 ->where('ColoresPorProducto.estatus', 1);
		$colores = $this->db->get()->result();

		if(sizeof($colores) > 0) {
			return $colores;
		} else {
			return array();
		}
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

		if(isset($resultado[0])) {
			return $resultado[0];
		} else {
			return 0;
		}
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

	public function obtener_precios_tope($id_categoria, $id_tipo)
	{
		/* if($id_categoria != 2) {
			$sql = "SELECT MIN(precio_producto*(1-(descuento_especifico/100))) AS minimo, MAX(precio_producto*(1-(descuento_especifico/100))) AS maximo FROM CatalogoProductos WHERE estatus=1 AND id_categoria=".$id_categoria;
		} else {
			$sql = "SELECT MIN(price) AS minimo, MAX(price) AS maximo FROM Enhance WHERE estatus=1";
		}
		$minimo_res = $this->db->query($sql);
		$resultado = $minimo_res->row(); */

		$sql = "SELECT CatalogoProductos.id_producto,
					   (SELECT MIN(precio) FROM ColoresPorProducto WHERE ColoresPorProducto.id_producto=CatalogoProductos.id_producto) AS precio
				FROM CatalogoProductos
				WHERE CatalogoProductos.id_categoria=".$id_categoria." AND CatalogoProductos.id_tipo=".$id_tipo." AND CatalogoProductos.estatus=1
				ORDER BY precio ASC";
		$precios_res = $this->db->query($sql);
		$precios = $precios_res->result();

		$resultado = new stdClass();
		$resultado->minimo = $precios[0]->precio;
		$resultado->maximo = $precios[sizeof($precios)-1]->precio;



		/* $sql = "SELECT MIN(precio) AS minimo, MAX(precio) AS maximo FROM (
			SELECT CatalogoProductos.id_categoria, ColoresPorProducto.*
			FROM CatalogoProductos
			JOIN ColoresPorProducto ON ColoresPorProducto.id_producto = CatalogoProductos.id_producto
			JOIN CatalogoSkuPorProducto ON CatalogoSkuPorProducto.id_color = ColoresPorProducto.id_color
			WHERE CatalogoProductos.id_categoria = ".$id_categoria." AND CatalogoProductos.id_tipo=".$id_tipo."
		) AS Precios";
		$minimo_res = $this->db->query($sql);
		$resultado = $minimo_res->row(); */

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

	public function obtener_minimo_id_editable()
	{
		$this->db->select('*');
		$this->db->from('CatalogoProductos');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto = CatalogoProductos.id_producto');
		$this->db->order_by('CatalogoProductos.id_producto', 'ASC');
		$this->db->order_by('ColoresPorProducto.id_color', 'ASC');
		$this->db->limit(1);

		$resultado_res = $this->db->get();
		$resultado = $resultado_res->result();

		return $resultado;
	}

	public function obtener_productos($id_categoria, $id_tipo = null) {

		$this->db->select('*, CatalogoProductos.id_producto as id, "producto" as type');
		$this->db->from('CatalogoProductos');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto=CatalogoProductos.id_producto');
		$this->db->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
		$this->db->join('ListasProductos', 'CatalogoProductos.id_producto=ListasProductos.id_producto', "left");
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color');
		$this->db->join('TiposDeProducto', 'TiposDeProducto.id_tipo = CatalogoProductos.id_tipo');
		$this->db->where('CatalogoProductos.id_categoria', $id_categoria);
		if($id_tipo) {
			$this->db->where('CatalogoProductos.id_tipo', $id_tipo);
		}
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
			$resultado[$key]->vinculo_producto = $categoria->nombre_categoria_slug.'/'.$producto->nombre_tipo_slug.'/'.$producto->nombre_producto_slug.'-'.$producto->id_producto;

		}

		return $resultado;
	}

	public function obtener_productos_distintos() {
		$categorias = $this->categoria->obtener_categorias_no_enhance();
		foreach($categorias as $indice=>$categoria) {
            if(isset($this->session->login)) {
                if($this->session->login['email'] == 'hello@printome.mx') {
                    $categorias[$indice]->tipos = $this->tipo_modelo->obtener_tipos_admin($categoria->id_categoria);
                }else{
                    $categorias[$indice]->tipos = $this->tipo_modelo->obtener_tipos_cliente($categoria->id_categoria);
                }
            }else{
                $categorias[$indice]->tipos = $this->tipo_modelo->obtener_tipos_cliente($categoria->id_categoria);
            }


			foreach($categorias[$indice]->tipos as $indice_tipo=>$tipo) {
				$this->db->select('*, CatalogoProductos.id_producto as id, "producto" as type');
				$this->db->from('CatalogoProductos');
				$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto=CatalogoProductos.id_producto');
				$this->db->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
				$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color');
				$this->db->where('CatalogoProductos.id_categoria', $categoria->id_categoria);
				$this->db->where('CatalogoProductos.id_tipo', $tipo->tipo->id_tipo);
				$this->db->where('CatalogoProductos.estatus', 1);
				$this->db->where('ColoresPorProducto.estatus', 1);
				$this->db->where('FotografiasPorProducto.estatus', 1);
				$this->db->where('FotografiasPorProducto.principal', 1);
				$this->db->order_by('CatalogoProductos.id_producto', 'ASC');
				$this->db->group_by('CatalogoProductos.id_producto');

				$categorias[$indice]->tipos->{$indice_tipo}->productos = $this->db->get()->result();

				foreach($categorias[$indice]->tipos->{$indice_tipo}->productos as $key=>$producto) {
					$categorias[$indice]->tipos->{$indice_tipo}->productos[$key]->id_producto = $categorias[$indice]->tipos->{$indice_tipo}->productos[$key]->id;
					if($categorias[$indice]->tipos->{$indice_tipo}->productos[$key]->descuento_especifico != 0.00) {
						$categorias[$indice]->tipos->{$indice_tipo}->productos[$key]->precio_descuento = $producto->precio_producto*(1-($producto->descuento_especifico/100));
					}
					$categorias[$indice]->tipos->{$indice_tipo}->productos[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
					$categorias[$indice]->tipos->{$indice_tipo}->productos[$key]->vinculo_producto = $categoria->nombre_categoria_slug.'/'.$tipo->tipo->nombre_tipo_slug.'/'.$producto->nombre_producto_slug.'-'.$producto->id_producto;

				}
			}
		}
		return $categorias;
	}

    public function obtener_misma_etiqueta($etiquetas, $id_excluir)
    {
        $this->db->select('Enhance.*, CatalogoProductos.id_producto AS id, CatalogoProductos.id_categoria, CatalogoProductos.id_subcategoria, CatalogoProductos.genero')
                 ->from('Enhance')
                 ->join('CatalogoProductos', 'CatalogoProductos.id_producto=Enhance.id_producto')
                 ->join('ColoresPorProducto', 'ColoresPorProducto.id_color=Enhance.id_color')
				 ->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca')
                 ->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color')
 				 ->where('CatalogoProductos.estatus', 1)
 				 ->where('ColoresPorProducto.estatus', 1)
 				 ->where('FotografiasPorProducto.estatus', 1)
 				 ->where('FotografiasPorProducto.principal', 1)
 				 ->where('Enhance.id_parent_enhance', 0)
                 ->like('Enhance.etiquetas', $etiquetas)
                 ->where('Enhance.etiquetas !=', '')
                 ->where('Enhance.id_enhance !=', $id_excluir)
                 ->group_start()
					 ->where('Enhance.type', 'fijo')
					 ->or_group_start()
						->where('Enhance.type', 'limitado')
						->where('Enhance.end_date >=', date("Y-m-d H:i:s"))
					 ->group_end()
				 ->group_end()
                 ->where("Enhance.estatus", 1)
                 ->limit(5)
                 ->group_by('Enhance.id_enhance');

        //echo $this->db->get_compiled_select();
 		$productos_res = $this->db->get();
 		$resultado = $productos_res->result();

 		foreach($resultado as $key=>$producto) {
 			$resultado[$key]->id_producto = $resultado[$key]->id;
 			$resultado[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
 			$categoria = $this->categoria->obtener_categoria($producto->id_categoria);

 			$name_slug = strtolower(url_title(convert_accented_characters(trim($resultado[$key]->name))));

 			$url = 'compra/'.($resultado[$key]->type == 'fijo' ? 'venta-inmediata' : 'plazo-definido').'/'.$name_slug.'-'.$resultado[$key]->id_enhance;

 			$resultado[$key]->name_slug = $name_slug;
 			$resultado[$key]->categoria = $categoria;
 			$resultado[$key]->vinculo_producto = $url;
 		}

        if(sizeof($resultado) > 0) {
        	return $resultado;
        } else {
            return array();
        }
    }

	public function obtener_enhanced($tipo_campana = null, $start = 0, $offset = 0, $random_seed = 123, $filtros = array(), $id_campana = null, $id_cliente = null, $exclude_id = null) {
		$this->db->select('Enhance.id_enhance, Enhance.name, Enhance.description, Enhance.etiquetas, Enhance.visitas, Enhance.id_clasificacion, Enhance.type, Enhance.id_producto, Enhance.sold, Enhance.quantity, Enhance.costo, Enhance.price, Enhance.front_image, Enhance.back_image, Enhance.right_image, Enhance.left_image, Enhance.date, Enhance.end_date, Enhance.days, Enhance.id_cliente, Enhance.id_color, Enhance.estatus, Enhance.additional_info, Enhance.cron, Enhance.id_parent_enhance, Enhance.modificador_ventas, Enhance.cantidad_vendida, Enhance.cantidad_adicional, Enhance.faltante,
						   Enhance.wow_winner,
						   ListasProductos.*,
						   CatalogoProductos.id_producto as id,
						   CatalogoProductos.id_categoria,
						   CatalogoProductos.id_subcategoria,
                           CatalogoProductos.genero')
				 ->from('Enhance')
				 ->join('CatalogoProductos', 'CatalogoProductos.id_producto=Enhance.id_producto')
				 ->join('ColoresPorProducto', 'ColoresPorProducto.id_color=Enhance.id_color')
				 ->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
		if($this->session->has_userdata('login')) {
			$this->db->join('ListasProductos', '(Enhance.id_enhance=ListasProductos.id_producto AND ListasProductos.id_cliente='.$this->session->login['id_cliente'].')', "left");
		} else {
			$this->db->join('ListasProductos', '(Enhance.id_enhance=ListasProductos.id_producto AND ListasProductos.id_cliente IS NULL)', "left");
		}
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color')
				 ->where('CatalogoProductos.estatus', 1)
				 ->where('ColoresPorProducto.estatus', 1)
				 ->where('FotografiasPorProducto.estatus', 1)
				 ->where('FotografiasPorProducto.principal', 1)
				 ->where('Enhance.id_parent_enhance', 0);


 		if(isset($filtros['busqueda'])) {
            $this->db->group_start();
                $this->db->or_like('Enhance.name', $filtros['busqueda']);
                $this->db->or_like('Enhance.id_enhance', $filtros['busqueda']);
                $this->db->or_like('Enhance.etiquetas', $filtros['busqueda']);
            $this->db->group_end();
 		}

		if(isset($filtros['idClasificacion'])) {
			if($filtros['idClasificacion'] != '*') {
				$this->db->where('Enhance.id_clasificacion', (int)$filtros['idClasificacion']);
			}
		}

        if(isset($filtros['idSubclasificacion'])) {
            if($filtros['idSubclasificacion'] != '*') {
                $this->db->where('Enhance.id_subclasificacion', (int)$filtros['idSubclasificacion']);
            }
        }

        if(isset($filtros['idSubsubclasificacion'])) {
            if ($filtros['idSubsubclasificacion'] != '*') {
                $this->db->where('Enhance.id_subsubclasificacion', (int)$filtros['idSubsubclasificacion']);
            }
        }

        if(isset($filtros['genero'])) {
            if($filtros['genero'] != '*') {
                $this->db->where('CatalogoProductos.genero', (int)$filtros['genero']);
            }
        }

		if($id_cliente) {
			$this->db->where('Enhance.id_cliente', $id_cliente);
		}

        if($exclude_id) {
            $this->db->where('Enhance.id_enhance !=', $exclude_id);
        }

		if(!$tipo_campana || $tipo_campana == 'null') {
			$this->db->group_start()
					 ->where('Enhance.type', 'fijo')
					 ->or_group_start()
						->where('Enhance.type', 'limitado')
						->where('Enhance.end_date >=', date("Y-m-d H:i:s"))
					 ->group_end()
					 ->group_end();
		} else {
			if($tipo_campana == 'fijo') {
				$this->db->where('Enhance.type', 'fijo');
			} else if($tipo_campana == 'limitado') {
				$this->db->where('Enhance.type', 'limitado')
						 ->where('Enhance.end_date >=', date("Y-m-d H:i:s"));
			}
		}

		if($start < 0 || $offset < 0) {
			if($id_campana) {
				$this->db->where('Enhance.id_enhance', $id_campana);
			}
			$this->db->limit(1);
		} else {
			if($start == 1) {
				$start = 0;
			}
			$this->db->limit($offset, $start);
		}

		// F F F


        if(!isset($filtros['ordenarPrecio']) && !isset($filtros['ordenarPopularidad']) && !isset($filtros['ordenarTiempo'])) {
            if($id_cliente) {
                if($id_cliente == 341) {
                    $this->db->order_by('Enhance.id_enhance', 'DESC');
                } else {
                    //$this->db->order_by('RAND('.$random_seed.')');
                    $this->db->order_by('FIELD(Enhance.id_producto, 42) DESC, FIELD(Enhance.id_enhance, 34925, 34924) DESC, RAND('.$random_seed.')');
                }
            } else {
                if(isset($filtros['busqueda'])) {
                    if(strtoupper($filtros['busqueda']) == 'PAREJAS2018') {
                        $this->db->order_by('Enhance.id_enhance', 'DESC');
                    } else {
                        //$this->db->order_by('RAND('.$random_seed.')');
                        $this->db->order_by('FIELD(Enhance.id_producto, 42) DESC, FIELD(Enhance.id_enhance, 34925, 34924)DESC, RAND('.$random_seed.')');
                    }
                } else {
                    //$this->db->order_by('RAND('.$random_seed.')');
                    $this->db->order_by('FIELD(Enhance.id_producto, 42) DESC, FIELD(Enhance.id_enhance, 34925, 34924)DESC, RAND('.$random_seed.')');
                }
            }
		} else if(isset($filtros['ordenarPrecio']) && !isset($filtros['ordenarPopularidad']) && !isset($filtros['ordenarTiempo'])) {
			// V F F - ordenar por precio
			if($filtros['ordenarPrecio'] == 'asc' || $filtros['ordenarPrecio'] == 'desc') {
				$this->db->order_by('price', $filtros['ordenarPrecio']);
			}
		} else if(isset($filtros['ordenarPrecio']) && isset($filtros['ordenarPopularidad']) && !isset($filtros['ordenarTiempo'])) {
			// V V F - ordenar por precio y popularidad
			if($filtros['ordenarPrecio'] == 'asc' || $filtros['ordenarPrecio'] == 'desc') {
				$this->db->order_by('price', $filtros['ordenarPrecio']);
			}
			if($filtros['ordenarPopularidad'] == 'asc' || $filtros['ordenarPopularidad'] == 'desc') {
				$this->db->order_by('cantidad_vendida', $filtros['ordenarPopularidad']);
			}

		} else if(isset($filtros['ordenarPrecio']) && isset($filtros['ordenarPopularidad']) && isset($filtros['ordenarTiempo'])) {
			// V V V - ordenar por precio, popularidad y tiempo
			if($filtros['ordenarPrecio'] == 'asc' || $filtros['ordenarPrecio'] == 'desc') {
				$this->db->order_by('price', $filtros['ordenarPrecio']);
			}
			if($filtros['ordenarPopularidad'] == 'asc' || $filtros['ordenarPopularidad'] == 'desc') {
				$this->db->order_by('cantidad_vendida', $filtros['ordenarPopularidad']);
			}
			if($filtros['ordenarTiempo'] == 'asc' || $filtros['ordenarTiempo'] == 'desc') {
				$this->db->order_by('faltante', $filtros['ordenarTiempo']);
			}

		} else if(!isset($filtros['ordenarPrecio']) && isset($filtros['ordenarPopularidad']) && !isset($filtros['ordenarTiempo'])) {
			// F V F - ordenar por popularidad
			if($filtros['ordenarPopularidad'] == 'asc' || $filtros['ordenarPopularidad'] == 'desc') {
				$this->db->order_by('SUM(cantidad_vendida + cantidad_adicional)', $filtros['ordenarPopularidad']);
			}
		} else if(!isset($filtros['ordenarPrecio']) && isset($filtros['ordenarPopularidad']) && isset($filtros['ordenarTiempo'])) {
			// F V V - ordenar por popularidad y tiempo
			if($filtros['ordenarPopularidad'] == 'asc' || $filtros['ordenarPopularidad'] == 'desc') {
				$this->db->order_by('SUM(cantidad_vendida + cantidad_adicional)', $filtros['ordenarPopularidad']);
			}
			if($filtros['ordenarTiempo'] == 'asc' || $filtros['ordenarTiempo'] == 'desc') {
				$this->db->order_by('faltante', $filtros['ordenarTiempo']);
			}

		} else if(!isset($filtros['ordenarPrecio']) && !isset($filtros['ordenarPopularidad']) && isset($filtros['ordenarTiempo'])) {
			// F F V - ordenar por tiempo
			if($filtros['ordenarTiempo'] == 'asc' || $filtros['ordenarTiempo'] == 'desc') {
				$this->db->order_by('faltante', $filtros['ordenarTiempo']);
			}

		} else if(isset($filtros['ordenarPrecio']) && !isset($filtros['ordenarPopularidad']) && isset($filtros['ordenarTiempo'])) {
			// V F V - ordenar por precio y tiempo
			if($filtros['ordenarPrecio'] == 'asc' || $filtros['ordenarPrecio'] == 'desc') {
				$this->db->order_by('price', $filtros['ordenarPrecio']);
			}
			if($filtros['ordenarTiempo'] == 'asc' || $filtros['ordenarTiempo'] == 'desc') {
				$this->db->order_by('faltante', $filtros['ordenarTiempo']);
			}

		}
		$this->db->where("Enhance.estatus", 1);
		$this->db->group_by('Enhance.id_enhance');
		//echo $this->db->get_compiled_select();
		$productos_res = $this->db->get();

		$resultado = $productos_res->result();
		if($id_cliente) {
			$tienda = $this->tienda_m->obtener_tienda_por_id_dueno($id_cliente);
		}

		foreach($resultado as $key=>$producto) {
			$resultado[$key]->id_producto = $resultado[$key]->id;
			$resultado[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
			$categoria = $this->categoria->obtener_categoria($producto->id_categoria);

			$name_slug = strtolower(url_title(convert_accented_characters(trim($resultado[$key]->name))));

			if(!$id_cliente) {
				$url = 'compra/'.($resultado[$key]->type == 'fijo' ? 'venta-inmediata' : 'plazo-definido').'/'.$name_slug.'-'.$resultado[$key]->id_enhance;
			} else {
				$url = 'tienda/'.$tienda->nombre_tienda_slug.'/'.($resultado[$key]->type == 'fijo' ? 'venta-inmediata' : 'plazo-definido').'/'.$name_slug.'-'.$resultado[$key]->id_enhance;
			}

			$resultado[$key]->name_slug = $name_slug;
			$resultado[$key]->categoria = $categoria;
			//$resultado[$key]->design_array = json_decode($resultado[$key]->design);
			$resultado[$key]->vinculo_producto = $url;
		}



		if($id_campana) {
			return $resultado[0];
		} else {
			return $resultado;
		}
	}

    public function obtener_enhanced_mas_popular($limite)
    {
        $this->db->select('Enhance.*,
                           Enhance.visitas/DATEDIFF(\''.date("Y-m-d H:i:s").'\', `date`) AS popularidad,
						   ListasProductos.*,
						   CatalogoProductos.id_producto as id,
						   CatalogoProductos.id_categoria,
						   CatalogoProductos.id_subcategoria,
						   IFNULL((SELECT SUM(cantidad_producto) FROM ProductosPorPedido JOIN Pedidos ON ProductosPorPedido.id_pedido=Pedidos.id_pedido WHERE ProductosPorPedido.id_enhance=Enhance.id_enhance AND Pedidos.estatus_pago=\'paid\' AND Pedidos.estatus_pedido != \'Cancelado\'), 0) AS cantidad_vendida,
						   IFNULL((SELECT SUM(cantidad_producto) FROM ProductosPorPedido JOIN Enhance AS Enh ON ProductosPorPedido.id_enhance=Enh.id_parent_enhance JOIN Pedidos ON ProductosPorPedido.id_pedido=Pedidos.id_pedido WHERE Enh.id_parent_enhance != 0 AND Enh.id_parent_enhance=Enhance.id_enhance AND Pedidos.estatus_pago=\'paid\' AND Pedidos.estatus_pedido != \'Cancelado\'), 0) AS cantidad_adicional,
						   DATEDIFF(\''.date("Y-m-d H:i:s").'\', Enhance.end_date) AS faltante')
				 ->from('Enhance')
				 ->join('CatalogoProductos', 'CatalogoProductos.id_producto=Enhance.id_producto')
				 ->join('ColoresPorProducto', 'ColoresPorProducto.id_color=Enhance.id_color')
				 ->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
		if($this->session->has_userdata('login')) {
			$this->db->join('ListasProductos', '(Enhance.id_enhance=ListasProductos.id_producto AND ListasProductos.id_cliente='.$this->session->login['id_cliente'].')', "left");
		} else {
			$this->db->join('ListasProductos', '(Enhance.id_enhance=ListasProductos.id_producto AND ListasProductos.id_cliente IS NULL)', "left");
		}
		$this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color')
				 ->where('CatalogoProductos.estatus', 1)
				 ->where('ColoresPorProducto.estatus', 1)
				 ->where('FotografiasPorProducto.estatus', 1)
				 ->where('FotografiasPorProducto.principal', 1)
				 ->where('Enhance.id_parent_enhance', 0);

        $this->db->group_start()
                 ->where('Enhance.type', 'fijo')
                 ->or_group_start()
                    ->where('Enhance.type', 'limitado')
                    ->where('Enhance.end_date >=', date("Y-m-d H:i:s"))
                 ->group_end()
                 ->group_end();
        $this->db->order_by('popularidad', 'DESC');
        $this->db->group_by('Enhance.id_enhance');
        $this->db->limit($limite);

        $populares = $this->db->get()->result();

        if(sizeof($populares) > 0) {
            foreach($populares as $key=>$producto) {
    			$populares[$key]->id_producto = $populares[$key]->id;
    			$populares[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
    			$categoria = $this->categoria->obtener_categoria($producto->id_categoria);

    			$name_slug = strtolower(url_title(convert_accented_characters(trim($populares[$key]->name))));

    			$url = 'compra/'.($populares[$key]->type == 'fijo' ? 'venta-inmediata' : 'plazo-definido').'/'.$name_slug.'-'.$populares[$key]->id_enhance;

    			$populares[$key]->name_slug = $name_slug;
    			$populares[$key]->categoria = $categoria;
    			$populares[$key]->design_array = json_decode($populares[$key]->design);
    			$populares[$key]->vinculo_producto = $url;
    		}

            return $populares;
        } else {
            return array();
        }
    }

	public function obtener_enhanced_sin_diseno($tipo_campana = null) {

		$this->db->select('Enhance.id_enhance, Enhance.name, Enhance.id_clasificacion, Enhance.type, Enhance.id_producto, Enhance.sold, Enhance.quantity, Enhance.costo, Enhance.price, Enhance.date, Enhance.end_date, Enhance.days, Enhance.estatus, Enhance.cron, Enhance.id_parent_enhance, Enhance.id_cliente,
						   CatalogoProductos.id_producto as id,
						   CatalogoProductos.id_categoria,
						   CatalogoProductos.id_subcategoria,
                           CatalogoProductos.genero,
						   IFNULL((SELECT SUM(cantidad_producto) FROM ProductosPorPedido JOIN Pedidos ON ProductosPorPedido.id_pedido=Pedidos.id_pedido WHERE ProductosPorPedido.id_enhance=Enhance.id_enhance AND Pedidos.estatus_pago=\'paid\' AND Pedidos.estatus_pedido != \'Cancelado\'), 0) AS cantidad_vendida,
						   IFNULL((SELECT SUM(cantidad_producto) FROM ProductosPorPedido JOIN Enhance AS Enh ON ProductosPorPedido.id_enhance=Enh.id_parent_enhance JOIN Pedidos ON ProductosPorPedido.id_pedido=Pedidos.id_pedido WHERE Enh.id_parent_enhance != 0 AND Enh.id_parent_enhance=Enhance.id_enhance AND Pedidos.estatus_pago=\'paid\' AND Pedidos.estatus_pedido != \'Cancelado\'), 0) AS cantidad_adicional,
						   DATEDIFF(\''.date("Y-m-d H:i:s").'\', Enhance.end_date) AS faltante')
				 ->from('Enhance')
				 ->join('CatalogoProductos', 'CatalogoProductos.id_producto=Enhance.id_producto')
				 ->join('ColoresPorProducto', 'ColoresPorProducto.id_color=Enhance.id_color')
				 ->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca')
				 ->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color')
				 ->where('CatalogoProductos.estatus', 1)
				 ->where('ColoresPorProducto.estatus', 1)
				 ->where('FotografiasPorProducto.estatus', 1)
				 ->where('FotografiasPorProducto.principal', 1)
				 ->where('Enhance.id_parent_enhance', 0)
				 ->where("Enhance.estatus", 1)
				 ->group_by('Enhance.id_enhance');

		if($tipo_campana == 'fijo') {
			$this->db->where('Enhance.type', 'fijo');
		} else if($tipo_campana == 'limitado') {
			$this->db->where('Enhance.type', 'limitado')
					 ->where('Enhance.end_date >=', date("Y-m-d H:i:s"));
		}
		//echo $this->db->get_compiled_select();
		$productos_res = $this->db->get();

		if ($productos_res->num_rows() == 0) return null;

		$resultado = $productos_res->result();

		return $resultado;
	}

	public function contar_enhanced($tipo_campana = null, $filtros = array(), $id_cliente = null) {
		$this->db->select('COUNT(id_enhance) AS cantidad_enhanced');
		$this->db->from('Enhance');
        $this->db->join('CatalogoProductos', 'CatalogoProductos.id_producto = Enhance.id_producto');
		if(!$tipo_campana || $tipo_campana == 'null') {
			$this->db->group_start()
					 ->where('Enhance.type', 'fijo')
					 ->where('Enhance.id_parent_enhance', 0)
					 ->or_group_start()
						->where('Enhance.type', 'limitado')
						->where('Enhance.end_date >=', date("Y-m-d H:i:s"))
					 ->group_end()
					 ->group_end();
		} else {
			if($tipo_campana == 'fijo') {
				$this->db->where('Enhance.type', 'fijo');
			} else if($tipo_campana == 'limitado') {
				$this->db->where('Enhance.type', 'limitado')
						 ->where('Enhance.end_date >=', date("Y-m-d H:i:s"));
			}
		}

		$this->db->where("Enhance.estatus", 1)
				 ->where('Enhance.id_parent_enhance', 0);
		if(isset($filtros['idClasificacion'])) {
			if($filtros['idClasificacion'] != '*') {
				$this->db->where('Enhance.id_clasificacion', (int)$filtros['idClasificacion']);
			}
		}

        if(isset($filtros['idSubclasificacion'])) {
            if($filtros['idSubclasificacion'] != '*') {
                $this->db->where('Enhance.id_subclasificacion', (int)$filtros['idSubclasificacion']);
            }
        }

        if(isset($filtros['idSubsubclasificacion'])) {
            if($filtros['idSubsubclasificacion'] != '*') {
                $this->db->where('Enhance.id_subsubclasificacion', (int)$filtros['idSubsubclasificacion']);
            }
        }

        if(isset($filtros['genero'])) {
            if($filtros['genero'] != '*') {
                $this->db->where('CatalogoProductos.genero', (int)$filtros['genero']);
            }
        }

		if($id_cliente) {
			$this->db->where('Enhance.id_cliente', $id_cliente);
		}

        if(isset($filtros['busqueda'])) {
            $this->db->group_start();
                $this->db->or_like('Enhance.name', $filtros['busqueda']);
                $this->db->or_like('Enhance.id_enhance', $filtros['busqueda']);
                $this->db->or_like('Enhance.etiquetas', $filtros['busqueda']);
            $this->db->group_end();
 		}

		$resultado = $this->db->get()->row();

		return $resultado->cantidad_enhanced;
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

	public function obtener_tallas_por_producto_y_hex($id_producto, $hex) {
		$this->db->select('*');
		$this->db->from('ColoresPorProducto');
		$this->db->join('CatalogoSkuPorProducto', 'ColoresPorProducto.id_color = CatalogoSkuPorProducto.id_color', 'left');
		$this->db->where(array('ColoresPorProducto.id_producto' => $id_producto, 'ColoresPorProducto.codigo_color' => $hex));
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

	public function obtener_color_por_id($id_color)
	{
		$color = $this->db->get_where('ColoresPorProducto', array('id_color' => $id_color, 'estatus' => 1))->row();
		if(isset($color->codigo_color)) {
			return $color;
		} else {
			return new stdClass();
		}
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

		$this->db->select('*');
		$this->db->from('Enhance');
		$this->db->join('CatalogoProductos', 'Enhance.id_producto = CatalogoProductos.id_producto');
		$this->db->join('Marcas', 'Marcas.id_marca = CatalogoProductos.id_marca');
		$this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_color = Enhance.id_color');
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
		//$subcategoria = $this->categoria->obtener_categoria($resultado[0]->id_subcategoria);

		if($resultado[0]->descuento_especifico != 0.00) {
			$resultado[0]->precio_descuento = $resultado[0]->precio_producto*(1-($resultado[0]->descuento_especifico/100));
		}

		$resultado[0]->ubicacion_base = 'assets/images/productos/producto'.$resultado[0]->id_producto.'/';
		$resultado[0]->vinculo_producto = $categoria->nombre_categoria_slug.'/'.$resultado[0]->nombre_producto_slug.'-'.$resultado[0]->id_producto;

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

		$sql = "SELECT MIN(precio) AS precio FROM (
			SELECT CatalogoProductos.id_categoria, ColoresPorProducto.*
			FROM CatalogoProductos
			JOIN ColoresPorProducto ON ColoresPorProducto.id_producto = CatalogoProductos.id_producto
			JOIN CatalogoSkuPorProducto ON CatalogoSkuPorProducto.id_color = ColoresPorProducto.id_color
			WHERE CatalogoProductos.id_producto = ".$id_producto."
		) AS Precios";
		$minimo_res = $this->db->query($sql);
		$resultado = $minimo_res->row();

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

	public function obtener_tallas_por_categoria($id_categoria, $id_tipo)
	{
		$this->db->select('CatalogoSkuPorProducto.caracteristicas');
		$this->db->from('Categorias');
		$this->db->join('CatalogoProductos', 'Categorias.id_categoria = CatalogoProductos.id_categoria', 'left');
		$this->db->join('ColoresPorProducto', 'CatalogoProductos.id_producto = ColoresPorProducto.id_producto', 'left');
		$this->db->join('CatalogoSkuPorProducto', 'ColoresPorProducto.id_color = CatalogoSkuPorProducto.id_color', 'left');
		$this->db->where('Categorias.id_categoria',$id_categoria);
		$this->db->where('CatalogoProductos.id_tipo',$id_tipo);


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
		$this->db->select("MAX(precio) AS max_precio");
		$this->db->from("ColoresPorProducto");
		$this->db->where("id_producto", $producto_id);

		$query = $this->db->get();

		return $query->row()->max_precio;

	}

	public function get_precio_por_color($id_producto, $codigo_color)
	{
		$this->db->select('precio')
				 ->from('ColoresPorProducto')
				 ->where('id_producto', $id_producto)
				 ->where('codigo_color', '#'.$codigo_color);

		$query = $this->db->get();
		return $query->row()->precio;
	}

	public function obtener_id_color_con_id_producto_y_hex($id_producto, $codigo_color)
	{
		$this->db->select('*')
				 ->from('ColoresPorProducto')
				 ->where('id_producto', $id_producto)
				 ->where('codigo_color', '#'.$codigo_color);

		$query = $this->db->get();
		return $query->row();
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
		$this->db->where('t1.estatus', 1);
		$this->db->where('t2.estatus', 1);

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

	public function obtener_otros_estilos($id_producto, $id_color, $json = false) {

		$info_producto = $this->db->get_where('CatalogoProductos', array('id_producto' => $id_producto, 'estatus' => 1))->row();
		$id_categoria = $info_producto->id_categoria;
		$id_tipo = $info_producto->id_tipo;

		$color_base = $this->db->get_where('ColoresPorProducto', array('id_color' => $id_color, 'id_producto' => $id_producto))->row();

		$this->db->select('DISTINCT(CatalogoProductos.id_producto) AS id, CatalogoProductos.*')
			 ->from('CatalogoProductos')
			 ->join('ColoresPorProducto', 'ColoresPorProducto.id_producto = CatalogoProductos.id_producto')
			 //->where('CatalogoProductos.id_producto !=', $id_producto)
			 ->where('CatalogoProductos.id_categoria', $id_categoria)
			 ->where('CatalogoProductos.estatus', 1);

		if($color_base->codigo_color == '#FFFFFF') {
			$this->db->where('ColoresPorProducto.codigo_color', '#FFFFFF');
		} else {
			$this->db->where('ColoresPorProducto.codigo_color !=', '#FFFFFF');
		}

		if($id_categoria == 10) {
			if($id_tipo == 5 || $id_tipo == 6) {
				$this->db->group_start()
							->or_where('CatalogoProductos.id_tipo', 5)
							->or_where('CatalogoProductos.id_tipo', 6)
						->group_end();
			} else if($id_tipo == 7 || $id_tipo == 8 || $id_tipo == 9) {
				$this->db->group_start()
							->or_where('CatalogoProductos.id_tipo', 7)
							->or_where('CatalogoProductos.id_tipo', 8)
							->or_where('CatalogoProductos.id_tipo', 9)
						->group_end();
			}
		}

		$this->db->order_by('RAND()')->limit(4);

		//$otros = $this->db->order_by('RAND()')->limit(4)->get_where('CatalogoProductos', array('id_producto !=' => $id_producto, 'id_categoria' => $id_categoria, 'estatus' => 1))->result();
		$otros = $this->db->get()->result();

		foreach($otros as $indice=>$otro) {

			$diseno = $this->db->get_where('DisenoProductos', array('id_producto' => $otro->id_producto))->row();

			$otros[$indice]->diseno = $diseno;
			$otros[$indice]->diseno->color_hex = json_decode($otros[$indice]->diseno->color_hex);
			$otros[$indice]->diseno->color_title = json_decode($otros[$indice]->diseno->color_title);
			$otros[$indice]->diseno->front = json_decode($otros[$indice]->diseno->front);
			$otros[$indice]->diseno->back = json_decode($otros[$indice]->diseno->back);
			$otros[$indice]->diseno->left = json_decode($otros[$indice]->diseno->left);
			$otros[$indice]->diseno->right = json_decode($otros[$indice]->diseno->right);
			$otros[$indice]->diseno->area = json_decode($otros[$indice]->diseno->area);
			$otros[$indice]->diseno->params = json_decode($otros[$indice]->diseno->params);

			$otros[$indice]->skus = array();
			$otros[$indice]->json_skus = array();

			foreach($otros[$indice]->diseno->color_hex as $subindice=>$color) {
				$otros[$indice]->diseno->front[$subindice] = json_decode(str_replace("'",'"',$otros[$indice]->diseno->front[$subindice]));
				$otros[$indice]->diseno->back[$subindice] = json_decode(str_replace("'",'"',$otros[$indice]->diseno->back[$subindice]));
				$otros[$indice]->diseno->left[$subindice] = json_decode(str_replace("'",'"',$otros[$indice]->diseno->left[$subindice]));
				$otros[$indice]->diseno->right[$subindice] = json_decode(str_replace("'",'"',$otros[$indice]->diseno->right[$subindice]));

				$el_color = $this->db->get_where('ColoresPorProducto', array('codigo_color' => '#'.$color, 'id_producto' => $otro->id_producto))->row();

				$skus = $this->db->get_where('CatalogoSkuPorProducto', array('id_color' => $el_color->id_color, 'estatus' => 1, 'cantidad_inicial > ' => 0))->result();
				$otros[$indice]->skus[$subindice] = $skus;
				if(!$json) {
					$otros[$indice]->json_skus[$subindice] = json_encode($skus);
				}
			}

			$otros[$indice]->diseno->area->front = json_decode(str_replace("'",'"',$otros[$indice]->diseno->area->front));
			$otros[$indice]->diseno->area->back = json_decode(str_replace("'",'"',$otros[$indice]->diseno->area->back));
			$otros[$indice]->diseno->area->left = json_decode(str_replace("'",'"',$otros[$indice]->diseno->area->left));
			$otros[$indice]->diseno->area->right = json_decode(str_replace("'",'"',$otros[$indice]->diseno->area->right));

			$otros[$indice]->diseno->params->front = json_decode(str_replace("'",'"',$otros[$indice]->diseno->params->front));
			$otros[$indice]->diseno->params->back = json_decode(str_replace("'",'"',$otros[$indice]->diseno->params->back));
			$otros[$indice]->diseno->params->left = json_decode(str_replace("'",'"',$otros[$indice]->diseno->params->left));
			$otros[$indice]->diseno->params->right = json_decode(str_replace("'",'"',$otros[$indice]->diseno->params->right));
		}

		foreach($otros as $indice=>$otro) {
			if($color_base->codigo_color == '#FFFFFF') {
				foreach($otro->diseno->color_hex as $indice_color=>$color_hex) {
					if($color_hex != 'FFFFFF') {
						unset($otros[$indice]->diseno->color_hex[$indice_color]);
						unset($otros[$indice]->diseno->color_title[$indice_color]);
						unset($otros[$indice]->diseno->front[$indice_color]);
						unset($otros[$indice]->diseno->back[$indice_color]);
						unset($otros[$indice]->diseno->left[$indice_color]);
						unset($otros[$indice]->diseno->right[$indice_color]);

						unset($otros[$indice]->skus[$indice_color]);
						if($json) {
							unset($otros[$indice]->json_skus[$indice_color]);
						}
					}
				}
			} else {
				foreach($otro->diseno->color_hex as $indice_color=>$color_hex) {
					if($color_hex == 'FFFFFF') {
						unset($otros[$indice]->diseno->color_hex[$indice_color]);
						unset($otros[$indice]->diseno->color_title[$indice_color]);
						unset($otros[$indice]->diseno->front[$indice_color]);
						unset($otros[$indice]->diseno->back[$indice_color]);
						unset($otros[$indice]->diseno->left[$indice_color]);
						unset($otros[$indice]->diseno->right[$indice_color]);
						unset($otros[$indice]->skus[$indice_color]);
						if($json) {
							unset($otros[$indice]->json_skus[$indice_color]);
						}
					}
				}
			}
		}

		foreach($otros as $indice=>$otro) {
			$otros[$indice]->diseno->color_hex = array_values($otros[$indice]->diseno->color_hex);
			$otros[$indice]->diseno->color_title = array_values($otros[$indice]->diseno->color_title);
			$otros[$indice]->diseno->front = array_values($otros[$indice]->diseno->front);
			$otros[$indice]->diseno->back = array_values($otros[$indice]->diseno->back);
			$otros[$indice]->diseno->left = array_values($otros[$indice]->diseno->left);
			$otros[$indice]->diseno->right = array_values($otros[$indice]->diseno->right);
			$otros[$indice]->skus = array_values($otros[$indice]->skus);

			if(!$json) {
				$otros[$indice]->json_skus = array_values($otros[$indice]->json_skus);
			}
		}

		//print_r($otros);

		if(!$json) {
			return $otros;
		} else {
			return json_encode($otros);
		}
	}
	public function obtener_slider_creador($id_cliente){
        $this->db->select('Tiendas.slider_uno,Tiendas.slider_dos,Tiendas.slider_tres ')
            ->from('Tiendas')
            ->where('Tiendas.id_cliente', $id_cliente);

        $query = $this->db->get()->result();
        return $query;
    }
    public function obtener_wow_winner($tipo_campana = null, $start = 0, $offset = 0, $random_seed = 123, $filtros = array(), $id_campana = null, $id_cliente = null, $exclude_id = null) {
        $this->db->select('Enhance.id_enhance, Enhance.name, Enhance.description, Enhance.etiquetas, Enhance.visitas, Enhance.id_clasificacion, Enhance.type, Enhance.id_producto, Enhance.sold, Enhance.quantity, Enhance.costo, Enhance.price, Enhance.front_image, Enhance.back_image, Enhance.right_image, Enhance.left_image, Enhance.date, Enhance.end_date, Enhance.days, Enhance.id_cliente, Enhance.id_color, Enhance.estatus, Enhance.additional_info, Enhance.cron, Enhance.id_parent_enhance, Enhance.modificador_ventas, Enhance.cantidad_vendida, Enhance.cantidad_adicional, Enhance.faltante,
						   ListasProductos.*,
						   Enhance.wow_winner,
						   CatalogoProductos.id_producto as id,
						   CatalogoProductos.id_categoria,
						   CatalogoProductos.id_subcategoria,
                           CatalogoProductos.genero')
            ->from('Enhance')
            ->join('CatalogoProductos', 'CatalogoProductos.id_producto=Enhance.id_producto')
            ->join('ColoresPorProducto', 'ColoresPorProducto.id_color=Enhance.id_color')
            ->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
        if($this->session->has_userdata('login')) {
            $this->db->join('ListasProductos', '(Enhance.id_enhance=ListasProductos.id_producto AND ListasProductos.id_cliente='.$this->session->login['id_cliente'].')', "left");
        } else {
            $this->db->join('ListasProductos', '(Enhance.id_enhance=ListasProductos.id_producto AND ListasProductos.id_cliente IS NULL)', "left");
        }
        $this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color')
            ->where('CatalogoProductos.estatus', 1)
            ->where('ColoresPorProducto.estatus', 1)
            ->where('FotografiasPorProducto.estatus', 1)
            ->where('FotografiasPorProducto.principal', 1)
            ->where('Enhance.wow_winner', 1)
            ->where('Enhance.id_parent_enhance', 0);


        if(isset($filtros['busqueda'])) {
            $this->db->group_start();
            $this->db->or_like('Enhance.name', $filtros['busqueda']);
            $this->db->or_like('Enhance.id_enhance', $filtros['busqueda']);
            $this->db->or_like('Enhance.etiquetas', $filtros['busqueda']);
            $this->db->group_end();
        }

        if(isset($filtros['idClasificacion'])) {
            if($filtros['idClasificacion'] != '*') {
                $this->db->where('Enhance.id_clasificacion', (int)$filtros['idClasificacion']);
            }
        }

        if(isset($filtros['idSubclasificacion'])) {
            if($filtros['idSubclasificacion'] != '*') {
                $this->db->where('Enhance.id_subclasificacion', (int)$filtros['idSubclasificacion']);
            }
        }

        if(isset($filtros['idSubsubclasificacion'])) {
            if ($filtros['idSubsubclasificacion'] != '*') {
                $this->db->where('Enhance.id_subsubclasificacion', (int)$filtros['idSubsubclasificacion']);
            }
        }



        if($id_cliente) {
            $this->db->where('Enhance.id_cliente', $id_cliente);
        }

        if($exclude_id) {
            $this->db->where('Enhance.id_enhance !=', $exclude_id);
        }

        if(!$tipo_campana || $tipo_campana == 'null') {
            $this->db->group_start()
                ->where('Enhance.type', 'fijo')
                ->or_group_start()
                ->where('Enhance.type', 'limitado')
                ->where('Enhance.end_date >=', date("Y-m-d H:i:s"))
                ->group_end()
                ->group_end();
        } else {
            if($tipo_campana == 'fijo') {
                $this->db->where('Enhance.type', 'fijo');
            } else if($tipo_campana == 'limitado') {
                $this->db->where('Enhance.type', 'limitado')
                    ->where('Enhance.end_date >=', date("Y-m-d H:i:s"));
            }
        }

        if($start < 0 || $offset < 0) {
            if($id_campana) {
                $this->db->where('Enhance.id_enhance', $id_campana);
            }
            $this->db->limit(1);
        } else {
            if($start == 1) {
                $start = 0;
            }
            $this->db->limit($offset, $start);
        }

        // F F F

        $this->db->order_by('Enhance.id_enhance', 'DESC');
        $this->db->where("Enhance.estatus", 1);
        $this->db->group_by('Enhance.id_enhance');
        //echo $this->db->get_compiled_select();
        $productos_res = $this->db->get();

        $resultado = $productos_res->result();
        if($id_cliente) {
            $tienda = $this->tienda_m->obtener_tienda_por_id_dueno($id_cliente);
        }

        foreach($resultado as $key=>$producto) {
            $resultado[$key]->id_producto = $resultado[$key]->id;
            $resultado[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
            $categoria = $this->categoria->obtener_categoria($producto->id_categoria);

            $name_slug = strtolower(url_title(convert_accented_characters(trim($resultado[$key]->name))));

            if(!$id_cliente) {
                $url = 'compra/'.($resultado[$key]->type == 'fijo' ? 'venta-inmediata' : 'plazo-definido').'/'.$name_slug.'-'.$resultado[$key]->id_enhance;
            } else {
                $url = 'tienda/'.$tienda->nombre_tienda_slug.'/'.($resultado[$key]->type == 'fijo' ? 'venta-inmediata' : 'plazo-definido').'/'.$name_slug.'-'.$resultado[$key]->id_enhance;
            }

            $resultado[$key]->name_slug = $name_slug;
            $resultado[$key]->categoria = $categoria;
            //$resultado[$key]->design_array = json_decode($resultado[$key]->design);
            $resultado[$key]->vinculo_producto = $url;
        }



        if($id_campana) {
            return $resultado[0];
        } else {
            return $resultado;
        }
    }
    public function obtener_mas_vendidos($tipo_campana = null, $start = 0, $offset = 0, $random_seed = 123, $filtros = array(), $id_campana = null, $id_cliente = null, $exclude_id = null) {
        $this->db->select('Enhance.id_enhance, Enhance.name, Enhance.description, Enhance.etiquetas, Enhance.visitas, Enhance.id_clasificacion, Enhance.type, Enhance.id_producto, Enhance.sold, Enhance.quantity, Enhance.costo, Enhance.price, Enhance.front_image, Enhance.back_image, Enhance.right_image, Enhance.left_image, Enhance.date, Enhance.end_date, Enhance.days, Enhance.id_cliente, Enhance.id_color, Enhance.estatus, Enhance.additional_info, Enhance.cron, Enhance.id_parent_enhance, Enhance.modificador_ventas, Enhance.cantidad_vendida, Enhance.cantidad_adicional, Enhance.faltante,
						   Enhance.wow_winner,
						   ListasProductos.*,
						   CatalogoProductos.id_producto as id,
						   CatalogoProductos.id_categoria,
						   CatalogoProductos.id_subcategoria,
                           CatalogoProductos.genero')
            ->from('Enhance')
            ->join('CatalogoProductos', 'CatalogoProductos.id_producto=Enhance.id_producto')
            ->join('ColoresPorProducto', 'ColoresPorProducto.id_color=Enhance.id_color')
            ->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
        if($this->session->has_userdata('login')) {
            $this->db->join('ListasProductos', '(Enhance.id_enhance=ListasProductos.id_producto AND ListasProductos.id_cliente='.$this->session->login['id_cliente'].')', "left");
        } else {
            $this->db->join('ListasProductos', '(Enhance.id_enhance=ListasProductos.id_producto AND ListasProductos.id_cliente IS NULL)', "left");
        }
        $this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color')
            ->where('CatalogoProductos.estatus', 1)
            ->where('ColoresPorProducto.estatus', 1)
            ->where('FotografiasPorProducto.estatus', 1)
            ->where('FotografiasPorProducto.principal', 1)
            ->where('Enhance.id_parent_enhance', 0);


        if(isset($filtros['busqueda'])) {
            $this->db->group_start();
            $this->db->or_like('Enhance.name', $filtros['busqueda']);
            $this->db->or_like('Enhance.id_enhance', $filtros['busqueda']);
            $this->db->or_like('Enhance.etiquetas', $filtros['busqueda']);
            $this->db->group_end();
        }

        if(isset($filtros['idClasificacion'])) {
            if($filtros['idClasificacion'] != '*') {
                $this->db->where('Enhance.id_clasificacion', (int)$filtros['idClasificacion']);
            }
        }

        if(isset($filtros['idSubclasificacion'])) {
            if($filtros['idSubclasificacion'] != '*') {
                $this->db->where('Enhance.id_subclasificacion', (int)$filtros['idSubclasificacion']);
            }
        }

        if(isset($filtros['idSubsubclasificacion'])) {
            if ($filtros['idSubsubclasificacion'] != '*') {
                $this->db->where('Enhance.id_subsubclasificacion', (int)$filtros['idSubsubclasificacion']);
            }
        }



        if($id_cliente) {
            $this->db->where('Enhance.id_cliente', $id_cliente);
        }

        if($exclude_id) {
            $this->db->where('Enhance.id_enhance !=', $exclude_id);
        }

        if(!$tipo_campana || $tipo_campana == 'null') {
            $this->db->group_start()
                ->where('Enhance.type', 'fijo')
                ->or_group_start()
                ->where('Enhance.type', 'limitado')
                ->where('Enhance.end_date >=', date("Y-m-d H:i:s"))
                ->group_end()
                ->group_end();
        } else {
            if($tipo_campana == 'fijo') {
                $this->db->where('Enhance.type', 'fijo');
            } else if($tipo_campana == 'limitado') {
                $this->db->where('Enhance.type', 'limitado')
                    ->where('Enhance.end_date >=', date("Y-m-d H:i:s"));
            }
        }

        if($start < 0 || $offset < 0) {
            if($id_campana) {
                $this->db->where('Enhance.id_enhance', $id_campana);
            }
            $this->db->limit(1);
        } else {
            if($start == 1) {
                $start = 0;
            }
            $this->db->limit($offset, $start);
        }

        $this->db->order_by('Enhance.sold', 'DESC');
        $this->db->where("Enhance.estatus", 1);
        $this->db->group_by('Enhance.id_enhance');
        //echo $this->db->get_compiled_select();
        $productos_res = $this->db->get();

        $resultado = $productos_res->result();
        if($id_cliente) {
            $tienda = $this->tienda_m->obtener_tienda_por_id_dueno($id_cliente);
        }

        foreach($resultado as $key=>$producto) {
            $resultado[$key]->id_producto = $resultado[$key]->id;
            $resultado[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
            $categoria = $this->categoria->obtener_categoria($producto->id_categoria);

            $name_slug = strtolower(url_title(convert_accented_characters(trim($resultado[$key]->name))));

            if(!$id_cliente) {
                $url = 'compra/'.($resultado[$key]->type == 'fijo' ? 'venta-inmediata' : 'plazo-definido').'/'.$name_slug.'-'.$resultado[$key]->id_enhance;
            } else {
                $url = 'tienda/'.$tienda->nombre_tienda_slug.'/'.($resultado[$key]->type == 'fijo' ? 'venta-inmediata' : 'plazo-definido').'/'.$name_slug.'-'.$resultado[$key]->id_enhance;
            }

            $resultado[$key]->name_slug = $name_slug;
            $resultado[$key]->categoria = $categoria;
            //$resultado[$key]->design_array = json_decode($resultado[$key]->design);
            $resultado[$key]->vinculo_producto = $url;
        }



        if($id_campana) {
            return $resultado[0];
        } else {
            return $resultado;
        }
    }
    public function contar_wow_winner($tipo_campana = null, $filtros = array(), $id_cliente = null) {
        $this->db->select('COUNT(id_enhance) AS cantidad_enhanced');
        $this->db->from('Enhance');
        $this->db->join('CatalogoProductos', 'CatalogoProductos.id_producto = Enhance.id_producto');
        $this->db->where('Enhance.wow_winner', 1);
        if(!$tipo_campana || $tipo_campana == 'null') {
            $this->db->group_start()
                ->where('Enhance.type', 'fijo')
                ->where('Enhance.id_parent_enhance', 0)
                ->or_group_start()
                ->where('Enhance.type', 'limitado')
                ->where('Enhance.end_date >=', date("Y-m-d H:i:s"))
                ->group_end()
                ->group_end();
        } else {
            if($tipo_campana == 'fijo') {
                $this->db->where('Enhance.type', 'fijo');
            } else if($tipo_campana == 'limitado') {
                $this->db->where('Enhance.type', 'limitado')
                    ->where('Enhance.end_date >=', date("Y-m-d H:i:s"));
            }
        }

        $this->db->where("Enhance.estatus", 1)
            ->where('Enhance.id_parent_enhance', 0);
        if(isset($filtros['idClasificacion'])) {
            if($filtros['idClasificacion'] != '*') {
                $this->db->where('Enhance.id_clasificacion', (int)$filtros['idClasificacion']);
            }
        }

        if(isset($filtros['idSubclasificacion'])) {
            if($filtros['idSubclasificacion'] != '*') {
                $this->db->where('Enhance.id_subclasificacion', (int)$filtros['idSubclasificacion']);
            }
        }

        if(isset($filtros['idSubsubclasificacion'])) {
            if($filtros['idSubsubclasificacion'] != '*') {
                $this->db->where('Enhance.id_subsubclasificacion', (int)$filtros['idSubsubclasificacion']);
            }
        }

        if(isset($filtros['genero'])) {
            if($filtros['genero'] != '*') {
                $this->db->where('CatalogoProductos.genero', (int)$filtros['genero']);
            }
        }

        if($id_cliente) {
            $this->db->where('Enhance.id_cliente', $id_cliente);
        }

        if(isset($filtros['busqueda'])) {
            $this->db->group_start();
            $this->db->or_like('Enhance.name', $filtros['busqueda']);
            $this->db->or_like('Enhance.id_enhance', $filtros['busqueda']);
            $this->db->or_like('Enhance.etiquetas', $filtros['busqueda']);
            $this->db->group_end();
        }

        $resultado = $this->db->get()->row();

        return $resultado->cantidad_enhanced;
    }
    public function obtener_creador($id_campana){
        $this->db->select('DISTINCT Enhance.id_cliente')
            ->from('Enhance')
            ->where('Enhance.id_enhance',$id_campana);
        $creador = $this->db->get()->result();
        return $creador;
    }
    public function obtener_relacionados($id_cliente){
        $this->db->select('Enhance.id_enhance, Enhance.name, Enhance.description, Enhance.etiquetas, Enhance.visitas, Enhance.id_clasificacion, Enhance.type, Enhance.id_producto, Enhance.sold, Enhance.quantity, Enhance.costo, Enhance.price, Enhance.front_image, Enhance.back_image, Enhance.right_image, Enhance.left_image, Enhance.date, Enhance.end_date, Enhance.days, Enhance.id_cliente, Enhance.id_color, Enhance.estatus, Enhance.additional_info, Enhance.cron, Enhance.id_parent_enhance, Enhance.modificador_ventas, Enhance.cantidad_vendida, Enhance.cantidad_adicional, Enhance.faltante,
						   Enhance.wow_winner,CatalogoProductos.id_producto,CatalogoProductos.id_categoria,Tiendas.nombre_tienda_slug')
            ->from('Enhance')
            ->join('CatalogoProductos', 'CatalogoProductos.id_producto = Enhance.id_producto')
            ->join('Tiendas', 'Tiendas.id_cliente = Enhance.id_cliente')
            ->where('Enhance.estatus = 1')
            ->where('Enhance.id_parent_enhance', 0)
            ->where('Enhance.id_cliente',$id_cliente)
            ->order_by('rand()')
            ->limit(10);
        $resultado = $this->db->get()->result();

        foreach($resultado as $key=>$producto) {
            $resultado[$key]->id_producto = $resultado[$key]->id;

            $categoria = $this->categoria->obtener_categoria($producto->id_categoria);

            $name_slug = strtolower(url_title(convert_accented_characters(trim($resultado[$key]->name))));

            /*$url = 'compra/'.($resultado[$key]->type == 'fijo' ? 'venta-inmediata' : 'plazo-definido').'/'.$name_slug.'-'.$resultado[$key]->id_enhance;*/
            $url = 'tienda/'.$resultado[$key]->nombre_tienda_slug.'/'.($resultado[$key]->type == 'fijo' ? 'venta-inmediata' : 'plazo-definido').'/'.$name_slug.'-'.$resultado[$key]->id_enhance;
            $resultado[$key]->name_slug = $name_slug;
            $resultado[$key]->categoria = $categoria;
            $resultado[$key]->vinculo_producto = $url;
        }

        $relacionados = $resultado;
        return $relacionados;
    }

}
