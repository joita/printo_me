<script>
var info_sesion;
var sesion_fiscal;

function complete_address()
{
    if(info_sesion.situacion == 'no_registrado') {
        var direccion = info_sesion;
        $.post( "<?php echo site_url('carrito/sesion-direccion'); ?>", { direccion: direccion })
        .done(function( data ) {

        });
    } else if(info_sesion.situacion == 'sin_direcciones') {
        if($("#direccion_envio_seleccionada").length == 0) {
            var direccion = info_sesion;
            $.post( "<?php echo site_url('carrito/sesion-direccion'); ?>", { direccion: direccion })
            .done(function( data ) {

            });
        } else {
            $("#direccion_envio_seleccionada").html('<span class="text-center">Por favor selecciona una dirección de envío.</span>');
        }

    }
}

function cambio_codigo_postal(){
    if($("#codigo_postal").val().length != 0) {
        var codigo_postal = $("#codigo_postal").val();
        $.ajax({
            url: "<?php echo site_url("carrito/obtener_datos_direccion");?>",
            type: 'get',
            data:{codigo_postal: codigo_postal},
            dataType: 'json',
            beforeSend: function(){
                $("#linea1").prop('disabled', true);
                $("#ciudad").prop('disabled', true);
                $("#estado").prop('disabled', true);
                $("#linea2").prop('disabled', true);
                $("#loader").css('display', 'block');
                $('#linea2').html('');
            },
            success: function(data){
                var direcciones = data;
                if(typeof direcciones[0] !== 'undefined'){
                    if(typeof direcciones[0].ciudad_asentamiento !== 'undefined'){
                        $("#ciudad").val(direcciones[0].ciudad_asentamiento);
                    }
                    $("#estado").val(direcciones[0].nombre_estado);
                    $('#linea2').html('');
                    for(i=0; i < direcciones.length; i++){
                        $("#linea2").append("<option>"+direcciones[i].nombre_asentamiento+"</option>");
                    }
                    $("#linea2").append("<option id='otro'>Otro</option>");
                    $("#linea1").prop('disabled', false);
                    $("#ciudad").prop('disabled', false);
                    $("#estado").prop('disabled', false);
                    $("#linea2").prop('disabled', false);
                }else{
                    alert("No contamos con información sobre el codigo postal ingresado, favor de ingresar su información manualmente.")
                    $("#linea2").append("<option selected='selected'>Otro</option>");
                    $("#linea1").prop('disabled', false);
                    $("#ciudad").prop('disabled', false);
                    $("#estado").prop('disabled', false);
                    $("#linea2").prop('disabled', false);
                    $("#colonia-otro").show('15', 'swing');
                }
            },
            complete: function(){
                $("#loader").css('display', 'none');
            }
        });
    }
}

$("#linea2").change(function () {
    var seleccionado = $(this).children("option:selected").val();
    if(seleccionado === "Otro"){
        $("#colonia-otro").show('15', 'swing');
    }else{
        $("#colonia-otro").hide('15', 'swing');
    }
});

function cambio_codigo_postal_fiscal(){
    if($("#codigo_postal_limpia").val().length != 0) {
        var codigo_postal = $("#codigo_postal_limpia").val();
        $.ajax({
            url: "<?php echo site_url("carrito/obtener_datos_direccion");?>",
            type: 'get',
            data:{codigo_postal: codigo_postal},
            dataType: 'json',
            beforeSend: function(){
                $("#linea1_limpia").prop('disabled', true);
                $("#ciudad_limpia").prop('disabled', true);
                $("#estado_limpia").prop('disabled', true);
                $("#linea2_limpia").prop('disabled', true);
                $("#linea2_limpia_otro").prop('required', false);
                $("#linea2_limpia_otro").prop('disabled', true);
                $("#loader_fiscal").css('display', 'block');
                $('#linea2_limpia').html('');
            },
            success: function(data){
                var direcciones = data;
                if(typeof direcciones[0] !== 'undefined'){
                    $("#colonia-otro-limpia").hide('15', 'swing');
                    if(typeof direcciones[0].ciudad_asentamiento !== 'undefined'){
                        $("#ciudad_limpia").val(direcciones[0].ciudad_asentamiento);
                    }
                    $("#estado_limpia").val(direcciones[0].nombre_estado);
                    $("#linea2_limpia").html('');
                    for(i=0; i < direcciones.length; i++){
                        $("#linea2_limpia").append("<option>"+direcciones[i].nombre_asentamiento+"</option>");
                    }
                    $("#linea2_limpia").append("<option id='otro'>Otro</option>");
                    $("#linea1_limpia").prop('disabled', false);
                    $("#ciudad_limpia").prop('disabled', false);
                    $("#estado_limpia").prop('disabled', false);
                    $("#linea2_limpia").prop('disabled', false);
                }else{
                    alert("No contamos con información sobre el codigo postal ingresado, favor de ingresar su información manualmente.")
                    $("#linea2_limpia").append("<option selected='selected'>Otro</option>");
                    $("#linea1_limpia").prop('disabled', false);
                    $("#ciudad_limpia").prop('disabled', false);
                    $("#estado_limpia").prop('disabled', false);
                    $("#linea2_limpia").prop('disabled', false);
                    $("#colonia-otro-limpia").show('15', 'swing');
                }
            },
            complete: function(){
                $("#loader_fiscal").css('display', 'none');
            }
        });
    }
}

$("#linea2_limpia").change(function () {
    var seleccionado = $(this).children("option:selected").val();
    if(seleccionado === "Otro"){
        $("#colonia-otro-limpia").show('15', 'swing');
        $("#linea2_limpia_otro").prop('required', true);
        $("#linea2_limpia_otro").prop('disabled', false);
    }else{
        $("#colonia-otro-limpia").hide('15', 'swing');
        $("#linea2_limpia_otro").prop('required', false);
        $("#linea2_limpia_otro").prop('disabled', true);
    }
});

