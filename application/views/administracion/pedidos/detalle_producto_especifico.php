<div class="row">
	<div class="small-24 columns">
		<h3 class="text-center" style="font-size: 1.3rem;padding: 0.6rem;color: #0a749e;border-bottom: dotted 2px;">Producto <?php echo $indice_custom+1; ?> de <?php echo $tamano_customs; ?></h3>

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
						<?php if(!$inner_producto->id_enhance) {

							$imagen_json = json_decode($inner_producto->diseno);
							$imagen_json_2 = $imagen_json->images;
							$imagen = $imagen_json_2->front;

							$nombre_producto = $inner_producto->nombre_producto;
						?>
						<tr>
							<?php if($imagen == $producto->front_image):  ?>
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
										<span>Talla: <?php echo caracteristicas_parse2($inner_producto->caracteristicas); ?></span>
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
							<?php endif; ?>
						</tr>
						<?php } ?>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="small-24 columns">
				<ul class="small-block-grid-2" id="campana_imagenes" style="margin-bottom:2rem;">
					<?php if(isset($producto->front_image)): ?>
					<?php $this->load->view('administracion/pedidos/pedido_custom_lado', array('campana' => $producto, 'lado' => 'front', 'color_fondo' => $pedido->productos[0]->codigo_color)); ?>
					<?php endif; ?>
					<?php if(isset($producto->back_image)): ?>
					<?php $this->load->view('administracion/pedidos/pedido_custom_lado', array('campana' => $producto, 'lado' => 'back', 'color_fondo' => $pedido->productos[0]->codigo_color)); ?>
					<?php endif; ?>
					<?php if(isset($producto->right_image)): ?>
					<?php $this->load->view('administracion/pedidos/pedido_custom_lado', array('campana' => $producto, 'lado' => 'right', 'color_fondo' => $pedido->productos[0]->codigo_color)); ?>
					<?php endif; ?>
					<?php if(isset($producto->left_image)): ?>
					<?php $this->load->view('administracion/pedidos/pedido_custom_lado', array('campana' => $producto, 'lado' => 'left', 'color_fondo' => $pedido->productos[0]->codigo_color)); ?>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
