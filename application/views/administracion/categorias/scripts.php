<script>
// Categorias
$(document).on("click", ".expand", function(e) {
	e.preventDefault();
	var id_categoria = $(this).parent().data("id_categoria");
	$(".divisor-subcategorias[data-id_parent='"+id_categoria+"']").slideDown(150);
	$(this).removeClass("expand").addClass("implode").html('<i class="fa fa-minus-square-o"></i> Ocultar subcategorías</i>');
});

$(document).on("click", ".implode", function(e) {
	e.preventDefault();
	var id_categoria = $(this).parent().data("id_categoria");
	$(".divisor-subcategorias[data-id_parent='"+id_categoria+"']").slideUp(150);
	$(this).removeClass("implode").addClass("expand").html('<i class="fa fa-plus-square-o"></i> Mostrar subcategorías</i>');
});

$(document).on("click", ".enabled", function() {
	var nuevo_estatus = 0;
	var id_categoria = $(this).parent().data("id_categoria");
	var id_categoria_parent = $(this).parent().data("id_categoria_parent");
	$(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');
	
	$(".divisor-subcategorias[data-id_parent='"+id_categoria+"'] .enabled").removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');
	
	$.post('<?php echo site_url('administracion/categorias/estatus'); ?>', { id_categoria: id_categoria, id_categoria_parent: id_categoria_parent, estatus: nuevo_estatus });
});

$(document).on("click", ".disabled", function() {
	var nuevo_estatus = 1;
	var id_categoria = $(this).parent().data("id_categoria");
	var id_categoria_parent = $(this).parent().data("id_categoria_parent");
	$(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');
	
	$(".divisor-subcategorias[data-id_parent='"+id_categoria+"'] .disabled").removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');
	
	$.post('<?php echo site_url('administracion/categorias/estatus'); ?>', { id_categoria: id_categoria, id_categoria_parent: id_categoria_parent, estatus: nuevo_estatus });
});

$(".edit-main-cat").click(function() {
	var id_categoria = $(this).parent().data("id_categoria");
	var nombre_categoria = $(this).parent().data("nombre_categoria");
	$("#nombre_categoria_mod").val(nombre_categoria);
	$("#id_categoria_mod").val(id_categoria);
});

$(".nuevasub").click(function() {
	var id_categoria_parent = $(this).data("id_categoria_parent");
	$("#id_categoria_parent_add").val(id_categoria_parent);
});

$(".edit-sub-cat").click(function() {
	var id_categoria = $(this).parent().data("id_categoria");
	var nombre_categoria = $(this).parent().data("nombre_categoria");
	$("#nombre_subcategoria_mod").val(nombre_categoria);
	$("#id_subcategoria_mod").val(id_categoria);
});

$(".delete-main-cat").click(function() {
	var id_categoria = $(this).parent().data("id_categoria");
	$("#id_categoria_bor").val(id_categoria);
});

$(".delete-sub-cat").click(function() {
	var id_categoria = $(this).parent().data("id_categoria");
	$("#id_subcategoria_bor").val(id_categoria);
});
</script>