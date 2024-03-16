<?php
/**
 * Created by PhpStorm.
 * User: javier
 * Date: 2018-12-17
 * Time: 11:02
 */
?>
<div class="row">
    <div class="small-24 columns">
        <h2 class="section-title">Adminstrar Categorias</h2>
    </div>
</div>
<div class="row">
    <div class="small-24 columns">
        <ul class="tab-menu">
            <?php foreach($categorias as $categoria): ?>
                <li><a href="<?php echo site_url('administracion/categorizar/'); ?>"<?php activar($categoria_slug, $categoria->nombre_categoria_slug); ?>><?php echo $categoria->nombre_categoria; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="row">
    <div class="small-24 columns" style="padding-top:0.8rem;padding-bottom:0.8rem;">
        <ul class="divisor">
            <?php foreach($clasificaciones as $clasificacionPadre): ?>
            <li>
                <div class="row">
                    <div class="small-12 columns">
                        <span class="categoria-principal"><i class="fa fa-bookmark"></i> <?php echo $clasificacionPadre->nombre_clasificacion; ?></span>
                    </div>
                    <div class="small-12 columns text-right function-links" data-id="<?php echo $clasificacionPadre->id_clasificacion; ?>" data-nombre="<?php echo $clasificacionPadre->nombre_clasificacion; ?>" data-nombre_clasificacion_slug="<?php echo $clasificacionPadre->nombre_clasificacion_slug; ?>" data-id_parent="<?php $clasificacionPadre->id_clasificacion_parent; ?>" data-estatus="<?php echo $clasificacionPadre->estatus; ?>"'>
                        <a href="#" class="expand_1"><i class="fa fa-plus-square-o"></i> Mostrar Subcategorias</i></a>
                        <a href="#" class="editar" data-reveal-id="editar_categoria"><i class="fa fa-edit"></i> Editar Categoria</i></a>
                        <?php if($clasificacionPadre->estatus == 1): ?>
                        <a href="#" class="enabled"><i class="fa fa-toggle-on"></i></a>
                        <?php else: ?>
                        <a href="#" class="disabled"><i class="fa fa-toggle-off"></i></a>
                        <?php endif; ?>
                        <a href="#" class="delete" data-reveal-id="borrar_categoria"><i class="fa fa-times"></i></a>
                    </div>
                </div>
            <ul class="divisor-sub list-caracteristica" data-id_parent="<?php echo $clasificacionPadre->id_clasificacion; ?>">
                <?php if(isset($clasificacionPadre->subclasificaciones)): ?>
                    <?php foreach($clasificacionPadre->subclasificaciones as $subclasificacion): ?>
                        <li>
                            <div class="row">
                                <div class="small-11 columns">
                                    <span class="clasificacion-principal"><i class="fa fa-tag"></i> <?php echo $subclasificacion->nombre_clasificacion; ?></span>
                                </div>
                                <div class="small-13 columns text-right function-links" data-id="<?php echo $subclasificacion->id_clasificacion; ?>" data-nombre="<?php echo $subclasificacion->nombre_clasificacion; ?>" data-nombre_slug="<?php echo $subclasificacion->nombre_clasificacion_slug; ?>" data-id_parent="<?php echo $subclasificacion->id_clasificacion_parent; ?>" data-estatus="<?php echo $subclasificacion->estatus; ?>">
                                    <a href="#" class="expand"><i class="fa fa-plus-square-o"></i> Mostrar Subcategorias</i></a>
                                    <a href="#" class="editar" data-reveal-id="editar_categoria"><i class="fa fa-edit"></i> Editar Categoria</i></a>
                                    <?php if($subclasificacion->estatus == 1): ?>
                                        <a href="#" class="enabled"><i class="fa fa-toggle-on"></i></a>
                                    <?php else: ?>
                                        <a href="#" class="disabled"><i class="fa fa-toggle-off"></i></a>
                                    <?php endif; ?>
                                    <a href="#" class="delete" data-reveal-id="borrar_categoria"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                            <ul class="divisor-sub list-subcaracteristica" data-id_parent="<?php echo $subclasificacion->id_clasificacion; ?>">
                                <?php if(isset($subclasificacion->subsubclasificaciones)): ?>
                                    <?php foreach($subclasificacion->subsubclasificaciones as $subsubclas): ?>
                                        <li>
                                            <div class="row">
                                                <div class="small-11 columns">
                                                    <i class="fa fa-tags"></i> <?php echo $subsubclas->nombre_clasificacion; ?>
                                                </div>
                                                <div class="small-13 columns text-right subfunction-links" data-id="<?php echo $subsubclas->id_clasificacion; ?>" data-nombre="<?php echo $subsubclas->nombre_clasificacion; ?>" data-nombre_slug="<?php echo $subsubclas->nombre_clasificacion_slug; ?>" data-id_caracteristica_parent="<?php echo $subsubclas->id_clasificacion_parent; ?>" data-estatus="<?php echo $subsubclas->estatus; ?>" data-nombre_parent="<?php echo $subclasificacion->nombre_clasificacion; ?>">
                                                    <a href="#" class="editar" data-reveal-id="editar_categoria"><i class="fa fa-edit"></i> Editar valor</i></a>
                                                    <?php if($subsubclas->estatus == 1): ?>
                                                        <a href="#" class="enabled"><i class="fa fa-toggle-on"></i></a>
                                                    <?php else: ?>
                                                        <a href="#" class="disabled"><i class="fa fa-toggle-off"></i></a>
                                                    <?php endif; ?>
                                                    <a href="#" class="delete" data-reveal-id="borrar_categoria"><i class="fa fa-times"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <li>
                                    <div class="row">
                                        <div class="small-24 columns">
                                            <a href="#" class="nueva_cat" data-reveal-id="nueva_categoria" id="new_categoria" data-id_parent="<?php echo $subclasificacion->id_clasificacion; ?>"><i class="fa fa-plus"></i> Agregar Categoria</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
                <li>
                    <div class="row">
                        <div class="small-24 columns">
                            <a href="#" class="nueva_cat" data-reveal-id="nueva_categoria" id="new_categoria" data-id_parent="<?php echo $clasificacionPadre->id_clasificacion?>"><i class="fa fa-plus"></i> Agregar Categoria</a>
                        </div>
                    </div>
                </li>
            </ul>
    </li>
    <?php endforeach; ?>
    <li>
        <div class="row">
            <div class="small-24 columns">
                <a href="#" class="nueva_cat" data-reveal-id="nueva_categoria" data-id_parent="0"><i class="fa fa-plus"></i> Agregar nueva Categoria</a>
            </div>
        </div>
    </li>
    </ul>
