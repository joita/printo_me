<div class="row collapse">
	<div class="small-24 columns">
		<ul class="tab-menu">
			<li class="tab-title<?php activar_alt('activos', $estatus_activo); ?>"><a href="<?php echo site_url('administracion/campanas/fijo'); ?>"><i class="fa fa-asterisk"></i> Activos <small class="cn"><?php echo $productos['activos']; ?></small></a></li>
			<li class="tab-title<?php activar_alt('aprobar', $estatus_activo); ?>"><a href="<?php echo site_url('administracion/campanas/fijo/aprobar'); ?>"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Por aprobar <small class="cn"><?php echo $productos['aprobar']; ?></small></a></li>
			<li class="tab-title<?php activar_alt('pagar', $estatus_activo); ?>"><a href="<?php echo site_url('administracion/campanas/fijo/pagar'); ?>"><i class="fa fa-credit-card-alt"></i> Por pagar <small class="cn"><?php echo $productos['pagar']; ?></small></a></li>
			<li class="tab-title<?php activar_alt('rechazados', $estatus_activo); ?>"><a href="<?php echo site_url('administracion/campanas/fijo/rechazados'); ?>"><i class="fa fa-times"></i> Rechazados <small class="cn"><?php echo $productos['rechazados']; ?></small></a></li>
		</ul>
	</div>
</div>


<div class="row collapse">
	<div class="small-24 columns">
		<div id="main-container" style="padding:1.2rem;">
			<table id="fijos" class="campanas hover stripe cell-border order-column">
				<thead>
					<tr>
						<th width="60"></th>
						<th width="250">Datos</th>
						<th width="90" class="text-center">Precio</th>
						<th width="90" class="text-center">Vendido</th>
						<th width="120">Estatus</th>
						<th class="text-right">Acciones</th>
					</tr>
				</thead>
			<tbody>

			</tbody>
		</table>
	</div>
</div>
