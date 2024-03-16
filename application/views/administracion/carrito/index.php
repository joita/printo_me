<div class="row">
    <div class="small-24 columns">
        <h2 class="section-title">Transferir Carrito de Compras</h2>
    </div>
</div>
<div class="row">
    <div class="small-24 columns">
        <ul class="tab-menu">
            <li><a class="active"><i class="fa fa-shopping-cart"></i> Transferir Carrito</a></li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="small-24 columns">
        <div id="main-container">
            <div class="row">
                <div class="columns small-12 small-push-6">
                    <form id="form_transferir">
                        <label class="transferir-label" for="cuenta_a">Cuenta emisora de carrito:</label>
                        <input class="transferir-text" type="email" name="cuenta_a" id="cuenta_a" placeholder="correo@printome.mx" required>
                        <label class="transferir-label" for="cuenta_b">Cuenta receptora de carrito:</label>
                        <input class="transferir-text" type="email" name="cuenta_b" id="cuenta_b" placeholder="correo@correo.com" required>
                        <input type="hidden" name="cuenta_a_tipo" id="cuenta_a_tipo" value=""/>
                        <input type="hidden" name="cuenta_b_tipo" id="cuenta_b_tipo" value=""/>
                        <div id="informacion" class="alert-box radius success text-center" style="opacity: 0.5; display: none">
                            <!--Despliegue de mensaje de error o exito-->
                        </div>
                        <div class="text-center">
                            <button type="submit" id="submit">Transferir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>