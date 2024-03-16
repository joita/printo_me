<?php $image = $lado.'_image'; ?>
<li>
	<div class="boxxy">
		<img src="<?php echo site_url($campana->$image); ?>" class="smmmimg" />
		<table class="imaging">
		<?php foreach($campana->diseno->$lado as $contenido_imagen): ?>
			<tr>
			<?php if($contenido_imagen->type == 'clipart'): ?>
				<td width="22%" class="text-center">
				<?php if($contenido_imagen->file->type == 'image'): ?>
					<img src="<?php echo site_url('assets/images/trans.png'); ?>" style="background: url(<?php echo $contenido_imagen->thumb; ?>) no-repeat center center; background-size: contain;" alt="" />
				<?php elseif($contenido_imagen->file->type == 'svg'): ?>
					<img src="<?php echo site_url('assets/images/trans.png'); ?>" style="background: url(<?php echo $contenido_imagen->thumb; ?>) no-repeat center center; background-size: contain;" alt="" />
				<?php endif; ?>
				</td>
				<td width="78%">
				<?php if($contenido_imagen->file->type == 'image'): ?>
					<a href="<?php echo $contenido_imagen->url; ?>" class="small button" target="_blank">Descargar Imagen</a>
				<?php elseif($contenido_imagen->file->type == 'svg'): ?>
					<a href="<?php echo $contenido_imagen->url.'print/'.$contenido_imagen->file_name; ?>" class="small button" target="_blank">Descargar SVG</a>
				<?php endif; ?>
				</td>
			<?php endif; ?>
			<?php if($contenido_imagen->type == 'text'): ?>
				<td width="22%" class="text-center">
					Texto
				</td>
				<td width="78%">
					<?php
						$svg_code = html_entity_decode($contenido_imagen->svg);
						if($contenido_imagen->fontFamily != 'Arial') {
							$svg_code = str_replace("</svg>", "<style>@import url('https://fonts.googleapis.com/css?family=".str_replace(" ", "+", $contenido_imagen->fontFamily)."');</style></svg>", $svg_code);
						}
						echo $svg_code; 
					?>
					<form method="post" action="<?php echo site_url('administracion/pedidos/svgme'); ?>" target="_blank" enctype="multipart/form-data">
						<input type="hidden" name="code" value='<?php echo $contenido_imagen->svg; ?>' />
						<input type="hidden" name="font" value="<?php echo $contenido_imagen->fontFamily; ?>" />
						<input type="hidden" name="color_fondo" value="<?php echo $color_fondo; ?>" />
						<button type="submit" class="small button" style="margin-bottom:1rem;">Generar Imagen</button>
					</form>
					
					<span class="font_imagen">Fuente: <a href="https://fonts.google.com/specimen/<?php echo $contenido_imagen->fontFamily; ?>" target="_blank" style="font-size:0.8rem;"><?php echo $contenido_imagen->fontFamily; ?></a></span>
				</td>
			<?php endif; ?>
			</tr>
		<?php endforeach; ?>
		<?php if(sizeof($campana->colores_por_lado->$lado) > 0): ?>
			<tr>
				<td colspan="2" style="padding: 5px 15px;">
					<span class="font_imagen text-center" style="margin-bottom:0.625rem;">Colores usados:</span>
					<ul class="colorcitos small-block-grid-6 text-center">
					<?php foreach($campana->colores_por_lado->$lado as $color): ?>
						<li>
							<i class="fa fa-square" style="color:<?php echo $color; ?>"></i>
							<span class="font_imagen"><?php echo $color; ?></span>
						</li>
					<?php endforeach; ?>
					</ul>
				</td>
			</tr>
		<?php endif; ?>
		</table>
	</div>
</li>