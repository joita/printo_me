<script src="<?php echo site_url('bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/datatables.net-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/datatables.net-select/js/dataTables.select.min.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/datatables.net-buttons/js/buttons.flash.min.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="<?php echo site_url('bower_components/datatables.net-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/datatables.net-buttons/js/buttons.print.min.js'); ?>"></script>
<script>
    $(document).ready(function() {
        $('#campanas').DataTable({
            columnDefs: [
                {orderable: false, targets: [2]}
            ],
            "order": [[3, "desc"]],
            "language": {
                "url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
            },
            ajax: {
                url: "<?php echo site_url('administracion/puntos/desplegar_referencias'); ?>",
                type: "POST"
            },
            "columns": [
                { "data": "id" },
                { "data": "nombre" },
                { "data": "cupon" },
                { "data": "experiencia" },
                { "data": "puntos" },
                { "data": "nivel" }
            ],
            "processing": true,
            "serverSide": true
        });
    });
</script>