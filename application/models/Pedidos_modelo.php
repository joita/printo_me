<?php

class Pedidos_modelo extends CI_Model {

		public function all() {

		$sql = "SELECT
			Pedidos.id_pedido,
			ProductosPorPedido.precio_producto,
			ProductosPorPedido.descuento_especifico,
			ProductosPorPedido.cantidad_producto,
			Pedidos.estatus_pago,
			Pedidos.estatus_pedido,
			Pedidos.subtotal,
			Pedidos.iva,
			Pedidos.total,
			Pedidos.costo_envio,
			Pedidos.codigo_rastreo,
			CatalogoSkuPorProducto.sku,
			CatalogoProductos.nombre_producto
			FROM
			ProductosPorPedido
			JOIN Pedidos ON Pedidos.id_pedido = ProductosPorPedido.id_pedido
			JOIN CatalogoSkuPorProducto ON CatalogoSkuPorProducto.id_sku = ProductosPorPedido.id_sku
			JOIN FotografiasPorProducto ON FotografiasPorProducto.id_fotografia = CatalogoSkuPorProducto.id_fotografia
			JOIN CatalogoProductos ON CatalogoProductos.id_producto = FotografiasPorProducto.id_producto
			ORDER BY Pedidos.id_pedido";

		$pedidos_res = $this->db->query($sql);

		if ($pedidos_res->num_rows() > 0){
		  return $pedidos_res->result();
		}
		return  array();
	}

	public function obtener_pedidos($id_cliente=0) {
		$sql = "SELECT
			Pedidos.*,
            PasosPedido.*,
			DireccionesPorCliente.id_direccion,
			DireccionesPorCliente.identificador_direccion,
			DireccionesPorCliente.linea1,
			DireccionesPorCliente.linea2,
			DireccionesPorCliente.codigo_postal,
			DireccionesPorCliente.ciudad,
			DireccionesPorCliente.estado,
			DireccionesPorCliente.pais,
			Clientes.id_cliente,
			Clientes.nombres,
			Clientes.apellidos,
            Clientes.email,
			(SELECT SUM(cantidad_producto) FROM ProductosPorPedido WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido) AS numero_productos
			FROM Pedidos
			JOIN Clientes ON Clientes.id_cliente=Pedidos.id_cliente
            JOIN PasosPedido ON PasosPedido.id_paso=Pedidos.id_paso_pedido
			JOIN DireccionesPorCliente ON DireccionesPorCliente.id_direccion=Pedidos.id_direccion ";
			if($id_cliente != 0) {
			$sql .= " WHERE Pedidos.id_cliente=".$id_cliente;
			}
			$sql .= " ORDER BY Pedidos.fecha_creacion DESC";

		$pedidos = $this->db->query($sql)->result();

		if(sizeof($pedidos) > 0) {
            foreach($pedidos as $indice_pedido=>$pedido) {
                $pedidos[$indice_pedido]->productos = $this->obtener_productos_por_pedido($pedido->id_pedido);
            }
			return $pedidos;
		} else {
			return array();
		}
	}

