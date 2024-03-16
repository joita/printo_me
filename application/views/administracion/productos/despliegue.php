<div class="row" data-equalizer style="padding:0 1rem">
	<div class="small-12 columns navholder" data-equalizer-watch>
		<a href="<?php echo site_url(uri_string().'/agregar-producto'); ?>" class="coollink"><i class="fa fa-plus"></i> Agregar producto</a>
	</div>
	<div class="small-12 columns navholder text-right" data-equalizer-watch>
		<div class="row collapse">
			<div class="small-16 columns right">
				<input type="text" name="prod_s" id="prod_s" placeholder="Buscar producto">
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<?php if(sizeof($productos) > 0): ?>
		<ul class="divisor">
		<?php foreach($productos as $producto): ?>
			<li>
				<div class="row">
					<div class="small-2 columns">
						<?php $imagen = $this->productos_modelo->obtener_imagen_producto($producto->id_producto); ?>
						<img src="<?php echo site_url($imagen->ubicacion_base.$imagen->fotografia_icono); ?>" alt="" style="margin:5px;">
					</div>
					<div class="small-9 columns">
						<span class="nombre_producto"><?php echo $producto->nombre_producto; ?></span>
						<span class="colores_producto"><?php echo $this->productos_modelo->obtener_iconos_de_colores_por_producto($producto->id_producto); ?></span>
					</div>
					<div class="small-13 columns text-right subfunction-links" data-id_producto="<?php echo $producto->id_producto; ?>">
						<a href="<?php echo site_url(uri_string().'/modificar-producto/'.$producto->id_producto); ?>" class="edit-sub-cat"><i class="fa fa-edit"></i> Editar producto</i></a>
						<?php if($producto->estatus == 1): ?>
						<a class="enabled"><i class="fa fa-toggle-on"></i></a>
						<?php else: ?>
						<a class="disabled"><i class="fa fa-toggle-off"></i></a>
						<?php endif; ?>
						<a href="#" class="delete-sub-cat" data-reveal-id="borrar_producto"><i class="fa fa-times"></i></a>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
		</ul>
		<?php else: ?>
		<p class="nohay text-center">No hay productos en esta categoría y tipo.</p>
		<?php endif; ?>
	</div>
</div>


<div class="reveal-modal small" id="borrar_producto" data-reveal>
	<form action="<?php echo site_url(uri_string().'/borrar-producto'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar este producto? Esta acción no se puede deshacer.</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_producto" id="id_producto_bor">
				<button type="submit">Borrar producto</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>