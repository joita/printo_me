<div class="column producto">
	<div class="hide">
		<span class="precio_campana"><?php echo number_format(redondeo($producto->price), 0, '', ''); ?></span>
		<span class="restante_campana"><?php echo strtotime($producto->end_date); ?></span>
		<?php /*<span class="vendido_campana"><?php echo $producto->cantidad_adicional + $producto->cantidad_vendida; ?></span> */ ?>
	</div>
	<div class="contenedor-producto" style="border: none">
		<a href="<?php echo site_url($producto->vinculo_producto); ?>">
			<img style="border: none" src="<?php echo site_url('assets/images/trans.png'); ?>" class="unveil" data-src="<?php echo site_url('image-tool/index.php?src='.$producto->front_image.'&w=310&h=310'); ?>" alt="Fotografía del producto <?php echo $producto->name.' ('.$producto->id_enhance.')';; ?>" width="310" height="310" />
			<noscript><img src="<?php echo site_url($producto->front_image); ?>" alt="Fotografía del producto <?php echo $producto->name.' ('.$producto->id_enhance.')'; ?>" /></noscript>
		</a>
		<div class="barra-links">
		<?php if( !$this->session->has_userdata('login') ): ?>
			<a data-open="login" class="cart_controls_inte like-me" title="Agregar a mis favoritos">
				<i style="color: #025573;" class="fa fa-heart-o"></i>
			</a>
		<?php else: ?>
			<?php if($producto->id_cliente == $this->session->login['id_cliente'] && !is_null($producto->fecha_agregado)): ?>
				<a href="<?php echo site_url('mi-cuenta/favoritos/quitar/'.$producto->id_enhance.'/'.$producto->id_producto)?>" class="cart_controls_inte like-me" title="Quitar de mis favoritos">
					<i style="color: #025573;" class="fa fa-heart"></i>
				</a>
			<?php else: ?>
				<a href="<?php echo site_url('mi-cuenta/favoritos/agregar/'.$producto->id_enhance.'/'.$producto->id_producto)?>" class="cart_controls_inte like-me" title="Agregar a mis favoritos">
					<i style="color: #025573;" class="fa fa-heart-o"></i>
				</a>
			<?php endif; ?>
		<?php endif; ?>
		</div>
		<?php if($producto->type == 'limitado'): ?>
		<div class="thumb-timer">
			<div class="timer-corto" data-countdown="<?php echo date("Y-m-d H:i:s", strtotime($producto->end_date)); ?>"></div>
		</div>
		<?php endif; ?>
		<?php /*
		<div class="thumb-sold">
			<span class="quedan">&nbsp;</span>
			<span class="f"><?php echo $producto->cantidad_adicional + $producto->cantidad_vendida; ?></span>
			<span class="quedan">vendidos</span>
		</div>
		*/ ?>
		<div class="thumb-price">
			<span style="color: #FF4D00;" class="price-me p">$<?php echo $this->cart->format_number($producto->price); ?></span>
		</div>
	</div>
	<div class="descripcion-producto">
		<a href="<?php echo site_url($producto->vinculo_producto); ?>">
			<span class="title-me" style="color: #025573;"><?php echo $producto->name; ?></span>
		</a>
	</div>
</div>
