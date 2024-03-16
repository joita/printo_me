<!-- slider_area -->
<div class="slider_areav2">
    <div class="slider_active2 owl-carousel owl-theme">
        <?php foreach ($slidescomprar as $indice => $slide):?>
            <?php if($slide->url_slide != ''):?>
                <a href="<?php echo $slide->url_slide; ?>" >
                    <div class="single_slider  d-flex align-items-center  " style="background-image: url(<?php echo site_url($slide->directorio."/".$slide->imagen_original); ?>) "></div>
                </a>
            <?php else: ?>
                <a>
                    <div class="single_slider  d-flex align-items-center  " style="background-image: url(<?php echo site_url($slide->directorio."/".$slide->imagen_original); ?>) "></div>
                </a>
            <?php endif ?>
        <?php endforeach;?>
    </div>
</div>

<!-- wow Area -->
<div class="wow_area">
    <div class="container wow-container">
        <div class="row">
            <div class="col-xl-4 col-md-4  cont-flyer">
                <div class="cont-wow">
                    <h1> PRINTOME <br><span> WOW</span><br> WINNERS</h1>
                    <div class="separador1" ></div>
                    <p>
                        Una selección diaria de los mejores diseños en Printome
                    </p>
                </div>
            </div>
            <div class="col-xl-8 col-md-8  bg-video-flyer">
                <div class="wow_active owl-carousel owl-theme">
                    <?php foreach ($wowwinner as $indice => $wow):?>
                        <div class="wow-opc">
                            <div class="wow-image">
                                <img src="<?php echo site_url($wow->front_image); ?>" alt="" class="img-fluid">
                                <?php if($indice==0):?>
                                    <div class="wow-cinta-hoy"></div>
                                <?php else: ?>
                                    <?php if($indice==1):?>
                                        <div class="wow-cinta-ayer"></div>
                                    <?php else: ?>
                                        <?php if($indice==2):?>
                                            <div class="wow-cinta-2dias"></div>
                                        <?php else: ?>
                                            <div class="wow-cinta-3dias"></div>
                                        <?php endif;?>
                                    <?php endif;?>
                                <?php endif;?>
                            </div>
                        </div>
                    <?php endforeach;?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- End wow Area -->

<!-- destacados_area_start -->
<div class="destacados_area">
    <div class="container destacados_container">
        <div class="dots-circle"></div>
        <h1>
            LO MAS <span>VENDIDO </span>

        </h1>
        <div class="separador1" ></div>
        <div class="row">
            <div class="col-xl-12">
                <div class="destacados_active owl-carousel owl-theme">
                    <?php foreach ($masvendidos as $indice => $vendido):?>
                        <div class="single_destacados">
                            <div class="cont_image">
                                <div class="destacados_image">
                                    <img src="<?php echo site_url($vendido->directorio."/".$vendido->imagen_medium);?>" alt="<?php echo $vendido->alt;?>">
                                </div>
                                <div class="logo-destacado">
                                    <div class="table-img">
                                        <?php if($vendido->logo != ''):?>
                                            <img src="<?php echo site_url($vendido->directorio."/".$vendido->logo);?>" alt="<?php echo $vendido->alt;?>" class="profile_image">
                                        <?php else: ?>
                                            <img src="assets/nimages/nuevo_diseno/img/profile_image.png" class="profile_image">
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <div class="destacados_cont text-center">
                                <h2> <?php echo $vendido->nombre_imagen;?> </h2>
                                <h3> Creado por <span> <?php echo $vendido->creador;?> </span><br></h3>
                                <div class="boton-solo text-center">
                                    <a href="<?php echo $vendido->url_imagen;?>" class="boxed-btn">COMPRAR</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- destacados_area_end -->

<!-- CLIENTES slider Area -->
<div class="clientes_area">
    <div class="container">
        <h1>
            CREADORES VIP<br>  <span> DE PRIN</span>TO<span>ME </span>
        </h1>
        <div class="separador1" ></div>

        <div class="row clientes-vip">
            <div class="col-xl-12 text-center">
                <div class="clientes_active owl-carousel owl-theme">
                    <?php foreach ($tiendas as $indice => $tienda):?>
                        <div class="clientes-opc">
                            <div class="circle-image">
                                <?php if($tienda->logotipo_mediano != ''):?>
                                    <img src="<?php echo site_url('assets/images/logos/'.$tienda->logotipo_mediano); ?>" alt="" class="img-fluid">
                                <?php else: ?>
                                    <img src="<?php echo site_url('assets/nimages/nuevo_diseno/img/default-creador.png'); ?>" alt="" class="img-fluid">
                                <?php endif;?>
                                <div class="mid-circle"></div>
                                <div class="min-circle"></div>
                            </div>
                            <div class="clientes-text-cont">
                                <h2> <?php echo $tienda->nombre_tienda ?> </h2>
                                <div class="boton-solo text-center">
                                    <a href="<?php echo site_url()."tienda/1/".$tienda->nombre_tienda_slug; ?>" class="boxed-btn">VISITAR TIENDA</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
        <div class="boton-solo text-center">
            <a href="<?php echo site_url('tiendas'); ?>" class="boxed-btn ">VER TODAS LAS TIENDAS</a>
        </div>
    </div>
</div>
<!-- End CLIENTES slider Area -->