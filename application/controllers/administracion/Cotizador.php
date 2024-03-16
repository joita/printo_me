<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizador extends MY_Admin {

	protected $_folder = 'cotizador';
	protected $_table = 'Cotizador';

	public function __construct()
	{
		parent::__construct();
		$this->class = strtolower(get_class());
	}

	public function index() 
	{
		$datos['seccion_activa'] = 'cotizador';
		
		$footer_datos['scripts'] = 'administracion/cotizador/scripts';
		
		$contenido['obtener_tipo_estampado_1'] = $this->cotizador_modelo->obtener_tipo_estampado_1();
		$contenido['obtener_tipo_estampado_2'] = $this->cotizador_modelo->obtener_tipo_estampado_2();

		$contenido['class'] = $this->class;
		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/'.$this->_folder.'/list', $contenido);
		$this->load->view('administracion/footer', $footer_datos);
	}
	
	/*public function agregar_old() 
	{
		$insert = array(
			'tipo_tinta' => $this->input->post('tipo_tinta'),
			'tipo_estampado' => $this->input->post('tipo_estampado'),
			'costo_blanca' => $this->input->post('costo_blanca'),
			'costo_color' => $this->input->post('costo_color'),
			'cantidad_min' => $this->input->post('cantidad_min'),
			'cantidad_max' => $this->input->post('cantidad_max'),
			'tecnica' => $this->input->post('tecnica'),
			'multiplicador_1' => $this->input->post('multiplicador_1'),
			'multiplicador_2' => $this->input->post('multiplicador_2'),
			'estatus' => $this->input->post('estatus'),
		);
		
		$this->db->insert($this->_table, $insert);
		
		redirect('administracion/'.$this->class);
	}*/
	
	public function get_post($id = '')
	{
		$id = (!empty($id)) ? $id : $this->input->post('id');
		$this->db->where('id_cotizador', $id);
		$data = $this->db->get($this->_table);
		echo json_encode($data->row());
	}

	public function agregar() 
	{
		$data = $this->input->post('data');
		$this->db->insert_batch($this->_table, $data);
	}

	public function recargar_datos()
	{
		$tipo = $this->input->post('tipo_tinta');;
		$estampado = $this->input->post('tipo_estampado');
		$result = '';
		$result_model = $this->cotizador_modelo->obtener_datos($tipo, $estampado);
		foreach($result_model as $key => $data) {
			$result .= '
				<tr data-id="'.$data->id_cotizador.'">
					<td><input name="data['.$data->id_cotizador.'][cantidad_min]" class="change_data text-center" value="'.$data->cantidad_min.'"></td>
					<td><input name="data['.$data->id_cotizador.'][cantidad_max]" class="change_data text-center" value="'.$data->cantidad_max.'"></td>
					<td><input name="data['.$data->id_cotizador.'][costo_blanca]" class="change_data text-center" value="'.$data->costo_blanca.'"></td>
					<td><input name="data['.$data->id_cotizador.'][costo_color]" class="change_data text-center" value="'.$data->costo_color.'"></td>
					<td>
						<select name="data['.$data->id_cotizador.'][tecnica]" class="change_data text-center">
							<option value="TDG" '.selected_opcion('TDG', $data->tecnica).'>TDG</option>
							<option value="SERI" '.selected_opcion('SERI', $data->tecnica).'>SERI</option>
							<option value="VINIL" '.selected_opcion('VINIL', $data->tecnica).'>VINIL</option>
						</select>
					</td>
					<td><input name="data['.$data->id_cotizador.'][multiplicador_1]" class="change_data text-center" value="'.$data->multiplicador_1.'"></td>
					<td><input name="data['.$data->id_cotizador.'][multiplicador_2]" class="change_data text-center" value="'.$data->multiplicador_2.'"></td>
					<td data-key="'.$key.'">
						<ul class="btn-opcion-list clearfix">
						  <li><a class="delete-item delete-item-db"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
						</ul>
					</td>
				</tr>
			';
		}
		$result .= '
			<tr class="tr-new-item" data-newitem="0">
				<td><input name="data[0][cantidad_min]" class="new_data text-center" value=""></td>
				<td><input name="data[0][cantidad_max]" class="new_data text-center" value=""></td>
				<td><input name="data[0][costo_blanca]" class="new_data text-center" value=""></td>
				<td><input name="data[0][costo_color]" class="new_data text-center" value=""></td>
				<td>
					<select name="data[0][tecnica]" class="new_data text-center">
						<option value="TDG">TDG</option>
						<option value="SERI">SERI</option>
						<option value="VINIL">VINIL</option>
					</select>
				</td>
				<td><input name="data[0][multiplicador_1]" class="new_data text-center" value=""></td>
				<td>
					<input name="data[0][multiplicador_2]" class="new_data text-center" value="">
					<input name="data[0][tipo_tinta]" type="hidden" value="'.$tipo.'">
					<input name="data[0][tipo_estampado]" type="hidden" value="'.$estampado.'">
				</td>
				<td>
					<ul class="btn-opcion-list clearfix">
					  <li><a class="new-item"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
					</ul>
				</td>
			</tr>
		';
		echo $result;
	}
	
	public function editar() 
	{
		$id = $this->input->post('id');
		$this->db->where('id_cotizador', $id);
		$this->db->update($this->_table, $this->input->post('data'));
	}
	
	public function eliminar($id = '') 
	{
		$id = (!empty($id)) ? $id : $this->input->post('id');
		$data = array('estatus' => '33');
		$this->db->where('id_cotizador', $id);
		$this->db->update($this->_table, $data);
		//redirect('administracion/'.$this->class);
	}
	
}