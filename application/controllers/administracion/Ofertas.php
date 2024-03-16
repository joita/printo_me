<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ofertas extends MY_Admin {

	public function index() {
		$datos['seccion_activa'] = 'ofertas';
		
		$footer_datos['scripts'] = 'administracion/ofertas/scripts';
		
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/ofertas/ofertas');
		$this->load->view('administracion/footer', $footer_datos);
	}
	
	public function agregar() {
		
		$directorio = './assets/images/ofertas/';
		
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
		
		$oferta = new stdClass();
		$oferta->imagen_original = $data['file_name'];
		$oferta->fecha_subido = date("Y-m-d H:i:s");
		$oferta->url_oferta = $this->input->post('url_slide');
		
		$this->db->insert('Ofertas', $oferta);
		$id_oferta = $this->db->insert_id();
		
		$config['source_image'] = $data['full_path'];
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		
		$configs = array(
			array('width' => 800, 'height' => 800, 'quality' => 85, 'new_image' => $data['file_path'].'800x800_'.$data['file_name'], 'new_file' => '800x800_'.$data['file_name']),
			array('width' => 600, 'height' => 600, 'quality' => 85, 'new_image' => $data['file_path'].'600x600_'.$data['file_name'], 'new_file' => '600x600_'.$data['file_name']),
			array('width' => 400, 'height' => 400, 'quality' => 85, 'new_image' => $data['file_path'].'400x400_'.$data['file_name'], 'new_file' => '400x400_'.$data['file_name']),
			array('width' => 200, 'height' => 200, 'quality' => 85, 'new_image' => $data['file_path'].'200x200_'.$data['file_name'], 'new_file' => '200x200_'.$data['file_name']),
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
		$image_info_db->imagen_large = $configs[0]['new_file'];
		$image_info_db->imagen_medium = $configs[1]['new_file'];
		$image_info_db->imagen_small = $configs[2]['new_file'];
		$image_info_db->imagen_icono = $configs[3]['new_file'];
		
		$this->db->where('id_oferta', $id_oferta);
		$this->db->update('Ofertas', $image_info_db);
		
		redirect('administracion/ofertas');
	}
	
	public function modificar() {
		$id_oferta = $this->input->post('id_oferta');
		
		$oferta = new stdClass();
		$oferta->url_oferta = $this->input->post('url_oferta');
		
		$this->db->where('id_oferta', $id_oferta);
		$this->db->update('Ofertas', $oferta);
		
		redirect('administracion/ofertas');
	}
	
	public function borrar() {
		$id_oferta = $this->input->post('id_oferta');
		
		$oferta['estatus'] = 33;
		$this->db->where('id_oferta', $id_oferta);
		$this->db->update('Ofertas', $oferta);
		
		redirect('administracion/ofertas');
	}
	
	public function estatus() {
		$id_oferta = $this->input->post('id_oferta');
		
		$producto['estatus'] = $this->input->post('estatus');
		$this->db->where('id_oferta', $id_oferta);
		$this->db->update('Ofertas', $producto);
		
		return true;
	}
	
}
