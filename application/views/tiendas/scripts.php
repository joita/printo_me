<script>
    $(document).ready(function () {
        $(".cont_option input").click(function() {
            var orden = $(this).val();
            var search = $('#search-open').val();
            var vip = $('.valor-vip').val();
            location.href =<?php site_url() ?>'/tiendas/'+vip+'/'+orden+'/'+search;
        });

        $(".btn-vip").click(function() {
            var orden = $("#valororden").val();
            var search = $('#search-open').val();
            $('.valor-vip').val('1');
            location.href =<?php site_url() ?>'/tiendas/1/'+orden+'/'+search;
        });

        $('.input_search').keypress(function(e) {
            if (e.charCode == 13) {
                var orden = $("#valororden").val();
                var search = $(this).val();
                var vip = $('.valor-vip').val();
                location.href = <?php site_url() ?>'/tiendas/' + vip + '/' + orden + '/' + search;
            }
        });
        /* $(".cont_option input").click(function() {

             var orden = $(this).val();
             var search = $('#search-open').val();

             console.log(orden);

             $.ajax({
                 url:
                 type: "post", // podría ser get, post, put o delete.
                 data: {id_orden: orden,search:search}, // datos a pasar al servidor, en caso de necesitarlo
                 dataType: 'JSON',
                 beforeSend: function() {
                 },
                 success: function ($data) {

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
 */
    });

</script>