function cambio_codigo_postal_reveal_fiscal(){
    if($("#codigo_postal_fiscal").val().length != 0) {
        var codigo_postal = $("#codigo_postal_fiscal").val();
        $.ajax({
            url: "<?php echo site_url("carrito/obtener_datos_direccion");?>",
            type: 'get',
            data:{codigo_postal: codigo_postal},
            dataType: 'json',
            beforeSend: function(){
                $("#linea1_fiscal").prop('disabled', true);
                $("#ciudad_fiscal").prop('disabled', true);
                $("#estado_fiscal").prop('disabled', true);
                $("#linea2_fiscal").prop('disabled', true);
                $("#loader_fiscal").css('display', 'block');
                $('#linea2_fiscal').html('');
            },
            success: function(data){
                var direcciones = data;
                if(typeof direcciones[0] !== 'undefined'){
                    if(typeof direcciones[0].ciudad_asentamiento !== 'undefined'){
                        $("#ciudad_nuevo_reveal_carrito").val(direcciones[0].ciudad_asentamiento);
                    }
                    $("#estado_fiscal").val(direcciones[0].nombre_estado);
                    $("#linea2_fiscal").html('');
                    for(i=0; i < direcciones.length; i++){
                        $("#linea2_fiscal").append("<option>"+direcciones[i].nombre_asentamiento+"</option>");
                }
                    $("#linea2_fiscal").append("<option id='otro'>Otro</option>");
                    $("#linea1_fiscal").prop('disabled', false);
                    $("#ciudad_fiscal").prop('disabled', false);
                    $("#estado_fiscal").prop('disabled', false);
                    $("#linea2_fiscal").prop('disabled', false);
                }else{
                    alert("No contamos con información sobre el codigo postal ingresado, favor de ingresar su información manualmente.")
                    $("#linea2_fiscal").append("<option selected='selected'>Otro</option>");
                    $("#linea1_fiscal").prop('disabled', false);
                    $("#ciudad_fiscal").prop('disabled', false);
                    $("#estado_fiscal").prop('disabled', false);
                    $("#linea2_fiscal").prop('disabled', false);
                    $("#colonia-otro-fiscal").show('15', 'swing');
                }
            },
            complete: function(){
                $("#loader_fiscal").css('display', 'none');
            }
        });
    }
}

$("#linea2_fiscal").change(function () {
    var seleccionado = $(this).children("option:selected").val();
    if(seleccionado === "Otro"){
        $("#colonia-otro-fiscal").show('15', 'swing');
    }else{
        $("#colonia-otro-fiscal").hide('15', 'swing');
    }
});

function cambio_codigo_postal_reveal(){
    if($("#codigo_postal_nuevo_reveal_carrito").val().length != 0) {

        var codigo_postal = $("#codigo_postal_nuevo_reveal_carrito").val();
        $.ajax({
            url: "<?php echo site_url("carrito/obtener_datos_direccion");?>",
            type: 'get',
            data:{codigo_postal: codigo_postal},
            dataType: 'json',
            beforeSend: function(){
                $("#linea1_nuevo_reveal_carrito").prop('disabled', true);
                $("#ciudad_nuevo_reveal_carrito").prop('disabled', true);
                $("#estado_nuevo").prop('disabled', true);
                $("#linea2_nuevo_reveal_carrito").prop('disabled', true);
                $("#loader").css('display', 'block');
                $('#linea2_nuevo_reveal_carrito').html('');
            },
            success: function(data){
                var direcciones = data;
                if(typeof direcciones[0] !== 'undefined'){
                    if(typeof direcciones[0].ciudad_asentamiento !== 'undefined'){
                        $("#ciudad_nuevo_reveal_carrito").val(direcciones[0].ciudad_asentamiento);
                    }
                    $("#estado_nuevo").val(direcciones[0].nombre_estado);
                    $("#linea2_nuevo_reveal_carrito").html('');
                    for(i=0; i < direcciones.length; i++){
                        $("#linea2_nuevo_reveal_carrito").append("<option>"+direcciones[i].nombre_asentamiento+"</option>");
                    }
                    $("#linea2_nuevo_reveal_carrito").append("<option id='otro'>Otro</option>");
                    $("#linea1_nuevo_reveal_carrito").prop('disabled', false);
                    $("#ciudad_nuevo_reveal_carrito").prop('disabled', false);
                    $("#estado_nuevo").prop('disabled', false);
                    $("#linea2_nuevo_reveal_carrito").prop('disabled', false);
                }else{
                    alert("No contamos con información sobre el codigo postal ingresado, favor de ingresar su información manualmente.")
                    $("#linea2_nuevo_reveal_carrito").append("<option selected='selected'>Otro</option>");
                    $("#linea1_nuevo_reveal_carrito").prop('disabled', false);
                    $("#ciudad_nuevo_reveal_carrito").prop('disabled', false);
                    $("#estado_nuevo").prop('disabled', false);
                    $("#linea2_nuevo_reveal_carrito").prop('disabled', false);
                    $("#colonia-otro").show('15', 'swing');
                }
            },
            complete: function(){
                $("#loader").css('display', 'none');
            }
        });
    }
}

$("#linea2_nuevo_reveal_carrito").change(function () {
    var seleccionado = $(this).children("option:selected").val();
    if(seleccionado === "Otro"){
        $("#colonia-otro").show('15', 'swing');
    }else{
        $("#colonia-otro").hide('15', 'swing');
    }
});

