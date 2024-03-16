<!-- slider_area -->
<div class="container  d-none d-block d-sm-block d-md-none text-slider-top">
    <div class="row">
        <div class="col-12 d-md-none bg-img-flyer">
            <h1> MONETIZA TU CONTENIDO<br>
                <span>HAZ CRECER TU NEGOCIO </span>
            </h1>
            <div class="separador1" ></div>
            <p>
                Crea y vende playeras personalizadas con Printome.
            </p>
            <div class="boton-solo text-center">
                <a <?php activar($seccion_activa, 'personalizar'); ?> href="<?php if(!isset($this->session->diseno_temp)) {
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

<div class="slider_area influencers_slider">
    <div class="slider_active owl-carousel">
        <div class="single_slider left-slider  d-flex align-items-center  " style="background-image: url(assets/nimages/nuevo_diseno/img/banner/ban5.png) ">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4" >

                    </div>
                    <div class="col-xl-8" >
                        <div class="slider_text d-none d-md-block">
                            <h1> MONETIZA TU CONTENIDO<br>
                                <span>HAZ CRECER TU NEGOCIO </span>
                            </h1>
                            <div class="separador1" ></div>
                            <p>
                                Crea y vende playeras personalizadas con Printome.
                            </p>
                            <div class="boton-solo text-center">
                                <a <?php activar($seccion_activa, 'personalizar'); ?> href="<?php if(!isset($this->session->diseno_temp)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    if(isset($boton_personaliza)) {
                                        echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                    } else {
                                        echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                    }
                                } ?>" class="boxed-btn ">EMPEZAR</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="base-banner"></div>
</div>
<!-- End slider Area -->

<!-- Personalización Area -->

<!-- Flyer Area -->
<div class="flyer_video_area">
    <div class="container flyer-container">
        <div class="row">
            <div class="col-xl-5 col-md-5 cont-flyer cont-flyer-influencer">
                <h1> ¿CÓMO FUNCIONA EL PROGRAMA DE <span> CREADORES VIP PRINTOME?</span></h1>
                <div class="separador1" ></div>
                <p>
                    Descubre aquí todo lo que pasa cuando creas tu playera personalizada con Printome

                </p>
            </div>
            <div class="col-xl-7 col-md-7 bg-video-flyer">
                <div id="yt-flyer" class="video-yt-flyer"> </div>
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
        player = new YT.Player('yt-flyer', {
            height: '405',
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
<!-- End Flyer Area -->

<!-- CLIENTES slider Area -->
<div class="clientes_area">
    <div class="container">
        <h1>
            LOS CREADORES <b>  <span> CONFÍAN EN PRINTOME </span>
        </h1>
        <div class="separador1" ></div>
        <p>
            Crea diseños de manera fácil con nuestras plantillas
        </p>
        <div class="row">
            <div class="col-xl-12">


                <div class="clientes_active owl-carousel owl-theme">
                    <?php foreach ($tiendas as $indice => $tienda):?>
                        <div class="clientes-opc">
                            <div class="circle-image">
                                <a href="<?php echo site_url()."tienda/1/".$tienda->nombre_tienda_slug; ?>" >
                                    <?php if($tienda->logotipo_mediano != ''):?>
                                        <img src="<?php echo site_url('assets/images/logos/'.$tienda->logotipo_mediano); ?>" alt="" class="img-fluid">
                                    <?php else: ?>
                                        <img src="<?php echo site_url('assets/nimages/nuevo_diseno/img/default-creador.png'); ?>" alt="" class="img-fluid">
                                    <?php endif;?>
                                </a>
                                <div class="mid-circle"></div>
                                <div class="min-circle"></div>
                            </div>
                            <div class="clientes-text-cont">
                                <h2> <?php echo $tienda->nombre_tienda ?> </h2>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>


            </div>
        </div>
    </div>
</div>
<!-- End CLIENTES slider Area -->

<!-- Informacion slider Area -->
<div class="info_area">
    <div class="container">
        <h1>
            ¿QUIERES <span> MÁS INFORMACIÓN? </span>
        </h1>
        <div class="separador1" ></div>
        <div class="row">
            <div class="col-xl-12">
                <div id="info_active_cf" class="owl-carousel owl-theme">
                </div>
            </div>
        </div>
        <div class="boton-solo text-center">
            <a href="https://printome.mx/blog/" class="boxed-btn">EXPLORAR</a>
        </div>
    </div>
</div>
<!-- End informacion slider Area -->
<script>
    (function ($) {
        $(document).ready(function(){

            //info slider
            $('#info_active_cf').owlCarousel({
                loop:true,
                margin:30,
                items:1,
                autoplay:false,
                navText:['<i class="ti-angle-left"></i>','<i class="ti-angle-right"></i>'],
                nav:true,
                dots:true,
                autoplayHoverPause: true,
                autoplaySpeed: 800,
                responsive:{
                    0:{
                        items:1,
                    },
                    767:{
                        items:2,
                    },
                    992:{
                        items:3
                    },
                    1200:{
                        items:3
                    },
                    1500:{
                        items:3
                    }
                }
            });

            // &_fields=id,title,excerpt,link,featured_image_src
            $.ajax({
                url: 'https://printome.mx/blog/wp-json/wp/v2/posts?per_page=6&_embed&order=desc',
                success: function(data) {
                    // console.log(data);
                    data.forEach( function(post_item, indice, array) {
                        let item_slide = `
                        <div class="info-opc">
                            <img src="${post_item.featured_image_src}" alt="" class="img-fluid">
                            <div class="info-text-cont">
                                <h2> ${post_item.title.rendered}</h2>
                                <p>  ${post_item.excerpt.rendered} </p>
                                <div class="boton-solo text-left">
                                    <a href="${post_item.link}" class="boxed-btn"> EXPLORAR </a>
                                </div>
                            </div>
                        </div>
                    `

                        $('#info_active_cf').trigger('add.owl.carousel', [item_slide]).trigger('refresh.owl.carousel');

                    });
                },
                error: function() {
                    console.log("No se ha podido obtener la información");
                }
            });

        });

    })(jQuery);
</script>
