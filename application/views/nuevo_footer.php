
<div class="margen-bottom"></div>
<footer >
    <div class="top-footer"></div>
    <div class="container text-md-center text-lg-center text-xs-center cont-footer">

        <div class="dots-circle-footer-top-right"></div>
        <div class="dots-triangle"></div>
        <div class="row">
            <h1>
                ¿POR QUÉ COMPRAR CON <br> <span> PRINTOME? </span>
            </h1>
            <div class="separador2" ></div>
            <div class="footer-icons">
                <div class="footer-icon">
                    <img src="<?php echo site_url('assets/nimages/nuevo_diseno/img/footer-icon-pedidos.png'); ?>" alt="">
                    <h3>
                        Sin pedidos mínimos
                    </h3>
                </div>
                <div class="footer-icon">
                    <img src="<?php echo site_url('assets/nimages/nuevo_diseno/img/footer-icon-ilim.png'); ?>" alt="">
                    <h3>
                        Diseños ilimitados
                    </h3>
                </div>
                <div class="footer-icon">
                    <img src="<?php echo site_url('assets/nimages/nuevo_diseno/img/footer-icon-plantillas.png'); ?>" alt="">
                    <h3>
                        plantillas profesionales para toda ocasión
                    </h3>
                </div>
                <div class="footer-icon">
                    <img src="<?php echo site_url('assets/nimages/nuevo_diseno/img/footer-icon-envios.png'); ?>" alt="">
                    <h3>
                        Envíos a todo México
                    </h3>
                </div>
                <div class="footer-icon ">
                    <img src="<?php echo site_url('assets/nimages/nuevo_diseno/img/footer-icon-pago.png'); ?>" alt="">
                    <h3>
                        Pago seguro
                    </h3>
                </div>
            </div>
            <h1>
                TESTIMONIALES
            </h1>
            <div class="separador2" ></div>


            <div class="testimonios-footer owl-carousel owl-theme">
                <div class="single-footer">
                    <p>
                        Hola! a todos, quiero decir que muy satisfecho con los productos, muy buena calidad en la tela y en la impresión ni se diga, felicidades, estoy próximo a adquirir más de sus productos.
                    </p>
                    <h3> Estigma Phiesco <br><span> Printome </span> </h3>
                </div>
                <div class="single-footer">
                    <p>
                        Muy fácil crear tus propios diseños y muy accesible el hecho de poder pedir desde una prenda. La calidad de las playeras y de la impresión es muy Buena! Entrega muy rápida, de verdad me sorprendió.
                    </p>
                    <h3> Guillermo Corella <br><span> Printome </span> </h3>
                </div>
                <div class="single-footer">
                    <p>
                        Encontré justo lo que buscaba en PrintToMe: - Calidad en el material de las playeras (algodón suavecito) - Calidad de impresión excelente - Un precio justo y razonable - Atención al cliente sobresaliente - Entregas y transacciones seguras Ampliamente recomendado.
                    </p>
                    <h3> Isaac AP <br><span> Printome </span> </h3>
                </div>
                <div class="single-footer">
                    <p>
                        Pedí dos camisetas y la impresión es fantástica, también en el proceso cometí un error y se me proporcionó la ayuda para solucionarlo y no tuve ningún problema. ¡Excelente calidad y servicio! por no mencionar que llegaron rapidísimo.
                    </p>
                    <h3> Dario Díaz <br><span> Printome </span> </h3>
                </div>
                <div class="single-footer">
                    <p>
                        Me encanta! llegó antes del tiempo estimado. Fué un regalo y la persona a quien se lo regalé dice que la calidad es excelente y el diseño de la prenda (un hoodie) súper cómoda. ¡Mil gracias, Printome!
                    </p>
                    <h3> Vini <br><span> Printome </span> </h3>
                </div>
                <div class="single-footer">
                    <p>
                        Fue muy fácil hacer la compra. La playera llegó incluso un día antes de lo esperado. Me da tanta confianza que abrí una tienda con mis diseños.
                    </p>
                    <h3> Dan Campos <br><span> Printome </span> </h3>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <a href="<?php echo site_url('testimonios'); ?>" class="btn-testimoniales">Ver todos los testimoniales</a>
            </div>




        </div>
        <div class="row enlaces-footer">
            <div class="col-xl-3 col-md-3 col-12 text-sm-center">
                <h2>EXPLORA</h2>
                <ul>
                    <li <?php activar($seccion_activa, 'inicio'); ?>> <a href="<?php echo base_url(); ?>" >Inicio</a> </li>
                    <li <?php activar($seccion_activa, 'funciona'); ?>> <a href="<?php echo site_url('comofunciona'); ?>" >¿Cómo funciona?</a> </li>
                    <li <?php activar($seccion_activa, 'personalizar'); ?>> <a  href="<?php if(!isset($this->session->diseno_temp)) {
                            echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                        } else {
                            if(isset($boton_personaliza)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                            }
                        } ?>" >Crea tu diseño</a> </li>
                    <li <?php activar($seccion_activa, 'comprar'); ?>> <a href="<?php echo site_url('comprar'); ?>" >Comprar</a> </li>
                    <li <?php activar($seccion_activa, 'plantillas'); ?> > <a href="<?php echo base_url('plantillas'); ?>" >Plantillas prediseñadas</a> </li>
                </ul>
            </div>
            <div class="col-xl-3 col-md-3 col-12">
                <h2>SOBRE PRINTOME</h2>
                <ul>
                    <li <?php activar($seccion_activa, 'quienessomos'); ?>> <a href="<?php echo site_url('quienessomos'); ?>" >¿Quiénes somos?</a> </li>
                    <li <?php activar($seccion_activa, 'testimonios'); ?>> <a href="<?php echo site_url('testimonios'); ?>" >Testimoniales</a> </li>
                    <li <?php activar($seccion_activa, 'politicas-de-compra'); ?>> <a href="<?php echo site_url('politicas-de-compra'); ?>" >Políticas de compra y envío</a> </li>
                    <li> <a  id="show-news" >Newsletter</a> </li>
                    <li> <a  id="show-contactofooter">Contacto </a> </li>

                </ul>
            </div>
            <div class="col-xl-3 col-md-3 col-12">
                <h2>RECURSOS</h2>
                <ul>
                    <li <?php activar($seccion_activa, 'funciona'); ?>> <a href="<?php echo site_url('comofunciona'); ?>" >Primeros pasos</a> </li>
                    <li <?php activar($seccion_activa, 'faqs'); ?>> <a href="<?php echo site_url('faqs'); ?>" >Preguntas frecuentes</a> </li>
                    <li> <a href="<?php echo site_url('blog'); ?>" >Blog</a> </li>
                </ul>
            </div>
            <div class="col-xl-3 col-md-3 col-12">
                <h2>PARA CUALQUIER OCASIÓN</h2>
                <ul>
                    <li <?php activar($seccion_activa, 'empresas'); ?>> <a href="<?php echo site_url('empresas'); ?>" >Para empresas</a> </li>
                    <li <?php activar($seccion_activa, 'tiendas'); ?>> <a href="<?php echo site_url('tiendas'); ?>" >Para tus eventos importantes</a> </li>
                    <li <?php activar($seccion_activa, 'creadoresinfluencers'); ?>> <a href="<?php echo site_url('creadoresinfluencers'); ?>" >Para creadores e influencers</a> </li>
                </ul>
            </div>

        </div>

        <div class="row extras-footer">
            <div class="col-xl-3 col-md-3 col-12 text-center">
                <img src="<?php echo site_url('assets/nimages/nuevo_diseno/img/logo-white.png'); ?>" class="img-fluid" alt="">
                <h2>Crea tu playera personalizada en minutos</h2>
                <p>Email: <a href="mailto:hello@printome.mx" class="whatslink" >hello@printome.mx </a></p>
                <p>Whatsapp: <a href="https://wa.me/529992595995" target="_blank" id="whatslink">9992-595995</a></p>
            </div>
            <div class="col-xl-3 col-md-3 col-12">
                <h1>ENVIAMOS CON</h1>
                <img src="<?php echo site_url('assets/nimages/nuevo_diseno/img/dhl.png'); ?>" class="img-fluid" alt="">
            </div>
            <div class="col-xl-3 col-md-3 col-12">
                <h1>MÉTODOS DE PAGO QUE ACEPTAMOS</h1>
                <img src="<?php echo site_url('assets/nimages/nuevo_diseno/img/metodos-pago.png'); ?>" class="img-fluid" alt="">
            </div>
            <div class="col-xl-3 col-md-3 col-12">
                <h1>SÍGUENOS EN:</h1>
                <ul>
                    <li> <a href="https://www.youtube.com/channel/UC5lC5b9lCLku8Zp3rwV-yBQ" target="_blank" class="social-yt"></a> </li>
                    <li> <a href="https://www.facebook.com/printome" target="_blank" class="social-fb"></a> </li>
                    <li> <a href="https://www.instagram.com/prin2me_mx/" target="_blank" class="social-ig"></a> </li>
                </ul>
            </div>

        </div>
    </div>
    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-sm-12 col-12 text-center">
                    <p>Todos los derechos reservados Printome 2017 - 2021. </p>
                </div>
                <div class="col-xl-6 col-lg-6 col-sm-12 col-12 text-center">
                    <a href="<?php echo site_url('terminos-y-condiciones'); ?>">Términos y condiciones</a>
                    <a href="<?php echo site_url('aviso-de-privacidad'); ?>"> Privacidad </a>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php /*$this->load->view('reveals/cupon');*/ ?>
<?php $this->load->view('reveals/newsletter'); ?>
<?php $this->load->view('reveals/login'); ?>
<?php $this->load->view('reveals/register'); ?>
<?php $this->load->view('reveals/forgot'); ?>
<?php $this->load->view('reveals/contacto_general', array('asunto' => 'Contacto desde printome.mx', 'lugar' => current_url(), 'placeholder' => 'Contáctanos y resolveremos cualquier duda que pudieras tener sobre nuestro servicio.')); ?>
<?php $this->load->view('reveals/contacto_footer', array('asunto' => 'Contacto desde printome.mx', 'lugar' => current_url(), 'placeholder' => 'Contáctanos y resolveremos cualquier duda que pudieras tener sobre nuestro servicio.')); ?>
</body>
</html>

