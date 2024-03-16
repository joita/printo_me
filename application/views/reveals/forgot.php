<div class="modal fade" id="olvidecontraseña" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form id="forgot_form" data-abide="ajax" novalidate>
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Recuperar contraseña</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="form-title">¿Cuál es tu correo electrónico?</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Correo electrónico
                                <input type="email" name="email_cliente_forgot" id="email_cliente_forgot" required>
                                <span class="form-error">Campo requerido.</span>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert radius callout" id="mensaje_forgot" style="display:none;">
                                <div></div>
                            </div>
                        </div>
                    </div>

                    <div class="row add-buttons">
                        <div class="col-md-6">
                            <a id="iniciarforgot" class="alink btn secondary button">Iniciar sesión</a>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="primary btn button" id="forgot_button">Recuperar</button>
                        </div>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>

<!--<div class="small reveal" id="forgot" data-reveal>
	<form id="forgot_form" data-abide="ajax" novalidate>
		
		<div class="row">
			<div class="small-18 columns">
				<h5 class="form-title">¿Cuál es tu correo electrónico?</h5>
			</div>
		</div>
	
		<div class="row">
			<div class="small-18 columns">
				<label>Correo electrónico
					<input type="email" name="email_cliente_forgot" id="email_cliente_forgot" required>
					<span class="form-error">Campo requerido.</span>
				</label>
			</div>
		</div>
		
		<div class="row">
			<div class="small-18 columns">
				<div class="alert radius callout" id="mensaje_forgot" style="display:none;">
					<div></div>
				</div>
			</div>
		</div>
		
		<div class="row collapse add-buttons">
			<div class="small-9 columns">
				<a data-open="login" class="secondary button">Iniciar sesión</a>
			</div>
			<div class="small-9 columns text-right">
				<button type="submit" class="primary button" id="forgot_button">Recuperar</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>

</div>-->