function complete_address_fiscal()
{
    if(sesion_fiscal.situacion == 'no_registrado') {
        var direccion_fiscal = sesion_fiscal;
        $.post( "<?php echo site_url('carrito/sesion-direccion'); ?>", { direccion_fiscal: direccion_fiscal })
        .done(function( data ) {

        });
    } else if(sesion_fiscal.situacion == 'sin_direcciones') {

        if($("#direccion_fiscal_seleccionada").length == 0) {
            var direccion_fiscal = sesion_fiscal;
            $.post( "<?php echo site_url('carrito/sesion-direccion'); ?>", { direccion_fiscal: direccion_fiscal })
            .done(function( data ) {

            });
        } else {
            $("#direccion_fiscal_seleccionada").html('<span class="text-center">Por favor selecciona los datos de facturación para la factura.</span>');
        }
    }
}

$(document).ready(function() {
    info_sesion = {
        "situacion": "",
        "nombre" : "<?php echo (isset($this->session->direccion_temporal['nombre']) ? $this->session->direccion_temporal['nombre'] : ''); ?>",
        "apellidos": "<?php echo (isset($this->session->direccion_temporal['apellidos']) ? $this->session->direccion_temporal['apellidos'] : ''); ?>",
        "email": "<?php echo (isset($this->session->direccion_temporal['email']) ? $this->session->direccion_temporal['email'] : ''); ?>",
        "identificador_direccion" : "<?php echo (isset($this->session->direccion_temporal['identificador_direccion']) ? $this->session->direccion_temporal['identificador_direccion'] : ''); ?>",
        "id_direccion": "<?php echo (isset($this->session->direccion_temporal['id_direccion']) ? $this->session->direccion_temporal['id_direccion'] : ''); ?>",
        "telefono" : "<?php echo (isset($this->session->direccion_temporal['telefono']) ? $this->session->direccion_temporal['telefono'] : ''); ?>",
        "linea1" : "<?php echo (isset($this->session->direccion_temporal['linea1']) ? $this->session->direccion_temporal['linea1'] : ''); ?>",
        "linea2" : "<?php echo (isset($this->session->direccion_temporal['linea2']) ? $this->session->direccion_temporal['linea2'] : ''); ?>",
        "ciudad" : "<?php echo (isset($this->session->direccion_temporal['ciudad']) ? $this->session->direccion_temporal['ciudad'] : ''); ?>",
        "codigo_postal" : "<?php echo (isset($this->session->direccion_temporal['codigo_postal']) ? $this->session->direccion_temporal['codigo_postal'] : ''); ?>",
        "estado" : "<?php echo (isset($this->session->direccion_temporal['estado']) ? $this->session->direccion_temporal['estado'] : ''); ?>",
        "valido" : false
    };

    sesion_fiscal = {
        "situacion" : "",
        "razon_social" : "<?php echo (isset($this->session->direccion_fiscal_temporal['razon_social']) ? $this->session->direccion_fiscal_temporal['razon_social'] : ''); ?>",
        "rfc" : "<?php echo (isset($this->session->direccion_fiscal_temporal['rfc']) ? $this->session->direccion_fiscal_temporal['rfc'] : ''); ?>",
        "id_direccion_fiscal": "<?php echo (isset($this->session->direccion_fiscal_temporal['id_direccion_fiscal']) ? $this->session->direccion_fiscal_temporal['id_direccion_fiscal'] : ''); ?>",
        "telefono" : "<?php echo (isset($this->session->direccion_fiscal_temporal['telefono']) ? $this->session->direccion_fiscal_temporal['telefono'] : ''); ?>",
        "correo_electronico_facturacion" : "<?php echo (isset($this->session->direccion_fiscal_temporal['correo_electronico_facturacion']) ? $this->session->direccion_fiscal_temporal['correo_electronico_facturacion'] : ''); ?>",
        "linea1" : "<?php echo (isset($this->session->direccion_fiscal_temporal['linea1']) ? $this->session->direccion_fiscal_temporal['linea1'] : ''); ?>",
        "linea2" : "<?php echo (isset($this->session->direccion_fiscal_temporal['linea2']) ? $this->session->direccion_fiscal_temporal['linea2'] : ''); ?>",
        "ciudad" : "<?php echo (isset($this->session->direccion_fiscal_temporal['ciudad']) ? $this->session->direccion_fiscal_temporal['ciudad'] : ''); ?>",
        "codigo_postal" : "<?php echo (isset($this->session->direccion_fiscal_temporal['codigo_postal']) ? $this->session->direccion_fiscal_temporal['codigo_postal'] : ''); ?>",
        "estado" : "<?php echo (isset($this->session->direccion_fiscal_temporal['estado']) ? $this->session->direccion_fiscal_temporal['estado'] : ''); ?>"
    };

    <?php $direcciones = $this->cuenta_modelo->obtener_direcciones($this->session->login['id_cliente']); ?>
    <?php $direcciones_fiscales = $this->cuenta_modelo->obtener_direcciones_fiscales($this->session->login['id_cliente']); ?>

    <?php $is_client = !is_null($this->session->login['id_cliente']);  ?>
    <?php if(!$is_client): ?>
    info_sesion.situacion = 'no_registrado';
    sesion_fiscal.situacion = 'no_registrado';
    info_sesion.identificador_direccion = 'Principal';
    <?php else: ?>
        <?php if(sizeof($direcciones) == 0): ?>
        info_sesion.situacion = 'sin_direcciones';
        info_sesion.identificador_direccion = 'Principal';
        <?php else: ?>
        info_sesion.situacion = 'con_direcciones';
        <?php endif; ?>

        <?php if(sizeof($direcciones_fiscales) == 0): ?>
        sesion_fiscal.situacion = 'sin_direcciones';
        <?php else: ?>
        sesion_fiscal.situacion = 'con_direcciones';
        <?php endif; ?>
    <?php endif; ?>


    $("[data-dircompleta]").click(function() {
        var direccion = $(this).data('dircompleta');
        info_sesion.id_direccion = direccion.id_direccion;
    });

    $("[name='direccion[nombre]']").on("focusout",function() {
        info_sesion.nombre = $(this).val();
        complete_address();
    });

    $("[name='direccion[apellidos]']").on("focusout",function() {
        info_sesion.apellidos = $(this).val();
        complete_address();
    });

    $("[name='direccion[email]']").on("focusout",function() {
        info_sesion.email = $(this).val();
        complete_address();
    });

    $("[name='direccion[identificador_direccion]']").on("focusout",function() {
        info_sesion.identificador_direccion = $(this).val();
        complete_address();
    });

    $("[name='direccion[telefono]']").on("focusout",function() {
        info_sesion.telefono = $(this).val();
        complete_address();
    });

    $("[name='direccion[linea1]']").on("focusout",function() {
        info_sesion.linea1 = $(this).val();
        complete_address();
    });

    $("[name='direccion[linea2]']").on("focusout",function() {
        info_sesion.linea2 = $(this).val();
        complete_address();
    });

    $("[name='direccion[ciudad]']").on("focusout",function() {
        info_sesion.ciudad = $(this).val();
        complete_address();
    });

    $("[name='direccion[codigo_postal]']").on("focusout",function() {
        info_sesion.codigo_postal = $(this).val();
        complete_address();
    });

    $("[name='direccion[estado]']").on("focusout",function() {
        info_sesion.estado = $(this).val();
        complete_address();
    });

    // Modificacion direccion_fiscal
    $("[name='direccion_fiscal[razon_social]']").on("focusout",function() {
        sesion_fiscal.razon_social = $(this).val();
        complete_address_fiscal();
    });
    $("[name='direccion_fiscal[rfc]']").on("focusout",function() {
        sesion_fiscal.rfc = $(this).val();
        complete_address_fiscal();
    });
    $("[name='direccion_fiscal[telefono]']").on("focusout",function() {
        sesion_fiscal.telefono = $(this).val();
        complete_address_fiscal();
    });
    $("[name='direccion_fiscal[correo_electronico_facturacion]']").on("focusout",function() {
        sesion_fiscal.correo_electronico_facturacion = $(this).val();
        complete_address_fiscal();
    });
    $("[name='direccion_fiscal[linea1]']").on("focusout",function() {
        sesion_fiscal.linea1 = $(this).val();
        complete_address_fiscal();
    });
    $("[name='direccion_fiscal[linea2]']").on("focusout",function() {
        sesion_fiscal.linea2 = $(this).val();
        complete_address_fiscal();
    });
    $("[name='direccion_fiscal[ciudad]']").on("focusout",function() {
        sesion_fiscal.ciudad = $(this).val();
        complete_address_fiscal();
    });
    $("[name='direccion_fiscal[codigo_postal]']").on("focusout",function() {
        sesion_fiscal.codigo_postal = $(this).val();
        complete_address_fiscal();
    });
    $("[name='direccion_fiscal[estado]']").on("focusout",function() {
        sesion_fiscal.estado = $(this).val();
        complete_address_fiscal();
    });

    // Activacion de botones en relacion a direcciones
    $("#id_direccion").change(function() {
        if($("#id_direccion option:selected").attr("id") == "agregar_dinamico") {
            $("#nueva_direccion").foundation("open");
            $("#id_direccion option:eq(0)").prop("selected", true);
        }

        if($(this).val() != "") {
            $("#paypal_selecciona_direccion, #oxxo_selecciona_direccion, #tarjeta_selecciona_direccion").hide();
            $("#area_paypal, #paypal_loading, .p_t_b").show();
            var direccion = $("#id_direccion option:selected").data("dircompleta");

            var html = '<span><strong>'+direccion.identificador_direccion+'</strong>';
            html += direccion.linea1+'<br />';
            if(direccion.linea2 != '') {
                html += direccion.linea2+', CP: '+direccion.codigo_postal+'<br />';
            }
            html += 'Teléfono: '+direccion.telefono+'<br />';
            html += direccion.ciudad+', '+direccion.estado+', '+direccion.pais;

            $.post( "<?php echo site_url('carrito/sesion-direccion'); ?>", { direccion: direccion })
            .done(function( data ) {

            });

            $("#direccion_envio_seleccionada").html(html);
        } else {
            $("#direccion_envio_seleccionada").html('<span class="text-center">Por favor selecciona una dirección de envío.</span>');
        }
    });

    $("select#id_direccion").on('change', function(){
        var direccion = JSON.parse($("option:selected").attr('data-dircompleta'));
        var codigo_postal = direccion.codigo_postal;
        var nombre_asentamiento = direccion.linea2;
        var total_envio = $("#costo_total").text();
        var id_direccion = $("option:selected").val();
        var html_completo;
        $.ajax({
            url: base_url+"carrito/cambiar-direccion-dinamico",
            type: 'POST',
            data:{
                codigo_postal: codigo_postal,
                nombre_asentamiento: nombre_asentamiento,
                total_envio: total_envio,
                id_direccion: id_direccion
            },
            beforeSend: function(){
                $("#costo_envio").html("");
                $("#costo_total").html("");
                $("#costo_envio").addClass('loading-16');
                $("#costo_total").addClass('loading-16');
            },
            success: function(respuesta){
                html_completo = JSON.parse(respuesta);
            },
            complete: function(){
                $("#costo_envio").removeClass('loading-16');
                $("#costo_total").removeClass('loading-16');
                $("#costo_envio").html(html_completo.html_envio);
                $("#costo_total").html(html_completo.html_total);
            }
        });
    });

    // Activacion de botones en relacion a direcciones de facturacion
    $("#id_direccion_fiscal").change(function() {
        if($("#id_direccion_fiscal option:selected").attr("id") == "agregar_dinamico") {
            $("#nueva_facturacion").foundation("open");
            $("#id_direccion_fiscal option:eq(0)").prop("selected", true);
        }

        if($(this).val() != "") {
            var direccion_fiscal = $("#id_direccion_fiscal option:selected").data("dircompleta");

            var html = '<span><strong>'+direccion_fiscal.razon_social+'</strong>';
            html += direccion_fiscal.rfc+'<br />';
            html += direccion_fiscal.linea1+'<br />';
            if(direccion_fiscal.linea2 != '') {
                html += direccion_fiscal.linea2+', CP: '+direccion_fiscal.codigo_postal+'<br />';
            }
            html += 'Correo facturación: '+direccion_fiscal.correo_electronico_facturacion+'<br />';
            html += 'Teléfono: '+direccion_fiscal.telefono+'<br />';
            html += direccion_fiscal.ciudad+', '+direccion_fiscal.estado+', '+direccion_fiscal.pais;

            $.post( "<?php echo site_url('carrito/sesion-direccion'); ?>", { direccion_fiscal: direccion_fiscal })
            .done(function( data ) {

            });
            $("#direccion_fiscal_seleccionada").html(html);
        } else {
            $("#direccion_fiscal_seleccionada").html('<span class="text-center">Por favor selecciona los datos de facturación para la factura.</span>');
        }
    });

<?php if($this->session->direccion_temporal): ?>
<?php if($this->session->direccion_temporal['id_direccion'] != ''): ?>
    $("#id_direccion").val(<?php echo $this->session->direccion_temporal['id_direccion']; ?>);

    var direccion = $("#id_direccion option:selected").data("dircompleta");

    var html = '<span><strong>'+direccion.identificador_direccion+'</strong>';
    html += direccion.linea1+'<br />';
    if(direccion.linea2 != '') {
        html += direccion.linea2+', CP: '+direccion.codigo_postal+'<br />';
    }
    html += 'Teléfono: '+direccion.telefono+'<br />';
    html += direccion.ciudad+', '+direccion.estado+', '+direccion.pais;

    $.post( "<?php echo site_url('carrito/sesion-direccion'); ?>", { direccion: direccion })
    .done(function( data ) {

    });
    $("#direccion_envio_seleccionada").html(html);
<?php endif; ?>
    $("#estado").val('<?php echo $this->session->direccion_temporal['estado']; ?>');

    $.post( "<?php echo site_url('carrito/sesion-direccion'); ?>", { direccion: <?php echo json_encode($this->session->direccion_temporal); ?> })
    .done(function( data ) {

    });
<?php endif; ?>

<?php if($this->session->direccion_fiscal_temporal): ?>
<?php if($this->session->direccion_fiscal_temporal['id_direccion_fiscal'] != ''): ?>
    $("#id_direccion_fiscal").val(<?php echo $this->session->direccion_fiscal_temporal['id_direccion_fiscal']; ?>);

    var direccion_fiscal = $("#id_direccion_fiscal option:selected").data("dircompleta");

    var html = '<span><strong>'+direccion_fiscal.razon_social+'</strong>';
    html += direccion_fiscal.rfc+'<br />';
    html += direccion_fiscal.linea1+'<br />';
    if(direccion_fiscal.linea2 != '') {
        html += direccion_fiscal.linea2+', CP: '+direccion_fiscal.codigo_postal+'<br />';
    }
    html += 'Correo facturación: '+direccion_fiscal.correo_electronico_facturacion+'<br />';
    html += 'Teléfono: '+direccion_fiscal.telefono+'<br />';
    html += direccion_fiscal.ciudad+', '+direccion_fiscal.estado+', '+direccion_fiscal.pais;

    $.post( "<?php echo site_url('carrito/sesion-direccion'); ?>", { direccion_fiscal: direccion_fiscal })
    .done(function( data ) {
    });

    $("#direccion_fiscal_seleccionada").html(html);
    <?php endif; ?>
    $("#estado_limpia").val('<?php echo $this->session->direccion_fiscal_temporal['estado']; ?>');

    $.post( "<?php echo site_url('carrito/sesion-direccion'); ?>", { direccion_fiscal: <?php echo json_encode($this->session->direccion_fiscal_temporal); ?> })
    .done(function( data ) {

    });
<?php endif; ?>

    $(document).on("click", "#requiero_facturar", function() {
    //$("#requiero_facturar").click(function() {
        if($(this).is(":checked")) {
            $("#hidden_fact").show();
            $("#hidden_fact input, #hidden_fact select").prop("disabled", false);
            $("#hidden_fact input, #hidden_fact select").prop("required", true);
            if($("#id_direccion_fiscal").length > 0) {
                $("#id_direccion_fiscal").prop("required", true);
                complete_address_fiscal();
            } else {
                complete_address_fiscal();
            }
            $.post( "<?php echo site_url('carrito/sesion-direccion'); ?>", { cancelar_direccion_fiscal: 0 })
            .done(function(data) {
                $("#hidden_fact input, #hidden_fact select").prop("disabled", false);
                $("#hidden_fact input, #hidden_fact select").prop("required", true);
            });
        } else {
            $("#hidden_fact").hide();
            $("#hidden_fact input, #hidden_fact select").prop("disabled", true);
            $("#hidden_fact input, #hidden_fact select").prop("required", false);
            if($("#id_direccion_fiscal").length > 0) {
                $("#id_direccion_fiscal").prop("required", false);
                $("#id_direccion_fiscal option:eq(0)").prop("selected", true);
            }
            $.post( "<?php echo site_url('carrito/sesion-direccion'); ?>", { cancelar_direccion_fiscal: 1 })
            .done(function(data) {
                $("#hidden_fact input, #hidden_fact select").prop("disabled", true);
                $("#hidden_fact input, #hidden_fact select").prop("required", false);
            });
        }
    });
    if($.trim($("#codigo_postal").val()) != ''){
        cambio_codigo_postal();
    }

    if($.trim($("#codigo_postal_limpia").val()) != ''){
        cambio_codigo_postal_fiscal();
    }
});

