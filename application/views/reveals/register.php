<div class="modal fade" id="registrarse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="register_form" method="post" data-abide="ajax" novalidate>
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Registrarse</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12 txt-center">
                            <a class="expanded button btnlog radius fbbut fbloginbutton"><i class="fa fa-facebook-square"></i> Inicia sesión con Facebook</a>
                        </div>
                        <div class="col-md-12 txt-center">
                            <h5 class="form-title">o inicia sesión con correo electrónico</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nombre(s)</label>
                                <input type="text" name="nombre_nuevo" id="nombre_nuevo" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Apellido(s)</label>
                                <input type="text" name="apellido_nuevo" id="apellido_nuevo" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Correo electrónico</label>
                                <input type="email" name="email_nuevo" id="email_nuevo" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" name="telefono_nuevo" id="telefono_nuevo" required>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha de nacimiento</label>
                                <input  type="date" id="cumple" data-date-format="mm/dd/yyyy" required>

                                <!-- <input type="date" name="cumple_nuevo" id="cumple_nuevo" required>-->

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Genero</label>
                                <select name="genero_nuevo" id="genero_nuevo" required>
                                    <option value="">Selecciona tu genero</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                    <option value="X">Prefiero no decir</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" name="password_nuevo" id="password_nuevo" required pattern="^.{6,}$">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Repetir Contraseña</label>
                                <input type="password" name="repetir_password_nuevo" id="password_nuevo_repetir" data-equalto="password_nuevo" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert radius callout" id="mensaje_registro" style="display:none;">
                                <div></div>
                            </div>
                        </div>
                        <div class="col-md-12 txt-center margin-bottom">
                            <input type="submit" class="btn"  id="register_button" value="REGISTRARME">
                        </div>

                        <div class="col-md-6 txt-center ">
                            <a id="iniciar" class="alink secondary button">Iniciar sesión</a>
                        </div>

                        <div class="col-md-6  txt-center ">
                            <a  class="alink olvidecontra">Olvidé mi contraseña.</a>
                        </div>


                    </div>




                </div>
            </form>
        </div>
    </div>
</div>



<!--<div class="small reveal" id="register" data-reveal>
	<form id="register_form" method="post" data-abide="ajax" novalidate>

		<div class="row fbb">
			<div class="small-18 columns text-center">
				<a class="expanded button btnlog radius fbbut fbloginbutton"><i class="fa fa-facebook-square"></i> Inicia sesión con Facebook</a>
			</div>
		</div>

		<div class="row">
			<div class="small-18 columns">
				<h5 class="form-title">o regístrate con tu correo electrónico</h5>
			</div>
		</div>

		<div class="row">
			<div class="small-18 columns">
				<label>Nombre(s)
					<input type="text" name="nombre_nuevo" id="nombre_nuevo" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="small-18 columns">
				<label>Apellido(s)
					<input type="text" name="apellido_nuevo" id="apellido_nuevo" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="small-18 medium-11 columns">
				<label>Correo electrónico
					<input type="email" name="email_nuevo" id="email_nuevo" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
			<div class="small-18 medium-7 columns">
				<label>Teléfono
					<input type="text" name="telefono_nuevo" id="telefono_nuevo" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="small-18 medium-9 columns">
				<label>Fecha de nacimiento
					<input type="date" name="cumple_nuevo" id="cumple_nuevo" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
			<div class="small-18 medium-9 columns">
				<label>Genero
					<select name="genero_nuevo" id="genero_nuevo" required>
						<option value="">Selecciona tu genero</option>
						<option value="M">Masculino</option>
						<option value="F">Femenino</option>
						<option value="X">Prefiero no decir</option>
					</select>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="small-18 medium-9 columns">
				<label>Contraseña
					<input type="password" name="password_nuevo" id="password_nuevo" required pattern="^.{6,}$">
					<span class="form-error">Campo requerido <br />(mínimo 6 caracteres).</span>
				</label>
			</div>
			<div class="small-18 medium-9 columns">
				<label>Repetir Contraseña
					<input type="password" name="repetir_password_nuevo" id="password_nuevo_repetir" data-equalto="password_nuevo" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="small-18 columns">
				<div class="alert radius callout" id="mensaje_registro" style="display:none;">
					<div></div>
				</div>
			</div>
		</div>

		<div class="row collapse add-buttons">
			<div class="small-9 columns">
				<a data-open="login" class="secondary button">Iniciar sesión</a>
			</div>
			<div class="small-9 columns text-right">
				<button type="submit" class="primary button" id="register_button">Registrarme</button>
			</div>
		</div>

	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>

</div>
-->