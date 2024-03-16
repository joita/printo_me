<?php $sold = $this->enhance_modelo->obtener_total_vendidos_por_campana($producto->id_enhance); ?>
<div class="column producto">
	<div class="hide">
		<span class="precio_campana"><?php echo number_format(redondeo($producto->price), 0, '', ''); ?></span>
		<span class="restante_campana"><?php echo strtotime($producto->end_date); ?></span>
		<?php /*
		<span class="vendido_campana"><?php echo $sold; ?></span>
		*/ ?>
	</div>
	<div class="contenedor-producto">
		<a href="<?php echo site_url($producto->vinculo_producto); ?>">
			<img src="<?php echo site_url('assets/images/trans.png'); ?>" class="unveil" data-src="<?php echo site_url('image-tool/index.php?src='.$producto->front_image.'&w=310&h=310'); ?>" alt="Fotografía del producto <?php echo $producto->name; ?>" width="310" height="310" />
			<noscript><img src="<?php echo site_url($producto->front_image); ?>" alt="Fotografía del producto <?php echo $producto->name; ?>" /></noscript>
		</a>
		<?php if($producto->type == 'limitado'): ?>
		<div class="thumb-timer">
			<div class="timer-corto" data-countdown="<?php echo date("Y-m-d H:i:s", strtotime($producto->end_date)); ?>"></div>
		</div>
		<?php endif; ?>
		<?php /*
		<div class="thumb-sold">
			<span class="quedan">&nbsp;</span>
			<span class="f"><?php echo $sold; ?></span>
			<span class="quedan">vendidos</span>
		</div>
		*/ ?>
		<div class="thumb-price">
			<span class="price-me p">$<?php echo $this->cart->format_number($producto->price); ?></span>
		</div>
	</div>
	<div class="descripcion-producto">
		<a href="<?php echo site_url($producto->vinculo_producto); ?>">
			<span class="title-me"><?php echo $producto->name; ?></span>
		</a>
	</div>
</div>