<?php if(sizeof($plantillas) == 0): ?>
<p style="padding: 1.5rem;">No hay plantillas por clasificar.</p>
<?php elseif(sizeof($plantillas) > 0): ?>
<ul class="small-block-grid-3" style="padding-top:0.7rem;">
	<?php foreach($plantillas as $plantilla): ?>
	<li>
		<div class="area-plantilla">
			<img src="<?php echo site_url($plantilla->image); ?>" alt="" />
			<div class="row collapse">
				<div class="small-8 columns">
					<a class="button expand edit-plant" href="<?php echo site_url('personalizar/'.$plantilla->id_producto.'/'.$plantilla->id_color.'/'.$plantilla->id_unico); ?>" target="_blank"><i class="fa fa-image"></i> Editar</a>
				</div>
				<div class="small-8 columns">
					<a class="button expand clasificar success" data-image="<?php echo site_url($plantilla->image); ?>" data-id_plantilla="<?php echo $plantilla->id_diseno; ?>" data-reveal-id="main-rev"><i class="fa fa-tasks"></i> Clasificar</a>
				</div>
				<div class="small-8 columns">
					<a class="button expand borrme alert" data-id_plantilla="<?php echo $plantilla->id_diseno; ?>" data-reveal-id="borr-rev"><i class="fa fa-times"></i> Borrar</a>
				</div>
			</div>
		</div>
	</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<div class="reveal-modal tiny" id="main-rev" style="padding:0;max-width:350px;" data-reveal>
	<form action="<?php echo site_url('administracion/plantillas/clasificar'); ?>" method="post" data-abide>
		<div id="inmain" style="margin-bottom:1rem;"></div>
		<div class="row">
			<div class="small-23 small-centered columns">
				<label>Clasificación de la plantilla
					<select name="id_clasificacion" required>
						<option value=""></option>
						<?php foreach($clasificaciones as $clasificacion): ?>
                            <optgroup label="<?php echo $clasificacion->nombre_clasificacion; ?>">
                                <option value="<?php echo $clasificacion->id_clasificacion; ?>">General (<?php echo $clasificacion->plantillas; ?>)</option>
                                <?php if(sizeof($clasificacion->subclasificaciones) > 0): ?>
                                    <?php foreach($clasificacion->subclasificaciones as $subclasificacion): ?>
                                        <option value="<?php echo $clasificacion->id_clasificacion; ?>/<?php echo $subclasificacion->id_clasificacion; ?>"><?php echo $subclasificacion->nombre_clasificacion; ?> (<?php echo $subclasificacion->plantillas; ?>)</option>
                                        <?php if(sizeof($subclasificacion->subsubclasificaciones) > 0): ?>
                                            <?php foreach($subclasificacion->subsubclasificaciones as $subsubclasificacion): ?>
                                                <option value="<?php echo $clasificacion->id_clasificacion; ?>/<?php echo $subclasificacion->id_clasificacion; ?>/<?php echo $subsubclasificacion->id_clasificacion; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $subsubclasificacion->nombre_clasificacion; ?> (<?php echo $subsubclasificacion->plantillas; ?>)</option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </optgroup>
						<?php endforeach; ?>
					</select>
				</label>
				<small class="error">Campo obligatorio.</small>
			</div>
		</div>
		<div class="row">
			<div class="small-23 small-centered text-center columns">
				<input type="hidden" id="id_plant" name="id_plantilla" value="" />
				<button type="submit" class="success action button" style="margin-bottom: 1rem;"><i class="fa fa-tasks"></i> Clasificar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal tiny" id="borr-rev" style="padding:0;max-width:350px;" data-reveal>
	<form action="<?php echo site_url('administracion/plantillas/borrar'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-23 small-centered columns">
				<p style="padding-top:1.5rem; padding-bottom: 1rem; margin: 0;">¿Estás seguro de borrar esta plantilla, una vez borrada no se puede deshacer.</p>
			</div>
		</div>
		<div class="row">
			<div class="small-23 small-centered text-center columns">
				<input type="hidden" id="id_plant_bor" name="id_plantilla" value="" />
				<button type="submit" class="alert action button" style="margin-bottom: 1rem;"><i class="fa fa-times"></i> Borrar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<script>
$(".clasificar").click(function() {
	var imagen = $(this).data("image");
	var id_plantilla = $(this).data("id_plantilla");

	var html = '<div class="row collapse"><div class="small-24 columns"><img src="'+imagen+'" alt="" /></div></div>';

	$("#id_plant").val(id_plantilla);
	$("#main-rev div#inmain").html(html);
});

$(".borrme").click(function() {
	var id_plantilla = $(this).data("id_plantilla");
	$("#id_plant_bor").val(id_plantilla);
});
</script>
