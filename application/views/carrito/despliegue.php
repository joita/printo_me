<div class="fgc pscat">
	<div class="row small-collapse medium-uncollapse">
		<div class="small-18 columns">
			<?php echo form_open('carrito/actualizar'); ?>
				<table cellpadding="0" cellspacing="0" id="carrito">
					<thead>
						<tr>
							<th class="cantidades-carrito text-center"><span class="show-for-small-only">#</span><span class="show-for-medium">Cant.</span></th>
							<th class="text-left titulo-precio">Producto</th>
							<th class="text-center prec-esp titulo-precio">Precio</th>
							<th class="text-center titulo-precio">Subtotal</th>
						</tr>
					</thead>
					<tbody>
					<?php $i = 1;  ?>
					<?php foreach($this->cart->contents() as $items): ?>
						<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
						<?php $options = $this->cart->product_options($items['rowid']); ?>
						<tr<?php echo ($options['enhance'] ? ($options['tipo_enhance'] == 'limitado' ? ' class="enhance"' : '') : ''); ?>>
							<td class="cantidades-carrito">
								<div class="clearfix">
									<div class="square-button-area hide">
										<button type="button" class="square increase"><i class="fa fa-plus"></i></button>
										<button type="button" class="square decrease"><i class="fa fa-minus"></i></button>
									</div>
									<div class="square-cantidad">
										<input type="text" name="<?php echo $i; ?>[qty]" value="<?php echo $items['qty']; ?>" class="qtyact" data-id="<?php echo $i; ?>" />
									</div>
								</div>
							</td>
							<td class="info-carrito">
								<div class="clearfix">
									<img src="<?php echo getCustomImage($options); ?>" alt="Fotografía del producto" class="carrito-foto" width="58" height="58" />
									<div class="carrito-descripcion">
										<span class="carrito-nombre-producto"><?php echo $items['name'].($options["enhance"] != 'enhance' ? ' personalizada' : ''); ?></span>
										<?php if(isset($options['talla'])): ?>
										<span class="carrito-talla">Talla: <?php echo $options['talla']; ?></span>
										<?php endif; ?>

										<?php if($options['enhance']): ?>
										<a href="<?php echo $this->enhance_modelo->obtener_link_ehnance($options['id_enhance']); ?>" class="more-cantidad" data-tipo="enhance"><i class="fa fa-plus-square"></i> Más<span> tallas</span></a>
										<?php
											$enhance = $this->enhance_modelo->obtener_enhance($options['id_enhance']);
											$sku_info = $this->productos_modelo->obtener_skus_activos_por_color($enhance->id_color, $options['sku']);
										?>
										<?php if($enhance->type == 'fijo'): ?>
										<a class="edit-cantidad fija" data-open="cantidades_campana" data-tipo="enhance" data-actual="<?php echo $sku_info[0]->cantidad_inicial/*'500'*/; ?>"><i class="fa fa-edit"></i> Editar<span> cantidad</span></a>
										<?php elseif($enhance->type == 'limitado'): ?>
										<a class="edit-cantidad limitada" data-open="cantidades_campana_limitada" data-tipo="enhance"><i class="fa fa-edit"></i> Editar<span> cantidad</span></a>
										<?php endif; ?>
										<a href="<?php echo site_url('carrito/quitar/'.$items['rowid']); ?>" class="borrar-cantidad"><i class="fa fa-trash"></i><span>Eliminar</span></a>
										<?php else: ?>
										<a class="edit-diseno-custom" data-id_producto="<?php echo $items['id']; ?>" data-id_color="<?php $info_color = $this->catalogo_modelo->obtener_id_color_con_id_producto_y_hex($items['id'], $options['disenos']['color']); echo $info_color->id_color; ?>" data-id_diseno="<?php echo $options['id_diseno']; ?>"><i class="fa fa-image"></i><span> Editar diseño</span></a>
										<a class="edit-cantidad-custom" data-open="cantidades_custom" data-id_color="<?php $info_color = $this->catalogo_modelo->obtener_id_color_con_id_producto_y_hex($items['id'], $options['disenos']['color']); echo $info_color->id_color; ?>" data-id_diseno="<?php echo $options['id_diseno']; ?>" data-tipo="custom"><i class="fa fa-edit"></i><span> Editar</span> Cantidad</a>
										<a href="<?php echo site_url('carrito/borrar_custom_en_carrito/'.$items['rowid'].'/'.$options['id_diseno']); ?>" data-id_fila="<?php echo $items['rowid']; ?>" data-id_diseno="<?php echo $options['id_diseno']; ?>" class="borrar-cantidad-custom"><i class="fa fa-trash"></i><span> Eliminar</span></a>
										<?php endif; ?>
									</div>
								</div>
							</td>
							<td class="precio-carrito prec-esp text-right">
								<span>$<?php echo $this->cart->format_number(($items['price'])); ?></span>
							</td>
							<td class="precio-carrito text-right">
								<span>$<?php echo $this->cart->format_number(($items['subtotal'])); ?></span>
							</td>
						</tr>
					<?php $i++; ?>
					<?php endforeach; ?>
						<tr>
							<td colspan="2" class="precio-carrito-sub">
								<span class="show-for-small-only text-right"><strong>Subtotal</strong></span>
							</td>
							<td class="precio-carrito-sub prec-esp text-right">
								<span><strong>Subtotal</strong></span>
							</td>
							<td class="precio-carrito-sub text-right">
								<span>$<?php echo $this->cart->format_number($this->cart->obtener_subtotal()); ?></span>
							</td>
						</tr>
						<?php if($this->cart->obtener_saldo_a_favor() > 0.00): ?>
						<tr>
							<td colspan="2" class="precio-carrito-sub">
								<span class="show-for-small-only text-right"><strong class="verde">Saldo a favor</strong></span>
							</td>
							<td class="precio-carrito-sub prec-esp text-right">
								<span><strong class="verde">Saldo a favor</strong></span>
							</td>
							<td class="precio-carrito-sub text-right">
								<span class="verde">-$<?php echo $this->cart->format_number($this->cart->obtener_saldo_a_favor()); ?></span>
							</td>
						</tr>
						<?php endif; ?>
						<tr>
							<td colspan="2" class="precio-carrito-sub">
								<span class="show-for-small-only text-right"><strong>Cupón</strong></span>
							</td>
							<td class="precio-carrito-sub prec-esp text-right">
								<span><strong>Cupón</strong></span>
							</td>
							<td class="precio-carrito-sub text-right">
								<div class="input-group" id="cupones">
								<?php if(!$this->session->descuento_global): ?>
									<input class="input-group-field" type="text" id="codigo-cupon">
									<div class="input-group-button">
										<button type="submit" class="button secondary" id="validar-cupon"><i class="fa fa-plus-circle"></i></button>
									</div>
								<?php else: ?>
									<input class="input-group-field" type="text" id="codigo-cupon-activo" readonly value="<?php echo $this->session->descuento_global->cupon; ?>">
									<div class="input-group-button">
										<button type="submit" class="button secondary" id="quitar-cupon"><i class="fa fa-times-circle"></i></button>
									</div>
								<?php endif; ?>
								</div>
							</td>
						</tr>
						<?php if($this->session->descuento_global): ?>
						<tr>
							<td colspan="2" class="precio-carrito-sub">
								<span class="show-for-small-only text-right"><strong>Descuento</strong></span>
							</td>
							<td class="precio-carrito-sub prec-esp text-right">
								<span><strong>Descuento</strong></span>
							</td>
							<td class="precio-carrito-sub text-right">
								<?php if($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1): ?>
								<span><strong class="verde">-<?php echo ($this->session->descuento_global->descuento * 100).'%'; ?></strong></span>
								<?php else: ?>
								<span><strong class="verde">-$<?php echo $this->cart->format_number($this->session->descuento_global->descuento); ?></strong></span>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="precio-carrito-sub">
								<span class="show-for-small-only text-right"><strong>Con descuento</strong></span>
							</td>
							<td class="precio-carrito-sub prec-esp text-right">
								<span><strong>Con descuento</strong></span>
							</td>
							<td class="precio-carrito-sub text-right">
                            <?php if($this->cart->obtener_saldo_a_favor() == 0): ?>
								<?php if($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1): ?>
								<span><strong class="verde">$<?php echo $this->cart->format_number(($this->cart->obtener_subtotal() * (1-$this->session->descuento_global->descuento))); ?></strong></span>
								<?php else: ?>
								<span><strong class="verde">$<?php echo $this->cart->format_number(($this->cart->obtener_subtotal()-$this->session->descuento_global->descuento)); ?></strong></span>
								<?php endif; ?>
                            <?php else: ?>
                                <?php if($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1): ?>
								<span><strong class="verde">$<?php echo $this->cart->format_number(($this->cart->obtener_subtotal()-$this->cart->obtener_saldo_a_favor()) * (1-$this->session->descuento_global->descuento)); ?></strong></span>
								<?php else: ?>
								<span><strong class="verde">$<?php echo $this->cart->format_number(($this->cart->obtener_subtotal()-$this->cart->obtener_saldo_a_favor()-$this->session->descuento_global->descuento)); ?></strong></span>
								<?php endif; ?>
                            <?php endif; ?>
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
								<span>$<?php echo $this->cart->format_number($this->cart->obtener_costo_envio()); ?></span>
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
								<span><strong>$<?php echo  $this->cart->format_number($this->cart->obtener_total()); ?></strong></span>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<div class="row collapse">
									<div class="small-18 columns text-center">
										<label id="individual">
											<i class="fa fa-truck"></i> Espera tus productos personalizados via <strong>DHL</strong> desde el <strong><?php fecha($recibir); ?></strong> (no aplica para productos de plazo definido).
										</label>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="5">
								<div class="row collapse">
									<div class="small-18 columns text-center">
										<label id="individual"><i class="fa fa-info-circle"></i> Los productos marcados en azul, pagan envío individual.</label>
									</div>
								</div>
							</td>
						</tr>
						<tr style="border-top:dashed 1px #EEE;">
							<td colspan="5">
								<div class="row collapse">
									<div class="small-9 columns">
										<a href="<?php echo site_url('compra'); ?>" class="small button" id="agmas"><i class="fa fa-cart-plus"></i><span class="show-for-medium"> Agregar Productos</span></a>
										<a href="<?php echo site_url('carrito/vaciar'); ?>" class="small error button" id="vaciar" onclick="if(typeof gtag != 'undefined') { gtag('event', 'Clic', {'event_category' : 'Carrito', 'event_label' : 'Vaciar'}); }"><i class="fa fa-trash"></i><span class="show-for-medium"> Vaciar</span></a>
										<button type="submit" id="actualizar_car" class="hide">Actualizar</button>
									</div>
									<div class="small-9 text-right columns" id="area_boton_pagar">
										<a id="link_abajo">
											<i class="fa fa-angle-down first animated infinite fadeIn"></i>
											<i class="fa fa-angle-down second animated infinite fadeIn"></i>
											<i class="fa fa-angle-down third animated infinite fadeIn"></i>
										</a>
										<a href="<?php echo site_url('carrito/pagar'); ?>" class="small success button" id="pagmas"><i class="fa fa-check"></i> Pagar</a>
									</div>
								</div>
							</td>
						</tr>
					</tfoot>
				</table>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<div class="small reveal" id="cantidades_campana" data-reveal>
	<form>
		<div class="row collapse">
			<div class="small-18 columns">
				<label>Nueva cantidad
					<select id="nueva_cantidad_campana">
						<option value=""></option>
					</select>
				</label>
			</div>
		</div>

		<div class="row collapse add-buttons">
			<div class="small-9 columns">
				<a data-close class="secondary button">Cancelar</a>
			</div>
			<div class="small-9 columns text-right">
				<input type="hidden" id="data_id" value="" />
				<button type="button" class="primary button" id="actualizar_campana_button">Actualizar</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="small reveal" id="cantidades_campana_limitada" data-reveal>
	<form>
		<div class="row collapse">
			<div class="small-18 columns">
				<label>Nueva cantidad
					<select id="nueva_cantidad_campana_limitada">
					<?php for($i=1;$i<101;$i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
				</label>
			</div>
		</div>

		<div class="row collapse add-buttons">
			<div class="small-9 columns">
				<a data-close class="secondary button">Cancelar</a>
			</div>
			<div class="small-9 columns text-right">
				<input type="hidden" id="data_id_limitada" value="" />
				<button type="button" class="primary button" id="actualizar_campana_limitada_button">Actualizar</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="small reveal" id="cantidades_custom" data-reveal>
	<form>
		<div id="con">

		</div>
		<div class="row collapse add-buttons">
			<div class="small-9 columns">
				<a data-close class="secondary button">Cancelar</a>
			</div>
			<div class="small-9 columns text-right">
				<input type="hidden" id="tallas_nuevas" value="" />
				<input type="hidden" id="design_id" value="" />
				<button type="button" class="primary button" id="actualizar_custom_button" data-tipo="" disabled="disabled">Actualizar</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
