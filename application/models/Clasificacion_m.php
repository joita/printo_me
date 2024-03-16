<?php

class Clasificacion_m extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}

	public function obtener_clasificaciones() {
        $this->db->select('ClasificacionVentas.*')
                 ->from('ClasificacionVentas')
                 ->where('ClasificacionVentas.estatus', 1)
                 ->where('ClasificacionVentas.id_clasificacion_parent', 0)
                 ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

        $clasificaciones = $this->db->get()->result();

        if(sizeof($clasificaciones) > 0) {
            foreach($clasificaciones as $indice_clasificacion => $clasificacion) {
                $this->db->select('ClasificacionVentas.*')
                         ->from('ClasificacionVentas')
                         ->where('ClasificacionVentas.estatus', 1)
                         ->where('ClasificacionVentas.id_clasificacion_parent', $clasificacion->id_clasificacion)
                         ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

                $clasificaciones[$indice_clasificacion]->subclasificaciones = $this->db->get()->result();

                if(sizeof($clasificaciones[$indice_clasificacion]->subclasificaciones)> 0){
                    foreach ($clasificaciones[$indice_clasificacion]->subclasificaciones as $indice_sub => $subclas){
                        $this->db->select('ClasificacionVentas.*')
                            ->from('ClasificacionVentas')
                            ->where('ClasificacionVentas.estatus', 1)
                            ->where('ClasificacionVentas.id_clasificacion_parent', $subclas->id_clasificacion)
                            ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

                        $clasificaciones[$indice_clasificacion]->subclasificaciones[$indice_sub]->subsubclasificaciones = $this->db->get()->result();
                    }
                }
            }
            return $clasificaciones;
        } else {
            return array();
        }
	}

    public function obtener_clasificaciones_admin() {
	    $where = "ClasificacionVentas.id_clasificacion_parent = 0 AND ClasificacionVentas.estatus != 33";
        $this->db->select('ClasificacionVentas.*')
            ->from('ClasificacionVentas')
            ->where($where)
            ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

        $clasificaciones = $this->db->get()->result();

        if(sizeof($clasificaciones) > 0) {
            foreach($clasificaciones as $indice_clasificacion => $clasificacion) {
                $this->db->select('ClasificacionVentas.*')
                    ->from('ClasificacionVentas')
                    ->where('ClasificacionVentas.estatus !=', 33)
                    ->where('ClasificacionVentas.id_clasificacion_parent', $clasificacion->id_clasificacion)
                    ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

                $clasificaciones[$indice_clasificacion]->subclasificaciones = $this->db->get()->result();
                if(sizeof($clasificaciones[$indice_clasificacion]->subclasificaciones)> 0){
                    foreach ($clasificaciones[$indice_clasificacion]->subclasificaciones as $indice_sub => $subclas){
                        $this->db->select('ClasificacionVentas.*')
                            ->from('ClasificacionVentas')
                            ->where('ClasificacionVentas.estatus !=', 33)
                            ->where('ClasificacionVentas.id_clasificacion_parent', $subclas->id_clasificacion)
                            ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

                        $clasificaciones[$indice_clasificacion]->subclasificaciones[$indice_sub]->subsubclasificaciones = $this->db->get()->result();
                    }
                }
            }

            return $clasificaciones;
        } else {
            return array();
        }
    }

	public function obtener_clasificacion($id_clasificacion) {
		$clasificaciones_res = $this->db->get_where('ClasificacionVentas', array('id_clasificacion' => $id_clasificacion))->result();

		return $clasificaciones_res[0];
	}

	public function obtener_clasificaciones_con_disponibles($tipo_campana = null, $filtros = array())
	{
		$ifstring = '';
		if(!$tipo_campana || $tipo_campana == 'null') {
			$ifstring = '( `Enhance`.`type` = \'fijo\' OR ( `Enhance`.`type` = \'limitado\' AND `Enhance`.`end_date` >= \''.date("Y-m-d H:i:s").'\' ) )';
		} else {
			if($tipo_campana == 'fijo') {
				$ifstring = '`Enhance`.`type` = \'fijo\'';
			} else if($tipo_campana == 'limitado') {
				$ifstring = '`Enhance`.`type` = \'limitado\' AND `Enhance`.`end_date` >= \''.date("Y-m-d H:i:s").'\' ';
			}
		}
		$this->db->select('ClasificacionVentas.*,
							(SELECT COUNT(Enhance.id_enhance) FROM Enhance
							WHERE Enhance.id_clasificacion=ClasificacionVentas.id_clasificacion
							AND '.$ifstring.'
							AND `Enhance`.`estatus` = 1) AS productos')
				 ->from('ClasificacionVentas')
				 ->where('ClasificacionVentas.estatus', 1)
                 ->where('ClasificacionVentas.id_clasificacion_parent', 0)
				 ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

		$clasificaciones = $this->db->get()->result();

        foreach($clasificaciones as $indice_clasificacion => $clasificacion) {
            $this->db->select('ClasificacionVentas.*,
    							(SELECT COUNT(Enhance.id_enhance) FROM Enhance
    							WHERE Enhance.id_clasificacion='.$clasificacion->id_clasificacion.'
                                AND Enhance.id_subclasificacion=ClasificacionVentas.id_clasificacion
    							AND '.$ifstring.'
    							AND `Enhance`.`estatus` = 1) AS productos')
    				 ->from('ClasificacionVentas')
    				 ->where('ClasificacionVentas.estatus', 1)
                     ->where('ClasificacionVentas.id_clasificacion_parent', $clasificacion->id_clasificacion)
    				 ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

            $clasificaciones[$indice_clasificacion]->subclasificaciones = $this->db->get()->result();
            if(sizeof($clasificaciones[$indice_clasificacion]->subclasificaciones)> 0) {
                foreach ($clasificaciones[$indice_clasificacion]->subclasificaciones as $indice_sub => $subsubclasificacion) {
                    $this->db->select('ClasificacionVentas.*,
                                    (SELECT COUNT(Enhance.id_enhance) FROM Enhance
                                    WHERE Enhance.id_subclasificacion=' . $subsubclasificacion->id_clasificacion . '
                                    AND Enhance.id_subsubclasificacion=ClasificacionVentas.id_clasificacion
                                    AND ' . $ifstring . '
                                    AND `Enhance`.`estatus` = 1) AS productos')
                        ->from('ClasificacionVentas')
                        ->where('ClasificacionVentas.estatus', 1)
                        ->where('ClasificacionVentas.id_clasificacion_parent', $subsubclasificacion->id_clasificacion)
                        ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

                    $clasificaciones[$indice_clasificacion]->subclasificaciones[$indice_sub]->subsubclasificaciones = $this->db->get()->result();
                }
            }
        }

        foreach($clasificaciones as $indice_clasificacion => $clasificacion) {
            $clasificaciones[$indice_clasificacion]->subproductos = 0;
            if(sizeof($clasificacion->subclasificaciones) > 0) {
                foreach($clasificacion->subclasificaciones as $indice_subclasificacion => $subclasificacion) {
                    $clasificaciones[$indice_clasificacion]->subproductos += $subclasificacion->productos;
                    $clasificacion->subclasificaciones[$indice_subclasificacion]->subsubproductos = 0;
                    if(sizeof($subclasificacion->subsubclasificaciones)>0){
                        foreach($subclasificacion->subsubclasificaciones as $indice_subsubclas => $subsubclasificacion){
                            $clasificacion->subclasificaciones[$indice_subclasificacion]->subsubproductos += $subsubclasificacion->productos;
                            $clasificaciones[$indice_clasificacion]->subproductos += $subsubclasificacion->productos;
                        }
                    }
                }
            }
        }
		return $clasificaciones;
	}

	public function obtener_clasificaciones_plantillas() {
		$this->db->select('ClasificacionVentas.*, (SELECT COUNT(DisenosGuardados.id_diseno) FROM DisenosGuardados WHERE DisenosGuardados.id_clasificacion=ClasificacionVentas.id_clasificacion) AS plantillas')
				 ->from('ClasificacionVentas')
				 ->where('ClasificacionVentas.estatus', 1)
                 ->where('ClasificacionVentas.id_clasificacion_parent', 0)
				 ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

		$clasificaciones = $this->db->get()->result();

        if(sizeof($clasificaciones) > 0) {
            foreach($clasificaciones as $indice_clasificacion => $clasificacion) {
                $this->db->select('ClasificacionVentas.*, (SELECT COUNT(DisenosGuardados.id_diseno) FROM DisenosGuardados WHERE DisenosGuardados.id_clasificacion='.$clasificacion->id_clasificacion.' AND DisenosGuardados.id_subclasificacion=ClasificacionVentas.id_clasificacion) AS plantillas')
        				 ->from('ClasificacionVentas')
        				 ->where('ClasificacionVentas.estatus', 1)
                         ->where('ClasificacionVentas.id_clasificacion_parent', $clasificacion->id_clasificacion)
        				 ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

                $clasificaciones[$indice_clasificacion]->subclasificaciones = $this->db->get()->result();
                if(sizeof($clasificaciones[$indice_clasificacion]->subclasificaciones) > 0) {
                    foreach($clasificaciones[$indice_clasificacion]->subclasificaciones as $indice_subclasificacion => $subclas) {
                        $this->db->select('ClasificacionVentas.*, (SELECT COUNT(DisenosGuardados.id_diseno) FROM DisenosGuardados WHERE DisenosGuardados.id_clasificacion='.$clasificacion->id_clasificacion.' AND DisenosGuardados.id_subsubclasificacion=ClasificacionVentas.id_clasificacion) AS plantillas')
                            ->from('ClasificacionVentas')
                            ->where('ClasificacionVentas.estatus', 1)
                            ->where('ClasificacionVentas.id_clasificacion_parent', $subclas->id_clasificacion)
                            ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

                        $clasificaciones[$indice_clasificacion]->subclasificaciones[$indice_subclasificacion]->subsubclasificaciones = $this->db->get()->result();
                    }
                }
            }

            foreach($clasificaciones as $indice_clasificacion => $clasificacion) {
                foreach($clasificacion->subclasificaciones as  $indice_subclasificacion => $subclasificacion) {
                    $clasificaciones[$indice_clasificacion]->plantillas -= $subclasificacion->plantillas;
                    $clasificaciones[$indice_clasificacion]->subplantillas += $subclasificacion->plantillas;
                    if(sizeof($clasificaciones[$indice_clasificacion]->subclasificaciones[$indice_subclasificacion]->subsubclasificaciones)>0) {
                        foreach ($subclasificacion->subsubclasificaciones as $indice_subsubclas => $subsubclas) {
                            $clasificaciones[$indice_clasificacion]->subclasificaciones[$indice_subclasificacion]->plantillas -= $subsubclas->plantillas;
                            $clasificaciones[$indice_clasificacion]->subclasificaciones[$indice_subclasificacion]->subplantillas += $subsubclas->plantillas;
                        }
                    }
                }
            }
    		return $clasificaciones;
        } else {
            return array();
        }
	}
    public function obtener_clasificacion_creador($id_creador)
    {
        $this->db->select('DISTINCT (ClasificacionVentas.id_clasificacion) as id_clasificacion, ClasificacionVentas.nombre_clasificacion,
        ClasificacionVentas.nombre_clasificacion_slug,ClasificacionVentas.id_clasificacion_parent, ClasificacionVentas.estatus')
            ->from('ClasificacionVentas')
            ->join('Enhance','Enhance.id_clasificacion = ClasificacionVentas.id_clasificacion')
            ->where('ClasificacionVentas.estatus', 1)
            ->where('Enhance.estatus', 1)
            ->where('Enhance.id_cliente', $id_creador)
            ->where('ClasificacionVentas.id_clasificacion_parent', 0)
            ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

        $clasificaciones = $this->db->get()->result();

        return $clasificaciones;
    }
    public function obtener_clasificacion_creador_wow_winner($id_creador)
    {
        $this->db->select('DISTINCT (ClasificacionVentas.id_clasificacion) as id_clasificacion, ClasificacionVentas.nombre_clasificacion,
        ClasificacionVentas.nombre_clasificacion_slug,ClasificacionVentas.id_clasificacion_parent, ClasificacionVentas.estatus')
            ->from('ClasificacionVentas')
            ->join('Enhance','Enhance.id_clasificacion = ClasificacionVentas.id_clasificacion')
            ->where('ClasificacionVentas.estatus', 1)
            ->where('Enhance.estatus', 1)
            ->where('Enhance.wow_winner', 1)
            ->where('Enhance.id_cliente', $id_creador)
            ->where('ClasificacionVentas.id_clasificacion_parent', 0)
            ->order_by('ClasificacionVentas.nombre_clasificacion', 'ASC');

        $clasificaciones = $this->db->get()->result();

        return $clasificaciones;
    }
}
