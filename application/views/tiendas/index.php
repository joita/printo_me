<!-- slider_area -->
<div class="container  d-none d-block d-sm-block d-md-none text-slider-top">
    <div class="row">
        <div class="col-12 d-md-none bg-img-flyer">
            <h1> TIENDAS DE CREADORES<br>
                <span>PRIN</span>TO<span>ME </span>
            </h1>
            <div class="separador1" ></div>
        </div>
    </div>
</div>

<div class="slider_area tiendas_slider">
    <div class="slider_active owl-carousel owl-theme">
        <div class="single_slider left-slider d-flex align-items-center  " style="background-image: url(assets/nimages/nuevo_diseno/img/banner/ban9.png) ">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4" >

                    </div>
                    <div class="col-xl-8" >
                        <div class="slider_text  d-none d-md-block">
                            <h1> TIENDAS DE CREADORES<br>
                                <span>PRIN</span>TO<span>ME </span>
                            </h1>
                            <div class="separador1" ></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="base-banner"></div>
</div>
<!-- End slider Area -->

<!-- blog Area -->
<div class="blog_area tiendas">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-12 col-12 d-none d-xl-block">
                <div class="sidebar-right">
                    <div class="title-green">
                        <h2> Filtrar búsqueda  </h2>
                    </div>
                    <input type="hidden" value="<?php echo $orden?>" id="valororden">
                    <label class="cont_option">A - Z &uarr;
                        <?php if($orden==='asc' or $orden === 'ASC'): ?>
                            <input type="radio" checked="checked" value="asc" name="radio">
                        <?php else :?>
                            <input type="radio" value="asc" name="radio">
                        <?php endif ?>
                        <span class="checkmark"></span>
                    </label>
                    <label class="cont_option">Z - A &darr;
                        <?php if($orden==='desc' or $orden === 'DESC'): ?>
                            <input type="radio" checked="checked" value="desc" name="radio">
                        <?php else :?>
                            <input type="radio" value="desc" name="radio">
                        <?php endif ?>
                        <span class="checkmark"></span>
                    </label>
                    <div class="boton-solo text-md-center text-lg-center text-xs-center">
                        <a  class="btn-vip boxed-btn-green">Creadores VIP ></a>
                        <input type="hidden" value="<?php echo $vip?>" class="valor-vip">
                    </div>

                </div>
            </div>
            <div class="col-12 d-none d-block d-sm-block d-md-block d-lg-block d-xl-none">
                <?php if($search==='null'):?>
                    <input class="input_search" id="search-oculto" type="text" name="search" value="" placeholder="Buscar">
                <?php else: ?>
                    <input class="input_search" id="search-oculto" value="<?php echo $search ?>" type="text" name="search" value="" placeholder="Buscar">
                <?php endif;?>


                <div class="boton-solo text-md-center text-lg-center text-xs-center">
                    <a class="btn-vip boxed-btn-green">Creadores VIP ></a>
                </div>
            </div>

            <div class="col-xl-9 col-md-12 col-12 tiendas_area">
                <div class="pagnav2  d-none d-xl-block">
                    <?php echo $paginacion; ?>
                </div>
                <div class="div-search  d-none d-xl-block">
                    <?php if($search==='null'):?>
                        <input class="input_search" id="search-open" value="" type="text" name="search" placeholder="Buscar">
                    <?php else: ?>
                        <input class="input_search" id="search-open" value="<?php echo $search ?>" type="text" name="search" placeholder="Buscar">
                    <?php endif;?>


                </div>
                <div class="clear"></div>
                <div class="cont-tiendas text-center">
                    <div class="row">
                        <?php foreach ($tiendas as $indice => $tienda):?>
                            <div class="tiendas-opc <?php if($tienda->vip == 1){ echo 'opc-vip'; } ?> col-xl-4 col-lg-4 col-md-6 col-sm-12"> <!-- LA CLASE OPC VIP PONE EMBLEMA DE VIP-->
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
                                <div class="tiendas-text-cont">
                                    <h2> <?php echo $tienda->nombre_tienda ?>  </h2>
                                    <div class="boton-solo text-center">
                                        <a href="<?php echo site_url()."tienda/1/".$tienda->nombre_tienda_slug; ?>" class="boxed-btn ">VISITAR TIENDA</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>


                    </div>

                </div>

                <div class="clear"></div>
                <div class="pagnav">
                    <?php echo $paginacion; ?>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- End blog Area -->