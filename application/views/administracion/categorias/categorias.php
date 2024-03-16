<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Categorías</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="divisor">
		<?php foreach($categorias as $categoria): ?>
			<li>
				<div class="row">
					<div class="small-12 columns">
						<span class="categoria-principal"><i class="fa fa-tag"></i> <?php echo $categoria->nombre_categoria; ?></span>
					</div>
					<div class="small-12 columns text-right function-links" data-id_categoria="<?php echo $categoria->id_categoria; ?>" data-nombre_categoria="<?php echo $categoria->nombre_categoria; ?>" data-nombre_categoria_slug="<?php echo $categoria->nombre_categoria_slug; ?>" data-id_categoria_parent="<?php echo $categoria->id_categoria_parent; ?>" data-estatus="<?php echo $categoria->estatus; ?>">
						<?php /*<a href="#" class="expand"><i class="fa fa-plus-square-o"></i> Mostrar subcategorías</i></a>*/?>
						<a href="#" class="edit-main-cat" data-reveal-id="editar_categoria"><i class="fa fa-edit"></i> Editar categoría</i></a>
						<?php if($categoria->estatus == 1): ?>
						<a href="#" class="enabled"><i class="fa fa-toggle-on"></i></a>
						<?php else: ?>
						<a href="#" class="disabled"><i class="fa fa-toggle-off"></i></a>
						<?php endif; ?>
						<a href="#" class="delete-main-cat" data-reveal-id="borrar_categoria"><i class="fa fa-times"></i></a>
					</div>
				</div>				
				<ul class="divisor-subcategorias" data-id_parent="<?php echo $categoria->id_categoria; ?>">
				<?php if(isset($categoria->subcategorias)): ?>
					<?php foreach($categoria->subcategorias as $subcategoria): ?>
					<li>
						<div class="row">
							<div class="small-11 columns">
								<i class="fa fa-tags"></i> <?php echo $subcategoria->nombre_categoria; ?>
							</div>
							<div class="small-13 columns text-right subfunction-links" data-id_categoria="<?php echo $subcategoria->id_categoria; ?>" data-nombre_categoria="<?php echo $subcategoria->nombre_categoria; ?>" data-nombre_categoria_slug="<?php echo $subcategoria->nombre_categoria_slug; ?>" data-id_categoria_parent="<?php echo $subcategoria->id_categoria_parent; ?>" data-estatus="<?php echo $subcategoria->estatus; ?>" data-nombre_categoria_parent="<?php echo $categoria->nombre_categoria; ?>">
								<a href="#" class="edit-sub-cat" data-reveal-id="editar_subcategoria"><i class="fa fa-edit"></i> Editar subcategoría</i></a>
								<?php if($subcategoria->estatus == 1): ?>
								<a href="#" class="enabled"><i class="fa fa-toggle-on"></i></a>
								<?php else: ?>
								<a href="#" class="disabled"><i class="fa fa-toggle-off"></i></a>
								<?php endif; ?>
								<a href="#" class="delete-sub-cat" data-reveal-id="borrar_subcategoria"><i class="fa fa-times"></i></a>
							</div>
						</div>
					</li>
					<?php endforeach; ?>				
				<?php endif; ?>
					<li>
						<div class="row">
							<div class="small-24 columns">
								<a href="#" class="nuevasub" data-reveal-id="nueva_subcategoria" data-id_categoria_parent="<?php echo $categoria->id_categoria; ?>"><i class="fa fa-plus"></i> Agregar Subcategoría</a>
							</div>
						</div>
					</li>
				</ul>
			</li>
		<?php endforeach; ?>
			<li>
				<div class="row">
					<div class="small-24 columns">
						<a href="#" data-reveal-id="nueva_categoria"><i class="fa fa-plus"></i> Agregar Nueva Categoría</a>
					</div>
				</div>	
			</li>
		</ul>
	</div>
</div>


<div class="reveal-modal small" id="nueva_categoria" data-reveal>
	<form action="<?php echo site_url('administracion/categorias/agregar_categoria'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre de la categoría
					<input type="text" name="nombre_categoria" id="nombre_categoria_add" required />
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




<div class="reveal-modal small" id="nueva_subcategoria" data-reveal>
	<form action="<?php echo site_url('administracion/categorias/agregar_subcategoria'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre de la subcategoría
					<input type="text" name="nombre_categoria" id="nombre_subcategoria_add" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_categoria_parent" id="id_categoria_parent_add">
				<button type="submit">Agregar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal small" id="editar_subcategoria" data-reveal>
	<form action="<?php echo site_url('administracion/categorias/editar_subcategoria'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre de la subcategoría
					<input type="text" name="nombre_categoria" id="nombre_subcategoria_mod" value="" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_categoria" id="id_subcategoria_mod">
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

<div class="reveal-modal small" id="borrar_subcategoria" data-reveal>
	<form action="<?php echo site_url('administracion/categorias/borrar_categoria'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar esta subcategoría? Se borrarían todos los productos pertenecientes a la misma.</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_categoria" id="id_subcategoria_bor">
				<button type="submit">Borrar subcategoría</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>