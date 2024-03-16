<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Reportes</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<div class="row">
			<div class="small-6 columns">
				<fieldset id="datos_producto">
					<legend>Tipo de reporte</legend>
					<div class="row collapse">
						<div class="small-24 columns">
							<ul class="side-nav inner-menu">
								<li><a href="<?php echo site_url('administracion/reportes/minimos'); ?>"<?php activar($reporte_especifico, 'minimos'); ?>>Inventario al mínimo</a></li>
                                <li><a href="<?php echo site_url('administracion/reportes/inventario_completo'); ?>"<?php activar($reporte_especifico, 'inventario_completo'); ?>>Inventario completo</a></li>
								<li><a href="<?php echo site_url('administracion/reportes/ventas'); ?>"<?php activar($reporte_especifico, 'ventas'); ?>>Ventas realizadas</a></li>
								<li><a href="<?php echo site_url('administracion/reportes/pagos'); ?>"<?php activar($reporte_especifico, 'pagos'); ?>>Pagos a diseñadores</a></li>

							</ul>
						</div>
					</div>
				</fieldset>
			</div>
			<div class="small-18 columns">
				<fieldset id="datos_adicionales">
				<?php $this->load->view('administracion/reportes/'.$reporte_especifico); ?>
				</fieldset>
			</div>
		</div>
	</div>
</div>
