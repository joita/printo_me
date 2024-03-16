<?php $image = $lado.'_image'; ?>
<li>
	<div class="boxxy">
		<img src="<?php echo site_url($campana->$image); ?>" class="smmmimg" />
		<table class="imaging">

            <?php
                $url = explode( $lado , $campana->$image);
                $url_diseno = $url[0]."dis_".$lado.$url[1];
            ?>
            <?php if(file_exists($url_diseno)):?>
                <tr><a href="<?php echo site_url($url_diseno); ?>" class="small button" target="_blank">Descargar Diseño Completo</a></tr>
            <?php endif;?>
		<?php $i = 0; foreach($campana->diseno->vector->$lado as $contenido_imagen): ?>
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
				<td width="22%" class="text-center" style="background:#eee;">
					Texto
				</td>
				<td width="78%" style="background:#eee;">
					<?php /*<script>
					WebFont.load({
						google: {
							families: ['<?php echo $contenido_imagen->fontFamily; ?>']
						}
					});
					</script> */ ?>
					<?php
						/* $svg_code = html_entity_decode($contenido_imagen->svg);
						$svg_code = str_replace("</svg>", "<defs><style>@import url('https://fonts.googleapis.com/css?family=".str_replace(" ", "+", $contenido_imagen->fontFamily)."');</style></defs></svg>", $svg_code);

						$xmlget = simplexml_load_string($svg_code);

						$xmlattributes = $xmlget->attributes();
						$new_width = $xmlattributes->width*15;
						$new_height = $xmlattributes->height*15;

						$viewbox_attr = explode(" ", $xmlattributes->viewBox);

						foreach($viewbox_attr as $indice=>$viewbox_ind) {
							$viewbox_attr[$indice] = $viewbox_ind * 15;
						}

						$new_viewbox_attr = '0 0 '.($new_width*1.75).' '.($new_height*1.75);

						$text_attr = $xmlget->g->text->attributes();
						$new_x = $text_attr['x'] * 15;
						$new_y = $text_attr['y'] * 15;
						$font_sin_px = (float) str_replace('px','', $text_attr['font-size']);
						$new_font_size = $font_sin_px*15;
						$new_font_size = (string) $new_font_size.'px';

						$svg_code2 = str_replace($xmlattributes->width, $new_width, $svg_code);
						$svg_code2 = str_replace($xmlattributes->height, $new_height, $svg_code2);
						$svg_code2 = str_replace($xmlattributes->viewBox, $new_viewbox_attr, $svg_code2);


						$svg_code2 = str_replace('"'.$text_attr['x'].'"', '"'.$new_x.'"', $svg_code2);
						$svg_code2 = str_replace('"'.$text_attr['y'].'"', '"'.$new_y.'"', $svg_code2);
						$svg_code2 = str_replace($text_attr['font-size'], $new_font_size, $svg_code2); */


					?>
					<?php //echo $svg_code; ?>
					<?php /*<canvas id="canvas_<?php echo $indice_custom; ?>_<?php echo $lado; ?>_<?php echo $i; ?>"></canvas>*/ ?>
					<script>
						//canvg(document.getElementById('canvas_<?php echo $indice_custom; ?>_<?php echo $lado; ?>_<?php echo $i; ?>'), '<?php echo addslashes($svg_code); ?>');
					</script>
					<form method="post" action="<?php echo site_url('administracion/pedidos/imagen'); ?>" target="_blank" enctype="multipart/form-data">
						<input type="hidden" name="code" value='<?php echo str_replace("'", '&#39;', $contenido_imagen->svg); ?>' />
						<input type="hidden" name="font" value="<?php echo $contenido_imagen->fontFamily; ?>" />
						<input type="hidden" name="color_fondo" value="<?php echo $color_fondo; ?>" />
						<input type="hidden" name="lado" value="<?php echo $lado; ?>" />
						<button type="submit" class="small button" style="margin-bottom:1rem;">Generar Imagen</button>
					</form>
					<span class="font_imagen">Font: <a href="https://fonts.google.com/specimen/<?php echo $contenido_imagen->fontFamily; ?>"><?php echo $contenido_imagen->fontFamily; ?></a></span>
					<span class="font_imagen">Texto: <?php echo $contenido_imagen->text; ?></span>
					<?php /*
					<div class="row">
						<div class="small-24 columns">
							<a href='data:image/svg+xml;utf8,<?php echo str_replace("'", '&#39;', $svg_code2); ?>' class="small button" style="margin-bottom:1rem;" target="_blank">Generar Imagen</a>
						</div>
					</div>
					<div class="row">
						<div class="small-24 columns">

						</div>
					</div>
					*/ ?>
					<?php /*<span class="font_imagen">Fuente: <a href="https://fonts.google.com/specimen/<?php echo $contenido_imagen->fontFamily; ?>" target="_blank" style="font-size:0.8rem;"><?php echo $contenido_imagen->fontFamily; ?></a></span>
				</td>*/ ?>
			<?php endif; ?>
			</tr>
		<?php $i++; endforeach; ?>
		<?php if(sizeof($campana->diseno->colores->$lado) > 0): ?>
			<tr>
				<td colspan="2" style="padding: 5px 15px;">
					<span class="font_imagen text-center" style="margin-bottom:0.625rem;">Colores usados:</span>
					<ul class="colorcitos small-block-grid-6 text-center">
					<?php foreach($campana->diseno->colores->$lado as $color): ?>
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
