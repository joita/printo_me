<script type="text/javascript" src="https://conektaapi.s3.amazonaws.com/v0.5.0/js/conekta.js"></script>
<script>
    $(window).load(function() {
        setTimeout(function() {
            $(".loading#paymentload").fadeOut(250);
        }, 5000);

    });
    //generar_pagos_ppp();



    if( $('#flexCheckDefault').prop('checked') ) {
        var response = grecaptcha.getResponse();

        if(response.length !== 0){
            $('#finalizar-compra').prop( "disabled", false );
            $('#boton-ppp #continueButton').prop( "disabled", false );
        }
    }else{
        $('#finalizar-compra').prop( "disabled", true );
        $('#boton-ppp #continueButton').prop( "disabled", true );
    }

    $('#flexCheckDefault').on('change', function() {
        if( $('#flexCheckDefault').prop('checked') ) {
            var response = grecaptcha.getResponse();

            if(response.length !== 0){
                $('#finalizar-compra').prop( "disabled", false );
                $('#boton-ppp #continueButton').prop( "disabled", false );
            }

        }else{
            $('#finalizar-compra').prop( "disabled", true );
            $('#boton-ppp #continueButton').prop( "disabled", true );
        }
    });

    if("<?php echo $ganador?>" === "conekta") {
        // Inicializar Conekta
        Conekta.setPublicKey('<?php echo $_ENV['CONEKTA_PUBLIC_KEY'] ?>');
        Conekta.setLanguage("es");

        $('#card_number').payment('formatCardNumber');
        $('#card_expiry_date').payment('formatCardExpiry');
        $('#card_verification').payment('formatCardCVC');

        $("#card_expiry_date").on("change input keyup paste", function () {
            var month = $(this).val().substring(0, 2);
            var year = $(this).val().substring(5, 9);
            $("#card_expiry_month").val(month);
            $("#card_expiry_year").val(year);
        });
    }else{
        $("#pagar-form").attr('action', '<?php echo site_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar-stripe/'.$idempotency_key); ?>');
        var stripe = Stripe("<?php echo $_ENV['STRIPE_PUBLIC_KEY'];?>");
        var elements = stripe.elements();
        var elementStyles = {
            base: {
                fontSize: '1.1rem'
            }
        };
        var cardNumber = elements.create("cardNumber",{
            style: elementStyles
        });
        cardNumber.mount("#stripe_card_number",);
        var cardExpiry = elements.create("cardExpiry",{
            style: elementStyles
        });
        cardExpiry.mount("#stripe_expiry");
        var cardCvc = elements.create("cardCvc",{
            style: elementStyles
        });
        cardCvc.mount("#stripe_cvc");
    }



    <?php if(uri_string() == 'carrito/pagar/error-pago-tarjeta'): ?>
    $("#recomendamos_paypal").foundation("open");
    <?php endif; ?>

    $("#cambiar_paypal").click(function() {
        $("#recomendamos_paypal").foundation("close");
        $("a[href='#pago_paypal']").click();
    });

    <?php if($this->cart->obtener_total() <= 0): ?>
    var forma_pago = 'saldo';
    <?php else: ?>
    var forma_pago = 'tdc';
    <?php endif; ?>
    var busy = false;
    <?php if($ganador == "ppp"):?>


    $("#tipo_pago").val("paypal");
    $("#pagar-form").attr('action', '<?php echo site_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar-paypal'); ?>');
    $("#finalizar-compra").attr('onclick', "if(typeof gtag != 'undefined') { gtag('event', 'Clic', { 'event_category' : 'Interacción', 'event_label' : 'Agregar-Carrito', 'value': <?php echo $this->cart->obtener_total(); ?>}); }");
    forma_pago = "paypal";
    <?php endif;?>


    $('#tab_pago').on('change.zf.tabs', function (event, accordion) {


        var contador = 0;
        var id = $(".tabs-title.is-active a").attr("href").replace("#","");

        if(id == 'pago_PPPtarjeta') {
            $("#pago_PPPtarjeta input").prop({ "disabled": false, "required": true });
            $("#pago_paypal input").prop("disabled", true);
            $("#pago_tarjeta input").prop("disabled", true);
            $("#pago_oxxo input").prop("disabled", true);
            $("#pago_transferencia input").prop("disabled", true);
            $("#tipo_pago").val("tdc");
            generar_pagos_ppp();
            //$("#pagar-form").attr('action', '<?php echo site_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar-tarjeta'); ?>');
            $("#finalizar-compra").hide();
            $("#finalizar-compra").prop("disabled", true);
            $("#boton-ppp").show();
            forma_pago = "PPP";
        }else if(id == 'pago_tarjeta'){
            $("#pago_tarjeta input").prop({ "disabled": false, "required": true });
            $("#pago_PPPtarjeta input").prop({ "disabled": true, "required": false });
            $("#pago_paypal input").prop("disabled", true);
            $("#pago_oxxo input").prop("disabled", true);
            $("#pago_transferencia input").prop("disabled", true);
            $("#tipo_pago").val("tdc");
            $("#pagar-form").attr('action', '<?php echo site_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar-tarjeta'); ?>');
            $("#finalizar-compra").attr('onclick', "");
            $("#finalizar-compra").show();
            $("#finalizar-compra").prop("disabled", false);
            $("#boton-ppp").hide();
            $("#boton-ppp").prop("disabled", true);
            forma_pago = "tdc";
        }else if(id == 'pago_stripe'){


            $("#pago_tarjeta input").prop({ "disabled": false, "required": true });
            $("#pago_PPPtarjeta input").prop({ "disabled": true, "required": false });
            $("#pago_paypal input").prop("disabled", true);
            $("#pago_oxxo input").prop("disabled", true);
            $("#pago_transferencia input").prop("disabled", true);
            $("#tipo_pago").val("tdc");
            $("#pagar-form").attr('action', '<?php echo site_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar-stripe/'.$idempotency_key); ?>');
            $("#finalizar-compra").attr('onclick', "");
            $("#finalizar-compra").show();
            $("#finalizar-compra").prop("disabled", false);
            $("#boton-ppp").hide();
            $("#boton-ppp").prop("disabled", true);
            forma_pago = "stripe";



        } else if(id == 'pago_paypal') {
            $("#pago_paypal input").prop("disabled", false);
            $("#pago_PPPtarjeta input").prop({ "disabled": true, "required": false });
            $("#pago_tarjeta input").prop({ "disabled": true, "required": false });
            $("#pago_oxxo input").prop("disabled", true);
            $("#pago_transferencia input").prop("disabled", true);
            $("#tipo_pago").val("paypal");
            $("#pagar-form").attr('action', '<?php echo site_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar-paypal'); ?>');
            $("#finalizar-compra").attr('onclick', "if(typeof gtag != 'undefined') { gtag('event', 'Clic', { 'event_category' : 'Interacción', 'event_label' : 'Agregar-Carrito', 'value': <?php echo $this->cart->obtener_total(); ?>}); }");
            $("#finalizar-compra").show();
            $("#finalizar-compra").prop("disabled", false);
            $("#boton-ppp").hide();
            $("#boton-ppp").prop("disabled", true);
            forma_pago = "paypal";
        } else if(id == 'pago_oxxo') {
            $("#pago_tarjeta input").prop("disabled", true).removeAttr("required");
            $("#pago_paypal input").prop("disabled", true);
            $("#pago_oxxo input").prop("disabled", false);
            $("#pago_transferencia input").prop("disabled", true);
            $("#tipo_pago").val("oxxo");
            $("#pagar-form").attr('action', '<?php echo site_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar-oxxo'); ?>');
            $("#finalizar-compra").attr('onclick', "");
            $("#finalizar-compra").show();
            $("#finalizar-compra").prop("disabled", false);
            $("#boton-ppp").hide();
            $("#boton-ppp").prop("disabled", true);
            forma_pago = "oxxo";
        } else if(id == 'pago_transferencia') {
            $("#pago_tarjeta input").prop({ "disabled": true, "required": false });
            $("#pago_paypal input").prop("disabled", true);
            $("#pago_oxxo input").prop("disabled", true);
            $("#pago_transferencia input").prop("disabled", false);
            $("#tipo_pago").val("spei");
            $("#pagar-form").attr('action', '<?php echo site_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar-spei'); ?>');
            $("#finalizar-compra").attr('onclick', "");
            $("#finalizar-compra").show();
            $("#finalizar-compra").prop("disabled", false);
            $("#boton-ppp").hide();
            $("#boton-ppp").prop("disabled", true);
            forma_pago = "spei";
        } else if(id == 'pago_saldo') {
            $("#tipo_pago").val("saldo");
            $("#pagar-form").attr('action', '<?php echo site_url(($nombre_tienda_slug ? 'tienda/'.$nombre_tienda_slug.'/' : '').'carrito/pagar-saldo'); ?>');
            $("#finalizar-compra").attr('onclick', "");
            $("#finalizar-compra").show();
            $("#finalizar-compra").prop("disabled", false);
            $("#boton-ppp").hide();
            $("#boton-ppp").prop("disabled", true);
            forma_pago = "saldo";
        }

        if( $('#flexCheckDefault').prop('checked') ) {
            var response = grecaptcha.getResponse();

            if(response.length !== 0){
                $('#finalizar-compra').prop( "disabled", false );
                $('#boton-ppp #continueButton').prop( "disabled", false );
            }

        }else{
            $('#finalizar-compra').prop( "disabled", true );
            $('#boton-ppp #continueButton').prop( "disabled", true );
        }
    });

    function enabledSubmit(response) {
        if( $('#flexCheckDefault').prop('checked') ) {
            $('#finalizar-compra').prop("disabled", false);
            $('#boton-ppp #continueButton').prop("disabled", false);
        }
    }

    $("#finalizar-compra").dblclick(function(e) {
        e.preventDefault();
    });

    $("#finalizar-compra").click(function(e) {
        if(forma_pago == 'paypal') {
            //$(this).prop("disabled", true);
            $(this).children("i").addClass("fa-spinner fa-pulse fa-fw").removeClass("fa-check");
        }
    });


    var formulario_enviado = false;

    $("#pagar-form").submit(function(event) {
        var response = grecaptcha.getResponse();

        if(response.length == 0){
            alert('Para continuar con su compra es necesario verificar el recaptcha.');
            $("#finalizar-compra i").removeClass("fa-spinner fa-pulse fa-fw").addClass("fa-check");
            $("#continueButton i").removeClass("fa-spinner fa-pulse fa-fw").addClass("fa-check");
            event.preventDefault();
            return false;
        } else {
            if( $('#flexCheckDefault').prop('checked') ) {



                if(!formulario_enviado) {
                    formulario_enviado = true;
                    if(forma_pago == "tdc") {
                        var $form;
                        $form = $("#pagar-form");

                        var conektaSuccessResponseHandler;
                        var conektaErrorResponseHandler;

                        conektaErrorResponseHandler = function(response) {
                            var $form;
                            $form = $("#pagar-form");

                            $form.find("#card_errors").text(response.message);
                            setTimeout(function() {
                                $("#finalizar-compra").prop("disabled", false);
                                $("#finalizar-compra i").removeClass("fa-spinner fa-pulse fa-fw").addClass("fa-check");
                            }, 1500);
                            busy = false;
                            formulario_enviado = false;
                            return false;
                        };

                        conektaSuccessResponseHandler = function(token) {
                            var $form;
                            $form = $("#pagar-form");
                            $form.append($("<input type=\"hidden\" name=\"conektaTokenId\" />").val(token.id));
                            $form.get(0).submit();
                            busy = false;
                            formulario_enviado = true;
                            return true;
                        };

                        $("#finalizar-compra").prop("disabled", true);
                        $("#finalizar-compra i").addClass("fa-spinner fa-pulse fa-fw").removeClass("fa-check");
                        Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);

                        return false;
                    } else if(forma_pago == "oxxo") {
                        $("#finalizar-compra").prop("disabled", true);
                        $("#finalizar-compra i").addClass("fa-spinner fa-pulse fa-fw").removeClass("fa-check");
                        formulario_enviado = false;
                    } else if(forma_pago == "spei") {
                        $("#finalizar-compra").prop("disabled", true);
                        $("#finalizar-compra i").addClass("fa-spinner fa-pulse fa-fw").removeClass("fa-check");
                        formulario_enviado = false;
                    } else if(forma_pago == 'saldo') {
                        $("#finalizar-compra").prop("disabled", true);
                        $("#finalizar-compra i").addClass("fa-spinner fa-pulse fa-fw").removeClass("fa-check");
                        formulario_enviado = false;
                    }else if(forma_pago == "stripe"){
                        event.preventDefault();
                        stripe.createToken(cardNumber).then(function(result) {
                            $("#finalizar-compra").prop("disabled", true);
                            $("#finalizar-compra i").addClass("fa-spinner fa-pulse fa-fw").removeClass("fa-check");
                            if (result.error) {
                                // Inform the customer that there was an error.
                                var errorElement = document.getElementById('card-errors');
                                $("#card-errors").show();
                                errorElement.textContent = result.error.message;
                                setTimeout(function() {
                                    $("#finalizar-compra").prop("disabled", false);
                                    $("#finalizar-compra i").removeClass("fa-spinner fa-pulse fa-fw").addClass("fa-check");
                                }, 1500);
                                busy = true;
                                formulario_enviado = false;
                                return false;
                            } else {
                                // Send the token to your server.
                                stripeTokenHandler(result.token);
                                busy = false;
                                formulario_enviado = true;
                                return true;
                            }
                        });
                    }
                } else {
                    event.preventDefault();
                    return false;
                }
            }else{
                alert('Para continuar con su compra es necesario aceptar los terminos y condiciones del servicio.');
                event.preventDefault();
                return false;
            }
        }

    });

    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        const form = document.getElementById('pagar-form');
        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        // Submit the form
        form.submit();
    }

    var ppp;
    var id_cliente;
    var payment_id;
    function generar_pagos_ppp(primera = false){

        if( $('#flexCheckDefault').prop('checked') ) {
            console.log('checked');
            var response = grecaptcha.getResponse();

            if(response.length !== 0){
                $('#finalizar-compra').prop( "disabled", false );
                $('#boton-ppp #continueButton').prop( "disabled", false );
            }
        }else{
            console.log('no checked');
            $('#finalizar-compra').prop( "disabled", true );
            $('#boton-ppp #continueButton').prop( "disabled", true );
        }
        let info_paypal;
        $.ajax({
            url: 'carrito/generar-link-ppp',
            method: 'GET',
            beforeSend: function(){
                $(".loading#paymentload").fadeIn(250);
            },
            success: function(data) {
                info_paypal = $.parseJSON(data);
            },
            complete: function(){

                ppp = PAYPAL.apps.PPP({
                    "approvalUrl": info_paypal.links[1].href,
                    "placeholder": "ppplusDiv",
                    "mode": "<?php echo $_ENV['PAYPAL_MODE']; ?>",
                    "payerFirstName": info_paypal.info_cliente.nombre_cliente,
                    "payerLastName": info_paypal.info_cliente.apellido_cliente,
                    "payerPhone": info_paypal.info_cliente.telefono_cliente,
                    "payerEmail": info_paypal.info_cliente.email_cliente,
                    "payerTaxId": "",
                    "payerTaxIdType": "",
                    "language": "es_MX",
                    "country": "MX",
                    //"rememberedCards" : info_paypal.info_cliente.hash_paypal,
                    "enableContinue" : "continueButton",
                    "disableContinue" : "continueButton",
                    "disallowRememberedCards" : true
                });
                payment_id = info_paypal.id;
                id_cliente = info_paypal.info_cliente.id_cliente;
                if(!primera) {
                    $(".loading#paymentload").fadeOut(250);
                }
                if( $('#flexCheckDefault').prop('checked') ) {
                    console.log('checkeddddd');
                    var response = grecaptcha.getResponse();

                    if(response.length !== 0){
                        $('#finalizar-compra').prop( "disabled", false );
                        $('#boton-ppp #continueButton').prop( "disabled", false );
                    }
                }else{
                    console.log('no chekckejeee');
                    $('#finalizar-compra').prop( "disabled", true );
                    $('#boton-ppp #continueButton').prop( "disabled", true );
                }
            }
        });
    }

    if (window.addEventListener) {
        window.addEventListener("message", receiveMessage, false);
        console.log("addEventListener successful", "debug");
    } else if (window.attachEvent) {
        window.attachEvent("onmessage", receiveMessage);
        console.log("attachEvent successful", "debug");
    } else {
        console.log("Could not attach message listener", "debug");
        throw new Error("Can't attach message listener");
    }

    function receiveMessage(event) {
        try {
            let message;
            let verificacion = false;
            if(event.origin != 'https://staticxx.facebook.com') {
                message = JSON.parse(event.data);
                verificacion = true;
            }
            if(verificacion) {
                if (message['cause'] !== undefined) { //iFrame error handling
                    const error_container = $("#error-ppp");
                    const mensaje_error = $("#error-pago-ppp");
                    const mensaje_per = $("#mensaje-per-ppp");
                    const ppplusError = message['cause'].replace(/['"]+/g, ""); //log & attach this error into the order if possible

                    switch (ppplusError) {
                        case "INTERNAL_SERVICE_ERROR": //javascript fallthrough
                        case "SOCKET_HANG_UP": //javascript fallthrough
                        case "socket hang up": //javascript fallthrough
                        case "connect ECONNREFUSED": //javascript fallthrough
                        case "connect ETIMEDOUT": //javascript fallthrough
                        case "UNKNOWN_INTERNAL_ERROR": //javascript fallthrough
                        case "fiWalletLifecycle_unknown_error": //javascript fallthrough
                        case "Failed to decrypt term info": //javascript fallthrough
                        case "RESOURCE_NOT_FOUND": //javascript fallthrough
                        case "INTERNAL_SERVER_ERROR": //Internal error, reload the iFrame & make a new createPayment API and ask the costumer to try again, if the problem persists check your integration and/or contact your PayPal POC.
                            $(error_container).html("Lo sentimos ocurrió un problema interno, por favor intentelo nuevamente.");
                            $(error_container).fadeIn(250);
                            setTimeout(function(){
                                location.reload();
                            }, 3000);
                            break;
                        case "RISK_N_DECLINE": //javascript fallthrough
                        case "NO_VALID_FUNDING_SOURCE_OR_RISK_REFUSED": //javascript fallthrough
                        case "TRY_ANOTHER_CARD": //javascript fallthrough
                        case "NO_VALID_FUNDING_INSTRUMENT": //Payment declined by risk, inform the customer to contact PayPal or offer Express Checkout payment solution.
                            $(mensaje_error).html(ppplusError);
                            $(mensaje_per).html("Al intentar el cobro a tu tarjeta, el sistema de pagos rechazó el cargo. A veces pasan este tipo de inconvenientes, por lo cual te recomendamos pagar con PayPal.");
                            $("#recomendamos_paypal").foundation("open");
                            break;
                        case "CARD_ATTEMPT_INVALID": //03 maximum attempts with error reached, inform the customer to try again and reload the iFrame.
                            $(error_container).html("Al parecer los datos ingresados han sido incorrectos, le pedimos que lo intente nuevamente, gracias.");
                            $(error_container).fadeIn(250);
                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                            break;
                        case "INVALID_OR_EXPIRED_TOKEN": //User session is expired, inform the customer to try again and reload the iFrame & make a new createPayment API.
                            $(error_container).html("Por el momento el servicio de pago por tarjeta no se encuentra disponible, lo sentimos.");
                            $(error_container).fadeIn(250);
                            break;
                        case "CHECK_ENTRY":  //Missing or invalid credit card information, inform your customer to check the inputs.
                            $(error_container).html("Por favor, verifique sus datos de pago.");
                            $(error_container).fadeIn(250);
                            break;
                        default: //unknown error & reload payment flow
                            window.location.replace(base_url+'/carrito');
                    }
                }
                if (message['action'] == "checkout") { //PPPlus session approved, do logic here
                    let installmentsValue;
                    //const rememberedCard = message['result']['rememberedCards']; //save on user BD record
                    const payerID = message['result']['payer']['payer_info']['payer_id']; //use it on executePayment API
                    if ("term" in message) {
                        installmentsValue = message['result']['term']['term']; //installments value
                    } else {
                        installmentsValue = 1; //no installments
                    }
                    let url;
                    try {
                        $.ajax({
                            url: 'carrito/finalizar-pago-paypal',
                            data: {
                                //rememberedCard : rememberedCard,
                                payerID: payerID,
                                id_cliente: id_cliente,
                                paymentID: payment_id
                            },
                            method: 'post',
                            beforeSend: function () {
                                $("span#mensaje-carga").html("Verificando información y realizando el pedido.");
                                $(".loading#paymentload").fadeIn(250);
                            },
                            success: function (response) {
                                url = response;
                            },
                            complete: function () {
                                $(".loading#paymentload").fadeOut(1000);
                                $("span#mensaje-carga").html("Estamos inicializando el formulario de pago, por favor espera.");
                                window.location.replace(url);
                            }
                        });
                    }catch(e){
                        window.location.replace(base_url+'carrito/pagar/error-pago-tarjeta');
                    }
                }
            }
        } catch (e){ //treat exceptions here
            //window.location.replace(base_url+'carrito/pagar/error-pago-tarjeta');
        }
    }
    // $(document).ready(function(){
    //     $.ajax({
    //         url: 'carrito/actualizar-direccion-ac',
    //         method: 'post'
    //     });
    // });

</script>
