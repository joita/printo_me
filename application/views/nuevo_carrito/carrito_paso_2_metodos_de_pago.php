<script src="https://www.paypalobjects.com/webstatic/ppplusdcc/ppplusdcc.min.js" type="text/javascript"> </script>
<form action="<?php echo ($this->cart->obtener_total() <= 0 ? site_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar-saldo') : site_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar-tarjeta')); ?>" method="post" id="pagar-form" enctype="multipart/form-data" data-abide novalidate>
    <div class="fgc pscat" style="background: white">
    	<div class="row small-collapse medium-uncollapse">
            <div class="small-18 medium-11 large-12 columns">
                <div class="address-area">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 style="color: #FF4C00;font-weight: bold; border: none; border-bottom: 2px solid #025573;" class="text-center medium-text-left">Método de pago  <span class="saldazo"> (No aceptamos tarjeta saldazo)</span></h2>
                        </div>
                    </div>
                    <?php

                    $fecha_creacion = date_parse($this->session->direccion_temporal['fecha_creacion']);
                    $fecha_condicion = date_parse("2019-10-22");
                    if($fecha_creacion < $fecha_condicion):?>
                        <div class="callout warning">
                            <p>Para poder brindarte un mejor servicio nos ayudaría mucho si pudieras actualizar tus datos de envío, para hacerlo ahora haz clic <a href="mi-cuenta/direcciones">aquí</a>.</p>
                        </div>
                    <?php endif;?>
                    <div class="row ">
                        <div class="col-md-12">
                            <ul class="tabs" data-deep-link="true" data-tabs id="tab_pago">
                                <?php if($this->cart->obtener_total() <= 0): ?>
                                    <li class="tabs-title is-active"><a href="#pago_saldo"><img src="<?php echo site_url('assets/images/saldo.svg'); ?>" alt="Saldo a favor" /></a></li>
                                <?php else: ?>
                                    <?php if($ganador == "conekta"):?>
                                        <li class="tabs-title is-active"><a href="#pago_tarjeta"><img src="<?php echo site_url('assets/images/visa_mc_amex.svg'); ?>" alt="Tarjetas" /></a></li>
                                    <?php endif;?>
                                    <li class="tabs-title is-active"><a href="#pago_paypal"><img src="<?php echo site_url('assets/images/paypal.svg'); ?>" alt="PayPal" /></a></li>
                                    <li class="tabs-title "><a href="#pago_PPPtarjeta"><img src="<?php echo site_url('assets/images/paypalplus.svg'); ?>" alt="PayPal Plus" /></a></li>
                                    <?php if($this->cart->obtener_total() < 10000): ?>
                                        <li class="tabs-title"><a href="#pago_oxxo"><img src="<?php echo site_url('assets/images/oxxopay.svg'); ?>" alt="OXXO" /></a></li>
                                    <?php endif; ?>
                                    <li class="tabs-title "><a href="#pago_stripe"><img src="<?php echo site_url('assets/images/visa_mc_amex.svg'); ?>" alt="Stripe" /></a></li>



                                    <?php if($this->cart->obtener_total() >= 3000): ?>
                                        <li class="tabs-title"><a href="#pago_transferencia"><img src="<?php echo site_url('assets/nimages/spei.png'); ?>" alt="Transferencia" /></a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                            <div class="tabs-content" data-tabs-content="tab_pago">
                            <?php if($this->cart->obtener_total() <= 0): ?>
                                <div class="tabs-panel is-active" id="pago_saldo">
                                    <div class="row paypal_pay">
                                        <div class="col-md-4 col-xs-12 text-center">
                                            <img id="pp" src="<?php echo site_url('assets/nimages/ps.svg'); ?>" alt="Saldo a favor" />
                                        </div>
                                        <div class="col-md-8 col-xs-12" id="saldop">
                                            <p class="text-justify aceptamos">Detectamos que cuentas con saldo a favor que supera el monto de tu pedido.</p>
                                            <p class="text-justify aceptamos">Lo único que tienes que hacer es finalizar tu compra para que se registre en nuestro sistema y empiece a ser procesada.</p>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="tabs-panel is-active" id="pago_paypal">
                                    <div class="row paypal_pay">
                                        <div class="col-md-4 col-xs-12 text-center">
                                            <img id="pp" src="<?php echo site_url('assets/nimages/pp.svg'); ?>" alt="PayPal" />
                                        </div>
                                        <div class="col-md-8 col-xs-12" id="paypalp">
                                            <p class="text-justify aceptamos">Al dar clic en Finalizar compra te redirigiremos de manera segura al portal de PayPal.</p>
                                            <p class="text-justify aceptamos">Una vez confirmado el pago por PayPal, procederemos con la preparación de tu pedido.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="tabs-panel " id="pago_stripe">
                                    <div class="row stripe_pay">

                                            <div class="col-md-12">
                                                <div id='card-errors' class="alert callout" data-closable style="display: none">
                                                    <button class="close-button" aria-label="Dismiss alert" type="button" data-close><span aria-hidden="true">&times;</span></button>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xs-12 text-center">
                                                <img id="candado" src="<?php echo site_url('assets/nimages/compra-segura.svg'); ?>" alt="Compra Segura" />
                                            </div>
                                            <div class="col-md-8 col-xs-12 columns">
                                                <div class="row card_pay">
                                                    <div class="small-18 columns">
                                                        <label style="color: #FF4C00;">Nombre del tarjetahabiente
                                                            <div class="input-group">
                                                                <input style="border: 2px solid #025573 !important;border-radius: 10px !important; color: #FF4C00;" type="text" id="card_name" placeholder="Nombre como aparece en la tarjeta.">
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row card_pay">
                                                    <div class="col-md-12">
                                                        <label style="color: #FF4C00;" for="stripe_card_number">Número de la tarjeta</label>
                                                        <div id="stripe_card_number">
                                                            <!--Generado por stripe-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row card_pay">
                                                    <div class="col-md-8 col-xs-12">
                                                        <label style="color: #FF4C00;" for="stripe_expiry">Válida hasta:</label>
                                                        <div id="stripe_expiry">
                                                            <!--Generado por stripe-->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12 end">
                                                        <label style="color: #FF4C00;" for="stripe_cvc">CVC:</label>
                                                        <div id="stripe_cvc">
                                                            <!--Generado por stripe-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                                </div>
                                <?php if($ganador == "conekta"):?>
                                <!--++++++++++++++++++++++++++++++++++INICIO TARJETAS++++++++++++++++++++++++++++++++-->
                                <div class="tabs-panel is-active" id="pago_tarjeta">
                                    <div class="row">
                                        <?php if($this->session->flashdata('error_pago')): ?>
                                            <div class="col-md-12">
                                                <div class="alert callout" data-closable>
                                                    <p><?php echo $this->session->flashdata('error_pago')->getMessage(); ?></p>
                                                    <button class="close-button" aria-label="Dismiss alert" type="button" data-close><span aria-hidden="true">&times;</span></button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-md-4 col-xs-12  text-center">
                                            <img id="candado" src="<?php echo site_url('assets/nimages/compra-segura.svg'); ?>" alt="Compra Segura" />
                                        </div>
                                        <div class="col-md-8 col-xs-12">
                                            <div class="row card_pay">
                                                <div class="col-md-12">
                                                    <label>Nombre del tarjetahabiente
                                                        <div class="input-group">
                                                            <input type="text" id="card_name" data-conekta="card[name]" placeholder="Nombre como aparece en la tarjeta.">
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row card_pay">
                                                <div class="col-md-12">
                                                    <label>Número de la tarjeta
                                                        <div class="input-group">
                                                            <input type="text" id="card_number" data-conekta="card[number]" placeholder="•••• •••• •••• ••••">
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row card_pay">
                                                <div class="col-md-8 col-xs-12">
                                                    <label>Válida hasta:
                                                        <div class="input-group">
                                                            <input type="text" id="card_expiry_date" placeholder="•• / ••">
                                                            <input type="hidden" id="card_expiry_month" size="2" data-conekta="card[exp_month]">
                                                            <input type="hidden" id="card_expiry_year" size="4" data-conekta="card[exp_year]">
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="col-md-4 col-xs-12 end">
                                                    <label for="card_verification">CVC:
                                                        <div class="input-group">
                                                            <input type="text" id="card_verification" data-conekta="card[cvc]" placeholder="••••">
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>
                                <!--++++++++++++++++++++++++++++++++++++FIN TARJETAS+++++++++++++++++++++++++++++++++-->
                                <!--++++++++++++++++++++++++++++++++++++++INICIO FORMULARIO PPP+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                                <div class="tabs-panel" id="pago_PPPtarjeta">
                                    <div class="col-md-12 ">
                                        <div id="error-ppp" class="callout warning" style="display:none;">
                                            <!--info error generado por ppp-->
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="ppplusDiv">
                                            <!--Area de formulario para PPP-->
                                        </div>
                                    </div>
                                </div>
								<!--++++++++++++++++++++++++++++++++++++++++++++++++FINAL FORMULARIO PPP++++++++++++++++++++++++++++++++++++++++-->
                                <?php if($this->cart->obtener_total() < 10000): ?>
                                <div class="tabs-panel" id="pago_oxxo">
                                    <div class="row oxxo_pay">
                                        <div class="col-md-4 col-xs-12 text-center">
                                            <img id="op" src="<?php echo site_url('assets/nimages/op.svg'); ?>" alt="OXXO Pay" />
                                        </div>
                                        <div class="col-md-8 col-xs-12" id="opp">
                                        <?php if($this->cart->obtener_total() < 10000): ?>
                                            <p class="text-justify aceptamos">Puedes realizar tu pago en cualquier OXXO de la República Mexicana: hasta por $10,000 pesos de compra, con el cargo de comisión por transacción vigente en OXXO.</p>
                                            <p class="text-justify aceptamos">Una vez que se genere el cargo, contarás con <strong>5 días para realizar el pago</strong>. Una vez realizado el pago, <strong>recibirás confirmación vía correo electrónico y a partir de dicha confirmación se empezará a procesar tu pedido</strong>. Si requieres de un proceso más rápido para tu pedido, te recomendamos pagar con tarjeta de crédito. Una vez que confirmes tu orden te enviaremos los datos para tu pago en OXXO.</p>
                                        <?php else: ?>
                                            <p class="text-justify aceptamos naranja">El pago en OXXO es disponible por montos de máximo $10,000 pesos.</p>
                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if($this->cart->obtener_total() >= 3000): ?>
                                <div class="tabs-panel" id="pago_transferencia">
                                    <div class="row spei_pay">
                                        <div class="col-md-4 col-xs-12 text-center">
                                            <img id="speip" src="<?php echo site_url('assets/nimages/speigrande.png'); ?>" alt="SPEI - Transferencia" />
                                        </div>
                                        <div class="col-md-8 col-xs-12 " id="speipp">
                                            <p class="text-justify aceptamos">Te generaremos una ficha de transferencia en la que vendrá el monto a pagar y la CLABE para la transferencia electrónica. Realiza la transferencia correspondiente por la cantidad exacta en la ficha, <strong>de lo contrario se rechazará el cargo</strong>.</p>
                                            <p class="text-justify aceptamos">Una vez que se genere el cargo, contarás con <strong>5 días para realizar el pago</strong>. Una vez realizado el pago, <strong>recibirás confirmación vía correo electrónico y a partir de dicha confirmación se empezará a procesar tu pedido</strong>. Si requieres de un proceso más rápido para tu pedido, te recomendamos pagar con tarjeta de crédito.</p>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 sums-area" id="sums-area-top">
                <div>
                    <div>
                        <?php $this->load->view('nuevo_carrito/mini_cart_excerpt'); ?>

                        <div class="row ">
                            <div class="col-md-12">
                                <div class="g-recaptcha" data-sitekey="6LclRioUAAAAAIDqJHxFoDPoTIcKek4G4bEsXYoG" data-callback="enabledSubmit"></div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="form-check terminos">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        He leído los <a href="<?php echo site_url('terminos-y-condiciones'); ?>" target="_blank">Términos y Condiciones del servicio</a>, los acepto sin reservas
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button style="background: #FF4C00 !important; color: white; border-radius: 10px" type="submit" class="expanded btn btn-hover btn-completo success button big-next-button" id="finalizar-compra" onclick="">Finalizar compra <i class="fa fa-check"></i></button>
                            </div>
                            <div class="col-md-12" id="boton-ppp" style="display: none">
                                <button style="background: #FF4C00 !important; color: white; border-radius: 10px" type="submit" class="expanded success btn btn-completo btn-hover button big-next-button" id="continueButton" onclick="ppp.doContinue(); return false;">Finalizar compra <i class="fa fa-check"></i></button>
                            </div>
                        </div>

                        <div class="row " id="info-adicional-cart">
                            <div class="col-md-12">
                                <p id="texto-dhl"><i class="fa fa-truck"></i> Espera tus productos personalizados via <strong>DHL</strong> desde el <strong><?php
                                        $paymentDate = date('Y-m-d');
                                        $paymentDate=date('Y-m-d', strtotime($paymentDate));
                                        $firstDateBegin = date('Y-m-d', strtotime("04/01/2020"));
                                        $firstDateEnd = date('Y-m-d', strtotime("05/31/2020"));
                                        $secondDateBegin = date('Y-m-d', strtotime("12/21/2019"));
                                        $secondDateEnd = date('Y-m-d', strtotime("01/07/2020"));
                                        if (($paymentDate >= $firstDateBegin) && ($paymentDate <= $firstDateEnd)){
                                            //16-20
                                            fecha("06/15/2020");
                                        }else if(($paymentDate >= $secondDateBegin) && ($paymentDate <= $secondDateEnd)){
                                            //21-7
                                            fecha("01/16/2019");
                                        }else{
                                            fecha($recibir);
                                        }?></strong>.</p>
                                <a style="font-size: 0.8rem" data-open="info-areas-diseno">¡Recuerda las medidas y colores de impresión!</a>
                            </div>
                        </div>

                        <div class="row " id="info-direccion-cart">
                            <div class="col-md-12">
                                <p id="ddd"><strong>Dirección seleccionada de envío</strong></p>
                                <p>
                                    <strong><?php echo $direccion_recibir->identificador_direccion; ?></strong><br />
            						<?php echo $direccion_recibir->linea1; ?><br />
            						<?php if($direccion_recibir->linea2 != '') { echo $direccion_recibir->linea2.'<br />'; } ?>
            						Código Postal: <?php echo $direccion_recibir->codigo_postal; ?><br />
                                    Teléfono: <?php echo $direccion_recibir->telefono; ?><br />
            						<?php echo $direccion_recibir->ciudad.', '.$direccion_recibir->estado.', '.$direccion_recibir->pais; ?>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<div class="small reveal" id="recomendamos_paypal" style="padding:1.5rem 0.7rem;max-width:500px;" data-reveal>
    <div class="row">
        <div class="col-md-12 small-centered">
            <img src="<?php echo site_url('assets/nimages/ohno.png'); ?>" alt="Problemas con tarjeta" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center" style="margin:1rem 0;"><strong>¡Oh no!</strong></h2>
            <p>Al intentar el cobro a tu tarjeta, el sistema de pagos nos marcó el siguiente error:</p>
            <?php if($this->session->flashdata('error_pago')): ?>
                <p ><?php echo $this->session->flashdata('error_pago'); ?></p>
            <?php endif; ?>
            <p id="error-pago-ppp"><!--Mensaje de error PPP--></p>
            <p id="mensaje-per-ppp"><!--Mensaje Personalizado PPP--></p>
            <a id="cambiar_paypal" class="success expanded button" style="margin-bottom: 0;"><strong>Quiero pagar con PayPal</strong></a>
        </div>
    </div>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="small reveal" id="info-areas-diseno" data-reveal>
    <div class="row">
        <div class="col-md-12">
            <ul>
                <li><p>La medida del área de impresión máxima es de 15 cm por 12 cm para niños y de 30 cm por 35 cm para adultos, sin embargo dependiendo del diseño podrían existir variaciones en las impresiones.</p></li>
                <li><p>Recuerda que la impresión no siempre será idéntica al color de la imagen digital. Dependerá de la calidad de la imagen proporcionada.<br>*Si tienes dudas y/o aclaraciones sobre la calidad de tu imagen contáctanos. </p></li>
            </ul>
        </div>
    </div>

    <button class="close-button" data-close aria-label="Cerrar" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="loading" id="paymentload" style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:1000000;opacity:0.9;">
    <span style="display:block;position:absolute;top: 50%;margin-top: 50px;width: 100%;text-align: center;padding: 0 1rem;font-weight: bold;color: #0e0e0e;" id="mensaje-carga">Estamos inicializando el formulario de pago, por favor espera.</span>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>