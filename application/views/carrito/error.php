<div class="row ptop">
  <div class="small-24 columns">
    <h3 class="text-center azul" style="line-height: 2;padding: 2rem 0 0;">¡Oops!</h3>
    <p class="text-center" style="margin-bottom:1rem;">Hubo algún problema con el proceso de pago, por favor intenta nuevamente.</p>
	<?php if($this->session->flashdata('error_pago')): ?>
    <p class="text-center" style="margin-bottom:1rem;"><?php echo $this->session->flashdata('error_pago')->message_to_purchaser; ?></p>
	<?php endif; ?>
    <p class="text-center" style="margin-bottom:1rem;">No se ha realizado ningún cobro a tu cuenta.</small></p>
    <p class="text-center" style="margin-bottom:2rem;"><a href="<?php echo site_url('carrito/pagar'); ?>" id="descargar_pdf_oxxo" class="button radius">Ir a mi carrito y volver a intentar.</a></p>
  </div>
</div>
