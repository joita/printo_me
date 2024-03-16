<div class="small reveal" id="cupon_printome" data-reveal>
	<form id="cupon_form" data-abide="ajax" novalidate>

		<div class="row collapse">
			<div class="small-18 columns">
				<img src="<?php echo site_url('assets/images/cupon-envio.png'); ?>" alt="Cupón de envío" />
			</div>
		</div>

		<div class="row collapse">
			<div class="small-18 columns">
				<label>Nombre
					<input type="text" name="nombre_cupon" id="nombre_cupon" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>

		<div class="row collapse">
			<div class="small-18 columns">
				<label>Correo electrónico
					<input type="email" name="email_cupon" id="email_cupon" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="small-18 columns">
				<div class="alert radius callout" id="mensaje_cupon" style="display:none;">
					<div></div>
				</div>
			</div>
		</div>

		<div class="row collapse add-buttons">
			<div class="small-18 columns text-right">
				<button type="submit" class="primary expanded button" id="cupon_boton">¡Quiero mi cupón!</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>

</div>
