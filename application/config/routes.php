<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'inicio';
$route['404_override'] = 'inicio/error_404';
$route['translate_uri_dashes'] = FALSE;

$route['sitemap.xml'] = 'cron/sitemap';

$route['heyyou'] = 'activetest/index';

//$route['tests-diseno/(:num)'] = 'testsfabric/index/$1';
//$route['tests-paypal'] = 'testsfabric/test_paypal';
//$route['tests-diseno'] = 'testsfabric/index/13';
//$route['tests-diseno/generar-imagen'] = 'testsfabric/generar_imagen';
//$route['tests-diseno/obtener-colores-imagen'] = 'testsfabric/obtener_colores_imagen';
//$route['tests-diseno/info'] = 'testsfabric/info';
//$route['tests-diseno/obtener-fuentes'] = 'testsfabric/obtener_fuentes';
//$route['tests-diseno/guardar'] = 'testsfabric/guardar';

// Relativos a secciones de texto
$route['dudas'] = 'inicio/ayuda';
$route['faqs'] = 'inicio/faqs';
$route['terminos-y-condiciones'] = 'inicio/terminos';
$route['testimonios'] = 'inicio/testimonios';
$route['testimonios/nuevo'] = 'inicio/nuevo_testimonio';
$route['testimonios/pagina/(:num)']='inicio/testimonios/$1';
$route['testimonios/nuevo/procesar'] = 'inicio/nuevo_testimonio_procesar';
$route['testimonios/nuevo/respuesta'] = 'inicio/nueva_respuesta_usuario';
$route['testimonios/responder/(:any)/(:num)/(:any)'] = 'inicio/respuesta_usuario/$1/$2/$3';
$route['testimonios/link_expirado'] = 'inicio/respuesta_expirado';
$route['testimonios/recibido'] = 'inicio/testimonio_recibido';
$route['politicas-de-compra'] = 'inicio/politicas';
$route['aviso-de-privacidad'] = 'inicio/aviso';
$route['tienda/(:any)/terminos-y-condiciones'] = 'tienda/terminos/$1';
$route['tienda/(:any)/politicas-de-compra'] = 'tienda/politicas/$1';
$route['tienda/(:any)/aviso-de-privacidad'] = 'tienda/aviso/$1';
$route['tienda/(:any)/cerrar-sesion'] = 'tienda/cerrar_sesion/$1';
$route['cargo-extra-expirado'] = 'inicio/cargo_extra_expirado';

$route['respuesta/nueva'] = 'inicio/error_404';

// Relativos a carrito
$route['carrito'] = 'ncarrito/index';
$route['carrito/error-pago'] = 'carrito/error';
$route['carrito/actualizar'] = 'ncarrito/actualizar';
$route['carrito/vaciar'] = 'ncarrito/vaciar';
$route['carrito/vacio'] = 'ncarrito/index';
$route['carrito/reordenar/(:num)'] = 'ncarrito/reordenar/$1';
$route['carrito/cambiar-direccion-dinamico'] = 'ncarrito/cambiar_direccion_dinamico';
$route['carrito/finalizar-pago-paypal'] = 'ncarrito/finalizar_pago_paypal';
//$route['carrito/pedido-completado-(paypal|oxxo|tarjeta)'] = 'carrito/pedido_completado/$1';

// Nuevas rutas carrito
$route['carrito/seleccionar-direccion'] = 'ncarrito/direccion';
$route['carrito/sesion-direccion'] = 'ncarrito/sesion_direccion';
$route['carrito/procesar-direccion'] = 'ncarrito/procesar_direccion';
$route['carrito/pagar'] = 'ncarrito/pagar';
$route['carrito/pagar-(tarjeta|oxxo|paypal|spei|saldo)'] = 'ncarrito/pagar_$1';
$route['carrito/pagar-stripe/(:any)'] = 'ncarrito/pagar_stripe/$1';
$route['carrito/pagar/error-pago-(tarjeta|oxxo|paypal|spei|saldo|stripe)'] = 'ncarrito/pagar';
$route['carrito/pedido-completado-(tarjeta|oxxo|paypal|spei|saldo|stripe)'] = 'ncarrito/pedido_completado/$1';
$route['carrito/terminar-paypal'] = 'ncarrito/terminar_paypal';
$route['carrito/obtener_datos_direccion'] = 'ncarrito/obtener_datos_direccion';
$route['carrito/generar-link-ppp'] = 'ncarrito/generar_link_ppp';
$route['carrito/post-total-ac'] = 'ncarrito/post_total_ac';
$route['carrito/actualizar-direccion-ac'] = 'ncarrito/sincronizar_direccion_ac';

