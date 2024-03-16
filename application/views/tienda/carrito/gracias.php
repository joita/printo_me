	<div class="row ptop">
	<div class="small-24 columns">
		<div class="text-center error-icon"><i class="fa fa-check-square-o" style="color:#44d705;font-size:9rem;margin-bottom:-2rem;"></i></div>
		<h3 class="text-center azul" style="line-height: 2;padding: 2rem 0 0;">¡Gracias por tu pedido!</h3>
		
    <?php if (!is_null($barcode)) : ?>
		<p class="text-center" style="margin-bottom:1rem;">Te debe de llegar un correo con la ficha de pago. De la misma manera puedes descargarlo de aqui e imprimirlo, o en su caso imprimir esta página y llevarla al OXXO más cercano.</p>
		<p class="text-center" style="margin-bottom:1rem;"><img src="<?php echo str_replace('http:', 'https:', $barcode); ?>" alt="Código de barras" />
		<p class="text-center" style="margin-bottom:2rem;"><a href="<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/pdf_oxxo/'.$pedido_id); ?>" id="descargar_pdf_oxxo" class="button radius" target="_blank"><i class="fa fa-file-pdf-o"></i> Descargar Ficha de Pago</a></p>
    <?php else: ?>
		<p class="text-center" style="margin-bottom:15rem;">Nuestro personal revisará la información y si todo está en orden empezará a procesar tu orden.</p>
    <?php endif; ?>
	</div>
</div>