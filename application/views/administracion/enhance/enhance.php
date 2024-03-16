<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Diseños en venta » <?php echo ($tipo_activo == 'limitado' ? 'Plazo definido' : 'Venta inmediata'); ?></h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="tab-menu">
			<li><a href="<?php echo site_url('administracion/campanas/limitado'); ?>"<?php activar('limitado', $tipo_activo); ?>><i class="fa fa-clock-o"></i> Plazo definido</a></li>
			<li><a href="<?php echo site_url('administracion/campanas/fijo'); ?>"<?php activar('fijo', $tipo_activo); ?>><i class="fa fa-server"></i> Venta inmediata</a></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<div id="main-container" style="padding: 1rem 1.2rem;">
			<?php $this->load->view('administracion/enhance/'.$tipo_activo); ?>
		</div>
	</div>
</div>