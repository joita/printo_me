<?php


?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
							<td>No. del producto:</td>
							<th><?php echo $campana->id_enhance; ?></th>
						</tr>
						<tr>
							<td>Generación de PDF:</td>
							<th><?php echo date("d/m/Y H:i:s"); ?></th>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<fieldset id="pedido" style="page-break-after: always;">
		<legend>Diseños en venta » <?php if($campana->type == 'limitado') { echo 'Plazo definido'; } else { echo 'Venta inmediata'; } ?> » <?php echo $campana->name; ?> (Folio: <?php echo $campana->id_enhance; ?>)</legend>

		<table cellpadding="6" cellspacing="1" width="100%" border="0" id="carrito">
			<tbody>
				<tr>
					<td width="76%" valign="top">
						<table cellpadding="0" cellspacing="0" width="100%" border="0">
							<tr>
								<td width="50%" align="center">
									<img src="<?php echo APPPATH. '../public/'.$campana->front_image; ?>" style="width:6cm;border: solid 1px #777;" alt="" />
								</td>
								<td width="50%" align="center">
									<?php if($campana->back_image != ''): ?>
									<img src="<?php echo APPPATH. '../public/'.$campana->back_image; ?>" style="width:6cm;border: solid 1px #777;" alt="" />
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<td width="50%" align="center">
									<?php if($campana->left_image != ''): ?>
									<img src="<?php echo APPPATH. '../public/'.$campana->left_image; ?>" style="width:6cm;border: solid 1px #777;" alt="" />
									<?php endif; ?>
								</td>
								<td width="50%" align="center">
									<?php if($campana->right_image != ''): ?>
									<img src="<?php echo APPPATH. '../public/'.$campana->right_image; ?>" style="width:6cm;border:solid 1px #777;" alt="" />
									<?php endif; ?>
								</td>
							</tr>
						</table>
					</td>
					<?php $vendidos = $this->enhance_modelo->obtener_tallas_vendidas_por_campana($campana->type, $campana->id_enhance); ?>
					<?php $producto = $this->catalogo_modelo->obtener_producto_con_id($campana->id_producto); ?>
					<?php $i = 0; ?>
					<?php $color = $this->db->get_where('ColoresPorProducto', array('id_color' => $campana->id_color))->row(); ?>
					<td width="24%" valign="top">
						<table cellpadding="6" cellspacing="1" width="100%" border="0">
							<thead>
								<tr>
									<th colspan="2">Producto base</th>
								</tr>
								<tr>
									<td colspan="2" style="text-align:center;"><?php echo $producto->modelo_producto; ?><?php echo $color->nombre_color; ?></td>
								</tr>
								<tr>
									<th colspan="2">Tallas a producir</th>
								</tr>
								<tr>
									<th width="42%">Talla</th>
									<th width="58%">Cantidad</th>
								</tr>
								<?php foreach($vendidos as $producto): ?>
								<tr>
									<td align="center"><?php echo caracteristicas_parse($producto->caracteristicas); ?></td>
									<td align="center"><?php echo $producto->total_vendido; ?></td>
								</tr>
								<?php $i += $producto->total_vendido; ?>
								<?php endforeach; ?>
								<tr>
									<th>Total</th>
									<td style="font-weight:bold;text-align:center;"><?php echo $i; ?></td>
								</tr>
							</thead>
						</table>
					</td>
				</tr>

			<?php foreach($campanas_adicionales as $indice_adicional=>$campana_adicional): ?>
				<?php $i = 0; ?>
				<?php $vendidos = $this->enhance_modelo->obtener_tallas_vendidas_por_campana($campana->type, $campana_adicional->id_enhance, true); ?>
				<?php $producto = $this->catalogo_modelo->obtener_producto_con_id($campana_adicional->id_producto); ?>
				<?php $color = $this->db->get_where('ColoresPorProducto', array('id_color' => $campana_adicional->id_color))->row(); ?>
				<tr>
					<td width="76%" valign="top">
						<table cellpadding="0" cellspacing="0" width="100%" border="0">
							<tr>
								<td width="50%" align="center">
									<img src="<?php echo APPPATH. '../public/'.$campana_adicional->front_image; ?>" style="width:6cm;border: solid 1px #777;" alt="" />
								</td>
								<td width="50%" align="center">
									<?php if($campana->back_image != ''): ?>
									<img src="<?php echo APPPATH. '../public/'.$campana_adicional->back_image; ?>" style="width:6cm;border: solid 1px #777;" alt="" />
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<td width="50%" align="center">
									<?php if($campana->left_image != ''): ?>
									<img src="<?php echo APPPATH. '../public/'.$campana_adicional->left_image; ?>" style="width:6cm;border: solid 1px #777;" alt="" />
									<?php endif; ?>
								</td>
								<td width="50%" align="center">
									<?php if($campana->right_image != ''): ?>
									<img src="<?php echo APPPATH. '../public/'.$campana_adicional->right_image; ?>" style="width:6cm;border:solid 1px #777;" alt="" />
									<?php endif; ?>
								</td>
							</tr>
						</table>
					</td>
					<td width="24%" valign="top">
						<table cellpadding="6" cellspacing="1" width="100%" border="0">
							<thead>
								<tr>
									<th colspan="2">Producto base</th>
								</tr>
								<tr>
									<td colspan="2" style="text-align:center;"><?php echo $producto->modelo_producto; ?><?php echo $color->nombre_color; ?></td>
								</tr>
								<tr>
									<th colspan="2">Tallas a producir</th>
								</tr>
								<tr>
									<th width="42%">Talla</th>
									<th width="58%">Cantidad</th>
								</tr>
								<?php foreach($vendidos as $producto): ?>
								<tr>
									<td align="center"><?php echo caracteristicas_parse($producto->caracteristicas); ?></td>
									<td align="center"><?php echo $producto->total_vendido; ?></td>
								</tr>
								<?php $i += $producto->total_vendido; ?>
								<?php endforeach; ?>
								<tr>
									<th>Total</th>
									<td style="font-weight:bold;text-align:center;"><?php echo $i; ?></td>
								</tr>
							</thead>
						</table>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</fieldset>

</body>
</html>
