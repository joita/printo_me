<script>
// Categorias
$(document).on("click", ".expand", function(e) {
	e.preventDefault();
	var id = $(this).parent().data("id");
	$(".divisor-sub[data-id_parent='"+id+"']").slideDown(150);
	$(this).removeClass("expand").addClass("implode").html('<i class="fa fa-minus-square-o"></i> Ocultar subcaracteristicas</i>');
});

$(document).on("click", ".implode", function(e) {
	e.preventDefault();
	var id = $(this).parent().data("id");
	$(".divisor-sub[data-id_parent='"+id+"']").slideUp(150);
	$(this).removeClass("implode").addClass("expand").html('<i class="fa fa-plus-square-o"></i> Mostrar subcaracteristicas</i>');
});

$(document).on("click", ".enabled", function() {
	var nuevo_estatus = 0;
	var id = $(this).parent().data("id");
	var id_parent = $(this).parent().data("id_parent");
	$(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');
	
	$(".divisor-sub[data-id_parent='"+id+"'] .enabled").removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');
	
	$.post('<?php echo site_url('administracion/'.$class.'/estatus'); ?>', { id: id, id_parent: id_parent, estatus: nuevo_estatus });
});

$(document).on("click", ".disabled", function() {
	var nuevo_estatus = 1;
	var id = $(this).parent().data("id");
	var id_parent = $(this).parent().data("id_parent");
	$(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');
	
	$(".divisor-sub[data-id_parent='"+id+"'] .disabled").removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');
	
	$.post('<?php echo site_url('administracion/'.$class.'/estatus'); ?>', { id: id, id_parent: id_parent, estatus: nuevo_estatus });
});

$("a.editar").click(function() {
	var id = $(this).parent().data("id");
	var nombre = $(this).parent().data("nombre");
	var id_tipo = $(this).parent().data("id_tipo");
	$('.form_edit select[name="id_tipo"] option[value="'+id_tipo+'"]').prop('selected', true);
	$(".form_edit #nombre").val(nombre);
	$(".form_edit #id").val(id);
});

$(".nuevasub").click(function() {
	var id_parent = $(this).data("id_parent");
	var id_tipo = $(this).data("id_tipo");
	$(".form_new_sub #id_parent").val(id_parent);
	$(".form_new_sub #id_tipo").val(id_tipo);
});

$(".edit-sub").click(function() {
	var id = $(this).parent().data("id");
	var nombre = $(this).parent().data("nombre");
	$(".form_edit_sub #nombre").val(nombre);
	$(".form_edit_sub #id").val(id);
});

$(".delete").click(function() {
	var id = $(this).parent().data("id");
	$(".form_borrar #id").val(id);
});

$(".delete-sub").click(function() {
	var id = $(this).parent().data("id");
	$(".form_borrar_sub #id").val(id);
});
</script>