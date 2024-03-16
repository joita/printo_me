<script>
$(document).on("click", ".enabled", function() {
	var nuevo_estatus = 0;
	var id_slide = $(this).parent().data("id_slide");
	$(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');
	
	$.post('<?php echo site_url('administracion/sliders/estatus'); ?>', { id_slide: id_slide, estatus: nuevo_estatus });
});

$(document).on("click", ".disabled", function() {
	var nuevo_estatus = 1;
	var id_slide = $(this).parent().data("id_slide");
	$(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');
	
	$.post('<?php echo site_url('administracion/sliders/estatus'); ?>', { id_slide: id_slide, estatus: nuevo_estatus });
});

$(".delete-sub-cat").click(function() {
	var id_slide = $(this).parent().data("id_slide");
	$("#id_slide_bor").val(id_slide);
});

$(".edit-sub-cat").click(function() {
	var id_slide = $(this).parent().data("id_slide");
	var imagen_slide = $(this).parent().data("imagen_slide");
	var url_slide = $(this).parent().data("url_slide");
	
	$("#img_mod").attr("src", imagen_slide);
	$("#id_slide_mod").val(id_slide);
	$("#url_slide_mod").val(url_slide);
});
</script>