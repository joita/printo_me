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
        <p style="font-size:13px;text-align:justify;">Te queremos dar la buena noticia de que tu campaña "<strong><?php echo $nombre_campana; ?></strong>" ha sido aprobada y ya está activa. Puedes compartir el siguiente vínculo para promover tu campaña en redes sociales:</p>
		<p style="font-size:13px;text-align:justify;"><a href="<?php echo $vinculo; ?>" style="color:#fa4c06"><?php echo $vinculo; ?></a></p>
		<p style="font-size:13px;text-align:justify;">Estate pendiente de las fechas de inicio y final de tu campaña:</p>
		<p style="font-size:13px;text-align:justify;">Fecha de inicio: <?php echo $fecha_inicio; ?></p>
		<p style="font-size:13px;text-align:justify;">Fecha final: <?php echo $fecha_final; ?></p>
		<p style="font-size:13px;text-align:justify;">Duración: <?php echo $dias; ?> días</p>
        <p style="font-size:13px;text-align:justify;color:#fa4c06;"></p>
		<p><a href="<?php echo base_url(); ?>" target="_blank" style="color:#055a7a;text-decoration:underline;font-size:13px;">https://printome.mx</a></p>
      </div>
    </td>
  </tr>
</table>