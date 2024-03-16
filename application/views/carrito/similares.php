<?php $productos_similares = $this->catalogo_modelo->obtener_productos_relacionados($ids_producto);  ?>
<?php if (!is_null($productos_similares)): ?>
<div class="row" id="productos_interesan">
	<div class="small-24 medium-24 large-23 large-centered columns">
		<h2 class="text-center rayas"><span><?php echo $titulo; ?></span></h2>
		<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4 xlarge-block-grid-5 text-center text-center" id="lista_interesan">

		<?php foreach($productos_similares as $producto): ?>
			<?php $this->load->view('catalogo/producto/thumb', $producto);  ?>
		<?php  endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>