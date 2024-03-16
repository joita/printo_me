<!--
Creado por Fabiola Medina
Fecha 12/04/2021
Sección inicio
-->

<!-- slider_area_start -->
<div class="container  d-none d-block d-sm-block d-md-none text-slider-top">
    <div class="row">
        <div class="col-12 d-md-none bg-img-flyer">
            <h1> <span >DISEÑA TU </span> PLAYERA   <br>
                PERSONALIZADA  <span >EN <br> MINUTOS </span>
            </h1>
            <div class="separador1" ></div>
            <div class="boton-solo text-center">
                <a  href="<?php if(!isset($this->session->diseno_temp)) {
                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                } else {
                    if(isset($boton_personaliza)) {
                        echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                    } else {
                        echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                    }
                } ?>" class="boxed-btn">EMPEZAR</a>
            </div>
        </div>
    </div>
</div>

<div class="slider_area">
    <div class="slider_active owl-carousel">
        <?php foreach ($banners as $indice => $banner):?>
            <div class="single_slider  d-flex align-items-center  " style="background-image: url(<?php echo site_url($banner->directorio."/".$banner->imagen_original); ?>) ">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12" >
                            <?php if($banner->texto != ''):?>
                                <div class="slider_text d-none d-md-block">
                                    <h1> <span ><?php echo $banner->texto; ?> </span> <?php echo $banner->texto_principal; ?>
                                    </h1>
                                    <div class="separador3" ></div>
                                    <div class="btn-div">
                                        <a href="<?php echo $banner->url_slide; ?>" class="boxed-btn"><?php echo $banner->boton; ?></a>
                                    </div>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>

    </div>
    <div class="base-banner"></div>
</div>
<!-- service_area_start -->
<div class="service_area">

    <div class="container service-container">
        <div class="dots-circle-bottom-left"></div>
        <div class="dots-circle-top-right"></div>
        <h1>
            CREA LA PLAYERA  <span>PERFECTA </span>

        </h1>
        <div class="separador1" ></div>
        <div class="row">

            <div class="col-xl-4 col-md-4 text-center">
                <div class="single_service">
                    <a href="<?php echo base_url('plantillas'); ?>">
                        <img src="assets/nimages/nuevo_diseno/img/servicio1.png" alt="MDN" class="img-fluid text-md-center text-xs-center">
                    </a>
                    <h2>PARA EMPRESAS</h2>
                    <p>Dale actitud a tu equipo de colaboradores o a tus eventos con increíbles playeras personalizadas</p>
                    <a href="<?php echo base_url('plantillas'); ?>" class="boxed-btn">EMPEZAR</a>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 text-center">
                <div class="single_service">
                    <a href="<?php echo base_url('plantillas'); ?>">
                        <img src="assets/nimages/nuevo_diseno/img/servicio2.png" alt="MDN" class="img-fluid text-center">
                    </a>
                    <h2>PARA TUS EVENTOS ESPECIALES</h2>
                    <p>Haz inolvidable cualquier ocasión con una playera personalizada.</p>
                    <a href="<?php echo base_url('plantillas'); ?>" class="boxed-btn">EMPEZAR</a>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 text-center">
                <div class="single_service">
                    <a href="<?php echo base_url('plantillas'); ?>">
                        <img src="assets/nimages/nuevo_diseno/img/servicio3.png" alt="MDN" class="img-fluid text-center">
                    </a>
                    <h2>CON TU PROPIO DISEÑO</h2>
                    <p>Sube tu diseño y crea tu playera personalizada.</p>
                    <a href="<?php echo base_url('plantillas'); ?>" class="boxed-btn">EMPEZAR</a>
                </div>
            </div>

        </div>
    </div>
    <div class="base-service-area"></div>
</div>

<!-- service_area_end -->
<!-- video area -->
<div class="video-area">
    <div class="container video-container">
        <div class="dots-triangle"></div>
        <div class="dots-circle-footer-top-right"></div>
        <div class="bg-green-circle-bottom-right"></div>
        <h1>
            <span style="color:#ffffff">¿CÓMO FUNCIONA <br> PRINTOME? </span>
        </h1>
        <div class="separador2" ></div>
        <p>Personalizar tu playera es fácil y rápido</p>

        <div class="row">
            <div class="col-xl-12 text-center bg-video">
                <div id="video-yt"> </div>
                <div class="start-video"></div>
            </div>

        </div>
    </div>
