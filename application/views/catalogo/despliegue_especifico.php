<div class="fgc pscat">
	<div class="row">
		<div class="small-18 medium-9 large-9 columns" id="slider-area">
			<div class="row collapse">
				<div class="small-3 medium-3 large-3 columns">
					<div class="row" id="profile_controller">
						<div class="small-18 columns profile_controller">
						<?php foreach($colores[0]->fotografias as $indice=>$fotografia): ?>
							<a data-slide="<?php echo $indice; ?>"<?php if($indice == 0) { echo ' class="active"'; } ?>>
								<img src="<?php echo site_url($fotografia->ubicacion_base.$fotografia->fotografia_chica); ?>" alt="">
							</a>
						<?php endforeach; ?>
						</div>
					</div>
				</div>
				<div class="small-15 medium-15 large-15 columns">
					<div class="row" id="profile_slider">
						<div class="small-18 columns profile_slider">
							<div class="slide">
								<div class="zoomHolder">
									<img data-src="<?php echo site_url($fotografia->ubicacion_base.$fotografia->fotografia_grande); ?>" data-elem="pinchzoomer" alt="" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="small-18 medium-9 large-9 columns" id="info-producto">
			<h2 class="text-center medium-text-left dosf"><?php echo $producto->nombre_producto; ?></h2>
			<div class="area-descripcion">
				<?php echo $producto->descripcion_producto; ?>
				<p><strong>Da clic en "Empieza a personalizar" y comienza el proceso con la playera que seleccionaste.</strong></p>
			</div>
			<div class="row" data-equalizer data-equalize-on="large">
				<div class="small-18 medium-18 large-9 columns">
					<p class="precio-prod text-center medium-text-left">Disponibilidad de colores:</p>
					<p class="adic-desc">Estos son los colores disponibles, podrás seleccionarlos durante tu proceso de personalización.</p>
					<div class="colores-producto clearfix text-center medium-text-left" data-equalizer-watch>
						<?php foreach($colores as $indice=>$color): ?>
						<a class="color-switcher special" data-url-designer="<?php echo site_url('personalizar/'.$producto->id_producto.'/'.$color->id_color); ?>" data-json-fotografias='<?php echo json_encode($color->fotografias); ?>'<?php if(isset($color->tallas_disponibles[0]->caracteristicas->talla)): ?>data-json-tallas='<?php echo json_encode($color->tallas_disponibles); ?>'<?php endif; ?>><i class="fa fa-<?php if($indice == 0) { echo 'check-'; } ?>circle" style="color:<?php echo $color->codigo_color; ?>;"></i></a>
						<?php endforeach; ?>
					</div>
					<a class="no-encuentras button talla-int" data-open="contacto_interno">¿No encuentras el color que necesitas?</a>
				</div>
				<div class="small-18 medium-18 large-9 columns">
				<?php if(isset($colores[0]->tallas_disponibles[0]->caracteristicas->talla)): ?>
					<p class="precio-prod text-center medium-text-left">Disponibilidad de tallas:</p>
					<p class="adic-desc">Estas son las tallas disponibles, podrás seleccionarlas una vez que termines tu proceso de personalización.</p>
					<div class="temp-tallas text-center medium-text-left colores-producto" data-equalizer-watch>
					<?php foreach($colores[0]->tallas_disponibles as $talla): ?><p style='margin-bottom: 0' class="talla_f" href="<?php //echo site_url('personalizar/'.$producto->id_producto.'/'.$colores[0]->id_color); ?>"><?php echo $talla->caracteristicas->talla; ?></p><?php endforeach; ?>
					</div>
				<?php endif; ?>

					<a class="no-encuentras button tabla-medidas" data-open="area-tabla-medidas">Tabla de medidas</a>
				</div>
			</div>
			<div class="row">
				<div class="small-18 columns">
					<p class="precio-prod Sshow-for-small-only text-center medium-text-left hide">Desde $<?php echo redondeo($this->catalogo_modelo->obtener_precio_minimo_por_producto($producto->id_producto)); ?></p>
					<div class="text-center area-boton">
						<a href="<?php echo site_url('personalizar/'.$producto->id_producto.'/'.$colores[0]->id_color); ?>" id="big-personalizar" class="button expanded">¡Empieza a personalizar!</a>
					</div>
				</div>
			</div>

			<div id="area-tabla-medidas" class="reveal" data-reveal>
			<?php if($producto->id_producto == 13 || $producto->id_producto == 14): ?>
			<?php $this->load->view('catalogo/tablas_medidas/hombre_cuello_redondo_manga_corta'); ?>
			<?php elseif($producto->id_producto == 15 || $producto->id_producto == 16): ?>
			<?php $this->load->view('catalogo/tablas_medidas/hombre_cuello_redondo_manga_larga'); ?>
			<?php elseif($producto->id_producto == 17 || $producto->id_producto == 19): ?>
			<?php $this->load->view('catalogo/tablas_medidas/mujer_cuello_redondo_manga_corta'); ?>
			<?php elseif($producto->id_producto == 20 || $producto->id_producto == 21): ?>
			<?php $this->load->view('catalogo/tablas_medidas/mujer_cuello_v_manga_corta'); ?>
			<?php elseif($producto->id_producto == 22 || $producto->id_producto == 23): ?>
			<?php $this->load->view('catalogo/tablas_medidas/mujer_capucha_manga_larga'); ?>
            <?php elseif($producto->id_producto == 39 || $producto->id_producto == 40): ?>
            <?php $this->load->view('catalogo/tablas_medidas/mujer_cuello_redondo_sin_mangas'); ?>
			<?php elseif($producto->id_producto == 24 || $producto->id_producto == 25): ?>
			<?php $this->load->view('catalogo/tablas_medidas/juvenil_manga_corta_unisex'); ?>
			<?php elseif($producto->id_producto == 27 || $producto->id_producto == 28): ?>
			<?php $this->load->view('catalogo/tablas_medidas/juvenil_manga_larga_unisex'); ?>
			<?php elseif($producto->id_producto == 29 || $producto->id_producto == 30): ?>
			<?php $this->load->view('catalogo/tablas_medidas/infantil_manga_corta_unisex'); ?>
			<?php elseif($producto->id_producto == 31 || $producto->id_producto == 32): ?>
			<?php $this->load->view('catalogo/tablas_medidas/infantil_manga_larga_unisex'); ?>
			<?php elseif($producto->id_producto == 33 || $producto->id_producto == 34): ?>
			<?php $this->load->view('catalogo/tablas_medidas/bebe_manga_corta_unisex'); ?>
			<?php elseif($producto->id_producto == 35 || $producto->id_producto == 36): ?>
			<?php $this->load->view('catalogo/tablas_medidas/bebe_manga_larga_unisex'); ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
</div>
