<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index($error = false)
	{
		$this->load->view('administracion/header_login');
		
		$this->load->view('administracion/footer');
	}
	
	public function login_proceso()
	{
		$usuario = $this->input->post('usuario');
		$password = $this->input->post('password');
		
		$cliente = $this->db->get_where('Usuarios', array('usuario' => $usuario))->row();
		
		if(isset($cliente->usuario)) {
			
			if($password == $this->encryption->decrypt($cliente->password)) {
				
				$fecha = new stdClass();
				$fecha->fecha_ultimo_inicio_sesion = date("Y-m-d H:i:s");
				
				$this->db->where('id_usuario', $cliente->id_usuario);
				$this->db->update('Usuarios', $fecha);
				
				$this->session->login_admin = true;
				
				$admin = array(
					'usuario' => $usuario,
					'nombre' => $cliente->nombre,
					'tipo_usuario' => $cliente->tipo_usuario,
					'privilegios' => explode(',', $cliente->privilegios)
				);
				
				$this->session->set_userdata('admin', $admin);
				
				if($cliente->tipo_usuario == 'admin') {
					redirect('administracion/pedidos');
				} else {
					redirect('administracion/'.$admin['privilegios'][0]);
				}
				
			} else {
				$this->session->login_admin = false;
				redirect('administracion/login');
			}
			
		} else {
			$this->session->login_admin = false;
			redirect('administracion/login');
		}
	}
	
	public function cerrar_sesion()
	{
		$this->session->unset_userdata('admin');
		$this->session->login_admin = false;
		redirect('administracion/login');
	}
}
