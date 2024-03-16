<?php
	
class Slider_modelo extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}

	public function obtener_sliders_admin(){
	    $this->db->select("*")
            ->from("Slider")
            ->where("estatus != 33")
            ->order_by('id_orden', 'ASC');
	    return $this->db->get()->result();
    }

    public function obtener_sliders_usuario(){
	    $this->db->select("*")
            ->from("Slider")
            ->where("estatus = 1")
            ->order_by('id_orden', 'ASC');
	    return $this->db->get()->result();
    }

    public function obtener_sliders_comprar(){
        $this->db->select("SliderComprar.id_slide_comprar,SliderComprar.id_orden,SliderComprar.nombre_imagen,SliderComprar.imagen_original,SliderComprar.alt,SliderComprar.estatus,
        SliderComprar.texto,SliderComprar.url_slide,SliderComprar.texto_principal,SliderComprar.boton,SliderComprar.directorio,SliderComprar.imagen_small")
            ->from("SliderComprar")
            ->where("estatus != 33")
            ->order_by('id_orden', 'ASC');
        $campanas = $this->db->get()->result();


        return $campanas;

    }
    public function obtener_slidersactivos_comprar(){
        $this->db->select("SliderComprar.id_slide_comprar,SliderComprar.id_orden,SliderComprar.nombre_imagen,SliderComprar.imagen_original,SliderComprar.alt,SliderComprar.estatus,
        SliderComprar.texto,SliderComprar.url_slide,SliderComprar.texto_principal,SliderComprar.boton,SliderComprar.directorio,SliderComprar.imagen_small")
            ->from("SliderComprar")
            ->where("estatus = 1")
            ->order_by('id_orden', 'ASC');
        $campanas = $this->db->get()->result();


        return $campanas;
    }
}