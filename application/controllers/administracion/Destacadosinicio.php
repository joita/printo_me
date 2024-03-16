<?php
/**
 * Created by PhpStorm.
 * User: Fabiola Medina
 * Date: 22/03/2021
 * Time: 12:53
 */

class Destacadosinicio extends MY_Controller
{
    public function index() {

        $datos_header['seccion_activa'] = 'destacadosinicio';
        $datos_seccion['destacadosinicio'] = $this->destacadosinicio_modelo->obtener_creadores_admin();
        $datos_footer['scripts'] = 'administracion/destacadosinicio/scripts';

        $this->load->view('administracion/header', $datos_header);
        $this->load->view('administracion/destacadosinicio/index',$datos_seccion);
        $this->load->view('administracion/footer', $datos_footer);
    }
    public function agregar_nuevo_creador(){

        $nombre_imagen = $this->input->post('nombre_imagen');
        $alt = $this->input->post('alt_imagen');
        $link = $this->input->post('link_imagen');
        $creador = $this->input->post('creador_imagen');

        $directorio_pre = 'assets/nimages/destacados_inicio';
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
            $config['file_name'] = time() . '_' . trim($nombre_imagen) . '_' . rand(111, 999);
            $this->upload->initialize($config);
            //echo "entra";
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

            if($_FILES['fileLogo']['error'] == 0 && $_FILES['fileLogo']['size'] > 0) {
                $config['file_name'] = time() . '_' . trim($creador) . '_' . rand(111, 999);
                $this->upload->initialize($config);
                //echo "entra";
                $_FILES['userfile']['name'] = $_FILES['fileLogo']['name'];
                $_FILES['userfile']['type'] = $_FILES['fileLogo']['type'];
                $_FILES['userfile']['tmp_name'] = $_FILES['fileLogo']['tmp_name'];
                $_FILES['userfile']['error'] = $_FILES['fileLogo']['error'];
                $_FILES['userfile']['size'] = $_FILES['fileLogo']['size'];

                $this->upload->do_upload();
                $dataLogo = $this->upload->data();

                $config['source_image'] = $dataLogo['full_path'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;

                $configsLogo = array(
                    //array('width' => 1440, 'height' => 533, 'quality' => 65, 'new_image' => $data['file_path'] . '1440_' . $data['file_name'], 'new_file' => '1440_' . $data['file_name']),
                    //array('width' => 960, 'height' => 356, 'quality' => 65, 'new_image' => $data['file_path'] . '960_' . $data['file_name'], 'new_file' => '960_' . $data['file_name']),
                    array('width' => 480, 'height' => 179, 'quality' => 65, 'new_image' => $dataLogo['file_path'] . '480_' . $dataLogo['file_name'], 'new_file' => '480_' . $dataLogo['file_name'])
                );

                foreach ($configsLogo as $confL) {
                    $config['width'] = $confL['width'];
                    $config['height'] = $confL['height'];
                    $config['quality'] = $confL['quality'];
                    $config['new_image'] = $confL['new_image'];

                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }
            }

            $newCreador = new stdClass();
            $newCreador->nombre_imagen = $nombre_imagen;
            $newCreador->nombre_imagen_slug = trim(str_replace(' ', '_', $nombre_imagen));
            $newCreador->imagen_original = $data['file_name'];
            $newCreador->imagen_large = $configs[0]['new_file'];
            $newCreador->imagen_medium = $configs[1]['new_file'];
            $newCreador->imagen_small = $configs[2]['new_file'];
            $newCreador->logo = $configsLogo[0]['new_file'];
            $newCreador->logo_slug = trim(str_replace(' ', '_', $creador));
            $newCreador->fecha_subido = date('Y-m-d H:i:s');
            $newCreador->alt = $alt;
            $newCreador->url_imagen = $link;
            $newCreador->directorio = $directorio;
            $newCreador->creador = $creador;
            $newCreador->estatus = 1;

            //print_r($newCreador);
            //exit();

            $this->db->select('MAX(id_orden) AS max_orden')
                ->from('CreadoresInicio')
                ->where('estatus', 1);
            $contar_fotos = $this->db->get()->row();

            if(isset($contar_fotos->max_orden)) {
                if($contar_fotos->max_orden == 0) {
                    $newCreador->id_orden = 1;
                } else {
                    $newCreador->id_orden = (int)$contar_fotos->max_orden + 1;
                }
            } else {
                $newCreador->id_orden = 1;
            }
            $this->db->select('*')
                ->from('CreadoresInicio')
                ->where('estatus', 0);
            $inactivos = $this->db->get()->result();

            $this->db->insert('CreadoresInicio', $newCreador);

            foreach($inactivos as $posicion => $creadoresinicio ) {
                $this->db->query("UPDATE CreadoresInicio SET id_orden=".($creadoresinicio->id_orden+1)." WHERE id_creadores_inicio=".$creadoresinicio->id_slide);
            }
        }
        redirect('administracion/destacadosinicio');
    }
    public function reordenar_creadores(){
        if(!$this->input->post('data')) {
            return false;
        } else {
            foreach($this->input->post('data') as $posicion => $id_creador ) {
                $this->db->query("UPDATE CreadoresInicio SET id_orden=".($posicion+1)." WHERE id_creadores_inicio=".$id_creador);
            }
        }
    }

