<table width="300" style="padding:0;margin:0;border: solid 1px #0a749d;border-radius:3px;width: 100%;max-width: 500px;font-family: Verdana;background-image: url(<?php echo site_url('assets/images/agua.png'); ?>);background-position: -160px;background-repeat: no-repeat;">
  <tr>
    <th style="text-align:center;">
      <img src="<?php echo site_url('assets/images/header-logo.png'); ?>" width="150" height="43" alt="printome.mx" style="margin:15px auto" />
    </th>
  </tr>
	<tr>
		<td>
			<h3 style="text-align: center;margin: 0;line-height: 2;padding-top: 10px;font-weight: normal;color:#fa4c06">Confirmación de pedido</h3>
			<div style="padding: 10px 15px;">
				<p style="font-size:13px;text-align:justify;">Hola, <?php echo $nombre; ?>,</p>
				<p style="font-size:13px;text-align:justify;">Hemos recibido tu pedido por un monto total de <strong>$<?php echo number_format($total_pedido, 2, ".", ","); ?></strong> con número <strong><?php echo $numero_pedido; ?></strong>. Vamos a confirmar tu pago con PayPal y una vez confirmado, preparar tus productos para enviar. Apenas salga el envío te vamos a enviar el código de rastreo a tu correo electrónico.</p>
				<p style="font-size:13px;text-align:justify;">Si en tu pedido hay productos de campaña estos se manejarán por separado y recibirás información adicional con posterioridad.</p>
				
				<h4 class="paso" style="font-weight: normal;color:#fa4c06">Resumen del pedido</h4>
				<table id="carrito" style="font-family: Verdana;">
					<tbody>
					<?php foreach($this->pedidos_modelo->obtener_productos_por_pedido($id_pedido) as $producto): ?>
					<?php if($producto->id_enhance) {
						$info_enhanced = $this->catalogo_modelo->obtener_enhanced_con_id($producto->id_enhance);
						$imagen = $info_enhanced->front_image;
						$nombre_producto = 'Campaña '.$info_enhanced->name;
					} else {
						$imagen_json = json_decode($producto->diseno);
						$imagen_json_2 = $imagen_json->images;
						$imagen = $imagen_json_2->front;
						
						$nombre_producto = $producto->nombre_producto;
					} ?>
					
						<tr class="entrada_carrito">
							<td class="cantidades-carrito" style="font-size:12px;">
								<?php echo $producto->cantidad_producto; ?>
							</td>
							<td class="info-carrito" style="padding-bottom: 6px;">
								<img src="<?php echo site_url($imagen); ?>" alt="Fotografía del producto" class="carrito-foto" width="48" height="48" style="margin:0 5px;" />
							</td>
							<td class="info-carrito">
								<div class="carrito-descripcion">
									<span class="carrito-nombre-producto" style="font-weight:bold;font-size:12px;display:block;"><?php echo $nombre_producto; ?></span>
									<?php if(isset($producto->caracteristicas)): ?>
									<span class="carrito-talla" style="font-size:12px;display:block;">Talla: <?php echo caracteristicas_parse($producto->caracteristicas); ?></span>
									<?php endif; ?>
									<?php if($producto->id_enhance): ?>
									<span style="color:#0a749d;font-size:12px;display:block;">Producto de campaña</span>
									<?php endif; ?>
								</div>
							</td>
							<td class="precio-carrito text-right" style="text-align:right;">	
								<span style="font-size:12px;">$<?php echo $this->cart->format_number($producto->precio_producto * $producto->cantidad_producto); ?></span>
							</td>
						</tr>
					<?php endforeach; ?>
				
						<tr>
							<td colspan="3" class="precio-carrito-sub" style="border-top: dotted 1px #CCC;padding-top:6px;">
								<span style="font-size:12px;text-align:right;display:block;">Subtotal</span>
							</td>
							<td class="precio-carrito-sub text-right" style="border-top: dotted 1px #CCC;padding-top:6px;">
								<span style="font-size:12px;text-align:right;display:block;">$<?php echo $this->cart->format_number($subtotal_pedido); ?></span>
							</td>
						</tr>
						<tr>
							<td colspan="3" class="precio-carrito-sub" style="padding-top:6px;">
								<span style="font-size:12px;text-align:right;display:block;">Envío</span>
							</td>
							<td class="precio-carrito-sub text-right" style="padding-top:6px;">
								<span style="font-size:12px;text-align:right;display:block;">$<?php echo $this->cart->format_number($costo_envio); ?></span>
							</td>
						</tr>
						<tr>
							<td colspan="3" class="precio-carrito-sub" style="padding-top:6px;">
								<span style="font-size:12px;text-align:right;display:block;"><strong>Total</strong></span>
							</td>
							<td class="precio-carrito-sub text-right" style="padding-top:6px;">
								<span style="font-size:12px;text-align:right;display:block;"><strong>$<?php echo  $this->cart->format_number($total_pedido); ?></strong></span>
							</td>
						</tr>
					</tbody>
				</table>
				
				
				<p style="font-size:13px;text-align:justify;">¡Gracias por comprar con nosotros!</p>
				<p><a href="<?php echo base_url(); ?>" target="_blank" style="color:#055a7a;text-decoration:underline;font-size:13px;">https://printome.mx</a></p>
			</div>
		</td>
	</tr>
</table>