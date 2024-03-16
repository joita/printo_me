<div class="herramienta">
    <div class="container herramienta-web  d-lg-block" >
        <div class="row" id="big-d">
            <div class="col-md-12" id="big-design-holder" style="min-height: 800px;">
                <form method="POST" id="tool_cart" name="tool_cart">
                    <div class="product-info" id="product-attributes">
                        <input type="hidden" value="0" name="quantity" id="quantity">
                    </div>
                </form>

                <div id="design-menu" class=" col-left col-xl-3 col-lg-3 col-md-3 col-xs-3 d-md-block">
                    <div id="dg-left" class="width-100 d-sm-none">
                        <h2 id="options-header"  >PUEDES</h2>
                        <div class="dg-box div-layers no-active">
                            <div class="menu-left" id="area-paso-1">
                                <div class="cont  ">
                                    <div class="boton-solo">
                                        <a href="<?php echo site_url('plantillas'); ?>" class="cien boxed-btn btn-green"> EXPLORAR PLANTILLAS > </a>
                                    </div>
                                </div>
                                <div class="cont " id="cambiar-de-producto">
                                    <div  class="cont-btn-shirt ">
                                        <a class="arrow-btn-white general-menu view_change_products" title="Cambiar de producto" data-toggle="modal" data-target="#dg-products" > Cambiar producto </a>
                                    </div>
                                </div>

                                <div class="cont menu-left  dg-box">
                                    <div id="agrega-cosas" >
                                        <div class="cont-btn-font">
                                            <a  title="Agregar texto" class="add_item_text general-menu add-btn-white2"> Agregar nuevo texto </a>
                                        </div>
                                        <div class="cont-btn-image">
                                            <a title="Agregar imágenes" data-toggle="modal" data-target="#dg-myclipart" class="general-menu add-btn-white2"> Agregar imágenes </a>
                                        </div>
                                        <div class="cont-btn-star">
                                            <a href="#" class="add_item_clipart general-menu add-btn-white2" title="" data-toggle="modal" data-target="#dg-cliparts"> Agregar artes </a>
                                        </div>

                                    </div>

                                </div>

                                <!--<ul class="menu-left" id="area-paso-1">
                                    <li id="cambiar-de-producto" style="border: solid 2px #025573; border-radius: 10px; ">
                                        <a style=" border-radius: 10px" class="view_change_products" title="Cambiar de producto" data-toggle="modal" data-target="#dg-products"><i class="glyphicons t-shirt"></i><span> Cambiar de producto</span></a>
                                    </li>
                                    <div id="agrega-cosas">
                                        <li style="border: solid 2px #025573; border-radius: 10px; margin-top: 1rem ">
                                            <a style=" border-radius: 10px" class="add_item_text" title="Agregar texto"><i class="glyphicons font"></i><span> Agregar texto</span></a>
                                        </li>
                                        <li style="border: solid 2px #025573; border-radius: 10px ; margin-top: 1rem">
                                            <a style=" border-radius: 10px" title="Agregar imágenes" data-toggle="modal" data-target="#dg-myclipart"><i class="fa fa-image"></i><span> Agregar imágenes</span></a>
                                        </li>
                                        <li class="last" style="border: solid 2px #025573; border-radius: 10px; margin-top: 1rem ">
                                            <a style=" border-radius: 10px" class="add_item_clipart" title="" data-toggle="modal" data-target="#dg-cliparts"><i class="fa fa-star"></i><span> Agregar artes</span></a>
                                        </li>
                                    </div>
                                </ul>-->
                            </div>
                        </div>
                        <div class="dg-box  div-layers no-active">
                            <div class="layers-toolbar">
                                <button type="button" class="btn btn-default">
                                    <i class="fa fa-object-ungroup"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fa fa-angle-left"></i>
                                </button>
                            </div>

                            <div class="accordion">
                                <h2 >CAPAS DEL DISEÑO</h2>
                                <div id="dg-layers">
                                    <ul id="layers">
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div id="cambiar-de-color-de-producto" class="dg-box width-100 div-layers no-active">
                            <div class="layers-toolbar">
                                <button type="button" class="btn btn-default">
                                    <i class="fa fa-th-large"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fa fa-angle-left"></i>
                                </button>
                            </div>

                            <div class="accordion" id="cambiar-de-color-de-producto">
                                <h2 >COLOR DE TU PLAYERA</h2>
                                <div class="product-options contentHolder" id="product-details">
                                    <?php if ($product != false) : ?>
                                        <div class="content-y">
                                            <?php if (isset($product->design) && $product->design != false) : ?>
                                                <div class="product-info">
                                                    <div class="form-group product-fields">
                                                        <div class="list-colors clearfix" id="product-list-colors">
                                                            <?php for ($i=0; $i<count($product->design->color_hex); $i++) : ?>
                                                                <span class="bg-colors2 <?php if ($i==0) echo 'active'; ?>" onclick="design.products.changeColor(this, <?php echo $i; ?>)" data-product-id="<?php echo $product->id_producto; ?>" data-i="<?php echo $i; ?>" data-color-id="<?php echo $product->design->color_id[$i]; ?>" data-color="<?php echo $product->design->color_hex[$i]; ?>" style="background-color:#<?php echo $product->design->color_hex[$i]; ?>" data-placement="top" data-original-title="<?php echo url_title($product->design->color_title[$i]); ?>"></span>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!--<div class="dg-box width-100 div-layers no-active">
                           <div class="layers-toolbar">
                               <button type="button" class="btn btn-default">
                                   <i class="fa fa-tint"></i>
                               </button>
                               <button type="button" class="btn btn-default btn-sm">
                                   <i class="fa fa-angle-left"></i>
                               </button>
                           </div>
                           <diss="accordion">
                               <h2>TINTAS DE LA IMPRESIÓN</h2>
                               <div class="color-used active"></div>
                           </div>
                        </div>-->
                        <div class="boton-solo">
                            <a id="boton-tallas-personalizador" class="no-encuentras button tabla-medidas boxed-btn btn-green" data-open="area-tabla-medidas"> TABLA DE MEDIDAS > </a>
                        </div>

                        <!-- <a style="border: 2px solid #025573; border-radius: 10px; color: #FF4C00; font-weight: bold" class="no-encuentras button tabla-medidas" id="boton-tallas-personalizador" data-open="area-tabla-medidas"><i class="fa fa-sort-amount-asc"></i>
                             <span> Tabla de medidas</span>
                         </a>-->
                    </div>
                    <div id="mask" class="color-fix">
                        <!-- configurar color de playera -->
                        <div id="colors-fix-movil" class="popup">
                            <div class="cont-fix">
                                <div class="close-cont-fix"> </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                            <h1> COLOR DE TU <span>  PLAYERA </span> </h1>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="continuar-fix-movil d-none d-block d-sm-block d-md-block d-lg-none">
                        <?php if (!$this->session->has_userdata('login')): ?> <a onclick="design.ajax.addJsCompra(this)" > TERMINAR Y CONTINUAR > </a><?php else: ?>
                            <a onclick="design.ajax.addJs(this)" > TERMINAR Y CONTINUAR > </a><?php endif; ?>
                    </div>
                    <div class="menu-fix-movil d-none d-block d-sm-block d-md-block d-lg-none">
                        <div id="dg-left" class="cont-menu-fixed menu-left">
                            <a href="<?php echo site_url('plantillas'); ?>" id="btn-adapt" class="btn-fixed btn-adapt"></a>
                            <a class="arrow-btn-white view_change_products btn-fixed btn-shirt" title="Cambiar de producto" data-toggle="modal" data-target="#dg-products" id="btn-shirt" > </a>
                            <a id="btn-font" class="add_item_text add-btn-white2 btn-fixed btn-font"> </a>
                            <a id="btn-image" data-toggle="modal" data-target="#dg-myclipart" class="add-btn-white2 btn-fixed btn-image"> </a>
                            <a id="btn-star" class="add_item_clipart add-btn-white2 btn-fixed btn-star" title="" data-toggle="modal" data-target="#dg-cliparts" > </a>
                            <a id="btn-colors" class="btn-fixed btn-colors">
                                <!--<a id="btn-layers" class="btn-fixed btn-layers">
                                </a>
                                 </a>-->
                                <a id="btn-size" class="no-encuentras button tabla-medidas boxed-btn btn-green btn-fixed btn-size" data-open="area-tabla-medidas" > </a>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-xs-3" id="contenedor-popover">
                    <div class="boton-solo text-md-center text-lg-center text-xs-center">
                        <a href="javascript:void(0)" id="tutorial-link" class="dg-tool cien info-btn btn-green"> VER TUTORIAL </a>
                    </div>
                    <div class="popover right editar-herramienta" id="dg-popover">

                        <h3 ><span>Editar</span> <a href="javascript:void(0)" class="popover-close"><i class="fa fa-times"></i></a></h3>
                        <div class="popover-content">

                            <!-- BEGIN clipart edit options -->
                            <div id="options-add_item_clipart" class="dg-options">
                                <div class="dg-options-toolbar">
                                    <div aria-label="First group" role="group" class="btn-group btn-group-lg">
                                        <button class="btn btn-default btn-action-edit" type="button" data-type="edit">
                                            <i class="glyphicon glyphicon-tint"></i> <small class="clearfix">Editar colores</small>
                                        </button>
                                        <button class="btn btn-default btn-action-colors" type="button" data-type="colors">
                                            <i class="glyphicon glyphicon-tint"></i> <small class="clearfix">Colores</small>
                                        </button>
                                        <button class="btn btn-default" type="button" data-type="size">
                                            <i class="fa fa-text-height"></i> <small class="clearfix">Tamaño</small>
                                        </button>
                                        <button class="btn btn-default" type="button" data-type="rotate">
                                            <i class="fa fa-rotate-right"></i> <small class="clearfix">Rotar</small>
                                        </button>
                                        <button class="btn btn-default" type="button" data-type="functions">
                                            <i class="fa fa-cogs"></i> <small class="clearfix">designer_functions</small>
                                        </button>
                                    </div>
                                </div>

                                <div class="dg-options-content" id="area-editar-imagen">
                                    <div class="arrow"></div>
                                    <?php /*
                    <div class="row toolbar-action-edit">
                        <div id="item-print-colors">
                        </div>
                    </div>
                    */ ?>
                                    <div class="col-md-12 toolbar-action-size hide">
                                        <div class="col-xs-6 col-lg-6 align-center">
                                            <div class="form-group">
                                                <small>Ancho</small>
                                                <input type="text" size="2" id="clipart-width" readonly disabled>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-lg-6 align-center">
                                            <div class="form-group">
                                                <small>Altura</small>
                                                <input type="text" size="2" id="clipart-height" readonly disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 toolbar-action-size">
                                        <div class="col-xs-12 col-lg-12 align-center no-padding">
                                            <div class="form-group">
                                                <label for="clipart-lock">
                                                    <input type="checkbox" class="ui-lock" id="clipart-lock" /> Desbloquear proporciones
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 toolbar-action-rotate">
                                        <div class="form-group col-lg-12">
                                            <div class="row">
                                                <div class="col-xs-12 align-center">
                                                    <small style="margin-bottom: 0.4rem;">Rotar elemento</small>
                                                </div>
                                                <div class="col-xs-12 align-center">
                                                    <span class="rotate-values"><input type="text" value="0" class="input-small rotate-value" id="clipart-rotate-value" />&deg;</span>
                                                    <span class="btn btn-default btn-xs undo glyphicons refresh hide"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 toolbar-action-colors">
                                        <div id="clipart-colors">
                                            <div class="form-group col-lg-12 text-left position-static">
                                                <small>Elegir colores</small>
                                                <div id="list-clipart-colors" class="list-colors row small-up-3"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 toolbar-action-functions">
                                        <div class="col-lg-12 form-group text-center">
                            <span class="btn btn-default btn-xs" onclick="design.item.flip('x')">
                                <i class="glyphicons transfer glyphicons-12"></i> Invertir
                            </span>
                                            <span class="btn btn-default btn-xs" onclick="design.item.center()">
                                <i class="glyphicons align_center glyphicons-12"></i> Centrar
                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END clipart edit options -->

                            <!-- BEGIN Text edit options -->
                            <div id="options-add_item_text" class="dg-options">
                                <div class="dg-options-toolbar">
                                    <div aria-label="First group" role="group" class="btn-group btn-group-lg">
                                        <button class="btn btn-default" type="button" data-type="text">
                                            <i class="fa fa-pencil"></i> <small class="clearfix">Texto</small>
                                        </button>
                                        <button class="btn btn-default" type="button" data-type="fonts">
                                            <i class="fa fa-font"></i> <small class="clearfix">Fuentes</small>
                                        </button>
                                        <button class="btn btn-default" type="button" data-type="style">
                                            <i class="fa fa-align-justify"></i> <small class="clearfix">Estilo</small>
                                        </button>
                                        <button class="btn btn-default" type="button" data-type="outline">
                                            <i class="fa fa-tint"></i> <small class="clearfix">Colores</small>
                                        </button>
                                        <button class="btn btn-default" type="button" data-type="size">
                                            <i class="fa fa-text-height"></i> <small class="clearfix">Tamaño</small>
                                        </button>
                                        <button class="btn btn-default" type="button" data-type="rotate">
                                            <i class="fa fa-rotate-right"></i> <small class="clearfix">Rotar</small>
                                        </button>
                                        <button class="btn btn-default" type="button" data-type="functions">
                                            <i class="fa fa-cogs"></i> <small class="clearfix">Diseñador</small>
                                        </button>
                                    </div>
                                </div>

                                <div class="dg-options-content" id="area-editar-texto">
                                    <!--<div class="arrow"></div>-->
                                    <!-- edit text normal -->
                                    <div class="row toolbar-action-text">
                                        <div class="col-xs-12">
                                            <textarea class="text-update" data-event="keyup" data-label="text" id="enter-text"></textarea>
                                        </div>
                                    </div>

                                    <div class="row toolbar-action-fonts">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <small>Elige una fuente</small>
                                                <div class="dropdown" data-target="#dg-fonts" data-toggle="modal">
                                                    <a id="txt-fontfamily" class="pull-left" href="javascript:void(0)">
                                                        Cambiar fuente
                                                    </a>
                                                    <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s pull-right"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row toolbar-action-style">
                                        <div class="col-xs-6">
                                            <small class="bluesmall">Tipo de fuente</small>
                                            <div id="text-style">
                                                <span id="text-style-b" class="text-update btn btn-default btn-xs glyphicons bold glyphicons-12" data-event="click" data-label="styleB"></span>
                                                <span id="text-style-i" class="text-update btn btn-default btn-xs glyphicons italic glyphicons-12" data-event="click" data-label="styleI"></span>
                                                <span id="text-style-u" class="text-update btn btn-default btn-xs glyphicons text_underline glyphicons-12" data-event="click" data-label="styleU"></span>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <small class="bluesmall">Alineación</small>
                                            <div id="text-align">
                                                <span id="text-align-left" class="text-update btn btn-default btn-xs glyphicons align_left glyphicons-12" data-event="click" data-label="alignL"></span>
                                                <span id="text-align-center" class="text-update btn btn-default btn-xs glyphicons align_center glyphicons-12" data-event="click" data-label="alignC"></span>
                                                <span id="text-align-right" class="text-update btn btn-default btn-xs glyphicons align_right glyphicons-12" data-event="click" data-label="alignR"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="row toolbar-action-outline">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <small>Color</small>
                                                <div class="list-colors">
                                                    <a class="dropdown-color" id="txt-color" title="Color del texto" href="javascript:void(0)" data-color="black" data-label="color" style="background-color:black">
                                                        <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <small class="bluesmall">Borde</small>
                                            <div class="option-outline">
                                                <div class="list-colors">
                                                    <a class="dropdown-color " data-label="outline" data-placement="top" data-original-title="Color del borde" href="javascript:void(0)" data-color="none">
                                                        <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row toolbar-action-outline">
                                    <div class="col-xs-12">
                                        <small class="bluesmall" style="margin-bottom: 0.4rem;">Grosor del borde</small>
                                    </div>
                                    <div class="col-xs-10" style="padding-left: 1.2rem;">
                                        <div id="dg-outline-width"></div>
                                    </div>
                                    <div class="col-xs-2">
                                        <a class="dg-outline-value"><span class="outline-value pull-left">0</span></a>
                                    </div>
                                </div>

                                <div class="row hide">
                                    <div class="col-lg-12">
                                        <small>designer_clipart_edit_adjust_shape</small>
                                        <div id="dg-shape-width"></div>
                                    </div>
                                </div>

                                <div class="clear"></div>

                                <div class="row toolbar-action-size hide">
                                    <div class="col-xs-6 col-lg-6 align-center">
                                        <div class="form-group">
                                            <small>Ancho</small><br>
                                            <input type="text" size="2" id="text-width" readonly disabled>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-lg-6 align-center">
                                        <div class="form-group">
                                            <small>Alto</small><br>
                                            <input type="text" size="2" id="text-height" readonly disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row toolbar-action-size">
                                    <div class="col-xs-12 col-lg-12 align-center no-padding">
                                        <div class="form-group">
                                            <label for="text-lock">
                                                <input type="checkbox" class="ui-lock" id="text-lock" /> Desbloquear proporciones
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row toolbar-action-rotate">
                                    <div class="form-group col-lg-12">
                                        <div class="row">
                                            <div class="col-xs-12 align-center">
                                                <small style="margin-bottom: 0.4rem;">Rotar elemento</small>
                                            </div>
                                            <div class="col-xs-12 align-center">
                                                <span class="rotate-values"><input type="text" value="0" class="input-small rotate-value" id="text-rotate-value" />&deg;</span>
                                                <span class="btn btn-default btn-xs undo glyphicons refresh hide"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row toolbar-action-functions">
                                    <div class="col-lg-12 text-center">
                <span class="btn btn-default btn-xs" onclick="design.item.flip('x')">
                  <i class="glyphicons transfer glyphicons-12"></i>
                  Invertir
                </span>
                                        <span class="btn btn-default btn-xs" onclick="design.item.center()">
                  <i class="glyphicons align_center glyphicons-12"></i>
                  Centrar
                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END clipart edit options -->

                        <!-- END team edit options -->
                    </div>
                </div>
                <div id="dg-wapper" class="col-xl-6 col-lg-6 col-md-6 col-xs-6" >
                    <div id="dg-mask" class="loading"><span></span></div>

                    <div id="dg-designer" class="col-xl-12 col-lg-12 col-md-12">
                        <div id="design-column" class="row">
                            <div id="design-area" class="col-xl-10 col-lg-10 col-md-10 div-design-area">
                                <div id="tools" class="text-right">
                                    <ul class="dg-tools clearfix">
                                        <!--<li class="text-center show-for-medium" style="border: 2px solid #025573; border-radius: 10px; margin-right: 1rem">
                                            <a href="javascript:void(0)" id="tutorial-link" class="dg-tool">
                                                <i class="fa fa-info-circle"></i>
                                                <span>Tutorial</span>
                                            </a>
                                        </li>
                                        <li class="text-center" style="border: 2px solid #025573; border-radius: 10px; margin-right: 1rem">
                                            <a href="javascript:void(0)" data-type="preview" title="preview" class="dg-tool">
                                                <i class="fa fa-eye"></i>
                                                <span>Vista Previa</span>
                                            </a>
                                        </li>
                                        <li class="hide" style="border: 2px solid #025573; border-radius: 10px; margin-right: 1rem">
                                            <a href="javascript:void(0)" data-type="zoom" title="zoom" class="dg-tool">
                                                <i class="glyphicons search"></i>
                                                <span>Zoom</span>
                                            </a>
                                        </li>
                                        <li class="text-center" style="border: 2px solid #025573; border-radius: 10px">
                                            <a href="javascript:void(0)" data-type="reset" title="reset" class="dg-tool">
                                                <i class="fa fa-recycle"></i>
                                                <span>Limpiar</span>
                                            </a>
                                        </li>-->
                                        <?php if(isset($this->session->login)) { if($this->session->login['email'] == 'hello@printome.mx') { ?>
                                            <li class="text-center">
                                                <a href="javascript:design.save()">
                                                    <i class="fa fa-floppy-o"></i>
                                                    <span>Guardar</span>
                                                </a>
                                            </li>
                                        <?php } } ?>
                                        <!--<li class="text-center float-right" id="finish-btn" style="border-radius: 10px">
                                            <a onclick="design.ajax.addJs(this)" style="border-radius: 10px">
                                                Siguiente <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </li>-->
                                    </ul>
                                </div>
                                <div id="app-wrap" class="div-design-area">

                                    <?php if ($product == false || (isset($product->design) && $product->design == false)) : ?>
                                        <div id="view-front" class="labView active">
                                            <div class="product-design">
                                                <strong>El producto no fue encontrado.</strong>
                                            </div>
                                        </div>
                                    <?php else: ?>

                                        <div id="view-front" class="labView active">

                                            <div class="product-design"></div>
                                            <div class="design-area"><div class="content-inner" id="cont-in-tut"></div></div>
                                            <span class="lado">Frente</span>
                                        </div>

                                        <div id="view-back" class="labView">
                                            <div class="product-design"></div>
                                            <div class="design-area"><div class="content-inner"></div></div>
                                            <span class="lado">Atrás</span>
                                        </div>

                                        <div id="view-left" class="labView">
                                            <div class="product-design"></div>
                                            <div class="design-area"><div class="content-inner"></div></div>
                                            <span class="lado">Manga izquierda</span>
                                        </div>

                                        <div id="view-right" class="labView">
                                            <div class="product-design"></div>
                                            <div class="design-area"><div class="content-inner"></div></div>
                                            <span class="lado">Manga derecha</span>
                                        </div>

                                        <span id="saveme" style="display:none;">Cambios guardados.</span>

                                        <!--<span id="aclaracion">Aunque el cuadro de diseño no encaje con el área de la foto, el diseño será ajustado al momento de la impresión. Los colores y/o tonos pueden variar con lo que se muestra en la pantalla y/o archivo recibido. Printome no ofrece servicios de igualación de colores. El resultado puede variar.</span>-->
                                    <?php endif; ?>
                                </div>

                            </div>

                            <!--<span id="aclaracion_movil">Aunque el cuadro de diseño no encaje con el área de la foto, el diseño será ajustado al momento de la impresión. Los colores y/o tonos pueden variar con lo que se muestra en la pantalla y/o archivo recibido. Printome no ofrece servicios de igualación de colores. El resultado puede variar.</span>-->
                            <div class="col-xl-2 col-lg-12 col-md-12 col-xs-12" id="product-thumbs"></div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <ul class="btn-continuar">
                                    <li class="text-center float-right" id="finish-btn" style="border-radius: 10px">
                                        <?php if (!$this->session->has_userdata('login')): ?> <a  style="border-radius: 10px" onclick="design.ajax.addJsCompra(this)"> CONTINUAR <i class="fa fa-arrow-right"></i></a><?php else: ?>
                                            <a style="border-radius: 10px" onclick="design.ajax.addJs(this)"> CONTINUAR <i class="fa fa-arrow-right"></i></a><?php endif; ?>
                                    </li>
                                </ul>
                            </div>
                        </div>



                        <!--<div id="testimonios-area" class="testidis">
                    <div class="grid-item" >
                        <div class="testimonio-container" style="border: 2px solid #025573; border-radius: 10px">
                            <div class="row collapse">
                                <div class="small-18 columns">
                                    <ul>
                                        <li style=" font-size: 0.7rem; color:#025573">La medida del área de impresión máxima es de 15 cm por 12 cm para niños y de 30 cm por 35 cm para adultos, sin embargo dependiendo del diseño podrían existir variaciones en las impresiones.</li>
                                        <li style=" font-size: 0.7rem; color: #025573">Recuerda que la impresión no siempre será idéntica al color de la imagen digital. Dependerá de la calidad de la imagen proporcionada.
                                            <br>
                                            *Si tienes dudas y/o aclaraciones sobre la calidad de tu imagen contáctanos. </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php /*foreach($testimonios as $testimonio): */?>
                    <div class="grid-item" >
                        <div class="testimonio-container" style="border: 2px solid #025573; border-radius: 10px">
                            <div class="row collapse testimonio-upper-row">
                                <div class="small-18 medium-9 columns text-center medium-text-left">
                                    <div class="testimonio-rating">
                                        <?php /*echo estrellitas($testimonio->monto_calificacion); */?>
                                    </div>
                                </div>
                                <div class="small-18 medium-9 columns text-center medium-text-right">
                                    <span class="testimonio-fecha">
                                        <?php /*echo date("d.m.Y", strtotime($testimonio->fecha_calificacion)); */?>
                                    </span>
                                </div>
                            </div>
                            <div class="row collapse">
                                <div class="small-18 columns">
                                    <blockquote class="testimonio-texto" style="color:  #025573"><?php /*echo $testimonio->comentario; */?></blockquote>
                                </div>
                            </div>
                            <div class="row collapse testimonio-lower-row">
                                <span class="testimonio-nombre"><?php /*echo $testimonio->nombre; */?></span>
                            </div>
                        </div>
                    </div>
                <?php /*endforeach; */?>
                </div>-->
                    </div>

                </div>

                <div id="screen_colors_body" style="display:none;">
                    <div id="screen_colors">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Selección de tintas</h4>
                            </div>
                            <div class="modal-body">
                                <div class="screen_colors_top row">
                                    <div class="col-xs-4 col-sm-5 col-md-3 text-left" id="screen_colors_images">
                                    </div>
                                    <div class="col-xs-8 col-sm-7 col-md-9 text-left" id="explic-img">
                                        <span class="descpar">Hemos hecho una selección automática de tintas en base a la imagen que subiste, por favor revisa si coinciden y selecciona las faltantes en caso de que las haya.</span>
                                        <span class="descpar">Tener esta información nos ayuda a determinar el costo final.</span>
                                    </div>
                                </div>
                                <div class="screen_colors_mid row">
                                    <div class="col-xs-12">
                                        <span id="screen_colors_error"></span>
                                        <div id="screen_colors_list" class="list-colors"></div>
                                    </div>
                                </div>
                                <div class="screen_colors_botton row">
                                    <div class="col-xs-12 text-right">
                                        <button type="button" class="button success" onclick="design.item.setColor()">Continuar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Begin products -->
                <div class="modal fade" id="dg-products" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row" data-equalizer="thumbies" data-equalize-by-row="true">
                                    <div class="small-18 columns" id="main-contender"></div>
                                </div>
                            </div>
                            <button type="button" class="close" id="btn-modaldgproducts" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                    </div>
                </div>


                <!-- <div id="dg-products">
                     <div class="popup-contacto">
                         <div class="cont-contacto">
                             <div id="close-contacto"></div>
                             <div class="separador1"></div>
                             <div  id="main-contender"> </div>
                         </div>
                     </div>
                 </div>-->
                <!-- End products -->

                <!-- Begin clipart -->
                <div class="modal fade" id="dg-cliparts" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">

                                <div class="row">

                                    <div class="col-md-4">
                                        <label>Categorías
                                            <select id="categorias_cliparts">
                                                <?php $i=0; foreach($categorias_vectores as $categoria_vector): ?>
                                                    <option value="<?php echo $categoria_vector->id_categoria_vector; ?>"<?php if($i==0) { echo ' selected'; } ?>><?php echo $categoria_vector->nombre_categoria_vector; ?></option>
                                                    <?php $i++; endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-md-offset-6 col-md-2">
                                        <button type="button" class="close" id="btn-modaldgcliparts" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body" id="clipart-area">
                                <div id="dag-list-arts" class="row small-up-3 medium-up-5 large-up-6"></div>
                            </div>

                            <div class="modal-footer" style="display:none;">
                                <?php /*
                            <div class="align-right" id="arts-pagination" style="display:none">
                                <ul class="pagination">
                                    <li><a href="javascript:void(0)">&laquo;</a></li>
                                    <li class="active"><a href="javascript:void(0)">1</a></li>
                                    <li><a href="javascript:void(0)">2</a></li>
                                    <li><a href="javascript:void(0)">3</a></li>
                                    <li><a href="javascript:void(0)">4</a></li>
                                    <li><a href="javascript:void(0)">5</a></li>
                                    <li><a href="javascript:void(0)">&raquo;</a></li>
                                </ul>
                                <input type="hidden" value="0" autocomplete="off" id="art-number-page">
                            </div>
                            */ ?>
                                <div class="align-right" id="arts-add" style="display:none">
                                    <div class="art-detail-price"></div>
                                    <button type="button"  class="btn btn-naranja">Agregar a diseño</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End clipart -->

                <!-- Begin Upload -->
                <div class="modal fade" id="dg-myclipart" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <?php /*
                        <div class="modal-header" style="border-color:#CACACA;">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <ul role="tablist" id="upload-tabs">
                                <li class="active"><a href="#upload-computer" role="tab" data-toggle="tab"><i class="fa fa-upload"></i> Subir imagen</a></li>
                                <li><a href="#uploaded-art" role="tab" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Ver imágenes</a></li>
                            </ul>
                        </div>
                        */ ?>
                            <div class="modal-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="upload-computer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="aceptamos">Tipos de archivos que aceptamos (Máximo 20 MB por archivo)</p>
                                                <ul class="requerimientos">
                                                    <li><i class="fa fa-check"></i> Imágenes JPG (.jpg, .jpeg)</li>
                                                    <li><i class="fa fa-check"></i> Imágenes PNG (.png)</li>
                                                    <li><i class="fa fa-check"></i> Imágenes GIF no animadas (.gif)</li>
                                                </ul>
                                                <p class="aceptamos text-justify">Si tu imagen no cumple con los <a href="<?php echo site_url('terminos-y-condiciones'); ?>">términos y condiciones</a> de printome.mx, tu diseño será rechazado.</p>
                                                <p class="aceptamos text-justify">Por favor sube imágenes en buena calidad y resolución para lograr el mejor resultado en tu impresión.</p>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="upload-copyright" checked><span class="aceptamos" style="color:#555;">Al subir mi archivo confirmo que he leído y que acepto los <a href="<?php echo site_url('terminos-y-condiciones'); ?>" target="_blank">términos y condiciones</a> de printome.mx.</span>
                                                    </label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <input type="file" id="files-upload" />
                                                        </div>
                                                    </div>
                                                    <div class="hide">
                                                        <div class="form-group text-center">
                                                            <button type="button" class="button success" id="action-upload"><i class="fa fa-upload"></i> Subir</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <p class="avisowarning" style="margin-bottom:0;">Nos reservamos el derecho de impresión en caso de que las imágenes tengan derechos de autor y no se hayan provisto los permisos necesarios.</p>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">


                                                <div class="checkbox" style="display:none;">
                                                    <label>
                                                        <input type="checkbox" id="remove-bg"> <span class="help-block">Mi imagen no cuenta con fondo en blanco</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade hide" id="uploaded-art">
                                        <div class="row">
                                            <div class="small-18 columns">
                                                <p class="aceptamos">En esta sección te aparecerán todas las imágenes que hayas subido. Para insertar alguna de las imágenes a tu diseño, simplemente haz clic sobre la imagen específica.</p>
                                            </div>
                                        </div>
                                        <div class="row small-up-3" id="dag-files-images">
                                        </div>
                                        <div id="drop-area"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="loading" style="position:absolute;top:0;left:0;right:0;bottom:0;z-index:1000;display:none;"><span>Estamos subiendo y procesando tu imagen, por favor espera...<br> El proceso puede tardar un poco, dependiendo tanto del peso de la imagen como de tu conexión de internet.</span></div>


                            <button type="button" class="close" id="btn-modaldgmyclipart" data-dismiss="modal" aria-hidden="true" style="position:absolute;top:12px;right:16px;">&times;</button>
                        </div>
                    </div>
                </div>
                <!-- End Upload -->

                <!-- Begin My design -->
                <div class="modal fade" id="dg-mydesign" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Mi Diseño</h4>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End my design -->

                <!-- Begin design ideas -->
                <div class="modal fade" id="dg-designidea" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Ideas de diseño</h4>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End design ideas -->

                <!-- Begin fonts -->
                <div class="modal fade" id="dg-fonts" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" id="btn-modaldgfonts" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Elige una fuente</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 list-fonts"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End fonts -->

                <!-- Begin preview -->
                <div class="modal fade" id="dg-preview" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body" id="dg-main-slider">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End preview -->

                <div class="modal fade" id="dg-sizes" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row" data-equalizer>
                                    <div class="col-xs-6">
                                        <div class="option-container">
                                            <div class="row">
                                                <div class="col-sm-12 text-center">
                                                    <h4>Compra inmediata</h4>
                                                    <img src="<?php echo site_url('assets/nimages/cart-comprar.svg'); ?>" alt="">
                                                    <ol>
                                                        <li>Selecciona la cantidad.</li>
                                                        <li>Cotiza.</li>
                                                        <li>Haz tu pedido.</li>
                                                    </ol>
                                                    <div class="row">
                                                        <div class="col-sm-12 text-center">
                                                            <a data-dismiss="modal" data-toggle="modal" href="#paynow_modal" class="btn btn-verde">Comprar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a data-dismiss="modal" data-toggle="modal" href="#paynow_modal"></a>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="option-container">
                                            <div class="row">
                                                <div class="col-sm-12 text-center">
                                                    <h4>Venta</h4>
                                                    <img src="<?php echo site_url('assets/nimages/vender.svg'); ?>" alt="">
                                                    <ol>
                                                        <li>Prepara tu diseño.</li>
                                                        <li>Define tus metas.</li>
                                                        <li>Vende.</li>
                                                    </ol>
                                                    <div class="row">
                                                        <div class="col-sm-12 text-center">
                                                            <a class="btn btn-naranja">Vender</a>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" value="<?php echo $user['id_cliente'];?>" id="id_cliente">
                                                </div>
                                            </div>
                                            <a id="enhance_now"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="avisowarning" style="margin-top:2rem;">Acepto cada una de las vistas finales de mi diseño, quiero que se vea de ese modo.</div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="paynow_modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom: 2px solid #025573">
                                <h2 class="modal-title" >Selecciona tus tallas para cotizar</h2>
                                <p class="hide" style="font-size: 0.8rem;margin: 0.5rem 0 0;text-align: center;font-weight: bold;border: dashed 1px #ffadad;padding: 0.5rem;">Los precios varían dependiendo del modelo de la playera, el número de tintas que tiene tu diseño y el numero de áreas que deseas estampar.</p>
                            </div>
                            <div class="modal-body">
                                <div class="models-container">
                                    <div class="row collapse estilo_completo estilo_principal" data-id_producto_principal="<?php echo $product->id_producto; ?>" data-id_color_principal="">
                                        <div class="small-4 small-centered medium-4 medium-uncentered columns">
                                            <div class="main-img-container" data-base=""></div>
                                        </div>
                                        <div class="small-18 medium-14 columns">
                                            <div class="row collapse">
                                                <div class="small-18 medium-11 columns">
                                                    <div class="row">
                                                        <div class="small-18 columns" id="initial_value">
                                                            <span style="color: #025573" class="custom-prod-title"><?php echo $product->nombre_producto; ?></span>
                                                            <input type="hidden" class="hidden_cotizacion" name="cotizacion[<?php echo $product->id_producto; ?>][id_producto]" value="<?php echo $product->id_producto; ?>" />
                                                            <input type="hidden" class="hidden_cotizacion" name="cotizacion[<?php echo $product->id_producto; ?>][id_color]" id="cotizacion_color_inicial" value="" />
                                                        </div>
                                                    </div>
                                                    <div class="clearfix" id="tallitas"><?php foreach($this->catalogo_modelo->obtener_tallas_por_producto($product->id_producto) as $key=>$color): ?><div class="color_<?php echo url_title($color->nombre_color); ?> tallita" style="display:none;">
                                                            <label style="color: #EE4500;" for="input_<?php echo $color->id_sku; ?>"><?php echo $color->caracteristicas->talla; ?></label>
                                                            <select style="border: 2px solid #025573" data-id_producto="<?php echo $product->id_producto; ?>" data-cantidad-talla data-cantidad_lote="<?php echo $color->id_color; ?>" class="text-center" name="sku[<?php echo $color->id_sku; ?>]" id="input_<?php echo $color->id_sku; ?>">
                                                                <option value="0">0</option>
                                                                <?php for($i=1;$i<=$color->cantidad_inicial;$i++): ?>
                                                                    <?php //for($i=1;$i<=100;$i++): ?>
                                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                <?php endfor; ?>
                                                            </select>
                                                            </div><?php endforeach; ?>
                                                    </div>
                                                    <div class="row">
                                                        <div class="small-18 columns">
                                                            <span style="color: #EE4500;" class="cantidad">Cantidad: <span style="color: #025573"  class="cantidad_lote" data-cantidad_lote="">0</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="small-9 medium-3 columns">
                                                    <label style="color: #EE4500;" class="text-center custom-prod-title custom-price-new">Precio unidad</label>
                                                    <span style="color: #025573"  class="custom-prod-price-text" id="prunin" data-id_color_precio="" data-otro-unidad="<?php echo $product->id_producto; ?>">$ -</span>
                                                </div>
                                                <div class="small-9 medium-4 columns">
                                                    <label style="color: #EE4500;" class="text-center custom-prod-title">Subtotal</label>
                                                    <span style="color: #025573"  class="custom-prod-price-text" id="prtoin" data-id_color_precio="" data-otro-total="<?php echo $product->id_producto; ?>">$ -</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="small-18 columns">
                                            <div id="cotizacion">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="gimme-more text-center promotext" style="display:none;">Mientras más pidas, obtendrás un mejor precio.</p>
                                <div class="row" style="padding-top:1.2rem;">
                                    <div class="small-18 medium-9 text-center medium-text-left columns">
                                        <button id="regresar_dis" type="button" class="btn btn-info btn-default float-left biggie" data-dismiss="modal" ><i class="fa fa-crop" aria-hidden="true"></i> Regresar a mi diseño</button>
                                    </div>
                                    <div class="small-18 medium-9 text-center medium-text-right columns">
                                        <button id="pay_now" type="button" class="btn btn-success biggie" style="border-radius:10px;" disabled><i class="fa fa-cart-plus"></i> Agregar a carrito</button>
                                    </div>
                                </div>
                                <div class="other-models pscat" >
                                    <h2 class="modal-title clearfix" >Agrega otros estilos a tu pedido <a id="ver-otros"><i class="fa fa-refresh"></i> Ver otros</a></h2>
                                    <div class="row small-up-2 medium-up-4 otros-estilos" data-equalizer data-equalize-by-row="true">

                                    </div>
                                </div>
                            </div>

                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">close_btn</span></button>
                        </div>

                    </div>
                </div>



                <!-- BEGIN colors system -->
                <div class="o-colors" style="display:none;">
                    <div class="other-colors"></div>
                </div>
                <!-- END colors system -->


                <div id="cacheText"></div>

                <div class="modal fade" id="save-confirm" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p>La plantilla ha sido guardada, va a aparecer automáticamente en la sección plantillas. La puedes utilizar con el siguiente URL:</p>
                                <code id="link_plant"></code>
                                <div class="text-center" style="padding-top:1rem;">
                                    <button class="copier button" data-clipboard-target="#link_plant"><i class="fa fa-clipboard"></i> Copiar link</button>
                                </div>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="position:absolute;top:12px;right:16px;">&times;</button>
                        </div>
                    </div>
                </div>

                <!--end-->
            </div>
        </div>
    </div>
