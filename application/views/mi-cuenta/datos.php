<h2 class="seccionador show-for-medium text-left" style="color: #025573;font-weight: bold">Mis Datos</h2>

<div class="row">
    <div class="col-md-12 ">
				<form id="form_cuenta_datos" class="form-cuenta" data-abide style="border: none; background: white">

					<?php if($this->session->flashdata('update_datos') == 'ok'): ?>
					<div class="small success callout">
						<p><i class="fa fa-check"></i> Cambios guardados</p>
					</div>
					<?php endif; ?>

					<div class="row text-center">
						<div class="col-md-6 col-xs-12">
							<label style="color: #FF4D00; font-weight: bold;">Nombre(s)
								<input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" id="nombres_cuenta" type="text" name="nombres" value="<?php echo $info->nombres; ?>" required>
								<small class="form-error">Campo obligatorio.</small>
							</label>
						</div>
                        <div class="col-md-6 col-xs-12">
                            <label style="color: #FF4D00; font-weight: bold;">Apellido(s)
                                <input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" id="apellidos_cuenta" type="text" name="apellidos" value="<?php echo $info->apellidos; ?>" required>
                                <small class="form-error">Campo obligatorio.</small>
                            </label>
                        </div>
					</div>
					<div class="row text-center">
						<div class="col-xs-12 col-md-6">
							<label style="color: #FF4D00; font-weight: bold;">Fecha de nacimiento
								<input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo $info->fecha_nacimiento; ?>" required>
								<small class="form-error">Campo obligatorio.</small>
							</label>
						</div>
						<div class="col-xs-12 col-md-6">
							<label style="color: #FF4D00; font-weight: bold;">Genero
								<select style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" name="genero" id="genero" required>
									<option style="text-align: center" value=""></option>
									<option style="text-align: center" value="M"<?php if($info->genero == 'M') { echo ' selected'; } ?>>Masculino</option>
									<option style="text-align: center" value="F"<?php if($info->genero == 'F') { echo ' selected'; } ?>>Femenino</option>
									<option style="text-align: center" value="X"<?php if($info->genero == 'X') { echo ' selected'; } ?>>Prefiero no decir</option>
								</select>
								<small class="form-error">Campo obligatorio.</small>
							</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-xs-12 ">
							<label id="tel_label_cuenta" style="color: #FF4D00; text-align: center;font-weight: bold;">Teléfono
								<input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; width: 100%" type="tel" name="telefono" id="telefono_cuenta" value="<?php echo $info->telefono; ?>" minlength="10" maxlength="12" required>
								<small style="margin-top: 0;" id="tel_cuenta_error" class="form-error">Campo obligatorio.</small>
							</label>
						</div>
                        <div class="col-md-6 col-xs-12 botones-cuenta">
                            <input id="id_cliente_cuenta" type="hidden" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
                            <button style="background: #F2560D; padding: 1rem 2rem; border-radius: 10px " type="submit" class="btn guardar button">Guardar Cambios</button>
                        </div>
					</div>
				</form>
			</div>
</div>
<div class="row">
    <div class="col-md-12 codigo-referencia">
        <form method="post" action="<?php echo site_url('mi-cuenta/cambiar_codigo_referencia'); ?>" class="form-cuenta" data-abide style="border:none">
            <?php if($this->session->flashdata('update_referencia') == 'success'): ?>
                <div class="small success callout">
                    <p><i class="fa fa-check"></i> Cambios guardados</p>
                </div>
            <?php elseif($this->session->flashdata('update_referencia') == 'existe'): ?>
                <div class="small warning callout">
                    <p><i class="fa fa-check"></i> El código ya se encuentra registrado en el sistema</p>
                </div>
            <?php endif;?>
            <div class="row ">
                <div class="col-md-6 col-xs-12 text-center">
                    <label style="color: #FF4D00; font-weight: bold;">Código de referencia
                        <input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" value="<?php echo $info->cupon?>" name="nuevo_cupon" required/>
                        <small class="form-error">Campo obligatorio.</small>
                    </label>
                </div>
                <div class="col-md-6 col-xs-12 text-center botones-cuenta">
                    <input type="hidden" value="<?php echo $info->cupon?>" name="viejo_cupon"/>
                    <input type="hidden" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
                    <button style="background: #F2560D; padding: 1rem 2rem; border-radius: 10px" type="submit" class="guardar btn button">Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>