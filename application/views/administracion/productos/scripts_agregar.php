<script>
// Productos

$(document).on("change load", "#tipo_producto_add", function() {
	var id = $("#tipo_producto_add option:selected").data("id_tipo");
	$.post("<?php echo site_url('administracion/'.$class.'/ajax-caracteristicas');?>", { id : id }, function(result) {
		$(".recargar_ajax#cara_adicionales").html(result.data);
	}, 'json');
});

var sku_base = '';

$(document).on("change input keyup keydown paste", "#modelo_producto", function() {
	sku_base = $(this).val();
	
	$.each($(".sku_final"), function(ciclo) {
		var i = $(this).data("i");
		var j = $(this).data("j");
		
		var specs = '';
		$.each($(this).closest(".row.item_info[data-i='"+i+"'][data-j='"+j+"']").find(".specs_select option:selected"), function(contador, item) {
			specs += $(this).val();
		});
		
		$(this).val(crear_sku(sku_base, specs, $(".nombre_color[data-i='"+i+"']").val()));
	});
});

/*$(document).on("change input keyup keydown paste", "#precio_producto", function() {
	sku_base = $(this).val();
	$.each($(".sku_final"), function(ciclo) {
		var i = $(this).data("i");
		var j = $(this).data("j");
		$.each($(this).closest(".row.item_info[data-i='"+i+"'][data-j='"+j+"']").find(".specs_select option:selected"), function(contador, item) {
			$("input[name='producto["+i+"][precio]["+j+"]']").val(sku_base);
		});
		//$(this).val(crear_sku(sku_base, specs, $(".nombre_color[data-i='"+i+"']").val()));
	});
});*/

$(document).on("change input keyup keydown paste", ".nombre_color", function() {
	var i = $(this).data("i");
	var nombre_color = $(this).val();
	
	$.each($(".sku_final[data-i='"+i+"']"), function(ciclo) {
		var j = $(this).data("j");
		
		var specs = '';
		$.each($(this).closest(".row.item_info[data-i='"+i+"'][data-j='"+j+"']").find(".specs_select option:selected"), function(contador, item) {
			specs += $(this).val();
		});
		
		$(this).val(crear_sku(sku_base, specs, $(".nombre_color[data-i='"+i+"']").val()));
	});
});

function crear_sku(base, talla, color) {
	return base+talla+color;
}
				
var html_input = '';
var tipo = '';

$("#tipo_producto_add").change(function() {
	
	if($(this).val() != '') {
		// Saca la información del tipo de producto
		// y lo convierte en array JSON
		tipo = $("#tipo_producto_add option:selected").text();
		var data = $.parseJSON($(this).val());
		
		// Crea el html para agregar fotos y SKUs
		html_input = '<fieldset><legend>SKUs</legend><div class="row item_info" data-i="0" data-j="0">';
		
		$.each(data, function(i, item) {
			html_input += ''+
				'<div class="small-4 columns end">'+
					'<label>'+item.titulo+
						'<select name="producto[0][caracteristicas]['+i+'][0]" class="specs_select" required>'+
							'<option value=""></option>';
						$.each(item.opciones, function(j, jtem) {
							html_input += '<option value="'+jtem+'">'+jtem+'</option>';
						});
						html_input += '</select>'+
					'</label>'+
				'</div>';
		});
		
		//html_input += '<div class="small-4 columns"><label>Precio <input type="text" name="producto[0][precio][0]" required value="'+$("#precio_producto").val()+'" readonly="readonly"/></label></div>';
		html_input += '<div class="small-3 columns"><label>Inicial <input type="text" name="producto[0][cantidad_inicial][0]" required /></label></div>';
		html_input += '<div class="small-3 columns"><label>Mínimo <input type="text" name="producto[0][cantidad_minima][0]" required /></label></div>';
		html_input += '<div class="small-2 columns end"><label>&nbsp;<button type="button" class="dynadd success" data-boton="0_0"><i class="fa fa-plus-circle"></i></button></label></div><div class="small-6 columns">'+
							'<label>SKU'+
								'<input type="text" name="producto[0][sku][0]" class="sku_final" data-i="0" data-j="0" value="'+$("#modelo_producto").val()+$(".nombre_color[data-i='0']").val()+'" readonly="readonly">'+
						'</div></div></fieldset>';
		
		$("#var1").html(html_input);
		$("#add_variedad, #fots").show();
		$("#nah").hide();
		$("#id_tipo_add").val($("#tipo_producto_add option:selected").data("id_tipo"));
		
	} else {
		tipo = '';
		$("#var1").html('');
		$("#add_variedad, #fots").hide();
		$("#nah").show();
		$("#id_tipo_add").val('');
	}
	
});

// Generador de nuevos inputs de fotos

$(document).on("click", ".add_foto", function() {
	var producto = $(this).data("producto");
	
	$("#contenido_fotos_"+producto).append(generar_html_foto(producto));
});

