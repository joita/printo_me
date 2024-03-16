<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Marcas</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="divisor">
		<?php foreach($this->marcas_modelo->obtener_marcas_admin() as $marca): ?>
			<li>
				<div class="row">
					<div class="small-12 columns">
						<span class="categoria-principal"><i class="fa fa-tag"></i> <?php echo $marca->nombre_marca; ?></span>
					</div>
					<div class="small-12 columns text-right function-links" data-id_marca="<?php echo $marca->id_marca; ?>" data-nombre_marca="<?php echo $marca->nombre_marca; ?>" data-nombre_marca_slug="<?php echo $marca->nombre_marca_slug; ?>" data-estatus="<?php echo $marca->estatus; ?>">
						<a href="#" class="edit-main-cat" data-reveal-id="editar_marca"><i class="fa fa-edit"></i> Editar marca</i></a>
						<?php if($marca->estatus == 1): ?>
						<a href="#" class="enabled"><i class="fa fa-toggle-on"></i></a>
						<?php else: ?>
						<a href="#" class="disabled"><i class="fa fa-toggle-off"></i></a>
						<?php endif; ?>
						<a href="#" class="delete-main-cat" data-reveal-id="borrar_marca"><i class="fa fa-times"></i></a>
					</div>
				</div>				
			</li>
		<?php endforeach; ?>
			<li>
				<div class="row">
					<div class="small-24 columns">
						<a href="#" data-reveal-id="nueva_marca"><i class="fa fa-plus"></i> Agregar Nueva Marca</a>
					</div>
				</div>	
			</li>
		</ul>
	</div>
</div>


<div class="reveal-modal small" id="nueva_marca" data-reveal>
	<form action="<?php echo site_url('administracion/marcas/agregar-marca'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre de la marca
					<input type="text" name="nombre_marca" id="nombre_marca_add" />
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

<div class="reveal-modal small" id="editar_marca" data-reveal>
	<form action="<?php echo site_url('administracion/marcas/editar-marca'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre de la marca
					<input type="text" name="nombre_marca" id="nombre_marca_mod" value="" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_marca" id="id_marca_mod">
				<button type="submit">Guardar cambios</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>


<div class="reveal-modal small" id="borrar_marca" data-reveal>
	<form action="<?php echo site_url('administracion/marcas/borrar-marca'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar esta marca? Se ocultarían todos los productos pertenecientes a la misma.</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_marca" id="id_marca_bor">
				<button type="submit">Borrar marca</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>