/**DE AQUI PARA ABAJO ES TWILIO NO TOCAR!**/

const id_direccion = $("#id_direccion"), id_direccion_fiscal = $("#id_direccion_fiscal");

let direccion, direccion_fiscal;

<?php if(!isset($tienda)):?>
    let iti_nueva_dir, iti_dir_fiscal;

    if(!id_direccion.length){
        const input = document.querySelector("#telefono");
        iti_nueva_dir = window.intlTelInput(input, {
            onlyCountries: ['us', 'mx', 'ca'],
            preferredCountries: ['mx'],
            initialCountry: 'mx',
            separateDialCode: true,
            utilsScript: "assets/js/IntlTelInput/utils.js",
        });
    }
    if(!id_direccion_fiscal.length){
        const input = document.querySelector("#telefono_limpia");
        iti_dir_fiscal = window.intlTelInput(input, {
            onlyCountries: ['us', 'mx', 'ca'],
            preferredCountries: ['mx'],
            initialCountry: 'mx',
            separateDialCode: true,
            utilsScript: "assets/js/IntlTelInput/utils.js",
        });
    }
<?php else:?>
let iti_nueva_dir, iti_dir_fiscal;

if(!id_direccion.length){
    const input = document.querySelector("#telefono");
    iti_nueva_dir = window.intlTelInput(input, {
        onlyCountries: ['us', 'mx', 'ca'],
        preferredCountries: ['mx'],
        initialCountry: 'mx',
        separateDialCode: true,
        utilsScript: "<?php echo base_url("assets/js/IntlTelInput/utils.js")?>",
    });
}
if(!id_direccion_fiscal.length){
    const input = document.querySelector("#telefono_limpia");
    iti_dir_fiscal = window.intlTelInput(input, {
        onlyCountries: ['us', 'mx', 'ca'],
        preferredCountries: ['mx'],
        initialCountry: 'mx',
        separateDialCode: true,
        utilsScript: "<?php echo base_url("assets/js/IntlTelInput/utils.js")?>",
    });
}
<?php endif;?>