$route['testa'] = 'ncarrito/probando';

// Relativos a registro
$route['iniciar-sesion'] = 'registro/iniciar_sesion';
$route['enviar-recuperacion'] = 'registro/enviar_recuperacion';
$route['restablecer-contrasena/(:any)'] = 'registro/restablecer_contrasena/$1';
$route['restablecer-contrasena/(:any)/procesar'] = 'registro/restablecer_contrasena_procesar/$1';
$route['registrar'] = 'registro/registrar';
$route['cerrar-sesion'] = 'registro/cerrar_sesion';
$route['verificar-cuenta/(:any)'] = 'registro/verificar_cuenta/$1';
$route['registro-campana'] = 'registro/registro_campana';
$route['registro-telefono-twilio'] = 'registro/verificar_telefono_twilio';
$route['registro-telefono-twilio-dos'] = 'registro/verificar_dos_telefonos_twilio';
$route['generar-cod/(:num)'] = 'registro/generar_codigo_emergencia/$1';

// Relativos a mi cuenta
$route['mi-cuenta/datos'] = 'cuenta/datos';
$route['mi-cuenta/cambiar_codigo_referencia'] = 'cuenta/cambiar_codigo_referencia';
$route['mi-cuenta/datos/actualizar'] = 'cuenta/actualizar_datos';
$route['mi-cuenta/tienda'] = 'cuenta/tienda';
$route['mi-cuenta/tienda/actualizar'] = 'cuenta/actualizar_datos_tienda';
$route['mi-cuenta/cambiar-contrasena'] = 'cuenta/cambiar_c';
$route['mi-cuenta/cambiar-contrasena/procesar'] = 'cuenta/cambiar_c_procesar';
$route['mi-cuenta/direcciones'] = 'cuenta/direcciones';
$route['mi-cuenta/direcciones/agregar'] = 'cuenta/agregar_direccion';
$route['mi-cuenta/direcciones/agregar/pagar'] = 'cuenta/agregar_direccion/pagar';
$route['mi-cuenta/direcciones/agregar/pagar/(:any)'] = 'cuenta/agregar_direccion/pagar/$1';
$route['mi-cuenta/direcciones/editar'] = 'cuenta/editar_direccion';
$route['mi-cuenta/direcciones/borrar'] = 'cuenta/borrar_direccion';
$route['mi-cuenta/facturacion'] = 'cuenta/facturacion';
$route['mi-cuenta/facturacion/agregar'] = 'cuenta/agregar_facturacion';
$route['mi-cuenta/facturacion/agregar/pagar'] = 'cuenta/agregar_facturacion/pagar';
$route['mi-cuenta/facturacion/agregar/pagar/(:any)'] = 'cuenta/agregar_facturacion/pagar/$1';
$route['mi-cuenta/facturacion/editar'] = 'cuenta/editar_facturacion';
$route['mi-cuenta/facturacion/borrar'] = 'cuenta/borrar_facturacion';
$route['mi-cuenta/datos-bancarios'] = 'cuenta/bancarios';
$route['mi-cuenta/datos-bancarios/actualizar'] = 'cuenta/bancarios_actualizar';
$route['mi-cuenta/pedidos'] = 'cuenta/pedidos';
$route['mi-cuenta/pedidos/(:num)'] = 'cuenta/pedidos/$1';
$route['mi-cuenta/solicitar-factura/(:num)'] = 'cuenta/solicitar_factura/$1';
$route['mi-cuenta/productos'] = 'cuenta/productos';
$route['mi-cuenta/productos-plazo-definido'] = 'cuenta/productos_plazo_definido';
$route['mi-cuenta/favoritos'] = 'cuenta/favoritos';
$route['mi-cuenta/favoritos/agregar/(:num)/(:num)'] = 'cuenta/agregar_favorito/$1/$2';
$route['mi-cuenta/favoritos/quitar/(:num)/(:num)'] = 'cuenta/quitar_favorito/$1/$2';
$route['mi-cuenta/obtener-inmediata'] = 'cuenta/obtener_inmediata';
$route['mi-cuenta/obtener-limitada'] = 'cuenta/obtener_limitada';
$route['mi-cuenta/puntos-printome'] = 'cuenta/puntos_printome';
$route['mi-cuenta/obtener-referencias-cliente'] = 'cuenta/obtener_referencias_cliente';


