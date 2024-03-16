<?php

class Destacadosinicio_modelo extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function obtener_creadores_admin(){
        $this->db->select("*")
            ->from("CreadoresInicio")
            ->where("estatus != 33")
            ->order_by('id_orden', 'ASC');
        return $this->db->get()->result();
    }

    public function obtener_creadores_usuario(){
        $this->db->select("*")
            ->from("CreadoresInicio")
            ->where("estatus = 1")
            ->order_by('id_orden', 'ASC');
        return $this->db->get()->result();
    }
}