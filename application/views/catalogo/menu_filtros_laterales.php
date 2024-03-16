<div class="contenedor-filtros" data-equalizer-watch>
	<span class="titulo-filtros" style="text-align: left; color: #FF4D00; border: none; border-bottom: 2px solid #025573">Refinar búsqueda</span>
	
	<h5 class="filtrador" style="text-align: left; color: #FF4D00; border: none ; ">Filtrar por tipo</h5>
	<ul class="vertical menu ff">
	<?php foreach($categoria->tipos as $tipo_menu): ?>
		<li<?php activar($tipo_activo, $tipo_menu->tipo->nombre_tipo_slug); ?>><a href="<?php echo site_url($categoria->nombre_categoria_slug.'/'.$tipo_menu->tipo->nombre_tipo_slug); ?>"><?php echo $tipo_menu->tipo->nombre_tipo; ?></a></li>
	<?php endforeach; ?>
	</ul>

	<?php if(sizeof($colores) > 0): ?>
	<h5 class="filtrador" style="text-align: left; color: #FF4D00; border: none ; border-bottom: 2px solid #025573">Filtrar por color</h5>
	<dl class="filtro color">
		<dd><a data-filtro="" class="initial active"><i class="fa fa-check-circle-o"></i> Todos los colores</a></dd>
		<dd class="clearfix links-colores">
		<?php foreach($colores as $color) : ?>
        <?php /*if ($color->codigo_color == "#302789"){
                $color->codigo_color = "#2C3657";
            }*/?>
			<a class="special" data-filtro="<?php echo '.color_'.url_title($color->codigo_color, '-', TRUE); ?>"><i class="fa fa-circle" style="color:<?php echo $color->codigo_color; ?>"></i></a>
		<?php endforeach; ?>
		</dd>
	</dl>

	<a class="no-encuentras button" data-open="contacto_interno" style="color: #FF4D00; border: 2px solid #025573; border-radius: 10px; background: white">¿No encuentras el color que necesitas?</a>
	<?php endif; ?>

	<?php if($script_datos['precios']->minimo != 0 && $script_datos['precios']->maximo != 0): ?>
	<div class="hide">
	<h5 class="filtrador">Rango de precio base</h5>
	<dl class="filtro precio">
		<dd style="padding-left:0;margin-right:1.5rem;padding-top:1rem">
			<input type="text" id="<?php echo $id; ?>" name="<?php echo $id; ?>">
		</dd>
	</dl>
	</div>
	<?php endif; ?>

	<?php if(sizeof($tallas) > 0): ?>
	<h5 class="filtrador" style="text-align: left; color: #FF4D00; border: none ; border-bottom: 2px solid #025573">Filtrar por talla</h5>
	<dl class="filtro talla">
		<dd><a class="initial active" data-filtro=""><i class="fa fa-check-circle-o"></i> Todas las tallas</a></dd>
		<dd>
		<?php foreach($tallas as $talla =>$flag) : ?><a class="talla_f" data-filtro="<?php echo '.talla_'.url_title($talla, '-', TRUE); ?>"><?php echo $talla; ?></a>
		<?php endforeach; ?>
		</dd>
	</dl>
	<?php endif; ?>
</div>