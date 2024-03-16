<script>
    $("#cambiar_estatus").change(function() {
        if($(this).val() == '5') {
            var input = '<tr id="dyn-envio"><td colspan="2"><input type="text" name="codigo_rastreo" id="codigo_rastreo_estatus" placeholder="Número de guía" required /></td></tr>';

            $(input).insertAfter("#cam-est");
        } else {
            $("#dyn-envio").remove();
        }
    });

    $("#marcar_atraso").click(function() {
        if($(this).is(":checked")) {
            $.get("<?php echo site_url('administracion/pedidos/atraso/'.$pedido->id_pedido); ?>/1");
        } else {
            $.get("<?php echo site_url('administracion/pedidos/atraso/'.$pedido->id_pedido); ?>/0");
        }
    })

    $("#switch_nueva").click(function () {
        if($("#switch_nueva").is(":checked")){
            $("#form_nueva_dir").show(250);
            $('#form_nueva_dir *').attr('disabled', false);
            $('#form_nueva_dir *').attr('required', true);
            $('#direccion_cliente').attr('required', false);
            $("#form_editar_dir").hide(250);
            $('#form_editar_dir *').attr('disabled', true);
            $('#form_editar_dir *').attr('required', false);
        }else{
            $("#form_nueva_dir").hide(250);
            $('#form_nueva_dir *').attr('disabled', true);
            $('#form_nueva_dir *').attr('required', false);
            $('#direccion_cliente').attr('required', true);
        }

    });
    $("#switch_editar").click(function () {
        if($("#switch_editar").is(":checked")){
            $("#form_editar_dir").show(250);
            $('#form_editar_dir *').attr('disabled', false);
            $('#form_editar_dir *').attr('required', true);
            $("#form_nueva_dir").hide(250);
            $('#form_nueva_dir *').attr('disabled', true);
            $('#form_nueva_dir *').attr('required', false);
            const id_dir = $("#direccion_cliente").val();
            $("#ed_identificador").val($("#opt-"+id_dir).data("identificador"));
            $("#ed_linea1").val($("#opt-"+id_dir).data("linea1"));
            $("#ed_linea2").val($("#opt-"+id_dir).data("linea2"));
            $("#ed_cp").val($("#opt-"+id_dir).data("cp"));
            $("#ed_ciudad").val($("#opt-"+id_dir).data("ciudad"));
            $("#ed_estado").val($("#opt-"+id_dir).data("estado"));
            $("#ed_tel").val($("#opt-"+id_dir).data("tel"));
        }else{
            $("#form_editar_dir").hide(250);
            $('#form_editar_dir *').attr('disabled', true);
            $('#form_editar_dir *').attr('required', false);
            $('#direccion_cliente').attr('required', true);
            $("#ed_identificador").val("");
            $("#ed_linea1").val("");
            $("#ed_linea2").val("");
            $("#ed_cp").val("");
            $("#ed_ciudad").val("");
            $("#ed_estado").val("");
            $("#ed_tel").val("");
        }

    });
    $("#direccion_cliente").change(function(){
        if($(this).val() != "none"){
            $("#switch-editar-dir").show();
        }else{
            $("#switch-editar-dir").hide();
        }
    });
</script>