$("#direccion-carrito").submit(function(event){
    event.preventDefault();
    let num_tel, fac_tel;
    /**CHECAR CONDICIONES PARA MANDAR A VERIFICAR TELEFONOS**/
    if($("#direccion-carrito input.is-invalid-input").length <= 0){
        if($("#requiero_facturar").is(":checked")){
            if(id_direccion.length && !id_direccion_fiscal.length){
                direccion = {
                    "id_direccion" : $("#id_direccion").val()
                };
                direccion_fiscal = {
                    "razon_social": $("#razon_social_limpia").val(),
                    "rfc": $("#rfc_limpia").val(),
                    "ciudad": $("#ciudad_limpia").val(),
                    "linea1": $("#linea1_limpia").val(),
                    "linea2": $("#linea2_limpia").val(),
                    "linea2_otro": $("#linea2_limpia_otro").val(),
                    "codigo_postal": $("#codigo_postal_limpia").val(),
                    "estado": $("#estado_limpia").val(),
                    "telefono": $("#telefono_limpia").val(),
                    "correo_electronico_facturacion": $("#correo_electronico_facturacion_limpia").val()
                };
                fac_tel = iti_dir_fiscal.getNumber(intlTelInputUtils.numberFormat.E164);
                verificar_telefono(fac_tel, 'direccion_fiscal', direccion, direccion_fiscal, '_limpia');
            }else if(id_direccion.length && id_direccion_fiscal.length){
                direccion = {
                    "id_direccion" : $("#id_direccion").val()
                };
                direccion_fiscal = {
                    "id_direccion_fiscal" : $("#id_direccion_fiscal").val()
                };
                enviar_formulario_direccion_carrito(direccion, direccion_fiscal);
            }else if(!id_direccion.length && id_direccion_fiscal.length){
                direccion = {
                    <?php if (!$this->session->has_userdata('login')):?>
                    "nombre": $("#nombre").val(),
                    "apellidos": $("#apellidos").val(),
                    "email": $("#email").val(),
                    <?php endif;?>
                    "identificador_direccion": $("#identificador_direccion").val(),
                    "codigo_postal": $("#codigo_postal").val(),
                    "ciudad": $("#ciudad").val(),
                    "linea1": $("#linea1").val(),
                    "linea2": $("#linea2").val(),
                    "linea2_otro": $("#linea2_otro").val(),
                    "estado": $("#estado").val(),
                    "telefono": $("#telefono").val()
                };
                num_tel = iti_nueva_dir.getNumber(intlTelInputUtils.numberFormat.E164);
                direccion_fiscal = {
                    "id_direccion_fiscal" : $("#id_direccion_fiscal").val()
                };
                verificar_telefono(num_tel, 'direccion', direccion, direccion_fiscal, '');
            }else if(!id_direccion_fiscal.length && !id_direccion_fiscal.length){
                direccion = {
                    <?php if (!$this->session->has_userdata('login')):?>
                    "nombre": $("#nombre").val(),
                    "apellidos": $("#apellidos").val(),
                    "email": $("#email").val(),
                    <?php endif;?>
                    "identificador_direccion": $("#identificador_direccion").val(),
                    "codigo_postal": $("#codigo_postal").val(),
                    "ciudad": $("#ciudad").val(),
                    "linea1": $("#linea1").val(),
                    "linea2": $("#linea2").val(),
                    "linea2_otro": $("#linea2_otro").val(),
                    "estado": $("#estado").val(),
                    "telefono": $("#telefono").val()
                };
                num_tel = iti_nueva_dir.getNumber(intlTelInputUtils.numberFormat.E164);
                direccion_fiscal = {
                    "razon_social": $("#razon_social_limpia").val(),
                    "rfc": $("#rfc_limpia").val(),
                    "ciudad": $("#ciudad_limpia").val(),
                    "linea1": $("#linea1_limpia").val(),
                    "linea2": $("#linea2_limpia").val(),
                    "linea2_otro": $("#linea2_limpia_otro").val(),
                    "codigo_postal": $("#codigo_postal_limpia").val(),
                    "estado": $("#estado_limpia").val(),
                    "telefono": $("#telefono_limpia").val(),
                    "correo_electronico_facturacion": $("#correo_electronico_facturacion_limpia").val()
                };
                fac_tel = iti_dir_fiscal.getNumber(intlTelInputUtils.numberFormat.E164);
                verificar_dos_telefonos(num_tel, fac_tel, direccion, direccion_fiscal);
            }
        }else{
            if(id_direccion.length){
                direccion = {
                    "id_direccion" : $("#id_direccion").val()
                };
                enviar_formulario_direccion_carrito(direccion, direccion_fiscal);
            }else if(!id_direccion.length){
                direccion = {
                    <?php if (!$this->session->has_userdata('login')):?>
                    "nombre": $("#nombre").val(),
                    "apellidos": $("#apellidos").val(),
                    "email": $("#email").val(),
                    <?php endif;?>
                    "identificador_direccion": $("#identificador_direccion").val(),
                    "codigo_postal": $("#codigo_postal").val(),
                    "ciudad": $("#ciudad").val(),
                    "linea1": $("#linea1").val(),
                    "linea2": $("#linea2").val(),
                    "linea2_otro": $("#linea2_otro").val(),
                    "estado": $("#estado").val(),
                    "telefono": $("#telefono").val()
                };
                num_tel = iti_nueva_dir.getNumber(intlTelInputUtils.numberFormat.E164);
                verificar_telefono(num_tel, 'direccion', direccion, direccion_fiscal, '');
            }
        }
    }
});

