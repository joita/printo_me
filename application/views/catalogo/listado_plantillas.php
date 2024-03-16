<?php if(sizeof($plantillas)): ?>
<div class="row small-up-1 medium-up-2 large-up-3 xlarge-up-3" id="contenedor-catalogo">
<?php foreach($plantillas as $plantilla) {
	$this->load->view('catalogo/thumb_plantilla', array('plantilla' => $plantilla));
} ?>
</div>
<?php else: ?>
<div class="row ptop">
	<div class="small-24 medium-23 medium-centered large-22 columns">
		<h3 class="text-center vacio">
			<div class="text-center error-icon"><i class="fa fa-times-circle-o"></i></div>
			No hay productos activos en esta categoría.
		</h3>
	</div>
</div>
<?php endif; ?>
