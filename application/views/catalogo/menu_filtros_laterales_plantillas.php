<div class="contenedor-filtros" data-equalizer-watch >
	<span class="titulo-filtros" style="text-align: left; color: #FF4D00; border: none; border-bottom: 2px solid #025573">Filtrar por temática</span>
	<ul class="vertical menu ff plant accordion-menu" data-accordion-menu>
	<?php foreach($clasificaciones as $clasificacion): ?>
		<?php if(($clasificacion->plantillas + $clasificacion->subplantillas) > 0): ?>
            <li<?php if(sizeof($clasificacion->subclasificaciones) == 0) { activar($clasificacion_activa, $clasificacion->nombre_clasificacion_slug); } ?>>
                <a href="<?php echo site_url('plantillas/'.$clasificacion->nombre_clasificacion_slug); ?>"><?php echo $clasificacion->nombre_clasificacion; ?></a>
                <?php if(sizeof($clasificacion->subclasificaciones)): ?>
                    <ul class="vertical menu nested<?php if($clasificacion_activa == $clasificacion->nombre_clasificacion_slug) { echo ' is-active'; } ?>">
                    <li<?php if(sizeof($clasificacion->subclasificaciones) > 0 && !$subclasificacion_activa) { activar($clasificacion_activa, $clasificacion->nombre_clasificacion_slug); } ?>>
                        <a href="<?php echo site_url('plantillas/'.$clasificacion->nombre_clasificacion_slug); ?>">Todas</a>
                    </li>
                    <?php foreach($clasificacion->subclasificaciones as $indice_subclasificacion => $subclasificacion): ?>
                        <?php if($subclasificacion->plantillas > 0): ?>
                            <li<?php if(sizeof($subclasificacion->subsubclasificaciones)==0){activar($subclasificacion_activa, $subclasificacion->nombre_clasificacion_slug);} ?> <?php if(sizeof($subclasificacion->subsubclasificaciones)>0){ echo "class='subsub'"; }?>>
                                <a href="<?php echo site_url('plantillas/'.$clasificacion->nombre_clasificacion_slug.'/'.$subclasificacion->nombre_clasificacion_slug); ?>" ><?php echo $subclasificacion->nombre_clasificacion; ?></a>
                                <?php if(sizeof($subclasificacion->subsubclasificaciones)): ?>
                                    <ul class="vertical menu nested<?php if($subclasificacion_activa == $subclasificacion->nombre_clasificacion_slug) { echo ' is-active'; } ?>">
                                        <li<?php if(sizeof($subclasificacion->subsubclasificaciones) > 0 && !$subsubclasificacion_activa) { activar($subclasificacion_activa, $subclasificacion->nombre_clasificacion_slug); } ?>>
                                            <a href="<?php echo site_url('plantillas/'.$clasificacion->nombre_clasificacion_slug).'/'.$subclasificacion->nombre_clasificacion_slug; ?>">Todas las Subcategorias</a>
                                        </li>
                                        <?php foreach($subclasificacion->subsubclasificaciones as $indice_subsubclasificacion => $subsubclasificacion): ?>
                                            <?php if($subsubclasificacion->plantillas > 0): ?>
                                                <li<?php activar($subsubclasificacion_activa, $subsubclasificacion->nombre_clasificacion_slug); ?>>
                                                    <a href="<?php echo site_url('plantillas/'.$clasificacion->nombre_clasificacion_slug.'/'.$subclasificacion->nombre_clasificacion_slug.'/'.$subsubclasificacion->nombre_clasificacion_slug); ?>"><?php echo $subsubclasificacion->nombre_clasificacion; ?></a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
		<?php endif; ?>
	<?php endforeach; ?>
	</ul>
</div>
