<?php


class Eliminar extends MY_Admin
{
    public function index() {

        $datos_header['seccion_activa'] = 'eliminar';
        $footer_datos['scripts'] = 'administracion/eliminar/scripts';

        $this->load->view('administracion/header', $datos_header);
        $this->load->view('administracion/eliminar/index');
        $this->load->view('administracion/footer', $footer_datos);
    }

    public function eliminar_cuenta(){
        $id_cliente = $this->input->post("id_cliente");
        $email_cliente = $this->input->post("cuenta_a");
        $respuesta = new stdClass();

        if($id_cliente != '341') {
            $mensaje = 'empezando con la eliminación del usuario.';
            try {
                $this->db->trans_start();
                $mensaje = 'eliminando datos del deposito del cliente.';
                //eliminado de datos de deposito
                $this->db->where('id_cliente', $id_cliente);
                $this->db->delete('DatosDepositoPorCliente');

                if ($this->db->trans_status() === FALSE) {
                    $respuesta->tipo = "error";
                    $respuesta->mensaje = $mensaje;
                    echo json_encode($respuesta);
                    return false;
                }

                $mensaje = 'eliminando el cupon del cliente.';
                //eliminado del cupon del cliente
                $update_cupon = new stdClass();
                $update_cupon->estatus = 33;
                $this->db->where('id_cliente', $id_cliente);
                $this->db->update('Cupones', $update_cupon);

                if ($this->db->trans_status() === FALSE) {
                    $respuesta->tipo = "error";
                    $respuesta->mensaje = $mensaje;
                    echo json_encode($respuesta);
                    return false;
                }

                $mensaje = 'empezando a eliminar las campañas del cliente.';
                //eliminado de campañas del cliente
                $this->db->select('id_enhance, front_image, back_image, right_image, left_image')
                    ->from('Enhance')
                    ->where('id_cliente', $id_cliente);
                $campanas = $this->db->get()->result();

                if ($this->db->trans_status() === FALSE) {
                    $respuesta->tipo = "error";
                    $respuesta->mensaje = $mensaje;
                    echo json_encode($respuesta);
                    return false;
                }

                if (sizeof($campanas) > 0) {
                    $mensaje = 'eliminando imagenes de las campañas del cliente.';
                    foreach ($campanas as $campana) {
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
                    }
                    $mensaje = 'eliminando enhances de la base de datos.';
                    foreach ($campanas as $campana) {
                        $this->db->delete('Enhance', array('id_enhance' => $campana->id_enhance));
                    }
                }

                if ($this->db->trans_status() === FALSE) {
                    $respuesta->tipo = "error";
                    $respuesta->mensaje = $mensaje;
                    echo json_encode($respuesta);
                    return false;
                }

                $mensaje = 'eliminando tienda del cliente.';
                //eliminado de tienda del cliente
                $this->db->where('id_cliente', $id_cliente);
                $this->db->delete('Tiendas');

                if ($this->db->trans_status() === FALSE) {
                    $respuesta->tipo = "error";
                    $respuesta->mensaje = $mensaje;
                    echo json_encode($respuesta);
                    return false;
                }

                $mensaje = 'cambiando estatus del usuario.';
                //bloqueo final de usuario
                $cuenta_eliminada = $email_cliente . '_eliminado';
                $update_cliente = new stdClass();
                $update_cliente->estatus_cliente = 33;
                $update_cliente->email = $cuenta_eliminada;
                $this->db->where('id_cliente', $id_cliente);
                $this->db->update('Clientes', $update_cliente);
                $this->db->trans_complete();

                if ($this->db->trans_status()) {
                    $respuesta->tipo = "exito";
                    $respuesta->mensaje = "Se eliminó toda la información del usuario exitosamente.";
                    echo json_encode($respuesta);
                }else{
                    $respuesta->tipo = "error";
                    $respuesta->mensaje = $mensaje;
                    echo json_encode($respuesta);
                }

            } catch (Exception $exception) {
                $respuesta->tipo = "error";
                $respuesta->mensaje = "Error " . $mensaje;
                echo json_encode($respuesta);
            }catch (DBException $exception){

            }
        }else{
            $respuesta->tipo = "error";
            $respuesta->mensaje = "Error gotito se niega a ser eliminado.";
            echo json_encode($respuesta);
        }


    }
}