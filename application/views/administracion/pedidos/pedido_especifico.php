<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title"><a href="<?php echo site_url('administracion/pedidos'); ?>">« Regresar a Pedidos</a></h2>
	</div>
</div>
<?php if($pedido->id_paso_pedido < 7): ?>
<div class="row resumen-pedido">
    <div class="small-24 columns">
    	<ul class="small-block-grid-6 text-center" id="pasos-pedido">
            <li class="<?php paso_pedido_class(1, $pedido->id_paso_pedido); ?>">
                <div>
                    <img src="<?php echo site_url('assets/images/pasos/1_confirmacion.svg'); ?>" alt="Confirmación de pago" />
                    <h5>Confirmación de pago</h5>
                    <?php historial_pedido_tiempo($pedido->historial, 1); ?>
                </div>
            </li>
            <li class="<?php paso_pedido_class(2, $pedido->id_paso_pedido); ?>">
                <div>
                    <img src="<?php echo site_url('assets/images/pasos/2_produccion.svg'); ?>" alt="Cliente Confirmado" />
                    <h5>Cliente confirmado</h5>
                    <?php historial_pedido_tiempo($pedido->historial, 2); ?>
                </div>
            </li>
            <li class="<?php paso_pedido_class(3, $pedido->id_paso_pedido); ?>">
                <div>
                    <img src="<?php echo site_url('assets/images/pasos/2_produccion.svg'); ?>" alt="En producción" />
                    <h5>En producción</h5>
                    <?php historial_pedido_tiempo($pedido->historial, 3); ?>
                </div>
            </li>
            <li class="<?php paso_pedido_class(4, $pedido->id_paso_pedido); ?>">
                <div>
                    <img src="<?php echo site_url('assets/images/pasos/3_imprenta.svg'); ?>" alt="Imprenta" />
                    <h5>En imprenta</h5>
                    <?php historial_pedido_tiempo($pedido->historial, 4); ?>
                </div>
            </li>
            <li class="<?php paso_pedido_class(5, $pedido->id_paso_pedido); ?>">
                <div>
                    <img src="<?php echo site_url('assets/images/pasos/4_envio.svg'); ?>" alt="En proceso de entrega" />
                    <h5>En proceso de entrega</h5>
                    <?php historial_pedido_tiempo($pedido->historial, 5); ?>
                </div>
            </li>
            <li class="last<?php paso_pedido_class(6, $pedido->id_paso_pedido); ?>">
                <div>
                    <img src="<?php echo site_url('assets/images/pasos/5_entregado.svg'); ?>" alt="Entregado" />
                    <h5>Pedido entregado</h5>
                    <?php historial_pedido_entrega($pedido->historial, 6); ?>
                </div>
            </li>
        </ul>
    </div>
