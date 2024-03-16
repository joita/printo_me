<script>
// Marcas

$(document).on("click", ".enabled", function(e) {
	e.preventDefault();
	var nuevo_estatus = 0;
	var id_marca = $(this).parent().data("id_marca");
	$(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');
	
	$.post('<?php echo site_url('administracion/marcas/estatus'); ?>', { id_marca: id_marca, estatus: nuevo_estatus });
});

$(document).on("click", ".disabled", function(e) {
	e.preventDefault();
	var nuevo_estatus = 1;
	var id_marca = $(this).parent().data("id_marca");
	$(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');
	
	$.post('<?php echo site_url('administracion/marcas/estatus'); ?>', { id_marca: id_marca, estatus: nuevo_estatus });
});

$(".edit-main-cat").click(function() {
	var id_marca = $(this).parent().data("id_marca");
	var nombre_marca = $(this).parent().data("nombre_marca");
	$("#nombre_marca_mod").val(nombre_marca);
	$("#id_marca_mod").val(id_marca);
});

$(".delete-main-cat").click(function() {
	var id_marca = $(this).parent().data("id_marca");
	$("#id_marca_bor").val(id_marca);
});
</script>