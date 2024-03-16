<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title"><a href="<?php echo site_url('administracion/devoluciones'); ?>">« Regresar a devoluciones</a></h2>
	</div>
</div>
<div class="row">
	<div class="small-24  large-centered columns">
	<?php if($estatus == "0"): ?>
		<?php echo form_open('administracion/devoluciones/' . $id_devolucion . '/actualizar/'  ); ?>
			<div class="row">
				<div class="small-24  columns text-right">
    			<input type="submit" class="button radius right" name="estatus[aprobar]" value="Aceptar"/>
					<span class="right">&nbsp;	</span>
					<input type="submit" class="button radius right" name="estatus[rechazar]" value="Rechazar"/>
				</div>
			</div>
			
		<?php echo form_close(); ?>			
	<?php endif; ?>

			<table cellpadding="6" cellspacing="1" style="width:100%" border="0" id="carrito">
				<thead>
					<tr>
						<th colspan="2">Producto</th>
						<th>Precio</th>
						<th>Subtotal</th>
						<th></th>
					</tr>
				</thead>
				<tbody>

				<?php foreach($productos as $key => $producto): ?>
					<tr class="entrada_carrito">
						<td style="position: relative;" class="text-center">
							<?php echo $producto->cantidad_producto ?>
						</td>
						<td class="entrada_carrito_imagen"><img src="<?php echo site_url('assets/images/productos/producto'.$producto->id_producto.'/'.$producto->fotografia_icono); ?>" alt="" class="thumb_cart"></td>
						<td class="entrada_carrito_info">
							<strong><?php echo $producto->nombre_marca; ?></strong>
							<strong><?php echo $producto->nombre_producto; ?></strong>
							<span>Talla: <?php echo caracteristicas_parse($producto->caracteristicas); ?></span>
							<span>Color: <?php echo color_awesome($producto->codigo_color); ?></span>
							<?php if($producto->descuento_especifico != 0.00): ?>
							<span>Descuento: -<?php echo ($producto->descuento_especifico); ?>%</span>
							<?php endif; ?>
						</td>
						<td>$ <?php echo $this->cart->format_number($producto->precio_producto); ?></td>
						<td>$ <?php echo $this->cart->format_number($producto->precio_producto * $producto->cantidad_producto); ?></td>
					</tr>
				<?php endforeach; ?>

				</tbody>
			</table>
	</div>
</div>