// Relativos a diseno
$route['personalizar'] = 'designer/design/13/20';
$route['personalizar/(:num)/(:num)'] = 'designer/design/$1/$2';
$route['personalizar/(:num)/(:num)/(:any)'] = 'designer/design/$1/$2/$3';

// Relativos a campañas
#$route['campanas'] = 'campanas/index';
#$route['campanas/sociales'] = 'campanas/index/social';
#$route['campanas/sociales/(:any)-(:num)'] = 'campanas/especifica/social/$2';
#$route['campanas/lucrativas'] = 'campanas/index/lucrativa';
#$route['campanas/lucrativas/(:any)-(:num)'] = 'campanas/especifica/lucrativa/$2';
$route['campanas/iniciar'] = 'campanas/iniciar';
$route['campanas/generar_otro_color'] = 'campanas/generar_otro_color';
$route['campanas/borrar_color_no_usado'] = 'campanas/borrar_color_no_usado';
$route['campanas/guardar'] = 'campanas/guardar';
$route['campanas/en-proceso'] = 'campanas/en_proceso';
$route['campanas/precio'] = 'campanas/precio';
$route['campanas/definir-metas'] = 'campanas/definir_metas';
$route['campanas/registrar-datos-deposito'] = 'campanas/registrar_datos_deposito';

$route['vende/iniciar'] = 'campanas/iniciar';
$route['vende/guardar'] = 'campanas/guardar';
$route['vende/en-proceso'] = 'campanas/en_proceso';
$route['vende/en-proceso-venta-inmediata'] = 'campanas/en_proceso';
$route['vende/en-proceso-plazo-definido'] = 'campanas/en_proceso';
$route['vende/precio'] = 'campanas/precio';
$route['vende/definir-metas'] = 'campanas/definir_metas';

//$route['asociaciones-civiles'] = 'vende/asociaciones';
//$route['asociaciones-civiles/contacto'] = 'vende/contacto_ac';

$route['servicios-de-diseno'] = 'vende/servicios';
$route['servicios-de-cotizacion'] = 'vende/cotiza';

$route['plantillas'] = 'plantillas/newindex';
$route['plantillas/(:any)'] = 'plantillas/newindex/$1/null/null/null/1';
$route['plantillas/(:any)/(:any)'] = 'plantillas/newindex/$1/$2/null/null/1';
$route['plantillas/(:any)/(:any)/pagina/(:num)'] = 'plantillas/newindex/$1/$2/null/null/$3';
$route['plantillas/(:any)/(:any)/(:any)'] = 'plantillas/newindex/$1/$2/$3/null/1';
$route['plantillas/(:any)/(:any)/(:any)/pagina/(:num)'] = 'plantillas/newindex/$1/$2/$3/null/$4';
$route['plantillas/(:any)/(:any)/(:any)/(:any)'] = 'plantillas/newindex/$1/$2/$3/$4/1';
$route['plantillas/(:any)/(:any)/(:any)/(:any)/pagina/(:num)'] = 'plantillas/newindex/$1/$2/$3/$4/$5';

/*$route['plantillas'] = 'plantillas/index';
$route['plantillas/(:any)'] = 'plantillas/index/$1';
$route['plantillas/(:any)/(:any)'] = 'plantillas/index/$1/$2';
$route['plantillas/(:any)/(:any)/(:any)'] = 'plantillas/index/$1/$2/$3';*/

$route['compra'] = 'campanas/index/null/1';
$route['compra/pagina'] = 'campanas/index/null/1';
$route['compra/pagina/(:num)'] = 'campanas/index/null/$1';

// campanas/index ($tipo_campana, $start, $offset, $random_seed, $categoria_slug, $id_campana)
$route['compra/venta-inmediata'] = 'campanas/index/fijo/1';
$route['compra/venta-inmediata/pagina/(:num)'] = 'campanas/index/fijo/$1';
$route['compra/venta-inmediata/(:any)-(:num)'] = 'campanas/especifica/fijo/$2';

$route['compra/plazo-definido'] = 'campanas/index/limitado/1';
$route['compra/plazo-definido/pagina/(:num)'] = 'campanas/index/limitado/$1';
$route['compra/plazo-definido/(:any)-(:num)'] = 'campanas/especifica/limitado/$2';

