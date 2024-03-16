<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Tipos de Producto</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="tab-menu">
		<?php foreach($categorias as $categoria): ?>
			<li><a href="<?php echo site_url('administracion/tipos/'.$categoria->nombre_categoria_slug); ?>"<?php activar($categoria_slug, $categoria->nombre_categoria_slug); ?>><i class="fa fa-tag"></i> <?php echo $categoria->nombre_categoria; ?></a></li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="row">
	<div class="small-24 columns" style="padding-top:0.8rem;padding-bottom:0.8rem;">
		<ul class="divisor">
        <?php if($tipos != 0):?>
		<?php foreach($tipos as $row): ?>
			<li>
				<div class="row">
					<div class="small-12 columns">
						<span class="categoria-principal"><i class="fa fa-bookmark"></i> <?php echo $row->tipo->nombre_tipo; ?></span>
					</div>
					<div class="small-12 columns text-right function-links" data-id_tipo="<?php echo $row->tipo->id_tipo; ?>" data-nombre_tipo="<?php echo $row->tipo->nombre_tipo; ?>" data-nombre_tipo_slug="<?php echo $row->tipo->nombre_tipo_slug; ?>" data-estatus="<?php echo $row->tipo->estatus; ?>" data-caracteristicas_tipo='<?php echo $row->tipo->caracteristicas_tipo; ?>' data-lados='<?php echo $row->lados;?>'>
						<a href="#" class="expand_1"><i class="fa fa-plus-square-o"></i> Mostrar características</i></a>
						<a href="#" class="edit-main-cat" data-reveal-id="editar_tipo"><i class="fa fa-edit"></i> Editar tipo</i></a>
						<a href="#" class="delete-main-cat" data-reveal-id="borrar_tipo"><i class="fa fa-times"></i></a>
					</div>
				</div>
				
				<ul class="divisor-sub list-caracteristica" data-id_parent="<?php echo $row->tipo->id_tipo; ?>">
					<?php if(isset($row->caracteristica)): ?>
					<?php foreach($row->caracteristica as $caracteristica): ?>
					<li>
						<div class="row">
							<div class="small-11 columns">
								<span class="caracteristica-principal"><i class="fa fa-tag"></i> <?php echo $caracteristica->nombre_caracteristica; ?></span>
							</div>
							<div class="small-13 columns text-right function-links" data-id="<?php echo $caracteristica->id_caracteristica; ?>" data-id_tipo="<?php echo $caracteristica->id_tipo; ?>" data-nombre="<?php echo $caracteristica->nombre_caracteristica; ?>" data-nombre_slug="<?php echo $caracteristica->nombre_caracteristica_slug; ?>" data-id_parent="<?php echo $caracteristica->id_caracteristica_parent; ?>" data-estatus="<?php echo $caracteristica->estatus; ?>">
								<a href="#" class="expand"><i class="fa fa-plus-square-o"></i> Mostrar valores</i></a>
								<a href="#" class="editar" data-reveal-id="editar"><i class="fa fa-edit"></i> Editar caracteristica</i></a>
								<?php if($caracteristica->estatus == 1): ?>
								<a href="#" class="enabled"><i class="fa fa-toggle-on"></i></a>
								<?php else: ?>
								<a href="#" class="disabled"><i class="fa fa-toggle-off"></i></a>
								<?php endif; ?>
								<a href="#" class="delete" data-reveal-id="borrar"><i class="fa fa-times"></i></a>
							</div>
						</div>				
						<ul class="divisor-sub list-subcaracteristica" data-id_parent="<?php echo $caracteristica->id_caracteristica; ?>">
						<?php if(isset($caracteristica->subcaracteristica)): ?>
							<?php foreach($caracteristica->subcaracteristica as $subcaracteristica): ?>
							<li>
								<div class="row">
									<div class="small-11 columns">
										<i class="fa fa-tags"></i> <?php echo $subcaracteristica->nombre_caracteristica; ?>
									</div>
									<div class="small-13 columns text-right subfunction-links" data-id="<?php echo $subcaracteristica->id_caracteristica; ?>" data-nombre="<?php echo $subcaracteristica->nombre_caracteristica; ?>" data-nombre_slug="<?php echo $subcaracteristica->nombre_caracteristica_slug; ?>" data-id_caracteristica_parent="<?php echo $subcaracteristica->id_caracteristica_parent; ?>" data-estatus="<?php echo $subcaracteristica->estatus; ?>" data-nombre_parent="<?php echo $caracteristica->nombre_caracteristica; ?>">
										<a href="#" class="edit-sub" data-reveal-id="editar_sub"><i class="fa fa-edit"></i> Editar valor</i></a>
										<?php if($subcaracteristica->estatus == 1): ?>
										<a href="#" class="enabled"><i class="fa fa-toggle-on"></i></a>
										<?php else: ?>
										<a href="#" class="disabled"><i class="fa fa-toggle-off"></i></a>
										<?php endif; ?>
										<a href="#" class="delete-sub" data-reveal-id="borrar_sub"><i class="fa fa-times"></i></a>
									</div>
								</div>
							</li>
							<?php endforeach; ?>				
						<?php endif; ?>
							<li>
								<div class="row">
									<div class="small-24 columns">
										<a href="#" class="nuevasub" data-reveal-id="nueva_sub" data-id_parent="<?php echo $caracteristica->id_caracteristica; ?>" data-id_tipo="<?php echo $caracteristica->id_tipo; ?>"><i class="fa fa-plus"></i> Agregar valor</a>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<?php endforeach; ?>
					<?php endif; ?>
					<li>
						<div class="row">
							<div class="small-24 columns">
								<a href="#" data-reveal-id="nueva_caracteristica" id="new_caracteristica" data-id_tipo="<?php echo $row->tipo->id_tipo?>"><i class="fa fa-plus"></i> Agregar característica</a>
							</div>
						</div>
					</li>
				</ul>		
			</li>
		<?php endforeach; ?>
        <?php else:?>
            <li style="padding: 2rem"><p>No se encuentran tipos de productos registrados en esta categoría.</p></li>
        <?php endif;?>
			<li>
				<div class="row">
					<div class="small-24 columns">
						<a href="#" data-reveal-id="nuevo_tipo"><i class="fa fa-plus"></i> Agregar tipo de producto</a>
					</div>
				</div>	
			</li>
		</ul>
	</div>
