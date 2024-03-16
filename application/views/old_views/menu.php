<div id="barra_naranja">
	<div class="row small-collapse medium-collapse large-uncollapse">
		<div class="small-18 hide-for-medium-only large-7 xlarge-9 columns hide-for-small-only">
			<span id="short-desc">Playeras personalizadas y mucho más, Envío Exprés con DHL</span>
		</div>
		<div class="small-18 medium-18 large-11 xlarge-9 columns">
			<ul id="menu-opciones" class="clearfix dropdown menu" data-dropdown-menu>
				<li class="float-right"><a href="<?php echo site_url('Servicios'); ?>" id="main-cart-link"<?php activar($seccion_activa, 'Servicios'); ?>><i class="fa fa-shopping-cart"></i><span id="cantidad"><?php echo $this->cart->total_items(); ?></span><span class="show-for-medium">$ <?php echo  $this->cart->format_number($this->cart->obtener_total());  ?></span></a></li>
				<li class="sub float-right"><a href="#"<?php activar($seccion_activa, 'mi-cuenta'); ?>><i class="fa fa-th"></i> <span class="show-for-medium">Mi cuenta</span> <span class="show-for-small-only">Cuenta</span></a>
					<ul>
						<?php if ($this->session->has_userdata('login')): ?>
						<li><a href="<?php echo site_url('mi-cuenta/datos'); ?>"<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'datos'); } ?>><i class="fa fa-child"></i> Mis Datos</a></li>
						<li><a href="<?php echo site_url('mi-cuenta/direcciones'); ?>"<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'direcciones'); } ?>><i class="fa fa-flag"></i> Mis Direcciones</a></li>
						<li><a href="<?php echo site_url('mi-cuenta/facturacion'); ?>"<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'facturacion'); } ?>><i class="fa fa-ticket"></i> Mis Datos de Facturación</a></li>
						<li><a href="<?php echo site_url('mi-cuenta/pedidos'); ?>"<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'pedidos'); } ?>><i class="fa fa-credit-card"></i> Mis Pedidos</a></li>
						<li><a href="<?php echo site_url('mi-cuenta/campanas'); ?>"<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'campanas'); } ?>><i class="fa fa-line-chart"></i> Mis Campañas</a></li>
						<li><a href="<?php echo site_url('mi-cuenta/favoritos'); ?>"<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'favoritos'); } ?>><i class="fa fa-star"></i> Mis Favoritos</a></li>
						<?php if(!$this->session->login['facebook']): ?>
						<li><a href="<?php echo site_url('mi-cuenta/cambiar-contrasena'); ?>"<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'cambiar-contrasena'); } ?>><i class="fa fa-refresh"></i> Cambiar Contraseña</a></li>
						<li><a href="<?php echo site_url('cerrar-sesion'); ?>" id="cerrar-link"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
						<?php else: ?>
						<li><a id="cerrar-link-fb"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
						<?php endif; ?>
						<?php else: ?>
						<li><a data-open="login"><i class="fa fa-sign-in"></i> Iniciar sesión</a></li>
						<li><a data-open="register"><i class="fa fa-user-plus"></i> Registrarse</a></li>
						<?php endif; ?>
					</ul>
				</li>
				<li class="float-right"><a data-open="contacto_general"><i class="fa fa-envelope"></i> Contáctanos</a></li>
			</ul>
		</div>
	</div>
</div>

<?php
	$categorias = $this->categoria->obtener_categorias_no_enhance();
	foreach($categorias as $indice=>$categoria) {
		$categorias[$indice]->tipos = $this->tipo_modelo->obtener_tipos_admin($categoria->id_categoria);
	}
?>
<section id="logo-container">
	<div class="row">
		<div class="small-14 medium-9 columns">
			<h1 id="logo">
				<a href="<?php echo base_url(); ?>">
					<img src="<?php echo cdn_url('assets/images/main_logo.svg'); ?>" alt="Diseña tu playera on-line | printome.mx" width="346" height="90" />
				</a>
			</h1>
		</div>
		<div class="small-4 medium-9 columns text-right right-links">
			<a href="https://www.facebook.com/printome" class="fbl" target="_blank"><i class="fa fa-facebook-square"></i></a>
			<?php /*<a href="https://www.instagram.com/printome_mx/" class="insta" target="_blank"><i class="fa fa-instagram"></i></a>*/ ?>
			<a href="https://www.youtube.com/channel/UC5lC5b9lCLku8Zp3rwV-yBQ" class="yout" target="_blank"><i class="fa fa-youtube"></i></a>
		</div>
	</div>
