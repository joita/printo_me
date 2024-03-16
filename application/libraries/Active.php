<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Active {

    private $active_url;
    private $active_url_v3;
    private $active_key;

    public $client;

    public function __construct()
    {
        $CI =& get_instance();

        $this->set_active_url($CI->config->item('active_api_url'));
        $this->set_active_url($CI->config->item('active_api_url_v3'));
        $this->set_active_key($CI->config->item('active_api_key'));

        $this->client = new \GuzzleHttp\Client();
    }

    // Función para crear una conexión de deep data integration
    public function crear_conexion($service, $externalid, $name, $logoUrl, $linkUrl)
    {
        $connection = new stdClass();
        $error = false;
        if($service != '') {
            $connection->service = $service;
        } else {
            $error = true;
        }
        if($externalid != '') {
            $connection->externalid = $externalid;
        } else {
            $error = true;
        }
        if($name != '') {
            $connection->name = $name;
        } else {
            $error = true;
        }
        if($logoUrl != '') {
            $connection->logoUrl = $logoUrl;
        } else {
            $error = true;
        }
        if($linkUrl != '') {
            $connection->linkUrl = $linkUrl;
        } else {
            $error = true;
        }

        if(!$error) {
            $res = $this->client->request('POST', $this->get_active_url_v3().'/connections', [
                'headers' => [
                    'Api-Token' => $this->get_active_key(),
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'connection' => $connection
                ]
            ]);

            return true;
        } else {
            return false;
        }
    }

    // Función para obtener todas las conexiones de deep data integration
    public function obtener_conexiones()
    {
        $res = $this->client->request('GET', $this->get_active_url_v3().'/connections', [
            'headers' => [
                'Api-Token' => $this->get_active_key()
            ]
        ]);

        $conexiones = json_decode($res->getBody());

        return $conexiones;
    }

    // Función para obtener una conexión de deep data integration
    public function obtener_conexion($id_conexion)
    {
        $res = $this->client->request('GET', $this->get_active_url_v3().'/connections/'.$id_conexion, [
            'headers' => [
                'Api-Token' => $this->get_active_key()
            ]
        ]);

        $conexion_temp = json_decode($res->getBody());
        $conexion = $conexion_temp->connection;

        return $conexion;
    }

    // Función para actualizar una conexión de deep data integration
    public function actualizar_conexion($id_conexion, $info_conexion /* info_conexion es stdClass */)
    {
        $connection = new stdClass();
        if(isset($info_conexion->service)) {
            $connection->service = $info_conexion->service;
        }
        if(isset($info_conexion->externalid)) {
            $connection->externalid = $info_conexion->externalid;
        }
        if(isset($info_conexion->name)) {
            $connection->name = $info_conexion->name;
        }
        if(isset($info_conexion->logoUrl)) {
            $connection->logoUrl = $info_conexion->logoUrl;
        }
        if(isset($info_conexion->linkUrl)) {
            $connection->linkUrl = $info_conexion->linkUrl;
        }

        if(count(get_object_vars($connection)) > 0) {
            $res = $this->client->request('PUT', $this->get_active_url_v3().'/connections/'.$id_conexion, [
                'headers' => [
                    'Api-Token' => $this->get_active_key(),
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'connection' => $connection
                ]
            ]);

            return true;
        } else {
            return false;
        }
    }

    // Función para borrar una conexión específica
    public function borrar_conexion($id_conexion)
    {
        $res = $this->client->request('DELETE', $this->get_active_url_v3().'/connections/'.$id_conexion, [
            'headers' => [
                'Api-Token' => $this->get_active_key()
            ]
        ]);

        return true;
    }

    // Función para crear cliente
    public function crear_cliente($connectionid, $externalid, $email, $limit = 100)
    {
        $cliente_nuevo = new stdClass();
        $error = false;
        if($connectionid != '') {
            $cliente_nuevo->connectionid = $connectionid;
        } else {
            $error = true;
        }
        if($externalid != '') {
            $cliente_nuevo->externalid = $externalid;
        } else {
            $error = true;
        }
        if($email != '') {
            $cliente_nuevo->email = $email;
        } else {
            $error = true;
        }

        if(!$error) {
            $res = $this->client->request('POST', $this->get_active_url_v3().'/ecomCustomers?limit='.$limit, [
                'headers' => [
                    'Api-Token' => $this->get_active_key(),
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'ecomCustomer' => $cliente_nuevo
                ]
            ]);

            return true;
        } else {
            return false;
        }
    }

    // Función para obtener todos los clientes de ecommerce
    public function obtener_clientes($filters = array('email' => '', 'externalid' => '', 'connectionid' => ''), $limit = 100, $offset = 0)
    {
        $filter_string = array();
        if(isset($filters['email'])) {
            if($filters['email'] != '') {
                $filter_string[] = 'filters[email]='.$filters['email'];
            }
        }
        if(isset($filters['externalid'])) {
            if($filters['externalid'] != '') {
                $filter_string[] = 'filters[externalid]='.$filters['externalid'];
            }
        }
        if(isset($filters['connectionid'])) {
            if($filters['connectionid'] != '') {
                $filter_string[] = 'filters[connectionid]='.$filters['connectionid'];
            }
        }

        $filtro = implode("&", $filter_string);

        $res = $this->client->request('GET', $this->get_active_url_v3().'/ecomCustomers?limit='.$limit.'&offset='.$offset.($filtro != '' ? '&'.$filtro : ''), [
            'headers' => [
                'Api-Token' => $this->get_active_key()
            ]
        ]);

        $clientes = json_decode($res->getBody());

        return $clientes;
    }

    // Función para obtener un cliente de ecommerce con id
    public function obtener_cliente($id_cliente)
    {
        $res = $this->client->request('GET', $this->get_active_url_v3().'/ecomCustomers/'.$id_cliente, [
            'headers' => [
                'Api-Token' => $this->get_active_key()
            ]
        ]);

        $cliente_temp = json_decode($res->getBody());
        $cliente = $cliente_temp->ecomCustomer;

        return $cliente;
    }

    // Función para actualizar un cliente de deep data integration
    public function actualizar_cliente($id_cliente, $info_cliente /* info_conexion es stdClass */)
    {
        $customer = new stdClass();
        if(isset($info_cliente->externalid)) {
            $customer->externalid = $info_cliente->externalid;
        }
        if(isset($info_cliente->connectionid)) {
            $customer->connectionid = $info_cliente->connectionid;
        }
        if(isset($info_cliente->email)) {
            $customer->email = $info_cliente->email;
        }

        if(count(get_object_vars($customer)) > 0) {
            $res = $this->client->request('PUT', $this->get_active_url_v3().'/ecomCustomers/'.$id_cliente, [
                'headers' => [
                    'Api-Token' => $this->get_active_key(),
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'ecomCustomer' => $customer
                ]
            ]);

            return true;
        } else {
            return false;
        }
    }

    // Función para borrar un cliente especifico
    public function borrar_cliente($id_cliente)
    {
        $res = $this->client->request('DELETE', $this->get_active_url_v3().'/ecomCustomers/'.$id_cliente, [
            'headers' => [
                'Api-Token' => $this->get_active_key()
            ]
        ]);

        return true;
    }

    // Función para crear una orden
    public function crear_pedido($connectionid, $customerid, $source /* 0 - sync, 1 - live */, $info_pedido, $productos_pedido)
    {
        $CI =& get_instance();

        $error = false;
        $order = new stdClass();
        $order->source = $source;
        if(isset($info_pedido->id_pedido)) {
            $order->externalid = $info_pedido->id_pedido;
        } else {
            $error = true;
        }
        if(isset($info_pedido->email)) {
            $order->email = $info_pedido->email;
        } else {
            $error = true;
        }
        if(isset($info_pedido->id_pedido)) {
            $order->orderNumber = $info_pedido->id_pedido;
        } else {
            $error = true;
        }

        if(sizeof($productos_pedido) > 0) {
            $order->orderProducts = array();
            foreach($productos_pedido as $producto) {
                if($producto->id_enhance) {
                    $info_enhanced = $CI->catalogo_modelo->obtener_enhanced_con_id($producto->id_enhance);
					if(!isset($info_enhanced->name)) {
						$nombre_producto = 'Producto vencido';
						$id_producto = $producto->id_enhance;
						$imagen_producto = site_url($info_enhanced->front_image);
					} else {
						$nombre_producto = $info_enhanced->name;
						$id_producto = $info_enhanced->id_enhance;
						$imagen_producto = site_url($info_enhanced->front_image);
					}
                    $categoria = 'Producto en venta';
                } else {
                    $nombre_producto = $producto->nombre_producto.' personalizada';
                    $id_producto = $producto->id_producto;
                    $categoria = 'Producto personalizado';
					$imagen_json = json_decode($producto->diseno);
					$imagen_json_2 = $imagen_json->images;
					$imagen_producto = site_url($imagen_json_2->front);
                }

                $new_prod = new stdClass();
                $new_prod->externalid = $id_producto;
                $new_prod->name = $nombre_producto;
                $new_prod->price = number_format($producto->precio_producto * 100, 0, '', '');
                $new_prod->quantity = $producto->cantidad_producto;
                $new_prod->category = $categoria;
				$new_prod->imageUrl = $imagen_producto;

                array_push($order->orderProducts, $new_prod);
            }
        } else {
            $error = true;
        }

        $order->orderDate = date("c", strtotime($info_pedido->fecha_creacion));
        $order->shippingMethod = 'DHL Express';
        $order->totalPrice = number_format($info_pedido->total * 100, 0, '', '');;
        $order->currency = 'MXN';
        $order->connectionid = $connectionid;
        $order->customerid = $customerid;

        if(!$error) {
            $res = $this->client->request('POST', $this->get_active_url_v3().'/ecomOrders', [
                'headers' => [
                    'Api-Token' => $this->get_active_key(),
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'ecomOrder' => $order
                ]
            ]);

            return true;
        } else {
            return false;
        }
    }

    public function crear_cargo($connectionid, $customerid, $source /* 0 - sync, 1 - live */, $info_pedido){
        $CI =& get_instance();

        $error = false;
        $order = new stdClass();
        $order->source = $source;
        if(isset($info_pedido->id_cargo)) {
            $order->externalid = $info_pedido->id_cargo."CE";
        } else {
            $error = true;
        }
        if(isset($info_pedido->email)) {
            $order->email = $info_pedido->email;
        } else {
            $error = true;
        }
        if(isset($info_pedido->id_cargo)) {
            $order->orderNumber = $info_pedido->id_cargo;
        } else {
            $error = true;
        }

        $order->orderProducts = array();

        $nombre_producto = "Cargo Extra";
        $id_producto = $info_pedido->id_cargo;
        $categoria = "Cargos Extra";

        $new_prod = new stdClass();
        $new_prod->externalid = $id_producto;
        $new_prod->name = $nombre_producto;
        $new_prod->price = number_format($info_pedido->total * 100, 0, '', '');
        $new_prod->quantity = 1;
        $new_prod->category = $categoria;

        array_push($order->orderProducts, $new_prod);

        $order->orderDate = date("c", strtotime($info_pedido->fecha_creacion));
        $order->shippingMethod = 'No Aplica';
        $order->totalPrice = number_format($info_pedido->total * 100, 0, '', '');;
        $order->currency = 'MXN';
        $order->connectionid = $connectionid;
        $order->customerid = $customerid;

        if(!$error) {
            $res = $this->client->request('POST', $this->get_active_url_v3().'/ecomOrders', [
                'headers' => [
                    'Api-Token' => $this->get_active_key(),
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'ecomOrder' => $order
                ]
            ]);

            return true;
        } else {
            return false;
        }
    }

    // Función para actualizar un pedido de deep data integration
    public function actualizar_pedido($id_pedido /* id de active */, $info_pedido, $productos_pedido)
    {
        $CI =& get_instance();

        $error = false;
        $order = new stdClass();
        if(isset($info_pedido->id_pedido)) {
            $order->orderNumber = $info_pedido->id_pedido;
        } else {
            $error = true;
        }

        if(sizeof($productos_pedido) > 0) {
            $order->orderProducts = array();

            foreach($productos_pedido as $producto) {
                if($producto->id_enhance) {
                    $info_enhanced = $CI->catalogo_modelo->obtener_enhanced_con_id($producto->id_enhance);
					if(!isset($info_enhanced->name)) {
						$nombre_producto = 'Producto vencido';
						$id_producto = $producto->id_enhance;
					} else {
						$nombre_producto = $info_enhanced->name;
						$id_producto = $info_enhanced->id_enhance;
					}
                    $categoria = 'Producto en venta';
                } else {
                    $nombre_producto = $producto->nombre_producto.' personalizada';
                    $id_producto = $producto->id_producto;
                    $categoria = 'Producto personalizado';
                }

                $new_prod = new stdClass();
                $new_prod->externalid = $id_producto;
                $new_prod->name = $nombre_producto;
                $new_prod->price = number_format($producto->precio_producto * 100, 0, '', '');
                $new_prod->quantity = $producto->cantidad_producto;
                $new_prod->category = $categoria;

                array_push($order->orderProducts, $new_prod);
            }
        } else {
            $error = true;
        }

        $order->orderDate = date("c", strtotime($info_pedido->fecha_creacion));
        $order->shippingMethod = 'DHL Express';
        $order->totalPrice = number_format($info_pedido->total * 100, 0, '', '');;
        $order->currency = 'MXN';

        if(!$error) {
            $res = $this->client->request('PUT', $this->get_active_url_v3().'/ecomOrders/'.$id_pedido, [
                'headers' => [
                    'Api-Token' => $this->get_active_key(),
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'ecomOrder' => $order
                ]
            ]);

            return true;
        } else {
            return false;
        }
    }

    // Función para obtener todos los pedidos de ecommerce
    public function obtener_pedidos($filters = array('email' => '', 'externalid' => '', 'connectionid' => ''))
    {
        $filter_string = array();
        if(isset($filters['email'])) {
            if($filters['email'] != '') {
                $filter_string[] = 'filters[email]='.$filters['email'];
            }
        }
        if(isset($filters['externalid'])) {
            if($filters['externalid'] != '') {
                $filter_string[] = 'filters[externalid]='.$filters['externalid'];
            }
        }
        if(isset($filters['connectionid'])) {
            if($filters['connectionid'] != '') {
                $filter_string[] = 'filters[connectionid]='.$filters['connectionid'];
            }
        }

        $filtro = implode("&", $filter_string);

        $res = $this->client->request('GET', $this->get_active_url_v3().'/ecomOrders'.($filtro != '' ? '?'.$filtro : ''), [
            'headers' => [
                'Api-Token' => $this->get_active_key()
            ]
        ]);

        $pedidos = json_decode($res->getBody());

        return $pedidos;
    }

    // Función para obtener un pedido de ecommerce con id
    public function obtener_pedido($id_pedido)
    {
        $res = $this->client->request('GET', $this->get_active_url_v3().'/ecomOrders/'.$id_pedido, [
            'headers' => [
                'Api-Token' => $this->get_active_key()
            ]
        ]);

        $pedido_temp = json_decode($res->getBody());
        $pedido = $pedido_temp->ecomOrder;

        return $pedido;
    }

    // Función para borrar un pedido especifico
    public function borrar_pedido($id_pedido)
    {
        $res = $this->client->request('DELETE', $this->get_active_url_v3().'/ecomOrders/'.$id_pedido, [
            'headers' => [
                'Api-Token' => $this->get_active_key()
            ]
        ]);

        return true;
    }


	public function obtener_contacto($filters = array('email' => ''), $limit = 100, $offset = 0)
    {
        $filter_string = array();
        if(isset($filters['email'])) {
            if($filters['email'] != '') {
                $filter_string[] = 'filters[email]='.$filters['email'];
            }
        }
        if(isset($filters['externalid'])) {
            if($filters['externalid'] != '') {
                $filter_string[] = 'filters[externalid]='.$filters['externalid'];
            }
        }
        if(isset($filters['connectionid'])) {
            if($filters['connectionid'] != '') {
                $filter_string[] = 'filters[connectionid]='.$filters['connectionid'];
            }
        }

        $filtro = implode("&", $filter_string);

        $res = $this->client->request('GET', $this->get_active_url_v3().'/contacts?limit='.$limit.'&offset='.$offset.($filtro != '' ? '&'.$filtro : ''), [
            'headers' => [
                'Api-Token' => $this->get_active_key()
            ]
        ]);

        $clientes = json_decode($res->getBody());

        return $clientes;
    }

    public function actualizar_campo_personalizado_cliente($id_contacto, $id_campo, $valor)
    {
        $error = false;
        if(!$id_contacto) {
            $error = true;
        }
        if(!$id_campo) {
            $error = true;
        }
        if(!$valor) {
            $error = true;
        }

        if(!$error) {

            $info_campo = new stdClass();
            $info_campo->contact = $id_contacto;
            $info_campo->field = $id_campo;
            $info_campo->value = $valor;

            $res = $this->client->request('POST', $this->get_active_url_v3().'/fieldValues', [
                'headers' => [
                    'Api-Token' => $this->get_active_key(),
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'fieldValue' => $info_campo
                ]
            ]);

            return json_decode($res->getBody());
        } else {
            return false;
        }
    }



    // Setters y getters
    public function get_active_url()
    {
        return $this->active_url;
    }

    public function set_active_url($active_url)
    {
        $this->active_url = $active_url;
    }

    public function get_active_url_v3()
    {
        return $this->active_url;
    }

    public function set_active_url_v3($active_url_v3)
    {
        $this->active_url_v3 = $active_url_v3;
    }

    public function get_active_key()
    {
        return $this->active_key;
    }

    public function set_active_key($active_key)
    {
        $this->active_key = $active_key;
    }
}
