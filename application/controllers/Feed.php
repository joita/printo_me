<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends MY_Controller {

	public function index() {
		$this->load->view('feed/feed_header');

		$productos['fijo'] = $this->catalogo_modelo->obtener_enhanced('fijo');
		$productos['limitado'] = $this->catalogo_modelo->obtener_enhanced('limitado');

        if(sizeof($productos['fijo']) > 0) {
            foreach($productos['fijo'] as $campana) {
    			$this->load->view('feed/feed_campanas', array('campana' => $campana));
    		}
        }

        if(sizeof($productos['limitado']) > 0) {
    		foreach($productos['limitado'] as $campana) {
    			$this->load->view('feed/feed_campanas', array('campana' => $campana));
    		}
        }

		$this->load->view('feed/feed_footer');
	}

	public function tienda($nombre_tienda_slug)
	{
        $id_cliente = $this->tienda_m->obtener_id_dueno($nombre_tienda_slug);
        $productos = $this->catalogo_modelo->obtener_enhanced(null, 0, 10000, 0, array(), null, $id_cliente);

		$datos_header['tienda'] = $this->tienda_m->obtener_tienda_por_id_dueno($id_cliente);

		$datos_header['meta']['title'] = $datos_header['tienda']->nombre_tienda;
		$datos_header['meta']['description'] = $datos_header['tienda']->descripcion_tienda;
		$datos_header['meta']['url'] = site_url('tienda/'.$nombre_tienda_slug);


		$this->load->view('feed/feed_header', $datos_header);
		//$productos = $this->tienda_m->obtener_productos($this->tienda_m->obtener_id_dueno($nombre_tienda_slug));
		foreach($productos as $campana) {
			$this->load->view('feed/feed_campanas', array('campana' => $campana));
		}
		$this->load->view('feed/feed_footer');
	}

    public function json_feed()
    {
        $productos = $this->catalogo_modelo->obtener_enhanced();

        $json_feed = array();

        foreach($productos as $producto) {
            if($producto->genero == 1) {
                $genero = 'female';
            } else if($producto->genero == 2) {
                $genero = 'male';
            } else if($producto->genero == 3) {
                $genero = 'unisex';
            } else {
                $genero = 'unisex';
            }


            $p = new stdClass();
            $p->id                          = $producto->id_enhance;
            $p->title                       = trim(htmlspecialchars($producto->name));
            $p->description                 = trim(htmlspecialchars($producto->description));
            $p->link                        = site_url($producto->vinculo_producto);
            $p->image_link                  = site_url($producto->front_image);
            $p->brand                       = 'Printome';
            $p->condition                   = 'new';
            $p->availability                = 'in stock';
            $p->gender                      = $genero;
            $p->price                       = $this->cart->format_number($producto->price);
            $p->shipping                    = new stdClass();
            $p->shipping->country           = 'MX';
            $p->shipping->service           = 'DHL Express';
            $p->shipping->price             = '99.00 MXN';
            $p->google_product_category     = 'Apparel &amp; Accessories &gt; Clothing &gt; Shirts &amp; Tops';

            array_push($json_feed, $p);
        }
        $json_feed = json_encode($json_feed);

        header('Content-Type: application/json');
        echo $json_feed;
    }

}
