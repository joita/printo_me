<legend>Existencias</legend>
<a href="<?php echo site_url('administracion/reportes/minimos_pdf'); ?>" target="_blank" class="alert fieldadd button"><i class="fa fa-file-pdf-o"></i> Generar PDF</a>

<table cellpadding="0" cellspacing="0" id="carrito" class="tabla-pedidos">
	<thead>
		<tr>
			<th width="15%" class="cantidades-carrito text-center"></th>
			<th class="text-left titulo-precio">SKU Producto</th>
			<th width="20%" class="text-center prec-esp titulo-precio">Cantidad actual</th>
			<th width="20%" class="text-center titulo-precio">Cantidad mínima</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($existencias as $existencia): ?>
		<tr>
			<td><img src="<?php echo site_url('assets/images/productos/producto'.$existencia->id_producto.'/'.$existencia->fotografia_icono); ?>" width="64" height="64" /></td>
			<td style="vertical-align: middle;padding-left: 10px;"><strong><?php echo $existencia->sku; ?></strong><br />Talla: <strong><?php echo $existencia->caracteristicas->talla; ?></strong>, Color: <strong><?php echo $existencia->nombre_color; ?></strong></td>
			<td style="vertical-align: middle;text-align:center;"><strong<?php echo ($existencia->cantidad_inicial == 0 ? ' style="color:red;"' : ''); ?>><?php echo $existencia->cantidad_inicial; ?></strong></td>
			<td style="vertical-align: middle;text-align:center;"><?php echo $existencia->cantidad_minima; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
