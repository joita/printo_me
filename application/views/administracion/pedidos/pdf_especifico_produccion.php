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
							<td>No. del pedido:</td>
							<th><?php echo str_pad($pedido->id_pedido, 8, "0", STR_PAD_LEFT); ?></th>
						</tr>
						<tr>
							<td>Fecha del pedido:</td>
							<th><?php echo date("d/m/Y H:i:s", strtotime($pedido->fecha_pago)); ?></th>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<?php foreach($info_pedido['customs'] as $indice_custom => $custom): ?>
	<fieldset id="pedido" style="page-break-after: always;">
		<legend>Producto <?php echo $indice_custom+1; ?> "<?php echo $custom->nombre_producto?>"</legend>

		<table cellpadding="6" cellspacing="1" width="100%" border="0" id="carrito">
			<tbody>
				<tr>
					<td width="76%" valign="top">
						<table cellpadding="0" cellspacing="0" width="100%" border="0">
							<tr>
								<td width="50%" align="center" valign="top">
									<img src="<?php echo APPPATH. '../public/'.$custom->diseno->images->front; ?>" style="width:6cm;border: solid 1px #777;" alt="" /><br>
                                    <?php $i = 0; ?>
                                    <?php foreach($custom->diseno->colores->front as $incolor => $col): ?>
                                    <?php if($i % 4 == 0 && $i > 0) { echo '<br>'; $i = 0; } ?>
                                    <?php $this->imger->cuadrado($col, 14, 14); ?>
                                    <?php $i++; ?>
                                    <?php endforeach; ?>
								</td>
								<td width="50%" align="center" valign="top">
									<?php if($custom->diseno->images->back != ''): ?>
									<img src="<?php echo APPPATH. '../public/'.$custom->diseno->images->back; ?>" style="width:6cm;border: solid 1px #777;" alt="" /><br>
                                    <?php $i = 0; ?>
                                    <?php foreach($custom->diseno->colores->back as $incolor => $col): ?>
                                    <?php if($i % 4 == 0 && $i > 0) { echo '<br>'; $i = 0; } ?>
                                    <?php $this->imger->cuadrado($col, 14, 14); ?>
                                    <?php $i++; ?>
                                    <?php endforeach; ?>
									<?php endif; ?>
								</td>
							</tr>

							<tr>
                                <?php if(isset($custom->diseno->images->left)): ?>
								<td width="50%" align="center" valign="top">
									<?php if($custom->diseno->images->left != ''): ?>
									<img src="<?php echo APPPATH. '../public/'.$custom->diseno->images->left; ?>" style="width:6cm;border: solid 1px #777;" alt="" /><br>
                                    <?php $i = 0; ?>
                                    <?php foreach($custom->diseno->colores->left as $incolor => $col): ?>
                                    <?php if($i % 4 == 0 && $i > 0) { echo '<br>'; $i = 0; } ?>
                                    <?php $this->imger->cuadrado($col, 14, 14); ?>
                                    <?php $i++; ?>
                                    <?php endforeach; ?>
									<?php endif; ?>
								</td>
                                <?php endif; ?>
                                <?php if(isset($custom->diseno->images->right)): ?>
								<td width="50%" align="center" valign="top">
								<?php if($custom->diseno->images->right != ''): ?>
									<img src="<?php echo APPPATH. '../public/'.$custom->diseno->images->right; ?>" style="width:6cm;border:solid 1px #777;" alt="" /><br>
                                    <?php $i = 0; ?>
                                    <?php foreach($custom->diseno->colores->right as $incolor => $col): ?>
                                    <?php if($i % 4 == 0 && $i > 0) { echo '<br>'; $i = 0; } ?>
                                    <?php $this->imger->cuadrado($col, 14, 14); ?>
                                    <?php $i++; ?>
                                    <?php endforeach; ?>
									<?php endif; ?>
								</td>
                                <?php endif; ?>
							</tr>
						</table>
					</td>
					<td width="24%" valign="top">
						<table cellpadding="6" cellspacing="1" width="100%" border="0">
							<thead>
								<tr>
									<th colspan="2">Tallas a producir</th>
								</tr>
								<tr>
									<th width="42%">Cantidad</th>
									<th width="58%">Talla</th>
								</tr>
								<?php foreach($custom->tallas as $inner_producto): ?>
								<tr>
									<td align="center"><?php echo $inner_producto->cantidad; ?></td>
									<td align="center"><?php echo $inner_producto->talla['talla']; ?></td>
								</tr>
								<?php endforeach; ?>
							</thead>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</fieldset>
	<?php endforeach; ?>

	<?php foreach($info_pedido['inmediatas'] as $indice_inmediato => $inmediato): ?>
	<?php $enhance = $this->enhance_modelo->obtener_enhance($inmediato->id_enhance); ?>
	<fieldset id="pedido" style="page-break-after: always;">
		<legend>Venta inmediata <?php echo $indice_inmediato+1; ?> "<?php echo $inmediato->tallas[0]->nombre_producto?>"</legend>

		<table cellpadding="6" cellspacing="1" width="100%" border="0" id="carrito">
			<tbody>
				<tr>
					<td width="76%" valign="top">
						<table cellpadding="0" cellspacing="0" width="100%" border="0">
							<tr>
								<td width="50%" align="center">
									<img src="<?php echo APPPATH. '../public/'.$enhance->front_image; ?>" style="width:6cm;border: solid 1px #777;" alt="" />
								</td>
								<td width="50%" align="center">
									<?php if($enhance->back_image != ''): ?>
									<img src="<?php echo APPPATH. '../public/'.$enhance->back_image; ?>" style="width:6cm;border: solid 1px #777;" alt="" />
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<td width="50%" align="center">
									<?php if($enhance->left_image != ''): ?>
									<img src="<?php echo APPPATH. '../public/'.$enhance->left_image; ?>" style="width:6cm;border: solid 1px #777;" alt="" />
									<?php endif; ?>
								</td>
								<td width="50%" align="center">
									<?php if($enhance->right_image != ''): ?>
									<img src="<?php echo APPPATH. '../public/'.$enhance->right_image; ?>" style="width:6cm;border:solid 1px #777;" alt="" />
									<?php endif; ?>
								</td>
							</tr>
						</table>
					</td>
					<td width="24%" valign="top">
						<table cellpadding="6" cellspacing="1" width="100%" border="0">
							<thead>
								<tr>
									<th colspan="2">Tallas a producir</th>
								</tr>
								<tr>
									<th width="42%">Cantidad</th>
									<th width="58%">Talla</th>
								</tr>
								<?php foreach($inmediato->tallas as $inner_producto): ?>
								<tr>
									<td align="center"><?php echo $inner_producto->cantidad; ?></td>
									<td align="center"><?php echo $inner_producto->talla['talla']; ?></td>
								</tr>
								<?php endforeach; ?>
							</thead>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</fieldset>
	<?php endforeach; ?>

</body>
</html>
