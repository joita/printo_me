<script src="<?php echo site_url('inicio/scripts_respuesta_testimonio'); ?>" type="text/javascript"></script>
<div class="fgc ps so_ab">
    <div class="row">
        <div class="small-16 medium-9 large-8 xlarge-7 small-centered columns">
            <form action="<?php echo site_url('testimonios/nuevo/respuesta'); ?>" class="fbc" id="testimonio_form" method="post" enctype="application/x-www-form-urlencoded" data-abide novalidate>
                <div class="row">
                    <div class="small-18 columns">
                        <h3 class="dosf text-center">Responde a Printome!</h3>
                        <?php if(isset($this->session->login['email'])): ?>
                            <p class="text-center">Hola <?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>, Printome respondío a tu testimonio:</p>
                            <input type="hidden" name="email_testimonio" id="email_testimonio" value="<?php echo $this->session->login['email']; ?>" />
                            <input type="hidden" name="nombre_testimonio" id="nombre_testimonio" value="<?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>" />
                        <?php else: ?>
                            <p class="text-center">Hola <?php echo $testimonio[0]->nombre; ?>, Printome respondío a tu testimonio:</p>
                            <input type="hidden" name="email_testimonio" id="email_testimonio" value="<?php echo $testimonio[0]->email; ?>" />
                            <input type="hidden" name="nombre_testimonio" id="nombre_testimonio" value="<?php echo $testimonio[0]->nombre; ?>" />
                        <?php endif; ?>

                        <hr class="dashed" />

                        <div class="row ">
                            <div class="small-18 columns">
                                <p class="text-left" style="padding: 0rem 0.3rem"><?php echo $testimonio[0]->comentario;?></p>
                            </div>
                        </div>

                        <hr class="dashed" />

                        <?php if($ultimo_comentario_usuario): ?>
                            <div class="row ">
                                <div class="small-18 columns">
                                    <div class="row ">
                                        <div class="small-18 columns">
                                            <div class="columns small-3">
                                                <img class="avatar-image" src="<?php echo $testimonio[0]->url_avatar; ?>" alt="avatar">
                                            </div>
                                            <div class="columns small-15">
                                                <p class="text-avatar">Tu último comentario:</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-left" style="padding: 0rem 0.3rem"><?php echo $ultimo_comentario_usuario->respuesta; ?></p>
                                </div>
                            </div>
                            <hr class="dashed" />
                        <?php endif; ?>
                        <div class="row ">
                            <div class="small-18 columns">
                                <div class="row ">
                                    <div class="small-18 columns">
                                        <div class="columns small-3">
                                            <img class="avatar-image" src="assets/images/icon.png" alt="avatar">
                                        </div>
                                        <div class="columns small-15">
                                            <p class="text-avatar">La respuesta de Printome:</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-left" style="padding: 0rem 0.3rem"><?php echo $ultimo_comentario_admin->respuesta; ?></p>
                            </div>
                        </div>

                        <hr class="dashed" />

                        <p class="text-center" style="padding: 0rem 0.3rem">Calificacion Actual: <?php echo estrellitas($testimonio[0]->monto_calificacion); ?></p>
                        <label class="text-center">Deseo cambiar mi calificacion:&nbsp &nbsp<input name="check-cambiar" id="check-cambiar" type="checkbox"></label>

                        <div class="row " id="cambiar-calif" style="display: none">
                            <div class="small-18 columns text-center">
                                <select id="rating-testimonio" name="calificacion_testimonio">
                                    <?php for($i=1;$i<=5;$i++): ?>
                                        <option value="<?php echo $i; ?>"<?php if($i==$testimonio[0]->monto_calificacion) { echo ' selected'; } ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>


                        <hr class="dashed" />

                        <div class="row ">
                            <div class="small-18 columns">
                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-edit"></i></span><textarea rows="3" name="mensaje_respuesta" id="mensaje_testimonio" placeholder="Responde a Printome!" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="small-18 columns">
                                <div class="g-recaptcha" data-sitekey="6LclRioUAAAAAIDqJHxFoDPoTIcKek4G4bEsXYoG"></div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="small-18 columns">
                                <input type="hidden" name="id_calificacion" value="<?php echo $testimonio[0]->id_calificacion;?>">
                                <input type="hidden" name="orden" value="<?php echo $nuevo_orden;?>">
                                <button type="submit" class="expanded button" id="testimonio_button"><strong>Enviar</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>