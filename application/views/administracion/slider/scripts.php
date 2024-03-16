<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.8.4/Sortable.min.js"></script>
<script>
    if($("#slides_list").length > 0) {
        var sortFotos = document.getElementById("slides_list");
        var orden_fotos = [];
        Sortable.create(sortFotos, {
            animation: 150,
            dataIdAttr: "data-id_slide",
            store: {
                get: function (sortable) {
                    var order_fotos = localStorage.getItem(sortable.options.group);
                    return order_fotos ? order.split("|") : [];
                },
                set: function (sortable) {
                    orden_fotos = sortable.toArray();
                    var base_url = "<?php echo base_url()?>";
                    $.post(base_url+"administracion/slider/reordenar_slides/", {
                        data: orden_fotos
                    });
                }
            }
        });
    }

    $(document).on("click", "#slides_list .enabled", function() {
        var nuevo_estatus = 0;
        var id_slide = $(this).parent().data("id_slide");
        $(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i> Deshabilitado');

        $.post(
            '<?php echo site_url('administracion/slider/cambiar_estatus'); ?>',
            { id_slide: id_slide, estatus: nuevo_estatus}
        );
    });

    $(document).on("click", "#slides_list .disabled", function() {
        var nuevo_estatus = 1;
        var id_slide = $(this).parent().data("id_slide");
        $(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i> Habilitado');

        $.post(
            '<?php echo site_url('administracion/slider/cambiar_estatus'); ?>',
            { id_slide: id_slide, estatus: nuevo_estatus}
        );
    });

    $(".edit-slide").click(function() {
        var id_slide = $(this).parent().data("id_slide");
        var nombre_imagen = $(this).parent().data("nombre_imagen");
        var alt_imagen = $(this).parent().data("alt");
        var link_imagen = $(this).parent().data("link");
        var boton_slide = $(this).parent().data("boton");
        var texto_slide = $(this).parent().data("texto");
        var principal_slide = $(this).parent().data("texto_principal");

        $("#id-slide-editar").val(id_slide);
        $("#editar-nombre").val(nombre_imagen);
        $("#editar-alt").val(alt_imagen);
        $("#editar-link").val(link_imagen);
        $("#editar-boton").val(boton_slide);
        $("#editar-texto").val(texto_slide);
        $("#editar-principal").val(principal_slide);
    });

    $(".delete-slide").click(function() {
        var id_slide = $(this).parent().data("id_slide");
        $("#id_slide_borrar").val(id_slide);
    });

    /*Sección slider comprar*/

    if($("#comprar_list").length > 0) {
        var sortFotos = document.getElementById("comprar_list");
        var orden_fotos = [];
        Sortable.create(sortFotos, {
            animation: 150,
            dataIdAttr: "data-id_slide_comprar",
            store: {
                get: function (sortable) {
                    var order_fotos = localStorage.getItem(sortable.options.group);
                    return order_fotos ? order.split("|") : [];
                },
                set: function (sortable) {
                    orden_fotos = sortable.toArray();
                    var base_url = "<?php echo base_url()?>";
                    $.post(base_url+"administracion/slider/reordenar_comprar/", {
                        data: orden_fotos
                    });
                }
            }
        });
    }

    $(document).on("click", "#comprar_list .enabled", function() {
        var nuevo_estatus = 0;
        var id_slide = $(this).parent().data("id_slide_comprar");
        $(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i> Deshabilitado');

        $.post(
            '<?php echo site_url('administracion/slider/cambiar_estatus_comprar'); ?>',
            { id_slide_comprar: id_slide, estatus: nuevo_estatus}
        );
    });

    $(document).on("click", "#comprar_list .disabled", function() {
        var nuevo_estatus = 1;
        var id_slide = $(this).parent().data("id_slide_comprar");
        $(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i> Habilitado');

        $.post(
            '<?php echo site_url('administracion/slider/cambiar_estatus_comprar'); ?>',
            { id_slide_comprar: id_slide, estatus: nuevo_estatus}
        );
    });

    $(document).on("click", ".edit-comprar", function() {

        var id_slide = $(this).parent().data("id_slide_comprar");
        var nombre_imagen = $(this).parent().data("nombre_imagen");
        var alt_imagen = $(this).parent().data("alt");
        var link_imagen = $(this).parent().data("link");
        var boton_slide = $(this).parent().data("boton");
        var texto_slide = $(this).parent().data("texto");
        var principal_slide = $(this).parent().data("texto_principal");

        $("#id-slide-comprar").val(id_slide);
        $("#editar-nombre-c").val(nombre_imagen);
        $("#editar-alt-c").val(alt_imagen);
        $("#editar-link-c").val(link_imagen);
        $("#editar-boton-c").val(boton_slide);
        $("#editar-texto-c").val(texto_slide);
        $("#editar-principal-c").val(principal_slide);
        $('#editar_comprar').foundation('reveal', 'open');
    });


    $("#save_slider_comprar").click(function() {

        var id_slide = $("#id-slide-comprar").val();
        var nombre_imagen = $("#editar-nombre-c").val();
        var alt_imagen = $("#editar-alt-c").val();
        var link_imagen = $("#editar-link-c").val();
        var boton_slide = $("#editar-boton-c").val();
        var texto_slide = $("#editar-texto-c").val();
        var principal_slide = $("#editar-principal-c").val();

        $.ajax({
            url: "<?php echo site_url('administracion/slider/editar_comprar'); ?>",
            type: "post", // podría ser get, post, put o delete.
            data: {id_slide_comprar: id_slide, nombre_slide: nombre_imagen, alt_slide:alt_imagen, link_slide:link_imagen, boton_slide:boton_slide, texto_slide:texto_slide, principal_slide:principal_slide}, // datos a pasar al servidor, en caso de necesitarlo
            dataType: 'JSON',
            beforeSend: function() {
            },
            success: function ($data) {
                $('#editar_comprar').foundation('reveal', 'close');
                $('#id-slide-comprar').val('');
                $("#id-comprar-editar").val('');
                $("#editar-nombre-c").val('');
                $("#editar-alt-c").val('');
                $("#editar-link-c").val('');
                $("#editar-boton-c").val('');
                $("#editar-texto-c").val('');
                $("#editar-principal-c").val('');
                actualizar_comprar();
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

    $(document).on("click", ".delete-comprar", function() {
        var id_slide = $(this).parent().data("id_slide_comprar");
        $("#id_slide_borrar_comprar").val(id_slide);
        $('#borrar_comprar').foundation('reveal', 'open');
    });

    $("#save_borrar_comprar").click(function() {

        var id_slide = $("#id_slide_borrar_comprar").val();

        $.ajax({
            url: "<?php echo site_url('administracion/slider/borrar_comprar'); ?>",
            type: "post", // podría ser get, post, put o delete.
            data: {id_slide_comprar: id_slide},
            dataType: 'JSON',
            beforeSend: function() {
            },
            success: function ($data) {
                $('#borrar_comprar').foundation('reveal', 'close');
                $('#id_slide_borrar_comprar').val('');
                actualizar_comprar();
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

    function actualizar_comprar(){
        console.log('entra');
        $.ajax({
            url: "<?php echo site_url('administracion/slider/obtener_comprar'); ?>",
            type: "post",
            data: {},
            dataType: 'JSON',
            beforeSend: function() {
            },
            success: function ($data) {

                var data = $data;
                var campanas = data.tiendas;

                $("#comprar_list").html('');
                var url = '<?php echo site_url();?>';
                for (var i=0; i<campanas.length; i++){
                    if(campanas[i]['estatus']==1){
                        $("#comprar_list").append('<div id="slide_item" class="list-group-item" data-eqalizer data-id_slide_comprar="'+campanas[i]['id_slide_comprar']+'">\n' +
                            '                                    <div class="row collapse" data-equalizer>\n' +
                            '                                        <div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>\n' +
                            '                                            <i class="fa fa-arrows "></i>\n' +
                            '                                        </div>\n' +
                            '                                        <div class="small-9 columns" id="foto" data-equalizer-watch>\n' +
                            '                                            <img src="'+url+campanas[i]['directorio']+'/'+campanas[i]['imagen_small']+'" style="display: block">\n' +
                            '                                        </div>\n' +
                            '                                        <div class="small-9 columns" id="datos_foto" data-equalizer-watch>\n' +
                            '                                            <b>Nombre Foto:</b> '+campanas[i]['nombre_imagen']+'<br/>\n' +
                            '                                            <b>Alt:</b>'+campanas[i]['alt']+'</br/>\n' +
                            '                                            <b>Botón:</b> '+campanas[i]['boton']+' </br/>\n' +
                            '                                            <b>Texto:</b> '+campanas[i]['texto']+' </br/>\n' +
                            '                                            <b>Texto principal:</b> '+campanas[i]['texto_principal']+' </br/>\n' +
                            '                                            <b>Link:</b> <a class="link" href="'+campanas[i]['url_slide']+'"><i class="fa fa-link"></i></a>\n' +
                            '                                        </div>\n' +
                            '                                        <div class="small-5 columns" id="opciones" data-boton="'+campanas[i]['boton']+'" data-texto="'+campanas[i]['texto']+'" data-texto_principal="'+campanas[i]['texto_principal']+'" data-id_slide_comprar ="'+campanas[i]['id_slide_comprar']+'" data-nombre_imagen="'+campanas[i]['nombre_imagen']+'" data-alt="'+campanas[i]['alt']+'" data-link="'+campanas[i]['url_slide']+'" data-equalizer-watch>\n' +
                            '                                            <a href="#" class="edit-comprar" ><i class="fa fa-edit"></i> Editar Slide</i></a></br/>\n' +
                            '                                                <a class="enabled"><i class="fa fa-toggle-on"></i> Habilitado</a></br/>\n' +
                            '                                            <a class="delete-comprar" ><i class="fa fa-times"></i> Borrar</a>\n' +
                            '                                        </div>\n' +
                            '                                    </div>\n' +
                            '                                </div>');
                    }else{
                        $("#comprar_list").append('<div id="slide_item" class="list-group-item" data-eqalizer data-id_slide_comprar="'+campanas[i]['id_slide_comprar']+'">\n' +
                            '                                    <div class="row collapse" data-equalizer>\n' +
                            '                                        <div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>\n' +
                            '                                            <i class="fa fa-arrows "></i>\n' +
                            '                                        </div>\n' +
                            '                                        <div class="small-9 columns" id="foto" data-equalizer-watch>\n' +
                            '                                            <img src="'+url+campanas[i]['directorio']+'/'+campanas[i]['imagen_small']+'" style="display: block">\n' +
                            '                                        </div>\n' +
                            '                                        <div class="small-9 columns" id="datos_foto" data-equalizer-watch>\n' +
                            '                                            <b>Nombre Foto:</b> '+campanas[i]['nombre_imagen']+'<br/>\n' +
                            '                                            <b>Alt:</b>'+campanas[i]['alt']+'</br/>\n' +
                            '                                            <b>Botón:</b> '+campanas[i]['boton']+' </br/>\n' +
                            '                                            <b>Texto:</b> '+campanas[i]['texto']+' </br/>\n' +
                            '                                            <b>Texto principal:</b> '+campanas[i]['texto_principal']+' </br/>\n' +
                            '                                            <b>Link:</b> <a class="link" href="'+campanas[i]['url_slide']+'"><i class="fa fa-link"></i></a>\n' +
                            '                                        </div>\n' +
                            '                                        <div class="small-5 columns" id="opciones" data-boton="'+campanas[i]['boton']+'" data-texto="'+campanas[i]['texto']+'" data-texto_principal="'+campanas[i]['texto_principal']+'" data-id_slide_comprar ="'+campanas[i]['id_slide_comprar']+'" data-nombre_imagen="'+campanas[i]['nombre_imagen']+'" data-alt="'+campanas[i]['alt']+'" data-link="'+campanas[i]['url_slide']+'" data-equalizer-watch>\n' +
                            '                                            <a href="#" class="edit-comprar" ><i class="fa fa-edit"></i> Editar Slide</i></a></br/>\n' +
                            '                                                <a class="disabled"><i class="fa fa-toggle-off"></i> Deshabilitado</a></br/>\n' +
                            '                                            <a class="delete-comprar"><i class="fa fa-times"></i> Borrar</a>\n' +
                            '                                        </div>\n' +
                            '                                    </div>\n' +
                            '                                </div>');
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


    }
    /*Fin sección slider comprar*/
</script>