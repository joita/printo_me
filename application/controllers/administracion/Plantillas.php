<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plantillas extends MY_Admin {

	public function __construct()
	{
		parent::__construct();
	}

	public function index($tipo = 'clasificar', $id_clasificacion = null, $id_subclasificacion = null) {
		$datos['seccion_activa'] = 'plantillas';
		$datos['criterio_activo'] = $tipo;
		if(!$id_clasificacion) {
			$datos['plantillas'] = $this->plantillas_m->obtener_plantillas($tipo);
			$datos['clasificaciones'] = $this->clasificacion_m->obtener_clasificaciones_plantillas();
			if($tipo == 'activas') {
				redirect('administracion/plantillas/activas/'.$datos['clasificaciones'][0]->id_clasificacion);
			}
		} else {
			$datos['plantillas'] = $this->plantillas_m->obtener_plantillas($tipo, $id_clasificacion, $id_subclasificacion);
			$datos['id_clasificacion'] = $id_clasificacion;
            $datos['id_subclasificacion'] = $id_subclasificacion;
			$datos['clasificaciones'] = $this->clasificacion_m->obtener_clasificaciones_plantillas();
		}

		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/plantillas/plantillas');
		$this->load->view('administracion/footer');
	}

	public function clasificar()
	{
		$id_plantilla = $this->input->post('id_plantilla');
		$id_clasificacion = $this->input->post('id_clasificacion');

		if($id_plantilla == '' || $id_plantilla == 0 || $id_clasificacion == '' || $id_clasificacion == 0) {
			redirect('administracion/plantillas');
		} else {

            $info_clasificacion = explode("/", $id_clasificacion);

            if(isset($info_clasificacion[1])) {
                $this->db->query("UPDATE DisenosGuardados SET id_clasificacion=".$info_clasificacion[0].", id_subclasificacion=".$info_clasificacion[1]." WHERE id_diseno=".$id_plantilla);
            } else {
                $this->db->query("UPDATE DisenosGuardados SET id_clasificacion=".$info_clasificacion[0].", id_subclasificacion = null WHERE id_diseno=".$id_plantilla);
            }

			redirect('administracion/plantillas/activas/'.$id_clasificacion);
		}
	}

	public function borrar()
	{
		$id_plantilla = $this->input->post('id_plantilla');
		$plantilla_info = $this->plantillas_m->obtener_plantilla($id_plantilla);
		$this->plantillas_m->borrar_plantilla($id_plantilla);

		if($plantilla_info->id_clasificacion != '') {
			redirect('administracion/plantillas/activas/'.$plantilla_info->id_clasificacion);
		} else {
			redirect('administracion/plantillas');
		}
	}
}
