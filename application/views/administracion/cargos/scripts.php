<script src="<?php echo site_url('bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script>
    $(document).ready(function(){
        $("#email_cliente").on('focusout', function () {
            var email_cliente = $(this).val();
            $.post("<?php echo site_url('administracion/cargos-extra/verificar'); ?>", {email_cliente:email_cliente}, function( data ) {
                var response = JSON.parse(data);
                if(response.respuesta === true){
                    $("#nombre_cliente").val(response.nombre);
                    $("select#direccion_cliente").prop('disabled', false);
                    $("select#direccion_cliente").html(response.direcciones);
                    $("#id_cliente").val(response.id_cliente);
                }else{
                    $("#email_cliente").html(' ');
                    $("select#direccion_cliente").prop('disabled', true);
                    $("#error_email").fadeIn(100);
                    $("#error_email").delay(2000).fadeOut(100);
                }
            });
        });
        $("#num_pedido").on('focusout', function () {
            var num_pedido = $(this).val();
            $.post("<?php echo site_url('administracion/cargos-extra/existe-shopify'); ?>", {num_pedido:num_pedido}, function( data ) {
                var response = JSON.parse(data);
                if(response.respuesta === true){
                    $("#agrega_cargo").prop('disabled', true);
                    $("#error_pedido").fadeIn(100);
                }else{
                    $("#agrega_cargo").prop('disabled', false);
                    $("#error_pedido").delay(2000).fadeOut(100);
                }
            });
        });
        $('#cargos_extra').DataTable({
            columnDefs: [
                { orderable: true }
            ],
            "order": [[0, "desc"]],
            "language": {
                "url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
            },
            ajax: {
                url: "<?php echo site_url('administracion/cargos/desplegar-cargos'); ?>",
                type: "POST"
            },
            "columns": [
                { "data": "id_cargo" },
                { "data": "id_pedido" },
                { "data": "cliente" },
                { "data": "fecha" },
                { "data": "total" },
                { "data": "metodo_pago" },
                { "data": "estatus" },
                { "data": "eliminar" }
            ],
            "processing": true,
            "serverSide": true
        });
    });


    function borrarCargo(cargo,pedido) {
        var resultado = window.confirm('¿Estás seguro de eliminar este cargo?');
        if (resultado === true) {
            $.ajax({
                url: "<?php echo site_url('administracion/cargos/delete_cargo'); ?>",
                type: "post", // podría ser get, post, put o delete.
                data: {cargo:cargo,pedido:pedido}, // datos a pasar al servidor, en caso de necesitarlo
                dataType: 'JSON',
                beforeSend: function() {
                },
                success: function ($data) {
                    console.log($data);
                    window.location.href = "<?php echo site_url() ?>/administracion/cargos_extra";
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.n' + jqXHR.responseText;
                    }
                    alert(msg);
                },
            });
        }
    };

    function consultarCargo(pago,pedido) {
        $.ajax({
            url: "<?php echo site_url('administracion/cargos/consultar_cargo'); ?>",
            type: "post", // podría ser get, post, put o delete.
            data: {pago:pago,pedido:pedido}, // datos a pasar al servidor, en caso de necesitarlo
            dataType: 'JSON',
            beforeSend: function() {
            },
            success: function ($data) {
                console.log($data);
            },
            error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.n' + jqXHR.responseText;
                }
                alert(msg);
            },
        });
    };



</script>