<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.8.4/Sortable.min.js"></script>
<script>
// Categorias

$(document).on('click', '#new_caracteristica', function() {
	var id = $(this).data('id_tipo');
	$('.form_new input[name="id_tipo"]').val(id);
});

$(document).on("click", ".expand_1", function(e) {
	e.preventDefault();
	var id = $(this).parent().data("id_tipo");
	$(".list-caracteristica[data-id_parent='"+id+"']").slideDown(150);
	$(this).removeClass("expand_1").addClass("implode_1").html('<i class="fa fa-minus-square-o"></i> Ocultar características</i>');
});

$(document).on("click", ".implode_1", function(e) {
	e.preventDefault();
	var id = $(this).parent().data("id_tipo");
	$(".list-caracteristica[data-id_parent='"+id+"']").slideUp(150);
	$(this).removeClass("implode_1").addClass("expand_1").html('<i class="fa fa-plus-square-o"></i> Mostrar características</i>');
});

$(document).on("click", ".expand", function(e) {
	e.preventDefault();
	var id = $(this).parent().data("id");
	$(".list-subcaracteristica[data-id_parent='"+id+"']").slideDown(150);
	$(this).removeClass("expand").addClass("implode").html('<i class="fa fa-minus-square-o"></i> Ocultar valores</i>');
});

$(document).on("click", ".implode", function(e) {
	e.preventDefault();
	var id = $(this).parent().data("id");
	$(".list-subcaracteristica[data-id_parent='"+id+"']").slideUp(150);
	$(this).removeClass("implode").addClass("expand").html('<i class="fa fa-plus-square-o"></i> Mostrar valores</i>');
});

