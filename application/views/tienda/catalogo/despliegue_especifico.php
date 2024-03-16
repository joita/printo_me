<!-- ficha Area -->
<div class="ficha-producto">
    <div class="container ficha-p">
        <div class="row">
            <div class="col-xl-5 col-lg-4 col-md-12 col-12">
                <div class="titu-ficha d-none d-block d-sm-block d-md-block d-lg-none">
                    <h1> <?php echo $producto->name; ?> </h1>
                    <h3> Por <span><?Php echo $autor->nombre_tienda; ?><span></h3>
                </div>
                <div id="show-img">

                </div>
                <div id="list-img">
                    <div class="row">
                        <?php if(isset($producto->front_image)): ?>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-4">
                                <img src="<?php echo site_url($producto->front_image); ?>" alt="Fotografía delantera" class="img-fluid" />
                            </div>
                        <?php endif; ?>
                        <?php if(isset($producto->back_image)): ?>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-4">
                                <img src="<?php echo site_url($producto->back_image); ?>" alt="Fotografía trasera" class="img-fluid">
                            </div>
                        <?php endif; ?>
                        <?php if(isset($producto->right_image)): ?>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-4">
                                <img src="<?php echo site_url($producto->right_image); ?>" alt="Fotografía derecha" class="img-fluid">
                            </div>
                        <?php endif; ?>
                        <?php if(isset($producto->left_image)): ?>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-4">
                                <img src="<?php echo site_url($producto->left_image); ?>" alt="Fotografía izquierda" class="img-fluid">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <div class="col-xl-7 col-lg-8 col-md-12 col-12">
                <div class="titu-ficha d-none d-lg-block">
                    <h1> <?php echo $producto->name; ?></h1>
                    <h3> Por <span><?Php echo $autor->nombre_tienda; ?><span></h3>
                </div>
                <div class="precio">
                    <?php echo redondeo($producto->price); ?>  MxN
                </div>
                <p>
                    <?php echo nl2br($producto->description); ?>

                </p>
                <p>Playera de algodón peinado orgánico con un tacto a la piel suave, impreso con tintas ecológicas que no dañan el medio ambiente.</p
                <ul>
                    <li> ISO 14001</li>
                    <li> Certificado Bluesign </li>
                </ul>
                <!--<div class="info-envio">
                    *Ésta playera cuenta con envío GRATIS
                </div>-->
                <form action="<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/agregar'); ?>" class="area-boton" method="post" data-abide novalidate>
                    <div class="filtros-producto">
                        <div class="row">
                            <div class="col-xl-4 col-md-6 col-sm-6 col-6">
                                <select name="id_sku" id="talla_elegida" required>
                                    <option value="" selected>Talla</option>
                                    <?php foreach($this->productos_modelo->obtener_skus_activos_por_color($producto->id_color) as $sku): ?>
                                        <option value="<?php echo $sku->id_sku; ?>" data-actual="<?php echo $sku->cantidad_inicial; ?>"><?php echo $sku->talla_completa; ?></option>
                                        <?php /*<option value="<?php echo $sku->id_sku; ?>" data-actual="500"><?php echo $sku->talla_completa; ?></option>*/ ?>
                                    <?php endforeach; ?>
                                </select>
                                <!--<select name="Talla">
                                    <option value="value1" selected>Talla</option>
                                    <option value="value2"> Chica</option>
                                    <option value="value2" > Mediana</option>
                                    <option value="value3"> Grande</option>
                                </select>-->
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-6 col-6">
                                <select name="cantidad" id="cantidad_campana" required>
                                    <option value="">Cantidad</option>
                                </select>
                                <!--<select name="Cantidad">
                                    <option value="value1" selected>Cantidad</option>
                                    <option value="value2"> 1</option>
                                    <option value="value2" > 2</option>
                                    <option value="value3"> 3</option>
                                </select>-->
                            </div>
                            <div class="col-xl-4 col-md-12">
                                <div class="boton-solo text-center">
                                    <a data-open="area-tabla-medidas" class="boxed-btn btn-green">TABLA DE MEDIDAS</a>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <p >Este producto está disponible en los siguientes colores. Haz clic para escoger el color que más te gusta.</p>
                                <div class="colores-producto clearfix text-center medium-text-left">
                                    <?php foreach($colores_disponibles as $indice=>$color): ?>
                                        <a class="color-switcher special" data-id_enhance="<?php echo $color->id_enhance; ?>" data-color-click="#color_<?php echo $color->id_color; ?>" data-info='<?php echo json_encode($color); ?>'><i class="fa fa-<?php if($color->id_color == $campana->id_color) { echo 'check-'; } ?>circle" style="color:<?php echo $color->codigo_color; ?>;"></i></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="boton-solo text-center">
                        <!--<a href="./carrito.php" class="add-btn">AGREGAR AL CARRITO</a>-->
                        <input type="hidden" name="id_enhance" value="<?php echo $producto->id_enhance; ?>">
                        <input type="hidden" name="tipo_enhance" value="<?php echo $producto->type; ?>">
                        <button type="submit" class="add-btn button expanded success" id="agregar-enh" onclick="if(typeof gtag != 'undefined'){ gtag('event', 'Clic', {'event_category' : 'Interacción','event_label' : 'Agregar-Carrito','value': <?php echo number_format(floor($producto->price), 0, ".", ""); ?>});}"><i class="fa fa-cart-plus"></i> Agregar a carrito</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<div id="area-tabla-medidas" class="reveal" data-reveal>
    <?php if($producto->id_producto == 13 || $producto->id_producto == 14): ?>
        <?php $this->load->view('catalogo/tablas_medidas/hombre_cuello_redondo_manga_corta'); ?>
    <?php elseif($producto->id_producto == 15 || $producto->id_producto == 16): ?>
        <?php $this->load->view('catalogo/tablas_medidas/hombre_cuello_redondo_manga_larga'); ?>
    <?php elseif($producto->id_producto == 17 || $producto->id_producto == 19): ?>
        <?php $this->load->view('catalogo/tablas_medidas/mujer_cuello_redondo_manga_corta'); ?>
    <?php elseif($producto->id_producto == 20 || $producto->id_producto == 21): ?>
        <?php $this->load->view('catalogo/tablas_medidas/mujer_cuello_v_manga_corta'); ?>
    <?php elseif($producto->id_producto == 22 || $producto->id_producto == 23): ?>
        <?php $this->load->view('catalogo/tablas_medidas/mujer_capucha_manga_larga'); ?>
    <?php elseif($producto->id_producto == 24 || $producto->id_producto == 25): ?>
        <?php $this->load->view('catalogo/tablas_medidas/juvenil_manga_corta_unisex'); ?>
    <?php elseif($producto->id_producto == 27 || $producto->id_producto == 28): ?>
        <?php $this->load->view('catalogo/tablas_medidas/juvenil_manga_larga_unisex'); ?>
    <?php elseif($producto->id_producto == 29 || $producto->id_producto == 30): ?>
        <?php $this->load->view('catalogo/tablas_medidas/infantil_manga_corta_unisex'); ?>
    <?php elseif($producto->id_producto == 31 || $producto->id_producto == 32): ?>
        <?php $this->load->view('catalogo/tablas_medidas/infantil_manga_larga_unisex'); ?>
    <?php elseif($producto->id_producto == 33 || $producto->id_producto == 34): ?>
        <?php $this->load->view('catalogo/tablas_medidas/bebe_manga_corta_unisex'); ?>
    <?php elseif($producto->id_producto == 35 || $producto->id_producto == 36): ?>
        <?php $this->load->view('catalogo/tablas_medidas/bebe_manga_larga_unisex'); ?>
    <?php else: ?>
        <?php $this->load->view('catalogo/tablas_medidas/hombre_cuello_redondo_manga_corta'); ?>
    <?php endif; ?>
