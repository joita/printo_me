<table width="300" style="padding:0;margin:0;border:solid 1px #CCC;border-radius:3px;width: 100%;max-width: 500px;font-family: Verdana;">
	<tr>
		<th style="text-align:center;">
			<img src="<?php echo site_url('assets/images/header-logo.png'); ?>" width="150" height="43" alt="printome.mx" />
		</th>
	</tr>
	<tr>
		<td>
			<h3 style="text-align: center;margin: 0;line-height: 2;padding-top: 10px;font-weight: normal;color: #fa4c06;">Restablecer Contraseña</h3>
			<div style="padding: 10px 15px;">
				<p style="font-size:13px;text-align:justify;">Hola, <?php echo $nombre; ?>,</p>
				<p style="font-size:13px;text-align:justify;">Por favor haz clic en el siguiente vínculo para restablecer tu contraseña.</p>
				<p style="font-size:13px;text-align:justify;"><a href="<?php echo site_url('restablecer-contrasena/'.$codigo_activacion); ?>" style="display:inline-block;background:#5EF17C;color:#FFF;text-decoration:none;padding:5px 15px;border-radius:4px;" target="_blank">Restablecer Contraseña</a></p>
				<p style="font-size:13px;text-align:justify;color:#fa4c06;"></p>
				<p><a href="<?php echo base_url(); ?>" target="_blank" style="color:#fa4c06;text-decoration:underline;font-size:13px;">https://printome.mx</a></p>
			</div>
		</td>
	</tr>
</table>