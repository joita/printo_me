<div class="contenedor-filtros" data-equalizer-watch>
	<span class="titulo-filtros" style="text-align: left; color: #FF4D00; border: none; border-bottom: 2px solid #025573">Refinar búsqueda</span>

	<h5 class="filtrador" style="text-align: left; color: #FF4D00; border: none ; border-bottom: 2px solid #025573">Filtrar por tipo</h5>
	<ul class="vertical menu ff">
		<li<?php activar($tipo_activo, null); ?>><a href="<?php echo site_url('compra'); ?><?php //echo generar_url_filtro($filtros); ?>"><i class="fa fa-list"></i> Todos</a></li>
		<li<?php activar($tipo_activo, 'limitado'); ?>><a href="<?php echo site_url('compra/plazo-definido'); ?><?php echo generar_url_filtro($filtros); ?>"><i class="fa fa-clock-o"></i> Plazo definido</a></li>
		<li<?php activar($tipo_activo, 'fijo'); ?>><a href="<?php echo site_url('compra/venta-inmediata'); ?><?php echo generar_url_filtro($filtros); ?>"><i class="fa fa-tint"></i> Venta</a></li>
        <!--<li<?php// activar($tipo_activo, 'envio-inmediato'); ?>><a href="<?php// echo site_url('compra/envio-inmediato'); ?><?php //echo generar_url_filtro($filtros); ?>"><i class="fa fa-tint"></i> Envio Inmediato</a></li>-->
	</ul>

	<h5 class="filtrador" style="text-align: left; color: #FF4D00; border: none; border-bottom: 2px solid #025573">Filtrar por categoría</h5>
	<div class="row">
		<div class="small-18 columns">
            <select style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center; color: #FF5004" class="cat-change">
                <option<?php if(isset($filtros['idClasificacion'])) { if($filtros['idClasificacion'] == '*') { echo ' selected'; } } else { echo ' selected'; } ?> value="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?>">Todas las categorías</option>
            <?php foreach($clasificaciones as $clasificacion): ?>
                <!--SubClasificaciones-->
                <?php if(sizeof($clasificacion->subclasificaciones) > 0): ?>
                    <?php if(($clasificacion->productos + $clasificacion->subproductos) > 0): ?>
                        <optgroup label="<?php echo $clasificacion->nombre_clasificacion; ?>">
                            <option<?php if(isset($filtros['idClasificacion'])) { if($filtros['idClasificacion'] == $clasificacion->id_clasificacion) { echo ' selected'; } } ?> value="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro($filtros, array('idClasificacion:'.$clasificacion->id_clasificacion, 'idSubclasificacion:*')); ?>"><?php echo $clasificacion->nombre_clasificacion; ?> » Todas</option>
                            <?php foreach($clasificacion->subclasificaciones as $subclasificacion): ?>
                                <?php if($subclasificacion->productos > 0): ?>
                                    <option<?php if(isset($filtros['idSubclasificacion'])) { if($filtros['idSubclasificacion'] == $subclasificacion->id_clasificacion) { echo ' selected'; } } ?> value="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro($filtros, array('idClasificacion:'.$clasificacion->id_clasificacion, 'idSubclasificacion:'.$subclasificacion->id_clasificacion, 'idSubsubclasificacion:*')); ?>"><?php echo $clasificacion->nombre_clasificacion; ?> » <?php echo $subclasificacion->nombre_clasificacion; ?></option>
                                    <!--SubSubClasificaciones-->
                                    <?php if(sizeof($subclasificacion->subsubclasificaciones) > 0): ?>
                                        <?php if(($subclasificacion->productos + $subclasificacion->subproductos) > 0): ?>
                                            <?php foreach($subclasificacion->subsubclasificaciones as $subsubclasificacion): ?>
                                                <?php if($subsubclasificacion->productos > 0): ?>
                                                    <option<?php if(isset($filtros['idSubsubclasificacion'])) { if($filtros['idSubsubclasificacion'] == $subsubclasificacion->id_clasificacion) { echo ' selected'; } } ?> value="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro($filtros, array('idClasificacion:'.$clasificacion->id_clasificacion, 'idSubclasificacion:'.$subclasificacion->id_clasificacion, 'idSubsubclasificacion:'.$subsubclasificacion->id_clasificacion)); ?>"><?php echo $clasificacion->nombre_clasificacion; ?> » <?php echo $subclasificacion->nombre_clasificacion ; ?> » <?php echo $subsubclasificacion->nombre_clasificacion ; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <!--End SubSubClasificaciones-->
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endif; ?>
                <?php else: ?>
                    <option<?php if(isset($filtros['idClasificacion'])) { if($filtros['idClasificacion'] == $clasificacion->id_clasificacion) { echo ' selected'; } } ?> value="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro($filtros, array('idClasificacion:'.$clasificacion->id_clasificacion, 'idSubclasificacion:*')); ?>"><?php echo $clasificacion->nombre_clasificacion; ?></option>
                <?php endif; ?>
                <!--End SubClasificaciones-->
            <?php endforeach; ?>
            </select>
		</div>
	</div>

	<h5 class="filtrador" style="text-align: left; color: #FF4D00; border: none; border-bottom: 2px solid #025573">Filtrar por género</h5>
	<div class="row">
		<div class="small-18 columns">
			<select style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center; color: #FF5004" class="gen-change">
				<option value="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro($filtros, 'genero:*'); ?>">Todos</option>
				<?php foreach($this->generos as $indice_genero => $genero): ?>
				<option value="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro($filtros, 'genero:'.$indice_genero); ?>"<?php if(isset($filtros['genero'])) { if($filtros['genero'] == $indice_genero) { echo ' selected'; } } ?>><?php echo $genero; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<h5 class="filtrador campanas" style="text-align: left; color: #FF4D00; border: none; border-bottom: 2px solid #025573">Ordenar por precio</h5>
	<ul class="vertical menu ff">
		<li<?php if(isset($filtros['ordenarPrecio'])) { activar($filtros['ordenarPrecio'], 'desc'); } ?>><a href="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro($filtros, 'ordenarPrecio:desc'); ?>"><i class="fa fa-sort-amount-desc downer"></i> De mayor a menor precio</a> <a href="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro_excluyente($filtros, 'ordenarPrecio:desc'); ?>" class="quitar" title="Quitar filtro"><i class="fa fa-times"></i></a></li>
		<li<?php if(isset($filtros['ordenarPrecio'])) { activar($filtros['ordenarPrecio'], 'asc'); } ?>><a href="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro($filtros, 'ordenarPrecio:asc'); ?>"><i class="fa fa-sort-amount-asc upper"></i> De menor a mayor precio</a> <a href="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro_excluyente($filtros, 'ordenarPrecio:asc'); ?>" class="quitar" title="Quitar filtro"><i class="fa fa-times"></i></a></li>
	</ul>

	<?php if($tipo_activo == 'limitado'): ?>
	<h5 class="filtrador campanas" style="text-align: left; color: #FF4D00; border: none; border-bottom: 2px solid #025573">Ordenar por tiempo</h5>
	<ul class="vertical menu ff">
		<li<?php if(isset($filtros['ordenarTiempo'])) { activar($filtros['ordenarTiempo'], 'desc'); } ?>><a href="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro($filtros, 'ordenarTiempo:desc'); ?>"><i class="fa fa-sort-numeric-asc downer"></i> Poco tiempo restante</a> <a href="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro_excluyente($filtros, 'ordenarTiempo:desc'); ?>" class="quitar" title="Quitar filtro"><i class="fa fa-times"></i></a></li>
		<li<?php if(isset($filtros['ordenarTiempo'])) { activar($filtros['ordenarTiempo'], 'asc'); } ?>><a href="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro($filtros, 'ordenarTiempo:asc'); ?>"><i class="fa fa-sort-numeric-desc upper"></i> Mucho tiempo restante</a> <a href="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro_excluyente($filtros, 'ordenarTiempo:asc'); ?>" class="quitar" title="Quitar filtro"><i class="fa fa-times"></i></a></li>
	</ul>
	<?php endif; ?>

	<h5 class="filtrador campanas" style="text-align: left; color: #FF4D00; border: none; border-bottom: 2px solid #025573">Ordenar por popularidad</h5>
	<ul class="vertical menu ff">
		<li<?php if(isset($filtros['ordenarPopularidad'])) { activar($filtros['ordenarPopularidad'], 'desc'); } ?>><a href="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro($filtros, 'ordenarPopularidad:desc'); ?>"><i class="fa fa-star downer"></i> Lo más vendido</a> <a href="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro_excluyente($filtros, 'ordenarPopularidad:desc'); ?>" class="quitar" title="Quitar filtro"><i class="fa fa-times"></i></a></li>
		<li<?php if(isset($filtros['ordenarPopularidad'])) { activar($filtros['ordenarPopularidad'], 'asc'); } ?>><a href="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro($filtros, 'ordenarPopularidad:asc'); ?>"><i class="fa fa-star-half-o upper"></i> Lo menos vendido</a> <a href="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?><?php echo generar_url_filtro_excluyente($filtros, 'ordenarPopularidad:asc'); ?>" class="quitar" title="Quitar filtro"><i class="fa fa-times"></i></a></li>
	</ul>

	<?php if(sizeof($filtros) > 0): ?>
	<a class="eliminar-filtros button" href="<?php echo site_url('compra'.($tipo_activo ? ($tipo_activo == 'limitado' ? '/plazo-definido' : '/venta-inmediata') : '')); ?>"><i class="fa fa-times"></i> Quitar filtros</a>
	<?php endif; ?>
</div>
