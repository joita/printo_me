<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sliders extends MY_Admin {

	public function index() {
		$datos['seccion_activa'] = 'sliders';
		
		$footer_datos['scripts'] = 'administracion/sliders/scripts';
		
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/sliders/sliders');
		$this->load->view('administracion/footer', $footer_datos);
	}
	
	public function agregar() {
		
		$directorio = './assets/images/slides/';
		
		$config['upload_path'] = $directorio;
		$config['file_ext_tolower'] = TRUE;			
		$config['allowed_types'] = 'jpg|jpeg|jpe';		
		$config['encrypt_name'] = TRUE;
		
		$this->upload->initialize($config);

		$this->upload->do_upload('imagen');
		$data = $this->upload->data();
		
		$config['source_image'] = $data['full_path'];
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		
		$slide = new stdClass();
		$slide->imagen_original = $data['file_name'];
		$slide->fecha_subido = date("Y-m-d H:i:s");
		$slide->url_slide = $this->input->post('url_slide');
		
		$this->db->insert('Slider', $slide);
		$id_slide = $this->db->insert_id();
		
		$config['source_image'] = $data['full_path'];
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		
		$configs = array(
			array('width' => 1920, 'height' => 800, 'quality' => 85, 'new_image' => $data['file_path'].'1920x800_'.$data['file_name'], 'new_file' => '1920x800_'.$data['file_name']),
			array('width' => 1440, 'height' => 600, 'quality' => 85, 'new_image' => $data['file_path'].'1440x600_'.$data['file_name'], 'new_file' => '1440x600_'.$data['file_name']),
			array('width' => 1024, 'height' => 427, 'quality' => 85, 'new_image' => $data['file_path'].'1024x427_'.$data['file_name'], 'new_file' => '1024x427_'.$data['file_name']),
			array('width' => 640, 'height' => 267, 'quality' => 85, 'new_image' => $data['file_path'].'640x267_'.$data['file_name'], 'new_file' => '640x267_'.$data['file_name']),
			array('width' => 320, 'height' => 133, 'quality' => 85, 'new_image' => $data['file_path'].'320x133_'.$data['file_name'], 'new_file' => '320x133_'.$data['file_name'])
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
		$image_info_db->imagen_xlarge = $configs[0]['new_file'];
		$image_info_db->imagen_large = $configs[1]['new_file'];
		$image_info_db->imagen_medium = $configs[2]['new_file'];
		$image_info_db->imagen_small = $configs[3]['new_file'];
		$image_info_db->imagen_icono = $configs[4]['new_file'];
		
		$this->db->where('id_slide', $id_slide);
		$this->db->update('Slider', $image_info_db);
		
		redirect('administracion/sliders');
	}
	
	public function modificar() {
		$id_slide = $this->input->post('id_slide');
		
		$slide = new stdClass();
		$slide->url_slide = $this->input->post('url_slide');
		
		$this->db->where('id_slide', $id_slide);
		$this->db->update('Slider', $slide);
		
		redirect('administracion/sliders');
	}
	
	public function borrar() {
		$id_slide = $this->input->post('id_slide');
		
		$slide['estatus'] = 33;
		$this->db->where('id_slide', $id_slide);
		$this->db->update('Slider', $slide);
		
		redirect('administracion/sliders');
	}
	
	public function estatus() {
		$id_slide = $this->input->post('id_slide');
		
		$producto['estatus'] = $this->input->post('estatus');
		$this->db->where('id_slide', $id_slide);
		$this->db->update('Slider', $producto);
		
		return true;
	}
	
}
