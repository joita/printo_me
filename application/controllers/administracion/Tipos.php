<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipos extends MY_Admin {

	public function index($categoria_slug = null) {
		$datos_header['seccion_activa'] = 'tipos';
		$datos['categoria_slug'] = $categoria_slug;
		
		if(!$categoria_slug) {
			$categoria_activa = $this->categoria->obtener_min_categoria();
			if(!$categoria_activa) {				
				$this->load->view('administracion/header', $datos_header);
				$this->load->view('administracion/tipos/no_hay');
				$this->load->view('administracion/footer');
			} else {
				redirect('administracion/tipos/'.$categoria_activa->nombre_categoria_slug);
			}
		} else {
			$datos_header['categorias'] = $this->categoria->obtener_categorias_admin();
			$categoria_activa = $this->catalogo_modelo->obtener_categoria_por_slug($categoria_slug, 0);
			if(!$categoria_activa) {
				$this->load->view('administracion/header', $datos_header);
				$this->load->view('administracion/tipos/no_existe', $datos);
				$this->load->view('administracion/footer');
			} else {
				$datos['categoria_activa'] = $categoria_activa;		
				$datos['tipos'] = $this->tipo_modelo->obtener_tipos_admin($categoria_activa->id_categoria);
				
				$datos['class_1'] = 'tipos';
				$datos['class_2'] = 'caracteristicas';
				
				$footer_datos['scripts'] = 'administracion/tipos/scripts';
				
				$this->load->view('administracion/header', $datos_header);
				$this->load->view('administracion/tipos/list', $datos);
				$this->load->view('administracion/footer', $footer_datos);
			}

		}
	}
	
	public function agregar($categoria_slug) {
        $id_tipo = 0;
		$categoria_activa = $this->catalogo_modelo->obtener_categoria_por_slug($categoria_slug, 0);
		
		$tipo = new stdClass();
		$tipo->nombre_tipo = $this->input->post('nombre_tipo');
		$tipo->nombre_tipo_slug = url_title($this->input->post('nombre_tipo'), '-', TRUE);
		
		$caracteristicas = array();
			
		$datos_tipo = $this->input->post('tipo');
		
		for($i=0;$i<sizeof($datos_tipo['caracteristicas']);$i++) {
				
			$titulo_url = url_title($datos_tipo["caracteristicas"][$i], '_', TRUE);
			
			$caracteristicas[$titulo_url] = array();
			$caracteristicas[$titulo_url]['titulo'] = $datos_tipo["caracteristicas"][$i];
			
			$opciones = $datos_tipo['valores'][$i];
			$opciones = preg_replace('/\s+/', '', $opciones);
			$opciones = explode(",", $opciones);
			
			$caracteristicas[$titulo_url]['opciones'] = $opciones;
		}
		
		$outside_car = json_encode($caracteristicas);
		$tipo->caracteristicas_tipo = $outside_car;
		$tipo->estatus = 1;
		/*$tipo->id_categoria = $categoria_activa->id_categoria; Se comenta ya que no existe ese campo actualmente*/
		$this->db->insert('TiposDeProducto', $tipo);
		
		$id_tipo = $this->db->insert_id();

        if($id_tipo > 0){
            $relacionTipoCategoria = new stdClass();
            $relacionTipoCategoria->id_categoria = $categoria_activa->id_categoria;
            $relacionTipoCategoria->id_tipo = $id_tipo;
            $this->db->insert('TipoPerteneceACategoria',$relacionTipoCategoria);
        }

        for($i=0;$i<sizeof($datos_tipo['lados']);$i++) {
            $lado = new stdClass();
            $lado->nombre_lado = $datos_tipo['lados'][$i];
            $lado->nombre_lado_slug = url_title($datos_tipo['lados'][$i], '-', TRUE);
            $lado->id_tipo = $id_tipo;
            $lado->orden = $i;
            $this->db->insert('LadosPorTipo', $lado);
        }
		
		redirect('administracion/tipos/'.$categoria_slug);
	}
	
	public function modificar($categoria_slug) {
		$tipo = new stdClass();
		$id_tipo = $this->input->post('id_tipo');
		
		$caracteristicas = array();
			
		$datos_tipo = $this->input->post('tipo');
		
		foreach($datos_tipo['caracteristicas'] as $slug=>$titulo) {
			
			$caracteristicas[$slug] = array();
			$caracteristicas[$slug]['titulo'] = $titulo;
			
			$opciones = $datos_tipo['valores'][$slug];
			$opciones = preg_replace('/\s+/', '', $opciones);
			$opciones = explode(",", $opciones);
			
			$caracteristicas[$slug]['opciones'] = $opciones;
			
		}		
		
		$outside_car = json_encode($caracteristicas);
		$tipo->caracteristicas_tipo = $outside_car;
		$tipo->nombre_tipo = $this->input->post('nombre_tipo');
		
		$this->db->where('id_tipo', $id_tipo);
		$this->db->update('TiposDeProducto', $tipo);
		
		redirect('administracion/tipos/'.$categoria_slug);
	} 
	
	public function borrar($categoria_slug) {
		$tipo = new stdClass();
		$tipo->estatus = 33;
		
		$this->db->where('id_tipo', $this->input->post('id_tipo'));
		$this->db->update('TiposDeProducto', $tipo);
		
		redirect('administracion/tipos/'.$categoria_slug);
	}
	
	public function estatus() {
		
	}

	public function reordenar_lados($id_tipo){
        if(!$this->input->post('data')) {
            return false;
        } else {
            foreach($this->input->post('data') as $posicion => $id_lado ) {
                $this->db->query("UPDATE LadosPorTipo SET orden=".($posicion)." WHERE id_lado=".$id_lado." AND id_tipo =".$id_tipo);
            }
        }
    }
	
}
