<div class="off-canvas-wrapper oculto-lateral" data-equalizer>
	<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
		<div class="title-bar show-for-small-only">
			<div class="title-bar-left">
				<button class="menu-icon" type="button" data-open="offCanvasLeft"></button>
				<span class="title-bar-title">Refinar búsqueda</span>
			</div>
		</div>
		<div class="off-canvas position-left catalogo-left-menu" id="offCanvasLeft" data-off-canvas>
			<?php $this->load->view('catalogo/menu_filtros_laterales', array('id' => 'rango_movil')); ?>
		</div>
		<div class="off-canvas-content pscat fgc" data-off-canvas-content style="background: white">
			<div class="row">
				<div class="medium-6 large-5 xlarge-4 columns show-for-medium lateral-cuenta" style="border-right: solid 1px #025573; padding-right: 0.5rem">
					<?php $this->load->view('catalogo/menu_filtros_laterales', array('id' => 'rango')); ?>
				</div>
				<div class="medium-12 large-13 xlarge-14 columns" data-equalizer-watch>
					<?php $this->load->view($vista); ?>
				</div>
			</div>
		</div>
	</div>
</div>