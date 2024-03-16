<?php

use SendGrid\Email;

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MY_Controller {

	function __construct() {
		parent::__construct();
		//if (!$this->input->is_cli_request()) show_error('Direct access is not allowed');
	}

    public function limpiar_desde_2019_campanas()
    {
        $meses = array(
            '201601', '201602', '201603', '201604', '201605', '201606', '201607', '201608', '201609', '201610', '201611', '201612',
            '201701', '201702', '201703', '201704', '201705', '201706', '201707'
        );

        foreach($meses as $mes){
            $this->limpiar_campanas($mes);
        }
    }

    public function limpiar_campanas($aniomes)
    {
        $this->db->select('*')
                 ->from('Enhance')
                 ->where('EXTRACT(YEAR_MONTH FROM date) = \''.$aniomes.'\'')
                 ->where('estatus', 33);

        $campanas = $this->db->get()->result();

        foreach($campanas as $indice_campana => $campana) {
            $campanas[$indice_campana]->design = json_decode($campana->design);
        }

        $imagenes_a_borrar = array();
        foreach($campanas as $indice_campana => $campana) {
            $imagenes_a_borrar[$campana->id_enhance] = array();
            array_push($imagenes_a_borrar[$campana->id_enhance], $campana->front_image);
            array_push($imagenes_a_borrar[$campana->id_enhance], $campana->back_image);
            array_push($imagenes_a_borrar[$campana->id_enhance], $campana->left_image);
            array_push($imagenes_a_borrar[$campana->id_enhance], $campana->right_image);

            foreach($campana->design->front as $arte) {
                if($arte->type == 'clipart') {
                    if($arte->file->type == 'image') {
                        array_push($imagenes_a_borrar[$campana->id_enhance], str_replace(base_url(), '', $arte->thumb));
                        array_push($imagenes_a_borrar[$campana->id_enhance], str_replace(base_url(), '', $arte->url));
                    }
                }
            }
            foreach($campana->design->back as $arte) {
                if($arte->type == 'clipart') {
                    if($arte->file->type == 'image') {
                        array_push($imagenes_a_borrar[$campana->id_enhance], str_replace(base_url(), '', $arte->thumb));
                        array_push($imagenes_a_borrar[$campana->id_enhance], str_replace(base_url(), '', $arte->url));
                    }
                }
            }
            foreach($campana->design->left as $arte) {
                if($arte->type == 'clipart') {
                    if($arte->file->type == 'image') {
                        array_push($imagenes_a_borrar[$campana->id_enhance], str_replace(base_url(), '', $arte->thumb));
                        array_push($imagenes_a_borrar[$campana->id_enhance], str_replace(base_url(), '', $arte->url));
                    }
                }
            }
            foreach($campana->design->right as $arte) {
                if($arte->type == 'clipart') {
                    if($arte->file->type == 'image') {
                        array_push($imagenes_a_borrar[$campana->id_enhance], str_replace(base_url(), '', $arte->thumb));
                        array_push($imagenes_a_borrar[$campana->id_enhance], str_replace(base_url(), '', $arte->url));
                    }
                }
            }
        }

        //
        // foreach($imagenes_a_borrar as $indice=>$imagen) {
        //     foreach($imagen as $im) {
        //         if(file_exists($im) && !is_dir($im)) {
        //             unlink($im);
        //         }
        //     }
        //
        //     $this->db->delete('Enhance', array('id_enhance' => $indice));
        //
        //     echo 'Borré imagenes y campaña '.$indice.'<br><br>';
        // }

    }

    public function obtener_imagenes_para_borrar($anio, $mes)
    {
        error_reporting(E_ERROR);
        // Tenemos dos casos
        // 1. Arte subido por usuarios que nunca se compro
        // 2. Vistas previas generadas por usuarios que nunca se compro

        // Trabajar en caso 1
        // Seleccionar todo lo que hay en la carpeta especifica
        $directorio_escanear_artes   = 'media/assets/uploaded/'.$anio.'/'.$mes;
        $directorio_escanear_vistas  = 'media/assets/system/'.$anio.'/'.$mes;

        // Archivos existentes en el directorio de artes del mes especifico
        $archivos_artes_existentes      = array_diff(scandir($directorio_escanear_artes), array('..', '.'));
        // Archivos existentes de vistas previas del mes especifico
        $archivos_vistas_existentes     = array_diff(scandir($directorio_escanear_vistas), array('..', '.'));

        // Array para las artes subidas a los productos custom
        $archivos_artes_pedidos = array();
        // Array para las vistas previas de los productos custom
        $archivos_vistas_previas = array();

        // Escaneamos todos los pedidos de ese mes
        $this->db->select('*')
                 ->from('Pedidos')
                 ->where('EXTRACT(YEAR_MONTH FROM fecha_creacion) = \''.$anio.$mes.'\'');
        $pedidos = $this->db->get()->result();

        // Asignamos todos los productos a los pedidos y escaneamos su contenido
        // Sacamos las imagenes de vistas previas y las imagenes subidas
        foreach($pedidos as $indice_pedido => $pedido) {
            $this->db->select('*')->from('ProductosPorPedido')->where('id_pedido', $pedido->id_pedido);
            $pedidos[$indice_pedido]->productos = $this->db->get()->result();

            foreach($pedidos[$indice_pedido]->productos as $subindice_producto => $producto) {
                $pedidos[$indice_pedido]->productos[$subindice_producto]->diseno = json_decode($producto->diseno);
            }

            foreach($pedidos[$indice_pedido]->productos as $subindice_producto => $producto) {
                // Agrego a la lista de vistas previas las del pedido especifico
                foreach($producto->diseno->images as $imagen_vista) {
                    array_push($archivos_vistas_previas, str_replace($directorio_escanear_vistas.'/', '', $imagen_vista));
                }

                // Agrego a la lista de artes las del pedido especifico
                foreach($producto->diseno->vector as $lado=>$elementos) {
                    foreach($elementos as $indice_elemento => $elemento) {
                        if($elemento->type == 'clipart') {
                            if($elemento->file->type == 'image') {
                                array_push($archivos_artes_pedidos, str_replace(site_url($directorio_escanear_artes).'/', '', $elemento->thumb));
                                array_push($archivos_artes_pedidos, str_replace(site_url($directorio_escanear_artes).'/', '', $elemento->url));
                            }
                        }
                    }
                }
            }
        }

        // Elimino nombres repetidos de archivos
        $archivos_vistas_previas = array_unique($archivos_vistas_previas);
        $archivos_artes_pedidos = array_unique($archivos_artes_pedidos);

        // De la lista de todos los archivos de la carpeta de artes, quito los artes de los pedidos
        $diferencia_artes = array_diff($archivos_artes_existentes, $archivos_artes_pedidos);
        $diferencia_artes = array_diff($diferencia_artes, $archivos_vistas_previas);

        // De la lista de todos los archivos de la carpeta de vistas previas, quito los que estan en los pedidos
        $diferencia_vistas = array_diff($archivos_vistas_existentes, $archivos_artes_pedidos);
        $diferencia_vistas = array_diff($diferencia_vistas, $archivos_vistas_previas);

        ///
        ///
        // Saco todas las artes de las campañas activas y las quito de las carpetas
        $this->db->select('*')
                 ->from('Enhance')
                 ->where('EXTRACT(YEAR_MONTH FROM date) = \''.$anio.$mes.'\'')
                 ->where('estatus !=', 33);

        $campanas = $this->db->get()->result();

        foreach($campanas as $indice_campana => $campana) {
            $campanas[$indice_campana]->design = json_decode($campana->design);
        }

        $vistas_previas_campanas_activas = array();
        $artes_campanas_activas = array();
        foreach($campanas as $indice_campana => $campana) {
            if(isset($campana->front_image)) {
                array_push($vistas_previas_campanas_activas, str_replace($directorio_escanear_vistas.'/', '', $campana->front_image));
            }
            if(isset($campana->back_image)) {
                array_push($vistas_previas_campanas_activas, str_replace($directorio_escanear_vistas.'/', '', $campana->back_image));
            }
            if(isset($campana->left_image)) {
                array_push($vistas_previas_campanas_activas, str_replace($directorio_escanear_vistas.'/', '', $campana->left_image));
            }
            if(isset($campana->right_image)) {
                array_push($vistas_previas_campanas_activas, str_replace($directorio_escanear_vistas.'/', '', $campana->right_image));
            }

            foreach($campana->design as $indice_lado => $lado) {
                foreach($lado as $indice_elemento => $elemento) {
                    if($elemento->type == 'clipart') {
                        if($elemento->file->type == 'image') {
                            array_push($artes_campanas_activas, str_replace(site_url($directorio_escanear_artes).'/', '', $elemento->thumb));
                            array_push($artes_campanas_activas, str_replace(site_url($directorio_escanear_artes).'/', '', $elemento->url));
                        }
                    }
                }
            }
        }

        // Lista de todas las vistas previas de las campañas activas
        $vistas_previas_campanas_activas = array_unique($vistas_previas_campanas_activas);
        // Lista de todos los artes de las campañas activas
        $artes_campanas_activas = array_unique($artes_campanas_activas);

        // De la lista de todos los archivos de la carpeta de artes, quito los artes de los pedidos
        $diferencia_artes = array_diff($diferencia_artes, $artes_campanas_activas);
        $diferencia_artes = array_diff($diferencia_artes, $vistas_previas_campanas_activas);

        // De la lista de todos los archivos de la carpeta de vistas previas, quito los que estan en los pedidos
        $diferencia_vistas = array_diff($diferencia_vistas, $artes_campanas_activas);
        $diferencia_vistas = array_diff($diferencia_vistas, $vistas_previas_campanas_activas);


        /*
        echo '<table style="width:100%;"><tr><td width="33%" valign="top">';
        echo '<pre>';
        print_r($archivos_vistas_existentes);
        print_r($archivos_artes_existentes);
        echo '</pre>';
        echo '</td><td width="33%" valign="top">';
        echo '<pre>';
        //print_r($archivos_vistas_previas);
        //print_r($archivos_artes_pedidos);
        //print_r($pedidos);
        //print_r($campanas);

        print_r($vistas_previas_campanas_activas);
        print_r($artes_campanas_activas);
        echo '</pre></td><td width="33%" valign="top">';
        echo '<pre>';
        //print_r($diferencia_artes);
        //print_r($diferencia_vistas);
        echo '</pre></td></tr></table>';
        */

        echo '<p>Archivos totales carpeta artes: '.sizeof($archivos_artes_existentes).'</p>';
        echo '<p>Archivos totales carpeta inutiles: '.sizeof($diferencia_artes).'</p>';
    }

    public function limpiar_carpeta_uploaded($anio, $mes)
    {
        error_reporting(E_ERROR);
        ini_set('display_errors', 'on');
        $directorio_escanear_artes      = 'media/assets/uploaded/'.$anio.'/'.$mes;
        $archivos_artes_existentes      = array_diff(scandir($directorio_escanear_artes), array('..', '.'));
        echo '<p>Archivos totales carpeta de artes: <strong>'.sizeof($archivos_artes_existentes).'</strong></p>';

        // Array para las artes subidas a los productos custom
        $archivos_artes_pedidos = array();

        // Escaneamos todos los pedidos de ese mes
        $this->db->select('*')
                 ->from('Pedidos')
                 ->where('EXTRACT(YEAR_MONTH FROM fecha_creacion) = \''.$anio.$mes.'\'');
        $pedidos = $this->db->get()->result();

        // Asignamos todos los productos a los pedidos y escaneamos su contenido
        // Sacamos las imagenes de vistas previas y las imagenes subidas
        foreach($pedidos as $indice_pedido => $pedido) {
            $this->db->select('*')->from('ProductosPorPedido')->where('id_pedido', $pedido->id_pedido);
            $pedidos[$indice_pedido]->productos = $this->db->get()->result();

            foreach($pedidos[$indice_pedido]->productos as $subindice_producto => $producto) {
                $pedidos[$indice_pedido]->productos[$subindice_producto]->diseno = json_decode($producto->diseno);
            }

            foreach($pedidos[$indice_pedido]->productos as $subindice_producto => $producto) {
                // Agrego a la lista de artes las del pedido especifico
                foreach($producto->diseno->vector as $lado=>$elementos) {
                    foreach($elementos as $indice_elemento => $elemento) {
                        if($elemento->type == 'clipart') {
                            if($elemento->file->type == 'image') {
                                array_push($archivos_artes_pedidos, str_replace(site_url($directorio_escanear_artes).'/', '', $elemento->thumb));
                                array_push($archivos_artes_pedidos, str_replace(site_url($directorio_escanear_artes).'/', '', $elemento->url));
                            }
                        }
                    }
                }
            }
        }
        $archivos_artes_pedidos = array_unique($archivos_artes_pedidos);
        echo '<p>Archivos de pedidos carpeta de artes: <strong style="color:green;">'.sizeof($archivos_artes_pedidos).'</strong></p>';

        // Saco todas las artes de las campañas activas y las quito de las carpetas
        $this->db->select('*')
                 ->from('Enhance')
                 ->where('EXTRACT(YEAR_MONTH FROM date) = \''.$anio.$mes.'\'')
                 ->where('estatus !=', 33);

        $campanas = $this->db->get()->result();

        foreach($campanas as $indice_campana => $campana) {
            $campanas[$indice_campana]->design = json_decode($campana->design);
        }

        $artes_campanas_activas = array();
        foreach($campanas as $indice_campana => $campana) {
            foreach($campana->design as $indice_lado => $lado) {
                foreach($lado as $indice_elemento => $elemento) {
                    if($elemento->type == 'clipart') {
                        if($elemento->file->type == 'image') {
                            array_push($artes_campanas_activas, str_replace(site_url($directorio_escanear_artes).'/', '', $elemento->thumb));
                            array_push($artes_campanas_activas, str_replace(site_url($directorio_escanear_artes).'/', '', $elemento->url));
                        }
                    }
                }
            }
        }
        $artes_campanas_activas = array_unique($artes_campanas_activas);
        echo '<p>Archivos de campañas carpeta de artes: <strong style="color:purple;">'.sizeof($artes_campanas_activas).'</strong></p>';

        // Sacar archivos de plantillas
        $artes_plantillas = array();
        $sql = "SELECT * FROM DisenosGuardados WHERE EXTRACT(YEAR_MONTH FROM created) = '".$anio.$mes."' AND vectors LIKE '%image%'";
        $plantillas = $this->db->query($sql)->result();

        foreach($plantillas as $indice_plantilla => $plantilla) {
            $plantillas[$indice_plantilla]->vectors = json_decode($plantilla->vectors);
        }

        foreach($plantillas as $indice_plantilla => $plantilla) {
            foreach($plantilla->vectors as $indice_lado => $lado) {
                foreach($lado as $indice_elemento => $elemento) {
                    if($elemento->type == 'clipart') {
                        if($elemento->file->type == 'image') {
                            array_push($artes_plantillas, str_replace(site_url($directorio_escanear_artes).'/', '', $elemento->thumb));
                            array_push($artes_plantillas, str_replace(site_url($directorio_escanear_artes).'/', '', $elemento->url));
                        }
                    }
                }
            }
        }

        echo '<p>Archivos de plantillas: <strong style="color:purple;">'.sizeof($artes_plantillas).'</strong></p>';

        /*
        echo '<table width="100%">';
        echo '<tr><th width="4%">ID</th><th width="48%">Archivos carpeta</th><th width="48%">Coincidencia</th></tr>';
        foreach($archivos_artes_existentes as $indice_arte => $arte) {
            echo '<tr style="border-bottom:solid 1px black;">';
            echo '<td>'.$indica_arte.'</td>';
            echo '<td>'.$arte.'</td>';
            $posicion = array_search($arte, $archivos_artes_pedidos);
            if($posicion) {
                echo '<td>(поръчка)<strong><em style="color:green;">'.$archivos_artes_pedidos[$posicion].'</em></strong></td>';
            } else {
                $posicion_campana = array_search($arte, $artes_campanas_activas);
                if($posicion_campana) {
                    echo '<td>(кампания)<strong><em style="color:purple;">'.$artes_campanas_activas[$posicion_campana].'</em></strong></td>';
                } else {
                    echo '<td></td>';
                }
            }
            echo '</tr>';
        }
        */

        $archivos_artes_existentes = array_diff($archivos_artes_existentes, $archivos_artes_pedidos);
        $archivos_artes_existentes = array_diff($archivos_artes_existentes, $artes_campanas_activas);
        $archivos_artes_existentes = array_diff($archivos_artes_existentes, $artes_plantillas);

        echo '<p>Archivos por borrar carpeta de artes: <strong style="color:red">'.sizeof($archivos_artes_existentes).'</strong></p>';

        foreach($archivos_artes_existentes as $archivo_borrar) {
            if(file_exists($directorio_escanear_artes.'/'.$archivo_borrar) && !is_dir($directorio_escanear_artes.'/'.$archivo_borrar)) {
                unlink($directorio_escanear_artes.'/'.$archivo_borrar);
            }
        }
    }

    public function reflejar_ventas_reales()
    {
        $productos = $this->catalogo_modelo->obtener_enhanced();

        echo '<progress id="avance" value="0" max="'.sizeof($productos).'"></progress>';

        foreach($productos as $indice_prod => $producto) {
            $update_cantidades = new stdClass();

            // Sacar cantidad vendida real
            $this->db->select('SUM(cantidad_producto) AS cantidad_vendida')
                     ->from('ProductosPorPedido')
                     ->join('Pedidos', 'ProductosPorPedido.id_pedido = Pedidos.id_pedido')
                     ->where('ProductosPorPedido.id_enhance', $producto->id_enhance)
                     ->where('Pedidos.estatus_pago', 'paid')
                     ->where('Pedidos.estatus_pedido !=', 'Cancelado');
            $vendida = $this->db->get()->row();
            if($vendida->cantidad_vendida) {
                $update_cantidades->cantidad_vendida = $vendida->cantidad_vendida;
            } else {
                $update_cantidades->cantidad_vendida = 0;
            }

            // Sacar cantidad adicional
            $this->db->select('SUM(cantidad_producto) AS cantidad_adicional')
                     ->from('ProductosPorPedido')
                     ->join('Enhance AS Enh', 'ProductosPorPedido.id_enhance = Enh.id_parent_enhance')
                     ->join('Pedidos', 'ProductosPorPedido.id_pedido = Pedidos.id_pedido')
                     ->where('Enh.id_parent_enhance !=', 0)
                     ->where('Enh.id_parent_enhance', $producto->id_enhance)
                     ->where('Pedidos.estatus_pago', 'paid')
                     ->where('Pedidos.estatus_pedido !=', 'Cancelado');
            $vendida = $this->db->get()->row();
            if($vendida->cantidad_adicional) {
                $update_cantidades->cantidad_adicional = $vendida->cantidad_adicional;
            } else {
                $update_cantidades->cantidad_adicional = 0;
            }

            // Sacar faltante
            $this->db->select('DATEDIFF(\''.date("Y-m-d H:i:s").'\', Enhance.end_date) AS faltante')
                     ->from('Enhance')
                     ->where('Enhance.id_enhance', $producto->id_enhance);
            $tiempo = $this->db->get()->row();
            $update_cantidades->faltante = $tiempo->faltante;

            $this->db->where('id_enhance', $producto->id_enhance);
            $this->db->update('Enhance', $update_cantidades);

            echo '<script>document.getElementById("avance").value = "'.$indice_prod.'";</script>';
        }
    }

	public function sitemap()
	{
		$limitados = $this->catalogo_modelo->obtener_enhanced('limitado');
		$fijos = $this->catalogo_modelo->obtener_enhanced('fijo');
		$playeras = array();
		$playeras['caballero'] = $this->catalogo_modelo->obtener_productos(10, 5);
		$playeras['dama'] = $this->catalogo_modelo->obtener_productos(10, 6);
		$playeras['juvenil'] = $this->catalogo_modelo->obtener_productos(10, 7);
		$playeras['infantil'] = $this->catalogo_modelo->obtener_productos(10, 8);
		$playeras['bebes'] = $this->catalogo_modelo->obtener_productos(10, 9);

		$this->load->view('sitemap/sitemap_header');
		$this->load->view('sitemap/static_urls');
		foreach($limitados as $limitado) {
			$this->load->view('sitemap/url_template', $limitado);
		}
		foreach($fijos as $fijo) {
			$this->load->view('sitemap/url_template', $fijo);
		}
		foreach($playeras as $indice_tipo=>$productos) {
			foreach($productos as $playera) {
				$this->load->view('sitemap/url_template', $playera);
			}
		}
		$this->load->view('sitemap/sitemap_footer');
	}

	public function regresar_inventario_no_pagado()
	{
        $this->db->select('*')
                 ->from('Pedidos')
                 ->or_group_start()
                    ->or_where('metodo_pago', 'cash_payment')
                    ->or_where('metodo_pago', 'spei')
                 ->group_end()
                 ->where('cronjob', 0)
                 ->where('estatus_pago', 'pending_payment');

        $pedidos = $this->db->get()->result();

		foreach($pedidos as $indice=>$pedido) {
            if($pedido->metodo_pago == 'cash_payment') {
                $time = strtotime($pedido->oxxo_fecha_vencimiento);
    			$newtime = $time + 86400;
            } else if($pedido->metodo_pago == 'spei') {
                $time = strtotime($pedido->fecha_creacion . " +72 hours");
                $newtime = $time + 86400;
            }

			$fecha_vencimiento = date("Y-m-d H:i:s", $newtime);

			if($fecha_vencimiento < date("Y-m-d H:i:s")) {
				$actualizacion = new stdClass();
				$actualizacion->cronjob = 1;
				$actualizacion->estatus_pedido = 'Cancelado';
                $actualizacion->id_paso_pedido = 7;

				$this->db->where('id_pedido', $pedido->id_pedido);
				$this->db->update('Pedidos', $actualizacion);

				$productos_por_pedido = $this->pedidos_modelo->obtener_productos_por_pedido($pedido->id_pedido);

				foreach ($productos_por_pedido as $producto) {
					$cantidad = $producto->cantidad_producto;
					$sku = $producto->id_sku;

					if($producto->id_enhance != 0) {
						if($pedido->estatus_pago != 'paid') {
							$query = $this->db->query('UPDATE Enhance SET sold=(sold-'.$cantidad.') WHERE id_enhance='.$producto->id_enhance);
						}
						$enhance = $this->enhance_modelo->obtener_enhance($producto->id_enhance);
						if($enhance->type == 'fijo') {
							$query = $this->db->query("UPDATE CatalogoSkuPorProducto SET cantidad_inicial=(cantidad_inicial+".$cantidad.") WHERE id_sku='".$sku."'");
						}
					} else {
						$query = $this->db->query("UPDATE `CatalogoSkuPorProducto` SET `cantidad_inicial` = (`cantidad_inicial`+".$cantidad.") WHERE `id_sku` = '".$sku."'");
					}
				}
			}
		}
	}


	public function abandono_de_carrito()
	{
		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
		$fibonacci = array(1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377, 610, 987);

		$this->db->select('id_cliente, email, nombres, carrito_en_sesion, carrito_fecha_actualizacion, abandono_fecha_envio, abandono_numero_envio')
			->from('Clientes')
			->where('token_activacion_correo', 'activado')
			->group_start()
				->where('carrito_en_sesion !=', NULL)
				->where('carrito_en_sesion !=', '[]')
			->group_end();

		$carters = $this->db->get()->result();

		$carteritos = array();

		foreach($carters as $indice => $carter) {
			$carters[$indice]->carrito_en_sesion = json_decode($carter->carrito_en_sesion);

			$cartero = new stdClass();
			$cartero->nombre = $carter->nombres;
			$cartero->email = $carter->email;
			$cartero->productos = array();
			$cartero->dias_transcurrido = (((time()-strtotime($carter->carrito_fecha_actualizacion))/24)/60)/60;
			$cartero->abandono_fecha_envio = $carter->abandono_fecha_envio;
			$cartero->abandono_numero_envio = $carter->abandono_numero_envio;

			$previous_des_id = '';
			$previous_id = 0;
			$previous_cam_id = 0;

			foreach($carters[$indice]->carrito_en_sesion as $producto) {
				if(isset($producto->options->id_diseno)) {
					if($previous_des_id == $producto->options->id_diseno) {
						if($producto->id != $previous_id) {
							array_push($cartero->productos, site_url($producto->options->disenos->images->front));
							$previous_id = $producto->id;
						}
					} else {
						array_push($cartero->productos, site_url($producto->options->disenos->images->front));
						$previous_des_id = $producto->options->id_diseno;
						$previous_id = $producto->id;
					}
				} else {
					if($previous_cam_id != $producto->options->id_enhance) {
						array_push($cartero->productos, site_url($producto->options->images->front));
						$previous_cam_id = $producto->options->id_enhance;
					}
				}
			}

			$enviar = false;

			if($cartero->dias_transcurrido >= 1 && $cartero->dias_transcurrido < 2 && $carter->abandono_numero_envio == 0) {

				$enviar = true;

			} else if($cartero->dias_transcurrido > 2) {

				$ultimo_envio = round((((time()-strtotime($carter->abandono_fecha_envio))/24)/60)/60);
				$numero_ultimo_envio = $carter->abandono_numero_envio;

				if($ultimo_envio == $fibonacci[$numero_ultimo_envio]) {
					$enviar = true;
				} else {
					$enviar = false;
				}

			}

			if($enviar) {
				$email = new SendGrid\Email();
				$email->addTo($cartero->email, $cartero->nombre)
					  ->setFrom('administracion@printome.mx')
					  ->setReplyTo('administracion@printome.mx')
					  ->setFromName('printome.mx')
					  ->setSubject('¡Tus productos te esperan!')
					  ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_abandono_carrito', $cartero, TRUE))
				;
				$sendgrid->send($email);

				$this->db->query("UPDATE Clientes SET abandono_fecha_envio='".date("Y-m-d H:i:s")."', abandono_numero_envio = abandono_numero_envio+1 WHERE id_cliente=".$carter->id_cliente);
			}
		}
	}

	public function recordatorio_oxxo()
	{
		// Se inicializa Sendgrid
		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);

		$pedidos_res = $this->db->get_where('Pedidos', array(
			'cronjob' => 0,
			'metodo_pago' => 'cash_payment',
			'estatus_pago' => 'pending_payment'
		));
		$pedidos = $pedidos_res->result();

		foreach($pedidos as $indice=>$pedido) {
			$time = strtotime($pedido->oxxo_fecha_vencimiento);
			$diferencia = $time-time();

			$datos_correo = new stdClass();

			if($diferencia > 86370 && $diferencia < 86430) {
				$datos_correo->restante = '¡Apúrate! Te quedan solamente 24 horas para pagar tu pedido.';
				$envio = true;
			} else if($diferencia > 172770 && $diferencia < 172830) {
				$datos_correo->restante = 'Te quedan 2 días para pagar tu pedido.';
				$envio = true;
			} else if($diferencia > 259170 && $diferencia < 259230) {
				$datos_correo->restante = 'Te quedan 3 días para pagar tu pedido';
				$envio = true;
			} else {
				$envio = false;
			}

			if($envio) {

				$cliente = $this->db->get_where('Clientes', array('id_cliente' => $pedido->id_cliente))->row();

				$datos_correo->numero_pedido = str_pad($pedido->id_pedido, 8, '0', STR_PAD_LEFT);
				$datos_correo->total_pedido  = $pedido->total;
                $datos_correo->referencia_oxxo = $pedido->oxxo_codigo_barras;
				$datos_correo->nombre        = $cliente->nombres.' '.$cliente->apellidos;
				$datos_correo->nombre_solo   = $cliente->nombres;
				$datos_correo->apellido      = $cliente->apellidos;
				$datos_correo->email         = $cliente->email;

                $email_oxxo = new SendGrid\Email();
				$email_oxxo->addTo($datos_correo->email, $datos_correo->nombre)
						   ->setFrom('administracion@printome.mx')
						   ->setReplyTo('administracion@printome.mx')
						   ->setFromName('printome.mx')
						   ->setSubject($datos_correo->restante.' | printome.mx')
						   ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_stub_oxxo', $datos_correo, TRUE));

                $sendgrid->send($email_oxxo);
			}
		}
	}

	public function pdf_oxxo_archivo($id_pedido){
		$this->load->helper(array('dompdf', 'file'));
        // Inicializar Conekta
        \Conekta\Conekta::setApiKey($_ENV['CONEKTA_PRIVATE_KEY']);
        \Conekta\Conekta::setLocale('es');
        \Conekta\Conekta::setApiVersion("2.0.0");

		$contenido['id_pedido']      = $id_pedido;
		$contenido['pedido']         = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
		$reference                   = $contenido['pedido']->referencia_pago;
		$charges                     = Conekta_Charge::where(array('reference_id'=>$reference));
		$charges                     = json_decode($charges->__toJSON());
		$charge                      = $charges[0];
		$barcode                     = $charge->payment_method->barcode_url;
		$barcode_number              = $charge->payment_method->barcode;
		$expiration                  = $charge->payment_method->expires_at;
		$amount                      = $charge->amount / 100;
		$im                          = file_get_contents($barcode);
		$barcode                     = "data:image/png;base64," . base64_encode($im);
		$contenido['barcode']        = $barcode;
		$contenido['barcode_number'] = $barcode_number;
		$contenido['expiration']     = $expiration;
		$contenido['amount']         = $amount;

		$html = $this->load->view('carrito/pdf', $contenido, true);

		$nombre = pdf_create_file($html, 'pago_'.str_pad($reference, 8, '0', STR_PAD_LEFT), TRUE);

		return $nombre;
	}

	public function abandono($correo)
	{
		$correo = urldecode($correo);

		$fibonacci = array(1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377, 610, 987);

		$this->db->select('id_cliente, email, nombres, carrito_en_sesion, carrito_fecha_actualizacion, abandono_fecha_envio, abandono_numero_envio')
			->from('Clientes')
			->where('token_activacion_correo', 'activado')
			->where('email', $correo)
			->group_start()
				->where('carrito_en_sesion !=', NULL)
				->where('carrito_en_sesion !=', '[]')
			->group_end();

		$carters = $this->db->get()->result();

		$carteritos = array();

		foreach($carters as $indice => $carter) {
			$carters[$indice]->carrito_en_sesion = json_decode($carter->carrito_en_sesion);

			$cartero = new stdClass();
			$cartero->nombre = $carter->nombres;
			$cartero->email = $carter->email;
			$cartero->productos = array();
			$cartero->dias_transcurrido = (((time()-strtotime($carter->carrito_fecha_actualizacion))/24)/60)/60;
			$cartero->abandono_fecha_envio = $carter->abandono_fecha_envio;
			$cartero->abandono_numero_envio = $carter->abandono_numero_envio;

			$previous_des_id = '';
			$previous_id = 0;
			$previous_cam_id = 0;

			foreach($carters[$indice]->carrito_en_sesion as $producto) {
				if(isset($producto->options->id_diseno)) {
					if($previous_des_id == $producto->options->id_diseno) {
						if($producto->id != $previous_id) {
							array_push($cartero->productos, site_url($producto->options->disenos->images->front));
							$previous_id = $producto->id;
						}
					} else {
						array_push($cartero->productos, site_url($producto->options->disenos->images->front));
						$previous_des_id = $producto->options->id_diseno;
						$previous_id = $producto->id;
					}
				} else {
					if($previous_cam_id != $producto->options->id_enhance) {
						array_push($cartero->productos, site_url($producto->options->images->front));
						$previous_cam_id = $producto->options->id_enhance;
					}
				}
			}

			$enviar = false;

			if($cartero->dias_transcurrido >= 1 && $cartero->dias_transcurrido < 2 && $carter->abandono_numero_envio == 0) {

				$enviar = true;

			} else if($cartero->dias_transcurrido > 2) {

				$ultimo_envio = round((((time()-strtotime($carter->abandono_fecha_envio))/24)/60)/60);
				$numero_ultimo_envio = $carter->abandono_numero_envio;

				if($ultimo_envio == $fibonacci[$numero_ultimo_envio]) {
					$enviar = true;
				} else {
					$enviar = false;
				}

			}

			$this->load->view('cron/abandono_carrito', $cartero);
		}
	}

    // Funcion de cambio de estatus de envio
    public function actualizar_dhl()
    {
        $this->load->library('dhl');

        $this->db->select('*')
                 ->from('Pedidos')
                 ->where('codigo_rastreo IS NOT NULL')
                 ->where('id_paso_pedido', 5);

        $pedidos_pendientes = $this->db->get()->result();

        foreach($pedidos_pendientes as $pedido) {
            $info = $this->dhl->track_request($pedido->codigo_rastreo);

            if(isset($info->AWBInfo)) {
                if($info->AWBInfo->Status->ActionStatus == 'success') {
                    $entregado = false;
                    foreach($info->AWBInfo->ShipmentInfo->ShipmentEvent as $indice => $ShipmentEvent) {
                        if($ShipmentEvent->ServiceEvent->EventCode == 'OK') {
                            $pedido_update = new stdClass();
                            $pedido_update->id_paso_pedido = 6;

                            $this->db->where('id_pedido', $pedido->id_pedido);
                            $this->db->update('Pedidos', $pedido_update);

                            $this->db->select('*')
                                     ->from('HistorialPedidos')
                                     ->where('id_pedido', $pedido->id_pedido)
                                     ->order_by('id_paso_pedido', 'DESC')
                                     ->limit(1);
                            $ultimo_historial = $this->db->get()->row();

                            if(isset($ultimo_historial->id_historial)) {
                                $this->db->query('UPDATE HistorialPedidos SET fecha_final=\''.date("Y-m-d H:i:s").'\' WHERE id_historial='.$ultimo_historial->id_historial);
                            }

                            $historial_pedido = new stdClass();
                            $historial_pedido->id_pedido = $pedido->id_pedido;
                            $historial_pedido->id_paso_pedido = $pedido_update->id_paso_pedido;
                            $historial_pedido->fecha_inicio = date("Y-m-d H:i:s", strtotime($ShipmentEvent->Date.' '.$ShipmentEvent->Time));
                            $this->db->insert('HistorialPedidos', $historial_pedido);

                            $datos_correo = new stdClass();
                            $pedido_sec = $this->pedidos_modelo->obtener_pedido_especifico($pedido->id_pedido);
                            $cliente_res = $this->db->get_where('Clientes', array('id_cliente' => $pedido_sec->id_cliente));
                    		$cliente = $cliente_res->result();

                            $asunto = 'Tu pedido ha sido entregado';
                            $plantilla = 'plantillas_correos/nuevas/cliente_pedido_estatus_recibido';

                            $datos_correo->asunto = $asunto;
                    		$datos_correo->nombre = $cliente[0]->nombres.' '.$cliente[0]->apellidos;
                    		$datos_correo->email = $cliente[0]->email;
                    		$datos_correo->numero_pedido = str_pad($pedido->id_pedido, 8, '0', STR_PAD_LEFT);

                            // Se inicializa Sendgrid
                    		$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
                    		$email = new SendGrid\Email();
                    		$email->addTo($datos_correo->email, $datos_correo->nombre)
                    			  ->setFrom('administracion@printome.mx')
                    			  ->setReplyTo('administracion@printome.mx')
                    			  ->setFromName('printome.mx')
                    			  ->setSubject($asunto.' | printome.mx')
                    			  ->setHtml($this->load->view($plantilla, $datos_correo, TRUE))
                    		;
                    		$sendgrid->send($email);
                        }
                    }
                }
            }
            usleep(500000);
        }
    }



	/// Mailing para avisos
	public function mailing($go = null)
	{
		if($go == '20170404') {
			// Se inicializa Sendgrid
			$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);

			$gente = $this->db->get_where('Clientes', array('token_activacion_correo' => 'activado'))->result();

			foreach($gente as $persona) {
				$datos_correo = new stdClass();
				$datos_correo->nombre = $persona->nombres.' '.$persona->apellidos;
				$datos_correo->email = $persona->email;
				$datos_correo->nombre_corto = $persona->nombres;

				$email_oxxo = new SendGrid\Email();
				$email_oxxo->addTo($datos_correo->email, $datos_correo->nombre)
						   ->setFrom('administracion@printome.mx')
						   ->setReplyTo('administracion@printome.mx')
						   ->setFromName('printome.mx')
						   ->setSubject('¡Ya puedes seleccionar tu método preferido de depósito! | printome.mx')
						   ->setHtml($this->load->view('plantillas_correos/nuevas/mailing_opcion_de_pago', $datos_correo, TRUE));

				$sendgrid->send($email_oxxo);
			}
		}
	}

	//baja de puntos para sistema de referencias printome
    public function baja_puntos(){
	    $this->db->select("*")
            ->from("Referencias")
            ->join("NivelesReferencias", "Referencias.id_nivel=NivelesReferencias.id_nivel")
            ->where("experiencia > '0.00'");
	    $referencias = $this->db->get()->result();

	    foreach ($referencias as $referencia){
	        $menos = new stdClass();
	        $menos->id_comprador = 'NULL';
	        $menos->id_referenciado = $referencia->id_cliente;
	        $menos->id_pedido = 'NULL';
	        $menos->id_cupon = 'NULL';
	        $menos->fecha = date("Y-m-d H:i:s");
	        echo ($referencia->experiencia < $referencia->baja_diaria) ? true : false;
	        if($referencia->experiencia < $referencia->baja_diaria){
                $menos->experiencia = number_format($referencia->experiencia * (-1),2,".","");
            }else{
                $menos->experiencia = $referencia->baja_diaria * (-1);
            }
	        $menos->puntos = 0.00;

            $this->db->insert("HistorialReferencias", $menos);
            $bajo = $this->referencias_modelo->verificar_nivel($referencia->id_cliente);
        }
    }

    public function correo_seguimiento_plazo_definido(){
        $this->db->select("HOUR(TIMEDIFF(e.end_date, NOW())) as diferencia, p.id_pedido, e.name, e.front_image, e.end_date, e.days, cli.nombres, cli.apellidos, cli.email")
            ->from("Pedidos p")
            ->join("ProductosPorPedido ppp", "p.id_pedido = ppp.id_pedido", "left")
            ->join("Enhance e", "ppp.id_enhance = e.id_enhance", "left")
            ->join("Clientes cli", "p.id_cliente = cli.id_cliente", "left")
            ->where("p.estatus_pago = 'paid'")
            ->where("p.estatus_pedido = 'En Proceso'")
            ->where("ppp.id_enhance != 0")
            ->where("e.type = 'limitado'")
            ->where("e.estatus = 1")
            ->group_start()
                ->where("HOUR(TIMEDIFF(e.end_date, NOW())) >= 24 AND HOUR(TIMEDIFF(e.end_date, NOW())) <= 30")
                ->or_where("HOUR(TIMEDIFF(e.end_date, NOW())) >= 48 AND HOUR(TIMEDIFF(e.end_date, NOW())) <= 54")
                ->or_where("HOUR(TIMEDIFF(e.end_date, NOW())) >= 72 AND HOUR(TIMEDIFF(e.end_date, NOW())) <= 78")
                ->or_where("HOUR(TIMEDIFF(e.end_date, NOW())) >= 168 AND HOUR(TIMEDIFF(e.end_date, NOW())) <= 174")
                ->or_where("HOUR(TIMEDIFF(e.end_date, NOW())) >= 336 AND HOUR(TIMEDIFF(e.end_date, NOW())) <= 342")
                ->or_where("HOUR(TIMEDIFF(e.end_date, NOW())) >= 504 AND HOUR(TIMEDIFF(e.end_date, NOW())) <= 510")
            ->group_end();
	    $pedidos = $this->db->get()->result();



	    foreach ($pedidos as $pedido) {
	        $pedido->flag = 0;
	        switch($pedido->days){
                case 28:
                    $pedido->flag = 1;
                    break;
                case 21:
                    if($pedido->diferencia < 504){
                        $pedido->flag = 1;
                    }
                    break;
                case 14:
                    if($pedido->diferencia < 336){
                        $pedido->flag = 1;
                    }
                    break;
                case 7:
                    if($pedido->diferencia < 168){
                        $pedido->flag = 1;
                    }
                    break;
            }

	        if($pedido->flag == 1) {
	            $dias_restantes = floor($pedido->diferencia / 24);
	            if($dias_restantes >= 7){
	                $semanas_restantes = floor($dias_restantes / 7);
                    $tiempo_restante = $semanas_restantes." semanas";
                    if($semanas_restantes == 1){
                        $tiempo_restante = $semanas_restantes." semana";
                    }
                }else{
                    $tiempo_restante = $dias_restantes." días";
                    if($dias_restantes == 1){
                        $tiempo_restante = $dias_restantes." día";
                    }
                }

                $datos_correo['nombre'] = $pedido->nombres . ' ' . $pedido->apellidos;
                $datos_correo['num_pedido'] = $pedido->id_pedido;
                $datos_correo['nombre_producto'] = $pedido->name;
                $datos_correo['imagen'] = $pedido->front_image;
                $datos_correo['end_date'] = date('d/m/Y', strtotime($pedido->end_date));
                $datos_correo['end_hour'] = date('H', strtotime($pedido->end_date));
                $datos_correo['days'] = $pedido->days;
                $datos_correo['tiempo_restante'] = $tiempo_restante;

                $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
                $email = new SendGrid\Email();
                $email->addTo($pedido->email, $datos_correo->nombre)
                    ->addTo('mirley@printome.mx', 'Mirley Parra')
                    ->setFrom('administracion@printome.mx')
                    ->setReplyTo('administracion@printome.mx')
                    ->setFromName('printome.mx')
                    ->setSubject('Aviso de compra de Plazo Definido | printome.mx')
                    ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_aviso_plazo_definido', $datos_correo, TRUE));
                $sendgrid->send($email);
            }
        }
    }

    public function crear_referencias_clientes(){
        //if ($this->input->is_cli_request()){
            try{
                $this->db->select('id_cliente')
                    ->from('Clientes')
                    ->where('estatus_cliente !=', 33);
                $clientes = $this->db->get()->result();
                foreach($clientes as $indice => $cliente){
                    $this->referencias_modelo->generar_codigo($cliente->id_cliente);
                }
                echo "exito";
            }catch(Exception $e){
                echo $e;
            }
        //}else{
          //  show_error('Direct access is not allowed');
        //}
    }

    public function obtener_token_paypal(){
        if ($this->input->is_cli_request()) {
            $this->load->library('paypalplus');
            $jsonResponse = $this->paypalplus->get_access_token();
            if ($jsonResponse) {
                $info = new stdClass();
                $info->token = $jsonResponse->access_token;
                $info->fecha = date("Y-m-d H:i:s");
                $info->estatus = 1;
                $this->db->insert('TokensPayPal', $info);

                $id_token = $this->db->insert_id();
                $estatus = new stdClass();
                $estatus->estatus = 33;
                $this->db->where('id_token !=', $id_token)
                    ->update('TokensPayPal', $estatus);
            }
        } else {
            show_error('Direct access is not allowed');
        }
    }

    public function registrar_sku_stripe(){
        $this->load->library('stripe_lib');
        $this->db->select("id_sku, sku, caracteristicas, codigo_color, nombre_color, precio, nombre_producto, fotografia_original, catp.id_stripe AS id_prod_stripe, catp.id_producto as id_producto, caracteristicas_adicionales")
            ->from("CatalogoSkuPorProducto skupp")
            ->join("ColoresPorProducto colpp", "skupp.id_color = colpp.id_color")
            ->join("CatalogoProductos catp", "catp.id_producto = colpp.id_producto")
            ->join("FotografiasPorProducto fpp", "fpp.id_color = skupp.id_color")
            ->where("skupp.estatus", 1)
            ->where("catp.estatus", 1)
            ->where("fpp.estatus", 1)
            ->where("skupp.id_stripe !=", "sku_Fs25pMiK8m7xec");
        $skus = $this->db->get()->result();
        try{
            foreach ($skus as $sku) {
                $id_sku_stripe = $this->stripe_lib->registrar_sku($sku);
                $this->db->where("id_sku", $sku->id_sku)
                    ->update("CatalogoSkuPorProducto", array("id_stripe" => $id_sku_stripe));
            }
        }catch(Exception $e){
            print_r($e);
        }
    }

    public function registrar_productos_stripe(){
        $this->db->select("*")
            ->from("CatalogoProductos catp")
            ->where("catp.estatus", 1);
        $productos = $this->db->get()->result();
        $this->load->library('stripe_lib');
        try {
            foreach ($productos as $producto) {
                $id_prod_stripe = $this->stripe_lib->registrar_producto($producto);
                $this->db->where("id_producto", $producto->id_producto)
                    ->update("CatalogoProductos", array("id_stripe" => $id_prod_stripe));
            }
        }catch(Exception $e){
            print_r($e);
        }
    }

    public function borrar_todo(){
        $this->load->library('stripe_lib');
        $this->stripe_lib->borrar_todos_los_productos();
    }

    public function borrar_todo_sku(){
        $this->load->library('stripe_lib');
        $this->stripe_lib->borrar_todos_skus();
    }

    public function limpieza_2020(){
        $this->db->select('id_enhance, front_image, back_image, right_image, left_image, sold, date')
            ->from('Enhance')
            ->where("date < '2019-01-01 00:00:00'")
            ->where("id_cliente !=", 341)
            ->where("estatus", 1)
            ->where("sold <=", 0);
        $campanas = $this->db->get()->result();

        try{
            if (sizeof($campanas) > 0) {
                $mensaje = 'eliminando imagenes de las campañas del cliente.';
                foreach ($campanas as $campana) {
                    $time = strstr(str_replace("_","", strstr($campana->front_image, '_')), '.', true);
                    $dir = strstr($campana->front_image, '_', true);
                    $dir_dibujo_front =  str_replace("front", "dibujo_front_", $dir).md5($time).".png";
                    $dir_dibujo_back =  str_replace("front", "dibujo_back_", $dir).md5($time).".png";
                    $dir_dibujo_left =  str_replace("front", "dibujo_left_", $dir).md5($time).".png";
                    $dir_dibujo_right =  str_replace("front", "dibujo_right_", $dir).md5($time).".png";

                    if (!is_dir($campana->front_image) && file_exists($campana->front_image)) {
                        unlink($campana->front_image);
                    }
                    if (!is_dir($campana->back_image) && file_exists($campana->back_image)) {
                        unlink($campana->back_image);
                    }
                    if (!is_dir($campana->right_image) && file_exists($campana->right_image)) {
                        unlink($campana->right_image);
                    }
                    if (!is_dir($campana->left_image) && file_exists($campana->left_image)) {
                        unlink($campana->left_image);
                    }
                    if (!is_dir($dir_dibujo_front) && file_exists($dir_dibujo_front)) {
                        unlink($dir_dibujo_front);
                    }
                    if (!is_dir($dir_dibujo_back) && file_exists($dir_dibujo_back)) {
                        unlink($dir_dibujo_back);
                    }
                    if (!is_dir($dir_dibujo_left) && file_exists($dir_dibujo_left)) {
                        unlink($dir_dibujo_left);
                    }
                    if (!is_dir($dir_dibujo_right) && file_exists($dir_dibujo_right)) {
                        unlink($dir_dibujo_right);
                    }
                }
                $mensaje = 'eliminando enhances de la base de datos.';
                foreach ($campanas as $campana) {
                    $this->db->delete('Enhance', array('id_enhance' => $campana->id_enhance));
                }
                echo "exito en la limpieza";
            }
        }catch(Exception $e){
            echo print_r($e);
        }
    }

    public function limpieza_printome_2020($bloque){
        $array_limpieza = array();
	    switch ($bloque){
            case 1:
                $array_limpieza = array(35551,35546,35542,35541,35540,35539,35538,35537,35536,35497,35496,35495,35482,35476,35471,35470,35469,35468,35463,35458,35454,35453,35452,35451,35450,35451,35442,35441,35440,35439,35431,35431,35427,35423,35422,35421,35420,35419,35418,35417,35413,35360,35356,35353,35352,35351,35350,35345,35340,35335,35334,35333,35332,35331,35330,35329,34416,34415,34408,34407,34401,34400,34365,34361,34358,34357,34356,34355,34234,34229,34225,34224,34223,34222,34186,34179,34173,34172,34171,34170,33974,33970,33967,33966,33966,33965,33964,33963,33962,33961,33650,33645,33641,33640,33639,33638,33586,33585,33579,33578,33573,33572,33480,33479,33474,33473,33469,33468,33316,33316,33311,33306,33305,33301,33300,33178,33176,33169,33168,33162,33156,33068,33064,33060,33059,33058,33057,33027,33026,33023,33022,33021,33020,32904,32903,32902,32901,32900,32899,32898,32892,32885,32878,32877,32876,32875,32874,32866,32858,32857,32856,32855,32848,32761,32756,32748,32747,32746,32745,32739,32734,32729,32728,32727,32726,32725,32632,32627,32623,32622,32621,32620,32572,32568,32565,32561,32560,32558,32416,32415,32413,32319,32318,32314,32313,32310,32309,32307,32306,32305,32304,32302,32301,32063,32056,32050,32049,32048,32047,31908,31907,31906,31748,31743,31739,31738,31737,31736,31615,31611,31604,31603,31597,31596,31406,31405,31401,31400,31397,31396,31375,31371,31368,31367,31366,31365,31354,1353,31352,31260,31259,31258,31106,31101,31100,31096,31094,31089,31088,31082,31081,31077,31076,31060,31059,31053,31052,31047,31046,31012,31008,31004,31003,31002,31001,31000,30999,30998,30997,30996,30995,30981,30980,30979,30977,30976,30975,30974,30973,30972,30960,30956,30955,30954,30953,30952,30951,30950,30949,30900,30896,30895,30894,30893,30892,30852,30848,30844,30843,30842,30841,30246,30243,30239,30235,30232,30231,30230,30229,30228,30227,30186,30185,30184,30179,30174,30169,30168,30168,30167,30166,30162,30162,30158,30154,30153,30152,30151,30149,30147,30145,30144,30143,30142,30141,30140,30139,30133,30127,30122,30121,30120,30119,30119,29923,29922,29918,29917,29913,29912,29794,29793,29788,29787,29783,29782,29613,29612,29607,29606,29602,29601,29548,29547,29541,29540,29536,29535,29530,29529,29524,29523,29519,29518,29377,29376,29375,29321,29317,29313,29312,29311,29310,29309,29308,29307,29277,29276,29274,29272,29270,29251,29250,29249,29222,29219,29216,29215,29214,29213,29188,29187,29182,29181,29177,29176,29131,29126,29123,29122,29121,29120,29115,29110,29105,29104,29102,29100,29098,29097,29058,29057,29052,29051,29047,29046,29041,29040,29035,29034,29030,29029,28992,28991,28990,28911,28910,28905,28904,28900,28899,28679,28678,28674,28673,28670,28669,28594,28593,28592,28587,28583,28578,28573,28569,28568,28567,28566,28563,28562,28561,28560,28559,28558,28557,28556,28501,28498,28496,28496,28495,28494,28493,28492,28491,28490,28486,28485,28481,28480,28477,28476,28335,28334,28333,28332,28331,28330,28329,28328,28327,28326,28256,28255,28254,28250,28246,28242,28157,28156,28151,28150,28146,28145);
                break;
            case 2:
                $array_limpieza = array(28145,28079,28076,28073,28072,28071,28070,28039,28038,28037,28036,28035,28034,28013,28007,28006,28000,27999,27997,27992,27991,27986,27985,27981,27979,27957,27956,27954, 7953, 27951, 27950, 27942, 27941, 27933, 27932, 27925, 27924, 27920, 27919, 27915, 27914, 27910, 27909, 27904, 27903, 27898, 27897, 27892, 27891, 27843, 27842, 27841, 27840, 27839, 27838, 27799, 27798, 27797, 27569, 27568, 27567, 27566, 27565, 27564, 27556, 27549, 27543, 27542, 27541, 27540, 27404, 27403, 27398, 27397, 27393, 27392, 27369, 27368, 27365, 27364, 27362, 27361, 27343, 27339, 27336, 27332, 27328, 27327, 27325, 27322, 27321, 27305, 27299, 27294, 27206, 27204, 27196, 27195, 27188, 27187, 27183, 27182, 27178, 27177, 27174, 27173, 27166, 27165, 27158, 27157, 27151, 27150, 27029, 27025, 27022, 27018, 27013, 27012, 27007, 27006, 26990, 26814, 26812, 26811, 26810, 26809, 26640, 26639, 26636, 26635, 26632, 26631, 26412, 26407, 26402, 26397, 26396, 26395, 26394, 26393, 26282, 26281, 26280, 26279, 26276, 26274, 26272, 26271, 26270, 26177, 26176, 26173, 26172, 26169, 26168, 25815, 25810, 25805, 25800, 25798, 25797, 25796, 25795, 25794, 25792, 25791, 25790, 25323, 25322, 25321, 25320,25273, 25270, 25269, 25210, 25209, 25208, 25206, 25205, 25204, 25203, 25202, 25201, 25200, 25199, 25198, 25117, 25116, 25115, 25114, 25113, 25111, 24942, 24941, 24940, 24939, 24938, 24937, 24897, 24896, 24895, 24894, 24893, 24892, 24780, 24779, 24778, 24777, 24776, 24775, 24687, 24686, 24685, 24651, 24650, 24649, 24648, 24647, 24646, 24638, 24637, 24636, 24635, 24634, 24633, 24632, 24631, 24630, 24629, 24628, 24627, 24438, 24437, 24436, 24435, 24434, 24433, 24333, 24332, 24331, 24330, 24329, 24328, 24248, 24247, 24246, 24135, 24134, 24133, 24132, 24131, 24130, 24129, 24128, 24127, 24079, 24078, 24077, 24076, 23910, 23909, 23908, 23907, 23906, 23903, 23855, 23854, 23853, 23852, 23851, 23850, 23849, 23848, 23847, 23681, 23680, 23679, 23678, 23677, 23676, 23633, 23632, 23631, 23630, 23629, 23628, 23610, 23609, 23608, 23607, 23606, 23605, 23568, 23567, 23566, 23565, 23564, 23563, 23562, 23561, 23560, 23559, 23558, 23557, 23556, 23555, 23554, 23553, 23552, 23551, 23481, 23480, 23479, 23430, 23429, 23428, 23427, 23426, 23425, 23424, 23423, 23422, 23421, 23420, 23419, 23418, 23417, 23409, 23408, 23407, 23406, 23346, 23345, 23344, 23343, 23342, 23257, 23256, 23255, 23124, 23123, 23122, 23121, 23120, 23119, 23118, 23117, 23116, 22916, 22915, 22914, 22913, 22912, 22911, 22803, 22802, 22801, 22800, 22799, 22798, 22797, 22796, 22795, 22792, 22791, 22789, 22788, 22787, 22786, 22493, 22492, 22491, 22342, 22341, 22340, 22339, 22338, 22337, 22114, 22113, 22021, 22020, 22019, 22018, 22017, 22016, 21985, 21984, 21983, 21982, 21981, 21980, 21794, 21793, 21792, 21791, 21790, 21789, 21772, 21771, 21770, 21769, 21768, 21767, 21636, 21635, 21634, 21633, 21632, 21631, 21630, 21629, 21628, 21627, 21336, 21335, 21334, 21333, 21332, 21331, 21254, 21238, 21237, 21236, 21235, 21234, 21233, 21232, 21231, 21230, 21226, 21225, 21224, 21213, 21212, 21211, 21210, 19939, 19938, 19937, 19936, 19935, 19934, 19933, 19932, 19141, 19140, 19139, 19138, 19137, 19136);
                break;
            case 3:
                $array_limpieza = array(12345,12344,12342,12341,12340,12339,12338,12337,12335,12333,12330,12329,12328,12327,12326,12325,12324,12321,12319,12318,12317,12316,12315,12314,12313,12312,12311,12310,12261,12260,12259,12257,12256,12255,12254,12253,12252,12251,12250,12249,12248,12195,12194,12193,12192,12191,12190,12189,12188,12187,12186,12184,12182,12180,12179,12178,12177,12176,12147,12146,12145,12046,12045,12044,12043,12042,12041,12040,12039,12038,12025,12024,12023,12022,12021,12018,12014,12013,11985,11984,11983,11982,11981,11980,11979,11978,11977,11976,11975,11974,11973,11972,11971,11969,11968,11965,11964,11963,11962,11961,11960,11959,11958,11957,11956,11955,11954,11952,11950,11949,11948,11862,11861,11860,11859,11858,11857,11856,11855,11854,11853,11852,11851,11850,11849,11848,11847,11846,11761,11760,11759,11758,11757,11756,11755,11754,11753,11752,11737,11736,11734,11733,11731,11729,11728,11727,11726,11725,11724,11723,11722,11721,11719,11717,11715,11714,11713,11712,11711,11710,11709,11708,11707,11706,11608,11606,11604,11602,11588,11587,11586,11585,11584,11583,11582,11581,11580,11578,11577,11576,11575,11574,11573,11571,11570,11569,11568,11567,11566,11565,11564,11563,11562,11561,11560,11559,11558,11557,11556,11555,11554,11553,11551,11549,11548,11547,11546,11545,11544,11540,11387,11535,11377,11375,11373,11372,11371,11370,11369,11368,11367,11366,11365,11364,11363,11359,11355,11354,11350,11346,11345,11344,11343,11342,11341,11340,11338,11336,11335,11334,11333,11332,11330,11328,11327,11326,11325,11324,11323,11322,11319,11283,11282,11281,11280,11279,11076,11075,11073,11067,11066,11065,11062,11061,11060,11059,11056,11052,11051,11050,11049,11047,11046,11045,11042,11039,11030,11027,10913,10912,10911,10910,10909,10908,10907,10906,10904,10903,10902,10900,10897,10896,10892,10889,10887,10886,10776,10775,10774,10773,10772,10771,10770,10766,10762,10753,10752,10751,10750,10749,10746,10743,10742,10741,10740,10739,10738,10737,10736,10735,10733,10731,10727,10726,10724,10723,10722,10716,10715,10710,10709,10708,10656,10655,10654,10653,10652,10651,10650,10649,10648,10647,10646,10642,10641,10640,10639,10638,10637,10636,10635,10487,10485,10483,10482,10481,10480,10479,10478,10477,10474,10471,10468,10467,10466,10464,10459,10458,10457,10456,10455,10454,10453,10451,10449,10447,10446,10445,10444,10443,10442,10441,10439,10437,10435,10434,10433,10432,10431,10430,10428,10426,10425,10424,10422,10420,10419,10418,10417,10416,10415,10414,10412,10410,10409,10408,10406,10404,10402,10399,10397,10395,10393,10391,10390,10398,10388,10387,10386,10385,10384,10383,10382,10381,10380,10378,10376,10246,10244,10243,10242,10241,10240,10239,10238,10237,10236,10235,10233,10230,10228,10225,10147,10144,10141,10140,10139,10138,10135,10132,10129,10128,10127,10126,9586,9582,9578,9574,9570,9566,9562,9558,9550,9545,9540,9535,9531,9527,9523,9522,9519,9518,9514,9510,9506,9502,9500,9496,9494,9493,9489,9488,9484,9480,9476,9472,9468,9463,9459,9450,9449,9445,9440,9439,9434,9428,9424,9419,9418,9417,9416,9415,9411,9409,9408,9405,9404,9403,9402,9401,9400,9399,9398,9397,9396,9395,9394,9393,9392,9391,9390,9389,9388,9387,9386,9385,9384,9383,9382,9381,9380,9379,9377,9376,9375,9374,9372,9371,9370,9369,9368,9367,9366,9365,9364,9363,9362,9361,9360,9359,9358,9357,9356,9355,9354,9353,9352,9351,9350,9349,9348,9347,9346,9345,9344,9343,9342,9341,9340,9339,9338,9337,9336,9335,9334,9333,9332,9331,9330,9329,9328,9327,9326,9325,9324,9323,9322,9321,9320,9319,9316,9313,9312,9294,9288,9287,9286,9285,9284,9282,9280,9279,9273,9269,9265,9261,9258,9252,9250,9246,9242,9237,9233,9228,9224,9229,9215,9210,9206,9201,9195,9190,9185,9180,9175,9169,9164,9159,9153,9147,9142,9132,9126,9120,9115,9110,9106,9102,9095,9088,9081,9074,8989,8986,8985,8983,8981,8980,8979,8978,8977,8976,8975,8974,8973,8972,8971,8970,8968,8967,8966,8965,8964,8963,8962,8961,8957,8953,8951,8947,8946,8945,8944,8942,8941,8940,8939,8938,8937,8936,8935,8934,8933,8883,8882,8881,8880,8879,8878,8877,8876,8875,8874,8873,8872,8867,8864,8861,8859,8858,8857,8856,8855,8854,8852,8851,8850,8849,8848,8847,8846,8845,8841,8840,8839,8837,8835,8832,8831,8829,8828,8827,8826,8825,8824,8823,8822,8677,8431,8422,9421,9417,8416,8414,8411,8410,8406,8404,8402,8399,8370,8369,8366,8363,8361,8359,8358,8357,8355,8353,8351,8349,8347,8345,8344,8335,8333,8331,8329,8328,8326,8324,8323,8322,8320,8317,8312,8308,8307,8305,8304,8303,8301,8299,8297,8295,8294,8292,8291,8290,8287,8286,8285,8284,8283,8282,8281,8280,8278,8276,8275,8272,8270,8269,8267,8265,8264,8263,8262,8261,8260,8259,8258,8257,8256,8255,8253,8251,8259,8248,8247,8246,8245,8244,8243,8242,8241,8240,8239,8238,8237,8236,8235,8234,8233,8232,8231,8230,8229,8228,8226,8225,8223,8222,8221,8220,8219,8218,8217,8216,8215,8213,8211,8210,8209,8207,8205,8203,8201,8200,8199,8199,8198,8197,8196,8195,8194,8193,8192,8191,8190,8189,8188,8187,8186,8185,8183,8181,8180,8179,8178,8170,8169,8168,8167,8166,8165,8163,8161,8161,8160,8159,8158,8157,8156,8155,8154,8153,8151,8150,8149,8148,8146,8145,8144,8143,8142,8141,8140,8139,8138,8137,8136,8135,8134,8130,8129,8125,8123,8120,8119,8118,8117,8116,8115,814,8113,8112,8111,8109,8108,8106,8105,8104,8103,8102,8101,8100,8099,8098,8099,8097,8096,8095,8094,8093,8092,8091,8087,8086,8081,8080,8079,8078,8077,8076,8075,8074,8073,8072,8071,8069,8068,8067,8066,8064,8062,8061,8060,8058,8057,8056,8055,8054,8053,8052,8051,8050,8049,8047,8046,8045,8043,8042,8040,8039,8037,8036,8035,8033,8029,8028,8024,8020,8018,8017,8016,8015,8014,8013,8012,8011,8010,8009,8007,8006,8005,8004,8003,8002,8001,7997,7996,7993,7992,7988,7987,7986,7984,7982,7981,7979,7436,7429,7143,7127,7106,6963,6962,6909,4776,4652,4651,4639,4476,4365,4292,4241,4073,4049,4003,3941,3804,3575,3557,3542,3535,3534,3019,3018,3017,2147,2137,1860,1437,237);
                break;
            case 4:
                $array_limpieza = array(19019,19020,19021,19022,19023,18715,18716,18718,18719,18721,18704,18701,18700,18698,18696,18695,18694,18693,18692,18691,18690,18689,18688,18638,18637,18636,18635,18634,18633,18632,18631,186,1796030,18629,18612,18611,18610,18609,18608,18607,18606,18605,18604,18603,18127,18126,18125,18124,18123,18122,17966,17965,17960,17956,17952,17170,17098,17096,17095,17094,17093,17092,17091,17090,17089,17087,17086,17085,17084,17083,17082,17081,17080,17079,17078,16944,16943,16942,16941,16940,16939,16938,16937,16936,16935,16934,16933,16909,16908,16907,16898,16897,16896,16894,16892,16890,16887,16879,16873,16871,16869,16867,16865,16863,16277,16276,16275,16274,16273,16272,16271,16270,16199,16046,16045,16044,16043,16040,16039,16038,16027,16018,16013,16012,16011,16006,16003,16001,16000,15999,15991,15988,15986,15985,15984,15983,15982,15977,15976,15971,15966,15965,15416,15415,15414,15413,15412,15409,15406,15403,15393,15392,15391,15390,15389,15388,15387,15385,15383,15380,15378,15377,15376,15375,15374,15372,15365,15363,15361,15360,15359,15358,15355,15353,15350,15348,15346,15343,15339,15338,15336,15333,15329,15326,15322,15319,15315,15285,15284,15283,15282,15281,15280,15278,15276,15274,15273,15272,15271,15268,15265,15262,15261,15260,15259,15258,15257,15256,15255,15254,15253,15251,15249,15247,15244,15241,15238,15237,15236,15235,15234,15233,15232,15231,15230,15227,15224,15221,15220,15219,15218,15215,15212,15209,15208,15207,15206,15184,15179,15176,15175,15174,15173,15172,15169,15166,15161,15156,15151,15030,15028,15026,15024,15022,15020,15019,15018,15017,15015,15013,15011,14998,14997,14996,14993,14990,14998,14891,14890,14889,14888,14880,14879,14877,14876,14875,14874,14339,14338,14333,14332,14331,14330,14329,14328,14237,14236,14235,14234,14233,14232,14231,14230,14214,14213,14212,13991,13989,13987,13977,13976,13975,13973,13971,13969,13968,13967,13966,13440,13436,13432,13431,13427,13426,13422,13418,13417,13416,13415,13414,13413,13412,13411,13410,13409,13408,13407,13406,13385,13384,13379,13374,13369,12984,12983,12982,12981,12980,12979,12943,12942,12941,12940,12939,12938,12937,12936,12935,12934,12933,12796,12795,12794,12793,12792,12791,12783,12782,12781,12780,12779,12778,12777,12776,12775,12774,12689,12686,12685,12684,12683,12682,12681,12680,12679,12678,12677,12676,12675,12674,12673,12667,12666,12665,12654,12653,12652,12634,12633,12632,12631,12630,12629,12628,12627,12626,12625,12624,12602,12601,12600,12599,12598,12597,12593,12589,12585,12579,12571,12570,12568,12567,12536,12535,12532,12531,12530,12529,12526,12523,12520,12519,12518,12517,12514,12513,12510,12509,12508,12507,12504,12503,12500,12499,12498,12497,12494,12491,12488,12487,12486,12485,12481,12478,12475,12474,12473,12472,12469,12466,12463,12462,12461,12459,12456,12453,12450,12449,12447,12446,12445,12444,12441,12438,12435,16201,16200);
                break;
        }
        $this->db->select('id_enhance, front_image, back_image, right_image, left_image, sold, date')
            ->from('Enhance')
            ->where("id_cliente =", 341)
            ->where_in("id_enhance", $array_limpieza)
            ->where("sold <=", 0);
        $campanas = $this->db->get()->result();

        try{
            if (sizeof($campanas) > 0) {
                $mensaje = 'eliminando imagenes de las campañas del cliente.';
                foreach ($campanas as $campana) {
                    $time = strstr(str_replace("_","", strstr($campana->front_image, '_')), '.', true);
                    $dir = strstr($campana->front_image, '_', true);

                    $dir_dibujo_front =  str_replace("front", "dibujo_front_", $dir).md5($time).".png";
                    $dir_dibujo_back =  str_replace("front", "dibujo_back_", $dir).md5($time).".png";
                    $dir_dibujo_left =  str_replace("front", "dibujo_left_", $dir).md5($time).".png";
                    $dir_dibujo_right =  str_replace("front", "dibujo_right_", $dir).md5($time).".png";

                    if (!is_dir($campana->front_image) && file_exists($campana->front_image)) {
                        unlink($campana->front_image);
                    }
                    if (!is_dir($campana->back_image) && file_exists($campana->back_image)) {
                        unlink($campana->back_image);
                    }
                    if (!is_dir($campana->right_image) && file_exists($campana->right_image)) {
                        unlink($campana->right_image);
                    }
                    if (!is_dir($campana->left_image) && file_exists($campana->left_image)) {
                        unlink($campana->left_image);
                    }
                    if (!is_dir($dir_dibujo_front) && file_exists($dir_dibujo_front)) {
                        unlink($dir_dibujo_front);
                    }
                    if (!is_dir($dir_dibujo_back) && file_exists($dir_dibujo_back)) {
                        unlink($dir_dibujo_back);
                    }
                    if (!is_dir($dir_dibujo_left) && file_exists($dir_dibujo_left)) {
                        unlink($dir_dibujo_left);
                    }
                    if (!is_dir($dir_dibujo_right) && file_exists($dir_dibujo_right)) {
                        unlink($dir_dibujo_right);
                    }
                }
                $mensaje = 'eliminando enhances de la base de datos.';
                foreach ($campanas as $campana) {
                    $this->db->delete('Enhance', array('id_enhance' => $campana->id_enhance));
                }
                $mensaje = "exito en la limpieza";
                echo $mensaje;
            }
        }catch(Exception $e){
            echo print_r($e);
        }
    }

    public function avisar_baja_disenos(){
        $this->db->select("Clientes.id_cliente, nombres, apellidos, email")
            ->from("Clientes")
            ->join("Enhance", "Clientes.id_cliente=Enhance.id_cliente")
            ->where("Enhance.date < '2019-01-01 00:00:00'")
            ->where("Enhance.sold", 0)
            ->group_by("email");
        $clientes = $this->db->get()->result();

	    foreach ($clientes as $cliente){
            $datos_correo['nombre'] = $cliente->nombres . ' ' . $cliente->apellidos;
            $datos_correo['anos'] = '2018';

            $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
            $email = new SendGrid\Email();
            $email->addTo($cliente->email, $datos_correo->nombre)
                ->setFrom('administracion@printome.mx')
                ->setReplyTo('administracion@printome.mx')
                ->setFromName('printome.mx')
                ->setSubject('Aviso de limpieza de diseños | printome.mx')
                ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_aviso_limpieza_disenos', $datos_correo, TRUE));
            $sendgrid->send($email);
        }
    }

    public function contabilizar_campanas(){
	    $this->db->select("id_enhance")->from("Enhance")->where("estatus", 1)->where('type', 'fijo')->where('id_parent_enhance', 0);;
	    $campanas = $this->db->get()->result();
	    foreach ($campanas as $campana){
            $update = new stdClass();
            $update->sold = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
            $this->db->where("id_enhance", $campana->id_enhance)->update('Enhance', $update);
        }
    }