$route['tienda/(:num)/(:any)'] = 'tienda/index/$1/$2/null/1';
$route['tienda/(:any)/(:any)/pagina'] = 'tienda/index/$1/$2/$3/null/1';
$route['tienda/(:any)/(:any)/pagina/(:num)'] = 'tienda/index/$1/$2/null/$3';
$route['tienda/(:any)/(:any)/plazo-definido'] = 'tienda/index/$1/$2/limitado/1';
$route['tienda/(:any)/(:any)/plazo-definido/pagina'] = 'tienda/index/$1/$2/limitado/1';
$route['tienda/(:any)/(:any)/plazo-definido/pagina/(:num)'] = 'tienda/index/$1/$2/limitado/$3';
$route['tienda/(:any)/(:any)/venta-inmediata'] = 'tienda/index/$1/$2/fijo/1';
$route['tienda/(:any)/(:any)/venta-inmediata/pagina'] = 'tienda/index/$1/$2/fijo/1';
$route['tienda/(:any)/(:any)/venta-inmediata/pagina/(:num)'] = 'tienda/index/$1/$2/fijo/$3';
$route['tienda/(:any)/plazo-definido/(:any)-(:num)'] = 'tienda/especifica/$1/limitado/$3';
$route['tienda/(:any)/venta-inmediata/(:any)-(:num)'] = 'tienda/especifica/$1/fijo/$3';

$route['tienda/(:any)/carrito'] = 'ncarrito/index/$1';
$route['tienda/(:any)/carrito/vacio'] = 'ncarrito/index/$1';
$route['tienda/(:any)/carrito/agregar'] = 'carrito/agregar/$1';
$route['tienda/(:any)/carrito/actualizar'] = 'ncarrito/actualizar/$1';
$route['tienda/(:any)/carrito/vaciar'] = 'ncarrito/vaciar/$1';
$route['tienda/(:any)/carrito/quitar/(:any)'] = 'carrito/quitar/$2/$1';

$route['tienda/(:any)/carrito/seleccionar-direccion'] = 'ncarrito/direccion/$1';
$route['tienda/(:any)/carrito/sesion-direccion'] = 'ncarrito/sesion_direccion/$1';
$route['tienda/(:any)/carrito/procesar-direccion'] = 'ncarrito/procesar_direccion/$1';
$route['tienda/(:any)/carrito/pagar'] = 'ncarrito/pagar/$1';
$route['tienda/(:any)/carrito/pagar-(tarjeta|oxxo|paypal|spei|saldo)'] = 'ncarrito/pagar_$2/$1';
$route['tienda/(:any)/carrito/pagar-stripe/(:any)'] = 'ncarrito/pagar_stripe/$2/$1';
$route['tienda/(:any)/carrito/pagar/error-pago-(tarjeta|oxxo|paypal|spei|saldo|stripe)'] = 'ncarrito/pagar/$1';
$route['tienda/(:any)/carrito/pedido-completado-(tarjeta|oxxo|paypal|spei|saldo|stripe)'] = 'ncarrito/pedido_completado/$2/$1';
$route['tienda/(:any)/carrito/terminar-paypal'] = 'ncarrito/terminar_paypal/$1';

//$route['tienda/(:any)/carrito/borrar_custom_en_carrito/(:any)/(:any)'] = 'tienda_carrito/borrar_custom_en_carrito/$2/$3/$1';
//$route['tienda/(:any)/carrito/pagar'] = 'tienda_carrito/pagar/$1';
//$route['tienda/(:any)/carrito/generar_link_paypal'] = 'tienda_carrito/generar_link_paypal/$1';
//$route['tienda/(:any)/carrito/terminar_paypal'] = 'tienda_carrito/terminar_paypal/$1';
//$route['tienda/(:any)/carrito/terminar'] = 'tienda_carrito/terminar/$1';
//$route['tienda/(:any)/carrito/error-pago'] = 'tienda_carrito/error/$1';
//$route['tienda/(:any)/carrito/pedido-completado-(paypal|oxxo|tarjeta)'] = 'tienda_carrito/pedido_completado/$2/$1';
//$route['tienda/(:any)/carrito/pdf_oxxo/(:num)'] = 'tienda_carrito/pdf_oxxo/$2/$1';
//$route['tienda/(:any)/carrito/pdf_oxxo_archivo/(:num)'] = 'tienda_carrito/pdf_oxxo_archivo/$2/$1';
//$route['tienda/(:any)/carrito/pdf_pedido_archivo/(:num)'] = 'tienda_carrito/pdf_pedido_archivo/$2/$1';
//$route['tienda/(:any)/carrito/pdf_pedido/(:num)'] = 'tienda_carrito/pdf_pedido/$2/$1';

