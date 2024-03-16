<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Tipos de Producto</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="divisor">
		<?php foreach($this->tipo_modelo->obtener_tipos_admin() as $tipo): ?>
			<li>
				<div class="row">
					<div class="small-12 columns">
						<span class="categoria-principal"><i class="fa fa-bookmark"></i> <?php echo $tipo->nombre_tipo; ?></span>
					</div>
					<div class="small-12 columns text-right function-links" data-id_tipo="<?php echo $tipo->id_tipo; ?>" data-nombre_tipo="<?php echo $tipo->nombre_tipo; ?>" data-nombre_tipo_slug="<?php echo $tipo->nombre_tipo_slug; ?>" data-estatus="<?php echo $tipo->estatus; ?>" data-caracteristicas_tipo='<?php echo $tipo->caracteristicas_tipo; ?>'>
						<a href="#" class="edit-main-cat" data-reveal-id="editar_tipo"><i class="fa fa-edit"></i> Editar tipo</i></a>
						<a href="#" class="delete-main-cat" data-reveal-id="borrar_tipo"><i class="fa fa-times"></i></a>
					</div>
				</div>				
			</li>
		<?php endforeach; ?>
			<li>
				<div class="row">
					<div class="small-24 columns">
						<a href="#" data-reveal-id="nuevo_tipo"><i class="fa fa-plus"></i> Agregar Nuevo Tipo de Producto</a>
					</div>
				</div>	
			</li>
		</ul>
	</div>
</div>


<div class="reveal-modal small" id="nuevo_tipo" style="max-width:600px;" data-reveal>
	<form action="<?php echo site_url('administracion/tipos/agregar-tipo'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre del tipo de producto
					<input type="text" name="nombre_tipo" id="nombre_tipo_add" required />
				</label>
				<small class="error">Campo obligatorio.</small>
			</div>
		</div>
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
	<form action="<?php echo site_url('administracion/tipos/editar-tipo'); ?>" method="post" data-abide>
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
	<form action="<?php echo site_url('administracion/tipos/borrar-tipo'); ?>" method="post" data-abide>
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