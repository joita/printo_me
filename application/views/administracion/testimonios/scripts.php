<script src="<?php echo site_url('bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script>
$(document).ready(function() {
    $('#campanas').DataTable({
		columnDefs: [
			{ orderable: false, targets: [-1, 0] },
			{ searchable: false, targets: [-1, 0] }
		],
		"order": [[1, "desc"]],
		"language": {
			"url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
		},
		"pageLength": 10
	});
} );
</script>
