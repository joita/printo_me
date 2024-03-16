<!-- Flyer Area -->
<div class="flyer_video_area">
    <div class="container flyer-container">
        <div class="row">
            <div class="col-xl-5 col-md-5 cont-flyer">
                <h1> ¿CÓMO  <span> FUNCIONA?</span></h1>
                <div class="separador3" ></div>
                <p>
                    Descubre aquí todo lo que pasa cuando creas tu playera personalizada con Printome

                </p>
            </div>
            <div class="col-xl-7 col-md-7 bg-video-flyer">
                <div id="yt-flyer" class="video-yt-flyer"> </div>
                <div class="start-video"></div>
            </div>
        </div>
        <div class="dots-circle"></div>
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

<!-- Personalización Area -->
<div class="personaliza_area">
    <div class="container">
        <div class="row">
            <h1>
                PROCESO DE   <br><span>PERSONALIZACIÓN </span>
            </h1>
            <div class="separador1" ></div>
            <div class="personaliza-paso col-xl-3 col-md-6 col-sm-6 col-12">
                <img src="assets/nimages/nuevo_diseno/img/personaliza1.png" alt="" class="img-fluid">
                <p>
                    Explora nuestra galería de plantillas o sube tu diseño
                </p>
            </div>
            <div class="personaliza-paso col-xl-3 col-md-6 col-sm-6 col-12">
                <img src="assets/nimages/nuevo_diseno/img/personaliza2.png" alt="" class="img-fluid">
                <p>
                    Selecciona la cantidad de playeras y los colores que necesites
                </p>
            </div>
            <div class="personaliza-paso col-xl-3 col-md-6 col-sm-6 col-12">
                <img src="assets/nimages/nuevo_diseno/img/personaliza3.png" alt="" class="img-fluid">
                <p>
                    haz tu pedido
                </p>
            </div>
            <div class="personaliza-paso col-xl-3 col-md-6 col-sm-6 col-12">
                <img src="assets/nimages/nuevo_diseno/img/personaliza4.png" alt="" class="img-fluid">
                <p>
                    ¡Estrena tus playeras personalizadas!
                </p>
            </div>

        </div>
    </div>
</div>
<!-- End Personalización Area -->

<!-- Plantilla Area -->
<div class="plantilla_area">
    <div class="container">
        <div class="row">
            <h1>
                ENCUENTRA LA <span> PLANTILLA PERFECTA </span>
            </h1>
            <div class="separador1" ></div>
            <div class="plantilla-opc text-md-center text-lg-center text-xs-center col-xl-6 col-md-6 col-12">
                <img src="assets/nimages/nuevo_diseno/img/plantilla-opc1.png" alt="">
                <h2>
                    PARA EMPRESAS
                </h2>
                <p>
                    Crea playeras personalizadas de la mas alta calidad para tu empresa o universidad.
                </p>
                <div class="boton-solo text-center">
                    <a <?php activar($seccion_activa, 'plantillas'); ?> href="<?php echo base_url('plantillas'); ?>" class="boxed-btn ">EXPLORAR</a>
                </div>
            </div>
            <div class="plantilla-opc text-md-center text-lg-center text-xs-center col-xl-6 col-md-6 col-12">
                <img src="assets/nimages/nuevo_diseno/img/plantilla-opc2.png" alt="">
                <h2>
                    PARA TUS EVENTOS ESPECIALES
                </h2>
                <p>
                    Haz memorable esos eventos importantes en tu vida a través de una playera personalizada
                </p>
                <div class="boton-solo text-center">
                    <a <?php activar($seccion_activa, 'plantillas'); ?> href="<?php echo base_url('plantillas'); ?>" class="boxed-btn ">EXPLORAR</a>
                </div>
            </div>


        </div>
    </div>
</div>
<!-- End Plantilla Area -->

<!-- Informacion slider Area -->
<div class="info_area">
    <div class="container">
        <h1>
            ¿QUIERES <span> MÁS INFORMACIÓN? </span>
        </h1>
        <div class="separador1" ></div>
        <div class="row">
            <div class="col-xl-12">
                <div id="info_active_cf" class="info_active owl-carousel owl-theme">

                </div>
            </div>
        </div>
        <div class="boton-solo text-center">
            <a href="https://printome.mx/blog/" class="boxed-btn ">IR AL BLOG</a>
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
<!-- Flyer IMAGE Area -->
<div class="flyer_img_area">
    <div class="container flyer-container">
        <div class="row">
            <div class="col-xl-7 col-lg-7">
                <img src="assets/nimages/nuevo_diseno/img/flyer-image1.png" alt="" class="img-fluid">
            </div>
            <div class="col-xl-5 col-lg-5 cont-flyer">
                <h1> CONOCE NUESRTO PROGRAMA DE  <span> CREADORES VIP</span></h1>
                <div class="separador1" ></div>
                <p>
                    Dale vida a tus diseños y empieza a venderlos.

                </p>
                <div class="boton-solo text-left">
                    <a href="<?php echo site_url('comprar'); ?>" class="boxed-btn ">EMPEZAR</a>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End FLYER IMAGE Area -->

