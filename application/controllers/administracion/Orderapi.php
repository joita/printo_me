<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orderapi extends MY_Controller {


    private $order;
    private $customer;
    private $clientID;

    public function __construct()
    {
        parent::__construct();
    }

    private function setData($data){
        $this->order = $data;
        $this->setCustomer();
    }
    private function setCustomer(){
        $this->customer = $this->getCustomer();
    }

    public function get_id(){
        return $this->order->id;
    }

    public function getLineItems(){
        return $this->order->line_items;
    }

    public function getCustomer(){
        return $this->order->customer;
    }

    public function getBillingAddress(){
        return $this->order->billing_address;
    }

    public function getShippingAddress(){
        return $this->order->shipping_address;
    }

    public function orderItems(){
        return $this->order->line_items;
    }

    public function getTotalPrice(){
        return $this->order->total_price;
    }

    public function getSubTotalPrice(){
        return $this->order->subtotal_price;
    }

    public function getCurrency(){
        return $this->order->currency;
    }

    public function getCreatedDate(){
        return $this->order->created_at;
    }
    public function getOrderStatus(){
        return $this->order->confirmed ? "confirmada":'No confirmado';
    }

    public function financial_status(){
        return $this->order->financial_status;
    }

    public function getMethod(){
        return $this->order->gateway;
    }

    public function getOrderNumber(){
        return $this->order->order_number;
    }

    public function getUserEmail(){
        return $this->customer->email;
    }

    public function getUserFirstName(){
        return $this->customer->first_name;
    }

    public function getUserLastName(){
        return $this->customer->last_name;
    }

    public function getUserPhone(){
        return $this->customer->phone;
    }

    public function getTotalTax(){
        return $this->order->total_tax;
    }

    public function getShipping(){
        return $this->order->shipping_lines;
    }

    public function getShippingAmount(){
        if(isset($this->order->total_shipping_price_set->shop_money))
        {
            return $this->order->total_shipping_price_set->shop_money->amount;
        }

    }

    public function discounts(){
        return $this->order->total_discounts;
    }

    public function getUserAddress($key = null){

        if($key === null)
        {
            return [
                'address1' => $this->customer->default_address->address1,
                'address2' => $this->customer->default_address->address2,
                'city' => $this->customer->default_address->city,
                'province' => $this->customer->default_address->province,
                'country' => $this->customer->default_address->country,
                'zip' => $this->customer->default_address->zip,
                'phone' => $this->customer->default_address->phone,
                'country_name' => $this->customer->default_address->country_name

            ];
        }
        else{
            return $this->customer->default_address->{$key};
        }
    }

    public function json_validator($data=NULL) {
        if (!empty($data)) {
            @json_decode($data);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }

    public function push_orders(){

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            exit("This method is not supported");
        }

        $webhook_content = '';
        $webhook = fopen('php://input' , 'rb');

        while(!feof($webhook)){ //loop through the input stream while the end of file is not reached
            $webhook_content .= fread($webhook, 4096); //append the content on the current iteration
        }
        fclose($webhook); //close the resource
        $response = $this->json_validator($webhook_content);
        if($response){

            $order = json_decode($webhook_content);
            if(isset($order->id))
            {

                $this->setData($order);

                $exists = $this->db->get_where('Pedidos',['shopify_oid' => $order->id])->result();
                if(count($exists) > 0)
                {
                    die('Order Already Exists.');
                }

                $data =  $this->prepareOrderData();
                $this->generateOrder($data);

                $this->db->insert('shopify_logs',['vendor_id'=>$order->id,'logs'=> json_encode($data),'type'=>'order_create']);
            }else{
                die("Incorrect input received");
            }

        }

        die("Request Processed");
    }

    public function registerUser(){
        $fname  =  $this->getUserFirstName();
        $lname  =  $this->getUserLastName();
        $email  =  $this->getUserEmail();
        $phone  =  $this->getUserPhone();

        $row =  $this->db->get_where('Clientes',['email'=>$email])->row();
        if(count($row) > 0)
        {
            return $row->id_cliente;
        }else{

            $arr = ['nombres'=> $fname,
                'apellidos' => $lname,
                'email' => $email,
                'telefono' => $phone,
                'password' =>'shopify-user'
            ];
            $this->db->insert('Clientes',$arr);
            return $this->db->insert_id();
        }
    }



    public function prepareOrderData(){


        $arr = [
            "fecha_creacion" => $this->getCreatedDate(),
            "estatus_pedido" => $this->getOrderStatus(),
            //"metodo_pago" => $this->getMethod(),
            "metodo_pago" => 'shopify_payment',
            "fecha_pago" =>  $this->getCreatedDate(),
            //"estatus_pago" => $this->financial_status(),
            "estatus_pago" => 'En Proceso',
            "subtotal" => $this->getSubTotalPrice(),
            "total" => $this->getTotalPrice(),
            "descuento" => $this->discounts(),
            "iva" => $this->getTotalTax(),
            "costo_envio" => $this->getShippingAmount(),

        ];
        return $arr;
    }

    public function getOrderItems(){

        $oItems = [];
        $line_items =  $this->getLineItems();
        foreach ($line_items as $key => $item) {

            //Find Enhance product id from shopify product id
            $enhanceProduct = $this->db->get_where('proveedores_shopify_prod',['shopify_id' => $item->product_id])->row();

            $enhanceId = 0;
            if(count($enhanceProduct) > 0)
            {
                $enhanceId = $enhanceProduct->product_id;
            }

            $enhanceClientProduct = $this->db->get_where('Enhance',['id_enhance' => $enhanceId])->row();

            $skuObject = [];
            if(count($enhanceClientProduct) > 0){
                $skuObject = $this->db->query("select cspp.* From CatalogoSkuPorProducto as cspp left join ColoresPorProducto as cpp on cpp.id_color = cspp.id_color where cspp.sku ='".$item->sku."' and cpp.id_producto='".$enhanceClientProduct->id_producto."'")->row();
            }
            /*$skuObject =  $this->db->get_where('CatalogoSkuPorProducto',['sku' => $item->sku])->row();*/
            if(!empty($skuObject))
            {

                //Enhance Product
                if(count($enhanceClientProduct) > 0){
                    $this->clientID =  $enhanceClientProduct->id_cliente;
                }

                $oItems[] = [
                    'id_sku' => $skuObject->id_sku,
                    'precio_producto' => $item->price,
                    'descuento_especifico' => $item->total_discount,
                    'cantidad_producto' => $item->quantity,
                    'aplica_devolucion' => 0,
                    'id_enhance' => $enhanceId,
                ];
            }

        }
        return $oItems;
    }

    public function generateOrder($data){

        //order items
        $order_items =  $this->getOrderItems();
        if(!empty($order_items))
        {

            //Register User or get ID
            $user_id = $this->registerUser();

            //Generate Shipping
            $shipping_id = $this->generateShipping($user_id);

            //order items
            $order_items =  $this->getOrderItems();

            $data['id_cliente'] = $user_id;
            $data['id_direccion'] = $shipping_id;
            $data['shopify_oid'] = $this->get_id();

            $isTrue = $this->db->insert('Pedidos',$data);
            $oid = $this->db->insert_id();
            if($oid && $isTrue)
            {
                foreach ($order_items as $key => $oItem) {

                    $oItem['id_pedido'] = $oid;

                    /*$query = $this->db->query("UPDATE CatalogoSkuPorProducto SET cantidad_inicial=(cantidad_inicial-".$oItem['cantidad_producto'].") WHERE id_sku='".$oItem['id_sku']."'");*/

                    $this->db->insert('ProductosPorPedido',$oItem);
                }

                //inventory_managment_increase
                $this->inventory_managment_increase($oid);


                //Create Extra Charge
                $this->CreateExtraCharge($oid);

                $this->db->insert('shopify_vendor_orders',['order_id' => $oid ,'shopify_domain' => $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'] ]);

                $this->db->insert('shopify_logs',['vendor_id'=>$oid,'logs'=> '{"Success":"Order Created Successfully"}','type'=>'order_create']);
            }
        }else{
            $this->db->insert('shopify_logs',['vendor_id'=>0,'logs'=> '{"error":"Empty Order Items"}','type'=>'order_create']);
        }
    }

    private function CreateExtraCharge($pedido = 0)
    {
        $directions = $this->db->get_where('DireccionesPorCliente',['id_cliente' => $this->clientID])->row();

        $Store = $this->db->get_where('Tiendas',['id_cliente' => $this->clientID])->row();

        $methodID =  $Store->tipo_pago;

        //finding store payment
        if($methodID == 1)
        {
            $metodo_pago = 'cash_payment';
        }elseif ($methodID == 2) {
            $metodo_pago = 'card_payment';
        }elseif ($methodID == 3) {
            $metodo_pago = 'spei';
        }else{
            $metodo_pago = 'cash_payment';
        }


        $arr = [
            'id_cliente' => $this->clientID,
            'num_pedido'  => $pedido,
            'metodo_pago'=> $metodo_pago,
            'concepto'  =>  'Cargo extra por envíos',
            'cantidad'  => $this->getTotalPrice(),
            'direccion_cliente' => json_encode($directions)
        ];

        // set post fields
        $ch = curl_init(base_url().'administracion/shopify-cargos-extra/agregar-nuevo-cargo');
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);

        // execute!
        $response = curl_exec($ch);
        // close the connection, release resources used
        curl_close($ch);
    }

    public function generateShipping($user =null)
    {

        $userAdd = $this->getUserAddress();

        $shippingAddress = [
            'identificador_direccion' => 'Principal',
            'linea1' => $userAdd['address1'],
            'linea2' => $userAdd['address2'],
            'codigo_postal' => $userAdd['zip'],
            'ciudad' => $userAdd['city'],
            'estado' => $userAdd['province'],
            'pais' => $userAdd['country'],
            'id_cliente' => $user

        ];

        $this->db->insert('DireccionesPorCliente',$shippingAddress);
        return $this->db->insert_id();
    }

    public function inventory_managment_deduction($id_pedido)
    {
        $pedido = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
        $productos = $this->pedidos_modelo->obtener_productos_por_pedido($id_pedido);

        foreach ($productos as $producto) {
            $cantidad = $producto->cantidad_producto;
            $sku = $producto->id_sku;

            if($producto->id_enhance != 0) {
                //if($producto->estatus_pago == 'paid') {
                    $query = $this->db->query('UPDATE Enhance SET sold=(sold-'.$cantidad.') WHERE id_enhance='.$producto->id_enhance);
                    $query2 = $this->db->query("UPDATE `CatalogoSkuPorProducto` SET `cantidad_inicial` = (`cantidad_inicial`+".$cantidad.") WHERE `id_sku` = '".$sku."'");
                //}
            } else {
                $query = $this->db->query("UPDATE `CatalogoSkuPorProducto` SET `cantidad_inicial` = (`cantidad_inicial`+".$cantidad.") WHERE `id_sku` = '".$sku."'");
            }
        }

    }

    public function inventory_managment_increase($id_pedido)
    {
        $pedido = $this->pedidos_modelo->obtener_pedido_especifico($id_pedido);
        $productos = $this->pedidos_modelo->obtener_productos_por_pedido($id_pedido);

        foreach ($productos as $producto) {
            $cantidad = $producto->cantidad_producto;
            $sku = $producto->id_sku;

            if($producto->id_enhance != 0) {
                //if($producto->estatus_pago == 'paid') {
                    $query = $this->db->query('UPDATE Enhance SET sold=(sold+'.$cantidad.') WHERE id_enhance='.$producto->id_enhance);
                    $query2 = $this->db->query("UPDATE `CatalogoSkuPorProducto` SET `cantidad_inicial` = (`cantidad_inicial`-".$cantidad.") WHERE `id_sku` = '".$sku."'");
                //}
            } else {
                $query = $this->db->query("UPDATE `CatalogoSkuPorProducto` SET `cantidad_inicial` = (`cantidad_inicial`-".$cantidad.") WHERE `id_sku` = '".$sku."'");
            }
        }

    }


    public function cencel_order()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            exit("This method is not supported");
        }

        $webhook_content = '';
        $webhook = fopen('php://input' , 'rb');

        while(!feof($webhook)){ //loop through the input stream while the end of file is not reached
            $webhook_content .= fread($webhook, 4096); //append the content on the current iteration
        }
        fclose($webhook); //close the resource
        $response = $this->json_validator($webhook_content);
        if($response){

            $order = json_decode($webhook_content);
            if(isset($order->id))
            {
                //3645490954446
                //Cancelado
                $orderExists =  $this->db->get_where('Pedidos',['shopify_oid'=>$order->id])->row();

                if(count($orderExists) === 1)
                {

                    $this->db->where(['shopify_oid'=>$order->id]);
                    $this->db->update('Pedidos', ['estatus_pedido' => 'Cancelado','observaciones' => $order->cancel_reason,'id_paso_pedido' =>7]);

                    $this->db->insert('HistorialPedidos',['id_pedido'=>$orderExists->id_pedido,'id_paso_pedido'=> 7,'fecha_inicio'=>date("Y-m-d H:i:s"),'fecha_final'=>date("Y-m-d H:i:s")]);

                    //manage inventory
                    $id_pedido = $orderExists->id_pedido;
                    $this->inventory_managment_deduction($id_pedido);
                    //Insert Into Logs
                    $this->db->insert('shopify_logs',['vendor_id'=>$order->id,'logs'=> json_encode($order),'type'=>'order_cancel']);
                }else{
                    die("Order doesn't exits");
                }

            }else{
                die("Incorrect input received");
            }
        }
    }
}