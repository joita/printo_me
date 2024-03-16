<div id="barra-negra">
	<div class="row  medium-uncollapse">
		<div class="large-7 xlarge-8 columns show-for-large text-left" id="ac-cont">
			<span class="acept ini-ac">Aceptamos: </span><span class="acept mc">MasterCard </span><span class="acept vi">Visa </span><span class="acept am">American Express </span><span class="acept ox">OXXO </span><span class="acept pp">PayPal </span>
		</div>
		<div class="small-18 medium-18 large-11 xlarge-10 columns">
			<ul id="menu-opc" class="clearfix dropdown menu" data-dropdown-menu>
				<li class="sub<?php activar_alt($seccion_activa, 'mi-cuenta'); ?>"><a><i class="fa fa-user"></i><span class="show-for-medium"> Mi cuenta</span></a>
					<ul class="menu">
						<?php if ($this->session->has_userdata('login')): ?>
						<li><a>Hola <?php echo $this->session->login['nombre']; ?></a></li>
						<li><a href="<?php echo site_url('tienda/'.$nombre_tienda_slug.'/cerrar-sesion'); ?>" id="cerrar-link"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
						<?php else: ?>
						<li><a data-open="login"><i class="fa fa-sign-in"></i> Iniciar sesión</a></li>
						<li><a data-open="register"><i class="fa fa-user-plus"></i> Registrarse</a></li>
						<?php endif; ?>
					</ul>
				</li>
				<li<?php activar($seccion_activa, 'Servicios'); ?>><a href="<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito'); ?>" id="main-cart-link"><i class="fa fa-shopping-cart"></i> <span class="show-for-medium">$ <?php echo  $this->cart->format_number($this->cart->obtener_total());  ?></span></a></li>
				
				<li class="soc"><a class="fbli" href="https://www.facebook.com/printome" target="_blank"><i class="fa fa-facebook"></i></a></li>
				<li class="soc"><a class="igli" href="https://www.instagram.com/printome_mx/" target="_blank"><i class="fa fa-instagram"></i></a></li>
				<li class="soc"><a class="ytli" href="https://www.youtube.com/channel/UC5lC5b9lCLku8Zp3rwV-yBQ" target="_blank"><i class="fa fa-youtube"></i></a></li>
			</ul>
		</div>
	</div>
</div>

<header id="menu-cont">
	<div class="row  medium-uncollapse">
		<div class="small-18 columns">
			<div class="top-bar" id="menu-principal">
				<div class="top-bar-left">
					<ul class="dropdown menu" data-dropdown-menu>
						<li class="menu-text">
							<h1 id="logo" class="text-center medium-text-left">
								<a href="<?php echo site_url('tienda/'.$nombre_tienda_slug); ?>">
								<?php if($tienda->logotipo_chico != ''): ?>
									<img src="#" data-interchange="[<?php echo site_url('assets/images/logos/'.$tienda->logotipo_chico); ?>, small], [<?php echo site_url('assets/images/logos/'.$tienda->logotipo_mediano); ?>, retina]" alt="Diseña tu playera on-line | printome.mx" width="346" height="90" />
								<?php else: ?>
									<img src="<?php echo site_url('assets/images/main_logo.svg'); ?>" alt="Diseña tu playera on-line | printome.mx" width="346" height="90" />
								<?php endif; ?>
								</a>
							</h1>
						</li>
					</ul>
				</div>
				<div class="top-bar-right">
					<span class="store-title show-for-medium"><?php echo $tienda->nombre_tienda; ?></span>
				</div>
			</div>
		</div>
	</div>
</header>
