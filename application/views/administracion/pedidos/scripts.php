<script src="<?php echo site_url('bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script>
$(document).ready(function() {
    $('#campanas').DataTable({
		columnDefs: [
			{ orderable: false, targets: [-1, 1, 7, 8, 9] },
			{ searchable: false, targets: [-1] }
		],
		"order": [[0, "desc"]],
		"language": {
			"url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
		},
        ajax: {
            url: "<?php echo site_url('administracion/pedidos/desplegar-pedidos'); ?>",
            type: "POST"
        },
        "columns": [
            { "data": "num_pedido" },
            { "data": "estatus" },
            { "data": "clientes" },
            { "data": "fecha" },
            { "data": "items_totales" },
            { "data": "total_pago" },
            { "data": "metodo_pago" },
            { "data": "pago" },
            { "data": "envio" },
            { "data": "factura" },
            { "data": "boton" }
        ],
        "processing": true,
        "serverSide": true
	});
} );
</script>
