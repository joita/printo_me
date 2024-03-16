<div class="contenedor-filtros" data-equalizer-watch>
	<span class="titulo-filtros">Refinar búsqueda</span>

	<h5 class="filtrador">Filtrar por tipo</h5>
	<ul class="vertical menu ff">
		<li<?php activar($tipo_activo, null); ?>><a href="<?php echo site_url('tienda/'.$nombre_tienda_slug); ?><?php echo generar_url_filtro($filtros); ?>"><i class="fa fa-list"></i> Todos</a></li>
		<li<?php activar($tipo_activo, 'limitado'); ?>><a href="<?php echo site_url('tienda/'.$nombre_tienda_slug.'/plazo-definido'); ?><?php echo generar_url_filtro($filtros); ?>"><i class="fa fa-clock-o"></i> Plazo definido</a></li>
		<li<?php activar($tipo_activo, 'fijo'); ?>><a href="<?php echo site_url('tienda/'.$nombre_tienda_slug.'/venta-inmediata'); ?><?php echo generar_url_filtro($filtros); ?>"><i class="fa fa-tint"></i> Venta inmediata</a></li>
	</ul>

	<h5 class="filtrador">Filtrar por categoría</h5>
	<div class="row">
		<div class="small-18 columns">
			<select class="nicesel" id="clasif_sel">
				<option value="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'idClasificacion:*'); ?>"><i class="fa fa-tags"></i> Todos</option>
				<?php foreach($clasificaciones as $clasificacion): ?>
				<?php if($clasificacion->productos > 0): ?>
				<option value="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'idClasificacion:'.$clasificacion->id_clasificacion); ?>"<?php if(isset($filtros['idClasificacion'])) { if($filtros['idClasificacion'] == $clasificacion->id_clasificacion) { echo ' selected'; } } ?>><?php echo $clasificacion->nombre_clasificacion; ?></option>
				<?php endif; ?>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<h5 class="filtrador">Filtrar por género</h5>
	<div class="row">
		<div class="small-18 columns">
			<select class="nicesel" id="genero_sel">
				<option value="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'genero:*'); ?>">Todos</option>
				<?php foreach($this->generos as $indice_genero => $genero): ?>
				<option value="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'genero:'.$indice_genero); ?>"<?php if(isset($filtros['genero'])) { if($filtros['genero'] == $indice_genero) { echo ' selected'; } } ?>><?php echo $genero; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<h5 class="filtrador campanas">Ordenar por precio</h5>
	<ul class="vertical menu ff">
		<li<?php if(isset($filtros['ordenarPrecio'])) { activar($filtros['ordenarPrecio'], 'desc'); } ?>><a href="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'ordenarPrecio:desc'); ?>"><i class="fa fa-sort-amount-desc downer"></i> De mayor a menor precio</a> <a href="<?php echo current_url(); ?><?php echo generar_url_filtro_excluyente($filtros, 'ordenarPrecio:desc'); ?>" class="quitar" title="Quitar filtro"><i class="fa fa-times"></i></a></li>
		<li<?php if(isset($filtros['ordenarPrecio'])) { activar($filtros['ordenarPrecio'], 'asc'); } ?>><a href="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'ordenarPrecio:asc'); ?>"><i class="fa fa-sort-amount-asc upper"></i> De menor a mayor precio</a> <a href="<?php echo current_url(); ?><?php echo generar_url_filtro_excluyente($filtros, 'ordenarPrecio:asc'); ?>" class="quitar" title="Quitar filtro"><i class="fa fa-times"></i></a></li>
	</ul>

	<?php if($tipo_activo == 'limitado'): ?>
	<h5 class="filtrador campanas">Ordenar por tiempo</h5>
	<ul class="vertical menu ff">
		<li<?php if(isset($filtros['ordenarTiempo'])) { activar($filtros['ordenarTiempo'], 'desc'); } ?>><a href="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'ordenarTiempo:desc'); ?>"><i class="fa fa-sort-numeric-asc downer"></i> Poco tiempo restante</a> <a href="<?php echo current_url(); ?><?php echo generar_url_filtro_excluyente($filtros, 'ordenarTiempo:desc'); ?>" class="quitar" title="Quitar filtro"><i class="fa fa-times"></i></a></li>
		<li<?php if(isset($filtros['ordenarTiempo'])) { activar($filtros['ordenarTiempo'], 'asc'); } ?>><a href="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'ordenarTiempo:asc'); ?>"><i class="fa fa-sort-numeric-desc upper"></i> Mucho tiempo restante</a> <a href="<?php echo current_url(); ?><?php echo generar_url_filtro_excluyente($filtros, 'ordenarTiempo:asc'); ?>" class="quitar" title="Quitar filtro"><i class="fa fa-times"></i></a></li>
	</ul>
	<?php endif; ?>

	<h5 class="filtrador campanas">Ordenar por popularidad</h5>
	<ul class="vertical menu ff">
		<li<?php if(isset($filtros['ordenarPopularidad'])) { activar($filtros['ordenarPopularidad'], 'desc'); } ?>><a href="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'ordenarPopularidad:desc'); ?>"><i class="fa fa-star downer"></i> Lo más vendido</a> <a href="<?php echo current_url(); ?><?php echo generar_url_filtro_excluyente($filtros, 'ordenarPopularidad:desc'); ?>" class="quitar" title="Quitar filtro"><i class="fa fa-times"></i></a></li>
		<li<?php if(isset($filtros['ordenarPopularidad'])) { activar($filtros['ordenarPopularidad'], 'asc'); } ?>><a href="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'ordenarPopularidad:asc'); ?>"><i class="fa fa-star-half-o upper"></i> Lo menos vendido</a> <a href="<?php echo current_url(); ?><?php echo generar_url_filtro_excluyente($filtros, 'ordenarPopularidad:asc'); ?>" class="quitar" title="Quitar filtro"><i class="fa fa-times"></i></a></li>
	</ul>

	<?php if(sizeof($filtros) > 0): ?>
	<a class="eliminar-filtros button" href="<?php echo current_url(); ?>"><i class="fa fa-times"></i> Quitar filtros</a>
	<?php endif; ?>
</div>
