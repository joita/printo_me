<div class="container">
    <div class="row">
        <div class="col-md-12 printome-rep">
            <form action="<?php echo site_url('testimonios/nuevo/procesar'); ?>" class="fbc" id="testimonio_form" method="post" enctype="application/x-www-form-urlencoded" data-abide novalidate>

                <h1>
                    DEJA TU  <span>TESTIMONIO </span>
                </h1>
                <div class="separador1" ></div>
                        <?php if(isset($this->session->login['email'])): ?>
                            <p class="text-center">Hola <?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>, ¿cómo calificarías a printome.mx?</p>
                            <input type="hidden" name="email_testimonio" id="email_testimonio" value="<?php echo $this->session->login['email']; ?>" />
                            <input type="hidden" name="nombre_testimonio" id="nombre_testimonio" value="<?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>" />

                        <?php else: ?>

                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-label"><i class="fa fa-user"></i></span><input type="text" name="nombre_testimonio" id="nombre_testimonio" placeholder="Nombre" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-label"><i class="fa fa-envelope-o"></i></span><input type="email" name="email_testimonio" id="email_testimonio" placeholder="Correo electrónico" required>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <hr class="dashed" />

                        <div class="row ">
                            <div class="col-md-12">
                                <p class="text-center">¿Cómo calificarías a printome.mx?</p>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-12  text-center">
                                <select id="rating-testimonio" name="calificacion_testimonio">
                                    <?php for($i=1;$i<=5;$i++): ?>
                                        <option value="<?php echo $i; ?>"<?php if($i==3) { echo ' selected'; } ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <hr class="dashed" />

                        <div class="row ">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-edit"></i></span><textarea rows="3" name="mensaje_testimonio" id="mensaje_testimonio" placeholder="Déjanos un comentario de qué te pareció printome.mx" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-12">
                                <div class="g-recaptcha" data-sitekey="6LclRioUAAAAAIDqJHxFoDPoTIcKek4G4bEsXYoG"></div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-12 text-center">
                                <input type="submit" class="expanded button" id="testimonio_button" value="ENVIAR">
                            </div>
                        </div>

            </form>
        </div>
    </div>
</div>


<script src='https://www.google.com/recaptcha/api.js'></script>
