<script>

    $(document).on('click', '#new_categoria', function() {
        var id = $(this).data('id_clasificacion');
        $('.form_new input[name="id_clasificacion"]').val(id);
    });

    $(document).on("click", ".expand_1", function(e) {
        e.preventDefault();
        var id = $(this).parent().data("id");
        $(".list-caracteristica[data-id_parent='"+id+"']").slideDown(150);
        $(this).removeClass("expand_1").addClass("implode_1").html('<i class="fa fa-minus-square-o"></i> Ocultar Subcategorias</i>');
    });

    $(document).on("click", ".implode_1", function(e) {
        e.preventDefault();
        var id = $(this).parent().data("id");
        $(".list-caracteristica[data-id_parent='"+id+"']").slideUp(150);
        $(this).removeClass("implode_1").addClass("expand_1").html('<i class="fa fa-plus-square-o"></i> Mostrar Subcategorias</i>');
    });

    $(document).on("click", ".enabled", function() {
        var nuevo_estatus = 0;
        var id = $(this).parent().data("id");
        var id_parent = $(this).parent().data("id_parent");
        $(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');

        $(".divisor-sub[data-id_parent='"+id+"'] .enabled").removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');

        $.post('<?php echo site_url('administracion/categorizar/estatus'); ?>', { id: id, id_parent: id_parent, estatus: nuevo_estatus });
    });

    $(document).on("click", ".disabled", function() {
        var nuevo_estatus = 1;
        var id = $(this).parent().data("id");
        var id_parent = $(this).parent().data("id_parent");
        $(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');

        $(".divisor-sub[data-id_parent='"+id+"'] .disabled").removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');

        $.post('<?php echo site_url('administracion/categorizar/estatus'); ?>', { id: id, id_parent: id_parent, estatus: nuevo_estatus });
    });

    $(document).on("click", ".expand", function(e) {
        e.preventDefault();
        var id = $(this).parent().data("id");
        $(".list-subcaracteristica[data-id_parent='"+id+"']").slideDown(150);
        $(this).removeClass("expand").addClass("implode").html('<i class="fa fa-minus-square-o"></i> Ocultar Subcategorias</i>');
    });

    $(document).on("click", ".implode", function(e) {
        e.preventDefault();
        var id = $(this).parent().data("id");
        $(".list-subcaracteristica[data-id_parent='"+id+"']").slideUp(150);
        $(this).removeClass("implode").addClass("expand").html('<i class="fa fa-plus-square-o"></i> Mostrar Subcategorias</i>');
    });

    $("a.editar").click(function() {
        var id = $(this).parent().data("id");
        $(".form_edit #id_categoria_mod").val(id);
    });

    $(".nueva_cat").click(function(){
        var id_parent = $(this).data("id_parent");
        $("#id_parent_mod").val(id_parent);
    });

    $(".delete").click(function() {
        var id = $(this).parent().data("id");
        $(".form_borrar #id_categoria_bor").val(id);
    });

</script>
