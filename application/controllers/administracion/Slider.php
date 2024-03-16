<?php
/**
 * Created by PhpStorm.
 * User: Javier
 * Date: 22/03/2019
 * Time: 12:53
 */

class Slider extends MY_Controller
{
    public function index() {
        $datos_header['seccion_activa'] = 'slider';
        $datos_seccion['slides'] = $this->slider_modelo->obtener_sliders_admin();
        $datos_seccion['slidescomprar'] = $this->slider_modelo->obtener_sliders_comprar();
        $datos_footer['scripts'] = 'administracion/slider/scripts';

        $this->load->view('administracion/header', $datos_header);
        $this->load->view('administracion/slider/index', $datos_seccion);
        $this->load->view('administracion/footer', $datos_footer);
    }

    public function agregar_nuevo_banner(){
        $nombre_slide = $this->input->post('nombre_slide');
        $alt = $this->input->post('alt_slide');
        $link = $this->input->post('link_slide');
        $boton = $this->input->post('boton_slide');
        $texto = $this->input->post('texto_slide');
        $principal = $this->input->post('principal_slide');

        $directorio_pre = 'assets/nimages/slider_inicio';
        if(!file_exists($directorio_pre) and !is_dir($directorio_pre)) {
            mkdir($directorio_pre);
            chmod($directorio_pre, 0755);
        }
        $directorio_anio = $directorio_pre.'/'.date("Y");
        if(!file_exists($directorio_anio) and !is_dir($directorio_anio)) {
            mkdir($directorio_anio);
            chmod($directorio_anio, 0755);
        }

        $directorio_mes = $directorio_anio.'/'.date("m");
        if(!file_exists($directorio_mes) and !is_dir($directorio_mes)) {
            mkdir($directorio_mes);
            chmod($directorio_mes, 0755);
        }
        $directorio = $directorio_mes;

        $config['upload_path'] = $directorio;
        $config['file_ext_tolower'] = TRUE;
        $config['allowed_types'] = 'jpg|jpeg|jpe|png';
        var_dump($_FILES);
        if($_FILES['file']['error'] == 0 && $_FILES['file']['size'] > 0) {
            $config['file_name'] = time() . '_' . trim($nombre_slide) . '_' . rand(111, 999);
            $this->upload->initialize($config);
            echo "entra";
            $_FILES['userfile']['name'] = $_FILES['file']['name'];
            $_FILES['userfile']['type'] = $_FILES['file']['type'];
            $_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
            $_FILES['userfile']['error'] = $_FILES['file']['error'];
            $_FILES['userfile']['size'] = $_FILES['file']['size'];

            $this->upload->do_upload();
            $data = $this->upload->data();

            $config['source_image'] = $data['full_path'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;

            $configs = array(
                array('width' => 1440, 'height' => 533, 'quality' => 65, 'new_image' => $data['file_path'] . '1440_' . $data['file_name'], 'new_file' => '1440_' . $data['file_name']),
                array('width' => 960, 'height' => 356, 'quality' => 65, 'new_image' => $data['file_path'] . '960_' . $data['file_name'], 'new_file' => '960_' . $data['file_name']),
                array('width' => 480, 'height' => 179, 'quality' => 65, 'new_image' => $data['file_path'] . '480_' . $data['file_name'], 'new_file' => '480_' . $data['file_name'])
            );

            foreach ($configs as $conf) {
                $config['width'] = $conf['width'];
                $config['height'] = $conf['height'];
                $config['quality'] = $conf['quality'];
                $config['new_image'] = $conf['new_image'];

                $this->image_lib->initialize($config);
                $this->image_lib->resize();
            }

            $banner = new stdClass();
            $banner->nombre_imagen = $nombre_slide;
            $banner->nombre_imagen_slug = trim(str_replace(' ', '_', $nombre_slide));
            $banner->imagen_original = $data['file_name'];
            $banner->imagen_large = $configs[0]['new_file'];
            $banner->imagen_medium = $configs[1]['new_file'];
            $banner->imagen_small = $configs[2]['new_file'];
            $banner->fecha_subido = date('Y-m-d H:i:s');
            $banner->alt = $alt;
            $banner->url_slide = $link;
            $banner->directorio = $directorio;
            $banner->boton = $boton;
            $banner->texto = $texto;
            $banner->texto_principal = $principal;
            $banner->estatus = 1;


            $this->db->select('MAX(id_orden) AS max_orden')
                ->from('Slider')
                ->where('estatus', 1);
            $contar_fotos = $this->db->get()->row();

            if(isset($contar_fotos->max_orden)) {
                if($contar_fotos->max_orden == 0) {
                    $banner->id_orden = 1;
                } else {
                    $banner->id_orden = (int)$contar_fotos->max_orden + 1;
                }
            } else {
                $banner->id_orden = 1;
            }
            $this->db->select('*')
                ->from('Slider')
                ->where('estatus', 0);
            $inactivos = $this->db->get()->result();

            $this->db->insert('Slider', $banner);

            foreach($inactivos as $posicion => $slide ) {
                $this->db->query("UPDATE Slider SET id_orden=".($slide->id_orden+1)." WHERE id_slide=".$slide->id_slide);
            }
        }
        redirect('administracion/slider');
    }
    public function reordenar_slides(){
        if(!$this->input->post('data')) {
            return false;
        } else {
            foreach($this->input->post('data') as $posicion => $id_slide ) {
                $this->db->query("UPDATE Slider SET id_orden=".($posicion+1)." WHERE id_slide=".$id_slide);
            }
        }
    }

    public function editar_banner(){
        $nombre_slide = $this->input->post('nombre_slide');
        $alt = $this->input->post('alt_slide');
        $link = $this->input->post('link_slide');
        $id_slide = $this->input->post('id_slide');
        $boton = $this->input->post('boton_slide');
        $texto = $this->input->post('texto_slide');
        $principal = $this->input->post('principal_slide');

        $slide = new stdClass();
        $slide->nombre_imagen = $nombre_slide;
        $slide->alt = $alt;
        $slide->url_slide = $link;
        $slide->boton = $boton;
        $slide->texto = $texto;
        $slide->texto_principal = $principal;

        $this->db->where("id_slide", $id_slide);
        $this->db->update("Slider", $slide);
        redirect('administracion/slider');
    }

    public function borrar_banner(){
        $id_slide = $this->input->post('id_slide');

        $slide = new stdClass();
        $slide->estatus = 33;

        $this->db->where("id_slide", $id_slide);
        $this->db->update("Slider", $slide);
        redirect('administracion/slider');
    }

    public function cambiar_estatus(){
        $id_slide = $this->input->post('id_slide');
        $estatus = $this->input->post('estatus');

        $slide = new stdClass();
        $slide->estatus = $estatus;

        $this->db->where("id_slide", $id_slide);
        $this->db->update("Slider", $slide);
    }

    /*Slider comprar*/

    public function agregar_nuevo_comprar(){
        $nombre_slide = $this->input->post('nombre_slide');
        $alt = $this->input->post('alt_slide');
        $link = $this->input->post('link_slide');
        $boton = $this->input->post('boton_slide');
        $texto = $this->input->post('texto_slide');
        $principal = $this->input->post('principal_slide');

        $directorio_pre = 'assets/nimages/slider_comprar';
        if(!file_exists($directorio_pre) and !is_dir($directorio_pre)) {
            mkdir($directorio_pre);
            chmod($directorio_pre, 0755);
        }
        $directorio_anio = $directorio_pre.'/'.date("Y");
        if(!file_exists($directorio_anio) and !is_dir($directorio_anio)) {
            mkdir($directorio_anio);
            chmod($directorio_anio, 0755);
        }

        $directorio_mes = $directorio_anio.'/'.date("m");
        if(!file_exists($directorio_mes) and !is_dir($directorio_mes)) {
            mkdir($directorio_mes);
            chmod($directorio_mes, 0755);
        }
        $directorio = $directorio_mes;

        $config['upload_path'] = $directorio;
        $config['file_ext_tolower'] = TRUE;
        $config['allowed_types'] = 'jpg|jpeg|jpe|png';
        var_dump($_FILES);
        if($_FILES['file']['error'] == 0 && $_FILES['file']['size'] > 0) {
            $config['file_name'] = time() . '_' . trim($nombre_slide) . '_' . rand(111, 999);
            $this->upload->initialize($config);
            echo "entra";
            $_FILES['userfile']['name'] = $_FILES['file']['name'];
            $_FILES['userfile']['type'] = $_FILES['file']['type'];
            $_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
            $_FILES['userfile']['error'] = $_FILES['file']['error'];
            $_FILES['userfile']['size'] = $_FILES['file']['size'];

            $this->upload->do_upload();
            $data = $this->upload->data();

            $config['source_image'] = $data['full_path'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;

            $configs = array(
                array('width' => 1440, 'height' => 533, 'quality' => 65, 'new_image' => $data['file_path'] . '1440_' . $data['file_name'], 'new_file' => '1440_' . $data['file_name']),
                array('width' => 960, 'height' => 356, 'quality' => 65, 'new_image' => $data['file_path'] . '960_' . $data['file_name'], 'new_file' => '960_' . $data['file_name']),
                array('width' => 480, 'height' => 179, 'quality' => 65, 'new_image' => $data['file_path'] . '480_' . $data['file_name'], 'new_file' => '480_' . $data['file_name'])
            );

            foreach ($configs as $conf) {
                $config['width'] = $conf['width'];
                $config['height'] = $conf['height'];
                $config['quality'] = $conf['quality'];
                $config['new_image'] = $conf['new_image'];

                $this->image_lib->initialize($config);
                $this->image_lib->resize();
            }

            $banner = new stdClass();
            $banner->nombre_imagen = $nombre_slide;
            $banner->nombre_imagen_slug = trim(str_replace(' ', '_', $nombre_slide));
            $banner->imagen_original = $data['file_name'];
            $banner->imagen_large = $configs[0]['new_file'];
            $banner->imagen_medium = $configs[1]['new_file'];
            $banner->imagen_small = $configs[2]['new_file'];
            $banner->fecha_subido = date('Y-m-d H:i:s');
            $banner->alt = $alt;
            $banner->url_slide = $link;
            $banner->directorio = $directorio;
            $banner->boton = $boton;
            $banner->texto = $texto;
            $banner->texto_principal = $principal;
            $banner->estatus = 1;



            $this->db->select('MAX(id_orden) AS max_orden')
                ->from('SliderComprar')
                ->where('estatus', 1);
            $contar_fotos = $this->db->get()->row();

            if(isset($contar_fotos->max_orden)) {
                if($contar_fotos->max_orden == 0) {
                    $banner->id_orden = 1;
                } else {
                    $banner->id_orden = (int)$contar_fotos->max_orden + 1;
                }
            } else {
                $banner->id_orden = 1;
            }
            $this->db->select('*')
                ->from('SliderComprar')
                ->where('estatus', 0);
            $inactivos = $this->db->get()->result();

            //print_r($banner);
            $this->db->insert('SliderComprar', $banner);

            foreach($inactivos as $posicion => $slide ) {
                $this->db->query("UPDATE SliderComprar SET id_orden=".($slide->id_orden+1)." WHERE id_slide_comprar=".$slide->id_slide_comprar);
            }
        }
        redirect('administracion/slider');
    }

    public function reordenar_comprar(){
        if(!$this->input->post('data')) {
            return false;
        } else {
            foreach($this->input->post('data') as $posicion => $id_slide ) {
                $this->db->query("UPDATE SliderComprar SET id_orden=".($posicion+1)." WHERE id_slide_comprar=".$id_slide);
            }
        }
    }

    public function editar_comprar(){
        $nombre_slide = $this->input->post('nombre_slide');
        $alt = $this->input->post('alt_slide');
        $link = $this->input->post('link_slide');
        $id_slide = $this->input->post('id_slide_comprar');
        $boton = $this->input->post('boton_slide');
        $texto = $this->input->post('texto_slide');
        $principal = $this->input->post('principal_slide');

        $slide = new stdClass();
        $slide->nombre_imagen = $nombre_slide;
        $slide->alt = $alt;
        $slide->url_slide = $link;
        $slide->boton = $boton;
        $slide->texto = $texto;
        $slide->texto_principal = $principal;


        $this->db->where("id_slide_comprar", $id_slide);
        $this->db->update("SliderComprar", $slide);
    }

    public function borrar_comprar(){
        $id_slide = $this->input->post('id_slide_comprar');

        $slide = new stdClass();
        $slide->estatus = 33;

        $this->db->where("id_slide_comprar", $id_slide);
        $this->db->update("SliderComprar", $slide);
    }

    public function cambiar_estatus_comprar(){
        $id_slide = $this->input->post('id_slide_comprar');
        $estatus = $this->input->post('estatus');

        $slide = new stdClass();
        $slide->estatus = $estatus;

        $this->db->where("id_slide_comprar", $id_slide);
        $this->db->update("SliderComprar", $slide);
    }
    public function obtener_comprar(){
        $comprar['tiendas'] = $this->slider_modelo->obtener_sliders_comprar();

        echo json_encode($comprar);;
    }
    /*Fin slider comprar*/
}
