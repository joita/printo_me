<h4 class="seccionador">Restablecer Contraseña</h4>

<div class="row">
	<div class="small-18 medium-16 large-10 xlarge-7 medium-centered columns">
		<div class="row">
			<div class="small-18 columns">
				<?php if($this->session->flashdata('update_datos') == 'ok'): ?>
				<div class="small success callout">
					<p><i class="fa fa-check"></i> Cambios guardados. ¡Por favor inicia sesión con tu nueva contraseña! <br />Redirigiendo automáticamente a inicio en 5 segundos.</p>
					<script>setTimeout(function() { window.location.href='<?php echo base_url(); ?>'; }, 5000);</script>
				</div>
				<?php else: ?>
				<form method="post" action="<?php echo site_url(uri_string().'/procesar'); ?>" class="form-cuenta" data-abide novalidate>
					<?php if($this->session->flashdata('error_datos') == 'datos'): ?>
					<div class="small alert callout">
						<p><i class="fa fa-times"></i> La información enviada no coincide con nuestros registros o ha ocurrido algún error al momento de procesar la información.</p>
					</div>
					<?php endif; ?>
					
					<div class="row">
						<div class="small-18 columns">
							<label>Contraseña nueva
								<input type="password" name="contrasena_nueva" id="contrasena_nueva" required pattern="^.{6,}$">
								<small class="form-error">Campo obligatorio, mínimo 6 caracteres.</small>
							</label>
						</div>
					</div>
					<div class="row">
						<div class="small-18 columns">
							<label>Repetir contraseña nueva
								<input type="password" name="repetir_contrasena_nueva" id="password_contrasena_nueva" data-equalto="contrasena_nueva" required>
								<small class="form-error">La contraseña tiene que ser igual.</small>
							</label>
						</div>
					</div>
					<div class="row botones-cuenta">
						<div class="small-24 columns text-center">
							<input type="hidden" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
							<button type="submit" class="guardar button"><i class="fa fa-refresh"></i> Restablecer contraseña</button>
						</div>
					</div>
				</form>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>