</div>
<?php endif; ?>
<div class="row resumen-pedido" style="padding:0 0.3rem">
	<div class="small-8 columns">
		<table class="campana_info pedido_info">
			<tr>
				<th colspan="2" class="text-center">Datos del pedido</th>
			</tr>
			<tr>
				<th width="35%">Estatus</th>
				<td width="65%"><?php echo $pedido->fa_icon.' '.$pedido->nombre_paso; ?></td>
			</tr>
			<tr>
				<th width="35%">Fecha</th>
				<td width="65%"><?php echo date("d/m/Y H:i:s", strtotime($pedido->fecha_creacion)); ?></td>
			</tr>
			<tr>
				<th width="35%">Nombre</th>
				<td width="65%"><?php echo $pedido->nombres; ?> <?php echo $pedido->apellidos; ?></td>
			</tr>
			<tr>
				<th>E-Mail</th>
				<td><?php echo $pedido->email; ?></td>
			</tr>
            <tr>
                <th># Pedidos</th>
                <td><?php echo $num_pedidos; ?></td>
            </tr>
			<tr>
				<th>No.</th>
				<td><?php echo str_pad($pedido->id_pedido, 8, "0", STR_PAD_LEFT); ?></td>
			</tr>
			<tr>
				<th>Productos</th>
				<td><?php echo $pedido->numero_productos; ?></td>
			</tr>
			<tr>
				<th>Subtotal</th>
                <?php $cupon = $this->db->get_where('Cupones', array('id' => $pedido->id_cupon))->row(); ?>
				<td>$ <?php 
                        echo $this->cart->format_number($pedido->subtotal);
                     ?></td>
			</tr>
			<?php if($pedido->descuento > 0.00): ?>
			<tr>
				<th>Saldo a favor</th>
				<td>-$ <?php echo $this->cart->format_number($pedido->descuento); ?></td>
			</tr>
			<tr>
				<th>Subtotal + Saldo a favor</th>
				<td>$ <?php echo $this->cart->format_number($pedido->subtotal - $pedido->descuento); ?></td>
			</tr>
			<?php endif; ?>
			<?php if($pedido->id_cupon): ?>		
			<tr>
				<th>Cupón</th>
				<td><?php echo $cupon->cupon; ?></td>
			</tr>
			<tr>
				<th>Descuento</th>
				<td><?php
					if($cupon->descuento > 0 && $cupon->descuento < 1) {
						echo '-'.($cupon->descuento * 100).'%';
					} else if($cupon->descuento >= 1) {
						echo '-$'.$this->cart->format_number($cupon->descuento);
					} else if($cupon->tipo == 4){
                        echo '-$'.$this->cart->format_number($pedido->costo_envio);
                    }
				?></td>
			</tr>
			<tr>
				<th>Subtotal con cupón</th>
				<td>$ <?php if($cupon->descuento > 0 && $cupon->descuento < 1) {
					echo $this->cart->format_number($pedido->subtotal * (1-$cupon->descuento));
				} else if($cupon->descuento >= 1) {
					echo $this->cart->format_number($pedido->subtotal - $cupon->descuento);
				} else if($cupon->tipo == 4){
                    echo $this->cart->format_number($pedido->subtotal);
                }
                 ?></td>
			</tr>
			<?php endif; ?>
			<tr>
				<th>Envío</th>
				<td>$ <?php 
                    if($cupon->tipo == 4){
                         echo '0.00';
                    }else{
                        echo $this->cart->format_number($pedido->costo_envio);
                    }
                ?></td>
			</tr>
			<tr>
				<th>Total</th>
				<td>$ <?php echo $this->cart->format_number($pedido->total); ?></td>
			</tr>
		</table>
        <?php if($pedido->estatus_pedido != 'Cancelado' && $pedido->estatus_pedido != 'Cancelado por fraude' && $pedido->id_paso_pedido < 7): ?>
        <table class="campana_info pedido_info">
            <tr>
                <th colspan="2" class="text-center">Opciones de cancelación</th>
            </tr>
            <tr>
                <td colspan="1" class="text-center" width="50%"><a data-reveal-id="terminar_campana" class="cancel expand button" style="padding:0.4rem;font-size:0.8rem"><i class="fa fa-times"></i> Cancelar pedido</a></td>
                <td colspan="1" class="text-center" width="50%"><a data-reveal-id="terminar_campana_fraude" class="cancel expand button" style="padding:0.4rem;font-size:0.8rem;background:darkred;"><i class="fa fa-ban"></i> Cancelar por fraude</a></td>
            </tr>
        </table>
        <?php endif; ?>
        <?php if($pedido->id_paso_pedido == 7 || $pedido->id_paso_pedido == 8): ?>
        <table class="campana_info pedido_info">
            <tr>
                <th colspan="2" class="text-center">Motivo de cancelación</th>
            </tr>
            <tr>
                <td colspan="2" class="text-left"><?php echo $pedido->observaciones; ?></td>
            </tr>
        </table>
        <?php endif; ?>
	</div>
	<div class="small-8 columns">
		<table class="campana_info pedido_info">
			<tr>
				<th colspan="2" class="text-center">Datos del pago</th>
			</tr>
			<tr>
				<th width="35%">Método</th>
				<td width="65%"><?php
					if($pedido->metodo_pago == 'paypal') {
						echo '<span class="hide">PayPal</span><img class="payimg" src="'.site_url('assets/images/paypal.svg').'" alt="PayPal" />';
					} else if($pedido->metodo_pago == 'card_payment') {
						echo '<span class="hide">Tarjeta</span><img class="payimg" src="'.site_url('assets/images/visa_mc_amex.svg').'" alt="Tarjeta" />';
					} else if($pedido->metodo_pago == 'cash_payment') {
						echo '<span class="hide">OXXO</span><img class="payimg" src="'.site_url('assets/images/oxxo.svg').'" alt="OXXO" />';
					} else if($pedido->metodo_pago == 'spei') {
                        echo '<span class="hide">SPEI</span><img class="payimg" src="'.site_url('assets/nimages/spei.png').'" alt="SPEI" />';
                    } else if($pedido->metodo_pago == 'saldo') {
                        echo '<span class="hide">SPEI</span><img class="payimg" style="max-height:20px;max-width: 80px;" src="'.site_url('assets/images/saldo.svg').'" alt="Saldo" />';
                    } else if($pedido->metodo_pago == 'stripe') {
                        echo '<span class="hide">Stripe</span><img class="payimg" src="'.site_url('assets/images/stripe.png').'" alt="Stripe" />';
                    } else if($pedido->metodo_pago == 'PPP') {
                        echo '<span class="hide">PayPal Plus</span><img class="payimg" src="'.site_url('assets/images/paypalplus.svg').'" alt="PayPal Plus" />';
                    }
				?></td>
			</tr>
			<tr>
				<th>Estatus</th>
				<td><?php echo ($pedido->estatus_pago == 'paid' ? '<i class="fa fa-check"></i> Completo' : '<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Pendiente'); ?></td>
			</tr>
			<tr>
				<th>Referencia</th>
				<td><?php echo $pedido->referencia_pago; ?></td>
			</tr>
            <?php
                if($pedido->metodo_pago == 'stripe') {
                    echo '<tr><th>ID Pago Stripe</th><td>'.$pedido->id_pago.'</td></tr>';
                }else if($pedido->metodo_pago == 'paypal'){
                    echo '<tr><th>ID Pago PayPal</th><td>'.$pedido->paypal_payer_email.'</td></tr>';
                }
            ?>
            <?php if($pedido->oxxo_codigo_barras != ""):?>
            <tr>
                <th>Código de Barras</th>
                <td><?php echo $pedido->oxxo_codigo_barras; ?></td>
            </tr>
            <?php endif;?>
			<?php if($pedido->estatus_pago == 'paid'): ?>
			<tr>
				<th>Fecha de pago</th>
				<td><?php echo ($pedido->estatus_pago == 'paid' ? date("d/m/Y H:i:s", strtotime($pedido->fecha_pago)) : ''); ?></td>
			</tr>

			<?php endif; ?>
            <tr>
                <th>Acepto términos <br> y condiciones</th>
                <td><?php echo ($pedido->terminos == 1 ? date("d/m/Y H:i:s", strtotime($pedido->fecha_terminos)) : 'No ha aceptado'); ?></td>
            </tr>
		</table>
        <table class="campana_info pedido_info">
			<tr>
				<th colspan="2" class="text-center">Dirección de envío</th>
			</tr>
            <?php
            foreach($cambios_pedido as $cambio){
                if(isset($cambio->id_tipo_cambio)) {
                    if ($cambio->id_tipo_cambio == '1') {
                        $cambio_direccion = true;
                        break;
                    }
                }else{
                    $cambio_direccion = false;
                }
            }
            if($cambio_direccion):?>
                <tr>
                    <td>
                        <div style="margin-bottom: 0; padding:0.5rem;" class="text-center panel callout radius error">Hubo un cambio en la dirección de envío.</div>
                    </td>
                </tr>
            <?php endif;?>
			<tr>
				<td colspan="2" style="padding:8px 10px;">
					<strong style="color: #0a749e;"><?php echo $pedido->identificador_direccion; ?></strong><br />
					<?php echo $pedido->linea1; ?><br />
					<?php if($pedido->linea2 != '') { echo $pedido->linea2.'<br />'; } ?>
					Código Postal: <?php echo $pedido->codigo_postal; ?><br />
					Teléfono: <?php echo $pedido->dirtel; ?><br />
					<?php echo $pedido->ciudad.', '.$pedido->estado.', '.$pedido->pais; ?>
				</td>
			</tr>
            <tr>
                <td class="text-center">
                    <a href="#" data-reveal-id="modal-cambio-dir" style="margin-bottom: 0" class="button">Cambiar direccion de envio</a>
                </td>
            </tr>
		</table>
		<table class="campana_info pedido_info">
			<tr>
				<th colspan="2" class="text-center">Datos de facturación</th>
			</tr>
			<tr>
				<td colspan="2" style="padding:8px 10px;">
				<?php if($pedido->id_direccion_fiscal): ?>
					<?php $direccion_fiscal = $this->cuenta_modelo->obtener_direcciones_fiscales($pedido->id_cliente, $pedido->id_direccion_fiscal); ?>
					<strong style="color: #0a749e;"><?php echo $direccion_fiscal[0]->razon_social; ?> (<?php echo $direccion_fiscal[0]->rfc; ?>)</strong><br />
					<?php echo $direccion_fiscal[0]->linea1; ?><br />
					<?php if($direccion_fiscal[0]->linea2 != '') { echo $direccion_fiscal[0]->linea2.'<br />'; } ?>
					CFDI: <?php echo $direccion_fiscal[0]->cfdi; ?><br />
                    Código Postal: <?php echo $direccion_fiscal[0]->codigo_postal; ?><br />
					Teléfono: <?php echo $direccion_fiscal[0]->telefono; ?><br />
					Correo electrónico: <?php echo $direccion_fiscal[0]->correo_electronico_facturacion; ?><br />
					<?php echo $pedido->ciudad.', '.$pedido->estado.', '.$pedido->pais; ?>
				<?php else: ?>
					No requiere facturar.
				<?php endif; ?>
				</td>
			</tr>
		</table>
	</div>
	<div class="small-8 columns">
        <form action="<?php echo site_url('administracion/pedidos/'.$pedido->id_pedido.'/cambiar_estatus_pedido'); ?>" method="post" data-abide>
            <table class="campana_info pedido_info">
                <tr>
                    <th colspan="2" class="text-center">Cambiar estatus del pedido</th>
                </tr>
                <tr id="cam-est">
                    <td class="text-center" colspan="2">
                        <select name="cambiar_estatus" id="cambiar_estatus" style="margin:0;height:35px;background-color:white;">
                        <?php foreach($this->db->query("SELECT * FROM PasosPedido WHERE id_paso < 7")->result() as $estatus): ?>
                            <option value="<?php echo $estatus->id_paso; ?>"<?php if($estatus->id_paso == $pedido->id_paso_pedido) { echo ' selected'; } ?>><?php echo $estatus->nombre_paso; ?></option>
                        <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-center" width="70%">
                        <label><input type="checkbox" id="avisar_estatus" name="avisar_estatus" style="margin:0.7rem 0;" checked /> Avisar al cliente por correo</label>
                    </td>
                    <td class="text-center">
                        <button type="submit" class="secondary expand button" id="cambiar_estatus_pedido" style="padding:0.4rem;font-size:0.9rem;margin:0;">Cambiar</button>
                    </td>
                </tr>
            </table>
        </form>
        <?php if($pedido->id_paso_pedido == '4'): ?>
        <form action="<?php echo site_url('administracion/pedidos/'.$pedido->id_pedido.'/indicar_atraso'); ?>" method="post" data-abide>
            <table class="campana_info pedido_info">
                <tr>
                    <th colspan="2" class="text-center">Indicar atraso en proceso de impresión</th>
                </tr>
                <tr id="cam-est">
                    <td class="text-left" colspan="2">
                        <div class="clearfix">
                            <style type="text/css">.switch input:checked + label { background: red; }</style>
                            <div class="switch radius clearfix" style="margin-bottom:0;float:left;">
                                <input id="marcar_atraso" type="checkbox" name="marcar"<?php echo ($pedido->atraso == 1 ? ' checked' : ''); ?>>
                                <label for="marcar_atraso"></label>
                            </div>
                            <label for="marcar_atraso" style="float:left;display: block;font-size: 0.8rem;margin:0;padding:0;line-height: 2rem;padding-left: 0.5rem;">Marcar para indicar retraso en el proceso.</label>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
        <?php endif; ?>
        <table class="campana_info pedido_info" id="datos-envio">
            <tr>
                <th colspan="2" class="text-center">Datos de envío</th>
            </tr>
            <?php if(sizeof($info_pedido['customs']) || sizeof($info_pedido['ventas_inmediatas'])): ?>
            <?php if($pedido->codigo_rastreo == ''): ?>

