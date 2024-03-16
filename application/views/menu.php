<!--<div id="barra-negra" style="background: #272727; box-shadow: none">
    <div class="row collapse large-uncollapse no activo">
        <div class="large-7 xlarge-8 columns show-for-large text-left" id="ac-cont">
            <a data-open="contacto_general"><span style="line-height: 2.375rem; color: white; font-weight: bold" class="show-for-large"> Contáctanos</span></a><span style="color: white; font-weight: bold">&nbsp;&nbsp; |&nbsp;&nbsp;</span>
            <a href="<?php /*echo site_url('dudas'); */?>"><span style="line-height: 2.375rem; color: white; font-weight: bold" class="show-for-large"> FAQ</span></a>
        </div>
        <div class="small-18 medium-18 large-11 xlarge-10 columns">
            <ul id="menu-opc" class="clearfix dropdown menu" data-dropdown-menu>
                <li<?php /*if(isset($subseccion_activa)) { activar($subseccion_activa, 'favoritos'); } */?>><a style="border: none;" href="<?php /*echo site_url('mi-cuenta/favoritos'); */?>"><i class="fa fa-heart" style="color: white"></i></a></li>
                <li<?php /*activar($seccion_activa, 'carrito'); */?>><a style="border: none;" href="<?php /*echo site_url('carrito'); */?>" id="main-cart-link"><i class="fa fa-shopping-cart" style="color:white;"></i> <span class="show-for-medium">$ <?php /*echo  $this->cart->format_number($this->cart->obtener_total());  */?></span></a></li>
                <li class="sub<?php /*activar_alt($seccion_activa, 'mi-cuenta'); */?>"><a style="border: none;"><i class="fa fa-user" style="color: white;"></i><span class="show-for-medium"><?php /*if (!$this->session->has_userdata('login')): */?> Mi cuenta<?php /*else: */?> <?php /*echo $this->session->login['nombre']; */?><?php /*endif; */?></span></a>
                    <ul class="menu" style="background: #272727">
                        <?php /*if ($this->session->has_userdata('login')): */?>
                            <li<?php /*if(isset($subseccion_activa)) { activar($subseccion_activa, 'datos'); } */?>><a href="<?php /*echo site_url('mi-cuenta/datos'); */?>"><i class="fa fa-child"></i> Mis Datos</a></li>
                            <li<?php /*if(isset($subseccion_activa)) { activar($subseccion_activa, 'puntos'); } */?> ><a href="<?php /*echo site_url('mi-cuenta/puntos-printome'); */?>"><i class="fa fa-trophy"></i> Mis Puntos Printome</a></li>
                            <li<?php /*if(isset($subseccion_activa)) { activar($subseccion_activa, 'direcciones'); } */?>><a href="<?php /*echo site_url('mi-cuenta/direcciones'); */?>"><i class="fa fa-flag"></i> Mis Direcciones</a></li>
                            <li<?php /*if(isset($subseccion_activa)) { activar($subseccion_activa, 'facturacion'); } */?>><a href="<?php /*echo site_url('mi-cuenta/facturacion'); */?>"><i class="fa fa-ticket"></i> Mis Datos de Facturación</a></li>
                            <li<?php /*if(isset($subseccion_activa)) { activar($subseccion_activa, 'pedidos'); } */?>><a href="<?php /*echo site_url('mi-cuenta/pedidos'); */?>"><i class="fa fa-credit-card"></i> Mis Pedidos</a></li>
                            <li<?php /*if(isset($subseccion_activa)) { activar($subseccion_activa, 'datos-bancarios'); } */?>><a href="<?php /*echo site_url('mi-cuenta/datos-bancarios'); */?>"><i class="fa fa-money"></i> Mis Datos de Depósito</a></li>
                            <li<?php /*if(isset($subseccion_activa)) { activar($subseccion_activa, 'productos'); } */?>><a href="<?php /*echo site_url('mi-cuenta/productos'); */?>"><i class="fa fa-line-chart"></i> Mis Productos Venta Inmediata</a></li>
                            <li<?php /*if(isset($subseccion_activa)) { activar($subseccion_activa, 'productos_plazo_definido'); } */?>><a href="<?php /*echo site_url('mi-cuenta/productos-plazo-definido'); */?>"><i class="fa fa-line-chart"></i> Mis Productos Plazo Definido</a></li>

                            <?php /*if(isset($this->tienda)): */?>
                                <li<?php /*if(isset($subseccion_activa)) { activar($subseccion_activa, 'tienda'); } */?>><a href="<?php /*echo site_url('mi-cuenta/tienda'); */?>"><i class="fa fa-shopping-bag"></i> Mi Tienda</a></li>
                            <?php /*endif; */?>
                            <?php /*if(!$this->session->login['facebook']): */?>
                                <li<?php /*if(isset($subseccion_activa)) { activar($subseccion_activa, 'cambiar-contrasena'); } */?>><a href="<?php /*echo site_url('mi-cuenta/cambiar-contrasena'); */?>"><i class="fa fa-refresh"></i> Cambiar Contraseña</a></li>
                                <li><a href="<?php /*echo site_url('cerrar-sesion'); */?>" id="cerrar-link"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
                            <?php /*else: */?>
                                <li><a id="cerrar-link-fb"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
                            <?php /*endif; */?>
                        <?php /*else: */?>
                            <li><a data-open="login"><i class="fa fa-sign-in"></i> Iniciar sesión</a></li>
                            <li><a data-open="register"><i class="fa fa-user-plus"></i> Registrarse</a></li>
                        <?php /*endif; */?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>-->

