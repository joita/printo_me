<div class="small reveal" id="contacto_ac" data-reveal>
	<form id="contact_form_ac" data-abide="ajax" novalidate>
	
		<div class="row collapse">
			<div class="small-18 columns">
				<label>Nombre del representante
					<input type="text" name="nombre_contacto" id="nombre_contacto_ac" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>
	
		<div class="row collapse">
			<div class="small-18 columns">
				<label>Nombre de la asociación civil
					<input type="text" name="nombre_ac" id="nombre_ac" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>
	
		<div class="row collapse">
			<div class="small-18 columns">
				<label>Correo electrónico
					<input type="email" name="email_contacto" id="email_contacto_ac" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>
	
		<div class="row collapse">
			<div class="small-18 columns">
				<label>Teléfono de contacto
					<input type="text" name="telefono_contacto" id="telefono_contacto_ac" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>
		
		<div class="row collapse">
			<div class="small-18 columns">
				<label>Mensaje
					<textarea name="mensaje_contacto" id="mensaje_contacto_ac" placeholder="" required></textarea>
				</label>
			</div>
		</div>
		
		<div class="row">
			<div class="small-18 columns">
				<div class="alert radius callout" id="mensaje_contacto_generico_ac" style="display:none;">
					<div></div>
				</div>
			</div>
		</div>
		
		<div class="row collapse add-buttons">
			<div class="small-9 columns">
				<a data-close class="secondary button">Cancelar</a>
			</div>
			<div class="small-9 columns text-right">
				<button type="submit" class="primary button" id="contacto_button_ac">Enviar</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>

</div>