</div>
<!-- End ficha Area -->

<!-- destacados_area_start -->

<div class="destacados_area">
    <div class="container destacados_container">
        <div class="dots-circle"></div>
        <h1>
            MAS DISEÑOS DE <span><?php echo $tienda->nombre_tienda; ?> </span>

        </h1>
        <div class="separador1" ></div>
        <div class="row">
            <div class="col-xl-12">
                <div class="destacados_active owl-carousel owl-theme">
                    <?php foreach ($relacionados as $indice => $relacionado):?>
                        <div class="single_destacados">
                            <div class="cont_image">
                                <div class="destacados_image">
                                    <a href="<?php echo site_url($relacionado->vinculo_producto); ?>" >
                                        <img src="<?php echo site_url($relacionado->front_image); ?>" alt="">
                                    </a>
                                </div>
                                <div class="logo-destacado">
                                    <div class="table-img">
                                        <?php if($tienda->logotipo_chico != ''): ?>
                                            <img src="<?php echo site_url('assets/images/logos/'.$tienda->logotipo_chico); ?>" alt="Diseña tu playera on-line | printome.mx" class="profile_image" />
                                        <?php else: ?>
                                            <img src="<?php echo site_url('assets/images/main_logo.svg'); ?>" alt="Diseña tu playera on-line | printome.mx" class="profile_image" />
                                        <?php endif; ?>
                                        <?php if($relacionado->wow_winner == 1):?>
                                            <div class="wow_winer"></div><!-- Añadir este div a los WOW WINNERS -->
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div class="destacados_cont text-center">
                                <h1> <?php echo $relacionado->name; ?> </h1>
                                <div class="boton-solo text-center">
                                    <a href="<?php echo site_url($relacionado->vinculo_producto); ?>" class="boxed-btn"> COMPRAR </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>

                </div>
                <div class="boton-solo text-center">
                    <a href="<?php echo site_url()."tienda/1/".$tienda->nombre_tienda_slug; ?>" class="boxed-btn btn-green"> < VER TODOS </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- destacados_area_end -->







