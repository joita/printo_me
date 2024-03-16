<?php

class Tienda_m extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function obtener_tiendas($id_tienda = null)
	{
		$this->db->order_by('id_tienda', 'DESC');
		if(!$id_tienda) {
			$tiendas = $this->db->get('Tiendas')->result();
		} else {
			$tiendas = $this->db->get_where('Tiendas', array('id_tienda' => $id_tienda))->result();
		}

		foreach($tiendas as $indice=>$tienda)
		{
			$tiendas[$indice]->dueno = $this->obtener_dueno($tienda->id_cliente);
			$tiendas[$indice]->cantidad_productos = $this->obtener_numero_productos($tienda->id_cliente);
		}

		return $tiendas;
	}

	public function obtener_id_dueno($nombre_tienda_slug)
	{
		$tienda = $this->db->get_where('Tiendas', array('nombre_tienda_slug' => $nombre_tienda_slug))->row();

		if(!isset($tienda->id_cliente)) {
			return 0;
		} else {
			return $tienda->id_cliente;
		}
	}

	public function obtener_dueno($id_dueno)
	{
		$this->db->select('nombres, apellidos, email')->from('Clientes')->where('id_cliente', $id_dueno);
		$dueno = $this->db->get()->row();

		return $dueno;
	}

	public function obtener_numero_productos($id_dueno)
	{
		$this->db->select('COUNT(id_enhance) AS cantidad')->from('Enhance')->where(array('id_cliente' => $id_dueno, 'estatus' => 1));
		$cantidad = $this->db->get()->row();

		return $cantidad->cantidad;
	}

	public function obtener_tienda_por_id_dueno($id_cliente)
	{
		return $this->db->get_where('Tiendas', array('id_cliente' => $id_cliente))->row();
	}

	public function obtener_link_producto($id_enhance, $nombre_tienda_slug = null)
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

			$url = site_url('tienda/'.$nombre_tienda_slug.'/'.$slug.'/'.$name_slug.'-'.$campana[0]->id_enhance);

			return $url;
		} else {
			return base_url();
		}
	}

    public function obtener_tiendas_datatable($limit, $offset, $orden, $search)
    {
        $this->db->select("Tiendas.*, Clientes.nombres, Clientes.apellidos, Clientes.email,
        (SELECT COUNT(Enhance.id_enhance) FROM Enhance WHERE Tiendas.id_cliente=Enhance.id_cliente AND estatus=1) AS cantidad");
        $this->db->from("Tiendas");
        $this->db->join("Clientes", "Tiendas.id_cliente=Clientes.id_cliente");
        $this->db->limit($limit, $offset);

        $columnas_orden = array(
            0 => 'Tiendas.id_tienda',
            2 => 'nombre_tienda',
            3 => 'Clientes.nombres',
            4 => 'cantidad'
        );

        if($orden) {
            foreach($orden as $indice_orden => $ord) {
                $this->db->order_by($columnas_orden[$ord['column']], $ord['dir']);
            }
        }

        if($search) {
            $criterios_search = array(
                'id_tienda',
                'nombres',
                'apellidos',
                'email',
                'nombre_tienda',
                'descripcion_tienda'
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

    public function contar_tiendas_datatable($search)
    {
        $this->db->select("Tiendas.*, Clientes.nombres, Clientes.apellidos, Clientes.email,
        (SELECT COUNT(Enhance.id_enhance) FROM Enhance WHERE Tiendas.id_cliente=Enhance.id_cliente AND estatus=1) AS cantidad");
        $this->db->from("Tiendas");
        $this->db->join("Clientes", "Tiendas.id_cliente=Clientes.id_cliente");

        if ($search) {
            $criterios_search = array(
                'id_tienda',
                'nombres',
                'apellidos',
                'email',
                'nombre_tienda',
                'descripcion_tienda'
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

    public function obtener_link_tienda($id_enhance){
	    $this->db->select('Tiendas.nombre_tienda_slug')
            ->from('Tiendas')
            ->join('Enhance', 'Tiendas.id_cliente = Enhance.id_cliente')
            ->where('Enhance.id_enhance', $id_enhance);
	    $tienda_slug = $this->db->get()->row();
        return site_url()."/tienda/1/".$tienda_slug->nombre_tienda_slug;
    }
    public function obtener_tiendas_vip(){

	    $this->db->select('Tiendas.id_tienda,Tiendas.nombre_tienda,Tiendas.nombre_tienda_slug,Tiendas.logotipo_mediano,concat_ws(\' \',Clientes.nombres,Clientes.apellidos) as cliente')
        ->from('Tiendas')
        ->join('Clientes','Clientes.id_cliente = Tiendas.id_cliente')
        ->where('Tiendas.vip = 1 and Clientes.estatus_cliente = 1')
        ->order_by('id_orden', 'ASC');
	    $tiendas = $this->db->get()->result();


        return $tiendas;
	}
    public function obtener_tiendas_general($start, $offset){

        $this->db->select('distinct (Tiendas.id_tienda) as id_tienda,Tiendas.vip,Tiendas.nombre_tienda,Tiendas.nombre_tienda_slug,Tiendas.logotipo_mediano,concat_ws(\' \',Clientes.nombres,Clientes.apellidos) as cliente')
            ->from('Tiendas')
            ->join('Clientes','Clientes.id_cliente = Tiendas.id_cliente')
            ->join('Enhance','Enhance.id_cliente = Tiendas.id_cliente')
            ->where('Clientes.estatus_cliente = 1 and Enhance.estatus = 1')
            ->order_by('id_orden', 'ASC');
        if($start < 0 || $offset < 0) {
            $this->db->limit(1);
        } else {
            if($start == 1) {
                $start = 0;
            }
            $this->db->limit($offset, $start);
        }

        $tiendas = $this->db->get()->result();

        return $tiendas;
    }
    public function obtener_tiendas_general_orden($start, $offset,$orden,$search,$vip){
        $this->db->select('distinct (Tiendas.id_tienda) as id_tienda,Tiendas.vip,Tiendas.nombre_tienda,Tiendas.nombre_tienda_slug,Tiendas.logotipo_mediano,concat_ws(\' \',Clientes.nombres,Clientes.apellidos) as cliente')
            ->from('Tiendas')
            ->join('Clientes','Clientes.id_cliente = Tiendas.id_cliente')
            ->join('Enhance','Enhance.id_cliente = Tiendas.id_cliente')
            ->where('Clientes.estatus_cliente = 1 and Enhance.estatus = 1');

        if($vip ==1){
            $this->db->where('Tiendas.vip = 1');
        }

        if($search !== 'null' && $search !== '') {

            $criterios_search = array(
                'Tiendas.nombre_tienda',
                'Clientes.nombres',
                'Enhance.name',
                'Enhance.etiquetas'
            );
            $this->db->group_start();
            foreach($criterios_search as $criterio) {
                $this->db->or_like($criterio, $search);
            }
            $this->db->group_end();
        }

        if($start < 0 || $offset < 0) {
            $this->db->limit(1);
        } else {
            if($start == 1) {
                $start = 0;
            }
            $this->db->limit($offset, $start);
        }


        if($orden === null || $orden === 'null'){
            $this->db->order_by('RAND()');
        }else{
            $this->db->order_by('Tiendas.nombre_tienda', $orden);
        }

        $tiendas = $this->db->get()->result();

        return $tiendas;
    }
    public function total_tiendas_general($search,$vip){
        $this->db->select('count( distinct (Tiendas.id_tienda)) as total')
            ->from('Tiendas')
            ->join('Clientes','Clientes.id_cliente = Tiendas.id_cliente')
            ->join('Enhance','Enhance.id_cliente = Tiendas.id_cliente')
            ->where('Clientes.estatus_cliente = 1 and Enhance.estatus = 1');

        if($vip ==1){
            $this->db->where('Tiendas.vip = 1');
        }

        if($search !== 'null' && $search !== '') {
            $criterios_search = array(
                'Tiendas.nombre_tienda',
                'Clientes.nombres',
                'Enhance.name',
                'Enhance.etiquetas'
            );
            $this->db->group_start();
            foreach($criterios_search as $criterio) {
                $this->db->or_like($criterio, $search);
            }
            $this->db->group_end();
        }
        $tiendas = $this->db->get()->result();
        return $tiendas;
    }

}