//$route['tienda/(:any)/carrito/seleccionar-direccion'] = 'tienda_carrito/direccion/$1';
//$route['tienda/(:any)/carrito/sesion-direccion'] = 'tienda_carrito/sesion_direccion/$1';
//$route['tienda/(:any)/carrito/procesar-direccion'] = 'tienda_carrito/procesar_direccion/$1';
//
$route['feed.json'] = 'feed/json_feed';
$route['feed/(:any)'] = 'feed/tienda/$1';

$route['ajax/colors'] = 'ajax/colors';
$route['ajax/fonts'] = 'ajax/fonts';
$route['ajax/upload'] = 'ajax/upload';


$route['catalogo/contacto'] = 'catalogo/contacto';
// Relativos a catalogo
$route['(?!dhltest|cargos|assets|administracion|activetest|listener|testimonios|cron|promociones|contacto|carrito|cron|inicio|configurar|art|registro|example|designer|tienda|ac)(:any)/(:any)'] = 'catalogo/index/$1/$2';
//$route['(?!administracion|promociones|contacto|carrito)(:any)/(:any)'] = 'catalogo/categoria/$1/$2';
$route['(?!dhltest|cargos|assets|administracion|activetest|listener|testimonios|cron|promociones|contacto|carrito|cron|inicio|configurar|art|registro|example|designer|tienda|ac)(:any)/(:any)/(:any)-(:num)'] = 'catalogo/producto/$1/$2/$4';


//Administracion
$route['administracion/login'] = 'administracion/login/index';

$route['administracion'] = 'administracion/categorias';

$route['administracion/migrar'] = 'administracion/migrar/index/';

$route['administracion/media/modals/(:any)/(:any)'] = 'administracion/media/modals/$1/$2';

/** Proveedores **/
$route['administracion/proveedores'] = 'administracion/proveedores/index';
$route['administracion/proveedores/add'] = 'administracion/proveedores/add';
$route['administracion/proveedores/submit_data'] = 'administracion/proveedores/submit_data';
$route['administracion/proveedore/sale_graph'] = 'administracion/proveedores/sale_graph';
$route['administracion/proveedores/(:any)'] = 'administracion/proveedores/edit/$1';
$route['administracion/orderupdate'] = 'administracion/orderapi/push_orders';
$route['administracion/order_cancel'] = 'administracion/orderapi/cencel_order';
$route['administracion/productos/clientes'] = 'administracion/productos/clientes';
$route['administracion/shopify-cargos-extra/agregar-nuevo-cargo'] = 'administracion/shopifycargos/agregar_nuevo_cargo';
/** Fin proveedores**/

$route['administracion/media/upload'] = 'administracion/media/upload';
$route['administracion/media/add'] = 'administracion/media/add';
$route['administracion/media/remove'] = 'administracion/media/remove';
$route['administracion/media/rename'] = 'administracion/media/rename';
$route['administracion/media/folder/(:any)'] = 'administracion/media/folder/$1';
$route['administracion/media/fileRemove'] = 'administracion/media/fileRemove';
$route['administracion/media/fileFename'] = 'administracion/media/fileFename';

$exclude = 'estatus|diseno|principal-fotografia|borrar-fotografia|estatus-color|estatus-sku|ajax-caracteristicas';


$route['administracion/productos'] = 'administracion/productos/index';
$route['administracion/productos/(?!'.$exclude.')(:any)'] = 'administracion/productos/index/$1';
$route['administracion/productos/(?!'.$exclude.')(:any)/(:any)'] = 'administracion/productos/index/$1/$2';
$route['administracion/productos/(?!'.$exclude.')(:any)/(:any)/agregar-producto'] = 'administracion/productos/agregar/$1/$2';
$route['administracion/productos/(?!'.$exclude.')(:any)/(:any)/agregar-producto/procesar'] = 'administracion/productos/agregar_procesar/$1/$2';
$route['administracion/productos/(?!'.$exclude.')(:any)/(:any)/modificar-producto/(:num)'] = 'administracion/productos/modificar/$1/$2/$3';
$route['administracion/productos/(?!'.$exclude.')(:any)/(:any)/modificar-producto/(:num)/procesar'] = 'administracion/productos/modificar_procesar/$1/$2/$3';
$route['administracion/productos/(?!'.$exclude.')(:any)/(:any)/borrar-producto'] = 'administracion/productos/borrar/$1/$2';

