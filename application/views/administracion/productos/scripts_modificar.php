<script>

$(document).on("click", ".volverprincipal", function() {
	var id_fotografia = $(this).parent().parent().data("id_fotografia");
	var id_color = $(this).parent().parent().data("id_color");
	
	$(this).closest(".fotos_producto").find(".principal").attr("title","Volver Principal").addClass("volverprincipal").removeClass("principal").children("i").addClass("fa-star-o").removeClass("fa-star");
	$(this).attr("title","Principal").addClass("principal").removeClass("volverprincipal").children("i").addClass("fa-star").removeClass("fa-star-o");
	
	$.post('<?php echo site_url('administracion/productos/principal-fotografia'); ?>', { id_fotografia: id_fotografia, id_color: id_color });
});

$(".bor_foto").click(function(e) {
	var id_fotografia = $(this).parent().parent().data("id_fotografia");
	var id_color = $(this).parent().parent().data("id_color");
	var estatus = $(this).parent().parent().data("estatus");
	
	var r = confirm("¿Estás seguro de querer borrar esta fotografía?");
    if (r == true) {
		e.preventDefault();
        $.post('<?php echo site_url('administracion/productos/borrar-fotografia'); ?>', { id_fotografia: id_fotografia, id_color: id_color, estatus: estatus });
		$(this).parent().parent().remove();
    }
});

