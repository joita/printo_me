<?php if($this->session->flashdata('error_direccion')): ?>
<div data-abide-error class="alert callout" id="error-direccion">
    <p><i class="fi-alert"></i> <?php echo $this->session->flashdata('error_direccion'); ?></p>
</div>
<?php endif; ?>
<div data-abide-error class="alert callout" id="error-paso" style="display: none;">
    <p><i class="fi-alert"></i> Hay errores en el formulario, por favor revisa la información.</p>
</div>
<div class="row sums-area-entry">
    <div class="small-9 columns" style="color:#025573;">
        No. de productos
    </div>
    <div class="small-9 text-right columns" style="color:#025573;">
        <?php echo $this->cart->total_items(); ?>
    </div>
</div>
<div class="row sums-area-entry">
    <div class="small-9 columns" style="color:#025573;">
        Subtotal
    </div>
    <div class="small-9 text-right columns" style="color:#025573;">
        $<?php echo $this->cart->format_number(($this->cart->obtener_subtotal())); ?>
    </div>
</div>
<?php if($this->cart->obtener_saldo_a_favor() > 0.00): ?>
<div class="row sums-area-entry">
    <div class="small-9 columns" style="color:#025573;">
        Saldo a favor
    </div>
    <div class="small-9 text-right columns" >
        <span class="verde">-$<?php echo $this->cart->format_number($this->cart->obtener_saldo_a_favor()); ?></span>
    </div>
</div>
<?php endif; ?>
<?php if($this->cart->obtener_subtotal() > 0): ?>
<div class="row sums-area-entry cupon-area" data-equalizer>
    <div class="small-6 columns cupon-area-first" data-equalizer-watch="cupon" style="color:#025573;">
        Cupón
    </div>
    <div class="small-12 text-right columns cupon-area-second">
        <div class="input-group" id="cupones" data-equalizer-watch="cupon">
            <script>console.log(<?php echo json_encode($this->session->descuento_global);?>)</script>
        <?php if(!$this->session->descuento_global): ?>
            <input style="border: solid 1px #025573 !important; border-radius: 10px!important; opacity: 100%; color: #FF4C00!important; background: white!important; " class="input-group-field" type="text" id="codigo-cupon" tabindex="1000" data-equalizer-watch="cupon" placeholder="Escribe aquí...">
            <div class="input-group-button">
                <button style="background: #FF4C00; color: white; border-radius: 10px" type="button" class="button secondary" id="validar-cupon" tabindex="1001" data-equalizer-watch="cupon"><i class="fa fa-plus-circle"></i></button>
            </div>
        <?php else: ?>
            <input class="input-group-field" type="text" id="codigo-cupon-activo" tabindex="1000" readonly value="<?php echo $this->session->descuento_global->cupon; ?>">
            <div class="input-group-button">
                <button style="background: #FF4C00; color: white; border-radius: 10px" type="button" class="button secondary" id="quitar-cupon" tabindex="1001"><i class="fa fa-times-circle"></i></button>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if($this->session->descuento_global && !$this->session->envio_gratis || $this->session->descuento_global && $this->cart->obtener_subtotal() > 999 || $this->session->envio_descuento ): ?>
<div class="row sums-area-entry">
    <div class="small-9 columns" style="color:#025573;">
        Descuento
    </div>
    <div class="small-9 text-right columns">
        <?php if($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1): ?>
        <strong class="verde">-<?php echo ($this->session->descuento_global->descuento * 100).'%'; ?></strong>
        <?php else: ?>
        <strong class="verde">-$<?php echo $this->cart->format_number($this->session->descuento_global->descuento); ?></strong>
        <?php endif; ?>
    </div>
</div>
<div class="row sums-area-entry">
    <div class="small-9 columns" style="color:#025573;">
        Con descuento
    </div>
    <div class="small-9 text-right columns">
        <?php if($this->cart->obtener_saldo_a_favor() == 0): ?>
            <?php if($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1): ?>
            <strong class="verde">$<?php echo $this->cart->format_number(($this->cart->obtener_subtotal() * (1-$this->session->descuento_global->descuento))); ?></strong>
            <?php else: ?>
            <strong class="verde">$<?php echo $this->cart->format_number(($this->cart->obtener_subtotal()-$this->session->descuento_global->descuento)); ?></strong>
            <?php endif; ?>
        <?php else: ?>
            <?php if($this->session->descuento_global->descuento > 0 && $this->session->descuento_global->descuento < 1): ?>
            <strong class="verde">$<?php echo $this->cart->format_number(($this->cart->obtener_subtotal() * (1-$this->session->descuento_global->descuento)) - $this->cart->obtener_saldo_a_favor()); ?></strong>
            <?php else: ?>
            <strong class="verde">$<?php echo $this->cart->format_number(($this->cart->obtener_subtotal()-$this->cart->obtener_saldo_a_favor()-$this->session->descuento_global->descuento)); ?></strong>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<div class="row sums-area-entry">
    <div class="small-9 columns" style="color:#025573;">
        Costo de envío
    </div>
    <div class="small-9 text-right columns" id="costo_envio" style="color:#025573;">
    <?php if($this->session->envio_gratis && isset($this->session->descuento_global) || $this->session->envio_gratis && $this->cart->obtener_subtotal() > 999 ):?>
            <strong class="verde">GRATIS</strong>
        <?php else:?>
            $<?php echo $this->cart->format_number($this->cart->obtener_costo_envio()); ?>
        <?php endif;?>
    </div>
</div>
<div class="row sums-area-entry">
    <div class="small-9 columns" style="color:#025573;">
        Total
    </div>
    <div class="small-9 text-right columns" id="costo_total" style="color:#FF4C00;">
        <strong>$<?php echo  $this->cart->format_number($this->cart->obtener_total()); ?></strong>
    </div>
</div>

