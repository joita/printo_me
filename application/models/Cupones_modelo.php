<?php
	
class Cupones_modelo extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}

	public function obtener_cupones_admin() {
	    $this->db->select("Cupones.*, Tiendas.nombre_tienda")
            ->from("Cupones")
            ->join("Tiendas", "Cupones.id_cliente = Tiendas.id_cliente", "left")
            ->where("estatus != 33")
            ->where("tipo != 5")
		    ->order_by('nombre', 'ASC');
		return $this->db->get()->result();
	}
	
	public function obtener_cupones_activas() {
		$this->db->order_by('nombre', 'ASC');
		$marcas_res = $this->db->get_where('Cupones', array('estatus' => 1));
		return $marcas_res->result();
	}

	public function crear_cupon($nombre, $id_cliente) {

		$cupones = $this->db->get_where('Cupones', array('id_cliente' => $id_cliente));

		if ($cupones->num_rows() > 0) {
			return $cupones->row()->cupon;
		}

		$nombres = explode( " ", $nombre);
		$cupon_str = "";

		foreach ($nombres as $str) {
			$cupon_str .= $str[0];
		}
		$cupon_str .= str_pad($id_cliente, 3, "0", STR_PAD_LEFT);

		$cupon = new stdClass();
		$cupon->nombre = $nombre;
		$cupon->cupon= strtoupper($cupon_str);
		$cupon->descuento= 0.10;
		$cupon->cantidad= 0;
		$cupon->expira= NULL;
		$cupon->tipo = 1;
		$cupon->id_cliente = $id_cliente;
		$cupon->estatus = 1;
		
		$this->db->insert('Cupones', $cupon);

		return $cupon->cupon ;
	}

	public function crear_referencia($id_cliente){
	    $cliente = $this->db->get_where('Clientes', array('id_cliente' => $id_cliente))->row();
        $nombres = explode(" ", $cliente->nombres);
        $primer_nom = trim($nombres[0]);
        $clave = substr(trim(md5(uniqid(rand(), true))), 0, 6);

	    $cupon = new stdClass();
        $cupon->nombre = 'Referencia-'.$cliente->id_cliente;
        $cupon->cupon= strtoupper($primer_nom."-".$clave);
        $cupon->descuento= 0.10;
        $cupon->cantidad= 0;
        $cupon->expira= NULL;
        $cupon->tipo = 5;
        $cupon->id_cliente = $id_cliente;
        $cupon->estatus = 1;

        $this->db->insert('Cupones', $cupon);
        $id_cupon = $this->db->insert_id();
	    return $id_cupon;
    }

    public function obtener_usuario_de_enhance($id_enhance){
	    $this->db->select('id_cliente')
            ->from('Enhance')
            ->where('id_enhance', $id_enhance);
	    $result = $this->db->get()->row();
	    return $result;
    }

    public function obtener_nombre_tienda($id_cliente){
        $this->db->select('nombre_tienda')
            ->from('Tiendas')
            ->where('id_cliente', $id_cliente);
        $result = $this->db->get()->row();
        return $result;
    }

    public function promocion_cm($id_cliente){
        $dotenv = new Dotenv\Dotenv(BASEPATH.'/../');
        $dotenv->load();
        $sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
        $cliente = $this->db->get_where('Clientes', array('id_cliente' => $id_cliente))->row();
        $clave = substr(trim(md5(uniqid(rand(), true))), 0, 6);

        $cupon = new stdClass();
        $cupon->nombre = 'CMONDAY-'.$cliente->id_cliente;
        $cupon->cupon= strtoupper("CM".$clave);
        $cupon->descuento = 0.00;
        $cupon->cantidad = 1;
        $cupon->expira = "2024-11-05 00:00:00";
        $cupon->tipo = 4;
        $cupon->id_cliente = NULL;
        $cupon->estatus = 1;

        $this->db->insert('Cupones', $cupon);
        $id_cupon = $this->db->insert_id();
        $cupon->id_cupon = $id_cupon;

        $datos_correo['cupon'] = $cupon->cupon;
        $datos_correo['nombre'] = $cliente->nombres;

        $email_compra = new SendGrid\Email();
        $email_compra->addTo($cliente->email, $cliente->nombres)
            ->setFrom('administracion@printome.mx')
            ->setReplyTo('administracion@printome.mx')
            ->setFromName('printome.mx')
            ->setSubject('Cupón Promoción Cyber Monday | printome.mx')
            ->setHtml($this->load->view('plantillas_correos/nuevas/promo_cybermonday', $datos_correo, TRUE));
        $sendgrid->send($email_compra);
    }
}