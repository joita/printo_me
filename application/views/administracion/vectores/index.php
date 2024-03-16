<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Vectores</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<div class="row">
			<div class="small-7 columns">
				<fieldset id="datos_producto">
					<legend>Categorías</legend>
					<a href="#" data-reveal-id="nueva_categoria" class="fieldadd button">Agregar</a>
					<div class="row collapse">
						<div class="small-24 columns">
						<?php if(sizeof($categorias_vectores) > 0): ?>
							<ul class="side-nav inner-menu">
							<?php foreach($categorias_vectores as $categoria): ?>
								<li><a href="<?php echo site_url('administracion/vectores/'.$categoria->nombre_categoria_vector_slug); ?>"<?php if(isset($categoria_activa)) { activar($categoria_activa->nombre_categoria_vector_slug, $categoria->nombre_categoria_vector_slug); } ?>><?php echo $categoria->nombre_categoria_vector; ?></a></li>
							<?php endforeach; ?>
							</ul>
						<?php else: ?>
							<p>No hay categorías.</p>
						<?php endif; ?>
						</div>
					</div>
				</fieldset>
			</div>
			<div class="small-17 columns">
				<fieldset id="datos_adicionales">
					<legend>Vectores</legend>
					<a href="#" data-reveal-id="agregar_vectores" class="fieldadd button">Agregar</a>
					<ul class="small-block-grid-7" id="vecs">
					<?php foreach($vectores as $vector): ?>
						<li>
							<div>
								<img src="<?php echo site_url('media/cliparts/'.$categoria_activa->id_categoria_vector.'/thumbs/'.md5($vector->clipart_id).'.png'); ?>" alt="" />
								<a href="<?php echo site_url('administracion/vectores/'.$categoria_activa->nombre_categoria_vector_slug.'/borrar_vector/'.$vector->clipart_id); ?>"><i class="fa fa-times"></i></a>
							</div>
						</li>
					<?php endforeach; ?>
					</ul>
				</fieldset>
			</div>
		</div>
	</div>
</div>


<div class="reveal-modal small" id="nueva_categoria" data-reveal>
	<form action="<?php echo site_url('administracion/vectores/agregar_categoria'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre de la categoría
					<input type="text" name="nombre_categoria_vector" id="nombre_categoria_add" required />
				</label>
				<small class="error">Campo requerido.</small>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<button type="submit">Agregar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal small" id="editar_categoria" data-reveal>
	<form action="<?php echo site_url('administracion/categorias/editar_categoria'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre de la categoría
					<input type="text" name="nombre_categoria" id="nombre_categoria_mod" required value="" />
				</label>
				<small class="error">Campo requerido.</small>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_categoria" id="id_categoria_mod">
				<button type="submit">Guardar cambios</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>




<div class="reveal-modal small" id="borrar_categoria" data-reveal>
	<form action="<?php echo site_url('administracion/categorias/borrar_categoria'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar esta categoría? Se borrarían todas las subcategorías y todos los productos pertenecientes a la misma.</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_categoria" id="id_categoria_bor">
				<button type="submit">Borrar categoría</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal small" id="agregar_vectores" data-reveal>
	<form action="<?php echo site_url('administracion/vectores/'.$categoria_activa->nombre_categoria_vector_slug.'/agregar_vectores'); ?>" method="post" enctype="multipart/form-data" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;">Puedes seleccionar múltiples archivos SVG.</label>
				<input type="file" name="svg[]" id="multiples_svg" accept="image/svg+xml" multiple required />
				<small class="error">Campo requerido.</small>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<button type="submit">Subir archivos</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>