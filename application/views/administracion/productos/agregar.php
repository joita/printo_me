<div class="row" style="padding: 0 1rem;">
	<div class="small-24 columns navholder">
		<a href="<?php echo site_url('administracion/productos/'.$categoria_slug.'/'.$tipo_activo->tipo->nombre_tipo_slug); ?>" class="coollink"><i class="fa fa-arrow-circle-left"></i> Regresar</a>
	</div>
</div>
<form action="<?php echo site_url(uri_string().'/procesar'); ?>" method="post" enctype="multipart/form-data" data-abide>
	<div class="row">
		<div class="small-24 columns">
			<div class="row">
				<div class="small-8 columns">
					<fieldset id="datos_producto">
						<legend>Datos del producto</legend>
						<div class="row">
							<div class="small-24 columns">
								<label>Nombre del producto
									<input type="text" name="nombre_producto" id="nombre_producto" required placeholder="Ej: Playera básica" />
								</label>
								<small class="error">Campo requerido.</small>
							</div>
						</div>
						<div class="row">
							<div class="small-24 columns">
								<label>Modelo del producto
									<input type="text" name="modelo_producto" id="modelo_producto" required placeholder="Ej: DD382" />
								</label>
								<small class="error">Campo requerido.</small>
							</div>
						</div>
						<div class="row hide">
							<div class="small-24 columns">
								<label>Tipo de producto
									<select id="tipo_producto_add" required>
										<option value=""></option>
									<?php foreach($this->tipo_modelo->obtener_tipos() as $tipo): ?>
										<option value='<?php echo $tipo->caracteristicas_tipo; ?>' data-id_tipo="<?php echo $tipo->id_tipo; ?>"<?php //if($tipo_forzado->id_tipo != $tipo->id_tipo) { echo ' style="background:#CCC;"'; } else { echo ' style="background:#FFF;font-weight:bold;"'; } ?>><?php echo $tipo->nombre_tipo; ?></option>
									<?php endforeach; ?>
									</select>
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
										<option value="<?php echo $marca->id_marca; ?>"><?php echo $marca->nombre_marca; ?></option>
									<?php endforeach; ?>
									</select>
								</label>
								<small class="error">Campo requerido.</small>
							</div>
						</div>
						<?php /*<div class="row">
							<div class="small-24 columns">
								<label>Precio (sin IVA)
									<input type="text" name="precio_producto" id="precio_producto" required pattern="number" placeholder="Ejemplo: 300.00" value="" />
								</label>
								<small class="error">Campo requerido.</small>
							</div>
						</div> */?>
						<div class="row">
							<div class="small-24 columns">
								<label>Descripción del producto
									<textarea name="descripcion_producto" id="descripcion_producto" required pattern="^(.|\s){50,}$"></textarea>
								</label>
								<small class="error">Campo requerido (mínimo 50 caracteres).</small>
							</div>
						</div>
						<div class="row">
							<div class="small-24 columns">
								<label>Género
									<select name="genero" id="genero_add" required>
										<option value=""></option>
									<?php foreach($this->generos as $indice_genero => $genero): ?>
										<option value="<?php echo $indice_genero; ?>"><?php echo $genero; ?></option>
									<?php endforeach; ?>
									</select>
								</label>
								<small class="error">Campo requerido.</small>
							</div>
						</div>
					</fieldset>
					<fieldset id="datos_adicionales" class="hide">
						<legend>Datos adicionales</legend>
						<div class="row">
							<div class="small-12 columns">
								<label>Descuento %
									<input type="text" name="descuento_especifico" id="precio_producto" pattern="number" placeholder="Ejemplo: 25" value="0" />
								</label>
								<small class="error">Campo requerido.</small>
							</div>
						</div>
						<div class="row">
							<div class="small-24 columns">
								<label>
									<input type="checkbox" name="envio_gratis" value="1"> Envío gratis
								</label>
							</div>
						</div>
						<div class="row">
							<div class="small-24 columns">
								<label>
									<input type="checkbox" name="aplica_devolucion" value="1"> Aplica devolución
								</label>
							</div>
						</div>
					</fieldset>
					<?php if(!is_null($caracteristicas_adicionales)): ?>
					<fieldset id="cara_adicionales" class="recargar_ajax">
						<legend>Características adicionales</legend>
						<?php foreach($caracteristicas_adicionales as $slug=>$caracteristica_adicional): ?>
						<label class="divisor"><?php echo $caracteristica_adicional['nombre']; ?></label>
							<?php foreach($caracteristica_adicional['items'] as $nivel_1): ?>
								<?php if(isset($nivel_1['items'])): ?>
								<label><strong><?php echo $nivel_1['nombre']; ?></strong></label>
								<?php foreach($nivel_1['items'] as $nivel_2): ?>
								<label>
									<input type="radio" class="second_level" name="car_adi[<?php echo $slug; ?>]" id="<?php echo $slug.'_'.$nivel_1['slug'].'_'.$nivel_2['slug']; ?>" value="<?php echo $nivel_1['slug'].'_'.$nivel_2['slug']; ?>" required> <?php echo $nivel_2['nombre']; ?>
								</label>
								<?php endforeach; ?>
								<?php else: ?>
								<label>
									<input type="radio" name="car_adi[<?php echo $slug; ?>]" id="<?php echo $slug.'_'.$nivel_1['slug']; ?>" value="<?php echo $nivel_1['slug']; ?>" required> <?php echo $nivel_1['nombre']; ?>
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
						<div id="nah">
							<p style="line-height:6;" class="text-center">Tiene que seleccionar un tipo de producto primero.</p>
						</div>

						<div id="fots" style="display:none;">
							<fieldset data-foto="0" class="nomtop">
								<legend>Variedad de color</legend>
								<div class="row">
									<div class="small-24 columns">
										<fieldset>
											<legend>Color</legend>
											<div class="row collapse" style="margin-bottom: 1rem;">
												<div class="small-24 large-6 columns">
													<label>Color
														<input type="text" class="color" name="producto[0][color]" data-i="0" value="#FFFFFF">
													</label>
												</div>
												<div class="small-24 large-7 columns">
													<label>Nombre
														<input type="text" class="nombre_color" id="nombre_color_0" name="producto[0][nombre_color]" data-i="0" required>
													</label>
												</div>
												<div class="small-24 large-10  columns">
													<label>Precio (sin IVA)
														<input type="text" name="producto[0][precio]" id="precio_producto" required pattern="number" placeholder="Ejemplo: 50.00" value="" />
													</label>
													<small class="error">Campo requerido.</small>
												</div>
											</div>
											<?php /*<div class="row collapse">

											</div>*/?>
										</fieldset>
									</div>
									<div class="small-24 columns">
										<fieldset>
											<legend>Fotografías</legend>
											<div class="row">
												<div class="small-24 columns" id="contenido_fotos_0">
													<div class="row foto">
														<div class="small-16 columns">
															<label>Fotografía
																<input type="file" name="producto[0][fotografia][]" accept="image/*" data-i="0" required />
															</label>
														</div>
														<div class="small-4 columns">
															<label>&nbsp;
																<button type="button" class="add_foto success" data-producto="0"><i class="fa fa-plus-circle"></i></button>
															</label>
														</div>
														<div class="small-4 columns">

														</div>
													</div>
												</div>
											</div>
										</fieldset>
									</div>
								</div>
								<div class="row">
									<div class="small-24 columns variable-content" id="var1">

									</div>
								</div>
							</fieldset>
						</div>
						<div class="text-center">
							<a class="coollink grey" id="add_variedad" style="display:none;"><i class="fa fa-plus"></i> Variedad</a>
						</div>
					</fieldset>
				</div>
			</div>
			<div class="row">
				<div class="small-24 columns text-center">
					<hr>
					<input type="hidden" name="id_tipo" id="id_tipo_add">
					<button type="submit" class="success">Agregar Producto</button>
				</div>
			</div>
		</div>
	</div>
</form>
