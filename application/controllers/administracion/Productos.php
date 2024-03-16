<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends MY_Admin {

	public function __construct()
	{
		parent::__construct();
		$this->class = strtolower(get_class());
	}

	public function index($categoria_slug = '', $tipo_slug = '') {
		$datos_header['seccion_activa'] = 'productos';
		$datos['categoria_slug'] = $categoria_slug;

		if(!$categoria_slug) {
			$categoria_activa = $this->categoria->obtener_min_categoria();
			if(!$categoria_activa) {
				$this->load->view('administracion/header', $datos_header);
				$this->load->view('administracion/productos/no_hay');
				$this->load->view('administracion/footer');
			} else {
				redirect('administracion/productos/'.$categoria_activa->nombre_categoria_slug);
			}
		} else {
			$datos_header['categorias'] = $this->categoria->obtener_categorias_admin();
			$categoria_activa = $this->catalogo_modelo->obtener_categoria_por_slug($categoria_slug, 0);
			if(!$categoria_activa) {
				$this->load->view('administracion/header', $datos_header);
				$this->load->view('administracion/productos/no_existe', $datos);
				$this->load->view('administracion/footer');
			} else {
				$datos['categoria_activa'] = $categoria_activa;
				$datos['tipos'] = $this->tipo_modelo->obtener_tipos_admin($categoria_activa->id_categoria);
				$datos['accion'] = 'despliegue';
				$footer_datos['scripts'] = 'administracion/productos/scripts_despliegue';

				if(!$tipo_slug) {
					$tipo_activo = $this->tipo_modelo->obtener_tipo_minimo_admin($categoria_activa->id_categoria);

					if(!$tipo_activo) {
						$this->load->view('administracion/header', $datos_header);
						$this->load->view('administracion/productos/productos', $datos);
						$this->load->view('administracion/footer', $footer_datos);
					} else {
						redirect('administracion/productos/'.$categoria_activa->nombre_categoria_slug.'/'.$tipo_activo->tipo->nombre_tipo_slug);
					}
				} else {
					$datos['tipo_activo'] = $this->tipo_modelo->obtener_tipo_activo_por_slug($categoria_activa->id_categoria, $tipo_slug);
					$datos['productos'] = $this->productos_modelo->obtener_productos($categoria_activa->id_categoria, $datos['tipo_activo']->tipo->id_tipo);
					$this->load->view('administracion/header', $datos_header);
					$this->load->view('administracion/productos/productos', $datos);
					$this->load->view('administracion/footer', $footer_datos);
				}
			}
		}
	}

	public function agregar($categoria_slug, $tipo_slug) {
		$datos['categoria_slug'] = $categoria_slug;
		$datos['seccion_activa'] = 'productos';
		$datos['categoria_activa'] = $this->catalogo_modelo->obtener_categoria_por_slug($categoria_slug, 0);
		$datos['tipo_activo'] = $this->tipo_modelo->obtener_tipo_activo_por_slug($datos['categoria_activa']->id_categoria, $tipo_slug);
		$datos['accion'] = 'agregar';
		$datos['tipos'] = $this->tipo_modelo->obtener_tipos_admin($datos['categoria_activa']->id_categoria);
		$datos['categorias'] = $this->categoria->obtener_categorias_activas_admin();

		$datos['caracteristicas_adicionales'] = $this->catalogo_modelo->obtener_caracterisitcas_adicionales_por_categoria($datos['tipo_activo']->tipo->id_tipo);


		$footer_datos['scripts'] = 'administracion/productos/scripts_agregar';
		$footer_datos['class'] = $this->class;
		//$contenido['tipo_forzado'] = $this->tipo_modelo->obtener_tipo_de_categoria($categoria_slug);

		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/productos/productos');
		$this->load->view('administracion/footer', $footer_datos);
	}

	public function caracteristicas_ajax($id = '') {
		$id = (!empty($id)) ? $id : $this->input->post('id');
		if(!empty($id)):
			$caracteristicas_adicionales = $this->catalogo_modelo->obtener_caracterisitcas_adicionales_por_categoria($id);
			$data = '';
			$data .= '<legend>Características adicionales</legend>';
			foreach($caracteristicas_adicionales as $slug=>$caracteristica_adicional):
				$data .= '<label class="divisor">'.$caracteristica_adicional['nombre'].'</label>';
				foreach($caracteristica_adicional['items'] as $nivel_1):
					if(isset($nivel_1['items'])):
					$data .= '<label><strong>'.$nivel_1['nombre'].'</strong></label>';
					foreach($nivel_1['items'] as $nivel_2):
					$data .= '<label>
						<input type="radio" class="second_level" name="car_adi['.$slug.']" id="'.$slug.'_'.$nivel_1['slug'].'_'.$nivel_2['slug'].'" value="'.$nivel_1['slug'].'_'.$nivel_2['slug'].'" required> '.$nivel_2['nombre'].'
					</label>';
					endforeach;
					else:
					$data .= '<label>
						<input type="radio" name="car_adi['.$slug.']" id="'.$slug.'_'.$nivel_1['slug'].'" value="'.$nivel_1['slug'].'" required> '.$nivel_1['nombre'].'
					</label>';
					endif;
				endforeach;
			endforeach;
			echo json_encode(array('data' => $data, 'id' => $id));
		else:
			echo json_encode(array('data'=> '<legend class="text-center">Tiene que selecionar un tipo</legend>'));
		endif;
	}

	public function modificar($categoria_slug, $tipo_slug, $id_producto) {
		$datos['categoria_slug'] = $categoria_slug;
		$datos['seccion_activa'] = 'productos';
		$datos['categoria_activa'] = $this->catalogo_modelo->obtener_categoria_por_slug($categoria_slug, 0);
		$datos['tipo_activo'] = $this->tipo_modelo->obtener_tipo_activo_por_slug($datos['categoria_activa']->id_categoria, $tipo_slug);
		$datos['accion'] = 'modificar';
		$datos['tipos'] = $this->tipo_modelo->obtener_tipos_admin($datos['categoria_activa']->id_categoria);
		$datos['categorias'] = $this->categoria->obtener_categorias_activas_admin();
		$datos['id_producto'] = $id_producto;
		$datos['caracteristicas_adicionales'] = $this->catalogo_modelo->obtener_caracterisitcas_adicionales_por_categoria($datos['tipo_activo']->tipo->id_tipo);

		$datos['producto'] = $this->productos_modelo->obtener_producto_con_id($id_producto);
		$datos['car_adi_producto'] = json_decode($datos['producto']->caracteristicas_adicionales);

		$footer_datos['scripts'] = 'administracion/productos/scripts_modificar';

		// Parte del diseñador
		$this->load->model('product_m');
		$design = $this->product_m->getProductDesign($id_producto);

		$this->load->helper('product');
		$class_product = new helperProduct();
		$design = $class_product->json($design);
		$design->options = $class_product->sortDesign($design);

		$datos['design'] = $design;

		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/productos/productos');
		$this->load->view('administracion/footer', $footer_datos);
	}

	public function agregar_procesar($categoria_slug, $tipo_slug) {

		$categoria = $this->catalogo_modelo->obtener_categoria_por_slug($categoria_slug, 0);

		$producto = new stdClass();
		$producto->nombre_producto = $this->input->post('nombre_producto');
		$producto->nombre_producto_slug = strtolower(url_title(convert_accented_characters($this->input->post('nombre_producto')), '-', TRUE));
		$producto->modelo_producto = $this->input->post('modelo_producto');
		$producto->modelo_producto_slug = strtolower(url_title(convert_accented_characters($this->input->post('modelo_producto')), '-', TRUE));
		$producto->descripcion_producto = $this->input->post('descripcion_producto');
		$producto->descuento_especifico = $this->input->post('descuento_especifico');
		//$producto->precio_producto = $this->input->post('precio_producto');
		$producto->id_tipo = $this->input->post('id_tipo');
		$producto->id_marca = $this->input->post('id_marca');
		$producto->id_categoria = $categoria->id_categoria;
		$producto->envio_gratis = ($this->input->post('envio_gratis') == 1 ? 1 : 0);
		$producto->aplica_devolucion = ($this->input->post('aplica_devolucion') == 1 ? 1 : 0);
		$producto->caracteristicas_adicionales = json_encode($this->input->post('car_adi'));
		$producto->genero = $this->input->post('genero');

		$this->db->insert('CatalogoProductos', $producto);
		$id_producto = $this->db->insert_id();

		$directorio = 'assets/images/productos/producto'.$id_producto;

		if(!file_exists($directorio) and !is_dir($directorio)) {
			mkdir($directorio);
			chmod($directorio, 0755);
		}

		$color_design = [];
		$color_hex = [];
		$color_name = [];

		foreach($this->input->post('producto') as $indice => $variedad_producto) {
			// Prepara el color a insertar
			$variedad_color = new stdClass();
			$variedad_color->codigo_color = strtoupper($variedad_producto['color']);
			$variedad_color->nombre_color = $variedad_producto['nombre_color'];
			$variedad_color->precio = $variedad_producto['precio'];
			$variedad_color->estatus = 1;
			$variedad_color->id_producto = $id_producto;

			$color_design[] = "";
			$color_name[] = $variedad_color->nombre_color;
			$color_hex[] = str_replace("#", "", $variedad_color->codigo_color);

			// Insert el color en la base de datos
			$this->db->insert('ColoresPorProducto', $variedad_color);
			$id_color = $this->db->insert_id();

			$config['upload_path'] = $directorio;

			$config['file_ext_tolower'] = TRUE;
			$config['allowed_types'] = 'jpg|png|jpeg|jpe';

			for($j=0;$j<sizeof($_FILES['producto']['name'][$indice]['fotografia']);$j++) {

				if($_FILES['producto']['size'][$indice]['fotografia'][$j] > 0 && $_FILES['producto']['error'][$indice]['fotografia'][$j] == 0) {

					$config['file_name'] = url_title($producto->nombre_producto_slug.'_'.$producto->modelo_producto_slug.'_'.$variedad_color->nombre_color, '-', TRUE);
					$this->upload->initialize($config);

					$_FILES['userfile']['name'] = $_FILES['producto']['name'][$indice]['fotografia'][$j];
					$_FILES['userfile']['type'] = $_FILES['producto']['type'][$indice]['fotografia'][$j];
					$_FILES['userfile']['tmp_name'] = $_FILES['producto']['tmp_name'][$indice]['fotografia'][$j];
					$_FILES['userfile']['error'] = $_FILES['producto']['error'][$indice]['fotografia'][$j];
					$_FILES['userfile']['size'] = $_FILES['producto']['size'][$indice]['fotografia'][$j];

					$this->upload->do_upload();
					$data = $this->upload->data();

					$config['source_image'] = $data['full_path'];
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = TRUE;

					$configs = array(
						array('width' => 1275, 'height' => 1800, 'quality' => 90, 'new_image' => $data['file_path'].'1800_'.$data['file_name'], 'new_file' => '1800_'.$data['file_name']),
						array('width' => 637, 'height' => 900, 'quality' => 90, 'new_image' => $data['file_path'].'900_'.$data['file_name'], 'new_file' => '900_'.$data['file_name']),
						array('width' => 319, 'height' => 450, 'quality' => 90, 'new_image' => $data['file_path'].'450_'.$data['file_name'], 'new_file' => '450_'.$data['file_name']),
						array('width' => 142, 'height' => 200, 'quality' => 90, 'new_image' => $data['file_path'].'200_'.$data['file_name'], 'new_file' => '200_'.$data['file_name'])
					);

					foreach($configs as $conf) {
						$config['width'] = $conf['width'];
						$config['height'] = $conf['height'];
						$config['quality'] = $conf['quality'];
						$config['new_image'] = $conf['new_image'];

						$this->image_lib->initialize($config);
						$this->image_lib->resize();
					}

					$image_info_db = new stdClass();
					$image_info_db->fotografia_original = $data['file_name'];
					$image_info_db->fotografia_grande = $configs[0]['new_file'];
					$image_info_db->fotografia_mediana = $configs[1]['new_file'];
					$image_info_db->fotografia_chica = $configs[2]['new_file'];
					$image_info_db->fotografia_icono = $configs[3]['new_file'];
					$image_info_db->estatus = 1;
					if($j==0) {
						$image_info_db->principal = 1;
					} else {
						$image_info_db->principal = 0;
					}
					$image_info_db->id_color = $id_color;

					$this->db->insert('FotografiasPorProducto', $image_info_db);

				}
			}

			$sku_entries = array();

			for($i=0;$i<sizeof($variedad_producto['sku']);$i++) {
				$sku_entry = new stdClass();
				$sku_entry->sku = $variedad_producto['sku'][$i];

				$caracteristicas = array();
				foreach($variedad_producto['caracteristicas'] as $indice => $caracteristica) {
					$caracteristicas[$indice] = $caracteristica[$i];
				}
				$caracteristicas = json_encode($caracteristicas);
				$sku_entry->caracteristicas = $caracteristicas;
				$sku_entry->cantidad_inicial = $variedad_producto['cantidad_inicial'][$i];
				$sku_entry->cantidad_minima = $variedad_producto['cantidad_minima'][$i];
				//$sku_entry->precio = $variedad_producto['precio'][$i];
				$sku_entry->id_color = $id_color;

				array_push($sku_entries, $sku_entry);
			}

			foreach($sku_entries as $sku_producto) {
				$this->db->insert('CatalogoSkuPorProducto', $sku_producto);
			}
		}

		$color_design = json_encode($color_design);
		$color_name = json_encode($color_name);
		$color_hex = json_encode($color_hex);

		$design = new stdClass();
		$design->params = new stdClass();
		$design->area = new stdClass();
		$design->id_producto = $id_producto;

		$design->color_hex = $color_hex;
		$design->color_title = $color_name;

		$design->front = $color_design;
		$design->back = $color_design;
		$design->left = $color_design;
		$design->right = $color_design;

		$design->params->front 	= "{'width':'21','height':'29','lockW':true,'lockH':true,'setbg':false,'shape':'square','shapeVal':0}";
		$design->params->back	= "{'width':'21','height':'29','lockW':true,'lockH':true,'setbg':false,'shape':'square','shapeVal':0}";
		$design->params->left 	= "{'width':'21','height':'29','lockW':true,'lockH':true,'setbg':false,'shape':'square','shapeVal':0}";
		$design->params->right 	= "{'width':'21','height':'29','lockW':true,'lockH':true,'setbg':false,'shape':'square','shapeVal':0}";
		$design->area->front 	= "{'width':204,'height':283,'left':'135px','top':'90px','radius':'0px','zIndex':''}";
		$design->area->back 	= "{'width':204,'height':283,'left':'135px','top':'90px','radius':'0px','zIndex':''}";
		$design->area->left 	= "{'width':204,'height':283,'left':'135px','top':'90px','radius':'0px','zIndex':''}";
		$design->area->right 	= "{'width':204,'height':283,'left':'135px','top':'90px','radius':'0px','zIndex':''}";

		$design->area = json_encode($design->area);
		$design->params = json_encode($design->params);

		$this->db->insert('DisenoProductos', $design);

		$id_diseno = $this->db->insert_id();


		redirect('administracion/productos/'.$categoria_slug.'/'.$tipo_slug);
	}

	public function modificar_procesar($categoria_slug, $tipo_slug, $id) {

		$id_producto = $this->input->post('id_producto');

		$producto = new stdClass();
		$producto->nombre_producto = $this->input->post('nombre_producto');
		$producto->nombre_producto_slug = strtolower(url_title(convert_accented_characters($this->input->post('nombre_producto')), '-', TRUE));
		$producto->descripcion_producto = $this->input->post('descripcion_producto');
		//$producto->precio_producto = $this->input->post('precio_producto');
		$producto->descuento_especifico = $this->input->post('descuento_especifico');
		$producto->envio_gratis = ($this->input->post('envio_gratis') == 1 ? 1 : 0);
		$producto->aplica_devolucion = ($this->input->post('aplica_devolucion') == 1 ? 1 : 0);
		$producto->caracteristicas_adicionales = json_encode($this->input->post('car_adi'));
		$producto->genero = $this->input->post('genero');

		$this->db->where('id_producto', $id_producto);
		$this->db->update('CatalogoProductos', $producto);

		$diseno = new stdClass();
		$design = $this->input->post('product')['design'];

		$diseno->params = json_encode($design['params']);
		$diseno->area = json_encode($design['area']);

		$diseno->front = json_encode($design['front']);
		$diseno->back = json_encode($design['back']);
		$diseno->left = json_encode($design['left']);
		$diseno->right = json_encode($design['right']);

		$this->db->where('id_producto', $id_producto);
		$this->db->update('DisenoProductos', $diseno);

        // Sacar diseno actual
		$colores_diseno = $this->db->get_where('DisenoProductos', array('id_producto' => $id))->row();
        $colores_diseno->front = json_decode($colores_diseno->front);
        $colores_diseno->back = json_decode($colores_diseno->back);
        $colores_diseno->left = json_decode($colores_diseno->left);
        $colores_diseno->right = json_decode($colores_diseno->right);
        $colores_diseno->color_hex = json_decode($colores_diseno->color_hex);
        $colores_diseno->color_title = json_decode($colores_diseno->color_title);

        $directorio = 'assets/images/productos/producto'.$id_producto;

		foreach($this->input->post('producto') as $id_color=>$sku) {
			$this->db->where('id_color', $id_color);
			$result_id_color = $this->db->get('ColoresPorProducto');
			if($result_id_color->num_rows()) {
				$this->db->where('id_color', $id_color);
				$this->db->update('ColoresPorProducto', array(
					'precio' => $this->input->post('producto')[$id_color]['precio']
					)
				);
			} else {
				// Prepara el color a insertar
				$variedad_color = new stdClass();
				$variedad_color->codigo_color = strtoupper($this->input->post('producto')[$id_color]['color']);
				$variedad_color->nombre_color = $this->input->post('producto')[$id_color]['nombre_color'];
				$variedad_color->precio = $this->input->post('producto')[$id_color]['precio'];
				$variedad_color->estatus = 1;
				$variedad_color->id_producto = $id_producto;

				// Insert el color en la base de datos
				$this->db->insert('ColoresPorProducto', $variedad_color);
				$id_color = $this->db->insert_id();
			}

			$color_res = $this->db->get_where('ColoresPorProducto', array('id_color' => $id_color));
			$color = $color_res->result();

			/*update sku*/

			/*$this->db->where('id_sku', $id_sku);
			$this->db->update('CatalogoSkuPorProducto', array(
				'cantidad_inicial'
				)
			);*/

			$producto_res = $this->db->get_where('CatalogoProductos', array('id_producto' => $id_producto));
			$producto_info = $producto_res->result();

			$config['upload_path'] = $directorio;

			$config['file_ext_tolower'] = TRUE;
			$config['allowed_types'] = 'jpg|png|jpeg|jpe';
			if(!empty($_FILES['producto']['name'][$id_color]['fotografia'])) {
				for($j=0;$j<sizeof($_FILES['producto']['name'][$id_color]['fotografia']);$j++) {

					if($_FILES['producto']['size'][$id_color]['fotografia'][$j] > 0 && $_FILES['producto']['error'][$id_color]['fotografia'][$j] == 0) {

						$config['file_name'] = url_title($producto->nombre_producto_slug.'_'.$producto_info[0]->modelo_producto_slug.'_'.$color[0]->nombre_color, '-', TRUE);
						$this->upload->initialize($config);

						$_FILES['userfile']['name'] = $_FILES['producto']['name'][$id_color]['fotografia'][$j];
						$_FILES['userfile']['type'] = $_FILES['producto']['type'][$id_color]['fotografia'][$j];
						$_FILES['userfile']['tmp_name'] = $_FILES['producto']['tmp_name'][$id_color]['fotografia'][$j];
						$_FILES['userfile']['error'] = $_FILES['producto']['error'][$id_color]['fotografia'][$j];
						$_FILES['userfile']['size'] = $_FILES['producto']['size'][$id_color]['fotografia'][$j];

						$this->upload->do_upload();
						$data = $this->upload->data();

						$config['source_image'] = $data['full_path'];
						$config['create_thumb'] = FALSE;
						$config['maintain_ratio'] = TRUE;

						$configs = array(
							array('width' => 1275, 'height' => 1800, 'quality' => 90, 'new_image' => $data['file_path'].'1800_'.$data['file_name'], 'new_file' => '1800_'.$data['file_name']),
							array('width' => 637, 'height' => 900, 'quality' => 90, 'new_image' => $data['file_path'].'900_'.$data['file_name'], 'new_file' => '900_'.$data['file_name']),
							array('width' => 319, 'height' => 450, 'quality' => 90, 'new_image' => $data['file_path'].'450_'.$data['file_name'], 'new_file' => '450_'.$data['file_name']),
							array('width' => 142, 'height' => 200, 'quality' => 90, 'new_image' => $data['file_path'].'200_'.$data['file_name'], 'new_file' => '200_'.$data['file_name'])
						);

						foreach($configs as $conf) {
							$config['width'] = $conf['width'];
							$config['height'] = $conf['height'];
							$config['quality'] = $conf['quality'];
							$config['new_image'] = $conf['new_image'];

							$this->image_lib->initialize($config);
							$this->image_lib->resize();
						}

						$image_info_db = new stdClass();
						$image_info_db->fotografia_original = $data['file_name'];
						$image_info_db->fotografia_grande = $configs[0]['new_file'];
						$image_info_db->fotografia_mediana = $configs[1]['new_file'];
						$image_info_db->fotografia_chica = $configs[2]['new_file'];
						$image_info_db->fotografia_icono = $configs[3]['new_file'];
						$image_info_db->estatus = 1;
						$image_info_db->principal = 0;
						$image_info_db->id_color = $id_color;

						$this->db->insert('FotografiasPorProducto', $image_info_db);

					}
				}
			}

            $data_sku_ini = isset($sku['cantidad_inicial']) ? $sku['cantidad_inicial'] : NULL;
			if($data_sku_ini != NULL)
				foreach($data_sku_ini as $id_sku=>$cantidad_inicial) {
					$sql = "UPDATE CatalogoSkuPorProducto SET cantidad_inicial=".$cantidad_inicial." WHERE id_sku=".$id_sku;
					$this->db->query($sql);
				}

			$data_sku_min = isset($sku['cantidad_minima']) ? $sku['cantidad_minima'] : NULL;
			if($data_sku_min != NULL)
				foreach($data_sku_min as $id_sku=>$cantidad_minima) {
					$sql = "UPDATE CatalogoSkuPorProducto SET cantidad_minima=".$cantidad_minima." WHERE id_sku=".$id_sku;
					$this->db->query($sql);
				}

		}

        if($this->input->post('nuevo_producto')) {
			foreach($this->input->post('nuevo_producto') as $indice=>$variedad_producto) {

				$variedad_color = new stdClass();
				$variedad_color->codigo_color = strtoupper($variedad_producto['color']);
				$variedad_color->nombre_color = $variedad_producto['nombre_color'];
				$variedad_color->precio = $variedad_producto['precio'];
				$variedad_color->estatus = 1;
				$variedad_color->id_producto = $id_producto;

				// Insert el color en la base de datos
			    $this->db->insert('ColoresPorProducto', $variedad_color);
				$id_color = $this->db->insert_id();

				if(isset($variedad_producto['color'])) {
                    $colores_diseno->front[] = '';
                    $colores_diseno->back[] = '';
                    $colores_diseno->left[] = '';
                    $colores_diseno->right[] = '';
                    $colores_diseno->color_hex[] = str_replace("#", "", strtoupper($variedad_color->codigo_color));
                    $colores_diseno->color_title[] = $variedad_color->nombre_color;
				}

				$config['upload_path'] = $directorio;

				$config['file_ext_tolower'] = TRUE;
				$config['allowed_types'] = 'jpg|png|jpeg|jpe';

				for($j=0;$j<sizeof($_FILES['nuevo_producto']['name'][$indice]['fotografia']);$j++) {

					if($_FILES['nuevo_producto']['size'][$indice]['fotografia'][$j] > 0 && $_FILES['nuevo_producto']['error'][$indice]['fotografia'][$j] == 0) {
						$config['file_name'] = url_title($producto->nombre_producto_slug.'_'.$producto_info[0]->modelo_producto_slug.'_'.$variedad_color->nombre_color, '-', TRUE);
						$this->upload->initialize($config);

						$_FILES['userfile']['name'] = $_FILES['nuevo_producto']['name'][$indice]['fotografia'][$j];
						$_FILES['userfile']['type'] = $_FILES['nuevo_producto']['type'][$indice]['fotografia'][$j];
						$_FILES['userfile']['tmp_name'] = $_FILES['nuevo_producto']['tmp_name'][$indice]['fotografia'][$j];
						$_FILES['userfile']['error'] = $_FILES['nuevo_producto']['error'][$indice]['fotografia'][$j];
						$_FILES['userfile']['size'] = $_FILES['nuevo_producto']['size'][$indice]['fotografia'][$j];

						$this->upload->do_upload();
						$data = $this->upload->data();

						$config['source_image'] = $data['full_path'];
						$config['create_thumb'] = FALSE;
						$config['maintain_ratio'] = TRUE;

						$configs = array(
							array('width' => 1275, 'height' => 1800, 'quality' => 90, 'new_image' => $data['file_path'].'1800_'.$data['file_name'], 'new_file' => '1800_'.$data['file_name']),
							array('width' => 637, 'height' => 900, 'quality' => 90, 'new_image' => $data['file_path'].'900_'.$data['file_name'], 'new_file' => '900_'.$data['file_name']),
							array('width' => 319, 'height' => 450, 'quality' => 90, 'new_image' => $data['file_path'].'450_'.$data['file_name'], 'new_file' => '450_'.$data['file_name']),
							array('width' => 142, 'height' => 200, 'quality' => 90, 'new_image' => $data['file_path'].'200_'.$data['file_name'], 'new_file' => '200_'.$data['file_name'])
						);

						foreach($configs as $conf) {
							$config['width'] = $conf['width'];
							$config['height'] = $conf['height'];
							$config['quality'] = $conf['quality'];
							$config['new_image'] = $conf['new_image'];

							$this->image_lib->initialize($config);
							$this->image_lib->resize();
						}

						$image_info_db = new stdClass();
						$image_info_db->fotografia_original = $data['file_name'];
						$image_info_db->fotografia_grande = $configs[0]['new_file'];
						$image_info_db->fotografia_mediana = $configs[1]['new_file'];
						$image_info_db->fotografia_chica = $configs[2]['new_file'];
						$image_info_db->fotografia_icono = $configs[3]['new_file'];
						$image_info_db->estatus = 1;
						if($j==0) {
							$image_info_db->principal = 1;
						} else {
							$image_info_db->principal = 0;
						}
						$image_info_db->id_color = $id_color;

						$this->db->insert('FotografiasPorProducto', $image_info_db);

					}
				}




				$sku_entries = array();

				for($i=0;$i<sizeof($variedad_producto['sku']);$i++) {
					$sku_entry = new stdClass();
					$sku_entry->sku = $variedad_producto['sku'][$i];

					$caracteristicas = array();
					foreach($variedad_producto['caracteristicas'] as $indice => $caracteristica) {
						$caracteristicas[$indice] = $caracteristica[$i];
					}
					$caracteristicas = json_encode($caracteristicas);
					$sku_entry->caracteristicas = $caracteristicas;
					$sku_entry->cantidad_inicial = $variedad_producto['cantidad_inicial'][$i];
					$sku_entry->cantidad_minima = $variedad_producto['cantidad_minima'][$i];
					//$sku_entry->precio = $variedad_producto['precio'][$i];
					$sku_entry->id_color = $id_color;

					array_push($sku_entries, $sku_entry);
				}

				foreach($sku_entries as $sku_producto) {
					$this->db->insert('CatalogoSkuPorProducto', $sku_producto);
				}
			}

            $colores_diseno->front = json_encode($colores_diseno->front);
            $colores_diseno->back = json_encode($colores_diseno->back);
            $colores_diseno->left = json_encode($colores_diseno->left);
            $colores_diseno->right = json_encode($colores_diseno->right);
            $colores_diseno->color_hex = json_encode($colores_diseno->color_hex);
            $colores_diseno->color_title = json_encode($colores_diseno->color_title);

            $this->db->where('id_producto', $id);
            $this->db->update('DisenoProductos', $colores_diseno);
		}

		if($this->input->post('nuevo_sku')) {
			foreach($this->input->post('nuevo_sku') as $id_color=>$nuevo_sku) {

				$sku_entries = array();

				for($i=0;$i<sizeof($nuevo_sku['sku']);$i++) {
					$sku_entry = new stdClass();
					$sku_entry->sku = $nuevo_sku['sku'][$i];

					$caracteristicas = array();
					foreach($nuevo_sku['caracteristicas'] as $indice => $caracteristica) {
						$caracteristicas[$indice] = $caracteristica[$i];
					}
					$caracteristicas = json_encode($caracteristicas);
					$sku_entry->caracteristicas = $caracteristicas;
					$sku_entry->cantidad_inicial = $nuevo_sku['cantidad_inicial'][$i];
					$sku_entry->cantidad_minima = $nuevo_sku['cantidad_minima'][$i];
					$sku_entry->id_color = $id_color;

					array_push($sku_entries, $sku_entry);
				}

				foreach($sku_entries as $sku_producto) {
					$this->db->insert('CatalogoSkuPorProducto', $sku_producto);
				}

			}
		}

		redirect('administracion/productos/'.$categoria_slug.'/'.$tipo_slug);
    }

    public function getProductInformationForShopify($product_id)
    {

        //Vendors Array for data post FotografiasPorProducto
        $shopiProducts = [];

        $query = "SELECT * FROM `CatalogoProductos` as cp LEFT join ColoresPorProducto as cpp ON cpp.id_producto = cp.id_producto RIGHT JOIN CatalogoSkuPorProducto as cspp ON cspp.id_color = cpp.id_color  WHERE cp.id_producto = '$product_id'";
        $resultArr = $this->db->query($query);
        $resultArr = $resultArr->result();
        //set default information
        $imageArr = [];
        $shopiProducts['images'] =[];
        if(count($resultArr) > 0 )
        {
            $id_color =  $resultArr[0]->id_color;
            //Fetch Image URL
            $imagesOfProducts = $this->db->query("Select * from FotografiasPorProducto where estatus='33' and id_color='$id_color'")->result();

            $shopiProducts['title'] =  $resultArr[0]->nombre_producto;
            $shopiProducts['body_html']  =  $resultArr[0]->descripcion_producto;
            $shopiProducts['vendor']  = 'printome';
            $shopiProducts['product_type'] = 'printome t-shirt';

            if(isset($imagesOfProducts[0]->fotografia_original))
            {
                $imageArr['src'] =  base_url().'assets/images/productos/producto'.$product_id.'/'.$imagesOfProducts[0]->fotografia_original;
            }

        }

        $shopiProducts['options'] = [];
        $shopiProducts['variants'] = [];
        $shopiProducts['images'][] = $imageArr;

        $allSizes = [];
        $allColors = [];
        $allModels = [];

        //Prepare Data for Posst
        foreach ($resultArr as $key => $inforPr) {

            $sizeChars =  json_decode($inforPr->caracteristicas);
            $allColors[] = $inforPr->nombre_color;
            $allSizes[] = $sizeChars->talla;
            $allModels[] = $inforPr->modelo_producto;
            $shopiProducts['variants'][] =array(
                'option1' => $sizeChars->talla,
                'option2' => $inforPr->nombre_color,
                'price' => $inforPr->precio,
                'sku' => $inforPr->sku,
                'inventory_quantity'=> $inforPr->cantidad_inicial,
                'inventory_management' => 'shopify',
                'fulfillment_service' => 'manual',
                'inventory_policy'=> 'continue',
                'taxable' => true,
                'requires_shipping' => true
            );

        }

        //Set All Size and colors Options
        $shopiProducts['options'][]  = [
            "name" => 'Size',
            "values" =>array_values(array_unique($allSizes))
        ];

        $shopiProducts['options'][]  = [
            "name" => 'Color',
            "values" => array_values(array_unique($allColors))
        ];

        $shopiProducts['pid'] = $product_id;
        return $shopiProducts;
    }

    public function clientes() {
        if(!isset($_POST['searchTerm'])){

            $fetchData = $this->db->query("select * from Clientes order by id_cliente DESC limit 5")->result_array();
        }else{

            $search = $_POST['searchTerm'];
            $fetchData = $this->db->query("select * from Clientes where nombres like '%".$search."%' limit 5")->result_array();
        }

        $data = array();

        foreach ($fetchData as $row) {
            $data[] = array("id"=>$row['id_cliente'], "text"=>$row['nombres'] .' '. $row['apellidos']  );
        }

        echo json_encode($data);

        return true;
    }

    public function postProductInVendors($infoArr)
    {
        $this->load->model('Proveedores_m');

        $vendors = $this->Proveedores_m->obtener_proveedores();

        foreach ($vendors as $vendor) {
            if($vendor->active == 0) continue;
            //Post request to Shopify vendor
            $this->load->helper('product');
            $class_product = new helperProduct();
            $class_product->postApiForShopifyVendors($vendor,$infoArr);
        }


    }

	public function borrar($categoria_slug, $tipo_slug) {
		$id_producto = $this->input->post('id_producto');

		$producto['estatus'] = 33;
		$this->db->where('id_producto', $id_producto);
		$this->db->update('CatalogoProductos', $producto);

		redirect('administracion/productos/'.$categoria_slug.'/'.$tipo_slug);
	}

	public function estatus() {
		$id_producto = $this->input->post('id_producto');

		$producto['estatus'] = $this->input->post('estatus');
		$this->db->where('id_producto', $id_producto);
		$this->db->update('CatalogoProductos', $producto);

		return true;
	}

	public function estatus_color() {
		$id_color = $this->input->post('id_color');

		$color['estatus'] = $this->input->post('estatus');
		$this->db->where('id_color', $id_color);
		$this->db->update('ColoresPorProducto', $color);

		return true;
	}

	public function estatus_sku() {
		$id_sku = $this->input->post('id_sku');

		$sku['estatus'] = $this->input->post('estatus');
		$this->db->where('id_sku', $id_sku);
		$this->db->update('CatalogoSkuPorProducto', $sku);

		return true;
	}

	public function principal_fotografia() {
		$id_fotografia = $this->input->post('id_fotografia');
		$id_color = $this->input->post('id_color');

		$estatus['principal'] = 0;
		$this->db->where('id_color', $id_color);
		$this->db->update('FotografiasPorProducto', $estatus);

		$estatus['principal'] = 1;
		$this->db->where('id_fotografia', $id_fotografia);
		$this->db->update('FotografiasPorProducto', $estatus);

		return true;
	}

	public function borrar_fotografia() {
		$id_fotografia = $this->input->post('id_fotografia');
		$id_color = $this->input->post('id_color');
		$estatus = $this->input->post('estatus');

		if($estatus == 0) {
			$fotografia['estatus'] = 33;
			$this->db->where('id_fotografia', $id_fotografia);
			$this->db->update('FotografiasPorProducto', $fotografia);

		} else {
			$this->db->select_min('id_fotografia');
			$this->db->from('FotografiasPorProducto');
			$this->db->where('id_color', $id_color);
			$this->db->where('id_fotografia !=', $id_fotografia);
			$this->db->where('principal', 0);
			$foto_res = $this->db->get();
			$foto = $foto_res->result();

			$fotografia_borrada['estatus'] = 33;
			$fotografia_borrada['principal'] = 0;
			$this->db->where('id_fotografia', $id_fotografia);
			$this->db->update('FotografiasPorProducto', $fotografia_borrada);

			$fotografia_nueva['principal'] = 1;
			$this->db->where('id_fotografia', $foto[0]->id_fotografia);
			$this->db->update('FotografiasPorProducto', $fotografia_nueva);
		}

		return true;
	}

	public function strt() {
		$categorias = array();
		foreach($this->categoria->obtener_categorias() as $categoria) {
			array_push($categorias,$categoria['nombre_categoria_slug']);
		}
		$categorias=implode('|',$categorias);
		$categorias='('.$categorias.')';
		echo $categorias;

	}

	// view box design with change area
	public function diseno()
	{
		$this->data['position'] 	= $this->input->post('position');
		$this->data['title'] 		= $this->input->post('title');
		$this->data['number'] 		= $this->input->post('number');

		error_log(print_r($this->data, true));

		$this->load->helper('product');

		$this->load->view('administracion/productos/diseno', $this->data);
	}

}
