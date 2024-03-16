<?php


class Stripe_lib
{
    private $stripe_public;
    private $stripe_private;
    private $CI;

    public function __construct(){
        $this->CI =& get_instance();

        $this->stripe_public = $_ENV['STRIPE_PUBLIC_KEY'];
        $this->stripe_private = $_ENV['STRIPE_PRIVATE_KEY'];

        \Stripe\Stripe::setApiKey($this->stripe_private);
    }

    public function crear_cliente($cliente, $direccion){
        $customer = \Stripe\Customer::create([
            "name" => $cliente->nombres." ".$cliente->apellidos,
            "address" => array(
                "line1" => $direccion->linea1,
                "line2" => $direccion->linea2,
                "city" => $direccion->ciudad,
                "country" => "MX",
                "state" => $direccion->estado,
                "postal_code" => $direccion->codigo_postal
            ),
            "email" => $cliente->email,
            "phone" => $direccion->telefono
        ]);

        $this->CI->db->where("id_cliente", $cliente->id_cliente);
        $this->CI->db->update("Clientes", array("id_stripe" => $customer->id));

        return $customer->id;
    }

    public function crear_orden($id_cus_stripe, $items, $direccion, $cliente, $idempotency_key){
        $orden = \Stripe\Order::create([
            "items" => $items,
            "currency" => "mxn",
            "customer" => $id_cus_stripe,
            "shipping" => [
                "name" => $cliente->nombres." ".$cliente->apellidos,
                "address" => [
                    "line1" => $direccion->linea1,
                    "line2" => $direccion->linea2,
                    "city" => $direccion->ciudad,
                    "country" => "MX",
                    "state" => $direccion->estado,
                    "postal_code" => $direccion->codigo_postal
                ]
            ],
            "email" => $cliente->email],
            ["idempotency_key" => $idempotency_key]);

        return $orden->id;
    }

    public function registrar_sku($sku){
        $car_sku = json_decode($sku->caracteristicas);
        $car_producto = json_decode($sku->caracteristicas_adicionales);

        $sku_stripe = \Stripe\SKU::create([
            "product" => $sku->id_prod_stripe,
            "price" => number_format($sku->precio, 2,'',''),
            "currency" => "MXN",
            "inventory" => [
                "type" => "infinite"
            ],
            "attributes" => array(
                "size" => $car_sku->talla,
                "color" => $color,
                "sku_interno" => $sku->sku
            ),
            "metadata" => array(
                "sku_interno" => $sku->sku,
                "nombre_color" => $sku->nombre_color,
                "codigo_color" => $sku->codigo_color,
                "tipo_manga" => $car_producto->{"tipo-de-manga"},
                "tipo_cuello" => $car_producto->{"tipo-de-cuello"},
                "tipo_tela" => $car_producto->{"tipo-de-tela"},
                "talla" => $car_sku->talla,
                "genero" => $sku->nombre_producto
            ),
            "image" => base_url("assets/images/productos/producto".$sku->id_producto."/".$sku->fotografia_original)
        ]);

        return $sku_stripe->id;
    }

    public function registrar_producto($producto){
        $producto_stripe = \Stripe\Product::create([
            "name" => $producto->nombre_producto,
            "type" => "good",
            "attributes" => ["size", "color", "sku_interno", "id_enhance", "name"],
            "metadata" => array(
                "nombre_producto_slug" => $producto->nombre_producto_slug,
                "id_categoria" => $producto->id_categoria,
                "modelo_producto" => $producto->modelo_producto,
                "descripcion" => $producto->descripcion_producto
            )
        ]);

        return $producto_stripe->id;
    }

    public function borrar_todos_los_productos(){
        $todos = \Stripe\Product::all(["limit" => 100]);
        foreach($todos->data as $prod){
            $product = \Stripe\Product::retrieve($prod->id);
            if($prod->id != 'ENVIOSPRINTOME' && $prod->id != "PRODPERSONALIZADO") {
                $product->delete();
            }
        }
    }

    public function borrar_todos_skus(){
        //for($i = 0; $i<= 5; $i++) {
            $todos = \Stripe\SKU::all(["limit" => 500]);
            foreach ($todos->data as $prod) {
                $product = \Stripe\SKU::retrieve($prod->id);
                if($prod->id != 'ENVIOREGULAR' && $prod->id != 'ENVIOMID' && $prod->id != 'ENVIOFREE' && $prod->id != 'sku_Fs25pMiK8m7xec') {
                    $product->delete();
                }
            }
        //}
    }

    public function crear_sku_tienda($item){
        $this->CI->db->select("id_stripe")
            ->from("CatalogoProductos")
            ->where("id_producto", $item['id']);
        $producto = $this->CI->db->get()->row();

        $sku_stripe = \Stripe\SKU::create([
            "product" => "PRODPERSONALIZADO",
            "price" => number_format($item['price'], 2,'',''),
            "currency" => "MXN",
            "inventory" => [
                "type" => "infinite"
            ],
            "attributes" => array(
                "size" => $item['options']['talla'],
                "color" => $item['options']['color'],
                "sku_interno" => $item['options']['sku'],
                "name" => $item['name']
            ),
            "metadata" => array(
                "id_enhance" => $item['options']['id_enhance']
            ),
            "image" => base_url($item['options']['images']['front'])
        ]);

        return $sku_stripe->id;
    }

    public function crear_sku_tienda_tester($item){
        $this->CI->db->select("id_stripe")
            ->from("CatalogoProductos")
            ->where("id_producto", $item['id']);
        $producto = $this->CI->db->get()->row();

        $sku_stripe = \Stripe\SKU::create([
            "product" => "PRODPERSONALIZADO",
            "price" => number_format($item['price'], 2,'',''),
            "currency" => "MXN",
            "inventory" => [
                "type" => "infinite"
            ],
            "attributes" => array(
                "size" => $item['options']['talla'],
                "color" => $item['options']['color'],
                "sku_interno" => $item['options']['sku'],
                "name" => $item['name']
            ),
            "metadata" => array(
                "id_enhance" => $item['options']['id_enhance']
            ),
            "image" => base_url($item['options']['images']['front'])
        ]);

        return $sku_stripe->id;
    }

    public function crear_sku_personalizado($item){

        if(!isset($item['options']['id_color']) || ($item['options']['id_color'] == "")){
            $color = "BCO";
        }else{
            $color = $item['options']['id_color'];
        }

        $sku_stripe = \Stripe\SKU::create([
            "product" => "PRODPERSONALIZADO",
            "price" => number_format($item['price'], 2,'',''),
            "currency" => "MXN",
            "inventory" => [
                "type" => "infinite"
            ],
            "attributes" => array(
                "size" => $item['options']['talla'],
                "color" => $color,
                "sku_interno" => $item['options']['sku'],
                "name" => "Producto Personalizado"
            ),
            "image" => base_url($item['options']['disenos']['images']['front'])
        ]);

        return $sku_stripe->id;
    }

    public function pagar_orden($order_id, $card_token, $idempotency_key){
        $order = \Stripe\Order::retrieve($order_id);
        $order = $order->pay([
            'source' => $card_token // obtained with Stripe.js
        ],
        ["idempotency_key" => $idempotency_key]);
        return $order;
    }
}