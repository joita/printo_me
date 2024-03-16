<script src="<?php echo site_url("assets/js/tiny-autocomplete/tiny-autocomplete.js")?>"></script>
<script>
    $(document).ready(function () {
        $(".transferir-text").tinyAutocomplete({
            markAsBold: true,
            showNoResults: true,
            noResultsTemplate: "<li class='autocomplete-item'>No se encontraron correos similares.</li>",
            url: "<?php echo site_url('administracion/carrito/obtener_correos')?>",
            minChars: 3,
            maxItems: 5,
            itemTemplate: '<li class="autocomplete-item">' +
                '<span class="tipo_cuenta">{{tipo}}</span>' +
                '<span class="nombre_cuenta">{{nombre}} </span></br>' +
                '<span class="result">{{title}}</span>' +
                '</li>',
            onSelect: function(el, val) {
                $(this).val(val.title);
                if($(this).attr('id') === 'cuenta_a'){
                    $("#cuenta_a_tipo").val(val.tipo);
                    console.log($("#cuenta_a_tipo"));
                }else if($(this).attr('id') === 'cuenta_b'){
                    $("#cuenta_b_tipo").val(val.tipo);
                    console.log($("#cuenta_b_tipo"));
                }
            }
        });
        $("#form_transferir").submit(function (e) {
            e.preventDefault();
            var cuenta_a = $("#cuenta_a").val();
            var cuenta_b = $("#cuenta_b").val();
            var cuenta_a_tipo = $("#cuenta_a_tipo").val();
            var cuenta_b_tipo = $("#cuenta_b_tipo").val();

            if( cuenta_a !== "" && cuenta_b !== ""){
                $.ajax({
                    url: "<?php echo site_url("administracion/carrito/transferir_carrito");?>",
                    data: {
                        cuenta_a: cuenta_a,
                        cuenta_b: cuenta_b,
                        cuenta_a_tipo: cuenta_a_tipo,
                        cuenta_b_tipo: cuenta_b_tipo
                    },
                    type: "post",
                    dataType: "html",
                    beforeSend: function(){
                        $("#submit").addClass("disabled");
                        $("#submit").attr("disabled", true);
                    },
                    success: function(respuesta) {
                        var elem = $("#informacion");
                        var resp = JSON.parse(respuesta);
                        if(resp.tipo !== "error"){
                            elem.removeClass("alert").addClass("success");
                            elem.html(resp.mensaje);
                            elem.fadeIn(10).delay(3000).fadeOut(10);
                        }else{
                            elem.removeClass("success").addClass("alert");
                            elem.html(resp.mensaje);
                            elem.fadeIn(10).delay(3000).fadeOut(10);
                        }
                        $("#cuenta_a").val("");
                        $("#cuenta_b").val("");
                        $("#cuenta_a_tipo").val("");
                        $("#cuenta_b_tipo").val("");
                        $("#submit").removeClass("disabled");
                        $("#submit").attr("disabled", false);
                    }
                });
            }
        });
    });

</script>