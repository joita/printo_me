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
        <p style="font-size:13px;text-align:justify;">Lo sentimos, pero tu campaña "<strong><?php echo $nombre_campana; ?></strong>" ha sido terminada por el equipo de printome.mx. El motivo de la terminación es el siguiente:</p>
        <p style="font-size:13px;text-align:justify;"><?php echo $motivo; ?></p>
		<p style="font-size:13px;text-align:justify;">Te recordamos que las campañas tienen que cumplir con los <a href="<?php echo site_url('terminos-y-condiciones'); ?>">términos y condiciones</a> de printome.mx.</p>
		<p style="font-size:13px;text-align:justify;">Si tienes alguna duda por favor comunícate con nosotros a administracion@printome.mx.</p>
        <p style="font-size:13px;text-align:justify;color:#fa4c06;"></p>
		<p><a href="<?php echo base_url(); ?>" target="_blank" style="color:#055a7a;text-decoration:underline;font-size:13px;">https://printome.mx</a></p>
      </div>
    </td>
  </tr>
</table>