<?php
/**
 * Created by PhpStorm.
 * User: Javier
 * Date: 21/03/2019
 * Time: 14:03
 */

class Puntos extends MY_Controller
{
    public function index() {
        $datos_header['seccion_activa'] = 'puntos';
        $datos_footer['scripts'] = 'administracion/puntos/scripts';

        $this->load->view('administracion/header', $datos_header);
        $this->load->view('administracion/puntos/index');
        $this->load->view('administracion/footer', $datos_footer);
    }

    public function desplegar_referencias(){
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');
        $orden = $this->input->post('order');

        $referencias = $this->referencias_modelo->obtener_referencias_admin($limit, $offset, $orden, $search);
        $info = new stdClass();
        $info->draw = $this->input->post('draw');
        $info->recordsTotal = $this->referencias_modelo->contar_referencias_admin(null);
        $info->recordsFiltered = $this->referencias_modelo->contar_referencias_admin($search);

        $info->data = array();
        foreach($referencias as $referencia){
            $inner_info = new stdClass();
            //seccion $inner_info->id
            $inner_info->id .= $referencia->id_referencia;
            //seccion $inner_info->nombre
            $inner_info->nombre = "<td>
									<em>Nombre:</em> ". $referencia->nombres." ".$referencia->apellidos ."<br/>
									<em>Email:</em> ". $referencia->email ."</br/>
									</td>";
            //seccion $inner_info->cupon
            $inner_info->cupon .= $referencia->cupon;
            //seccion $innner_info->experiencia
            $inner_info->experiencia .= $referencia->experiencia;
            //seccion $inner_info->puntos
            $inner_info->puntos .= $referencia->puntos;
            //seccion $inner_info->nivel
            $inner_info->nivel .= $referencia->nombre_nivel;
            array_push($info->data, $inner_info);
        }
        echo json_encode($info);
    }
}