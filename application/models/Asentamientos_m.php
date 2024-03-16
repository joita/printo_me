<?php
/**
 * Created by PhpStorm.
 * User: Javier
 * Date: 11/01/2019
 * Time: 10:29
 */

class Asentamientos_m extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }

    public function obtener_cp_ciudades_estados($codigo_postal){
        $this->db->select("a.nombre_asentamiento, a.ciudad_asentamiento, e.nombre_estado");
        $this->db->from("Asentamientos a");
        $this->db->join("Estados e" , "a.id_estado = e.id_estado");
        $this->db->where("MATCH(a.codigo_postal) AGAINST('".$codigo_postal."')");

        return $this->db->get()->result();
    }
}