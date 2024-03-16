<?php

class Masvendidos_modelo extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function obtener_masvendidos_admin(){
        $this->db->select("MasVendidos.nombre_imagen,MasVendidos.directorio,MasVendidos.alt,MasVendidos.creador,MasVendidos.logo,
        MasVendidos.estatus,MasVendidos.url_imagen,MasVendidos.imagen_small,MasVendidos.id_mas_vendido,MasVendidos.imagen_medium")
            ->from("MasVendidos")
            ->where("estatus != 33")
            ->order_by('id_orden', 'ASC');
        return $this->db->get()->result();
    }

    public function obtener_masvendidos_usuario(){
        $this->db->select("MasVendidos.nombre_imagen,MasVendidos.directorio,MasVendidos.alt,MasVendidos.creador,MasVendidos.logo,
        MasVendidos.estatus,MasVendidos.url_imagen,MasVendidos.imagen_small,MasVendidos.id_mas_vendido,MasVendidos.imagen_medium")
            ->from("MasVendidos")
            ->where("estatus = 1")
            ->order_by('id_orden', 'ASC');
        return $this->db->get()->result();
    }
}