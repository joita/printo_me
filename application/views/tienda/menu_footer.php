		<footer id="main-footer">
			<div class="row">
				<div class="small-18 medium-9 large-6 columns text-center large-text-left">
					<div class="row">
						<div class="small-18 columns">
							<img id="flogo" src="<?php echo site_url('assets/nimages/footer_logo.svg'); ?>" alt="Diseña tu playera on-line | printome.mx" width="175" height="51" />
						</div>
					</div>
					<div class="row">
						<div class="small-18 columns"><span class="acept mc">MasterCard </span><span class="acept vi">Visa </span><span class="acept am">American Express </span><span class="acept ox">OXXO </span><span class="acept pp">PayPal </span>
						</div>
					</div>
				</div>
				<div class="small-18 medium-9 large-7 xlarge-6 columns text-center large-text-left" id="contfoot-area">
					<div class="row">
						<div class="small-18 medium-18 large-17 columns">
							<h3 class="verde">Contáctanos</h3>
							<form id="contact_form_footer" data-abide="ajax" novalidate>						
								<?php if(isset($this->session->login['email'])): ?>
								<p class="blanco">Hola <?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>, ¿cómo te podemos ayudar hoy?</p>
								<input type="hidden" name="email_contacto" id="email_contacto_footer" value="<?php echo $this->session->login['email']; ?>" />
								<input type="hidden" name="nombre_contacto" id="nombre_contacto_footer" value="<?php echo $this->session->login['nombre'].' '.$this->session->login['apellidos']; ?>" />
								
								<?php else: ?>
								
								<div class="row collapse">
									<div class="small-18 columns">
										<div class="input-group">
											<span class="input-group-label"><i class="fa fa-user"></i></span><input type="text" name="nombre_contacto" id="nombre_contacto_footer" placeholder="Nombre" required>
										</div>
									</div>
								</div>
							
								<div class="row collapse">
									<div class="small-18 columns">
										<div class="input-group">
											<span class="input-group-label"><i class="fa fa-envelope-o"></i></span><input type="email" name="email_contacto" id="email_contacto_footer" placeholder="Correo electrónico" required>
										</div>
									</div>
								</div>
								<?php endif; ?>
								
								<div class="row collapse">
									<div class="small-18 columns">
										<div class="input-group">
											<span class="input-group-label"><i class="fa fa-edit"></i></span><textarea rows="3" name="mensaje_contacto" id="mensaje_contacto_footer" placeholder="Contáctanos y resolveremos cualquier duda que pudieras tener sobre nuestro servicio." required></textarea>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="small-18 columns">
										<div class="alert radius callout" id="mensaje_contacto_generico_footer" style="display:none;">
											<div></div>
										</div>
									</div>
								</div>
								
								<div class="row collapse">
									<div class="small-18 columns text-center large-text-left">
										<input type="hidden" name="asunto_contacto" id="asunto_contacto_footer" value="Contacto desde printome.mx" />
										<input type="hidden" name="lugar_contacto" id="lugar_contacto_footer" value="<?php echo current_url(); ?>" />
										<input type="hidden" name="template_contacto" id="template_contacto_footer" value="contacto_base" />
										<button type="submit" class="primary button" id="contacto_button_footer">Enviar</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="small-18 medium-18 large-5 columns text-center large-text-left" id="info-adicional">
					<div class="row">
						<div class="small-18 columns">
							<h3 class="verde">Soporte</h3>
							<p class="fli"><a href="<?php echo site_url('tienda/'.$nombre_tienda_slug.'/terminos-y-condiciones'); ?>">Términos y Condiciones</a></p>
							<p class="fli"><a href="<?php echo site_url('tienda/'.$nombre_tienda_slug.'/aviso-de-privacidad'); ?>">Aviso de privacidad</a></p>
							<p class="fli"><a href="<?php echo site_url('tienda/'.$nombre_tienda_slug.'/politicas-de-compra'); ?>">Políticas de compra</a></p>
						</div>
					</div>
					<div class="row">
						<div class="small-18 columns">
							<h3 class="verde">Síguenos</h3>
							<ul class="menu" id="footsoc">
								<li class="soc"><a class="fbli" href="https://www.facebook.com/printome" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li class="soc"><a class="igli" href="https://www.instagram.com/printome_mx/" target="_blank"><i class="fa fa-instagram"></i></a></li>
								<li class="soc"><a class="ytli" href="https://www.youtube.com/channel/UC5lC5b9lCLku8Zp3rwV-yBQ" target="_blank"><i class="fa fa-youtube"></i></a></li>
							</ul>
							<p class="fli" style="margin-top:0.6rem;"><a href="<?php echo site_url('blog'); ?>">Blog</a></p>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<div class="fneg">
			<div class="row">
				<div class="text-center">
					<span>&copy; <?php echo date("Y"); ?> <a href="<?php echo base_url(); ?>" class="main">printome.mx</a>. Todos los derechos reservados.</span>
				</div>
			</div>
		</div>

		<?php $this->load->view('reveals/cupon'); ?>
		<?php $this->load->view('reveals/login'); ?>
		<?php $this->load->view('reveals/register'); ?>
		<?php $this->load->view('reveals/forgot'); ?>