<!--            <tr>-->
<!--                <td colspan="2" class="text-center">-->
<!--                    <a href="--><?php //echo site_url('administracion/pedidos/generar_envio/'.$pedido->id_pedido); ?><!--" class="button dhl"><i class="fa fa-truck"></i> Generar Envío</a>-->
<!--                </td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td colspan="2" class="text-center">-->
<!--                    o-->
<!--                </td>-->
<!--            </tr>-->

            <tr>
                <form method="post" action="<?php echo site_url('administracion/pedidos/asignar_guia/'.$pedido->id_pedido); ?>" data-abide>
                    <th class="text-right" style="vertical-align:middle;">
                        Número de guía
                    </th>
                    <td class="text-left">
                        <div class="row collapse">
                            <div class="small-14 columns">
                                <input type="text" name="codigo_rastreo" id="codigo_rastreo" required />
                            </div>
                            <div class="small-10 columns">
                                <button type="submit" id="asignar_codigo"><i class="fa fa-truck"></i> Asignar</button>
                            </div>
                        </div>
                    </th>
                </form>
            </tr>
            <?php else: ?>
            <tr>
                <th>Número de guía</th>
                <td><strong><a href="<?php echo site_url('carrito/abrir_dhl/'.$pedido->id_pedido); ?>" target="_blank"><?php echo $pedido->codigo_rastreo; ?></a></strong></td>
            </tr>
            <?php if($pedido->xml_envio_dhl != ''): ?>
            <?php /*
            <tr>
                <th style="vertical-align:middle">Etiqueta DHL</th>
                <td><a href="<?php echo site_url('administracion/pedidos/pdf_dhl/'.$pedido->id_pedido); ?>" class="button action pdfmaker" target="_blank"><i class="fa fa-file-pdf-o"></i> Generar Etiqueta</a></td>
            </tr>
            */ ?>
            <?php endif; ?>
            <?php endif; ?>
            <?php else: ?>
            <tr>
                <td colspan="2" class="text-center">
                    Este pedido no cuenta con productos personalizados, solo con productos de campaña por lo cual el envío se genera desde la sección de campaña específica.
                </td>
            </tr>
            <?php endif; ?>
        </table>

        <?php if($pedido->codigo_rastreo != ''): ?>
        <table class="campana_info pedido_info" style="margin-top:4rem;">
            <tr>
                <th colspan="2" class="text-center">Actualizar código de envío</th>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <a href="<?php echo site_url('administracion/pedidos/generar_envio/'.$pedido->id_pedido); ?>" class="button dhl"><i class="fa fa-truck"></i> Generar Envío Nuevo</a>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    o
                </td>
            </tr>
            <tr>
                <form method="post" action="<?php echo site_url('administracion/pedidos/asignar_guia/'.$pedido->id_pedido); ?>" data-abide>
                    <th class="text-right" style="vertical-align:middle;">
                        Nuevo número de guía
                    </th>
                    <td class="text-left">
                        <div class="row collapse">
                            <div class="small-14 columns">
                                <input type="text" name="codigo_rastreo" id="codigo_rastreo" required />
                            </div>
                            <div class="small-10 columns">
                                <button type="submit" id="asignar_codigo"><i class="fa fa-truck"></i> Asignar</button>
                            </div>
                        </div>
                    </th>
                </form>
            </tr>
        </table>
        <?php endif; ?>

        <?php if(sizeof($info_pedido['customs']) || sizeof($info_pedido['ventas_inmediatas'])): ?>
        <table class="campana_info pedido_info">
            <tr>
                <th colspan="2" class="text-center">Generación de PDFs</th>
            </tr>
            <tr>
                <td class="text-center">
                    <a href="<?php echo site_url('administracion/pedidos/pdf_pedido/'.$pedido->id_pedido); ?>" class="button expand pdfmaker" style="padding:0.4rem;color:white;font-size:0.8rem" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF Pedido</a>
                </td>
                <td class="text-center">
                    <a href="<?php echo site_url('administracion/pedidos/pdf_pedido_produccion/'.$pedido->id_pedido); ?>" class="button expand pdfmaker" style="padding:0.4rem;color:white;font-size:0.8rem" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF Producción</a>
                </td>
            </tr>
        </table>
        <?php endif; ?>
	</div>
