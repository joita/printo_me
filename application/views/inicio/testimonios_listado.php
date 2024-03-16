<div class="row fgc pscat small-collapse medium-uncollapse" style="background-color: white;">
    <div class="small-18 columns">
        <div class="address-area">
            <div class="row">
                <div class="small-18 medium-18 large-14 columns">
                    <h1 class="dosf text-center medium-text-left" style="color: #EE4500">Lo que opinan los usuarios de la plataforma</h1>
                </div>
                <div class="small-18 large-4 columns">
                    <a href="<?php echo site_url('testimonios/nuevo'); ?>" class="small expanded button"><i class="fa fa-edit"></i> <strong>Deja tu testimonio</strong></a>
                </div>
            </div>
            <div class="small-18 large-12 columns pagination">
                <div class="text-left"><?php echo $paginacion; ?></div>
            </div>
            <div class="row collapse">
                <div class="small-18 columns">
                    <div id="area-testimonios">
                        <div class="grid" id="testimonios-grid">
                        <?php foreach($testimonios as $testimonio): ?>
                            <div class="grid-item">
                                <div class="testimonio-container" style="border: 2px solid #025573; border-radius: 10px">
                                    <div class="row collapse testimonio-upper-row" style="border-color: #025573">
                                        <div class="small-18 medium-9 columns text-center medium-text-left">
                                            <div class="testimonio-rating">
                                                <?php echo estrellitas($testimonio->monto_calificacion); ?>
                                            </div>
                                        </div>
                                        <div class="small-18 medium-9 columns text-center medium-text-right">
                                            <span class="testimonio-fecha">
                                                <?php fecha($testimonio->fecha_calificacion); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row collapse">
                                        <div class="small-18 columns testimonio-mid-row">
                                            <div class="avatar row collapse">
                                                <div class="columns small-2 columna-avatar">
                                                    <img class="avatar-image" src="<?php echo $testimonio->url_avatar; ?>" alt="avatar">
                                                </div>
                                                <div class="columns small-16 columna-nombre">
                                                    <span class="testimonio-nombre"><?php echo $testimonio->nombre; ?></span>
                                                </div>
                                            </div>
                                            <blockquote class="testimonio-texto"><?php echo $testimonio->comentario; ?></blockquote>
                                        </div>
                                    </div>
                                    <!--Despliegue de Respuestas-->
                                    <?php if($testimonio->cantidad_respuestas > 0):?>
                                        <?php foreach($testimonio->respuestas as $indice_respuestas => $respuesta):?>
                                            <div class="row collapse">
                                                <div class="small-18 columns testimonio-mid-row">
                                                    <div class="row collapse testimonio-lower-row" style="border-color: #025573"></div>
                                                    <div class="avatar row collapse">
                                                        <div class="columns small-2 columna-avatar">
                                                            <img class="avatar-image" src="<?php if($respuesta->tipo_usuario == 'admin'){echo 'assets/images/icon.png';}else{echo $testimonio->url_avatar;} ?>" alt="avatar">
                                                        </div>
                                                        <div class="columns small-16 columna-nombre">
                                                            <span class="respuesta-nombre"><?php if($respuesta->tipo_usuario == 'admin'){echo 'Printome';}else{echo $testimonio->nombre;} ?></span>
                                                        </div>
                                                    </div>
                                                    <blockquote class="testimonio-texto"><?php echo $respuesta->respuesta; ?></blockquote>
                                                </div>
                                            </div>
                                            <div class="row collapse testimonio-lower-row"></div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <!--End Despliegue de Respuestas-->
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="small-18 large-18 text-center columns pagination">
                    <div><?php echo $paginacion; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