$(document).on("click", ".color_switch.enabled", function() {
	var nuevo_estatus = 0;
	var id_color = $(this).parent().data("id_color");
	$(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');
	
	$.post('<?php echo site_url('administracion/productos/estatus-color'); ?>', { id_color: id_color, estatus: nuevo_estatus });
});

$(document).on("click", ".color_switch.disabled", function() {
	var nuevo_estatus = 1;
	var id_color = $(this).parent().data("id_color");
	$(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');
	
	$.post('<?php echo site_url('administracion/productos/estatus-color'); ?>', { id_color: id_color, estatus: nuevo_estatus });
});

$(document).on("click", ".sku_switch.enabled", function() {
	var nuevo_estatus = 0;
	var id_sku = $(this).parent().data("id_sku");
	$(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');
	
	$.post('<?php echo site_url('administracion/productos/estatus-sku'); ?>', { id_sku: id_sku, estatus: nuevo_estatus });
});

$(document).on("click", ".sku_switch.disabled", function() {
	var nuevo_estatus = 1;
	var id_sku = $(this).parent().data("id_sku");
	$(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');
	
	$.post('<?php echo site_url('administracion/productos/estatus-sku'); ?>', { id_sku: id_sku, estatus: nuevo_estatus });
});

// Generador de nuevos inputs de fotos

$(document).on("click", ".add_foto", function() {
	var producto = $(this).data("producto");
	
	$("#contenido_fotos_"+producto).append(generar_html_foto(producto));
});


$(document).on("click", ".add_foto_existente", function() {
	var producto = $(this).data("producto");
	
	$("#contenido_fotos_"+producto).append(generar_html_foto_existente(producto));
});

$(document).on("click", ".delete-item-fieldset", function() {
	var data_cont = $(this).data('cont');
	$('fieldset.nomtop[data-foto="'+ data_cont +'"]').remove();
});

function generar_html_foto(producto) {
	
	var html_foto = '<div class="row foto">'+
		'<div class="small-16 columns">'+
			'<label>Fotografía'+
				'<input type="file" name="nuevo_producto['+producto+'][fotografia][]" accept="image/*" />'+
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

function generar_html_foto_existente(producto) {
	
	var html_foto = '<div class="row foto">'+
		'<div class="small-16 columns">'+
			'<label>Fotografía'+
				'<input type="file" name="producto['+producto+'][fotografia][]" accept="image/*" />'+
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

function crear_sku(base, talla, color) {
	return base+talla+color;
}

var sku_base = $("#modelo_producto").val();
var html_input = '';
var tipo = '';

// Generador de nuevos espacios de SKU
$(document).on("click", ".dynadd", function() {
	var contador = $(this).closest(".variable-content").find('.item_info').length;
	var foto = $(this).closest("[data-foto]").data('foto');
	
	var data = $.parseJSON($("#tipo").val());
	
	html_input = '<div class="row item_info" data-contador="'+foto+'_'+contador+'" data-i="'+foto+'" data-j="'+contador+'">';
		
		$.each(data, function(i, item) {
			html_input += ''+
				'<div class="small-4 columns end">'+
					'<label>'+item.titulo+
						'<select name="nuevo_producto['+foto+'][caracteristicas]['+i+']['+contador+']" class="specs_select" required>'+
							'<option value=""></option>';
						$.each(item.opciones, function(j, jtem) {
							html_input += '<option value="'+jtem+'">'+jtem+'</option>';
						});
						html_input += '</select>'+
					'</label>'+
				'</div>';
		});
		//html_input += '<div class="small-4 columns"><label>Precio <input type="text" name="producto['+foto+'][precio]['+contador+']" required value="'+$("#precio_producto").val()+'" readonly="readonly"/></label></div>';
		html_input += '<input type="hidden" talla="" />';
		html_input += '<div class="small-3 columns"><label>Inicial <input type="text" name="nuevo_producto['+foto+'][cantidad_inicial]['+contador+']" required /></label></div>';
		html_input += '<div class="small-3 columns"><label>Mínimo <input type="text" name="nuevo_producto['+foto+'][cantidad_minima]['+contador+']" required /></label></div>';
				
		html_input += '<div class="small-2 columns end"><label>&nbsp;<button type="button" class="dynadd success" data-boton="'+foto+'_'+contador+'"><i class="fa fa-plus-circle"></i></button></div>';
		html_input += '<div class="small-2 columns end"><label>&nbsp;<button type="button" class="dynrem warning" data-boton="'+foto+'_'+contador+'"><i class="fa fa-times-circle"></i></button></div>';
		html_input += '<div class="small-6 columns">'+
							'<label>SKU'+
								'<input type="text" name="nuevo_producto['+foto+'][sku]['+contador+']" data-i="'+foto+'" data-j="'+contador+'" class="sku_final" value="'+$("#modelo_producto").val()+$(".nombre_color[data-i='"+foto+"']").val()+'" readonly="readonly">'+
						'</div></div>';
	
	$(this).parent().parent().parent().parent().append(html_input);
	$("#tipo_producto_add").prop("disabled", true);
	$(".dynadd[data-boton='"+contador+"']").hide();
	
});

// Generador de nuevos espacios de SKU
$(document).on("click", ".dynsku", function() {
	var contador = $(this).closest(".variable-content").find('.item_info').length;
	var foto = $(this).closest("[data-foto]").data('foto');
	
	var data = $.parseJSON($("#tipo").val());
	
	html_input = '<div class="row item_info" data-contador="'+foto+'_'+contador+'" data-i="'+foto+'" data-j="'+contador+'">';
		
		$.each(data, function(i, item) {
			html_input += ''+
				'<div class="small-4 columns end">'+
					'<label>'+item.titulo+
						'<select name="nuevo_sku['+foto+'][caracteristicas]['+i+']['+contador+']" class="specs_select" required>'+
							'<option value=""></option>';
						$.each(item.opciones, function(j, jtem) {
							html_input += '<option value="'+jtem+'">'+jtem+'</option>';
						});
						html_input += '</select>'+
					'</label>'+
				'</div>';
		});
		//html_input += '<div class="small-4 columns"><label>Precio <input type="text" name="producto['+foto+'][precio]['+contador+']" required value="'+$("#precio_producto").val()+'" readonly="readonly"/></label></div>';
		html_input += '<input type="hidden" talla="" />';
		html_input += '<div class="small-3 columns"><label>Inicial <input type="text" name="nuevo_sku['+foto+'][cantidad_inicial]['+contador+']" required /></label></div>';
		html_input += '<div class="small-3 columns"><label>Mínimo <input type="text" name="nuevo_sku['+foto+'][cantidad_minima]['+contador+']" required /></label></div>';
				
		html_input += '<div class="small-2 columns end"><label>&nbsp;<button type="button" class="dynadd success" data-boton="'+foto+'_'+contador+'"><i class="fa fa-plus-circle"></i></button></div>';
		html_input += '<div class="small-2 columns end"><label>&nbsp;<button type="button" class="dynrem warning" data-boton="'+foto+'_'+contador+'"><i class="fa fa-times-circle"></i></button></div>';
		html_input += '<div class="small-6 columns">'+
							'<label>SKU'+
								'<input type="text" name="nuevo_sku['+foto+'][sku]['+contador+']" data-i="'+foto+'" data-j="'+contador+'" class="sku_final" value="'+$("#modelo_producto").val()+$(".nombre_color[data-i='"+foto+"']").val()+'" readonly="readonly">'+
						'</div></div>';
	
	$(this).parent().parent().parent().parent().append(html_input);
	$("#tipo_producto_add").prop("disabled", true);
	$(".dynadd[data-boton='"+contador+"']").hide();
	
});


$(document).on("click", ".quitar_foto", function() { 
	$(this).closest(".row.foto").remove();
})


$(document).on("change", ".specs_select", function() {
	var specs = '';
	$.each($(this).closest(".row.item_info").find(".specs_select option:selected"), function(i, item) {
		specs += $(this).val();
	});
	
	var i = $(this).closest(".row.item_info").data("i");
	var j = $(this).closest(".row.item_info").data("j");
	
	var nombre_color = $(".nombre_color[data-i='"+i+"']").val();
	
	$(".sku_final[data-i='"+i+"'][data-j='"+j+"']").val(crear_sku(sku_base, specs, nombre_color));

});

/*$(document).ready(function(){
	cambiar_precio($('#precio_producto').val());
});*/

/*$(document).on("change input keyup keydown paste", "#precio_producto", function() {
	sku_base = $(this).val();
	cambiar_precio(sku_base);
});

function cambiar_precio(sku_base)
{
	$.each($(".row.item_info"), function(ciclo) {
		var i = $(this).data("i");
		var j = $(this).data("j");
		$.each($(this).closest(".row.item_info[data-i='"+i+"'][data-j='"+j+"']"), function(contador, item) {
			$("input[name='producto["+i+"][precio]["+j+"]']").val(sku_base);
		});
	});
	//el each no va
	$.each($(".sku_final"), function(ciclo) {
		var i = $(this).data("i");
		var j = $(this).data("j");
		$.each($(this).closest(".row.item_info[data-i='"+i+"'][data-j='"+j+"']").find(".specs_select option:selected"), function(contador, item) {
			$("input[name='producto["+i+"][precio]["+j+"]']").val(sku_base);
		});
	});
}*/

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

$(document).on("click", ".dynrem", function() {
	$(".item_info[data-contador='"+$(this).data("boton")+"']").remove();
	contador--;
});

// Agregar Variedad
var contador = 0;

$("#add_variedad").click(function() {
	
	var data = $.parseJSON($("#tipo").val());
	
	html_input = '<fieldset><legend>SKUs</legend><div class="row item_info" data-contador="'+contador+'_0" data-i="'+contador+'" data-j="0">';
	
	$.each(data, function(i, item) {
		html_input += ''+
			'<div class="small-4 columns end">'+
				'<label>'+item.titulo+
					'<select name="nuevo_producto['+contador+'][caracteristicas]['+i+'][0]" class="specs_select" required>'+
						'<option value=""></option>';
					$.each(item.opciones, function(j, jtem) {
						html_input += '<option value="'+jtem+'">'+jtem+'</option>';
					});
					html_input += '</select>'+
				'</label>'+
			'</div>';
	});
	
	//html_input += '<div class="small-4 columns"><label>Precio <input type="text" name="producto[0][precio][0]" required value="'+$("#precio_producto").val()+'" readonly="readonly"/></label></div>';
	html_input += '<div class="small-3 columns"><label>Inicial <input type="text" name="nuevo_producto['+contador+'][cantidad_inicial][0]" required /></label></div>';
	html_input += '<div class="small-3 columns"><label>Mínimo <input type="text" name="nuevo_producto['+contador+'][cantidad_minima][0]" required /></label></div>';
			
	html_input += '<div class="small-2 columns end"><label>&nbsp;<button type="button" class="dynadd success" data-boton="'+contador+'_0"><i class="fa fa-plus-circle"></i></button></label></div><div class="small-6 columns">'+
					'<label>SKU'+
						'<input type="text" name="nuevo_producto['+contador+'][sku][0]" data-i="'+contador+'" data-j="0" class="sku_final" value="'+$("#modelo_producto").val()+'" readonly="readonly">'+
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
								'<input type="text" name="producto['+contador+'][precio]" data-i="'+contador+'" required pattern="number" placeholder="Ejemplo: $ 100.00" value="" />'+
							'</label>'+
							'<small class="error">Campo requerido.</small>'+
						'</div>'+
					'</div>'+
					/*'<div class="row collapse">'+
						
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
										'<input type="file" name="nuevo_producto['+contador+'][fotografia][]" accept="image/*" data-i="'+contador+'" required />'+
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
	
	
	contador++;

	//alert("Posteriormente se deben de agregar las fotografías correspondientes al nuevo color en el área del diseñador.");

});			


$("#add_variedad_mod").click(function() {
	
	var data = $.parseJSON($("#tipo").val());
	
	html_input = '<fieldset><legend>SKUs</legend><div class="row item_info" data-contador="'+contador+'_0" data-i="'+contador+'" data-j="0">';
	
	$.each(data, function(i, item) {
		html_input += ''+
			'<div class="small-4 columns end">'+
				'<label>'+item.titulo+
					'<select name="nuevo_producto['+contador+'][caracteristicas]['+i+'][0]" class="specs_select" required>'+
						'<option value=""></option>';
					$.each(item.opciones, function(j, jtem) {
						html_input += '<option value="'+jtem+'">'+jtem+'</option>';
					});
					html_input += '</select>'+
				'</label>'+
			'</div>';
	});
	
	//html_input += '<div class="small-4 columns"><label>Precio <input type="text" name="producto[0][precio][0]" required value="'+$("#precio_producto").val()+'" readonly="readonly"/></label></div>';
	html_input += '<div class="small-3 columns"><label>Inicial <input type="text" name="nuevo_producto['+contador+'][cantidad_inicial][0]" required /></label></div>';
	html_input += '<div class="small-3 columns"><label>Mínimo <input type="text" name="nuevo_producto['+contador+'][cantidad_minima][0]" required /></label></div>';
			
	html_input += '<div class="small-2 columns end"><label>&nbsp;<button type="button" class="dynadd success" data-boton="'+contador+'_0"><i class="fa fa-plus-circle"></i></button></label></div><div class="small-6 columns">'+
					'<label>SKU'+
						'<input type="text" name="nuevo_producto['+contador+'][sku][0]" data-i="'+contador+'" data-j="0" class="sku_final" value="'+$("#modelo_producto").val()+'" readonly="readonly">'+
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
								'<input type="text" class="color" name="nuevo_producto['+contador+'][color]" data-i="'+contador+'" value="#FFFFFF">'+
							'</label>'+
						'</div>'+
						'<div class="small-24 large-7  columns">'+
							'<label>Nombre'+
								'<input type="text" class="nombre_color" id="nuevo_nombre_color_'+contador+'" name="nuevo_producto['+contador+'][nombre_color]" data-i="'+contador+'" required>'+
							'</label>'+
						'</div>'+
						'<div class="small-24 large-10 columns">'+
							'<label>Precio (sin IVA)'+
								'<input type="text" name="nuevo_producto['+contador+'][precio]" data-i="'+contador+'" required pattern="number" placeholder="" value="" />'+
							'</label>'+
							'<small class="error">Campo requerido.</small>'+
						'</div>'+
					'</div>'+
					/*'<div class="row collapse">'+
						
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
										'<input type="file" name="nuevo_producto['+contador+'][fotografia][]" accept="image/*" data-i="'+contador+'" required />'+
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
	
	
	contador++;

	//alert("Posteriormente se deben de agregar las fotografías correspondientes al nuevo color en el área del diseñador.");

});		

tinymce.init({
	selector: 'textarea#descripcion_producto',
	height: 190,
	menubar: false,
	plugins: [
	'advlist autolink lists link image charmap print preview anchor',
	'searchreplace visualblocks code fullscreen',
	'insertdatetime media table contextmenu paste code'
	],
	toolbar: ' bold italic | undo redo | styleselect'
});	


$(".habilitador").on("click", function() {
	var i = $(this).data("i");
	var j = $(this).data("j");
	
	if($(this).is(":checked")) {
		$(".item_info[data-i='"+i+"'][data-j='"+j+"']").find("input[type='text']").prop("disabled", false);
		$(".item_info[data-i='"+i+"'][data-j='"+j+"']").find("select").prop("disabled", false);
		$(".item_info[data-i='"+i+"'][data-j='"+j+"']").find("button").prop("disabled", false);
	} else {
		$(".item_info[data-i='"+i+"'][data-j='"+j+"']").find("input[type='text']").prop("disabled", true);
		$(".item_info[data-i='"+i+"'][data-j='"+j+"']").find("select").prop("disabled", true);
		$(".item_info[data-i='"+i+"'][data-j='"+j+"']").find("button").prop("disabled", true);
	}
});

</script>