<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enhance_modelo extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get($id_cliente) {
		$this->db->select('*');
		$this->db->from('Enhance');
		$this->db->where('id_cliente', $id_cliente);
		$this->db->where('Enhance.id_parent_enhance', 0);

		$enhance_res = $this->db->get();
		$enhance = $enhance_res->result();

		return $enhance;
	}

	public function obtener_enhance_admin($tipo_campana, $id_enhance = null, $hijo = false) {
        $this->db->select('*');
		$this->db->from('Enhance');
		$this->db->join('Clientes', 'Enhance.id_cliente = Clientes.id_cliente', 'left');
		$this->db->group_start();
			$this->db->or_where('Enhance.estatus !=', 33);
			$this->db->or_where('Enhance.estatus IS NULL');
		$this->db->group_end();
		$this->db->where('Enhance.type', $tipo_campana);
		if(!$hijo) {
			$this->db->where('Enhance.id_parent_enhance', 0);
		}
		if($id_enhance) {
			$this->db->where('Enhance.id_enhance', $id_enhance);
		}
		$this->db->order_by('Enhance.id_enhance', 'DESC');

		$enhance_res = $this->db->get();
		return $enhance_res->result();
	}

	public function obtener_enhances_adicionales_admin($tipo_campana, $id_enhance) {
		$this->db->from('Enhance');
		$this->db->join('Clientes', 'Enhance.id_cliente = Clientes.id_cliente', 'left');
		$this->db->group_start();
			$this->db->or_where('Enhance.estatus !=', 33);
			$this->db->or_where('Enhance.estatus IS NULL');
		$this->db->group_end();
		$this->db->where('Enhance.type', $tipo_campana);
		$this->db->where('Enhance.id_parent_enhance', $id_enhance);
		$this->db->order_by('Enhance.id_enhance', 'DESC');

		$enhances = $this->db->get()->result();

		if(sizeof($enhances)) {
			return $enhances;
		} else {
			return array();
		}
	}

	public function obtener_link_ehnance($id_enhance)
	{
		$campana_res = $this->db->get_where('Enhance', array('id_enhance' => $id_enhance));
		$campana = $campana_res->result();

		if(sizeof($campana) > 0) {
			if($campana[0]->type == 'fijo') {
				$slug = 'venta-inmediata';
			} else if($campana[0]->type == 'limitado') {
				$slug = 'plazo-definido';
			}

			$name_slug = strtolower(url_title(convert_accented_characters(trim($campana[0]->name))));

			if($campana[0]->id_parent_enhance == 0) {
				$url = site_url('compra/'.$slug.'/'.$name_slug.'-'.$campana[0]->id_enhance);
			} else {
				$url = site_url('compra/'.$slug.'/'.$name_slug.'-'.$campana[0]->id_parent_enhance.'#color_'.$campana[0]->id_color);
			}
			return $url;
		} else {
			return base_url();
		}
	}

	public function obtener_campanas_finalizadas()
	{
		$this->db->select('*')
				 ->from('Enhance')
				 ->join('Clientes', 'Clientes.id_cliente = Enhance.id_cliente', 'left')
				 ->where('Enhance.estatus', 1)
				 ->where('Enhance.type', 'limitado')
				 ->where('Enhance.end_date <', date("Y-m-d H:i:s"))
				 ->where('Enhance.cron', 0)
				 ->where('Enhance.id_parent_enhance', 0)
				 ->order_by('Enhance.id_enhance', 'ASC');

		$enhance_res = $this->db->get();
		return $enhance_res->result();
	}

	public function obtener_mis_campanas($id_cliente, $type)
	{
		$this->db->from('Enhance');
		$this->db->group_start();
			$this->db->or_where('Enhance.estatus !=', 33);
			$this->db->or_where('Enhance.estatus IS NULL');
		$this->db->group_end();
		$this->db->where('Enhance.id_cliente', $id_cliente);
		$this->db->where('Enhance.id_parent_enhance', 0);
		$this->db->where('Enhance.type', $type);
		$this->db->order_by('id_enhance', 'DESC');
		//$this->db->order_by('estatus', 'DESC');
		//$this->db->order_by('end_date', 'ASC');

		$campanas_res = $this->db->get();
		return $campanas_res->result();
	}

	public function obtener_campanas_usuario($id_cliente, $tipo_campana)
	{
		$this->db->from('Enhance');
		$this->db->group_start();
			$this->db->or_where('Enhance.estatus !=', 33);
			$this->db->or_where('Enhance.estatus IS NULL');
		$this->db->group_end();
		$this->db->where('Enhance.id_cliente', $id_cliente);
		$this->db->where('Enhance.id_parent_enhance', 0);
		$this->db->where('Enhance.type', $tipo_campana);
		$this->db->order_by('id_enhance', 'DESC');

		$campanas_res = $this->db->get();
		return $campanas_res->result();
	}

    public function obtener_campanas_printome($numero)
    {
        $this->db->from('Enhance');
        $this->db->where('Enhance.estatus', 1);
		$this->db->where('Enhance.id_cliente', 341);
		$this->db->where('Enhance.id_parent_enhance', 0);
		$this->db->order_by('id_enhance', 'DESC');
		$this->db->group_by('Enhance.name');
        $this->db->limit($numero);

		$campanas_res = $this->db->get();
		return $campanas_res->result();
    }
	
	public function obtener_publicaciones_blog_printome($numero) 
	{
		$dblog = $this->load->database('blog', TRUE);

		
		$dblog->select('ID, post_date, post_title, post_name,post_content')
			  ->from('wp_posts')
			  ->where('post_type', 'post')
			  ->where('post_status', 'publish')
			  ->order_by('ID', 'DESC')
			  ->limit($numero);
			  
		$posts = $dblog->get()->result();
		
		if(sizeof($posts)) {
			foreach($posts as $indice_post => $post) {
				$dblog->select('*')
					  ->from('wp_postmeta')
					  ->join('wp_posts', 'wp_posts.ID = wp_postmeta.meta_value')
					  ->where('wp_postmeta.post_id', $post->ID)
					  ->where('wp_postmeta.meta_key', '_thumbnail_id')
					  ->where('wp_posts.post_type', 'attachment');
					  
				$posts[$indice_post]->featured = $dblog->get()->row();
			}
			
			return $posts;
		} else {
			return array();
		}
	}

	public function obtener_campanas_mas_vendidas($tipo_campana)
	{

		if($tipo_campana == 'fijo') {
			$slug = 'venta-inmediata';
		} else if($tipo_campana == 'limitado') {
			$slug = 'plazo-definido';
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
		$this->db->where("Enhance.estatus", 1);
		$this->db->where("Enhance.type", $tipo_campana);
		$this->db->where('Enhance.id_parent_enhance', 0);
		$this->db->order_by('Enhance.sold', 'DESC');
		$this->db->group_by('Enhance.id_enhance');
		$this->db->limit(4);

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

			$url = 'compra/'.$slug.'/'.$name_slug.'-'.$resultado[$key]->id_enhance;

			$resultado[$key]->name_slug = $name_slug;
			$resultado[$key]->categoria = $categoria;
			$resultado[$key]->design_array = json_decode($resultado[$key]->design);
			$resultado[$key]->vinculo_producto = $url;

		}

		return $resultado;
	}

	public function obtener_campanas_acabantes()
	{
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
		$this->db->where("Enhance.estatus", 1);
		$this->db->where('Enhance.id_parent_enhance', 0);
		$this->db->order_by('Enhance.end_date', 'ASC');
		$this->db->group_by('Enhance.id_enhance');
		$this->db->limit(4);

		$productos_res = $this->db->get();

		if ($productos_res->num_rows() == 0) return null;

		$resultado = $productos_res->result();

		foreach($resultado as $key=>$producto) {
			if($producto->type == 'fijo') {
				$slug = 'venta-inmediata';
			} else {
				$slug = 'plazo-definido';
			}

			$resultado[$key]->id_producto = $resultado[$key]->id;
			/* if($resultado[$key]->descuento_especifico != 0.00) {
				$resultado[$key]->precio_descuento = $producto->precio_producto*(1-($producto->descuento_especifico/100));
			} */
			$resultado[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
			$categoria = $this->categoria->obtener_categoria($producto->id_categoria);
			//$subcategoria = $this->categoria->obtener_categoria($producto->id_subcategoria);

			$name_slug = strtolower(url_title(convert_accented_characters(trim($resultado[$key]->name))));

			$url = 'compra/'.$slug.'/'.$name_slug.'-'.$resultado[$key]->id_enhance;

			$resultado[$key]->name_slug = $name_slug;
			$resultado[$key]->categoria = $categoria;
			$resultado[$key]->design_array = json_decode($resultado[$key]->design);
			$resultado[$key]->vinculo_producto = $url;

		}

		return $resultado;
	}

	public function obtener_tallas_vendidas_por_campana($tipo_campana, $id_enhance, $hijo = false)
	{
		$enhance = $this->obtener_enhance_admin($tipo_campana, $id_enhance, $hijo);
		if(isset($enhance[0])) {
			$id_color = $enhance[0]->id_color;
		} else {
			$id_color = 0;
		}

		$this->db->order_by('id_sku', 'ASC');
		$skus_producto = $this->db->get_where('CatalogoSkuPorProducto', array('id_color' => $id_color))->result();

		foreach($skus_producto as $indice=>$sku_producto) {
			$sql = "SELECT SUM(cantidad_producto) AS cantidad FROM ProductosPorPedido JOIN Pedidos ON ProductosPorPedido.id_pedido=Pedidos.id_pedido WHERE ProductosPorPedido.id_enhance=".$id_enhance." AND ProductosPorPedido.id_sku=".$sku_producto->id_sku." AND Pedidos.estatus_pago='paid' AND Pedidos.estatus_pedido != 'Cancelado'";

			$cantidad_res = $this->db->query($sql)->result();

			if($cantidad_res[0]->cantidad) {
				$skus_producto[$indice]->total_vendido = $cantidad_res[0]->cantidad;
			} else {
				$skus_producto[$indice]->total_vendido = 0;
			}
		}

		if(sizeof($skus_producto)) {
			return $skus_producto;
		} else {
			return array();
		}
	}

	public function obtener_total_vendidos_por_campana($id_enhance)
	{
		$sql = "SELECT SUM(cantidad_producto) AS cantidad FROM ProductosPorPedido JOIN Pedidos ON ProductosPorPedido.id_pedido=Pedidos.id_pedido WHERE ProductosPorPedido.id_enhance=".$id_enhance." AND Pedidos.estatus_pago='paid' AND Pedidos.estatus_pedido != 'Cancelado'";

		$cantidad_res = $this->db->query($sql)->result();

		$cantidad_final = $cantidad_res[0]->cantidad;

		$otros_colores = $this->obtener_colores_disponibles_por_enhance($id_enhance);
		foreach($otros_colores as $indice_otro => $otro_color) {
			$sql = "SELECT SUM(cantidad_producto) AS cantidad FROM ProductosPorPedido JOIN Pedidos ON ProductosPorPedido.id_pedido=Pedidos.id_pedido JOIN Enhance ON Enhance.id_enhance=ProductosPorPedido.id_enhance WHERE ProductosPorPedido.id_enhance=".$otro_color->id_enhance." AND Enhance.id_parent_enhance=".$id_enhance." AND Pedidos.estatus_pago='paid' AND Pedidos.estatus_pedido != 'Cancelado'";

			$cantidad_res = $this->db->query($sql)->result();

			$cantidad_final += $cantidad_res[0]->cantidad;
		}

        $modificador_info = $this->db->select('modificador_ventas')->from('Enhance')->where('id_enhance', $id_enhance)->get()->row();

        if(isset($modificador_info->modificador_ventas)) {
            $cantidad_final += $modificador_info->modificador_ventas;
        }

		if($cantidad_final) {

			return $cantidad_final;
		} else {
			return 0;
		}
	}

	public function obtener_total_vendidos_por_campana_por_pedido($id_enhance, $id_pedido)
	{
		$sql = "SELECT SUM(cantidad_producto) AS cantidad FROM ProductosPorPedido JOIN Pedidos ON ProductosPorPedido.id_pedido=Pedidos.id_pedido WHERE ProductosPorPedido.id_enhance=".$id_enhance." AND Pedidos.id_pedido=".$id_pedido." AND Pedidos.estatus_pago='paid' AND Pedidos.estatus_pedido != 'Cancelado'";

		$cantidad_res = $this->db->query($sql)->result();

		if($cantidad_res[0]->cantidad) {
			return $cantidad_res[0]->cantidad;
		} else {
			return 0;
		}
	}

	public function obtener_pedidos_por_campana($id_enhance)
	{
		$sql = "SELECT DISTINCT(ProductosPorPedido.id_pedido) AS pedido,
						Pedidos.*,
						Clientes.*,
                        Enhance.id_parent_enhance,
						PasosPedido.*
				FROM ProductosPorPedido
				JOIN Pedidos ON Pedidos.id_pedido=ProductosPorPedido.id_pedido
				JOIN Clientes ON Pedidos.id_cliente=Clientes.id_cliente
                JOIN Enhance ON Enhance.id_enhance=ProductosPorPedido.id_enhance
				JOIN PasosPedido ON PasosPedido.id_paso=Pedidos.id_paso_pedido
				WHERE (Enhance.id_enhance=".$id_enhance." OR Enhance.id_parent_enhance=".$id_enhance.")
				AND Pedidos.estatus_pago='paid' AND Pedidos.id_paso_pedido < 8
				GROUP BY pedido
				ORDER BY id_pedido ASC";
		$pedidos_campana_res = $this->db->query($sql);

		$pedidos_campana = $pedidos_campana_res->result();

		foreach($pedidos_campana as $indice=>$pedido) {
			$contar_productos_sql = "SELECT SUM(cantidad_producto) AS numero_productos FROM ProductosPorPedido WHERE ProductosPorPedido.id_pedido=".$pedido->id_pedido;
			$contar_productos_res = $this->db->query($contar_productos_sql);
			$contar_productos = $contar_productos_res->result();

			$pedidos_campana[$indice]->numero_productos = $contar_productos[0]->numero_productos;

            $pedidos_campana[$indice]->productos = $this->pedidos_modelo->obtener_productos_por_pedido($pedido->id_pedido);
		}

		if(sizeof($pedidos_campana)) {
			return $pedidos_campana;
		} else {
			return array();
		}
	}

	public function obtener_pedidos_por_campana_por_rango($id_enhance, $rango_minimo, $rango_maximo)
	{
		$sql = "SELECT DISTINCT(Ps.id_pedido) AS id_p, Pedidos.*, Clientes.*
				FROM (SELECT ProductosPorPedido.*, Enhance.id_parent_enhance FROM ProductosPorPedido JOIN Enhance ON Enhance.id_enhance=ProductosPorPedido.id_enhance WHERE (ProductosPorPedido.id_enhance=".$id_enhance." OR Enhance.id_parent_enhance = ".$id_enhance.")) AS Ps
				JOIN Pedidos ON Pedidos.id_pedido = Ps.id_pedido
				JOIN Clientes ON Pedidos.id_cliente=Clientes.id_cliente
				WHERE Pedidos.fecha_pago BETWEEN '".$rango_minimo."' AND '".$rango_maximo."'
				AND Pedidos.estatus_pago='paid' AND Pedidos.estatus_pedido != 'Cancelado' AND Pedidos.estatus_pedido != 'Cancelado por fraude'" ;

		$pedidos_campana_res = $this->db->query($sql);

		$pedidos_campana = $pedidos_campana_res->result();

		foreach($pedidos_campana as $indice=>$pedido) {
			$contar_productos_sql = "SELECT SUM(cantidad_producto) AS numero_productos FROM ProductosPorPedido WHERE ProductosPorPedido.id_pedido=".$pedido->id_pedido;
			$contar_productos_res = $this->db->query($contar_productos_sql);
			$contar_productos = $contar_productos_res->result();

			$pedidos_campana[$indice]->numero_productos = $contar_productos[0]->numero_productos;
		}

		if(sizeof($pedidos_campana)) {
			return $pedidos_campana;
		} else {
			return array();
		}
	}

	public function obtener_skus_enhance($id_enhance, $id_pedido)
	{
		$this->db->select('*')
				 ->from('ProductosPorPedido')
				 ->join('CatalogoSkuPorProducto', 'CatalogoSkuPorProducto.id_sku = ProductosPorPedido.id_sku')
				 ->join('ColoresPorProducto', 'ColoresPorProducto.id_color = CatalogoSkuPorProducto.id_color')
				 ->where('ProductosPorPedido.id_pedido', $id_pedido)
				 ->where('ProductosPorPedido.id_enhance', $id_enhance);

		$productos = $this->db->get()->result();

		if(sizeof($productos)) {
			return $productos;
		} else {
			return array();
		}
	}

	public function obtener_enhance($id_enhance)
	{
		return $this->db->get_where('Enhance', array('id_enhance' => $id_enhance))->row();
	}

	public function obtener_id_cliente($id_campana)
	{
		$this->db->select('id_cliente')->from('Enhance')->where('id_enhance', $id_campana);
		$res = $this->db->get()->row();

		return $res->id_cliente;
	}

	// Funcion para obtener las campanas limitadas para el admin de acuerdo al estatus
	public function obtener_campanas_limitadas_por_estatus($estatus, $limit, $offset, $orden, $search = null)
	{
		$this->db->from('Enhance')
				 ->join('Clientes', 'Enhance.id_cliente = Clientes.id_cliente', 'left');
		if($estatus == 'activos') {
			$this->db->where('Enhance.end_date >=', date('Y-m-d H:i:s'))
					 ->where('Enhance.estatus', 1);
		} else if($estatus == 'aprobar') {
			$this->db->where('Enhance.estatus IS NULL');
		} else if($estatus == 'rechazados') {
			$this->db->where('Enhance.estatus', 2);
		} else if($estatus == 'ceros') {
			$this->db->where('Enhance.estatus', 1)
					 ->where('Enhance.cron', 1)
					 ->where('Enhance.end_date <', date("Y-m-d H:i:s"));
		} else if($estatus == 'pagar') {
			$this->db->join('CortesPorCampana', 'CortesPorCampana.id_enhance = Enhance.id_enhance', 'left')
					 ->where('CortesPorCampana.monto_corte >', 0.00)
					 ->where('CortesPorCampana.fecha_pago IS NULL');
		} else if($estatus == 'pagados') {
			$this->db->join('CortesPorCampana', 'CortesPorCampana.id_enhance = Enhance.id_enhance', 'left')
					 ->where('CortesPorCampana.monto_corte >', 0.00)
					 ->where('CortesPorCampana.fecha_pago IS NOT NULL');
		} else if($estatus == 'negativos') {
			$this->db->join('CortesPorCampana', 'CortesPorCampana.id_enhance = Enhance.id_enhance', 'left')
					 ->where('CortesPorCampana.monto_corte <', 0.00)->where('Enhance.estatus',1);
		}

		$this->db->where('Enhance.type', 'limitado')->where('Enhance.id_parent_enhance', 0);
        //->order_by('Enhance.id_enhance', 'DESC');

        $columnas_orden = array(
           0 => 'Enhance.id_enhance',
           1 => 'Enhance.id_enhance',
           2 => 'Enhance.price',
           4 => 'Enhance.estatus'
        );

        foreach($orden as $indice_orden => $ord) {
           $this->db->order_by($columnas_orden[$ord['column']], $ord['dir']);
        }

        if($search) {
           $criterios_search = array(
               'Enhance.name',
               'Enhance.description',
               'Enhance.price'
           );
           $this->db->group_start();
           foreach($criterios_search as $criterio) {
               $this->db->or_like($criterio, $search['value']);
           }
           $this->db->group_end();
        }

		// if($estatus == 'ceros') {
		// 	foreach($enhances as $indice=>$enhance) {
		// 		$vendido = $this->obtener_total_vendidos_por_campana($enhance->id_enhance);
		// 		if($vendido > 0) {
		// 			unset($enhances[$indice]);
		// 		}
		// 	}
		// }

        //echo $this->db->get_compiled_select();

		$enhances = $this->db->get()->result();

		return $enhances;
	}


    public function contar_campanas_limitadas_por_estatus($estatus, $search = null)
    {
        $this->db->select('COUNT(Enhance.id_enhance) AS cantidad')
		         ->from('Enhance')
				 ->join('Clientes', 'Enhance.id_cliente = Clientes.id_cliente', 'left');

        if($estatus == 'activos') {
 			$this->db->where('Enhance.end_date >=', date('Y-m-d H:i:s'))
 					 ->where('Enhance.estatus', 1);
 		} else if($estatus == 'aprobar') {
 			$this->db->where('Enhance.estatus IS NULL');
 		} else if($estatus == 'rechazados') {
 			$this->db->where('Enhance.estatus', 2);
 		} else if($estatus == 'ceros') {
 			$this->db->where('Enhance.estatus', 1)
 					 ->where('Enhance.cron', 1)
 					 ->where('Enhance.end_date <', date("Y-m-d H:i:s"));
 		} else if($estatus == 'pagar') {
 			$this->db->join('CortesPorCampana', 'CortesPorCampana.id_enhance = Enhance.id_enhance', 'left')
 					 ->where('CortesPorCampana.monto_corte >', 0.00)
 					 ->where('CortesPorCampana.fecha_pago IS NULL');
 		} else if($estatus == 'pagados') {
 			$this->db->join('CortesPorCampana', 'CortesPorCampana.id_enhance = Enhance.id_enhance', 'left')
 					 ->where('CortesPorCampana.monto_corte >', 0.00)
 					 ->where('CortesPorCampana.fecha_pago IS NOT NULL');
 		} else if($estatus == 'negativos') {
 			$this->db->join('CortesPorCampana', 'CortesPorCampana.id_enhance = Enhance.id_enhance', 'left')
 					 ->where('CortesPorCampana.monto_corte <', 0.00)->where('Enhance.estatus', 1);
 		}

		$this->db->where('Enhance.type', 'limitado')->where('Enhance.id_parent_enhance', 0);

        if($search) {
            $criterios_search = array(
                'Enhance.name',
                'Enhance.description',
                'Enhance.price'
            );
            $this->db->group_start();
            foreach($criterios_search as $criterio) {
                $this->db->or_like($criterio, $search['value']);
            }
            $this->db->group_end();
        }

        $cantidad = $this->db->get()->row();

        if(isset($cantidad->cantidad)) {
            return $cantidad->cantidad;
        } else {
            return 0;
        }
    }

	// Funcion para obtener todos los colores disponibles por campana
	public function obtener_colores_disponibles_por_enhance($id_campana)
	{
		$this->db->select('Enhance.id_enhance, Enhance.id_color, Enhance.front_image, Enhance.back_image, Enhance.left_image, Enhance.right_image, ColoresPorProducto.*')
				 ->from('Enhance')
				 ->join('ColoresPorProducto', 'ColoresPorProducto.id_color = Enhance.id_color')
				 ->or_group_start()
					->or_where('Enhance.id_enhance', $id_campana)
				 	->or_where('Enhance.id_parent_enhance', $id_campana)
				 ->group_end()
				 ->where('Enhance.estatus', 1);

		$colores = $this->db->get()->result();

		if(sizeof($colores)) {
			return $colores;
		} else {
			return array();
		}
	}

	// Funcion obtener todos los id_enhance aplicables para una campanas
	public function obtener_ids_enhance($id_parent_campana)
	{
		$this->db->select('Enhance.id_enhance')
				 ->from('Enhance')
				 ->or_group_start()
				 	->or_where('Enhance.id_enhance', $id_parent_campana)
					->or_where('Enhance.id_parent_enhance', $id_campana)
				 ->group_end()
				 ->where('Enhance.estatus', 1);

		$id_enhances = $this->db->get()->result();

		if(sizeof($id_enhances)) {
			return $id_enhances;
		} else {
			return array();
		}
	}


	// Funcion para obtener las campanas fijas para el admin de acuerdo al estatus
	public function obtener_campanas_fijas_por_estatus($estatus, $limit, $offset, $orden, $search = null)
	{
        $this->db->select('*')
		         ->from('Enhance')
				 ->join('Clientes', 'Enhance.id_cliente = Clientes.id_cliente', 'left');

		if($estatus == 'activos') {
			$this->db->where('Enhance.estatus', 1);
		} else if($estatus == 'aprobar') {
			$this->db->where('Enhance.estatus IS NULL');
		} else if($estatus == 'rechazados') {
			$this->db->where('Enhance.estatus', 2);
		} else if($estatus == 'pagar') {
			$this->db->join('CortesPorCampana', 'CortesPorCampana.id_enhance = Enhance.id_enhance', 'left')
					 ->where('CortesPorCampana.monto_corte >', 0.00)
					 ->where('CortesPorCampana.fecha_pago IS NULL');
		}

        $this->db->limit($limit, $offset);

		$this->db->where('Enhance.type', 'fijo')->where('Enhance.id_parent_enhance', 0);
				 //->order_by('Enhance.id_enhance', 'DESC');

        $columnas_orden = array(
            0 => 'Enhance.id_enhance',
            1 => 'Enhance.id_enhance',
            2 => 'Enhance.price',
            3 => 'Enhance.sold',
            4 => 'Enhance.estatus'
        );

        foreach($orden as $indice_orden => $ord) {
            $this->db->order_by($columnas_orden[$ord['column']], $ord['dir']);
        }

        if($search) {
            $criterios_search = array(
                'Enhance.name',
                'Enhance.description',
                'Enhance.price'
            );
            $this->db->group_start();
            foreach($criterios_search as $criterio) {
                $this->db->or_like($criterio, $search['value']);
            }
            $this->db->group_end();
        }

        //echo $this->db->get_compiled_select();

		$enhances = $this->db->get()->result();

		return $enhances;
	}

    public function contar_campanas_fijas_por_estatus($estatus, $search = null)
    {
        $this->db->select('COUNT(Enhance.id_enhance) AS cantidad')
		         ->from('Enhance')
				 ->join('Clientes', 'Enhance.id_cliente = Clientes.id_cliente', 'left');

		if($estatus == 'activos') {
			$this->db->where('Enhance.estatus', 1);
		} else if($estatus == 'aprobar') {
			$this->db->where('Enhance.estatus IS NULL');
		} else if($estatus == 'rechazados') {
			$this->db->where('Enhance.estatus', 2);
		} else if($estatus == 'pagar') {
			$this->db->join('CortesPorCampana', 'CortesPorCampana.id_enhance = Enhance.id_enhance', 'left')
					 ->where('CortesPorCampana.monto_corte >', 0.00)
					 ->where('CortesPorCampana.fecha_pago IS NULL');
		}

		$this->db->where('Enhance.type', 'fijo')->where('Enhance.id_parent_enhance', 0);

        if($search) {
            if($search) {
                $criterios_search = array(
                    'Enhance.name',
                    'Enhance.description',
                    'Enhance.price'
                );
                $this->db->group_start();
                foreach($criterios_search as $criterio) {
                    $this->db->or_like($criterio, $search['value']);
                }
                $this->db->group_end();
            }
        }

        $cantidad = $this->db->get()->row();

        if(isset($cantidad->cantidad)) {
            return $cantidad->cantidad;
        } else {
            return 0;
        }
    }

	public function obtener_corte($id_enhance)
	{
		$corte = $this->db->get_where('CortesPorCampana', array('id_enhance' => $id_enhance))->row();

		if(isset($corte->id_corte)) {
			return $corte;
		} else {
			return false;
		}
	}

	public function obtener_cortes($id_enhance, $id_corte = null)
	{
		$this->db->order_by('id_corte', 'DESC');
		if(!$id_corte) {
			$cortes = $this->db->get_where('CortesPorCampana', array('id_enhance' => $id_enhance))->result();
			if(sizeof($cortes) > 0) {
				return $cortes;
			} else {
				return array();
			}
		} else {
			$corte = $this->db->get_where('CortesPorCampana', array('id_enhance' => $id_enhance, 'id_corte' => $id_corte))->row();

			if(isset($corte->id_corte)) {
				return $corte;
			} else {
				return new stdClass();
			}
		}
	}

    public function obtener_mis_campanas_datatable($id_cliente, $limit, $offset, $orden, $search, $type)
    {
        $this->db->select('*');
        $this->db->from('Enhance');
        $this->db->group_start();
        $this->db->or_where('Enhance.estatus !=', 33);
        $this->db->or_where('Enhance.estatus IS NULL');
        $this->db->group_end();
        $this->db->where('Enhance.id_cliente', $id_cliente);
        $this->db->where('Enhance.id_parent_enhance', 0);
        $this->db->where('Enhance.type', $type);
        $this->db->limit($limit, $offset);

        if($type == 'fijo') {
            $columnas_orden = array(
                2 => 'name',
                3 => 'price',
                4 => '(price - costo / 1.16) * 0.75 * 1',
                5 => 'sold',
                6 => '(price - costo / 1.16) * 0.75 * sold',
                7 => 'estatus'
            );
        }elseif($type == 'limitado'){
            $columnas_orden = array(
                2 => 'name',
                3 => 'price',
                4 => '(price - costo / 1.16) * 0.75 * 1',
                5 => 'sold',
                6 => '(price - costo / 1.16) * 0.75 * sold',
                7 => 'estatus'
            );
        }

        if($orden) {
            foreach($orden as $indice_orden => $ord) {
                $this->db->order_by($columnas_orden[$ord['column']], $ord['dir']);
            }
        }

        if($search) {
            $criterios_search = array(
                'name',
                'description',
                'etiquetas'
            );
            $this->db->group_start();
            if(is_array($search)) {
                foreach($criterios_search as $criterio) {
                    $this->db->or_like($criterio, $search['value']);
                }
            } else {
                foreach($criterios_search as $criterio) {
                    $this->db->or_like($criterio, $search);
                }
            }
            $this->db->group_end();
        }

        return $this->db->get()->result();
    }

    public function contar_campanas($search, $id_cliente, $type){
        $this->db->select('*');
        $this->db->from('Enhance');
        $this->db->group_start();
        $this->db->or_where('Enhance.estatus !=', 33);
        $this->db->or_where('Enhance.estatus IS NULL');
        $this->db->group_end();
        $this->db->where('Enhance.id_cliente', $id_cliente);
        $this->db->where('Enhance.type', $type);
        $this->db->where('Enhance.id_parent_enhance', 0);

        if($search) {
            $criterios_search = array(
                'name',
                'description',
                'etiquetas'
            );
            $this->db->group_start();
            if(is_array($search)) {
                foreach($criterios_search as $criterio) {
                    $this->db->or_like($criterio, $search['value']);
                }
            } else {
                foreach($criterios_search as $criterio) {
                    $this->db->or_like($criterio, $search);
                }
            }
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    public function obtener_campanas_usuario_datatable($limit, $offset, $orden, $search, $id_cliente, $tipo_campana){
        $this->db->select('*');
	    $this->db->from('Enhance');
        $this->db->group_start();
        $this->db->or_where('Enhance.estatus !=', 33);
        $this->db->or_where('Enhance.estatus IS NULL');
        $this->db->group_end();
        $this->db->where('Enhance.id_cliente', $id_cliente);
        $this->db->where('Enhance.id_parent_enhance', 0);
        $this->db->where('Enhance.type', $tipo_campana);
        $this->db->limit($limit, $offset);

        if($tipo_campana == 'fijo') {
            $columnas_orden = array(
                1 => 'id_enhance',
                2 => 'price',
                3 => 'sold',
                4 => '(price - costo / 1.16) * sold',
                5 => 'date',
                6 => 'sold',
                7 => 'estatus'
            );
        }elseif($tipo_campana == 'limitado'){
            $columnas_orden = array(
                1 => 'id_enhance',
                2 => 'price',
                3 => 'sold',
                4 => '(price - costo / 1.16) * sold',
                5 => 'quantity',
                6 => '(sold * 100) / quantity',
                7 => 'estatus',
                8 => 'estatus'
            );
        }

        if($orden) {
            foreach($orden as $indice_orden => $ord) {
                $this->db->order_by($columnas_orden[$ord['column']], $ord['dir']);
            }
        }

        if($search) {
            $criterios_search = array(
                'name',
                'description',
                'etiquetas'
            );
            $this->db->group_start();
            if(is_array($search)) {
                foreach($criterios_search as $criterio) {
                    $this->db->or_like($criterio, $search['value']);
                }
            } else {
                foreach($criterios_search as $criterio) {
                    $this->db->or_like($criterio, $search);
                }
            }
            $this->db->group_end();
        }

        return $this->db->get()->result();
    }

    /*Obtener campañas activas*/

    /*Fin campañas activas*/

}

/* End of file Enhance_modelo.php */
/* Location: ./application/models/Enhance_modelo.php */
