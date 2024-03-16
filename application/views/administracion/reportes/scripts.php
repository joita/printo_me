<script src="<?php echo site_url('bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script>
    $(document).ready(function() {
        $('#tabla_pagos').DataTable({
            columnDefs: [
                { orderable: false, targets: [-1] },
                { searchable: true, targets: [0] }
            ],
            "order": [[1, "desc"]],
            "language": {
                "url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
            },
            ajax: {
                url: "<?php echo site_url('administracion/reportes/desplegar_pagos_data'); ?>",
                type: "POST",
                "data": function ( d ) {
                    d.fecha_inicio = $("#fecha_inicio").val();
                    d.fecha_final = $("#fecha_final").val();
                    d.metodo_pago = $("#metodo_de_pago").val();
                    d.tipo_campana = $("#tipo_campana").val();
                }
            },
            "columns": [
                { "data": "email" },
                { "data": "fecha_pago" },
                { "data": "monto" },
                { "data": "metodo_pago" },
                { "data": "comprobante" }
            ],
            "processing": true,
            "serverSide": true
        });
    } );
</script>