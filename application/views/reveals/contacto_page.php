<div id="mask-contactopage">
    <div class="popup-contacto">
        <div class="cont-contacto">
            <div id="close-contactopage"></div>
            <h1>CONTACTO</h1>
            <div class="separador1"></div>
            <form id="contact_form_p" data-abide="ajax" novalidate>
                <?php if(isset($this->session->login['email'])): ?>
                    <p>Hola <?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>, ¿cómo te podemos ayudar hoy?</p>
                    <input type="hidden" name="email_contactop" id="email_contactop" value="<?php echo $this->session->login['email']; ?>" />
                    <input type="hidden" name="nombre_contactop" id="nombre_contactop" value="<?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>" />
                    <input type="hidden" name="telefono_contactop" id="telefono_contactop" value="<?php echo (isset($this->session->login['telefono']) ? $this->session->login['telefono'] : ''); ?>" />

                <?php else: ?>
                    <p>¿Necesitas ayuda?</p>

                    <input type="text" placeholder="Nombre" name="nombre_contactop" id="nombre_contactop" required>
                    <span class="form-error">Campo requerido.</span>
                    <input type="email" placeholder="Email" name="email_contactop" id="email_contactop" required>
                    <span class="form-error">Campo requerido.</span>
                    <input type="text" placeholder="Telefono" name="telefono_contactop" id="telefono_contactop" required>
                    <span class="form-error">Campo requerido.</span>
                <?php endif; ?>
                <textarea name="mensaje_contactop" id="mensaje_contactop" placeholder="<?php echo $placeholder; ?>" required></textarea>
                <div class="alert radius callout" id="mensaje_contacto_generico_p" style="display:none;">
                    <div></div>
                </div>
                <input type="submit" id="contacto_button_p" value="ENVIAR">

                <div class="row  add-buttons">
                    <div class="col-md-6 text-right">
                        <input type="hidden" name="asunto_contactop" id="asunto_contactop" value="<?php echo $asunto; ?>" />
                        <input type="hidden" name="lugar_contactop" id="lugar_contactop" value="<?php echo $lugar; ?>" />
                        <input type="hidden" name="template_contactop" id="template_contactop" value="contacto_base" />

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>