    public function obtener_pedidos_por_cliente($id_cliente = null, $periodo = null)
    {
        $this->db->select('Pedidos.*,
                           DireccionesPorCliente.id_direccion,
                           DireccionesPorCliente.identificador_direccion,
                           DireccionesPorCliente.linea1,
                           DireccionesPorCliente.linea2,
                           DireccionesPorCliente.codigo_postal,
                           DireccionesPorCliente.ciudad,
                           DireccionesPorCliente.estado,
                           DireccionesPorCliente.pais,
                           Clientes.id_cliente,
                           Clientes.nombres,
                           Clientes.apellidos,
                           Clientes.email,
                           PasosPedido.*,
                           (SELECT SUM(cantidad_producto) FROM ProductosPorPedido WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido) AS numero_productos')
                 ->from('Pedidos')
                 ->join('Clientes', 'Clientes.id_cliente = Pedidos.id_cliente')
                 ->join('PasosPedido', 'PasosPedido.id_paso = Pedidos.id_paso_pedido')
                 ->join('DireccionesPorCliente', 'DireccionesPorCliente.id_direccion = Pedidos.id_direccion');
        if($id_cliente != 0) {
            $this->db->where('Pedidos.id_cliente', $id_cliente);
        }
        if($periodo) {
            $this->db->where('DATEDIFF(\''.date("Y-m-d H:i:s").'\', fecha_pago)/30.44 <= '.$periodo);
        }
        $this->db->order_by('Pedidos.fecha_creacion', 'DESC');

        $pedidos = $this->db->get()->result();

        if(sizeof($pedidos)) {
            foreach($pedidos as $indice_pedido=>$pedido) {
                $pedidos[$indice_pedido]->productos = $this->obtener_productos_por_pedido($pedido->id_pedido);
            }
            return $pedidos;
        } else {
            return array();
        }
    }

    public function obtener_cantidad_pedidos($id_cliente){
        $this->db->select("COUNT(id_pedido) as cantidad_pedidos")
            ->from("Pedidos")
            ->where("id_cliente", $id_cliente)
            ->where("estatus_pedido !=", "Cancelado")
            ->where("estatus_pedido !=", "Cancelado por fraude");
        return $this->db->get()->row();
    }

	public function obtener_pedido_especifico($id_pedido) {
		$this->db->select('Pedidos.*, PasosPedido.*, Clientes.*, DireccionesPorCliente.id_direccion, DireccionesPorCliente.identificador_direccion, DireccionesPorCliente.linea1, DireccionesPorCliente.linea2, DireccionesPorCliente.codigo_postal, DireccionesPorCliente.ciudad, DireccionesPorCliente.estado, DireccionesPorCliente.pais, DireccionesPorCliente.principal, DireccionesPorCliente.telefono AS dirtel')
				 ->from('Pedidos')
                 ->join('PasosPedido', 'Pedidos.id_paso_pedido = PasosPedido.id_paso')
				 ->join('Clientes', 'Clientes.id_cliente = Pedidos.id_cliente')
				 ->join('DireccionesPorCliente', 'DireccionesPorCliente.id_direccion = Pedidos.id_direccion')
				 ->where('Pedidos.id_pedido', $id_pedido);

		$pedido_res = $this->db->get();
		$pedido = $pedido_res->row();

        if(isset($pedido)) {
            if(isset($pedido->id_pedido)) {
                $pedido->numero_productos = $this->obtener_numero_productos_pedido($pedido->id_pedido);

                $pedido->productos = $this->obtener_productos_por_pedido($pedido->id_pedido);

                $pedido->historial = $this->obtener_historial_pedido($pedido->id_pedido);
            } else {
                return new stdClass();
            }
        } else {
            return new stdClass();
        }
		return $pedido;
	}

	public function obtener_productos_por_pedido($id_pedido) {
        $this->db->select('ProductosPorPedido.*,
            CatalogoSkuPorProducto.*,
            ColoresPorProducto.*,
            FotografiasPorProducto.*,
            CatalogoProductos.id_producto,
            CatalogoProductos.nombre_producto,
            CatalogoProductos.nombre_producto_slug,
            CatalogoProductos.modelo_producto,
            CatalogoProductos.modelo_producto_slug,
            CatalogoProductos.id_categoria,
            CatalogoProductos.id_subcategoria,
            Marcas.nombre_marca,
            Marcas.nombre_marca_slug')
            ->from('ProductosPorPedido')
            ->join('CatalogoSkuPorProducto', 'ProductosPorPedido.id_sku=CatalogoSkuPorProducto.id_sku')
            ->join('ColoresPorProducto', 'ColoresPorProducto.id_color=CatalogoSkuPorProducto.id_color')
            ->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color=ColoresPorProducto.id_color')
            ->join('CatalogoProductos', 'CatalogoProductos.id_producto=ColoresPorProducto.id_producto')
            ->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca')
            ->where('FotografiasPorProducto.estatus', 1)
            ->where('FotografiasPorProducto.principal', 1)
            ->where('ProductosPorPedido.id_pedido', $id_pedido)
            ->order_by('ProductosPorPedido.id_ppp');

        $ppp = $this->db->get()->result();

        if(sizeof($ppp)) {
            foreach($ppp as $indice_ppp => $producto) {
                $ppp[$indice_ppp]->caracteristicas = json_decode($producto->caracteristicas,TRUE);
            }

            return $ppp;
        } else {
            return array();
        }
	}

    public function obtener_historial_pedido($id_pedido)
    {
        $this->db->select('*')
                 ->from('HistorialPedidos')
                 ->where('id_pedido', $id_pedido)
                 ->order_by('id_historial', 'DESC');

        $historial = $this->db->get()->result();

        if(sizeof($historial) > 0) {
            return $historial;
        } else {
            return array();
        }
    }

	public function pedido_devuelto($id_pedido)
	{
		$this->db->select('id_pedido');
		$this->db->from('Devoluciones');
		$this->db->where('id_pedido', $id_pedido);
		$minima_res = $this->db->get();

		return ($minima_res->num_rows() > 0);
	}

	public function use_cupon($id_cliente, $id_cupon)
	{
		$this->db->select("*");
		$this->db->where("id_cliente", $id_cliente);
		$this->db->where("id_cupon", $id_cupon);

		$this->db->from('Pedidos');

		$query = $this->db->get();

		return (count($query->result()) == 0);

	}

    public function obtener_numero_productos_pedido($id_pedido)
    {
        $this->db->select('SUM(cantidad_producto) AS numero_productos')
                 ->from('ProductosPorPedido')
                 ->where('ProductosPorPedido.id_pedido', $id_pedido);

        $num = $this->db->get()->row();

        if(isset($num)) {
            if(isset($num->numero_productos)) {
                return $num->numero_productos;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function obtener_pedidos_datatable($limit, $offset, $orden, $search)
    {
        $this->db->select("Pedidos.*, PasosPedido.*, Clientes.id_cliente, Clientes.nombres, Clientes.apellidos, Clientes.email,
        (SELECT SUM(cantidad_producto) 
         FROM ProductosPorPedido 
         WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido) AS numero_productos");
        $this->db->from("Pedidos");
        $this->db->join("Clientes" , "Clientes.id_cliente=Pedidos.id_cliente");
        $this->db->join("PasosPedido", "PasosPedido.id_paso=Pedidos.id_paso_pedido");
        $this->db->join("(SELECT id_pedido,
        (SELECT SUM(cantidad_producto) 
         FROM Enhance 
         JOIN ProductosPorPedido on Enhance.id_enhance=ProductosPorPedido.id_enhance 
         WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido AND Enhance.type='limitado')AS numero_limitado,
        (SELECT SUM(cantidad_producto) 
         FROM Enhance 
         JOIN ProductosPorPedido on Enhance.id_enhance=ProductosPorPedido.id_enhance 
         WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido AND Enhance.type='fijo')AS numero_fijo,
        (SELECT SUM(cantidad_producto) 
         FROM ProductosPorPedido 
         WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido AND ProductosPorPedido.id_enhance=0)AS numero_custom,
         (SELECT decision_produccion
         FROM CortesPorCampana
         JOIN ProductosPorPedido ON CortesPorCampana.id_enhance=ProductosPorPedido.id_enhance
         WHERE (CortesPorCampana.tipo_campana='limitado' AND  ProductosPorPedido.id_pedido=Pedidos.id_pedido) LIMIT 1)AS decision_producir
        From Pedidos
        ) x", "x.id_pedido=Pedidos.id_pedido");
        $this->db->group_start();
        $this->db->where("x.numero_fijo > 0 OR x.numero_custom > 0 OR (x.numero_limitado > 0 AND x.decision_producir = 1)");
        $this->db->group_end();
        $this->db->limit($limit, $offset);

        $columnas_orden = array(
            0 => 'Pedidos.id_pedido',
            1 => 'nombres',
            3 => 'fecha_creacion',
            4 => 'numero_productos',
            5 => 'total',
            6 => 'metodo_pago'
        );

        if($orden) {
            foreach($orden as $indice_orden => $ord) {
                $this->db->order_by($columnas_orden[$ord['column']], $ord['dir']);
            }
        }

        if($search) {
            $criterios_search = array(
                'Pedidos.id_pedido',
                'nombres',
                'apellidos',
                'Pedidos.id_pedido',
                'fecha_creacion',
                'metodo_pago',
                'nombre_paso',
                'estatus_pedido',
                'id_pago'
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

    public function contar_pedidos_datatable($search)
    {
        $this->db->select("Pedidos.*, PasosPedido.*, Clientes.id_cliente, Clientes.nombres, Clientes.apellidos, Clientes.email,
        (SELECT SUM(cantidad_producto) 
         FROM ProductosPorPedido 
         WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido) AS numero_productos");
        $this->db->from("Pedidos");
        $this->db->join("Clientes" , "Clientes.id_cliente=Pedidos.id_cliente");
        $this->db->join("PasosPedido", "PasosPedido.id_paso=Pedidos.id_paso_pedido");
        $this->db->join("(SELECT id_pedido,
        (SELECT SUM(cantidad_producto) 
         FROM Enhance 
         JOIN ProductosPorPedido on Enhance.id_enhance=ProductosPorPedido.id_enhance 
         WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido AND Enhance.type='limitado')AS numero_limitado,
        (SELECT SUM(cantidad_producto) 
         FROM Enhance 
         JOIN ProductosPorPedido on Enhance.id_enhance=ProductosPorPedido.id_enhance 
         WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido AND Enhance.type='fijo')AS numero_fijo,
        (SELECT SUM(cantidad_producto) 
         FROM ProductosPorPedido 
         WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido AND ProductosPorPedido.id_enhance=0)AS numero_custom,
         (SELECT decision_produccion
         FROM CortesPorCampana
         JOIN ProductosPorPedido ON CortesPorCampana.id_enhance=ProductosPorPedido.id_enhance
         WHERE (CortesPorCampana.tipo_campana='limitado' AND  ProductosPorPedido.id_pedido=Pedidos.id_pedido) LIMIT 1)AS decision_producir
        From Pedidos
        ) x", "x.id_pedido=Pedidos.id_pedido");
        $this->db->group_start();
        $this->db->where("x.numero_fijo > 0 OR x.numero_custom > 0 OR (x.numero_limitado > 0 AND x.decision_producir = 1)");
        $this->db->group_end();

        if ($search) {
            $criterios_search = array(
                'nombres',
                'apellidos',
                'Pedidos.id_pedido',
                'fecha_creacion',
                'metodo_pago',
                'nombre_paso',
                'estatus_pedido'
            );
            $this->db->group_start();
            if (is_array($search)) {
                foreach ($criterios_search as $criterio) {
                    $this->db->or_like($criterio, $search['value']);
                }
            } else {
                foreach ($criterios_search as $criterio) {
                    $this->db->or_like($criterio, $search);
                }
            }
            $this->db->group_end();
        }
        return $this->db->count_all_results();

    }

    public function obtener_cambios_pedido($id_pedido){
        $this->db->select("*")
            ->from('HistorialCambiosPedidos')
            ->where('id_pedido', $id_pedido);
        $cambios = $this->db->get()->result();
        return $cambios;
    }

    public function obtener_pedidos_datatable_excel($fecha_inicio,$fecha_fin)
    {
        $doc = $this->db->select("Pedidos.*, PasosPedido.*, Clientes.id_cliente, Clientes.nombres, Clientes.apellidos, Clientes.email,
        (SELECT SUM(cantidad_producto) 
         FROM ProductosPorPedido 
         WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido) AS numero_productos")
        ->from("Pedidos")
        ->where('date(Pedidos.fecha_creacion) >= ',$fecha_inicio)
        ->where('date(Pedidos.fecha_creacion) <= ',$fecha_fin)
        ->join("Clientes" , "Clientes.id_cliente=Pedidos.id_cliente")
        ->join("PasosPedido", "PasosPedido.id_paso=Pedidos.id_paso_pedido")
        ->join("(SELECT id_pedido,
        (SELECT SUM(cantidad_producto) 
         FROM Enhance 
         JOIN ProductosPorPedido on Enhance.id_enhance=ProductosPorPedido.id_enhance 
         WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido AND Enhance.type='limitado')AS numero_limitado,
        (SELECT SUM(cantidad_producto) 
         FROM Enhance 
         JOIN ProductosPorPedido on Enhance.id_enhance=ProductosPorPedido.id_enhance 
         WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido AND Enhance.type='fijo')AS numero_fijo,
        (SELECT SUM(cantidad_producto) 
         FROM ProductosPorPedido 
         WHERE ProductosPorPedido.id_pedido=Pedidos.id_pedido AND ProductosPorPedido.id_enhance=0)AS numero_custom,
         (SELECT decision_produccion
         FROM CortesPorCampana
         JOIN ProductosPorPedido ON CortesPorCampana.id_enhance=ProductosPorPedido.id_enhance
         WHERE (CortesPorCampana.tipo_campana='limitado' AND  ProductosPorPedido.id_pedido=Pedidos.id_pedido) LIMIT 1)AS decision_producir
        From Pedidos
        ) x", "x.id_pedido=Pedidos.id_pedido")
        // ->where("date(Pedidos.fecha_creacion) BETWEEN $fecha_inicio1 AND $fecha_inicio1")
        ->group_start()
        ->where("x.numero_fijo > 0 OR x.numero_custom > 0 OR (x.numero_limitado > 0 AND x.decision_producir = 1)")
        ->group_end()
        ->get();
 
        return $doc->result();
    }


}
