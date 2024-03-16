<table width="300" style="padding:0;margin:0;border: solid 1px #0a749d;border-radius:3px;width: 100%;max-width: 500px;font-family: Verdana;background-image: url(<?php echo site_url('assets/images/agua.png'); ?>);background-position: -160px;background-repeat: no-repeat;">
  <tr>
    <th style="text-align:center;">
      <img src="<?php echo site_url('assets/images/header-logo.png'); ?>" width="150" height="43" alt="printome.mx" style="margin:15px auto" />
    </th>
  </tr>
  <tr>
    <td>
      <div style="padding: 10px 15px;">
        <p style="font-size:13px;text-align:justify;">Hola <?php echo $nombre; ?>,</p>
        <p style="font-size:13px;text-align:justify;">Tu campaña "<strong><?php echo $nombre_campana; ?></strong>" ha finalizado. Te presentamos el reporte de resultados:</p>
        <p style="font-size:13px;text-align:justify;">Precio de venta: <?php echo $precio; ?></p>
        <p style="font-size:13px;text-align:justify;">Meta de venta: <?php echo $meta; ?></p>
        <p style="font-size:13px;text-align:justify;">Vendido: <?php echo $vendido; ?></p>
		<?php if($vendido == 0): ?>
		<p style="font-size:13px;text-align:justify;">Tu campaña no logró realizar ventas, si quieres volver a empezar la campaña por favor comunícate con nosotros al correo administracion@printome.mx para definir como procederemos.</p>
		<?php elseif($vendido < $meta && $vendido > 0): ?>
		<p style="font-size:13px;text-align:justify;">Tu campaña vendió menos de lo que planeaste originalmente, si quieres proceder con la campaña o cancelarla por favor comunícate con nosotros al correo administracion@printome.mx para definir como procederemos.</p>
		<?php else: ?>
		<p style="font-size:13px;text-align:justify;">Tu campaña <?php if($meta == $vendido) { echo 'alcanzó'; } else { echo 'superó'; } ?> la meta planteada. Procederemos a elaborar los productos finales y enviarlos a sus respectivos compradores.</p>
		<p style="font-size:13px;text-align:justify;">Si tienes alguna duda por favor comunícate con nosotros a administracion@printome.mx.</p>
		<?php endif; ?>
        <p style="font-size:13px;text-align:justify;color:#fa4c06;"></p>
		<p><a href="<?php echo base_url(); ?>" target="_blank" style="color:#055a7a;text-decoration:underline;font-size:13px;">https://printome.mx</a></p>
      </div>
    </td>
  </tr>
</table>