<!-- header-start -->
<header id="menu-cont">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-66337302-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-66337302-2');
    </script>
    <div class="header-area">
        <div id="sticky-header" class="main-header-area">
            <div id="barra-negra">
                <div class="container">
                    <div class="row">
                        <div class="col-6 faqs d-none d-md-block ">
                            <a id="show-contacto" >Contáctanos!</a>
                            <a <?php activar($seccion_activa, 'faqs'); ?> href="<?php echo site_url('faqs'); ?>" > FAQs </a>
                        </div>
                        <div class="col-6 d-none d-md-block ">
                            <div class="cuenta-sesion">
                                <div class="dropdown">
                                    <a  class="dropbtn"><i class="fa fa-user" style="color: white;"></i><span class="show-for-medium"><?php if (!$this->session->has_userdata('login')): ?> Mi cuenta<?php else: ?> <?php echo $this->session->login['nombre']; ?> <i class="fa fa-caret-down" style="color: white;"></i><?php endif; ?></span> </a>

                                    <?php if ($this->session->has_userdata('login')): ?>
                                        <div class="dropdown-content">
                                            <ul id="menu-opc" class="menu" style="background: #272727">

                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'datos'); } ?>><a href="<?php echo site_url('mi-cuenta/datos'); ?>"><i class="fa fa-child"></i> Mis Datos</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'puntos'); } ?> ><a href="<?php echo site_url('mi-cuenta/puntos-printome'); ?>"><i class="fa fa-trophy"></i> Mis Puntos Printome</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'direcciones'); } ?>><a href="<?php echo site_url('mi-cuenta/direcciones'); ?>"><i class="fa fa-flag"></i> Mis Direcciones</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'facturacion'); } ?>><a href="<?php echo site_url('mi-cuenta/facturacion'); ?>"><i class="fa fa-ticket"></i> Mis Datos de Facturación</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'pedidos'); } ?>><a href="<?php echo site_url('mi-cuenta/pedidos'); ?>"><i class="fa fa-credit-card"></i> Mis Pedidos</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'datos-bancarios'); } ?>><a href="<?php echo site_url('mi-cuenta/datos-bancarios'); ?>"><i class="fa fa-money"></i> Mis Datos de Depósito</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'productos'); } ?>><a href="<?php echo site_url('mi-cuenta/productos'); ?>"><i class="fa fa-line-chart"></i> Mis Productos Venta Inmediata</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'productos_plazo_definido'); } ?>><a href="<?php echo site_url('mi-cuenta/productos-plazo-definido'); ?>"><i class="fa fa-line-chart"></i> Mis Productos Plazo Definido</a></li>

                                                <?php if(isset($this->tienda)): ?>
                                                    <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'tienda'); } ?>><a href="<?php echo site_url('mi-cuenta/tienda'); ?>"><i class="fa fa-shopping-bag"></i> Mi Tienda</a></li>
                                                <?php endif; ?>
                                                <?php if(!$this->session->login['facebook']): ?>
                                                    <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'cambiar-contrasena'); } ?>><a href="<?php echo site_url('mi-cuenta/cambiar-contrasena'); ?>"><i class="fa fa-refresh"></i> Cambiar Contraseña</a></li>
                                                    <li><a href="<?php echo site_url('cerrar-sesion'); ?>" id="cerrar-link"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
                                                <?php else: ?>
                                                    <li><a id="cerrar-link-fb1"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    <?php else: ?>

                                        <div class="dropdown-content">
                                            <a data-toggle="modal" data-target="#mask-login" class="correcto"><i class="fa fa-sign-in"></i> <span>Iniciar sesion</span> </a>
                                            <a  data-toggle="modal" data-target="#registrarse"><i class="fa fa-user-plus"></i> <span>Registrarse</span> </a>
                                        </div>
                                    <?php endif; ?>
                                    <!--<a href="#" class="dropbtn"><i class="fa fa-user" style="color: white;"></i> <span>Mi cuenta</span> </a>
                                    <div class="dropdown-content">
                                        <a id="show-login"  href="#"><i class="fa fa-sign-in"></i> <span>Iniciar sesion</span> </a>
                                        <a  data-toggle="modal" data-target="#registrarse"><i class="fa fa-user-plus"></i> <span>Registrarse</span> </a>
                                    </div>-->

                                </div>
                            </div>
                            <div class="enlace-top">
                                <a <?php activar($seccion_activa, 'carrito'); ?> href="<?php echo site_url('carrito'); ?>" id="main-cart-link"><i class="fa fa-shopping-cart" style="color:white;"></i> <span class="show-for-medium">$ <?php echo  $this->cart->format_number($this->cart->obtener_total());  ?></span></a>
                            </div>
                            <!--<div class="enlace-top">
                                    <a <?php /*if(isset($subseccion_activa)) { activar($subseccion_activa, 'favoritos'); } */?> href="<?php /*echo site_url('mi-cuenta/favoritos'); */?>"><i class="fa fa-heart" style="color: white"></i></a>
                                </div>-->




                        </div>
                        <!--<div class="col-4 d-block d-sm-block d-md-none tex-center">
                                <div class="enlace-top-s">
                                    <a <?php /*if(isset($subseccion_activa)) { activar($subseccion_activa, 'favoritos'); } */?> href="<?php /*echo site_url('mi-cuenta/favoritos'); */?>"><i class="fa fa-heart" style="color: white"></i></a>
                                </div>
                            </div>-->
                        <div class="col-6">
                            <div class="enlace-top-s d-block d-sm-block d-md-none tex-center">
                                <a <?php activar($seccion_activa, 'carrito'); ?> href="<?php echo site_url('carrito'); ?>" id="main-cart-link"><i class="fa fa-shopping-cart" style="color:white;"></i></a>
                            </div>
                        </div>
                        <div class="col-6 d-none d-block d-sm-block d-md-none tex-center">

                            <div class="cuenta-sesion-s text-center">
                                <div class="dropdown">
                                    <a  class="dropbtn"><i class="fa fa-user" style="color: white;"></i><span class="show-for-medium"><?php if (!$this->session->has_userdata('login')): ?> <?php else: ?> <i class="fa fa-caret-down" style="color: white;"></i><?php endif; ?></span> </a>

                                    <?php if ($this->session->has_userdata('login')): ?>
                                        <div class="dropdown-content">
                                            <ul id="menu-opc" class="menu" style="background: #272727">

                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'datos'); } ?>><a href="<?php echo site_url('mi-cuenta/datos'); ?>"><i class="fa fa-child"></i> Mis Datos</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'puntos'); } ?> ><a href="<?php echo site_url('mi-cuenta/puntos-printome'); ?>"><i class="fa fa-trophy"></i> Mis Puntos Printome</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'direcciones'); } ?>><a href="<?php echo site_url('mi-cuenta/direcciones'); ?>"><i class="fa fa-flag"></i> Mis Direcciones</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'facturacion'); } ?>><a href="<?php echo site_url('mi-cuenta/facturacion'); ?>"><i class="fa fa-ticket"></i> Mis Datos de Facturación</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'pedidos'); } ?>><a href="<?php echo site_url('mi-cuenta/pedidos'); ?>"><i class="fa fa-credit-card"></i> Mis Pedidos</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'datos-bancarios'); } ?>><a href="<?php echo site_url('mi-cuenta/datos-bancarios'); ?>"><i class="fa fa-money"></i> Mis Datos de Depósito</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'productos'); } ?>><a href="<?php echo site_url('mi-cuenta/productos'); ?>"><i class="fa fa-line-chart"></i> Mis Productos Venta Inmediata</a></li>
                                                <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'productos_plazo_definido'); } ?>><a href="<?php echo site_url('mi-cuenta/productos-plazo-definido'); ?>"><i class="fa fa-line-chart"></i> Mis Productos Plazo Definido</a></li>

                                                <?php if(isset($this->tienda)): ?>
                                                    <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'tienda'); } ?>><a href="<?php echo site_url('mi-cuenta/tienda'); ?>"><i class="fa fa-shopping-bag"></i> Mi Tienda</a></li>
                                                <?php endif; ?>
                                                <?php if(!$this->session->login['facebook']): ?>
                                                    <li<?php if(isset($subseccion_activa)) { activar($subseccion_activa, 'cambiar-contrasena'); } ?>><a href="<?php echo site_url('mi-cuenta/cambiar-contrasena'); ?>"><i class="fa fa-refresh"></i> Cambiar Contraseña</a></li>
                                                    <li><a href="<?php echo site_url('cerrar-sesion'); ?>" id="cerrar-link"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
                                                <?php else: ?>
                                                    <li><a id="cerrar-link-fb2"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    <?php else: ?>

                                        <div class="dropdown-content">
                                            <a data-toggle="modal" data-target="#mask-login"  ><i class="fa fa-sign-in"></i> <span>Iniciar sesion</span> </a>
                                            <a  data-toggle="modal" data-target="#registrarse"><i class="fa fa-user-plus"></i> <span>Registrarse</span> </a>
                                        </div>
                                    <?php endif; ?>
                                    <!--<a href="#" class="dropbtn"><i class="fa fa-user" style="color: white;"></i> <span>Mi cuenta</span> </a>
                                    <div class="dropdown-content">
                                        <a id="show-login"  href="#"><i class="fa fa-sign-in"></i> <span>Iniciar sesion</span> </a>
                                        <a  data-toggle="modal" data-target="#registrarse"><i class="fa fa-user-plus"></i> <span>Registrarse</span> </a>
                                    </div>-->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-3 col-10">
                        <div class="logo">
                            <a href="<?php echo base_url(); ?>">
                                <img src="<?php echo cdn_url('assets/images/logo.png'); ?>" class="img-fluid" alt="Printome" width="346" height="90" />
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="main-menu  d-none d-lg-block">
                            <nav>

                                <ul id="navigation">
                                    <li <?php activar($seccion_activa, 'inicio'); ?>><a href="<?php echo base_url(); ?>">Inicio</a></li>
                                    <li<?php activar($seccion_activa, 'comprar'); ?>><a href="<?php echo site_url('comprar'); ?>">Comprar</a></li>
                                    <li<?php activar($seccion_activa, 'tiendas'); ?>><a href="<?php echo site_url('tiendas'); ?>">Tiendas</a></li>
                                    <li<?php activar($seccion_activa, 'empresas'); ?>><a href="<?php echo site_url('empresas'); ?>">Empresas</a></li>
                                    <li<?php activar($seccion_activa, 'funciona'); ?>><a href="<?php echo site_url('comofunciona'); ?>">¿Cómo funciona?</a></li>
                                    <li<?php activar($seccion_activa, 'plantillas'); ?>><a href="<?php echo site_url('plantillas'); ?>">Plantillas</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 d-none d-lg-block">
                        <div class=" d-none d-lg-block">
                            <a class="boxed-btn" href="<?php if(!isset($this->session->diseno_temp)) {
                                echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                            } else {
                                if(isset($boton_personaliza)) {
                                    echo site_url((isset($boton_personaliza) ? $boton_personaliza : 'personalizar'));
                                } else {
                                    echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']);
                                }
                            } ?>"<?php activar($seccion_activa, 'personalizar'); ?>>
                                CREA TU PLAYERA
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none">
                            <a class="carrito" <?php activar($seccion_activa, 'carrito'); ?> href="<?php echo site_url('carrito'); ?>" id="main-cart-link" > </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</header>
<!-- header-end -->