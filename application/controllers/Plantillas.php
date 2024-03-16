<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plantillas extends MY_Controller {

	private $clasificaciones;

	public function __construct()
	{
		parent::__construct();
		$this->clasificaciones = $this->clasificacion_m->obtener_clasificaciones_plantillas();
	}

	public function index($nombre_clasificacion_slug = null, $nombre_subclasificacion_slug = null, $nombre_subsubclasificacion_slug = null)
    {
		// Config
		$datos_header['seccion_activa'] = 'plantillas';
		$datos_header['meta']['title'] = 'Diseña de manera fácil con nuestras plantillas | printome.mx';
		$datos_header['meta']['description'] = 'Tenemos plantillas de diferentes temáticas para poder personalizar y estampar tus camisetas para uso personal o eventos memorables con máxima calidad y entrega exprés a domicilio en México.';
		$datos_header['meta']['imagen'] = '';

		$datos_header['clasificacion_activa'] = $nombre_clasificacion_slug;
        $datos_header['subclasificacion_activa'] = $nombre_subclasificacion_slug;
        $datos_header['subsubclasificacion_activa'] = $nombre_subsubclasificacion_slug;
		$datos_header['clasificaciones'] = $this->get_clasificaciones();

		if(!$nombre_clasificacion_slug) {
			foreach($datos_header['clasificaciones'] as $indice_clasificacion=>$clasificacion) {
				if(($clasificacion->plantillas + $clasificacion->subplantillas) > 0) {
					$datos_header['clasificaciones'][$indice_clasificacion]->plantillas_random = $this->plantillas_m->obtener_plantillas_random($clasificacion->id_clasificacion, 4);
				}
			}
			$datos_header['vista'] = 'catalogo/listado_clasificaciones_plantillas';
		} else {
            if(!$nombre_subclasificacion_slug) {
                foreach($datos_header['clasificaciones'] as $indice_clasificacion=>$clasificacion) {
    				if($nombre_clasificacion_slug == $clasificacion->nombre_clasificacion_slug) {
    					$datos_header['id_clasificacion'] = $clasificacion->id_clasificacion;
    					$datos_header['plantillas'] = $this->plantillas_m->obtener_plantillas_catalogo('activas', $datos_header['id_clasificacion']);


                        $datos_header['vista'] = 'catalogo/listado_plantillas';
    				}
    			}
            } else {
                if(!$nombre_subsubclasificacion_slug){
                    foreach($datos_header['clasificaciones'] as $indice_clasificacion=>$clasificacion) {
                        if($nombre_clasificacion_slug == $clasificacion->nombre_clasificacion_slug) {
                            foreach($clasificacion->subclasificaciones as $indice_subclasificacion=>$subclasificacion) {
                                if($nombre_subclasificacion_slug == $subclasificacion->nombre_clasificacion_slug) {
                                    $datos_header['id_clasificacion'] = $clasificacion->id_clasificacion;
                                    $datos_header['id_subclasificacion'] = $subclasificacion->id_clasificacion;
                                    $datos_header['plantillas'] = $this->plantillas_m->obtener_plantillas_catalogo('activas', $datos_header['id_clasificacion'], $datos_header['id_subclasificacion']);
                                    $datos_header['vista'] = 'catalogo/listado_plantillas';
                                }
                            }
                        }
                    }
                } else {
                    foreach($datos_header['clasificaciones'] as $indice_clasificacion=>$clasificacion) {
                        if($nombre_clasificacion_slug == $clasificacion->nombre_clasificacion_slug) {
                            foreach($clasificacion->subclasificaciones as $indice_subclasificacion=>$subclasificacion) {
                                if($nombre_subclasificacion_slug == $subclasificacion->nombre_clasificacion_slug) {
                                    foreach($subclasificacion->subsubclasificaciones as $indice_subsubclasificaciones => $subsubclasificacion) {
                                        if($nombre_subsubclasificacion_slug == $subsubclasificacion->nombre_clasificacion_slug) {
                                            $datos_header['id_clasificacion'] = $clasificacion->id_clasificacion;
                                            $datos_header['id_subclasificacion'] = $subclasificacion->id_clasificacion;
                                            $datos_header['id_subsubclasificacion'] = $subsubclasificacion->id_clasificacion;
                                            $datos_header['plantillas'] = $this->plantillas_m->obtener_plantillas_catalogo('activas', $datos_header['id_clasificacion'], $datos_header['id_subclasificacion'], $datos_header['id_subsubclasificacion']);
                                            $datos_header['vista'] = 'catalogo/listado_plantillas';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

			if(!$datos_header['id_clasificacion']) {
				redirect('plantillas');
			}
		}

		$this->load->view('header', $datos_header);
		$this->load->view('catalogo/despliegue_clasificaciones_plantillas');
		//$this->load->view('inicio/loquedicen');
		$this->load->view('footer');
	}

	public function get_clasificaciones()
	{
		return $this->clasificaciones;
	}

    public function newindex($search= null,$nombre_clasificacion_slug = null, $nombre_subclasificacion_slug = null, $nombre_subsubclasificacion_slug = null,$pagina=1)
    {
        // Config
        $this->load->library('pagination');
        $datos_header['seccion_activa'] = 'plantillas';
        $datos_header['meta']['title'] = 'Diseña de manera fácil con nuestras plantillas | printome.mx';
        $datos_header['meta']['description'] = 'Tenemos plantillas de diferentes temáticas para poder personalizar y estampar tus camisetas para uso personal o eventos memorables con máxima calidad y entrega exprés a domicilio en México.';
        $datos_header['meta']['imagen'] = '';

        $datos_header['clasificacion_activa'] = $nombre_clasificacion_slug;
        $datos_header['subclasificacion_activa'] = $nombre_subclasificacion_slug;
        $datos_header['subsubclasificacion_activa'] = $nombre_subsubclasificacion_slug;
        $datos_header['clasificaciones'] = $this->get_clasificaciones();
        $datos_footer['scripts'] = 'catalogo/scripts_plantillas';

        if($nombre_clasificacion_slug === null || $nombre_clasificacion_slug === ''){
            $nombre_clasificacion_slug = 'null';
        }
        if($nombre_subclasificacion_slug === null || $nombre_subclasificacion_slug === ''){
            $nombre_subclasificacion_slug = 'null';
        }
        if($nombre_subsubclasificacion_slug === null || $nombre_subsubclasificacion_slug === ''){
            $nombre_subsubclasificacion_slug = 'null';
        }
        if($search === null || $search === ''){
            $search = 'null';
        }

        //$datos_seccion['filtros'] = descomponer_filtros($this->input->get('filtros'));
        $config['base_url'] = site_url('plantillas').'/'.$search.'/'.$nombre_clasificacion_slug.'/'.$nombre_subclasificacion_slug.'/'.$nombre_subsubclasificacion_slug.'/'.'pagina/';

        if($nombre_clasificacion_slug==='null') {

            $total = $this->plantillas_m->contar_plantillas_catalogo($search,'activas');
        } else {
            if($nombre_subclasificacion_slug ==='null') {

                foreach($datos_header['clasificaciones'] as $indice_clasificacion=>$clasificacion) {
                    if($nombre_clasificacion_slug == $clasificacion->nombre_clasificacion_slug) {
                        $datos_header['id_clasificacion'] = $clasificacion->id_clasificacion;
                        $total = $this->plantillas_m->contar_plantillas_catalogo($search,'activas', $datos_header['id_clasificacion']);
                    }
                }
            } else {
                if($nombre_subsubclasificacion_slug ==='null'){

                    foreach($datos_header['clasificaciones'] as $indice_clasificacion=>$clasificacion) {
                        if($nombre_clasificacion_slug == $clasificacion->nombre_clasificacion_slug) {
                            foreach($clasificacion->subclasificaciones as $indice_subclasificacion=>$subclasificacion) {
                                if($nombre_subclasificacion_slug == $subclasificacion->nombre_clasificacion_slug) {
                                    $datos_header['id_clasificacion'] = $clasificacion->id_clasificacion;
                                    $datos_header['id_subclasificacion'] = $subclasificacion->id_clasificacion;

                                    $total = $this->plantillas_m->contar_plantillas_catalogo($search,'activas', $datos_header['id_clasificacion'],$datos_header['id_subclasificacion']);
                                }
                            }
                        }
                    }
                } else {

                    foreach($datos_header['clasificaciones'] as $indice_clasificacion=>$clasificacion) {
                        if($nombre_clasificacion_slug == $clasificacion->nombre_clasificacion_slug) {
                            foreach($clasificacion->subclasificaciones as $indice_subclasificacion=>$subclasificacion) {
                                if($nombre_subclasificacion_slug == $subclasificacion->nombre_clasificacion_slug) {
                                    foreach($subclasificacion->subsubclasificaciones as $indice_subsubclasificaciones => $subsubclasificacion) {
                                        if($nombre_subsubclasificacion_slug == $subsubclasificacion->nombre_clasificacion_slug) {
                                            $datos_header['id_clasificacion'] = $clasificacion->id_clasificacion;
                                            $datos_header['id_subclasificacion'] = $subclasificacion->id_clasificacion;
                                            $datos_header['id_subsubclasificacion'] = $subsubclasificacion->id_clasificacion;
                                            $total = $this->plantillas_m->contar_plantillas_catalogo($search,'activas', $datos_header['id_clasificacion'],$datos_header['id_subclasificacion'],$datos_header['id_subsubclasificacion']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if(!$datos_header['id_clasificacion']) {
                $datos_seccion['plantillas'] = $this->plantillas_m->contar_plantillas_catalogo($search,'activas');
            }
        }
        $config['total_rows'] = $total[0]->total;
        $config['first_url'] = site_url('plantillas').'/'.$search.'/'.$nombre_clasificacion_slug.'/'.$nombre_subclasificacion_slug.'/'.$nombre_subsubclasificacion_slug.'/';
        $config['per_page'] = 12;
        //$config['suffix'] = generar_url_filtro($datos_seccion['filtros']);
        $this->pagination->initialize($config);

        $start = (($pagina - 1) * $config['per_page'])+1;
        $offset = $config['per_page'];

        if($nombre_clasificacion_slug==='null') {

            $datos_seccion['plantillas'] = $this->plantillas_m->obtener_plantillas_completas($search,'activas', null,null,null,$start,$offset);
        } else {
            if($nombre_subclasificacion_slug ==='null') {

                foreach($datos_header['clasificaciones'] as $indice_clasificacion=>$clasificacion) {
                    if($nombre_clasificacion_slug == $clasificacion->nombre_clasificacion_slug) {
                        $datos_header['id_clasificacion'] = $clasificacion->id_clasificacion;
                        $datos_seccion['plantillas'] = $this->plantillas_m->obtener_plantillas_completas($search,'activas', $datos_header['id_clasificacion'],null,null,$start,$offset);
                    }
                }
            } else {
                if($nombre_subsubclasificacion_slug ==='null'){

                    foreach($datos_header['clasificaciones'] as $indice_clasificacion=>$clasificacion) {
                        if($nombre_clasificacion_slug == $clasificacion->nombre_clasificacion_slug) {
                            foreach($clasificacion->subclasificaciones as $indice_subclasificacion=>$subclasificacion) {
                                if($nombre_subclasificacion_slug == $subclasificacion->nombre_clasificacion_slug) {
                                    $datos_header['id_clasificacion'] = $clasificacion->id_clasificacion;
                                    $datos_header['id_subclasificacion'] = $subclasificacion->id_clasificacion;
                                    $datos_seccion['plantillas'] = $this->plantillas_m->obtener_plantillas_completas($search,'activas', $datos_header['id_clasificacion'],$datos_header['id_subclasificacion'],null,$start,$offset);
                                }
                            }
                        }
                    }
                } else {

                    foreach($datos_header['clasificaciones'] as $indice_clasificacion=>$clasificacion) {
                        if($nombre_clasificacion_slug == $clasificacion->nombre_clasificacion_slug) {
                            foreach($clasificacion->subclasificaciones as $indice_subclasificacion=>$subclasificacion) {
                                if($nombre_subclasificacion_slug == $subclasificacion->nombre_clasificacion_slug) {
                                    foreach($subclasificacion->subsubclasificaciones as $indice_subsubclasificaciones => $subsubclasificacion) {
                                        if($nombre_subsubclasificacion_slug == $subsubclasificacion->nombre_clasificacion_slug) {
                                            $datos_header['id_clasificacion'] = $clasificacion->id_clasificacion;
                                            $datos_header['id_subclasificacion'] = $subclasificacion->id_clasificacion;
                                            $datos_header['id_subsubclasificacion'] = $subsubclasificacion->id_clasificacion;
                                            $datos_seccion['plantillas'] = $this->plantillas_m->obtener_plantillas_completas($search,'activas', $datos_header['id_clasificacion'],$datos_header['id_subclasificacion'],$datos_header['id_subsubclasificacion'],$start,$offset);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if(!$datos_header['id_clasificacion']) {
                $datos_seccion['plantillas'] = $this->plantillas_m->obtener_plantillas_completas($search,'activas', null,null,null,$start,$offset);
            }
        }

        $datos_seccion['paginacion'] = $this->pagination->create_links();
        $datos_seccion['search'] = $search;


        $this->load->view('header', $datos_header);
        $this->load->view('catalogo/index.php',$datos_seccion);
        $this->load->view('footer',$datos_footer);

    }
}
