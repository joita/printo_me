<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tienda extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("cart");
        $this->clasificaciones = $this->clasificacion_m->obtener_clasificaciones_plantillas();
        if(!$this->session->tempdata('random_seed')) {
            $this->session->set_tempdata('random_seed', mt_rand(), 1800);
        }
    }

    public function index($tipotienda=1,$nombre_tienda_slug = null, $tipo_campana = null, $pagina = 1)
    {
        $tipo_campana = null;
        if(!$nombre_tienda_slug) {
            show_404();
        }
        $this->load->library('pagination');
        $datos_header['id_cliente'] = $this->tienda_m->obtener_id_dueno($nombre_tienda_slug);
        $datos_header['tienda'] = $this->tienda_m->obtener_tienda_por_id_dueno($datos_header['id_cliente']);

        if(uri_string() == 'tienda/'.$tipotienda.'/'.$nombre_tienda_slug.'/pagina' || uri_string() == 'tienda/'.$nombre_tienda_slug.'compra/pagina/') {
            redirect('tienda/'.$tipotienda.'/'.$nombre_tienda_slug, 'auto', 301);
        }

        if($tipo_campana) {
            if($tipo_campana == 'fijo') { $tipo = '/venta-inmediata/'; $datos_seccion['tipo_activo'] = $tipo_campana; }
            else if($tipo_campana == 'limitado') { $tipo = '/plazo-definido/'; $datos_seccion['tipo_activo'] = $tipo_campana; }
            else if($tipo_campana == 'null') { $tipo = '/'; $datos_seccion['tipo_activo'] = null; }
        } else {
            $tipo = '/'; $datos_seccion['tipo_activo'] = null;
        }
        $datos_seccion['filtros'] = descomponer_filtros($this->input->get('filtros'));

        $config['base_url'] = site_url('tienda').'/'.$tipotienda.'/'.$nombre_tienda_slug.'/'.$tipo.'pagina/';
        if($tipotienda == 2){
            $config['total_rows'] = $this->catalogo_modelo->contar_wow_winner($tipo_campana, $datos_seccion['filtros'], $datos_header['id_cliente']);
            $datos_seccion['clasificaciones2'] = $this->clasificacion_m->obtener_clasificacion_creador_wow_winner($datos_header['id_cliente']);
        }else{
            $config['total_rows'] = $this->catalogo_modelo->contar_enhanced($tipo_campana, $datos_seccion['filtros'], $datos_header['id_cliente']);
            $datos_seccion['clasificaciones2'] = $this->clasificacion_m->obtener_clasificacion_creador($datos_header['id_cliente']);
        }
        $config['first_url'] = site_url('tienda').'/'.$tipotienda.'/'.$nombre_tienda_slug.'/'.$tipo.generar_url_filtro($datos_seccion['filtros']);
        $config['per_page'] = 12;
        $config['suffix'] = generar_url_filtro($datos_seccion['filtros']);
        $this->pagination->initialize($config);

        $start = (($pagina - 1) * $config['per_page'])+1;
        $offset = $config['per_page'];


        // Config
        $datos_header['seccion_activa'] = 'tiendas';
        $datos_header['meta']['title'] = $datos_header['tienda']->nombre_tienda;
        $datos_header['meta']['description'] = $datos_header['tienda']->descripcion_tienda;
        $datos_header['meta']['imagen'] = '';

        $datos_header['nombre_tienda_slug'] = $nombre_tienda_slug;
        $datos_header['tipo_activo'] = $tipo_campana;

        //$datos_seccion['productos'] = $this->tienda_m->obtener_productos($this->tienda_m->obtener_id_dueno($nombre_tienda_slug), $tipo_campana);
        switch ($tipotienda){
            case 1:
                $datos_seccion['productos'] = $this->catalogo_modelo->obtener_enhanced($tipo_campana, $start, $offset, $this->session->tempdata('random_seed'), $datos_seccion['filtros'], null, $datos_header['id_cliente']);
                break;
            case 2:
                $datos_seccion['productos'] = $this->catalogo_modelo->obtener_wow_winner($tipo_campana, $start, $offset, $this->session->tempdata('random_seed'), $datos_seccion['filtros'], null, $datos_header['id_cliente']);
                break;
            case 3:
                $datos_seccion['productos'] = $this->catalogo_modelo->obtener_mas_vendidos($tipo_campana, $start, $offset, $this->session->tempdata('random_seed'), $datos_seccion['filtros'], null, $datos_header['id_cliente']);
                break;
            default:
                $datos_seccion['productos'] = $this->catalogo_modelo->obtener_enhanced($tipo_campana, $start, $offset, $this->session->tempdata('random_seed'), $datos_seccion['filtros'], null, $datos_header['id_cliente']);
        }



        $datos_seccion['paginacion'] = $this->pagination->create_links();

        $datos_seccion['vista'] = 'tienda/catalogo/listado';
        $datos_seccion['scripts'] = 'tienda/catalogo/scripts_tienda';
        //$datos_seccion['clasificaciones'] = $this->clasificacion_m->obtener_clasificaciones_con_disponibles($tipo_campana);

        $datos_seccion['slider'] = $this->catalogo_modelo->obtener_slider_creador($datos_header['id_cliente']);

        $datos_seccion['tipo_tienda'] = $tipotienda;
        $this->load->view('tienda/header', $datos_header);
        $this->load->view('tienda/catalogo/slider_creador', $datos_seccion);
        $this->load->view('tienda/catalogo/general', $datos_seccion);
        //$this->load->view('tienda/catalogo/despliegue_base', $datos_seccion);
        //$this->load->view('inicio/loquedicen');
        $this->load->view('footer');
    }

    public function especifica($nombre_tienda_slug = null, $tipo_campana = null, $id_producto = null) {

        $datos_header['tienda'] = $this->tienda_m->obtener_tienda_por_id_dueno($this->tienda_m->obtener_id_dueno($nombre_tienda_slug));
        $datos_header['id_cliente'] = $this->tienda_m->obtener_id_dueno($nombre_tienda_slug);
        $datos_seccion['producto'] = $this->catalogo_modelo->obtener_enhanced($tipo_campana, -1, -1, null, array(), $id_producto, $datos_header['id_cliente']);
        $datos_header['pixel_campana'] = $datos_seccion['producto'];
        $datos_seccion['scripts'] = 'tienda/catalogo/scripts_tienda';
        $datos_seccion['relacionados'] = $this->catalogo_modelo->obtener_relacionados($datos_header['id_cliente']);

        if(!$datos_seccion['producto']) {
            redirect('tienda/'.$nombre_tienda_slug.'/'.($tipo_producto == 'fijo' ? 'venta-inmediata' : 'plazo-definido'));
        }

        // Config
        $datos_header['seccion_activa'] = 'tienda';
        $datos_header['subseccion_activa'] = $tipo_campana;
        $datos_header['nombre_tienda_slug'] = $nombre_tienda_slug;
        $datos_seccion['tipo_activo'] = $tipo_campana;
        $datos_header['meta']['title'] = '$'.$this->cart->format_number($datos_seccion['producto']->price).' MXN | '.$datos_seccion['producto']->name.' ('.$datos_seccion['producto']->id_enhance.')';
        $datos_header['meta']['description'] = 'Diseño único y original '.$datos_seccion['producto']->name.', no disponible en tiendas fisicas. ('.$datos_seccion['producto']->id_enhance.')';


        $datos_header['meta']['imagen'] = $datos_seccion['producto']->front_image;
        $datos_header['meta']['prefix'] = ' prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#"';
        $datos_header['meta']['type'] = 'product';
        if (strpos(uri_string(), 'pagina') !== false || $this->input->get('filtros') != null) {
            $datos_header['meta']['noindex'] = true;
        }

        $datos_seccion['autor'] = $this->tienda_m->obtener_tienda_por_id_dueno($datos_header['id_cliente']);
        $datos_seccion['colores_disponibles'] = $this->enhance_modelo->obtener_colores_disponibles_por_enhance($id_producto);

        foreach($datos_seccion['colores_disponibles'] as $indice=>$color) {
            $datos_seccion['colores_disponibles'][$indice]->tallas_disponibles = $this->catalogo_modelo->obtener_tallas_por_color($color->id_color);
            foreach($datos_seccion['colores_disponibles'][$indice]->tallas_disponibles as $subindice=>$caracteristica) {
                $datos_seccion['colores_disponibles'][$indice]->tallas_disponibles[$subindice]->caracteristicas = json_decode($caracteristica->caracteristicas);
            }
        }

        $datos_header['meta']['producto_precio'] = number_format($datos_seccion['producto']->price, 2, '.', '');
        $datos_header['meta']['expiracion'] = $datos_seccion['producto']->end_date;

        $this->load->view('tienda/header', $datos_header);
        $this->load->view('tienda/catalogo/despliegue_especifico', $datos_seccion);
        //$this->load->view('inicio/loquedicen');
        $this->load->view('footer');
    }




    public function terminos($nombre_tienda_slug = null)
    {
        if(!$nombre_tienda_slug) {
            show_404();
        }
        // Config
        $datos_header['tienda'] = $this->tienda_m->obtener_tienda_por_id_dueno($this->tienda_m->obtener_id_dueno($nombre_tienda_slug));
        $datos_header['seccion_activa'] = 'terminos-y-condiciones';
        $datos_header['meta']['title'] = 'Revisa nuestros términos y condiciones. | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';

        $datos_header['nombre_tienda_slug'] = $nombre_tienda_slug;

        $this->load->view('tienda/header', $datos_header);
        $this->load->view('inicio/terminos');
        $this->load->view('inicio/loquedicen');
        $this->load->view('tienda/footer');
    }

    public function politicas($nombre_tienda_slug = null)
    {
        if(!$nombre_tienda_slug) {
            show_404();
        }
        // Config
        $datos_header['tienda'] = $this->tienda_m->obtener_tienda_por_id_dueno($this->tienda_m->obtener_id_dueno($nombre_tienda_slug));
        $datos_header['seccion_activa'] = 'politicas-de-compra';
        $datos_header['meta']['title'] = 'Revisa nuestras políticas de compra. | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';

        $datos_header['nombre_tienda_slug'] = $nombre_tienda_slug;

        $this->load->view('tienda/header', $datos_header);
        $this->load->view('inicio/politicas');
        $this->load->view('inicio/loquedicen');
        $this->load->view('tienda/footer');
    }

    public function aviso($nombre_tienda_slug = null)
    {
        if(!$nombre_tienda_slug) {
            show_404();
        }
        // Config
        $datos_header['tienda'] = $this->tienda_m->obtener_tienda_por_id_dueno($this->tienda_m->obtener_id_dueno($nombre_tienda_slug));
        $datos_header['seccion_activa'] = 'aviso-de-privacidad';
        $datos_header['meta']['title'] = 'Revisa nuestro aviso de privacidad. | printome.mx';
        $datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
        $datos_header['meta']['imagen'] = '';

        $datos_header['nombre_tienda_slug'] = $nombre_tienda_slug;

        $this->load->view('tienda/header', $datos_header);
        $this->load->view('inicio/aviso');
        $this->load->view('inicio/loquedicen');
        $this->load->view('tienda/footer');
    }

    public function cerrar_sesion($nombre_tienda_slug = null)
    {
        if(!$nombre_tienda_slug) {
            show_404();
        }
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('direccion_temporal');
        $this->session->unset_userdata('direccion_fiscal_temporal');
        $this->facebook->destroy_session();
        $this->cart->destroy();
        redirect('tienda/'.$nombre_tienda_slug);
    }
}
