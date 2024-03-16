<div class="row">
    <div class="small-24 columns">
        <h2 class="section-title">Eliminar cuentas de Usuarios</h2>
    </div>
</div>
<div class="row">
    <div class="small-24 columns">
        <ul class="tab-menu">
            <li><a class="active"><i class="fa fa-user"></i> Eliminar Usuario</a></li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="small-24 columns">
        <div id="main-container">
            <div class="row">
                <div class="columns small-12 small-push-6">
                    <form id="form_eliminar" style="margin-top: 1rem">
                        <label class="eliminar-label" for="cuenta_a">Correo de cuenta a eliminar:</label>
                        <input class="transferir-text" type="email" name="cuenta_a" id="cuenta_a" placeholder="correo@correo.com" required>
                        <input type="hidden" name="cuenta_a_tipo" id="cuenta_a_tipo" value="" required/>
                        <input type="hidden" name="id_cliente" id="id_cliente" value="" required/>
                        <div id="informacion" class="alert-box radius success text-center" style="opacity: 0.5; display: none">
                            <!--Despliegue de mensaje de error o exito-->
                        </div>
                        <div id="confirmacion_eliminar" style="display: none;">
                            <div class="row collapse text-center" style="margin-bottom: 1rem;">
                                <input id="check_confirmacion" type="checkbox" required style="margin: 0"/>
                                <label for="check_confirmacion" id="label_conf"></label>
                            </div>
                            <div class=" row text-center">
                                <button class="alert" type="submit" id="submit">Eliminar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
