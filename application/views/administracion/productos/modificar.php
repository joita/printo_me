<style>
	.product-design-view {
		border: 1px solid #CCC;
		float: left;
		height: 500px;
		overflow: hidden;
		position: relative;
		width: 500px;
	}
	.product-design-view .selected {
		border: 1px dashed #428BCA;
	}
	.product-design-view .selected .ui-resizable-handle {
		background-color: #FFF;
		border: 2px solid #428BCA;
		height: 10px;
		width: 10px;
	}

	.product-design-view .selected .ui-resizable-handle.ui-resizable-se {
		bottom: -6px;
		right: -6px;
	}

	#product-images {
		float: left;
		height: 500px;
		text-align: center;
		width: 500px;
	}
	#area-design {
		cursor: pointer;
		height: 317px;
		left: 135px;
		position: absolute;
		top: 90px;
		width: 230px;
		background: url("<?php echo base_url('assets/images/bg-area.png'); ?>");
	}

	#ajax-modal{
		min-width: 835px;
	}
</style>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>">
<script type="text/javascript">
	//var base_url = '<?php echo site_url(); ?>';
	var base_url = '<?php echo substr(base_url(), 0, strlen(base_url())-1); ?>'
	//var url = '<?php echo base_url(); ?>';
	var url = '<?php echo substr(base_url(), 0, strlen(base_url())-1); ?>';
	var areaZoom = 10;