$route['administracion/productos/estatus'] = 'administracion/productos/estatus';
$route['administracion/productos/diseno'] = 'administracion/productos/diseno';
$route['administracion/productos/principal-fotografia'] = 'administracion/productos/principal_fotografia';
$route['administracion/productos/borrar-fotografia'] = 'administracion/productos/borrar_fotografia';
$route['administracion/productos/estatus-color'] = 'administracion/productos/estatus_color';
$route['administracion/productos/estatus-sku'] = 'administracion/productos/estatus_sku';
$route['administracion/productos/ajax-caracteristicas'] = 'administracion/productos/caracteristicas_ajax';

$route['administracion/campanas/(fijo|limitado)'] = 'administracion/campanas/index/$1';
$route['administracion/campanas/(fijo|limitado)/post-to-shopify/(:num)'] = 'administracion/campanas/post_shopify/$1/$2';
$route['administracion/campanas/(fijo|limitado)/editar/(:num)'] = 'administracion/campanas/editar/$1/$2';
$route['administracion/campanas/(fijo|limitado)/aprobar/(:num)'] = 'administracion/campanas/aprobar/$1/$2';
$route['administracion/campanas/(fijo|limitado)/borrar/(:num)'] = 'administracion/campanas/borrar/$1/$2';
$route['administracion/campanas/(fijo|limitado)/terminar/(:num)'] = 'administracion/campanas/terminar/$1/$2';
$route['administracion/campanas/(fijo|limitado)/rechazar/(:num)'] = 'administracion/campanas/rechazar/$1/$2';
$route['administracion/campanas/(fijo|limitado)/producir/(:num)'] = 'administracion/campanas/producir/$1/$2';
$route['administracion/campanas/(fijo|limitado)/no_producir/(:num)'] = 'administracion/campanas/no_producir/$1/$2';
$route['administracion/campanas/limitado/asignar_pago/(:num)'] = 'administracion/campanas/asignar_pago_limitado/$1';
$route['administracion/campanas/fijo/asignar_pago/(:num)'] = 'administracion/campanas/asignar_pago_fijo/$1';
$route['administracion/campanas/(fijo|limitado)/pdf_produccion/(:num)'] = 'administracion/campanas/pdf_pedido_produccion/$1/$2';
$route['administracion/campanas/(fijo|limitado)/editar/(:num)/pedidos/(:num)'] = 'administracion/campanas/pedido_especifico/$1/$2/$3';
$route['administracion/campanas/(fijo|limitado)/editar/(:num)/pedidos/(:num)/asignar_guia'] = 'administracion/campanas/asignar_guia_limitado/$1/$2/$3';
$route['administracion/campanas/(fijo|limitado)/actualizar_clasificacion/(:num)'] = 'administracion/campanas/actualizar_clasificacion/$1/$2';
$route['administracion/campanas/(fijo|limitado)/actualizar_descripcion/(:num)'] = 'administracion/campanas/actualizar_descripcion/$1/$2';
$route['administracion/campanas/(fijo|limitado)/actualizar_etiquetas/(:num)'] = 'administracion/campanas/actualizar_etiquetas/$1/$2';
$route['administracion/campanas/(fijo|limitado)/disfrazar_ventas/(:num)'] = 'administracion/campanas/disfrazar_ventas/$1/$2';
$route['administracion/campanas/(fijo|limitado)/cambiar_nombre_campana/(:num)'] = 'administracion/campanas/cambiar_nombre_campana/$1/$2';

$route['administracion/campanas/limitado/pdf_comprobante/(:num)/(:num)'] = 'administracion/campanas/pdf_comprobante_limitado/$1/$2';
$route['administracion/campanas/fijo/pdf_comprobante/(:num)/(:num)'] = 'administracion/campanas/pdf_comprobante_fijo/$1/$2';

$route['administracion/campanas/(fijo|limitado)/(activos|aprobar|pagar|pagados|ceros|negativos|rechazados)'] = 'administracion/campanas/index/$1/$2';

