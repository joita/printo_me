<?php
/**
 * Created by PhpStorm.
 * User: Javier
 * Date: 07/03/2019
 * Time: 14:45
 */

class Referencias_modelo extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function generar_codigo($id_cliente){
        $id_cupon = $this->cupones_modelo->crear_referencia($id_cliente);
        $this->nueva_referencia($id_cliente, $id_cupon);
    }

    public function nueva_referencia($id_cliente, $id_cupon){
        $referencia = new stdClass();
        $referencia->id_cliente = $id_cliente;
        $referencia->id_cupon = $id_cupon;
        $referencia->experiencia = 0;
        $referencia->puntos = 0;
        $this->db->insert('Referencias', $referencia);
    }

    public function verificar_nivel($id_cliente){
        $referenciado = $this->db->get_where("Referencias", array("id_cliente" => $id_cliente))->row();
        $niveles = $this->db->get('NivelesReferencias')->result();
        $nivel_nuevo = $referenciado->id_nivel;
        foreach ($niveles as $nivel){
            if($referenciado->experiencia >= $nivel->minimo_ventas && $referenciado->experiencia <= $nivel->maximo_ventas){
                $nivel_nuevo = $nivel->id_nivel;
                break;
            }
        }
        $this->db->set('id_nivel', $nivel_nuevo);
        $this->db->where('id_cliente', $id_cliente);
        $this->db->update('Referencias');
        if($referenciado->id_nivel != $nivel_nuevo){
            return true;
        }else{
            return false;
        }
    }

    public function obtener_puntos_referenciado($id_cliente, $subtotal){
        $referenciado = $this->db->get_where("Referencias", array("id_cliente" => $id_cliente))->row();
        $nivel = $this->db->get_where("NivelesReferencias", array("id_nivel" => $referenciado->id_nivel))->row();
        $puntos = $subtotal * $nivel->porcentaje_ganancia;
        return $puntos;
    }

    public function obtener_cliente_referencia($id_cliente){
        $this->db->select("*")
            ->from("Clientes")
            ->where("id_cliente", $id_cliente);
        $cliente = $this->db->get()->result();
        return $cliente[0];
    }

    public function obtener_nivel_referencia($id_nivel){
        $this->db->select("*")
            ->from("NivelesReferencias")
            ->where("id_nivel", $id_nivel);
        $nivel = $this->db->get()->result();
        return $nivel[0];
    }

    public function obtener_cupon_referencia($id_cupon){
        $this->db->select("*")
            ->from("Cupones")
            ->where("id", $id_cupon);
        $cupon = $this->db->get()->result();
        return $cupon[0];
    }

    public function obtener_referencias_cliente($id_cliente){
        $this->db->select("*")
            ->from("HistorialReferencias")
            ->where("id_referenciado", $id_cliente);
        return $this->db->get()->result();
    }

    public function obtener_referencia_cliente($id_cliente){
        $this->db->select("*")
            ->from("Referencias")
            ->where("id_cliente", $id_cliente);
        $referencias = $this->db->get()->result();
        return $referencias[0];
    }
    public function obtener_referencias_datatable($id_cliente, $limit, $offset, $orden){
        $this->db->select("fecha, experiencia, puntos")
            ->from("HistorialReferencias")
            ->where("id_referenciado", $id_cliente)
            ->limit($limit, $offset);

        $columnas_orden = array(
            0 => 'fecha',
            1 => 'experiencia',
            2 => 'puntos'
        );

        if($orden) {
            foreach($orden as $indice_orden => $ord) {
                $this->db->order_by($columnas_orden[$ord['column']], $ord['dir']);
            }
        }
        $referencias = $this->db->get()->result();
        foreach ($referencias as $indice => $referencia){
            $index = $indice + 1;
            $referencia->id_transaccion = $index;
        }
        return $referencias;
    }

    public function contar_referencias($id_cliente){
        $this->db->select("fecha")
            ->from("HistorialReferencias")
            ->where("id_referenciado", $id_cliente);
        return $this->db->count_all_results();
    }

    public function obtener_referencias_admin($limit, $offset, $orden, $search){
        $this->db->select("Referencias.*, Clientes.nombres, Clientes.apellidos, Clientes.email, Cupones.cupon, nombre_nivel, nombre_nivel_slug")
            ->from("Referencias")
            ->join("Clientes", "Referencias.id_cliente=Clientes.id_cliente")
            ->join("NivelesReferencias", "Referencias.id_nivel=NivelesReferencias.id_nivel")
            ->join("Cupones", "Referencias.id_cupon=Cupones.id")
            ->where("experiencia > '0.00'");
        $this->db->limit($limit, $offset);

        $columnas_orden = array(
            0 => 'id_referencia',
            1 => 'Clientes.nombres',
            3 => 'experiencia',
            4 => 'puntos',
            5 => 'Referencias.id_nivel'
        );

        if($orden) {
            foreach($orden as $indice_orden => $ord) {
                $this->db->order_by($columnas_orden[$ord['column']], $ord['dir']);
            }
        }

        if($search) {
            $criterios_search = array(
                'Clientes.nombres',
                'Clientes.apellidos',
                'Clientes.email',
                'NivelesReferencias.nombre_nivel'
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

    public function contar_referencias_admin($search){
        $this->db->select("Referencias*")
            ->from("Referencias")
            ->join("Clientes", "Referencias.id_cliente=Clientes.id_cliente")
            ->join("NivelesReferencias", "Referencias.id_nivel=NivelesReferencias.id_nivel")
            ->where("experiencia > '0.00'");

        if ($search) {
            $criterios_search = array(
                'Clientes.nombres',
                'Clientes.apellidos',
                'Clientes.email',
                'nombre_nivel'
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