function verificar_telefono(num_tel, nombre_form, dir, dir_fiscal, limpia){
    $.ajax({
        url: "registro-telefono-twilio",
        data: {
            num_tel: num_tel
        },
        method: "GET",
        beforeSend: function () {
            $("#telefono"+limpia).removeClass("is-invalid-input");
            $("#error-tel"+limpia).removeClass("is-visible");
            $("#direcciones_load").show(10);
        },
        success: function (response) {
            response = $.parseJSON(response);
            if (response.estatus) {
                const input_tipo_tel = $("<input>").attr("type", "hidden").attr("name", nombre_form+"[tipo_tel]").val(response.type);
                $("#direccion-carrito").append(input_tipo_tel);
                enviar_formulario_direccion_carrito(dir, dir_fiscal);
            } else {
                $("#direcciones_load").hide(10);
                $("#telefono"+limpia).addClass("is-invalid-input").attr("aria-invalid", "true");
                $("#error-tel"+limpia).html(response.message).addClass("is-visible").css("margin-top", "0.1rem");
            }
        }
    });
}

function verificar_dos_telefonos(num_tel, fac_tel, dir, dir_fiscal){
    $.ajax({
        url: "registro-telefono-twilio-dos",
        data: {
            num_tel: num_tel,
            fac_tel : fac_tel
        },
        method: "GET",
        beforeSend: function () {
            $("#telefono_limpia").removeClass("is-invalid-input");
            $("#error-tel_limpia").removeClass("is-visible");
            $("#telefono").removeClass("is-invalid-input");
            $("#error-tel").removeClass("is-visible");
            $("#direcciones_load").show(10);
        },
        success: function (response) {
            response = $.parseJSON(response);
            if (response.tel.estatus && response.fac.estatus) {
                const input_tipo_tel = $("<input>").attr("type", "hidden").attr("name", "direccion[tipo_tel]").val(response.tel.type);
                $("#direccion-carrito").append(input_tipo_tel);
                enviar_formulario_direccion_carrito(dir, dir_fiscal);
            } else if(!response.tel.estatus && response.fac.estatus) {
                $("#direcciones_load").hide(10);
                $("#telefono").addClass("is-invalid-input").attr("aria-invalid", "true");
                $("#error-tel").html(response.message).addClass("is-visible").css("margin-top", "0.1rem");
            }else if(response.tel.estatus && !response.fac.estatus){
                $("#direcciones_load").hide(10);
                $("#telefono_limpia").addClass("is-invalid-input").attr("aria-invalid", "true");
                $("#error-tel_limpia").html(response.message).addClass("is-visible").css("margin-top", "0.1rem");
            }else if(!response.tel.estatus && !response.fac.estatus){
                $("#direcciones_load").hide(10);
                $("#telefono").addClass("is-invalid-input").attr("aria-invalid", "true");
                $("#error-tel").html(response.message).addClass("is-visible").css("margin-top", "0.1rem");
                $("#telefono_limpia").addClass("is-invalid-input").attr("aria-invalid", "true");
                $("#error-tel_limpia").html(response.message).addClass("is-visible").css("margin-top", "0.1rem");
            }
        }
    });
}

