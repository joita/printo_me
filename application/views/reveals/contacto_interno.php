<div class="small reveal" id="contacto_interno" data-reveal>
	<form id="contact_form_interno" data-abide="ajax" novalidate>
	
		<?php if(isset($this->session->login['email'])): ?>
		<p>Hola <?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>, ¿qué color necesitas?</p>
		<input type="hidden" name="email_contacto" id="email_contacto_interno" value="<?php echo $this->session->login['email']; ?>" />
		<input type="hidden" name="nombre_contacto" id="nombre_contacto_interno" value="<?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>" />
		<input type="hidden" name="telefono_contacto" id="telefono_contacto_interno" value="<?php echo (isset($this->session->login['telefono']) ? $this->session->login['telefono'] : ''); ?>" />
		
		<?php else: ?>
		<div class="row collapse">
			<div class="small-18 columns">
				<label>Nombre
					<input type="text" name="nombre_contacto" id="nombre_contacto_interno" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>
	
		<div class="row collapse">
			<div class="small-18 columns">
				<label>Correo electrónico
					<input type="email" name="email_contacto" id="email_contacto_interno" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>
							
		<div class="row collapse">
			<div class="small-18 columns">
				<label>Teléfono
					<input type="text" name="telefono_contacto" id="telefono_contacto_interno" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>
		<?php endif; ?>
		
		<div class="row collapse">
			<div class="small-18 columns">
				<label>Mensaje
					<textarea name="mensaje_contacto" id="mensaje_contacto_interno" placeholder="<?php echo $placeholder; ?>" required></textarea>
				</label>
			</div>
		</div>
		
		<div class="row">
			<div class="small-18 columns">
				<div class="alert radius callout" id="mensaje_contacto_generico_interno" style="display:none;">
					<div></div>
				</div>
			</div>
		</div>
		
		<div class="row collapse add-buttons">
			<div class="small-9 columns">
				<a data-close class="secondary button">Cancelar</a>
			</div>
			<div class="small-9 columns text-right">
				<input type="hidden" name="asunto_contacto" id="asunto_contacto_interno" value="<?php echo $asunto; ?>" />
				<input type="hidden" name="lugar_contacto" id="lugar_contacto_interno" value="<?php echo $lugar; ?>" />
				<input type="hidden" name="template_contacto" id="template_contacto_interno" value="contacto_generico" />
				<button type="submit" class="primary button" id="contacto_button_interno">Enviar</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>

</div>