</div>

<div class="reveal-modal small modal-categorizar" id="nueva_categoria" style="max-width:600px;" data-reveal>
    <form action="<?php echo site_url('administracion/categorizar/agregar'); ?>" method="post" data-abide>
        <h4 class="text-center">Nueva Categoria</h4>
        <div class="row">
            <div class="small-24 columns">
                <label>Nombre de la categoria
                    <input type="text" name="nombre_categoria" id="nombre_categoria_add" required />
                </label>
                <small class="error">Campo obligatorio.</small>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="small-24 columns text-center">
                <input type="hidden" name="id_parent" id="id_parent_mod">
                <button type="submit">Agregar</button>
            </div>
        </div>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal small modal-categorizar" id="editar_categoria" style="max-width:600px;" data-reveal>
    <form action="<?php echo site_url('administracion/categorizar/editar'); ?>" class="form_edit" method="post" data-abide>
        <h4 class="text-center">Editar Categoria</h4>
        <div class="row">
            <div class="small-24 columns">
                <label>Nombre de la categoria
                    <input type="text" name="nombre_categoria" id="nombre_categoria_mod" value="" />
                </label>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="small-24 columns text-center">
                <input type="hidden" name="id_categoria" id="id_categoria_mod">
                <button type="submit">Guardar cambios</button>
            </div>
        </div>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal small modal-categorizar" id="borrar_categoria" data-reveal>
    <form action="<?php echo site_url('administracion/categorizar/borrar'); ?>" class="form_borrar" method="post" data-abide>
        <h4 class="text-center">Borrar categoria</h4>
        <div class="row">
            <div class="small-24 columns">
                <label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar esta categoria? Se ocultarían todos los productos pertenecientes a la misma.</label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns text-center">
                <input type="hidden" name="id_categoria" id="id_categoria_bor">
                <button type="submit">Borrar categoria</button>
            </div>
        </div>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>