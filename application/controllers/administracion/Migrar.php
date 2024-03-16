<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Migrar extends MY_Admin
{

  public function index()
  {
    $this->load->library('migration');

    if ($this->migration->current() === FALSE)
    {
      show_error($this->migration->error_string());
    } else {
      echo 'Migrations ran successfully!';
    } 
  }
  
	public function crear_usuario()
	{
		$usuario = new stdClass();
		//$usuario->nombre = 'Omar';
		//$usuario->usuario = 'omark';
		//$usuario->password = $this->encryption->encrypt('pr1nt0m3');
		//$usuario->fecha_registro = date("Y-m-d H:i:s");
		//$usuario->tipo_usuario = 'admin';
		//$usuario->privilegios = 'categorias,tipos,marcas,productos,cotizador,pedidos,campanas,vectores';
		
		//$usuario->nombre = 'Diseño';
		//$usuario->usuario = 'diseno';
		//$usuario->password = $this->encryption->encrypt('d1$-printo');
		//$usuario->fecha_registro = date("Y-m-d H:i:s");
		//$usuario->tipo_usuario = 'secundario';
		//$usuario->privilegios = 'vectores';
		
		//$usuario->nombre = 'Producción';
		//$usuario->usuario = 'produccion';
		//$usuario->password = $this->encryption->encrypt('Pr0d-printo');
		//$usuario->fecha_registro = date("Y-m-d H:i:s");
		//$usuario->tipo_usuario = 'secundario';
		//$usuario->privilegios = 'pedidos';
		
		//$this->db->insert('Usuarios', $usuario);
	}
}
