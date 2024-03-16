<div class="ps fbc">
	<div class="row">
		<div class="small-18 medium-17 medium-centered xlarge-18 columns">
			<h2 class="text-center dosf">Los diseños más populares</h2>
            <div class="row small-up-1 medium-up-2 large-up-4 xlarge-up-4" id="contenedor-catalogo">
            <?php foreach($populares as $producto): ?>
                <?php $this->load->view('campanas/thumb_producto', array('producto' => $producto)); ?>
            <?php endforeach; ?>
            </div>
		</div>
	</div>
</div>
