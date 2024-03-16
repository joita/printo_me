<!-- filtros Area -->
<div class="filtros_area">
    <div class="container">
        <h1>
            TIENDA DE <br> <span> <?php echo $tienda->nombre_tienda; ?> </span>
        </h1>
        <div class="separador1" ></div>
        <div class="row filtros_row text-center">

            <div class="col-xl-2 col-lg-6 col-md-12 col-sm-12 col-12 d-none d-lg-block">


                <?php if($tienda->logotipo_chico != ''): ?>
                    <img src="<?php echo site_url('assets/images/logos/'.$tienda->logotipo_chico); ?>" alt="Diseña tu playera on-line | printome.mx" class="img-fluid" />
                <?php else: ?>
                    <img src="<?php echo site_url('assets/images/main_logo.svg'); ?>" alt="Diseña tu playera on-line | printome.mx" class="img-fluid" />
                <?php endif; ?>

            </div>
            <div class="col-xl-2 col-lg-6 col-md-12 col-sm-12 col-12 d-none d-lg-block">
                <a href="<?php echo site_url()."tienda/1/".$tienda->nombre_tienda_slug; ?>" class="title-tienda <?php if($tipo_tienda==1) { echo 'active'; } ?>">Todos los productos</a>
            </div>
            <div class="col-xl-2 col-lg-6 col-md-12 col-sm-12 col-12 d-none d-lg-block">
                <select  id="colecciones" name="colecciones">

                    <option value="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'idClasificacion:*'); ?>"><i class="fa fa-tags"></i> Todos</option>
                    <?php foreach($clasificaciones2 as $clasificacion): ?>
                        <option value="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'idClasificacion:'.$clasificacion->id_clasificacion); ?>"<?php if(isset($filtros['idClasificacion'])) { if($filtros['idClasificacion'] == $clasificacion->id_clasificacion) { echo ' selected'; } } ?>><?php echo $clasificacion->nombre_clasificacion; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-xl-2 col-lg-6 col-md-12 col-sm-12 col-12 d-none d-lg-block">
                <a href="<?php echo site_url()."tienda/2/".$tienda->nombre_tienda_slug; ?>" class="title-tienda <?php if($tipo_tienda==2) { echo 'active'; } ?>">Printome Wow winners</a>
            </div>
            <div class="col-xl-1 col-lg-6 col-md-12 col-sm-12 col-12 d-none d-lg-block">
                <a href="<?php echo site_url()."tienda/3/".$tienda->nombre_tienda_slug; ?>" class="title-tienda <?php if($tipo_tienda==3) { echo 'active'; } ?>">Más vendidos</a>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12 d-none d-lg-block">
                <form method="get" id="form-buscador-catalogo" enctype="application/x-www-form-urlencoded" data-abide novalidate>
                    <input type="text" class="input_search" id="buscador-catalogo" name="search" placeholder="Buscar"<?php if(isset($filtros['busqueda'])) { echo ' value="'.$filtros['busqueda'].'"'; } ?> />
                    <input type="hidden" id="urstr-busc" value="<?php echo uri_string(); ?>" />
                    <input type="hidden" id="filtr-busc" value="<?php echo generar_url_filtro($filtros); ?>" />
                    <?php if(isset($filtros['busqueda'])): ?>
                        <button type="button" id="limpbus"><i class="fa fa-times"></i></button>
                    <?php endif; ?>
                    <button type="submit" id="buscme"><i class="fa fa-search"></i></button>
                </form>
            </div>

            <div class="col-6 d-none d-block d-sm-block d-md-block d-lg-none">
                <img src="./img/logo-dog.png" alt="" class="img-fluid">
            </div>
            <div class="col-6 filtros_group text-center d-none d-block d-sm-block d-md-block d-lg-none" id="filtros_toggle">

            </div>
            <div class="col-12 elementos_filtro">

                <div class="">
                    <a href="<?php echo site_url()."tienda/1/".$tienda->nombre_tienda_slug; ?>" class="title-tienda <?php if($tipo_tienda==1) { echo 'active'; } ?>">Todos los productos</a>
                </div>
                <div class="">
                    <select id="colecciones" name="colecciones">

                        <option value="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'idClasificacion:*'); ?>"><i class="fa fa-tags"></i> Todos</option>
                        <?php foreach($clasificaciones2 as $clasificacion): ?>
                            <option value="<?php echo current_url(); ?><?php echo generar_url_filtro($filtros, 'idClasificacion:'.$clasificacion->id_clasificacion); ?>"<?php if(isset($filtros['idClasificacion'])) { if($filtros['idClasificacion'] == $clasificacion->id_clasificacion) { echo ' selected'; } } ?>><?php echo $clasificacion->nombre_clasificacion; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="">
                    <a href="<?php echo site_url()."tienda/2/".$tienda->nombre_tienda_slug; ?>" class="title-tienda <?php if($tipo_tienda==2) { echo 'active'; } ?>">Printome Wow winners</a>
                </div>
                <div class="">
                    <a href="<?php echo site_url()."tienda/3/".$tienda->nombre_tienda_slug; ?>" class="title-tienda <?php if($tipo_tienda==3) { echo 'active'; } ?>">Más vendidos</a>
                </div>
                <div class="">
                    <form method="get" id="form-buscador-catalogo" enctype="application/x-www-form-urlencoded" data-abide novalidate>
                        <input type="text" class="input_search" id="buscador-catalogo" name="search" placeholder="Buscar"<?php if(isset($filtros['busqueda'])) { echo ' value="'.$filtros['busqueda'].'"'; } ?> />
                        <input type="hidden" id="urstr-busc" value="<?php echo uri_string(); ?>" />
                        <input type="hidden" id="filtr-busc" value="<?php echo generar_url_filtro($filtros); ?>" />
                        <?php if(isset($filtros['busqueda'])): ?>
                            <button type="button" id="limpbus"><i class="fa fa-times"></i></button>
                        <?php endif; ?>
                        <button type="submit" id="buscme"><i class="fa fa-search"></i></button>
                    </form>
                </div>

            </div>

        </div>

    </div>