/* $route['administracion/productos/(?!diseno)(:any)'] = 'administracion/productos/index/$1';
$route['administracion/productos/(:any)/agregar-producto'] = 'administracion/productos/agregar/$1';
$route['administracion/productos/(:any)/agregar-producto/procesar'] = 'administracion/productos/agregar_procesar/$1';

$route['administracion/productos/(:any)/modificar-producto/(:num)'] = 'administracion/productos/modificar/$1/$2';
$route['administracion/productos/(:any)/modificar-producto/(:num)/procesar'] = 'administracion/productos/modificar_procesar/$1/$2';

$route['administracion/productos/(:any)/borrar-producto'] = 'administracion/productos/borrar/$1';
$route['administracion/productos/estatus'] = 'administracion/productos/estatus';
$route['administracion/productos/diseno'] = 'administracion/productos/diseno';
$route['administracion/productos/principal-fotografia'] = 'administracion/productos/principal_fotografia';
$route['administracion/productos/borrar-fotografia'] = 'administracion/productos/borrar_fotografia';
$route['administracion/productos/estatus-color'] = 'administracion/productos/estatus_color';
$route['administracion/productos/estatus-sku'] = 'administracion/productos/estatus_sku';
$route['administracion/productos/ajax-caracteristicas'] = 'administracion/productos/caracteristicas_ajax'; */

$route['administracion/pedidos/(:num)'] = 'administracion/pedidos/pedido_especifico/$1';
$route['administracion/pedidos/(:num)/pdf'] = 'administracion/pedidos/pdf_pedido/$1';
$route['administracion/pedidos/(:num)/cambiar_guia'] = 'administracion/pedidos/actualizar_guia/$1';
$route['administracion/pedidos/(:num)/dhl'] = 'administracion/pedidos/abrir_dhl/$1';
$route['administracion/pedidos/(:num)/cambiar_estatus_pedido'] = 'administracion/pedidos/cambiar_estatus_pedido/$1';
$route['administracion/pedidos/desplegar-pedidos'] = 'administracion/pedidos/desplegar_pedidos';

$route['administracion/devoluciones'] = 'administracion/devoluciones/index';
$route['administracion/devoluciones/(:num)'] = 'administracion/devoluciones/devolucion/$1';
$route['administracion/devoluciones/(:num)/actualizar'] = 'administracion/devoluciones/actualizar/$1';

$route['administracion/marcas/agregar-marca'] = 'administracion/marcas/agregar';
$route['administracion/marcas/editar-marca'] = 'administracion/marcas/modificar';
$route['administracion/marcas/borrar-marca'] = 'administracion/marcas/borrar';

$route['administracion/tipos'] = 'administracion/tipos/index';
$route['administracion/tipos/(:any)'] = 'administracion/tipos/index/$1';

$route['administracion/tipos/(:any)/agregar-tipo'] = 'administracion/tipos/agregar/$1';
$route['administracion/tipos/(:any)/editar-tipo'] = 'administracion/tipos/modificar/$1';
$route['administracion/tipos/(:any)/borrar-tipo'] = 'administracion/tipos/borrar/$1';
$route['administracion/tipos/reordenar_lados/(:num)'] = 'administracion/tipos/reordenar_lados/$1';

$route['administracion/caracteristicas/(:any)/agregar'] = 'administracion/caracteristicas/agregar/$1';
$route['administracion/caracteristicas/(:any)/editar'] = 'administracion/caracteristicas/editar/$1';

$route['administracion/caracteristicas/(:any)/agregar_sub'] = 'administracion/caracteristicas/agregar_sub/$1';
$route['administracion/caracteristicas/(:any)/editar_sub'] = 'administracion/caracteristicas/editar_sub/$1';
$route['administracion/caracteristicas/(:any)/borrar'] = 'administracion/caracteristicas/borrar/$1';

$route['administracion/cupones/agregar-cupon'] = 'administracion/cupones/agregar';
$route['administracion/cupones/editar-cupon'] = 'administracion/cupones/modificar';
$route['administracion/cupones/borrar-cupon'] = 'administracion/cupones/borrar';

$route['administracion/vectores'] = 'administracion/vectores/index';
$route['administracion/vectores/agregar_categoria'] = 'administracion/vectores/agregar_categoria';
$route['administracion/vectores/estatus'] = 'administracion/vectores/estatus';
$route['administracion/vectores/modificar'] = 'administracion/vectores/modificar';
$route['administracion/vectores/(:any)'] = 'administracion/vectores/index/$1';
$route['administracion/vectores/(:any)/agregar_vectores'] = 'administracion/vectores/agregar_vectores/$1';
$route['administracion/vectores/(:any)/borrar_vector/(:num)'] = 'administracion/vectores/borrar_vector/$1/$2';

