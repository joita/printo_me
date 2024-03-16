<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ac extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

    function cupon()
    {
        $new_contact = new stdClass();
        $new_contact->name = $this->input->post('nombre');
        $new_contact->email = $this->input->post('email');

        if($new_contact->name == '' || $new_contact->email == '') {
            return false;
        } else {
            $contact_exists = new stdClass();
            $response = new stdClass();
            $contact_exists = $this->ac->api("contact/view?email=".$new_contact->email);
            $datos = array(
                'first_name'    => $new_contact->name,
                'email'         => $new_contact->email,
                'p[14]'         => 14,
                'status[14]'    => 1
            );

            $datos_correo = new stdClass();
            $datos_correo->nombre = $new_contact->name;

            $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
            $email = new SendGrid\Email();
            $email->addTo($new_contact->email, $new_contact->name)
                ->setFrom('hello@printome.mx')
                ->setFromName('printome.mx')
                ->setSubject('Gracias por registrarte! | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_registro_temporal', $datos_correo, TRUE))
            ;
            $sendgrid->send($email);

    		if(!isset($contact_exists->id)){
                $response = $this->ac->api('contact/add', $datos);
                $response->success = 1;
                $respuesta['estatus'] = 'exitoso';
                $respuesta['mensaje'] = '¡Vía correo electrónico recibirás tu cupón! No olvides revisar tu bandeja de spam y correos no deseados, a veces no llega inmediato.';
    		} else {
                $response = $this->ac->api('contact/sync', $datos);
                $response->success = 1;
                $respuesta['estatus'] = 'exitoso';
                $respuesta['mensaje'] = '¡Vía correo electrónico recibirás tu cupón! No olvides revisar tu bandeja de spam y correos no deseados, a veces no llega inmediato.';
            }

            if(!$this->session->has_userdata('login')) {
                $datos = new stdClass();
                $datos->email_cliente = $new_contact->email;

                $items = array();
                foreach($this->cart->contents() as $cart_item) {
                    $item = array(
                        'id'		=> $cart_item['id'],
                        'qty'		=> $cart_item['qty'],
                        'price'		=> $cart_item['price'],
                        'name'		=> $cart_item['name'],
                        'options'	=> $cart_item['options']
                    );

                    array_push($items, $item);
                }
                $datos->carrito_en_sesion = json_encode($items);
                $datos->carrito_fecha_actualizacion = date("Y-m-d H:i:s");

                $existe_temporal = $this->db->get_where('ClientesInvitados', array('email_cliente' => $new_contact->email))->row();
                if(isset($existe_temporal->email_cliente)) {
                    $this->db->where('email_cliente', $new_contact->email);
                    $this->db->update('ClientesInvitados', $datos);
                } else {
                    $this->db->insert('ClientesInvitados', $datos);
                }

                $this->session->set_userdata('correo_temporal', $datos->email_cliente);
                $this->session->set_userdata('cupon_solicitado', true);
            }

    		if($response->success == 1) {
                echo json_encode($respuesta);
    		} else {
                $respuesta['estatus'] = 'error';
                $respuesta['mensaje'] = 'Ha ocurrido algún error, por favor intenta nuevamente.';
    			echo json_encode($respuesta);
    		}
        }
    }

    public function ocultar_temporalmente_cupon()
    {
        $this->session->set_tempdata('ocultar_cupon_5_min', true, 300);
    }

    public function carrito_abandonado_invitado($email, $carrito, $id_cliente, $fecha_actualizacion, $fecha_abandono)
    {
//        if(!isset($carrito)) {
//            return false;
//        } else {
//			if($carrito != '' && $carrito != '[]') {
//	            $carrito = json_decode($carrito);
//	            $productos = array();
//
//	            $previous_des_id = '';
//	            $previous_id = 0;
//	            $previous_cam_id = 0;
//
//	            foreach($carrito as $producto) {
//	                if(isset($producto->options->id_diseno)) {
//	                    if($previous_des_id == $producto->options->id_diseno) {
//	                        if($producto->id != $previous_id) {
//	                            array_push($productos, site_url($producto->options->disenos->images->front));
//	                            $previous_id = $producto->id;
//	                        }
//	                    } else {
//	                        array_push($productos, site_url($producto->options->disenos->images->front));
//	                        $previous_des_id = $producto->options->id_diseno;
//	                        $previous_id = $producto->id;
//	                    }
//	                } else {
//	                    if($previous_cam_id != $producto->options->id_enhance) {
//	                        array_push($productos, site_url($producto->options->images->front));
//	                        $previous_cam_id = $producto->options->id_enhance;
//	                    }
//	                }
//	            }
//
//	            $html = '<table border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
//	        		<tr>
//	        			<td align="left" style="color: inherit; font-size: inherit; font-weight: inherit; line-height: 1; text-decoration: inherit; font-family: Arial;" valign="top">
//	        				<div style="margin: 0; outline: none; padding: 0;">';
//	        					$filas = ceil(sizeof($productos)/3);
//	        					$html .= '<table style="width:100%;">';
//	        					for($i = 0; $i < $filas; $i++) {
//	        						$html .= '<tr colspan="3">';
//	        						for($j = 0; $j < 3; $j++) {
//	        							if(isset($productos[($i*3)+$j])) {
//	        								$html .= '<td width="33%" style="text-align:center;"><img src="'.$productos[($i*3)+$j].'" style="width:100%;height:auto;max-width:200px" /></td>';
//	        							}
//	        						}
//	        						$html .= '</tr>';
//	        					}
//	        					$html .= '</table>
//							</div>
//	        			</td>
//	        		</tr>
//	        	</table>';
//
//	            $params = [
//	    			'email' => $email,
//	    			'field[1,0]' => $html
//	    		];
//
//	    		$persona_update = $this->ac->api('contact/sync', $params);
//
//				sleep(1);
//			}
//        }
        $date = new DateTime();
        $productos = json_decode($carrito);
        $timestamp = $date->getTimestamp();
        $carrito_abandonado = new stdClass();
        $total_price = 0;


        $carrito_abandonado->externalcheckoutid = $timestamp."_".$id_cliente;
        $carrito_abandonado->source = "1";
        $carrito_abandonado->email = $email;
        $carrito_abandonado->orderProducts = array();
        foreach ($productos as $indice => $producto){
            $prod = new stdClass();
            if($producto->options->enhance){
                $enhance = $this->db->get_where('Enhance', array('id_enhance' => (int)$producto->options->id_enhance))->row();
                $prod->productoUrl = $this->enhance_modelo->obtener_link_ehnance($producto->options->id_enhance);
                $prod->externalid = (string)$producto->options->id_enhance;
                $prod->description = $enhance->description;
                $prod->imageUrl = site_url($producto->options->images->front);
            }else{
                $prod->externalid = 'Producto Personalizado';
                $prod->description = 'Producto Personalizado';
                $prod->productUrl = '';
                $prod->imageUrl = site_url($producto->options->disenos->images->front);
            }
            $prod->name = $producto->name;
            $prod->price = (string)number_format($producto->price, 2, '.', '') * 100;
            $prod->quantity = (string)$producto->qty;
            $prod->category = 'Apparel > Accessories > Clothing';
            array_push($carrito_abandonado->orderProducts, $prod);
            $total_price += number_format($producto->price, 2, '.', '') * 100;
        }
        $carrito_abandonado->externalCreatedDate = $fecha_actualizacion;
        $carrito_abandonado->externalUpdatedDate = $fecha_actualizacion;
        $carrito_abandonado->abandonedDate = $fecha_abandono;
        $carrito_abandonado->currency = "MXN";
        $carrito_abandonado->connectionid = "1";
        $carrito_abandonado->totalPrice = $total_price;

        $cliente_ac = $this->active->obtener_clientes(array('email' => $email, 'connectionid' => 1));
        if($cliente_ac->meta->total != 0) {
            $carrito_abandonado->customerid = (string)$cliente_ac->ecomCustomers[0]->id;
        }else{
            $ver = $this->active->crear_cliente(1, $email, $email);
            if($ver) {
                $nuevo_cliente = $this->active->obtener_clientes(array('email' => $email, 'connectionid' => 1));
                $carrito_abandonado->customerid = (string)$nuevo_cliente->ecomCustomers[0]->id;
            }
        }

        $res = $this->active->client->request('POST', $this->active->get_active_url_v3().'/ecomOrders', [
            'headers' => [
                'Api-Token' => $this->active->get_active_key(),
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'ecomOrder' => $carrito_abandonado
            ]
        ]);
    }

	public function actualizar_clientes_invitados()
	{
		$fecha = date("Y-m-d H:i:s");

		$this->db->select('ClientesInvitados.*')
				 ->from('ClientesInvitados')
				 ->where('carrito_en_sesion !=', '[]')
				 ->where('carrito_en_sesion !=', '')
				 ->where('carrito_en_sesion IS NOT NULL')
				 ->where('cronjob', 0)
				 ->where('TIME_TO_SEC(TIMEDIFF("'.$fecha.'",ClientesInvitados.carrito_fecha_actualizacion))/3600 >', 2.00);

		$clientes_invitados = $this->db->get()->result();

		if(sizeof($clientes_invitados) > 0) {
			foreach($clientes_invitados as $cliente_invitado) {
                $fecha_abandono = date("Y-m-d H:i:s");
				$this->carrito_abandonado_invitado($cliente_invitado->email_cliente, $cliente_invitado->carrito_en_sesion, $cliente_invitado->email_cliente, $cliente_invitado->carrito_fecha_actualizacion, $fecha_abandono);
				sleep(1);
				ac_agregar_etiqueta($cliente_invitado->email_cliente, 'abandono-carrito');

				$info_nuevo = new stdClass();
				$info_nuevo->cronjob = 1;
				$info_nuevo->fecha_ejecucion_cronjob = $fecha_abandono;
				$this->db->where('email_cliente', $cliente_invitado->email_cliente);
				$this->db->update('ClientesInvitados', $info_nuevo);
			}
		} else {
			return false;
		}
	}

	public function actualizar_clientes_registrados()
	{
		$fecha = date("Y-m-d H:i:s");

		$this->db->select('Clientes.*')
				 ->from('Clientes')
				 ->where('carrito_en_sesion !=', '[]')
				 ->where('carrito_en_sesion !=', '')
				 ->where('carrito_en_sesion IS NOT NULL')
				 ->where('abandono_numero_envio', 0)
				 ->where('TIME_TO_SEC(TIMEDIFF("'.$fecha.'",Clientes.carrito_fecha_actualizacion))/3600 >', 2.00);

		$clientes_registrados = $this->db->get()->result();
		if(sizeof($clientes_registrados) > 0) {
			foreach($clientes_registrados as $cliente_registrado) {
			    $fecha_abandono = date("Y-m-d H:i:s");
				$this->carrito_abandonado_invitado($cliente_registrado->email, $cliente_registrado->carrito_en_sesion, $cliente_registrado->id_cliente, $cliente_registrado->carrito_fecha_actualizacion, $fecha_abandono);
				sleep(1);
				ac_agregar_etiqueta($cliente_registrado->email, 'abandono-carrito');

				$info_nuevo = new stdClass();
				$info_nuevo->abandono_numero_envio = 1;
				$info_nuevo->abandono_fecha_envio = $fecha_abandono;

				$this->db->where('email', $cliente_registrado->email);
				$this->db->update('Clientes', $info_nuevo);
			}
		} else {
			return false;
		}
	}

    public function clear_session()
    {
        $this->session->unset_userdata('correo_temporal');
        $this->session->unset_userdata('cupon_solicitado');
    }

    public function generar_thumbs_productos_printome($numero)
    {
        if($numero > 20) {
            echo 'El número máximo es de 20 productos.';
        } else {
            $enhances = $this->enhance_modelo->obtener_campanas_printome($numero);
            $this->load->view('ac/ultimos_productos_printome', array('enhances' => $enhances));
        }

    }
	
	public function obtener_publicaciones_blog_printome($numero) {
		if($numero > 20) {
            echo 'El número máximo es de 20 productos.';
        } else {
			$articulos = $this->enhance_modelo->obtener_publicaciones_blog_printome($numero);
			$this->load->view('ac/ultimas_publicaciones_blog_printome', array('articulos' => $articulos));
		}
	}
	
	public function obtener_plantilla_mensual($numero_productos = 6, $numero_articulos = 4) 
	{
		$enhances = $this->enhance_modelo->obtener_campanas_printome($numero_productos);
		$articulos = $this->enhance_modelo->obtener_publicaciones_blog_printome($numero_articulos);
		$this->load->view('ac/nueva_plantilla', array('enhances' => $enhances, 'articulos' => $articulos));
	}
}
