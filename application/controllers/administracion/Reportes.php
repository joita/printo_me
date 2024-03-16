<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends MY_Admin {

	public function index() {
		redirect('administracion/reportes/minimos');
	}

	public function minimos()
	{
		$datos['seccion_activa'] = 'reportes';
		$contenido['accion'] = 'especifico';
		$contenido['reporte_especifico'] = 'minimos';
		$contenido['minimos'] = $this->reportes_modelo->obtener_minimos();

		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/reportes/despliegue_base', $contenido);
		$this->load->view('administracion/footer');
	}

    public function inventario_completo()
    {
        $datos['seccion_activa'] = 'reportes';
        $contenido['accion'] = 'especifico';
        $contenido['reporte_especifico'] = 'inventario_completo';
        $contenido['minimos'] = $this->reportes_modelo->obtener_todos();

        $this->load->view('administracion/header', $datos);
        $this->load->view('administracion/reportes/despliegue_base', $contenido);
        $this->load->view('administracion/footer');
    }

	public function existencias()
	{
		$datos['seccion_activa'] = 'reportes';
		$contenido['accion'] = 'especifico';
		$contenido['reporte_especifico'] = 'existencias';
		$contenido['existencias'] = $this->reportes_modelo->obtener_existencias();

		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/reportes/despliegue_base', $contenido);
		$this->load->view('administracion/footer');
	}

	public function minimos_pdf()
	{
		$this->load->helper(array('dompdf', 'file'));
		$contenido = array();
		$contenido['minimos'] = $this->reportes_modelo->obtener_minimos();

		$html = $this->load->view('administracion/reportes/pdf_minimos', $contenido, true);

		pdf_create($html, 'reporte_minimos_printome_'.date("YmdHis"));
	}

    public function completo_pdf()
    {
        $this->load->helper(array('dompdf', 'file'));
        $contenido = array();
        $contenido['minimos'] = $this->reportes_modelo->obtener_todos();

        $html = $this->load->view('administracion/reportes/pdf_completo', $contenido, true);

        pdf_create($html, 'reporte_minimos_printome_'.date("YmdHis"));
    }


	public function minimos_pdf_archivo()
	{
		$this->load->helper(array('dompdf', 'file'));
		$contenido = array();
		$contenido['minimos'] = $this->reportes_modelo->obtener_minimos();

		$html = $this->load->view('administracion/reportes/pdf_minimos', $contenido, true);

		$nombre = pdf_create_file($html, 'reporte_minimos_printome_'.date("YmdHis"));

		return $nombre;
	}

	public function correo_minimos_pdf_archivo()
	{
		$minimos = $this->reportes_modelo->obtener_minimos();

		if(sizeof($minimos) > 0) {
			$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);

			$email_administracion = new SendGrid\Email();
			$email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
								 ->setFrom('no-reply@printome.mx')
								 ->setReplyTo('administracion@printome.mx')
								 ->setReplyTo('eli@printome.mx')
								 ->setFromName('Tienda en línea printome.mx')
								 ->setSubject('¡Existencias debajo del mínimo! | printome.mx')
								 ->setHtml($this->load->view('plantillas_correos/nuevas/reporte_minimos', array(), TRUE))
								 ->addAttachment('assets/pdf/'.$this->minimos_pdf_archivo(), 'reporte_minimos_printome_'.date("YmdHis").'.pdf');
			$sendgrid->send($email_administracion);
		}
	}

	public function ventas($fecha_inicio = null, $fecha_final = null, $metodo_de_pago = 'todos')
	{
		$datos['seccion_activa'] = 'reportes';
		$contenido['accion'] = 'especifico';
		$contenido['reporte_especifico'] = 'ventas';

		$day = date('w');
		$inicio_default = date('Y-m-d', strtotime('-'.($day-1).' days'));
		$final_default = date('Y-m-d', strtotime('+'.(7-$day).' days'));

		if(!$fecha_inicio) {
			redirect('administracion/reportes/ventas/'.$inicio_default.'/'.$final_default.'/todos');
		}

		$contenido['fecha_inicio'] = ($fecha_inicio ? $fecha_inicio : $inicio_default);
		$contenido['fecha_final'] = ($fecha_final ? $fecha_final : $final_default);
		$contenido['metodo_de_pago'] = $metodo_de_pago;

		$contenido['reporte'] = $this->reportes_modelo->ventas($fecha_inicio, $fecha_final, $metodo_de_pago);

		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/reportes/despliegue_base', $contenido);
		$this->load->view('administracion/footer');
	}

	public function ventas_pdf($fecha_inicio = null, $fecha_final = null, $metodo_de_pago = 'todos')
	{
		$this->load->helper(array('dompdf', 'file'));
		$contenido = array();
		$day = date('w');
		$inicio_default = date('Y-m-d', strtotime('-'.($day-1).' days'));
		$final_default = date('Y-m-d', strtotime('+'.(7-$day).' days'));

		if(!$fecha_inicio) {
			redirect('administracion/reportes/ventas_pdf/'.$inicio_default.'/'.$final_default.'/todos');
		}

		$contenido['fecha_inicio'] = ($fecha_inicio ? $fecha_inicio : $inicio_default);
		$contenido['fecha_final'] = ($fecha_final ? $fecha_final : $final_default);
		$contenido['metodo_de_pago'] = $metodo_de_pago;

		$contenido['reporte'] = $this->reportes_modelo->ventas($fecha_inicio, $fecha_final, $metodo_de_pago);

		$html = $this->load->view('administracion/reportes/pdf_ventas', $contenido, true);

		pdf_create($html, 'reporte_ventas_printome_'.date("YmdHis"));
	}

	public function pagos($fecha_inicio = null, $fecha_final = null, $metodo_de_pago = 'todos', $tipo_campana = 'todos')
	{
		$datos['seccion_activa'] = 'reportes';
		$contenido['accion'] = 'especifico';
		$contenido['reporte_especifico'] = 'pagos';

		$day = date('w');
		$inicio_default = date('Y-m-d', strtotime('-'.($day-1).' days'));
		$final_default = date('Y-m-d', strtotime('+'.(7-$day).' days'));

		if(!$fecha_inicio) {
			redirect('administracion/reportes/pagos/'.$inicio_default.'/'.$final_default);
		}

		$contenido['fecha_inicio'] = ($fecha_inicio ? $fecha_inicio : $inicio_default);
		$contenido['fecha_final'] = ($fecha_final ? $fecha_final : $final_default);
        $contenido['metodo_pago'] = ($metodo_de_pago ? $metodo_de_pago : 'todos');
        $contenido['tipo_campana'] = ($tipo_campana ? $tipo_campana : 'todos');

		$contenido['reporte'] = $this->reportes_modelo->obtener_pagos($fecha_inicio, $fecha_final, $metodo_de_pago, $tipo_campana, false);

        $datos_footer['scripts'] = 'administracion/reportes/scripts';

		$this->load->view('administracion/header', $datos);
	    $this->load->view('administracion/reportes/despliegue_base', $contenido);
		$this->load->view('administracion/footer', $datos_footer);
	}

	public function desplegar_pagos_data(){
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');
        $orden = $this->input->post('order');

        $fecha_inicio = $this->input->post('fecha_inicio');
        $fecha_final = $this->input->post('fecha_final');
        $metodo_pago = $this->input->post('metodo_pago');
        $tipo_campana = $this->input->post('tipo_campana');

        $pagos = $this->reportes_modelo->obtener_pagos_datatable($limit, $offset, $orden, $search, $fecha_inicio, $fecha_final, $metodo_pago, $tipo_campana);

        $info = new stdClass();
        $info->draw = $this->input->post('draw');
        $info->recordsTotal = $this->reportes_modelo->contar_pagos_datatable(null, $fecha_inicio, $fecha_final, $metodo_pago, $tipo_campana);
        $info->recordsFiltered = $this->reportes_modelo->contar_pagos_datatable($search, $fecha_inicio, $fecha_final, $metodo_pago, $tipo_campana);
        $info->data = array();

        foreach($pagos as $pago){
            $inner_info = new stdClass();
            $inner_info->email .= "<td width='20%' class='text-center'>".$pago->email."</td>";
            $inner_info->fecha_pago .= "<td width='20%' class='text-center'>".$pago->fecha_pago."</td>";
            $inner_info->monto .= "<td width='20%' class='text-center'>$".$pago->monto_corte."</td>";
            $inner_info->metodo_pago .= "<td width='20%' class='text-center'>";
            if($pago->tipo_pago == 'paypal'){
                $inner_info->metodo_pago .= "<span class='hide'>PayPal</span><img class='payimg' src='".site_url('assets/images/paypal.svg')."' alt='PayPal' />";
            }else {
                $inner_info->metodo_pago .= "<i class='fa fa-bank'></i>";
            }
            $inner_info->metodo_pago .= "</td>";
            $inner_info->comprobante .= "<td width='20%' class='text-center'>
                <a href='".site_url('assets/comprobantes/'.$pago->comprobante_pago)."' target='_blank' class='action button'><i class='fa fa-file'></i> Documento</a>
            </td>";

            array_push($info->data, $inner_info);
        }
        echo json_encode($info);
    }

    public function pagos_pdf($fecha_inicio = null, $fecha_final = null, $metodo_de_pago = 'todos', $tipo_campana = 'todos')
    {
        $this->load->helper(array('dompdf', 'file'));
        $contenido = array();
        $day = date('w');
        $inicio_default = date('Y-m-d', strtotime('-'.($day-1).' days'));
        $final_default = date('Y-m-d', strtotime('+'.(7-$day).' days'));

        if(!$fecha_inicio) {
            redirect('administracion/reportes/pagos_pdf/'.$inicio_default.'/'.$final_default.'/todos/todos');
        }

        $contenido['fecha_inicio'] = ($fecha_inicio ? $fecha_inicio : $inicio_default);
        $contenido['fecha_final'] = ($fecha_final ? $fecha_final : $final_default);
        $contenido['metodo_de_pago'] = $metodo_de_pago;
        $contenido['tipo_campana'] = $tipo_campana;

        $contenido['reporte'] = $this->reportes_modelo->obtener_pagos($fecha_inicio, $fecha_final, $metodo_de_pago, $tipo_campana, true);

        $html = $this->load->view('administracion/reportes/pdf_pagos', $contenido, true);

        pdf_create($html, 'reporte_pagos_diseñadores_printome_'.date("YmdHis"));
    }

	public function pdf_pedido($id_pedido){
		$this->load->helper(array('dompdf', 'file'));
		$contenido['accion'] = 'despliegue';
		$contenido['pedidos'] = 'despliegue';
		$contenido['id_pedido'] = $id_pedido;
		$contenido['pedido'] = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$contenido['productos'] = $this->pedidos_modelo->obtener_productos_por_pedido($id_pedido);
        $contenido['cantidad_pedidos'] =  $this->pedidos_modelo->obtener_cantidad_pedidos($contenido['pedido']->id_cliente)->cantidad_pedidos;

		foreach($contenido['productos'] as $indice => $producto) {
			if(!$producto->id_enhance) {
				$contenido['productos'][$indice]->diseno = json_decode($producto->diseno);
				$contenido['productos'][$indice]->imagen_principal = $contenido['productos'][$indice]->diseno->images->front;
				$contenido['productos'][$indice]->nombre_principal = $producto->nombre_producto.' personalizada';
			} else {
				$info_enhanced = $this->catalogo_modelo->obtener_enhanced_con_id($producto->id_enhance);
				$contenido['productos'][$indice]->imagen_principal = $info_enhanced->front_image;
				if($info_enhanced->type == 'fijo') {
					$contenido['productos'][$indice]->nombre_principal = 'Venta inmediata (Folio: '.($info_enhanced->id_parent_enhance == 0 ? $info_enhanced->id_enhance : $info_enhanced->id_parent_enhance).') - '.$info_enhanced->name;
				} else if($info_enhanced->type == 'limitado') {
					$contenido['productos'][$indice]->nombre_principal = 'Plazo definido (Folio: '.($info_enhanced->id_parent_enhance == 0 ? $info_enhanced->id_enhance : $info_enhanced->id_parent_enhance).') - '.$info_enhanced->name;
					$contenido['productos'][$indice]->especial = true;
					$contenido['productos'][$indice]->end_date = $info_enhanced->end_date;
				}
			}
		}

		$html = $this->load->view('administracion/pedidos/pdf_especifico', $contenido, true);

		pdf_create($html, 'pedido_printome_'.str_pad($id_pedido, 8, '0', STR_PAD_LEFT));
	}


	public function pdf_pedido_archivo($id_pedido){
		$this->load->helper(array('dompdf', 'file'));
		$contenido['accion'] = 'despliegue';
		$contenido['pedidos'] = 'despliegue';
		$contenido['id_pedido'] = $id_pedido;
		$contenido['pedido'] = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$contenido['productos'] = $this->pedidos_modelo->obtener_productos_por_pedido($id_pedido);
        $contenido['cantidad_pedidos'] =  $this->pedidos_modelo->obtener_cantidad_pedidos($contenido['pedido']->id_cliente)->cantidad_pedidos;

		foreach($contenido['productos'] as $indice => $producto) {
			if(!$producto->id_enhance) {
				$contenido['productos'][$indice]->diseno = json_decode($producto->diseno);
				$contenido['productos'][$indice]->imagen_principal = $contenido['productos'][$indice]->diseno->images->front;
				$contenido['productos'][$indice]->nombre_principal = $producto->nombre_producto.' personalizada';
			} else {
				$info_enhanced = $this->catalogo_modelo->obtener_enhanced_con_id($producto->id_enhance);
				$contenido['productos'][$indice]->imagen_principal = $info_enhanced->front_image;
				if($info_enhanced->type == 'fijo') {
					$contenido['productos'][$indice]->nombre_principal = 'Venta inmediata (Folio: '.($info_enhanced->id_parent_enhance == 0 ? $info_enhanced->id_enhance : $info_enhanced->id_parent_enhance).') - '.$info_enhanced->name;
				} else if($info_enhanced->type == 'limitado') {
					$contenido['productos'][$indice]->nombre_principal = 'Plazo definido (Folio: '.($info_enhanced->id_parent_enhance == 0 ? $info_enhanced->id_enhance : $info_enhanced->id_parent_enhance).') - '.$info_enhanced->name;
					$contenido['productos'][$indice]->especial = true;
					$contenido['productos'][$indice]->end_date = $info_enhanced->end_date;
				}
			}
		}
		// page info here, db calls, etc.
		$html = $this->load->view('administracion/pedidos/pdf_especifico', $contenido, true);
		//echo $html;

		$nombre = pdf_create_file($html, 'pedido_avanda_'.str_pad($id_pedido, 8, '0', STR_PAD_LEFT));

		return $nombre;
	}

	public function pdf_sku($id_ppp){
		// id_ppp = id_producto_por_pedido
    $this->load->helper(array('dompdf', 'file'));
    $contenido['accion'] = 'despliegue';
		$contenido['pedidos'] = 'despliegue';
		$contenido['id_pedido'] = $id_pedido;
		$contenido['producto'] = $this->pedidos_modelo->obtener_diseno_de_ppp($id_ppp);
    // page info here, db calls, etc.
    $html = $this->load->view('administracion/pedidos/pdf_diseno', $contenido, true);
    //echo $html;

    pdf_create($html, 'pedido_avanda_'.str_pad($id_pedido, 8, '0', STR_PAD_LEFT));

	}


	public function pdf_pedido_produccion($id_pedido){
		$this->load->helper(array('dompdf', 'file'));
		$contenido['accion'] = 'despliegue';
		$contenido['pedidos'] = 'despliegue';
		$contenido['id_pedido'] = $id_pedido;
		$contenido['pedido'] = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$contenido['productos'] = $this->pedidos_modelo->obtener_productos_por_pedido($id_pedido);

		// page info here, db calls, etc.
		$html = $this->load->view('administracion/pedidos/pdf_especifico_produccion', $contenido, true);
		//echo $html;

		pdf_create($html, 'pedido_printome_'.str_pad($id_pedido, 8, '0', STR_PAD_LEFT));

	}
}
