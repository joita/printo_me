<div id="mask-contactofooter">
    <div class="popup-contacto">
        <div class="cont-contacto">
            <div id="close-contactofooter"></div>
            <h1>CONTACTO</h1>
            <div class="separador1"></div>
            <form id="contact_form_f" data-abide="ajax" novalidate>
                <?php if(isset($this->session->login['email'])): ?>
                    <p>Hola <?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>, ¿cómo te podemos ayudar hoy?</p>
                    <input type="hidden" name="email_contactof" id="email_contactof" value="<?php echo $this->session->login['email']; ?>" />
                    <input type="hidden" name="nombre_contactof" id="nombre_contactof" value="<?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>" />
                    <input type="hidden" name="telefono_contactof" id="telefono_contactof" value="<?php echo (isset($this->session->login['telefono']) ? $this->session->login['telefono'] : ''); ?>" />

                <?php else: ?>
                    <p>¿Necesitas ayuda?</p>

                    <input placeholder="Nombre" type="text" name="nombre_contactof" id="nombre_contactof" required>
                    <span class="form-error">Campo requerido.</span>
                    <input placeholder="Email" type="email" name="email_contactof" id="email_contactof" required>
                    <span class="form-error">Campo requerido.</span>
                    <input placeholder="Teléfono" type="text" name="telefono_contactof" id="telefono_contactof" required>
                    <span class="form-error">Campo requerido.</span>
                <?php endif; ?>
                <textarea name="mensaje_contactof" id="mensaje_contactof" placeholder="<?php echo $placeholder; ?>" required></textarea>
                <div class="alert radius callout" id="mensaje_contacto_generico_f" style="display:none;">
                    <div></div>
                </div>
                <input type="submit" id="contacto_button_f" value="ENVIAR">

                <div class="row  add-buttons">
                    <div class="col-md-6 text-right">
                        <input type="hidden" name="asunto_contactof" id="asunto_contactof" value="<?php echo $asunto; ?>" />
                        <input type="hidden" name="lugar_contactof" id="lugar_contactof" value="<?php echo $lugar; ?>" />
                        <input type="hidden" name="template_contactof" id="template_contactof" value="contacto_base" />

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>