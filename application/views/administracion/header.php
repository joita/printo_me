<?php
	$secci = $seccion_activa;
	if($secci == 'enhance') {
		$secci = 'campanas';
	}
	if(!in_array($secci, $this->session->admin['privilegios'])) {
		redirect('administracion/'.$this->session->admin['privilegios'][0]);
	}
?><?php echo doctype('html5'); ?>
<html class="no-js" lang="es">
	<head>
		<?php echo meta('charset', 'utf-8'); ?>
		<?php echo meta('viewport', 'width=device-width, initial-scale=1.0'); ?>

		<title>Administración</title>
		<?php echo meta('description', 'Panel de administración de Print-o-Me .'); ?>

		<?php echo link_tag(array('href' => current_url(), 'rel' => 'canonical')); ?>

        <?php echo link_tag('assets/css/normalize.css'); ?>
        <?php echo link_tag('assets/css/general.css'); ?>
		<?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'); ?>
		<?php echo link_tag('assets/css/jquery.qtip.min.css'); ?>
		<?php echo link_tag('assets/css/foundation.css'); ?>
        <?php echo link_tag('assets/js/tiny-autocomplete/tiny-autocomplete.css')?>
		<?php echo link_tag('assets/css/admin.css?v='.time()); ?>
		<?php echo link_tag('assets/js/spectrum/spectrum.css'); ?>
		<?php echo link_tag('bower_components/datatables.net-dt/css/jquery.dataTables.min.css'); ?>
		<?php echo link_tag('bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css'); ?>
		<?php echo link_tag('bower_components/pickadate/lib/themes/default.css'); ?>
		<?php echo link_tag('bower_components/pickadate/lib/themes/default.date.css'); ?>
		<?php echo link_tag('bower_components/jquery.tagsinput/dist/jquery.tagsinput.min.css'); ?>
        <?php echo link_tag('bower_components/jquery-bar-rating/dist/themes/fontawesome-stars.css');?>

		<?php echo link_tag(array('href' => 'assets/images/icon.png', 'rel' => 'shortcut icon')); ?>

		<script src="<?php echo site_url('assets/js/vendor/jquery/2.1.3/jquery.min.js'); ?>"></script>
		<script src="<?php echo site_url('assets/js/vendor/jquery-migrate/1.2.1/jquery-migrate.min.js'); ?>"></script>
		<script src="<?php echo site_url('assets/js/vendor/modernizr.js'); ?>"></script>
		<script src="<?php echo site_url('bower_components/canvg/dist/canvg.bundle.min.js'); ?>"></script>
		<script src="<?php echo site_url('bower_components/webfontloader/webfontloader.js'); ?>"></script>
		<script src="<?php echo site_url('assets/js/tinymce/tinymce.min.js'); ?>"></script>
        <script src="<?php echo site_url('bower_components/jquery-bar-rating/dist/jquery.barrating.min.js');?>"></script>


		<!--[if lt IE 9]>
		<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
		<script src="//s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.5-min.js"></script>
		<script src="//html5base.googlecode.com/svn-history/r38/trunk/js/selectivizr-1.0.3b.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>

	<div id="wrapper">
		<div class="row collapse" data-equalizer>
			<div class="small-5 columns" id="nav">
				<div class="row">
					<div class="small-24 columns">
						<h1 id="logo" class="text-center"><img src="<?php echo site_url('assets/images/footer-logo.png'); ?>" /></h1>
					</div>
				</div>
				<div class="row collapse">
					<nav>
						<ul class="accordion side-nav" id="menu" data-accordion>
                            <li><a href="<?php echo site_url('administracion/pedidos'); ?>"<?php activar($secci, 'pedidos'); ?>><i class="fa fa-credit-card"></i> Pedidos</a></li>
                            <li><a href="<?php echo site_url('administracion/tiendas'); ?>"<?php activar($secci, 'tiendas'); ?>><i class="fa fa-building-o"></i> Tiendas</a></li>
                            <li><a href="<?php echo site_url('administracion/reportes'); ?>"<?php activar($secci, 'reportes'); ?>><i class="fa fa-line-chart"></i> Reportes</a></li>
                            <li><a href="<?php echo site_url('administracion/cotizador'); ?>"<?php activar($secci, 'cotizador'); ?>><i class="fa fa-table"></i> Tabla de cotizador</a></li>
                            <li><a href="<?php echo site_url('administracion/proveedores'); ?>"<?php activar($secci, 'proveedores'); ?>><i class="fa fa-industry"></i> Proveedores</a></li>
                            <li><a href="<?php echo site_url('administracion/puntos'); ?>"<?php activar($secci, 'puntos'); ?> ><i class="fa fa-trophy"></i> Puntos Printome</a></li>
                            <li class="accordion-navigation" data-cat="productos">
                                <a href="#productos"><i class="fa fa-tags"></i> Productos <i class="flecha fa fa-caret-right" data-cat="productos"></i></a>
                                <div id="productos" class="content">
                                    <nav>
                                        <ul class="side-nav">
                                            <li><a href="<?php echo site_url('administracion/categorias'); ?>"<?php activar($secci, 'categorias'); ?>><i class="fa fa-tags"></i> Categorías</a></li>
                                            <li><a href="<?php echo site_url('administracion/tipos'); ?>"<?php activar($secci, 'tipos'); ?>><i class="fa fa-bookmark"></i> Tipos de producto</a></li>
                                            <li><a href="<?php echo site_url('administracion/marcas'); ?>"<?php activar($secci, 'marcas'); ?>><i class="fa fa-tag"></i> Marcas</a></li>
                                            <li><a href="<?php echo site_url('administracion/categorizar'); ?>"<?php activar($secci, 'categorizar'); ?>><i class="fa fa-tag"></i> Categorizar</a></li>
                                            <li><a href="<?php echo site_url('administracion/productos'); ?>"<?php activar($secci, 'productos'); ?>><i class="fa fa-tag"></i> Productos</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </li>
                            <li class="accordion-navigation" data-cat="diseno">
                                <a href="#diseno"><i class="fa fa-picture-o"></i> Diseño <i class="flecha fa fa-caret-right" data-cat="diseno"></i></a>
                                <div id="diseno" class="content">
                                    <nav>
                                        <ul class="side-nav">
                                            <li><a href="<?php echo site_url('administracion/campanas'); ?>"<?php activar($secci, 'campanas'); ?>><i class="fa fa-shield"></i> Diseños en venta</a></li>
                                            <li><a href="<?php echo site_url('administracion/slider'); ?>"<?php activar($secci, 'slider'); ?>><i class="fa fa-picture-o"></i> Slider</a></li>
                                            <li><a href="<?php echo site_url('administracion/plantillas'); ?>"<?php activar($secci, 'plantillas'); ?>><i class="fa fa-image"></i> Plantillas</a></li>
                                            <li><a href="<?php echo site_url('administracion/vectores'); ?>"<?php activar($secci, 'vectores'); ?>><i class="fa fa-star"></i> Vectores</a></li>
                                            <li><a href="<?php echo site_url('administracion/destacadosinicio'); ?>"<?php activar($secci, 'destacadosinicio'); ?>><i class="fa fa-picture-o"></i> Destacados inicio</a></li>
                                            <li><a href="<?php echo site_url('administracion/masvendidos'); ?>"<?php activar($secci, 'masvendidos'); ?>><i class="fa fa-picture-o"></i> Más vendidos</a></li>
                                            <li><a id="btnwowwinner" href="<?php echo site_url('administracion/wowwinners'); ?>"<?php activar($secci, 'wowwinners'); ?>><i class="fa fa-picture-o"></i> Wow winners</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </li>
                            <li class="accordion-navigation" data-cat="servicios">
                                <a href="#servicios"><i class="fa fa-user"></i> Servicio al cliente <i class="flecha fa fa-caret-right" data-cat="servicios"></i></a>
                                <div id="servicios" class="content">
                                    <nav>
                                        <ul class="side-nav">
                                            <li><a href="<?php echo site_url('administracion/testimonios'); ?>"<?php activar($secci, 'testimonios'); ?>><i class="fa fa-user"></i> Testimonios</a></li>
                                            <li><a href="<?php echo site_url('administracion/cupones'); ?>"<?php activar($secci, 'cupones'); ?>><i class="fa fa-money"></i> Cupones</a></li>
                                            <li><a href="<?php echo site_url('administracion/cargos_extra'); ?>"<?php activar($secci, 'cargos_extra'); ?>><i class="fa fa-calculator"></i> Cargos Extra</a></li>
                                            <li><a href="<?php echo site_url('administracion/carrito'); ?>"<?php activar($secci, 'carrito'); ?>><i class="fa fa-shopping-cart"></i> Transferir Carritos</a></li>
                                            <li><a href="<?php echo site_url('administracion/eliminar'); ?>"<?php activar($secci, 'eliminar'); ?>><i class="fa fa-trash"></i> Eliminar Cuentas</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </li>
                            <li><a href="<?php echo site_url('administracion/login/cerrar_sesion'); ?>"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
						</ul>
					</nav>
				</div>
			</div>
            <script>
                $(".accordion-navigation").on('click', function() {
                    $('.accordion-navigation').removeClass("clicked");
                    $(this).addClass("clicked");
                    $('.accordion-navigation').trigger('classChange');
                });

                $('.accordion-navigation').on('classChange', function() {
                    $(this).each(function(index, value){
                        var data_elem = $(this).data("cat");
                        if($(value).hasClass("clicked")) {
                            if ($(value).hasClass("active")) {
                                $(value).find("i[data-cat='" + data_elem + "']").removeClass("fa-caret-down").addClass("fa-caret-right");
                            } else {
                                $(value).find("i[data-cat='" + data_elem + "']").removeClass("fa-caret-right").addClass("fa-caret-down");
                            }
                        }else{
                            $(value).find("i[data-cat='" + data_elem + "']").removeClass("fa-caret-down").addClass("fa-caret-right");
                        }
                    });

                });
                $(document).ready(function(){
                    var elem = $(".content a.active");
                    if(elem.hasClass('active')){
                        elem.parents('.accordion-navigation').addClass('active');
                        elem.parents('.content').addClass('active');
                        var data_parent = elem.parents('.accordion-navigation').data("cat");
                        elem.parents('.accordion-navigation').find("i[data-cat='" + data_parent + "']").removeClass("fa-caret-right").addClass("fa-caret-down");
                    }
                });
            </script>
			<div class="small-19 columns" id="stuff">
