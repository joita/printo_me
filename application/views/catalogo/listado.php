<?php if(sizeof($productos) > 0): ?>
<div class="row small-up-1 medium-up-2 large-up-3 xlarge-up-3" id="contenedor-catalogo">
<?php foreach($productos as $producto): ?>
	<?php $this->load->view('catalogo/thumb_producto', array('producto' => $producto)); ?>
<?php endforeach; ?>
</div>
<?php else: ?>
<div class="row ptop">
	<div class="small-18 columns">
		<h3 class="text-center vacio">
			<div class="text-center error-icon"><i class="fa fa-times-circle-o"></i></div>
			No hay productos activos en esta categoría.
		</h3>
	</div>
</div>
<?php endif; ?>