<div class="modal fade" id="mask-login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLabel">Iniciar sesión</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">

                <form id="login_form" data-abide="ajax" novalidate>
                    <div class="row">
                        <div class="col-md-12 txt-center">
                            <a class="expanded button btnlog radius fbbut fbloginbutton"><i class="fa fa-facebook-square"></i> Inicia sesión con Facebook</a>
                        </div>
                        <div class="col-md-12 txt-center">
                            <h5 class="form-title">o inicia sesión con correo electrónico</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Correo electrónico</label>
                                <input type="email" class="form-control" name="email_cliente" id="email_cliente_login" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" class="form-control" name="password_cliente" id="password_cliente_login" required pattern="^.{6,}$">

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="alert radius callout" id="mensaje_inicio_sesion" style="display:none;">
                                <div></div>
                            </div>
                        </div>

                        <div class="col-md-6 txt-center">
                            <button type="button" id="register" class="btn btn-primary" data-toggle="modal" data-target="#registrarse">
                                REGISTRARME
                            </button>

                        </div>
                        <div class="col-md-6 txt-center">
                            <input type="submit" class="primary button" id="login_button" value="INICIAR SESIÓN">
                        </div>

                        <div class="col-md-12 txt-center ">
                            <a  id="forgot" data-toggle="modal" data-target="#olvidecontraseña"  class="alink olvidecontra">Olvidé mi contraseña.</a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>




<!--<div id="mask-login">
    <div class="popup-contacto">
        <div class="cont-contacto">
            <div id="close-login"></div>
            <h1>Iniciar sesión</h1>
            <div class="separador1"></div>
            <form id="login_form" data-abide="ajax" novalidate>
                <div class="row">
                    <div class="col-md-12 txt-center">
                        <a class="expanded button btnlog radius fbbut fbloginbutton"><i class="fa fa-facebook-square"></i> Inicia sesión con Facebook</a>
                    </div>
                    <div class="col-md-12 txt-center">
                        <h5 class="form-title">o inicia sesión con correo electrónico</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Correo electrónico</label>
                            <input type="email" class="form-control" name="email_cliente" id="email_cliente_login" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" class="form-control" name="password_cliente" id="password_cliente_login" required pattern="^.{6,}$">

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="alert radius callout" id="mensaje_inicio_sesion" style="display:none;">
                            <div></div>
                        </div>
                    </div>

                    <div class="col-md-6 txt-center">
                        <button type="button" id="register" class="btn btn-primary" data-toggle="modal" data-target="#registrarse">
                            REGISTRARME
                        </button>

                    </div>
                    <div class="col-md-6 txt-center">
                        <input type="submit" class="primary button" id="login_button" value="INICIAR SESIÓN">
                    </div>

                    <div class="col-md-12 txt-center ">
                        <a  class="alink olvidecontra">Olvidé mi contraseña.</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>-->
<!--<div class="small reveal" id="login" data-reveal>
	<form id="login_form" data-abide="ajax" novalidate>
		<div class="row fbb">
			<div class="small-18 columns text-center">
				<a class="expanded button btnlog radius fbbut fbloginbutton"><i class="fa fa-facebook-square"></i> Inicia sesión con Facebook</a>
			</div>
		</div>
		
		<div class="row">
			<div class="small-18 columns">
				<h5 class="form-title">o inicia sesión con correo electrónico</h5>
			</div>
		</div>
	
		<div class="row">
			<div class="small-18 columns">
				<label>Correo electrónico
					<input type="email" name="email_cliente" id="email_cliente_login" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>
		
		<div class="row">
			<div class="small-18 columns">
				<label>Contraseña
					<input type="password" name="password_cliente" id="password_cliente_login" required pattern="^.{6,}$">
					<span class="form-error">Campo requerido, mínimo 6 caracteres.</span>
				</label>
			</div>
		</div>
		
		<div class="row">
			<div class="small-18 columns">
				<div class="alert radius callout" id="mensaje_inicio_sesion" style="display:none;">
					<div></div>
				</div>
			</div>
		</div>
		
		<div class="row collapse add-buttons">
			<div class="small-9 columns">
				<a data-open="register" class="secondary button">Registrarme</a>
			</div>
			<div class="small-9 columns text-right">
				<button type="submit" class="primary button" id="login_button">Iniciar sesión</button>
			</div>
		</div>
		
		<div class="row collapse add-buttons olvide">
			<div class="small-18 columns text-center">
				<a data-open="forgot" class="olvidecontra">Olvidé mi contraseña.</a>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>

</div>-->