<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Devoluciones</h2>
	</div>
</div>
<?php if(isset($devoluciones)): ?>
	<div class="row">
		<div class="small-24 columns" id="subnav-productos">
			<table width="100%">
				<thead>
					<tr>	
						<th>#</th>
						<th>Cliente</th>
						<th>Fecha</th>
						<th>Estatus Devolucion</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php if(sizeof($devoluciones)>0): ?>
					<?php foreach($devoluciones as $devolucion): ?>
					<tr>
						<td><?php echo $devolucion->id_devolucion; ?> </td>
						<td><?php echo $devolucion->nombres.' '.$devolucion->apellidos; ?> </td>
						<td><?php echo date("d/m/Y", strtotime($devolucion->fecha_creacion)); ?> </td>
						<td><?php echo ($devolucion->estatus == "0") ? "Pendiente" : (($devolucion->estatus == "1") ? "Aprobada" : "Rechazada"); ?></td>
						<td><a href="<?php echo site_url('administracion/devoluciones/'.$devolucion->id_devolucion); ?>"><i class="fa fa-search"></i> Ver devolucion</a></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

<?php else: ?>
	<p class="text-center" style="line-height:13;">Sin devoluciones.</p>
<?php endif; ?>