<?php
/*
 * Libreria para la utilizacion de paypal plus
*/

class Paypalplus {

    private $paypal_url;
    private $paypal_client;
    private $paypal_secret;
    private $CI;

    public $connection;

    public function __construct(){
        $this->CI =& get_instance();

        $paypal_mode = $_ENV['PAYPAL_MODE'];
        if ($paypal_mode == 'live') {
            $host = 'https://api.paypal.com';
        }else{
            $host = 'https://api.sandbox.paypal.com';
        }

        $this->paypal_url = $host;
        $this->paypal_client = $_ENV['PAYPALPLUS_CLIENT'];
        $this->paypal_secret = $_ENV['PAYPALPLUS_SECRET'];

        $this->connection = new \GuzzleHttp\Client();
    }

    /*
     * This function gets the OAuth2 Access Token which will be valid for 28800 seconds = 8 hours
     * este proceso se debe correr cada 6 horas = 21600 segundos para evitar problemas
    */
    public function get_access_token() {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->paypal_url.'/v1/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->paypal_client . ':' . $this->paypal_secret);

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = $this->verificar_respuesta($result, $ch);

        return $response;
    }
    public function send_payment_information($data, $access_token){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->paypal_url.'/v1/payments/payment');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer '.$access_token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = $this->verificar_respuesta($result, $ch);
        return $response;
    }

    private function verificar_respuesta($result, &$ch){
        $mensaje = new stdClass();
        if (curl_errno($ch)) {
            $mensaje->error = 'Error:' . curl_error($ch);
            $mensaje->estatus = false;
            curl_close($ch);
            return $mensaje;
        }else{
            $info = curl_getinfo($ch);
            curl_close($ch);
            if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
                $mensaje->error =  "Received error: " . $info['http_code']. "\n";
                $mensaje->mensaje =  "Raw response:".$result."\n";
                $mensaje->estatus =  false;
                return $mensaje;
            }else{
                $jsonResponse = json_decode( $result );
                $jsonResponse->estatus = true;
                return $jsonResponse;
            }
        }
    }

    public function finalizar_pago($payerID, $paymentID, $accessToken){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->paypal_url.'/v1/payments/payment/'.$paymentID.'/execute/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"payer_id": "'.$payerID.'"}');
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer '.$accessToken.'';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = $this->verificar_respuesta($result, $ch);
        return $response;
    }
}
