<div class="address-area">
    <div class="row">
        <div class="small-18 columns">
            <h2 style="color: #FF4C00;font-weight: bold; border: none; border-bottom: 2px solid #025573;" class="text-center medium-text-left" data-equalizer-watch="titulo">Tus datos de envío</h2>
        </div>
    </div>
    <div class="row">
        <div class="small-18 columns">
            <select style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center; color:#FF4C00; font-weight: bold; background-color: white " name="direccion[id_direccion]" id="id_direccion" required>
                <option value="">Seleccionar dirección de envío</option>
                <optgroup label="Mis Direcciones">
                <?php foreach($direcciones as $direccion): ?>
                    <option value="<?php echo $direccion->id_direccion; ?>" data-dircompleta='<?php echo json_encode($direccion, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>'><?php echo $direccion->identificador_direccion; ?> (<?php echo $direccion->linea1; ?>, <?php echo $direccion->linea2; ?>...)</option>
                <?php endforeach; ?>
                </optgroup>
                <optgroup label="Más opciones">
                    <option id="agregar_dinamico" value="" data-open="nueva_direccion">+ Agregar Dirección</option>
                </optgroup>
            </select>

            <label class="clearfix direccion_pago" id="direccion_envio_seleccionada" data-dircompleta='' style="border:  2px solid #025573; border-radius: 10px">
                <span class="text-center">Por favor selecciona una dirección de envío.</span>
            </label>
        </div>
    </div>

    <div class="row" id="factura-label-container">
        <div class="small-18 large-8 columns text-left">
            <div class="row collapse">
                <div class="small-5 columns">
                    <div class="switch">
                        <input class="switch-input" id="requiero_facturar" type="checkbox"<?php if($this->session->direccion_fiscal_temporal) { echo ' checked'; } ?> name="requiero_facturar">
                        <label class="switch-paddle" for="requiero_facturar">
                            <span class="show-for-sr">Requiero facturar</span>
                            <span class="switch-active" aria-hidden="true">Si</span>
                            <span class="switch-inactive" aria-hidden="true">No</span>
                        </label>
                    </div>
                </div>
                <div class="small-13 columns">
                    <label for="requiero_facturar" id="factura-label">
                        Requiero facturar
                    </label>
                </div>
            </div>
        </div>
    </div>

    <?php // para facturacion ?>
    <div id="hidden_fact"<?php if(!$this->session->direccion_fiscal_temporal) { echo ' style="display:none;"'; } ?>>
        <div class="row collapse">
            <div class="small-18 columns">
                <?php if(sizeof($direcciones_fiscales) > 0) {
                    $this->load->view('nuevo_carrito/direcciones/listado_direcciones_fiscales_cliente');
                } else {
                    $this->load->view('nuevo_carrito/direcciones/datos_fiscales_cliente');
                } ?>
            </div>
        </div>
    </div>
</div>
