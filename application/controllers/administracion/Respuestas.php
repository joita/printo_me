<?php
/**
 * Created by PhpStorm.
 * User: javier
 * Date: 2018-12-26
 * Time: 11:18
 */

class Respuestas extends MY_Controller
{
    public function index($id_testimonio) {
        $datos_header['seccion_activa'] = 'testimonios';
        $datos['testimonio'] = $this->testimonios_m->obtener_testimonio_respuestas($id_testimonio);
        $datos_footer['scripts'] = 'administracion/testimonios/respuestas/scripts';

        $this->load->view('administracion/header', $datos_header);
        $this->load->view('administracion/testimonios/respuestas/index', $datos);
        $this->load->view('administracion/footer', $datos_footer);
    }

    public function responder(){
        $respuesta = new stdClass();
        $respuesta_recibida = $this->input->post('respuesta');
        $orden_recibido = $this->input->post('orden');
        $id_calificacion = $this->input->post('id_calificacion');
        $nombre = $this->input->post('nombre_usuario');
        $correo = $this->input->post('email_usuario');
        $orden = (int)$orden_recibido;
        $orden++;

        $respuesta->id_respuesta = 'NULL';
        $respuesta->id_calificacion = $id_calificacion;
        $respuesta->respuesta = $respuesta_recibida;
        $respuesta->tipo_usuario = 'admin';
        $respuesta->orden = $orden;
        $respuesta->fecha = date("Y-m-d H:i:s");

        $this->db->insert('RespuestasCalificaciones', $respuesta);

        $fecha = new DateTime();
        $timestamp_actual = $fecha->getTimestamp();

        $datos_correo['respuesta'] = $respuesta_recibida;
        $datos_correo['link'] = site_url("testimonios/responder/".md5($correo)."/".$timestamp_actual."/".md5($id_calificacion));
        $datos_correo['nombre'] = $nombre;

        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        $email = new SendGrid\Email();
        $email->addTo($correo, $nombre)
            ->setFrom('no-reply@printome.mx')
            ->setFromName('Sitio web printome.mx')
            ->setSubject('Printome ha respondido a tu testimonio. | printome.mx')
            ->setHtml($this->load->view('plantillas_correos/nuevas/aviso_respuesta_testimonio', $datos_correo, TRUE))
        ;
        $sendgrid->send($email);

        redirect('administracion/respuestas/'.$id_calificacion);
    }

    public function cambiarcalificacion(){
        $elegido = $this->input->post('elegido');
        $id_calificacion = $this->input->post('id_calificacion');

        $info_nuevo = new stdClass();
        $info_nuevo->monto_calificacion = $elegido;

        $this->db->where('id_calificacion', $id_calificacion);
        $this->db->update('CalificacionesPrintome', $info_nuevo);
        redirect('administracion/respuestas/'.$id_calificacion);
    }
}