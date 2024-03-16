<div class="row">
    <div class="small-24 columns">
        <h2 class="section-title">Slider</h2>
    </div>
</div>
<div class="row">
    <div class="small-24 columns">
        <ul class="tabs" data-tab role="tablist">
            <li class="tab-title active" role="presentation"><a id="sliderinicio" href="#panel2-1" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-1"><i class="fa fa-building-o"></i> Inicio</a></li>
            <li class="tab-title" role="presentation"><a id="panelwow" href="#panel2-2" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-2"><i class="fa fa-building-o"></i> Comprar</a></li>
        </ul>
        <div class="tabs-content">
            <section role="tabpanel" aria-hidden="false" class="content active" id="panel2-1">
                <div class="row" data-equalizer style="padding:0 1rem">
                    <div class="small-24 end columns navholder" data-equalizer-watch>
                        <a href="#" data-reveal-id="nuevo_banner" class="coollink"><i class="fa fa-plus"></i> Nuevo Banner</a>
                    </div>
                </div>
                <div class="row">
                    <div class="small-24 columns">
                        <div id="slides_list" class="list-group">
                            <?php foreach($slides as $slide):?>
                                <div id="slide_item" class="list-group-item" data-eqalizer data-id_slide="<?php echo $slide->id_slide?>">
                                    <div class="row collapse" data-equalizer>
                                        <div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>
                                            <i class="fa fa-arrows "></i>
                                        </div>
                                        <div class="small-9 columns" id="foto" data-equalizer-watch>
                                            <img src="<?php echo site_url($slide->directorio."/".$slide->imagen_small);?>" style="display: block">
                                        </div>
                                        <div class="small-9 columns" id="datos_foto" data-equalizer-watch>
                                            <b>Nombre Foto:</b> <?php echo $slide->nombre_imagen;?><br/>
                                            <b>Alt:</b> <?php echo $slide->alt;?> </br/>
                                            <b>Botón:</b> <?php echo $slide->boton;?> </br/>
                                            <b>Texto:</b> <?php echo $slide->texto;?> </br/>
                                            <b>Texto principal:</b> <?php echo $slide->texto_principal;?> </br/>
                                            <b>Link:</b> <a class="link" href="<?php echo $slide->url_slide;?>"><i class="fa fa-link"></i></a>
                                        </div>
                                        <div class="small-5 columns" id="opciones" data-boton="<?php echo $slide->boton;?> " data-texto="<?php echo $slide->texto;?>" data-texto_principal="<?php echo $slide->texto_principal;?>" data-id_slide ="<?php echo $slide->id_slide?>" data-nombre_imagen="<?php echo $slide->nombre_imagen;?>" data-alt="<?php echo $slide->alt;?>" data-link="<?php echo $slide->url_slide;?>" data-equalizer-watch>
                                            <a href="#" class="edit-slide" data-reveal-id="editar_banner"><i class="fa fa-edit"></i> Editar Slide</i></a></br/>
                                            <?php if($slide->estatus == 1): ?>
                                                <a class="enabled"><i class="fa fa-toggle-on"></i> Habilitado</a></br/>
                                            <?php else: ?>
                                                <a class="disabled"><i class="fa fa-toggle-off"></i> Deshabilitado</a></br/>
                                            <?php endif; ?>
                                            <a class="delete-slide" data-reveal-id="borrar_slide"><i class="fa fa-times"></i> Borrar</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </section>
            <section role="tabpanel" aria-hidden="true" class="content" id="panel2-2">
                <div class="row" data-equalizer style="padding:0 1rem">
                    <div class="small-24 end columns navholder" data-equalizer-watch>
                        <a href="#" data-reveal-id="nuevo_comprar" class="coollink"><i class="fa fa-plus"></i> Nuevo Banner</a>
                    </div>
                </div>
                <div class="row">
                    <div class="small-24 columns">
                        <div id="comprar_list" class="list-group">
                            <?php foreach($slidescomprar as $comprar):?>
                                <div id="slide_item" class="list-group-item" data-eqalizer data-id_slide_comprar="<?php echo $comprar->id_slide_comprar?>">
                                    <div class="row collapse" data-equalizer>
                                        <div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>
                                            <i class="fa fa-arrows "></i>
                                        </div>
                                        <div class="small-9 columns" id="foto" data-equalizer-watch>
                                            <img src="<?php echo site_url($comprar->directorio."/".$comprar->imagen_small);?>" style="display: block">
                                        </div>
                                        <div class="small-9 columns" id="datos_foto" data-equalizer-watch>
                                            <b>Ahora si:</b> <?php echo $comprar->nombre_imagen;?><br/>
                                            <b>Alt:</b> <?php echo $comprar->alt;?> </br/>
                                            <b>Botón:</b> <?php echo $comprar->boton;?> </br/>
                                            <b>Texto:</b> <?php echo $comprar->texto;?> </br/>
                                            <b>Texto principal:</b> <?php echo $comprar->texto_principal;?> </br/>
                                            <b>Link:</b> <a class="link" href="<?php echo $comprar->url_slide;?>"><i class="fa fa-link"></i></a>
                                        </div>
                                        <div class="small-5 columns" id="opciones" data-boton="<?php echo $comprar->boton;?> " data-texto="<?php echo $comprar->texto;?>" data-texto_principal="<?php echo $comprar->texto_principal;?>" data-id_slide_comprar ="<?php echo $comprar->id_slide_comprar?>" data-nombre_imagen="<?php echo $comprar->nombre_imagen;?>" data-alt="<?php echo $comprar->alt;?>" data-link="<?php echo $comprar->url_slide;?>" data-equalizer-watch>
                                            <a href="#" class="edit-comprar" ><i class="fa fa-edit"></i> Editar Slide</i></a></br/>
                                            <?php if($comprar->estatus == 1): ?>
                                                <a class="enabled"><i class="fa fa-toggle-on"></i> Habilitado</a></br/>
                                            <?php else: ?>
                                                <a class="disabled"><i class="fa fa-toggle-off"></i> Deshabilitado</a></br/>
                                            <?php endif; ?>
                                            <a class="delete-comprar" ><i class="fa fa-times"></i> Borrar</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </section>
    </div>