function generar_html_foto(producto) {
	
	var html_foto = '<div class="row foto">'+
		'<div class="small-16 columns">'+
			'<label>Fotografía'+
				'<input type="file" name="producto['+producto+'][fotografia][]" accept="image/*" required />'+
			'</label>'+
		'</div>'+
		'<div class="small-4 columns">'+
			'<label>&nbsp;'+
				'<button type="button" class="add_foto success" data-producto="'+producto+'"><i class="fa fa-plus-circle"></i></button>'+
			'</label>'+
		'</div>'+
		'<div class="small-4 columns">'+
			'<label>&nbsp;'+
				'<button type="button" class="quitar_foto warning" data-producto="'+producto+'"><i class="fa fa-times-circle"></i></button>'+
			'</label>'+
		'</div>'+
	'</div>';
	
	return html_foto;
}

$(document).on("click", ".quitar_foto", function() { 
	$(this).closest(".row.foto").remove();
})


// Generador de nuevos espacios de SKU
$(document).on("click", ".dynadd", function() {
	var contador = $(this).closest(".variable-content").find('.item_info').length;
	var foto = $(this).closest("[data-foto]").data('foto');
	
	var data = $.parseJSON($("#tipo_producto_add option:selected").val());
	
	html_input = '<div class="row item_info" data-contador="'+foto+'_'+contador+'" data-i="'+foto+'" data-j="'+contador+'">';
		
		$.each(data, function(i, item) {
			html_input += ''+
				'<div class="small-4 columns end">'+
					'<label>'+item.titulo+
						'<select name="producto['+foto+'][caracteristicas]['+i+']['+contador+']" class="specs_select" required>'+
							'<option value=""></option>';
						$.each(item.opciones, function(j, jtem) {
							html_input += '<option value="'+jtem+'">'+jtem+'</option>';
						});
						html_input += '</select>'+
					'</label>'+
				'</div>';
		});
		
		html_input += '<input type="hidden" talla="" />';
		//html_input += '<div class="small-4 columns"><label>Precio <input type="text" name="producto['+foto+'][precio]['+contador+']" required readonly="readonly"/></label></div>';
		html_input += '<div class="small-3 columns"><label>Inicial <input type="text" name="producto['+foto+'][cantidad_inicial]['+contador+']" required /></label></div>';
		html_input += '<div class="small-3 columns"><label>Mínimo <input type="text" name="producto['+foto+'][cantidad_minima]['+contador+']" required /></label></div>';
				
		html_input += '<div class="small-2 columns end"><label>&nbsp;<button type="button" class="dynadd success" data-boton="'+foto+'_'+contador+'"><i class="fa fa-plus-circle"></i></button></div>';
		html_input += '<div class="small-2 columns end"><label>&nbsp;<button type="button" class="dynrem warning" data-boton="'+foto+'_'+contador+'"><i class="fa fa-times-circle"></i></button></div>';
		html_input += '<div class="small-6 columns">'+
							'<label>SKU'+
								'<input type="text" name="producto['+foto+'][sku]['+contador+']" data-i="'+foto+'" data-j="'+contador+'" class="sku_final" value="'+$("#modelo_producto").val()+$(".nombre_color[data-i='"+foto+"']").val()+'" readonly="readonly">'+
						'</div></div>';
	
	$(this).parent().parent().parent().parent().append(html_input);
	$("#tipo_producto_add").prop("disabled", true);
	$(".dynadd[data-boton='"+contador+"']").hide();
	
});


$(document).on("change", ".specs_select", function() {
	var specs = '';
	$.each($(this).closest(".row.item_info").find(".specs_select option:selected"), function(i, item) {
		specs += $(this).val();
	});
	
	var i = $(this).closest(".row.item_info").data("i");
	var j = $(this).closest(".row.item_info").data("j");
	
	var nombre_color = $(".nombre_color[data-i='"+i+"']").val();
	
	$(".sku_final[data-i='"+i+"'][data-j='"+j+"']").val(crear_sku(sku_base, specs, nombre_color));

})

$(document).on("click", ".dynrem", function() {
	$(".item_info[data-contador='"+$(this).data("boton")+"']").remove();
});

$(document).on("click", ".delete-item-fieldset", function() {
	var data_cont = $(this).data('cont');
	$('fieldset.nomtop[data-foto="'+ data_cont +'"]').remove();
});

// Agregar Variedad

