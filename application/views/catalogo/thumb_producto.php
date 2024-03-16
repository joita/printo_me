<div class="column producto">
	<div class="hide">
		<span class="precio_oculto"><?php echo number_format(redondeo($this->catalogo_modelo->obtener_precio_minimo_por_producto($producto->id_producto)),0,'',''); ?></span>
	<?php foreach($this->catalogo_modelo->obtener_string_colores_por_producto($producto->id_producto) as $color): ?>
		<span class="color_oculto"><?php echo $color; ?></span>
	<?php endforeach; ?>
		<span class="marca_oculta"><?php echo '.marca_'.$producto->nombre_marca_slug; ?></span>
	<?php foreach($this->catalogo_modelo->obtener_string_tallas_por_producto($producto->id_producto) as $talla): ?>
		<span class="talla_oculta"><?php echo $talla; ?></span>
	<?php endforeach; ?>
	</div>
	<div class="contenedor-producto">
		<a href="<?php echo site_url($producto->vinculo_producto); ?>">
			<img src="<?php echo site_url($producto->ubicacion_base.$producto->fotografia_mediana); ?>" alt="<?php echo htmlspecialchars($producto->nombre_producto); ?>" />
		</a><?php /*
		<div class="barra-links">
			<a href="<?php echo site_url($producto->vinculo_producto); ?>" class="cart_controls_inte see-me">
				<i class="fa fa-search-plus"></i>
			</a>
		</div>*/ ?>
	</div>
	<div class="descripcion-producto">
		<a href="<?php echo site_url($producto->vinculo_producto); ?>">
			<span class="title-me"><?php echo $producto->nombre_producto; ?></span>
			<?php /*<span class="price-me">Desde $<?php echo redondeo($this->catalogo_modelo->obtener_precio_minimo_por_producto($producto->id_producto)); ?></span>*/ ?>
		</a>
	</div>
</div>
