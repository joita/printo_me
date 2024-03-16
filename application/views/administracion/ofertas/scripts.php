<script>
$(document).on("click", ".enabled", function() {
	var nuevo_estatus = 0;
	var id_oferta = $(this).parent().data("id_oferta");
	$(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');
	
	$.post('<?php echo site_url('administracion/ofertas/estatus'); ?>', { id_oferta: id_oferta, estatus: nuevo_estatus });
});

$(document).on("click", ".disabled", function() {
	var nuevo_estatus = 1;
	var id_oferta = $(this).parent().data("id_oferta");
	$(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');
	
	$.post('<?php echo site_url('administracion/ofertas/estatus'); ?>', { id_oferta: id_oferta, estatus: nuevo_estatus });
});

$(".delete-sub-cat").click(function() {
	var id_oferta = $(this).parent().data("id_oferta");
	$("#id_oferta_bor").val(id_oferta);
});

$(".edit-sub-cat").click(function() {
	var id_oferta = $(this).parent().data("id_oferta");
	var imagen_oferta = $(this).parent().data("imagen_oferta");
	var url_slide = $(this).parent().data("url_slide");
	
	$("#img_mod").attr("src", imagen_oferta);
	$("#id_oferta_mod").val(id_oferta);
	$("#url_slide_mod").val(url_slide);
});
</script>