<?php

class Wowwinners_modelo extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function obtener_campanas_activas($limit, $offset, $orden, $search){

        $this->db->select("concat_ws(' ',Clientes.nombres,Clientes.apellidos) as cliente,
            Enhance.front_image, Enhance.name, Tiendas.nombre_tienda,Enhance.id_enhance,Enhance.wow_winner,Tiendas.logotipo_chico")
            ->from("Enhance")
            ->join('Clientes','Clientes.id_cliente = Enhance.id_cliente')
            ->join('Tiendas','Tiendas.id_cliente = Clientes.id_cliente')
            ->where("Enhance.estatus = 1 and Clientes.estatus_cliente = 1")
            ->order_by('Enhance.cantidad_vendida', 'DESC');
        $this->db->limit($limit, $offset);

        $columnas_orden = array(
            0 => 'Enhance.id_enhance',
            1 => 'Enhance.name',
            2 => 'Clientes.nombres',
            3 => 'Clientes.apellidos',
            4 => 'Tiendas.nombre_tienda'
        );
        if($orden) {
            foreach($orden as $indice_orden => $ord) {

                $this->db->order_by($columnas_orden[$ord['column']], $ord['dir']);
            }
        }


        if($search) {
            $criterios_search = array(
                'name',
                'nombres',
                'apellidos',
                'nombre_tienda',
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

    public function contar_campanas_datatable($search)
    {
        $this->db->select("concat_ws(' ',Clientes.nombres,Clientes.apellidos) as cliente,
            Enhance.front_image, Enhance.name, Tiendas.nombre_tienda,Enhance.id_enhance,Enhance.wow_winner,Tiendas.logotipo_chico")
            ->from("Enhance")
            ->join('Clientes','Clientes.id_cliente = Enhance.id_cliente')
            ->join('Tiendas','Tiendas.id_cliente = Clientes.id_cliente')
            ->where("Enhance.estatus = 1 and Clientes.estatus_cliente = 1")
            ->order_by('Enhance.cantidad_vendida', 'DESC');

        if ($search) {
            $criterios_search = array(
                'name',
                'nombres',
                'apellidos',
                'nombre_tienda',
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

    public function obtener_campanas_wow(){

        $this->db->select("concat_ws(' ',Clientes.nombres,Clientes.apellidos) as cliente,
            Enhance.front_image, Enhance.name, Tiendas.nombre_tienda,Enhance.id_enhance,Enhance.wow_winner,Tiendas.logotipo_chico, Enhance.texto_wow")
            ->from("Enhance")
            ->join('Clientes','Clientes.id_cliente = Enhance.id_cliente')
            ->join('Tiendas','Tiendas.id_cliente = Clientes.id_cliente')
            ->where("Enhance.estatus = 1 and Clientes.estatus_cliente = 1 and Enhance.wow_winner= 1")
            ->order_by('Enhance.id_orden', 'ASC');
        $campanas = $this->db->get()->result();


        return $campanas;
    }
}