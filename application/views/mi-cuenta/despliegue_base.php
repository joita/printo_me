 <div class="off-canvas-wrapper oculto-lateral" style="background: white; box-shadow: none" data-equalizer="base">
	<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
		<div class="title-bar show-for-small-only">
			<div class="title-bar-left">
				<button class="menu-icon" type="button" data-open="offCanvasLeft"></button>
				<span class="title-bar-title">Mi Cuenta » <?php echo $lugar; ?></span>
			</div>
		</div>
		<div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas>
			<?php $this->load->view('mi-cuenta/menu_lateral_cuenta', array('subseccion_activa' => $subseccion_activa)); ?>
		</div>
		<div class="off-canvas-content pscat fgc" data-off-canvas-content style="background-color: white; box-shadow: none">
			<div class="row<?php if($subseccion_activa == 'pedidos') { echo ' '; } ?>">
				<div class="medium-7 large-5 xlarge-4 columns show-for-medium lateral-cuenta" style="border-right: solid 2px #025573">
					<?php $this->load->view('mi-cuenta/menu_lateral_cuenta', array('subseccion_activa' => $subseccion_activa)); ?>
				</div>
				<div class="medium-11 large-13 xlarge-14 columns"<?php if($subseccion_activa != 'productos' && $subseccion_activa != 'productos_plazo_definido' && $subseccion_activa != 'puntos'): ?> data-equalizer-watch="base"<?php endif; ?>>
					<div class="fbc pscat" style="padding: 0.7rem">
                        <input type="hidden" id="subseccion-activa" value="<?php echo $subseccion_activa;?>">
						<?php $this->load->view('mi-cuenta/'.$subseccion_activa); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

 <div id="loader_direcciones">
     <span id="text_loader">Estamos verificando tus datos, sólo tomará un momento.</span>
 </div>

