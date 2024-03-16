<script>
    $('#btn-ahora').click(function() {
        var clasificacion = $(".clasificacion").val();
        var subclasificacion = $(".subclasificacion").val();
        var subsubclasificacion = $(".subsubclasificacion").val();
        var search = $("#search-oculto").val();
        if(search === ''){
            search = 'null';
        }
        if (typeof subsubclasificacion === 'undefined'){
            subsubclasificacion = 'null';
        }

        location.href = <?php site_url() ?>'/plantillas/' + search + '/' + clasificacion + '/' + subclasificacion + '/' + subsubclasificacion;
    });
    $('.input_search').keypress(function(e) {
        if (e.charCode == 13) {
            var clasificacion = $(".clasificacion").val();
            var subclasificacion = $(".subclasificacion").val();
            var subsubclasificacion = $(".subsubclasificacion").val();
            var search = $(this).val();
            if(search === ''){
                search = 'null';
            }
            if (typeof subsubclasificacion === 'undefined'){
                subsubclasificacion = 'null';
            }

                location.href = <?php site_url() ?>'/plantillas/' + search + '/' + clasificacion + '/' + subclasificacion + '/' + subsubclasificacion;
        }
    });
</script>