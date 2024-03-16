<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Pedidos de productos de campaña</h2>
	</div>
</div>
<?php if(isset($pedidos)): ?>
	<div class="row">
		<div class="small-24 columns" id="subnav-productos">
			<table id="campanas" class="hover stripe cell-border order-column">
				<thead>
					<tr>
						<th>No.</th>
						<th>Cliente</th>
						<th>Fecha Pedido</th>
						<th>Items</th>
						<th>Subtotal</th>
						<th>Envío</th>
						<th>Total</th>
						<th>Método</th>
						<th>Pago</th>
						<th>Envío</th>
						<th>Factura</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th></th>
						<th>Cliente</th>
						<th>Fecha Pedido</th>
						<th>Items</th>
						<th>Subtotal</th>
						<th>Envío</th>
						<th>Total</th>
						<th>Método</th>
						<th>Pago</th>
						<th>Envío</th>
						<th>Factura</th>
						<th>Acciones</th>
					</tr>
				</tfoot>
				<tbody>
				<?php foreach($pedidos as $pedido): ?>
				<?php
					$customs = array();
					$design_ids = array();
					$enhances = array();
					$item_id = '';
					$enhance_id = 0;
					
					$i = 0;
					
					$productos = $this->pedidos_modelo->obtener_productos_por_pedido($pedido->id_pedido);
					// Customs
					foreach($productos as $item) {
						if($item->diseno != $item_id && !$item->id_enhance) {
							$customs[$i] = new stdClass();
							$customs[$i]->diseno = $item->diseno;
							$customs[$i]->id_producto = $item->id_producto;
							$customs[$i]->id_color = $item->id_color;
							$item_id = $item->diseno;
							$i++;
						}
					}
					
					foreach($customs as $indice=>$custom) {
						
						if(isset($custom->diseno)) {
							$diseno = $custom->diseno;
							$customs[$indice]->tallas = array(); 
							
							foreach($productos as $item) {
								if($item->diseno == $diseno) {
									$talla_cantidad = new stdClass();
									//$medida = json_decode
									$talla_cantidad->talla = json_decode($item->caracteristicas);
									$talla_cantidad->cantidad = $item->cantidad_producto;
									array_push($customs[$indice]->tallas, $talla_cantidad);
								}
							}
						}
					}
					
					foreach($customs as $indice=>$custom) {
						if(isset($custom->diseno)) {
							$customs[$indice]->diseno = json_decode($customs[$indice]->diseno);
							if(isset($customs[$indice]->diseno->images->front)) {
								$customs[$indice]->front_image = $customs[$indice]->diseno->images->front;
							}
							if(isset($customs[$indice]->diseno->images->back)) {
								$customs[$indice]->back_image = $customs[$indice]->diseno->images->back;
							}
							if(isset($customs[$indice]->diseno->images->left)) {
								$customs[$indice]->left_image = $customs[$indice]->diseno->images->left;
							}
							if(isset($customs[$indice]->diseno->images->right)) {
								$customs[$indice]->right_image = $customs[$indice]->diseno->images->right;
							}
						}
					}
					
					foreach($customs as $indice=>$custom) {
						if(!isset($custom->diseno)) {
							unset($customs[$indice]);
						}
					}
					
					// Enhances
					foreach($productos as $item) {
						if(!$item->diseno && $item->id_enhance != $enhance_id) {
							array_push($design_ids, $item->id_enhance);
						}
					}
					
					$design_ids = array_unique($design_ids);
					
					$i = 0;
					
					foreach($design_ids as $indice=>$did) {
						$enhances[$i] = new stdClass();
						$enhances[$i]->id_enhance = $did;
						$enhances[$i]->tallas = array(); 
						
						foreach($productos as $item) {
							if($item->id_enhance == $enhances[$i]->id_enhance && $item->id_enhance == $id_enhance) {
								$talla_cantidad = new stdClass();
								//$medida = json_decode
								$talla_cantidad->talla = json_decode($item->caracteristicas);
								$talla_cantidad->cantidad = $item->cantidad_producto;
								array_push($enhances[$i]->tallas, $talla_cantidad);
							}
						}
						
						$i++;
					}

				?>
					<?php if(sizeof($enhances) > 0): ?>
					<tr>
						<td><?php echo $pedido->id_pedido; ?> <i class="fa fa-<?php if($pedido->estatus_pedido == 'Completo') { echo 'check'; } else if($pedido->estatus_pedido == 'Cancelado') { echo 'times'; } else if($pedido->estatus_pedido == 'En Proceso') { echo 'circle-o-notch fa-spin fa-fw'; } ?>"></i></td>
						<td><?php echo $pedido->nombres.' '.$pedido->apellidos; ?></td>
						<td><?php echo date("Y/m/d H:i", strtotime($pedido->fecha_creacion)); ?></td>
						<td class="text-center"><?php echo $pedido->numero_productos; ?></td>
						<td class="text-right">$ <?php echo $this->cart->format_number($pedido->subtotal); ?></td>
						<td class="text-right">$ <?php echo $this->cart->format_number($pedido->costo_envio); ?></td>
						<td class="text-right">$ <?php echo $this->cart->format_number($pedido->total); ?></td>
						<td><?php 
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
						<td class="text-center"><?php if($pedido->estatus_pedido != 'Cancelado') { echo ($pedido->estatus_pago == 'paid' ? '<i class="fa fa-check"></i> Completo' : '<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Pendiente'); } else { echo '<i class="fa fa-times"></i> Cancelado'; } ?></td>
						<td class="text-center"><?php if($pedido->estatus_pedido != 'Cancelado') { echo ($pedido->codigo_rastreo ? '<i class="fa fa-truck"></i> Enviado' : '<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Pendiente'); } else { echo '<i class="fa fa-times"></i> Cancelado'; } ?></td>
						<td class="text-center"><?php echo ($pedido->id_direccion_fiscal ? '<i class="fa fa-check"></i>' : ''); ?></td>
						<td class="text-right"><a href="<?php echo site_url('administracion/pedidos/'.$pedido->id_pedido); ?>" class="action button"><i class="fa fa-search"></i> Ver pedido</a></td>
					</tr>
					<?php endif; ?>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

<?php else: ?>
	<p class="text-center" style="line-height:13;">Sin Pedidos.</p>
<?php endif; ?>