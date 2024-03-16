<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Productos</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="tab-menu">
		<?php foreach($categorias as $categoria): ?>
			<li><a href="<?php echo site_url('administracion/productos/'.$categoria->nombre_categoria_slug); ?>"<?php activar($categoria_slug, $categoria->nombre_categoria_slug); ?>><?php echo $categoria->nombre_categoria; ?></a></li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="row">
	<div class="small-24 columns text-center">
		<p class="nohay">No existe esta categoría, por favor selecciona una categoría de las ya existentes.</p>
	</div>
</div>