</div>
<hr class="dashed" style="margin-top:0;border-style:dashed;" />

<ul class="tabs" data-tab data-options="deep_linking:true;scroll_to_content: false">
	<li class="tab-title active"><a href="#resumen_del_pedido">Resumen del pedido</a></li>
    	<?php if(sizeof($info_pedido['customs']) > 0): ?>
	<li class="tab-title"><a href="#productos_a_enviar">Productos a enviar</a></li>
	<?php endif; ?>
	<?php if(sizeof($info_pedido['ventas_inmediatas']) > 0): ?>
	<li class="tab-title"><a href="#productos_venta_inmediata">Productos de venta inmediata</a></li>
	<?php endif; ?>
	<?php if(sizeof($info_pedido['enhances']) > 0): ?>
	<li class="tab-title"><a href="#productos_de_campana">Productos de campaña</a></li>
	<?php endif; ?>
</ul>
<div class="tabs-content">
	<div class="content active" id="resumen_del_pedido">
		<div class="row">
			<div class="small-24 columns">
				<?php $this->load->view('administracion/pedidos/pedido_especifico_carrito'); ?>
			</div>
		</div>
	</div>
	<?php if(sizeof($info_pedido['customs']) > 0): ?>
	<div class="content" id="productos_a_enviar">
		<div class="row">
			<div class="small-24 columns">
				<?php foreach($info_pedido['customs'] as $indice_custom => $custom): ?>
				<?php $this->load->view('administracion/pedidos/detalle_producto_especifico', array('producto' => $custom, 'indice_custom' => $indice_custom, 'tamano_customs' => sizeof($info_pedido['customs']))); ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php if(sizeof($info_pedido['ventas_inmediatas']) > 0): ?>
	<div class="content" id="productos_venta_inmediata">
		<?php foreach($info_pedido['inmediatas'] as $indice_campana => $campana): ?>
			<?php $this->load->view('administracion/pedidos/detalle_venta_inmediata_especifica', array('campana' => $campana, 'indice_campana' => $indice_campana, 'tamano_campanas' => sizeof($info_pedido['ventas_inmediatas']))); ?>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	<?php if(sizeof($info_pedido['enhances']) > 0): ?>
	<div class="content" id="productos_de_campana">
	<?php foreach($info_pedido['enhances'] as $indice_campana => $campana): ?>
		<?php $this->load->view('administracion/pedidos/detalle_campana_especifica', array('campana' => $campana, 'indice_campana' => $indice_campana, 'tamano_campanas' => sizeof($info_pedido['enhances']))); ?>
	<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>



