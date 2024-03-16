<h1 class="azul text-center divisor">Nuestras instalaciones</h1>

<div class="row" id="instalaciones">
	<div class="small-18 columns">
		<div id="gallery" style="display:none;">
		<?php for($i=1;$i<31;$i++): ?>
			<img alt="Instalaciones de printome.mx" src="<?php echo site_url('assets/images/galeria/thumb/'.$i.'.jpg'); ?>" data-image="<?php echo site_url('assets/images/galeria/big/'.$i.'.jpg'); ?>" data-description="Instalaciones de printome.mx" />
		<?php endfor; ?>
		</div>
	</div>
</div>