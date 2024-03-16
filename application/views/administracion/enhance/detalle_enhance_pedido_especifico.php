<div class="row" style="margin-bottom:1.5rem;">
	<div class="small-16 columns">
		<h3 class="text-center" style="font-size: 1.3rem;padding: 0.6rem;color: #0a749e;border-bottom: dotted 2px;">Pedido No. <?php echo $id_pedido; ?></h3>

		<div class="row collapse">
			<div class="small-24 columns">
				<table cellpadding="0" cellspacing="0" id="carrito" style="margin: 0.5% 0 1.4rem;width: 100%;">
					<thead>
						<tr>
							<th class="cantidades-carrito text-center"><span class="show-for-small-only">#</span><span class="show-for-medium">Cant.</span></th>
							<th class="text-left titulo-precio">Producto</th>
							<th class="text-center prec-esp titulo-precio">Precio</th>
							<th class="text-center titulo-precio">Subtotal</th>
						</tr>
					</thead>
					<tbody>
					<?php $suma = 0; ?>
					<?php foreach($pedido->productos as $inner_producto): ?>
						<?php if($inner_producto->id_enhance) {
							$info_enhanced = $this->catalogo_modelo->obtener_enhanced_con_id($inner_producto->id_enhance);
							$imagen = $info_enhanced->front_image;
							$nombre_producto = 'Campaña '.$info_enhanced->name;
						?>
						<tr>
							<?php if($inner_producto->id_enhance == $campana->id_enhance):  ?>
							<td class="cantidades-carrito">
								<div class="clearfix">
									<div class="square-button-area hide">
										<button type="button" class="square increase"><i class="fa fa-plus"></i></button>
										<button type="button" class="square decrease"><i class="fa fa-minus"></i></button>
									</div>
									<div class="square-cantidad">
										<input type="text" value="<?php echo $inner_producto->cantidad_producto ?>" class="qtyact" readonly />
									</div>
								</div>
							</td>
							<td class="info-carrito">
								<div class="clearfix">
									<img src="<?php echo site_url($imagen); ?>" alt="Fotografía del producto" class="carrito-foto" width="58" height="58" />
									<div class="carrito-descripcion">
										<span class="carrito-nombre-producto"><?php echo $nombre_producto; ?></span>
										<span>Talla: <?php echo caracteristicas_parse($inner_producto->caracteristicas); ?></span>
										<span>Color: <?php echo color_awesome($inner_producto->codigo_color); ?></span>
										<?php if($inner_producto->descuento_especifico != 0.00): ?>
										<span>Descuento: -<?php echo ($inner_producto->descuento_especifico); ?>%</span>
										<?php endif; ?>
									</div>
								</div>
							</td>
							<td class="precio-carrito prec-esp text-right">
								<span>$<?php echo $this->cart->format_number($inner_producto->precio_producto); ?></span>
							</td>
							<td class="precio-carrito text-right">
								<span>$<?php echo $this->cart->format_number($inner_producto->precio_producto * $inner_producto->cantidad_producto); ?></span>
							</td>
							<?php $suma += $inner_producto->precio_producto * $inner_producto->cantidad_producto; ?>
							<?php endif; ?>
						</tr>
						<?php } ?>
					<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td>
								<div class="clearfix">
									<div class="square-cantidad">
										<input style="height:auto;line-height:1;" type="text" value="<?php echo $this->enhance_modelo->obtener_total_vendidos_por_campana_por_pedido($campana->id_enhance, $id_pedido); ?>" class="qtyact" readonly />
									</div>
								</div>
							</td>
							<td class="info-carrito">
								<span style="min-height:0;font-size:0.8rem;">Envío cubierto en el pedido.</span>
							</td>
							<td class="precio-carrito prec-esp text-right">
								<span style="min-height:0;">TOTAL</span>
							</td>
							<td class="precio-carrito text-right">
								<span style="min-height:0;">$<?php echo $this->cart->format_number($suma); ?></span>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<div class="small-8 columns">
		<table class="campana_info" style="margin-top:1rem;">
			<tr>
				<th colspan="2" class="text-center">Datos de envío</th>
			</tr>
		</table>
	</div>
</div>
