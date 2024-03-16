<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cupones extends MY_Admin {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('cupones_modelo');
	}

	public function index() {
		$datos['seccion_activa'] = 'cupones';
		
		$footer_datos['scripts'] = 'administracion/cupones/scripts';
		
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/cupones/cupones');
		$this->load->view('administracion/footer', $footer_datos);
	}
	
	public function agregar() {
		
		$cupon = new stdClass();
		$cupon->nombre = $this->input->post('nombre');
		$cupon->cupon= $this->input->post('cupon');
		$cupon->descuento= $this->input->post('descuento');
		$cupon->monto_minimo= $this->input->post('monto_minimo');
		$cupon->cantidad= $this->input->post('cantidad');
		$cupon->expira= $this->input->post('expira');
		$cupon->tipo = $this->input->post('tipo');
        $flag = $this->input->post("producto");
        $id_cliente = $this->input->post('id_cliente');
        if($id_cliente == ''){
            $cupon->id_cliente = null;
        }else{
            $cupon->id_cliente = $id_cliente;
        }
		if($flag){
            $cupon->flag_producto = 1;
        }
		$cupon->estatus = 1;
		
		$this->db->insert('Cupones', $cupon);
		
		redirect('administracion/cupones');
	}
	
	public function modificar() {
		
		$cupon = new stdClass();
		$cupon->nombre = $this->input->post('nombre');
		$cupon->cupon= $this->input->post('cupon');
		$cupon->descuento= $this->input->post('descuento');
		$cupon->monto_minimo= $this->input->post('monto_minimo');
		$cupon->cantidad= $this->input->post('cantidad');
		$cupon->expira= $this->input->post('expira');
		$cupon->tipo= $this->input->post('tipo');
        $flag = $this->input->post("producto");
        $id_cliente = $this->input->post('id_cliente');
        if($id_cliente == ''){
            $cupon->id_cliente = null;
        }else{
            $cupon->id_cliente = $id_cliente;
        }
        if($flag){
            $cupon->flag_producto = 1;
        }
		$id = $this->input->post('id_cupon');
		
		$this->db->where('id', $id);
		$this->db->update('Cupones', $cupon);
		
		redirect('administracion/cupones');
	}
	
	public function borrar() {
		$id = $this->input->post('id_cupon');
		
		$cupon['estatus'] = 33;
		$this->db->where('id', $id);
		$this->db->update('Cupones', $cupon);
		
		redirect('administracion/cupones');
	}
	
	public function estatus() {
		$id = $this->input->post('id_cupon');
		
		$cupon['estatus'] = $this->input->post('estatus');
		$this->db->where('id', $id);
		$this->db->update('Cupones', $cupon);
		
		return true;
	}

    public function obtener_tiendas(){
        $busqueda = $this->input->get('q');
        $this->db->select('id_cliente, nombre_tienda')
            ->from('Tiendas')
            ->like('nombre_tienda', $busqueda);
        $tiendas = $this->db->get()->result();
        $respuesta = array();
        foreach ($tiendas as $indice => $tienda){
            $respuesta[$indice] = new stdClass();
            $respuesta[$indice]->nombre = $tienda->nombre_tienda;
            $respuesta[$indice]->id_cliente = $tienda->id_cliente;
        }
        echo json_encode($respuesta);
    }
	
}
