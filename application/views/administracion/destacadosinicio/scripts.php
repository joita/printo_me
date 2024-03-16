<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.8.4/Sortable.min.js"></script>
<script>
    if($("#creadores_list").length > 0) {

        var sortFotos = document.getElementById("creadores_list");
        var orden_fotos = [];
        Sortable.create(sortFotos, {
            animation: 150,
            dataIdAttr: "data-id_creador",
            store: {
                get: function (sortable) {
                    var order_fotos = localStorage.getItem(sortable.options.group);
                    return order_fotos ? order.split("|") : [];
                },
                set: function (sortable) {
                    orden_fotos = sortable.toArray();
                    var base_url = "<?php echo base_url()?>";
                    $.post(base_url+"administracion/destacadosinicio/reordenar_creadores/", {
                        data: orden_fotos
                    });
                }
            }
        });
    }

    $(document).on("click", ".enabled", function() {
        var nuevo_estatus = 0;
        var id_creador = $(this).parent().data("id_creador");
        $(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i> Deshabilitado');

        $.post(
            '<?php echo site_url('administracion/destacadosinicio/cambiar_estatus'); ?>',
            { id_creador: id_creador, estatus: nuevo_estatus}
        );
    });

    $(document).on("click", ".disabled", function() {
        var nuevo_estatus = 1;
        var id_creador = $(this).parent().data("id_creador");
        $(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i> Habilitado');

        $.post(
            '<?php echo site_url('administracion/destacadosinicio/cambiar_estatus'); ?>',
            { id_creador: id_creador, estatus: nuevo_estatus}
        );
    });

    $(".edit-creador").click(function() {
        var id_slide = $(this).parent().data("id_creador");
        var nombre_imagen = $(this).parent().data("nombre_imagen");
        var nombre_creador = $(this).parent().data("creador");
        var alt_imagen = $(this).parent().data("alt");
        var link_imagen = $(this).parent().data("link");

        $("#id-creador-editar").val(id_slide);
        $("#editar-nombre").val(nombre_imagen);
        $("#editar-creador").val(nombre_creador);
        $("#editar-alt").val(alt_imagen);
        $("#editar-link").val(link_imagen);
    });

    $(".delete-creador").click(function() {
        var id_creador = $(this).parent().data("id_creador");
        $("#id_creador_borrar").val(id_creador);
    });
</script>