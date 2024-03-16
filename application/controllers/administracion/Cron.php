<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MY_Controller {

	// Proceso de cron para enviar el correo de las campañas vencidas, falta crear el cronjob.
	public function finalizar_campanas()
	{
		// Se inicializa Sendgrid
		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
		$campanas = $this->enhance_modelo->obtener_campanas_finalizadas();

		foreach($campanas as $indice=>$campana) {

			$actualizacion				= new stdClass();
			$actualizacion->additional_info = 'Finalización: Terminó el período de campaña.';
			$actualizacion->cron		= 1;

			$this->db->where('id_enhance', $campana->id_enhance);
			$this->db->update('Enhance', $actualizacion);

			// Obtener productos hijos
			$otros_productos = $this->enhance_modelo->obtener_colores_disponibles_por_enhance($campana->id_enhance);
			foreach($otros_productos as $otro_producto) {
				$actualizacion				= new stdClass();
				$actualizacion->additional_info = 'Finalización: Terminó el período de campaña.';
				$actualizacion->cron		= 1;

				$this->db->where('id_enhance', $otro_producto->id_enhance);
				$this->db->update('Enhance', $actualizacion);
			}

			// Se envía correo de aprobacion de campana
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

			$corte = new stdClass();
			$corte->id_enhance = $campana->id_enhance;
			$corte->tipo_campana = 'limitado';
			$corte->fecha_inicio_corte = $campana->date;
			$corte->fecha_final_corte = $campana->end_date;
			if($datos_correo->vendido == 0) {
				// Si no ha vendido nada crea un corte en ceros
				$corte->monto_corte = 0.00;
				$corte->productos_vendidos = 0;
				$corte->fecha_creacion = date("Y-m-d H:i:s");
				$corte->fecha_pago = date("Y-m-d H:i:s");
				$this->db->insert('CortesPorCampana', $corte);

				$email_disenador = new SendGrid\Email();
				$email_disenador->addTo($datos_correo->email, $datos_correo->nombre)
								->setFrom('administracion@printome.mx')
								->setReplyTo('administracion@printome.mx')
								->setFromName('printome.mx')
								->setSubject('Tu diseño "'.$datos_correo->nombre_campana.'" ha finalizado. | printome.mx')
								->setHtml($this->load->view('plantillas_correos/nuevas/admin_finalizar_campana_no_vendio', $datos_correo, TRUE));
				$sendgrid->send($email_disenador);

			} else if($datos_correo->vendido > 0) {
				$color = $this->db->get_where('ColoresPorProducto', array('id_color' => $campana->id_color))->row();
				if($color->codigo_color == '#FFFFFF') { $esBlanca = true; } else { $esBlanca = false; }
				if($campana->quantity >= $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance)) {
					$base_estimacion = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
					$cantidad_vendida = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
				} else {
					$base_estimacion = $campana->quantity;
					$cantidad_vendida = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
				}
				$colores_lados = json_decode($campana->colores, TRUE);
				$costo_real = getCost(array('front' => sizeof($colores_lados['front']), 'back' => sizeof($colores_lados['back']), 'left' => sizeof($colores_lados['left']), 'right' => sizeof($colores_lados['right'])), $esBlanca, $base_estimacion, $color->precio);

                if($campana->id_cliente == 2003 || $campana->id_cliente == 1) {
                    $ganancia_real = ((($campana->price-$costo_real)/1.16)*0.9)*$cantidad_vendida;
                } else {
                    $ganancia_real = ((($campana->price-$costo_real)/1.16)*0.75)*$cantidad_vendida;
                }
				//$ganancia_real = ((($campana->price-$costo_real)/1.16)*0.75)*$cantidad_vendida;

				$corte->productos_vendidos = $datos_correo->vendido;

				if($ganancia_real < 0.00) {
					$corte->monto_corte = $ganancia_real;
					$corte->fecha_creacion = date("Y-m-d H:i:s");
					$corte->fecha_pago = date("Y-m-d H:i:s");

					$this->db->insert('CortesPorCampana', $corte);

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


				} else if($ganancia_real == 0.00) {
					$corte->monto_corte = $ganancia_real;
					$corte->fecha_creacion = date("Y-m-d H:i:s");

					$datos_correo = new stdClass();
					$datos_correo->folio = $campana->id_enhance;
					$datos_correo->name = $campana->name;
					$datos_correo->ganancia_real = $ganancia_real;

					$email_cliente = new SendGrid\Email();
					$email_cliente->addTo('administracion@printome.mx', 'Administración Printome')
									->setFrom('no-reply@printome.mx')
									->setReplyTo('administracion@printome.mx')
									->setFromName('printome.mx')
									->setSubject('Finalización de producto de plazo definido | printome.mx')
									->setHtml($this->load->view('plantillas_correos/nuevas/admin_aviso_corte_limitado', $datos_correo, TRUE));
					$sendgrid->send($email_cliente);

					$this->db->insert('CortesPorCampana', $corte);
				} else if($ganancia_real > 0.00) {
					$corte->monto_corte = $ganancia_real;
					$corte->fecha_creacion = date("Y-m-d H:i:s");

					$datos_correo = new stdClass();
					$datos_correo->folio = $campana->id_enhance;
					$datos_correo->name = $campana->name;
					$datos_correo->ganancia_real = $ganancia_real;

					$email_cliente = new SendGrid\Email();
					$email_cliente->addTo('administracion@printome.mx', 'Administración Printome')
									->setFrom('no-reply@printome.mx')
									->setReplyTo('administracion@printome.mx')
									->setFromName('printome.mx')
									->setSubject('Finalización de producto de plazo definido | printome.mx')
									->setHtml($this->load->view('plantillas_correos/nuevas/admin_aviso_corte_limitado', $datos_correo, TRUE));
					$sendgrid->send($email_cliente);

					$this->db->insert('CortesPorCampana', $corte);
				}
			}

			/* $email = new SendGrid\Email();
			$email->addTo($datos_correo->email, $datos_correo->nombre)
				  ->setFrom('administracion@printome.mx')
				  ->setReplyTo('administracion@printome.mx')
				  ->setFromName('printome.mx')
				  ->setSubject('Tu diseño "'.$datos_correo->nombre_campana.'" ha finalizado. | printome.mx');

			if($datos_correo->vendido == 0) {
				$email->setHtml($this->load->view('plantillas_correos/nuevas/admin_finalizar_campana_no_vendio', $datos_correo, TRUE));
			} else if($datos_correo->vendido > 0 && $datos_correo->vendido < $campana->quantity) {
				$email->setHtml($this->load->view('plantillas_correos/nuevas/admin_finalizar_campana_no_alcanzo', $datos_correo, TRUE));
			} else if($datos_correo->vendido >= $campana->quantity) {
				$email->setHtml($this->load->view('plantillas_correos/nuevas/admin_finalizar_campana_alcanzo_supero', $datos_correo, TRUE));
			}

			$sendgrid->send($email); */
		}
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

	public function generar_cortes_historicos()
	{
		$campanas_activas = $this->catalogo_modelo->obtener_enhanced('fijo');

		$fechas = array(
			array(
				'inicio' => date("Y-m-d H:i:s", strtotime('2017-02-03 00:00:00')),
				'final'	 => date("Y-m-d H:i:s", strtotime('2017-02-09 23:59:59'))
			)
		);

		for($i=1;$i<=6;$i++) {
			$fechas[$i]['inicio'] = date("Y-m-d H:i:s", strtotime("+7 days", strtotime($fechas[$i-1]['inicio'])));
			$fechas[$i]['final']  = date("Y-m-d H:i:s", strtotime("+7 days", strtotime($fechas[$i-1]['final'])));
		}

		foreach($campanas_activas as $campana) {
			foreach($fechas as $fecha) {
				$pedidos_por_fecha = $this->enhance_modelo->obtener_pedidos_por_campana_por_rango($campana->id_enhance, $fecha['inicio'], $fecha['final']);

				$cantidad_especifica = 0;
				$monto_especifico = 0.00;

				foreach($pedidos_por_fecha as $pedido) {
					$productos_enhance = $this->db->get_where('ProductosPorPedido', array('id_pedido' => $pedido->id_pedido, 'id_enhance' => $campana->id_enhance))->result();
					foreach($productos_enhance as $pe) {
						$cantidad_especifica += $pe->cantidad_producto;
						$monto_especifico += $pe->precio_producto * $pe->cantidad_producto;
					}
				}

				$ganancia_real = ((($campana->price-$campana->costo)/1.16)*0.75)*$cantidad_especifica;

				$this->db->select('*')
						 ->from('CortesPorCampana')
						 ->where('id_enhance', $campana->id_enhance)
						 ->where('fecha_inicio_corte <=', $fecha['final'])
						 ->where('fecha_final_corte >', $fecha['inicio'])
						 ->where('tipo_campana', 'fijo');
				$check = $this->db->get()->row();

				if(!isset($check->id_corte)) {
					$corte = new stdClass();
					$corte->id_enhance = $campana->id_enhance;
					$corte->fecha_inicio_corte = $fecha['inicio'];
					$corte->fecha_final_corte = $fecha['final'];
					$corte->monto_corte = $ganancia_real;
					$corte->productos_vendidos = $cantidad_especifica;
					$corte->fecha_creacion = date("Y-m-d H:i:s");
					$corte->tipo_campana = 'fijo';
					$corte->decision_produccion = 1;
					$corte->fecha_decision_produccion = date("Y-m-d H:i:s");

					if($ganancia_real == 0) {
						$corte->fecha_pago = date("Y-m-d H:i:s");
					}

					$this->db->insert('CortesPorCampana', $corte);
				}
			}
		}
	}

	public function generar_cortes_semanales()
	{
		$day = 6;
		$inicio_default = new DateTime(date('Y-m-d', strtotime('previous saturday')));
		$final_default = new DateTime(date('Y-m-d', strtotime('previous friday')));
		
		$inicio_default->setTime(00, 00, 00);
		$final_default->setTime(23, 59, 59);
		
		$campanas_activas = $this->catalogo_modelo->obtener_enhanced_sin_diseno('fijo');

		foreach($campanas_activas as $campana) {
			$pedidos_por_fecha = $this->enhance_modelo->obtener_pedidos_por_campana_por_rango($campana->id_enhance, $inicio_default->format('Y-m-d H:i:s'), $final_default->format('Y-m-d H:i:s'));

			$cantidad_especifica = 0;
			$monto_especifico = 0.00;

			foreach($pedidos_por_fecha as $pedido) {

				$this->db->select('ProductosPorPedido.*, Enhance.*')
						 ->from('ProductosPorPedido')
						 ->join('Enhance', 'Enhance.id_enhance=ProductosPorPedido.id_enhance')
						 ->where('ProductosPorPedido.id_pedido', $pedido->id_pedido)
						 ->group_start()
						 	->or_where('ProductosPorPedido.id_enhance', $campana->id_enhance)
							->or_where('Enhance.id_parent_enhance', $campana->id_enhance)
						 ->group_end();
				$productos_enhance = $this->db->get()->result();

				foreach($productos_enhance as $pe) {
					$cantidad_especifica += $pe->cantidad_producto;
					$monto_especifico += $pe->precio_producto * $pe->cantidad_producto;
				}
			}

            if($campana->id_cliente == 2003 || $campana->id_cliente == 1) {
                $ganancia_real = ((($campana->price-$campana->costo)/1.16)*0.9)*$cantidad_especifica;
            } else {
                $ganancia_real = ((($campana->price-$campana->costo)/1.16)*0.75)*$cantidad_especifica;
            }
			//$ganancia_real = ((($campana->price-$campana->costo)/1.16)*0.75)*$cantidad_especifica;

			$this->db->select('*')
					 ->from('CortesPorCampana')
					 ->where('id_enhance', $campana->id_enhance)
					 ->where('fecha_inicio_corte', $inicio_default->format('Y-m-d H:i:s'))
					 ->where('fecha_final_corte', $final_default->format('Y-m-d H:i:s'))
					 ->where('tipo_campana', 'fijo');
			$check = $this->db->get()->row();

			if(!isset($check->id_corte)) {
				$corte = new stdClass();
				$corte->id_enhance = $campana->id_enhance;
				$corte->fecha_inicio_corte = $inicio_default->format('Y-m-d H:i:s');
				$corte->fecha_final_corte = $final_default->format('Y-m-d H:i:s');
				$corte->monto_corte = $ganancia_real;
				$corte->productos_vendidos = $cantidad_especifica;
				$corte->fecha_creacion = date("Y-m-d H:i:s");
				$corte->tipo_campana = 'fijo';
				$corte->decision_produccion = 1;
				$corte->fecha_decision_produccion = date("Y-m-d H:i:s");

				if($ganancia_real == 0) {
					$corte->fecha_pago = date("Y-m-d H:i:s");
				}

				$this->db->insert('CortesPorCampana', $corte);
			}
		}

		$datos['campanas_por_pagar'] = $this->enhance_modelo->obtener_campanas_fijas_por_estatus('pagar', 1000, 0, array(), null);

		if(sizeof($datos['campanas_por_pagar']) > 0) {
			// Se inicializa Sendgrid
			$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);

			$email_administracion = new SendGrid\Email();
			$email_administracion->addTo('administracion@printome.mx', 'Administración Printome')
								 ->setFrom('no-reply@printome.mx')
								 ->setReplyTo('administracion@printome.mx')
								 ->setFromName('Tienda en línea printome.mx')
								 ->setSubject('¡Pendiente por pagar de ventas inmediatas! | printome.mx')
								 ->setHtml($this->load->view('plantillas_correos/nuevas/reporte_pendientes_pagar', $datos, TRUE));
			$sendgrid->send($email_administracion);
		}
	}
}
