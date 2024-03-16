<div class="row special-row">
    <div class="col-md-6 col-xs-12">
        <h2 class="seccionador show-for-medium text-left" style="color: #025573;font-weight: bold">Mis Pedidos</h2>
    </div>
    <div class="col-md-6 col-xs-12">
        <select id="periodo" style="border-radius: 10px; border: 2px solid #025573; color: #F2560D">
            <option style="color: #F2560D" value="1"<?php if($periodo == 1) { echo ' selected'; } ?>>Del último mes</option>
            <option style="color: #F2560D" value="3"<?php if($periodo == 3) { echo ' selected'; } ?>>De los últimos 3 meses</option>
            <option style="color: #F2560D" value="6"<?php if($periodo == 6) { echo ' selected'; } ?>>De los últimos 6 meses</option>
            <option style="color: #F2560D" value="9"<?php if($periodo == 9) { echo ' selected'; } ?>>De los últimos 9 meses</option>
            <option style="color: #F2560D" value="12"<?php if($periodo == 12) { echo ' selected'; } ?>>Del último año</option>
            <option style="color: #F2560D" value="0"<?php if($periodo == 0) { echo ' selected'; } ?>>Todos</option>
        </select>
    </div>
</div>
<div class="row ">
	<div class="col-md-12">
		<?php if(sizeof($pedidos) > 0): ?>
		<?php foreach($pedidos as $pedido): ?>
        <?php $info_pedido = clasificar_productos_pedido($pedido); ?>
		<div class="pedido" style="border: none">
			<div class="row head" style="background: none">
				<div class="col-md-6 col-xs-12 text-center medium-text-left" style="color:#F2560D ; font-size: 1.2rem">
					Resumen del pedido: <em style="color:#F2560D; font-size: 1.2rem"><?php echo str_pad($pedido->id_pedido, 8, "0", STR_PAD_LEFT); ?></em>
				</div>
				<div class="col-md-6 col-xs-12 text-center medium-text-right" style="color:#F2560D; font-size: 1.2rem">
					Fecha: <em style="color:#F2560D ; font-size: 1.2rem"><?php echo date("d/m/Y H:i:s", strtotime($pedido->fecha_creacion)); ?></em>
				</div>
			</div>
			<div class="row info-pedido " data-equalizer="filas" data-equalize-on="large">
                <div class="col-md-6 col-xs-12 datos-pedido" data-equalizer-watch="filas">
                    <div class="row ">
                        <div class="col-md-12">
                            <?php if(sizeof($info_pedido['enhances']) > 0 && sizeof($info_pedido['inmediatas']) == 0 && sizeof($info_pedido['customs']) == 0): ?>
                                <?php $this->load->view('mi-cuenta/proceso', array('pedido' => $pedido, 'purasplazo' => true)); ?>
                            <?php else: ?>
                                <?php if($pedido->id_paso_pedido <= 6): ?>
                                    <?php $this->load->view('mi-cuenta/proceso', array('pedido' => $pedido, 'purasplazo' => false)); ?>
                                    <h3 style="color:#025573" class="estatus-pedido-titulo"><?php echo $pedido->fa_icon.' '.$pedido->nombre_paso; ?></h3>
                                    <?php if($pedido->id_paso_pedido == 4 && $pedido->atraso == 1): ?>
                                        <p style="color:#025573">Hemos tenido un retraso con la impresión de tu producto, sin embargo, actualmente se encuentra en el proceso de impresión y al concluir estará listo para su envío.</p>
                                    <?php else: ?>
                                        <p style="color:#025573"><?php echo $pedido->descripcion_paso; ?></p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <h3 style="color:#025573" class="estatus-pedido-titulo"><?php echo $pedido->fa_icon.' '.$pedido->nombre_paso; ?></h3>
                                    <?php if($pedido->observaciones != ''): ?>
                                        <p style="color:#025573"><?php echo $pedido->observaciones; ?></p>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <table>
                        <tr>
                            <td style="color:#025573">Método de pago</td>
                            <th ><?php
                                if($pedido->metodo_pago == 'paypal') {
                                    echo '<span class="hide">PayPal</span><img src="'.site_url('assets/images/paypal.svg').'" alt="PayPal" />';
                                } else if($pedido->metodo_pago == 'card_payment') {
                                    echo '<span class="hide">Tarjeta</span><img src="'.site_url('assets/images/visa_mc_amex.svg').'" alt="Tarjeta" />';
                                } else if($pedido->metodo_pago == 'cash_payment') {
                                    echo '<span class="hide">OXXO</span><img src="'.site_url('assets/images/oxxopay.svg').'" alt="OXXO" />';
                                } else if($pedido->metodo_pago == 'spei') {
                                    echo '<span class="hide">SPEI</span><img src="'.site_url('assets/nimages/spei.png').'" alt="SPEI" />';
                                } else if($pedido->metodo_pago == 'saldo') {
                                    echo '<span class="hide">Saldo</span><img src="'.site_url('assets/images/saldo.svg').'" alt="Saldo" />';
                                } else if($pedido->metodo_pago == 'stripe') {
                                    echo '<span class="hide">Stripe</span><img class="payimg" src="'.site_url('assets/images/stripe.png').'" alt="Stripe" />';
                                }
                                ?></th>
                        </tr>
                        <?php if($pedido->id_paso_pedido <= 6): ?>
                            <tr>
                                <td style="color:#025573">Estatus del pago</td>
                                <th style="color:#F2560D"><?php echo ($pedido->estatus_pago == 'paid' ? '<i class="fa fa-check"></i> Completo' : '<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Pendiente'); ?></th>
                            </tr>
                        <?php endif; ?>
                        <?php if(!is_null($pedido->codigo_rastreo)): ?>
                            <tr>
                                <td style="color:#025573">Código de rastreo</td>
                                <th><a style="color:#F2560D" href="<?php echo site_url('carrito/abrir_dhl/'.$pedido->id_pedido); ?>" target="_blank" title="Haz clic para revisar el estatus del envío">DHL <?php echo $pedido->codigo_rastreo; ?> <i class="fa fa-external-link"></i></a>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td style="color:#025573">Productos</td>
                            <th style="color:#F2560D"><?php echo $pedido->numero_productos; ?></th>
                        </tr>
                        <tr>
                            <td style="color:#025573">Subtotal</td>
                            <th style="color:#F2560D"><?php echo '$'.$this->cart->format_number($pedido->subtotal); ?></th>
                        </tr>
                        <tr>
                            <td style="color:#025573">Envío</td>
                            <th style="color:#F2560D"><?php echo '$'.$this->cart->format_number($pedido->costo_envio); ?></th>
                        </tr>
                        <tr>
                            <td style="color:#025573">Total</td>
                            <th><strong style="color:#F2560D"><?php echo '$'.$this->cart->format_number($pedido->total); ?></strong></th>
                        </tr>
                    </table>

                    <?php if($pedido->estatus_pedido == 'Cancelado'): ?>
                        <h5 class="text-center medium-text-left">Motivo de cancelación</h5>
                        <p style="color:#F2560D"><?php echo $pedido->observaciones; ?></p>
                    <?php endif; ?>

                    <div class="row ">
                        <div class="col-md-12 btn-pedido">
                            <a style="background: #F2560D; border-radius: 10px " href="<?php echo site_url('carrito/reordenar/'.$pedido->id_pedido); ?>" class="expanded reordenar btn btn-success success button"><i class="fa fa-cart-arrow-down"></i> Volver a pedir</a>
                        </div>
                    </div>
                </div>
				<div class="col-md-6 col-xs-12 resumen" data-equalizer-watch="filas" style="border: solid 2px #025573; border-radius: 10px; padding: 1rem">
                    <div class="fgc">
                        <?php
    					    foreach($pedido->productos as $producto):
    						$car = array();
    						foreach($producto->caracteristicas as $caracteristica) {
    							array_push($car, $caracteristica);
    						}
    						$car = implode("",$car);
    					?>
                        <?php if($producto->id_enhance) {
                            $info_enhanced = $this->catalogo_modelo->obtener_enhanced_con_id($producto->id_enhance);
                            $imagen = $info_enhanced->front_image;
                            $nombre_producto = $info_enhanced->name;
                            $info_color = $info_enhanced->codigo_color;
                        } else {
                            $imagen_json = json_decode($producto->diseno);
                            $imagen_json_2 = $imagen_json->images;
                            $imagen = $imagen_json_2->front;

                            $nombre_producto = $producto->nombre_producto.' personalizada';
                            $color = $this->catalogo_modelo->obtener_color_por_id($producto->id_color);
                            $info_color = $color->codigo_color;
                        }


                        ?>
                        <div class="row  cart-entry<?php echo ($producto->id_enhance ? ($info_enhanced->type == 'limitado' ? ' enhance' : '') : ''); ?>">
                            <div class="col-md-3 col-xs-4 cart-entry-img-holder">
    							<img src="<?php echo site_url($imagen); ?>" alt="Fotografía del producto" class="cart-entry-img" />
                            </div>
                            <div class="col-md-6 col-xs-4 cart-entry-middle-col">
                                <span class="cart-entry-title" style="color:#025573"><?php echo $nombre_producto; ?></span>
                                <span class="cart-entry-info" style="color:#025573">Talla: <?php echo $car; ?>, Color: <i class="fa fa-circle" style="color:<?php echo $info_color; ?>"></i></span>
                            </div>
                            <div class="col-md-3 col-xs-4 cart-entry-last-col text-center">
                                <span class="cart-entry-whole-price">
                                    <span class="cart-entry-multiplier"><?php echo $producto->cantidad_producto; ?></span>
                                    <span class="cart-entry-x"> x </span>
                                    <span class="cart-entry-price" style="color:#F2560D">$<?php echo $this->cart->format_number($producto->precio_producto); ?></span>
                                </span>
                            </div>
                        </div>
    					<?php endforeach; ?>
                    </div>
                    <div class="row  datos-direcciones" style="border-top: solid 2px #025573; border-bottom: solid 2px #025573">
                        <div class="col-md-6 col-xs-12 left-address">
                            <h5 class="text-center medium-text-left" style="color: #025573; border: none">Dirección de envío</h5>
        					<p style="color:#F2560D">
        						<strong style="color:#F2560D; font-weight: bold; font-size: 1rem"><?php echo $pedido->identificador_direccion; ?></strong><br />
        						<?php echo $pedido->linea1; ?><br />
        						<?php if($pedido->linea2 != '') { echo $pedido->linea2.'<br />'; } ?>
        						Código Postal: <?php echo $pedido->codigo_postal; ?><br />
        						<?php echo $pedido->ciudad.', '.$pedido->estado.', '.$pedido->pais; ?>
        					</p>
                        </div>
                        <div class="col-md-6 col-xs-12 right-address">
                            <?php if($pedido->id_direccion_fiscal): ?>
        					<?php $direccion_fiscal = $this->cuenta_modelo->obtener_direcciones_fiscales($this->session->login['id_cliente'], $pedido->id_direccion_fiscal); ?>
        					<h5 class="text-center medium-text-right" style="color: #025573; border: none">Datos de facturación</h5>
        					<p style="color:#F2560D">
        						<strong style="color:#F2560D; font-weight: bold; font-size: 1rem"><?php echo $direccion_fiscal[0]->razon_social; ?> (<?php echo $direccion_fiscal[0]->rfc; ?>)</strong><br />
        						<?php echo $direccion_fiscal[0]->linea1; ?><br />
        						<?php if($direccion_fiscal[0]->linea2 != '') { echo $direccion_fiscal[0]->linea2.'<br />'; } ?>
        						Código Postal: <?php echo $direccion_fiscal[0]->codigo_postal; ?><br />
        						Teléfono: <?php echo $direccion_fiscal[0]->telefono; ?><br />
        						Correo electrónico: <?php echo $direccion_fiscal[0]->correo_electronico_facturacion; ?><br />
        						<?php echo $pedido->ciudad.', '.$pedido->estado.', '.$pedido->pais; ?>
        					</p>
        					<?php else: ?>
        					<?php $time_restante = round((((strtotime("+30 days", strtotime($pedido->fecha_creacion))-time())/24)/60)/60); ?>

        					<?php if($time_restante > 0): ?>
        					<h5 class="text-center medium-text-right" style="color: #025573; border: none">Opciones de facturación</h5>
        						<?php if(sizeof($direcciones_facturacion) > 0): ?>
        						<form method="post" action="<?php echo site_url('mi-cuenta/solicitar-factura/'.$pedido->id_pedido); ?>" id="solicitar_factura_<?php echo $pedido->id_pedido; ?>" data-abide novalidate>
        							<div class="row ">
        								<div class="col-md-12">
        									<p style="color: #025573;">Te quedan <strong style="color:#F2560D; font-weight: bold;" ><?php echo $time_restante; ?></strong> días para solicitar una factura.</p>
        								</div>
        							</div>
        							<div class="row ">
        								<div class="col-md-12 ">
        									<select style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center; color: #F2560D;" name="id_direccion_fiscal" class="id_direccion" required>
        										<option style="color: #025573;" value="">Seleccionar dirección de facturación</option>
        										<?php foreach($direcciones_facturacion as $dir_fac): ?>
        										<option style="color: #025573;" value="<?php echo $dir_fac->id_direccion_fiscal; ?>"><?php echo $dir_fac->razon_social; ?> (<?php echo $dir_fac->rfc; ?>)</option>
        										<?php endforeach; ?>
        									</select>
        								</div>
        							</div>
        							<div class="row ">
        								<div class="col-md-12 text-center">
        									<button style="color: white; background: #72A508; border-radius: 10px; margin-bottom: 10px; " type="submit" class="small expanded btn btn-completo btn-primary button">Solicitar Factura</button>
        								</div>
        							</div>
        						</form>
        						<?php else: ?>
                                    <?php if($pedido->id_paso_pedido > 6): ?>
                                        <p>Solicitud de factura no valida por ser un pedido cancelado.</p>
                                    <?php else: ?>
        						        <p>Para solicitar una factura por favor <a href="<?php echo site_url('mi-cuenta/facturacion'); ?>">agrega datos de facturación</a> a tu cuenta.</p>
                                    <?php endif; ?> 
        						<?php endif; ?>
        						<?php endif; ?>
        					<?php endif; ?>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12">
                            <br>
                            <h5 class="text-center medium-text-left" style="color: #025573; border: none">Al volver a pedir, tienes que tomar en cuenta que:</h5>
                            <p style="color:#025573">
                                Los productos personalizados se vuelven a cotizar con el precio vigente de impresión. </br>
                                <br>
                                Los productos de venta inmediata/plazo definido se agregaría al carrito solamente si siguen vigentes.
                            </p>

                        </div>
                    </div>
				</div>

			</div>
		</div>

		<?php endforeach; ?>
		<?php else: ?>
		<div class="form-cuenta text-center">
			<p>No has comprado nada en printome.mx. ¿Qué esperas?</p>
		</div>
	<?php endif; ?>
	</div>
</div>
