<?php

class Cuenta_modelo extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}

	public function obtener_info_cliente($id_cliente) {
        $this->db->select('nombres, apellidos, fecha_nacimiento, genero, telefono, foto_perfil_grande, foto_perfil_chica, cupon');
        $this->db->from('Clientes')
            ->join('Cupones', 'Clientes.id_cliente=Cupones.id_cliente')
            ->where('Cupones.tipo', 5);
        $this->db->where('Clientes.id_cliente', $id_cliente);
        $info_usuario_res = $this->db->get();
        $info_usuario = $info_usuario_res->result();

        return $info_usuario[0];
	}

	public function obtener_direcciones($id_cliente) {
		$this->db->select('*');
		$this->db->from('DireccionesPorCliente');
		$this->db->where('id_cliente', $id_cliente);
		$this->db->where('estatus', 1);
		$this->db->order_by('id_direccion', 'DESC');

		$direcciones_res = $this->db->get();
		$direcciones = $direcciones_res->result();

		return $direcciones;
	}

	public function obtener_direcciones_fiscales($id_cliente, $id_direccion = null) {
		$this->db->select('*');
		$this->db->from('DireccionesFiscalesPorCliente');
		$this->db->where('id_cliente', $id_cliente);
		if($id_direccion) {
			$this->db->where('id_direccion_fiscal', $id_direccion);
		} else {
			$this->db->where('estatus', 1);
		}
		$this->db->order_by('id_direccion_fiscal', 'DESC');

		$direcciones_res = $this->db->get();
		$direcciones = $direcciones_res->result();

		return $direcciones;
	}

	public function obtener_lista($id_cliente){
        $this->db->select('ListasProductos.*,
        ColoresPorProducto.*,
        Marcas.*,
        FotografiasPorProducto.*,
        CatalogoProductos.*,
        Enhance.id_enhance,
        Enhance.name,
        Enhance.description,
        Enhance.id_producto,
        Enhance.design,
        Enhance.price,
        Enhance.front_image,
        Enhance.back_image,
        Enhance.right_image,
        Enhance.left_image,
        Enhance.date,
        Enhance.end_date');
        $this->db->from('ListasProductos');
        $this->db->join('CatalogoProductos', 'ListasProductos.id_producto=CatalogoProductos.id_producto');
        $this->db->join('Enhance', 'ListasProductos.id_enh = Enhance.id_enhance');
        $this->db->join('ColoresPorProducto', 'ColoresPorProducto.id_producto=CatalogoProductos.id_producto');
        $this->db->join('Marcas', 'Marcas.id_marca=CatalogoProductos.id_marca');
        $this->db->join('FotografiasPorProducto', 'FotografiasPorProducto.id_color = ColoresPorProducto.id_color');
        $this->db->where('CatalogoProductos.estatus', 1);
        $this->db->where('ColoresPorProducto.estatus', 1);
        $this->db->where('FotografiasPorProducto.estatus', 1);
        $this->db->where('FotografiasPorProducto.principal', 1);
        $this->db->where('ListasProductos.id_cliente', $id_cliente);
        $this->db->order_by('RAND()');
        $this->db->group_by('CatalogoProductos.id_producto,ListasProductos.id_enh');

        $lista_res = $this->db->get();
        $lista = $lista_res->result();

		foreach($lista as $key=>$producto) {
			if($lista[$key]->descuento_especifico != 0.00) {
				$lista[$key]->precio_descuento = $producto->precio_producto*(1-($producto->descuento_especifico/100));
			}
			$lista[$key]->ubicacion_base = 'assets/images/productos/producto'.$producto->id_producto.'/';
			$categoria = $this->categoria->obtener_categoria($producto->id_categoria);

			if($producto->type == 'fijo') {
				$slug = 'venta-inmediata';
			} else {
				$slug = 'plazo-definido';
			}
			$name_slug = strtolower(url_title(convert_accented_characters(trim($lista[$key]->name))));

			$url = 'compra/'.$slug.'/'.$name_slug.'-'.$lista[$key]->id_enhance;

			$lista[$key]->vinculo_producto = $url;
		}

		return $lista;
	}

	public function obtener_dato_deposito_reciente($id_cliente)
	{
		$this->db->select('*')
				 ->from('DatosDepositoPorCliente')
				 ->where('id_cliente', $id_cliente)
				 ->where('estatus', 1)
				 ->order_by('id_dato_deposito', 'DESC')
				 ->limit(1);

		$datos = $this->db->get()->result();

		if(!isset($datos[0])) {
			return new stdClass();
		} else {
			$datos[0]->datos_json = json_decode($datos[0]->datos_json);
			return $datos[0];
		}
	}

	public function obtener_dato_deposito_por_id($id_dato_deposito)
	{
		$dato_deposito = $this->db->get_where('DatosDepositoPorCliente', array('id_dato_deposito' => $id_dato_deposito))->result();

		if(isset($dato_deposito[0])) {
			$dato_deposito[0]->datos_json = json_decode($dato_deposito[0]->datos_json);
			return $dato_deposito[0];
		} else {
			return new stdClass();
		}
	}

	public function obtener_dato_deposito_por_cliente($id_cliente){
        $dato_deposito = $this->db->get_where('DatosDepositoPorCliente', array('id_cliente' => $id_cliente))->result();
        if(isset($dato_deposito[0])) {
            return true;
        } else {
            return false;
        }
    }

    public function obtener_usuario_email($email){
	    $usuario = $this->db->get_where('Clientes', array('email' => $email))->result();
        if(isset($usuario[0])) {
            return $usuario;
        } else {
            return false;
        }
    }

    public function verificar_nueva_referencia($nuevo_codigo){
        $this->db->select("*")
            ->from('Cupones')
            ->where('cupon', $nuevo_codigo)
            ->where('estatus', 1);
        $resultado = $this->db->get()->result();
        return $resultado;
    }

    public function guardar_nueva_referencia($id_cliente, $nuevo_codigo, $viejo_cupon){
        $data = new stdClass();
        $data->cupon = $nuevo_codigo;
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('tipo', 5);
        $this->db->update('Cupones', $data);

        $this->db->select("id")
            ->from('Cupones')
            ->where('cupon', $nuevo_codigo)
            ->where('tipo', 5);
        $cupon = $this->db->get()->row();

        $historial_cupon = new stdClass();
        $historial_cupon->id_cupon = $cupon->id;
        $historial_cupon->nuevo_cupon = $nuevo_codigo;
        $historial_cupon->viejo_cupon = $viejo_cupon;
        $historial_cupon->fecha_cambio = date("Y-m-d H:i:s");

        $this->db->insert("HistorialCuponesReferencias", $historial_cupon);
    }
}
