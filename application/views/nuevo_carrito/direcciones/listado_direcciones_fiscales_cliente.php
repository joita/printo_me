<div class="row">
    <div class="small-18 columns">
        <h2 style="color: #FF4C00;font-weight: bold; border: none; border-bottom: 2px solid #025573;" class="text-center medium-text-left" data-equalizer-watch="titulo">Tus datos de facturación</h2>
        <select style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center; color:#FF4C00; font-weight: bold; background-color: white " name="id_direccion_fiscal" id="id_direccion_fiscal">
            <option value="">Seleccionar datos de facturación</option>
            <optgroup label="Mis datos de facturación">
            <?php foreach($direcciones_fiscales as $direccion): ?>
                <option value="<?php echo $direccion->id_direccion_fiscal; ?>" data-dircompleta='<?php echo json_encode($direccion, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>'><?php echo $direccion->razon_social; ?> (<?php echo $direccion->rfc; ?>)</option>
            <?php endforeach; ?>
            </optgroup>
            <optgroup label="Más opciones">
                <option id="agregar_dinamico" value="" data-open="nueva_direccion">+ Agregar datos de facturación</option>
            </optgroup>
        </select>

        <label class="clearfix direccion_pago" id="direccion_fiscal_seleccionada" data-dircompleta='' style="border:  2px solid #025573; border-radius: 10px">
            <span class="text-center">Por favor selecciona los datos de facturación para la factura.</span>
        </label>
    </div>
</div>