</div>


<!--formulario para subir nuevo banner-->
<div class="reveal-modal small" id="nuevo_banner" data-reveal aria-hidden="true" style="position: fixed">
    <form action="<?php echo site_url('administracion/slider/agregar-nuevo-banner'); ?>" method="post" data-abide enctype="multipart/form-data">
        <div class="row">
            <div class="small-24 columns">
                <label>Nombre Slide
                    <input type="text" class="width100" name="nombre_slide" id="nombre_slide" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Slide
                    <input type="file" name="file" class="width100" accept="image/*" data-i="0" required />
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Alt
                    <input type="text" class="width100" name="alt_slide" id="alt_slide" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Link Slide
                    <input type="text" class="width100" name="link_slide" id="link_slide" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Texto botón (Máx 15 carácteres)
                    <input type="text" class="width100" name="boton_slide" maxlength="15" id="boton_slide" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Texto slider (Máx 50 carácteres)
                    <input type="text" class="width100" name="texto_slide" maxlength="50" id="texto_slide" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Texto principal (Máx 30 carácteres)
                    <input type="text" class="width100" name="principal_slide" (Máx 30 carácteres) id="principal_slide" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns text-center">
                <button type="submit">Subir</button>
            </div>
        </div>
    </form>
</div>
<!--end formulario para subir nuevo banner-->

<!--formulario para editar info banner-->
<div class="reveal-modal small" id="editar_banner" data-reveal aria-hidden="true" style="position: fixed">
    <form action="<?php echo site_url('administracion/slider/editar-banner'); ?>" method="post" data-abide>
        <input type="hidden" value="" name="id_slide" id="id-slide-editar">
        <div class="row">
            <div class="small-24 columns">
                <label>Nombre Slide
                    <input type="text" name="nombre_slide" id="editar-nombre" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Alt
                    <input type="text" name="alt_slide" id="editar-alt" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Link Slide
                    <input type="text" name="link_slide" id="editar-link" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Texto botón (Máx. 15 carácteres)
                    <input type="text" name="boton_slide" maxlength="15" id="editar-boton" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Texto slider (Máx. 50 carácteres)
                    <input type="text" name="texto_slide"  maxlength="50" id="editar-texto" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Texto principal (Máx. 30 carácteres)
                    <input type="text" name="principal_slide" maxlength="30"id="editar-principal" placeholder="(Opcional)"/>

                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns text-center">
                <button type="submit">Confirmar</button>
            </div>
        </div>
    </form>