$(document).on("click", ".enabled", function() {
	var nuevo_estatus = 0;
	var id = $(this).parent().data("id");
	var id_parent = $(this).parent().data("id_parent");
	$(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');
	
	$(".divisor-sub[data-id_parent='"+id+"'] .enabled").removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');
	
	$.post('<?php echo site_url('administracion/'.$class_2.'/estatus'); ?>', { id: id, id_parent: id_parent, estatus: nuevo_estatus });
});

$(document).on("click", ".disabled", function() {
	var nuevo_estatus = 1;
	var id = $(this).parent().data("id");
	var id_parent = $(this).parent().data("id_parent");
	$(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');
	
	$(".divisor-sub[data-id_parent='"+id+"'] .disabled").removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');
	
	$.post('<?php echo site_url('administracion/'.$class_2.'/estatus'); ?>', { id: id, id_parent: id_parent, estatus: nuevo_estatus });
});

$("a.editar").click(function() {
	var id = $(this).parent().data("id");
	var nombre = $(this).parent().data("nombre");
	var id_tipo = $(this).parent().data("id_tipo");
	//$('.form_edit input[name="id_tipo"]').val(id_tipo);
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
<script>
// Categorias
$(document).on("click", ".add_tipo", function() {
	var numero = $(".row.caracteristica").length;
	
	var html = '<div class="row caracteristica">'+
		'<div class="small-8 columns">'+
			'<label>Característica'+
				'<input type="text" name="tipo[caracteristicas]['+numero+']" id="caracteristicas_add_'+numero+'" required />'+
			'</label>'+
			'<small class="error">Obligatorio.</small>'+
		'</div>'+
		'<div class="small-12 columns">'+
			'<label>Posibles valores (Separados por ,)'+
				'<input type="text" name="tipo[valores]['+numero+']" id="valores_add_'+numero+'" required />'+
			'</label>'+
			'<small class="error">Obligatorio.</small>'+
		'</div>'+
		'<div class="small-2 columns">'+
			'<label>&nbsp;'+
				'<button type="button" class="remove_tipo warning"><i class="fa fa-times-circle"></i></button>'+
			'</label>'+
		'</div>'+
		'<div class="small-2 columns">'+
			'<label>&nbsp;'+
				'<button type="button" class="add_tipo success"><i class="fa fa-plus-circle"></i></button>'+
			'</label>'+
		'</div>'+
	'</div>';
	
	$("#cars").append(html);
});

$(document).on("click", ".add_lado", function() {
    var numero = $(".row.lados").length;

    var html = '<div class="row lados">'+
        '<div class="small-20 columns">'+
            '<label>Nombre Lado'+
                '<input type="text" name="tipo[lados]['+numero+']" id="lados_add_'+numero+'" required />'+
            '</label>'+
            '<small class="error">Obligatorio.</small>'+
        '</div>'+
        '<div class="small-2 columns">'+
            '<label>&nbsp;'+
                '<button type="button" class="remove_lado warning"><i class="fa fa-times-circle"></i></button>'+
            '</label>'+
        '</div>'+
        '<div class="small-2 columns">'+
            '<label>&nbsp;'+
                '<button type="button" class="add_lado success"><i class="fa fa-plus-circle"></i></button>'+
            '</label>'+
        '</div>'+
    '</div>';

    $("#lds").append(html);
});

$(document).on("click", ".remove_lado", function() {
    $(this).closest(".row.lados").remove();
});

$(document).on("click", ".remove_tipo", function() {
	$(this).closest(".row.caracteristica").remove();
});

$(".delete-main-cat").click(function() {
	$("#id_tipo_bor").val($(this).parent().data("id_tipo"));
});

$(".edit-main-cat").click(function() {
	var id_tipo = $(this).parent().data("id_tipo");
	var nombre_tipo = $(this).parent().data("nombre_tipo");
	var caracteristicas_tipo = $(this).parent().data("caracteristicas_tipo");
	const lados_tipo = $(this).parent().data("lados");
	
	$("#id_tipo_mod").val(id_tipo);
	$("#nombre_tipo_mod").val(nombre_tipo);
	
	var html = '';
	let html_lado = '';

	$.each(caracteristicas_tipo, function(indice, caracteristica) {
		
		var opciones = caracteristica.opciones.join(", ");
		
		html += '<div class="row caracteristica">'+
					'<hr>'+
					'<div class="small-8 columns">'+
						'<label>Característica'+
							'<input type="text" name="tipo[caracteristicas]['+indice+']" id="caracteristicas_mod_'+indice+'" value="'+caracteristica.titulo+'" readonly />'+
						'</label>'+
					'</div>'+
					'<div class="small-16 columns">'+
						'<label>Valores (Separados por ,)'+
							'<input type="text" name="tipo[valores]['+indice+']" id="valores_add_'+indice+'" value="'+opciones+'" required />'+
						'</label>'+
						'<small class="error">Obligatorio.</small>'+
					'</div>'+
				'</div>';
		$("#cars_mod").html(html);
	});

    $("#cars_mod").append("<hr>");

	$.each(lados_tipo, function(indice, lado){
        html_lado += '<div id="lado_item" class="list-group-item row lado_tipo'+id_tipo+'" data-equalizer data-id_lado="'+lado.id_lado+'" data-orden="'+lado.orden+'">'+
                '<div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>'+
                    '<i class="fa fa-arrows "></i>'+
                '</div>' +
                '<div class="small-22 columns" data-equalizer-watch>' +
                    '<label>Nombre Lado '+ (parseInt(lado.orden) + 1) +
                        '<input type="text" name="tipo[lados]['+indice+']" id="lados_add_'+indice+'" value="'+lado.nombre_lado+'" required />'+
                    '</label>'+
                    '<small class="error">Obligatorio.</small>'+
                '</div>'+
            '</div>';
        $("#lds_mod").html(html_lado);
    });

    if($("#lds_mod").length > 0) {
        const sortLados = document.getElementById("lds_mod");
        let ids_lados = [];
        Sortable.create(sortLados, {
            animation: 150,
            dataIdAttr: "data-id_lado",
            store: {
                get: function (sortable) {
                    var order_lados = localStorage.getItem(sortable.options.group);
                    return order_lados ? order.split("|") : [];
                },
                set: function (sortable) {
                    ids_lados = sortable.toArray();
                    var base_url = "<?php echo base_url()?>";
                    $.post(base_url+"administracion/tipos/reordenar_lados/"+id_tipo, {
                        data: ids_lados
                    });
                }
            }
        });
    }
		
});
</script>