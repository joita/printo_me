<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Sliders
			<a href="#" class="coollink right" style="font-size:0.9rem;" data-reveal-id="agregar_slide"><i class="fa fa-plus"></i> Agregar slide</a>
		</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="divisor">
		<?php foreach($this->slider_modelo->obtener_sliders(true) as $slider): ?>
			<li>
				<div class="row">
					<div class="small-7 columns">
						<img src="<?php echo site_url($slider->ubicacion_base.$slider->imagen_icono); ?>" alt="" style="margin:10px 5px;">
					</div>
					<div class="small-13 columns text-right subfunction-links" data-id_slide="<?php echo $slider->id_slide; ?>" data-imagen_slide="<?php echo site_url($slider->ubicacion_base.$slider->imagen_icono); ?>" data-url_slide="<?php echo $slider->url_slide; ?>">
						<a href="#" class="edit-sub-cat" data-reveal-id="editar_slide"><i class="fa fa-edit"></i> Editar slide</i></a>
						<?php if($slider->estatus == 1): ?>
						<a class="enabled"><i class="fa fa-toggle-on"></i></a>
						<?php else: ?>
						<a class="disabled"><i class="fa fa-toggle-off"></i></a>
						<?php endif; ?>
						<a href="#" class="delete-sub-cat" data-reveal-id="borrar_slide"><i class="fa fa-times"></i></a>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>


<div class="reveal-modal small" id="agregar_slide" data-reveal>
	<form action="<?php echo site_url('administracion/sliders/agregar'); ?>" method="post" enctype="multipart/form-data" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Archivo de la imagen
					<input type="file" name="imagen" id="imagen_slider_add" accept="image/jpeg" required />
				</label>
				<small class="error">Archivo obligatorio</small>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns">
				<label>Dirección URL (Opcional)
					<input type="text" name="url_slide" id="url_slider_add" pattern="url" placeholder="Ej: http://www.Print-o-Me.com.mx/promociones" />
				</label>
				<small class="error">Formato incorrecto</small>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<button type="submit">Agregar slide</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>


<div class="reveal-modal small" id="editar_slide" data-reveal>
	<form action="<?php echo site_url('administracion/sliders/modificar'); ?>" method="post" enctype="multipart/form-data" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<img src="" alt="" id="img_mod">
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns">
				<label>Dirección URL (Opcional)
					<input type="text" name="url_slide" id="url_slide_mod" pattern="url" placeholder="Ej: http://www.Print-o-Me.com.mx/promociones" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_slide" id="id_slide_mod" value="">
				<button type="submit">Agregar slide</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>



<div class="reveal-modal small" id="borrar_slide" data-reveal>
	<form action="<?php echo site_url('administracion/sliders/borrar'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar este slide?</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_slide" id="id_slide_bor">
				<button type="submit">Borrar slide</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>