<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogo extends MY_Controller {

	public $categorias;

	public function __construct()
	{
		parent::__construct();

		$this->categorias = $this->categoria->obtener_categorias_no_enhance();
		foreach($this->categorias as $indice=>$categoria) {
			$this->categorias[$indice]->tipos = $this->tipo_modelo->obtener_tipos_admin($categoria->id_categoria);
		}
	}

	// Funcion principal que redirige a la subcategoria minima
	// Ej: sexy redirige a sexy/corset
	// Ej: basico redirige a basico/panty
	public function index($categoria_slug = '', $tipo_slug = '')
	{
		$categoria = $this->catalogo_modelo->obtener_categoria_por_slug($categoria_slug);
		$tipo = $this->tipo_modelo->obtener_tipo_activo_por_slug($categoria->id_categoria, $tipo_slug);

		$categoria->tipos = $this->tipo_modelo->obtener_tipos_cliente($categoria->id_categoria);

		$use_enhance = false;

		if(is_null($categoria)) show_404();

		if ($categoria->custom == "1") {
			$use_enhance = true;
		}

		if (!$use_enhance) {
			$productos = $this->catalogo_modelo->obtener_productos($categoria->id_categoria, $tipo->tipo->id_tipo);
		}else{
			$productos = $this->catalogo_modelo->obtener_enhanced();
		}

		// Config
		$datos_header['seccion_activa'] = 'productos';
		$datos_header['subseccion_activa'] = $categoria->nombre_categoria_slug;
		$datos_header['tipo_activo'] = $tipo->tipo->nombre_tipo_slug;
		$datos_header['meta']['title'] = $tipo->tipo->title;
		$datos_header['meta']['description'] = $tipo->tipo->description;
		$datos_header['meta']['imagen'] = '';

		$datos_seccion['categoria'] = $categoria;
		$datos_seccion['colores'] = $this->catalogo_modelo->obtener_colores_disponibles($categoria->id_categoria, $tipo->tipo->id_tipo);
		$datos_seccion['tallas'] = $this->catalogo_modelo->obtener_tallas_por_categoria($categoria->id_categoria, $tipo->tipo->id_tipo);
		//$datos_seccion['caracteristicas_tipo'] = $this->catalogo_modelo->obtener_caracteristicas_adicionales_por_categoria($categoria->id_categoria);
		$datos_seccion['scripts'] = 'catalogo/scripts_catalogo';
		$datos_seccion['script_datos']['precios'] = $this->catalogo_modelo->obtener_precios_tope($categoria->id_categoria, $tipo->tipo->id_tipo);
		$datos_seccion['productos'] = $productos;
		$datos_seccion['iva'] = $this->iva;

		if($tipo_slug == 'playeras') {
			$idp = 13;
			$idc = 20;
		} else if($tipo_slug == 'playeras-dama') {
			$idp = 17;
			$idc = 30;
		} else if($tipo_slug == 'juvenil-unisex') {
			$idp = 25;
			$idc = 47;
		} else if($tipo_slug == 'infantil-unisex') {
			$idp = 30;
			$idc = 58;
		} else if($tipo_slug == 'bebes-unisex') {
			$idp = 34;
			$idc = 68;
		} else {
			$idp = 13;
			$idc = 20;
		}
		$datos_header['boton_personaliza'] = 'personalizar/'.$idp.'/'.$idc;

		$datos_seccion['vista'] = 'catalogo/listado';

		$this->load->view('header', $datos_header);
		$this->load->view('catalogo/despliegue_base', $datos_seccion);
		$this->load->view('reveals/contacto_interno', array('asunto' => 'Visitante interesado en otros colores de productos', 'lugar' => 'Sección: '.$tipo->tipo->nombre_tipo.' | '.$categoria->nombre_categoria, 'placeholder' => 'Coméntanos con qué color te gustaría poder contar.'));
        $this->load->view('inicio/loquedicen');
        $this->load->view('footer');

	}


	public function producto($categoria_slug, $tipo_slug, $id_producto) {

		$categoria = $this->catalogo_modelo->obtener_categoria_por_slug($categoria_slug);
		$tipo = $this->tipo_modelo->obtener_tipo_activo_por_slug($categoria->id_categoria, $tipo_slug);

		$use_enhance = false;

		if ($categoria->custom == "1") {
			$use_enhance = true;
		}

		if (!$use_enhance) {
			$producto = $this->catalogo_modelo->obtener_producto_con_id($id_producto);
		}else{
			$producto = $this->catalogo_modelo->obtener_enhanced_con_id($id_producto);
			$id_enhance = $id_producto;
			$id_producto = $producto->id_producto;
		}

		$producto->caracteristicas_tipo = json_decode($producto->caracteristicas_tipo);

		// Config
		$datos_header['seccion_activa'] = 'productos';
		$datos_header['subseccion_activa'] = $categoria->nombre_categoria_slug;
		$datos_header['tipo_activo'] = $tipo->tipo->nombre_tipo_slug;
		$datos_header['meta']['title'] = $producto->nombre_producto;
		$datos_header['meta']['description'] = ($producto->descripcion_producto != '' ? strip_tags($producto->descripcion_producto) : 'Diseña tu playera on-line | printome.mx');
		$datos_header['meta']['imagen'] = '';
		$datos_header['pixel_producto'] = $producto;

		$datos_seccion['producto'] = $producto;
		$datos_seccion['scripts'] = 'catalogo/scripts_catalogo';
		$datos_seccion['script_datos']['precios'] = $this->catalogo_modelo->obtener_precios_tope($categoria->id_categoria, $tipo->tipo->id_tipo);
		$datos_seccion['disponibilidad'] = $this->catalogo_modelo->obtener_disponibles_por_producto($producto->id_producto);
		$datos_seccion['colores'] = $this->catalogo_modelo->obtener_colores_activos_por_producto($producto->id_producto);

        $datos_seccion['testimonios'] = $this->testimonios_m->obtener_testimonios_random($id_producto);

		$datos_header['boton_personaliza'] = 'personalizar/'.$id_producto.'/'.$datos_seccion['colores'][0]->id_color;

		foreach($datos_seccion['colores'] as $indice=>$color) {
			$datos_seccion['colores'][$indice]->fotografias = $this->productos_modelo->obtener_fotografias_producto($color->id_color, $producto->id_producto);
			$datos_seccion['colores'][$indice]->tallas_disponibles = $this->catalogo_modelo->obtener_tallas_por_color($color->id_color);
			foreach($datos_seccion['colores'][$indice]->tallas_disponibles as $subindice=>$caracteristica) {
				$datos_seccion['colores'][$indice]->tallas_disponibles[$subindice]->caracteristicas = json_decode($caracteristica->caracteristicas);
			}
		}

		// Cargar vistas
		$this->load->view('header', $datos_header);
		$this->load->view('catalogo/despliegue_especifico', $datos_seccion);
		$this->load->view('reveals/contacto_interno', array('asunto' => 'Visitante interesado en otros colores de productos', 'lugar' => 'Producto específico: '.$producto->nombre_producto.' | '.$tipo->tipo->nombre_tipo.' | '.$categoria->nombre_categoria, 'placeholder' => 'Coméntanos con qué color te gustaría poder contar.'));
		$this->load->view('inicio/testimonios_plug');
		$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
	}

	public function contacto()
	{
		$datos = new stdClass();
		$datos->nombre = $this->input->post('nombre');
		$datos->email = $this->input->post('email');
		$datos->lugar = $this->input->post('lugar');
		$datos->url = $this->input->post('url');
		$datos->mensaje = $this->input->post('mensaje');
		$datos->telefono = $this->input->post('telefono');
		$datos->asunto = $this->input->post('asunto');

		if($datos->email != '' && valid_email($datos->email)) {
			$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);

			$email = new SendGrid\Email();
			$email->addTo('hello@printome.mx', 'printome.mx')
				  ->addTo('eli@printome.mx', 'Elizabeth Ortiz')
				  ->setFrom('no-reply@printome.mx')
				  ->setReplyTo($datos->email)
				  ->setFromName($datos->nombre)
				  ->setSubject($datos->asunto.' | printome.mx')
				  ->setHtml($this->load->view('plantillas_correos/nuevas/contacto_base', $datos, TRUE))
			;

			$contact = array(
				"email"              => $datos->email,
				"first_name"         => $datos->nombre,
				"last_name"          => '',
				"phone"         	 => $datos->telefono,
				"p[16]"               => '16',
				"status[16]"          => 1,
				"tags"				 => "contacto"
			);
			$contact_sync = $this->ac->api("contact/sync", $contact);

			if($sendgrid->send($email)) {
				echo json_encode(array('resultado' => 'exito'));
			} else {
				echo json_encode(array('resultado' => 'error'));
			}
		} else {
			echo json_encode(array('resultado' => 'error'));
		}
	}

}