</div>
<script>
    //youtube script
    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;

    onYouTubeIframeAPIReady = function () {
        player = new YT.Player('video-yt', {
            height: '600',
            width: '100%',
            videoId: 'UdMopQ6lPes',  // youtube video id
            playerVars: {
                'autoplay': 0,
                'rel': 0,
                'controls': 0,
                'showinfo': 0,
                'wmode': 'opaque',
                'rel': 0
            },
            events: {
                'onStateChange': onPlayerStateChange
            }
        });
    }

    onPlayerStateChange = function (event) {
        if (event.data == YT.PlayerState.ENDED) {
            $('.start-video').fadeIn('normal');
        }
    }

    $(document).on('click', '.start-video', function () {
        $(this).fadeOut('normal');
        player.playVideo();
    });
</script>

<!-- video area end -->

<!-- usos_area_start -->
<div class="usos_area">
    <div class="container">
        <h1>
            DESCUBRE LO QUE PUEDES  <span>HACER CON PRINTOME </span>

        </h1>
        <div class="separador1" ></div>
        <div class="row">
            <div class="col-xl-12">
                <div class="usos_active owl-carousel owl-theme">
                    <div class="single_usos">
                        <div class="usos_image">
                            <a href="<?php if(!isset($this->session->diseno_temp)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                if(isset($boton_personaliza)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                }
                            } ?>">
                                <img src="assets/nimages/nuevo_diseno/img/Group30.png" alt="">
                            </a>
                        </div>
                        <div class="boton-solo text-center">
                            <a href="<?php if(!isset($this->session->diseno_temp)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                if(isset($boton_personaliza)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                }
                            } ?>" <?php activar($seccion_activa, 'personalizar'); ?> class="boxed-btn ">EMPEZAR</a>
                        </div>
                    </div>
                    <div class="single_usos">
                        <div class="usos_image">
                            <a href="<?php if(!isset($this->session->diseno_temp)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                if(isset($boton_personaliza)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                }
                            } ?>">
                                <img src="assets/nimages/nuevo_diseno/img/Group31.png" alt="">
                            </a>
                        </div>
                        <div class="boton-solo text-center">
                            <a href="<?php if(!isset($this->session->diseno_temp)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                if(isset($boton_personaliza)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                }
                            } ?>"<?php activar($seccion_activa, 'personalizar'); ?> class="boxed-btn ">EMPEZAR</a>
                        </div>
                    </div>
                    <div class="single_usos">
                        <div class="usos_image">
                            <a href="<?php if(!isset($this->session->diseno_temp)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                if(isset($boton_personaliza)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                }
                            } ?>">
                                <img src="assets/nimages/nuevo_diseno/img/Group32.png" alt="">
                            </a>
                        </div>
                        <div class="boton-solo text-center">
                            <a href="<?php if(!isset($this->session->diseno_temp)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                if(isset($boton_personaliza)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                }
                            } ?>"<?php activar($seccion_activa, 'personalizar'); ?> class="boxed-btn ">EMPEZAR</a>
                        </div>
                    </div>
                    <div class="single_usos">
                        <div class="usos_image">
                            <a href="<?php if(!isset($this->session->diseno_temp)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                if(isset($boton_personaliza)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                }
                            } ?>">
                                <img src="assets/nimages/nuevo_diseno/img/Group34.png" alt="">
                            </a>
                        </div>
                        <div class="boton-solo text-center">
                            <a href="<?php if(!isset($this->session->diseno_temp)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                if(isset($boton_personaliza)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                }
                            } ?>"<?php activar($seccion_activa, 'personalizar'); ?> class="boxed-btn ">EMPEZAR</a>
                        </div>
                    </div>
                    <div class="single_usos">
                        <div class="usos_image">
                            <a href="<?php if(!isset($this->session->diseno_temp)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                if(isset($boton_personaliza)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                }
                            } ?>">
                                <img src="assets/nimages/nuevo_diseno/img/Group35.png" alt="">
                            </a>
                        </div>
                        <div class="boton-solo text-center">
                            <a href="<?php if(!isset($this->session->diseno_temp)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                if(isset($boton_personaliza)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                }
                            } ?>"<?php activar($seccion_activa, 'personalizar'); ?> class="boxed-btn ">EMPEZAR</a>
                        </div>
                    </div>
                    <div class="single_usos">
                        <div class="usos_image">
                            <a href="<?php if(!isset($this->session->diseno_temp)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                if(isset($boton_personaliza)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                }
                            } ?>">
                                <img src="assets/nimages/nuevo_diseno/img/Group36.png" alt="">
                            </a>
                        </div>
                        <div class="boton-solo text-center">
                            <a href="<?php if(!isset($this->session->diseno_temp)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                if(isset($boton_personaliza)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                }
                            } ?>"<?php activar($seccion_activa, 'personalizar'); ?> class="boxed-btn ">EMPEZAR</a>
                        </div>
                    </div>
                    <div class="single_usos">
                        <div class="usos_image">
                            <a href="https://printome.mx/plantillas/null/celebraciones/bautizo">
                                <img src="assets/nimages/nuevo_diseno/img/Group38.png" alt="">
                            </a>
                        </div>
                        <div class="boton-solo text-center">
                            <a href="https://printome.mx/plantillas/null/celebraciones/bautizo" class="boxed-btn ">EMPEZAR</a>
                        </div>
                    </div>
                    <div class="single_usos">
                        <div class="usos_image">
                            <a href="https://printome.mx/plantillas/null/gente">
                                <img src="assets/nimages/nuevo_diseno/img/Group39.png" alt="">
                            </a>
                        </div>
                        <div class="boton-solo text-center">
                            <a href="https://printome.mx/plantillas/null/gente" class="boxed-btn ">EMPEZAR</a>
                        </div>
                    </div>
                    <div class="single_usos">
                        <div class="usos_image">
                            <a href="https://printome.mx/plantillas/null/celebraciones/dia-de-la-madre" >
                                <img src="assets/nimages/nuevo_diseno/img/Group40.png" alt="">
                            </a>
                        </div>
                        <div class="boton-solo text-center">
                            <a href="https://printome.mx/plantillas/null/celebraciones/dia-de-la-madre" class="boxed-btn ">EMPEZAR</a>
                        </div>
                    </div>
                    <div class="single_usos">
                        <div class="usos_image">
                            <a href="https://printome.mx/plantillas/null/celebraciones/graduaciones" >
                                <img src="assets/nimages/nuevo_diseno/img/Group41.png" alt="">
                            </a>
                        </div>
                        <div class="boton-solo text-center">
                            <a href="https://printome.mx/plantillas/null/celebraciones/graduaciones" class="boxed-btn ">EMPEZAR</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- usos_area_end -->

