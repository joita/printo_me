<table class="spacer" style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
	<tbody>
		<tr style="padding:0;text-align:left;vertical-align:top">
			<td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&#xA0;</td>
		</tr>
	</tbody>
</table>
<?php foreach($articulos as $articulo): ?>
<table class="row" style="border-collapse:collapse;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%">
	<tbody>
		<tr style="padding:0;text-align:left;vertical-align:top">
			<th class="small-12 large-4 columns first" style="Margin:0 auto;color:#0a0a0a;font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:16px;padding-right:8px;text-align:left;width:200.67px">
				<table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
					<tr style="padding:0;text-align:left;vertical-align:top">
						<th style="Margin:0;color:#0a0a0a;font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
							<a href="<?php echo site_url('blog/'.$articulo->post_name); ?>">
								<img class="small-float-center" src="<?php echo $articulo->featured->guid; ?>" alt style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto">
							</a>
						</th>
					</tr>
				</table>
			</th>
			<th class="small-12 large-8 columns last" style="Margin:0 auto;color:#0a0a0a;font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:16px;text-align:left;width:417.33px">
				<table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
					<tr style="padding:0;text-align:left;vertical-align:top">
						<th style="Margin:0;color:#0a0a0a;font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
							<h3 style="Margin:0;Margin-bottom:10px;color:#93d60a;font-family:Arial,Helvetica,sans-serif;font-size:1.45rem;font-weight:700;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left;word-wrap:normal"
								class="verde"><a href="<?php echo site_url('blog/'.$articulo->post_name); ?>" class="verde" style="Margin:0;color:#93d60a;font-family:Arial,Helvetica,sans-serif;font-weight:700;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><?php echo $articulo->post_title; ?></a></h3>
							<table class="button primary" style="Margin:0 0 16px 0;border-collapse:collapse;border-spacing:0;margin:0 0 16px 0;padding:0;text-align:left;vertical-align:top;width:auto">
								<tr style="padding:0;text-align:left;vertical-align:top">
									<td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
										<table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
											<tr style="padding:0;text-align:left;vertical-align:top">
												<td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;background:#EE4500;border:2px solid #EE4500;border-collapse:collapse!important;color:#fefefe;font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><a
														href="<?php echo site_url('blog/'.$articulo->post_name); ?>" style="Margin:0;border:0 solid #EE4500;border-radius:3px;color:#fefefe;display:inline-block;font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:700;line-height:1.3;margin:0;padding:8px 16px 8px 16px;text-align:left;text-decoration:none">Leer
														más</a></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</th>
					</tr>
				</table>
			</th>
		</tr>
	</tbody>
</table>
<?php endforeach; ?>