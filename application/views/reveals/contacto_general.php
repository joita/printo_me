<div id="mask-contacto">
    <div class="popup-contacto">
        <div class="cont-contacto">
            <div id="close-contacto"></div>
            <h1>CONTACTO</h1>
            <div class="separador1"></div>
            <form id="contact_form" data-abide="ajax" novalidate>
                <?php if(isset($this->session->login['email'])): ?>
                    <p>Hola <?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>, ¿cómo te podemos ayudar hoy?</p>
                    <input type="hidden" name="email_contacto" id="email_contacto" value="<?php echo $this->session->login['email']; ?>" />
                    <input type="hidden" name="nombre_contacto" id="nombre_contacto" value="<?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>" />
                    <input type="hidden" name="telefono_contacto" id="telefono_contacto" value="<?php echo (isset($this->session->login['telefono']) ? $this->session->login['telefono'] : ''); ?>" />

                <?php else: ?>
                    <p>¿Necesitas ayuda?</p>

                    <input placeholder="Nombre"  type="text" name="nombre_contacto" id="nombre_contacto" required>
                    <span class="form-error">Campo requerido.</span>
                    <input placeholder="Email" type="email" name="email_contacto" id="email_contacto" required>
                    <span class="form-error">Campo requerido.</span>
                    <input placeholder="Teléfono" type="text" name="telefono_contacto" id="telefono_contacto" required>
                    <span class="form-error">Campo requerido.</span>
                <?php endif; ?>
                <textarea name="mensaje_contacto" id="mensaje_contacto" placeholder="<?php echo $placeholder; ?>" required></textarea>
                <div class="alert radius callout" id="mensaje_contacto_generico" style="display:none;">
                    <div></div>
                </div>
                <input type="submit" id="contacto_button" value="ENVIAR">

                <div class="row  add-buttons">
                    <div class="col-md-6 text-right">
                        <input type="hidden" name="asunto_contacto" id="asunto_contacto" value="<?php echo $asunto; ?>" />
                        <input type="hidden" name="lugar_contacto" id="lugar_contacto" value="<?php echo $lugar; ?>" />
                        <input type="hidden" name="template_contacto" id="template_contacto" value="contacto_base" />

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>