//    public function informe_error_correo(){
//	    $this->db->select("Clientes.nombres, Clientes.apellidos, Clientes.email")
//            ->from("Pedidos")->join("Clientes","Pedidos.id_cliente = Clientes.id_cliente")
//            ->where("Pedidos.id_paso_pedido", 6)
//            ->group_by("Clientes.id_cliente");
//	    $clientes = $this->db->get()->result();
//	    foreach ($clientes as $cliente){
//            $datos_correo = array();
//	        $datos_correo['nombre'] = $cliente->nombres." ".$cliente->apellidos;
//
//            $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
//            $email = new SendGrid\Email();
//            $email->addTo($cliente->email, $datos_correo['nombre'])
//                ->setFrom('hello@printome.mx')
//                ->setReplyTo('hello@printome.mx')
//                ->setFromName('printome.mx')
//                ->setSubject('¡Aviso importante! | printome.mx')
//                ->setHtml($this->load->view('plantillas_correos/nuevas/aviso_correo_entregado_equivocado', $datos_correo, TRUE));
//            $sendgrid->send($email);
//        }
//    }



//    public function subir_paso_pedido(){
//        $this->db->query('UPDATE Pedidos
//            SET id_paso_pedido = id_paso_pedido + 1');
//    }

//    public function enviar_correos_promodescuentos(){
//	    $array_correos = array(
//            
//        );
//
//	    foreach($array_correos as $correo){
//
//	        $datos_correo = array();
//	        $datos_correo['nombre'] = $correo['nombre']." ".$datos_correo['apellido'];
//	        $datos_correo['guia'] = $correo['guia'];
//
//            $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
//            $email = new SendGrid\Email();
//            $email->addTo($correo['email'], $datos_correo['nombre'])
//                ->addBcc('javier.quijano@printome.mx', 'Javier Quijano')
//                ->setFrom('administracion@printome.mx')
//                ->setReplyTo('administracion@printome.mx')
//                ->setFromName('printome.mx')
//                ->setSubject('Guia de Envio Pedido Printome | printome.mx')
//                ->setHtml($this->load->view('plantillas_correos/nuevas/aviso_guia_promodescuentos', $datos_correo, TRUE));
//            $sendgrid->send($email);
//        }
//    }