</div>
<!-- End filtros Area -->
<!-- tienda_prodcutos area -->
<div class="tienda_productos">
    <div class="container">
        <div class="row">
            <?php if(sizeof($productos) > 0): ?>
                <?php foreach($productos as $producto): ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 elemento_tienda">
                        <div class="cont_image">
                            <div class="destacados_image">
                                <a href="<?php echo site_url($producto->vinculo_producto); ?>">
                                    <img src="<?php echo site_url($producto->front_image); ?>" alt="Fotografía del producto <?php echo $producto->name; ?>">
                                </a>
                            </div>
                            <?php if($producto->wow_winner == 1):?>
                                <div class="wow_winer"></div><!-- Añadir este div a los WOW WINNERS -->
                            <?php endif ?>
                        </div>
                        <div class="destacados_cont text-center">
                            <h1> <?php echo $producto->name; ?></h1>
                            <a href="<?php echo site_url($producto->vinculo_producto); ?>" class="boxed-btn">COMPRAR</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-md-12">
                    <h1>No hay productos activos en esta tienda.</h1>
                </div>
            <?php endif; ?>



        </div>
        <div class="pagnav">
            <?php echo $paginacion; ?>
        </div>
        <div class="boton-solo text-center">
            <a href="<?php echo site_url('tiendas'); ?>" class="boxed-btn ">VOLVER A TODAS LAS TIENDAS</a>
        </div>

        <!-- tienda area end -->

        <!-- infoimage -->
        <div class="row infoimage-left">
            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                <h1>
                    ACERCA DE  <br> <span> <?php echo $tienda->nombre_tienda; ?> </span>
                </h1>
                <div class="separador1" ></div>
                <p>
                    <?php echo $tienda->descripcion_tienda; ?>
                </p>
                <div class="share">
                    <h2> ENCUÉNTRALO EN: </h2>
                    <ul>
                        <?php if($tienda->youtube != '' && $tienda->youtube != null): ?>
                            <li> <a href="<?php echo $tienda->youtube; ?>" target="_blank" class="social-yt"></a> </li>
                        <?php else: ?>
                            <li> <a   class="social-yt icon-gray"></a> </li>
                        <?php endif; ?>
                        <?php if($tienda->instagram != '' && $tienda->instagram != null): ?>
                            <li> <a href="<?php echo $tienda->instagram; ?>" target="_blank" class="social-ig"></a> </li>
                        <?php else: ?>
                            <li> <a  disabled class="social-ig icon-gray"></a> </li>
                        <?php endif; ?>
                        <?php if($tienda->facebook != '' && $tienda->facebook != null): ?>
                            <li> <a href="<?php echo $tienda->facebook; ?>" target="_blank" class="social-fb"></a> </li>
                        <?php else: ?>
                            <li> <a  disabled class="social-fb icon-gray"></a> </li>
                        <?php endif; ?>
                        <?php if($tienda->twitter != '' && $tienda->twitter != null): ?>
                            <li> <a href="<?php echo $tienda->twitter; ?>" target="_blank" class="social-tw"></a> </li>
                        <?php else: ?>
                            <li> <a disabled class="social-tw icon-gray"></a> </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                <?php if($tienda->imagen_acercade != ''): ?>
                    <img  src="<?php echo site_url('assets/images/acercade/'.$tienda->imagen_acercade); ?>" class="img-fluid img-tienda " alt="" />
                <?php else: ?>
                    <img  src="<?php echo site_url('assets/images/sin-imagen.jpg'); ?>" class="img-fluid img-tienda" alt="" />
                <?php endif; ?>

            </div>
        </div>
        <!-- infoimage end -->

    </div>
</div>