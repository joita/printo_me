<table width="300" style="padding:0;margin:0;border: solid 1px #0a749d;border-radius:3px;width: 100%;max-width: 500px;font-family: Verdana;background-image: url(<?php echo site_url('assets/images/agua.png'); ?>);background-position: -160px;background-repeat: no-repeat;">
  <tr>
    <th style="text-align:center;">
      <img src="<?php echo site_url('assets/images/header-logo.png'); ?>" width="150" height="43" alt="printome.mx" style="margin:15px auto" />
    </th>
	</tr>
	<tr>
		<td>
			<h3 style="text-align: center;margin: 0;line-height: 2;padding-top: 10px;font-weight: normal;">¡Tu pedido va en camino!</h3>
			<div style="padding: 10px 15px;">
				<p style="font-size:13px;text-align:justify;">Hola, <?php echo $nombre; ?>,</p>
				<p style="font-size:13px;text-align:justify;">Nos complace informarte que tu pedido <strong>No. <?php echo $numero_pedido; ?></strong> por un total de $ <?php echo number_format($total_pedido, 2, ".", ","); ?> ha sido enviado vía DHL con código de rastreo <a href="<?php echo site_url('carrito/abrir_dhl/'.$numero_pedido_corto); ?>" target="_blank"><?php echo $codigo_rastreo; ?></a>.</p>
				<p style="font-size:13px;text-align:justify;"><a href="<?php echo site_url('carrito/abrir_dhl/'.$numero_pedido_corto); ?>" style="display:inline-block;background:#fa4b06;color:#FFF;text-decoration:none;padding:5px 15px;border-radius:4px;" target="_blank">Rastrear Pedido</a>.</p>
				<p style="font-size:13px;text-align:justify;">¡Gracias por comprar con nosotros!</p>
				<p><a href="<?php echo base_url(); ?>" target="_blank" style="text-decoration:underline;font-size:13px;">https://printome.mx</a></p>
			</div>
		</td>
	</tr>
</table>