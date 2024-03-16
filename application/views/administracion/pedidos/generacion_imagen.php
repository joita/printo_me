<?php echo doctype('html5'); ?>
<html class="no-js" lang="es">
	<head>
		<?php echo meta('charset', 'utf-8'); ?>
		<title><?php echo time().'.png'; ?></title>

		<script src="<?php echo site_url('assets/js/vendor/jquery/2.1.3/jquery.min.js'); ?>"></script>
		<script src="<?php echo site_url('assets/js/vendor/jquery-migrate/1.2.1/jquery-migrate.min.js'); ?>"></script>
		<script src="<?php echo site_url('assets/js/vendor/modernizr.js'); ?>"></script>
		<script src="<?php echo site_url('bower_components/canvg/dist/canvg.bundle.min.js'); ?>"></script>
		<script src="<?php echo site_url('bower_components/webfontloader/webfontloader.js'); ?>"></script>
	</head>
	<body>
		<?php
			$svg_code = html_entity_decode($svg);
			$svg_code = stripslashes($svg_code);

			$svg_code = str_replace('<svg ', '<svg id="svg_'.$lado.'" ', $svg_code);
			$svg_code = str_replace("'", '&#39;', $svg_code);

			$xmlget = simplexml_load_string($svg_code);

			$xmlattributes = $xmlget->attributes();
			$new_width = $xmlattributes->width*15;
			$new_height = $xmlattributes->height*15;

			$viewbox_attr = explode(" ", $xmlattributes->viewBox);

			foreach($viewbox_attr as $indice=>$viewbox_ind) {
				$viewbox_attr[$indice] = $viewbox_ind * 15;
			}

			//$new_viewbox_attr = implode(" ", $viewbox_attr);

			$new_viewbox_attr = '0 0 '.($new_width*1.75).' '.($new_height*1.75);

			$text_attr = $xmlget->g->text->attributes();
			$new_x = $text_attr['x'] * 15;
			$new_y = $text_attr['y'] * 15;
			$font_sin_px = (float) str_replace('px','', $text_attr['font-size']);
			$new_font_size = $font_sin_px*15;
			$new_font_size = (string) $new_font_size.'px';

			$svg_code = str_replace($xmlattributes->width, $new_width, $svg_code);
			$svg_code = str_replace($xmlattributes->height, $new_height, $svg_code);
			$svg_code = str_replace($xmlattributes->viewBox, $new_viewbox_attr, $svg_code);


			$svg_code = str_replace('"'.$text_attr['x'].'"', '"'.$new_x.'"', $svg_code);
			$svg_code = str_replace('"'.$text_attr['y'].'"', '"'.$new_y.'"', $svg_code);
			$svg_code = str_replace($text_attr['font-size'], $new_font_size, $svg_code);

			//$svg_code = str_replace('</svg>', '<defs><style>@import url("https://fonts.googleapis.com/css?family='.$font_family.'");</style></defs></svg>', $svg_code);

			echo $svg_code;

		?>

		<script>
			var i = 0;
			$("svg#<?php echo $xmlattributes->id; ?> tspan").each(function() {
				var dy = parseFloat($(this).attr("dy"));
				var new_dy = ((dy*15));
				if(i == 0) {
					new_dy += 0.3*<?php echo $new_height; ?>;
				}
				i++;
				$(this).attr("dy", new_dy);
			});

			$("svg#<?php echo $xmlattributes->id; ?>").prepend('<defs><style>@import url("https://fonts.googleapis.com/css?family=<?php echo $font_family; ?>");</style></defs><rect width="<?php echo ($new_width*1.75); ?>" height="<?php echo ($new_height*1.75); ?>" fill="<?php echo $color_fondo; ?>" x="0" y="0"></rect>');
		</script>
		<img src="" id="datastuff" />
		<?php /*<canvas id="canvas_<?php echo $lado; ?>"></canvas> */ ?>
		<script>
			//canvg(document.getElementById('canvas_<?php echo $lado; ?>'), $("svg#<?php echo $xmlattributes->id; ?>").prop('outerHTML'));
			$("svg#<?php echo $xmlattributes->id; ?>").hide()
			window.location.href='data:image/svg+xml;utf-8,'+$("svg#<?php echo $xmlattributes->id; ?>").prop("outerHTML");
		</script>
	</body>
</html>
