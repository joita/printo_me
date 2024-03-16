<!--Creado por Fabiola Medina
Fecha 20/04/2021
Descripción sección Tiendas del nuevo diseño 2021 Adivor-->

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tiendas extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index($vip,$orden,$search,$pagina){

        if($orden === null || $orden === ''){
            $orden = null;
            $ordenurl= 'null/';
        }else{

            $ordenurl = $orden.'/';
        }

        if($search === null || $search === ''){
            $search = null;
            $searchurl = 'null/';
        }else{

            $searchurl = $search.'/';
        }

        // Config
        $this->load->library('pagination');

        $datos_header['seccion_activa'] = 'tiendas';
        $datos_header['meta']['title'] = '¡Personaliza tus playeras con Printome!';
        $datos_header['meta']['description'] = 'Si no sabes que diseño poner en tu playera y necesitas ayuda profesional, nosotros te apoyamos.';
        $datos_header['meta']['imagen'] = '';
        $datos_footer['scripts'] = 'tiendas/scripts';

        $config['base_url'] = site_url('tiendas').'/pagina/'.$vip.'/'.$ordenurl.$searchurl;

        $numero = $this->tienda_m->total_tiendas_general($search,$vip);
        $config['total_rows'] = $numero[0]->total;
        $datos_seccion['total'] = $numero[0]->total;

        $config['first_url'] = site_url('tiendas/'.$vip.'/'.$ordenurl.$searchurl);

        $config['per_page'] = 12;
        $this->pagination->initialize($config);

        $start = (($pagina - 1) * $config['per_page']) + 1;
        $offset = $config['per_page'];

        $datos_seccion['tiendas'] = $this->tienda_m->obtener_tiendas_general_orden($start, $offset,$orden,$search,$vip);
        $datos_seccion['paginacion'] = $this->pagination->create_links();
        $datos_seccion['orden'] = $orden;
        $datos_seccion['search'] = $search;
        $datos_seccion['vip'] = $vip;

        $this->load->view('header', $datos_header);
        $this->load->view('tiendas/index',$datos_seccion);

        $this->load->view('footer', $datos_footer);
    }
    public function tiendas_orden($pagina = 1){
        $search = $this->input->post('search');
        $orden = $this->input->post('id_orden');

        $this->load->library('pagination');
        $config['base_url'] = site_url('tiendas').'/pagina/';
        $numero = $this->tienda_m->total_tiendas_general();

        $config['total_rows'] = $numero[0]->total;
        $datos_seccion['total'] = $numero[0]->total;
        $config['first_url'] = site_url('tiendas');
        $config['per_page'] = 12;
        $this->pagination->initialize($config);

        $start = (($pagina - 1) * $config['per_page']) + 1;
        $offset = $config['per_page'];

        $datos_seccion['tiendas'] = $this->tienda_m->obtener_tiendas_general_orden($start, $offset,$orden,$search);

        $datos_seccion['paginacion'] = $this->pagination->create_links();


        echo json_encode($datos_seccion);
    }
}
