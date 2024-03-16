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
							<th>Ventas</th>
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


	<table cellpadding="0" cellspacing="0" class="tabla-pedidos" id="carrito" style="width:100%;">
		<tr>
			<th width="36.2%" rowspan="2" style="vertical-align:bottom;">Datos del reporte</th>
			<th width="15%" class="text-center">Fecha inicio</td>
			<th width="15%" class="text-center">Fecha final</td>
			<th width="15%" class="text-center">Métodos de pago</td>
		</tr>
		<tr>
			<td width="15%" style="text-align:center;"><?php echo $fecha_inicio; ?></td>
			<td width="15%" style="text-align:center;"><?php echo $fecha_final; ?></td>
			<td width="15%" style="text-align:center;">
			<?php if($metodo_de_pago == 'todos') { echo 'Todos'; }
			else if($metodo_de_pago == 'card_payment') { echo 'Tarjeta'; }
			else if($metodo_de_pago == 'cash_payment') { echo 'OXXO'; }
			else if($metodo_de_pago == 'paypal') { echo 'PayPal'; }
			else if($metodo_de_pago == 'spei') { echo 'SPEI'; }
			else if($metodo_de_pago == 'PPP') { echo 'PayPalPlus'; }
			?>
			</td>
		</tr>
	</table>

	<table cellpadding="0" cellspacing="0" class="tabla-pedidos" id="carrito" style="width:100%;">
		<tr>
			<th width="36.2%" rowspan="2" style="vertical-align:bottom;">Número de ventas en período</th>
			<th width="15%" class="text-center">Total</td>
			<th width="15%" class="text-center">Pagadas</td>
			<th width="15%" class="text-center">Pendientes</td>
			<th width="15%" class="text-center">Canceladas</td>
		</tr>
		<tr>
			<td width="15%" style="text-align:center;"><?php echo $reporte->numero_pedidos; ?></td>
			<td width="15%" style="text-align:center;"><?php echo $reporte->numero_pedidos_pagados; ?></td>
			<td width="15%" style="text-align:center;"><?php echo $reporte->numero_pedidos_pendientes; ?></td>
			<td width="15%" style="text-align:center;"><?php echo $reporte->numero_pedidos_cancelados; ?></td>
		</tr>
	</table>

	<?php if($metodo_de_pago == 'todos'): ?>
    <table cellpadding="0" cellspacing="0" class="tabla-pedidos" id="carrito" style="width:100%;">
		<tr>
			<th width="24.2%" rowspan="6" style="vertical-align:middle;">Número de ventas por método de pago</th>
			<th width="6.66%" class="text-center">Tarjeta</td>
			<th width="6.66%" class="text-center">PayPal</td>
            <th width="6.66%" class="text-center">PayPalPlus</th>
		</tr>
		<tr>
			<td width="10%" style="text-align:center;"><?php echo $reporte->pedidos_tarjeta; ?></td>
			<td width="10%" style="text-align:center;"><?php echo $reporte->pedidos_paypal; ?></td>
            <td width="10%" style="text-align:center;"><?php echo $reporte->pedidos_ppp; ?></td>
		</tr>
        <tr>
			<th width="10%" class="text-center">OXXO Pagadas</td>
			<th width="10%" class="text-center">OXXO Pendientes</td>
        </tr>
        <tr>
            <td width="15%" style="text-align:center;"><?php echo $reporte->pedidos_oxxo_pagados; ?></td>
            <td width="15%" style="text-align:center;"><?php echo $reporte->pedidos_oxxo_pendientes; ?></td>
        </tr>
        <tr>
            <th width="10%" class="text-center">SPEI Pagadas</td>
			<th width="10%" class="text-center">SPEI Pendientes</td>
        </tr>
        <tr>
            <td width="15%" style="text-align:center;"><?php echo $reporte->pedidos_spei_pagados; ?></td>
            <td width="15%" style="text-align:center;"><?php echo $reporte->pedidos_spei_pendientes; ?></td>
        </tr>
	</table>
	<?php endif; ?>

    <table cellpadding="0" cellspacing="0" class="tabla-pedidos" id="carrito" style="width:100%;">
        <tr>
            <th width="31.4%" rowspan="2" style="vertical-align:bottom;">Monto de ventas <strong><u>pagadas</u></strong></th>
            <th width="15%" style="text-align:center;">Total</td>
            <th width="15%" style="text-align:center;">Promedio</td>
            <th width="15%" style="text-align:center;">Mínima</td>
            <th width="15%" style="text-align:center;">Máxima</td>
        </tr>
        <tr>
            <td width="15%" style="text-align:center;">$<?php echo $this->cart->format_number($reporte->montos->venta_total); ?></td>
            <td width="15%" style="text-align:center;">$<?php echo $this->cart->format_number($reporte->montos->promedio); ?></td>
            <td width="15%" style="text-align:center;">$<?php echo $this->cart->format_number($reporte->montos->minimo); ?></td>
            <td width="15%" style="text-align:center;">$<?php echo $this->cart->format_number($reporte->montos->maximo); ?></td>
        </tr>
    </table>

    <table cellpadding="0" cellspacing="0" class="tabla-pedidos" id="carrito" style="width:100%;">
        <tr>
            <th width="31.4%" rowspan="2" style="vertical-align:bottom;">Clientes nuevos vs. recurrentes</th>
            <th width="27%" class="text-center">Nuevos</td>
            <th width="27%" class="text-center">Recurrentes</td>
        </tr>
        <tr>
            <td width="27%" style="text-align:center;"><?php echo $reporte->nuevos; ?></td>
            <td width="27%" style="text-align:center;"><?php echo $reporte->recurrentes; ?></td>
        </tr>
    </table>


	<table cellpadding="0" cellspacing="0" class="tabla-pedidos" id="carrito" width="100%">
        <tr>
            <th width="28.4%" rowspan="2" style="vertical-align:bottom;">Saldo de pagos a diseñadores</th>
			<th width="18%" style="text-align:center;">Total ventas</td>
			<th width="18%" style="text-align:center;">Pagado a diseñadores</td>
			<th width="18%" style="text-align:center;">Saldo</td>
        </tr>
        <tr>
            <td style="text-align:center;">$<?php echo $this->cart->format_number($reporte->montos->venta_total); ?></td>
            <td style="text-align:center;">$<?php echo $this->cart->format_number($reporte->ganancias_disenadores); ?></td>
            <td style="text-align:center;">$<?php echo $this->cart->format_number($reporte->montos->venta_total-$reporte->ganancias_disenadores); ?></td>
        </tr>
    </table>

    <table cellpadding="0" cellspacing="0" class="tabla-pedidos" id="carrito" width="100%">
        <tr>
            <th colspan="2" width="31.4%" rowspan="2" style="vertical-align:bottom;">Monto de ventas pendientes por pagar</th>
            <th style="text-align:center;">Total</td>
        </tr>
        <tr>
            <td colspan="1" width="15%" style="text-align:center;color:red;">$<?php echo $this->cart->format_number($reporte->venta_total_pendiente); ?></td>
        </tr>
    </table>

	<table cellpadding="0" cellspacing="0" class="tabla-pedidos" id="carrito" style="width:100%;">
		<tr>
			<th width="36.2%" rowspan="2" style="vertical-align:bottom;">Monto de ventas</th>
			<th width="15%" class="text-center">Total</td>
			<th width="15%" class="text-center">Promedio</td>
			<th width="15%" class="text-center">Mínima</td>
			<th width="15%" class="text-center">Máxima</td>
		</tr>
		<tr>
			<td width="15%" style="text-align:center;">$<?php echo $this->cart->format_number($reporte->montos->venta_total); ?></td>
			<td width="15%" style="text-align:center;">$<?php echo $this->cart->format_number($reporte->montos->promedio); ?></td>
			<td width="15%" style="text-align:center;">$<?php echo $this->cart->format_number($reporte->montos->minimo); ?></td>
			<td width="15%" style="text-align:center;">$<?php echo $this->cart->format_number($reporte->montos->maximo); ?></td>
		</tr>
	</table>

	<table cellpadding="0" cellspacing="0" class="tabla-pedidos" id="carrito" style="width:100%;">
		<tr>
			<th colspan="2" class="text-center">Los SKUs más vendidos en el período (productos custom)</th>
		<tr>
			<th width="60%" style="text-align:center;">SKU</th>
			<th width="40%" style="text-align:center;">Productos vendidos</th>
		</tr>
		<?php foreach($reporte->cinco_skus as $sku_venta): ?>
		<tr>
			<th style="text-align:center;"><?php echo $sku_venta->sku.' (Talla: '.$sku_venta->caracteristicas->talla.')'; ?></th>
			<td style="text-align:center;"><?php echo $sku_venta->vendidos; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>

	<table cellpadding="0" cellspacing="0" class="tabla-pedidos" id="carrito" style="width:100%;">
		<tr>
			<th colspan="2" class="text-center">Los diseños más vendidos en el período (productos fijos)</th>
		<tr>
			<th width="60%" class="text-center">Nombre del producto</th>
			<th width="40%" class="text-center">Productos vendidos</th>
		</tr>
		<?php foreach($reporte->cinco_productos as $producto): ?>
		<tr>
			<th style="text-align:center;"><?php echo $producto->name; ?></th>
			<td style="text-align:center;"><?php echo $this->enhance_modelo->obtener_total_vendidos_por_campana($producto->id_enhance); ?></td>
		</tr>
		<?php endforeach; ?>
	</table>

</body>
</html>
