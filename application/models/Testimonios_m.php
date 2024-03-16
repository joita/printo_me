<?php

class Testimonios_m extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

    public function obtener_rating_promedio()
    {
        $this->db->select('IFNULL(AVG(monto_calificacion), 0) AS rating_promedio, COUNT(id_calificacion) AS numero_ratings')
                 ->from('CalificacionesPrintome')
                 ->where('estatus', 1);

        $rating = $this->db->get()->row();

        return $rating;
    }

    public function obtener_testimonio_respuestas($id_testimonio){
        $this->db->select('CalificacionesPrintome.*,
							(SELECT COUNT(RespuestasCalificaciones.id_respuesta) FROM RespuestasCalificaciones
							WHERE RespuestasCalificaciones.id_calificacion=CalificacionesPrintome.id_calificacion
							) AS cantidad_respuestas')
            ->from('CalificacionesPrintome')
            ->where('CalificacionesPrintome.id_calificacion', $id_testimonio);

        $testimonio = $this->db->get()->result();

        $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $testimonio[0]->email ) ) ) . "?d=https://printome.mx/assets/nimages/blankuser.png &s=" . 30;
        $testimonio[0]->url_avatar = $grav_url;

        if($testimonio[0]->cantidad_respuestas > 0) {
            $this->db->select('*')
                ->from('RespuestasCalificaciones')
                ->where('id_calificacion', $testimonio[0]->id_calificacion)
                ->order_by('orden', 'ASC');

            $testimonio[0]->respuestas = $this->db->get()->result();
        }
        return $testimonio;
    }

    public function obtener_testimonio_respuestas_encrip($id_testimonio_encrip){
        $this->db->select('CalificacionesPrintome.*,
							(SELECT COUNT(RespuestasCalificaciones.id_respuesta) FROM RespuestasCalificaciones
							WHERE RespuestasCalificaciones.id_calificacion=CalificacionesPrintome.id_calificacion
							) AS cantidad_respuestas')
            ->from('CalificacionesPrintome')
            ->where('md5(CalificacionesPrintome.id_calificacion)', $id_testimonio_encrip);

        $testimonio = $this->db->get()->result();

        $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $testimonio[0]->email ) ) ) . "?d=https://printome.mx/assets/nimages/blankuser.png &s=" . 30;
        $testimonio[0]->url_avatar = $grav_url;

        if($testimonio[0]->cantidad_respuestas > 0) {
            $this->db->select('*')
                ->from('RespuestasCalificaciones')
                ->where('id_calificacion', $testimonio[0]->id_calificacion)
                ->order_by('orden', 'ASC');

            $testimonio[0]->respuestas = $this->db->get()->result();
        }
        return $testimonio;
    }

    public function verificar_email_con_testimonio($email_encrip, $id_encrip){
	    $this->db->select('*')
            ->from('CalificacionesPrintome')
            ->where('md5(email)', $email_encrip)
            ->where('md5(id_calificacion)', $id_encrip);

	    $resultado = $this->db->get()->result();
	    if(sizeof($resultado) > 0){
	        return true;
        }else{
	        return false;
        }
    }

    public function obtener_testimonios_con_respuestas($start, $offset){
        $this->db->select('CalificacionesPrintome.*,
							(SELECT COUNT(RespuestasCalificaciones.id_respuesta) FROM RespuestasCalificaciones
							WHERE RespuestasCalificaciones.id_calificacion=CalificacionesPrintome.id_calificacion
							) AS cantidad_respuestas')
                    ->from('CalificacionesPrintome')
                    ->where('estatus', 1)
                    ->order_by('id_calificacion', 'DESC');
        if($start < 0 || $offset < 0) {
            $this->db->limit(1);
        } else {
            if($start == 1) {
                $start = 0;
            }
            $this->db->limit($offset, $start);
        }

        $testimonios = $this->db->get()->result();

        foreach($testimonios as $indice_testimonios => $testimonio){

            $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $testimonio->email ) ) ) . "?d=https://printomedev.verticalknits.com//assets/nimages/nuevo_diseno/img/user-image.png &s=" . 30;
            $testimonio->url_avatar = $grav_url;

            if($testimonio->cantidad_respuestas > 0){
                $this->db->select('*')
                    ->from('RespuestasCalificaciones')
                    ->where('id_calificacion', $testimonio->id_calificacion)
                    ->order_by('orden', 'ASC');

                $testimonios[$indice_testimonios]->respuestas = $this->db->get()->result();
            }
        }
        return $testimonios;
    }

    public function obtener_testimonios()
    {
        $this->db->select('*')
                 ->from('CalificacionesPrintome')
                 ->where('estatus', 1)
                 ->order_by('id_calificacion', 'DESC');

        $testimonios = $this->db->get()->result();

        if(sizeof($testimonios)) {
            return $testimonios;
        } else {
            return array();
        }
    }

    public function obtener_testimonios_random($seed, $cantidad = 7, $calificacion = null)
    {
        $this->db->select('*')
                 ->from('CalificacionesPrintome')
                 ->where('estatus', 1)
                 ->where('id_calificacion >= 27');

        if($calificacion) {
            $this->db->where('monto_calificacion', $calificacion);
        }

        $this->db->order_by('RAND('.$seed.')')
                 ->limit($cantidad);

        $testimonios_random = $this->db->get()->result();

        if(sizeof($testimonios_random)) {
            return $testimonios_random;
        } else {
            return array();
        }
    }

    public function obtener_testimonios_admin()
    {
        $this->db->select('*')
                 ->from('CalificacionesPrintome')
                 ->where('estatus != ', 33)
                 ->order_by('id_calificacion', 'DESC');

        $testimonios = $this->db->get()->result();

        if(sizeof($testimonios)) {
            return $testimonios;
        } else {
            return array();
        }
    }

    public function contar_testimonios(){
        $this->db->select('COUNT(*) AS numero_testimonios')
            ->from('CalificacionesPrintome')
            ->where('estatus', 1);
        return $this->db->get()->result();
    }

}
