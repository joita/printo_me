<legend>Inventario completo</legend>
<a href="<?php echo site_url('administracion/reportes/completo_pdf'); ?>" target="_blank" class="alert fieldadd button"><i class="fa fa-file-pdf-o"></i> Generar PDF</a>

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
	<?php if(sizeof($minimos) > 0): ?>
	<?php foreach($minimos as $minimo): ?>
		<tr>
			<td><img src="<?php echo site_url('assets/images/productos/producto'.$minimo->id_producto.'/'.$minimo->fotografia_icono); ?>" width="64" height="64" /></td>
			<td style="vertical-align: middle;padding-left: 10px;"><strong><?php echo $minimo->sku; ?></strong><br />Talla: <strong><?php echo $minimo->caracteristicas->talla; ?></strong>, Color: <strong><?php echo $minimo->nombre_color; ?></strong></td>
			<td style="vertical-align: middle;text-align:center;"><strong<?php echo ($minimo->cantidad_inicial == 0 ? ' style="color:red;"' : ''); ?>><?php echo $minimo->cantidad_inicial; ?></strong></td>
			<td style="vertical-align: middle;text-align:center;"><?php echo $minimo->cantidad_minima; ?></td>
		</tr>
	<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="4" class="text-center">No hay productos debajo del mínimo.</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>
