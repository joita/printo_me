<?php


class Test_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }
    public function obtener_estilos(){
        $this->db->select('id_diseno')
            ->from('DisenoProductos');
        return $this->db->get()->result();
    }

    public function obtener_estilo_actual($estilo){
        $this->db->select('*')
        ->from('DisenoProductos')
        ->where('id_diseno', $estilo);

        return $this->db->get()->row();
    }

    public function obtener_fuentes_texto(){
        $this->db->select("*")
            ->from("fuentes")
            ->where("published", 1);
        return $this->db->get()->result();
    }
}