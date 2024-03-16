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
    var contador = 0;
    var general = 0;

    $(document).ready(function() {
        contador = 0;
        $('#wow.listis').DataTable({
            columnDefs: [
                {orderable: false, targets: [-1, 1]}
            ],
            "order": [[4, "desc"]],
            "language": {
                "url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
            },
            ajax: {
                url: "<?php echo site_url('administracion/wowwinners/desplegar-campanas'); ?>",
                type: "POST"
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "logo"},
                {"data": "playera"},
                {"data": "nombre_tienda"},
                {"data": "cliente"},
                {"data": "wow_winner"},
            ],
            "processing": true,
            "serverSide": true
        });
    });


    $(document).on("click", ".tablawow.enabled", function() {
        contador++;
        var nuevo_estatus = 0;
        var id_enhance = $(this).data("id_enhance");

        $(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i> Deshabilitado');

        $.post(
            '<?php echo site_url('administracion/wowwinners/cambiar_wow'); ?>',
            { id_enhance: id_enhance, estatus: nuevo_estatus}
        );


    });

    $(document).on("click", ".tablawow.disabled", function() {
        contador++;
        var nuevo_estatus = 1;
        var id_enhance = $(this).data("id_enhance");

        $(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i> Habilitado');

        $.post(
            '<?php echo site_url('administracion/wowwinners/cambiar_wow'); ?>',
            { id_enhance: id_enhance, estatus: nuevo_estatus}
        );



    });


    $(document).on("click", "#fa.seleccionados.enabled", function() {
        contador++;
        var nuevo_estatus = 0;
        var id_enhance = $(this).data("id_enhance");

        $(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i> Deshabilitado');

        $.post(
            '<?php echo site_url('administracion/wowwinners/cambiar_wow'); ?>',
            { id_enhance: id_enhance, estatus: nuevo_estatus}
        );
        general ++;
        actualizar();
    });

    $(document).on("click", "#fa.seleccionados.disabled", function() {
        contador++;
        var nuevo_estatus = 1;
        var id_enhance = $(this).data("id_enhance");

        $(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i> Habilitado');

        $.post(
            '<?php echo site_url('administracion/wowwinners/cambiar_wow'); ?>',
            { id_enhance: id_enhance, estatus: nuevo_estatus}
        );
        general ++;
        actualizar();

    });

    function actualizar(){
        console.log('actualiza');
        $.ajax({
            url: "<?php echo site_url('administracion/wowwinners/obtener_campanas_wow'); ?>",
            type: "post", // podría ser get, post, put o delete.
            data: {}, // datos a pasar al servidor, en caso de necesitarlo
            dataType: 'JSON',
            beforeSend: function() {
            },
            success: function ($data) {
                var data = $data;
                var campanas = data.campanas;
                $("#wow_list").html('');
                var url = '<?php echo site_url();?>';
                for (var i=0; i<campanas.length; i++){
                    if(campanas[i]['wow_winner']==1){
                        $("#wow_list").append('<div id="slide_item" class="list-group-item" data-eqalizer data-id_enhance="'+campanas[i]['id_enhance']+'"> \n' +
                            '                            <div class="row collapse" data-equalizer>\n' +
                            '                                <div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>\n' +
                            '                                    <i class="fa fa-arrows "></i>\n' +
                            '                                </div>\n' +
                            '                                <div class="small-4 columns "  data-equalizer-watch>\n' +
                            '                                    <img src="'+url+campanas[i]['front_image']+'" >\n'+
                            '                                </div>\n'+
                            '                                <div class="small-15 columns tienda" id="datos_foto" data-equalizer-watch>\n'+
                            '                                    <b>Nombre tienda:</b>'+campanas[i]['nombre_tienda']+'<br/>\n'+
                            '                                    <b>Nombre playera:</b>'+campanas[i]['name']+'<br/>\n'+
                            '                                    <b>Creador:</b> '+campanas[i]['cliente']+'</br/>\n'+
                            '                                    <b>Texto :</b> '+campanas[i]['texto_wow']+'</br/>\n'+
                            '                                </div>\n'+
                            '                                <div class="small-4 columns " data-equalizer-watch data-texto_wow="'+campanas[i]['texto_wow']+'" data-id_enhance ="'+campanas[i]['id_enhance']+'">\n' +
                            '                                    <a href="#" class="edit-enhance" ><i class="fa fa-edit"></i> Editar</i></a></br>\n'+
                            '                                    <a data-id_enhance="'+campanas[i]['id_enhance']+'" id="fa" class="seleccionados enabled"><i class="fa fa-toggle-on"></i> Habilitado</a></br/>\n'+
                            '                                </div>\n'+
                            '                            </div>\n'+
                            '                        </div>');
                    }else{
                        $("#wow_list").append('<div id="slide_item" class="list-group-item" data-eqalizer data-id_enhance="'+campanas[i]['id_enhance']+'"> \n' +
                            '                            <div class="row collapse" data-equalizer>\n' +
                            '                                <div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>\n' +
                            '                                    <i class="fa fa-arrows "></i>\n' +
                            '                                </div>\n' +
                            '                                <div class="small-4 columns "  data-equalizer-watch>\n' +
                            '                                    <img src="'+url+campanas[i]['front_image']+'" >\n'+
                            '                                </div>\n'+
                            '                                <div class="small-15 columns tienda" id="datos_foto" data-equalizer-watch>\n'+
                            '                                    <b>Nombre tienda:</b>'+campanas[i]['nombre_tienda']+'<br/>\n'+
                            '                                    <b>Nombre playera:</b>'+campanas[i]['name']+'<br/>\n'+
                            '                                    <b>Creador:</b> '+campanas[i]['cliente']+'</br/>\n'+
                            '                                    <b>Texto :</b> '+campanas[i]['texto_wow']+'</br/>\n'+
                            '                                </div>\n'+
                            '                                <div class="small-4 columns " data-equalizer-watch data-texto_wow="'+campanas[i]['texto_wow']+'" data-id_enhance ="'+campanas[i]['id_enhance']+'">\n' +
                            '                                    <a href="#" class="edit-enhance" ><i class="fa fa-edit"></i> Editar</i></a></br>\n'+
                            '                                    <a data-id_enhance="'+campanas[i]['id_enhance']+'" id="fa" class="seleccionados disabled"><i class="fa fa-toggle-off"></i> Deshabilitado</a></br/>\n'+
                            '                                </div>\n'+
                            '                            </div>\n'+
                            '                        </div>');
                    }

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


    };
    $(document).on("click", "#panelprincipal", function() {
        if(general > 0){
            location.reload();
            general = 0;
        };

    });

    $(document).on("click", "#panelwow", function() {
        if(contador > 0){
            $.ajax({
                url: "<?php echo site_url('administracion/wowwinners/obtener_campanas_wow'); ?>",
                type: "post", // podría ser get, post, put o delete.
                data: {}, // datos a pasar al servidor, en caso de necesitarlo
                dataType: 'JSON',
                beforeSend: function() {
                },
                success: function ($data) {
                    var data = $data;
                    var campanas = data.campanas;
                    $("#wow_list").html('');
                    var url = '<?php echo site_url();?>';
                    for (var i=0; i<campanas.length; i++){
                        if(campanas[i]['wow_winner']==1){
                            $("#wow_list").append('<div id="slide_item" class="list-group-item" data-eqalizer data-id_enhance="'+campanas[i]['id_enhance']+'"> \n' +
                                '                            <div class="row collapse" data-equalizer>\n' +
                                '                                <div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>\n' +
                                '                                    <i class="fa fa-arrows "></i>\n' +
                                '                                </div>\n' +
                                '                                <div class="small-4 columns "  data-equalizer-watch>\n' +
                                '                                    <img src="'+url+campanas[i]['front_image']+'" >\n'+
                                '                                </div>\n'+
                                '                                <div class="small-15 columns tienda" id="datos_foto" data-equalizer-watch>\n'+
                                '                                    <b>Nombre tienda:</b>'+campanas[i]['nombre_tienda']+'<br/>\n'+
                                '                                    <b>Nombre playera:</b>'+campanas[i]['name']+'<br/>\n'+
                                '                                    <b>Creador:</b> '+campanas[i]['cliente']+'</br/>\n'+
                                '                                    <b>Texto :</b> '+campanas[i]['texto_wow']+'</br/>\n'+
                                '                                </div>\n'+
                                '                                <div class="small-4 columns " data-equalizer-watch data-texto_wow="'+campanas[i]['texto_wow']+'" data-id_enhance ="'+campanas[i]['id_enhance']+'">\n' +
                                '                                    <a href="#" class="edit-enhance" ><i class="fa fa-edit"></i> Editar</i></a></br>\n'+
                                '                                    <a data-id_enhance="'+campanas[i]['id_enhance']+'" id="fa" class="seleccionados enabled"><i class="fa fa-toggle-on"></i> Habilitado</a></br/>\n'+
                                '                                </div>\n'+
                                '                            </div>\n'+
                                '                        </div>');
                        }else{
                            $("#wow_list").append('<div id="slide_item" class="list-group-item" data-eqalizer data-id_enhance="'+campanas[i]['id_enhance']+'"> \n' +
                                '                            <div class="row collapse" data-equalizer>\n' +
                                '                                <div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>\n' +
                                '                                    <i class="fa fa-arrows "></i>\n' +
                                '                                </div>\n' +
                                '                                <div class="small-4 columns "  data-equalizer-watch>\n' +
                                '                                    <img src="'+url+campanas[i]['front_image']+'" >\n'+
                                '                                </div>\n'+
                                '                                <div class="small-15 columns tienda" id="datos_foto" data-equalizer-watch>\n'+
                                '                                    <b>Nombre tienda:</b>'+campanas[i]['nombre_tienda']+'<br/>\n'+
                                '                                    <b>Nombre playera:</b>'+campanas[i]['name']+'<br/>\n'+
                                '                                    <b>Creador:</b> '+campanas[i]['cliente']+'</br/>\n'+
                                '                                    <b>Texto :</b> '+campanas[i]['texto_wow']+'</br/>\n'+
                                '                                </div>\n'+
                                '                                <div class="small-4 columns " data-equalizer-watch data-texto_wow="'+campanas[i]['texto_wow']+'" data-id_enhance ="'+campanas[i]['id_enhance']+'">\n' +
                                '                                    <a href="#" class="edit-enhance" ><i class="fa fa-edit"></i> Editar</i></a></br>\n'+
                                '                                    <a data-id_enhance="'+campanas[i]['id_enhance']+'" id="fa" class="seleccionados disabled"><i class="fa fa-toggle-off"></i> Deshabilitado</a></br/>\n'+
                                '                                </div>\n'+
                                '                            </div>\n'+
                                '                        </div>');
                        }

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

            contador = 0;
        }

    });
    $(document).on("click", ".edit-enhance", function() {

        var id_enhance = $(this).parent().data("id_enhance");
        var texto_wow = $(this).parent().data("texto_wow");


        $("#id-enhance").val(id_enhance);
        $("#editar-texto_wow").val(texto_wow);
        $('#editar_wow').foundation('reveal', 'open');



    });

    $("#guardar-texto-wow").click(function() {
        var id_enhance = $("#id-enhance").val();
        var texto_wow = $("#editar-texto_wow").val();

        $.post(
            '<?php echo site_url('administracion/wowwinners/editar_enhance'); ?>',
            { id_enhance: id_enhance, texto_wow: texto_wow}
        );

        $('#editar_wow').foundation('reveal', 'close');
        $("#id-enhance").val('');
        $("#editar-texto_wow").val('');
        actualizar();

    });

    if($("#wow_list").length > 0) {

        var sortFotos = document.getElementById("wow_list");
        var orden_fotos = [];
        Sortable.create(sortFotos, {
            animation: 150,
            dataIdAttr: "data-id_enhance",
            store: {
                get: function (sortable) {
                    var order_fotos = localStorage.getItem(sortable.options.group);
                    return order_fotos ? order.split("|") : [];
                },
                set: function (sortable) {
                    orden_fotos = sortable.toArray();
                    var base_url = "<?php echo base_url()?>";
                    $.post(base_url+"administracion/wowwinners/reordenar_enhance/", {
                        data: orden_fotos
                    });
                }
            }
        });
    }


</script>