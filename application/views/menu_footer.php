		<footer id="main-footer" itemscope itemtype="https://schema.org/LocalBusiness" style="background: #272727">
			<div class="row">
				<div class="small-18 medium-9 large-6 columns text-center large-text-left">
					<div class="row">
						<div class="small-18 columns">
							<img id="flogo" src="<?php echo site_url('assets/nimages/footer_logo.svg'); ?>" alt="Printome" width="175" height="51" />
						</div>
					</div>
                    <?php /*
					<div class="row">
						<div class="small-18 columns">
                            <script src="https://apis.google.com/js/platform.js?onload=renderBadge" async defer></script> <script> window.renderBadge = function() { var ratingBadgeContainer = document.createElement("div"); document.body.appendChild(ratingBadgeContainer); window.gapi.load('ratingbadge', function() { window.gapi.ratingbadge.render(ratingBadgeContainer, {"merchant_id": 118110452, "position": "BOTTOM_LEFT" }); }); } </script>
						</div>
					</div>
                    */ ?>
					<div class="row">
						<div class="small-18 columns">
							<a href="tel:+5219992595995" id="ftelink"><i class="fa fa-phone"></i> (999) 259 59 95</a><br />
							<p class="blanco"><i class="fa fa-whatsapp samew"></i> WhatsApp: <a href="https://wa.me/529992595995" target="_blank" id="whatslink"><strong> (999) 259 59 95</strong></a><br />
							<i class="fa fa-envelope-o samew"></i> E-Mail: <?php echo safe_mailto('hello@printome.mx'); ?><br />
							<i class="fa fa-clock-o samew"></i> Lunes a Viernes de 9:00 a.m a 6:00 p.m </p>
						</div>
					</div>
					<div class="row">
						<div class="small-18 columns"><span class="acept mc">MasterCard </span><span class="acept vi">Visa </span><span class="acept am">American Express </span><span class="acept ox">OXXO </span><span class="acept pp">PayPal </span>
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
							<p class="fli" style="margin-top:0.6rem;"><a href="<?php echo site_url('blog').'/'; ?>">Blog</a></p><?php /*
                            <p class="fli" style="margin-top:0.6rem;"><a href="<?php echo site_url('asociaciones-civiles'); ?>">Recauda fondos</a></p>*/ ?>
                        <!--<p class="fli" style="margin-top:0.6rem;"><a href="<?php //echo site_url('servicios-de-diseno'); ?>">Servicios de diseño</a></p>-->
						</div>
					</div>
					<div class="hide">
						<span itemprop="name">printome.mx</span>
						<span itemprop="sameAs">https://www.facebook.com/printome/</span>
						<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
							<span itemprop="streetAddress">Calle 133-A No. 815 Int. 55 entre 46-A y 46-I, Fracc. Villa Magna del Sur</span>
							<span itemprop="addressLocality">Mérida</span>,
							<span itemprop="addressRegion">Yucatán</span>
							<span itemprop="addressCountry">México</span>
							<span itemprop="postalCode">97285</span>
						</div>
						Teléfono: <span itemprop="telephone">+525575839906</span>
						<time itemprop="openingHours" datetime="Mo-Fr 08:00-18:00">Lunes a Viernes de 8:00 a.m. a 6:00 p.m.</time>
						<div itemprop="priceRange">$</div>
						<img src="<?php echo site_url('assets/images/logo_schema.png'); ?>" itemprop="image">
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
								<input type="hidden" name="telefono_contacto" id="telefono_contacto_footer" value="<?php echo (isset($this->session->login['telefono']) ? $this->session->login['telefono'] : ''); ?>" />

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

								<div class="row collapse">
									<div class="small-18 columns">
										<div class="input-group">
											<span class="input-group-label"><i class="fa fa-phone"></i></span><input type="text" name="telefono_contacto" id="telefono_contacto_footer" placeholder="Teléfono" required>
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
                            <h3 class="verde">Valoración de printome.mx</h3>
                            <div class="row" id="rating-row">
                                <div class="small-18 columns">
                                    <div class="row">
                                        <div class="small-18 columns">
                                            <?php
                                                $info_rating = $this->testimonios_m->obtener_rating_promedio();
                                                $rating = number_format($info_rating->rating_promedio, 1);
                                                echo estrellitas($rating);
                                            ?>
                                            <span itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
                                                <span class="hide" itemprop="worstRating">1.0</span>
                                                <span class="ratprom"><span itemprop="ratingValue"><?php echo $rating; ?></span> / <span itemprop="bestRating">5.0</span></span>
                                                <span class="totalrat">Basado en <span itemprop="ratingCount"><?php echo $info_rating->numero_ratings; ?></span> testimonios.</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="small-18 columns">
                                            <a href="<?php echo site_url('testimonios'); ?>" class="tiny button">Ver todos los testimonios</a>
                                            <a href="<?php echo site_url('testimonios/nuevo'); ?>" class="tiny button" id="enviar-testimonio">Enviar testimonio</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

							<h3 class="verde">Soporte</h3>
							<p class="fli"><a href="<?php echo site_url('terminos-y-condiciones'); ?>">Términos y Condiciones</a></p>
							<p class="fli"><a href="<?php echo site_url('aviso-de-privacidad'); ?>">Aviso de privacidad</a></p>
							<p class="fli"><a href="<?php echo site_url('politicas-de-compra'); ?>">Políticas de compra</a></p>
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

		<?php /*$this->load->view('reveals/cupon');*/ ?>
		<?php $this->load->view('reveals/login'); ?>
		<?php $this->load->view('reveals/register'); ?>
		<?php $this->load->view('reveals/forgot'); ?>
		<?php $this->load->view('reveals/contacto_general', array('asunto' => 'Contacto desde printome.mx', 'lugar' => current_url(), 'placeholder' => 'Contáctanos y resolveremos cualquier duda que pudieras tener sobre nuestro servicio.')); ?>
