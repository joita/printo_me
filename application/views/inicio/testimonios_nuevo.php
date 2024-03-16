<!-- slider_area -->
<div class="container  d-none d-block d-sm-block d-md-none text-slider-top">
    <div class="row">
        <div class="col-12 d-md-none bg-img-flyer">
            <h1>
                <span>TESTIMONIALES </span>
            </h1>
            <div class="separador1" ></div>
            <p>
                Conoce lo que opinan los usuarios de Printome
            </p>
        </div>
    </div>
</div>

<div class="slider_area">
    <div class="slider_active owl-carousel">
        <div class="single_slider  d-flex align-items-center  " style="background-image: url(assets/nimages/nuevo_diseno/img/banner/ban3.png) ">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12" >
                        <div class="slider_text d-none d-md-block">
                            <h1>
                                <span>TESTIMONIALES </span>
                            </h1>
                            <div class="separador1-left " ></div>
                            <p>
                                Conoce lo que opinan los usuarios de Printome
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="base-banner"></div>
</div>

<!-- testimonios Area -->
<div class="testimonios_area">
    <div class="container">
        <div class="row">
            <?php foreach($testimonios as $testimonio): ?>
            <div class="col-xs-6 col-md-4 col-xl-4 testimonio">
                <div class="user-image">
                    <img src="assets/nimages/nuevo_diseno/img/user-image.png" alt="" class="img-fluid">
                </div>
                <div class="user-name">
                    <h2> <?php echo $testimonio->nombre; ?>  </h2>
                </div>
                <div class="clear"> </div>

                <div class="user-stars">
                    <?php echo estrellitas($testimonio->monto_calificacion); ?>
                </div>
                <div class="user-date"> <?php fecha($testimonio->fecha_calificacion); ?>    </div>
                <div class="clear"> </div>

                <p>
                    <?php echo $testimonio->comentario; ?>
                </p>
                <?php if($testimonio->cantidad_respuestas > 0):?>
                    <a class="link-respuesta" data-toggle="collapse" href="#testimonio<?php echo$testimonio->id_calificacion?>" role="button" aria-expanded="false" aria-controls="testimonio<?php echo $testimonio->id_calificacion?>">Respuesta <?php echo $testimonio->cantidad_respuestas ?> <i class="fa fa-angle-down"></i></a>
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="testimonio respuesta collapse multi-collapse" id="testimonio<?php echo $testimonio->id_calificacion?>">
                                <?php foreach($testimonio->respuestas as $indice_respuestas => $respuesta):?>
                                    <div class="user-image">
                                        <img src="assets/nimages/nuevo_diseno/img/user-image.png" alt="" class="img-fluid">
                                    </div>
                                    <div class="user-name">
                                        <h2> <?php if($respuesta->tipo_usuario == 'admin'){echo 'Prin<span class="green">to</span>me';}else{echo $testimonio->nombre;} ?>  </h2>
                                    </div>
                                    <div class="clear"> </div>
                                    <p>
                                        <?php echo $respuesta->respuesta; ?>
                                    </p>

                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>

        </div>
        <div class="row pagnav">

                <?php echo $paginacion; ?>

        </div>
    </div>
</div>
<!-- End testimonios Area -->

<!-- Flyer IMAGE Area -->
<div class="dudas_area">
    <div class="container flyer-container">
        <div class="row">
            <div class="col-xl-5 col-md-5 col-12 d-none d-md-block bg-img-flyer">
                <img src="assets/nimages/nuevo_diseno/img/image-dudas3.png" alt="" class="img-fluid">
            </div>
            <div class="col-xl-7 col-md-7 col-12">
                <h1> ¿YA ERES NUESTRO CLIENTE?</h1>
                <div class="separador2" ></div>
                <div class="boton-solo text-left">
                    <a href="<?php echo site_url('testimonios/nuevo'); ?>" class="boxed-btn">DEJA TU TESTIMONIO</a>
                </div>
            </div>
            <div class="col-xl-5 col-md-5 col-12 d-none d-block d-sm-block d-md-none bg-img-flyer">
                <img src="assets/nimages/nuevo_diseno/img/image-dudas3.png" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<!-- End FLYER IMAGE Area -->
