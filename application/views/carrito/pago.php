<div class="fgc pscat">
	<form method="post" action="<?php echo site_url('carrito/terminar'); ?>" id="terminar_pago" data-abide="ajax" novalidate autocomplete="off">
		<div class="row" id="area_pagar">
			<div class="small-18 medium-18 large-18 large-centered columns">
				<div class="row">
					<div class="small-18 medium-9 large-6 columns" id="col_direccion">
						<div class="surround">
						<?php $is_client = !is_null($this->session->login['id_cliente']);  ?>
						<?php if(!$is_client): ?>
						<?php // Opcion de agregar datos iniciales si no es cliente ?>
							<h4 class="paso">Tus datos de envío</h4>
							<div class="row">
								<div class="small-18 columns">
									<p class="aceptamos text-justify">Al realizar la compra, te crearemos una cuenta con los datos proporcionados para que puedas acceder y ver tus pedidos.</p>
								</div>
							</div>
							<div class="row">
								<div class="small-18 medium-9 columns">
									<label>Nombre(s)
										<input type="text" name="direccion[nombre]" id="nombre"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['nombre'].'"' : ''); ?> required />
									</label>
								</div>
								<div class="small-18 medium-9 columns">
									<label>Apellido(s)
										<input type="text" name="direccion[apellidos]" id="apellidos"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['apellidos'].'"' : ''); ?> required />
									</label>
								</div>
							</div>
							<div class="row">
								<div class="small-18 medium-11 columns">
									<label>E-mail
										<input type="email" name="direccion[email]" id="email"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['email'].'"' : ''); ?> required />
									</label>
								</div>
								<div class="small-18 medium-7 columns">
									<label>Teléfono
										<input type="text" name="direccion[telefono]" id="telefono"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['telefono'].'"' : ''); ?> required pattern="^\d{10}$"/>
										<small class="form-error">Dato obligatorio, deberán ser 10 dígitos.</small>
									</label>
								</div>
							</div>
							<div class="row">
								<div class="small-18 columns">
									<label>Dirección línea 1 (máximo 35 caracteres)
										<input type="text" name="direccion[linea1]" id="linea1"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['linea1'].'"' : ''); ?> placeholder="Calle, Número Ext., Número Int., Cruzamiento"  required pattern="^(.|\s){0,35}$" maxlength="35" />
									</label>
									<small class="form-error">Dato obligatorio, máximo 35 caracteres.</small>
								</div>
							</div>
							<div class="row">
								<div class="small-18 columns">
									<label>Dirección línea 2 (máximo 35 caracteres)
										<input type="text" name="direccion[linea2]" id="linea2"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['linea2'].'"' : ''); ?> placeholder="Colonia" pattern="^(.|\s){0,35}$" maxlength="35" />
									</label>
								</div>
							</div>
							<div class="row">
								<div class="small-18 medium-11 columns">
									<label>Ciudad (máximo 35 caracteres)
										<input type="text" name="direccion[ciudad]" id="ciudad"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['ciudad'].'"' : ''); ?> required pattern="^(.|\s){0,35}$" maxlength="35" />
									</label>
								</div>
								<div class="small-18 medium-7 columns end">
									<label>Código Postal
										<input type="text" name="direccion[codigo_postal]" id="codigo_postal"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['codigo_postal'].'"' : ''); ?> required />
									</label>
								</div>
							</div>
							<div class="row">
								<div class="small-18 columns">
									<label>Estado
										<select name="direccion[estado]" id="estado" required>
											<option value=""></option>
											<option value="Aguascalientes">Aguascalientes</option>
											<option value="Baja California">Baja California</option>
											<option value="Baja California Sur">Baja California Sur</option>
											<option value="Campeche">Campeche</option>
											<option value="Chiapas">Chiapas</option>
											<option value="Chihuahua">Chihuahua</option>
											<option value="Coahuila">Coahuila</option>
											<option value="Colima">Colima</option>
											<option value="Distrito Federal">Distrito Federal</option>
											<option value="Durango">Durango</option>
											<option value="Estado de México">Estado de México</option>
											<option value="Guanajuato">Guanajuato</option>
											<option value="Guerrero">Guerrero</option>
											<option value="Hidalgo">Hidalgo</option>
											<option value="Jalisco">Jalisco</option>
											<option value="Michoacán">Michoacán</option>
											<option value="Morelos">Morelos</option>
											<option value="Nayarit">Nayarit</option>
											<option value="Nuevo León">Nuevo León</option>
											<option value="Oaxaca">Oaxaca</option>
											<option value="Puebla">Puebla</option>
											<option value="Querétaro">Querétaro</option>
											<option value="Quintana Roo">Quintana Roo</option>
											<option value="San Luis Potosí">San Luis Potosí</option>
											<option value="Sinaloa">Sinaloa</option>
											<option value="Sonora">Sonora</option>
											<option value="Tabasco">Tabasco</option>
											<option value="Tamaulipas">Tamaulipas</option>
											<option value="Tlaxcala">Tlaxcala</option>
											<option value="Veracruz">Veracruz</option>
											<option value="Yucatán">Yucatán</option>
											<option value="Zacatecas">Zacatecas</option>
										</select>
									</label>
								</div>
							</div>

							<div class="row">
								<div class="small-18 columns text-center">
									<label id="factu">
										<input type="checkbox" id="requiero_facturar"<?php if($this->session->direccion_fiscal_temporal) { echo ' checked'; } ?> /> Requiero facturar
									</label>
								</div>
							</div>

							<?php // para facturacion ?>
							<div id="hidden_fact"<?php if(!$this->session->direccion_fiscal_temporal) { echo ' style="display:none;"'; } ?>>
								<h4 class="paso">Tus datos de facturación</h4>
								<div class="row">
									<div class="small-18 columns">
										<?php $direcciones_fiscales = $this->cuenta_modelo->obtener_direcciones_fiscales($this->session->login['id_cliente']); ?>
										<?php if(sizeof($direcciones_fiscales) > 0): ?>
										<select name="id_direccion_fiscal" id="id_direccion_fiscal">
											<option value="">Seleccionar datos de facturación</option>
											<optgroup label="Mis datos de facturación">
											<?php foreach($direcciones_fiscales as $direccion): ?>
												<option value="<?php echo $direccion->id_direccion_fiscal; ?>" data-dircompleta='<?php echo json_encode($direccion); ?>'><?php echo $direccion->razon_social; ?> (<?php echo $direccion->rfc; ?>)</option>
											<?php endforeach; ?>
											</optgroup>
											<optgroup label="Más opciones">
												<option id="agregar_dinamico" value="" data-open="nueva_direccion">+ Agregar datos de facturación</option>
											</optgroup>
										</select>

										<label class="clearfix direccion_pago" id="direccion_fiscal_seleccionada" data-dircompleta=''>
											<span class="text-center">Por favor selecciona los datos de facturación para la factura.</span>
										</label>
										<?php else: ?>

										<div class="row">
											<div class="small-18 columns">
												<label>Razón Social / Nombre
													<input type="text" name="direccion_fiscal[razon_social]" id="razon_social_limpia" placeholder=""<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['razon_social'].'"' : ''); ?> required />
													<small class="form-error">Dato obligatorio.</small>
												</label>
											</div>
										</div>
										<div class="row">
											<div class="small-18 columns">
												<label>R.F.C.
													<input type="text" name="direccion_fiscal[rfc]" id="rfc_limpia" placeholder=""<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['rfc'].'"' : ''); ?> required />
													<small class="form-error">Dato obligatorio.</small>
												</label>
											</div>
										</div>
										<div class="row">
											<div class="small-18 columns">
												<label>Dirección línea 1
													<input type="text" name="direccion_fiscal[linea1]" id="linea1_limpia" placeholder="Calle, Número Ext., Número Int., Cruzamiento"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['linea1'].'"' : ''); ?> required />
												</label>
											</div>
										</div>
										<div class="row">
											<div class="small-18 columns">
												<label>Dirección línea 2
													<input type="text" name="direccion_fiscal[linea2]" id="linea2_limpia" placeholder="Colonia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['linea2'].'"' : ''); ?> />
												</label>
											</div>
										</div>
										<div class="row">
											<div class="small-18 medium-11 columns">
												<label>Ciudad
													<input type="text" name="direccion_fiscal[ciudad]" id="ciudad_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['ciudad'].'"' : ''); ?> required />
												</label>
											</div>
											<div class="small-18 medium-7 columns end">
												<label>Código Postal
													<input type="text" name="direccion_fiscal[codigo_postal]" id="codigo_postal_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['codigo_postal'].'"' : ''); ?> required />
												</label>
											</div>
										</div>
										<div class="row">
											<div class="small-18 columns">
												<label>Estado
													<select name="direccion_fiscal[estado]" id="estado_limpia" required>
														<option value=""></option>
														<option value="Aguascalientes">Aguascalientes</option>
														<option value="Baja California">Baja California</option>
														<option value="Baja California Sur">Baja California Sur</option>
														<option value="Campeche">Campeche</option>
														<option value="Chiapas">Chiapas</option>
														<option value="Chihuahua">Chihuahua</option>
														<option value="Coahuila">Coahuila</option>
														<option value="Colima">Colima</option>
														<option value="Distrito Federal">Distrito Federal</option>
														<option value="Durango">Durango</option>
														<option value="Estado de México">Estado de México</option>
														<option value="Guanajuato">Guanajuato</option>
														<option value="Guerrero">Guerrero</option>
														<option value="Hidalgo">Hidalgo</option>
														<option value="Jalisco">Jalisco</option>
														<option value="Michoacán">Michoacán</option>
														<option value="Morelos">Morelos</option>
														<option value="Nayarit">Nayarit</option>
														<option value="Nuevo León">Nuevo León</option>
														<option value="Oaxaca">Oaxaca</option>
														<option value="Puebla">Puebla</option>
														<option value="Querétaro">Querétaro</option>
														<option value="Quintana Roo">Quintana Roo</option>
														<option value="San Luis Potosí">San Luis Potosí</option>
														<option value="Sinaloa">Sinaloa</option>
														<option value="Sonora">Sonora</option>
														<option value="Tabasco">Tabasco</option>
														<option value="Tamaulipas">Tamaulipas</option>
														<option value="Tlaxcala">Tlaxcala</option>
														<option value="Veracruz">Veracruz</option>
														<option value="Yucatán">Yucatán</option>
														<option value="Zacatecas">Zacatecas</option>
													</select>
												</label>
											</div>
										</div>
										<div class="row">
											<div class="small-18 medium-10 large-11 columns">
												<label>Correo electrónico
													<input type="email" name="direccion_fiscal[correo_electronico_facturacion]" id="correo_electronico_facturacion_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['correo_electronico_facturacion'].'"' : ''); ?> required />
													<small class="form-error">Dato obligatorio.</small>
												</label>
											</div>
											<div class="small-18 medium-8 large-7 columns">
												<label>Teléfono
													<input type="text" name="direccion_fiscal[telefono]" id="telefono_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['telefono'].'"' : ''); ?> required pattern="^\d{10}$" />
													<small class="form-error">Dato obligatorio, deberán ser 10 dígitos.</small>
												</label>
											</div>
										</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php else: ?>
						<?php // Opcion de agregar datos iniciales si si es cliente ?>
							<h4 class="paso">Tus datos de envío</h4>
							<div class="row">
								<div class="small-18 columns">
									<?php $direcciones = $this->cuenta_modelo->obtener_direcciones($this->session->login['id_cliente']); ?>
									<?php if(sizeof($direcciones) > 0): ?>
									<select name="id_direccion" id="id_direccion" required>
										<option value="">Seleccionar dirección de envío</option>
										<optgroup label="Mis Direcciones">
										<?php foreach($direcciones as $direccion): ?>
											<option value="<?php echo $direccion->id_direccion; ?>" data-dircompleta='<?php echo json_encode($direccion); ?>'><?php echo $direccion->identificador_direccion; ?> (<?php echo $direccion->linea1; ?>, <?php echo $direccion->linea2; ?>...)</option>
										<?php endforeach; ?>
										</optgroup>
										<optgroup label="Más opciones">
											<option id="agregar_dinamico" value="" data-open="nueva_direccion">+ Agregar Dirección</option>
										</optgroup>
									</select>

									<label class="clearfix direccion_pago" id="direccion_envio_seleccionada" data-dircompleta=''>
										<span class="text-center">Por favor selecciona una dirección de envío.</span>
									</label>
									<?php else: ?>

									<div class="row">
										<div class="small-18 medium-11 columns">
											<label>Identificador
												<input type="text" name="direccion[identificador_direccion]" id="identificador_direccion"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['identificador_direccion'].'"' : ''); ?> placeholder="Casa, Oficina, etc." required />
											</label>
										</div>
										<div class="small-18 medium-7 columns">
											<label>Teléfono
												<input type="text" name="direccion[telefono]" id="telefono"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['telefono'].'"' : ''); ?> required pattern="^\d{10}$"/>
												<small class="form-error">Dato obligatorio, deberán ser 10 dígitos.</small>
											</label>
										</div>
									</div>
									<div class="row">
										<div class="small-18 columns">
											<label>Dirección línea 1 (máximo 35 caracteres)
												<input type="text" name="direccion[linea1]" id="linea1"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['linea1'].'"' : ''); ?> placeholder="Calle, Número Ext., Número Int., Cruzamiento" required pattern="^(.|\s){0,35}$" maxlength="35" />
											</label>
											<small class="form-error">Dato obligatorio, máximo 35 caracteres.</small>
										</div>
									</div>
									<div class="row">
										<div class="small-18 columns">
											<label>Dirección línea 2 (máximo 35 caracteres)
												<input type="text" name="direccion[linea2]" id="linea2"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['linea2'].'"' : ''); ?> placeholder="Colonia" pattern="^(.|\s){0,35}$" maxlength="35" />
											</label>
										</div>
									</div>
									<div class="row">
										<div class="small-18 medium-11 columns">
											<label>Ciudad (máximo 35 caracteres)
												<input type="text" name="direccion[ciudad]" id="ciudad"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['ciudad'].'"' : ''); ?> required pattern="^(.|\s){0,35}$" maxlength="35" />
											</label>
										</div>
										<div class="small-18 medium-7 columns end">
											<label>Código Postal
												<input type="text" name="direccion[codigo_postal]" id="codigo_postal"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['codigo_postal'].'"' : ''); ?> required />
											</label>
										</div>
									</div>
									<div class="row">
										<div class="small-18 columns">
											<label>Estado
												<select name="direccion[estado]" id="estado" required>
													<option value=""></option>
													<option value="Aguascalientes">Aguascalientes</option>
													<option value="Baja California">Baja California</option>
													<option value="Baja California Sur">Baja California Sur</option>
													<option value="Campeche">Campeche</option>
													<option value="Chiapas">Chiapas</option>
													<option value="Chihuahua">Chihuahua</option>
													<option value="Coahuila">Coahuila</option>
													<option value="Colima">Colima</option>
													<option value="Distrito Federal">Distrito Federal</option>
													<option value="Durango">Durango</option>
													<option value="Estado de México">Estado de México</option>
													<option value="Guanajuato">Guanajuato</option>
													<option value="Guerrero">Guerrero</option>
													<option value="Hidalgo">Hidalgo</option>
													<option value="Jalisco">Jalisco</option>
													<option value="Michoacán">Michoacán</option>
													<option value="Morelos">Morelos</option>
													<option value="Nayarit">Nayarit</option>
													<option value="Nuevo León">Nuevo León</option>
													<option value="Oaxaca">Oaxaca</option>
													<option value="Puebla">Puebla</option>
													<option value="Querétaro">Querétaro</option>
													<option value="Quintana Roo">Quintana Roo</option>
													<option value="San Luis Potosí">San Luis Potosí</option>
													<option value="Sinaloa">Sinaloa</option>
													<option value="Sonora">Sonora</option>
													<option value="Tabasco">Tabasco</option>
													<option value="Tamaulipas">Tamaulipas</option>
													<option value="Tlaxcala">Tlaxcala</option>
													<option value="Veracruz">Veracruz</option>
													<option value="Yucatán">Yucatán</option>
													<option value="Zacatecas">Zacatecas</option>
												</select>
											</label>
										</div>
									</div>
									<?php endif; ?>
								</div>
							</div>

							<div class="row">
								<div class="small-18 columns text-center">
									<label id="factu">
										<input type="checkbox" id="requiero_facturar"<?php if($this->session->direccion_fiscal_temporal) { echo ' checked'; } ?> /> Requiero facturar
									</label>
								</div>
							</div>

							<?php // para facturacion ?>
							<div id="hidden_fact"<?php if(!$this->session->direccion_fiscal_temporal) { echo ' style="display:none;"'; } ?>>
								<h4 class="paso">Tus datos de facturación</h4>
								<div class="row">
									<div class="small-18 columns">
										<?php $direcciones_fiscales = $this->cuenta_modelo->obtener_direcciones_fiscales($this->session->login['id_cliente']); ?>
										<?php if(sizeof($direcciones_fiscales) > 0): ?>
										<select name="id_direccion_fiscal" id="id_direccion_fiscal">
											<option value="">Seleccionar datos de facturación</option>
											<optgroup label="Mis datos de facturación">
											<?php foreach($direcciones_fiscales as $direccion): ?>
												<option value="<?php echo $direccion->id_direccion_fiscal; ?>" data-dircompleta='<?php echo json_encode($direccion); ?>'><?php echo $direccion->razon_social; ?> (<?php echo $direccion->rfc; ?>)</option>
											<?php endforeach; ?>
											</optgroup>
											<optgroup label="Más opciones">
												<option id="agregar_dinamico" value="" data-open="nueva_direccion">+ Agregar datos de facturación</option>
											</optgroup>
										</select>

										<label class="clearfix direccion_pago" id="direccion_fiscal_seleccionada" data-dircompleta=''>
											<span class="text-center">Por favor selecciona los datos de facturación para la factura.</span>
										</label>
										<?php else: ?>

										<div class="row">
											<div class="small-18 columns">
												<label>Razón Social / Nombre
													<input type="text" name="direccion_fiscal[razon_social]" id="razon_social_limpia" placeholder=""<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['razon_social'].'"' : ''); ?> required />
													<small class="form-error">Dato obligatorio.</small>
												</label>
											</div>
										</div>
										<div class="row">
											<div class="small-18 columns">
												<label>R.F.C.
													<input type="text" name="direccion_fiscal[rfc]" id="rfc_limpia" placeholder=""<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['rfc'].'"' : ''); ?> required />
													<small class="form-error">Dato obligatorio.</small>
												</label>
											</div>
										</div>
										<div class="row">
											<div class="small-18 columns">
												<label>Dirección línea 1
													<input type="text" name="direccion_fiscal[linea1]" id="linea1_limpia" placeholder="Calle, Número Ext., Número Int., Cruzamiento"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['linea1'].'"' : ''); ?> required />
												</label>
											</div>
										</div>
										<div class="row">
											<div class="small-18 columns">
												<label>Dirección línea 2
													<input type="text" name="direccion_fiscal[linea2]" id="linea2_limpia" placeholder="Colonia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['linea2'].'"' : ''); ?> />
												</label>
											</div>
										</div>
										<div class="row">
											<div class="small-18 medium-11 columns">
												<label>Ciudad
													<input type="text" name="direccion_fiscal[ciudad]" id="ciudad_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['ciudad'].'"' : ''); ?> required />
												</label>
											</div>
											<div class="small-18 medium-7 columns end">
												<label>Código Postal
													<input type="text" name="direccion_fiscal[codigo_postal]" id="codigo_postal_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['codigo_postal'].'"' : ''); ?> required />
												</label>
											</div>
										</div>
										<div class="row">
											<div class="small-18 columns">
												<label>Estado
													<select name="direccion_fiscal[estado]" id="estado_limpia" required>
														<option value=""></option>
														<option value="Aguascalientes">Aguascalientes</option>
														<option value="Baja California">Baja California</option>
														<option value="Baja California Sur">Baja California Sur</option>
														<option value="Campeche">Campeche</option>
														<option value="Chiapas">Chiapas</option>
														<option value="Chihuahua">Chihuahua</option>
														<option value="Coahuila">Coahuila</option>
														<option value="Colima">Colima</option>
														<option value="Distrito Federal">Distrito Federal</option>
														<option value="Durango">Durango</option>
														<option value="Estado de México">Estado de México</option>
														<option value="Guanajuato">Guanajuato</option>
														<option value="Guerrero">Guerrero</option>
														<option value="Hidalgo">Hidalgo</option>
														<option value="Jalisco">Jalisco</option>
														<option value="Michoacán">Michoacán</option>
														<option value="Morelos">Morelos</option>
														<option value="Nayarit">Nayarit</option>
														<option value="Nuevo León">Nuevo León</option>
														<option value="Oaxaca">Oaxaca</option>
														<option value="Puebla">Puebla</option>
														<option value="Querétaro">Querétaro</option>
														<option value="Quintana Roo">Quintana Roo</option>
														<option value="San Luis Potosí">San Luis Potosí</option>
														<option value="Sinaloa">Sinaloa</option>
														<option value="Sonora">Sonora</option>
														<option value="Tabasco">Tabasco</option>
														<option value="Tamaulipas">Tamaulipas</option>
														<option value="Tlaxcala">Tlaxcala</option>
														<option value="Veracruz">Veracruz</option>
														<option value="Yucatán">Yucatán</option>
														<option value="Zacatecas">Zacatecas</option>
													</select>
												</label>
											</div>
										</div>
										<div class="row">
											<div class="small-18 medium-10 large-11 columns">
												<label>Correo electrónico
													<input type="email" name="direccion_fiscal[correo_electronico_facturacion]" id="correo_electronico_facturacion_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['correo_electronico_facturacion'].'"' : ''); ?> required />
													<small class="form-error">Dato obligatorio.</small>
												</label>
											</div>
											<div class="small-18 medium-8 large-7 columns">
												<label>Teléfono
													<input type="text" name="direccion_fiscal[telefono]" id="telefono_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['telefono'].'"' : ''); ?> required pattern="^\d{10}$" />
													<small class="form-error">Dato obligatorio, deberán ser 10 dígitos.</small>
												</label>
											</div>
										</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<?php endif; ?>
						</div>
					</div>
					<div class="small-18 medium-9 large-6 columns" id="col_pedido">
						<div class="surround">
							<h4 class="paso">Resumen de pedido</h4>
							<table id="carrito">
								<tbody>
								<?php $i = 1; ?>
								<?php foreach($this->cart->contents() as $items): ?>
									<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
									<?php $options = $this->cart->product_options($items['rowid']); ?>
									<tr class="entrada_carrito">
										<td class="cantidades-carrito">
											<div class="clearfix">
												<div class="square-button-area hide">
													<button type="button" class="square increase"><i class="fa fa-plus"></i></button>
													<button type="button" class="square decrease"><i class="fa fa-minus"></i></button>
												</div>
												<div class="square-cantidad">
													<input type="text" name="<?php echo $i['qty']; ?>" value="<?php echo $items['qty']; ?>" class="qtyact" data-id="<?php echo $i; ?>" readonly="readonly" />
												</div>
											</div>
										</td>
										<td class="info-carrito">
											<div class="clearfix">
												<img src="<?php echo getCustomImage($options); ?>" alt="Fotografía del producto" class="carrito-foto" width="48" height="48" />
												<div class="carrito-descripcion">
													<span class="carrito-nombre-producto"><?php echo $items['name'].($options["enhance"] != 'enhance' ? ' personalizada' : ''); ?></span>
													<?php if(isset($options['talla'])): ?>
													<span class="carrito-talla">Talla: <?php echo $options['talla']; ?></span>
													<?php endif; ?>
												</div>
											</div>
										</td>
										<td class="precio-carrito text-right">
											<span>$<?php echo $this->cart->format_number(($items['subtotal'])); ?></span>
										</td>
									</tr>
								<?php $i++; ?>
								<?php endforeach; ?>

									<tr>
										<td colspan="2" class="precio-carrito-sub">
											<span class="text-right"><strong>Subtotal</strong></span>
										</td>
										<td class="precio-carrito-sub text-right">
											<span>$<?php echo $this->cart->format_number($this->cart->obtener_subtotal()); ?></span>
										</td>
									</tr>

									<?php if($this->cart->obtener_saldo_a_favor() > 0.00): ?>
									<tr>
										<td colspan="2" class="precio-carrito-sub">
											<span class="text-right"><strong>Saldo a favor</strong></span>
										</td>
										<td class="precio-carrito-sub text-right" id="tr_costo_envio">
											<span class="verde">-$<?php echo $this->cart->format_number($this->cart->obtener_saldo_a_favor()); ?></span>
										</td>
									</tr>
									<?php endif; ?>
									<tr>
										<td colspan="2" class="precio-carrito-sub">
											<span class="text-right"><strong>Cupón</strong></span>
										</td>
										<td class="precio-carrito-sub text-right" id="tr_costo_envio">
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
											<span class="text-right"><strong>Descuento</strong></span>
										</td>
										<td class="precio-carrito-sub text-right" id="tr_costo_envio">
											<span class="verde"><?php if($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1): ?>-<?php echo ($this->session->descuento_global->descuento * 100).'%'; ?><?php else: ?>-$<?php echo $this->cart->format_number($this->session->descuento_global->descuento); ?><?php endif; ?></span>
										</td>
									</tr>
									<tr>
										<td colspan="2" class="precio-carrito-sub">
											<span class="text-right"><strong>Con Descuento</strong></span>
										</td>
										<td class="precio-carrito-sub text-right" id="tr_costo_envio">
											<span class="verde"><?php if($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1): ?>$<?php echo $this->cart->format_number($this->cart->obtener_subtotal() * (1-$this->session->descuento_global->descuento)); ?><?php else: ?>$<?php echo $this->cart->format_number($this->cart->obtener_subtotal()  -$this->session->descuento_global->descuento); ?><?php endif; ?></span>
										</td>
									</tr>
									<?php endif; ?>

									<tr id="tr_envio_gratis" style="display:none !important;">
										<td colspan="2" class="precio-carrito-sub" style="display:none !important;">
											<span id="envio_gratis">
												<label class="clearfix">
													<input type="checkbox" id="recoger_paquete"<?php if($this->session->recoger == 'gratis') { echo ' checked'; } ?> />
													<span>Recoger paquete en las instalaciones de printome.mx en Baca, Yucatán *</span>
												</label>
											</span>
										</td>
										<td class="precio-carrito-sub text-right" style="display:none !important;">
											<span></span>
										</td>
									</tr>
									<tr>
										<td colspan="2" class="precio-carrito-sub">
											<span class="text-right"><strong>Envío</strong></span>
										</td>
										<td class="precio-carrito-sub text-right" id="tr_costo_envio">
										<?php if($this->cart->obtener_costo_envio() == 0): ?>
											<span><strong class="verde">GRATIS</strong></span>
										<?php else: ?>
											<span>$<?php echo $this->cart->format_number($this->cart->obtener_costo_envio()); ?></span>
										<?php endif; ?>
										</td>
									</tr>
									<tr>
										<td colspan="2" class="precio-carrito-sub">
											<span class="text-right"><strong>Total</strong></span>
										</td>
										<td class="precio-carrito-sub text-right" id="tr_costo_total">
											<span><strong>$<?php echo  $this->cart->format_number($this->cart->obtener_total()); ?></strong></span>
										</td>
									</tr>
									<tr id="tr_explicacion_envio_gratis"<?php /* if($this->session->recoger == 'pagado') { */ echo ' style="display:none;"'; /* } */ ?>>
										<td colspan="3" class="text-left">
											<small id="explicacion_envio_gratis">* Si tu pedido contiene productos personalizados y productos de plazo definido, tienes que tomar en cuenta que los productos de cada plazo definido tienen distintas fechas de entrega por lo cual si seleccionas la opción de recoger en nuestras instalaciones, tendrías que ir por tu paquete cuando esté listo el producto correspondiente.</small>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="small-18 medium-18 medium-centered large-uncentered large-6 columns" id="col_forma">
						<div class="surround">
							<h4 class="paso">Forma de pago</h4>

							<div class="row">
								<div class="small-18 columns">
									<ul class="tabs" data-tabs id="tab_pago">
										<li class="tabs-title is-active"><a href="#pago_tarjeta"><img src="<?php echo site_url('assets/images/visa_mc_amex.svg'); ?>" alt="Tarjetas" /></a></li>
										<li class="tabs-title"><a href="#pago_paypal"><img src="<?php echo site_url('assets/images/paypal.svg'); ?>" alt="PayPal" /></a></li>
										<li class="tabs-title"><a href="#pago_oxxo"><img src="<?php echo site_url('assets/images/oxxo.svg'); ?>" alt="OXXO" /></a></li>
									</ul>
									<div class="tabs-content" data-tabs-content="tab_pago">
										<div class="tabs-panel is-active" id="pago_tarjeta">
											<div class="row card_pay">
												<div class="small-18 columns">
													<p id="ssl">
														<i class="fa fa-lock"></i>
														La conexión por la cual se transfieren los datos es segura.
													</p>
												</div>
											</div>
											<div class="row card_pay">
												<div class="small-18 columns">
													<label>Nombre del tarjetahabiente
														<input type="text" id="card_name" data-conekta="card[name]" required placeholder="Nombre como aparece en la tarjeta.">
													</label>
												</div>
											</div>
											<div class="row card_pay">
												<div class="small-18 columns">
													<label>Número de la tarjeta
														<input type="text" id="card_number" data-conekta="card[number]" required placeholder="•••• •••• •••• ••••">
													</label>
												</div>
											</div>
											<div class="row card_pay">
												<div class="small-11 medium-11 columns">
													<label>Válida hasta:
														<input type="text" id="card_expiry_date" required placeholder="•• / ••">
														<input type="hidden" id="card_expiry_month" size="2" data-conekta="card[exp_month]">
														<input type="hidden" id="card_expiry_year" size="4" data-conekta="card[exp_year]">
													</label>
												</div>
												<div class="small-7 medium-7 columns end">
													<label for="card_expiry_date">CVC:
														<input type="text" id="card_verification" data-conekta="card[cvc]" required placeholder="••••">
													</label>
												</div>
											</div>
											<div class="row card_pay">
												<div class="small-18 columns">
													<p id="card_errors"></p>
												</div>
											</div>
											<div class="row card_pay">
												<div class="small-18 columns">
													<p class="text-justify aceptamos naranja" id="tarjeta_selecciona_direccion">Por favor selecciona una dirección de envío.</p>
													<p class="text-center p_t_b" style="display:none;"><button class="button small success" type="submit" id="pagar_tarjeta_btn"><i class="fa fa-check"></i> Pagar con Tarjeta</button></p>
												</div>
											</div>
										</div>
										<div class="tabs-panel" id="pago_paypal">
										<?php if($link_paypal != ''): ?>
											<div class="row paypal_pay">
												<div class="small-24 columns">
													<p class="text-justify aceptamos">A continuación te redirigiremos de manera segura al portal de PayPal.</p>
													<p class="text-justify aceptamos">Una vez confirmado el pago por PayPal, procederemos con la preparación de tu pedido.</p>
												</div>
											</div>
											<div class="row paypal_pay">
												<div class="small-24 columns">
													<p class="text-justify aceptamos naranja" id="paypal_selecciona_direccion">Por favor selecciona una dirección de envío.</p>
													<p class="text-center p_t_b" style="margin-top:1.5rem; display: none;" id="area_paypal"><a class="button small success" href="<?php echo $link_paypal; ?>" id="pagar_paypal_btn"><i class="fa fa-paypal"></i> Pagar con PayPal</a></p>
													<div class="loading" style="display:none;" id="paypal_loading"></div>
												</div>
											</div>
										<?php else: ?>
											<div class="row paypal_pay">
												<div class="small-24 columns">
													<p class="text-justify aceptamos">En este momento estamos experimentando problemas con la plataforma de pagos de PayPal.</p>
													<p class="text-justify aceptamos">El problema es externo a nosotros, puedes pagar ya sea con tarjeta o a través de OXXO.</p>
													<p class="text-justify aceptamos">Si requieres pagar específicamente con PayPal por favor intenta más tarde.</p>
												</div>
											</div>
										<?php endif; ?>
										</div>
										<div class="tabs-panel" id="pago_oxxo">
											<div class="row oxxo_pay">
												<div class="small-18 columns">
												<?php if($this->cart->obtener_total() < 10000): ?>
													<p class="text-justify aceptamos">Puedes realizar tu pago en cualquier OXXO de la República Mexicana: hasta por $10,000 pesos de compra, con el cargo de comisión por transacción vigente en OXXO.</p>
													<p class="text-justify aceptamos">Una vez que se genere el cargo, contarás con <strong>5 días para realizar el pago</strong>. Una vez realizado el pago, <strong>recibirás confirmación en un lapso de 24 a 72 horas y a partir de dicha confirmación se realizará el envío de tu pedido</strong>. Si requieres de un envío inmediato, te recomendamos pagar con tarjeta de crédito.</p>
													<p class="text-justify aceptamos">Una vez que confirmes tu orden te enviaremos los datos para tu pago en OXXO.</p>
													<p class="text-justify aceptamos naranja" id="oxxo_selecciona_direccion">Por favor selecciona una dirección de envío.</p>
													<p class="text-center p_t_b" style="display:none;"><button class="button small success" id="pagar_oxxo_btn" type="submit"><i class="fa fa-ticket"></i> Generar Ficha de Pago en OXXO</button></p>
												<?php else: ?>
													<p class="text-justify aceptamos naranja">El pago en OXXO es disponible por montos de máximo $10,000 pesos.</p>
												<?php endif; ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<input type="hidden" name="pago" id="tipo_pago" value="tdc" />
	</form>
