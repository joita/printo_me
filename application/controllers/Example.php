<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Example extends MY_Controller {

	public function prueba()
	{
		$path = '';
		
		$imgs = array(
			array(
				'url' => 'media/assets/PRINTOME-21.jpg',
				'area' => array('width' => 203, 'height' => 282),
				'print' => array('left' => 150, 'top' => 107)
			),
			array(
				'url' => 'media/assets/PRINTOME_NAT-39.jpg',
				'area' => array('width' => 173, 'height' => 248),
				'print' => array('left' => 171, 'top' => 107)
			),
			array(
				'url' => 'media/assets/INFANTIL%20MANGA%20CORTA/Fotos-Infantiles-46.jpg',
				'area' => array('width' => 156, 'height' => 218),
				'print' => array('left' => 173, 'top' => 107)
			)
		);
		
		foreach($imgs as $indice=>$img) {
			$img1 = new \Imagick();
			$img1->readImage($img['url']);
			$img1->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);
			
			$img2 = new \Imagick();
			$img2->readImage("media/assets/leon.png");
			$img2->resizeimage($img['area']['width'], $img['area']['height'], \Imagick::FILTER_LANCZOS, 1);
			
			$img1->compositeImage($img2, \Imagick::COMPOSITE_ATOP, $img['print']['left'], $img['print']['top']);
 
			$img1->writeImage("media/assets/temp/test_".$indice.".jpg");
		}
		
		
		
	}
	
	public function svgme() {
		
		$code = stripslashes(html_entity_decode('&lt;svg width=&quot;198&quot; height=&quot;162&quot; viewBox=&quot;0 0 198 162&quot; xmlns=&quot;http:\/\/www.w3.org\/2000\/svg&quot; xmlns:xlink=&quot;http:\/\/www.w3.org\/1999\/xlink&quot;&gt;&lt;g id=&quot;0.1908476794015317&quot;&gt;&lt;text fill=&quot;#800000&quot; stroke=&quot;none&quot; stroke-width=&quot;0&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; x=&quot;24&quot; y=&quot;27&quot; text-anchor=&quot;middle&quot; font-size=&quot;20px&quot; font-family=&quot;Meddon&quot;&gt;&lt;tspan dy=&quot;0&quot; x=&quot;50%&quot;&gt;Hey&lt;\/tspan&gt;&lt;tspan dy=&quot;20&quot; x=&quot;50%&quot;&gt;  &lt;\/tspan&gt;&lt;tspan dy=&quot;20&quot; x=&quot;50%&quot;&gt;you&lt;\/tspan&gt;&lt;tspan dy=&quot;20&quot; x=&quot;50%&quot;&gt;  &lt;\/tspan&gt;&lt;tspan dy=&quot;20&quot; x=&quot;50%&quot;&gt;is there anybody&lt;\/tspan&gt;&lt;tspan dy=&quot;20&quot; x=&quot;50%&quot;&gt; &lt;\/tspan&gt;&lt;tspan dy=&quot;20&quot; x=&quot;50%&quot;&gt;in there&lt;\/tspan&gt;&lt;tspan dy=&quot;20&quot; x=&quot;50%&quot;&gt;&lt;\/tspan&gt;&lt;\/text&gt;&lt;\/g&gt;&lt;\/svg&gt;'));
		$code = '<?xml version="1.0" encoding="iso-8859-1"?>'.$code;
		
		file_put_contents('media/assets/temp.svg', $code);
		
		$font = 'Meddon';
		
		try {
			ob_start();
			$url_font = 'https://fonts.googleapis.com/css?family='.$font;
			$font_code = file_get_contents($url_font);
			
			$start_string = 'url(';
			$start_string_length = strlen($start_string);
			$start = strpos($font_code, $start_string) + $start_string_length;
			$end = strpos($font_code, ')', $start);
			
			$ttf_url = substr($font_code, $start, $end - $start);
			$fonts_dir = 'media/assets/fonts';
			if(!is_file($fonts_dir) && !file_exists($fonts_dir)) {
				mkdir($fonts_dir);
			}
			
			if(!file_exists($fonts_dir.'/'.$font.'.ttf') && !is_dir($fonts_dir.'/'.$font.'.ttf')) {
				file_put_contents($fonts_dir.'/'.$font.'.ttf', file_get_contents($ttf_url));
			}
			
			$img1 = new \Imagick();
			$img1->setResolution(300, 300);
			$img1->readImage('media/assets/temp.svg');
			$img1->setFont('/var/www/printome.mx/public/media/assets/fonts/'.$font.'.ttf');
			$img1->setBackgroundColor(new ImagickPixel('transparent'));
			$img1->setImageFormat('png');
			
			
			
			$thumbnail = $img1->getImageBlob();
			echo $thumbnail;
			$contents =  ob_get_contents();
			ob_end_clean();
			
			echo '<img src="data:image/png;base64,'.base64_encode($contents).'" />';
			
		} catch(ImagickException $e) {
			$e->getMessage();
		}
		
	}
	
	public function fontme()
	{
		$fonts = $this->db->get_where('fuentes', array('title NOT LIKE' => '% %'))->result();
		
		foreach($fonts as $font) {
			$url_font = 'https://fonts.googleapis.com/css?family='.str_replace(' ', '+', $font->title);
			$font_code = file_get_contents($url_font);
			
			$start_string = 'url(';
			$start_string_length = strlen($start_string);
			$start = strpos($font_code, $start_string) + $start_string_length;
			$end = strpos($font_code, ')', $start);
			
			$ttf_url = substr($font_code, $start, $end - $start);
			$fonts_dir = 'media/assets/fonts';
			if(!is_file($fonts_dir) && !file_exists($fonts_dir)) {
				mkdir($fonts_dir);
			}
			
			if(!file_exists($fonts_dir.'/'.$font->title.'.ttf') && !is_dir($fonts_dir.'/'.$font->title.'.ttf')) {
				file_put_contents($fonts_dir.'/'.$font->title.'.ttf', file_get_contents($ttf_url));
			}
		}
	}
	
	public function tet()
	{
		ob_start();
		
		$fontUrl = 'https://fonts.googleapis.com/css?family=Meddon';
		try {
			$fontDescription = file_get_contents($fontUrl);

			$startStr = 'url(';
			$startStrLen = strlen($startStr);
			$start = strpos($fontDescription, $startStr) + $startStrLen;
			$end = strpos($fontDescription, ')', $start);
			$tffUrl = substr($fontDescription, $start, $end - $start);
			
			//echo $tffUrl;

			$tffFile = 'media/assets/meddon.ttf';
			file_put_contents($tffFile, file_get_contents($tffUrl));
		} catch(Exception $e) {
			print_r($e);
		}
		//copy($tffFile, '/usr/share/fonts/truetype/meddon.ttf');

		$img1 = new \Imagick();
		$img1->setResolution(500, 500);
		$img1->readImage("media/assets/test3.svg");
		$img1->setFont("/var/www/printome.mx/public/media/assets/meddon.ttf");
		$img1->setBackgroundColor(new ImagickPixel('transparent'));
		$img1->setImageFormat('png');
		
		$thumbnail = $img1->getImageBlob();
		echo $thumbnail;
		$contents =  ob_get_contents();
		ob_end_clean();
		
		echo '<img src="data:image/png;base64,'.base64_encode($contents).'" />';
		
		
		/* $im->newPseudoImage(100, 100, "caption:Hello");
		$im->setImageFormat('png');
		$im->setImageBackgroundColor(new ImagickPixel('transparent'));
		header('Content-Type: image/png');
		echo $im->__toString(); */
		
		/* 
		
		
		$img1 = new \Imagick();
		$img1->setResolution(500, 500);
		$img1->readImage("media/assets/test.svg");
		//$img1->readImage("media/cliparts/10/print/beer.svg");
		$img1->setBackgroundColor(new ImagickPixel('#000'));
		$img1->setFontFamily("Rammetto One");
		$img1->setImageFormat('png');
		
		$thumbnail = $img1->getImageBlob();
		echo $thumbnail;
		$contents =  ob_get_contents();
		ob_end_clean();
		
		echo '<img src="data:image/png;base64,'.base64_encode($contents).'" />'; */
	}
	
	public function testing($family = 'Meddon')
	{
		//https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCDQQhgKRxbVdUiE8pQUlsEeHDXycCCpj4&family='+data.fonts.google_fonts			
		
		$url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAL5hM45PPhBPaumaquhSIqvhCbiY0YSmI&family='.$family;
		
		//echo $url;

		// Simple GET request
		$response = CurlHelper::factory($url)->exec();
		
		print_r($response);

		//var_dump($response);
	}
	
	
	public function actest()
	{
		$params = [
            'ids'  => '8',
            'full' => '1'
        ];
        $lists  = $this->ac->api( "list/list_", $params );
        //return $lists;
		
        $contacts  = $this->ac->api( "contact/list?filters[listid]=8" );
		
		$messages = $this->ac->api("message/template/list?ids=5");
		
		$account = $this->ac->api("list/list?listid=8");
		echo '<pre>';
		//print_r($lists);
		//print_r($contacts);
		print_r($messages);
		echo '</pre>';
	}
	
	public function actest2($correo = null)
	{
		if($correo != '') {
			$correo = urldecode($correo);
			
			$this->db->select('id_cliente, email, carrito_en_sesion')
				->from('Clientes')
				->where('token_activacion_correo', 'activado')
				->where('email', $correo)
				->group_start()
					->where('carrito_en_sesion !=', NULL)
					->where('carrito_en_sesion !=', '[]')
				->group_end();
				
			$carters = $this->db->get()->result();
			
			$carteritos = array();
			
			foreach($carters as $indice => $carter) {
				$carters[$indice]->carrito_en_sesion = json_decode($carter->carrito_en_sesion);
				
				//print_r($carter);
				
				$cartero = new stdClass();
				$cartero->email = $carter->email;
				$cartero->productos = array();
				
				$previous_des_id = '';
				$previous_id = 0;
				$previous_cam_id = 0;
				
				foreach($carters[$indice]->carrito_en_sesion as $producto) {
					if(isset($producto->options->id_diseno)) {
						if($previous_des_id == $producto->options->id_diseno) {
							if($producto->id != $previous_id) {
								array_push($cartero->productos, site_url($producto->options->disenos->images->front));	
								$previous_id = $producto->id;
							}
						} else {
							array_push($cartero->productos, site_url($producto->options->disenos->images->front));	
							$previous_des_id = $producto->options->id_diseno;
							$previous_id = $producto->id;
						}
					} else {
						if($previous_cam_id != $producto->options->id_enhance) {
							array_push($cartero->productos, site_url($producto->options->images->front));	
							$previous_cam_id = $producto->options->id_enhance;
						}
					}
				}
				
				array_push($carteritos, $cartero);
			}
			
			foreach($carteritos as $carterito) {
			
				$filas = ceil(sizeof($carterito->productos)/3);
				
				$html = '<table style="width:100%;">';
				
				for($i = 0; $i < $filas; $i++) { 
					$html .= '<tr colspan="3">';
					for($j = 0; $j < 3; $j++) {
						if(isset($carterito->productos[($i*3)+$j])) {
							$html .= '<td width="33%"><img src="'.$carterito->productos[($i*3)+$j].'" style="width:100%;height:auto;max-width:200px" /></td>';
						}
					}
					$html .= '</tr>';
				}
				
				$html .= '</table>';
				
				echo $html;
			}
		}
	}
	
}

/*
{"front":"{'width':153,'height':217,'left':'167.111px','top':'107.111px','radius':'0px','zIndex':''}","back":"{'width':166,'height':230,'left':'168.219px','top':'85.2188px','radius':'0px','zIndex':''}","left":"{'width':56,'height':78,'left':'224.111px','top':'85.1111px','radius':'0px','zIndex':''}","right":"{'width':56,'height':78,'left':'217.111px','top':'87.1111px','radius':'0px','zIndex':''}"}
*/