</section>
<div<?php if($seccion_activa != 'personalizar') { echo ' data-sticky-container id="menu-sticky"'; } else { echo ' style="position:relative;z-index:1029;"'; } ?>>
	<header class="main-header show-for-medium"<?php if($seccion_activa != 'personalizar') { echo '  data-sticky data-sticky-on="medium" data-top-anchor="logo-container:bottom" data-btm-anchor="main-footer:top" data-options="marginTop:0;"'; } else { echo ' style="margin-bottom:0;"'; } ?>>
		<div class="row">
			<nav class="medium-18 columns">
				<ul class="dropdown menu clearfix" data-dropdown-menu>
					<li><a href="<?php echo base_url(); ?>"<?php activar($seccion_activa, 'inicio'); ?>><i class="fa fa-home"></i> Inicio</a></li>
					<?php if(sizeof($categorias) > 0): ?>
					<li class="sub"><a<?php activar($seccion_activa, 'productos'); ?>><i class="fa fa-tags"></i> Selecciona y Crea</a>
						<ul>
						<?php foreach($categorias as $categoria): ?>
							<?php if($categoria->tipos): ?>
							<li><a<?php if(isset($subseccion_activa)) { activar($subseccion_activa, $categoria->nombre_categoria_slug); } ?>><i class="fa fa-tag"></i> <?php echo $categoria->nombre_categoria; ?></a>
								<ul>
								<?php foreach($categoria->tipos as $tipo): ?>
									<li><a href="<?php echo site_url($categoria->nombre_categoria_slug.'/'.$tipo->tipo->nombre_tipo_slug); ?>"<?php if(isset($tipo_activo)) { activar($tipo_activo, $tipo->tipo->nombre_tipo_slug); } ?>><?php echo $tipo->tipo->nombre_tipo; ?></a></li>
								<?php endforeach; ?>
								</ul>
							</li>
							<?php endif; ?>
						<?php endforeach; ?>
						</ul>
					</li>
					<?php endif; ?>
					<li<?php /* class="sub"*/ ?>><a href="<?php echo site_url('campanas'); ?>"<?php activar($seccion_activa, 'campanas'); ?>><i class="fa fa-star"></i> Compra</a><?php /*
						<ul>
							<li><a href="<?php echo site_url('campanas/sociales'); ?>"<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'social'); } ?>>Sociales</a></li>
							<li><a href="<?php echo site_url('campanas/lucrativas'); ?>"<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'lucrativa'); } ?>>Lucrativas</a></li>
						</ul>
					*/ ?></li>
					<li class="show-for-medium-only"><a href="<?php echo site_url('ayuda'); ?>"<?php activar($seccion_activa, 'ayuda'); ?>><i class="fa fa-info-circle"></i> Ayuda</a>
					<li class="float-right" id="disena"><a href="<?php echo site_url('personalizar/13/20'); ?>"<?php activar($seccion_activa, 'personalizar'); ?>><i class="fa fa-rocket"></i> ¡Empieza a personalizar!</a></li>
					<li class="float-right show-for-large"><a href="<?php echo site_url('ayuda'); ?>"<?php activar($seccion_activa, 'ayuda'); ?>><i class="fa fa-info-circle"></i> ¿Necesitas Ayuda?<span class="show-for-small-only">Ayuda</span></a></li>
				</ul>
			</nav>
		</div>
	</header>
</div>

<div data-sticky-container>
	<header class="main-header show-for-small-only" data-sticky data-sticky-on="small" data-top-anchor="logo-container:bottom" data-btm-anchor="main-footer:top" data-options="marginTop:0;">
		<div class="row small-collapse show-for-small-only">
			<nav class="small-18 columns">
				<div class="title-bar" data-responsive-toggle="menu-movil" data-hide-for="medium">
					<div class="title-bar-title">Menú principal</div>
					<button class="menu-icon" type="button" data-toggle></button>
				</div>
				<div class="top-bar" id="menu-movil">
					<ul class="vertical menu" data-drilldown>
						<li><a href="<?php echo base_url(); ?>"<?php activar($seccion_activa, 'inicio'); ?>><i class="fa fa-home"></i> Inicio</a></li>
						<?php if(sizeof($categorias) > 0): ?>
						<li class="sub"><a<?php activar($seccion_activa, 'productos'); ?>><i class="fa fa-tags"></i> Selecciona y Crea</a>
							<ul class="vertical menu">
							<?php foreach($categorias as $categoria): ?>
								<?php if($categoria->tipos): ?>
								<li class="sub"><a<?php if(isset($subseccion_activa)) { activar($subseccion_activa, $categoria->nombre_categoria_slug); } ?>><i class="fa fa-tag"></i> <?php echo $categoria->nombre_categoria; ?></a>
									<ul class="vertical menu">
										<?php foreach($categoria->tipos as $tipo): ?>
											<li><a href="<?php echo site_url($categoria->nombre_categoria_slug.'/'.$tipo->tipo->nombre_tipo_slug); ?>"<?php if(isset($tipo_activo)) { activar($tipo_activo, $tipo->tipo->nombre_tipo_slug); } ?>><i class="fa fa-tag"></i> <?php echo $tipo->tipo->nombre_tipo; ?></a></li>
										<?php endforeach; ?>
									</ul>
								</li>
								<?php endif; ?>
							<?php endforeach; ?>
							</ul>
						</li>
						<?php endif; ?>
						<li<?php /* class="sub"*/ ?>><a href="<?php echo site_url('campanas'); ?>"<?php activar($seccion_activa, 'campanas'); ?>><i class="fa fa-line-chart"></i> Compra</a><?php /*
							<ul class="vertical menu">
								<li><a href="<?php echo site_url('campanas/sociales'); ?>">Sociales</a></li>
								<li><a href="<?php echo site_url('campanas/lucrativas'); ?>">Lucrativas</a></li>
							</ul>
						*/ ?></li>
						<li><a href="<?php echo site_url('ayuda'); ?>"<?php activar($seccion_activa, 'ayuda'); ?>><i class="fa fa-info-circle"></i> ¿Necesitas Ayuda?</a></li>
						<li><a href="<?php echo site_url('personalizar/13/20'); ?>" id="disena-movil"<?php activar($seccion_activa, 'personalizar'); ?>><i class="fa fa-rocket"></i> ¡Empieza a personalizar!</a></li>
					</ul>
				</div>
			</nav>
		</div>
	</header>
</div>