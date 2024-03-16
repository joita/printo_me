<?php
/**
 * Created by PhpStorm.
 * User: Fabiola Medina
 * Date: 05/04/2021
 * Time: 12:53
 */

class Masvendidos extends MY_Controller
{
    public function index() {

        $datos_header['seccion_activa'] = 'masvendidos';
        $datos_seccion['masvendidos'] = $this->masvendidos_modelo->obtener_masvendidos_admin();
        $datos_footer['scripts'] = 'administracion/masvendidos/scripts';

        $this->load->view('administracion/header', $datos_header);
        $this->load->view('administracion/masvendidos/index',$datos_seccion);
        $this->load->view('administracion/footer', $datos_footer);
    }
    public function agregar_nuevo(){

        $nombre_imagen = $this->input->post('nombre_imagen');
        $alt = $this->input->post('alt_imagen');
        $link = $this->input->post('link_imagen');
        $creador = $this->input->post('creador_imagen');

        $directorio_pre = 'assets/nimages/mas_vendidos';
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

            $newVendido = new stdClass();
            $newVendido->nombre_imagen = $nombre_imagen;
            $newVendido->nombre_imagen_slug = trim(str_replace(' ', '_', $nombre_imagen));
            $newVendido->imagen_original = $data['file_name'];
            $newVendido->imagen_large = $configs[0]['new_file'];
            $newVendido->imagen_medium = $configs[1]['new_file'];
            $newVendido->imagen_small = $configs[2]['new_file'];
            $newVendido->logo = $configsLogo[0]['new_file'];
            $newVendido->logo_slug = trim(str_replace(' ', '_', $creador));
            $newVendido->fecha_subido = date('Y-m-d H:i:s');
            $newVendido->alt = $alt;
            $newVendido->url_imagen = $link;
            $newVendido->directorio = $directorio;
            $newVendido->creador = $creador;
            $newVendido->estatus = 1;

            //print_r($newCreador);
            //exit();

            $this->db->select('MAX(id_orden) AS max_orden')
                ->from('MasVendidos')
                ->where('estatus', 1);
            $contar_fotos = $this->db->get()->row();

            if(isset($contar_fotos->max_orden)) {
                if($contar_fotos->max_orden == 0) {
                    $newVendido->id_orden = 1;
                } else {
                    $newVendido->id_orden = (int)$contar_fotos->max_orden + 1;
                }
            } else {
                $newVendido->id_orden = 1;
            }
            $this->db->select('*')
                ->from('MasVendidos')
                ->where('estatus', 0);
            $inactivos = $this->db->get()->result();

            $this->db->insert('MasVendidos', $newVendido);

            foreach($inactivos as $posicion => $masvendidos ) {
                $this->db->query("UPDATE MasVendidos SET id_orden=".($masvendidos->id_orden+1)." WHERE id_mas_vendido=".$masvendidos->id_mas_vendido);
            }
        }
        redirect('administracion/masvendidos');
    }
    public function reordenar_vendidos(){
        if(!$this->input->post('data')) {
            return false;
        } else {
            foreach($this->input->post('data') as $posicion => $id_mas_vendido) {
                $this->db->query("UPDATE MasVendidos SET id_orden=".($posicion+1)." WHERE id_mas_vendido=".$id_mas_vendido);
            }
        }
    }

    public function editar(){
        $nombre_imagen = $this->input->post('nombre_imagen');
        $nombre_creador = $this->input->post('nombre_creador');
        $alt = $this->input->post('alt_creador');
        $link = $this->input->post('link_creador');
        $id_mas_vendido = $this->input->post('id_mas_vendido');

        $vendido = new stdClass();
        $vendido->nombre_imagen = $nombre_imagen;
        $vendido->creador = $nombre_creador;
        $vendido->alt = $alt;
        $vendido->url_imagen = $link;

        $directorio_pre = 'assets/nimages/mas_vendidos';
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

            $vendido->nombre_imagen_slug = trim(str_replace(' ', '_', $nombre_imagen));
            $vendido->imagen_original = $data['file_name'];
            $vendido->imagen_large = $configs[0]['new_file'];
            $vendido->imagen_medium = $configs[1]['new_file'];
            $vendido->imagen_small = $configs[2]['new_file'];


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
            $vendido->logo = $configsLogo[0]['new_file'];
            $vendido->logo_slug = trim(str_replace(' ', '_', $nombre_creador));

        }

        $this->db->where("id_mas_vendido", $id_mas_vendido);
        $this->db->update("MasVendidos", $vendido);
        redirect('administracion/masvendidos');

    }

    public function borrar(){
        $id_mas_vendido = $this->input->post('id_mas_vendido');

        $vendido = new stdClass();
        $vendido->estatus = 33;

        $this->db->where("id_mas_vendido", $id_mas_vendido);
        $this->db->update("MasVendidos", $vendido);
        redirect('administracion/masvendidos');
    }

    public function cambiar_estatus(){
        $id_mas_vendido = $this->input->post('id_mas_vendido');
        $estatus = $this->input->post('estatus');

        $vendido = new stdClass();
        $vendido->estatus = $estatus;

        $this->db->where("id_mas_vendido", $id_mas_vendido);
        $this->db->update("MasVendidos", $vendido);
    }
}