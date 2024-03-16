<table width="300" style="padding:0;margin:0;border: solid 1px #0a749d;border-radius:3px;width: 100%;max-width: 500px;font-family: Verdana;background-image: url(<?php echo site_url('assets/images/agua.png'); ?>);background-position: -160px;background-repeat: no-repeat;">
  <tr>
    <th style="text-align:center;">
      <img src="<?php echo site_url('assets/images/header-logo.png'); ?>" width="150" height="43" alt="printome.mx" style="margin:15px auto" />
    </th>
	</tr>
	<tr>
		<td>
			<h3 style="text-align: center;margin: 0;line-height: 2;padding-top: 10px;font-weight: normal;">Ficha de pago en OXXO</h3>
			<div style="padding: 10px 15px;">
				<p style="font-size:13px;text-align:justify;">Hola, <?php echo $nombre; ?>,</p>
				<p style="font-size:13px;text-align:justify;">Tu orden <strong>No. <?php echo $numero_pedido; ?></strong> por un total de $ <?php echo number_format($total_pedido, 2, ".", ","); ?> ha sido confirmada. Para que nuestro equipo la empiece a procesar necesitarás realizar el pago en OXXO. A continuación te enviamos el código de barras con el que puedes realizar el pago en tu OXXO más cercano.</p>
				<p style="font-size:13px;text-align:justify;">Puedes imprimir el correo con el código de barras o imprimir la ficha en PDF que viene como archivo adjunto en este correo.</p>
				<p style="text-align:center;padding: 15px 0;"><img src="<?php echo str_replace('http:', 'https:', $codigo_barras); ?>" alt="Código de barras" /></p>
				<p style="text-align:center;padding: 15px 0;"><?php echo $numero_barras; ?></p>
				<p style="font-size:13px;text-align:justify;">¡Gracias por comprar con nosotros!</p>
				<p><a href="<?php echo base_url(); ?>" target="_blank" style="text-decoration:underline;font-size:13px;">https://printome.mx</a></p>
			</div>
		</td>
	</tr>
</table>