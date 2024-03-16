<h2 class="seccionador show-for-medium text-left" style="color: #025573;font-weight: bold">Cambiar Contraseña</h2>
<br>
<div class="row">
	<div class="small-18 medium-18 large-11 xlarge-8 columns">
		<div class="row">
			<div class="small-18 columns text-center">
				<form method="post" action="<?php echo site_url('mi-cuenta/cambiar-contrasena/procesar'); ?>" class="form-cuenta" data-abide novalidate style="border: none">
					
					<?php if($this->session->flashdata('update_datos') == 'ok'): ?>
					<div class="small success callout">
						<p><i class="fa fa-check"></i> Cambios guardados. ¡Recuerda usar tu nueva contraseña la próxima vez que inicies sesión!</p>
					</div>
					<?php endif; ?>
					
					<?php if($this->session->flashdata('error_datos') == 'datos'): ?>
					<div class="small alert callout">
						<p><i class="fa fa-times"></i> La información enviada no coincide con nuestros registros o ha ocurrido algún error al momento de procesar la información.</p>
					</div>
					<?php endif; ?>
				
					<div class="row">
						<div class="small-18 columns">
							<label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Contraseña actual
								<input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="password" name="contrasena_actual" id="contrasena_actual" required pattern="^.{6,}$">
								<small class="form-error">Campo obligatorio, mínimo 6 caracteres.</small>
							</label>
						</div>
					</div>
					<hr class="dashed" style="border: 1px solid #025573"/>
					<div class="row">
						<div class="small-18 columns">
							<label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Contraseña nueva
								<input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="password" name="contrasena_nueva" id="contrasena_nueva" required pattern="^.{6,}$">
								<small class="form-error">Campo obligatorio, mínimo 6 caracteres.</small>
							</label>
						</div>
					</div>
					<div class="row">
						<div class="small-18 columns">
							<label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Repetir contraseña nueva
								<input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="password" name="repetir_contrasena_nueva" id="password_contrasena_nueva" data-equalto="contrasena_nueva" required>
								<small class="form-error">La contraseña tiene que ser igual.</small>
							</label>
						</div>
					</div>
					<div class="row botones-cuenta">
						<div class="small-24 columns text-center">
							<input type="hidden" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
							<button style="background: #F2560D; padding: 1rem 2rem; border-radius: 10px " type="submit" class="guardar button"><i class="fa fa-save"></i> Cambiar contraseña</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>