function enviar_formulario_direccion_carrito(dir, dir_fiscal) {
    $.ajax({
        url: "<?php echo ($nombre_tienda_slug) ? site_url('tienda/'.$nombre_tienda_slug.'/carrito/procesar-direccion') : site_url('carrito/procesar-direccion');?>",
        data: {
            direccion : JSON.stringify(dir),
            direccion_fiscal : JSON.stringify(dir_fiscal)
        },
        method: "POST",
        beforeSend: function () {
            $("#direcciones_load").show(10);
        },
        success: function (response) {
            response = JSON.parse(response);
            window.location.replace(response.url);
            $("#direcciones_load").hide(10);
        }
    });
}

let iti_dir_listado = null;
let validacion_dir_listado = false;
if($("#telefono_nuevo_reveal_carrito")){

    $("#telefono_nuevo_reveal_carrito").ready(function(){
        const input = document.querySelector("#telefono_nuevo_reveal_carrito");
        iti_dir_listado = window.intlTelInput(input, {
            onlyCountries: ['us', 'mx', 'ca'],
            preferredCountries: ['mx'],
            initialCountry: 'mx',
            separateDialCode: true,
            utilsScript: "assets/js/IntlTelInput/utils.js",
        });
    });
}

    $("#form-listado-dir").submit(function(event){
        event.preventDefault();
        validacion_dir_listado = ($("#form-listado-dir input.is-invalid-input").length > 0);
        if(!validacion_dir_listado) {
            const num_tel = iti_dir_listado.getNumber(intlTelInputUtils.numberFormat.E164);
            $.ajax({
                url: "registro-telefono-twilio",
                data: {
                    num_tel: num_tel
                },
                method: "GET",
                beforeSend: function () {
                    $("#telefono_nuevo_reveal_carrito").removeClass("is-invalid-input");
                    $("#error-listado-dir").removeClass("is-visible");
                    $("#direcciones_load").show(10);
                },
                success: function (response) {
                    response = $.parseJSON(response);
                    if (response.estatus) {
                        const input_tipo_tel = $("<input>").attr("type", "hidden").attr("name", "direccion[tipo_tel]").val(response.type);
                        $("#form-listado-dir").append(input_tipo_tel);
                        enviar_formulario_listado_dir(num_tel);
                        validacion_dir_listado = true;
                    } else {
                        $("#direcciones_load").hide(10);
                        $("#telefono_nuevo_reveal_carrito").addClass("is-invalid-input").attr("aria-invalid", "true");
                        $("#error-listado-dir").html(response.message).addClass("is-visible").css("margin-top", "0.1rem");
                        validacion_dir_listado = false;
                    }
                }
            });
        }
    });

