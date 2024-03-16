<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Característica</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="divisor">
		<?php foreach($caracteristicas as $caracteristica): ?>
			<?php //print_m($caracteristica);?>
			<li>
				<div class="row">
					<div class="small-11 columns">
						<span class="caracteristica-principal"><i class="fa fa-tag"></i> <?php echo $caracteristica->nombre_caracteristica; ?></span>
					</div>
					<div class="small-13 columns text-right function-links" data-id="<?php echo $caracteristica->id_caracteristica; ?>" data-id_tipo="<?php echo $caracteristica->id_tipo; ?>" data-nombre="<?php echo $caracteristica->nombre_caracteristica; ?>" data-nombre_slug="<?php echo $caracteristica->nombre_caracteristica_slug; ?>" data-id_parent="<?php echo $caracteristica->id_caracteristica_parent; ?>" data-estatus="<?php echo $caracteristica->estatus; ?>">
						<a href="#" class="expand"><i class="fa fa-plus-square-o"></i> Mostrar caracteristica</i></a>
						<a href="#" class="editar" data-reveal-id="editar"><i class="fa fa-edit"></i> Editar caracteristica</i></a>
						<?php if($caracteristica->estatus == 1): ?>
						<a href="#" class="enabled"><i class="fa fa-toggle-on"></i></a>
						<?php else: ?>
						<a href="#" class="disabled"><i class="fa fa-toggle-off"></i></a>
						<?php endif; ?>
						<a href="#" class="delete" data-reveal-id="borrar"><i class="fa fa-times"></i></a>
					</div>
				</div>				
				<ul class="divisor-sub" data-id_parent="<?php echo $caracteristica->id_caracteristica; ?>">
				<?php if(isset($caracteristica->subcaracteristicas)): ?>
					<?php foreach($caracteristica->subcaracteristicas as $subcaracteristica): ?>
					<li>
						<div class="row">
							<div class="small-11 columns">
								<i class="fa fa-tags"></i> <?php echo $subcaracteristica->nombre_caracteristica; ?>
							</div>
							<div class="small-13 columns text-right subfunction-links" data-id="<?php echo $subcaracteristica->id_caracteristica; ?>" data-nombre="<?php echo $subcaracteristica->nombre_caracteristica; ?>" data-nombre_slug="<?php echo $subcaracteristica->nombre_caracteristica_slug; ?>" data-id_caracteristica_parent="<?php echo $subcaracteristica->id_caracteristica_parent; ?>" data-estatus="<?php echo $subcaracteristica->estatus; ?>" data-nombre_parent="<?php echo $caracteristica->nombre_caracteristica; ?>">
								<a href="#" class="edit-sub" data-reveal-id="editar_sub"><i class="fa fa-edit"></i> Editar subcaracteristica</i></a>
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
								<a href="#" class="nuevasub" data-reveal-id="nueva_sub" data-id_parent="<?php echo $caracteristica->id_caracteristica; ?>" data-id_tipo="<?php echo $caracteristica->id_tipo; ?>"><i class="fa fa-plus"></i> Agregar Subcaracteristica</a>
							</div>
						</div>
					</li>
				</ul>
			</li>
		<?php endforeach; ?>
			<li>
				<div class="row">
					<div class="small-24 columns">
						<a href="#" data-reveal-id="nueva_caracteristica"><i class="fa fa-plus"></i> Agregar Nueva Característica</a>
					</div>
				</div>	
			</li>
		</ul>
	</div>
</div>


<div class="reveal-modal small" id="nueva_caracteristica" data-reveal>
	<form action="<?php echo site_url('administracion/'.$class.'/agregar'); ?>" class="form_new" method="post" data-abide>
		<h4 class="text-center">Característica</h4>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre
					<input type="text" name="nombre" id="nombre_add" />
				</label>
			</div>
			<div class="small-24 columns">
				<label>Tecnica
					<select name="id_tipo" id="id_tipo">
						<?php foreach($tipos->result() as $row): ?>
							<option value="<?php echo $row->id_tipo?>"><?php echo $row->nombre_tipo?></option>
						<?php endforeach ?>
					</select>
				</label>
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

<div class="reveal-modal small" id="editar" data-reveal>
	<form action="<?php echo site_url('administracion/'.$class.'/editar'); ?>" class="form_edit" method="post" data-abide>
		<h4 class="text-center">Editar característica</h4>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre
					<input type="text" name="nombre" id="nombre" />
				</label>
			</div>
			<div class="small-24 columns">
				<label>Tecnica
					<select name="id_tipo" id="id_tipo">
						<?php foreach($tipos->result() as $row): ?>
							<option value="<?php echo $row->id_tipo?>"><?php echo $row->nombre_tipo?></option>
						<?php endforeach ?>
					</select>
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
	<form action="<?php echo site_url('administracion/'.$class.'/agregar_sub'); ?>" class="form_new_sub" method="post" data-abide>
		<h4 class="text-center">Subcaracteristica</h4>
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
	<form action="<?php echo site_url('administracion/'.$class.'/editar_sub'); ?>" class="form_edit_sub" method="post" data-abide>
		<h4 class="text-center">Editar subcaracteristica</h4>
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
	<form action="<?php echo site_url('administracion/'.$class.'/borrar'); ?>" class="form_borrar" method="post" data-abide>
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
	<form action="<?php echo site_url('administracion/'.$class.'/borrar'); ?>" class="form_borrar_sub" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar esta subcaracteristica? Se borrarían todos los productos pertenecientes a la misma.</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id" id="id">
				<button type="submit">Borrar subcaracteristica</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>