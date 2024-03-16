<table width="300" style="padding:0;margin:0;border: solid 1px #0a749d;border-radius:3px;width: 100%;max-width: 500px;font-family: Verdana;background-image: url(<?php echo site_url('assets/images/agua.png'); ?>);background-position: -160px;background-repeat: no-repeat;">
  <tr>
    <th style="text-align:center;">
      <img src="<?php echo site_url('assets/images/header-logo.png'); ?>" width="150" height="43" alt="printome.mx" style="margin:15px auto" />
    </th>
	</tr>
	<tr>
		<td>
			<h3 style="text-align: center;margin: 0;line-height: 2;padding-top: 10px;font-weight: normal;color: #fa4c06;">Activación de cuenta</h3>
			<div style="padding: 10px 15px;">
				<p style="font-size:13px;text-align:justify;">Hola, <?php echo $nombre; ?>,</p>
				<p style="font-size:13px;text-align:justify;">Puedes verificar tu cuenta haciendo clic en el siguiente botón.</p>
				<p style="font-size:13px;text-align:justify;"><a href="<?php echo site_url('verificar-cuenta/'.$codigo_activacion); ?>" style="display:inline-block;background:#5EF17C;color:#FFF;text-decoration:none;padding:5px 15px;border-radius:4px;" target="_blank">Verificar Cuenta</a></p>
				<p style="font-size:13px;text-align:justify;color:#fa4c06;"></p>
				<p><a href="<?php echo base_url(); ?>" target="_blank" style="color:#fa4c06;text-decoration:underline;font-size:13px;">https://printome.mx</a></p>
			</div>
		</td>
	</tr>
</table>