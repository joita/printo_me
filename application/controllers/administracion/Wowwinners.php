<?php
/**
 * Created by PhpStorm.
 * User: Fabiola Medina
 * Date: 26/03/2021
 * Time: 12:53
 */

class Wowwinners extends MY_Controller
{
    public function index() {

        $datos_header['seccion_activa'] = 'wowwinners';
        $datos_footer['scripts'] = 'administracion/wowwinners/scripts';
        $campanas['campanas'] = $this->wowwinners_modelo->obtener_campanas_wow();

        $this->load->view('administracion/header', $datos_header);
        $this->load->view('administracion/wowwinners/index',$campanas);
        $this->load->view('administracion/footer', $datos_footer);
    }
    public function desplegar_campanas(){

        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');

        $orden = $this->input->post('order');
        $campanas = $this->wowwinners_modelo->obtener_campanas_activas($limit, $offset, $orden, $search);

        $info = new stdClass();
        $info->draw = $this->input->post('draw');
        $info->recordsTotal = $this->wowwinners_modelo->contar_campanas_datatable(null);
        $info->recordsFiltered = $this->wowwinners_modelo->contar_campanas_datatable($search);


        $info->data = array();
        foreach($campanas as $campana){
            $inner_info = new stdClass();
            $inner_info->id = "<td class='text-center'>". $campana->id_enhance. "</td>";

            $inner_info->name = "<td>". $campana->name."</td>";

            $inner_info->playera .= "<td><img src='". site_url('assets/images/trans.png')."'";
            if($campana->front_image != '') {
                $inner_info->playera .= " style='background:url(".site_url($campana->front_image).") no-repeat center center; background-size: contain;'";
            }
            $inner_info->playera .= " width='80' height='80' /></td>";

            $inner_info->logo .= "<td><img src='". site_url('assets/images/trans.png')."'";
            if($campana->logotipo_chico != '' && file_exists('assets/images/logos/'.$campana->logotipo_chico)) {
                $inner_info->logo .= " style='background:url(".site_url('assets/images/logos/'.$campana->logotipo_chico).") no-repeat center center; background-size: contain;'";
            }
            $inner_info->logo .= " width='80' height='80' /></td>";
            $inner_info->nombre_tienda = "<td>". $campana->nombre_tienda."</td>";
            $inner_info->cliente = "<td>". $campana->cliente."</td>";
            //seccion $inner_info->productos

            if($campana->wow_winner == 1){
                $inner_info->wow_winner = "<td class='text-center' ><a data-id_enhance=\"$campana->id_enhance\" class=\"tablawow enabled\"><i class=\"fa fa-toggle-on\"></i> Habilitado</a><input value=\"$campana->id_enhance\" type=\"hidden\" name=\"id_enhance\" id=\"id_enhance\"></td>";
            }else{
                $inner_info->wow_winner = "<td class='text-center' ><a data-id_enhance=\"$campana->id_enhance\" class=\"tablawow disabled\"><i class=\"fa fa-toggle-off\"></i> Deshabilitado</a><input value=\"$campana->id_enhance\" type=\"hidden\" name=\"id_enhance\" id=\"id_enhance\"></td>";
            }
            array_push($info->data, $inner_info);
        }
        echo json_encode($info);
    }

    public function obtener_campanas_wow(){
        $campanas['campanas'] = $this->wowwinners_modelo->obtener_campanas_wow();
        echo json_encode($campanas);
    }

    public function reordenar_enhance(){
        if(!$this->input->post('data')) {
            return false;
        } else {
            foreach($this->input->post('data') as $posicion => $id_enhance ) {
                $this->db->query("UPDATE Enhance SET id_orden=".($posicion+1)." WHERE id_enhance=".$id_enhance);
            }
        }
    }



    public function cambiar_wow(){
        $id_enhance = $this->input->post('id_enhance');
        $estatus = $this->input->post('estatus');

        $enhance = new stdClass();
        $enhance->wow_winner = $estatus;
        $enhance->texto_wow = '';
        $enhance->id_orden = 0;

        $this->db->where("id_enhance", $id_enhance);
        $this->db->update("Enhance", $enhance);
    }

    public function editar_enhance(){
        $texto_wow = $this->input->post('texto_wow');
        $id_enhance = $this->input->post('id_enhance');

        $enhance = new stdClass();
        $enhance->texto_wow = $texto_wow;

        $this->db->where("id_enhance", $id_enhance);
        $this->db->update("Enhance", $enhance);


    }

}