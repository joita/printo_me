<script>
    $(function() {
        $('#rating-testimonio').barrating({
            theme: 'fontawesome-stars'
        });
    });
    $('select#rating-testimonio').change(function(){
        var elegido = $(this).children(":selected").html();
        var idcalif = $('input#idcalif').val();
        var califanterior = $('input#califanterior').val();
        $.ajax({
            url: "<?php echo site_url('administracion/respuestas/cambiarcalificacion') ;?>",
            data: { "elegido": elegido, "id_calificacion": idcalif , "califanterior": califanterior},
            type: "post",
            success: function(){
                window.location.reload();
            }
        });
    });
</script>