</script>
<div class="row" style="padding:0 1rem;">
	<div class="small-24 columns navholder">
		<a href="<?php echo site_url('administracion/productos/'.$categoria_slug); ?>" class="coollink grey"><i class="fa fa-arrow-circle-left"></i> Regresar</a>
	</div>
	<div class="small-24 columns" style="padding:0;">
		<ul class="tabs tab-menu" data-tab role="tablist">
			<li class="active"><a href="#producto" role="tab" tabindex="0" aria-selected="true" aria-controls="producto">Información</a></li>
			<li class=""><a href="#diseno" role="tab" tabindex="0" aria-selected="false" aria-controls="diseno">Diseñador</a></li>
		</ul>
		<form action="<?php echo site_url(uri_string().'/procesar'); ?>" method="post" enctype="multipart/form-data" data-abide>
			<div class="tabs-content">
				<section role="tabpanel" aria-hidden="false" class="content active" id="producto" style="padding-top:0;">
					<div class="row">
						<div class="small-24 columns" style="padding: 0 0.5rem;border: solid 1px #CFE3EA;border-top: none;">
							<div class="row">
								<div class="small-8 columns">
									<fieldset id="datos_producto">
										<legend>Datos del producto</legend>
										<div class="row">
											<div class="small-24 columns">
												<label>Nombre del producto
													<input type="text" name="nombre_producto" id="nombre_producto" required placeholder="Ej: Despertar decembrino" value="<?php echo $producto->nombre_producto; ?>" />
												</label>
												<small class="error">Campo requerido.</small>
											</div>
										</div>
										<div class="row">
											<div class="small-24 columns">
												<label>Modelo del producto
													<input type="text" id="modelo_producto" required placeholder="Ej: DD382" value="<?php echo $producto->modelo_producto; ?>" readonly="readonly" />
												</label>
												<small class="error">Campo requerido.</small>
											</div>
										</div>
										<div class="row">
											<div class="small-24 columns">
												<label>Marca
													<select name="id_marca" id="marca_producto_add" required>
														<option value=""></option>
														<?php foreach($this->marcas_modelo->obtener_marcas_activas() as $marca): ?>
															<option value="<?php echo $marca->id_marca; ?>"<?php if($marca->id_marca == $producto->id_marca) { echo ' selected'; } ?>><?php echo $marca->nombre_marca; ?></option>
														<?php endforeach; ?>
													</select>
												</label>
												<small class="error">Campo requerido.</small>
											</div>
										</div>
										<?php /*<div class="row">
											<div class="small-24 columns">
												<label>Precio (sin IVA)
													<input type="text" name="precio_producto" id="precio_producto" required pattern="number" placeholder="Ejemplo: 300.00" value="<?php echo $producto->precio_producto; ?>" />
												</label>
												<small class="error">Campo requerido.</small>
											</div>
										</div> */?>
										<div class="row">
											<div class="small-24 columns">
												<label>Descripción del producto
													<textarea name="descripcion_producto" id="descripcion_producto" required><?php echo $producto->descripcion_producto; ?></textarea>
												</label>
												<small class="error">Campo requerido.</small>
											</div>
										</div>
                						<div class="row" style="margin-top: 1rem;">
                							<div class="small-24 columns">
                								<label>Género
                									<select name="genero" id="genero_mod" required>
                										<option value=""></option>
                									<?php foreach($this->generos as $indice_genero => $genero): ?>
                										<option value="<?php echo $indice_genero; ?>"<?php if($indice_genero == $producto->genero) { echo ' selected'; } ?>><?php echo $genero; ?></option>
                									<?php endforeach; ?>
                									</select>
                								</label>
                								<small class="error">Campo requerido.</small>
                							</div>
                						</div>
									</fieldset>
									<fieldset id="datos_adicionales">
										<legend>Datos adicionales</legend>
										<div class="row">
											<div class="small-12 columns">
												<label>Descuento %
													<input type="text" name="descuento_especifico" id="precio_producto" pattern="number" placeholder="Ejemplo: 25" value="<?php echo $producto->descuento_especifico; ?>" />
												</label>
												<small class="error">Campo requerido.</small>
											</div>
										</div>
										<div class="row">
											<div class="small-24 columns">
												<label>
													<input type="checkbox" name="envio_gratis" value="1"<?php echo ($producto->envio_gratis == 1 ? ' checked' : ''); ?>> Envío gratis
												</label>
											</div>
										</div>
										<div class="row">
											<div class="small-24 columns">
												<label>
													<input type="checkbox" name="aplica_devolucion" value="1"<?php echo ($producto->aplica_devolucion == 1 ? ' checked' : ''); ?>> Aplica devolución
												</label>
											</div>
										</div>
									</fieldset>
									<?php if(!is_null($caracteristicas_adicionales)): ?>
										<fieldset id="cara_adicionales">
											<legend>Características adicionales</legend>
											<?php foreach($caracteristicas_adicionales as $slug=>$caracteristica_adicional): ?>
												<label class="divisor"><?php echo $caracteristica_adicional['nombre']; ?></label>
												<?php foreach($caracteristica_adicional['items'] as $nivel_1): ?>
													<?php if(isset($nivel_1['items'])): ?>
														<label><strong><?php echo $nivel_1['nombre']; ?></strong></label>
														<?php foreach($nivel_1['items'] as $nivel_2): ?>
															<label>
																<input type="radio" class="second_level" name="car_adi[<?php echo $slug; ?>]" id="<?php echo $slug.'_'.$nivel_1['slug'].'_'.$nivel_2['slug']; ?>" value="<?php echo $nivel_1['slug'].'_'.$nivel_2['slug']; ?>" required<?php if($car_adi_producto->$slug == $nivel_1['slug'].'_'.$nivel_2['slug']) { echo ' checked'; } ?>> <?php echo $nivel_2['nombre']; ?>
															</label>
														<?php endforeach; ?>
													<?php else: ?>
														<label>
															<input type="radio" name="car_adi[<?php echo $slug; ?>]" id="<?php echo $slug.'_'.$nivel_1['slug']; ?>" value="<?php echo $nivel_1['slug']; ?>" required<?php if($car_adi_producto->$slug == $nivel_1['slug']) { echo ' checked'; } ?>> <?php echo $nivel_1['nombre']; ?>
														</label>
													<?php endif; ?>
												<?php endforeach; ?>
											<?php endforeach; ?>
										</fieldset>
									<?php endif; ?>
								</div>
								<div class="small-16 columns">
									<fieldset id="fotografias">
										<legend>Colores, Fotografías, SKUs</legend>

										<div id="fots">
											<?php $tamano_variedades = sizeof($this->productos_modelo->obtener_lista_colores_por_producto($id_producto)); ?>
											<?php foreach($this->productos_modelo->obtener_lista_colores_por_producto($id_producto) as $color): ?>
												<fieldset data-foto="<?php echo $color->id_color; ?>" class="nomtop">
													<legend>Variedad</legend>
													<div class="row">
														<div class="small-24 columns">
															<fieldset>
																<legend>Color</legend>
																<div class="row collapse">
																	<div class="small-3 columns">
																		<label>Color
																			<div><i class="fa fa-square" style="color:<?php echo $color->codigo_color; ?>;font-size: 2rem;text-shadow: 0px 0px 1px #666;"></i></div>
																		</label>
																	</div>
																	<div class="small-8 large-5 columns">
																		<label>Nombre
																			<input type="text" class="nombre_color" id="nombre_color_<?php echo $color->id_color; ?>" data-i="<?php echo $color->id_color; ?>" value="<?php echo $color->nombre_color; ?>" readonly>
																		</label>
																	</div>
																	<div class="small-10 large-offset-1 small-offset-1 large-8 columns">
																		<label>Precio (sin IVA)
																			<input type="text" name="producto[<?php echo $color->id_color; ?>][precio]" id="precio_producto" required pattern="number" placeholder="Ejemplo: $ 100.00" value="<?php echo $color->precio; ?>">
																		</label>
																		<small class="error">Campo requerido.</small>
																	</div>
																	<div class="small-5 columns text-right">
																		<?php if($tamano_variedades > 1): ?>
																			<label data-id_color="<?php echo $color->id_color; ?>">Estatus
																				<?php if($color->estatus == 1): ?>
																					<a class="color_switch enabled"><i class="fa fa-toggle-on"></i></a>
																				<?php else: ?>
																					<a class="color_switch disabled"><i class="fa fa-toggle-off"></i></a>
																				<?php endif; ?>
																			</label>
																		<?php endif; ?>
																	</div>
																</div>
																<?php /*<div class="row collapse">

																</div>*/?>
															</fieldset>
														</div>
													</div>
													<div class="small-24 columns">
														<fieldset>
															<legend>Fotografías</legend>
															<div class="row">
																<ul class="small-block-grid-4 fotos_producto">
																	<?php $tamano = sizeof($this->productos_modelo->obtener_fotografias_producto($color->id_color, $id_producto)); ?>
																	<?php foreach($this->productos_modelo->obtener_fotografias_producto($color->id_color, $id_producto) as $fotografia): ?>
																		<li data-id_fotografia="<?php echo $fotografia->id_fotografia; ?>" data-estatus="<?php echo $fotografia->principal; ?>" data-id_color="<?php echo $color->id_color; ?>">
																			<img src="<?php echo site_url($fotografia->ubicacion_base.$fotografia->fotografia_chica); ?>">
																			<div class="white_mod clearfix">
																				<?php if($fotografia->principal == 1): ?>
																					<a class="est_foto principal" title="Principal"><i class="fa fa-star"></i></a>
																				<?php else: ?>
																					<a class="est_foto volverprincipal" title="Volver Principal"><i class="fa fa-star-o"></i></a>
																				<?php endif; ?>

																				<?php if($tamano > 1): ?>
																					<a href="#" class="bor_foto right" title="Borrar"><i class="fa fa-times-circle"></i></a>
																				<?php endif; ?>
																			</div>
																		</li>
																	<?php endforeach; ?>
																</ul>
															</div>
															<div class="row">
																<div class="small-24 columns" id="contenido_fotos_<?php echo $color->id_color; ?>">
																	<div class="row foto">
																		<div class="small-16 columns">
																			<label>Fotografía
																				<input type="file" name="producto[<?php echo $color->id_color; ?>][fotografia][]" accept="image/*" data-i="<?php echo $color->id_color; ?>" />
																			</label>
																		</div>
																		<div class="small-4 columns">
																			<label>&nbsp;
																				<button type="button" class="add_foto_existente success" data-producto="<?php echo $color->id_color; ?>"><i class="fa fa-plus-circle"></i></button>
																			</label>
																		</div>
																		<div class="small-4 columns">

																		</div>
																	</div>
																</div>
															</div>
														</fieldset>
													</div>
													<div class="row">
														<div class="small-24 columns variable-content" id="var1">
															<?php foreach($this->productos_modelo->obtener_skus_por_color($color->id_color) as $key => $sku): ?>
																<div class="row item_info item_update" data-contador="<?php echo $color->id_color; ?>_<?php echo $key ?>" data-i="<?php echo $color->id_color; ?>" data-j="<?php echo $sku->id_sku; ?>">
																	<div class="small-6 columns">
																		<label>SKU
																			<div><strong><?php echo $sku->sku; ?></strong></div>
																		</label>
																	</div>
																	<div class="small-2 columns end">
																		<label>Talla
																			<div><strong><?php echo $sku->talla_completa; ?></strong></div>
																		</label>
																	</div>
																	<?php /*<div class="small-4 columns">
																		<label>Precio
																			<input type="text" name="producto[<?php echo $color->id_color; ?>][precio][<?php echo $sku->id_sku; ?>]" value="<?php echo $sku->precio; ?>" readonly="readonly">
																		</label>
																	</div>*/ ?>
																	<div class="small-4 columns">
																		<label>Actual
																			<input type="text" name="producto[<?php echo $color->id_color; ?>][cantidad_inicial][<?php echo $sku->id_sku; ?>]" value="<?php echo $sku->cantidad_inicial; ?>">
																		</label>
																	</div>
																	<div class="small-4 columns">
																		<label>Mínimo
																			<input type="text" name="producto[<?php echo $color->id_color; ?>][cantidad_minima][<?php echo $sku->id_sku; ?>]" value="<?php echo $sku->cantidad_minima; ?>">
																		</label>
																	</div>
																	<div class="small-2 columns text-right">
																		<label data-id_sku="<?php echo $sku->id_sku; ?>">Estatus SKU
																			<?php if($sku->estatus == 1): ?>
																				<a class="sku_switch enabled"><i class="fa fa-toggle-on"></i></a>
																			<?php else: ?>
																				<a class="sku_switch disabled"><i class="fa fa-toggle-off"></i></a>
																			<?php endif; ?>
																		</label>
																	</div>
																</div>
															<?php endforeach; ?>
														</div>
													</div>
													<div class="row">
														<div class="small-24 columns variable-content" id="var<?php echo $color->id_color; ?>">
															<div class="row item_info" data-contador="<?php echo $color->id_color; ?>_0" data-i="<?php echo $color->id_color; ?>" data-j="0">
																<input type="checkbox" id="habilitar_<?php echo $color->id_color; ?>_0" data-i="<?php echo $color->id_color; ?>" data-j="0" class="habilitador">
																<?php
																$tipo = $this->tipo_modelo->obtener_tipo($producto->id_tipo, true);
																foreach($tipo->caracteristicas_tipo as $slug_car=>$caracteristica):
																	?>
																<div class="small-4 columns">
																	<label><?php echo $caracteristica->titulo; ?>
																		<select name="nuevo_sku[<?php echo $color->id_color; ?>][caracteristicas][<?php echo $slug_car; ?>][0]" class="specs_select" required disabled>
																			<option value=""></option>
																			<?php foreach($caracteristica->opciones as $opcion): ?>
																				<option value="<?php echo $opcion; ?>"><?php echo $opcion; ?></option>
																			<?php endforeach; ?>
																		</select>
																	</label>
																</div>
																<?php
																endforeach;
																?>
																<?php /*<div class="small-4 columns">
																	<label>Precio
																		<input type="text" name="producto[<?php echo $color->id_color; ?>][precio][0]" required readonly="readonly"/>
																	</label>
																</div>*/ ?>
																<div class="small-3 columns">
																	<label>Actual
																		<input type="text" name="nuevo_sku[<?php echo $color->id_color; ?>][cantidad_inicial][0]" value="" required pattern="number" disabled>
																	</label>
																</div>
																<div class="small-3 columns">
																	<label>Mínimo
																		<input type="text" name="nuevo_sku[<?php echo $color->id_color; ?>][cantidad_minima][0]" value="" required pattern="number" disabled>
																	</label>
																</div>
																<div class="small-2 columns end">
																	<label>&nbsp;
																		<button type="button" class="dynsku success" data-boton="<?php echo $color->id_color; ?>_0"><i class="fa fa-plus-circle"></i></button>
																	</label>
																</div>
																<div class="small-6 columns">
																	<label>SKU
																		<input type="text" name="nuevo_sku[<?php echo $color->id_color; ?>][sku][0]" class="sku_final" data-i="<?php echo $color->id_color; ?>" data-j="0" value="<?php echo $producto->modelo_producto; ?><?php echo $color->nombre_color; ?>" readonly="readonly" disabled>
																	</label>
																</div>
															</div>
														</div>
													</div>
												</fieldset>
											<?php endforeach; ?>
										</div>
										<div class="text-center">
											<a class="coollink grey" id="add_variedad_mod"><i class="fa fa-plus"></i> Variedad</a>
										</div>
									</fieldset>
								</div>
							</div>
							<div class="row">
								<div class="small-24 columns text-center">
									<hr>
									<input type="hidden" name="id_producto" value="<?php echo $producto->id_producto; ?>">
									<input type="hidden" id="tipo" value='<?php $tipo = $this->tipo_modelo->obtener_tipo($producto->id_tipo); echo $tipo->caracteristicas_tipo; ?>'>
									<input type="hidden" id="modelo_producto" value="<?php echo $producto->modelo_producto; ?>">
								</div>
							</div>
						</div>
					</div>

				</section>
				<section role="tabpanel" aria-hidden="true" class="content" id="diseno">

					<table class="table" style="width:100%">
						<thead>
							<tr>
								<th rowspan="2" class="text-center" width="20%">Nombre de Color</th>
								<th colspan="4" class="text-center" width="80%">Vistas</th>
							</tr>
							<tr class="title text-center">
								<th class="text-center">Frente</th>
								<th class="text-center">Atras</th>
								<th class="text-center">Izquierda</th>
								<th class="text-center">Derecha</th>
							</tr>
						</thead>

						<tbody>

							<?php if( isset($design->options) && count($design->options)):  ?>
								<?php for( $i=0; $i<count($design->options); $i++ ) :?>

									<tr id="color_<?php echo $i; ?>" data-color="<?php echo $design->options[$i]['color_title']; ?>">
										<td class="text-center">
											<?php echo $design->options[$i]['color_title']; ?>
										</td>

										<td class="text-center">
											<input type="hidden" id="front-products-design-<?php echo $i; ?>" value="<?php  echo $design->options[$i]['front']; ?>" name="product[design][front][]">
											<a onclick="dgUI.product.design(this, 'front')" href="javascript:void(0)">Ajustar</a>
										</td>

										<td class="text-center">
											<input type="hidden" id="back-products-design-<?php echo $i; ?>" value="<?php  echo $design->options[$i]['back']; ?>" name="product[design][back][]">
											<a onclick="dgUI.product.design(this, 'back')" href="javascript:void(0)">Ajustar</a>
										</td>

										<td class="text-center">
											<input type="hidden" id="left-products-design-<?php echo $i; ?>" value="<?php  echo $design->options[$i]['left']; ?>" name="product[design][left][]">
											<a onclick="dgUI.product.design(this, 'left')" href="javascript:void(0)">Ajustar</a>
										</td>

										<td class="text-center">
											<input type="hidden" id="right-products-design-<?php echo $i; ?>" value="<?php echo $design->options[$i]['right']; ?>" name="product[design][right][]">
											<a onclick="dgUI.product.design(this, 'right')" href="javascript:void(0)">Ajustar</a>
										</td>
									</tr>

								<?php endfor; ?>
							<?php endif; ?>
						</tbody>
						<tfoot>
							<input type="hidden" value="<?php echo $design->params->front; ?>" id="products-design-print-front" name="product[design][params][front]" />
							<input type="hidden" value="<?php echo $design->params->back; ?>" id="products-design-print-back" name="product[design][params][back]" />
							<input type="hidden" value="<?php echo $design->params->left; ?>" id="products-design-print-left" name="product[design][params][left]" />
							<input type="hidden" value="<?php echo $design->params->right; ?>" id="products-design-print-right" name="product[design][params][right]" />
							<input type="hidden" value="<?php echo $design->area->front; ?>" id="products-design-area-front" name="product[design][area][front]" />
							<input type="hidden" value="<?php echo $design->area->back; ?>" id="products-design-area-back" name="product[design][area][back]" />
							<input type="hidden" value="<?php echo $design->area->left; ?>" id="products-design-area-left" name="product[design][area][left]" />
							<input type="hidden" value="<?php echo $design->area->right; ?>" id="products-design-area-right" name="product[design][area][right]" />
							<input type="hidden" value="<?php echo $producto->id_producto; ?>" name="product[id]" />
						</tfoot>
					</table>
				</section>
			</div>
			<div class="text-center">
				<button type="submit">Guardar modificaciones</button>
			</div>

		</form>
	</div>
</div>


<div id="ajax-modal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" style="display: none;"></div>