$("#add_variedad").click(function() {
	var contador = $("#fots>fieldset").length;
	console.log(contador);
	
	var data = $.parseJSON($("#tipo_producto_add option:selected").val());
	
	html_input = '<fieldset><legend>SKUs</legend><div class="row item_info" data-contador="'+contador+'_0" data-i="'+contador+'" data-j="0">';
	
	$.each(data, function(i, item) {
		html_input += ''+
			'<div class="small-4 columns end">'+
				'<label>'+item.titulo+
					'<select name="producto['+contador+'][caracteristicas]['+i+'][0]" class="specs_select" required>'+
						'<option value=""></option>';
					$.each(item.opciones, function(j, jtem) {
						html_input += '<option value="'+jtem+'">'+jtem+'</option>';
					});
					html_input += '</select>'+
				'</label>'+
			'</div>';
	});
	
	//html_input += '<div class="small-4 columns"><label>Precio <input type="text" name="producto['+contador+'][precio][0]" value="'+$("#precio_producto").val()+'" required readonly="readonly"/></label></div>';
	html_input += '<div class="small-3 columns"><label>Inicial <input type="text" name="producto['+contador+'][cantidad_inicial][0]" required /></label></div>';
	html_input += '<div class="small-3 columns"><label>Mínimo <input type="text" name="producto['+contador+'][cantidad_minima][0]" required /></label></div>';
			
	html_input += '<div class="small-2 columns end"><label>&nbsp;<button type="button" class="dynadd success" data-boton="'+contador+'_0"><i class="fa fa-plus-circle"></i></button></label></div><div class="small-6 columns">'+
					'<label>SKU'+
						'<input type="text" name="producto['+contador+'][sku][0]" data-i="'+contador+'" data-j="0" class="sku_final" value="'+$("#modelo_producto").val()+'" readonly="readonly">'+
				'</div></div></fieldset>';
	
	
	var html_foto = '<fieldset data-foto="'+contador+'" class="nomtop">'+
		'<legend>Variedad</legend>'+
		'<a class="delete-item-fieldset" data-cont="'+contador+'"><i class="fa fa-times" aria-hidden="true"></i></a>'+
		'<div class="row">'+
			'<div class="small-24 columns">'+
				'<fieldset>'+
					'<legend>Color</legend>'+
					'<div class="row collapse" style="margin-bottom: 1rem;">'+
						'<div class="small-24 large-6 columns">'+
							'<label>Color'+
								'<input type="text" class="color" name="producto['+contador+'][color]" data-i="'+contador+'" value="#FFFFFF">'+
							'</label>'+
						'</div>'+
						'<div class="small-24 large-7  columns">'+
							'<label>Nombre'+
								'<input type="text" class="nombre_color" id="nombre_color_'+contador+'" name="producto['+contador+'][nombre_color]" data-i="'+contador+'" required>'+
							'</label>'+
						'</div>'+
						'<div class="small-24 large-10 columns">'+
							'<label>Precio (sin IVA)'+
								'<input type="text" name="producto['+contador+'][precio]" data-i="'+contador+'" required pattern="number" placeholder="Ejemplo: 50.00" value="" />'+
							'</label>'+
							'<small class="error">Campo requerido.</small>'+
						'</div>'+
					'</div>'+
					/*'<div class="row collapse">'+
						'<div class="small-24 columns">'+
							'<label>Precio (sin IVA)'+
								'<input type="text" name="producto['+contador+'][precio]" data-i="'+contador+'" required pattern="number" placeholder="Ejemplo: $ 100.00" value="" />'+
							'</label>'+
							'<small class="error">Campo requerido.</small>'+
						'</div>'+
					'</div>'+*/
				'</fieldset>'+
			'</div>'+
			'<div class="small-24 columns">'+
				'<fieldset>'+
					'<legend>Fotografías</legend>'+
					'<div class="row">'+
						'<div class="small-24 columns" id="contenido_fotos_'+contador+'">'+
							'<div class="row foto">'+
								'<div class="small-16 columns">'+
									'<label>Fotografía'+
										'<input type="file" name="producto['+contador+'][fotografia][]" accept="image/*" data-i="'+contador+'" required />'+
									'</label>'+
								'</div>'+
								'<div class="small-4 columns">'+
									'<label>&nbsp;'+
										'<button type="botton" class="add_foto success" data-producto="'+contador+'"><i class="fa fa-plus-circle"></i></button>'+
									'</label>'+
								'</div>'+
								'<div class="small-4 columns">'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</fieldset>'+
			'</div>'+
		'</div>'+
		'<div class="row">'+
			'<div class="small-24 columns variable-content">'+	html_input +
			'</div>'+
		'</div>'+
	'</fieldset>';
	
	$("#fots").append(html_foto);
	$("#tipo_producto_add").prop("disabled", true);
	$('fieldset[data-foto="'+contador+'"] .color').spectrum({
		showPalette: true,
		preferredFormat: "hex",
		palette: [
			<?php echo $this->productos_modelo->obtener_colores_paleta(); ?>
		]
	});
	
	$(document).foundation('abide', 'reflow');
});			

$(document).ready(function() {
	$(".color").spectrum({
		showPalette: true,
		preferredFormat: "hex",
		palette: [
			<?php echo $this->productos_modelo->obtener_colores_paleta(); ?>
		]
	});
});

$(window).load(function() {
	$("#tipo_producto_add option[data-id_tipo='<?php echo $tipo_activo->tipo->id_tipo; ?>']").prop("selected", true).trigger("change");
});

</script>