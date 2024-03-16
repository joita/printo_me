<?php

class Plantillas_m extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function obtener_plantillas($estatus, $id_clasificacion = null, $id_subclasificacion = null, $id_subsubclasificacion = null)
	{
		$this->db->select('*')
			     ->from('DisenosGuardados');

		if($estatus == 'clasificar') {
			$this->db->where('id_clasificacion IS NULL');
		} else if($estatus == 'activas') {
			$this->db->where('id_clasificacion IS NOT NULL');
			if($id_clasificacion) {
				$this->db->where('id_clasificacion', $id_clasificacion);
                if($id_subclasificacion) {
                    $this->db->where('id_subclasificacion', $id_subclasificacion);
                    if($id_subsubclasificacion){
                        $this->db->where('id_subsubclasificacion', $id_subsubclasificacion);
                    }else{
                        $this->db->where('id_subsubclasificacion IS NULL');
                    }
                } else{
                    $this->db->where('id_subclasificacion IS NULL');
                }
			}
		}
		$this->db->order_by('id_diseno', 'DESC');
		$plantillas = $this->db->get()->result();

		if(sizeof($plantillas) > 0) {
			return $plantillas;
		} else {
			return array();
		}
	}

	public function obtener_plantillas_catalogo($estatus, $id_clasificacion = null, $id_subclasificacion = null, $id_subsubclasificacion = null)
	{
		$this->db->select('*')
			     ->from('DisenosGuardados');

        if($estatus == 'clasificar') {
            $this->db->where('id_clasificacion IS NULL');
        } else if($estatus == 'activas') {
            $this->db->where('id_clasificacion IS NOT NULL');
            if($id_clasificacion) {
                $this->db->where('id_clasificacion', $id_clasificacion);
                if($id_subclasificacion) {
                    $this->db->where('id_subclasificacion', $id_subclasificacion);
                    if($id_subsubclasificacion){
                        $this->db->where('id_subsubclasificacion', $id_subsubclasificacion);
                    }
                }
            }
        }
        if($id_subclasificacion == '32' || $id_subclasificacion == '33' || $id_subclasificacion == '34'){
            $this->db->order_by('id_diseno', 'DESC');
        }else{
            $this->db->order_by('RAND()');
        }

		$plantillas = $this->db->get()->result();

		if(sizeof($plantillas) > 0) {
			foreach($plantillas as $indice_plantilla => $plantilla) {
				$plantillas[$indice_plantilla]->url = 'personalizar/'.$plantilla->id_producto.'/'.$plantilla->id_color.'/'.$plantilla->id_unico;
			}

			return $plantillas;
		} else {
			return array();
		}
	}

	public function obtener_plantilla($id_plantilla)
	{
		$plantilla = $this->db->get_where('DisenosGuardados', array('id_diseno' => $id_plantilla))->result();

		if(sizeof($plantilla)) {
			$plantilla[0]->vectors = json_decode($plantilla[0]->vectors);

			return $plantilla[0];
		} else {
			return new stdClass();
		}
	}

	public function obtener_plantillas_random($id_clasificacion, $limit = 3)
	{
		$this->db->select('*')
				 ->from('DisenosGuardados')
				 ->where('id_clasificacion', $id_clasificacion)
				 ->order_by('RAND()')
				 ->limit($limit);

		$plantillas = $this->db->get()->result();

		if(sizeof($plantillas)) {
			foreach($plantillas as $indice_plantilla => $plantilla) {
				$plantillas[$indice_plantilla]->url = 'personalizar/'.$plantilla->id_producto.'/'.$plantilla->id_color.'/'.$plantilla->id_unico;
			}

			return $plantillas;
		} else {
			return array();
		}
	}

	public function borrar_plantilla($id_plantilla)
	{
		$plantilla = $this->obtener_plantilla($id_plantilla);

		foreach($plantilla->vectors->front as $vector) {
			if($vector->type == 'clipart') {
				if($vector->file->type == 'image') {
					$thumb_url = str_replace(base_url(), '', $vector->thumb);
					$full_url = str_replace(base_url(), '', $vector->url);

					if(file_exists($thumb_url) && !is_dir($thumb_url)) {
						unlink($thumb_url);
					}

					if(file_exists($full_url) && !is_dir($full_url)) {
						unlink($full_url);
					}
				}
			}
		}

		if(file_exists($plantilla->image) && !is_dir($plantilla->image)) {
			unlink($plantilla->image);
		}

		$this->db->where('id_diseno', $id_plantilla);
		$this->db->delete('DisenosGuardados');
	}

	/*Nuevas funciones*/
    public function obtener_plantillas_completas($search,$estatus, $id_clasificacion = null, $id_subclasificacion = null, $id_subsubclasificacion = null,$start,$offset)
    {
        $this->db->select('DisenosGuardados.id_diseno,DisenosGuardados.id_unico,DisenosGuardados.id_cliente,DisenosGuardados.id_producto,
        DisenosGuardados.id_color, DisenosGuardados.vectors,DisenosGuardados.image,DisenosGuardados.id_clasificacion,DisenosGuardados.id_subclasificacion,
        DisenosGuardados.id_subsubclasificacion,Tiendas.vip,Tiendas.nombre_tienda,ClasificacionVentas.nombre_clasificacion,sub.nombre_clasificacion,subsub.nombre_clasificacion')
            ->from('DisenosGuardados')
            ->join('Tiendas', 'Tiendas.id_cliente=DisenosGuardados.id_cliente')
            ->join('ClasificacionVentas', 'ClasificacionVentas.id_clasificacion = DisenosGuardados.id_clasificacion and ClasificacionVentas.estatus = 1', 'left')
            ->join('ClasificacionVentas sub', 'sub.id_clasificacion = DisenosGuardados.id_subclasificacion and sub.estatus = 1', 'left')
            ->join('ClasificacionVentas subsub', 'subsub.id_clasificacion = DisenosGuardados.id_subsubclasificacion and subsub.estatus = 1', 'left');

        if($estatus == 'clasificar') {
            $this->db->where('DisenosGuardados.id_clasificacion IS NULL');
        } else if($estatus == 'activas') {
            $this->db->where('DisenosGuardados.id_clasificacion IS NOT NULL');
            if($id_clasificacion) {
                $this->db->where('DisenosGuardados.id_clasificacion', $id_clasificacion);
                if($id_subclasificacion) {
                    $this->db->where('DisenosGuardados.id_subclasificacion', $id_subclasificacion);
                    if($id_subsubclasificacion){
                        $this->db->where('DisenosGuardados.id_subsubclasificacion', $id_subsubclasificacion);
                    }
                }
            }
        }

        if($search !== 'null' && $search !== '') {

            $criterios_search = array(
                'ClasificacionVentas.nombre_clasificacion',
                'sub.nombre_clasificacion',
                'subsub.nombre_clasificacion'
            );
            $this->db->group_start();
            foreach($criterios_search as $criterio) {
                $this->db->or_like($criterio, $search);
            }
            $this->db->group_end();
        }



        if($id_subclasificacion == '32' || $id_subclasificacion == '33' || $id_subclasificacion == '34'){
            $this->db->order_by('id_diseno', 'DESC');
        }else{
            $this->db->order_by('RAND()');
        }

        if($start < 0 || $offset < 0) {
            $this->db->limit(1);
        } else {
            if($start == 1) {
                $start = 0;
            }
            $this->db->limit($offset, $start);
        }


        $plantillas = $this->db->get()->result();

        if(sizeof($plantillas) > 0) {
            foreach($plantillas as $indice_plantilla => $plantilla) {
                $plantillas[$indice_plantilla]->url = 'personalizar/'.$plantilla->id_producto.'/'.$plantilla->id_color.'/'.$plantilla->id_unico;
            }

            return $plantillas;
        } else {
            return array();
        }
    }
    public function contar_plantillas_catalogo($search,$estatus, $id_clasificacion = null, $id_subclasificacion = null, $id_subsubclasificacion = null)
    {
        $this->db->select('COUNT(DisenosGuardados.id_diseno) as total,ClasificacionVentas.nombre_clasificacion,sub.nombre_clasificacion,subsub.nombre_clasificacion')
            ->from('DisenosGuardados')
            ->join('ClasificacionVentas', 'ClasificacionVentas.id_clasificacion = DisenosGuardados.id_clasificacion and ClasificacionVentas.estatus = 1', 'left')
            ->join('ClasificacionVentas sub', 'sub.id_clasificacion = DisenosGuardados.id_subclasificacion and sub.estatus = 1', 'left')
            ->join('ClasificacionVentas subsub', 'subsub.id_clasificacion = DisenosGuardados.id_subsubclasificacion and subsub.estatus = 1', 'left')
        ;

        if($estatus == 'clasificar') {
            $this->db->where('DisenosGuardados.id_clasificacion IS NULL');
        } else if($estatus == 'activas') {
            $this->db->where('DisenosGuardados.id_clasificacion IS NOT NULL');
            if($id_clasificacion) {
                $this->db->where('DisenosGuardados.id_clasificacion', $id_clasificacion);
                if($id_subclasificacion) {
                    $this->db->where('DisenosGuardados.id_subclasificacion', $id_subclasificacion);
                    if($id_subsubclasificacion){
                        $this->db->where('DisenosGuardados.id_subsubclasificacion', $id_subsubclasificacion);
                    }
                }
            }
        }
        if($search !== 'null' && $search !== '') {

            $criterios_search = array(
                'ClasificacionVentas.nombre_clasificacion',
                'sub.nombre_clasificacion',
                'subsub.nombre_clasificacion'
            );
            $this->db->group_start();
            foreach($criterios_search as $criterio) {
                $this->db->or_like($criterio, $search);
            }
            $this->db->group_end();
        }

        if($id_subclasificacion == '32' || $id_subclasificacion == '33' || $id_subclasificacion == '34'){
            $this->db->order_by('id_diseno', 'DESC');
        }else{
            $this->db->order_by('RAND()');
        }

        $total = $this->db->get()->result();

        return $total;
    }
}
