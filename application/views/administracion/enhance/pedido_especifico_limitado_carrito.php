<table cellpadding="0" cellspacing="0" id="carrito" class="tabla-pedidos">
	<thead>
		<tr>
			<th class="cantidades-carrito text-center"><span class="show-for-small-only">#</span><span class="show-for-medium">Cant.</span></th>
			<th class="text-left titulo-precio">Producto</th>
			<th class="text-center prec-esp titulo-precio">Precio</th>
			<th class="text-center titulo-precio">Subtotal</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($pedido->productos as $producto): ?>
		<?php if($producto->id_enhance) {
			$info_enhanced = $this->catalogo_modelo->obtener_enhanced_con_id($producto->id_enhance);
			$imagen = $info_enhanced->front_image;
			$nombre_producto = $info_enhanced->name;
			$producto->info_enhance = $this->enhance_modelo->obtener_enhance($producto->id_enhance);

			if($producto->id_enhance == $campana->id_enhance) {
				$coincidencia = true;
			} else {
				if($producto->info_enhance->id_parent_enhance == $campana->id_enhance) {
					$coincidencia = true;
				} else {
					$coincidencia = false;
				}
			}
		} else {

			$imagen_json = json_decode($producto->diseno);
			$imagen_json_2 = $imagen_json->images;
			$imagen = $imagen_json_2->front;
			$coincidencia = false;
			$nombre_producto = $producto->nombre_producto;
		} ?>
		<?php //echo ($producto->id_enhance ? ($producto->id_enhance != $campana->id_enhance ? '<tr class="coverme" style="width:95%"><td colspan="4">Otros productos.</td></tr>' : '') : '<tr class="coverme" style="width:95%"><td colspan="4">Otros productos.</td></tr>'); ?>
		<?php //echo ($producto->id_enhance ? ($producto->id_enhance != $campana->id_enhance ? '<tr class="coverme" style="width:95%"><td colspan="4">Otros productos.</td></tr>' : '') : ''); ?>
		<?php if(!$coincidencia) { echo '<tr class="coverme" style="width:95%"><td colspan="4">Otros productos.</td></tr>'; } ?>
		<tr<?php if(!$coincidencia) { echo ' class="enhance"'; } ?>>
			<td class="cantidades-carrito">
				<div class="clearfix">
					<div class="square-button-area hide">
						<button type="button" class="square increase"><i class="fa fa-plus"></i></button>
						<button type="button" class="square decrease"><i class="fa fa-minus"></i></button>
					</div>
					<div class="square-cantidad">
						<input type="text" value="<?php echo $producto->cantidad_producto ?>" class="qtyact" readonly />
					</div>
				</div>
			</td>
			<td class="info-carrito">
				<div class="clearfix">
					<img src="<?php echo site_url($imagen); ?>" alt="Fotografía del producto" class="carrito-foto" width="58" height="58" />
					<div class="carrito-descripcion">
						<span class="carrito-nombre-producto"><?php echo $nombre_producto; ?></span>
						<span>Talla: <?php echo caracteristicas_parse2($producto->caracteristicas); ?></span>
						<span>Color: <?php echo color_awesome($producto->codigo_color); ?></span>
						<?php if($producto->descuento_especifico != 0.00): ?>
						<span>Descuento: -<?php echo ($producto->descuento_especifico); ?>%</span>
						<?php endif; ?>
					</div>
				</div>
			</td>
			<td class="precio-carrito prec-esp text-right">
				<span>$<?php echo $this->cart->format_number($producto->precio_producto); ?></span>
			</td>
			<td class="precio-carrito text-right">
				<span>$<?php echo $this->cart->format_number($producto->precio_producto * $producto->cantidad_producto); ?></span>
			</td>
		</tr>
	<?php endforeach; ?>
		<tr>
			<td colspan="2" class="precio-carrito-sub">
				<span class="show-for-small-only text-right"><strong>Subtotal</strong></span>
			</td>
			<td class="precio-carrito-sub prec-esp text-right">
				<span><strong>Subtotal</strong></span>
			</td>
			<td class="precio-carrito-sub text-right">
				<span>$<?php echo $this->cart->format_number($pedido->subtotal); ?></span>
			</td>
		</tr>
		<?php if($pedido->descuento > 0.00): ?>
		<tr>
			<td colspan="2" class="precio-carrito-sub">
				<span class="show-for-small-only text-right"><strong>Saldo a favor</strong></span>
			</td>
			<td class="precio-carrito-sub prec-esp text-right">
				<span><strong>Saldo</strong></span>
			</td>
			<td class="precio-carrito-sub text-right">
				<span>-$<?php echo $this->cart->format_number($pedido->descuento); ?></span>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="precio-carrito-sub">
				<span class="show-for-small-only text-right"><strong>Subtotal + Saldo a favor</strong></span>
			</td>
			<td class="precio-carrito-sub prec-esp text-right">
				<span><strong>Subtotal + Saldo</strong></span>
			</td>
			<td class="precio-carrito-sub text-right">
				<span>$<?php echo $this->cart->format_number($pedido->subtotal - $pedido->descuento); ?></span>
			</td>
		</tr>
		<?php endif; ?>
		<?php if($pedido->id_cupon): ?>
		<?php $cupon = $this->db->get_where('Cupones', array('id' => $pedido->id_cupon))->row(); ?>
		<tr>
			<td colspan="2" class="precio-carrito-sub">
				<span class="show-for-small-only text-right"><strong>Cupón</strong></span>
			</td>
			<td class="precio-carrito-sub prec-esp text-right">
				<span><strong>Cupón</strong></span>
			</td>
			<td class="precio-carrito-sub text-right">
				<span><?php echo $cupon->cupon; ?></span>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="precio-carrito-sub">
				<span class="show-for-small-only text-right"><strong>Descuento</strong></span>
			</td>
			<td class="precio-carrito-sub prec-esp text-right">
				<span><strong>Descuento</strong></span>
			</td>
			<td class="precio-carrito-sub text-right">
				<span><?php
				if($cupon->descuento > 0 && $cupon->descuento < 1) {
					echo '-'.($cupon->descuento * 100).'%';
				} else if($cupon->descuento >= 1) {
					echo '-$'.$this->cart->format_number($cupon->descuento);
				}
				?></span>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="precio-carrito-sub">
				<span class="show-for-small-only text-right"><strong>Subtotal + Cupón</strong></span>
			</td>
			<td class="precio-carrito-sub prec-esp text-right">
				<span><strong>Subtotal + Cupón</strong></span>
			</td>
			<td class="precio-carrito-sub text-right">
				<span>$ <?php if($cupon->descuento > 0 && $cupon->descuento < 1) {
					echo $this->cart->format_number($pedido->subtotal * (1-$cupon->descuento));
				} else if($cupon->descuento >= 1) {
					echo $this->cart->format_number($pedido->subtotal - $cupon->descuento);
				} ?></span>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td colspan="2" class="precio-carrito-sub">
				<span class="show-for-small-only text-right"><strong>Envío</strong></span>
			</td>
			<td class="precio-carrito-sub prec-esp text-right">
				<span><strong>Envío</strong></span>
			</td>
			<td class="precio-carrito-sub text-right">
				<span>$<?php echo $this->cart->format_number($pedido->costo_envio); ?></span>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="precio-carrito-sub">
				<span class="show-for-small-only text-right"><strong>Total</strong></span>
			</td>
			<td class="precio-carrito-sub prec-esp text-right">
				<span><strong>Total</strong></span>
			</td>
			<td class="precio-carrito-sub text-right">
				<span><strong>$<?php echo $this->cart->format_number($pedido->total); ?></strong></span>
			</td>
		</tr>
	</tbody>
</table>
