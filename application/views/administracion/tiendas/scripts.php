<script src="<?php echo site_url('bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/datatables.net-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/datatables.net-select/js/dataTables.select.min.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/datatables.net-buttons/js/buttons.flash.min.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="<?php echo site_url('bower_components/datatables.net-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/datatables.net-buttons/js/buttons.print.min.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.8.4/Sortable.min.js"></script>
<script>
    var tope = 0;
    $(document).ready(function() {
        $('#campanas.listis').DataTable({
            columnDefs: [
                { orderable: false, targets: [-1, 1] }
            ],
            "order": [[4, "desc"]],
            "language": {
                "url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
            },
            ajax: {
                url: "<?php echo site_url('administracion/tiendas/desplegar-tiendas'); ?>",
                type: "POST"
            },
            "columns": [
                { "data": "id" },
                { "data": "logo" },
                { "data": "datos_tienda" },
                { "data": "propietario" },
                { "data": "productos" },
                { "data": "vip" },
                { "data": "acciones" }
            ],
            "processing": true,
            "serverSide": true
        });

        $('#campanas.prodis_limitado').DataTable({
            columnDefs: [
                { orderable: false, targets: [-1, 1] }
            ],
            "order": [[3, "desc"]],
            "language": {
                "url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
            },
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            ajax: {
                url: "<?php echo site_url('administracion/tiendas/desplegar-especifico/limitado/'.$tienda->id_cliente); ?>",
                type: "POST"
            },
            "columns": [
                { "data": "img" },
                { "data": "datos" },
                { "data": "precio" },
                { "data": "vendidos" },
                { "data": "total" },
                { "data": "meta" },
                { "data": "percent_meta" },
                { "data":"quedan" },
                { "data": "estatus" },
                { "data": "acciones" }
            ],
            "processing": true,
            "serverSide": true
        });
        $('#campanas.prodis_fijo').DataTable({
            columnDefs: [
                { orderable: false, targets: [-1, 0] }
            ],
            "order": [[3, "desc"]],
            "language": {
                "url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
            },
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            ajax: {
                url: "<?php echo site_url('administracion/tiendas/desplegar-especifico/fijo/'.$tienda->id_cliente); ?>",
                type: "POST"
            },
            "columns": [
                { "data": "img" },
                { "data": "datos" },
                { "data": "precio" },
                { "data": "vendidos" },
                { "data": "total" },
                { "data": "activo_desde" },
                { "data": "vendido" },
                { "data": "estatus" },
                { "data": "acciones" }
            ],
            "processing": true,
            "serverSide": true
        });
    } );



    $(document).on("click", ".enabled", function() {
        var nuevo_estatus = 0;
        var id_tienda = $(this).data("id_tienda");
        console.log(id_tienda);
        $(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i> Deshabilitado');

        $.post(
            '<?php echo site_url('administracion/tiendas/cambiar_vip'); ?>',
            { id_tienda: id_tienda, estatus: nuevo_estatus}
        );

    });

    $(document).on("click", ".disabled", function() {
        var nuevo_estatus = 1;
        var id_tienda = $(this).data("id_tienda");
        console.log(id_tienda);
        $(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i> Habilitado');

        $.post(
            '<?php echo site_url('administracion/tiendas/cambiar_vip'); ?>',
            { id_tienda: id_tienda, estatus: nuevo_estatus}
        );

    });

    $(document).on("click", "#tab-vip", function() {

        $.ajax({
            url: "<?php echo site_url('administracion/tiendas/obtener_tiendas_vip'); ?>",
            type: "post", // podría ser get, post, put o delete.
            data: {}, // datos a pasar al servidor, en caso de necesitarlo
            dataType: 'JSON',
            beforeSend: function() {
            },
            success: function ($data) {
                var data = $data;
                var tiendas = data.tiendas;
                $("#tiendas_list").html('');
                var url = '<?php echo site_url('assets/images/logos');?>';
                for (var i=0; i<tiendas.length; i++){
                    $("#tiendas_list").append('<div id="slide_item" class="list-group-item" data-eqalizer data-id_tienda="'+tiendas[i]['id_tienda']+'"> \n' +
                        '                            <div class="row collapse" data-equalizer>\n' +
                        '                                <div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>\n' +
                        '                                    <i class="fa fa-arrows "></i>\n' +
                        '                                </div>\n' +
                        '                                <div class="small-4 columns " id="logotienda" data-equalizer-watch>\n' +
                        '                                    <img src="'+url+'/'+tiendas[i]['logotipo_mediano']+'" >\n'+
                        '                                </div>\n'+
                        '                                <div class="small-19 columns tienda" id="datos_foto" data-equalizer-watch>\n'+
                        '                                    <b>Nombre tienda:</b>'+tiendas[i]['nombre_tienda']+'<br/>\n'+
                        '                                    <b>Creador:</b> '+tiendas[i]['cliente']+'</br/>\n'+
                        '                                </div>\n'+
                        '                            </div>\n'+
                        '                        </div>');
                }


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
    });


    if($("#tiendas_list").length > 0) {

        var sortFotos = document.getElementById("tiendas_list");
        var orden_fotos = [];
        Sortable.create(sortFotos, {
            animation: 150,
            dataIdAttr: "data-id_tienda",
            store: {
                get: function (sortable) {
                    var order_fotos = localStorage.getItem(sortable.options.group);
                    return order_fotos ? order.split("|") : [];
                },
                set: function (sortable) {
                    orden_fotos = sortable.toArray();
                    var base_url = "<?php echo base_url()?>";
                    $.post(base_url+"administracion/tiendas/reordenar_tiendas/", {
                        data: orden_fotos
                    });
                }
            }
        });
    }

    $(document).on("click", "#save-metodo", function() {
        var metodo = $("#metodo").val();
        var id_tienda = $("#id_tienda").val();
        $.ajax({
            url: "<?php echo site_url('administracion/tiendas/save_metodo_tienda'); ?>",
            type: "post", // podría ser get, post, put o delete.
            data: {metodo:metodo,id_tienda:id_tienda}, // datos a pasar al servidor, en caso de necesitarlo
            dataType: 'JSON',
            beforeSend: function() {
            },
            success: function ($data) {
                $(".msj-success").html('<p>Actualizado correctamente</p>');
                $(".msj-success").addClass('activo');

                intervalos();
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
    });

    var tope=0;
    var intervalo;
    function mensaje() {
        tope++;
        if (tope>=1) {
            $(".msj-success").removeClass('activo');
            $(".msj-success").html('');
            tope = 0;
            clearInterval(intervalo);

        }
    }

    function intervalos() {

        intervalo=setInterval(mensaje,2000);

    }
</script>
