<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends MY_Controller {

	public function iniciar_sesion() {

		$email = $this->input->post('email_cliente');
		$password = $this->input->post('password_cliente');

		if(!isset($email) || !isset($password)) {
			$datos['estatus'] = 'error';
			$datos['mensaje'] = 'No ha llenado todos los campos necesarios.';
		} else {

			$cliente_res = $this->db->get_where('Clientes', array('email' => $email));
			$cliente = $cliente_res->result();

			if(isset($cliente[0]) && $cliente[0]->estatus_cliente != 33) {
				if($password == $this->encryption->decrypt($cliente[0]->password)) {

					if($cliente[0]->token_activacion_correo == 'activado') {
						$datos['estatus'] = 'verificado';
						$datos['mensaje'] = 'Iniciando sesión.';

						$usuario['login'] = array(
							'id_cliente' => $cliente[0]->id_cliente,
							'nombre' => $cliente[0]->nombres,
							'apellidos' => $cliente[0]->apellidos,
							'email' => $cliente[0]->email,
							'telefono' => $cliente[0]->telefono,
							'logged_in' => TRUE,
							'facebook' => FALSE
						);

						$this->cart_modelo->mezclar_carrito($cliente[0]->id_cliente);

						$this->session->set_userdata($usuario);
						if($this->session->has_userdata('correo_temporal')) {
							$this->cart_modelo->borrar_carrito_invitado($this->session->correo_temporal);
							$this->session->unset_userdata('correo_temporal');
						}
						$this->session->unset_userdata('direccion_temporal');
						$this->session->unset_userdata('direccion_fiscal_temporal');
					} else {
						$datos['estatus'] = 'error';
						$datos['mensaje'] = 'Esta cuenta no ha sido verificada, por favor revisa tu correo electrónico para el correo de activación.';
					}

				} else {
					$datos['estatus'] = 'error';
					$datos['mensaje'] = 'El usuario o la contraseña proporcionados son inválidos.';
				}
			} else {
				$datos['estatus'] = 'error';
				$datos['mensaje'] = 'El usuario no existe, por favor regístrate.';
			}
		}

		echo json_encode($datos);
	}

	public function registrar() {
		$nombre						= $this->input->post('nombre');
		$apellido					= $this->input->post('apellido');
		$email						= $this->input->post('email');
		$telefono					= $this->input->post('telefono');
		$cumple						= $this->input->post('cumple');
		$genero						= $this->input->post('genero');
		$contrasena					= $this->input->post('contrasena');
		$contrasena_repetir			= $this->input->post('contrasena_repetir');

		if(!isset($nombre) || !isset($apellido)|| !isset($email) || !isset($cumple) || !isset($contrasena) || !isset($contrasena_repetir) || !isset($genero) || !isset($telefono)) {
			$datos['estatus'] = 'error';
			$datos['mensaje'] = 'No ha llenado todos los campos necesarios.';
		} else {


			$cliente_res = $this->db->get_where('Clientes', array('email' => $email));
			$cliente = $cliente_res->result();
			$compro_pero_no_se_registro = array();
			$hay_client = false;

			if (count($cliente) > 0) {
				foreach ($cliente as $unico) {
					$compro_pero_no_se_registro[] = ($unico->password != "NO-SOY-CLIENTE");
				}

				foreach ($compro_pero_no_se_registro as $compro) {
					if($compro) $hay_client = true;
				}
			}


			if($hay_client ) {
				$datos['estatus'] = 'error';
				$datos['mensaje'] = 'Ya existe una cuenta con este correo electrónico.';
			} else {

				if($contrasena == $contrasena_repetir && valid_email($email)) {
					$datos['estatus'] = 'verificado';
					$datos['mensaje'] = 'Registrando...';

					$usuario = array();
					$usuario['nombres'] = $nombre;
					$usuario['apellidos'] = $apellido;
					$usuario['email'] = $email;
					$usuario['telefono'] = $telefono;
					$usuario['password'] = $this->encryption->encrypt($contrasena);
					$usuario['fecha_registro'] = date('Y-m-d H:i:s');
					$usuario['token_activacion_correo'] = 'activado';
					$usuario['fecha_nacimiento'] = $cumple;
					$usuario['genero'] = $genero;

					if (count($cliente) > 0) {
						$this->db->where('id_cliente', $cliente[0]->id_cliente);
						$this->db->update('Clientes', $usuario);
						$id_cliente = $cliente[0]->id_cliente;
					}else{
						$this->db->insert('Clientes', $usuario);
						$id_cliente = $this->db->insert_id();
						$this->referencias_modelo->generar_codigo($id_cliente);
					}

                    if($usuario['genero'] == 'M') {
                        $opcion = 'Masculino';
                    } else if($usuario['genero'] == 'F') {
                        $opcion = 'Femenino';
                    } else if($usuario['genero'] == 'X') {
                        $opcion = 'Prefiero no decir';
                    } else {
                        $opcion = '';
                    }

					$contact = array(
						"email"              => $usuario['email'],
						"first_name"         => $usuario['nombres'],
						"last_name"          => $usuario['apellidos'],
						"phone"          	 => $usuario['telefono'],
						"p[16]"               => "16",
						"status[16]"          => 1,
						"tags"				 => "registro, bienvenida-pendiente",
                        "field[2,0]"         => $usuario['fecha_nacimiento'],
                        "field[3,0]"         => $opcion,
                        "field[4,0]"         => $contrasena
					);
					$contact_sync = $this->ac->api("contact/sync", $contact);

					$usuario['login'] = array(
						'id_cliente' => $id_cliente,
						'nombre' => $usuario['nombres'],
						'apellidos' => $usuario['apellidos'],
						'email' => $usuario['email'],
						'telefono' => $usuario['telefono'],
						'logged_in' => TRUE,
						'facebook' => FALSE
					);

					$tienda = new stdClass();
					$tienda->nombre_tienda = 'Tienda de '.$usuario['nombres'];
					$tienda->nombre_tienda_slug = uniqid($id_cliente, true);
					$tienda->descripcion_tienda = 'Esta es la tienda de '.$usuario['nombres'];
					$tienda->id_cliente = $id_cliente;

					$this->db->insert('Tiendas', $tienda);

					$this->cart_modelo->mezclar_carrito($id_cliente);

					$this->session->set_userdata($usuario);
					if($this->session->has_userdata('correo_temporal')) {
						$this->cart_modelo->borrar_carrito_invitado($this->session->correo_temporal);
						$this->session->unset_userdata('correo_temporal');
					}
					$this->session->unset_userdata('direccion_temporal');
					$this->session->unset_userdata('direccion_fiscal_temporal');

					$datos['estatus'] = 'verificado';
					$datos['mensaje'] = '¡Gracias por registrarte! Vamos a iniciar sesión de manera automática. Mientras, te enviamos un correo de verificación para confirmar tu cuenta de correo.';


				} else {
					$datos['estatus'] = 'error';
					$datos['mensaje'] = 'Tus contraseñas no coinciden.';
				}
			}
		}

		echo json_encode($datos);
	}

	/*
	 * activar cuenta nueva
	 */
	public function verificar_cuenta($codigo) {

		$cliente_res = $this->db->get_where('Clientes', array('token_activacion_correo' => $codigo));
		$cliente = $cliente_res->result();

		if(!is_null($cliente[0])) {
			$cliente_activo = new stdClass();
			$cliente_activo->token_activacion_correo = 'activado';

			$this->db->where('id_cliente', $cliente[0]->id_cliente);
			$this->db->update('Clientes', $cliente_activo);

			$usuario['login'] = array(
				'id_cliente' => $cliente[0]->id_cliente,
				'nombre' => $cliente[0]->nombres,
				'apellidos' => $cliente[0]->apellidos,
				'email' => $cliente[0]->email,
				'telefono' => $cliente[0]->telefono,
				'facebook' => FALSE,
				'logged_in' => TRUE
			);

			$this->session->set_userdata($usuario);
			$this->session->unset_userdata('direccion_temporal');
			$this->session->unset_userdata('direccion_fiscal_temporal');

			$datos_correo = new stdClass();
			$datos_correo->nombre = $cliente[0]->nombres.' '.$cliente[0]->apellidos;
			$datos_correo->email = $cliente[0]->email;

			// Se inicializa Sendgrid
			$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
			$email = new SendGrid\Email();
			$email->addTo($datos_correo->email, $datos_correo->nombre)
				  ->setFrom('administracion@printome.mx')
				  ->setReplyTo('administracion@printome.mx')
				  ->setFromName('printome.mx')
				  ->setSubject('¡Te damos la bienvenida a printome.mx!')
				  ->setHtml($this->load->view('plantillas_correos/bienvenida_printome', $datos_correo, TRUE))
			;
			$sendgrid->send($email);

			redirect(base_url());
		} else {
			echo '<h1>Vínculo inválido.</h1><script>setTimeout(function() { window.location.href = "'.base_url().'"; }, 1000);</script>';
		}
	}

	/*
	 * enviar correo de recuperacion
	 */
	public function enviar_recuperacion() {

		$email = $this->input->post('email_cliente_forgot');

		$cliente_res = $this->db->get_where('Clientes', array('email' => $email));
		$cliente = $cliente_res->result();

		if(!is_null($cliente[0])) {

			if($cliente[0]->password == 'facebook-login') {
				$datos['estatus'] = 'error';
				$datos['mensaje'] = 'Este correo está registrado a través de Facebook, por favor inicia sesión usando Facebook.';
			} else {

				// Se envía correo de reseteo
				$datos_correo = new stdClass();
				$datos_correo->nombre = $cliente[0]->nombres.' '.$cliente[0]->apellidos;
				$datos_correo->email = $cliente[0]->email;
				$datos_correo->codigo_activacion = md5($cliente[0]->email.$cliente[0]->fecha_registro);

				// Se inicializa Sendgrid
				$sendgrid = new SendGrid($_ENV['SENDGRID_KEY']);
				$email = new SendGrid\Email();
				$email->addTo($datos_correo->email, $datos_correo->nombre)
					  ->setFrom('administracion@printome.mx')
					  ->setReplyTo('administracion@printome.mx')
					  ->setFromName('printome.mx')
					  ->setSubject('Restablecer contraseña | printome.mx')
					  ->setHtml($this->load->view('plantillas_correos/restablecer_contrasena', $datos_correo, TRUE))
				;
				$sendgrid->send($email);

				$datos['estatus'] = 'verificado';
				$datos['mensaje'] = 'Te hemos enviado un correo con instrucciones para restablecer tu contraseña.';
			}

		} else {
			$datos['estatus'] = 'error';
			$datos['mensaje'] = 'No tenemos registro de este correo electrónico. Puedes <a href="#" data-open="register">registrarte aquí</a>.';
		}

		echo json_encode($datos);
	}

	/*
	 * pantalla de cambiar contrasena
	 */
	public function restablecer_contrasena($codigo_recuperacion)
	{
		// Config
		$datos_header['seccion_activa'] = '';
		$datos_header['meta']['title'] = 'Restablecer contraseña | printome.mx';
		$datos_header['meta']['description'] = 'Diseña tu playera on-line | printome.mx';
		$datos_header['meta']['imagen'] = '';

		$this->db->select('*');
		$this->db->from('Clientes');
		$this->db->where('MD5(CONCAT(email, fecha_registro)) =', $codigo_recuperacion);

		$cliente_res = $this->db->get();
		$cliente = $cliente_res->result();

		$this->load->view('header', $datos_header);
		if(isset($cliente[0])) {
			$this->load->view('registro/restablecer_contrasena');
		} else {
			$this->load->view('registro/restablecer_contrasena_codigo_incorrecto');
		}
		$this->load->view('footer');
	}

	public function restablecer_contrasena_procesar($codigo_recuperacion)
	{
		if($this->input->post('contrasena_nueva') != $this->input->post('repetir_contrasena_nueva')) {
			$this->session->set_flashdata('error_datos', 'datos');
			redirect('restablecer-contrasena/'.$codigo_recuperacion);
		} else {
			$this->db->select('*');
			$this->db->from('Clientes');
			$this->db->where('MD5(CONCAT(email, fecha_registro)) =', $codigo_recuperacion);

			$cliente_res = $this->db->get();
			$cliente = $cliente_res->result();

			$nueva_info = new stdClass();
			$nueva_info->password = $this->encryption->encrypt($this->input->post('contrasena_nueva'));

			$this->db->where('id_cliente', $cliente[0]->id_cliente);
			$this->db->update('Clientes', $nueva_info);

            $contact = array(
                "email"              => $usuario['email'],
                "field[4,0]"         => $this->input->post('contrasena_nueva')
            );
            $contact_sync = $this->ac->api("contact/sync", $contact);

			$this->session->set_flashdata('update_datos', 'ok');
			$this->session->set_flashdata('ocultar_form', 'ok');
			redirect('restablecer-contrasena/'.$codigo_recuperacion);
		}
	}

	public function cerrar_sesion()
	{
		$this->session->unset_userdata('login');
		$this->session->unset_userdata('direccion_temporal');
        $this->session->unset_userdata('id_direccion_pedido');
		$this->session->unset_userdata('direccion_fiscal_temporal');
		$this->session->unset_userdata('descuento_global');
        $this->session->unset_userdata('envio_gratis');
		$this->facebook->destroy_session();
		$this->cart->destroy();
		redirect(base_url());
	}

	public function cerrar_sesion_ajax()
	{
		$this->session->unset_userdata('login');
		$this->session->unset_userdata('direccion_temporal');
		$this->session->unset_userdata('direccion_fiscal_temporal');
		$this->session->unset_userdata('descuento_global');
        $this->session->unset_userdata('envio_gratis');
        $this->session->unset_userdata('id_direccion_pedido');
		$this->facebook->destroy_session();
		$this->cart->destroy();

		return true;
	}

	public function limpiar_sesion()
	{
		$this->session->unset_userdata('limpiar_sesion');
	}

	public function facebook()
	{
		$facebook_id = $this->input->post('id');
		$cliente_res = $this->db->get_where('Clientes', array('facebook_id' => $facebook_id));
		$cliente = $cliente_res->row();

		if (is_null($cliente)) {
			$cliente                          = new stdClass;
			$cliente->facebook_id             = $this->input->post('id');;
			$cliente->nombres                 = $this->input->post('first_name');
			$cliente->apellidos               = $this->input->post('last_name');
			$cliente->email                   = $this->input->post('email');
			$cliente->genero                  = ($this->input->post('gender') == "male" ? "M" : ($this->input->post('gender') == "female" ? "F" : "X"));
			$cliente->token_activacion_correo = "activado";
			$cliente->password                = "facebook-login";
			$cliente->fecha_registro          = date('Y-m-d H:i:s');
			if($this->input->post('birthday')) {
				$cliente->fecha_nacimiento        = date('Y-m-d H:i:s', strtotime($this->input->post('birthday')));
			}
			$this->db->insert('Clientes', $cliente);
			$cliente->id_cliente = $this->db->insert_id();
            $this->referencias_modelo->generar_codigo($cliente->id_cliente);

			$tienda = new stdClass();
			$tienda->nombre_tienda = 'Tienda de '.$cliente->nombres;
			$tienda->nombre_tienda_slug = uniqid($cliente->id_cliente, true);
			$tienda->descripcion_tienda = 'Esta es la tienda de '.$cliente->nombres;
			$tienda->id_cliente = $cliente->id_cliente;

			$this->db->insert('Tiendas', $tienda);

			$contact = array(
				"email"              => $cliente->email,
				"first_name"         => $cliente->nombres,
				"last_name"          => $cliente->apellidos,
				"p[16]"               => "16",
				"status[16]"          => 1,
				"tags"				 => "registro-facebook, bienvenida-pendiente"
			);
			$contact_sync = $this->ac->api("contact/sync", $contact);
		}

		// Falta ActiveCollab
		$usuario['login'] = array(
			'id_cliente' => $cliente->id_cliente,
			'nombre' => $cliente->nombres,
			'apellidos' => $cliente->apellidos,
			'email' => $cliente->email,
            'telefono' => '',
			'facebook' => TRUE,
			'logged_in' => TRUE
		);

		$this->cart_modelo->mezclar_carrito($cliente->id_cliente);

		$this->session->set_userdata($usuario);
		if($this->session->has_userdata('correo_temporal')) {
			$this->cart_modelo->borrar_carrito_invitado($this->session->correo_temporal);
			$this->session->unset_userdata('correo_temporal');
		}
		$this->session->unset_userdata('direccion_temporal');
	}

	public function hey()
	{
		echo $this->encryption->decrypt('b0dc0c2c37542b1d70eba63a0ac6ae76ad8d5225250d6f02a7b5b0c57c6970f894c603cebab91a41ec71d24ca77468acc134148a1cfaada6709d6b502473f2c2n2wIIGLw5R6BSXaFKIq+v6RQMSZLadKVLu09AUtQKcw=');
	}

	public function fbauth() {




		/* $data['user'] = array();
		// Check if user is logged in
		if ($this->facebook->is_authenticated()) {
			// User logged in, get user details
			$user = $this->facebook->request('get', '/me?fields=id,name,email,birthday,first_name,last_name,gender');
			if (!isset($user['error'])) {

				$cliente_res = $this->db->get_where('Clientes', array('facebook_id' => $user['id']));
				$client = $cliente_res->row();

				if (is_null($client)) {
					$client                          = new stdClass;
					$client->facebook_id             = $user['id'];
					$client->nombres                 = $user['first_name'];
					$client->apellidos               = $user['last_name'];
					$client->email                   = $user['email'];
					$client->genero                  = ($user['gender'] == "male" ? "M" : ($user['gender'] == "female" ? "F" : "X"));
					$client->token_activacion_correo = "activado";
					$client->password                = "facebook-login";
					$client->fecha_registro          = date('Y-m-d H:i:s');
					$client->fecha_nacimiento        = date('Y-m-d H:i:s', strtotime($user['birthday']));

					$this->db->insert('Clientes', $client);

					$client->id_cliente = $this->db->insert_id();

					$contact = array(
						"email"      => $client->email,
						"first_name" => $client->nombres,
						"last_name"  => $client->apellidos,
						"p[2]"       => "2",
						"status[2]"  => 1 // "Active" status
					);

					$contact_sync = $this->ac->api("contact/sync", $contact);
				}

				$usuario['login'] = array(
					'id_cliente' => $client->id_cliente,
					'nombre' => $client->nombres,
					'apellidos' => $client->apellidos,
					'email' => $client->email,
					'logged_in' => TRUE
				);

				$this->cart_modelo->mezclar_carrito($client->id_cliente);

				$this->session->set_userdata($usuario);

				redirect('/', 'refresh');
			} else {
				//manejar error de login con facebook
				$this->facebook->destroy_session();
				redirect('/','refresh');
			}
		} else {
			//manejar error de login con facebook
			$this->facebook->destroy_session();
			redirect('/','refresh');
		} */
	}

	private function crear_tiendas_para_todos()
	{
		$clientes = $this->db->get('Clientes')->result();

		foreach($clientes as $cliente) {
			$id_cliente = $cliente->id_cliente;

			$tienda = $this->db->get_where('Tiendas', array('id_cliente' => $id_cliente))->row();

			if(!isset($tienda->id_tienda)) {
				$tienda = new stdClass();
				$tienda->nombre_tienda = 'Tienda de '.$cliente->nombres;
				$tienda->nombre_tienda_slug = uniqid($id_cliente, true);
				$tienda->descripcion_tienda = 'Esta es la tienda de '.$cliente->nombres;
				$tienda->id_cliente = $id_cliente;

				$this->db->insert('Tiendas', $tienda);
			}
		}
	}

    public function verificar_telefono_twilio(){
        $tel = $this->input->get("num_tel");
        $response = new stdClass();
        try {
            $twilio = new Twilio\Rest\Client($_ENV['TWILIO_SID'], $_ENV['TWILIO_TOKEN']);
            $phone_number = $twilio->lookups->v1->phoneNumbers($tel)->fetch(array("type" => "carrier"));
            if(isset($phone_number->carrier['type']) && isset($phone_number->carrier['name'])){
                $response->estatus = true;
                $response->type = $phone_number->carrier['type'];
                $response->name = $phone_number->carrier['name'];
            }
        } catch (Exception $e) {
            $response->estatus = false;
            $response->message = $e->getMessage();
        }
        echo json_encode($response);
    }

    public function verificar_dos_telefonos_twilio(){
        $tel = $this->input->get("num_tel");
        $fac_tel = $this->input->get("fac_tel");
        $response = new stdClass();
        $response->tel = new stdClass();
        $response->fac = new stdClass();
        try {
            $twilio = new Twilio\Rest\Client($_ENV['TWILIO_SID'], $_ENV['TWILIO_TOKEN']);
            $phone_number = $twilio->lookups->v1->phoneNumbers($tel)->fetch(array("type" => "carrier"));
            if(isset($phone_number->carrier['type']) && isset($phone_number->carrier['name'])){
                $response->tel->estatus = true;
                $response->tel->type = $phone_number->carrier['type'];
                $response->tel->name = $phone_number->carrier['name'];
            }
        } catch (Exception $e) {
            $response->tel->estatus = false;
            $response->tel->message = "El teléfono ingresado no es válido.";
        }
        try {
            $twilio = new Twilio\Rest\Client($_ENV['TWILIO_SID'], $_ENV['TWILIO_TOKEN']);
            $phone_number = $twilio->lookups->v1->phoneNumbers($fac_tel)->fetch(array("type" => "carrier"));
            if(isset($phone_number->carrier['type']) && isset($phone_number->carrier['name'])){
                $response->fac->estatus = true;
                $response->fac->type = $phone_number->carrier['type'];
                $response->fac->name = $phone_number->carrier['name'];
            }
        } catch (Exception $e) {
            $response->fac->estatus = false;
            $response->fac->message = "El teléfono ingresado no es válido.";
        }

        echo json_encode($response);
    }
    public function generar_codigo_emergencia($id_cliente){
        $this->referencias_modelo->generar_codigo($id_cliente);
    }
}
