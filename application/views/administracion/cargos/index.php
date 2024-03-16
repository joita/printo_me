<div class="row">
    <div class="small-24 columns">
        <h2 class="section-title">Cargos Extra</h2>
    </div>
</div>
<div class="row">
    <div class="small-24 columns">
        <ul class="tab-menu">
            <li><a class="active"><i class="fa fa-building-o"></i> Cargos Extrass</a></li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="small-24 columns">
        <div id="main-container">
            <div class="row" data-equalizer style="padding:0 1rem">
                <div class="small-24 end columns navholder" data-equalizer-watch>
                    <a href="#" data-reveal-id="nuevo_cargo" class="coollink"><i class="fa fa-plus"></i> Nuevo Cargo Extra</a>
                </div>
            </div>
            <div class="row">
                <div class="small-24 columns">
                    <table id="cargos_extra" class="hover stripe cell-border order-column">
                        <thead>
                        <tr>
                            <th>No. Cargo</th>
                            <th>No. Pedido</th>
                            <th>Datos Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Metodo de Pago</th>
                            <th>Estatus</th>
                            <th>Eliminar</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!--Generado por serverside Data Tables-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--formulario para crear un nuevo cargo_extra-->
<div class="reveal-modal small" id="nuevo_cargo" data-reveal>
    <form action="<?php echo site_url('administracion/cargos-extra/agregar-nuevo-cargo'); ?>" method="post" data-abide>
        <div class="row">
            <div class="small-24 columns">
                <label>E-Mail del Cliente
                    <input type="text" name="email_cliente" id="email_cliente" required/>
                </label>
            </div>
        </div>
        <div class="row" id="error_email" hidden >
            <div class="small-24 columns">
                <div class="alert-box alert radius" style="opacity: 0.65;">
                    El correo ingresado no se encuentra registrado.
                </div>
            </div>
        </div>
        <input type="hidden" name="id_cliente" id="id_cliente" value="">
        <div class="row">
            <div class="small-24 columns">
                <label>Nombre del Cliente
                    <input type="text" name="nombre_cliente" id="nombre_cliente" readonly required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Direccion Cliente
                    <select name="direccion_cliente" id="direccion_cliente" disabled required>
                        <option selected value disabled>-- Seleccionar --</option>
                        <!--Generado AJAX-->
                    </select>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>No. de pedido
                    <input type="text" name="num_pedido" id="num_pedido" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row" id="error_pedido" hidden >
            <div class="small-24 columns">
                <div class="alert-box alert radius" style="opacity: 0.65;">
                    El pedido viene de shopify y tiene un cargo extra activo, no puede agregar otro .
                </div>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Concepto
                    <input type="text" name="concepto" id="concepto" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Metodo de Pago
                    <select name="metodo_pago" id="metodo_pago" required>
                        <option selected value disabled>-- Seleccionar --</option>
                        <option value="cash_payment">OXXO</option>
                        <option value="card_payment">Tarjeta</option>
                        <option value="spei">SPEI</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Cantidad A Pagar
                    <input type="number" name="cantidad" id="cantidad" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns text-center">
                <button id="agrega_cargo" type="submit">Enviar</button>
            </div>
        </div>
    </form>
</div>