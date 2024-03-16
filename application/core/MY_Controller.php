<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{

	public $bugsnag;
	public $dotenv;
	public $ac;

	public $iva;

    public $generos;

	public function __construct()
	{
		$dotenv = new Dotenv\Dotenv(BASEPATH.'/../');
		$dotenv->load();

		parent::__construct();
		$this->new_session = false;

        $this->bugsnag = Bugsnag\Client::make("8c826e52d51878f2e69f30b2e5688e5d");
        Bugsnag\Handler::register($this->bugsnag);

		//For random seed, to not alter the order of the catalog
		if(!$this->session->has_userdata('catalog_seed')){
			$this->new_session = true;
			$this->session->set_userdata('catalog_seed', microtime() * 1000000);
		}

		$this->ac = new ActiveCampaign($_ENV["ACTIVECAMPAIGN_API_URL"], $_ENV["ACTIVECAMPAIGN_API_KEY"]);

		$this->tienda = $this->tienda_m->obtener_tienda_por_id_dueno($this->session->login['id_cliente']);

        $this->generos = array(
            1 => 'Femenino',
            2 => 'Masculino',
            3 => 'Unisex',
            4 => 'No aplica'
        );

        $this->iva = 0.16;
	}

}

class MY_Admin extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->session->login_admin) {
			redirect('administracion/login');
		}
	}

}
