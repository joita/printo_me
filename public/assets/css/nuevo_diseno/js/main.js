(function ($) {



    $(document).ready(function(){
        /*Testimonios*/
        $('.link-respuesta').click(function() {

            $("i", this).toggleClass("fa-angle-down fa-angle-up");
        });

// mobile_menu
        var menu = $('ul#navigation');
        if(menu.length){
            menu.slicknav({
                prependTo: ".mobile_menu",
                closedSymbol: '+',
                openedSymbol:'-'
            });
        };


//CONFIGURACION DE LOS SLIDERS:

        $('.slider_active').owlCarousel({
            loop:true,
            margin:0,
            items:1,
            autoplay:true,
            navText:['<i class="ti-angle-left"></i>','<i class="ti-angle-right"></i>'],
            nav:false,
            dots:true,
            autoplayHoverPause: true,
            autoplayTimeout:5000, //cambiar el tiempo por banner
            autoplaySpeed: 800,
            responsive:{
                0:{
                    items:1,
                    nav:false,
                },
                767:{
                    items:1,
                    nav:false,
                },
                992:{
                    items:1,
                    nav:false
                },
                1200:{
                    items:1,
                    nav:false
                },
                1600:{
                    items:1,
                    nav:false
                }
            }
        });
// review-active
        $('.slider_active2').owlCarousel({
            loop:true,
            margin:0,
            items:1,
            autoplay:true,
            navText:['<i class="ti-angle-left"></i>','<i class="ti-angle-right"></i>'],
            nav:false,
            dots:true,
            autoplayHoverPause: true,
            autoplayTimeout:5000, //cambiar el tiempo por banner
            autoplaySpeed: 800,
            responsive:{
                0:{
                    items:1,
                    nav:false,
                },
                767:{
                    items:1,
                    nav:false,
                },
                992:{
                    items:1,
                    nav:false
                },
                1200:{
                    items:1,
                    nav:false
                },
                1600:{
                    items:1,
                    nav:false
                }
            }
        });

// review-active
        $('.testmonial_active').owlCarousel({
            loop:true,
            margin:0,
            items:1,
            autoplay:true,
            navText:['<i class="ti-angle-left"></i>','<i class="ti-angle-right"></i>'],
            nav:true,
            dots:false,
            paginationSpeed: 1000,
            autoplayHoverPause: true,
            autoplaySpeed: 800,
            responsive:{
                0:{
                    items:1,
                    dots:false,
                    nav:false,
                },
                767:{
                    items:1,
                    dots:false,
                    nav:false,
                },
                992:{
                    items:1,
                    nav:false
                },
                1200:{
                    items:1,
                    nav:false
                },
                1500:{
                    items:1
                }
            }
        });

// review-active
        $('.usos_active').owlCarousel({
            loop:true,
            margin:30,
            items:1,
            autoplay:true,
            navText:['<i class="ti-angle-left"></i>','<i class="ti-angle-right"></i>'],
            nav:true,
            dots:true,
            autoplayHoverPause: true,
            autoplaySpeed: 800,
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                767:{
                    items:2,
                    nav:true
                },
                992:{
                    items:3
                },
                1200:{
                    items:4
                },
                1500:{
                    items:4
                }
            }
        });
// review-active
        $('.destacados_active').owlCarousel({
            loop:true,
            margin:30,
            items:1,
            autoplay:true,
            navText:['<i class="ti-angle-left"></i>','<i class="ti-angle-right"></i>'],
            nav:true,
            dots:true,
            autoplayHoverPause: true,
            autoplaySpeed: 800,
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                767:{
                    items:2,
                    nav:true
                },
                992:{
                    items:3
                }
            }
        });

//info slider
        $('.info_active').owlCarousel({
            loop:true,
            margin:30,
            items:1,
            autoplay:true,
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

//clientes slider
        $('.clientes_active').owlCarousel({
            loop:true,
            margin:30,
            items:1,
            autoplay:true,
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
                    items:4
                }
            }
        });

//wow slider
        $('.wow_active').owlCarousel({
            loop:true,
            margin:30,
            items:1,
            autoplay:true,
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
                    items:1,
                },
                992:{
                    items:2
                },
                1200:{
                    items:2
                },
                1500:{
                    items:2
                }
            }
        });