//    public function avisar_pandemia_plazo_definido(){
//        $this->db->select("Clientes.id_cliente, nombres, apellidos, email")
//            ->from("Clientes")
//            ->join("Enhance", "Clientes.id_cliente=Enhance.id_cliente")
//            ->where("Enhance.date > '2020-03-30 00:00:00'")
//            ->where("Enhance.type", "limitado")
//            ->group_by("email");
//        $clientes = $this->db->get()->result();
//
//        foreach ($clientes as $cliente){
//            $datos_correo['nombre'] = $cliente->nombres . ' ' . $cliente->apellidos;
//
//            $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
//            $email = new SendGrid\Email();
//            $email->addTo($cliente->email, $datos_correo['nombre'])
//                ->setFrom('administracion@printome.mx')
//                ->setReplyTo('administracion@printome.mx')
//                ->setFromName('printome.mx')
//                ->setSubject('Aviso contingencia aprobación de diseños | printome.mx')
//                ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_aviso_pandemia_definido', $datos_correo, TRUE));
//            $sendgrid->send($email);
//        }
//    }

//    public function aviso_nuevas_mascarillas(){
//        $this->db->select("id_cliente, nombres, apellidos, email")
//            ->from("Clientes c")
//            ->join("Pedidos p", "p.id_cliente = c.id_cliente")
//            ->join("ProductosPorPedido ppp", "p.id_pedido = ppp.id_pedido")
//            ->where("ppp.id_enhance !=", 34924)
//            ->or_where("ppp.id_enhance !=", 34925)
//            ->group_by("email");
//        $clientes = $this->db->get()->result();
//
//        foreach ($clientes as $cliente){
//            $datos_correo['nombre'] = $cliente->nombres . ' ' . $cliente->apellidos;
//
//            $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
//            $email = new SendGrid\Email();
//            $email->addTo($cliente->email, $datos_correo['nombre'])
//                ->setFrom('administracion@printome.mx')
//                ->setReplyTo('administracion@printome.mx')
//                ->setFromName('printome.mx')
//                ->setSubject($datos_correo['nombre'].', cubrebocas de algodón ¡No te quedes sin el tuyo!')
//                ->setHtml($this->load->view('plantillas_correos/nuevas/cliente_aviso_nuevas_mascarillas', $datos_correo, TRUE));
//            $sendgrid->send($email);
//        }
//    }
}


