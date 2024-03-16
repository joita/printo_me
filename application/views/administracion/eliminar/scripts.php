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
                $("#cuenta_a_tipo").val(val.tipo);
                $("#id_cliente").val(val.id_cliente);
                $("#confirmacion_eliminar").fadeIn(1000);
                $("#label_conf").html("Confirmo la eliminación total del cliente con correo: <b>"+val.title+"</b>");
            }
        });
        $("#form_eliminar").submit(function (e) {
            e.preventDefault();
            var cuenta_a = $("#cuenta_a").val();
            var id_cliente = $("#id_cliente").val();

            if( cuenta_a !== ""){
                $.ajax({
                    url: "<?php echo site_url("administracion/eliminar/eliminar_cuenta");?>",
                    data: {
                        id_cliente: id_cliente,
                        cuenta_a: cuenta_a
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
                        $("#cuenta_a_tipo").val("");
                        $("#id_cliente").val("");
                        $("#submit").removeClass("disabled");
                        $("#submit").attr("disabled", false);
                        $("#confirmacion_eliminar").fadeOut(1000);
                        $("#label_conf").html("");
                    },
                    error: function (respuesta) {
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
                        $("#cuenta_a_tipo").val("");
                        $("#id_cliente").val("");
                        $("#submit").removeClass("disabled");
                        $("#submit").attr("disabled", false);
                        $("#confirmacion_eliminar").fadeOut(1000);
                        $("#label_conf").html("");
                    }
                });
            }
        });
    });

</script>