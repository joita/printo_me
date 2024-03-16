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
	
	<fieldset id="datos">
		<legend>Datos del Cliente</legend>
		<table width="100%">
			<tr>
				<td width="50%" valign="top">
					<p>Nombre: <br><strong><?php echo $pedido->nombres . " " . $pedido->apellidos; ?></strong></p>
					<p>E-Mail: <br><strong><?php echo $pedido->email ?></strong></p>
				</td>
				<td width="50%" valign="top">
					<p>Monto a pagar: <br><strong>$<?php echo $this->cart->format_number($pedido->total); ?></strong></p>
					<p>Fecha límite de pago: <br><strong><?php echo date("d/m/Y H:i:s", $expiration); ?></strong></p>
				</td>
			</tr>
		</table>
	</fieldset>
	
	<fieldset id="info">
		<legend>Información sobre el pago</legend>
		<p>Puedes realizar tu pago en cualquier OXXO de la República Mexicana: hasta por $ 10,000 pesos de compra, con un cargo de $9.00 pesos de comisión en OXXO.</p>
		<p>Cuentas con 5 días para realizar el pago. Una vez realizado el pago, recibirás confirmación en un lapso de 24 a 72 horas y a partir de dicha confirmación se realizará el envío de tu pedido. Si requieres de un envío inmediato, te recomendamos pagar con tarjeta de crédito.</p>
		<p>Utiliza el siguiente codigo de barras para pagar en tu tienda OXXO más cercana:</p>
	
		<div style="text-align:center;margin-top:1cm;margin-bottom:1cm;">
			<img src="<?php echo $barcode ?>" alt="">
			<span style="display:block;text-align:center;"><?php echo $barcode_number; ?></span>
		</div>
	</fieldset>


</body>
</html>
