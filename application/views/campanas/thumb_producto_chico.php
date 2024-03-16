<div class="column producto">
	<div class="contenedor-producto">
		<a href="<?php echo site_url($producto->vinculo_producto); ?>">
			<img src="<?php echo site_url('assets/images/trans.png'); ?>" class="unveil" data-src="<?php echo site_url('image-tool/index.php?src='.$producto->front_image.'&w=310&h=310'); ?>" alt="Fotografía del producto <?php echo $producto->name.' ('.$producto->id_enhance.')';; ?>" width="310" height="310" />
			<noscript><img src="<?php echo site_url($producto->front_image); ?>" alt="Fotografía del producto <?php echo $producto->name.' ('.$producto->id_enhance.')'; ?>" /></noscript>
		</a>
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
