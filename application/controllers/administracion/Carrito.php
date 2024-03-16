<?php


class Carrito extends MY_Admin
{
    public function index() {

        $datos_header['seccion_activa'] = 'carrito';
        $footer_datos['scripts'] = 'administracion/carrito/scripts';

        $this->load->view('administracion/header', $datos_header);
        $this->load->view('administracion/carrito/index');
        $this->load->view('administracion/footer', $footer_datos);
    }

    public function transferir_carrito(){
        $cuenta_a = $this->input->post("cuenta_a");
        $cuenta_b = $this->input->post("cuenta_b");
        $cuenta_a_tipo = $this->input->post("cuenta_a_tipo");
        $cuenta_b_tipo = $this->input->post("cuenta_b_tipo");

        $this->db->select("carrito_en_sesion")
            ->from("Clientes")
            ->where("email", $cuenta_a);
        if($cuenta_a_tipo == "Facebook"){
            $this->db->where("facebook_id IS NOT NULL");
        }else{
            $this->db->where("facebook_id IS NULL");
        }
        $carrito_cuenta_a = $this->db->get()->row();

        $respuesta = new stdClass();

        if(!$carrito_cuenta_a->carrito_en_sesion){
            $respuesta->tipo = "error";
            $respuesta->mensaje = "El carrito de la cuenta emisora esta vacio.";
            echo json_encode($respuesta);
        }else{
            $update_b = new stdClass();
            $update_b->carrito_en_sesion = $carrito_cuenta_a->carrito_en_sesion;
            $this->db->where("email", $cuenta_b);
            if($cuenta_b_tipo == "Facebook"){
                $this->db->where("facebook_id IS NOT NULL");
            }else{
                $this->db->where("facebook_id IS NULL");
            }
            $this->db->update("Clientes", $update_b);

            $respuesta->tipo = "exito";
            $respuesta->mensaje = "El carrito se transfirió correctamente.";
            echo json_encode($respuesta);
        }
    }

    public function obtener_correos(){
        $busqueda = $this->input->get('q');
        $this->db->select('id_cliente, nombres, apellidos, email, facebook_id')
            ->from('Clientes')
            ->where('estatus_cliente != 33')
            ->like('email', $busqueda);
        $correos = $this->db->get()->result();
        $respuesta = array();
        foreach ($correos as $indice => $correo){
            $respuesta[$indice] = new stdClass();
            $respuesta[$indice]->title = $correo->email;
            if($correo->facebook_id != NULL){
                $respuesta[$indice]->tipo = "Facebook";
            }else{
                $respuesta[$indice]->tipo = "";
            }
            $respuesta[$indice]->nombre = $correo->nombres." ".$correo->apellidos;
            $respuesta[$indice]->id_cliente = $correo->id_cliente;
        }
        echo json_encode($respuesta);
    }
}