<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiendas extends MY_Admin {

	public function index() {		
		$datos['seccion_activa'] = 'tiendas';
		$datos['scripts'] = 'administracion/tiendas/scripts';
        $datospagina['tiendas'] = $this->tienda_m->obtener_tiendas_vip();

		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/tiendas/index',$datospagina);
		$this->load->view('administracion/footer');
	}

	public function tienda($id_tienda, $tipo_campana = 'limitado') {		
		$datos['seccion_activa'] = 'tiendas';
		$datos['tienda'] = $this->tienda_m->obtener_tiendas($id_tienda)[0];
		$datos['campanas'] = $this->enhance_modelo->obtener_campanas_usuario($datos['tienda']->id_cliente, $tipo_campana);
		$datos['scripts'] = 'administracion/tiendas/scripts';
		$datos['tipo_activo'] = $tipo_campana;
		
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/tiendas/especifica');
		$this->load->view('administracion/footer');
	}

	public function desplegar_tiendas(){
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');
        $orden = $this->input->post('order');
        $tiendas = $this->tienda_m->obtener_tiendas_datatable($limit, $offset, $orden, $search);
        $info = new stdClass();
        $info->draw = $this->input->post('draw');
        $info->recordsTotal = $this->tienda_m->contar_tiendas_datatable(null);
        $info->recordsFiltered = $this->tienda_m->contar_tiendas_datatable($search);

        $info->data = array();
        foreach($tiendas as $tienda){
            $inner_info = new stdClass();
            //seccion $inner_info->id
            $inner_info->id = "<td class='text-center'>". $tienda->id_tienda. "</td>";
            //seccion $inner_info->logo
            $inner_info->logo .= "<td><img src='". site_url('assets/images/trans.png')."'";
            if($tienda->logotipo_chico != '' && file_exists('assets/images/logos/'.$tienda->logotipo_chico)) {
                $inner_info->logo .= " style='background:url(".site_url('assets/images/logos/'.$tienda->logotipo_chico).") no-repeat center center; background-size: contain;'";
            }
            $inner_info->logo .= " width='80' height='80' /></td>";
            //seccion $inner_info->datos_tienda
            $inner_info->datos_tienda = "<td>
									<em>Nombre:</em> ". $tienda->nombre_tienda ."<br/>
									<em>Descripción:</em> ". $tienda->descripcion_tienda ."</br/>
									<em>Vínculo:</em> <a href='". site_url('tienda/1/'.$tienda->nombre_tienda_slug)."' target='_blank'>". site_url('tienda/1/'.$tienda->nombre_tienda_slug)."</a>
								</td>";
            //seccion $innner_info->propietario
            $inner_info->propietario = "<td>". $tienda->nombres.' '.$tienda->apellidos."</td>";
            //seccion $inner_info->productos
            $inner_info->productos = "<td class='text-center'>". $tienda->cantidad."</td>";
            if($tienda->vip == 1){
                $inner_info->vip = "<td class='text-center' ><a data-id_tienda=\"$tienda->id_tienda\" class=\"enabled\"><i class=\"fa fa-toggle-on\"></i> Habilitado</a><input value=\"$tienda->id_tienda\" type=\"hidden\" name=\"id_tienda\" id=\"id_tienda\"></td>";
            }else{
                $inner_info->vip = "<td class='text-center' ><a data-id_tienda=\"$tienda->id_tienda\" class=\"disabled\"><i class=\"fa fa-toggle-off\"></i> Deshabilitado</a><input value=\"$tienda->id_tienda\" type=\"hidden\" name=\"id_tienda\" id=\"id_tienda\"></td>";
            }
            //seccion $inner_info->acciones
            $inner_info->acciones = "<td><a href='". site_url('administracion/tiendas/'.$tienda->id_tienda)."' class='action button'><i class=\"fa fa-search\"></i></a></td>";
            array_push($info->data, $inner_info);
        }
        echo json_encode($info);
    }

    public function desplegar_especifico($tipo_campana = 'limitado', $id_cliente){
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');
        $orden = $this->input->post('order');
        $campanas = $this->enhance_modelo->obtener_campanas_usuario_datatable($limit, $offset, $orden, $search, $id_cliente, $tipo_campana);

        $info = new stdClass();
        $info->draw = $this->input->post('draw');
        $info->recordsTotal = $this->enhance_modelo->contar_campanas(null, $id_cliente, $tipo_campana);
        $info->recordsFiltered = $this->enhance_modelo->contar_campanas($search, $id_cliente, $tipo_campana);

        $info->data = array();
        foreach ($campanas as $campana){
            $inner_info = new stdClass();
            //seccion $inner_info->img
            $inner_info->img .= '<td><span class="hide">'.$campana->id_enhance.'</span><ul class="small-block-grid-2 precamp">';
            if(isset($campana->front_image)){
                $inner_info->img .='<li><img src="'. site_url($campana->front_image).'" class="smmmimg" /></li>';
            }
            if(isset($campana->back_image)){
                $inner_info->img .= '<li><img src="'. site_url($campana->back_image).'" class="smmmimg" /></li>';
            }
            if(isset($campana->right_image)){
                $inner_info->img .= '<li><img src="'. site_url($campana->right_image).'" class="smmmimg" /></li>';
            }
            if(isset($campana->left_image)) {
                $inner_info->img .= '<li><img src="'. site_url($campana->left_image).'" class="smmmimg" /></li>';
            }
            $inner_info->img.= '</ul></td>';
            //seccion $inner_info->datos
            $inner_info->datos .= '<td>
				<em>Folio:</em> <strong>'. $campana->id_enhance.'</strong><br />
				<em>Producto:</em> <strong>'. $campana->name.'</strong>
			</td>';
            //seccion $inner_info->precio
            $inner_info->precio .= '<td class="text-center">$'. $this->cart->format_number($campana->price).'</td>';
            //seccion $inner_info->vendidos
            $inner_info->vendidos .= '<td class="text-center">'. $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance).'</td>';
            //seccion $inner_info->total
            $inner_info->total .= '<td class="text-center">$'. $this->cart->format_number($this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance) * $campana->price).'</td>';
            if($tipo_campana == 'limitado'){
                //seccion $inner_info->meta
                $inner_info->meta .= '<td class="text-center">'. $campana->quantity.'</td>';
                //seccion $inner_info->percent_meta
                $inner_info->percent_meta .= '<td class="text-center">'. number_format(($this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance)/$campana->quantity)*100, 2).'%</td>';
                //seccion $inner_info->quedan
                $inner_info->quedan .= '<td class="text-center">';
                if(!$campana->estatus) {
                    $inner_info->quedan.='<em> Pendiente por revisar </em>';
                }elseif($campana->estatus == 2) {
                    $inner_info->quedan.='<i class="fa fa-times" ></i > Rechazada';
                }elseif($campana->estatus == 3) {
                    $inner_info->quedan.='<i class="fa fa-ban" ></i > Terminada por printome.mx';
                }else{
                    $time_restante = strtotime($campana->end_date)-time();
                    if($time_restante < 0){
                        $inner_info->quedan.='<i class="fa fa-check"></i> Finalizada';
                    }else{
                        $inner_info->quedan.= round((($time_restante/24)/60)/60).'días';
                    };
                }
                $inner_info->quedan .= '</td>';
            }else{
                //seccion $inner_info->activo_desde
                $inner_info->activo_desde .= '<td class="text-center">'. $campana->date.'</td>';
                //seccion $inner_info->vendido
                $inner_info->vendido .= '<td class="text-center">'. $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance).'</td>';
            }
            //seccion $inner_info->estatus
            $inner_info->estatus .= '<td class="text-center">';
            if($campana->estatus == 1){
                if($tipo_campana == 'limitado') {
                    if ($time_restante < 0) {
                        $inner_info->estatus .= '<i class="fa fa-check"></i> Finalizada';
                    } else {
                        $inner_info->estatus .= '<i class="fa fa-line-chart" ></i > Activa';
                    }
                }else{
                    $inner_info->estatus .= '<i class="fa fa-line-chart"></i> Activa';
                }

            }elseif($campana->estatus == 2){
                $inner_info->estatus .= '<i class="fa fa-times"></i> Rechazada';

            }elseif($campana->estatus == 3){
                $inner_info->estatus .= '<i class="fa fa-ban"></i> Terminada por printome.mx';

            }else{
                $inner_info->estatus .= '<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Pendiente';

            }
            $inner_info->estatus .='</td>';
            //seccion $inner_info->acciones
            $inner_info->acciones .= '<td class="text-right">';

            //seccion $inner_info->acciones
            $inner_info->acciones .= '<a href="'. site_url("administracion/campanas/".$tipo_campana."/editar/".$campana->id_enhance).'" class="action button"><i class="fa fa-eye"></i> Revisar </a>';

            if($campana->estatus == 1){
                // check if Vendor Exists for the Client
                $proveedores = $this->db->get_where('proveedores', array('creator_id' => $id_cliente))->row();
                if(count($proveedores) > 0)
                {
                    $inner_info->acciones .= '<a href="'. site_url("administracion/campanas/".$tipo_campana."/post-to-shopify/".$campana->id_enhance).'" style="margin-top: 5px;width: 100%;" class="action button">Exportar a shopify</a>';
                }
            }else{
                // check if Vendor Exists for the Client
                $proveedores = $this->db->get_where('proveedores', array('creator_id' => $id_cliente))->row();
                if(count($proveedores) > 0)
                {
                    $inner_info->acciones .= '<a disabled style="background:#737373 !important; margin-top: 5px;width: 100%;" class="action button">Exportar a shopify</a>';
                }
            }




            $inner_info->acciones .= '</td>';

            array_push($info->data, $inner_info);
        }

        echo json_encode($info);
    }
    /*Inicio habilitar vip*/
    public function cambiar_vip(){
        $id_tienda = $this->input->post('id_tienda');
        $vip = $this->input->post('estatus');

        $tienda = new stdClass();
        $tienda->vip = $vip;

        $this->db->where("id_tienda", $id_tienda);
        $this->db->update("Tiendas", $tienda);
    }
    public function reordenar_tiendas(){
        if(!$this->input->post('data')) {
            return false;
        } else {
            foreach($this->input->post('data') as $posicion => $id_tienda ) {
                $this->db->query("UPDATE Tiendas SET id_orden=".($posicion+1)." WHERE id_tienda=".$id_tienda);
            }
        }
    }
    public function obtener_tiendas_vip(){
        $tiendas['tiendas'] = $this->tienda_m->obtener_tiendas_vip();
        echo json_encode($tiendas);
    }
    /*Fin habilitar vip*/
    /*Inicio metodo de pago para shopify*/
    public function save_metodo_tienda(){
        $id_tienda = $this->input->post('id_tienda');
        $metodo = $this->input->post('metodo');

        $tienda = new stdClass();
        $tienda->tipo_pago = $metodo;

        $this->db->where("id_tienda", $id_tienda);
        $this->db->update("Tiendas", $tienda);


    }
}
