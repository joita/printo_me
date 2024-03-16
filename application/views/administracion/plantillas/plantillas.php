<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Plantillas</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="tab-menu">
			<li><a href="<?php echo site_url('administracion/plantillas'); ?>"<?php activar($criterio_activo, 'clasificar'); ?>><i class="fa fa-question"></i> Por clasificar</a></li>
			<li><a href="<?php echo site_url('administracion/plantillas/activas'); ?>"<?php activar($criterio_activo, 'activas'); ?>><i class="fa fa-check"></i> Activas</a></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<div id="main-container">
			<div class="row">
				<div class="small-24 columns">
					<?php $this->load->view('administracion/plantillas/'.$criterio_activo); ?>
				</div>
			</div>
		</div>
	</div>
</div>