<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title clearfix"><a href="<?php echo site_url('administracion/campanas/limitado'); ?>" class="coollink left" style="margin-right:1.5rem;">« Regresar</a> Diseños en venta » Plazo definido » <?php echo $campana->name; ?> (Folio: <?php echo $campana->id_enhance; ?>) </h2>
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

	foreach($campanas_adicionales as $indice_adicional=>$campana_adicional) {
		$campanas_adicionales[$indice_adicional]->diseno = json_decode($campana_adicional->design);
		$campanas_adicionales[$indice_adicional]->colores_por_lado = json_decode($campana_adicional->colores);
	}
?>
<div class="row">
	<div class="small-24 columns">
		<ul class="tabs" data-tab data-options="deep_linking:true;scroll_to_content: false">
			<li class="tab-title active"><a href="#resumen_del_pedido">Resumen del producto</a></li>
			<li class="tab-title"><a href="#resumen_de_produccion">Tallas a producir</a></li>
			<li class="tab-title"><a href="#pedidos_realizados">Pedidos realizados</a></li>
			<li class="tab-title"><a href="#info_pagos">Información de pago</a></li>
		</ul>
		<div class="tabs-content">
			<div class="content active" style="padding: 1.2rem 1.2rem;" id="resumen_del_pedido">
				<div class="row">
					<div class="small-16 columns">
						<ul class="small-block-grid-2" id="campana_imagenes">
							<?php $color_info = $this->db->get_where('ColoresPorProducto', array('id_color' => $campana->id_color))->row(); ?>
							<?php if(isset($campana->front_image)): ?>
							<?php $this->load->view('administracion/enhance/enhance_lado', array('campana' => $campana, 'lado' => 'front', 'color_fondo' => $color_info->codigo_color)); ?>
							<?php endif; ?>
							<?php if(isset($campana->back_image)): ?>
							<?php $this->load->view('administracion/enhance/enhance_lado', array('campana' => $campana, 'lado' => 'back', 'color_fondo' => $color_info->codigo_color)); ?>
							<?php endif; ?>
							<?php if(isset($campana->right_image)): ?>
							<?php $this->load->view('administracion/enhance/enhance_lado', array('campana' => $campana, 'lado' => 'right', 'color_fondo' => $color_info->codigo_color)); ?>
							<?php endif; ?>
							<?php if(isset($campana->left_image)): ?>
							<?php $this->load->view('administracion/enhance/enhance_lado', array('campana' => $campana, 'lado' => 'left', 'color_fondo' => $color_info->codigo_color)); ?>
							<?php endif; ?>
						</ul>
						<?php foreach($campanas_adicionales as $campana_adicional): ?>
							<ul class="small-block-grid-2 campana_imagenes">
								<?php $color_info = $this->db->get_where('ColoresPorProducto', array('id_color' => $campana_adicional->id_color))->row(); ?>
								<?php if(isset($campana_adicional->front_image)): ?>
								<?php $this->load->view('administracion/enhance/enhance_lado', array('campana' => $campana_adicional, 'lado' => 'front', 'color_fondo' => $color_info->codigo_color)); ?>
								<?php endif; ?>
								<?php if(isset($campana_adicional->back_image)): ?>
								<?php $this->load->view('administracion/enhance/enhance_lado', array('campana' => $campana_adicional, 'lado' => 'back', 'color_fondo' => $color_info->codigo_color)); ?>
								<?php endif; ?>
								<?php if(isset($campana_adicional->right_image)): ?>
								<?php $this->load->view('administracion/enhance/enhance_lado', array('campana' => $campana_adicional, 'lado' => 'right', 'color_fondo' => $color_info->codigo_color)); ?>
								<?php endif; ?>
								<?php if(isset($campana_adicional->left_image)): ?>
								<?php $this->load->view('administracion/enhance/enhance_lado', array('campana' => $campana_adicional, 'lado' => 'left', 'color_fondo' => $color_info->codigo_color)); ?>
								<?php endif; ?>
							</ul>
						<?php endforeach; ?>
					</div>
					<div class="small-8 columns" style="padding:0;">
						<?php if($corte && $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance) > 0): ?>
						<?php if($corte->monto_corte >= 0): ?>
						<table class="campana_info">
							<tr>
								<th colspan="2" class="text-center">Decisión de producción</th>
							</tr>
							<?php if($corte->decision_produccion == 0): ?>
							<tr>
								<td width="50%" class="text-center"><a class="expand action button success" data-reveal-id="producir_campana"><i class="fa fa-check"></i> Producir</a></td>
								<td width="50%" class="text-center"><a class="expand action button alert" data-reveal-id="no_producir_campana"><i class="fa fa-times"></i> No producir</a></td>
							</tr>
							<?php elseif($corte->decision_produccion == 1): ?>
							<tr>
								<td colspan="2" class="text-justify">Se decidió que el producto si va a pasar a producción el <?php echo date("d/m/Y", strtotime($corte->fecha_decision_produccion)); ?> a las <?php echo date("H:i:s", strtotime($corte->fecha_decision_produccion)); ?></td>
							</tr>
							<?php elseif($corte->decision_produccion == 2): ?>
							<tr>
								<td colspan="2" class="text-justify">Se decidió que el producto no va a pasar a producción el <?php echo date("d/m/Y", strtotime($corte->fecha_decision_produccion)); ?> a las <?php echo date("H:i:s", strtotime($corte->fecha_decision_produccion)); ?></td>
							</tr>
							<?php endif; ?>
						</table>
						<?php endif; ?>
						<?php endif; ?>
						<table class="campana_info">
							<tr>
								<th colspan="4" class="text-center">Acciones</th>
							</tr>
							<tr>
								<td colspan="4">
									<?php if(!$campana->estatus || $campana->estatus != 1): ?>
									<a href="<?php echo site_url('administracion/campanas/limitado/aprobar/'.$campana->id_enhance); ?>" class="action button success"><i class="fa fa-check"></i> <?php if($campana->estatus == 3) { echo 'Reiniciar'; } else { echo 'Aprobar'; } ?></a>
									<?php endif; ?>
									<?php if(!$campana->estatus || $campana->estatus != 2 && $campana->estatus != 3): ?>
									<a href="#" data-reveal-id="rechazar_campana" class="action button warning"><i class="fa fa-times"></i> Rechazar</a>
									<?php endif; ?>
									<?php if($campana->estatus == 1): ?>
									<a href="#" data-reveal-id="terminar_campana" class="action button secondary"><i class="fa fa-ban"></i> Terminar</a>
									<?php endif; ?>
									<a href="#" data-reveal-id="borrar_campana" class="action button alert right"><i class="fa fa-trash-o"></i> Borrar</a>
								</td>
							</tr>
						</table>
                        <table class="campana_info">
                            <form action="<?php echo site_url('administracion/campanas/limitado/cambiar_nombre_campana/'.$campana->id_enhance); ?>" method="post">
                                <tr>
                                    <th colspan="4" class="text-center">Cambiar Nombre</th>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <input type="text" name='nuevo_nombre' autocomplete="off" value="<?php echo $campana->name?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <button class="action button expand secondary"><i class="fa fa-refresh"></i> Actualizar</button>
                                    </td>
                                </tr>
                            </form>
                        </table>
						<table class="campana_info">
							<form action="<?php echo site_url('administracion/campanas/limitado/actualizar_clasificacion/'.$campana->id_enhance); ?>" method="post">
								<tr>
									<th colspan="4" class="text-center">Clasificación</th>
								</tr>
								<tr>
									<td colspan="4">
										<select name="id_clasificacion" style="margin-bottom:0;" required>
                                        <?php foreach($clasificaciones as $clasificacion): ?>
                                            <optgroup label="<?php echo $clasificacion->nombre_clasificacion; ?>">
                                                <option value="<?php echo $clasificacion->id_clasificacion; ?>"<?php if(!$campana->id_subclasificacion) { if($clasificacion->id_clasificacion == $campana->id_clasificacion) { echo ' selected'; } } ?>><?php echo $clasificacion->nombre_clasificacion; ?> General (sin subclasificación)</option>
                                                <?php if(sizeof($clasificacion->subclasificaciones) > 0): ?>
                                                    <?php foreach($clasificacion->subclasificaciones as $subclasificacion): ?>
                                                        <option value="<?php echo $clasificacion->id_clasificacion; ?>/<?php echo $subclasificacion->id_clasificacion; ?>"<?php if($campana->id_subclasificacion) { if($subclasificacion->id_clasificacion == $campana->id_subclasificacion) { echo ' selected'; } } ?>><?php echo $subclasificacion->nombre_clasificacion; ?></option>
                                                        <?php if(sizeof($subclasificacion->subsubclasificaciones) > 0): ?>
                                                            <?php foreach($subclasificacion->subsubclasificaciones as $subsubclasificacion): ?>
                                                                <option value="<?php echo $clasificacion->id_clasificacion; ?>/<?php echo $subclasificacion->id_clasificacion; ?>/<?php echo $subsubclasificacion->id_clasificacion;?>"<?php if($campana->id_subsubclasificacion) { if($subsubclasificacion->id_clasificacion == $campana->id_subsubclasificacion) { echo ' selected'; } } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $subsubclasificacion->nombre_clasificacion; ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </optgroup>
                                        <?php endforeach; ?>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="4">
										<button class="action button expand secondary"><i class="fa fa-refresh"></i> Actualizar</button>
									</td>
								</tr>
							</form>
						</table>
						<table class="campana_info">
							<form action="<?php echo site_url('administracion/campanas/limitado/actualizar_etiquetas/'.$campana->id_enhance); ?>" method="post">
								<tr>
									<th colspan="4" class="text-center">Etiquetas</th>
								</tr>
								<tr>
									<td colspan="4">
										<input type="text" name="campana_etiquetas" id="campana_etiquetas" value="<?php echo $campana->etiquetas; ?>" />
									</td>
								</tr>
								<tr>
									<td colspan="4">
										<button class="action button expand secondary"><i class="fa fa-refresh"></i> Actualizar</button>
									</td>
								</tr>
							</form>
						</table>
						<table class="campana_info">
							<form action="<?php echo site_url('administracion/campanas/limitado/actualizar_descripcion/'.$campana->id_enhance); ?>" method="post">
								<tr>
									<th colspan="4" class="text-center">Descripción</th>
								</tr>
								<tr>
									<td colspan="4">
										<textarea rows="7" name="campana_description_edit" id="campana_description_edit" style="margin-bottom:0;"><?php echo $campana->description; ?></textarea>
									</td>
								</tr>
								<tr>
									<td colspan="4">
										<button class="action button expand secondary"><i class="fa fa-refresh"></i> Actualizar</button>
									</td>
								</tr>
							</form>
						</table>
						<table class="campana_info">
							<form action="<?php echo site_url('administracion/campanas/limitado/disfrazar_ventas/'.$campana->id_enhance); ?>" method="post">
								<tr>
									<th colspan="4" class="text-center">Número disfrazado de ventas adicionales</th>
								</tr>
								<tr>
									<th colspan="4" class="text-center" style="white-space:normal;">OJO: Este número se suma a las ventas actuales para disfrazar el número que aparece en el producto.</th>
								</tr>
								<tr>
									<td colspan="4">
										<input type="number" name="modificador_ventas" id="modificador_ventas" value="<?php echo $campana->modificador_ventas; ?>" min="0" required />
									</td>
								</tr>
								<tr>
									<td colspan="4">
										<button class="action button expand secondary"><i class="fa fa-refresh"></i> Actualizar</button>
									</td>
								</tr>
							</form>
						</table>
						<table class="campana_info">
							<tr>
								<th colspan="2" class="text-center">Reporte de producto</th>
							</tr>
							<tr>
								<th width="35%">Folio</th>
								<td width="65%"><?php echo $campana->id_enhance; ?></td>
							</tr>
							<tr>
								<th width="35%">Estatus</th>
								<td width="65%">
								<?php if(!$campana->estatus): ?>
									<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Pendiente
								<?php elseif($campana->estatus == 1): ?>
									<?php if((((strtotime($campana->end_date) - time())/24)/60)/60 > 0): ?>
									<i class="fa fa-line-chart"></i> Activa
									<?php else: ?>
									<i class="fa fa-check"></i> Finalizada
									<?php endif; ?>
								<?php elseif($campana->estatus == 2): ?>
									<i class="fa fa-times"></i> Rechazada
								<?php elseif($campana->estatus == 3): ?>
									<i class="fa fa-ban"></i> Terminada por printome.mx
								<?php endif; ?>
								</td>
							</tr>
							<?php if($campana->estatus == 1 || $campana->estatus == 3): ?>
							<tr>
								<th width="35%">Fecha de inicio</th>
								<td width="65%"><?php echo date("d/m/Y H:i:s", strtotime($campana->date)); ?></td>
							</tr>
							<tr>
								<th width="35%">Fecha final</th>
								<td width="65%"><?php echo date("d/m/Y H:i:s", strtotime($campana->end_date)); ?></td>
							</tr>
							<?php endif; ?>
							<tr>
								<th width="35%">Días de campaña</th>
								<td width="65%"><?php echo number_format(((((strtotime($campana->end_date) - strtotime($campana->date))/24)/60)/60), 0, '.', ','); ?> <?php if($campana->estatus == 3) { echo '/ '.$campana->days; } ?> días</td>
							</tr>
							<?php if($campana->estatus == 1): ?>
							<?php if((((strtotime($campana->end_date) - time())/24)/60)/60 > 0): ?>
							<tr>
								<th width="35%">Días restantes</th>
								<td width="65%"><?php echo number_format(((((strtotime($campana->end_date) - time())/24)/60)/60), 3, '.', ','); ?> días</td>
							</tr>
							<?php endif; ?>
							<?php endif; ?>
							<tr>
								<th>Costo de producción</th>
								<td>$<?php echo $this->cart->format_number($campana->costo); ?></td>
							</tr>
							<tr>
								<th>Precio de venta</th>
								<td>$<?php echo $this->cart->format_number($campana->price); ?></td>
							</tr>
							<tr>
								<th>A vender</th>
								<td><?php echo $campana->quantity; ?></td>
							</tr>
							<tr>
								<th>Ganancia estimada</th>
								<td>$<?php if($campana->id_cliente == 2003 || $campana->id_cliente == 1) {
                                    echo $this->cart->format_number(((($campana->price-$campana->costo)/1.16)*0.9)*$campana->quantity);
                                } else {
                                    echo $this->cart->format_number(((($campana->price-$campana->costo)/1.16)*0.75)*$campana->quantity);
                                } ?></td>
							</tr>
							<tr>
								<th>Vendido</th>
								<td><?php echo $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance); ?></td>
							</tr>
							<tr>
								<th>% Cumplimiento</th>
								<td><?php echo $this->cart->format_number(($this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance)/$campana->quantity)*100); ?>%</td>
							</tr>
							<?php if($campana->estatus == 2): ?>
							<tr>
								<td colspan="2"><?php echo $campana->additional_info; ?></td>
							</tr>
							<?php endif; ?>
						</table>
						<table class="campana_info">
							<tr>
								<th colspan="2" class="text-center">Ganancia real</th>
							</tr>
							<?php
							$color = $this->db->get_where('ColoresPorProducto', array('id_color' => $campana->id_color))->row();

							if($color->codigo_color == '#FFFFFF') {
								$esBlanca = true;
							} else {
								$esBlanca = false;
							}

							if($campana->quantity >= $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance)) {
								$base_estimacion = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
								$cantidad_vendida = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
							} else {
								$base_estimacion = $campana->quantity;
								$cantidad_vendida = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
							}

							$colores_lados = json_decode($campana->colores, TRUE);


							$costo_real = getCost(array('front' => sizeof($colores_lados['front']), 'back' => sizeof($colores_lados['back']), 'left' => sizeof($colores_lados['left']), 'right' => sizeof($colores_lados['right'])), $esBlanca, $base_estimacion, $color->precio);

                            if($campana->id_cliente == 2003 || $campana->id_cliente == 1) {
                                $ganancia_real = ((($campana->price-$costo_real)/1.16)*0.9)*$cantidad_vendida;
                            } else {
                                $ganancia_real = ((($campana->price-$costo_real)/1.16)*0.75)*$cantidad_vendida;
                            }
							?>
							<tr>
								<th width="35%">Costo de producción</th>
								<td width="65%">$<?php echo $this->cart->format_number($costo_real); ?></td>
							</tr>
							<tr>
								<th width="35%">Precio de venta</th>
								<td width="65%">$<?php echo $this->cart->format_number($campana->price); ?></td>
							</tr>
							<tr>
								<th>Vendido</th>
								<td><?php echo $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance); ?></td>
							</tr>
							<tr>
								<th width="35%">Base para estimación</th>
								<td width="65%"><?php echo $base_estimacion; ?></td>
							</tr>
							<tr>
								<th>Ganancia real</th>
								<td><?php if($ganancia_real > 0) {
									echo '<strong style="color:green;">';
								} elseif($ganancia_real == 0) {
									echo '<strong style="color:black;">';
								} else {
									echo '<strong style="color:red;">-';
								} ?>$<?php echo $this->cart->format_number($ganancia_real*($ganancia_real < 0 ? (-1) : (1))); ?></strong></td>
							</tr>

						</table>
						<table class="campana_info">
							<tr>
								<th colspan="2" class="text-center">Datos de la campaña</th>
							</tr>
							<tr>
								<th width="35%">Autor</th>
								<td width="65%"><?php echo $campana->nombres.' '.$campana->apellidos; ?></td>
							</tr>
							<tr>
								<th width="35%">E-Mail</th>
								<td width="65%"><?php echo safe_mailto($campana->email); ?></td>
							</tr>
							<tr>
								<th width="35%">Nombre</th>
								<td width="65%"><?php echo $campana->name; ?></td>
							</tr>
							<tr>
								<th width="35%">Teléfono</th>
								<td width="65%"><?php echo $campana->telefono; ?></td>
							</tr>
							<tr>
								<th>Descripción</th>
								<td><?php echo $campana->description; ?></td>
							</tr>
                            <tr>
                                <th width="35%">Link Tienda</th>
                                <td width="65%"><a href="<?php echo $link_tienda?>">Tienda Cliente</a></td>
                            </tr>
						</table>
					</div>
				</div>
			</div>
			<div class="content" style="padding: 1.2rem 1.2rem;" id="resumen_de_produccion">
				<div class="row">
					<div class="small-16 columns">
					<?php $vendidos = $this->enhance_modelo->obtener_tallas_vendidas_por_campana('limitado', $campana->id_enhance); ?>
					<?php $i = 0; ?>
					<?php if(sizeof($vendidos)): ?>
						<table cellpadding="0" cellspacing="0" id="carrito" style="margin: 0.5% 0 1.4rem;width: 100%;">
							<thead>
								<tr>
									<th class="text-left titulo-precio">Tallas</th>
									<th class="cantidades-carrito text-center"><span class="show-for-small-only">#</span><span class="show-for-medium">Cant.</span></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($vendidos as $producto): ?>
								<tr>
									<td class="info-carrito">
										<div class="clearfix">
											<?php if(isset($campana->front_image)): ?>
											<img src="<?php echo site_url($campana->front_image); ?>" alt="Fotografía del producto" class="carrito-foto" width="58" height="58" />
											<div class="carrito-descripcion">
												<span class="carrito-nombre-producto"><?php echo $campana->name; ?></span>
												<span>Talla: <strong><?php echo caracteristicas_parse($producto->caracteristicas); ?></strong></span>
												<span>SKU: <strong><?php echo $producto->sku; ?></strong></span>
											</div>
										</div>
									</td>
									<td class="cantidades-carrito">
										<div class="clearfix">
											<div class="square-button-area hide">
												<button type="button" class="square increase"><i class="fa fa-plus"></i></button>
												<button type="button" class="square decrease"><i class="fa fa-minus"></i></button>
											</div>
											<div class="square-cantidad">
												<input type="text" value="<?php echo $producto->total_vendido; ?>" class="qtyact" readonly />
												<?php $i += $producto->total_vendido; ?>
											</div>
										</div>
									</td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
							</tbody>
							<thead>
								<tr>
									<th class="text-left titulo-precio text-right">Total vendidos</th>
									<th class="cantidades-carrito text-center"><?php echo $i; ?></th>
								</tr>
							</thead>
						</table>

						<?php foreach($campanas_adicionales as $indice_adicional=>$campana_adicional): ?>
						<?php $i = 0; ?>
						<?php $vendidos = $this->enhance_modelo->obtener_tallas_vendidas_por_campana('limitado', $campana_adicional->id_enhance, true); ?>
						<table cellpadding="0" cellspacing="0" id="carrito" style="margin: 0.5% 0 1.4rem;width: 100%;">
							<thead>
								<tr>
									<th class="text-left titulo-precio">Tallas</th>
									<th class="cantidades-carrito text-center"><span class="show-for-small-only">#</span><span class="show-for-medium">Cant.</span></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($vendidos as $producto): ?>
								<tr>
									<td class="info-carrito">
										<div class="clearfix">
											<?php if(isset($campana_adicional->front_image)): ?>
											<img src="<?php echo site_url($campana_adicional->front_image); ?>" alt="Fotografía del producto" class="carrito-foto" width="58" height="58" />
											<div class="carrito-descripcion">
												<span class="carrito-nombre-producto"><?php echo $campana_adicional->name; ?></span>
												<span>Talla: <strong><?php echo caracteristicas_parse($producto->caracteristicas); ?></strong></span>
												<span>SKU: <strong><?php echo $producto->sku; ?></strong></span>
											</div>
										</div>
									</td>
									<td class="cantidades-carrito">
										<div class="clearfix">
											<div class="square-button-area hide">
												<button type="button" class="square increase"><i class="fa fa-plus"></i></button>
												<button type="button" class="square decrease"><i class="fa fa-minus"></i></button>
											</div>
											<div class="square-cantidad">
												<input type="text" value="<?php echo $producto->total_vendido; ?>" class="qtyact" readonly />
												<?php $i += $producto->total_vendido; ?>
											</div>
										</div>
									</td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
							</tbody>
							<thead>
								<tr>
									<th class="text-left titulo-precio text-right">Total vendidos</th>
									<th class="cantidades-carrito text-center"><?php echo $i; ?></th>
								</tr>
							</thead>
						</table>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="row">
							<div class="small-24 columns">
								<h5 class="text-center">No se han vendido productos de esta campaña.</h5>
							</div>
						</div>
					<?php endif; ?>
					</div>
					<div class="small-8 columns">
						<table class="campana_info">
							<tr>
								<th colspan="4" class="text-center">Acciones</th>
							</tr>
							<tr>
								<td colspan="4">
									<a href="<?php echo site_url('administracion/campanas/limitado/pdf_produccion/'.$campana->id_enhance); ?>" class="button expand pdfmaker" target="_blank" style="color:#FFF;"><i class="fa fa-file-pdf-o"></i> PDF Producción</a>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="content" style="padding: 1rem 0 !important;" id="pedidos_realizados">
				<?php if(sizeof($pedidos)): ?>
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
								$info_pedido = clasificar_productos_pedido($pedido);

								$codigo_rastreo = $this->db->get_where('EnviosPorCampana', array('id_pedido' => $pedido->id_pedido, 'id_enhance' => $campana->id_enhance))->row();
								if(!isset($codigo_rastreo->codigo_rastreo)) {
									$enviado = false;
								} else {
									$enviado = true;
								}
							?>
								<?php if(sizeof($info_pedido['enhances']) > 0): ?>
								<tr>
									<td><?php echo $pedido->id_pedido; ?> <i class="fa fa-<?php if($enviado) { echo 'check'; } else { echo 'circle-o-notch fa-spin fa-fw'; } ?>"></i></td>
									<td><?php echo $pedido->nombres.' '.$pedido->apellidos; ?></td>
									<td><?php echo date("Y/m/d H:i", strtotime($pedido->fecha_creacion)); ?></td>
									<td class="text-center"><?php echo $pedido->numero_productos; ?></td>
									<td class="text-right" style="white-space:nowrap;">$ <?php echo $this->cart->format_number($pedido->subtotal); ?></td>
									<td class="text-right" style="white-space:nowrap;">$ <?php echo $this->cart->format_number($pedido->costo_envio); ?></td>
									<td class="text-right" style="white-space:nowrap;">$ <?php echo $this->cart->format_number($pedido->total); ?></td>
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
									<td class="text-center"><?php if($enviado) { echo '<i class="fa fa-truck"></i> Enviado'; } else { echo '<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Pendiente'; } ?></td>
									<td class="text-center"><?php echo ($pedido->id_direccion_fiscal ? '<i class="fa fa-check"></i>' : ''); ?></td>
									<td class="text-right" style="white-space: nowrap;"><a href="<?php echo site_url('administracion/campanas/limitado/editar/'.$campana->id_enhance.'/pedidos/'.$pedido->id_pedido); ?>" class="action button"><i class="fa fa-search"></i></a> <a href="<?php echo site_url('administracion/pedidos/pdf_pedido/'.$pedido->id_pedido); ?>" class="button pdfmaker action" target="_blank"><i class="fa fa-file-pdf-o"></i></a></td>
								</tr>
								<?php endif; ?>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<?php else: ?>
					<div class="row">
						<div class="small-24 columns">
							<h5 class="text-center">No se han vendido productos de esta campaña.</h5>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="content" id="info_pagos">
				<div class="row">
					<div class="small-13 columns">

						<table class="campana_info">
							<tr>
								<th style="font-size:1.25rem;line-height:2.4rem;font-weight:bold;" colspan="2" class="text-center">Datos de la campaña</th>
							</tr>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;" width="35%">Autor</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="65%"><?php echo $campana->nombres.' '.$campana->apellidos; ?></td>
							</tr>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;" width="35%">E-Mail</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="65%"><?php echo $campana->email; ?></td>
							</tr>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;" width="35%">Nombre</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="65%"><?php echo $campana->name; ?></td>
							</tr>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;" width="35%">Teléfono</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="65%"><?php echo $campana->telefono; ?></td>
							</tr>
						</table>

						<table class="campana_info">
							<tr>
								<th style="font-size:1.25rem;line-height:2.4rem;font-weight:bold;" colspan="2" class="text-center">Reporte final</th>
							</tr>
							<?php
							$color = $this->db->get_where('ColoresPorProducto', array('id_color' => $campana->id_color))->row();

							if($color->codigo_color == '#FFFFFF') {
								$esBlanca = true;
							} else {
								$esBlanca = false;
							}

							if($campana->quantity >= $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance)) {
								$base_estimacion = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
								$cantidad_vendida = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
							} else {
								$base_estimacion = $campana->quantity;
								$cantidad_vendida = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance);
							}

							$colores_lados = json_decode($campana->colores, TRUE);


							$costo_real = getCost(array('front' => sizeof($colores_lados['front']), 'back' => sizeof($colores_lados['back']), 'left' => sizeof($colores_lados['left']), 'right' => sizeof($colores_lados['right'])), $esBlanca, $base_estimacion, $color->precio);

                            if($campana->id_cliente == 2003 || $campana->id_cliente == 1) {
                                $ganancia_real = ((($campana->price-$costo_real)/1.16)*0.9)*$cantidad_vendida;
                            } else {
                                $ganancia_real = ((($campana->price-$costo_real)/1.16)*0.75)*$cantidad_vendida;
                            }

							?>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;">Número de ventas</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" class="text-right"><?php echo $cantidad_vendida; ?></td>
							</tr>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;" width="65%">Base para estimación</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="35%" class="text-right"><?php echo $base_estimacion; ?></td>
							</tr>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;" width="65%">Costo de producción unitario</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="35%" class="text-right">$<?php echo $this->cart->format_number($costo_real); ?></td>
							</tr>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;" width="65%">Precio de venta unitario</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="35%" class="text-right">$<?php echo $this->cart->format_number($campana->price); ?></td>
							</tr>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;" width="65%">Ventas totales</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="35%" class="text-right">$<?php echo $this->cart->format_number($campana->price*$cantidad_vendida); ?></td>
							</tr>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;" width="65%">Costo total de producción</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="35%" class="text-right">$<?php echo $this->cart->format_number($costo_real*$cantidad_vendida); ?></td>
							</tr>
							<tr style="border-top: solid 2px #000">
								<th style="font-size:1.25rem;line-height:2.4rem;">A depositar</th>
								<td style="font-size:1.25rem;line-height:2.4rem;padding-right:12px;" class="text-right"><?php if($ganancia_real > 0) {
									echo '<strong style="color:green;">';
								} elseif($ganancia_real == 0) {
									echo '<strong style="color:black;">';
								} else {
									echo '<strong style="color:red;">-';
								} ?>$<?php echo $this->cart->format_number($ganancia_real*($ganancia_real < 0 ? (-1) : (1))); ?></strong></td>
							</tr>

						</table>

						<?php if(isset($corte->id_corte)): ?>
							<?php if($corte->monto_corte > 0): ?>
								<?php if($corte->fecha_pago == ''): ?>
								<table class="campana_info">
									<tr>
										<th style="font-size:1.25rem;line-height:2.4rem;font-weight:bold;" colspan="2" class="text-center">Datos de depósito</th>
									</tr>
									<?php if(!isset($info_deposito_actual->id_dato_deposito)): ?>
									<tr>
										<td colspan="2" style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" class="text-center">La persona no ha subido sus datos de depósito.</td>
									</tr>
									<?php else: ?>
										<?php if($info_deposito_actual->tipo_pago == 'paypal'): ?>
										<tr>
											<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Correo asociado a PayPal</th>
											<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $info_deposito_actual->datos_json->cuenta_paypal; ?></td>
										</tr>
										<?php elseif($info_deposito_actual->tipo_pago == 'banco'): ?>
										<tr>
											<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Nombre de cuentahabiente</th>
											<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $info_deposito_actual->datos_json->nombre_cuentahabiente; ?></td>
										</tr>
										<tr>
											<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Nombre del banco</th>
											<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $info_deposito_actual->datos_json->nombre_banco; ?></td>
										</tr>
										<tr>
											<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Número de cuenta</th>
											<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $info_deposito_actual->datos_json->cuenta; ?></td>
										</tr>
										<tr>
											<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">CLABE Interbancaria</th>
											<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $info_deposito_actual->datos_json->clabe; ?></td>
										</tr>
										<?php if(isset($info_deposito_actual->datos_json->ciudad)): ?>
										<tr>
											<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Ciudad</th>
											<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $info_deposito_actual->datos_json->ciudad; ?></td>
										</tr>
										<?php endif; ?>
										<?php if(isset($info_deposito_actual->datos_json->sucursal)): ?>
										<tr>
											<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Sucursal</th>
											<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $info_deposito_actual->datos_json->sucursal; ?></td>
										</tr>
										<?php endif; ?>
										<?php endif; ?>
									<?php endif; ?>
								</table>
								<?php else: ?>
									<?php if($corte->id_dato_deposito != ''): ?>
										<?php if(isset($dato_bancario_corte)): ?>
										<table class="campana_info">
											<tr>
												<th style="font-size:1.25rem;line-height:2.4rem;font-weight:bold;" colspan="2" class="text-center">Datos de depósito usados para este corte</th>
											</tr>
											<?php if($dato_bancario_corte->tipo_pago == 'paypal'): ?>
											<tr>
												<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Correo asociado a PayPal</th>
												<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $dato_bancario_corte->datos_json->cuenta_paypal; ?></td>
											</tr>
											<?php elseif($dato_bancario_corte->tipo_pago == 'banco'): ?>
											<tr>
												<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Nombre de cuentahabiente</th>
												<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $dato_bancario_corte->datos_json->nombre_cuentahabiente; ?></td>
											</tr>
											<tr>
												<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Nombre del banco</th>
												<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $dato_bancario_corte->datos_json->nombre_banco; ?></td>
											</tr>
											<tr>
												<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Número de cuenta</th>
												<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $dato_bancario_corte->datos_json->cuenta; ?></td>
											</tr>
											<tr>
												<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">CLABE Interbancaria</th>
												<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $dato_bancario_corte->datos_json->clabe; ?></td>
											</tr>

											<?php if(isset($dato_bancario_corte->datos_json->ciudad)): ?>
											<tr>
												<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Ciudad</th>
												<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $dato_bancario_corte->datos_json->ciudad; ?></td>
											</tr>
											<?php endif; ?>
											<?php if(isset($dato_bancario_corte->datos_json->sucursal)): ?>
											<tr>
												<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Sucursal</th>
												<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $dato_bancario_corte->datos_json->sucursal; ?></td>
											</tr>
											<?php endif; ?>
											<?php endif; ?>
										</table>
										<?php endif; ?>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<div class="small-10 columns">
					<?php if(isset($corte->id_corte)): ?>
						<table class="campana_info">
							<tr>
								<th colspan="4" class="text-center">Acciones</th>
							</tr>
							<tr>
								<td colspan="4">
									<a href="<?php echo site_url('administracion/campanas/limitado/pdf_comprobante/'.$campana->id_enhance.'/'.(isset($corte) ? $corte->id_corte : '')); ?>" class="button expand pdfmaker" target="_blank" style="color:#FFF;"><i class="fa fa-file-pdf-o"></i> PDF Comprobante</a>
								</td>
							</tr>
						</table>
					<?php if($corte->monto_corte > 0): ?>
						<?php if($corte->fecha_pago == ''): ?>
						<form action="<?php echo site_url('administracion/campanas/limitado/asignar_pago/'.$campana->id_enhance); ?>" method="post" enctype="multipart/form-data" data-abide id="enviar-ficha">
							<table class="campana_info">
								<tr>
									<th style="font-size:1.25rem;line-height:2.4rem;font-weight:bold;" colspan="2" class="text-center">Enviar ficha de pago</th>
								</tr>
								<tr>
									<th style="font-size:1.05rem;line-height:1.8rem;">Monto: $</th>
									<td style="font-size:1.05rem;line-height:1.8rem;">
										<input type="text" name="pago_asignado[monto_corte]" style="margin:0;font-size:1.05rem;line-height:1.1;text-align:right;" readonly value="<?php echo number_format($ganancia_real, 2, ".", ""); ?>" />
										<input type="hidden" name="pago_asignado[id_corte]" value="<?php echo $corte->id_corte; ?>" />
									</td>
								</tr>
								<tr>
									<td colspan="2" class="text-center">
										<label style="margin-top:1rem;">Archivo escaneado / Pantallazo de ficha
											<input type="file" id="archivo_pago" style="background:white;width:90%;" name="pago_asignado[archivo_pago]" />
										</label>
										<small class="error">Archivo requerido</small>
									</td>
								</tr>
								<tr>
									<td colspan="2" class="text-center" style="font-size:1.05rem;">
										<label style="line-height:2.4rem;font-size:1.05rem !important;"><input type="checkbox" name="pago_asignado[avisar_persona]" id="avisar_persona" /> Avisar a la persona por correo</label>
										<input type="hidden" name="pago_asignado[id_dato_deposito]" value="<?php echo (isset($info_deposito_actual->id_dato_deposito) ? $info_deposito_actual->id_dato_deposito : ''); ?>" />
									</td>
								</tr>
								<tr>
									<td colspan="2" class="text-center">
										<button type="submit" class="button" style="margin:0;"><i class="fa fa-save"></i> Guardar información de pago</button>
									</td>
								</tr>
							</table>
						</form>
						<?php else: ?>
						<table class="campana_info">
							<tr>
								<th style="font-size:1.25rem;line-height:2.4rem;font-weight:bold;" colspan="2" class="text-center">Comprobante de pago</th>
							</tr>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;">Fecha</th>
								<td style="font-size:1.05rem;line-height:1.8rem;"><?php echo date("d/m/Y H:i:s", strtotime($corte->fecha_pago)); ?></td>
							</tr>
							<?php if($corte->comprobante_pago != ''): ?>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;">Archivo</th>
								<td style="font-size:1.05rem;line-height:1.8rem;"><a href="<?php echo site_url('assets/comprobantes/'.$corte->comprobante_pago); ?>" class="action button" target="_blank"><i class="fa fa-file"></i> Ver archivo</a></td>
							</tr>
							<?php else: ?>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;">&nbsp;</th>
								<td style="font-size:1.05rem;line-height:1.8rem;">Sin comprobante.</td>
							</tr>
							<?php endif; ?>
						</table>

						<form action="<?php echo site_url('administracion/campanas/limitado/asignar_pago/'.$campana->id_enhance); ?>" method="post" enctype="multipart/form-data" data-abide id="actualizar-ficha">
							<table class="campana_info">
								<tr>
									<th style="font-size:1.25rem;line-height:2.4rem;font-weight:bold;" colspan="2" class="text-center">Actualizar ficha de pago</th>
								</tr>
								<tr>
									<th style="font-size:1.05rem;line-height:1.8rem;">Monto: $</th>
									<td style="font-size:1.05rem;line-height:1.8rem;">
										<input type="text" name="pago_asignado[monto_corte]" style="margin:0;font-size:1.05rem;line-height:1.1;text-align:right;" readonly value="<?php echo number_format($ganancia_real, 2, ".", ""); ?>" />
										<input type="hidden" name="pago_asignado[id_corte]" value="<?php echo $corte->id_corte; ?>" />
									</td>
								</tr>
								<tr>
									<td colspan="2" class="text-center">
										<label style="margin-top:1rem;">Archivo escaneado / Pantallazo de ficha (opcional)
											<input type="file" id="archivo_pago" style="background:white;width:90%;" name="pago_asignado[archivo_pago]" />
										</label>
									</td>
								</tr>
								<tr>
									<td colspan="2" class="text-center" style="font-size:1.05rem;">
										<label style="line-height:2.4rem;font-size:1.05rem !important;"><input type="checkbox" name="pago_asignado[avisar_persona]" id="avisar_persona" /> Avisar a la persona por correo</label>
										<input type="hidden" name="pago_asignado[id_dato_deposito]" value="<?php echo (isset($info_deposito_actual->id_dato_deposito) ? $info_deposito_actual->id_dato_deposito : ''); ?>" />
									</td>
								</tr>
								<tr>
									<td colspan="2" class="text-center">
										<button type="submit" class="button" style="margin:0;"><i class="fa fa-save"></i> Actualizar información de pago</button>
									</td>
								</tr>
							</table>
						</form>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="reveal-modal small" id="rechazar_campana" data-reveal>
	<form action="<?php echo site_url('administracion/campanas/limitado/rechazar/'.$campana->id_enhance); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Motivo del rechazo
					<textarea name="motivo" id="motivo" style="min-height: 80px;" required></textarea>
				</label>
				<small class="error">Campo requerido.</small>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<button type="submit">Rechazar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal small" id="terminar_campana" data-reveal>
	<form action="<?php echo site_url('administracion/campanas/limitado/terminar/'.$campana->id_enhance); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Motivo de la terminación
					<textarea name="motivo" id="motivo" style="min-height: 80px;" required></textarea>
				</label>
				<small class="error">Campo requerido.</small>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<button type="submit">Terminar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal small" id="borrar_campana" data-reveal>
	<form action="<?php echo site_url('administracion/campanas/limitado/borrar/'.$campana->id_enhance); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Estás seguro de querer borrar esta campaña?</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<button type="submit">Borrar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal medium" id="producir_campana" style="max-width:520px;" data-reveal>
	<form action="<?php echo site_url('administracion/campanas/limitado/producir/'.$campana->id_enhance); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;font-size: 1rem !important;text-align: justify;">Si aceptas producir esta campaña todos los clientes que han comprado recibirán un correo de que la campaña se va a producir y se les enviará en los próximos días. El diseñador recibirá un correo de que su campaña se va a producir y de cuanto será su ganancia final.</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns text-center">
				<button type="submit" class="button success"><i class="fa fa-check"></i> Producir</button>
			</div>
			<div class="small-12 columns text-center">
				<button type="button" class="button warning" onclick="$('#producir_campana').foundation('reveal', 'close');"><i class="fa fa-times"></i> Cancelar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal medium" id="no_producir_campana" style="max-width:520px;" data-reveal>
	<form action="<?php echo site_url('administracion/campanas/limitado/no_producir/'.$campana->id_enhance); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;font-size: 1rem !important;text-align: justify;">Si decides no producir esta campaña todos los clientes que han comprado recibirán un correo de que la campaña <u>no</u> se va a producir y se les reembolsará en forma de saldo a favor en printome.mx. El diseñador recibirá un correo de que su campaña <u>no</u> se va a producir por no haber .</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns text-center">
				<button type="submit" class="button alert"><i class="fa fa-times-circle"></i> No producir</button>
			</div>
			<div class="small-12 columns text-center">
				<button type="button" class="button warning" onclick="$('#no_producir_campana').foundation('reveal', 'close');"><i class="fa fa-times"></i> Cancelar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
