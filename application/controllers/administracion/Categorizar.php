<?php
/**
 * Created by PhpStorm.
 * User: javier
 * Date: 2018-12-17
 * Time: 11:00
 */

class Categorizar extends MY_Admin
{
    public function index() {

        $datos_header['seccion_activa'] = 'categorizar';
        $contenido['categorias'] = $this->categoria->obtener_categorias_admin();
        $contenido['clasificaciones'] = $this->clasificacion_m->obtener_clasificaciones_admin();
        $footer_datos['scripts'] = 'administracion/categorizar/scripts';

        $this->load->view('administracion/header', $datos_header);
        $this->load->view('administracion/categorizar/categorizar', $contenido);
        $this->load->view('administracion/footer', $footer_datos);
    }

    public function editar(){
        $clasificacion = new stdClass();
        $id_clasificacion = $this->input->post('id_categoria');
        $clasificacion->nombre_clasificacion = $this->input->post('nombre_categoria');

        $this->db->where('id_clasificacion', $id_clasificacion);
        $this->db->update('ClasificacionVentas', $clasificacion);

        redirect('administracion/categorizar');
    }

    public function agregar(){
        $clasificacion = new stdClass();
        $id_parent = $this->input->post('id_parent');
        $nombreClasificacion = $this->input->post('nombre_categoria');
        $slugClasificacion = slugger($nombreClasificacion);
        $estatus = "1";
        $id_clas = "NULL";

        $clasificacion->nombre_clasificacion = $nombreClasificacion;
        $clasificacion->id_clasificacion = $id_clas;
        $clasificacion->nombre_clasificacion_slug = $slugClasificacion;
        $clasificacion->id_clasificacion_parent = $id_parent;
        $clasificacion->estatus = $estatus;

        $this->db->insert('ClasificacionVentas', $clasificacion);

        redirect('administracion/categorizar');
    }

    public function borrar(){
        $clasificacion = new stdClass();
        $idClas = $this->input->post('id_categoria');
        $clasificacion->estatus = 33;

        $this->db->where('id_clasificacion', $idClas);
        $this->db->update('ClasificacionVentas', $clasificacion);

        redirect('administracion/categorizar');
    }

    public function estatus(){
        $clasificacion = new stdClass();
        $idClass = $this->input->post('id');
        $estatus = $this->input->post('estatus');

        $clasificacion->estatus = $estatus;

        $this->db->where('id_clasificacion', $idClass);
        $this->db->update('ClasificacionVentas', $clasificacion);

        redirect('administracion/categorizar');
    }

}