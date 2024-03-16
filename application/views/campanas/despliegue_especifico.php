<div class="fgc pscat" itemscope itemtype="https://schema.org/Product" style="background: white">
	<div class="row">
		<div class="small-18 medium-9 large-9 columns" id="info-producto">
			<div class="row">
				<div class="small-18 columns">
					<h2 class="text-center medium-text-left" itemprop="name" style="color:#FF4D00; font-size: xx-large; border-bottom: 2px solid #025E7A; margin-bottom: 2rem; font-weight: bolder"><?php echo $campana->name; ?></h2>
					<span class="autor text-center medium-text-left" style="color: #025E7A">por <a href="<?php echo site_url('tienda/'.$autor->nombre_tienda_slug); ?>"><?Php echo $autor->nombre_tienda; ?></a></span>
					<span class="hide" itemprop="brand">printome</span>
				</div>
			</div>
			<div class="row">
                <div class="small-18 columns">
                    <div class="area-descripcion campana" itemprop="description">
                        <p  style="color: #025E7A"><?php echo nl2br($campana->description); ?></p>
                        <?php if($color->id_enhance != 34924 && $color->id_enhance != 34925):?>
                            <p style="color: #025E7A">Playera de algodón peinado orgánico con un tacto a la piel suave, impreso con tintas ecológicas que no dañan el medio ambiente.</p>
                            <div class="row">
                                <div class="small-18 medium-9 columns">
                                    <ul>
                                        <li style="color: #025E7A">ISO 14001</li>
                                        <li style="color: #025E7A">Certificado Bluesign</li>
                                    </ul>
                                </div>
                                <div class="small-18 medium-9 columns">
                                    <div class="row small-up-1 medium-up-1 large-up-2 text-left" id="botones-compartir">
                                        <div class="column"><div class="fb-share-button" data-href="<?php echo current_url(); ?>" data-layout="button_count" data-mobile-iframe="false"></div></div>
                                        <div class="column"><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo current_url(); ?>" data-lang="es" data-related="printome_mx" data-dnt="true" data-show-count="true">Twittear</a></div>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
				<div class="small-18 medium-18 large-18 columns">
					<p class="adic-desc" style="color: #025E7A">Este producto está disponible en los siguientes colores. Haz clic para escoger el color que más te gusta.</p>
					<div class="colores-producto clearfix text-center medium-text-left">
						<?php foreach($colores_disponibles as $indice=>$color): ?>
						<a class="color-switcher special" data-id_enhance="<?php echo $color->id_enhance; ?>" data-color-click="#color_<?php echo $color->id_color; ?>" data-info='<?php echo json_encode($color); ?>'><i class="fa fa-<?php if($color->id_color == $campana->id_color) { echo 'check-'; } ?>circle" style="color:<?php echo $color->codigo_color; ?>;"></i></a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
            <div class="row">
                <div class="small-18 medium-18 large-12 xlarge-13 text-center medium-text-left columns" itemscope itemtype="http://schema.org/Offer">
                    <span class="gran-precio" style="color: #FF4D00"><span itemprop="priceCurrency" content="MXN" style="color: #FF4D00">$</span><span style="color: #FF4D00" itemprop="price"><?php echo redondeo($campana->price); ?></span> MXN</span>
                </div>
            </div>
			<?php if($campana->type == 'limitado'): ?>
			<div class="row">
				<div class="small-18 medium-18 large-18 columns">
					<div class="row collapse">
						<div class="small-18 medium-18 large-10 columns text-center large-text-left">
							<span class="precio">Avance</span>
							<div class="row">
								<div class="small-18 columns">
									<?php $sold = $this->enhance_modelo->obtener_total_vendidos_por_campana($campana->id_enhance); ?>
									<div class="progress success" role="progressbar" tabindex="0" aria-valuenow="<?php echo $sold; ?>" aria-valuemin="0" aria-valuetext="<?php echo $sold; ?> unidades" aria-valuemax="<?php echo redondeo($campana->quantity); ?>">
										<span class="progress-meter" style="width: <?php echo ($sold/$campana->quantity >= 1 ? 100 : ($sold/$campana->quantity)*100); ?>%">
										</span>
										<span class="meter-text"><?php echo $sold; ?> / <?php echo redondeo($campana->quantity); ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="small-18 medium-18 large-8 columns text-center large-text-right">
							<span class="precio">Tiempo restante</span>
							<div class="timer" data-countdown="<?php echo date("Y-m-d H:i:s", strtotime($campana->end_date)); ?>"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="small-18 columns">
					<div id="aclaracion-plazo">
						<p>Este producto está a la venta en la modalidad de Plazo Definido. Es importante que recuerdes:</p>
						<ul>
							<li>Si se cumple la meta establecida por el diseñador, enviaremos a producción tu playera y te llegará en un máximo de 5 días hábiles.</li>
							<li>En caso de no alcanzar la meta fijada, Printome te devuelve tu dinero en forma de saldo a favor. De esta manera lo puedes usar para comprar cualquier producto en el momento que quieras. Gracias por comprar con nosotros.</li>

						</ul>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<div class="row">
				<div class="small-18 columns">
					<form action="<?php echo site_url('carrito/agregar'); ?>" class="area-boton" method="post" data-abide novalidate>
						<div class="row">
                            <?php if(!isset($tallas_cb) && !isset($tallas_stock)):?>
                                <div class="small-9 medium-5 large-5 columns">
                                    <label style="color: #FF4D00">Talla
                                        <select style="color: #FF4D00; border: 2px solid #025E7A; border-radius: 10px" name="id_sku" id="talla_elegida" required>
                                            <option value="" selected></option>
                                            <?php foreach($this->productos_modelo->obtener_skus_activos_por_color($campana->id_color) as $sku): ?>
                                                <?php /*<option value="<?php echo $sku->id_sku; ?>" data-actual="<?php echo $sku->cantidad_inicial; ?>"><?php echo $sku->talla_completa; ?></option>*/ ?>
                                                <option value="<?php echo $sku->id_sku; ?>" data-actual="500"><?php echo $sku->talla_completa; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </label>
                                </div>
                                <div class="small-9 medium-5 large-5 columns">
                                    <label style="color: #FF4D00">Cantidad
                                        <select style="color: #FF4D00; border: 2px solid #025E7A; border-radius: 10px" name="cantidad" id="cantidad_campana" required>
                                            <option value=""></option>
                                        </select>
                                    </label>
                                </div>
                            <?php elseif(isset($tallas_stock) && !isset($tallas_cb)):?>
                                <div class="small-9 medium-5 large-5 columns">
                                    <label style="color: #FF4D00">Talla
                                        <select style="color: #FF4D00; border: 2px solid #025E7A; border-radius: 10px" name="id_sku" id="talla_elegida" required>
                                            <option value="" selected></option>
                                            <?php foreach($this->productos_modelo->obtener_skus_activos_por_color($campana->id_color) as $index => $sku): ?>
                                                <option value="<?php echo $sku->id_sku; ?>" data-actual="<?php echo $tallas_stock->{$sku->talla_completa."_stock"}?>"><?php echo $sku->talla_completa; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </label>
                                </div>
                                <div class="small-9 medium-5 large-5 columns">
                                    <label style="color: #FF4D00">Cantidad
                                        <select style="color: #FF4D00; border: 2px solid #025E7A; border-radius: 10px" name="cantidad" id="cantidad_campana" required>
                                            <option value=""></option>
                                        </select>
                                    </label>
                                </div>
                            <?php elseif(!isset($tallas_stock) && isset($tallas_cb)):?>
                                <div class="small-9 medium-5 large-5 columns">
                                    <label style="color: #FF4D00">Talla normal
                                        <select style="color: #FF4D00; border: 2px solid #025E7A; border-radius: 10px" name="id_sku" id="talla_elegida" required>
                                            <?php foreach($tallas_cb as $sku): ?>
                                                <option value="<?php echo $sku->id_sku; ?>" data-actual="500"><?php echo $sku->talla_completa; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </label>
                                </div>
                                <div class="small-9 medium-5 large-5 columns">
                                    <label style="color: #FF4D00">Cantidad
                                        <select style="color: #FF4D00; border: 2px solid #025E7A; border-radius: 10px" name="cantidad" id="cantidad_campana" required>
                                            <?php for($i = 0; $i <= $tallas_cb[0]->cantidad_inicial-1; $i++):?>
                                            <option value="<?php echo $i+1?>"><?php echo $i+1?></option>
                                            <?php endfor;?>
                                        </select>
                                    </label>
                                </div>
                            <?php endif;?>

							<div class="small-18 medium-8 large-8 end columns text-center large-text-right">
                                <?php if($color->id_enhance != 34924 && $color->id_enhance != 34925):?>
								<label><span style="color:transparent;" class="show-for-medium">Ver tabla de medidas</span>
									<a class="no-encuentras button expanded" data-open="area-tabla-medidas" style="color: #FF4D00; border: 2px solid #025E7A; border-radius: 10px; font-weight: bolder; background: white">Tabla de medidas</a>
								</label>
                                <?php endif;?>
							</div>

						</div>
						<div class="row">
							<div class="small-18 columns">
								<input type="hidden" name="id_enhance" value="<?php echo $campana->id_enhance; ?>">
								<input type="hidden" name="tipo_enhance" value="<?php echo $campana->type; ?>">
								<button style="background: #FF4D00; border-radius: 10px" type="submit" class="button expanded success" id="agregar-enh" onclick="if(typeof gtag != 'undefined'){ gtag('event', 'Clic', {'event_category' : 'Interacción','event_label' : 'Agregar-Carrito','value': <?php echo number_format(floor($campana->price), 0, ".", ""); ?>});}"><i class="fa fa-cart-plus"></i> Agregar a carrito</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div id="area-tabla-medidas" class="reveal" data-reveal>
			<?php if($campana->id_producto == 13 || $campana->id_producto == 14): ?>
			<?php $this->load->view('catalogo/tablas_medidas/hombre_cuello_redondo_manga_corta'); ?>
			<?php elseif($campana->id_producto == 15 || $campana->id_producto == 16): ?>
			<?php $this->load->view('catalogo/tablas_medidas/hombre_cuello_redondo_manga_larga'); ?>
			<?php elseif($campana->id_producto == 17 || $campana->id_producto == 19): ?>
			<?php $this->load->view('catalogo/tablas_medidas/mujer_cuello_redondo_manga_corta'); ?>
			<?php elseif($campana->id_producto == 20 || $campana->id_producto == 21): ?>
			<?php $this->load->view('catalogo/tablas_medidas/mujer_cuello_v_manga_corta'); ?>
			<?php elseif($campana->id_producto == 22 || $campana->id_producto == 23): ?>
			<?php $this->load->view('catalogo/tablas_medidas/mujer_capucha_manga_larga'); ?>
			<?php elseif($campana->id_producto == 24 || $campana->id_producto == 25): ?>
			<?php $this->load->view('catalogo/tablas_medidas/juvenil_manga_corta_unisex'); ?>
			<?php elseif($campana->id_producto == 27 || $campana->id_producto == 28): ?>
			<?php $this->load->view('catalogo/tablas_medidas/juvenil_manga_larga_unisex'); ?>
			<?php elseif($campana->id_producto == 29 || $campana->id_producto == 30): ?>
			<?php $this->load->view('catalogo/tablas_medidas/infantil_manga_corta_unisex'); ?>
			<?php elseif($campana->id_producto == 31 || $campana->id_producto == 32): ?>
			<?php $this->load->view('catalogo/tablas_medidas/infantil_manga_larga_unisex'); ?>
			<?php elseif($campana->id_producto == 33 || $campana->id_producto == 34): ?>
			<?php $this->load->view('catalogo/tablas_medidas/bebe_manga_corta_unisex'); ?>
			<?php elseif($campana->id_producto == 35 || $campana->id_producto == 36): ?>
			<?php $this->load->view('catalogo/tablas_medidas/bebe_manga_larga_unisex'); ?>
			<?php endif; ?>
			</div>
		</div>
        <div class="small-18 medium-9 large-9 columns" id="slider-area">
            <div class="row collapse">

                <div class="small-15 medium-15 large-15 columns">
                    <div class="row" id="profile_slider">
                        <div class="small-18 columns profile_slider">
                            <?php if(isset($campana->front_image)): ?>
                                <div class="slide">
                                    <div class="zoomHolder">
                                        <img data-src="<?php echo site_url('image-tool/index.php?src='.site_url($campana->front_image).'&w=750&h=750'); ?>" data-elem="pinchzoomer"/>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if(isset($campana->back_image)): ?>
                                <div class="slide">
                                    <div class="zoomHolder">
                                        <img data-src="<?php echo site_url('image-tool/index.php?src='.site_url($campana->back_image).'&w=750&h=750'); ?>" data-elem="pinchzoomer"/>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if(isset($campana->right_image)): ?>
                                <div class="slide">
                                    <div class="zoomHolder">
                                        <img data-src="<?php echo site_url('image-tool/index.php?src='.site_url($campana->right_image).'&w=750&h=750'); ?>" data-elem="pinchzoomer"/>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if(isset($campana->left_image)): ?>
                                <div class="slide">
                                    <div class="zoomHolder">
                                        <img data-src="<?php echo site_url('image-tool/index.php?src='.site_url($campana->left_image).'&w=750&h=750'); ?>" data-elem="pinchzoomer"/>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="small-3 medium-3 large-3 columns">
                    <div class="row" id="profile_controller">
                        <div class="small-18 columns profile_controller">
                            <?php if(isset($campana->front_image)): ?>
                                <a data-slide="0" class="active">
                                    <img src="<?php echo site_url($campana->front_image); ?>" alt="Fotografía delantera" />
                                </a>
                            <?php endif; ?>
                            <?php if(isset($campana->back_image)): ?>
                                <a data-slide="1">
                                    <img src="<?php echo site_url($campana->back_image); ?>" alt="Fotografía trasera" />
                                </a>
                            <?php endif; ?>
                            <?php if(isset($campana->right_image)): ?>
                                <a data-slide="2">
                                    <img src="<?php echo site_url($campana->right_image); ?>" alt="Fotografía derecha" />
                                </a>
                            <?php endif; ?>
                            <?php if(isset($campana->left_image)): ?>
                                <a data-slide="3">
                                    <img src="<?php echo site_url($campana->left_image); ?>" alt="Fotografía izquierda" />
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>

<?php if(isset($disenos_adjuntos)): ?>
<?php if(sizeof($disenos_adjuntos) > 0): ?>
<div class="row">
    <div class="small-18 columns">
        <div class="row">
            <div class="small-18 columns">
                <p>Los clientes que compraron este producto también compraron:</p>
            </div>
        </div>
        <div class="row small-up-1 medium-up-3 large-up-4 xlarge-up-5" id="contenedor-catalogo">
        <?php foreach($disenos_adjuntos as $producto): ?>
            <?php $this->load->view('campanas/thumb_producto_chico', array('producto' => $producto)); ?>
        <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>