$route['administracion/tiendas'] = 'administracion/tiendas/index';
$route['administracion/tiendas/desplegar-tiendas'] = 'administracion/tiendas/desplegar_tiendas';
$route['administracion/tiendas/(:num)'] = 'administracion/tiendas/tienda/$1';
$route['administracion/tiendas/(:num)/(fijo|limitado)'] = 'administracion/tiendas/tienda/$1/$2';
$route['administracion/tiendas/desplegar-especifico/(fijo|limitado)/(:num)'] = 'administracion/tiendas/desplegar_especifico/$1/$2';

$route['administracion/plantillas'] = 'administracion/plantillas/index';
$route['administracion/plantillas/activas'] = 'administracion/plantillas/index/activas';
$route['administracion/plantillas/activas/(:num)'] = 'administracion/plantillas/index/activas/$1';
$route['administracion/plantillas/activas/(:num)/(:num)'] = 'administracion/plantillas/index/activas/$1/$2';
$route['administracion/plantillas/activas/(:num)/(:num)/(:num)'] = 'administracion/plantillas/index/activas/$1/$2/$3';

$route['administracion/testimonios/aprobar/(:num)'] = 'administracion/testimonios/aprobar/$1';
$route['administracion/testimonios/borrar/(:num)'] = 'administracion/testimonios/borrar/$1';

$route['administracion/respuestas/(:num)'] = 'administracion/respuestas/index/$1';
$route['administracion/respuestas/responder/'] = 'administracion/respuestas/responder/';

$route['administracion/cargos_extra'] = 'administracion/cargos';
$route['administracion/cargos-extra/verificar'] = 'administracion/cargos/verificar_usuario';
$route['administracion/cargos-extra/existe-shopify'] = 'administracion/cargos/existe_shopify';
$route['administracion/cargos-extra/agregar-nuevo-cargo'] = 'administracion/cargos/agregar_nuevo_cargo';
$route['cargos-extra/pagar/(:any)/(:num)/(:any)/(:any)'] = 'inicio/cargos_extra/$1/$2/$3/$4';
$route['cargos/pagar-tarjeta'] = 'inicio/pagar_tarjeta';
$route['cargos/error-tarjeta/(:any)/(:num)/(:any)/(:any)'] = 'inicio/cargos_extra/$1/$2/$3/$4';
$route['cargo-completado-tarjeta'] = 'inicio/cargo_extra_pagado';
$route['administracion/cargos/desplegar-cargos'] = 'administracion/cargos/desplegar_cargos';
$route['administracion/puntos'] = 'administracion/puntos';

$route['administracion/slider/agregar-nuevo-banner'] = 'administracion/slider/agregar_nuevo_banner';
$route['administracion/slider/editar-banner'] = 'administracion/slider/editar_banner';
$route['administracion/slider/borrar-banner'] = 'administracion/slider/borrar_banner';

$route['administracion/slider/agregar-nuevo-comprar'] = 'administracion/slider/agregar_nuevo_comprar';
$route['administracion/slider/editar-comprar'] = 'administracion/slider/editar_comprar';
$route['administracion/slider/borrar-comprar'] = 'administracion/slider/borrar_comprar';

$route['administracion/destacadosinicio/agregar-nuevo-creador'] = 'administracion/destacadosinicio/agregar_nuevo_creador';
$route['administracion/destacadosinicio/editar-creador'] = 'administracion/destacadosinicio/editar_creador';
$route['administracion/destacadosinicio/borrar-creador'] = 'administracion/destacadosinicio/borrar_creador';

$route['administracion/wowwinners/desplegar-campanas'] = 'administracion/wowwinners/desplegar_campanas';

$route['administracion/masvendidos/agregar-nuevo'] = 'administracion/masvendidos/agregar_nuevo';
$route['administracion/masvendidos/editar'] = 'administracion/masvendidos/editar';
$route['administracion/masvendidos/borrarr'] = 'administracion/masvendidos/borrar';

$route['tiendas'] = 'tiendas/index/0/null/null/1';
$route['tiendas/(:num)/(:any)']='tiendas/index/$1/$2/null/1';
$route['tiendas/(:num)/(:any)/(:any)']='tiendas/index/$1/$2/$3/1';
$route['tiendas/pagina/(:num)/(:any)/(:any)/(:num)']='tiendas/index/$1/$2/$3/$4';
