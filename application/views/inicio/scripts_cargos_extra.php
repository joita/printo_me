<script type="text/javascript" src="https://conektaapi.s3.amazonaws.com/v0.5.0/js/conekta.js"></script>
<script>
    $(window).load(function() {
        setTimeout(function() {
            $(".loading#paymentload").fadeOut(250);
        }, 500);
    });

    // Inicializar Conekta
    Conekta.setPublicKey('<?php echo $_ENV['CONEKTA_PUBLIC_KEY'] ?>');
    Conekta.setLanguage("es");

    $('#card_number').payment('formatCardNumber');
    $('#card_expiry_date').payment('formatCardExpiry');
    $('#card_verification').payment('formatCardCVC');

    $("#card_expiry_date").on("change input keyup paste",function() {
        var month = $(this).val().substring(0,2);
        var year = $(this).val().substring(5,9);
        $("#card_expiry_month").val(month);
        $("#card_expiry_year").val(year);
    });

    <?php if(uri_string() == 'carrito/pagar/error-pago-tarjeta'): ?>
    $("#recomendamos_paypal").foundation("open");
    <?php endif; ?>
    var busy = false;

    $("#finalizar-compra").dblclick(function(e) {
        e.preventDefault();
    });
    var formulario_enviado = false;

    $("#pagar-form").submit(function(event) {
        if(!formulario_enviado) {
            formulario_enviado = true;
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

        } else {
            event.preventDefault();
        }
    });

</script>