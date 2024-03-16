<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title clearfix"><a href="<?php echo site_url('administracion/campanas/limitado/editar/'.$campana->id_enhance.'#pedidos_realizados'); ?>" class="coollink left" style="margin-right:1.5rem;">« Regresar</a> Diseños en venta » Plazo definido » <?php echo $campana->name; ?> (Folio: <?php echo $campana->id_enhance; ?>) » Pedido <?php echo $pedido->id_pedido; ?></h2>
	</div>
</div>
<?php $campana->diseno = json_decode($campana->design); ?>
<?php $campana->colores_por_lado = json_decode($campana->colores); ?>
<?php 
	$images = array();
	$des = json_decode($campana->design); 
	foreach($des as $nombre_lado=>$lado) {
		$images[$nombre_lado] = array();
		foreach($lado as $indice=>$inner_lado) {
			unset($lado[$indice]->svg);
			if(isset($lado[$indice]->url)) {
				array_push($images[$nombre_lado], $lado[$indice]->url);
			}
		}
	}
	$img_json = json_encode($images);
	
	$codigo_rastreo = $this->db->get_where('EnviosPorCampana', array('id_pedido' => $pedido->id_pedido, 'id_enhance' => $campana->id_enhance))->row();

?>
<div class="row">
	<div class="small-24 columns">
		<ul class="tabs hide">
			<li class="tab-title"><a href="<?php echo site_url('administracion/campanas/limitado/editar/'.$campana->id_enhance); ?>#resumen_del_pedido">Resumen del producto</a></li>
			<li class="tab-title"><a href="<?php echo site_url('administracion/campanas/limitado/editar/'.$campana->id_enhance); ?>#resumen_de_produccion">Tallas a producir</a></li>
			<li class="tab-title active"><a href="<?php echo site_url('administracion/campanas/limitado/editar/'.$campana->id_enhance); ?>#pedidos_realizados">Pedidos realizados</a></li>
		</ul>
		<div class="tabs-content">
			<div class="content active" style="padding:0;border:none;">
				<div class="row resumen-pedido">
					<div class="small-8 columns">
						<table class="campana_info">
							<tr>
								<th colspan="2" class="text-center">Datos del pedido</th>
							</tr>
							<tr>
								<th width="35%">Estatus</th>
								<td width="65%"><?php
									if(!isset($codigo_rastreo->codigo_rastreo)) {
										echo '<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> En proceso';
									} else {
										echo '<i class="fa fa-truck"></i> Enviado';
									}
								?></td>
							</tr>
							<tr>
								<th width="35%">Nombre</th>
								<td width="65%"><?php echo $pedido->nombres; ?> <?php echo $pedido->apellidos; ?></td>
							</tr>
							<tr>
								<th>E-Mail</th>
								<td><?php echo $pedido->email; ?></td>
							</tr>
							<tr>
								<th>No.</th>
								<td><?php echo str_pad($pedido->id_pedido, 8, "0", STR_PAD_LEFT); ?></td>
							</tr>
							<tr>
								<th>Productos</th>
								<td><?php echo $pedido->numero_productos; ?></td>
							</tr>
							<tr>
								<th>Subtotal</th>
								<td>$ <?php echo $this->cart->format_number($pedido->subtotal); ?></td>
							</tr>
							<?php if($pedido->descuento > 0.00): ?>
							<tr>
								<th>Saldo a favor</th>
								<td>-$ <?php echo $this->cart->format_number($pedido->descuento); ?></td>
							</tr>
							<tr>
								<th>Subtotal + Saldo a favor</th>
								<td>$ <?php echo $this->cart->format_number($pedido->subtotal - $pedido->descuento); ?></td>
							</tr>
							<?php endif; ?>
							<?php if($pedido->id_cupon): ?>
							<?php $cupon = $this->db->get_where('Cupones', array('id' => $pedido->id_cupon))->row(); ?>
							<tr>
								<th>Cupón</th>
								<td><?php echo $cupon->cupon; ?></td>
							</tr>
							<tr>
								<th>Descuento</th>
								<td><?php 
									if($cupon->descuento > 0 && $cupon->descuento < 1) { 
										echo '-'.($cupon->descuento * 100).'%';
									} else if($cupon->descuento >= 1) {
										echo '-$'.$this->cart->format_number($cupon->descuento);
									}
								?></td>
							</tr>
							<tr>
								<th>Subtotal con cupón</th>
								<td>$ <?php if($cupon->descuento > 0 && $cupon->descuento < 1) {
									echo $this->cart->format_number($pedido->subtotal * (1-$cupon->descuento));
								} else if($cupon->descuento >= 1) {
									echo $this->cart->format_number($pedido->subtotal - $cupon->descuento);
								} ?></td>
							</tr>
							<?php endif; ?>
							<tr>
								<th>Envío</th>
								<td>$ <?php echo $this->cart->format_number($pedido->costo_envio); ?></td>
							</tr>
							<tr>
								<th>Total</th>
								<td><strong>$ <?php echo $this->cart->format_number($pedido->total); ?></strong></td>
							</tr>
						</table>
					</div>
					<div class="small-8 columns">
						<table class="campana_info">
							<tr>
								<th colspan="2" class="text-center">Datos del pago</th>
							</tr>
							<tr>
								<th width="35%">Método</th>
								<td width="65%"><?php 
									if($pedido->metodo_pago == 'paypal') {
										echo '<span class="hide">PayPal</span><img class="payimg" src="'.site_url('assets/images/paypal.svg').'" alt="PayPal" />';
									} else if($pedido->metodo_pago == 'card_payment') {
										echo '<span class="hide">Tarjeta</span><img class="payimg" src="'.site_url('assets/images/visa_mc_amex.svg').'" alt="Tarjeta" />';
									} else if($pedido->metodo_pago == 'cash_payment') {
										echo '<span class="hide">OXXO</span><img class="payimg" src="'.site_url('assets/images/oxxo.svg').'" alt="OXXO" />';
									} else if($pedido->metodo_pago == 'stripe') {
                                        echo '<span class="hide">Stripe</span><img class="payimg" src="'.site_url('assets/images/stripe.png').'" alt="Stripe" />';
                                    }
								?></td>
							</tr>
							<tr>
								<th>Estatus</th>
								<td><?php echo ($pedido->estatus_pago == 'paid' ? '<i class="fa fa-check"></i> Completo' : '<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Pendiente'); ?></td>
							</tr>
							<tr>
								<th colspan="2" class="text-center">Referencia</th>
							</tr>
							<tr>
								<td colspan="2" class="text-center"><?php echo $pedido->referencia_pago; ?></td>
							</tr>
							<?php if($pedido->estatus_pago == 'paid'): ?>
							<tr>
								<th colspan="2" class="text-center">Fecha de pago</th>
							</tr>
							<tr>
								<td colspan="2" class="text-center"><?php echo ($pedido->estatus_pago == 'paid' ? date("d/m/Y H:i:s", strtotime($pedido->fecha_pago)) : ''); ?></td>
							</tr>
							<?php endif; ?>
                            <tr>
                                <th>Acepto términos <br> y condiciones</th>
                                <td><?php echo ($pedido->terminos == 1 ? date("d/m/Y H:i:s", strtotime($pedido->fecha_terminos)) : 'No ha aceptado'); ?></td>
                            </tr>
						</table>
					</div>
					<div class="small-8 columns">
						<table class="campana_info">
							<tr>
								<th colspan="2" class="text-center">Dirección de envío</th>
							</tr>
							<tr>
								<td colspan="2" style="padding:8px 10px;">
									<strong style="color: #0a749e;"><?php echo $pedido->identificador_direccion; ?></strong><br />
									<?php echo $pedido->linea1; ?><br />
									<?php if($pedido->linea2 != '') { echo $pedido->linea2.'<br />'; } ?>
									Código Postal: <?php echo $pedido->codigo_postal; ?><br />
									<?php echo $pedido->ciudad.', '.$pedido->estado.', '.$pedido->pais; ?>
								</td>
							</tr>
						</table>
						
						
						<table class="campana_info">
							<tr>
								<th colspan="2" class="text-center">Datos de facturación</th>
							</tr>
							<tr>
								<td colspan="2" style="padding:8px 10px;">
								<?php if($pedido->id_direccion_fiscal): ?>
									<?php $direccion_fiscal = $this->cuenta_modelo->obtener_direcciones_fiscales($pedido->id_cliente, $pedido->id_direccion_fiscal); ?>
									<strong style="color: #0a749e;"><?php echo $direccion_fiscal[0]->razon_social; ?> (<?php echo $direccion_fiscal[0]->rfc; ?>)</strong><br />
									<?php echo $direccion_fiscal[0]->linea1; ?><br />
									<?php if($direccion_fiscal[0]->linea2 != '') { echo $direccion_fiscal[0]->linea2.'<br />'; } ?>
									Código Postal: <?php echo $direccion_fiscal[0]->codigo_postal; ?><br />
									Teléfono: <?php echo $direccion_fiscal[0]->telefono; ?><br />
									Correo electrónico: <?php echo $direccion_fiscal[0]->correo_electronico_facturacion; ?><br />
									<?php echo $pedido->ciudad.', '.$pedido->estado.', '.$pedido->pais; ?>
								<?php else: ?>
									No requiere facturar.
								<?php endif; ?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			
				<div class="row resumen-pedido">
					<div class="small-16 columns">
						<?php $this->load->view('administracion/enhance/pedido_especifico_limitado_carrito'); ?>
					</div>
					<div class="small-8 columns">
						<table class="campana_info">
							<tr>
								<th colspan="2" class="text-center">Generación de PDFs</th>
							</tr>
							<tr>
								<td colspan="2" class="text-center">
									<a href="<?php echo site_url('administracion/pedidos/pdf_pedido/'.$pedido->id_pedido); ?>" class="button pdfmaker" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF Pedido</a>
								</td>
							</tr>
						</table>
						
						<table class="campana_info">
							<tr>
								<th colspan="2" class="text-center">Datos de envío</th>
							</tr>
							<?php if(!isset($codigo_rastreo->codigo_rastreo)): ?>
							<tr>
								<form method="post" action="<?php echo site_url('administracion/campanas/limitado/editar/'.$campana->id_enhance.'/pedidos/'.$pedido->id_pedido.'/asignar_guia'); ?>" data-abide>
									<th class="text-right" style="vertical-align:middle;">
										Número de guía
									</th>
									<td class="text-left">
										<div class="row collapse">
											<div class="small-14 columns">
												<input type="text" name="codigo_rastreo" id="codigo_rastreo" required />
											</div>
											<div class="small-10 columns">
												<button type="submit" id="asignar_codigo"><i class="fa fa-truck"></i> Asignar</button>
											</div>
										</div>
									</th>
								</form>
							</tr>
							<?php else: ?>
							<tr>
								<th>Número de guía</th>
								<td><strong><a href="<?php echo site_url('carrito/abrir_dhl_limitado/'.$codigo_rastreo->codigo_rastreo); ?>" target="_blank"><?php echo $codigo_rastreo->codigo_rastreo; ?></a></strong></td>
							</tr>
							<?php endif; ?>
						</table>
						
						<?php if(isset($codigo_rastreo->codigo_rastreo)): ?>
						<?php if($codigo_rastreo->codigo_rastreo != ''): ?>
						<table class="campana_info" style="margin-top:4rem;">
							<tr>
								<th colspan="2" class="text-center">Actualizar código de envío</th>
							</tr>
							<tr>
								<form method="post" action="<?php echo site_url('administracion/campanas/limitado/editar/'.$campana->id_enhance.'/pedidos/'.$pedido->id_pedido.'/asignar_guia'); ?>" data-abide>
									<th class="text-right" style="vertical-align:middle;">
										Nuevo número de guía
									</th>
									<td class="text-left">
										<div class="row collapse">
											<div class="small-14 columns">
												<input type="text" name="codigo_rastreo" id="codigo_rastreo" required />
											</div>
											<div class="small-10 columns">
												<button type="submit" id="asignar_codigo"><i class="fa fa-truck"></i> Asignar</button>
											</div>
										</div>
									</th>
								</form>
							</tr>
						</table>
						<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