</div>
<div id="area-tabla-medidas" class="reveal" data-reveal>
    <?php if($product->id_producto == 13 || $product->id_producto == 14): ?>
        <?php $this->load->view('catalogo/tablas_medidas/hombre_cuello_redondo_manga_corta'); ?>
    <?php elseif($product->id_producto == 15 || $product->id_producto == 16): ?>
        <?php $this->load->view('catalogo/tablas_medidas/hombre_cuello_redondo_manga_larga'); ?>
    <?php elseif($product->id_producto == 17 || $product->id_producto == 19): ?>
        <?php $this->load->view('catalogo/tablas_medidas/mujer_cuello_redondo_manga_corta'); ?>
    <?php elseif($product->id_producto == 20 || $product->id_producto == 21): ?>
        <?php $this->load->view('catalogo/tablas_medidas/mujer_cuello_v_manga_corta'); ?>
    <?php elseif($product->id_producto == 22 || $product->id_producto == 23): ?>
        <?php $this->load->view('catalogo/tablas_medidas/mujer_capucha_manga_larga'); ?>
    <?php elseif($product->id_producto == 24 || $product->id_producto == 25): ?>
        <?php $this->load->view('catalogo/tablas_medidas/juvenil_manga_corta_unisex'); ?>
    <?php elseif($product->id_producto == 27 || $product->id_producto == 28): ?>
        <?php $this->load->view('catalogo/tablas_medidas/juvenil_manga_larga_unisex'); ?>
    <?php elseif($product->id_producto == 29 || $product->id_producto == 30): ?>
        <?php $this->load->view('catalogo/tablas_medidas/infantil_manga_corta_unisex'); ?>
    <?php elseif($product->id_producto == 31 || $product->id_producto == 32): ?>
        <?php $this->load->view('catalogo/tablas_medidas/infantil_manga_larga_unisex'); ?>
    <?php elseif($product->id_producto == 33 || $product->id_producto == 34): ?>
        <?php $this->load->view('catalogo/tablas_medidas/bebe_manga_corta_unisex'); ?>
    <?php elseif($product->id_producto == 35 || $product->id_producto == 36): ?>
        <?php $this->load->view('catalogo/tablas_medidas/bebe_manga_larga_unisex'); ?>
    <?php endif; ?>
</div>