</div>


<div class="reveal-modal small" id="nuevo_tipo" style="max-width:600px;" data-reveal>
	<form action="<?php echo site_url('administracion/tipos/'.$categoria_slug.'/agregar-tipo'); ?>" method="post" data-abide>
		<h4 class="text-center">Nuevo tipo de producto</h4>
		<div class="row">
			<div class="small-24 columns" >
				<label>Nombre del tipo de producto
					<input type="text" name="nombre_tipo" id="nombre_tipo_add" required />
				</label>
				<small class="error">Campo obligatorio.</small>
			</div>
		</div>
        <hr class="dashed">
        <div class="row">
            <div class="small-24 columns" id="lds">
                <div class="row lados">
                    <div class="small-20 columns">
                        <label>Nombre Lado
                            <input type="text" name="tipo[lados][0]" id="lados_add_0" required />
                        </label>
                        <small class="error">Obligatorio.</small>
                    </div>
                    <div class="small-2 columns">
                        <label>&nbsp;
                            <button type="button" class="add_lado success"><i class="fa fa-plus-circle"></i></button>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <hr class="dashed">
		<div class="row">
			<div class="small-24 columns" id="cars">
				<div class="row caracteristica">
					<div class="small-8 columns">
						<label>Característica
							<input type="text" name="tipo[caracteristicas][0]" id="caracteristicas_add_0" required />
						</label>
						<small class="error">Obligatorio.</small>
					</div>
					<div class="small-12 columns">
						<label>Posibles valores (Separados por ,)
							<input type="text" name="tipo[valores][0]" id="valores_add_0" required />
						</label>
						<small class="error">Obligatorio.</small>
					</div>
					<div class="small-2 columns">
						<label>&nbsp;
							<button type="button" class="add_tipo success"><i class="fa fa-plus-circle"></i></button>
						</label>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="small-24 columns text-center">
				<button type="submit">Agregar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal small" id="editar_tipo" style="max-width:600px;" data-reveal>
	<form action="<?php echo site_url('administracion/tipos/'.$categoria_slug.'/editar-tipo'); ?>" method="post" data-abide>
		<h4 class="text-center">Editar tipo de producto</h4>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre del tipo
					<input type="text" name="nombre_tipo" id="nombre_tipo_mod" value="" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns" id="cars_mod">
				
			</div>
		</div>
        <div class="row">
            <div class="small-24 columns list-group" id="lds_mod">

            </div>
        </div>
		<hr>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_tipo" id="id_tipo_mod">
				<button type="submit">Guardar cambios</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>