</div>

<div class="small reveal" id="nueva_direccion" data-reveal>
	<form action="<?php echo site_url('mi-cuenta/direcciones/agregar/pagar'); ?>" method="post" data-abide novalidate autocomplete="off">
		<div class="row">
			<div class="small-18 text-center columns logo-container">
				<img src="#" class="small-logo" data-interchange="[<?php echo site_url('assets/images/header-logo.png'); ?>, small], [<?php echo site_url('assets/images/header-logo-retina.png'); ?>, retina]" alt="Diseña tu playera on-line | printome.mx" width="300" height="87" />
				<h5 class="text-center">Nueva Dirección</h5>
			</div>
		</div>

		<div class="row">
			<div class="small-18 columns">
				<label>Identificador
					<input type="text" name="identificador_direccion" id="identificador_direccion" placeholder="Casa, Oficina, etc." required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-18 columns">
				<label>Dirección línea 1 (máximo 35 caracteres)
					<input type="text" name="linea1" id="linea1" placeholder="Calle, Número Ext., Número Int., Cruzamiento" required pattern="^(.|\s){0,35}$" maxlength="35" />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-18 columns">
				<label>Dirección línea 2 (máximo 35 caracteres)
					<input type="text" name="linea2" id="linea2" placeholder="Colonia, Delegación, etc." pattern="^(.|\s){0,35}$" maxlength="35" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-18 medium-11 large-12 columns">
				<label>Ciudad (máximo 35 caracteres)
					<input type="text" name="ciudad" id="ciudad" required pattern="^(.|\s){0,35}$" maxlength="35" />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
			<div class="small-18 medium-7 large-6 columns">
				<label title="Código Postal">C.P.
					<input type="text" name="codigo_postal" id="codigo_postal" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-18 columns">
				<label>Estado
					<select name="estado" id="estado" required>
						<option value=""></option>
						<option value="Aguascalientes">Aguascalientes</option>
						<option value="Baja California">Baja California</option>
						<option value="Baja California Sur">Baja California Sur</option>
						<option value="Campeche">Campeche</option>
						<option value="Chiapas">Chiapas</option>
						<option value="Chihuahua">Chihuahua</option>
						<option value="Coahuila">Coahuila</option>
						<option value="Colima">Colima</option>
						<option value="Distrito Federal">Distrito Federal</option>
						<option value="Durango">Durango</option>
						<option value="Estado de México">Estado de México</option>
						<option value="Guanajuato">Guanajuato</option>
						<option value="Guerrero">Guerrero</option>
						<option value="Hidalgo">Hidalgo</option>
						<option value="Jalisco">Jalisco</option>
						<option value="Michoacán">Michoacán</option>
						<option value="Morelos">Morelos</option>
						<option value="Nayarit">Nayarit</option>
						<option value="Nuevo León">Nuevo León</option>
						<option value="Oaxaca">Oaxaca</option>
						<option value="Puebla">Puebla</option>
						<option value="Querétaro">Querétaro</option>
						<option value="Quintana Roo">Quintana Roo</option>
						<option value="San Luis Potosí">San Luis Potosí</option>
						<option value="Sinaloa">Sinaloa</option>
						<option value="Sonora">Sonora</option>
						<option value="Tabasco">Tabasco</option>
						<option value="Tamaulipas">Tamaulipas</option>
						<option value="Tlaxcala">Tlaxcala</option>
						<option value="Veracruz">Veracruz</option>
						<option value="Yucatán">Yucatán</option>
						<option value="Zacatecas">Zacatecas</option>
					</select>
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="small-18 medium-9 large-8 columns">
				<label>Teléfono
					<input type="text" name="telefono" id="telefono" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>

		<div class="row collapse add-buttons">
			<div class="small-9 columns">
				<button type="button" class="secondary button" data-close>Cancelar</button>
			</div>
			<div class="small-9 columns text-right">
				<input type="hidden" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
				<button type="submit" class="primary button" id="add_dir">Agregar Dirección</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="small reveal" id="nueva_facturacion" data-reveal>
	<form action="<?php echo site_url('mi-cuenta/facturacion/agregar/pagar'); ?>" method="post" data-abide novalidate>
		<div class="row">
			<div class="small-18 text-center columns logo-container">
				<img src="#" class="small-logo" data-interchange="[<?php echo site_url('assets/images/header-logo.png'); ?>, small], [<?php echo site_url('assets/images/header-logo-retina.png'); ?>, retina]" alt="Diseña tu playera on-line | printome.mx" width="300" height="87" />
				<h5 class="text-center">Nuevos Datos de Facturación</h5>
			</div>
		</div>

		<div class="row">
			<div class="small-18 columns">
				<label>Razón Social / Nombre
					<input type="text" name="razon_social" id="razon_social" placeholder="" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-18 columns">
				<label>R.F.C.
					<input type="text" name="rfc" id="rfc" placeholder="" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-18 columns">
				<label>Dirección línea 1
					<input type="text" name="linea1" id="linea1_fiscal" placeholder="Calle, Número Ext., Número Int., Cruzamiento" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-18 columns">
				<label>Dirección línea 2
					<input type="text" name="linea2" id="linea2_fiscal" placeholder="Colonia, Delegación, etc." />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-18 medium-11 large-12 columns">
				<label>Ciudad
					<input type="text" name="ciudad" id="ciudad_fiscal" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
			<div class="small-18 medium-7 large-6 columns">
				<label title="Código Postal">C.P.
					<input type="text" name="codigo_postal" id="codigo_postal_fiscal" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-18 columns">
				<label>Estado
					<select name="estado" id="estado_fiscal" required>
						<option value=""></option>
						<option value="Aguascalientes">Aguascalientes</option>
						<option value="Baja California">Baja California</option>
						<option value="Baja California Sur">Baja California Sur</option>
						<option value="Campeche">Campeche</option>
						<option value="Chiapas">Chiapas</option>
						<option value="Chihuahua">Chihuahua</option>
						<option value="Coahuila">Coahuila</option>
						<option value="Colima">Colima</option>
						<option value="Distrito Federal">Distrito Federal</option>
						<option value="Durango">Durango</option>
						<option value="Estado de México">Estado de México</option>
						<option value="Guanajuato">Guanajuato</option>
						<option value="Guerrero">Guerrero</option>
						<option value="Hidalgo">Hidalgo</option>
						<option value="Jalisco">Jalisco</option>
						<option value="Michoacán">Michoacán</option>
						<option value="Morelos">Morelos</option>
						<option value="Nayarit">Nayarit</option>
						<option value="Nuevo León">Nuevo León</option>
						<option value="Oaxaca">Oaxaca</option>
						<option value="Puebla">Puebla</option>
						<option value="Querétaro">Querétaro</option>
						<option value="Quintana Roo">Quintana Roo</option>
						<option value="San Luis Potosí">San Luis Potosí</option>
						<option value="Sinaloa">Sinaloa</option>
						<option value="Sonora">Sonora</option>
						<option value="Tabasco">Tabasco</option>
						<option value="Tamaulipas">Tamaulipas</option>
						<option value="Tlaxcala">Tlaxcala</option>
						<option value="Veracruz">Veracruz</option>
						<option value="Yucatán">Yucatán</option>
						<option value="Zacatecas">Zacatecas</option>
					</select>
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="small-18 medium-10 large-11 columns">
				<label>Correo electrónico
					<input type="email" name="correo_electronico_facturacion" id="correo_electronico_facturacion" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
			<div class="small-18 medium-8 large-7 columns">
				<label>Teléfono
					<input type="text" name="telefono" id="telefono_fiscal" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>

		<div class="row collapse add-buttons">
			<div class="small-9 columns">
				<button type="button" class="secondary button" data-close>Cancelar</button>
			</div>
			<div class="small-9 columns text-right">
				<input type="hidden" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
				<button type="submit" class="primary button" id="add_dir_2">Agregar</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