//testimoniales footer slider
        $('.testimonios-footer').owlCarousel({
            loop:true,
            margin:30,
            items:1,
            autoplay:true,
            navText:['<i class="ti-angle-left"></i>','<i class="ti-angle-right"></i>'],
            nav:false,
            dots:true,
            autoplayHoverPause: true,
            autoplaySpeed: 800,
            responsive:{
                0:{
                    items:1,
                },
                767:{
                    items:1,
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
//testimoniales footer slider
        $('.plantillas-empresa').owlCarousel({
            loop:true,
            margin:30,
            items:1,
            autoplay:true,
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


        /*
       * Content-Type:text/javascript
       *
       * A bridge between iPad and iPhone touch events and jquery draggable,
       * sortable etc. mouse interactions.
       * @author Oleg Slobodskoi
       *
       * modified by John Hardy to use with any touch device
       * fixed breakage caused by jquery.ui so that mouseHandled internal flag is reset
       * before each touchStart event
       *
       */
        (function( $ ) {

            $.support.touch = typeof Touch === 'object';

            if (!$.support.touch) {
                return;
            }

            var proto =  $.ui.mouse.prototype,
                _mouseInit = proto._mouseInit;

            $.extend( proto, {
                _mouseInit: function() {
                    this.element
                        .bind( "touchstart." + this.widgetName, $.proxy( this, "_touchStart" ) );
                    _mouseInit.apply( this, arguments );
                },

                _touchStart: function( event ) {
                    if ( event.originalEvent.targetTouches.length != 1 ) {
                        return false;
                    }

                    this.element
                        .bind( "touchmove." + this.widgetName, $.proxy( this, "_touchMove" ) )
                        .bind( "touchend." + this.widgetName, $.proxy( this, "_touchEnd" ) );

                    this._modifyEvent( event );

                    $( document ).trigger($.Event("mouseup")); //reset mouseHandled flag in ui.mouse
                    this._mouseDown( event );

                    return false;
                },

                _touchMove: function( event ) {
                    this._modifyEvent( event );
                    this._mouseMove( event );
                },

                _touchEnd: function( event ) {
                    this.element
                        .unbind( "touchmove." + this.widgetName )
                        .unbind( "touchend." + this.widgetName );
                    this._mouseUp( event );
                },

                _modifyEvent: function( event ) {
                    event.which = 1;
                    var target = event.originalEvent.targetTouches[0];
                    event.pageX = target.clientX;
                    event.pageY = target.clientY;
                }

            });

        })( jQuery );

//ROTAR PLAYERA - FUNCIONALIDAD BÁSICA, SE ADAPTA LUEGO POR PROGRAMADOR
        $("#switch").click(function() {
            if($( "#switch" ).hasClass( "press" )) {
                $('.camiseta').css("background-image", "url(././img/playera2.png)");
                $("#switch").removeClass( "press" );
            }else{
                $('.camiseta').css("background-image", "url(././img/playera-trasera.png)");
                $("#switch").addClass( "press" );
            }

        });

//REMOVER MODALES MOVILES

        $(function() {
            $(".close-cont-fix").click(function() {
                $(this).parents().children(".popup").fadeOut( "fast", function() {
                    $("#mask").hide();
                    $( this ).hide();
                    $("#btn-adapt").addClass( "select" );
                    $("#btn-shirt").removeClass( "select" );
                    $("#btn-font").removeClass( "select" );
                    $("#btn-image").removeClass( "select" );
                    $("#btn-star").removeClass( "select" );
                    $("#btn-layers").removeClass( "select" );
                    $("#btn-colors").removeClass( "select" );
                    $("#btn-size").removeClass( "select" );
                    $("#product-details").removeClass('colores-movil');
                    $("#cambiar-de-color-de-producto.dg-box").removeClass('mostrar');
                });
                return false;
            });

            $(".fix-text-color").click(function() {
                $(".elemento1-font-fix").hide();
                $(".elemento2-font-fix").show();

            });
            $(".fix-lapiz").click(function() {
                $(".elemento1-font-fix").show();
                $(".elemento2-font-fix").hide();

            });

//MOSTRAR U OCULTAR POPUPs contacto
            $("#show-contacto").click(function() {
                $("#mask-contacto").show();
            });
            $("#close-contacto").click(function() {
                $("#mask-contacto").hide();
            });

//MOSTRAR U OCULTAR POPUPs contactofooter
            $("#show-contactofooter").click(function() {
                $("#mask-contactofooter").show();
            });
            $("#close-contactofooter").click(function() {
                $("#mask-contactofooter").hide();
            });

//MOSTRAR U OCULTAR POPUPs contactopage
            $("#show-contactopage").click(function() {
                $("#mask-contactopage").show();
            });
            $("#close-contactopage").click(function() {
                $("#mask-contactopage").hide();
            });

//MOSTRAR U OCULTAR POPUPs login
            $("#show-login").click(function() {
                $("#mask-login").show();
            });
            $("#show-login2").click(function() {
                $("#mask-login").show();
            });
            $("#close-login").click(function() {
                $("#mask-login").modal('hide');
            });
            $("#iniciar").click(function() {
                $("#mask-login").show();
                $("#registrarse").modal('hide');
            });

//MOSTRAR U OCULTAR POPUPs register
            $("#register").click(function() {
                console.log('click');
                $("#mask-login").hide();
            });
            $("#forgot").click(function() {
                $("#mask-login").hide();
                $("#mask-login .close").trigger("click");
            });
            $("#iniciarforgot").click(function() {
                $("#mask-login").show();
                $("#mask-login").modal('show');
                $("#olvidecontraseña").modal('hide');
            });
            $("#iniciar").click(function() {
                $("#mask-login").show();
                $("#mask-login").modal('show');
                $("#registrarse").modal('hide');
            });
//MOSTRAR U OCULTAR POPUPs newsletter
            $("#show-news").click(function() {
                $("#mask-news").show();
            });
            $("#close-news").click(function() {
                $("#mask-news").hide();
            });

            //MOSTRAR U OCULTAR POPUPS, **SE HIZO BÁSICO PARA MUESTRA DE PANTALLAS** LOS PROGRAMADORES PUEDEN CAMBIAR LA FORMA EN QUE SE PRESENTAN
            $("#btn-layers").click(function() {
                if($('#layers-fix-movil').is(':visible')) {
                    $("#mask").hide();

                    $("#font-fix-movil").fadeOut();
                    $("#producto-fix-movil").fadeOut();
                    $("#image-fix-movil").fadeOut();
                    $("#star-fix-movil").fadeOut();
                    $("#layers-fix-movil").fadeOut();
                    $("#colors-fix-movil").fadeOut();
                    $("#size-fix-movil").fadeOut();
                    //EFECTO SELECCION DE BOTON
                    $("#btn-adapt").removeClass( "select" );
                    $("#btn-shirt").removeClass( "select" );
                    $("#btn-font").removeClass( "select" );
                    $("#btn-image").removeClass( "select" );
                    $("#btn-star").removeClass( "select" );
                    $("#btn-layers").removeClass( "select" );
                    $("#btn-colors").removeClass( "select" );
                    $("#btn-size").removeClass( "select" );
                    //-------------
                }else{
                    //EFECTO SELECCION DE BOTON
                    $("#btn-adapt").removeClass( "select" );
                    $("#btn-shirt").removeClass( "select" );
                    $("#btn-font").removeClass( "select" );
                    $("#btn-image").removeClass( "select" );
                    $("#btn-star").removeClass( "select" );
                    $("#btn-layers").addClass( "select" );
                    $("#btn-colors").removeClass( "select" );
                    $("#btn-size").removeClass( "select" );
                    //-------------
                    $("#font-fix-movil").fadeOut();
                    $("#producto-fix-movil").fadeOut();
                    $("#image-fix-movil").fadeOut();
                    $("#star-fix-movil").fadeOut();
                    $("#colors-fix-movil").fadeOut();
                    $("#size-fix-movil").fadeOut();

                    $("#mask").show();
                    $("#layers-fix-movil").show();
                }

            });
            /*$("#btn-star").click(function() {
              if($('#star-fix-movil').is(':visible')) {
                $("#mask").hide();

                $("#font-fix-movil").fadeOut();
                $("#producto-fix-movil").fadeOut();
                $("#image-fix-movil").fadeOut();
                $("#star-fix-movil").fadeOut();
                $("#layers-fix-movil").fadeOut();
                $("#colors-fix-movil").fadeOut();
                $("#size-fix-movil").fadeOut();
                //EFECTO SELECCION DE BOTON
                $("#btn-adapt").removeClass( "select" );
                $("#btn-shirt").removeClass( "select" );
                $("#btn-font").removeClass( "select" );
                $("#btn-image").removeClass( "select" );
                $("#btn-star").removeClass( "select" );
                $("#btn-layers").removeClass( "select" );
                $("#btn-colors").removeClass( "select" );
                $("#btn-size").removeClass( "select" );
                //-------------
              }else{
                //EFECTO SELECCION DE BOTON
                $("#btn-adapt").removeClass( "select" );
                $("#btn-shirt").removeClass( "select" );
                $("#btn-font").removeClass( "select" );
                $("#btn-image").removeClass( "select" );
                $("#btn-star").addClass( "select" );
                $("#btn-layers").removeClass( "select" );
                $("#btn-colors").removeClass( "select" );
                $("#btn-size").removeClass( "select" );
                //-------------
                $("#font-fix-movil").fadeOut();
                $("#producto-fix-movil").fadeOut();
                $("#image-fix-movil").fadeOut();
                $("#layers-fix-movil").fadeOut();
                $("#colors-fix-movil").fadeOut();
                $("#size-fix-movil").fadeOut();

                $("#mask").show();
                $("#star-fix-movil").show();
              }

            });
            $("#btn-shirt").click(function() {
              if($('#producto-fix-movil').is(':visible')) {
                $("#mask").hide();

                $("#font-fix-movil").fadeOut();
                $("#producto-fix-movil").fadeOut();
                $("#image-fix-movil").fadeOut();
                $("#star-fix-movil").fadeOut();
                $("#layers-fix-movil").fadeOut();
                $("#colors-fix-movil").fadeOut();
                $("#size-fix-movil").fadeOut();
                //EFECTO SELECCION DE BOTON
                $("#btn-adapt").removeClass( "select" );
                $("#btn-shirt").removeClass( "select" );
                $("#btn-font").removeClass( "select" );
                $("#btn-image").removeClass( "select" );
                $("#btn-star").removeClass( "select" );
                $("#btn-layers").removeClass( "select" );
                $("#btn-colors").removeClass( "select" );
                $("#btn-size").removeClass( "select" );
                //-------------
              }else{
                //EFECTO SELECCION DE BOTON
                $("#btn-adapt").removeClass( "select" );
                $("#btn-shirt").addClass( "select" );
                $("#btn-font").removeClass( "select" );
                $("#btn-image").removeClass( "select" );
                $("#btn-star").removeClass( "select" );
                $("#btn-layers").removeClass( "select" );
                $("#btn-colors").removeClass( "select" );
                $("#btn-size").removeClass( "select" );
                //-------------
                $("#font-fix-movil").fadeOut();
                $("#image-fix-movil").fadeOut();
                $("#star-fix-movil").fadeOut();
                $("#layers-fix-movil").fadeOut();
                $("#colors-fix-movil").fadeOut();
                $("#size-fix-movil").fadeOut();

                $("#mask").show();
                $("#producto-fix-movil").show();
              }

            });*/
            $("#btn-colors").click(function() {
                if($('#colors-fix-movil').is(':visible')) {
                    $("#mask").hide();

                    $("#font-fix-movil").fadeOut();
                    $("#producto-fix-movil").fadeOut();
                    $("#image-fix-movil").fadeOut();
                    $("#star-fix-movil").fadeOut();
                    $("#layers-fix-movil").fadeOut();
                    $("#colors-fix-movil").fadeOut();
                    $("#size-fix-movil").fadeOut();
                    //EFECTO SELECCION DE BOTON
                    $("#btn-adapt").removeClass( "select" );
                    $("#btn-shirt").removeClass( "select" );
                    $("#btn-font").removeClass( "select" );
                    $("#btn-image").removeClass( "select" );
                    $("#btn-star").removeClass( "select" );
                    $("#btn-layers").removeClass( "select" );
                    $("#btn-colors").removeClass( "select" );
                    $("#btn-size").removeClass( "select" );
                    $("#product-details").removeClass('colores-movil');
                    $("#cambiar-de-color-de-producto.dg-box").removeClass('mostrar');
                    //-------------
                    $("#dg-popover").hide('slow');
                    /*$("#dg-popover").hide('slow');
                    $("#mask").hide();*/
                }else{
                    //EFECTO SELECCION DE BOTON
                    $("#btn-adapt").removeClass( "select" );
                    $("#btn-shirt").removeClass( "select" );
                    $("#btn-font").removeClass( "select" );
                    $("#btn-image").removeClass( "select" );
                    $("#btn-star").removeClass( "select" );
                    $("#btn-layers").removeClass( "select" );
                    $("#btn-colors").addClass( "select" );
                    $("#btn-size").removeClass( "select" );
                    //-------------
                    $("#font-fix-movil").fadeOut();
                    $("#producto-fix-movil").fadeOut();
                    $("#image-fix-movil").fadeOut();
                    $("#star-fix-movil").fadeOut();
                    $("#layers-fix-movil").fadeOut();
                    $("#size-fix-movil").fadeOut();

                    $("#mask").show();
                    $("#colors-fix-movil").show();
                    $("#dg-popover").hide('slow');
                    $("#product-details").addClass('colores-movil');
                    $("#cambiar-de-color-de-producto.dg-box").addClass('mostrar');
                    $("#cambiar-de-color-de-producto.dg-box").addClass('mostrardos');

                }

            });
            /*$("#btn-size").click(function() {
              if($('#size-fix-movil').is(':visible')) {
                  $("#mask").hide();

                  $("#font-fix-movil").fadeOut();
                  $("#producto-fix-movil").fadeOut();
                  $("#image-fix-movil").fadeOut();
                  $("#star-fix-movil").fadeOut();
                  $("#layers-fix-movil").fadeOut();
                  $("#colors-fix-movil").fadeOut();
                  $("#size-fix-movil").fadeOut();
                  //EFECTO SELECCION DE BOTON
                  $("#btn-adapt").removeClass( "select" );
                  $("#btn-shirt").removeClass( "select" );
                  $("#btn-font").removeClass( "select" );
                  $("#btn-image").removeClass( "select" );
                  $("#btn-star").removeClass( "select" );
                  $("#btn-layers").removeClass( "select" );
                  $("#btn-colors").removeClass( "select" );
                  $("#btn-size").removeClass( "select" );
                  //-------------
              }else{
                //EFECTO SELECCION DE BOTON
                $("#btn-adapt").removeClass( "select" );
                $("#btn-shirt").removeClass( "select" );
                $("#btn-font").removeClass( "select" );
                $("#btn-image").removeClass( "select" );
                $("#btn-star").removeClass( "select" );
                $("#btn-layers").removeClass( "select" );
                $("#btn-colors").removeClass( "select" );
                $("#btn-size").addClass( "select" );
                //-------------
                $("#producto-fix-movil").fadeOut();
                $("#image-fix-movil").fadeOut();
                $("#star-fix-movil").fadeOut();
                $("#layers-fix-movil").fadeOut();
                $("#colors-fix-movil").fadeOut();
                $("#size-fix-movil").fadeOut();

                $("#mask").show();
                $("#size-fix-movil").show();
              }

            });*/
            /*$("#btn-font").click(function() {
              if($('#font-fix-movil').is(':visible')) {
                  $("#mask").hide();

                  $("#font-fix-movil").fadeOut();
                  $("#producto-fix-movil").fadeOut();
                  $("#image-fix-movil").fadeOut();
                  $("#star-fix-movil").fadeOut();
                  $("#layers-fix-movil").fadeOut();
                  $("#colors-fix-movil").fadeOut();
                  $("#size-fix-movil").fadeOut();
                  //EFECTO SELECCION DE BOTON
                  $("#btn-adapt").removeClass( "select" );
                  $("#btn-shirt").removeClass( "select" );
                  $("#btn-font").removeClass( "select" );
                  $("#btn-image").removeClass( "select" );
                  $("#btn-star").removeClass( "select" );
                  $("#btn-layers").removeClass( "select" );
                  $("#btn-colors").removeClass( "select" );
                  $("#btn-size").removeClass( "select" );
                  //-------------
              }else{
                //EFECTO SELECCION DE BOTON
                $("#btn-adapt").removeClass( "select" );
                $("#btn-shirt").removeClass( "select" );
                $("#btn-font").addClass( "select" );
                $("#btn-image").removeClass( "select" );
                $("#btn-star").removeClass( "select" );
                $("#btn-layers").removeClass( "select" );
                $("#btn-colors").removeClass( "select" );
                $("#btn-size").removeClass( "select" );
                //-------------
                $("#producto-fix-movil").fadeOut();
                $("#image-fix-movil").fadeOut();
                $("#star-fix-movil").fadeOut();
                $("#layers-fix-movil").fadeOut();
                $("#colors-fix-movil").fadeOut();
                $("#size-fix-movil").fadeOut();

                $("#mask").show();
                $("#font-fix-movil").show();
              }

            });*/
            /*$("#btn-image").click(function() {
              if($('#image-fix-movil').is(':visible')) {
                  $("#mask").hide();

                  $("#font-fix-movil").fadeOut();
                  $("#producto-fix-movil").fadeOut();
                  $("#image-fix-movil").fadeOut();
                  $("#star-fix-movil").fadeOut();
                  $("#layers-fix-movil").fadeOut();
                  $("#colors-fix-movil").fadeOut();
                  $("#size-fix-movil").fadeOut();
                  //EFECTO SELECCION DE BOTON
                  $("#btn-adapt").removeClass( "select" );
                  $("#btn-shirt").removeClass( "select" );
                  $("#btn-font").removeClass( "select" );
                  $("#btn-image").removeClass( "select" );
                  $("#btn-star").removeClass( "select" );
                  $("#btn-layers").removeClass( "select" );
                  $("#btn-colors").removeClass( "select" );
                  $("#btn-size").removeClass( "select" );
                  //-------------
              }else{
                //EFECTO SELECCION DE BOTON
                $("#btn-adapt").removeClass( "select" );
                $("#btn-shirt").removeClass( "select" );
                $("#btn-font").removeClass( "select" );
                $("#btn-image").addClass( "select" );
                $("#btn-star").removeClass( "select" );
                $("#btn-layers").removeClass( "select" );
                $("#btn-colors").removeClass( "select" );
                $("#btn-size").removeClass( "select" );
                //-------------
                $("#font-fix-movil").fadeOut();
                $("#producto-fix-movil").fadeOut();
                $("#star-fix-movil").fadeOut();
                $("#layers-fix-movil").fadeOut();
                $("#colors-fix-movil").fadeOut();
                $("#size-fix-movil").fadeOut();

                $("#mask").show();
                $("#image-fix-movil").show();
              }

            });*/

            /*$("#btn-adapt").click(function() {
              if($('#mask').is(':visible')) {
                $("#mask").hide();

                $("#font-fix-movil").fadeOut();
                $("#producto-fix-movil").fadeOut();
                $("#image-fix-movil").fadeOut();
                $("#star-fix-movil").fadeOut();
                $("#layers-fix-movil").fadeOut();
                $("#colors-fix-movil").fadeOut();
                $("#size-fix-movil").fadeOut();
                //EFECTO SELECCION DE BOTON
                $("#btn-adapt").removeClass( "select" );
                $("#btn-shirt").removeClass( "select" );
                $("#btn-font").removeClass( "select" );
                $("#btn-image").removeClass( "select" );
                $("#btn-star").removeClass( "select" );
                $("#btn-layers").removeClass( "select" );
                $("#btn-colors").removeClass( "select" );
                $("#btn-size").removeClass( "select" );
                //-------------
              }
              //EFECTO SELECCION DE BOTON
              $("#btn-adapt").addClass( "select" );
              $("#btn-shirt").removeClass( "select" );
              $("#btn-font").removeClass( "select" );
              $("#btn-image").removeClass( "select" );
              $("#btn-star").removeClass( "select" );
              $("#btn-layers").removeClass( "select" );
              $("#btn-colors").removeClass( "select" );
              $("#btn-size").removeClass( "select" );
              //-------------
            });*/

            $("#show-filtros").click(function() {
                $('# filtros-ocasion').toggle("slow");
            });

            $("#filtros_toggle").click(function() {
                $('.elementos_filtro').toggle("slow");
            });


        });

        $("#sortable").on("click", ".tabla-elim", function() {
            $(this).closest("tr").remove();
        });

        $("#list-img").find('img').bind("click", function() {
            var src = $(this).attr("src");
            $('#show-img').css("background-image", "url("+src+")");
        });

        $("#sortable tbody").sortable({
            cursor: "move",
            placeholder: "sortable-placeholder",
            helper: function(e, tr)
            {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index)
                {
                    // Set helper cell sizes to match the original sizes
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            }
        }).disableSelection();

//ponemos siempre la primer imagen de plallera en el contenedor
        var inicial_img = $("#list-img").find('img').first().attr("src");
        $('#show-img').css("background-image", "url("+inicial_img+")");

    });//end document ready




})(jQuery);	