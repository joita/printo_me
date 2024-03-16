<div class="row" style="margin-bottom:1.5rem;">
	<div class="small-16 columns">
		<h3 class="text-center" style="font-size: 1.3rem;padding: 0.6rem;color: #0a749e;border-bottom: dotted 2px;">Campaña <?php echo $indice_campana+1; ?> de <?php echo $tamano_campanas; ?></h3>

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
										<span class="carrito-nombre-producto"><?php echo $nombre_producto; ?> <?php if($inner_producto->id_producto == 42):?><span style="color: white; background: red; padding: 0.2rem 0.5rem; border-radius: 1rem; display: inline-block">PRODUCTO DE STOCK</span><?php endif;?></span>
										<span>Talla: <?php echo caracteristicas_parse2($inner_producto->caracteristicas); ?></span>
										<span>Color: <?php echo color_awesome($inner_producto->codigo_color); ?></span>
										<?php if($inner_producto->descuento_especifico != 0.00): ?>
										<span>Descuento: -<?php echo ($inner_producto->descuento_especifico); ?>%</span>
										<?php endif; ?>
										<a class="small button" href="<?php echo site_url('administracion/campanas/limitado/editar/'.($info_enhanced->id_parent_enhance == 0 ? $info_enhanced->id_enhance : $info_enhanced->id_parent_enhance)); ?>#fndtn-resumen_del_pedido" style="margin: 0.7rem 0 0;padding: 0.4rem 1.1rem;">Ir a diseño</a>
									</div>
								</div>
							</td>
							<td class="precio-carrito prec-esp text-right">
								<span>$<?php echo $this->cart->format_number($inner_producto->precio_producto); ?></span>
							</td>
							<td class="precio-carrito text-right">
								<span>$<?php echo $this->cart->format_number($inner_producto->precio_producto * $inner_producto->cantidad_producto); ?></span>
							</td>
							<?php endif; ?>
						</tr>
						<?php } ?>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="small-8 columns">
		<table class="campana_info hide" style="margin-top:1rem;">
			<tr>
				<th colspan="2" class="text-center">Datos de envío</th>
			</tr>
		</table>
	</div>
</div>
