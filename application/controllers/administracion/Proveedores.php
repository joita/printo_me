<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends MY_Admin {

	public function index() {		
		$this->load->model('Proveedores_m');
		$datos['seccion_activa'] = 'proveedores';
		//$datos['scripts'] = 'administracion/tiendas/scripts';
		$datos['proveedores'] = $this->Proveedores_m->obtener_proveedores();

		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/proveedores/index', $datos);
		$this->load->view('administracion/footer');

	}

	public function add(){
		$this->load->model('Proveedores_m');
		$datos['seccion_activa'] = 'proveedores';
		//$datos['scripts'] = 'administracion/tiendas/scripts';
		// $datos['proveedores'] = $this->Proveedores_m->obtener_proveedores();
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/proveedores/add');
		$this->load->view('administracion/footer');

	}

	public function submit_data()
	
    {
    	
    	$this->load->library('form_validation');

    	$this->form_validation->set_rules('code', 'Nombre', 'required');
		$this->form_validation->set_rules('domain', 'Dominio', 'required');
		$this->form_validation->set_rules('api_key', 'Clave api', 'required');
		$this->form_validation->set_rules('api_pass', 'Contraseña de api', 'required');
		$this->form_validation->set_rules('creator_id', 'creador', 'required');

    	if ($this->form_validation->run() == FALSE)
            {
            	//$this->session->set_flashdata('message', 'Vendor Added Successfully..');
    			$datos['seccion_activa'] = 'proveedores';
				//$datos['scripts'] = 'administracion/tiendas/scripts';
				// $datos['proveedores'] = $this->Proveedores_m->obtener_proveedores();
				$this->load->view('administracion/header', $datos);
				$this->load->view('administracion/proveedores/add');
				$this->load->view('administracion/footer');
            }
            else
            {
            	$this->load->model('Proveedores_m');
			    $data = array('code'    => $this->input->post('code'),
			                  'store_url'       => $this->input->post('domain'),
			                  'api_key'         => $this->input->post('api_key'),
			                  'api_pass'     => $this->input->post('api_pass'),
			                  'creator_id'     => $this->input->post('creator_id')
			                  );
			    
			    $insert = $this->Proveedores_m->insert_data($data);

                $this->session->set_flashdata('message', 'Proveedor agregado correctamente..');
    			redirect('administracion/proveedores');
            }
    }

	public function edit($id){
		
		$this->load->model('Proveedores_m');
		$datos['seccion_activa'] = 'proveedores';
		//$datos['scripts'] = 'administracion/tiendas/scripts';
		$datos['proveedore'] = $this->Proveedores_m->obtener_proveedores($id);
		$datos['cliente'] =  $this->db->get_where('Clientes',['id_cliente' => $datos['proveedore']->creator_id])->row();
		
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/proveedores/edit', $datos);
		$this->load->view('administracion/footer');


	}


	public function update_data($id){
		
		$this->load->model('Proveedores_m');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('code', 'Nombre', 'required');
		$this->form_validation->set_rules('domain', 'Dominio', 'required');
		$this->form_validation->set_rules('api_key', 'Clave api', 'required');
		$this->form_validation->set_rules('api_pass', 'Contraseña de api', 'required');
		$this->form_validation->set_rules('creator_id', 'Creador', 'required');

    	if ($this->form_validation->run() == FALSE)
        {
        	//$this->session->set_flashdata('message', 'Vendor Added Successfully..');
			$datos['seccion_activa'] = 'proveedores';
			$datos['proveedore'] = $this->Proveedores_m->obtener_proveedores($id);
		
			$this->load->view('administracion/header', $datos);
			$this->load->view('administracion/proveedores/edit', $datos);
			$this->load->view('administracion/footer');

        }
        else
        {
        	$this->load->model('Proveedores_m');
			    $data = array('code'    => $this->input->post('code'),
			                  'store_url'       => $this->input->post('domain'),
			                  'api_key'         => $this->input->post('api_key'),
			                  'api_pass'     => $this->input->post('api_pass'),
			                  'creator_id'     => $this->input->post('creator_id')
			                  );
			    
			    $insert = $this->Proveedores_m->update_data($id,$data);

                $this->session->set_flashdata('message', 'Proveedor actualizado correctamente...');
    			redirect('administracion/proveedores');
        }
	}

	public function delete_data($id)
	{
		$this->db->delete('proveedores', array('id' => $id));
		$this->session->set_flashdata('message', 'Proveedor eliminado correctamente...');
    	redirect('administracion/proveedores');
	}

	public  function sale_graph(){
		$this->load->model('Proveedores_m');
		$datos['seccion_activa'] = 'proveedores';
		//$datos['scripts'] = 'administracion/tiendas/scripts';
		$datos['proveedores'] = $this->Proveedores_m->obtener_proveedores();
		$this->load->helper('product');
		$class_product = new helperProduct();
		$datos['class_product'] = $class_product;
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/proveedores/graph', $datos);
		$this->load->view('administracion/footer');
		
	}

}