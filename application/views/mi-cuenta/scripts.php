<script src="<?php echo site_url('bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/datatables.net-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/datatables.net-select/js/dataTables.select.min.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/datatables.net-buttons/js/buttons.flash.min.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/datatables.net-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/datatables.net-buttons/js/buttons.print.min.js'); ?>"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.foundation.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.2/js/responsive.foundation.min.js"></script>
<script>
    /*
    function timer() {
        $(".timer").each(function () {
            var tiempo = $(this).data("countdown");
            var fecha = moment.tz(tiempo, 'America/Merida');

            $(this).countdown(fecha.toDate(), function (event) {
                $(this).html(event.strftime('<span class="f"><span class="d_digit">%-D</span><span class="d_text">días</span></span><span class="f"><span class="d_digit">%-H</span><span class="d_text">hrs</span></span><span class="f"><span class="d_digit">%-M</span><span class="d_text">min</span></span><span class="f"><span class="d_digit">%-S</span><span class="d_text">seg</span></span>'));
            });
        });
    }
    function timer_corto()
    {
        $(".timer-corto").each(function () {
            var tiempo = $(this).data("countdown");
            var fecha = moment.tz(tiempo, 'America/Merida');

            $(this).countdown(fecha.toDate(), function (event) {
                $(this).html(event.strftime('<span class="quedan">Quedan</span> <span class="f">%-D</span> <span class="quedan">días</span>'));
            });
        });
    }
*/

$(document).ready(function () {
    $("form.pedido input").click(function() {
        var id_pedido = $(this).data("pedido-id");
        if ($(this).is(":checked")) {
            $("button[data-pedido-id=" + id_pedido + "]").prop("disabled", false);
        } else {
            var something_is_checked = false;
            $("input[data-pedido-id=" + id_pedido + "]").each( function  (index, val) {
                console.log(this);
                if($(this).is(":checked")) {
                    something_is_checked = true;
                }
            });
            if (!something_is_checked) {
                $("button[data-pedido-id=" + id_pedido + "]").prop("disabled", true);
            }
        }
    });
    var url = "";
    if($("input#tipo").val() == 'fijo'){
        url = base_url + 'mi-cuenta/obtener-inmediata';
    }else if($("input#tipo").val() == 'limitado'){
        url = base_url + 'mi-cuenta/obtener-limitada';
    }
    var table = $("table#datos").addClass( 'nowrap' ).
    on( 'init.dt', function () {
        $("div#datos_length").parent().removeClass('small-6');
        $("div#datos_length").parent().addClass('small-5 medium-4 large-3');
        $("div#datos_filter").parent().removeClass('small-6');
        $("div#datos_filter").parent().addClass('small-push-5 medium-push-7 large-push-10 small small-8 medium-7 large-5 ');
    }).DataTable({
        responsive: {
            details: {
                type: 'column',
                renderer: function ( api, rowIdx, columns ) {
                    var data = $.map( columns, function ( col, i ) {
                        if(col.hidden) {
                            if (col.title != 'Imagen' && col.title != 'Avance') {
                                return '<div class="row collapse contenedor-detalles">' +
                                    '<div class="small-7 columns escondido-titulo"><h5>' + col.title + ':</h5></div>' +
                                    '   <div class="small-11 columns escondido" >' + col.data + '</div>' +
                                    '</div>';
                            } else if(col.title == 'Avance') {
                                return '<div class="row collapse contenedor-detalles">' +
                                    '   <div class="small-18 columns escondido" >' + col.data + '</div>' +
                                    '</div>';
                            }else{
                                return '<div class="row collapse contenedor-detalles-imagen">' +
                                    '   <div class="small-18 columns escondido" >' + col.data + '</div>' +
                                    '</div>';
                            }
                        }else {
                            return '';
                        }
                    } ).join('');

                    return data;
                }
            }
        },
        columnDefs: [
            { orderable: false, targets: [0, 1, -1] },
            { className: 'control', orderable: false, targets: 0 },
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 2 },
            { responsivePriority: 3, targets: 3 },
            { responsivePriority: 4, targets: 4 },
            { responsivePriority: 5, targets: 5 },
            { responsivePriority: 6, targets: 6 },
            { responsivePriority: 7, targets: -1 },
            { responsivePriority: 10000, targets: 1 }
        ],

        ajax: {
            url: url,
            type: "POST"
        },
        "columns": [
            { "data": "despliegue" },
            { "data": "imagen" },
            { "data": "campana" },
            { "data": "precio_total" },
            { "data": "ganancia" },
            { "data": "vendidos" },
            { "data": "total_ganancia" },
            { "data": "avance" }
        ],
        "processing": true,
        "serverSide": true,
        "language": {
            "url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
        }
    });

    //tabla de referencias
    $("table#referencias").DataTable({
        columnDefs: [
            { orderable: true }
        ],
        "order" : [0, 'desc'],
        "searching": false,
        ajax: {
            url: base_url + 'mi-cuenta/obtener-referencias-cliente',
            type: "POST"
        },
        "columns": [
            { "data": "fecha" },
            { "data": "experiencia" },
            { "data": "puntos" }
        ],
        "processing": true,
        "serverSide": true,
        "language": {
            "url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
        }
    });









});

</script>