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
        <p style="font-size:13px;text-align:justify;">Te queremos dar la bienvenida a printome.mx y esperamos que tengas una excelente experiencia de compras por internet. Para cualquier duda nos puedes contactar vía chat o correo electrónico <a href="mailto:atencion@printome.mx" style="color:#fa4c06">atencion@printome.mx</a>.</p>
		<p style="font-size:13px;text-align:justify;">Puedes acceder a <a href="<?php echo base_url(); ?>" target="_blank" style="color:#fa4c06;text-decoration:underline;font-size:13px;">printome.mx</a> usando las siguientes credenciales</p>
		<p style="font-size:13px;text-align:justify;">Usuario: <?php echo $email; ?></p>
		<p style="font-size:13px;text-align:justify;">Contraseña: <?php echo $contra; ?></p>
        <p style="font-size:13px;text-align:justify;color:#fa4c06;"></p>
		<p><a href="<?php echo base_url(); ?>" target="_blank" style="color:#055a7a;text-decoration:underline;font-size:13px;">https://printome.mx</a></p>
      </div>
    </td>
  </tr>
</table>