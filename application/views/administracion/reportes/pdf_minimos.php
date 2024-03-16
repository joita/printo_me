<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css">
	<?php $this->load->view('carrito/estilos_pdf.css'); ?>
	</style>
</head>
<body>
	
	<div id="header">
		<table>
			<tr>
				<td><img src="<?php echo APPPATH. '../public/assets/images/header-logo-retina.png'; ?>" alt="" height="70"></td>
				<td style="text-align: right;">
					<table id="info">
						<tr>
							<td>Reporte:</td>
							<th>Existencias debajo del mínimo</th>
						</tr>
						<tr>
							<td>Fecha del reporte:</td>
							<th><?php echo date("d/m/Y H:i:s"); ?></th>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	
	<fieldset id="datos">
		<legend>Productos debajo del mínimo</legend>
		
		<table cellpadding="0" cellspacing="0" id="carrito" class="tabla-pedidos" style="width:100%;">
			<thead>
				<tr>
					<th width="15%" class="cantidades-carrito text-center"></th>
					<th class="text-left titulo-precio">SKU Producto</th>
					<th width="20%" class="text-center prec-esp titulo-precio">Cantidad actual</th>
					<th width="20%" class="text-center titulo-precio">Cantidad mínima</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($minimos as $minimo): ?>
				<tr>
					<td><img src="<?php echo APPPATH. '../public/assets/images/productos/producto'.$minimo->id_producto.'/'.$minimo->fotografia_icono; ?>" width="64" height="64" /></td>
					<td style="vertical-align: middle;padding-left: 10px;"><strong><?php echo $minimo->sku; ?></strong><br />Talla: <strong><?php echo $minimo->caracteristicas->talla; ?></strong>, Color: <strong><?php echo $minimo->nombre_color; ?></strong></td>
					<td style="vertical-align: middle;text-align:center;"><strong<?php echo ($minimo->cantidad_inicial == 0 ? ' style="color:red;"' : ''); ?>><?php echo $minimo->cantidad_inicial; ?></strong></td>
					<td style="vertical-align: middle;text-align:center;"><?php echo $minimo->cantidad_minima; ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</fieldset>

</body>
</html>