    public function editar_creador(){
        $nombre_imagen = $this->input->post('nombre_imagen');
        $nombre_creador = $this->input->post('nombre_creador');
        $alt = $this->input->post('alt_creador');
        $link = $this->input->post('link_creador');
        $id_creador = $this->input->post('id_creador');

        $creador = new stdClass();
        $creador->nombre_imagen = $nombre_imagen;
        $creador->creador = $nombre_creador;
        $creador->alt = $alt;
        $creador->url_imagen = $link;

        $directorio_pre = 'assets/nimages/destacados_inicio';
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
        /*Playera*/
        if($_FILES['file']['error'] == 0 && $_FILES['file']['size'] > 0) {
            $config['file_name'] = time() . '_' . trim($nombre_imagen) . '_' . rand(111, 999);
            $this->upload->initialize($config);

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

            $creador->nombre_imagen_slug = trim(str_replace(' ', '_', $nombre_imagen));
            $creador->imagen_original = $data['file_name'];
            $creador->imagen_large = $configs[0]['new_file'];
            $creador->imagen_medium = $configs[1]['new_file'];
            $creador->imagen_small = $configs[2]['new_file'];


        }
        /*Logo*/
        if($_FILES['fileLogo']['error'] == 0 && $_FILES['fileLogo']['size'] > 0) {
            $config['file_name'] = time() . '_' . trim($nombre_creador) . '_' . rand(111, 999);
            $this->upload->initialize($config);
            echo "entra";
            $_FILES['userfile']['name'] = $_FILES['fileLogo']['name'];
            $_FILES['userfile']['type'] = $_FILES['fileLogo']['type'];
            $_FILES['userfile']['tmp_name'] = $_FILES['fileLogo']['tmp_name'];
            $_FILES['userfile']['error'] = $_FILES['fileLogo']['error'];
            $_FILES['userfile']['size'] = $_FILES['fileLogo']['size'];

            $this->upload->do_upload();
            $dataLogo = $this->upload->data();

            $config['source_image'] = $dataLogo['full_path'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;

            $configsLogo = array(
                array('width' => 480, 'height' => 179, 'quality' => 65, 'new_image' => $dataLogo['file_path'] . '480_' . $dataLogo['file_name'], 'new_file' => '480_' . $dataLogo['file_name'])
            );
            foreach ($configsLogo as $confL) {
                $config['width'] = $confL['width'];
                $config['height'] = $confL['height'];
                $config['quality'] = $confL['quality'];
                $config['new_image'] = $confL['new_image'];

                $this->image_lib->initialize($config);
                $this->image_lib->resize();
            }
            $creador->logo = $configsLogo[0]['new_file'];
            $creador->logo_slug = trim(str_replace(' ', '_', $nombre_creador));

        }

        $this->db->where("id_creadores_inicio", $id_creador);
        $this->db->update("CreadoresInicio", $creador);
        redirect('administracion/destacadosinicio');

    }

    public function borrar_creador(){
        $id_creador = $this->input->post('id_creador');

        $creador = new stdClass();
        $creador->estatus = 33;

        $this->db->where("id_creadores_inicio", $id_creador);
        $this->db->update("CreadoresInicio", $creador);
        redirect('administracion/destacadosinicio');
    }

    public function cambiar_estatus(){
        $id_creador = $this->input->post('id_creador');
        $estatus = $this->input->post('estatus');

        $creador = new stdClass();
        $creador->estatus = $estatus;

        $this->db->where("id_creadores_inicio", $id_creador);
        $this->db->update("CreadoresInicio", $creador);
    }
}