function enviar_formulario_listado_dir(tipo_tel) {
    $.ajax({
        url: "<?php echo 'mi-cuenta/direcciones/agregar/pagar'.($nombre_tienda_slug ? '/'.$nombre_tienda_slug : '');?>",
        data: {
            identificador_direccion: $("#identificador_direccion_nuevo_reveal_carrito").val(),
            codigo_postal: $("#codigo_postal_nuevo_reveal_carrito").val(),
            ciudad: $("#ciudad_nuevo_reveal_carrito").val(),
            linea1: $("#linea1_nuevo_reveal_carrito").val(),
            linea2: $("#linea2_nuevo_reveal_carrito").val(),
            linea2_otro: $("#linea2_nuevo_reveal_carrito_otro").val(),
            estado: $("#estado_nuevo").val(),
            telefono: $("#telefono_nuevo_reveal_carrito").val(),
            tipo_telefono: tipo_tel,
            id_cliente: $("#id_cliente_nuevo_reveal_carrito").val()
        },
        method: "POST",
        success: function (response) {
            response = JSON.parse(response);
            window.location.replace(response.url);
        }
    });
}
<?php if(isset($tienda)):?>
    let iti_dir_listado_fac = null;
    let validacion_dir_listado_fac = false;

    $("#telefono_fiscal").ready(function(){
        const input = document.querySelector("#telefono_fiscal");
        iti_dir_listado_fac = window.intlTelInput(input, {
            onlyCountries: ['us', 'mx', 'ca'],
            preferredCountries: ['mx'],
            initialCountry: 'mx',
            separateDialCode: true,
            utilsScript: "assets/js/IntlTelInput/utils.js",
        });
    });

    $("#form-listado-fac").submit(function(event){
        event.preventDefault();
        validacion_dir_listado_fac = ($("#form-listado-fac input.is-invalid-input").length > 0);
        if(!validacion_dir_listado_fac) {
            const num_tel = iti_dir_listado_fac.getNumber(intlTelInputUtils.numberFormat.E164);
            $.ajax({
                url: "registro-telefono-twilio",
                data: {
                    num_tel: num_tel
                },
                method: "GET",
                beforeSend: function () {
                    $("#telefono_fiscal").removeClass("is-invalid-input");
                    $("#error_telefono_fiscal").removeClass("is-visible");
                    $("#direcciones_load").show(10);
                },
                success: function (response) {
                    response = $.parseJSON(response);
                    if (response.estatus) {
                        enviar_formulario_listado_fac(num_tel);
                        validacion_dir_listado_fac = true;
                    } else {
                        $("#direcciones_load").hide(10);
                        $("#telefono_fiscal").addClass("is-invalid-input").attr("aria-invalid", "true");
                        $("#error_telefono_fiscal").html(response.message).addClass("is-visible").css("margin-top", "0.1rem");
                        validacion_dir_listado_fac = false;
                    }
                }
            });
        }
    });
<?php endif;?>


function enviar_formulario_listado_fac(tipo_tel) {
    $.ajax({
        url: "<?php echo site_url('mi-cuenta/facturacion/agregar/pagar'.($nombre_tienda_slug ? '/'.$nombre_tienda_slug : '')); ?>",
        data: {
            razon_social: $("#razon_social").val(),
            rfc: $("#rfc").val(),
            ciudad: $("#ciudad_fiscal").val(),
            linea1: $("#linea1_fiscal").val(),
            linea2: $("#linea2_fiscal").val(),
            linea2_otro: $("#linea2_fiscal_otro").val(),
            codigo_postal: $("#codigo_postal_fiscal").val(),
            estado: $("#estado_fiscal").val(),
            telefono: $("#telefono_fiscal").val(),
            correo_electronico_facturacion: $("#correo_electronico_facturacion").val(),
            id_cliente: $("#id_cliente_fiscal").val()
        },
        method: "POST",
        success: function (response) {
            response = JSON.parse(response);
            window.location.replace(response.url);
        }
    });
}

/**DE AQUI PARA ABAJO YA SE PUEDE TOCAR**/

</script>
