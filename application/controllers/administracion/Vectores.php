<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vectores extends MY_Admin {

	public function index($nombre_categoria_slug = '') {
		if($nombre_categoria_slug == '' && $this->vectores_modelo->obtener_primer_categoria()) {
			$categoria_minima = $this->vectores_modelo->obtener_primer_categoria();
			redirect('administracion/vectores/'.$categoria_minima->nombre_categoria_vector_slug);
		}
		
		$datos['seccion_activa'] = 'vectores';
		$datos['categorias_vectores'] = $this->vectores_modelo->obtener_categorias_vectores();
		if(isset($nombre_categoria_slug)) {
			$categoria_vectores = $this->vectores_modelo->obtener_categoria_vectores_slug($nombre_categoria_slug);
			$datos['categoria_activa'] = $categoria_vectores;
			$datos['vectores'] = $this->vectores_modelo->obtener_vectores_por_categoria($categoria_vectores->id_categoria_vector);
		}
		
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/vectores/index');
		$this->load->view('administracion/footer');
	}
	
	public function agregar_vectores($nombre_categoria_slug) {
		
		$categoria_vectores = $this->vectores_modelo->obtener_categoria_vectores_slug($nombre_categoria_slug);
		
		$directorio = 'media/cliparts/'.$categoria_vectores->id_categoria_vector;
		
		if (!file_exists($directorio)) {
			 mkdir($directorio, 0777, TRUE);
		}
		
		$config['upload_path'] = getcwd().'/'.$directorio.'/print';
		if(!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'], 0777, TRUE);
		}
		$config['allowed_types'] 	= 'svg';	
		$config['max_size']			= '5120';
		$this->upload->initialize($config);
		
		for($i=0;$i<sizeof($_FILES['svg']['name']);$i++) {
			if(isset($_FILES['svg']['name'][$i]) && $_FILES['svg']['error'][$i] == 0) {
				$_FILES['userfile']['name'] = $_FILES['svg']['name'][$i];
				$_FILES['userfile']['tmp_name'] = $_FILES['svg']['tmp_name'][$i];
				$_FILES['userfile']['size'] = $_FILES['svg']['size'][$i];
				$_FILES['userfile']['error'] = $_FILES['svg']['error'][$i];
				$_FILES['userfile']['type'] = $_FILES['svg']['type'][$i];
				
				if ( ! $this->upload->do_upload('userfile'))
                {
                    redirect('administracion/vectores/'.$categoria_vectores->nombre_categoria_vector_slug);
                } 
				
				$archivo = $this->upload->data();
				
				$vector = new stdClass();
				$vector->user_id 		= 0;
				$vector->system_id		= 0;
				$vector->title			= $archivo['raw_name'];
				$vector->slug			= url_title(strtolower(convert_accented_characters($vector->title)), '-', TRUE);
				$vector->description	= url_title(strtolower(convert_accented_characters($vector->title)), '-', TRUE);
				$vector->cate_id		= $categoria_vectores->id_categoria_vector;
				$vector->add_price		= 0;
				$vector->status			= 1;
				$vector->feature		= 0;
				$vector->copyright		= 0;
				$vector->type			= 0;
				$vector->fle_url		= $categoria_vectores->id_categoria_vector.'/'.$archivo['file_name'];
				$vector->file_name		= $archivo['file_name'];
				$vector->file_type		= str_replace('.', '', $archivo['file_ext']);
				
				$this->load->library('svg');
				$colors = $this->svg->getColors($archivo['full_path']);
				$vector->colors			= json_encode($colors);
				$vector->change_color	= 1;
				
				$this->db->insert('cliparts', $vector);
				$clipart_id = $this->db->insert_id();
				
				$this->load->library('thumb');
				$this->thumb->file	= $archivo['full_path'];
				
				$thumbs	= $directorio.'/thumbs';				
				if(!is_dir($thumbs)) {
					mkdir($thumbs, 0755, TRUE);
				}
				$this->thumb->resize($thumbs.'/'.md5($clipart_id), array('width'=>100, 'height'=>100));
				
				$medium	= $directorio.'/medium';
				if(!is_dir($medium)) { 
					mkdir($medium, 0755, TRUE);
				}
				$this->thumb->resize($medium.'/'.md5($clipart_id.'medium'), array('width'=>300, 'height'=>300));
				
				$large	= $directorio.'/large';
				if(!is_dir($large)) {
					mkdir($large, 0755, TRUE);
				}
				$this->thumb->resize($large.'/'.md5($clipart_id.'large'), array('width'=>800, 'height'=>800));				
				
				
			}
		}
		
		redirect('administracion/vectores/'.$categoria_vectores->nombre_categoria_vector_slug);
		
	}
	
	public function modificar() {
		/* $vector = site_url('../files/backup.printome/media/cliparts/29/print/1041basketballc14.svg');
		//$vector = site_url('assets/images/paypal.svg');
		//$vector = site_url('assets/images/loudspeaker.svg');
		//$vector = site_url('media/cliparts/22/print/earthquake.svg');
		
		ob_start();
		$image = new Imagick();
		$image->setResolution(800, 800);
		$image->readImage($vector);		
		$image->setBackgroundColor(new ImagickPixel('transparent'));
		$image->setImageFormat('png');
		
		$newWidth = 600;
		$newHeight = 600;
		
		$image->resizeImage($newWidth, $newHeight, imagick::FILTER_LANCZOS, 1); 
		$thumbnail = $image->getImageBlob();
		echo $thumbnail;
		$contents =  ob_get_contents();
		ob_end_clean();
		
		echo '<img src="data:image/png;base64,'.base64_encode($contents).'" />'; */
	}
	
	public function borrar_vector($nombre_categoria_slug, $clipart_id) {
		$this->db->query('UPDATE cliparts SET status=-1 WHERE clipart_id='.$clipart_id);
		redirect('administracion/vectores/'.$nombre_categoria_slug);
	}
	
	public function estatus() {
	}
	
	/* Funciones de categorias */
	public function agregar_categoria() {
		$categoria['nombre_categoria_vector'] = $this->input->post('nombre_categoria_vector');
		$categoria['nombre_categoria_vector_slug'] = url_title(strtolower(convert_accented_characters($this->input->post('nombre_categoria_vector'))), '-', TRUE);
		$categoria['id_categoria_vector_parent'] = 0;
		$categoria['estatus'] = 1;
		
		$this->db->insert('CategoriasVectores', $categoria);
		
		redirect('administracion/vectores');
	}
	
	public function editar_categoria() {
		$categoria['nombre_categoria'] = $this->input->post('nombre_categoria');
		$categoria['nombre_categoria_slug'] = url_title($this->input->post('nombre_categoria'), '-', TRUE);

		$this->db->where('id_categoria', $this->input->post('id_categoria'));
		$this->db->update('Categorias', $categoria);
		
		redirect('administracion/categorias');
	}
	
}
