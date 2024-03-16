<h2 class="seccionador show-for-medium text-left" style="color: #025573;font-weight: bold">Mis Favoritos</h2>
<br>
<div class="row">
	<div class="small-18 columns">
		<?php if(sizeof($favoritos) > 0): ?>
		<div class="row small-up-2 medium-up-2 large-up-3">
		<?php foreach($favoritos as $favorito): ?>
			<?php $this->load->view('campanas/thumb_producto', array('producto' => $favorito)); ?>
		<?php endforeach; ?>
		</div>
		<?php else: ?>
		<div class="form-cuenta text-center">
			<p>Tu lista de favoritos está vacía.</p>
		</div>
		<?php endif; ?>
	</div>
</div>