<div class="row">
    <div class="small-24 columns">
        <h2 class="section-title">Más vendidos</h2>
    </div>
</div>
<div class="row">
    <div class="small-24 columns">
        <ul class=" tab-menu" >

            <li class="active" role="presentation"><a  ><i class="fa fa-building-o"></i> Más vendidos</a></li>

        </ul>
    </div>
</div>
<div class="row tabs-content">
    <div role="tabpanel" aria-hidden="false" class="small-24 columns " id="destacados">
        <div id="main-container">
            <div class="row" data-equalizer >
                <div class="small-24 end columns navholder" data-equalizer-watch>
                    <a href="#" data-reveal-id="nuevo_vendido" class="coollink btn-new"><i class="fa fa-plus"></i> Nuevo</a>
                </div>
            </div>
            <div class="row">
                <div class="small-24 columns">
                    <div id="vendidos_list" class="list-group">
                        <?php foreach($masvendidos as $vendido):?>
                            <div id="slide_item" class="list-group-item" data-eqalizer data-id_mas_vendido="<?php echo $vendido->id_mas_vendido?>">
                                <div class="row collapse" data-equalizer>
                                    <div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>
                                        <i class="fa fa-arrows "></i>
                                    </div>
                                    <div class="small-4 columns creador" id="logocreador" data-equalizer-watch>
                                        <img src="<?php echo site_url($vendido->directorio."/".$vendido->logo);?>" >
                                    </div>
                                    <div class="small-6 columns creador" id="foto" data-equalizer-watch>
                                        <img src="<?php echo site_url($vendido->directorio."/".$vendido->imagen_small);?>" >
                                    </div>
                                    <div class="small-8 columns" id="datos_foto" data-equalizer-watch>
                                        <b>Nombre playera:</b> <?php echo $vendido->nombre_imagen;?><br/>
                                        <b>Alt:</b> <?php echo $vendido->alt;?> </br/>
                                        <b>Creador:</b> <?php echo $vendido->creador;?> </br/>
                                        <b>Link:</b> <a class="link" href="<?php echo $vendido->url_imagen;?>"><i class="fa fa-link"></i></a>
                                    </div>
                                    <div class="small-5 columns" id="opciones" data-creador="<?php echo $vendido->creador;?> " data-id_mas_vendido ="<?php echo $vendido->id_mas_vendido?>" data-nombre_imagen="<?php echo $vendido->nombre_imagen;?>" data-alt="<?php echo $vendido->alt;?>" data-link="<?php echo $vendido->url_imagen;?>" data-equalizer-watch>
                                        <a href="#" class="edit-vendido" data-reveal-id="editar"><i class="fa fa-edit"></i> Editar</i></a></br/>
                                        <?php if($vendido->estatus == 1): ?>
                                            <a class="enabled"><i class="fa fa-toggle-on"></i> Habilitado</a></br/>
                                        <?php else: ?>
                                            <a class="disabled"><i class="fa fa-toggle-off"></i> Deshabilitado</a></br/>
                                        <?php endif; ?>
                                        <a class="delete-vendido" data-reveal-id="borrar"><i class="fa fa-times"></i> Borrar</a>
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


<!--formulario para subir nuevo mas vendido-->
<div class="reveal-modal small" id="nuevo_vendido" data-reveal aria-hidden="true" style="position: fixed">
    <form action="<?php echo site_url('administracion/masvendidos/agregar-nuevo'); ?>" method="post" data-abide enctype="multipart/form-data">
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
<!--end formulario para subir nuevo mas vendido-->
<!--formulario para editar mas vendido-->
<div class="reveal-modal small" id="editar" data-reveal aria-hidden="true" style="position: fixed">
    <form action="<?php echo site_url('administracion/masvendidos/editar'); ?>" method="post" data-abide enctype="multipart/form-data">
        <input type="hidden" value="" name="id_mas_vendido" id="id-mas-vendido-editar">
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
<!--end formulario para editar mas vendido-->
<!--confirmación borrar mas vendido-->
<div class="reveal-modal small" id="borrar" data-reveal aria-hidden="true" style="position: fixed">
    <form action="<?php echo site_url('administracion/masvendidos/borrar'); ?>" method="post" data-abide>
        <div class="row">
            <div class="small-24 columns">
                <label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar?</label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns text-center">
                <input type="hidden" name="id_mas_vendido" id="id_mas_vendido_borrar">
                <button type="submit">Borrar</button>
            </div>
        </div>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
<!--end confirmación borrar mas vendido -->
