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
	
	$("#id_tipo_mod").val(id_tipo);
	$("#nombre_tipo_mod").val(nombre_tipo);
	
	var html = '';
	$.each(caracteristicas_tipo, function(indice, caracteristica) {
		
		
		var opciones = caracteristica.opciones.join(", ");
		
		html += '<div class="row caracteristica">'+
					'<div class="small-12 small-centered columns">'+
						'<label>Característica'+
							'<input type="text" name="tipo[caracteristicas]['+indice+']" id="caracteristicas_mod_'+indice+'" value="'+caracteristica.titulo+'" readonly />'+
						'</label>'+
					'</div>'+
				'</div>'+
				'<div class="row">'+
					'<div class="small-24 columns">'+
						'<label>Valores (Separados por ,)'+
							'<input type="text" name="tipo[valores]['+indice+']" id="valores_add_'+indice+'" value="'+opciones+'" required />'+
						'</label>'+
						'<small class="error">Obligatorio.</small>'+
					'</div>'+
				'</div>';
		$("#cars_mod").html(html);
	});
		
});
</script>