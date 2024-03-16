
<div class="row">
    <div class="small-24 columns">
        <h2 class="section-title">Respuestas a Testimonio</h2>
    </div>
</div>
<div class="row">
    <div class="small-24 columns">
        <div class="row">
            <!--Contenedor Chat-->
            <div class="small-17 columns">
                <fieldset id="chat_container">
                    <legend>Testimonio</legend>
                    <div class="row" >
                        <div class="columns small-11 user-chat">
                            <?php echo $testimonio[0]->comentario;
                            $orden = 0;?>
                        </div>
                    </div>
                    <?php if($testimonio[0]->cantidad_respuestas > 0): ?>
                        <?php foreach($testimonio[0]->respuestas as $indice_respuesta => $respuesta):?>
                            <div class="row" >
                                <div class="columns <?php if($respuesta->tipo_usuario == 'admin'){echo 'admin-chat small-push-13 small-11';}else{echo 'user-chat small-11';} ?>">
                                    <?php echo $respuesta->respuesta;
                                    $orden = $respuesta->orden;?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div class="row">
                        <br>
                        <form method="post" action="<?php echo site_url('administracion/respuestas/responder/'); ?>" >
                            <input type="text" name="respuesta" placeholder="Respuesta..." style="width: 38rem" autocomplete="off">
                            <input type="submit" name="submit" id="submit-text">
                            <input type="hidden" name="id_calificacion" value="<?php echo $testimonio[0]->id_calificacion; ?>">
                            <input type="hidden" name="orden" value="<?php echo $orden; ?>">
                            <input type="hidden" name="email_usuario" value="<?php echo $testimonio[0]->email; ?>">
                            <input type="hidden" name="nombre_usuario" value="<?php echo $testimonio[0]->nombre; ?>">
                        </form>
                    </div>
                </fieldset>
            </div>
            <!--End Contenedor Chat-->
            <!--Datos del testimonio-->
            <div class="small-7 columns">
                <fieldset id="datos_adicionales">
                    <legend>Datos Testimonio</legend>
                    <div class="small-24 columns">
                        <ul id="datos-testimonio">
                            <li>Nombre: <br>
                                <?php echo $testimonio[0]->nombre; ?></li>
                            <li>Correo: <br>
                                <?php echo $testimonio[0]->email; ?></li>
                            <li>Fecha: <br>
                                <?php echo $testimonio[0]->fecha_calificacion; ?></li>
                            <li>Estatus:<br>
                                <?php if($testimonio[0]->estatus == 1): ?>
                                    <?php echo "Aprovado"; ?>
                                <?php elseif($testimonio[0]->estatus == 0):?>
                                    <?php echo "Por Aprovar";?>
                                <?php else:?>
                                    <?php echo "Eliminado";?>
                                <?php endif?>
                            </li>
                            <li>Calificacion Actual:<br>
                                <?php echo estrellitas($testimonio[0]->monto_calificacion); ?>
                            </li>
                        </ul>
                    </div>
                </fieldset>
                <!--Modificacion de datos-->
                <div class="row">
                    <fieldset id="modificacion_datos">
                        <legend>Modificacion de Datos</legend>
                        <div class="small-24 columns">
                            <a href="<?php echo site_url('administracion/testimonios/aprobar/'.$testimonio[0]->id_calificacion); ?>" class="success action button">Aprobar</a>
                            <a href="<?php echo site_url('administracion/testimonios/borrar/'.$testimonio[0]->id_calificacion); ?>" class="warning action button">Borrar</a>
                            <label>Cambiar Calificacion:</label>
                            <select id="rating-testimonio" name="calificacion_testimonio">
                                <?php for($i=1;$i<=5;$i++): ?>
                                    <option value="<?php echo $i; ?>"<?php if($i==$testimonio[0]->monto_calificacion) { echo ' selected'; } ?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <input type="hidden" id="idcalif" value="<?php echo $testimonio[0]->id_calificacion;?>">
                        </div>
                    </fieldset>
                </div>
                <!--End Modificaion de datos-->
            </div>
            <!--End datos-->
        </div>
    </div>
</div>
