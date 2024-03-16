<div class="fgc pscat">
	<div class="row small-collapse medium-uncollapse">
        <div class="small-18 medium-14 large-12 medium-centered columns">
            <div class="address-area">
                <div class="row">
                    <div class="small-18 columns" id="pago-completado">
                        <h2 class="dosf text-center medium-text-left">¡Gracias!</h2>
                        <div class="row">
                            <div class="small-18 medium-18 large-6 columns text-center">
                                <img id="checklist-img" src="<?php echo site_url('assets/nimages/checklist.svg'); ?>" alt="Todo en orden" />
                            </div>
                            <div class="small-18 medium-18 large-12 columns<?php echo ' '.$metodo_pago; ?>" id="checkp">
                            <?php if($metodo_pago == 'tarjeta' || $metodo_pago == 'saldo'): ?>
                                <p class="text-left medium-text-justify">¡Gracias por comprar en printome.mx! Nuestro personal revisará la información de tu pedido y si todo está en orden se llevará a producción.</p>
                                <?php
                                $paymentDate = date('Y-m-d');
                                $paymentDate=date('Y-m-d', strtotime($paymentDate));
                                $firstDateBegin = date('Y-m-d', strtotime("04/01/2020"));
                                $firstDateEnd = date('Y-m-d', strtotime("05/31/2020"));
                                $secondDateBegin = date('Y-m-d', strtotime("12/21/2019"));
                                $secondDateEnd = date('Y-m-d', strtotime("01/07/2020"));?>
                                <?php if (($paymentDate >= $firstDateBegin) && ($paymentDate <= $firstDateEnd)):?>
                                    <p class='text-left medium-text-justify'>Debido a la contingencia del COVID-19 nuestra fábrica se encuentra cerrada por lo que las fechas de entrega de pedidos cambian. Los producctos empezarán a producirse a partir del <strong>1 de Junio</strong> (no aplica para productos de plazo definido).</p>
                                <?php elseif(($paymentDate >= $secondDateBegin) && ($paymentDate <= $secondDateEnd)): ?>
                                    <p class='text-left medium-text-justify'>Debido a las fiestas decembrinas, espera tus productos a partir del <strong>16 de Enero</strong> (no aplica para productos de plazo definido).</p>
                                <?php else:?>
                                    <p class='text-left medium-text-justify'>Espera tus productos desde el <strong><?php fecha($recibir); ?></strong> (no aplica para productos de plazo definido).</p>
                                <?php endif;?>
                            <?php elseif($metodo_pago == 'oxxo'): ?>
                                <p class="text-left medium-text-justify">¡Gracias por comprar en printome.mx! Para terminar tu proceso de compra, hace falta realizar el pago en OXXO. Te hemos enviado una ficha de pago a tu correo electrónico. A continuación de mostramos las intrucciones para realizar el pago.</p>
                                <ol>
                					<li>Acude a la tienda OXXO más cercana. <a href="https://www.google.com.mx/maps/search/oxxo/" target="_blank">Encuéntrala aquí</a>.</li>
                					<li>Indica en caja que quieres ralizar un pago de <strong>OXXOPay</strong>.</li>
                					<li>Dicta al cajero el número de referencia en la ficha que te enviamos por correo para que teclee directamete en la pantalla de venta.</li>
                					<li>Realiza el pago correspondiente con dinero en efectivo.</li>
                					<li>Al confirmar tu pago, el cajero te entregará un comprobante impreso. <strong>En el podrás verificar que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
                				</ol>
                                <p><strong>Te recomendamos guardar tu ficha de OXXO que se encuentra en este <a href="assets/pdf/<?php echo $this->session->tempdata("filename_oxxo");?>">link</a>.</strong> Una copia intentará ser enviada a tu correo.</p>

                            <?php elseif($metodo_pago == 'paypal'): ?>
                                <p class="text-left medium-text-justify">¡Gracias por comprar en printome.mx! Nuestro personal revisará la información de tu pedido y confirmará el pago en PayPal y si todo está en orden se llevará a producción.</p>
                                <?php
                                $paymentDate = date('Y-m-d');
                                $paymentDate=date('Y-m-d', strtotime($paymentDate));
                                $firstDateBegin = date('Y-m-d', strtotime("04/01/2020"));
                                $firstDateEnd = date('Y-m-d', strtotime("05/31/2020"));
                                $secondDateBegin = date('Y-m-d', strtotime("12/21/2019"));
                                $secondDateEnd = date('Y-m-d', strtotime("01/07/2020"));?>
                                <?php if (($paymentDate >= $firstDateBegin) && ($paymentDate <= $firstDateEnd)):?>
                                    <p class='text-left medium-text-justify'>Debido a la contingencia del COVID-19 nuestra fábrica se encuentra cerrada por lo que las fechas de entrega de pedidos cambian. Los producctos empezarán a producirse a partir del <strong>1 de Junio</strong> (no aplica para productos de plazo definido).</p>
                                <?php elseif(($paymentDate >= $secondDateBegin) && ($paymentDate <= $secondDateEnd)): ?>
                                    <p class='text-left medium-text-justify'>Debido a las fiestas decembrinas, espera tus productos a partir del <strong>16 de Enero</strong> (no aplica para productos de plazo definido).</p>
                                <?php else:?>
                                    <p class='text-left medium-text-justify'>Espera tus productos desde el <strong><?php fecha($recibir); ?></strong> (no aplica para productos de plazo definido).</p>
                                <?php endif;?>
                            <?php elseif($metodo_pago == 'spei'): ?>
                                <p class="text-left medium-text-justify">¡Gracias por comprar en printome.mx! Para terminar tu proceso de compra, hace falta realizar el pago por SPEI. Te hemos enviado una ficha de pago a tu correo electrónico. A continuación de mostramos las intrucciones para realizar el pago.</p>
                                <ol>
                					<li>Accede a tu banca en línea.</li>
                                    <li>Da de alta la CLABE en esta ficha. El banco deberá de ser STP.</li>
                                    <li>Realiza la transferencia correspondiente por la cantidad exacta en esta ficha, de lo contrario se rechazará el cargo.</li>
                                    <li>Al confirmar tu pago, el portal de tu banco generará un comprobante digital. En el podrás verificar que se haya realizado correctamente. Conserva este comprobante de pago.</li>
                                    <li>Al completar estos pasos recibirás un correo de printome.mx confirmando tu pago.</li>
                                </ol>
                            <?php endif; ?>

                                <?php if(substr($this->uri->uri_string(), 0, 25) == 'carrito/pedido-completado'): ?>
                                <?php if($this->session->flashdata('total_pedido')): ?>
                                <script src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer></script>
                                <script>
                                window.renderOptIn = function() {
                                    window.gapi.load('surveyoptin', function() {
                                        window.gapi.surveyoptin.render(
                                        {
                                            "merchant_id": 118110452,
                                            "order_id": "<?php echo $this->session->flashdata('tracking_id_pedido'); ?>",
                                            "email": "<?php echo $this->session->login['email']; ?>",
                                            "delivery_country": "MX",
                                            "estimated_delivery_date": "<?php echo date("Y-m-d", strtotime(fecha_recepcion(date("N")))); ?>"
                                        });
                                    });
                                }
                                </script>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
