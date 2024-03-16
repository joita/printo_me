<?php

class Reportes_modelo extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}

	public function obtener_minimos()
	{
		$this->db->select('*')
				 ->from('CatalogoSkuPorProducto')
				 ->join('ColoresPorProducto', 'CatalogoSkuPorProducto.id_color=ColoresPorProducto.id_color')
				 ->join('FotografiasPorProducto', 'ColoresPorProducto.id_color=FotografiasPorProducto.id_color')
				 ->where('CatalogoSkuPorProducto.estatus', 1)
				 ->where('CatalogoSkuPorProducto.cantidad_inicial <= CatalogoSkuPorProducto.cantidad_minima')
				 ->where('FotografiasPorProducto.principal', 1)
				 ->order_by('CatalogoSkuPorProducto.cantidad_inicial', 'ASC');

		$minimos_res = $this->db->get();

		$minimos = $minimos_res->result();

		foreach($minimos as $index=>$minimo) {
			$minimos[$index]->caracteristicas = json_decode($minimo->caracteristicas);
		}

		return $minimos;
	}

    public function obtener_todos()
    {
        $this->db->select('*')
            ->from('CatalogoSkuPorProducto')
            ->join('ColoresPorProducto', 'CatalogoSkuPorProducto.id_color=ColoresPorProducto.id_color')
            ->join('FotografiasPorProducto', 'ColoresPorProducto.id_color=FotografiasPorProducto.id_color')
            ->where('CatalogoSkuPorProducto.estatus', 1)
            ->where('FotografiasPorProducto.principal', 1)
            ->order_by('CatalogoSkuPorProducto.cantidad_inicial', 'ASC');

        $minimos_res = $this->db->get();

        $minimos = $minimos_res->result();

        foreach($minimos as $index=>$minimo) {
            $minimos[$index]->caracteristicas = json_decode($minimo->caracteristicas);
        }

        return $minimos;
    }

    public function obtener_existencias()
    {
        $this->db->order_by('id_producto', 'ASC');
        $productos = $this->db->get_where('CatalogoProductos', array('estatus' => 1))->result();

        foreach($productos as $indice_producto => $producto)
        {
            $productos[$indice_producto]->colores = $this->db->get_where('ColoresPorProducto', array('id_producto' => $producto->id_producto, 'estatus' => 1))->result();

            foreach($productos[$indice_producto]->colores as $indice_color => $color) {
                $productos[$indice_producto]->colores[$indice_color]->fotografia = $this->db->get_where('FotografiasPorProducto', array('id_color' => $color->id_color, 'principal' => 1))->row();

                $this->db->order_by('id_sku', 'ASC');
                $productos[$indice_producto]->colores[$indice_color]->tallas = $this->db->get_where('CatalogoSkuPorProducto', array('id_color' => $color->id_color, 'estatus' => 1))->result();
            }
        }

        return $productos;
    }

	public function ventas($fecha_inicio, $fecha_final, $metodo_de_pago)
	{
		$fecha_inicio .= ' 00:00:00';
		$fecha_final  .= ' 23:59:59';

		$resultado = new stdClass();

		// Numero de pedidos
		$this->db->select('COUNT(id_pedido) AS numero_pedidos')
				 ->from('Pedidos')
				 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
		if($metodo_de_pago != 'todos') {
			$this->db->where('metodo_pago', $metodo_de_pago);
		}
		$no_pedidos = $this->db->get()->row();
		$resultado->numero_pedidos = $no_pedidos->numero_pedidos;

		// Numero de pedidos pagados
		$this->db->select('COUNT(id_pedido) AS numero_pedidos')
				 ->from('Pedidos')
                 ->where('id_paso_pedido < 7')
				 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'')
				 ->where('estatus_pago', 'paid');
		if($metodo_de_pago != 'todos') {
			$this->db->where('metodo_pago', $metodo_de_pago);
		}
		$no_pedidos = $this->db->get()->row();
		$resultado->numero_pedidos_pagados = $no_pedidos->numero_pedidos;

		// Numero de pedidos pendientes
		$this->db->select('COUNT(id_pedido) AS numero_pedidos')
				 ->from('Pedidos')
                 ->where('id_paso_pedido < 7')
				 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'')
				 ->where('estatus_pago', 'pending_payment')
				 ->where('cronjob', 0);
		if($metodo_de_pago != 'todos') {
			$this->db->where('metodo_pago', $metodo_de_pago);
		}
		$no_pedidos = $this->db->get()->row();
		$resultado->numero_pedidos_pendientes = $no_pedidos->numero_pedidos;

		// Numero de pedidos cancelados
		$this->db->select('COUNT(id_pedido) AS numero_pedidos')
				 ->from('Pedidos')
				 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'')
				 ->where('estatus_pago', 'pending_payment')
                 ->where('estatus_pedido', 'Cancelado')
                 ->or_where('estatus_pedido', 'Cancelado por fraude')
				 ->where('cronjob', 1);
		if($metodo_de_pago != 'todos') {
			$this->db->where('metodo_pago', $metodo_de_pago);
		}
		$no_pedidos = $this->db->get()->row();
		$resultado->numero_pedidos_cancelados = $no_pedidos->numero_pedidos;

		// Contar por tipo
		if($metodo_de_pago == 'todos') {
			$this->db->select('COUNT(id_pedido) AS tarjeta')
					 ->from('Pedidos')
					 ->where('metodo_pago', 'stripe')
                     ->where('id_paso_pedido < 7')
					 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
			$no_tarjeta = $this->db->get()->row();

			$this->db->select('COUNT(id_pedido) AS paypal')
					 ->from('Pedidos')
					 ->where('metodo_pago', 'paypal')
                     ->where('id_paso_pedido < 7')
					 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
			$no_paypal = $this->db->get()->row();

			$this->db->select('COUNT(id_pedido) AS oxxo')
					 ->from('Pedidos')
					 ->where('metodo_pago', 'cash_payment')
                     ->where('estatus_pago', 'paid')
                     ->where('id_paso_pedido < 7')
					 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
			$no_oxxo_pagados = $this->db->get()->row();

			$this->db->select('COUNT(id_pedido) AS oxxo')
					 ->from('Pedidos')
					 ->where('metodo_pago', 'cash_payment')
                     ->where('estatus_pago', 'pending_payment')
					 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
			$no_oxxo_pendientes = $this->db->get()->row();

			$this->db->select('COUNT(id_pedido) AS spei')
					 ->from('Pedidos')
					 ->where('metodo_pago', 'spei')
                     ->where('estatus_pago', 'paid')
                     ->where('id_paso_pedido < 7')
					 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
			$no_spei_pagados = $this->db->get()->row();

			$this->db->select('COUNT(id_pedido) AS spei')
					 ->from('Pedidos')
					 ->where('metodo_pago', 'spei')
                     ->where('estatus_pago', 'pending_payment')
					 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
			$no_spei_pendientes = $this->db->get()->row();

            $this->db->select('COUNT(id_pedido) AS ppp')
                ->from('Pedidos')
                ->where('metodo_pago', 'PPP')
                ->where('id_paso_pedido < 7')
                ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
            $no_ppp = $this->db->get()->row();

			$resultado->pedidos_tarjeta = $no_tarjeta->tarjeta;
			$resultado->pedidos_paypal = $no_paypal->paypal;
            $resultado->pedidos_ppp = $no_ppp->ppp;
			$resultado->pedidos_oxxo_pagados = $no_oxxo_pagados->oxxo;
			$resultado->pedidos_oxxo_pendientes = $no_oxxo_pendientes->oxxo;
			$resultado->pedidos_spei_pagados = $no_spei_pagados->spei;
			$resultado->pedidos_spei_pendientes = $no_spei_pendientes->spei;
		}

		// Montos de ventas
		// Total
		$this->db->select('SUM(total) AS venta_total, MIN(total) AS minimo, MAX(total) AS maximo, AVG(total) as promedio')
				 ->from('Pedidos')
                 ->where('estatus_pago', 'paid')
                 ->where('id_paso_pedido < 7')
				 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
		if($metodo_de_pago != 'todos') {
			$this->db->where('metodo_pago', $metodo_de_pago);
		}
		$resultado->montos = $this->db->get()->row();

		// Montos de ventas
		// Total pendiente
		$this->db->select('SUM(total) AS monto_total_pendiente')
				 ->from('Pedidos')
                 ->where('estatus_pago', 'pending_payment')
                 ->where('estatus_pedido !=', 'Cancelado por fraude')
                 ->where('estatus_pedido !=', 'Cancelado')
                 ->where('id_paso_pedido < 7')
				 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
		if($metodo_de_pago != 'todos') {
			$this->db->where('metodo_pago', $metodo_de_pago);
		}
		$resultado->venta_total_pendiente = $this->db->get()->row()->monto_total_pendiente;

		//Montos de pedidos cancelados
        //total cancelados
        $this->db->select('SUM(total) AS total, MIN(total) AS minimo, MAX(total) AS maximo, AVG(total) as promedio')
            ->from('Pedidos')
            ->where('estatus_pedido !=', 'Completo')
            ->where('estatus_pedido !=', 'En Proceso' )
            ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
        if($metodo_de_pago != 'todos') {
            $this->db->where('metodo_pago', $metodo_de_pago);
        }

        $resultado->montos_cancelados = $this->db->get()->row();
        $resultado->montos_cancelados->query = $this->db->last_query();


        // Clientes nuevos vs clientes recurrentes
        $this->db->select('DISTINCT(id_cliente) AS id_c, (SELECT COUNT(id_pedido) FROM Pedidos WHERE Pedidos.id_cliente=id_c) AS pedidos')
                 ->from('Pedidos')
                 ->where('id_paso_pedido < 7')
                 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
		if($metodo_de_pago != 'todos') {
			$this->db->where('metodo_pago', $metodo_de_pago);
		}
        $this->db->order_by('pedidos', 'ASC');
        $resultado->info_clientes = $this->db->get()->result();

        $resultado->nuevos = 0;
        $resultado->recurrentes = 0;
        foreach($resultado->info_clientes as $res) {
            if($res->pedidos == 1) {
                $resultado->nuevos += 1;
            } else {
                $resultado->recurrentes += 1;
            }
        }

		// Id_pedidos en el periodo
		$this->db->select('MIN(id_pedido) as min_id, MAX(id_pedido) as max_id')
				 ->from('Pedidos')
				 ->where('fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
		$pedidos_rango = $this->db->get()->row();

		if(isset($pedidos_rango->min_id) && isset($pedidos_rango->max_id)) {
			// 5 SKU más vendidos
			$this->db->select('ProductosPorPedido.id_sku, SUM(ProductosPorPedido.cantidad_producto) AS vendidos, CatalogoSkuPorProducto.*')
					 ->from('ProductosPorPedido')
					 ->join('CatalogoSkuPorProducto', 'CatalogoSkuPorProducto.id_sku = ProductosPorPedido.id_sku')
					 ->where('ProductosPorPedido.id_pedido BETWEEN '.$pedidos_rango->min_id.' AND '.$pedidos_rango->max_id)
					 ->group_by('ProductosPorPedido.id_sku')
					 ->order_by('vendidos', 'DESC');
			$resultado->cinco_skus = $this->db->get()->result();
			foreach($resultado->cinco_skus as $indice_sku => $cinco) {
				$resultado->cinco_skus[$indice_sku]->caracteristicas = json_decode($cinco->caracteristicas);
			}
		} else {
			$resultado->cinco_skus = array();
		}

        $info = $this->db->query('SELECT * FROM (
                SELECT
                Pedidos.id_pedido,
                (SELECT COUNT(id_enhance) FROM ProductosPorPedido WHERE ProductosPorPedido.id_pedido = Pedidos.id_pedido AND ProductosPorPedido.id_enhance != 0) AS cantidad_campanas
                FROM Pedidos
                WHERE Pedidos.fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'
                AND Pedidos.estatus_pago = \'paid\'
                AND Pedidos.estatus_pedido != \'Cancelado\'
                ORDER BY cantidad_campanas DESC
                ) AS info
                WHERE cantidad_campanas > 0')->result();

        if(sizeof($info) > 0) {
            $ors = 'AND (';
            $i = 0;
            foreach($info as $inf) {
                $ors .= 'ProductosPorPedido.id_pedido = '.$inf->id_pedido;
                if($i < sizeof($info)-1) {
                    $ors .= ' OR ';
                }
                $i++;
            }
            $ors .= ')';

            if($ors == 'AND ()') {
                $ors = '';
            }

            $sql_cantidades = 'SELECT DISTINCT(ProductosPorPedido.id_enhance) AS id_e, Enhance.*,
                               (SELECT SUM(cantidad_producto) FROM ProductosPorPedido AS producto_vendido WHERE ProductosPorPedido.id_enhance=id_e '.$ors.') AS vendido
                               FROM ProductosPorPedido
                               JOIN Enhance ON Enhance.id_enhance=ProductosPorPedido.id_enhance
                               WHERE ProductosPorPedido.id_enhance != 0 '.$ors;

            $resultado->cinco_productos = $this->db->query($sql_cantidades)->result();
        } else {
            $resultado->cinco_productos = array();
        }


        $distintas_campanas = 'SELECT DISTINCT(id_enhance) AS id_enhance FROM (
            SELECT ProductosPorPedido.* FROM Pedidos JOIN ProductosPorPedido ON Pedidos.id_pedido=ProductosPorPedido.id_pedido
            JOIN Enhance ON ProductosPorPedido.id_enhance = Enhance.id_enhance
            WHERE ProductosPorPedido.id_enhance != 0 AND Pedidos.fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'
            AND Pedidos.estatus_pago = \'paid\'
            AND Pedidos.estatus_pedido != \'Cancelado\'
            AND Enhance.id_cliente != 341';
            if($metodo_de_pago != 'todos') {
                $distintas_campanas .= ' AND metodo_pago=\''.$metodo_de_pago.'\' ';
            }
        $distintas_campanas .= ') AS VentasCampanas';

        $enhances = $this->db->query($distintas_campanas)->result();

        foreach($enhances as $indice_enhance => $enhance) {
            $enhances[$indice_enhance]->ganancia_disenador = 0.00;

            $info_para_disenadores = 'SELECT SUM(precio_producto) AS suma_ventas, SUM(cantidad_producto) AS total_vendidos FROM (
                    SELECT ProductosPorPedido.* FROM Pedidos JOIN ProductosPorPedido ON Pedidos.id_pedido=ProductosPorPedido.id_pedido
                    WHERE ProductosPorPedido.id_enhance='.$enhance->id_enhance.' AND Pedidos.fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'
                    AND Pedidos.estatus_pago = \'paid\'
                    AND Pedidos.estatus_pedido != \'Cancelado\'';
            if($metodo_de_pago != 'todos') {
    			$info_para_disenadores .= ' AND metodo_pago=\''.$metodo_de_pago.'\' ';
    		}
            $info_para_disenadores .= ') AS VentasCampanas';
            $info_para_disenadores_res = $this->db->query($info_para_disenadores)->row();
            $enhances[$indice_enhance]->suma_ventas = $info_para_disenadores_res->suma_ventas;
            $enhances[$indice_enhance]->total_vendidos = $info_para_disenadores_res->total_vendidos;

            $this->db->select('*')->from('CortesPorCampana')
                     ->where('id_enhance', $enhance->id_enhance)
                     ->where('fecha_inicio_corte BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'')
                     ->where('fecha_final_corte BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'');
            $enhances[$indice_enhance]->info_cortes = $this->db->get()->result();

            foreach($enhances[$indice_enhance]->info_cortes as $corte) {
                $enhances[$indice_enhance]->ganancia_disenador += $corte->monto_corte;
            }

            $this->db->select("e.costo, e.price, SUM(cantidad_producto) as total_prod")
                ->from("Enhance e")->join("ProductosPorPedido ppp", "ppp.id_enhance = e.id_enhance")
                ->join("Pedidos p", "ppp.id_pedido = p.id_pedido")
                ->where("e.id_enhance", $enhance->id_enhance)
                ->where("p.estatus_pago", "paid")
                ->where("p.estatus_pedido !=", "Cancelado")
                ->where("p.fecha_creacion BETWEEN '$fecha_inicio' AND '$fecha_final'");
            $pagar_disenos = $this->db->get()->row();
            $enhances[$indice_enhance]->ganancia_total_disenador = ((($pagar_disenos->price - $pagar_disenos->costo)/1.16)*0.75)* $pagar_disenos->total_prod;
        }

        foreach($enhances as $indice_enhance => $enhance) {
            if($enhance->ganancia_disenador == 0.00) {
                unset($enhances[$indice_enhance]);
            }
        }


        $resultado->total_ventas_enhances = 0.00;
        $resultado->ganancias_disenadores = 0.00;
        $resultado->ganancias_printome = 0.00;
        $resultado->ganancias_total_disenadores = 0.00;
        foreach($enhances as $indice_enhance => $enhance) {
            $resultado->total_ventas_enhances += $enhance->suma_ventas;
            $resultado->ganancias_disenadores += $enhance->ganancia_disenador;
            $resultado->ganancias_total_disenadores += $enhance->ganancia_total_disenador;
        }

		return $resultado;
	}

	public function obtener_pagos($fecha_inicio, $fecha_final, $metodo_de_pago, $tipo_campana, $pdf){
        $fecha_inicio .= ' 00:00:00';
        $fecha_final  .= ' 23:59:59';

        $resultado = new stdClass();

        //obtener numero de pagos
        $this->db->select("COUNT(id_corte) as numero_pagos, SUM(monto_corte) as total_pagos")
            ->from("CortesPorCampana c")
            ->join("Enhance e", "c.id_enhance=e.id_enhance")
            ->join("Clientes cli", "e.id_cliente=cli.id_cliente")
            ->join("DatosDepositoPorCliente d", "d.id_cliente=cli.id_cliente")
            ->where('c.fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'')
            ->where('d.estatus', 1)
            ->where('c.monto_corte > 0')
            ->where('c.fecha_pago IS NOT NULL');
        if($metodo_de_pago != 'todos') {
            $this->db->where('tipo_pago', $metodo_de_pago);
        }
        if($tipo_campana != 'todos') {
            $this->db->where('tipo_campana', $tipo_campana);
        }
        $pagos = $this->db->get()->row();
        $resultado->numero_pagos = $pagos->numero_pagos;
        if($resultado->numero_pagos != 0) {
            $resultado->total_pagos = $pagos->total_pagos;
            $resultado->promedio_pagos = ($pagos->total_pagos) / ($pagos->numero_pagos);
        }else{
            $resultado->total_pagos = 0.00;
            $resultado->promedio_pagos = 0.00;
            $resultado->min_fecha = date('Y-m-d H:i:s');
            $resultado->max_fecha = date('Y-m-d H:i:s');
        }

        //obtener fechas maximas y minimas
        $this->db->select('COUNT(id_corte) as numero_pagos, MIN(fecha_pago) as min_fecha')
            ->from("CortesPorCampana c")
            ->where('c.monto_corte > 0')
            ->where('c.fecha_pago IS NOT NULL');
        $fechas = $this->db->get()->row();
        $resultado->min_fecha = new stdClass();
        $resultado->max_fecha = new stdClass();
        if($fechas->numero_pagos != 0) {
            $resultado->min_fecha->year = date('Y', strtotime($fechas->min_fecha));
            $resultado->min_fecha->month = date('n', strtotime($fechas->min_fecha));
            $resultado->min_fecha->day = date('j', strtotime($fechas->min_fecha));
            $resultado->max_fecha->year = date('Y');
            $resultado->max_fecha->month = date('n');
            $resultado->max_fecha->day = date('j');
        }else{
            $resultado->min_fecha->year = date('Y');
            $resultado->min_fecha->month = date('n');
            $resultado->min_fecha->day = date('j');
            $resultado->max_fecha->year = date('Y');
            $resultado->max_fecha->month = date('n');
            $resultado->max_fecha->day = date('j');
        }

        //obtener listado pagos
        if($pdf) {
            $this->db->select("cli.email, c.monto_corte, c.fecha_pago, d.tipo_pago, c.comprobante_pago, c.tipo_campana")
                ->from("CortesPorCampana c")
                ->join("Enhance e", "c.id_enhance=e.id_enhance")
                ->join("Clientes cli", "e.id_cliente=cli.id_cliente")
                ->join("DatosDepositoPorCliente d", "d.id_cliente=cli.id_cliente")
                ->where('c.fecha_creacion BETWEEN \'' . $fecha_inicio . '\' AND \'' . $fecha_final . '\'')
                ->where('d.estatus', 1)
                ->where('c.monto_corte > 0')
                ->where('c.fecha_pago IS NOT NULL')
                ->order_by('c.fecha_pago', 'DESC');

            if ($metodo_de_pago != 'todos') {
                $this->db->where('tipo_pago', $metodo_de_pago);
            }
            if ($tipo_campana != 'todos') {
                $this->db->where('tipo_campana', $tipo_campana);
            }
            $lista_pagos = $this->db->get()->result();
            $resultado->pagos = $lista_pagos;
        }

        return $resultado;
    }

    public function obtener_pagos_datatable($limit, $offset, $orden, $search, $fecha_inicio, $fecha_final, $metodo_pago, $tipo_campana){
        $this->db->select("cli.email, c.monto_corte, c.fecha_pago, d.tipo_pago, c.comprobante_pago, c.tipo_campana")
            ->from("CortesPorCampana c")
            ->join("Enhance e", "c.id_enhance=e.id_enhance")
            ->join("Clientes cli", "e.id_cliente=cli.id_cliente")
            ->join("DatosDepositoPorCliente d", "d.id_cliente=cli.id_cliente")
            ->where('c.fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'')
            ->where('d.estatus', 1)
            ->where('c.monto_corte > 0')
            ->where('c.fecha_pago IS NOT NULL');

        if($metodo_pago != 'todos') {
            $this->db->where('tipo_pago', $metodo_pago);
        }
        if($tipo_campana != 'todos') {
            $this->db->where('tipo_campana', $tipo_campana);
        }

        $this->db->limit($limit, $offset);

        $columnas_orden = array(
            0 => 'cli.email',
            1 => 'fecha_pago',
            2 => 'monto_corte',
            3 => 'tipo_pago'
        );

        if($orden) {
            foreach($orden as $indice_orden => $ord) {
                $this->db->order_by($columnas_orden[$ord['column']], $ord['dir']);
            }
        }

        if($search) {
            $criterios_search = array(
                'cli.email'
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

    public function contar_pagos_datatable($search, $fecha_inicio, $fecha_final, $metodo_pago, $tipo_campana){
        $this->db->select("id_corte")
            ->from("CortesPorCampana c")
            ->join("Enhance e", "c.id_enhance=e.id_enhance")
            ->join("Clientes cli", "e.id_cliente=cli.id_cliente")
            ->join("DatosDepositoPorCliente d", "d.id_cliente=cli.id_cliente")
            ->where('c.fecha_creacion BETWEEN \''.$fecha_inicio.'\' AND \''.$fecha_final.'\'')
            ->where('d.estatus', 1)
            ->where('c.monto_corte > 0')
            ->where('c.fecha_pago IS NOT NULL');

        if($metodo_pago != 'todos') {
            $this->db->where('tipo_pago', $metodo_pago);
        }
        if($tipo_campana != 'todos') {
            $this->db->where('tipo_campana', $tipo_campana);
        }

        if ($search) {
            $criterios_search = array(
                'cli.email'
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
}
