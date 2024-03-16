<?php
/**
 * Created by PhpStorm.
 * User: Javier
 * Date: 25/02/2019
 * Time: 13:22
 */

class Cargos_extra_m extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtener_cargo_especifico($id_cargo) {
        $this->db->select('*')
            ->from('CargosExtra')
            ->join('Clientes', 'CargosExtra.id_cliente = Clientes.id_cliente')
            ->where('CargosExtra.id_cargo', $id_cargo);

        $cargo_res = $this->db->get();
        $cargo = $cargo_res->row();

        return $cargo;
    }

    public function obtener_cliente($id_cliente){
        return $this->db->get_where('Clientes', array('id_cliente' => $id_cliente))->row();
    }

    public function obtener_info_cargo($md5_id_cliente, $md5_id_tarjeta){
        $this->db->select('*')
            ->from('CargosExtra')
            ->where('md5(id_cliente)', $md5_id_cliente)
            ->where('md5(id_pago_tarjeta)', $md5_id_tarjeta);

        return $this->db->get()->result();
    }

    public function obtener_info_direccion($md5_direccion){
        $this->db->select('*')
            ->from('DireccionesPorCliente')
            ->where('md5(id_direccion)', $md5_direccion);

        return $this->db->get()->row();
    }

    public function guardar_cargos_extra_tarjeta($orden, $metodo_pago, $email, $cargo){
        $cargo_nuevo = array(
            "fecha_pago" => date("Y-m-d H:i:s", $orden->updated_at),
            "estatus_pago" => 'paid',
            "id_pago" => $orden->id,
            "metodo_pago" => $metodo_pago,
        );
        $this->db->where('id_cargo', $cargo->id_cargo);
        $this->db->update('CargosExtra', $cargo_nuevo);

        $cliente_ac = $this->active->obtener_clientes(array('email' => $email, 'connectionid' => 1));

        if(!isset($cliente_ac->ecomCustomers[0]->id)) {
            $this->active->crear_cliente(1, $cargo->id_cliente, $email);
        }

        // Guardar pedido en active campaign
        $cargo_para_ac = $this->cargos_extra_m->obtener_cargo_especifico($cargo->id_cargo);
        $cliente_ac = $this->active->obtener_clientes(array('email' => $email, 'connectionid' => 1));
        $this->active->crear_cargo(1, $cliente_ac->ecomCustomers[0]->id, 1 /* 0 - sync, 1 - live */, $cargo_para_ac);

        $datos_pedido = new stdClass();
        $datos_pedido->id_pedido = $cargo->id_cargo;
        $datos_pedido->total = $cargo->total;

        return $datos_pedido;
    }

    public function obtener_cargos_datatable($limit, $offset, $orden, $search){
        $this->db->select('CE.id_cargo, CE.metodo_pago, CE.total, CE.estatus_pago, CE.fecha_creacion, CE.id_pedido, CL.nombres, CL.apellidos, CL.email');
        $this->db->from('CargosExtra CE');
        $this->db->join('Clientes CL', 'CE.id_cliente = CL.id_cliente');
        $this->db->where('CE.estatus ', 1);
        $this->db->limit($limit, $offset);

        $columnas_orden = array(
            0 => 'id_cargo',
            1 => 'id_pedido',
            3 => 'nombres',
            4 => 'fecha_creacion',
            5 => 'total',
            6 => 'metodo_pago',
            7 => 'estatus_pago'
        );

        if($orden) {
            foreach($orden as $indice_orden => $ord) {
                $this->db->order_by($columnas_orden[$ord['column']], $ord['dir']);
            }
        }

        if($search) {
            $criterios_search = array(
                'nombres',
                'apellidos',
                'id_pedido',
                'fecha_creacion',
                'metodo_pago',
                'id_cargo',
                'estatus_pago'
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

    public function contar_cargos_datatable($search){
        $this->db->select('CE.id_cargo, CE.metodo_pago, CE.total, CE.estatus_pago, CE.fecha_creacion, CE.id_pedido, CL.nombres, CL.apellidos, CL.email CL.telefono');
        $this->db->from('CargosExtra CE');
        $this->db->join('Clientes CL', 'CE.id_cliente = CL.id_cliente');

        if ($search) {
            $criterios_search = array(
                'nombres',
                'apellidos',
                'id_pedido',
                'fecha_creacion',
                'metodo_pago',
                'id_cargo',
                'estatus_pago'
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
    /*Manejo de shopify */
    public function obtener_pedido_shopify($id_pago) {
        $this->db->select('Pedidos.id_pedido,Pedidos.total as total_pedido, CargosExtra.total as total_cargo,Pedidos.id_paso_pedido,Pedidos.fecha_pago');
        $this->db->from('CargosExtra');
        $this->db->join('Pedidos', 'Pedidos.id_pedido = CargosExtra.id_pedido');
        $this->db->where('CargosExtra.estatus',1);
        $this->db->where('Pedidos.shopify_oid <>',0);
        $this->db->where('Pedidos.id_paso_pedido <>',7);
        $this->db->where('Pedidos.id_paso_pedido <>',8);
        $this->db->where('Pedidos.id_paso_pedido',1);
        $this->db->where('CargosExtra.id_pago', $id_pago);
        $cargo_res = $this->db->get();
        $cargo = $cargo_res->row();

        return $cargo;
    }
    public function obtener_pedido_shopify_cargo($id_cargo) {
        $this->db->select('Pedidos.id_pedido,Pedidos.total as total_pedido, CargosExtra.total as total_cargo,Pedidos.id_paso_pedido,Pedidos.fecha_pago');
        $this->db->from('CargosExtra');
        $this->db->join('Pedidos', 'Pedidos.id_pedido = CargosExtra.id_pedido');
        $this->db->where('CargosExtra.estatus',1);
        $this->db->where('Pedidos.shopify_oid <>',0);
        $this->db->where('Pedidos.id_paso_pedido <>',7);
        $this->db->where('Pedidos.id_paso_pedido <>',8);
        $this->db->where('Pedidos.id_paso_pedido',1);
        $this->db->where('CargosExtra.id_cargo', $id_cargo);

        $cargo_res = $this->db->get();
        $cargo = $cargo_res->row();

        return $cargo;
    }
    public function existe_shopify($id_pedido) {
        $this->db->select('Pedidos.id_pedido');
        $this->db->from('CargosExtra');
        $this->db->join('Pedidos', 'Pedidos.id_pedido = CargosExtra.id_pedido');
        $this->db->where('CargosExtra.estatus',1);
        $this->db->where('Pedidos.shopify_oid <>',0);
        $this->db->where('CargosExtra.id_pedido', $id_pedido);
        $this->db->limit(1);

        $pedido_res = $this->db->get();
        $pedido = $pedido_res->row();

        return $pedido;
    }
    /*Fin manejo de shopify*/
}