<table width="300" style="padding:0;margin:0;border: solid 1px #0a749d;border-radius:3px;width: 100%;max-width: 500px;font-family: Verdana;background-image: url(<?php echo site_url('assets/images/agua.png'); ?>);background-position: -160px;background-repeat: no-repeat;">
  <tr>
    <th style="text-align:center;">
      <img src="<?php echo site_url('assets/images/header-logo.png'); ?>" width="150" height="43" alt="printome.mx" style="margin:15px auto" />
    </th>
	</tr>
	<tr>
		<td>
			<h3 style="text-align: center;margin: 0;line-height: 2;padding-top: 10px;font-weight: normal;">Confirmación de pago en OXXO</h3>
			<div style="padding: 10px 15px;">
				<p style="font-size:13px;text-align:justify;">Hola, <?php echo $nombre; ?>,</p>
				<p style="font-size:13px;text-align:justify;">Hemos recibido tu pago en OXXO para el pedido <strong>No. <?php echo $numero_pedido; ?></strong> por un total de $ <?php echo number_format($total_pedido, 2, ".", ","); ?>. Vamos a preparar tus productos para enviar y apenas salga el envío te vamos a enviar el código de rastreo a tu correo electrónico.</p>
				<p style="font-size:13px;text-align:justify;">¡Gracias por comprar con nosotros!</p>
				<p><a href="<?php echo base_url(); ?>" target="_blank" style="text-decoration:underline;font-size:13px;">https://printome.mx</a></p>
			</div>
		</td>
	</tr>
</table>