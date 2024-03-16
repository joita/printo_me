<table width="300" style="padding:0;margin:0;border: solid 1px #0a749d;border-radius:3px;width: 100%;max-width: 500px;font-family: Verdana;background-image: url(<?php echo site_url('assets/images/agua.png'); ?>);background-position: -160px;background-repeat: no-repeat;">
	<tr>
		<th style="text-align:center;">
			<img src="<?php echo site_url('assets/images/header-logo.png'); ?>" width="150" height="43" alt="printome.mx" style="margin:15px auto" />
		</th>
	</tr>
	<tr>
		<td>
			<h3 style="text-align: center;margin: 0;line-height: 2;padding-top: 10px;font-weight: normal;color:#fa4c06">Confirmación de pago con tarjeta</h3>
			<div style="padding: 10px 15px;">
				<p style="font-size:13px;text-align:justify;">Hola <?php echo $nombre; ?>,</p>
				<p style="font-size:13px;text-align:justify;">Hemos recibido tu pago con tarjeta para el pedido <strong>No. <?php echo $numero_pedido; ?></strong> por un total de $ <?php echo number_format($total_pedido, 2, ".", ","); ?>. Vamos a preparar tus productos para enviar y apenas salga el envío te vamos a enviar el código de rastreo a tu correo electrónico.</p>
				<p style="font-size:13px;text-align:justify;">Si en tu pedido hay productos de campaña estos se manejarán por separado y recibirás información adicional con posterioridad.</p>
				
				<h4 class="paso" style="font-weight: normal;color:#fa4c06">Resumen del pedido</h4>
				<table id="carrito" style="font-family: Verdana;">
					<tbody>
					<?php foreach($this->cart->contents() as $items): ?>
						<?php $options = $this->cart->product_options($items['rowid']); ?>
						<tr class="entrada_carrito">
							<td class="cantidades-carrito" style="font-size:12px;">
								<?php echo $items['qty']; ?>
							</td>
							<td class="info-carrito" style="padding-bottom: 6px;">
								<img src="<?php echo getCustomImage($options); ?>" alt="Fotografía del producto" class="carrito-foto" width="48" height="48" style="margin:0 5px;" />
							</td>
							<td class="info-carrito">
								<div class="carrito-descripcion">
									<span class="carrito-nombre-producto" style="font-weight:bold;font-size:12px;display:block;"><?php echo $items['name'].($options["enhance"] != 'enhance' ? ' personalizada' : ''); ?></span>
									<?php if(isset($options['talla'])): ?>
									<span class="carrito-talla" style="font-size:12px;display:block;">Talla: <?php echo $options['talla']; ?></span>
									<?php endif; ?>
									<?php if(isset($options['id_enhance'])): ?>
									<span style="color:#0a749d;font-size:12px;display:block;">Producto de campaña</span>
									<?php endif; ?>
								</div>
							</td>
							<td class="precio-carrito text-right" style="text-align:right;">	
								<span style="font-size:12px;">$<?php echo $this->cart->format_number(($items['subtotal'])); ?></span>
							</td>
						</tr>
					<?php endforeach; ?>
				
						<tr>
							<td colspan="3" class="precio-carrito-sub" style="border-top: dotted 1px #CCC;padding-top:6px;">
								<span style="font-size:12px;text-align:right;display:block;">Subtotal</span>
							</td>
							<td class="precio-carrito-sub text-right" style="border-top: dotted 1px #CCC;padding-top:6px;">
								<span style="font-size:12px;text-align:right;display:block;">$<?php echo $this->cart->format_number($this->cart->obtener_subtotal()); ?></span>
							</td>
						</tr>
						<tr>
							<td colspan="3" class="precio-carrito-sub" style="padding-top:6px;">
								<span style="font-size:12px;text-align:right;display:block;">Envío</span>
							</td>
							<td class="precio-carrito-sub text-right" style="padding-top:6px;">
								<span style="font-size:12px;text-align:right;display:block;">$<?php echo $this->cart->format_number($this->cart->obtener_costo_envio()); ?></span>
							</td>
						</tr>
						<tr>
							<td colspan="3" class="precio-carrito-sub" style="padding-top:6px;">
								<span style="font-size:12px;text-align:right;display:block;"><strong>Total</strong></span>
							</td>
							<td class="precio-carrito-sub text-right" style="padding-top:6px;">
								<span style="font-size:12px;text-align:right;display:block;"><strong>$<?php echo  $this->cart->format_number($this->cart->obtener_total()); ?></strong></span>
							</td>
						</tr>
					</tbody>
				</table>
				
				<p style="font-size:13px;text-align:justify;">¡Gracias por comprar con nosotros!</p>
				<p style="font-size:13px;text-align:justify;color:#fa4c06;"></p>
				<p><a href="<?php echo base_url(); ?>" target="_blank" style="color:#055a7a;text-decoration:underline;font-size:13px;">https://printome.mx</a></p>
			</div>
		</td>
	</tr>
</table>