</div>
<!--end formulario para editar info banner-->

<!--confirmación borrar slide-->
<div class="reveal-modal small" id="borrar_slide" data-reveal aria-hidden="true" style="position: fixed">
    <form action="<?php echo site_url('administracion/slider/borrar-banner'); ?>" method="post" data-abide>
        <div class="row">
            <div class="small-24 columns">
                <label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar este banner?</label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns text-center">
                <input type="hidden" name="id_slide" id="id_slide_borrar">
                <button type="submit">Borrar Banner</button>
            </div>
        </div>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
<!--end confirmación borrar slide-->


<!--formulario para subir nuevo banner comprar-->
<div class="reveal-modal small" id="nuevo_comprar" data-reveal aria-hidden="true" style="position: fixed">
    <form action="<?php echo site_url('administracion/slider/agregar-nuevo-comprar'); ?>" method="post" data-abide enctype="multipart/form-data">
        <div class="row">
            <div class="small-24 columns">
                <label>Nombre Slide
                    <input type="text" name="nombre_slide" id="nombre_slide" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Slide
                    <input type="file" name="file" accept="image/*" data-i="0" required />
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Alt
                    <input type="text" name="alt_slide" id="alt_slide" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Link Slide
                    <input type="text" name="link_slide" id="link_slide" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Texto botón (Máx 15 carácteres)
                    <input type="text" name="boton_slide" maxlength="15" id="boton_slide" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Texto slider (Máx 50 carácteres)
                    <input type="text" name="texto_slide" maxlength="50" id="texto_slide" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Texto principal (Máx 30 carácteres)
                    <input type="text" name="principal_slide" (Máx 30 carácteres) id="principal_slide" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns text-center">
                <button type="submit">Subir</button>
            </div>
        </div>
    </form>
</div>
<!--end formulario para subir nuevo banner comprar-->

<!--formulario para editar info banner-->
<div class="reveal-modal small" id="editar_comprar" data-reveal aria-hidden="true" style="position: fixed">

        <input type="hidden" value="" name="id_slide" id="id-slide-comprar">
        <div class="row">
            <div class="small-24 columns">
                <label>Nombre Slide
                    <input type="text" name="nombre_slide" id="editar-nombre-c" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Alt
                    <input type="text" name="alt_slide" id="editar-alt-c" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Link Slide
                    <input type="text" name="link_slide" id="editar-link-c" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Texto botón (Máx. 15 carácteres)
                    <input type="text" name="boton_slide" maxlength="15" id="editar-boton-c" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Texto slider (Máx. 50 carácteres)
                    <input type="text" name="texto_slide"  maxlength="50" id="editar-texto-c" placeholder="(Opcional)"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Texto principal (Máx. 30 carácteres)
                    <input type="text" name="principal_slide" maxlength="30"id="editar-principal-c" placeholder="(Opcional)"/>

                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns text-center">
                <button type="submit" id="save_slider_comprar">Confirmar</button>
            </div>
        </div>

</div>
<!--end formulario para editar info banner-->

<!--confirmación borrar slide-->
<div class="reveal-modal small" id="borrar_comprar" data-reveal aria-hidden="true" style="position: fixed">

        <div class="row">
            <div class="small-24 columns">
                <label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar este banner?</label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns text-center">
                <input type="hidden" name="id_slide" id="id_slide_borrar_comprar">
                <button id="save_borrar_comprar" type="submit">Borrar Banner</button>
            </div>
        </div>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
<!--end confirmación borrar slide-->