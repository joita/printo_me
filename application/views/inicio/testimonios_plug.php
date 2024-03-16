<div class="fgc pscat">
	<div class="row">
        <div class="small-18 columns">
            <h2 class="text-center dosf">Testimonios de nuestros clientes</h2>
            <div class="owl-carousel owl-theme" id="testimonios-area">
            <?php foreach($testimonios as $testimonio): ?>
                <div class="grid-item">
                    <div class="testimonio-container">
                        <div class="row collapse testimonio-upper-row">
                            <div class="small-18 medium-7 columns text-center medium-text-left">
                                <div class="testimonio-rating">
                                    <?php echo estrellitas($testimonio->monto_calificacion); ?>
                                </div>
                            </div>
                            <div class="small-18 medium-11 columns text-center medium-text-right">
                                <span class="testimonio-fecha">
                                    <?php fecha($testimonio->fecha_calificacion); ?>
                                </span>
                            </div>
                        </div>
                        <div class="row collapse">
                            <div class="small-18 columns">
                                <blockquote class="testimonio-texto"><?php echo $testimonio->comentario; ?></blockquote>
                            </div>
                        </div>
                        <div class="row collapse testimonio-lower-row">
                            <span class="testimonio-nombre"><?php echo $testimonio->nombre; ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