<!--                						--><?php //$iconos = array(
//                							'categorias' => '<i class="fa fa-tags"></i> Categorías',
//                							'tipos' => '<i class="fa fa-bookmark"></i> Tipos de producto',
//                							'marcas' => '<i class="fa fa-tag"></i> Marcas',
//                                          'categorizar' => '<i class="fa fa-tag"></i> Categorizar',
//                							'productos' => '<i class="fa fa-tag"></i> Productos',
//                							'plantillas' => '<i class="fa fa-image"></i> Plantillas',
//                							'cotizador' => '<i class="fa fa-table"></i> Tabla de cotizador',
//                							'pedidos' => '<i class="fa fa-credit-card"></i> Pedidos',
//                							'reportes' => '<i class="fa fa-line-chart"></i> Reportes',
//                							'cupones' => '<i class="fa fa-money"></i> Cupones',
//                                          'puntos' => '<i class="fa fa-trophy"></i> Puntos Printome',
//                							'campanas' => '<i class="fa fa-shield"></i> Diseños en venta',
//                							'tiendas' => '<i class="fa fa-building-o"></i> Tiendas',
//                							'vectores' => '<i class="fa fa-star"></i> Vectores',
//                							'testimonios' => '<i class="fa fa-user"></i> Testimonios',
//                                          'cargos_extra'=> '<i class="fa fa-calculator"></i> Cargos Extra',
//                                          'slider' => '<i class="fa fa-picture-o"></i> Slider',
//                                          'servicios' => '<i class="fa fa-shopping-cart"></i> Servicios'
//                						); ?>
<!--                						--><?php //foreach($this->session->admin['privilegios'] as $privilegio): ?>
<!--                							<li><a href="--><?php //echo site_url('administracion/'.$privilegio); ?><!--"--><?php //activar($secci, $privilegio); ?><!-- >--><?php //echo $iconos[$privilegio]; ?><!--</a></li>-->
<!--                						--><?php //endforeach; ?>
				<div class="row collapse" id="main-content-container">
					<div class="small-24 columns" id="main-content">
					<?php // main-content starts ?>
