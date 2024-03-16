<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campanas extends MY_Admin {

	public function index($tipo = 'limitado', $estatus = 'activos') {
		if(!$tipo) {
			redirect('administracion/campanas/'.$tipo);
		}
		$datos['seccion_activa'] = 'enhance';
		$datos['tipo_activo'] = $tipo;
		$datos['estatus_activo'] = $estatus;

		if($tipo == 'limitado') {
			$datos['productos']['activos'] = $this->enhance_modelo->contar_campanas_limitadas_por_estatus('activos', null);
			$datos['productos']['aprobar'] = $this->enhance_modelo->contar_campanas_limitadas_por_estatus('aprobar', null);
			$datos['productos']['rechazados'] = $this->enhance_modelo->contar_campanas_limitadas_por_estatus('rechazados', null);
			$datos['productos']['ceros'] = $this->enhance_modelo->contar_campanas_limitadas_por_estatus('ceros', null);
			$datos['productos']['pagar'] = $this->enhance_modelo->contar_campanas_limitadas_por_estatus('pagar', null);
			$datos['productos']['pagados'] = $this->enhance_modelo->contar_campanas_limitadas_por_estatus('pagados', null);
			$datos['productos']['negativos'] = $this->enhance_modelo->contar_campanas_limitadas_por_estatus('negativos', null);
		} else if($tipo == 'fijo') {
			$datos['productos']['activos'] = $this->enhance_modelo->contar_campanas_fijas_por_estatus('activos', null);
			$datos['productos']['aprobar'] = $this->enhance_modelo->contar_campanas_fijas_por_estatus('aprobar', null);
			$datos['productos']['pagar'] = $this->enhance_modelo->contar_campanas_fijas_por_estatus('pagar', null);
			$datos['productos']['rechazados'] = $this->enhance_modelo->contar_campanas_fijas_por_estatus('rechazados', null);
		}

		$footer_datos['scripts'] = 'administracion/enhance/scripts';

		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/enhance/enhance');
		$this->load->view('administracion/footer', $footer_datos);
	}

    public function obtener_campanas($tipo, $estatus)
    {
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');
        $orden = $this->input->post('order');

        if($tipo == 'fijo') {
            $productos = $this->enhance_modelo->obtener_campanas_fijas_por_estatus($estatus, $limit, $offset, $orden, $search);
        } else if($tipo == 'limitado') {
            $productos = $this->enhance_modelo->obtener_campanas_limitadas_por_estatus($estatus, $limit, $offset, $orden, $search);
        }


        $info = new stdClass();
        $info->draw = $this->input->post('draw');
        if($tipo == 'fijo') {
            $info->recordsTotal = $this->enhance_modelo->contar_campanas_fijas_por_estatus($estatus, null);
            $info->recordsFiltered = $this->enhance_modelo->contar_campanas_fijas_por_estatus($estatus, $search);
        } else if($tipo == 'limitado') {
            $info->recordsTotal = $this->enhance_modelo->contar_campanas_limitadas_por_estatus($estatus, null);
            $info->recordsFiltered = $this->enhance_modelo->contar_campanas_limitadas_por_estatus($estatus, $search);
        }

        $info->data = array();

        foreach($productos as $campana) {
            $inner_info = new stdClass();

            // Sacar imagenes
            $images = array();
            $des = json_decode($campana->design);
            foreach($des as $nombre_lado=>$lado) {
                $images[$nombre_lado] = array();
                foreach($lado as $indice=>$inner_lado) {
                    unset($lado[$indice]->svg);
                    if(isset($lado[$indice]->url)) {
                        array_push($images[$nombre_lado], $lado[$indice]->url);
                    }
                }
            }
            $img_json = json_encode($images);

            $inner_info->imagenes = '<span class="hide">.'.$campana->id_enhance.'</span><ul class="small-block-grid-2 precamp">';
            if(isset($campana->front_image)) {
                $inner_info->imagenes .= '<li><img src="'.site_url('image-tool/index.php?src='.site_url($campana->front_image)).'&w=30&h=30" class="smmmimg" /></li>';
            }
            if(isset($campana->back_image)) {
                $inner_info->imagenes .= '<li><img src="'.site_url('image-tool/index.php?src='.site_url($campana->back_image)).'&w=30&h=30" class="smmmimg" /></li>';
            }
            if(isset($campana->left_image)) {
                $inner_info->imagenes .= '<li><img src="'.site_url('image-tool/index.php?src='.site_url($campana->left_image)).'&w=30&h=30" class="smmmimg" /></li>';
            }
            if(isset($campana->right_image)) {
                $inner_info->imagenes .= '<li><img src="'.site_url('image-tool/index.php?src='.site_url($campana->right_image)).'&w=30&h=30" class="smmmimg" /></li>';
            }
            $inner_info->imagenes .= '</ul>';

            // Sacar datos generales
            $inner_info->datos_generales = '<em>Folio:</em> <strong>'.$campana->id_enhance.'</strong><br />
            <em>Campaña:</em> <strong>'.$campana->name.'</strong><br />
            <em>Vendedor:</em> <strong>'.$campana->nombres.' '.$campana->apellidos.'</strong>';

            // Sacar precio
            $inner_info->precio = '$'.$this->cart->format_number($campana->price);

            // Sacar vendidos
            $inner_info->vendidos = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);

            // Sacar estatus
            // if($campana->estatus == 1) {
            //     $inner_info->estatus = '<i class="fa fa-line-chart"></i> Activo';
            // } else if($campana->estatus == 2) {
            //     $inner_info->estatus = '<i class="fa fa-times"></i> Rechazado';
            // } else if($campana->estatus == 3) {
            //     $inner_info->estatus = '<i class="fa fa-ban"></i> Terminado por printome.mx';
            // } else {
            //     $inner_info->estatus = '<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Pendiente';
            // }

            if(!$campana->estatus) {
                $inner_info->estatus = '<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Pendiente';
            } else {
                if($campana->estatus == 2) {
                    $inner_info->estatus = '<i class="fa fa-times"></i> Rechazado';
                } else if($campana->estatus == 3) {
                    $inner_info->estatus = '<i class="fa fa-ban"></i> Terminado por printome.mx';
                } else {
                    $time_restante = strtotime($campana->end_date)-time();
                    if($time_restante < 0) {
                        $inner_info->estatus = '<i class="fa fa-check"></i> Finalizado';
                    } else {
                        $inner_info->estatus = round((($time_restante/24)/60)/60);
                    }
                }
            }

            if($tipo == 'limitado') {
                $inner_info->meta = 0;
                $inner_info->porcentaje = 0;
            }

            // Sacar Acciones
            $inner_info->acciones = '<a href="'.site_url('administracion/campanas/'.$tipo.'/editar/'.$campana->id_enhance).($estatus == 'pagar' ? '#fndtn-cortes_semanales' : '').'" class="action button"><i class="fa fa-eye"></i> Revisar</a>';

            array_push($info->data, $inner_info);
        }

        echo json_encode($info);
    }

    public function cambiar_nombre_campana($tipo, $id_enhance){
	    $nuevo_nombre = $this->input->post('nuevo_nombre');

        $campana = new stdClass();
        $campana->name = $nuevo_nombre;
        $this->db->where('id_enhance', $id_enhance);
        $this->db->update('Enhance', $campana);
        redirect('administracion/campanas/'.$tipo.'/editar/'.$id_enhance);
    }

    public function post_shopify($tipo, $id_enhance)
    {
        if(!$tipo) {
            redirect('administracion/campanas/'.$tipo);
        }
        $campana = $this->enhance_modelo->obtener_enhance_admin($tipo, $id_enhance);

        if(!isset($campana[0])) {
            $client_id = $campana[0]->id_cliente;
            $Store = $this->db->get_where('Tiendas',['id_cliente' => $client_id])->row();
            redirect('administracion/tiendas/'.$Store);
        }


        $client_id = $campana[0]->id_cliente;

        //Check Shopfy Vendor if exists
        $proveedores = $this->db->get_where('proveedores', array('creator_id' => $client_id))->row();
        $Store = $this->db->get_where('Tiendas',['id_cliente' => $client_id])->row();
        if(count($proveedores) <= 0) {

            redirect('administracion/tiendas/'.$Store);
        }

        //Prepare Data for Shopify

        $shopiProducts['title'] =  $campana[0]->name;
        $shopiProducts['body_html']  =  $campana[0]->description;
        $shopiProducts['vendor']  = '';
        $shopiProducts['product_type'] = '';
        $shopiProducts['images'] =[];
        $imageArr = [];
        $imageArr[]['src'] =  base_url().$campana[0]->front_image;
        $imageArr[]['src'] =  base_url().$campana[0]->back_image;
        $imageArr[]['src'] =  base_url().$campana[0]->right_image;
        $imageArr[]['src'] =  base_url().$campana[0]->left_image;
        $shopiProducts['images'] = $imageArr;
        $shopiProducts['options'] = [];
        $shopiProducts['variants'] = [];

        $allSizes = [];
        $allColors = [];

        //Sizes prepare
        $vendidos = $this->enhance_modelo->obtener_tallas_vendidas_por_campana($tipo, $id_enhance);

        $campanas_adicionales = $this->enhance_modelo->obtener_enhances_adicionales_admin($tipo, $id_enhance);

        foreach($campanas_adicionales as $indice_adicional=>$campana_adicional){

            $vendidosTemp = $this->enhance_modelo->obtener_tallas_vendidas_por_campana($tipo, $campana_adicional->id_enhance, true);

            $vendidos = array_merge($vendidos,$vendidosTemp);
        }

        //Prepare Data for Posst
        foreach ($vendidos as $key => $prd) {

            $color_info = $this->db->get_where('ColoresPorProducto', array('id_color' => $prd->id_color))->row();
            $sizeChars =  caracteristicas_parse($prd->caracteristicas);
            $allColors[] = $color_info->nombre_color;
            $allSizes[] = $sizeChars;
            $shopiProducts['variants'][] =array(
                'option1' => $sizeChars,
                'option2' => $color_info->nombre_color,
                'price' => $campana[0]->price,
                'sku' => $prd->sku,
                'inventory_quantity'=> $prd->cantidad_inicial,
                'inventory_management' => 'shopify',
                'fulfillment_service' => 'manual',
                'inventory_policy'=> 'continue',
                'taxable' => true,
                'requires_shipping' => true
            );


        }

        //Set All Size and colors Options
        $shopiProducts['options'][]  = [
            "name" => 'Size',
            "values" =>array_values(array_unique($allSizes))
        ];

        $shopiProducts['options'][]  = [
            "name" => 'Color',
            "values" => array_values(array_unique($allColors))
        ];
        $shopiProducts['pid'] = $id_enhance;


        //Post to Shopify API Call
        $this->postProductInVendors($shopiProducts,$client_id);

        redirect('administracion/tiendas/'.$Store->id_tienda);


    }

    public function postProductInVendors($infoArr,$client_id)
    {
        $this->load->model('Proveedores_m');

        $vendors = $this->Proveedores_m->obtener_proveedores_by_client($client_id);

        foreach ($vendors as $vendor) {
            if($vendor->active == 0) continue;
            //Post request to Shopify vendor
            $this->load->helper('product');
            $class_product = new helperProduct();
            $class_product->postApiForShopifyVendors($vendor,$infoArr);
        }


    }

	public function editar($tipo, $id_enhance)
	{
		if(!$tipo) {
			redirect('administracion/campanas/'.$tipo);
		}
		$campana = $this->enhance_modelo->obtener_enhance_admin($tipo, $id_enhance);

		if(!isset($campana[0])) {
			redirect('administracion/campanas/'.$tipo);
		}

		$datos['seccion_activa'] = 'enhance';
		$datos['tipo_activo'] = $tipo;
		$datos['campana'] = $campana[0];
		$datos['campanas_adicionales'] = $this->enhance_modelo->obtener_enhances_adicionales_admin($tipo, $id_enhance);
		$datos['clasificaciones'] = $this->clasificacion_m->obtener_clasificaciones();
		$datos['link_tienda'] = $this->tienda_m->obtener_link_tienda($id_enhance);

		if($tipo == 'limitado') {
			$datos['corte'] = $this->enhance_modelo->obtener_corte($id_enhance);
			if(isset($datos['corte']->id_dato_deposito)) {
				if($datos['corte']->id_dato_deposito != '') {
					$datos['dato_bancario_corte'] = $this->cuenta_modelo->obtener_dato_deposito_por_id($datos['corte']->id_dato_deposito);
				}
			}
		} else if($tipo == 'fijo') {
			$datos['cortes'] = $this->enhance_modelo->obtener_cortes($id_enhance);
		}

		$datos['info_deposito_actual'] = $this->cuenta_modelo->obtener_dato_deposito_reciente($campana[0]->id_cliente);

		$footer_datos['scripts'] = 'administracion/enhance/scripts';

		$datos['pedidos'] = $this->enhance_modelo->obtener_pedidos_por_campana($id_enhance);

		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/enhance/enhance_especifico_'.$tipo);
		$this->load->view('administracion/footer', $footer_datos);
	}

	public function actualizar_clasificacion($tipo, $id_enhance)
	{
        $info_clasificacion = explode("/", $this->input->post('id_clasificacion'));
		$campana = new stdClass();
        if(isset($info_clasificacion[2])) {
            $campana->id_clasificacion = $info_clasificacion[0];
            $campana->id_subclasificacion = $info_clasificacion[1];
            $campana->id_subsubclasificacion = $info_clasificacion[2];
        } else if(isset($info_clasificacion[1])){
            $campana->id_clasificacion = $info_clasificacion[0];
            $campana->id_subclasificacion = $info_clasificacion[1];
            $campana->id_subsubclasificacion = null;
        } else{
            $campana->id_clasificacion = $info_clasificacion[0];
            $campana->id_subclasificacion = null;
            $campana->id_subsubclasificacion = null;
        }

		$this->db->where('id_enhance', $id_enhance);
		$this->db->update('Enhance', $campana);

		$campana = new stdClass();
		$campana->id_clasificacion = $this->input->post('id_clasificacion');
		$this->db->where('id_parent_enhance', $id_enhance);
		$this->db->update('Enhance', $campana);

		redirect('administracion/campanas/'.$tipo.'/editar/'.$id_enhance);
	}

	public function actualizar_etiquetas($tipo, $id_enhance)
	{
		$campana = new stdClass();
		$campana->etiquetas = $this->input->post('campana_etiquetas');

		$this->db->where('id_enhance', $id_enhance);
		$this->db->update('Enhance', $campana);

		$campana = new stdClass();
		$campana->etiquetas = $this->input->post('campana_etiquetas');
		$this->db->where('id_parent_enhance', $id_enhance);
		$this->db->update('Enhance', $campana);

		redirect('administracion/campanas/'.$tipo.'/editar/'.$id_enhance);
	}

	public function actualizar_descripcion($tipo, $id_enhance)
	{
		$campana = new stdClass();
		$campana->description = $this->input->post('campana_description_edit');

		$this->db->where('id_enhance', $id_enhance);
		$this->db->update('Enhance', $campana);

		$campana = new stdClass();
		$campana->description = $this->input->post('campana_description_edit');
		$this->db->where('id_parent_enhance', $id_enhance);
		$this->db->update('Enhance', $campana);

		redirect('administracion/campanas/'.$tipo.'/editar/'.$id_enhance);
	}

	public function disfrazar_ventas($tipo, $id_enhance)
	{
		$campana = new stdClass();
		$campana->modificador_ventas = $this->input->post('modificador_ventas');

		$this->db->where('id_enhance', $id_enhance);
		$this->db->update('Enhance', $campana);

		redirect('administracion/campanas/'.$tipo.'/editar/'.$id_enhance);
	}

	public function pedido_especifico($tipo, $id_enhance, $id_pedido)
	{
		if(!$tipo) {
			redirect('administracion/campanas');
		}
		$campana = $this->enhance_modelo->obtener_enhance_admin($tipo, $id_enhance);
		if(!isset($campana[0])) {
			redirect('administracion/campanas/'.$tipo);
		}

		$datos['seccion_activa'] = 'enhance';
		$datos['tipo_activo'] = $tipo;
		$datos['campana'] = $campana[0];
		$footer_datos['scripts'] = 'administracion/enhance/scripts';

		$datos['pedido'] = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);

		$this->load->view('administracion/header', $datos);
		$this->load->view('administracion/enhance/pedido_especifico_'.$tipo);
		$this->load->view('administracion/footer', $footer_datos);
	}

	public function asignar_guia_limitado($tipo, $id_enhance, $id_pedido)
	{
		$codigo_rastreo = $this->input->post('codigo_rastreo');

		if($codigo_rastreo == '') {
			redirect('administracion/campanas/limitado/editar/'.$id_enhance.'/pedidos/'.$id_pedido);
		}

		$existe = $this->db->get_where('EnviosPorCampana', array('id_enhance' => $id_enhance, 'id_pedido' => $id_pedido))->row();

		if(isset($existe->codigo_rastreo)) {
			// Actualizacion
			$actualizacion = new stdClass();
			$actualizacion->codigo_rastreo = $codigo_rastreo;

			$this->db->where('id_pedido', $id_pedido);
			$this->db->where('id_enhance', $id_enhance);
			$this->db->update('EnviosPorCampana', $actualizacion);
		} else {
			// Nuevo
			$nuevo_codigo = new stdClass();
			$nuevo_codigo->id_enhance = $id_enhance;
			$nuevo_codigo->id_pedido = $id_pedido;
			$nuevo_codigo->codigo_rastreo = $codigo_rastreo;

			$this->db->insert('EnviosPorCampana', $nuevo_codigo);
		}

		$pedido = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$enhance = $this->enhance_modelo->obtener_enhance($id_enhance);

		$cliente_res = $this->db->get_where('Clientes', array('id_cliente' => $pedido->id_cliente));
		$cliente = $cliente_res->result();

		$datos_correo = new stdClass();
		$datos_correo->nombre = $cliente[0]->nombres.' '.$cliente[0]->apellidos;
		$datos_correo->email = $cliente[0]->email;
		$datos_correo->numero_pedido = str_pad($pedido->id_pedido, 8, '0', STR_PAD_LEFT);
		$datos_correo->numero_pedido_corto = $pedido->id_pedido;
		$datos_correo->codigo_rastreo = $codigo_rastreo;
		$datos_correo->total_pedido = $pedido->total;
		$datos_correo->campana = $enhance->name;

		// Se inicializa Sendgrid
		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
		$email = new SendGrid\Email();
		$email->addTo($datos_correo->email, $datos_correo->nombre)
			  ->setFrom('administracion@printome.mx')
			  ->setReplyTo('administracion@printome.mx')
			  ->setFromName('printome.mx')
			  ->setSubject('¡Productos de plazo definido enviados! | printome.mx')
			  ->setHtml($this->load->view('plantillas_correos/nuevas/admin_pedido_plazo_definido_enviado', $datos_correo, TRUE))
		;
		$sendgrid->send($email);

		redirect('administracion/campanas/limitado/editar/'.$id_enhance.'/pedidos/'.$id_pedido);
	}

	public function pdf_pedido_produccion($tipo_campana, $id_campana){
		$this->load->helper(array('dompdf', 'file'));
		$contenido['accion'] = 'despliegue';
		$contenido['pedidos'] = 'despliegue';
		$contenido['id_campana'] = $id_campana;
		$contenido['campana'] = $this->enhance_modelo->obtener_enhance_admin($tipo_campana, $id_campana)[0];
		$contenido['campanas_adicionales'] = $this->enhance_modelo->obtener_enhances_adicionales_admin($tipo_campana, $id_campana);
		// page info here, db calls, etc.
		$html = $this->load->view('administracion/enhance/pdf_especifico_produccion', $contenido, true);
		//echo $html;

		pdf_create($html, 'produccion_campana_printome_'.str_pad($id_campana, 8, '0', STR_PAD_LEFT));

	}

	public function pdf_comprobante_limitado($id_campana, $id_corte)
	{
		$this->load->helper(array('dompdf', 'file'));
		$datos['id_campana'] = $id_campana;
		$datos['campana'] = $this->enhance_modelo->obtener_enhance_admin('limitado', $id_campana)[0];
		$datos['corte'] = $this->enhance_modelo->obtener_corte($id_campana);
		if($datos['corte']->id_dato_deposito != '') {
			$datos['dato_bancario_corte'] = $this->cuenta_modelo->obtener_dato_deposito_por_id($datos['corte']->id_dato_deposito);
		}

		$html = $this->load->view('administracion/enhance/pdf_limitado_comprobante', $datos, true);
		//echo $html;

		pdf_create($html, 'comprobante_pago_campana_printome_'.str_pad($id_campana, 8, '0', STR_PAD_LEFT));
	}

	public function pdf_comprobante_fijo($id_campana, $id_corte)
	{
		$this->load->helper(array('dompdf', 'file'));
		$datos['id_campana'] = $id_campana;
		$datos['campana'] = $this->enhance_modelo->obtener_enhance_admin('fijo', $id_campana)[0];
		$datos['corte'] = $this->enhance_modelo->obtener_cortes($id_campana, $id_corte);
		if($datos['corte']->id_dato_deposito != '') {
			$datos['dato_bancario_corte'] = $this->cuenta_modelo->obtener_dato_deposito_por_id($datos['corte']->id_dato_deposito);
		}

		$html = $this->load->view('administracion/enhance/pdf_fijo_comprobante', $datos, true);
		//echo $html;

		pdf_create($html, 'comprobante_pago_campana_printome_'.str_pad($id_campana, 8, '0', STR_PAD_LEFT));
	}

	public function estatus() {
		$id_enhance = $this->input->post('id_enhance');

		$enhance['estatus'] = $this->input->post('estatus');
		$this->db->where('id_enhance', $id_enhance);
		$this->db->update('Enhance', $enhance);

		return true;
	}

	public function aprobar($tipo, $id_enhance)
	{
		$campana = $this->enhance_modelo->obtener_enhance_admin($tipo, $id_enhance);
        $tienda = $this->tienda_m->obtener_tienda_por_id_dueno($campana[0]->id_cliente);
		if(!isset($campana[0])) {
			redirect('administracion/campanas/'.$tipo);
		}

		if($campana[0]->type == 'fijo') {

			$actualizacion				= new stdClass();
			$actualizacion->estatus		= 1;
			$this->db->where('id_enhance', $id_enhance);
			$this->db->update('Enhance', $actualizacion);

			$actualizacion				= new stdClass();
			$actualizacion->estatus		= 1;
			$this->db->where('id_parent_enhance', $id_enhance);
			$this->db->update('Enhance', $actualizacion);

			$slug = 'venta-inmediata';

			// Se envía correo de aprobacion de campana
			$datos_correo = new stdClass();
			$datos_correo->nombre = $campana[0]->nombres.' '.$campana[0]->apellidos;
			$datos_correo->email = $campana[0]->email;
			$datos_correo->nombre_campana = $campana[0]->name;
            $datos_correo->vinculo = site_url('tienda/'.$tienda->nombre_tienda_slug.'/'.$slug.'/'.strtolower(url_title(convert_accented_characters(trim($campana[0]->name)))).'-'.$campana[0]->id_enhance);
			//$datos_correo->vinculo = site_url('compra/'.$slug.'/'.strtolower(url_title(convert_accented_characters(trim($campana[0]->name)))).'-'.$campana[0]->id_enhance);

			// Se inicializa Sendgrid
			$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
			$email = new SendGrid\Email();
			$email->addTo($datos_correo->email, $datos_correo->nombre)
				  ->setFrom('administracion@printome.mx')
				  ->setReplyTo('administracion@printome.mx')
				  ->setFromName('printome.mx')
				  ->setSubject('¡Felicidades! Tu producto ya se encuentra a la venta en nuestra plataforma.')
				  ->setHtml($this->load->view('plantillas_correos/nuevas/admin_aprobar_fijo', $datos_correo, TRUE))
			;
			$sendgrid->send($email);

		} else if($campana[0]->type == 'limitado') {
			$dias = (((strtotime($campana[0]->end_date) - strtotime($campana[0]->date))/24)/60)/60;

			$fecha_actual = date("Y-m-d H:i:s");
			$fecha_final = date("Y-m-d H:i:s", strtotime("+".$campana[0]->days." days"));

			$actualizacion				= new stdClass();
			$actualizacion->date 		= $fecha_actual;
			$actualizacion->end_date	= $fecha_final;
			$actualizacion->estatus		= 1;

			$this->db->where('id_enhance', $id_enhance);
			$this->db->update('Enhance', $actualizacion);

			$actualizacion				= new stdClass();
			$actualizacion->date 		= $fecha_actual;
			$actualizacion->end_date	= $fecha_final;
			$actualizacion->estatus		= 1;

			$this->db->where('id_parent_enhance', $id_enhance);
			$this->db->update('Enhance', $actualizacion);

			$slug = 'plazo-definido';
			// Se envía correo de aprobacion de campana
			$datos_correo = new stdClass();
			$datos_correo->nombre = $campana[0]->nombres.' '.$campana[0]->apellidos;
			$datos_correo->email = $campana[0]->email;
			$datos_correo->nombre_campana = $campana[0]->name;
			//$datos_correo->vinculo = site_url('compra/'.$slug.'/'.strtolower(url_title(convert_accented_characters(trim($campana[0]->name)))).'-'.$campana[0]->id_enhance);
            $datos_correo->vinculo = site_url('tienda/'.$tienda->nombre_tienda_slug.'/'.$slug.'/'.strtolower(url_title(convert_accented_characters(trim($campana[0]->name)))).'-'.$campana[0]->id_enhance);
            $datos_correo->fecha_inicio = date("d/m/Y H:i", strtotime($actualizacion->date));
			$datos_correo->fecha_final = date("d/m/Y H:i", strtotime($actualizacion->end_date));
			$datos_correo->dias = $campana[0]->days;

			// Se inicializa Sendgrid
			$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
			$email = new SendGrid\Email();
			$email->addTo($datos_correo->email, $datos_correo->nombre)
				  ->setFrom('administracion@printome.mx')
				  ->setReplyTo('administracion@printome.mx')
				  ->setFromName('printome.mx')
				  ->setSubject('¡Felicidades! Tu producto ya se encuentra a la venta en nuestra plataforma.')
				  ->setHtml($this->load->view('plantillas_correos/nuevas/admin_aprobar_limitado', $datos_correo, TRUE))
			;
			$sendgrid->send($email);
		}
		redirect('administracion/campanas/'.$tipo.'/editar/'.$id_enhance);
	}

	public function rechazar($tipo, $id_enhance)
	{
		$campana = $this->enhance_modelo->obtener_enhance_admin($tipo, $id_enhance);
		if(!isset($campana[0])) {
			redirect('administracion/campanas');
		}

		$actualizacion				= new stdClass();
		$actualizacion->additional_info = 'Motivo del rechazo: '.$this->input->post('motivo');
		$actualizacion->estatus		= 2;
		$this->db->where('id_enhance', $id_enhance);
		$this->db->update('Enhance', $actualizacion);

		$actualizacion				= new stdClass();
		$actualizacion->additional_info = 'Motivo del rechazo: '.$this->input->post('motivo');
		$actualizacion->estatus		= 2;
		$this->db->where('id_parent_enhance', $id_enhance);
		$this->db->update('Enhance', $actualizacion);

		// Se envía correo de aprobacion de campana
		$datos_correo = new stdClass();
		$datos_correo->nombre = $campana[0]->nombres.' '.$campana[0]->apellidos;
		$datos_correo->email = $campana[0]->email;
		$datos_correo->nombre_campana = $campana[0]->name;
		$datos_correo->motivo = $this->input->post('motivo');

		// Se inicializa Sendgrid
		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
		$email = new SendGrid\Email();
		$email->addTo($datos_correo->email, $datos_correo->nombre)
			  ->setFrom('administracion@printome.mx')
			  ->setReplyTo('administracion@printome.mx')
			  ->setFromName('printome.mx')
			  ->setSubject('Lo sentimos, el producto que diseñaste para printome.mx ha sido rechazado.')
			  ->setHtml($this->load->view('plantillas_correos/nuevas/admin_rechazar_fijo_limitado', $datos_correo, TRUE))
		;
		$sendgrid->send($email);

		redirect('administracion/campanas/'.$tipo.'/editar/'.$id_enhance);
	}

	public function terminar($tipo, $id_enhance)
	{
		$campana = $this->enhance_modelo->obtener_enhance_admin($tipo, $id_enhance);
		if(!isset($campana[0])) {
			redirect('administracion/campanas/'.$tipo);
		}

		$actualizacion				= new stdClass();
		$actualizacion->additional_info = 'Motivo de la terminación: '.$this->input->post('motivo');
		$actualizacion->estatus		= 3;
		$actualizacion->end_date	= date("Y-m-d H:i:s");

		$this->db->where('id_enhance', $id_enhance);
		$this->db->update('Enhance', $actualizacion);

		$actualizacion				= new stdClass();
		$actualizacion->additional_info = 'Motivo de la terminación: '.$this->input->post('motivo');
		$actualizacion->estatus		= 3;
		$actualizacion->end_date	= date("Y-m-d H:i:s");

		$this->db->where('id_parent_enhance', $id_enhance);
		$this->db->update('Enhance', $actualizacion);

		// Se envía correo de aprobacion de campana
		$datos_correo = new stdClass();
		$datos_correo->nombre = $campana[0]->nombres.' '.$campana[0]->apellidos;
		$datos_correo->email = $campana[0]->email;
		$datos_correo->nombre_campana = $campana[0]->name;
		$datos_correo->motivo = $this->input->post('motivo');

		// Se inicializa Sendgrid
		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
		$email = new SendGrid\Email();
		$email->addTo($datos_correo->email, $datos_correo->nombre)
			  ->setFrom('administracion@printome.mx')
			  ->setReplyTo('administracion@printome.mx')
			  ->setFromName('printome.mx')
			  ->setSubject('Lo sentimos, tu producto en printome.mx ha sido terminado por nuestro equipo.')
			  ->setHtml($this->load->view('plantillas_correos/nuevas/admin_terminar_fijo_limitado', $datos_correo, TRUE))
		;
		$sendgrid->send($email);

		redirect('administracion/campanas/'.$tipo.'/editar/'.$id_enhance);
	}

	public function borrar($tipo, $id_enhance)
	{
		$campana = $this->enhance_modelo->obtener_enhance_admin($tipo, $id_enhance);
		if(!isset($campana[0])) {
			redirect('administracion/campanas/'.$tipo);
		}

		$actualizacion				= new stdClass();
		$actualizacion->estatus		= 33;

		$this->db->where('id_enhance', $id_enhance);
		$this->db->update('Enhance', $actualizacion);

		$actualizacion				= new stdClass();
		$actualizacion->estatus		= 33;

		$this->db->where('id_parent_enhance', $id_enhance);
		$this->db->update('Enhance', $actualizacion);

		redirect('administracion/campanas/'.$tipo);
	}

	public function producir($tipo, $id_enhance)
	{
		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
		$campana_res = $this->enhance_modelo->obtener_enhance_admin($tipo, $id_enhance);
		$campana = $campana_res[0];
		$corte = $this->enhance_modelo->obtener_corte($id_enhance);

		$datos_correo = new stdClass();
		$datos_correo->nombre = $campana->nombres.' '.$campana->apellidos;
		$datos_correo->email = $campana->email;
		$datos_correo->nombre_campana = $campana->name;
		$datos_correo->fecha_inicio = date("d/m/Y H:i", strtotime($campana->date));
		$datos_correo->fecha_final = date("d/m/Y H:i", strtotime($campana->end_date));
		$datos_correo->dias = $campana->days;

		$datos_correo->vendido = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
		$datos_correo->meta = $campana->quantity;
		$datos_correo->precio = $campana->price;

		$this->db->query("UPDATE CortesPorCampana SET decision_produccion=1, fecha_decision_produccion='".date("Y-m-d H:i:s")."' WHERE id_corte=".$corte->id_corte);

		// Correo para diseñador indicando que su diseño se va a producir
		$email_disenador = new SendGrid\Email();
		$email_disenador->addTo($datos_correo->email, $datos_correo->nombre)
						->setFrom('administracion@printome.mx')
						->setReplyTo('administracion@printome.mx')
						->setFromName('printome.mx')
						->setSubject('Tu diseño "'.$datos_correo->nombre_campana.'" pasará a producción. | printome.mx')
						->setHtml($this->load->view('plantillas_correos/nuevas/admin_finalizar_campana_alcanzo_supero', $datos_correo, TRUE));
		$sendgrid->send($email_disenador);

		// Correo para avisarle a cada persona que compró que se va a producir
		$pedidos = $this->enhance_modelo->obtener_pedidos_por_campana($campana->id_enhance);

		foreach($pedidos as $indice_pedido=>$pedido) {
			$productos_enhance = $this->db->get_where('ProductosPorPedido', array('id_pedido' => $pedido->id_pedido, 'id_enhance' => $campana->id_enhance))->result();

			$info_cliente = $this->db->get_where('Clientes', array('id_cliente' => $pedido->id_cliente))->row();
			$datos_correo->email = $info_cliente->email;
			$datos_correo->nombre = $info_cliente->nombres.' '.$info_cliente->apellidos;

			// Correo para diseñador indicando que su diseño no generó ganancia y no se va a producir
			$email_cliente = new SendGrid\Email();
			$email_cliente->addTo($datos_correo->email, $datos_correo->nombre)
							->setFrom('administracion@printome.mx')
							->setReplyTo('administracion@printome.mx')
							->setFromName('printome.mx')
							->setSubject('¡El producto de plazo definido que compraste pasará a producción! | printome.mx')
							->setHtml($this->load->view('plantillas_correos/nuevas/admin_cliente_producto_si_se_va_a_producir', $datos_correo, TRUE));
			$sendgrid->send($email_cliente);
		}

		redirect('administracion/campanas/'.$tipo.'/editar/'.$id_enhance);
	}

	public function no_producir($tipo, $id_enhance)
	{
		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
		$campana_res = $this->enhance_modelo->obtener_enhance_admin($tipo, $id_enhance);
		$campana = $campana_res[0];
		$corte = $this->enhance_modelo->obtener_corte($id_enhance);

		$datos_correo = new stdClass();
		$datos_correo->nombre = $campana->nombres.' '.$campana->apellidos;
		$datos_correo->email = $campana->email;
		$datos_correo->nombre_campana = $campana->name;
		$datos_correo->fecha_inicio = date("d/m/Y H:i", strtotime($campana->date));
		$datos_correo->fecha_final = date("d/m/Y H:i", strtotime($campana->end_date));
		$datos_correo->dias = $campana->days;

		$datos_correo->vendido = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
		$datos_correo->meta = $campana->quantity;
		$datos_correo->precio = $campana->price;


		$this->db->query("UPDATE CortesPorCampana SET decision_produccion=2, fecha_decision_produccion='".date("Y-m-d H:i:s")."', fecha_pago='".date("Y-m-d H:i:s")."' WHERE id_corte=".$corte->id_corte);

		// Correo para diseñador indicando que su diseño no generó ganancia y no se va a producir
		$email_disenador = new SendGrid\Email();
		$email_disenador->addTo($datos_correo->email, $datos_correo->nombre)
						->setFrom('administracion@printome.mx')
						->setReplyTo('administracion@printome.mx')
						->setFromName('printome.mx')
						->setSubject('Tu diseño "'.$datos_correo->nombre_campana.'" ha finalizado. | printome.mx')
						->setHtml($this->load->view('plantillas_correos/nuevas/admin_finalizar_campana_vendio_pero_negativo', $datos_correo, TRUE));
		$sendgrid->send($email_disenador);

		// Correo para avisarle a cada persona que compró que no se va a producir y devolverle el saldo a favor
		$pedidos = $this->enhance_modelo->obtener_pedidos_por_campana($campana->id_enhance);

		foreach($pedidos as $indice_pedido=>$pedido) {
			$productos_enhance = $this->db->get_where('ProductosPorPedido', array('id_pedido' => $pedido->id_pedido, 'id_enhance' => $campana->id_enhance))->result();

			$cantidad_especifica = 0;
			$monto_especifico = 0.00;
			foreach($productos_enhance as $pe) {
				$cantidad_especifica += $pe->cantidad_producto;
				$monto_especifico += $pe->precio_producto * $pe->cantidad_producto;
			}
			if($cantidad_especifica <= 25) {
				$costo_envio = 99;
			} else {
				$costo_envio = 99 + (($cantidad_especifica-25) * 2);
			}

			$devolucion_total = $monto_especifico + $costo_envio;

			// Devolucion de saldo a favor
			$this->db->query('UPDATE Clientes SET saldo_a_favor = saldo_a_favor + '.$devolucion_total.' WHERE id_cliente='.$pedido->id_cliente);

			$info_cliente = $this->db->get_where('Clientes', array('id_cliente' => $pedido->id_cliente))->row();
			$datos_correo->email = $info_cliente->email;
			$datos_correo->nombre = $info_cliente->nombres.' '.$info_cliente->apellidos;
			$datos_correo->devolucion_total = $devolucion_total;

			// Correo para diseñador indicando que su diseño no generó ganancia y no se va a producir
			$email_cliente = new SendGrid\Email();
			$email_cliente->addTo($datos_correo->email, $datos_correo->nombre)
							->setFrom('administracion@printome.mx')
							->setReplyTo('administracion@printome.mx')
							->setFromName('printome.mx')
							->setSubject('Saldo a favor | printome.mx')
							->setHtml($this->load->view('plantillas_correos/nuevas/admin_devolver_saldo_campana_limitado', $datos_correo, TRUE));
			$sendgrid->send($email_cliente);
		}

		redirect('administracion/campanas/'.$tipo.'/editar/'.$id_enhance);
	}

	public function asignar_pago_limitado($id_enhance)
	{
		if(!$this->input->post('pago_asignado')) {
			redirect('administracion/campanas/limitado/editar/'.$id_enhance.'#fndtn-info_pagos');
		}
		$campana_res = $this->enhance_modelo->obtener_enhance_admin('limitado', $id_enhance);
		$campana = $campana_res[0];
		$pago_asignado = $this->input->post('pago_asignado');

		if($pago_asignado['id_dato_deposito'] != '') {
			$dato_deposito_usado = $this->cuenta_modelo->obtener_dato_deposito_por_id($pago_asignado['id_dato_deposito']);
		}

		$directorio = 'assets/comprobantes';
		if(!file_exists($directorio) and !is_dir($directorio)) {
			mkdir($directorio);
			chmod($directorio, 0755);
		}

		$actualizacion_corte = new stdClass();
		$actualizacion_corte->fecha_pago = date("Y-m-d H:i:s");

		if(isset($_FILES['pago_asignado'])) {
			if($_FILES['pago_asignado']['error']['archivo_pago'] == 0 && $_FILES['pago_asignado']['size']['archivo_pago'] > 0) {
				$config['upload_path'] = $directorio;
				$config['file_ext_tolower'] = TRUE;
				$config['allowed_types'] = 'jpg|png|jpeg|jpe|pdf|doc|docx|tiff|bmp';
				$config['file_name'] = 'comprobante_'.date("YmdHis").'_'.$id_enhance.'_'.$pago_asignado['id_corte'];
				$this->upload->initialize($config);

				$_FILES['userfile']['name'] = $_FILES['pago_asignado']['name']['archivo_pago'];
				$_FILES['userfile']['type'] = $_FILES['pago_asignado']['type']['archivo_pago'];
				$_FILES['userfile']['tmp_name'] = $_FILES['pago_asignado']['tmp_name']['archivo_pago'];
				$_FILES['userfile']['error'] = $_FILES['pago_asignado']['error']['archivo_pago'];
				$_FILES['userfile']['size'] = $_FILES['pago_asignado']['size']['archivo_pago'];

				$this->upload->do_upload();
				$data = $this->upload->data();
				$actualizacion_corte->comprobante_pago = $data['file_name'];
			}
		}

		if($pago_asignado['id_dato_deposito'] != '') {
			$actualizacion_corte->id_dato_deposito = $pago_asignado['id_dato_deposito'];
		}

		$this->db->where('id_corte', $pago_asignado['id_corte']);
		$this->db->update('CortesPorCampana', $actualizacion_corte);

		if(isset($pago_asignado['avisar_persona'])) {
			$datos_correo = new stdClass();
			$datos_correo->nombre = $campana->nombres.' '.$campana->apellidos;
			$datos_correo->email = $campana->email;
			$datos_correo->nombre_campana = $campana->name;
			$datos_correo->monto_corte = $pago_asignado['monto_corte'];
			$datos_correo->tipo_pago = ($pago_asignado['id_dato_deposito'] != '' ? ($dato_deposito_usado->tipo_pago == 'banco' ? 'banco' : 'paypal') : '');

			$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);

			$email_cliente = new SendGrid\Email();
			$email_cliente->addTo($datos_correo->email, $datos_correo->nombre)
							->setFrom('administracion@printome.mx')
							->setReplyTo('administracion@printome.mx')
							->setFromName('printome.mx')
							->setSubject('Ganancias depositadas | printome.mx')
							->setHtml($this->load->view('plantillas_correos/nuevas/admin_aviso_pago_limitado', $datos_correo, TRUE));
			$sendgrid->send($email_cliente);
		}

		redirect('administracion/campanas/limitado/editar/'.$id_enhance.'#fndtn-info_pagos');
	}

	public function asignar_pago_fijo($id_enhance)
	{
		if(!$this->input->post('pago_asignado')) {
			redirect('administracion/campanas/fijo/editar/'.$id_enhance.'#fndtn-cortes_semanales');
		}
		$campana_res = $this->enhance_modelo->obtener_enhance_admin('fijo', $id_enhance);
		$campana = $campana_res[0];
		$pago_asignado = $this->input->post('pago_asignado');

		if($pago_asignado['id_dato_deposito'] != '') {
			$dato_deposito_usado = $this->cuenta_modelo->obtener_dato_deposito_por_id($pago_asignado['id_dato_deposito']);
		}


		$directorio = 'assets/comprobantes';
		if(!file_exists($directorio) and !is_dir($directorio)) {
			mkdir($directorio);
			chmod($directorio, 0755);
		}

		$actualizacion_corte = new stdClass();
		$actualizacion_corte->fecha_pago = date("Y-m-d H:i:s");

		if(isset($_FILES['pago_asignado'])) {
			if($_FILES['pago_asignado']['error']['archivo_pago'] == 0 && $_FILES['pago_asignado']['size']['archivo_pago'] > 0) {
				$config['upload_path'] = $directorio;
				$config['file_ext_tolower'] = TRUE;
				$config['allowed_types'] = 'jpg|png|jpeg|jpe|pdf|doc|docx|tiff|bmp';
				$config['file_name'] = 'comprobante_'.date("YmdHis").'_'.$id_enhance.'_'.$pago_asignado['id_corte'];
				$this->upload->initialize($config);

				$_FILES['userfile']['name'] = $_FILES['pago_asignado']['name']['archivo_pago'];
				$_FILES['userfile']['type'] = $_FILES['pago_asignado']['type']['archivo_pago'];
				$_FILES['userfile']['tmp_name'] = $_FILES['pago_asignado']['tmp_name']['archivo_pago'];
				$_FILES['userfile']['error'] = $_FILES['pago_asignado']['error']['archivo_pago'];
				$_FILES['userfile']['size'] = $_FILES['pago_asignado']['size']['archivo_pago'];

				$this->upload->do_upload();
				$data = $this->upload->data();
				$actualizacion_corte->comprobante_pago = $data['file_name'];
			}
		}

		if($pago_asignado['id_dato_deposito'] != '') {
			$actualizacion_corte->id_dato_deposito = $pago_asignado['id_dato_deposito'];
		}

		$this->db->where('id_corte', $pago_asignado['id_corte']);
		$this->db->update('CortesPorCampana', $actualizacion_corte);

		if(isset($pago_asignado['avisar_persona'])) {
			$datos_correo = new stdClass();
			$datos_correo->nombre = $campana->nombres.' '.$campana->apellidos;
			$datos_correo->email = $campana->email;
			$datos_correo->nombre_campana = $campana->name;
			$datos_correo->monto_corte = $pago_asignado['monto_corte'];
			$datos_correo->tipo_pago = ($pago_asignado['id_dato_deposito'] != '' ? ($dato_deposito_usado->tipo_pago == 'banco' ? 'banco' : 'paypal') : '');

			$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);

			$email_cliente = new SendGrid\Email();
			$email_cliente->addTo($datos_correo->email, $datos_correo->nombre)
							->setFrom('administracion@printome.mx')
							->setReplyTo('administracion@printome.mx')
							->setFromName('printome.mx')
							->setSubject('Ganancias depositadas | printome.mx')
							->setHtml($this->load->view('plantillas_correos/nuevas/admin_aviso_pago_fijo', $datos_correo, TRUE));
			$sendgrid->send($email_cliente);
		}

		redirect('administracion/campanas/fijo/editar/'.$id_enhance.'#fndtn-cortes_semanales');
	}
}
