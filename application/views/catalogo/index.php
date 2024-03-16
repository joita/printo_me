<!-- plantillas Area -->
<div class="blog_area plantillas">
    <div class="container">
        <div class="row">
            <h1 class="h1-plantillas"> <span>PLANTILLAS</span></h1>
            <div class="separador1" ></div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                <div class="sidebar-right d-none d-lg-block" >
                    <div class="title-green">
                        <h2> Filtrar por ocasión  </h2>
                    </div>
                    <ul class="vertical menu ff plant accordion-menu" data-accordion-menu>
                        <?php foreach($clasificaciones as $clasificacion): ?>
                            <?php if(($clasificacion->plantillas + $clasificacion->subplantillas) > 0): ?>
                            <?php if($search==='' || $search===null || $search === 'null'){ $search = 'null'; } ?>
                                <li class="cont_option" <?php if(sizeof($clasificacion->subclasificaciones) == 0) { activar($clasificacion_activa, $clasificacion->nombre_clasificacion_slug); } ?>>
                                    <a class="cont_option" href="<?php echo site_url('plantillas/'.$search.'/'.$clasificacion->nombre_clasificacion_slug); ?>"><?php echo $clasificacion->nombre_clasificacion; ?></a>
                                    <span class="checkmark"></span>
                                    <input type="hidden" class="clasificacion" value="<?php echo $clasificacion_activa; ?>">
                                    <input type="hidden" class="subclasificacion" value="<?php echo $subclasificacion_activa; ?>">
                                    <input type="hidden" class="subsubclasificacion" value="<?php echo $subsubclasificacion_activa; ?>">
                                    <?php if(sizeof($clasificacion->subclasificaciones)): ?>
                                        <ul class="vertical menu nested<?php if($clasificacion_activa == $clasificacion->nombre_clasificacion_slug) { echo ' is-active'; } ?>">
                                            <li<?php if(sizeof($clasificacion->subclasificaciones) > 0 && $subclasificacion_activa==='null') { activar($clasificacion_activa, $clasificacion->nombre_clasificacion_slug); } ?>>
                                                <a class="cont_option sub" href="<?php echo site_url('plantillas/'.$search.'/'.$clasificacion->nombre_clasificacion_slug); ?>">Todas</a>
                                            </li>

                                            <?php foreach($clasificacion->subclasificaciones as $indice_subclasificacion => $subclasificacion): ?>

                                                <?php if($subclasificacion->plantillas > 0): ?>
                                                    <li<?php if(sizeof($subclasificacion->subsubclasificaciones)==0){activar($subclasificacion_activa, $subclasificacion->nombre_clasificacion_slug);} ?> <?php if(sizeof($subclasificacion->subsubclasificaciones)>0){ echo "class='subsub'"; }?>>
                                                        <a class="cont_option sub" href="<?php echo site_url('plantillas/'.$search.'/'.$clasificacion->nombre_clasificacion_slug.'/'.$subclasificacion->nombre_clasificacion_slug); ?>" ><?php echo $subclasificacion->nombre_clasificacion; ?></a>
                                                        <?php if(sizeof($subclasificacion->subsubclasificaciones)): ?>
                                                            <ul class="vertical menu nested<?php if($subclasificacion_activa == $subclasificacion->nombre_clasificacion_slug) { echo ' is-active'; } ?>">
                                                                <li<?php if(sizeof($subclasificacion->subsubclasificaciones) > 0 && $subsubclasificacion_activa==='null') { activar($subclasificacion_activa, $subclasificacion->nombre_clasificacion_slug); } ?>>
                                                                    <a class="cont_option sub" href="<?php echo site_url('plantillas/'.$search.'/'.$clasificacion->nombre_clasificacion_slug).'/'.$subclasificacion->nombre_clasificacion_slug; ?>">Todas las Subcategorias</a>
                                                                </li>
                                                                <?php foreach($subclasificacion->subsubclasificaciones as $indice_subsubclasificacion => $subsubclasificacion): ?>
                                                                    <?php if($subsubclasificacion->plantillas > 0): ?>

                                                                        <li<?php activar($subsubclasificacion_activa, $subsubclasificacion->nombre_clasificacion_slug); ?>>
                                                                            <a class="cont_option sub" href="<?php echo site_url('plantillas/'.$search.'/'.$clasificacion->nombre_clasificacion_slug.'/'.$subclasificacion->nombre_clasificacion_slug.'/'.$subsubclasificacion->nombre_clasificacion_slug); ?>"><?php echo $subsubclasificacion->nombre_clasificacion; ?></a>
                                                                        </li>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <div class="boton-solo">
                        <a id="btn-ahora" class="boxed-btn">BUSCAR AHORA</a>
                    </div>

                </div>

                <div class="sidebar-right-movil d-none d-block d-lg-none" >
                    <div class="title-green" id="show-filtros">
                        <h2> Filtrar por ocasión  </h2>
                    </div>
                    <ul class="vertical menu ff plant accordion-menu" data-accordion-menu>
                        <?php foreach($clasificaciones as $clasificacion): ?>
                            <?php if(($clasificacion->plantillas + $clasificacion->subplantillas) > 0): ?>

                                <li class="cont_option" <?php if(sizeof($clasificacion->subclasificaciones) == 0) { activar($clasificacion_activa, $clasificacion->nombre_clasificacion_slug); } ?>>
                                    <a class="cont_option" href="<?php echo site_url('plantillas/'.$clasificacion->nombre_clasificacion_slug); ?>"><?php echo $clasificacion->nombre_clasificacion; ?></a>
                                    <span class="checkmark"></span>
                                    <input type="hidden" class="clasificacion" value="<?php echo $clasificacion_activa; ?>">
                                    <input type="hidden" class="subclasificacion" value="<?php echo $subclasificacion_activa; ?>">
                                    <input type="hidden" class="subsubclasificacion" value="<?php echo $subsubclasificacion_activa; ?>">
                                    <?php if(sizeof($clasificacion->subclasificaciones)): ?>
                                        <ul class="vertical menu nested<?php if($clasificacion_activa == $clasificacion->nombre_clasificacion_slug) { echo ' is-active'; } ?>">
                                            <li<?php if(sizeof($clasificacion->subclasificaciones) > 0 && $subclasificacion_activa==='null') { activar($clasificacion_activa, $clasificacion->nombre_clasificacion_slug); } ?>>
                                                <a class="cont_option sub" href="<?php echo site_url('plantillas/'.$search.'/'.$clasificacion->nombre_clasificacion_slug); ?>">Todas</a>
                                            </li>

                                            <?php foreach($clasificacion->subclasificaciones as $indice_subclasificacion => $subclasificacion): ?>

                                                <?php if($subclasificacion->plantillas > 0): ?>
                                                    <li<?php if(sizeof($subclasificacion->subsubclasificaciones)==0){activar($subclasificacion_activa, $subclasificacion->nombre_clasificacion_slug);} ?> <?php if(sizeof($subclasificacion->subsubclasificaciones)>0){ echo "class='subsub'"; }?>>
                                                        <a class="cont_option sub" href="<?php echo site_url('plantillas/'.$search.'/'.$clasificacion->nombre_clasificacion_slug.'/'.$subclasificacion->nombre_clasificacion_slug); ?>" ><?php echo $subclasificacion->nombre_clasificacion; ?></a>
                                                        <?php if(sizeof($subclasificacion->subsubclasificaciones)): ?>
                                                            <ul class="vertical menu nested<?php if($subclasificacion_activa == $subclasificacion->nombre_clasificacion_slug) { echo ' is-active'; } ?>">
                                                                <li<?php if(sizeof($subclasificacion->subsubclasificaciones) > 0 && $subsubclasificacion_activa==='null') { activar($subclasificacion_activa, $subclasificacion->nombre_clasificacion_slug); } ?>>
                                                                    <a class="cont_option sub" href="<?php echo site_url('plantillas/'.$search.'/'.$clasificacion->nombre_clasificacion_slug).'/'.$subclasificacion->nombre_clasificacion_slug; ?>">Todas las Subcategorias</a>
                                                                </li>
                                                                <?php foreach($subclasificacion->subsubclasificaciones as $indice_subsubclasificacion => $subsubclasificacion): ?>
                                                                    <?php if($subsubclasificacion->plantillas > 0): ?>

                                                                        <li<?php activar($subsubclasificacion_activa, $subsubclasificacion->nombre_clasificacion_slug); ?>>
                                                                            <a class="cont_option sub" href="<?php echo site_url('plantillas/'.$search.'/'.$clasificacion->nombre_clasificacion_slug.'/'.$subclasificacion->nombre_clasificacion_slug.'/'.$subsubclasificacion->nombre_clasificacion_slug); ?>"><?php echo $subsubclasificacion->nombre_clasificacion; ?></a>
                                                                        </li>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <!--<div id=" filtros-ocasion">
                        <label class="cont_option">Todas las plantillas
                            <input type="radio" checked="checked" name="radio">
                            <span class="checkmark"></span>
                        </label>
                        <label class="cont_option">Empresas
                            <input type="radio" name="radio">
                            <span class="checkmark"></span>
                        </label>
                        <label class="cont_option">Graduaciones
                            <input type="radio" name="radio">
                            <span class="checkmark"></span>
                        </label>
                        <label class="cont_option">Bodas
                            <input type="radio" name="radio">
                            <span class="checkmark"></span>
                        </label>
                        <label class="cont_option">14 de febrero
                            <input type="radio" name="radio">
                            <span class="checkmark"></span>
                        </label>
                        <label class="cont_option">Todas las plantillas
                            <input type="radio" checked="checked" name="radio">
                            <span class="checkmark"></span>
                        </label>
                        <label class="cont_option">Empresas
                            <input type="radio" name="radio">
                            <span class="checkmark"></span>
                        </label>
                        <label class="cont_option">Graduaciones
                            <input type="radio" name="radio">
                            <span class="checkmark"></span>
                        </label>
                        <label class="cont_option">Bodas
                            <input type="radio" name="radio">
                            <span class="checkmark"></span>
                        </label>
                        <label class="cont_option">14 de febrero
                            <input type="radio" name="radio">
                            <span class="checkmark"></span>
                        </label>
                        <div class="boton-solo">
                            <a href="#" class="boxed-btn">BUSCAR AHORA</a>
                        </div>
                    </div>-->
                </div>

            </div>



            <div class="col-xl-9 col-lg-9 col-md-12 col-12 tiendas_area">
                <div class="pagnav2 d-none d-lg-block">
                </div>
                <div class="div-search">
                    <!--<form>
                        <input class="input_search" type="text" name="search" placeholder="Buscar">
                    </form>-->
                    <?php if($search==='null'):?>
                        <input class="input_search" id="search-oculto" type="text" name="search" value="" placeholder="Buscar">
                    <?php else: ?>
                        <input class="input_search" id="search-oculto" value="<?php echo $search ?>" type="text" name="search" placeholder="Buscar">
                    <?php endif;?>
                </div>
                <div class="clear"></div>
                <div class="tienda_productos text-center">
                    <div class="row">
                        <?php foreach ($plantillas as $indice => $plantilla):?>

                            <div class="tiendas-opc <?php if($plantilla->vip == 1): echo 'opc-vip'; endif ?> col-md-4 col-sm-6 col-12 elemento_tienda"> <!-- LA CLASE OPC VIP PONE EMBLEMA DE VIP-->

                            <div class="cont_image">
                                <div class="destacados_image">
                                    <img src="<?php echo site_url($plantilla->image); ?>" alt="">
                                </div>
                            </div>
                            <div class="destacados_cont text-center">

                                    <a href="<?php echo site_url($plantilla->url); ?>" class="boxed-btn">PERSONALIZAR</a>
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