<div class="reveal-modal small" id="terminar_campana" data-reveal>
	<form action="<?php echo site_url('administracion/pedidos/cancelar_pedido/'.$pedido->id_pedido); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Motivo de la cancelación
					<textarea name="motivo" id="motivo" style="min-height: 80px;" required></textarea>
				</label>
				<small class="error">Campo requerido.</small>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<label><input type="checkbox" name="avisar" checked /> Avisar por correo a la persona.</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<button type="submit">Cancelar Pedido</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>


<div class="reveal-modal small" id="terminar_campana_fraude" data-reveal>
	<form action="<?php echo site_url('administracion/pedidos/pedido_fraudulento/'.$pedido->id_pedido); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Motivo de la cancelación
					<textarea name="motivo" id="motivo" style="min-height: 80px;" required></textarea>
				</label>
				<small class="error">Campo requerido.</small>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<button type="submit">Cancelar Pedido Fraudulento</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="modal-cambio-dir" class="reveal-modal medium" data-reveal>
    <form action="<?php echo site_url("administracion/pedidos/cambio_direccion_envio/$pedido->id_pedido/$pedido->id_cliente/$pedido->id_direccion"); ?>" method="post" data-abide>
        <div class="row">
            <div class="small-24 columns">
                <label>Direcciones del cliente disponibles
                    <?php $direcciones = $this->cuenta_modelo->obtener_direcciones($pedido->id_cliente)?>
                    <select id="direccion_cliente" name="direccion_cliente" required>
                        <option value="none" selected>Direcciones Existentes</option>
                        <?php foreach($direcciones as $direccion){
                            echo "<option id='opt-$direccion->id_direccion' value='$direccion->id_direccion' data-identificador='$direccion->identificador_direccion' data-linea1='$direccion->linea1' data-linea2='$direccion->linea2' data-cp='$direccion->codigo_postal' data-ciudad='$direccion->ciudad' data-estado='$direccion->estado' data-tel='$direccion->telefono'>
                                $direccion->identificador_direccion $direccion->linea1 $direccion->linea2 $direccion->codigo_postal $direccion->ciudad $direccion->estado
                            </option>";
                        }
                        ?>
                    </select>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-12 columns">
                <p style="margin:0; font-size: 0.8rem">Nueva Dirección?</p>
                <div class="switch round small">
                    <input id="switch_nueva" type="checkbox" name="switch_nueva">
                    <label for="switch_nueva"></label>
                </div>
            </div>
            <div class="small-12 columns" id="switch-editar-dir" style="display: none">
                <p style="margin:0; font-size: 0.8rem">Editar Dirección?</p>
                <div class="switch round small">
                    <input id="switch_editar" type="checkbox" name="switch_editar">
                    <label for="switch_editar"></label>
                </div>
            </div>
        </div>
        <div class="row" id="form_nueva_dir" style="display: none">
            <div class="small-24 columns">
                <label>Identificador
                    <input name="identificador_dir">
                </label>
            </div>
            <div class="small-8 columns">
                <label>Codigo Postal
                    <input name="cp_dir">
                </label>
            </div>
            <div class="small-16 columns">
                <label>Ciudad (máximo 35 caracteres)
                    <input name="ciudad_dir" maxlength="35">
                </label>
            </div>
            <div class="small-24 columns">
                <label>Linea 1 (máximo 35 caracteres)
                    <input name="linea1_dir" maxlength="35">
                </label>
                <label>Linea 2 (máximo 35 caracteres)
                    <input name="linea2_dir" maxlength="35">
                </label>
            </div>
            <div class="small-16 columns">
                <label>Estado
                    <select name="estado_dir">
                        <option value="" selected></option>
                        <option value="Aguascalientes">Aguascalientes</option>
                        <option value="Baja California">Baja California</option>
                        <option value="Baja California Sur">Baja California Sur</option>
                        <option value="Campeche">Campeche</option>
                        <option value="Chiapas">Chiapas</option>
                        <option value="Chihuahua">Chihuahua</option>
                        <option value="Coahuila">Coahuila</option>
                        <option value="Colima">Colima</option>
                        <option value="Distrito Federal">Distrito Federal</option>
                        <option value="Durango">Durango</option>
                        <option value="Estado de México">Estado de México</option>
                        <option value="Guanajuato">Guanajuato</option>
                        <option value="Guerrero">Guerrero</option>
                        <option value="Hidalgo">Hidalgo</option>
                        <option value="Jalisco">Jalisco</option>
                        <option value="Michoacán">Michoacán</option>
                        <option value="Morelos">Morelos</option>
                        <option value="Nayarit">Nayarit</option>
                        <option value="Nuevo León">Nuevo León</option>
                        <option value="Oaxaca">Oaxaca</option>
                        <option value="Puebla">Puebla</option>
                        <option value="Querétaro">Querétaro</option>
                        <option value="Quintana Roo">Quintana Roo</option>
                        <option value="San Luis Potosí">San Luis Potosí</option>
                        <option value="Sinaloa">Sinaloa</option>
                        <option value="Sonora">Sonora</option>
                        <option value="Tabasco">Tabasco</option>
                        <option value="Tamaulipas">Tamaulipas</option>
                        <option value="Tlaxcala">Tlaxcala</option>
                        <option value="Veracruz">Veracruz</option>
                        <option value="Yucatán">Yucatán</option>
                        <option value="Zacatecas">Zacatecas</option>
                    </select>
                </label>
            </div>
            <div class="small-8 columns">
                <label>Teléfono
                    <input name="tel_dir" pattern="[0-9]{10}">
                </label>
            </div>
        </div>
        <div class="row" id="form_editar_dir" style="display: none">
            <div class="small-24 columns">
                <label>Identificador
                    <input id="ed_identificador"  name="ed_identificador_dir">
                </label>
            </div>
            <div class="small-8 columns">
                <label>Codigo Postal
                    <input id="ed_cp" name="ed_cp_dir">
                </label>
            </div>
            <div class="small-16 columns">
                <label>Ciudad (máximo 35 caracteres)
                    <input id="ed_ciudad" name="ed_ciudad_dir" maxlength="35">
                </label>
            </div>
            <div class="small-24 columns">
                <label>Linea 1 (máximo 35 caracteres)
                    <input id="ed_linea1" name="ed_linea1_dir" maxlength="35">
                </label>
                <label>Linea 2 (máximo 35 caracteres)
                    <input id="ed_linea2" name="ed_linea2_dir" maxlength="35">
                </label>
            </div>
            <div class="small-16 columns">
                <label>Estado
                    <select id="ed_estado" name="ed_estado_dir">
                        <option value="" selected></option>
                        <option value="Aguascalientes">Aguascalientes</option>
                        <option value="Baja California">Baja California</option>
                        <option value="Baja California Sur">Baja California Sur</option>
                        <option value="Campeche">Campeche</option>
                        <option value="Chiapas">Chiapas</option>
                        <option value="Chihuahua">Chihuahua</option>
                        <option value="Coahuila">Coahuila</option>
                        <option value="Colima">Colima</option>
                        <option value="Distrito Federal">Distrito Federal</option>
                        <option value="Durango">Durango</option>
                        <option value="Estado de México">Estado de México</option>
                        <option value="Guanajuato">Guanajuato</option>
                        <option value="Guerrero">Guerrero</option>
                        <option value="Hidalgo">Hidalgo</option>
                        <option value="Jalisco">Jalisco</option>
                        <option value="Michoacán">Michoacán</option>
                        <option value="Morelos">Morelos</option>
                        <option value="Nayarit">Nayarit</option>
                        <option value="Nuevo León">Nuevo León</option>
                        <option value="Oaxaca">Oaxaca</option>
                        <option value="Puebla">Puebla</option>
                        <option value="Querétaro">Querétaro</option>
                        <option value="Quintana Roo">Quintana Roo</option>
                        <option value="San Luis Potosí">San Luis Potosí</option>
                        <option value="Sinaloa">Sinaloa</option>
                        <option value="Sonora">Sonora</option>
                        <option value="Tabasco">Tabasco</option>
                        <option value="Tamaulipas">Tamaulipas</option>
                        <option value="Tlaxcala">Tlaxcala</option>
                        <option value="Veracruz">Veracruz</option>
                        <option value="Yucatán">Yucatán</option>
                        <option value="Zacatecas">Zacatecas</option>
                    </select>
                </label>
            </div>
            <div class="small-8 columns">
                <label>Teléfono
                    <input id="ed_tel" name="ed_tel_dir" pattern="[0-9]{10}">
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-24 columns text-center">
                <button type="submit">Cambiar dirección de envío</button>
            </div>
        </div>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