<div class="reveal-modal small" id="borrar_tipo" data-reveal>
	<form action="<?php echo site_url('administracion/tipos/'.$categoria_slug.'/borrar-tipo'); ?>" method="post" data-abide>
		<h4 class="text-center">Borrar tipo de producto</h4>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar esta tipo? Se ocultarían todos los productos pertenecientes a la misma.</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_tipo" id="id_tipo_bor">
				<button type="submit">Borrar tipo</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<?php /* caracteristicas */?>

<div class="reveal-modal small" id="nueva_caracteristica" data-reveal>
	<form action="<?php echo site_url('administracion/'.$class_2.'/'.$categoria_slug.'/agregar'); ?>" class="form_new" method="post" data-abide>
		<h4 class="text-center">Nueva característica</h4>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre
					<input type="text" name="nombre" id="nombre_add" />
				</label>
			</div>
		</div>
		<div class="row">
			<input type="hidden" name="id_tipo">
			<div class="small-24 columns text-center">
				<button type="submit">Agregar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal small" id="editar" data-reveal>
	<form action="<?php echo site_url('administracion/'.$class_2.'/'.$categoria_slug.'/editar'); ?>" class="form_edit" method="post" data-abide>
		<h4 class="text-center">Editar característica</h4>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre
					<input type="text" name="nombre" id="nombre" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id" id="id">
				<button type="submit">Guardar cambios</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>




<div class="reveal-modal small" id="nueva_sub" data-reveal>
	<form action="<?php echo site_url('administracion/'.$class_2.'/'.$categoria_slug.'/agregar_sub'); ?>" class="form_new_sub" method="post" data-abide>
		<h4 class="text-center">Nuevo valor</h4>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre
					<input type="text" name="nombre" id="nombre" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_parent" id="id_parent">
				<input type="hidden" name="id_tipo" id="id_tipo">
				<button type="submit">Agregar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal small" id="editar_sub" data-reveal>
	<form action="<?php echo site_url('administracion/'.$class_2.'/'.$categoria_slug.'/editar_sub'); ?>" class="form_edit_sub" method="post" data-abide>
		<h4 class="text-center">Editar valor</h4>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre
					<input type="text" name="nombre" id="nombre" value="" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id" id="id">
				<button type="submit">Guardar cambios</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>



<div class="reveal-modal small" id="borrar" data-reveal>
	<form action="<?php echo site_url('administracion/'.$class_2.'/'.$categoria_slug.'/borrar'); ?>" class="form_borrar" method="post" data-abide>
		<h4 class="text-center">Borrar caracteristica</h4>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar esta caracteristica? Se borrarían todas las subcategorías y todos los productos pertenecientes a la misma.</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id" id="id">
				<button type="submit">Borrar caracteristica</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal small" id="borrar_sub" data-reveal>
	<form action="<?php echo site_url('administracion/'.$class_2.'/'.$categoria_slug.'/borrar'); ?>" class="form_borrar_sub" method="post" data-abide>
		<h4 class="text-center">Borrar valor</h4>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar esta valor? Se borrarían todos los productos pertenecientes a la misma.</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id" id="id">
				<button type="submit">Borrar valor</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>