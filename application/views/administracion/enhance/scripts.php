<script src="<?php echo site_url('bower_components/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script>
$(document).ready(function() {
    $('#campanas').DataTable({
		columnDefs: [
		   { orderable: false, targets: [-1] }
		],
		"order": [[0, "desc"]],
		"language": {
			"url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
		},
		initComplete: function () {
            this.api().columns(7).every( function () {
                var column = this;
                var select = $('<select class="filterer"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
	});

    $('#limitados').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url: '<?php echo site_url('administracion/campanas/obtener_campanas/limitado/'.$estatus_activo); ?>',
            type: 'POST'
        },
        "columns": [
            { "data": "imagenes" },
            { "data": "datos_generales" },
            { "data": "precio" },
            { "data": "vendidos" },
            { "data": "meta" },
            { "data": "porcentaje" },
            { "data": "estatus" },
            { "data": "acciones" }
        ],
		columnDefs: [
		   { orderable: false, targets: [-1, 3, 4, 5] }
		],
		"lengthMenu": [ [10, 25, 50, 100], [10, 25, 50, 100] ],
		"pageLength": 25,
		"order": [[0, "desc"]],
		"language": {
			"url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
		}
	});

    $('#fijos').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url: '<?php echo site_url('administracion/campanas/obtener_campanas/fijo/'.$estatus_activo); ?>',
            type: 'POST'
        },
        "columns": [
            { "data": "imagenes" },
            { "data": "datos_generales" },
            { "data": "precio" },
            { "data": "vendidos" },
            { "data": "estatus" },
            { "data": "acciones" }
        ],
		columnDefs: [
		   { orderable: false, targets: [-1, 4] }
		],
		"lengthMenu": [ [10, 25, 50, 100], [10, 25, 50, 100] ],
		"pageLength": 25,
		"order": [[0, "desc"]],
		"language": {
			"url": "<?php echo site_url('assets/js/Spanish.json'); ?>"
		}
	});

	$("#table-filter-limitado a").click(function() {
		var filtro = $(this).data("filtro");
		$("#table-filter-limitado a").parent().removeClass("active");
		$(this).parent().addClass("active");
		$(".filterer").val(filtro).trigger("change");
	});
} );

// Marcas

$(document).on("click", ".enabled", function(e) {
	e.preventDefault();
	var nuevo_estatus = 0;
	var id_enhance = $(this).parent().data("id_enhance");
	$(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');

	$.post('<?php echo site_url('administracion/enhance/estatus'); ?>', { id_enhance: id_enhance, estatus: nuevo_estatus });
});

$(document).on("click", ".disabled", function(e) {
	e.preventDefault();
	var nuevo_estatus = 1;
	var id_enhance = $(this).parent().data("id_enhance");
	$(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');

	$.post('<?php echo site_url('administracion/enhance/estatus'); ?>', { id_enhance: id_enhance, estatus: nuevo_estatus });
});

$(".edit-main-cat").click(function() {
	var id_enhance = $(this).parent().data("id_enhance");
	var name = $(this).parent().data("name");
	$("#name").html(name);

	var price = $(this).parent().data("price");
	$("#price").html(price);

	var date = $(this).parent().data("date");
	$("#date").html(date);

	var email = $(this).parent().data("email");
	$("#email").html(email);

	var images = $(this).parent().data("design");

	$("#front_image>.images").html('');
	$("#back_image>.images").html('');
	$("#left_image>.images").html('');
	$("#right_image>.images").html('');

	var front_image = $(this).parent().data("front_image");
	if(front_image != "<?php echo base_url(); ?>") $("#front_image>img").attr("src", front_image);
	$.each(images.front, function(i, imagen) {
		var html = '<div class="row"><div class="small-5 columns text-right"><img src="'+imagen+'" style="height:50px;"></div><div class="small-19 columns"><a href="'+imagen+'" target="_blank" style="line-height:20px;display:inline-block;margin:15px 0;">Descargar</a></div></div>';
		$("#front_image>.images").append(html);
	});

	var back_image = $(this).parent().data("back_image");
	if(back_image != "<?php echo base_url(); ?>") $("#back_image>img").attr("src", back_image);
	$.each(images.back, function(i, imagen) {
		var html = '<div class="row"><div class="small-5 columns text-right"><img src="'+imagen+'" style="height:50px;"></div><div class="small-19 columns"><a href="'+imagen+'" target="_blank" style="line-height:20px;display:inline-block;margin:15px 0;">Descargar</a></div></div>';
		$("#back_image>.images").append(html);
	});

	var left_image = $(this).parent().data("left_image");
	if(left_image != "<?php echo base_url(); ?>") $("#left_image>img").attr("src", left_image);
	$.each(images.left, function(i, imagen) {
		var html = '<div class="row"><div class="small-5 columns text-right"><img src="'+imagen+'" style="height:50px;"></div><div class="small-19 columns"><a href="'+imagen+'" target="_blank" style="line-height:20px;display:inline-block;margin:15px 0;">Descargar</a></div></div>';
		$("#left_image>.images").append(html);
	});

	var right_image = $(this).parent().data("right_image");
	if(right_image != "<?php echo base_url(); ?>") $("#right_image>img").attr("src", right_image);
	$.each(images.right, function(i, imagen) {
		var html = '<div class="row"><div class="small-5 columns text-right"><img src="'+imagen+'" style="height:50px;"></div><div class="small-19 columns"><a href="'+imagen+'" target="_blank" style="line-height:20px;display:inline-block;margin:15px 0;">Descargar</a></div></div>';
		$("#right_image>.images").append(html);
	});

	$("#id_enhance_mod").val(id_enhance);

});

$(".pagador").click(function() {
	var boton = $(this);

	var id_corte = boton.data("id_corte");
	var monto_corte = boton.data("monto_corte");

	$("#id_corte_fijo_reveal").val(id_corte);
	$("#monto_corte_fijo_reveal").val(monto_corte);
});

$(".delete-main-cat").click(function() {
	var id_enhance = $(this).parent().data("id_enhance");
	$("#id_enhance_bor").val(id_enhance);
});

$("#campana_etiquetas").tagsInput({
    defaultText: 'Etiquetas descriptivas',
    width:'100%',
    height: '82px'
});
</script>
