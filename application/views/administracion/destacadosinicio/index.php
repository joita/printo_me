<div class="row">
    <div class="small-24 columns">
        <h2 class="section-title">Destacados Inicio</h2>
    </div>
</div>
<div class="row">
    <div class="small-24 columns">
        <ul class=" tab-menu" >

            <li class="active" role="presentation"><a  ><i class="fa fa-building-o"></i> Destacados</a></li>

        </ul>
    </div>
</div>
<div class="row tabs-content">
    <div role="tabpanel" aria-hidden="false" class="small-24 columns " id="destacados">
        <div id="main-container">
            <div class="row" data-equalizer >
                <div class="small-24 end columns navholder" data-equalizer-watch>
                    <a href="#" data-reveal-id="nuevo_creador" class="coollink btn-new"><i class="fa fa-plus"></i> Nuevo destacado</a>
                </div>
            </div>
            <div class="row">
                <div class="small-24 columns">
                    <div id="creadores_list" class="list-group">
                        <?php foreach($destacadosinicio as $creador):?>
                            <div id="slide_item" class="list-group-item" data-eqalizer data-id_creador="<?php echo $creador->id_creadores_inicio?>">
                                <div class="row collapse" data-equalizer>
                                    <div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>
                                        <i class="fa fa-arrows "></i>
                                    </div>
                                    <div class="small-4 columns creador" id="logocreador" data-equalizer-watch>
                                        <img src="<?php echo site_url($creador->directorio."/".$creador->logo);?>" >
                                    </div>
                                    <div class="small-6 columns creador" id="foto" data-equalizer-watch>
                                        <img src="<?php echo site_url($creador->directorio."/".$creador->imagen_small);?>" >
                                    </div>
                                    <div class="small-8 columns" id="datos_foto" data-equalizer-watch>
                                        <b>Nombre playera:</b> <?php echo $creador->nombre_imagen;?><br/>
                                        <b>Alt:</b> <?php echo $creador->alt;?> </br/>
                                        <b>Creador:</b> <?php echo $creador->creador;?> </br/>
                                        <b>Link:</b> <a class="link" href="<?php echo $creador->url_imagen;?>"><i class="fa fa-link"></i></a>
                                    </div>
                                    <div class="small-5 columns" id="opciones" data-creador="<?php echo $creador->creador;?> " data-id_creador ="<?php echo $creador->id_creadores_inicio?>" data-nombre_imagen="<?php echo $creador->nombre_imagen;?>" data-alt="<?php echo $creador->alt;?>" data-link="<?php echo $creador->url_imagen;?>" data-equalizer-watch>
                                        <a href="#" class="edit-creador" data-reveal-id="editar_creador"><i class="fa fa-edit"></i> Editar</i></a></br/>
                                        <?php if($creador->estatus == 1): ?>
                                            <a class="enabled"><i class="fa fa-toggle-on"></i> Habilitado</a></br/>
                                        <?php else: ?>
                                            <a class="disabled"><i class="fa fa-toggle-off"></i> Deshabilitado</a></br/>
                                        <?php endif; ?>
                                        <a class="delete-creador" data-reveal-id="borrar_creador"><i class="fa fa-times"></i> Borrar</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


<!--formulario para subir nuevo creador-->
<div class="reveal-modal small" id="nuevo_creador" data-reveal aria-hidden="true" style="position: fixed">
    <form action="<?php echo site_url('administracion/destacadosinicio/agregar-nuevo-creador'); ?>" method="post" data-abide enctype="multipart/form-data">
        <div class="row">
            <div class="small-24 columns">
                <label>Nombre playera
                    <input type="text" name="nombre_imagen" id="nombre_imagen" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Creador
                    <input type="text" name="creador_imagen" id="creador_imagen" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Playera
                    <input type="file" name="file" accept="image/*" data-i="0" required />
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Logo
                    <input type="file" name="fileLogo" accept="image/*" data-i="0" required />
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Alt
                    <input type="text" name="alt_imagen" id="alt_imagen" required/>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="small-24 columns">
                <label>Link playera
                    <input type="text" name="link_imagen" id="link_imagen" placeholder="(Opcional)"/>
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
<!--end formulario para subir nuevo creador-->
<!--formulario para editar creador-->
<div class="reveal-modal small" id="editar_creador" data-reveal aria-hidden="true" style="position: fixed">
    <form action="<?php echo site_url('administracion/destacadosinicio/editar-creador'); ?>" method="post" data-abide enctype="multipart/form-data">
        <input type="hidden" value="" name="id_creador" id="id-creador-editar">
        <div class="row">
            <div class="small-24 columns">
                <label>Nombre playera
                    <input type="text" name="nombre_imagen" id="editar-nombre" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Creador
                    <input type="text" name="nombre_creador" id="editar-creador" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Playera
                    <input type="file" name="file" id="editar_playera" accept="image/*" data-i="0" />
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Logo
                    <input type="file" name="fileLogo" id="editar_logo" accept="image/*" data-i="0" />
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Alt
                    <input type="text" name="alt_creador" id="editar-alt" required/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns">
                <label>Link playera
                    <input type="text" name="link_creador" id="editar-link" placeholder="(Opcional)"/>
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
<!--end formulario para editar creador-->
<!--confirmación borrar creador-->
<div class="reveal-modal small" id="borrar_creador" data-reveal aria-hidden="true" style="position: fixed">
    <form action="<?php echo site_url('administracion/destacadosinicio/borrar-creador'); ?>" method="post" data-abide>
        <div class="row">
            <div class="small-24 columns">
                <label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar este creador?</label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns text-center">
                <input type="hidden" name="id_creador" id="id_creador_borrar">
                <button type="submit">Borrar creador</button>
            </div>
        </div>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
<!--end confirmación borrar creador -->
