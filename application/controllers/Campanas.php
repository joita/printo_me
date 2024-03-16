<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campanas extends MY_Controller {

	private $clasificaciones;

	public function __construct()
	{
		parent::__construct();
		//$this->clasificaciones = $this->clasificacion_m->obtener_clasificaciones_plantillas();
		$this->load->helper("cart");
		if(!$this->session->tempdata('random_seed')) {
			$this->session->set_tempdata('random_seed', mt_rand(), 1800);
		}

		if(uri_string() == 'compra/pagina' || uri_string() == 'compra/pagina/') {
			redirect('compra', 'auto', 301);
		}
	}

	public function index($tipo_campana = null, $pagina = 1){
		$this->load->library('pagination');
		if($tipo_campana) {
			if($tipo_campana == 'fijo') { $tipo = '/venta-inmediata/'; $datos_seccion['tipo_activo'] = $tipo_campana; }
			else if($tipo_campana == 'limitado') { $tipo = '/plazo-definido/'; $datos_seccion['tipo_activo'] = $tipo_campana; }
			else if($tipo_campana == 'null') { $tipo = '/'; $datos_seccion['tipo_activo'] = null; }
		} else {
			$tipo = '/'; $datos_seccion['tipo_activo'] = null;
		}
		$datos_seccion['filtros'] = descomponer_filtros($this->input->get('filtros'));

		$config['base_url'] = base_url().'compra'.$tipo.'pagina/';
		$config['total_rows'] = $this->catalogo_modelo->contar_enhanced($tipo_campana, $datos_seccion['filtros']);
		$config['first_url'] = base_url().'compra'.$tipo.generar_url_filtro($datos_seccion['filtros']);
		$config['per_page'] = 12;
		$config['suffix'] = generar_url_filtro($datos_seccion['filtros']);
		$this->pagination->initialize($config);

		$start = (($pagina - 1) * $config['per_page'])+1;
		$offset = $config['per_page'];

		// Config
		$datos_header['seccion_activa'] = 'compra';
		$datos_header['subseccion_activa'] = $tipo_campana;
		$datos_header['meta']['title'] = 'Diseña, personaliza y vende playeras en minutos';
		$datos_header['meta']['description'] = 'Nunca había sido tan fácil vender tus diseños de playera, aprovecha el crowd funding para vender camisetas y hacer dinero sin tener que invertir un centavo.';
		$datos_header['meta']['imagen'] = '';
		if (strpos(uri_string(), 'pagina') !== false || $this->input->get('filtros') != null) {
		    $datos_header['meta']['noindex'] = true;
		}

		$datos_seccion['productos'] = $this->catalogo_modelo->obtener_enhanced($tipo_campana, $start, $offset, $this->session->tempdata('random_seed'), $datos_seccion['filtros']);
		$datos_seccion['vista'] = 'campanas/listado';
		$datos_seccion['scripts'] = 'campanas/scripts_campana';
		$datos_seccion['paginacion'] = $this->pagination->create_links();
		$datos_seccion['clasificaciones'] = $this->clasificacion_m->obtener_clasificaciones_con_disponibles($tipo_campana);

		$this->load->view('header', $datos_header);
		$this->load->view('campanas/despliegue_base', $datos_seccion);
		//$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
	}

	public function especifica($tipo_campana, $id_campana)
	{
		$datos_seccion['campana'] = $this->catalogo_modelo->obtener_enhanced($tipo_campana, -1, -1, null, array(), $id_campana);
		$datos_header['pixel_campana'] = $datos_seccion['campana'];
		$datos_seccion['scripts'] = 'campanas/scripts_campana';

        $datos_seccion['disenos_similares'] = $this->catalogo_modelo->obtener_enhanced($tipo_campana, 1, 4, mt_rand(), array('idClasificacion' => $datos_seccion['campana']->id_clasificacion), null, null, $id_campana);

        if($datos_seccion['campana']->id_producto == 42){
            $this->db->select("*")->from("StockProducts")->where("id_enhance", $id_campana);
            $datos_seccion['tallas_stock'] = $this->db->get()->row();
        }

        if($id_campana == 34924 || $id_campana == 34925){
            $datos_seccion['tallas_cb'] = $this->productos_modelo->obtener_skus_activos_por_color($datos_seccion['campana']->id_color, $id_sku = null);
        }

        $etiquetas = explode(',', $datos_seccion['campana']->etiquetas);
        $matches  = preg_grep ('/^Pareja[0-9]/i', $etiquetas);
        $matches = array_values($matches);

        if(sizeof($matches) > 0) {
            $criterio = $matches[0];
            $datos_seccion['disenos_adjuntos'] = $this->catalogo_modelo->obtener_misma_etiqueta($criterio, $datos_seccion['campana']->id_enhance);
        }

        if(!$this->session->tempdata('visitado')) {
            $this->db->query('UPDATE Enhance SET visitas=visitas+1 WHERE Enhance.id_enhance='.$id_campana);
            $visitado = true;
            $this->session->set_tempdata('visitado', $id_campana, 120);
        } else {
            if($this->session->tempdata('visitado') != $id_campana) {
                $this->db->query('UPDATE Enhance SET visitas=visitas+1 WHERE Enhance.id_enhance='.$id_campana);
                $visitado = true;
                $this->session->set_tempdata('visitado', $id_campana, 120);
            }
        }

		if(!$datos_seccion['campana']) {
			redirect('compra/'.($tipo_campana == 'fijo' ? 'venta-inmediata' : 'plazo-definido'));
		}

		// Config
		$datos_header['seccion_activa'] = 'compra';
		$datos_header['subseccion_activa'] = $tipo_campana;
		$datos_seccion['tipo_activo'] = $tipo_campana;
		$datos_header['meta']['title'] = '$'.$this->cart->format_number($datos_seccion['campana']->price).' MXN | '.$datos_seccion['campana']->name.' ('.$datos_seccion['campana']->id_enhance.')';
		$datos_header['meta']['description'] = 'Diseño único y original '.$datos_seccion['campana']->name.', no disponible en tiendas fisicas. ('.$datos_seccion['campana']->id_enhance.')';
		$datos_header['meta']['imagen'] = $datos_seccion['campana']->front_image;
		$datos_header['meta']['prefix'] = ' prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#"';
		$datos_header['meta']['type'] = 'product';

		$datos_seccion['autor'] = $this->tienda_m->obtener_tienda_por_id_dueno($this->enhance_modelo->obtener_id_cliente($id_campana));
		$datos_seccion['colores_disponibles'] = $this->enhance_modelo->obtener_colores_disponibles_por_enhance($id_campana);

        $datos_seccion['testimonios'] = $this->testimonios_m->obtener_testimonios_random($id_campana);

		foreach($datos_seccion['colores_disponibles'] as $indice=>$color) {
			$datos_seccion['colores_disponibles'][$indice]->tallas_disponibles = $this->catalogo_modelo->obtener_tallas_por_color($color->id_color);
			foreach($datos_seccion['colores_disponibles'][$indice]->tallas_disponibles as $subindice=>$caracteristica) {
				$datos_seccion['colores_disponibles'][$indice]->tallas_disponibles[$subindice]->caracteristicas = json_decode($caracteristica->caracteristicas);
			}
		}

		$datos_header['meta']['producto_precio'] = number_format($datos_seccion['campana']->price, 2, '.', '');
		$datos_header['meta']['expiracion'] = $datos_seccion['campana']->end_date;

		$this->load->view('header', $datos_header);
		$this->load->view('campanas/despliegue_especifico', $datos_seccion);
        $this->load->view('inicio/testimonios_plug');
        //$this->load->view('inicio/loquedicen');
        if(sizeof($datos_seccion['disenos_similares']) > 0) {
		    $this->load->view('campanas/disenos_similares');
        }
		$this->load->view('footer');
	}

	public function definir_metas()
	{
		$enhance = $this->session->userdata('enhance');
		if(is_null($enhance)) {
			redirect('compra');
		}

		// Config
		$datos_header['seccion_activa'] = 'vende';
		$datos_header['meta']['title'] = 'Define tus metas de venta | printome.mx';
		$datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
		$datos_header['meta']['imagen'] = '';
		$datos_header['mouseflow'] = true;

		$datos_seccion['clasificaciones'] = $this->clasificacion_m->obtener_clasificaciones();

		$datos_seccion['enhance'] = $enhance;
		if($enhance->diseno->color != 'FFFFFF' && $enhance->diseno->color != 'A8A4A4' && !$enhance->esBlanca) {
			$datos_seccion['otros_colores'] = $this->catalogo_modelo->obtener_colores_adicionales($enhance->id_producto, $enhance->diseno->id_color);
		}

        if($this->session->has_userdata('login')) {
            $id_cliente =  $this->session->login['id_cliente'];
            $info_pago = $this->cuenta_modelo->obtener_dato_deposito_por_cliente($id_cliente);
            $this->session->set_userdata('info_pago', $info_pago);
        }else{
            $this->session->unset_userdata('info_pago');
        }

		$datos_footer['scripts'] = 'scripts/costo_campana';

		$this->load->view('header', $datos_header);
		$this->load->view('campanas/definir_metas', $datos_seccion);
		//$this->load->view('inicio/loquedicen');
		$this->load->view('footer', $datos_footer);
	}

    public function registrar_datos_deposito() {
        $info = $this->input->post('info_pago');

        $info_pago_nuevo = new stdClass();

        if($info['tipo_pago'] == 'banco') {
            $info_pago_nuevo->tipo_pago = 'banco';
            $info_pago_nuevo->datos_json = new stdClass();
            $info_pago_nuevo->datos_json->nombre_cuentahabiente = $info['nombre_cuentahabiente'];
            $info_pago_nuevo->datos_json->nombre_banco = $info['nombre_banco'];
            $info_pago_nuevo->datos_json->clabe = $info['clabe'];
            $info_pago_nuevo->datos_json->cuenta = $info['cuenta'];
            $info_pago_nuevo->datos_json->ciudad = $info['ciudad'];
            $info_pago_nuevo->datos_json->sucursal = $info['sucursal'];
            $info_pago_nuevo->estatus = 1;
            $info_pago_nuevo->fecha_agregado = date("Y-m-d H:i:s");
            $info_pago_nuevo->id_cliente = $info['id_cliente'];

            $info_pago_nuevo->datos_json = json_encode($info_pago_nuevo->datos_json);
        } else if($info['tipo_pago'] == 'paypal') {
            $info_pago_nuevo->tipo_pago = 'paypal';
            $info_pago_nuevo->datos_json = new stdClass();
            $info_pago_nuevo->datos_json->cuenta_paypal = $info['cuenta_paypal'];
            $info_pago_nuevo->estatus = 1;
            $info_pago_nuevo->fecha_agregado = date("Y-m-d H:i:s");
            $info_pago_nuevo->id_cliente = $info['id_cliente'];

            $info_pago_nuevo->datos_json = json_encode($info_pago_nuevo->datos_json);
        }

        if($this->db->insert('DatosDepositoPorCliente', $info_pago_nuevo)){
            $datos['estatus'] = "verificado";
            $datos['mensaje'] = "Tus datos de depósito han sido guardados exitosamente!";
        }else{
            $datos['estatus'] = "error";
            $datos['mensaje'] = "Ocurrio un error favor de intentarlo nuevamente.";
        }
        echo json_encode($datos);
    }


	public function generar_otro_color()
	{
		if(!$this->session->has_userdata('enhances_adicionales')) {
			$this->session->set_userdata('enhances_adicionales', array());
		}
		$enhances_adicionales = $this->session->enhances_adicionales;

		$this->load->model('product_m');
		$enhance = $this->session->userdata('enhance');
		$id_producto = $this->input->post('id_producto');
		$id_color = $this->input->post('id_color');
		$color = $this->catalogo_modelo->obtener_color_por_id($id_color);
		$mi_color = str_replace('#', '', $color->codigo_color);

		if($id_producto == '' || $id_color == '') {
			return false;
		}

		$design_info = $this->product_m->getProductDesign($id_producto);
		$design_info->color_hex = json_decode($design_info->color_hex);
		$design_info->color_title = json_decode($design_info->color_title);
		$design_info->front = json_decode($design_info->front);
		$design_info->back = json_decode($design_info->back);
		$design_info->left = json_decode($design_info->left);
		$design_info->right = json_decode($design_info->right);

		$mi_indice = 0;
		$mismo_diseno = md5(time());

		foreach($design_info->color_hex as $indice_color_hex => $color_hex) {
			if($color_hex == $mi_color) {
				$mi_indice = $indice_color_hex;
			}
		}

		foreach($design_info->color_hex as $indice_color_hex => $color_hex) {
			if($color_hex != $mi_color) {
				unset($design_info->color_hex[$indice_color_hex]);
				unset($design_info->color_title[$indice_color_hex]);
				unset($design_info->front[$indice_color_hex]);
				unset($design_info->back[$indice_color_hex]);
				unset($design_info->left[$indice_color_hex]);
				unset($design_info->right[$indice_color_hex]);
			}
		}

		$design_info->front[$mi_indice] = json_decode(str_replace("'",'"',$design_info->front[$mi_indice]));
		$design_info->back[$mi_indice] = json_decode(str_replace("'",'"',$design_info->back[$mi_indice]));
		$design_info->left[$mi_indice] = json_decode(str_replace("'",'"',$design_info->left[$mi_indice]));
		$design_info->right[$mi_indice] = json_decode(str_replace("'",'"',$design_info->right[$mi_indice]));
		$design_info->area = json_decode($design_info->area);
		$design_info->area->front = json_decode(str_replace("'",'"',$design_info->area->front));
		$design_info->area->back = json_decode(str_replace("'",'"',$design_info->area->back));
		$design_info->area->left = json_decode(str_replace("'",'"',$design_info->area->left));
		$design_info->area->right = json_decode(str_replace("'",'"',$design_info->area->right));
		$design_info->params = json_decode($design_info->params);

		// Generar imagen delantera
		if(isset($enhance->dibujos->front)) {
			$design['images']['front'] = generar_imagen_imagick(
				$design_info->front[$mi_indice]->{1}->img, $enhance->dibujos->front, $design_info->area->front->width, $design_info->area->front->height, $design_info->area->front->left, $design_info->area->front->top, 'front', $mismo_diseno, $id_color
			);
		} else {
			$design['images']['front'] = generar_imagen_vacia_imagick(
				$design_info->front[$mi_indice]->{1}->img, 'front', $mismo_diseno, $id_color
			);
		}
		// Generar imagen trasera
		if(isset($enhance->dibujos->back)) {
			$design['images']['back'] = generar_imagen_imagick(
				$design_info->back[$mi_indice]->{1}->img, $enhance->dibujos->back, $design_info->area->back->width, $design_info->area->back->height, $design_info->area->back->left, $design_info->area->back->top, 'back', $mismo_diseno, $id_color
			);
		} else {
			$design['images']['back'] = generar_imagen_vacia_imagick(
				$design_info->back[$mi_indice]->{1}->img, 'back', $mismo_diseno, $id_color
			);
		}
		// Generar imagen izquierda
		if(isset($enhance->dibujos->left)) {
			$design['images']['left'] = generar_imagen_imagick(
				$design_info->left[$mi_indice]->{1}->img, $enhance->dibujos->left, $design_info->area->left->width, $design_info->area->left->height, $design_info->area->left->left, $design_info->area->left->top, 'left', $mismo_diseno, $id_color
			);
		} else {
			$design['images']['left'] = generar_imagen_vacia_imagick(
				$design_info->left[$mi_indice]->{1}->img, 'left', $mismo_diseno, $id_color
			);
		}
		// Generar imagen derecha
		if(isset($enhance->dibujos->right)) {
			$design['images']['right'] = generar_imagen_imagick(
				$design_info->right[$mi_indice]->{1}->img, $enhance->dibujos->right, $design_info->area->right->width, $design_info->area->right->height, $design_info->area->right->left, $design_info->area->right->top, 'right', $mismo_diseno, $id_color
			);
		} else {
			$design['images']['right'] = generar_imagen_vacia_imagick(
				$design_info->right[$mi_indice]->{1}->img, 'right', $mismo_diseno, $id_color
			);
		}

		$enhance_adicional = new stdClass();
		$enhance_adicional->id_producto = $id_producto;
		$enhance_adicional->id_color = $id_color;
		$enhance_adicional->front_image = $design['images']['front'];
		$enhance_adicional->back_image = $design['images']['back'];
		$enhance_adicional->right_image = $design['images']['right'];
		$enhance_adicional->left_image = $design['images']['left'];

		array_push($enhances_adicionales, $enhance_adicional);
		$this->session->set_userdata('enhances_adicionales', $enhances_adicionales);

		echo '<div class="row small-up-4 medium-up-2 large-up-4 xlarge-up-4 thumbis-definir" data-fila-id_color="'.$id_color.'">';
		foreach ($design['images'] as $key => $side) {
		echo '<div class="column">
				<div class="lado-container">
					<img src="'.site_url($side).'" alt="Vista previa de la playera">
					<span class="lado">'.($key == "front" ? 'Frente' : '').
						($key == "back" ? 'Atrás' : '').
						($key == "right" ? 'Manga derecha' : '').
						($key == "left" ? 'Manga izquierda' : '').'</span>
				</div>
			</div>';
		} echo '
		</div>';
	}

	public function borrar_color_no_usado()
	{
		foreach($this->input->post('borrar') as $imagen) {
			unlink($imagen);
		}

		$enhances_adicionales = $this->session->enhances_adicionales;
		foreach($enhances_adicionales as $indice_adicional => $enhance_adicional) {
			if($enhance_adicional->id_color == $this->input->post('id_color')) {
				unset($enhances_adicionales[$indice_adicional]);
			}
		}
		$this->session->set_userdata('enhances_adicionales', $enhances_adicionales);
	}

	public function guardar() {
		$precio_establecido = $this->input->post('price', TRUE);
		$cantidad           = $this->input->post('quantity', TRUE);
		$dias           	= $this->input->post('dias', TRUE);
		$userdata           = $this->session->userdata('enhance');

		$enhance = new StdClass();
        $enhance->id_clasificacion = $userdata->custom->id_clasificacion;
        $enhance->id_subclasificacion = $userdata->custom->id_subclasificacion;
        $enhance->id_subsubclasificacion = $userdata->custom->id_subsubclasificacion;

		$date     = strtotime("now");
		$end_date = strtotime("+" . $dias . "days");

		$id_cliente = $this->session->userdata('login')["id_cliente"];

		$enhance->name        = trim($userdata->custom->name);
		$enhance->description = trim($userdata->custom->description);
		$enhance->etiquetas   = trim($userdata->custom->etiquetas);
		$enhance->type		  = $userdata->custom->type;
		$enhance->design      = $userdata->diseno->vector;
		$enhance->id_producto = $userdata->id_producto;
		$enhance->costo		  = $this->input->post('costo');
		$enhance->price       = $this->input->post('costoplayera');
		$enhance->quantity    = $this->input->post('quantity');
		$enhance->sold        = 0;
		$enhance->front_image = $userdata->diseno->images["front"];
		$enhance->back_image  = $userdata->diseno->images["back"];
		$enhance->right_image = $userdata->diseno->images["right"];
		$enhance->left_image  = $userdata->diseno->images["left"];
		$enhance->date        = date('Y-m-d H:i:s', $date);
		$enhance->end_date    = date('Y-m-d H:i:s', $end_date);
		$enhance->days   	  = $userdata->custom->days;
		$enhance->id_cliente  = $id_cliente;
		$enhance->id_color    = $userdata->diseno->id_color;
		$enhance->colores	  = json_encode($userdata->diseno->colores);

		if($enhance->name == '' || strlen($enhance->description) < 50 || $enhance->id_clasificacion == '') {
			redirect('vende/definir-metas?error=informacion');
		}

		if($enhance->costo == 0 || $enhance->costo == '') {
			$color = $this->db->get_where('ColoresPorProducto', array('id_color' => $enhance->id_color))->row();

			if($color->codigo_color == '#FFFFFF') {
				$esBlanca = true;
			} else {
				$esBlanca = false;
			}

			$base_estimacion = $enhance->quantity;
			$colores_lados = json_decode($enhance->colores, TRUE);

			$enhance->costo = getCost(array('front' => sizeof($colores_lados['front']), 'back' => sizeof($colores_lados['back']), 'left' => sizeof($colores_lados['left']), 'right' => sizeof($colores_lados['right'])), $esBlanca, $base_estimacion, $color->precio);
		}
		$this->db->insert("Enhance", $enhance);
		$enhance_id = $this->db->insert_id();

		if($this->session->has_userdata('enhances_adicionales')) {
			$enhances_adicionales = array();
			foreach($this->session->enhances_adicionales as $enhance_adicional) {
				$enhance_nuevo = clone $enhance;
				$enhance_nuevo->front_image = $enhance_adicional->front_image;
				$enhance_nuevo->back_image = $enhance_adicional->back_image;
				$enhance_nuevo->left_image = $enhance_adicional->left_image;
				$enhance_nuevo->right_image = $enhance_adicional->right_image;
				$enhance_nuevo->id_color = $enhance_adicional->id_color;
				$enhance_nuevo->id_parent_enhance = $enhance_id;

				array_push($enhances_adicionales, $enhance_nuevo);
			}
		}

        if(sizeof($enhances_adicionales) > 0) {
    		foreach($enhances_adicionales as $enhance_adicional) {
    			$this->db->insert("Enhance", $enhance_adicional);
    		}
        }

        if($enhance->id_producto == 42){
            $stock_stuff = new stdClass();
            $stock_stuff->XS_stock = $this->input->post("xs_stock");
            $stock_stuff->S_stock = $this->input->post("s_stock");
            $stock_stuff->M_stock = $this->input->post("m_stock");
            $stock_stuff->L_stock = $this->input->post("l_stock");
            $stock_stuff->XL_stock = $this->input->post("xl_stock");
            $stock_stuff->id_enhance = $enhance_id;
            $this->db->insert("StockProducts", $stock_stuff);
        }

        $tienda = $this->tienda_m->obtener_tienda_por_id_dueno($this->session->login['id_cliente']);


		$datos_correo = new stdClass();
		$datos_correo->nombre_campana = $enhance->name;
		$datos_correo->imagen_principal = $enhance->front_image;
        $datos_correo->precio = $enhance->price;
        $datos_correo->nombre_persona = $this->session->login['nombre'];
        $datos_correo->nombre_tienda = $tienda->nombre_tienda;

		// Se inicializa Sendgrid
		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
		$email = new SendGrid\Email();
		$email->addTo('administracion@printome.mx', 'Administración printome.mx')
			  ->addTo('hello@printome.mx', 'Atención a Clientes printome.mx')
			  ->setFrom('no-reply@printome.mx')
			  ->setFromName('Sitio web printome.mx')
			  ->setSubject('Se ha creado un producto nuevo. | printome.mx')
			  ->setHtml($this->load->view('plantillas_correos/nuevas/admin_aviso_venta_nueva', $datos_correo, TRUE))
		;
		$sendgrid->send($email);

		// We destroy the session
		$this->session->unset_userdata('enhance');
		$this->session->unset_userdata('enhances_adicionales');
		$this->session->unset_userdata('diseno_temp');

		redirect("vende/en-proceso-".($enhance->type == 'fijo' ? 'venta-inmediata' : 'plazo-definido'));
	}

	public function en_proceso()
	{
		// Config
		$datos_header['seccion_activa'] = 'vende';
		$datos_header['meta']['title'] = 'Tu producto está en proceso de revisión | printome.mx';
		$datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
		$datos_header['meta']['imagen'] = '';

		$this->load->view('header', $datos_header);
		$this->load->view('campanas/revision');
		//$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
	}

	// Creamos la campaña
	public function iniciar(){
		$data = $this->input->post();
		$this->session->unset_userdata('enhances_adicionales');

		$fonts = array();

		// Procesamos los vectores
		$vectors = json_decode($data['design']['vectors']);
		foreach (get_object_vars($vectors) as $key => $value) {
			$new_side = [];
			foreach (get_object_vars($value) as $k => $v) {
				if(isset($v->{'fontFamily'})) {
					if($v->{'fontFamily'} != "") $fonts[] = $v->{'fontFamily'};
				}
				$v->{'svg'} = htmlentities($v->{'svg'});
				$new_side[] = $v;
			}
			$vectors->{$key} = $new_side;
		}

		$data['fonts']             = $fonts;
		$data['design']['vectors'] = $vectors;


		// get data post
		$product_id   = $data['product_id'];

		//buscamos el producto
		$product = $this->catalogo_modelo->obtener_producto_con_id($product_id);
		$nombre  = $product->nombre_producto;

		$colors   = $data['colors'];
		$esBlanca = false;
		if(isset($colors[0])) {
			if ($colors[0] == "FFFFFF" || $colors[0] == "FFF" || $colors[0] == "ffffff" || $colors[0] == "fff") {
				$esBlanca = true;
			}
		}

		// We are going to work with 1 element because we do not know if we are going to need it

		$total_colors    = array("front" => 0, "back" => 0, "left" => 0, "right" => 0);
		$print           = $data['print'];
		$print['colors'] = json_decode($print['colors']);

		foreach ($print['colors'] as $key => $value) {
			$total_colors[$key] = count($value);
		}


		$time = strtotime("now");

		// save file image design
		$design = array();
		if (isset($data['design']['images']['front'])) {
			$design['images']['front']  = createFile($data['design']['images']['front'], 'front', $time);
		}

		if (isset($data['design']['images']['back'])) {
			$design['images']['back']   = createFile($data['design']['images']['back'], 'back', $time);
		}

		if (isset($data['design']['images']['left'])) {
			$design['images']['left']   = createFile($data['design']['images']['left'], 'left', $time);
		}

		if (isset($data['design']['images']['right'])) {
			$design['images']['right']  = createFile($data['design']['images']['right'], 'right', $time);
		}

		//$precio = $this->catalogo_modelo->getMaxPriceFromProduct($product_id);
		$precio = $this->catalogo_modelo->get_precio_por_color($product_id, $data['colors'][key($data['colors'])]);

		$enhance = new StdClass;

		$enhance->id_producto     = $product_id;
		$enhance->precio          = $precio;
		$enhance->nombre          = $nombre;
		$enhance->esBlanca        = $esBlanca; // El costo se va a manejar como si no existira un tipo de playera blanca.
		$enhance->colores_totales = $total_colors;

		$enhance->precio_minimo = getCost($enhance->colores_totales, $enhance->esBlanca, 1, $enhance->precio);

		$mismo_diseno = md5(time());
		$enhance->dibujos = new stdClass();

		if(isset($data['looks']['front'])) {
			$enhance->dibujos->front = createFile($data['looks']['front'], 'dibujo_front', $mismo_diseno);
		}
		if(isset($data['looks']['back'])) {
			$enhance->dibujos->back = createFile($data['looks']['back'], 'dibujo_back', $mismo_diseno);
		}
		if(isset($data['looks']['left'])) {
			$enhance->dibujos->left = createFile($data['looks']['left'], 'dibujo_left', $mismo_diseno);
		}
		if(isset($data['looks']['right'])) {
			$enhance->dibujos->right = createFile($data['looks']['right'], 'dibujo_right', $mismo_diseno);
		}

		$enhance->usuario = new stdClass();
		$enhance->usuario->nombres 				= '';
		$enhance->usuario->apellidos 			= '';
		$enhance->usuario->email				= '';
		$enhance->usuario->fecha_de_nacimiento	= '';
		$enhance->usuario->genero				= '';

		$enhance->diseno           = new StdClass;
		$enhance->diseno->color    = $data['colors'][key($data['colors'])];
		$enhance->diseno->colores  = $print['colors'];
		$enhance->diseno->images   = $design['images'];
		$enhance->diseno->vector   = json_encode($data['design']['vectors']);
		$enhance->diseno->fonts    = $data['fonts'];
		$enhance->diseno->id_color = $data['id_color'];

		$enhance->custom           = new StdClass;
		$enhance->custom->quantity = 1;
		$enhance->custom->price    = floor($enhance->precio_minimo*1.2);
		$enhance->custom->name     = null;
		$enhance->custom->etiquetas       = null;
		$enhance->custom->description = null;
		$enhance->custom->id_clasificacion = null;
		$enhance->custom->id_subclasificacion = null;
		$enhance->custom->id_subsubclasificacion = null;
		$enhance->custom->type     = null;
		$enhance->custom->days     = 7;

		$this->session->set_userdata('enhance', $enhance);

		echo json_encode(array("url" => site_url("vende/definir-metas")));
	}

	public function precio() {

		$nombres			= $this->input->post('nombres', TRUE);
		$apellidos			= $this->input->post('apellidos', TRUE);
		$email				= $this->input->post('email', TRUE);
		$fecha_de_nacimiento= $this->input->post('fecha_de_nacimiento', TRUE);
		$genero				= $this->input->post('genero', TRUE);
		$id_clasificacion	= $this->input->post('id_clasificacion', TRUE);

		$cantidad           = $this->input->post('quantity', TRUE);
		$precio_establecido = $this->input->post('price', TRUE);
		$name               = $this->input->post('name', TRUE);
		$description        = $this->input->post('description', TRUE);
		$etiquetas          = $this->input->post('etiquetas', TRUE);
		$type		        = $this->input->post('type', TRUE);
		$days               = $this->input->post('days', TRUE);
		$costo				= $this->input->post('costo', TRUE);
		$enhance            = $this->session->userdata('enhance');

		$costo_unico = getCost($enhance->colores_totales, $enhance->esBlanca, $cantidad, $enhance->precio);

		//$costo_total = $costo_unico * $cantidad;
		//$total_ganancia = $precio_establecido * $cantidad; // omar mas diseñador
        //
		//$diferencia = ((($total_ganancia - $costo_total)/1.16)*0.75);

		//$diferencia = (($precio_establecido - $costo)/1.16)*0.75*$cantidad;
        if($this->session->has_userdata('login')) {
            if($this->session->login['id_cliente'] == 2003 || $this->session->login['id_cliente'] == 1) {
                $diferencia = (($precio_establecido - $costo_unico)/(1 + $this->iva))*0.90*$cantidad;
            } else {
                $diferencia = (($precio_establecido - $costo_unico)/(1 + $this->iva))*0.75*$cantidad;
            }
        } else {
            $diferencia = (($precio_establecido - $costo_unico)/(1 + $this->iva))*0.75*$cantidad;
        }

		//$diferencia = ( ( $total_ganancia - $costo_total) / 0.87 ); // <- Corresponde a la resta del iva y el 75% de lo que recibe el cliente

		$enhance->usuario->nombres 				= $nombres;
		$enhance->usuario->apellidos 			= $apellidos;
		$enhance->usuario->email				= $email;
		$enhance->usuario->fecha_de_nacimiento	= $fecha_de_nacimiento;
		$enhance->usuario->genero				= $genero;

		$enhance->custom->quantity = $cantidad;
		$enhance->custom->cost     = $costo;

		if($precio_establecido != '') {
			$enhance->custom->price    = $precio_establecido;
		} else {
			$enhance->custom->price		= $this->cart->format_number($costo_unico);
		}
		$enhance->custom->name     = $name;
		$enhance->custom->description = $description;
		$enhance->custom->etiquetas = $etiquetas;

        $info_clasificacion = explode("/", $id_clasificacion);

        if(isset($info_clasificacion[2])) {
            $enhance->custom->id_clasificacion = $info_clasificacion[0];
            $enhance->custom->id_subclasificacion = $info_clasificacion[1];
            $enhance->custom->id_subsubclasificacion = $info_clasificacion[2];
        } else if($info_clasificacion[1]){
            $enhance->custom->id_clasificacion = $info_clasificacion[0];
            $enhance->custom->id_subclasificacion = $info_clasificacion[1];
            $enhance->custom->id_subsubclasificacion = null;
        } else{
            $enhance->custom->id_clasificacion = $info_clasificacion[0];
            $enhance->custom->id_subclasificacion = null;
            $enhance->custom->id_subsubclasificacion = null;
        }

		$enhance->custom->type 	   = $type;
		$enhance->custom->days     = $days;

		$this->session->set_userdata('enhance', $enhance);

		setlocale(LC_MONETARY,"es_MX");

		$resultado = array();
		$resultado['costo_nuevo'] = $this->cart->format_number($costo_unico);
		$resultado['precio_recomendado'] = $this->cart->format_number(floor($costo_unico*1.2));
		$resultado['diferencia'] = $this->cart->format_number($diferencia);

		echo json_encode($resultado);

	}

	public function ocultar_tutorial($decision)
	{
		if($decision == 'no') {
			$this->session->set_userdata('mostrar_tutorial_campana', false);
		} else {
			$this->session->set_userdata('mostrar_tutorial_campana', true);
		}
	}

}
