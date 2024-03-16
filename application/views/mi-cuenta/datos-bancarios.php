<h2 class="seccionador show-for-medium text-left" style="color: #025573;font-weight: bold">Mis Datos de Deposito</h2>

<form action="<?php echo site_url('mi-cuenta/datos-bancarios/actualizar'); ?>" method="post" data-abide novalidate>
	<div class="row" id="contenedor-direcciones">
		<div class="small-18 columns">
			<p style="color: #F2560D">Esta información se utilizará para depositarte tus ganancias generadas por la venta de productos. Aquí puedes seleccionar tu método preferido de depósito.</p>
			<div class="row">
				<div class="small-18 medium-18 large-7 xlarge-5 columns">
					<select style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center; color: #F2560D" id="tipo_pago" name="info_pago[tipo_pago]">
						<option style="color: #F2560D" value="">Selecciona el tipo de cuenta</option>
						<option style="color: #F2560D" value="banco"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'banco') { echo ' selected'; } } ?>>Cuenta de banco</option>
						<option style="color: #F2560D" value="paypal"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'paypal') { echo ' selected'; } } ?>>PayPal</option>
					</select>
				</div>
			</div>

			<div class="row small-up-1 medium-up-1 large-up-2 xlarge-up-2" id="pago_banco" style="<?php if(!isset($dato_deposito->tipo_pago)) { echo ' display:none;'; } ?>">
				<div class="column text-center">
					<div class="direccion form-cuenta info-banco" style="border: none">
						<div class="row bank-row"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'paypal') { echo ' style="display:none;"'; } } ?>>
							<div class="small-18 columns">
								<span class="identi text-center medium-text-left" style="color: #025573"><strong>Información de cuenta de banco</strong></span>
							</div>
						</div>
						<div class="row bank-row"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'paypal') { echo ' style="display:none;"'; } } ?>>
                            <div class="column text-center">
								<label style="color: #F2560D">Nombre del cuentahabiente
									<input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" name="info_pago[nombre_cuentahabiente]" id="nombre_cuentahabiente"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'banco') { echo ' value="'.$dato_deposito->datos_json->nombre_cuentahabiente.'" required'; } } ?> />
									<span class="form-error">Campo requerido.</span>
								</label>
							</div>
						</div>
						<div class="row bank-row"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'paypal') { echo ' style="display:none;"'; } } ?>>
                            <div class="column text-center">
								<label style="color: #F2560D">Nombre del banco
									<input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" name="info_pago[nombre_banco]" id="nombre_banco"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'banco') { echo ' value="'.$dato_deposito->datos_json->nombre_banco.'" required'; } } ?> />
									<span class="form-error">Campo requerido.</span>
								</label>
							</div>
						</div>
						<div class="row bank-row"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'paypal') { echo ' style="display:none;"'; } } ?>>
                            <div class="column text-center">
								<label style="color: #F2560D">CLABE Interbancaria
									<input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" name="info_pago[clabe]" id="clabe_banco"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'banco') { echo ' value="'.$dato_deposito->datos_json->clabe.'"  required'; } } ?> />
									<span class="form-error">Campo requerido.</span>
								</label>
							</div>
						</div>
						<div class="row bank-row"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'paypal') { echo ' style="display:none;"'; } } ?>>
                            <div class="column text-center">
								<label style="color: #F2560D">Cuenta de banco
									<input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" name="info_pago[cuenta]" id="cuenta"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'banco') { echo ' value="'.$dato_deposito->datos_json->cuenta.'" required'; } } ?> />
									<span class="form-error">Campo requerido.</span>
								</label>
							</div>
						</div>
						<div class="row bank-row"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'paypal') { echo ' style="display:none;"'; } } ?>>
                            <div class="column text-center">
								<label style="color: #F2560D">Ciudad
									<input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" name="info_pago[ciudad]" id="ciudad"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'banco') { echo (isset($dato_deposito->datos_json->ciudad) ? ' value="'.$dato_deposito->datos_json->ciudad.'"' : '').' required'; } } ?> />
									<span class="form-error">Campo requerido.</span>
								</label>
							</div>
						</div>
						<div class="row bank-row"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'paypal') { echo ' style="display:none;"'; } } ?>>
                            <div class="column text-center">
								<label style="color: #F2560D">Sucursal
									<input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" name="info_pago[sucursal]" id="sucursal"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'banco') { echo (isset($dato_deposito->datos_json->sucursal) ? ' value="'.$dato_deposito->datos_json->sucursal.'"' : '').' '; } } ?> />
									<span class="form-error">Campo requerido.</span>
								</label>
							</div>
						</div>

						<div class="row paypal-row"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'banco') { echo ' style="display:none;"'; } } ?>>
                            <div class="column text-center">
								<span style="color: #025573" class="identi text-center medium-text-left"><strong>Información de cuenta de PayPal</strong></span>
							</div>
						</div>
						<div class="row paypal-row"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'banco') { echo ' style="display:none;"'; } } ?>>
                            <div class="column text-center">
								<label style="color: #F2560D">E-Mail asociado a PayPal
									<input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="email" name="info_pago[cuenta_paypal]" id="cuenta_paypal"<?php if(isset($dato_deposito->tipo_pago)) { if($dato_deposito->tipo_pago == 'paypal') { echo ' value="'.$dato_deposito->datos_json->cuenta_paypal.'" required'; } } ?> />
									<span class="form-error">Campo requerido.</span>
								</label>
							</div>
						</div>

						<div class="row">
							<div class="small-18 columns">
								<button type="submit" class="guardar btn btn-success button"><i class="fa fa-save"></i> Guardar Cambios</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
