<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 *
 * Designer
 *
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Designer extends MY_Controller {

	public function design($id = 13, $color = 20, $id_unico = '')
	{

		$datos_header["product_id"] = $id;
		$datos_header["color_id"] = $id;

		$id  = (int) $id;

		$data = array();
		$data['id'] = $id;
		$data['color'] = (string) $color;
		$data['id_color'] = $color;
		$data['id_unico'] = $id_unico;

		$color_activo = $this->catalogo_modelo->obtener_color_por_id($color);

		// get product default or product id
		if ($id > 0){
			$fields = array('id_producto' => $id);
		} else {
			$fields = array( );
		}

		$this->load->model('product_m');
		$rows = $this->product_m->getProduct($fields);

		// Config
		$datos_header['seccion_activa'] = 'personalizar';
		$datos_header['meta']['title'] = 'Personalizar '.strtolower($rows[0]->nombre_producto).' '.strtolower($color_activo->nombre_color);
		$datos_header['meta']['description'] = 'Sube una imagen e imprime tu '.strtolower($rows[0]->nombre_producto).' '.strtolower($color_activo->nombre_color).' para uso personal o cualquier evento con la mejor calidad.';
		$datos_header['meta']['imagen'] = '';

		//$otros_prods = $this->catalogo_modelo->obtener_otros_estilos($id, $color);

		if ($rows != false) {
			$product  = $rows[0];

			$design = $this->product_m->getProductDesign($product->id_producto);

			$db_color = $this->catalogo_modelo->obtener_colores_por_producto($product->id_producto);

			$color_hex = json_decode($design->color_hex);
			$color_title = json_decode($design->color_title);
			$color_id = array();

			foreach ($color_hex as $key => $value) {
				$color_name = $color_title[$key];
				foreach ($db_color as $color_index => $color) {
					$item = str_replace("#", "", $color->codigo_color);
					$name = $color->nombre_color;
					if ($item == strtoupper($value) && $name == $color_name) {
						$color_id[] = $color->id_color;
						unset($db_color[$color_index]);
						break;
					}
				}
			}

			$design->color_id = json_encode($color_id);

			if ($design == false) {
				$product = false;
			} else {
				$this->load->helper('product');
				$help_design = new helperProduct();
				$product->design = $help_design->getDesign($design);
			}

			$data['product'] = $product;
		} else {
			$data['product'] = false;
		}

		$data['user'] = $this->session->userdata('login');


		$categorias_vectores = $this->vectores_modelo->obtener_categorias_vectores();

		foreach($categorias_vectores as $indice=>$categoria_vector) {
			$vectores = $this->vectores_modelo->obtener_vectores_por_categoria($categoria_vector->id_categoria_vector);
			$categorias_vectores[$indice]->vectores = $vectores;
		}

		$data['categorias_vectores'] = $categorias_vectores;
		//$data['otros_productos'] = $otros_prods;

        $data['testimonios'] = $this->testimonios_m->obtener_testimonios_random(rand(100,300), 2, 5);

		//print_r($data['otros_productos']);

		$this->load->view('designer_header', $datos_header);
		$this->load->view('design/custom_designer', $data);
		//$this->load->view('inicio/loquedicen');
		$this->load->view('reveals/contacto_interno', array('asunto' => 'Visitante interesado en un número mayor de productos del disponible', 'lugar' => 'Producto personalizable', 'placeholder' => 'Coméntanos qué cantidades requieres.'));
		$this->load->view('designer_footer');
	}

	public function ocultar_tutorial($decision)
	{
		if($decision == 'no') {
			$this->session->set_userdata('mostrar_tutorial', false);
		} else {
			$this->session->set_userdata('mostrar_tutorial', true);
		}
	}

	public function obtener_otros($id_producto, $id_color)
	{
		echo $this->catalogo_modelo->obtener_otros_estilos($id_producto, $id_color, true);
	}

	public function guardar()
	{
		$results	= array();

		$user = $this->session->login;

		$data = json_decode(file_get_contents('php://input'), true);

		$this->load->helper('file');

		$path	= 'media/assets/system';

		$temp 		= explode(';base64,', $data['image']);
		$buffer		= base64_decode($temp[1]);

		$design 					= array();

		$design['id_cliente']		= $user['id_cliente'];
		$design['vectors']			= $data['vectors'];
		$design['teams']			= $data['teams'];
		$design['fonts']			= $data['fonts'];

		$designer_id				= $data['designer_id'];

		// check design and author
		if ($data['design_file'] != '' && $designer_id == $design['id_cliente'])
		{
			// override file and update
			$file 			= $data['design_file'];

			$path_file		= str_replace('/', '/', $file);
			//$id				= $data['id_unico'];
			$key			= $data['design_key'];
		}
		else
		{
			// save new file
			$this->load->library('file');
			$file 		= new file();

			// create path file
			$date 	= new DateTime();

			$year	= $date->format('Y');
			$file->create($path.'/'.$year, 0755);

			$month 	= $date->format('m');
			$file->create($path.'/'.$year.'/'.$month, 0755);

			$key 		= uniqid(date("His"));
			$file 		=  $key . '.png';
			$path_file	= $path.'/'.$year.'/'.$month.'/'.$file;
			$file		= 'media/assets/system/'.$year .'/'. $month .'/'. $file;

			$id			= null;

			$design['id_unico'] 		= $key;
		}


		if ( ! write_file($path_file, $buffer))
		{
			$results['error'] = 1;
			$results['msg']	= 'Hubo errores al intentar crear el archivo';
		}
		else
		{
			$design['image']			= $file;
			$design['id_producto']		= $data['product_id'];
			$design['id_color']  = $data['product_color'];

			$existe_dis = $this->db->get_where('DisenosGuardados', array('id_unico' => $key))->row();

			if(isset($existe_dis->id_unico)) {
				$design['modified'] = date("Y-m-d H:i:s");
				$this->db->where('id_unico', $key);
				$this->db->update('DisenosGuardados', $design);
				$id = $existe_dis->id_diseno;
			} else {
				$design['created'] = date("Y-m-d H:i:s");
				$design['modified'] = date("Y-m-d H:i:s");
				$this->db->insert('DisenosGuardados', $design);
				$id = $this->db->insert_id();
			}

			if ($id > 0)
			{
				$results['error'] = 0;

				$content = array(
					'id_unico'=> $id,
					'design_key'=> $key,
					'designer_id'=> $user['id_cliente'],
					'design_file'=> $file,
					'link_plantilla' => site_url('personalizar/'.$design['id_producto'].'/'.$design['id_color'].'/'.$key)
				);
				$results['content'] = $content;


				// send email savedesign.
				/*
				//params shortcode email.
				$params = array(
					'username'=>$user['username'],
					'url_design'=>site_url('design/index/'.$data['product_id'].'/'.$data['product_color'].'/'.$key),
				);

				//config email.
				$config = array(
					'mailtype' => 'html',
				);
				$subject = configEmail('sub_save_design', $params);
				$message = configEmail('save_design', $params);

				$this->load->library('email', $config);
				$this->email->from(getEmail(config_item('admin_email')), getSiteName(config_item('site_name')));
				$this->email->to($user['email']);
				$this->email->subject ( $subject);
				$this->email->message ($message);
				$this->email->send(); */
			}
			else
			{
				$results['error'] = 1;
				$results['msg']	= 'Ocurrió algún error al guardar el diseño, por favor intenta nuevamente';
			}
		}

		echo json_encode($results);
	}

	public function cargar($key = '')
	{
		$result	= array();
		$result['error'] 		= 0;
		if ($key == '')
		{
			$result['error'] 	= 1;
			$result['msg'] 		= 'No encontrado';
		}
		else
		{

			$options = array(
				'design_id'=> $key
			);
			$design = $this->db->get_where('DisenosGuardados', array('id_unico' => $key))->row();

			if (count($design) == 0)
			{
				$result['error']	= 1;
				$result['msg'] 		= 'Encontrado';
			}

			if ($result['error'] == 0)
			{
				$result['design'] 	= $design;
				$result['msg'] 		= '';
			}
			else
			{
				$result['error'] 	= 1;
				$result['msg'] 		= 'Encontrado';
			}
		}

		echo json_encode($result);
		exit;
	}

	public function obtener_productos()
	{
		$productos = $this->catalogo_modelo->obtener_productos_distintos(10);

		if ($productos === false)
		{
			$data['status'] = 0;
			$data['error'] = 'Ocurrió algún error, por favor intenta nuevamente';
		}
		else
		{
			$data['status'] = 1;
		}

		$data['products'] = $productos;

		echo json_encode($data);
	}

	function obtener_diseno($id = '')
	{
		$data 	= array();

		if ($id == '')
		{
			$this->msgError();
		}

		$this->load->model('product_m');

		// get product info
		$fields = array('id_producto'=>$id, 'estatus'=>1);
		$rows 	= $this->product_m->getProduct($fields);

		// check product
		if ($rows == false)
		{
			$this->msgError();
		}

		$product	= $rows[0];


		// product design
		$design = $this->product_m->getProductDesign($id);
		if (count($design) == 0)
		{
			$this->msgError();
		}
		$this->load->helper('product');
		$help_design		= new helperProduct();
		$product->design 	= $help_design->getDesign($design);


		$data = array();
		$data['status'] = 1;

		$data['product'] = $product;

		echo json_encode($data);
		exit();
	}

	public function obtener_tallas_html($id_producto) {

		$tallas = $this->catalogo_modelo->obtener_tallas_por_producto($id_producto);

		$html = '';
		foreach($tallas as $key=>$color) {
		$html .= '<div class="color_'.url_title($color->nombre_color).' tallita" style="display:none;">
			<label for="input_'.$color->id_sku.'">'.$color->caracteristicas->talla.'</label>
			<select data-id_producto="'.$id_producto.'" data-cantidad-talla data-cantidad_lote="'.$color->id_color.'" class="text-center" name="sku['.$color->id_sku.']" id="input_'.$color->id_sku.'">
				<option value="0">0</option>';
				for($i=1;$i<=$color->cantidad_inicial;$i++) {
				//for($i=1;$i<=100;$i++) {
					$html .= '<option value="'.$i.'">'.$i.'</option>';
				}
		$html .= '</select>
			</div>';
		}

		echo $html;
	}

	public function sesion_diseno()
	{
		$diseno = $this->input->post('sesion');

		if(!isset($this->session->diseno_temp)) {
			$this->session->set_userdata('diseno_temp', $diseno);
		} else {
			$this->session->diseno_temp = $diseno;
		}

		echo json_encode(array('mensaje' => 'Cambios guardados.'));
	}

    public function comenzo_personalizacion()
    {
        if($this->session->has_userdata('login')) {
			ac_agregar_etiqueta($this->session->login['email'], 'comenzo-personalizacion');
		}
		if($this->session->has_userdata('correo_temporal')) {
			ac_agregar_etiqueta($this->session->correo_temporal, 'comenzo-personalizacion');
		}
    }

	public function recuperar_sesion()
	{
		//print_r($this->session->diseno_temp);
		echo json_encode($this->session->diseno_temp);
	}

	public function limpiar_sesion_diseno()
	{
		$this->session->unset_userdata('diseno_temp');
		if($this->session->has_userdata('login')) {
			ac_quitar_etiqueta($this->session->login['email'], 'comenzo-personalizacion');
		}
		if($this->session->has_userdata('correo_temporal')) {
			ac_quitar_etiqueta($this->session->correo_temporal, 'comenzo-personalizacion');
		}
	}

	public function obtener_tabla_medidas($id_producto)
	{
		if($id_producto == 13 || $id_producto == 14) {
			$this->load->view('catalogo/tablas_medidas/hombre_cuello_redondo_manga_corta', TRUE);
		} elseif($id_producto == 15 || $id_producto == 16) {
			$this->load->view('catalogo/tablas_medidas/hombre_cuello_redondo_manga_larga', TRUE);
		} elseif($id_producto == 17 || $id_producto == 19) {
			$this->load->view('catalogo/tablas_medidas/mujer_cuello_redondo_manga_corta', TRUE);
		} elseif($id_producto == 20 || $id_producto == 21) {
			$this->load->view('catalogo/tablas_medidas/mujer_cuello_v_manga_corta', TRUE);
		} elseif($id_producto == 22 || $id_producto == 23) {
			$this->load->view('catalogo/tablas_medidas/mujer_capucha_manga_larga', TRUE);
		} elseif($id_producto == 24 || $id_producto == 25) {
			$this->load->view('catalogo/tablas_medidas/juvenil_manga_corta_unisex', TRUE);
		} elseif($id_producto == 27 || $id_producto == 28) {
			$this->load->view('catalogo/tablas_medidas/juvenil_manga_larga_unisex', TRUE);
		} elseif($id_producto == 29 || $id_producto == 30) {
			$this->load->view('catalogo/tablas_medidas/infantil_manga_corta_unisex', TRUE);
		} elseif($id_producto == 31 || $id_producto == 32) {
			$this->load->view('catalogo/tablas_medidas/infantil_manga_larga_unisex', TRUE);
		} elseif($id_producto == 33 || $id_producto == 34) {
			$this->load->view('catalogo/tablas_medidas/bebe_manga_corta_unisex', TRUE);
		} elseif($id_producto == 35 || $id_producto == 36) {
			$this->load->view('catalogo/tablas_medidas/bebe_manga_larga_unisex', TRUE);
		}
	}
}
