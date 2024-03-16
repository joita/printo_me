<form action="<?php echo site_url('cargos/pagar-tarjeta'); ?>" method="post" id="pagar-form" enctype="multipart/form-data" data-abide novalidate>
    <div class="fgc pscat">
        <div class="row ">
            <div class="col-md-12">
                <div class="address-area">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="dosf text-center medium-text-left">Método de pago</h2>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12">
                            <ul class="tabs" id="tab_pago">
                                <li class="tabs-title is-active"><a><img src="<?php echo site_url('assets/images/visa_mc_amex.svg'); ?>" alt="Tarjetas" /></a></li>
                            </ul>
                            <div class="tabs-content" data-tabs-content="tab_pago">
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
                                        <div class="col-md-4  text-center">
                                            <img id="candado" src="<?php echo site_url('assets/nimages/compra-segura.svg'); ?>" alt="Compra Segura" />
                                        </div>
                                        <div class="coml-md-8">
                                            <div class="row card_pay">
                                                <div class="col-md-12 monto_pago text-center">
                                                    <h3>Monto a pagar: <span><?php echo $info_cargo->total;?></span></h3>
                                                </div>
                                            </div>
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
                                                <div class="col-md-8">
                                                    <label>Válida hasta:
                                                        <div class="input-group">
                                                            <input type="text" id="card_expiry_date" placeholder="•• / ••">
                                                            <input type="hidden" id="card_expiry_month" size="2" data-conekta="card[exp_month]">
                                                            <input type="hidden" id="card_expiry_year" size="4" data-conekta="card[exp_year]">
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="card_verification">CVC:
                                                        <div class="input-group">
                                                            <input type="text" id="card_verification" data-conekta="card[cvc]" placeholder="••••">
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row card_pay">
                                        <div class="col-md-12">
                                            <p id="card_errors"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-success success button big-next-button" id="finalizar-compra" onclick="if(typeof gtag != 'undefined') { gtag('event', 'Clic', { 'event_category' : 'Interacción', 'event_label' : 'Agregar-Carrito', 'value': <?php echo $this->cart->obtener_total(); ?>}); }">Finalizar compra <i class="fa fa-check"></i></button>
                                        </div>
                                    </div>
                                    <div class="row card_pay">
                                        <div class="col-md-12">
                                            <p id="ssl">
                                                Sus datos están seguros. La conexión por la cual se transfieren los datos es encriptada con certificado de seguridad SSL.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?php echo $timestamp;?>" name="time"/>
    <input type="hidden" value="<?php echo $id_direccion;?>" name="id_direccion"/>
    <input type="hidden" value="<?php echo $info_cargo->id_cargo;?>" name="id_cargo"/>
</form>

<?php if(uri_string() == 'cargos/error-tarjeta/(:any)/(:num)/(:any)/(:any)'): ?>
    <div class="small reveal" id="recomendamos_paypal" style="padding:1.5rem 0.7rem;max-width:500px;" data-reveal>
        <div class="row">
            <div class="col-md-12 small-centered">
                <img src="<?php echo site_url('assets/nimages/ohno.png'); ?>" alt="Problemas con tarjeta" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center" style="margin:1rem 0;"><strong>¡Oh no!</strong></h2>
                <?php if($this->session->flashdata('error_pago')): ?>
                    <p>Al intentar el cobro a tu tarjeta, el sistema de pagos nos marcó el siguiente error:</p>
                    <p><?php echo $this->session->flashdata('error_pago')->getMessage(); ?></p>
                <?php else: ?>
                    <p>Al intentar el cobro a tu tarjeta, el sistema de pagos rechazó el cargo.</p>
                <?php endif; ?>
            </div>
        </div>

        <button class="close-button" data-close aria-label="Cerrar" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!--<div class="loading" id="paymentload" style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:1000000;opacity:0.9;">-->
<!--    <span style="display:block;position:absolute;top: 50%;margin-top: 50px;width: 100%;text-align: center;padding: 0 1rem;font-weight: bold;color: #0e0e0e;">Estamos inicializando el formulario de pago, por favor espera.</span>-->
<!--</div>-->
