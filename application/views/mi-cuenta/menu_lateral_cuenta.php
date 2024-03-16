<div class="contenedor-filtros"<?php if($subseccion_activa != 'productos' && $subseccion_activa != 'productos_plazo_definido'): ?> data-equalizer-watch="base"<?php endif; ?>>
	<span class="titulo-filtros" style="color: #F2560D; font-size: 2rem; text-align: left; border: none">Mi Cuenta</span>
					
	<ul class="vertical menu ff"> <?php /*  lateral */ ?>
		<li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'datos'); } ?>><a href="<?php echo site_url('mi-cuenta/datos'); ?>"><i class="fa fa-child"></i> Mis Datos</a></li>
        <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'puntos'); } ?>><a href="<?php echo site_url('mi-cuenta/puntos-printome'); ?>"><i class="fa fa-trophy"></i> Mis Puntos Printome</a></li>
        <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'direcciones'); } ?>><a href="<?php echo site_url('mi-cuenta/direcciones'); ?>"><i class="fa fa-flag"></i> Mis Direcciones</a></li>
		<li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'facturacion'); } ?>><a href="<?php echo site_url('mi-cuenta/facturacion'); ?>"><i class="fa fa-ticket"></i> Mis Datos de Facturación</a></li>
		<li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'pedidos'); } ?>><a href="<?php echo site_url('mi-cuenta/pedidos'); ?>"><i class="fa fa-credit-card"></i> Mis Pedidos</a></li>
		<li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'productos'); } ?>><a href="<?php echo site_url('mi-cuenta/productos'); ?>"><i class="fa fa-line-chart"></i> Productos Venta Inmediata</a></li>
        <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'productos_plazo_definido'); } ?>><a href="<?php echo site_url('mi-cuenta/productos-plazo-definido'); ?>"><i class="fa fa-line-chart"></i> Productos Plazo Definido</a></li>
        <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'datos-bancarios'); } ?>><a href="<?php echo site_url('mi-cuenta/datos-bancarios'); ?>"><i class="fa fa-money"></i> Mis Datos de Depósito</a></li>
		<li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'favoritos'); } ?>><a href="<?php echo site_url('mi-cuenta/favoritos'); ?>"><i class="fa fa-star"></i> Mis Favoritos</a></li>
		<?php if(isset($this->tienda)): ?>
		<li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'tienda'); } ?>><a href="<?php echo site_url('mi-cuenta/tienda'); ?>"><i class="fa fa-shopping-bag"></i> Mi Tienda</a></li>
		<?php endif; ?>
		<?php if(!$this->session->login['facebook']): ?>
		<li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'cambiar-contrasena'); } ?>><a href="<?php echo site_url('mi-cuenta/cambiar-contrasena'); ?>"><i class="fa fa-refresh"></i> Cambiar Contraseña</a></li>
		<?php endif; ?>
	</ul>
</div>