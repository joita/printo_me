<?php foreach($clasificaciones as $clasificacion): ?>
    <?php if(($clasificacion->plantillas + $clasificacion->subplantillas) > 0): ?>
        <div class="plantilla-container">
            <h2 class="text-left dosf extended"><?php echo $clasificacion->nombre_clasificacion; ?> <a href="<?php echo site_url('plantillas/'.$clasificacion->nombre_clasificacion_slug); ?>" class="float-right see-more-plant"><i class="fa fa-angle-double-right"></i> Ver todas</a></h2>
            <div class="row small-up-1 medium-up-2 large-up-4 xlarge-up-4" id="contenedor-catalogo">
                <?php foreach($clasificacion->plantillas_random as $plantilla) {
                    $this->load->view('catalogo/thumb_plantilla', array('plantilla' => $plantilla));
                } ?>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