<!-- destacados_area_start -->
<div class="destacados_area">
    <div class="container destacados_container">
        <div class="dots-circle-bottom-left"></div>
        <div class="dots-circle-top-right"></div>
        <h1>
            DISEÑOS <span>DESTACADOS </span>

        </h1>
        <div class="separador1" ></div>
        <div class="row">
            <div class="col-xl-12">

                <div class="destacados_active owl-carousel owl-theme">
                    <?php foreach ($creadores as $indice => $creador):?>
                        <div class="single_destacados">
                            <div class="cont_image">
                                <div class="destacados_image">
                                    <img src="<?php echo site_url($creador->directorio."/".$creador->imagen_original); ?>" alt="<?php echo $creador->alt?>">
                                </div>
                                <div class="logo-destacado">
                                    <div class="table-img">
                                        <img src="<?php echo site_url($creador->directorio."/".$creador->logo); ?>" alt="<?php echo $creador->alt?>" class="profile_image">
                                    </div>
                                </div>
                            </div>
                            <div class="destacados_cont text-center">
                                <h2> <?php echo $creador->nombre_imagen; ?> </h2>
                                <h3> Creado por <span> <?php echo $creador->creador; ?> </span><br></h3>
                                <a href="<?php echo $creador->url_imagen; ?>" class="boxed-btn">COMPRAR</a>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
                <div class="boton-solo text-center">
                    <a href="<?php echo site_url('tiendas'); ?>" class="boxed-btn ">VER MÁS TIENDAS</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- destacados_area_end -->
