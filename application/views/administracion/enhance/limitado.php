<div class="row collapse">
	<div class="small-24 columns">
		<ul class="tab-menu">
			<li class="tab-title<?php activar_alt('activos', $estatus_activo); ?>"><a href="<?php echo site_url('administracion/campanas/limitado'); ?>"><i class="fa fa-asterisk"></i> Activos <small class="cn"><?php echo $productos['activos']; ?></small></a></li>
			<li class="tab-title<?php activar_alt('aprobar', $estatus_activo); ?>"><a href="<?php echo site_url('administracion/campanas/limitado/aprobar'); ?>"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Por aprobar <small class="cn"><?php echo $productos['aprobar']; ?></small></a></li>
			<li class="tab-title<?php activar_alt('pagar', $estatus_activo); ?>"><a href="<?php echo site_url('administracion/campanas/limitado/pagar'); ?>"><i class="fa fa-credit-card-alt"></i> Por pagar <small class="cn"><?php echo $productos['pagar']; ?></small></a></li>
			<li class="tab-title<?php activar_alt('pagados', $estatus_activo); ?>"><a href="<?php echo site_url('administracion/campanas/limitado/pagados'); ?>"><i class="fa fa-check"></i> Pagados <small class="cn"><?php echo $productos['pagados']; ?></small></a></li>
			<li class="tab-title<?php activar_alt('ceros', $estatus_activo); ?>"><a href="<?php echo site_url('administracion/campanas/limitado/ceros'); ?>"><i class="fa fa-thermometer-empty"></i> No vendieron <small class="cn"><?php echo $productos['ceros']; ?></small></a></li>
			<li class="tab-title<?php activar_alt('negativos', $estatus_activo); ?>"><a href="<?php echo site_url('administracion/campanas/limitado/negativos'); ?>"><i class="fa fa-minus"></i> Negativos <small class="cn"><?php echo $productos['negativos']; ?></small></a></li>
			<li class="tab-title<?php activar_alt('rechazados', $estatus_activo); ?>"><a href="<?php echo site_url('administracion/campanas/limitado/rechazados'); ?>"><i class="fa fa-times"></i> Rechazados <small class="cn"><?php echo $productos['rechazados']; ?></small></a></li>
		</ul>
	</div>
</div>

<div class="row collapse">
	<div class="small-24 columns">
		<div id="main-container" style="padding:1.2rem;">
			<table id="limitados" class="campanas hover stripe cell-border order-column">
				<thead>
					<tr>
						<th width="60"></th>
						<th width="200">Datos</th>
						<th width="50" class="text-center">Precio</th>
						<th width="50" class="text-center">Vendido</th>
						<th width="50" class="text-center">Meta</th>
						<th width="50" class="text-center">% Meta</th>
						<th width="90" class="text-center">Quedan (días)</th>
						<th class="text-right">Acciones</th>
					</tr>
				</thead>
				<tbody>

                <?php /*
				<?php foreach($productos[$estatus_activo] as $campana): ?>
				<?php
					$images = array();
					$des = json_decode($campana->design);
					foreach($des as $nombre_lado=>$lado) {
						$images[$nombre_lado] = array();
						foreach($lado as $indice=>$inner_lado) {
							unset($lado[$indice]->svg);
							if(isset($lado[$indice]->url)) {
								array_push($images[$nombre_lado], $lado[$indice]->url);
							}
						}
					}
					$img_json = json_encode($images);
				?>
					<tr>
						<td>
							<span class="hide"><?php echo $campana->id_enhance; ?></span>
							<ul class="small-block-grid-2 precamp">
								<?php if(isset($campana->front_image)): ?><li><img src="<?php echo site_url('image-tool/index.php?src='.site_url($campana->front_image)); ?>&w=30&h=30" class="smmmimg" /></li><?php endif; ?>
								<?php if(isset($campana->back_image)): ?><li><img src="<?php echo site_url('image-tool/index.php?src='.site_url($campana->back_image)); ?>&w=30&h=30" class="smmmimg" /></li><?php endif; ?>
								<?php if(isset($campana->right_image)): ?><li><img src="<?php echo site_url('image-tool/index.php?src='.site_url($campana->right_image)); ?>&w=30&h=30" class="smmmimg" /></li><?php endif; ?>
								<?php if(isset($campana->left_image)): ?><li><img src="<?php echo site_url('image-tool/index.php?src='.site_url($campana->left_image)); ?>&w=30&h=30" class="smmmimg" /></li><?php endif; ?>
							</ul>
						</td>
						<td>
							<em>Folio:</em> <strong><?php echo $campana->id_enhance; ?></strong><br />
							<em>Campaña:</em> <strong><?php echo $campana->name; ?></strong><br />
							<em>Fecha de finalización:</em> <strong><?php echo date("d/m/Y", strtotime($campana->end_date)); ?></strong><br />
							<em>Vendedor:</em> <strong><?php echo $campana->nombres.' '.$campana->apellidos; ?></strong>
						</td>
						<td class="text-center">$<?php echo $this->cart->format_number($campana->price); ?></td>
						<td class="text-center"><?php echo $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance); ?></td>
						<td class="text-center"><?php echo $campana->quantity; ?></td>
						<td class="text-center"><?php echo number_format(($this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance)/$campana->quantity)*100, 2); ?>%</td>
						<td class="text-center">
							<?php if(!$campana->estatus): ?>
							<em>Pendiente por revisar</em>
							<?php elseif($campana->estatus == 2): ?>
							<i class="fa fa-times"></i> Rechazado
							<?php elseif($campana->estatus == 3): ?>
							<i class="fa fa-ban"></i> Terminado por printome.mx
							<?php else: ?>
								<?php $time_restante = strtotime($campana->end_date)-time(); ?>
								<?php if($time_restante < 0): ?>
									<?php echo '<i class="fa fa-check"></i> Finalizado'; ?>
								<?php else: ?>
									<?php echo round((($time_restante/24)/60)/60); ?>
								<?php endif; ?>
							<?php endif; ?>
						</td>
						<td class="text-right"><a href="<?php echo site_url('administracion/campanas/limitado/editar/'.$campana->id_enhance); ?><?php if($estatus_activo == 'pagar' || $estatus_activo == 'pagado') { echo '#fndtn-info_pagos'; } ?>" class="action button"><i class="fa fa-eye"></i> Revisar</a></td>
					</tr>
				<?php endforeach; ?>
                <?php */ ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
