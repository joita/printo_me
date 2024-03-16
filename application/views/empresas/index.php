
<!-- slider_area -->
<div class="container-fluid  d-none d-block d-sm-block d-md-none text-slider-top">
    <div class="row">
        <div class="col-12 d-md-none bg-img-flyer">
            <h1> DALE PERSONALIDAD<br>
                <span>A TU NEGOCIO </span>
            </h1>
            <div class="separador1" ></div>
            <p>
                Recibe las playeras que tu negocio necesita.
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

<div class="slider_area">
    <div class="slider_active owl-carousel">
        <div class="single_slider  d-flex align-items-center  " style="background-image: url(assets/nimages/nuevo_diseno/img/banner/ban2.png) ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12" >
                        <div class="slider_text d-none d-md-block">
                            <h1> DALE PERSONALIDAD<br>
                                <span>A TU NEGOCIO </span>
                            </h1>
                            <div class="separador3" ></div>
                            <p>
                                Recibe las playeras que tu negocio necesita.
                            </p>
                            <div class="boton-solo text-left">
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

<!-- Personalización Area -->
<div class="personaliza_area">
    <div class="container">
        <div class="row">
            <h1>
                ¿POR QUÉ UTILIZAR LOS   <br><span>SERVICIOS DE PRINTOME? </span>
            </h1>
            <div class="separador1" ></div>
            <div class="personaliza-paso col-xl-3 col-md-6 col-6">
                <img src="assets/nimages/nuevo_diseno/img/utserv1.png" alt="">
                <p>
                    Explora nuestra galería de plantillas o sube tu diseño
                </p>
            </div>
            <div class="personaliza-paso col-xl-3 col-md-6 col-6">
                <img src="assets/nimages/nuevo_diseno/img/utserv2.png" alt="">
                <p>
                    Explora nuestra galería de plantillas o sube tu diseño
                </p>
            </div>
            <div class="personaliza-paso col-xl-3 col-md-6 col-6">
                <img src="assets/nimages/nuevo_diseno/img/utserv3.png" alt="">
                <p>
                    Explora nuestra galería de plantillas o sube tu diseño
                </p>
            </div>
            <div class="personaliza-paso col-xl-3 col-md-6 col-6">
                <img src="assets/nimages/nuevo_diseno/img/utserv4.png" alt="">
                <p>
                    Explora nuestra galería de plantillas o sube tu diseño
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
                EXPLORA NUESTRAS PLANTILLAS <br> PROFESIONALES <span> LISTAS PARA USAR </span>
            </h1>
            <div class="separador1" ></div>
            <div class="col-12">
                <p>
                    Crea diseños de manera fácil con nuestras plantillas
                </p>
            </div>
            <div class="plantilla-opc text-md-center text-lg-center text-xs-center col-xl-3 col-md-6 col-12">
                <img src="assets/nimages/nuevo_diseno/img/plantilla1.png" alt="" class="img-fluid">
                <h2>
                    Departamentos
                </h2>
                <div class="boton-solo text-center" >
                    <a <?php activar($seccion_activa, 'plantillas'); ?> href="<?php echo base_url('plantillas'); ?>" class="boxed-btn">EMPEZAR</a>
                </div>
            </div>
            <div class="plantilla-opc text-md-center text-lg-center text-xs-center col-xl-3 col-md-6 col-12">
                <img src="assets/nimages/nuevo_diseno/img/plantilla2.png" alt="" class="img-fluid">
                <h2>
                    Empleado del mes
                </h2>
                <div class="boton-solo text-center" >
                    <a <?php activar($seccion_activa, 'plantillas'); ?> href="<?php echo base_url('plantillas'); ?>" class="boxed-btn">EMPEZAR</a>
                </div>
            </div>
            <div class="plantilla-opc text-md-center text-lg-center text-xs-center col-xl-3 col-md-6 col-12">
                <img src="assets/nimages/nuevo_diseno/img/plantilla3.png" alt="" class="img-fluid">
                <h2>
                    Nuevo personal
                </h2>
                <div class="boton-solo text-center" >
                    <a <?php activar($seccion_activa, 'plantillas'); ?> href="<?php echo base_url('plantillas'); ?>" class="boxed-btn">EMPEZAR</a>
                </div>
            </div>
            <div class="plantilla-opc text-md-center text-lg-center text-xs-center col-xl-3 col-md-6 col-12">
                <img src="assets/nimages/nuevo_diseno/img/plantilla4.png" alt="" class="img-fluid">
                <h2>
                    Activaciones de marca
                </h2>
                <div class="boton-solo text-center" >
                    <a <?php activar($seccion_activa, 'plantillas'); ?> href="<?php echo base_url('plantillas'); ?>" class="boxed-btn">EMPEZAR</a>
                </div>
            </div>


        </div>
    </div>
</div>
<!-- End Plantilla Area -->


