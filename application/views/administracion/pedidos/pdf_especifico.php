<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css">
	<?php $this->load->view('carrito/estilos_pdf.css'); ?>
	</style>
</head>
<body>

	<div id="header">
		<table>
			<tr>
				<td><img src="<?php echo APPPATH. '../public/assets/images/header-logo-retina.png'; ?>" alt="" height="70"></td>
				<td style="text-align: right;">
					<table id="info">
						<tr>
							<td>No. del pedido:</td>
							<th><?php echo str_pad($pedido->id_pedido, 8, "0", STR_PAD_LEFT); ?></th>
						</tr>
						<tr>
							<td>Fecha del pedido:</td>
							<th><?php echo date("d/m/Y H:i:s", strtotime($pedido->fecha_pago)); ?></th>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<fieldset id="datos">
		<legend>Datos del Cliente</legend>
		<table width="100%">
			<tr>
				<td width="40%" valign="top">
					<p>Nombre: <br><strong><?php echo $pedido->nombres . " " . $pedido->apellidos; ?></strong></p>
					<p>E-Mail: <br><strong><?php echo $pedido->email ?></strong></p>
                    <p># Pedidos Realizados: <br><strong><?php echo $cantidad_pedidos ?></strong></p>
					<p>Método de pago: <br><strong><?php
						if($pedido->metodo_pago == 'paypal') {
							echo 'PayPal';
						} else if($pedido->metodo_pago == 'card_payment') {
							echo 'Tarjeta';
						} else if($pedido->metodo_pago == 'cash_payment') {
							echo 'OXXO';
						} else if($pedido->metodo_pago == 'spei') {
							echo 'SPEI';
						} else if($pedido->metodo_pago == 'stripe') {
                            echo 'Stripe';
                        }
					?></strong></p>
				</td>
				<td width="60%" valign="top">
					<p><strong style="border-bottom: solid 1px;font-weight:normal;">Dirección de entrega:</strong> <br><strong><?php echo $pedido->linea1."<br>".$pedido->linea2.", CP: ".$pedido->codigo_postal." <br>" .  $pedido->ciudad. "  " .  $pedido->estado; ?></strong></p>
					<p><strong style="border-bottom: solid 1px;font-weight:normal;">Teléfono:</strong> <br><strong><?php echo $pedido->dirtel; ?></strong></p>

					<?php if($pedido->id_direccion_fiscal): ?>
					<p><strong style="border-bottom: solid 1px;font-weight:normal;">Datos de facturación</strong><br />
					<?php $direccion_fiscal = $this->cuenta_modelo->obtener_direcciones_fiscales($pedido->id_cliente, $pedido->id_direccion_fiscal); ?>
					<strong><?php echo $direccion_fiscal[0]->razon_social; ?> (<?php echo $direccion_fiscal[0]->rfc; ?>)</strong><br />
					<?php echo $direccion_fiscal[0]->linea1; ?><br />
					<?php if($direccion_fiscal[0]->linea2 != '') { echo $direccion_fiscal[0]->linea2.'<br />'; } ?>
					Código Postal: <?php echo $direccion_fiscal[0]->codigo_postal; ?><br />
					Teléfono: <?php echo $direccion_fiscal[0]->telefono; ?><br />
					Correo electrónico: <?php echo $direccion_fiscal[0]->correo_electronico_facturacion; ?><br />
					<?php echo $pedido->ciudad.', '.$pedido->estado.', '.$pedido->pais; ?>
					</p>
					<?php endif; ?>
				</td>
			</tr>
		</table>
	</fieldset>

	<fieldset id="pedido">
		<legend>Resumen del Pedido</legend>

		<table cellpadding="6" cellspacing="1" width="100%" border="0" id="carrito">
			<thead>
				<tr>
					<th width="5%">#</th>
					<th width="10%">Foto</th>
					<th width="51%">Producto</th>
					<th width="17%">Precio</th>
					<th width="17%">Subtotal</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($pedido->productos as $producto): ?>
				<tr<?php if(isset($producto->especial)) { if($producto->especial) { echo ' style="background:#daefff"'; } } ?>>
					<td style="text-align:center;"><?php echo $producto->cantidad_producto ?></td>
					<td><img src="<?php echo APPPATH. '../public/'.$producto->imagen_principal; ?>" alt="" style="width:1.2cm;height:auto;"></td>
					<td>
						<strong><?php echo $producto->nombre_principal; ?></strong><?php echo ($producto->id_producto == 42 ? "<span style='color: red; font-weight: bold'> - PRODUCTO DE STOCK</span>":"")?><br>
						<span>SKU:  <strong><?php echo $producto->sku; ?></strong>, <span>Talla: <?php echo caracteristicas_parse2($producto->caracteristicas); ?></span><br>
						<?php if(isset($producto->especial)): ?>
						<?php if($producto->especial): ?>
						<span>Fecha finalización: <strong><?php echo date("d/m/Y", strtotime($producto->end_date)); ?></strong></span><br>
						<?php endif; ?>
						<?php endif; ?>
						<span>Color: <div style="height:18px;width:18px;background-color:<?php echo $producto->codigo_color; ?>;border:solid 1px #CCC;display:inline-block;"></div></span>
					</td>
					<td style="text-align: right;">$ <?php echo $this->cart->format_number($producto->precio_producto); ?></td>
					<td style="text-align: right;">$ <?php echo $this->cart->format_number($producto->precio_producto * $producto->cantidad_producto); ?></td>
				</tr>
				<?php endforeach; ?>
				<?php $cupon = $this->db->get_where('Cupones', array('id' => $pedido->id_cupon))->row(); ?>
				<tr style="line-height:2.2;">
					<td colspan="4" style="text-align: right;"><strong>Subtotal</strong></td>
					<td style="text-align: right;">$ <?php echo $this->cart->format_number($pedido->subtotal); ?></td>
				</tr>
				<?php if($pedido->descuento > 0.00): ?>
				<tr style="line-height:2.2;">
					<td colspan="4" style="text-align: right;"><strong class="verde">Saldo a favor</strong></td>
					<td style="text-align: right;" class="verde">-$ <?php echo $this->cart->format_number($pedido->descuento); ?></td>
				</tr>
				<tr style="line-height:2.2;">
					<td colspan="4" style="text-align: right;" class="verde"><strong>Subtotal + Saldo a favor</strong></td>
					<td style="text-align: right;" class="verde">$ <?php echo $this->cart->format_number($pedido->subtotal - $pedido->descuento); ?></td>
				</tr>
				<?php endif; ?>
				<?php if($pedido->id_cupon): ?>
			
				<tr style="line-height:2.2;">
					<td colspan="4" style="text-align: right;"><strong class="verde">Cupón</strong></td>
					<td style="text-align: right;" class="verde"><?php echo $cupon->cupon; ?></td>
				</tr>
				<tr style="line-height:2.2;">
					<td colspan="4" style="text-align: right;"><strong class="verde">Descuento</strong></td>
					<td style="text-align: right;" class="verde"><?php
						if($cupon->descuento > 0 && $cupon->descuento < 1) {
							echo '-'.($cupon->descuento * 100).'%';
						} else if($cupon->descuento >= 1) {
							echo '-$'.$this->cart->format_number($cupon->descuento);
						} else if($cupon->tipo == 4){
							echo '-$'.$this->cart->format_number($pedido->costo_envio);
						}
					?></td>
				</tr>
				<tr style="line-height:2.2;">
					<td colspan="4" style="text-align: right;" class="verde"><strong>Subtotal con cupón</strong></td>
					<td style="text-align: right;" class="verde">$ <?php if($cupon->descuento > 0 && $cupon->descuento < 1) {
						echo $this->cart->format_number($pedido->subtotal * (1-$cupon->descuento));
					} else if($cupon->descuento >= 1) {
						echo $this->cart->format_number($pedido->subtotal - $cupon->descuento);
					}else if($cupon->tipo == 4){
						echo $this->cart->format_number($pedido->subtotal);
					}?></td>
				</tr>
				<?php endif; ?>
				<tr style="line-height:2.2;">
					<td colspan="4" style="text-align: right;"><strong>Costo de Envío</strong></td>
					<td style="text-align: right;">$ <?php 
					if($cupon->tipo == 4){
						echo '0.00';
                    }else{
						echo $this->cart->format_number($pedido->costo_envio); 
					}?></td>
				</tr>
				<tr style="line-height:2.2;">
					<td colspan="4" style="text-align: right;border-bottom:none;"><strong>Total</strong></td>
					<td style="text-align: right;border-bottom:none;"><strong>$ <?php echo $this->cart->format_number($pedido->total); ?></strong></td>
				</tr>
			</tbody>
		</table>

	</fieldset>

</body>
</html>
