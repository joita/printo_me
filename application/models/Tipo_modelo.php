<?php
	
class Tipo_modelo extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}

	public function obtener_tipo($id_tipo, $json = false) {
		
		$tipo_res = $this->db->get_where('TiposDeProducto', array('id_tipo' => $id_tipo));
		$result = $tipo_res->result();
		
		if($json) {
			$result[0]->caracteristicas_tipo = json_decode($result[0]->caracteristicas_tipo);
		}
		
		return $result[0];
		
	}
	
	public function obtener_tipos() {
		
		$tipos_res = $this->db->get_where('TiposDeProducto', array('estatus' => 1));
		$tipos = $tipos_res->result();
		
		return $tipos;
	}
	
	public function obtener_tipos_admin($id_categoria) {
        $this->db->select('*');
        $this->db->from('TipoPerteneceACategoria');
        $this->db->join('TiposDeProducto', 'TiposDeProducto.id_tipo = TipoPerteneceACategoria.id_tipo');
        $this->db->where('TipoPerteneceACategoria.id_categoria', $id_categoria);
        $this->db->where('TiposDeProducto.estatus !=', 33);
        $this->db->where('TiposDeProducto.estatus !=', 33);

        $tipos_res = $this->db->get();

        $tipos = new stdClass();
        foreach ($tipos_res->result() as $i => $tipo) {
            $tipos->$i = new stdClass();
            $tipos->$i->tipo = $tipo;
            $result_cara = $this->db->get_where('CaracteristicasAdicionales', array('id_caracteristica_parent' => 0, 'estatus !=' => 33, 'id_tipo' => $tipo->id_tipo));
            //print_r($result_cara->result());
            if($result_cara->num_rows()) {
                $tipos->$i->caracteristica = new stdClass();
                foreach ($result_cara->result() as $j => $caracteristica) {
                    $tipos->$i->caracteristica->$j = new stdClass();
                    $tipos->$i->caracteristica->$j = $caracteristica;
                    $this->db->order_by('id_caracteristica', 'ASC');
                    $tipos->$i->caracteristica->$j->subcaracteristica = $this->db->get_where('CaracteristicasAdicionales', array('id_caracteristica_parent' => $caracteristica->id_caracteristica, 'id_tipo' => $tipo->id_tipo, 'estatus !=' => 33))->result();
                }
            }
        }

        if(!isset($tipos->{0})) {
            return 0;
        } else {
            return $tipos;
        }

    }

    public function obtener_tipos_cliente($id_categoria) {
        $this->db->select('*');
        $this->db->from('TipoPerteneceACategoria');
        $this->db->join('TiposDeProducto', 'TiposDeProducto.id_tipo = TipoPerteneceACategoria.id_tipo');
        $this->db->where('TipoPerteneceACategoria.id_categoria', $id_categoria);
        $this->db->where('TiposDeProducto.estatus !=', 33);
        $this->db->where('TiposDeProducto.estatus !=', 55);

        $tipos_res = $this->db->get();

        $tipos = new stdClass();
        foreach ($tipos_res->result() as $i => $tipo) {
            $tipos->$i = new stdClass();
            $tipos->$i->tipo = $tipo;
            $result_cara = $this->db->get_where('CaracteristicasAdicionales', array('id_caracteristica_parent' => 0, 'estatus !=' => 33, 'id_tipo' => $tipo->id_tipo));
            //print_r($result_cara->result());
            if($result_cara->num_rows()) {
                $tipos->$i->caracteristica = new stdClass();
                foreach ($result_cara->result() as $j => $caracteristica) {
                    $tipos->$i->caracteristica->$j = new stdClass();
                    $tipos->$i->caracteristica->$j = $caracteristica;
                    $this->db->order_by('id_caracteristica', 'ASC');
                    $tipos->$i->caracteristica->$j->subcaracteristica = $this->db->get_where('CaracteristicasAdicionales', array('id_caracteristica_parent' => $caracteristica->id_caracteristica, 'id_tipo' => $tipo->id_tipo, 'estatus !=' => 33))->result();
                }
            }
        }

        if(!isset($tipos->{0})) {
            return 0;
        } else {
            return $tipos;
        }

    }
	
	public function obtener_tipo_minimo_admin($id_categoria) {
        $this->db->select('*');
        $this->db->from('TipoPerteneceACategoria');
        $this->db->join('TiposDeProducto', 'TiposDeProducto.id_tipo = TipoPerteneceACategoria.id_tipo');
        $this->db->where('TipoPerteneceACategoria.id_categoria', $id_categoria);
        $this->db->where('TiposDeProducto.estatus !=', 33);
        $this->db->order_by('TiposDeProducto.id_tipo', 'ASC');
        $this->db->limit(1);

        $tipos_res = $this->db->get();

        $tipos = new stdClass();
        foreach ($tipos_res->result() as $i => $tipo) {
            $tipos->$i = new stdClass();
            $tipos->$i->tipo = $tipo;
            $result_cara = $this->db->get_where('CaracteristicasAdicionales', array('id_caracteristica_parent' => 0, 'estatus !=' => 33, 'id_tipo' => $tipo->id_tipo));
            //print_r($result_cara->result());
            if($result_cara->num_rows()) {
                $tipos->$i->caracteristica = new stdClass();
                foreach ($result_cara->result() as $j => $caracteristica) {
                    $tipos->$i->caracteristica->$j = new stdClass();
                    $tipos->$i->caracteristica->$j = $caracteristica;
                    $this->db->order_by('id_caracteristica', 'ASC');
                    $tipos->$i->caracteristica->$j->subcaracteristica = $this->db->get_where('CaracteristicasAdicionales', array('id_caracteristica_parent' => $caracteristica->id_caracteristica, 'id_tipo' => $tipo->id_tipo, 'estatus !=' => 33))->result();
                }
            }
        }

        if(!isset($tipos->{0})) {
            return 0;
        } else {
            return $tipos->{0};
        }

    }
	
	public function obtener_tipo_activo_por_slug($id_categoria, $nombre_tipo_slug) {
        $this->db->select('*');
        $this->db->from('TipoPerteneceACategoria');
        $this->db->join('TiposDeProducto', 'TiposDeProducto.id_tipo = TipoPerteneceACategoria.id_tipo');
        $this->db->where('TiposDeProducto.nombre_tipo_slug', $nombre_tipo_slug);
        $this->db->where('TipoPerteneceACategoria.id_categoria', $id_categoria);
        $this->db->where('TiposDeProducto.estatus !=', 33);
        $this->db->order_by('TiposDeProducto.id_tipo', 'ASC');
        $this->db->limit(1);

        $tipos_res = $this->db->get();

        $tipos = new stdClass();
        foreach ($tipos_res->result() as $i => $tipo) {
            $tipos->$i = new stdClass();
            $tipos->$i->tipo = $tipo;
            $result_cara = $this->db->get_where('CaracteristicasAdicionales', array('id_caracteristica_parent' => 0, 'estatus !=' => 33, 'id_tipo' => $tipo->id_tipo));
            //print_r($result_cara->result());
            if($result_cara->num_rows()) {
                $tipos->$i->caracteristica = new stdClass();
                foreach ($result_cara->result() as $j => $caracteristica) {
                    $tipos->$i->caracteristica->$j = new stdClass();
                    $tipos->$i->caracteristica->$j = $caracteristica;
                    $this->db->order_by('id_caracteristica', 'ASC');
                    $tipos->$i->caracteristica->$j->subcaracteristica = $this->db->get_where('CaracteristicasAdicionales', array('id_caracteristica_parent' => $caracteristica->id_caracteristica, 'id_tipo' => $tipo->id_tipo, 'estatus !=' => 33))->result();
                }
            }
        }

        if(!isset($tipos->{0})) {
            return 0;
        } else {
            return $tipos->{0};
        }

    }
	
	
	/*
	 * obtiene el tipo a partir de la categoría
	 */
	public function obtener_tipo_de_categoria($categoria_slug)
	{
		$categoria = $this->catalogo_modelo->obtener_categoria_por_slug($categoria_slug, 0);
		
		$tipo_relacion_res = $this->db->get_where('TiposDeProducto', array('id_categoria' => $categoria->id_categoria));
		$tipo_relacion = $tipo_relacion_res->result();
		
		$tipo = $this->obtener_tipo($tipo_relacion[0]->id_tipo);
		
		return $tipo;
	}
}