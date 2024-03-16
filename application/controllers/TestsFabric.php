<?php

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

class TestsFabric extends MY_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('test_model');
    }
    public function index($estilo = 13)
    {
        $datos_footer['scripts'] = 'test/fabrictests';
        $datos_seccion['estilos'] = $this->test_model->obtener_estilos();
        $datos_seccion['estilo_actual'] = $this->test_model->obtener_estilo_actual($estilo);
        $datos_seccion['fonts'] = $this->test_model->obtener_fuentes_texto();

        $this->load->view('header');
        $this->load->view('test/index', $datos_seccion);
        $this->load->view('footer', $datos_footer);
    }

    public function test_paypal(){

        $this->load->view('header');
        /* CODIGO PARA ALMACENAR TOKEN EN BD DESPUES DE GENERAR EXITOSAMENTE (FUNCION DE CRON)*/

        /*CODIGO PARA GENERAR ESTRUCTURA PREVIA AL PAGO, ESTO PARA DESPLEGAR EL FORMULARIO DE PAGO FINAL
        (FUNCION DE NCARRITO)
        $item_array = array();

        foreach ($items as $i => $item){
            $item_array[$i] = array (
                'name' => $item->name,
                'description' => $item->description,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'sku' => $item->sku,
                'currency' => $item->currency,
            );
        }

        $payment = array (
            'intent' => 'sale',
            'application_context' => array (
                'shipping_preference' => 'SET_PROVIDED_ADDRESS',
            ),
            'payer' => array (
                'payment_method' => $pedido->metodo_pago,
                'payer_info' => array (
                    'billing_address' => array (
                        'line1' => $direccion->linea1,
                        'line2' => $direccion->linea2,
                        'city' => $direccion->ciudad,
                        'country_code' => 'MXN',
                        'postal_code' => $direccion->codigo_postal,
                        'state' => $direccion->estado,
                    ),
                ),
            ),
            'transactions' => array (
                0 => array (
                    'amount' => array (
                        'currency' => 'MXN',
                        'total' => number_format($pedido->total, 2,'.',''),
                        'details' => array (
                            'subtotal' => number_format($pedido->subtotal, 2,'.',''),
                        ),
                    ),
                    'description' => 'Pedido en Envia Flores',
                    'payment_options' => array (
                        'allowed_payment_method' => 'IMMEDIATE_PAY',
                    ),
                    'invoice_number' => $pedido->id_pedido,
                    'item_list' => array (
                        'items' => $item_array,
                        'shipping_address' => array (
                            'recipient_name' => $pedido->nombre,
                            'line1' => $direccion->linea1,
                            'line2' => $direccion->linea2,
                            'city' => $direccion->ciudad,
                            'country_code' => 'MXN',
                            'postal_code' => $direccion->codigo_postal,
                            'state' => $direccion->estado,
                            'phone' => $direccion->telefono,
                        ),
                    ),
                ),
            ),
            'redirect_urls' => array (
                'cancel_url' => base_url('carrito'),
                'return_url' => base_url('carrito'),
            ),
        );
        $payment = json_encode($payment);
        $token =  $this->db->get_where('TokensPayPal', array('estatus' => 1))->row();
        $result_info_pago = $this->paypalplus->send_payment_information($payment, $token->access_token);
        ****************************************************************************************************/

        $this->load->view('footer');
    }

    public function generar_imagen(){
        $png_string = $this->input->post('svgString');
        $png_string = str_replace("data:image/png;base64,", "", $png_string);
        $img_dis_front = new \Imagick();
        $decoded = base64_decode($png_string);
        $img_dis_front->readimageblob($decoded);
        try {
            $img_front = new \Imagick();
            $img_front->readImage("assets/images/productos/producto1/900_playera-blanca_pp01_blanca.jpg");
            $img_front->resizeimage(500, 500, \Imagick::FILTER_LANCZOS, 1);
            $img_front->compositeImage($img_dis_front, \Imagick::COMPOSITE_ATOP, 150, 100);
            $conf = $img_front->getImageBlob();
            echo "data:image/jpeg;base64,".base64_encode($conf);
        }catch(Exception $e){
            echo $e;
            echo "error";
        }
    }

    public function info(){
        phpinfo();
    }

    public function obtener_fuentes(){
        $var = $this->test_model->obtener_fuentes_texto();
        echo json_encode($var);
    }

    public function obtener_colores_imagen(){
        $filename = $_FILES['file']['name'];
        $path_parts = pathinfo($filename);
        $ext = $path_parts['extension'];
        switch ($ext){
            case 'png':
                $img = imagecreatefrompng($_FILES['file']['tmp_name']);
                break;
            case 'jpg':
            case 'jpeg':
                $img = imagecreatefromjpeg($_FILES['file']['tmp_name']);
                break;
            case 'gif':
                $img = imagecreatefromgif($_FILES['file']['tmp_name']);
                break;
            default:
                $img = false;
                break;
        }
        if($img != false){
            list($width, $height) = getimagesize($_FILES['file']['tmp_name']);
            if($width > 500 && $height > 500){
                $img_resized = imagescale($img, 500, 500);
                $palette = League\ColorExtractor\Palette::fromGD($img_resized);
            }else{
                $palette = League\ColorExtractor\Palette::fromGD($img);
            }
            $extractor = new League\ColorExtractor\ColorExtractor($palette);
            $colors = $extractor->extract(5);
            foreach ($colors as $index => $color){
                $colors[$index] = League\ColorExtractor\Color::fromIntToHex($color);
            }
        }else{
            $colors = false;
        }

        echo json_encode($colors);
    }

    public function guardar(){
        $json = json_decode($this->input->post('json'));
        foreach ($json->objects as $index => $object){
            if($object->tipo == 'img'){
                $image_data = $object->src;
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image_data));
                $random_number = rand(1, 1000000);
                file_put_contents('tests/'.$random_number.$object->image_name, $data);
                $object->src = 'tests/'.$random_number.$object->image_name;
            }
        }
        echo json_encode($json);
    }

}