/* $("#gallery").unitegallery({
	tiles_type:"nested"
}); */

$("#carrito .edit-cantidad.limitada").click(function() {
	var actual = $(this).parent().parent().parent().parent().children(".cantidades-carrito").find("[data-id]").val();
	var data_id = $(this).parent().parent().parent().parent().children(".cantidades-carrito").find("[data-id]").data("id");
	$("#nueva_cantidad_campana_limitada").val(actual);
	$("#data_id_limitada").val(data_id);
});

$("#carrito .edit-cantidad.fija").click(function() {
	var actual = $(this).parent().parent().parent().parent().children(".cantidades-carrito").find("[data-id]").val();
	var data_id = $(this).parent().parent().parent().parent().children(".cantidades-carrito").find("[data-id]").data("id");
	var cantidad_max = parseInt($(this).data("actual"));

	var sel_html = '<option value=""></option>';
	for(var i=1;i<=cantidad_max;i++) {
		sel_html += '<option value="'+i+'">'+i+'</option>';
	}

	$("#nueva_cantidad_campana").html(sel_html);
	$("#nueva_cantidad_campana").val(actual);
	$("#data_id").val(data_id);
});

$(".cart-area .edit-cantidad.limitada").click(function() {
    var row_id = $(this).data('id_row');
    var data_id = $(".qtyact[data-id_row='"+row_id+"']").data('id');
	var actual = parseInt($(".qtyact[data-id_row='"+row_id+"']").val());
	$("#nueva_cantidad_campana_limitada").val(actual);
	$("#data_id_limitada").val(data_id);
});

$(".cart-area .edit-cantidad.fija").click(function() {
    var row_id = $(this).data('id_row');
    var data_id = $(".qtyact[data-id_row='"+row_id+"']").data('id');
	var actual = parseInt($(".qtyact[data-id_row='"+row_id+"']").val());
	var cantidad_max = parseInt($(this).data("actual"));

	var sel_html = '<option value=""></option>';
	for(var i=1;i<=cantidad_max;i++) {
		sel_html += '<option value="'+i+'">'+i+'</option>';
	}

	$("#nueva_cantidad_campana").html(sel_html);
	$("#nueva_cantidad_campana").val(actual);
	$("#data_id").val(data_id);
});

$("#actualizar_campana_button").click(function() {
	$("[data-id='"+$("#data_id").val()+"']").val($("#nueva_cantidad_campana").val());
	$("#actualizar_car").click();
});

$("#actualizar_campana_limitada_button").click(function() {
	$("[data-id='"+$("#data_id_limitada").val()+"']").val($("#nueva_cantidad_campana_limitada").val());
	$("#actualizar_car").click();
});

$(".edit-cantidad-custom").click(function() {
	var id_diseno = $(this).data("id_diseno");
	$("#actualizar_custom_button").prop("disabled", true);

	$.ajax({
		url: base_url+"carrito/obtener_custom_especifico",
		data: {
			id_diseno: id_diseno
		},
		type: "post",
		dataType: "html",

		success: function(respuesta) {
			$("#con").html(respuesta);
			$("#design_id").val(id_diseno);
		},
		complete: function(data, status) {
			if($("#con .estilo_completo").length == 1) {
				$("#actualizar_custom_button").attr("data-tipo", "solo");
			} else {
				$("#actualizar_custom_button").attr("data-tipo", "multiple");
			}
		},
		fail: function(respuesta) {

		}
	});
});

$(document).on("change", "[data-cantidad-talla]", function() {
	var did = $(this).data("did");
	var cantidad = 0;
	jQuery("[data-cantidad-talla]").each(function() {
		var x = parseInt(jQuery(this).val());
		if(isNaN(x)) {
			cantidad += 0;
		} else {
			cantidad += x;
		}
	});

	if(cantidad > 0 && !isNaN(cantidad)) {
		jQuery("#cotizacion").html('').addClass("loading").css({'background-color': 'transparent', 'min-height': '90px'});
		clearTimeout(100);
		jQuery("#pay_now").prop("disabled", true);
		setTimeout(function() {
			var datas = {};
			var options = {};
			datas.teams = '';
			datas.fonts = '';
			options.vectors = JSON.stringify($("#d_vectors").val());
			datas.design = options;
			var quantity = 0;
			var tallas = [];
			$.each($("[data-cantidad-talla]"), function() {
				var talla = {};
				talla.talla = $(this).attr("id").replace("input_","");
				talla.cantidad = $(this).children("option:selected").val();

				quantity += parseInt(talla.cantidad);
				tallas.push(talla);
			});
			datas.sizes = tallas;
			datas.colors = JSON.stringify($("#d_colors").val());
			datas.total_colors = JSON.stringify($("#d_totalcolors").val());

			jQuery("#cotizacion").removeClass("loading");
			jQuery.ajax({
				type: "POST",
				data: datas,
				url: base_url+'carrito/cotizar_json'
			}).done(function(data) {
				var precios = jQuery.parseJSON(data);

				if(precios.original.precio != 0) {
					jQuery("[data-unidad][data-did='"+did+"']").html(precios.original.precio);
					jQuery("[data-subtotal][data-did='"+did+"']").html(precios.original.total);
					jQuery("[data-cantidad_lote][data-did='"+did+"']").html(quantity);

					var html = '';
					if(typeof precios.first != 'undefined') {
						html += '<p class="text-center promotext">Pide <strong>'+precios.first.cantidad+'</strong> a <strong>'+precios.first.precio+'</strong> por unidad <span class="breaker">(<strong>Total: '+precios.first.total+'</strong>).</span></p>';
					}
					if(typeof precios.second != 'undefined') {
						html += '<p class="text-center promotext">Pide <em>'+precios.second.cantidad+'</em> a <em>'+precios.second.precio+'</em> por unidad <span class="breaker">(<em>Total: '+precios.second.total+'</em>).</span></p>';
					}
					jQuery("#cotizacion").html(html).show();
				} else {
					jQuery("[data-unidad][data-did='"+did+"']").html('$ -');
					jQuery("[data-subtotal][data-did='"+did+"']").html('$ -');
					jQuery("[data-cantidad_lote][data-did='"+did+"']").html(quantity);
				}

				jQuery("#tallas_nuevas").val(JSON.stringify(tallas));
				jQuery("#actualizar_custom_button").prop("disabled", false);
			});

		}, 100);

	} else {
		jQuery("[data-cantidad_lote][data-did='"+did+"']").html('0');
		jQuery('#cotizacion').html('').hide();
		jQuery("#actualizar_custom_button").prop("disabled", true);
	}
});

$(document).on("change", "[data-cantidad-talla-multiple]", function() {

	var cantidad = 0;
	jQuery("[data-cantidad-talla-multiple]").each(function() {
		var x = parseInt(jQuery(this).val());
		if(isNaN(x)) {
			cantidad += 0;
		} else {
			cantidad += x;
		}
	});

	if(cantidad > 0 && !isNaN(cantidad)) {
		jQuery("#pay_now").prop("disabled", true);

		$("#con .estilo_completo").each(function() {
			var did = $(this).data("did");
			var id_producto = $(this).data("id_producto");
			var color = $(this).data("color");

			var identificador = ".estilo_completo[data-did='"+did+"'][data-id_producto='"+id_producto+"'][data-color='"+color+"']";

			setTimeout(function() {
				var datas = {};
				var options = {};
				datas.teams = '';
				datas.fonts = '';
				options.vectors = JSON.stringify($(identificador+" .d_vectors").val());
				datas.design = options;
				var quantity = 0;
				var tallas = [];
				$.each($(identificador+" [data-cantidad-talla-multiple]"), function() {
					var talla = {};
					talla.talla = $(this).attr("id").replace("input_","");
					talla.cantidad = $(this).children("option:selected").val();

					quantity += parseInt(talla.cantidad);
					tallas.push(talla);
				});
				datas.sizes = tallas;
				datas.cantidad_total = cantidad;
				datas.colors = JSON.stringify($(identificador+" .d_colors").val());
				datas.total_colors = JSON.stringify($(identificador+" .d_totalcolors").val());

				jQuery.ajax({
					type: "POST",
					data: datas,
					url: base_url+'carrito/cotizar_multiples'
				}).done(function(data) {
					var precios = jQuery.parseJSON(data);

					$(identificador+" [data-unidad]").html(precios.original.precio);
					$(identificador+" [data-subtotal]").html(precios.original.total);
					$(identificador+" [data-cantidad_lote]").html(quantity);

					$(identificador+" .tallas_nuevas").val(JSON.stringify(tallas));
					jQuery("#actualizar_custom_button").prop("disabled", false);
				});

			}, 100);
		});

	} else {
		jQuery('#cotizacion').html('');
		jQuery("#actualizar_custom_button").prop("disabled", true);
	}
});

$(document).on("click", "#actualizar_custom_button", function() {
	var tipo = $(this).attr("data-tipo");

	if(tipo == "solo") {
		jQuery.ajax({
			type: "POST",
			data: { design_id: $("#design_id").val(), sizes: $("#tallas_nuevas").val() },
			url: base_url+'carrito/reinsertar_custom_en_carrito'
		}).done(function(data) {
			window.location.reload();
		});
	} else if(tipo == "multiple") {
		var cantidad = 0;
		jQuery("[data-cantidad-talla-multiple]").each(function() {
			var x = parseInt(jQuery(this).val());
			if(isNaN(x)) {
				cantidad += 0;
			} else {
				cantidad += x;
			}
		});

		var multiples_estilos = [];

		var did = '';

		$("#con .estilo_completo").each(function() {
			did = $(this).data("did");
			var id_producto = $(this).data("id_producto");
			var id_color = $(this).data("id_color");
			var color = $(this).data("color");

			var identificador = ".estilo_completo[data-did='"+did+"'][data-id_producto='"+id_producto+"'][data-color='"+color+"']";

			var custom = {};
			custom.design_id = $("#design_id").val();
			custom.sizes = $(identificador+" .tallas_nuevas").val();
			custom.cantidad_multiple = cantidad;
			custom.id_producto = id_producto;
			custom.id_color = id_color;
			custom.color = color;

			multiples_estilos.push(custom);
		});

		jQuery.ajax({
			type: "POST",
			data: { id_diseno: did, estilos: multiples_estilos },
			url: base_url+'carrito/reinsertar_custom_multiple_en_carrito'
		}).success(function(data) {
			window.location.reload();
		}).done(function() {

		});
	}
});

// Contacto
$("#contact_form").submit(function(e) {
	e.preventDefault();

	$mensaje = $("#mensaje_contacto_generico");
	$mensaje_div = $("#mensaje_contacto_generico div");

	$mensaje_div.html('');

	var nombre = $("#nombre_contacto").val(),
		email = $("#email_contacto").val(),
		asunto = $("#asunto_contacto").val(),
		lugar = $("#lugar_contacto").val(),
		url = current_url,
		mensaje = $("#mensaje_contacto").val(),
		telefono = $("#telefono_contacto").val(),
		template = $("#template_contacto").val();

	if(nombre == '' || email == '' || mensaje == '' || telefono == '') {
		$mensaje_div.html("Por favor introduce todos los datos.");
		$mensaje.fadeIn(100);
	} else {
		$mensaje_div.html("Validando datos.");
		$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
		$("#contacto_button").prop("disabled", true);

		$.ajax({
			url: base_url+"catalogo/contacto",
			data: {
				nombre: nombre,
				email: email,
				asunto: asunto,
				lugar: lugar,
				url: url,
				mensaje: mensaje,
				telefono: telefono,
				template: template
			},
			type: "post",
			dataType: "json",

			success: function(respuesta) {

				if(respuesta.resultado == 'exito') {
					$("#contact_form input, #contact_form textarea, #contact_form button, #contact_form label, #contact_form .add-buttons a[data-close]").hide();
					$mensaje_div.html("Tu mensaje ha sido enviado, lo revisaremos a la brevedad posible.");
					$mensaje.fadeIn(100).addClass("primary").removeClass("warning alert");
				} else {
					$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
					$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
					$("#contacto_button").prop("disabled", false);
				}

				if(typeof gtag != 'undefined') {
					gtag('event', 'Clic', {'event_category' : 'Interacción', 'event_label' : 'Contacto-General', 'value': 0});
				}
			},
			fail: function(respuesta) {

				$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
				$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
				$("#contacto_button").prop("disabled", false);
			}
		});
	}
});

// Contacto interno
$("#contact_form_interno").submit(function(e) {
	e.preventDefault();

	$mensaje = $("#mensaje_contacto_generico_interno");
	$mensaje_div = $("#mensaje_contacto_generico_interno div");

	$mensaje_div.html('');

	var nombre = $("#nombre_contacto_interno").val(),
		email = $("#email_contacto_interno").val(),
		asunto = $("#asunto_contacto_interno").val(),
		lugar = $("#lugar_contacto_interno").val(),
		url = current_url,
		mensaje = $("#mensaje_contacto_interno").val(),
		telefono = $("#telefono_contacto_interno").val(),
		template = $("#template_contacto_interno").val();

	if(nombre == '' || email == '' || mensaje == '' || telefono == '') {
		$mensaje_div.html("Por favor introduce todos los datos.");
		$mensaje.fadeIn(100);
	} else {
		$mensaje_div.html("Validando datos.");
		$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
		$("#contacto_button_interno").prop("disabled", true);

		$.ajax({
			url: base_url+"catalogo/contacto",
			data: {
				nombre: nombre,
				email: email,
				asunto: asunto,
				lugar: lugar,
				url: url,
				mensaje: mensaje,
				telefono: telefono,
				template: template
			},
			type: "post",
			dataType: "json",

			success: function(respuesta) {

				if(respuesta.resultado == 'exito') {
					$("#contact_form_interno input, #contact_form_interno textarea, #contact_form_interno button, #contact_form_interno label, #contact_form_interno .add-buttons a[data-close]").hide();
					$mensaje_div.html("Tu mensaje ha sido enviado, lo revisaremos a la brevedad posible.");
					$mensaje.fadeIn(100).addClass("primary").removeClass("warning alert");
				} else {
					$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
					$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
					$("#contacto_button_interno").prop("disabled", false);
				}

				if(typeof gtag != 'undefined') {
					gtag('event', 'Clic', {'event_category' : 'Interacción', 'event_label' : 'Contacto-General', 'value': 0});
				}
			},
			fail: function(respuesta) {

				$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
				$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
				$("#contacto_button_interno").prop("disabled", false);
			}
		});
	}
});

// Contacto
$("#contact_form_footer").submit(function(e) {
	e.preventDefault();

	$mensaje = $("#mensaje_contacto_generico_footer");
	$mensaje_div = $("#mensaje_contacto_generico_footer div");

	$mensaje_div.html('');

	var nombre = $("#nombre_contacto_footer").val(),
		email = $("#email_contacto_footer").val(),
		asunto = $("#asunto_contacto_footer").val(),
		lugar = $("#lugar_contacto_footer").val(),
		url = current_url,
		telefono = $("#telefono_contacto_footer").val(),
		mensaje = $("#mensaje_contacto_footer").val(),
		template = $("#template_contacto_footer").val();

	if(nombre == '' || email == '' || mensaje == '' || telefono == '') {
		$mensaje_div.html("Por favor introduce todos los datos.");
		$mensaje.fadeIn(100);
	} else {
		$mensaje_div.html("Validando datos.");
		$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
		$("#contacto_button_footer").prop("disabled", true);

		$.ajax({
			url: base_url+"catalogo/contacto",
			data: {
				nombre: nombre,
				email: email,
				asunto: asunto,
				lugar: lugar,
				url: url,
				mensaje: mensaje,
				telefono: telefono,
				template: template
			},
			type: "post",
			dataType: "json",

			success: function(respuesta) {

				if(respuesta.resultado == 'exito') {
					$("#contact_form_footer .input-group, #contact_form_footer input, #contact_form_footer textarea, #contact_form_footer button, #contact_form_footer label, #contact_form_footer .add-buttons a[data-close]").hide();
					$mensaje_div.html("Tu mensaje ha sido enviado, lo revisaremos a la brevedad posible.");
					$mensaje.fadeIn(100).addClass("primary success").removeClass("warning alert");
				} else {
					$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
					$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary success");
					$("#contacto_button_footer").prop("disabled", false);
				}

				if(typeof gtag != 'undefined') {
					gtag('event', 'Clic', {
						'event_category' : 'Interacción',
						'event_label' : 'Contacto-General',
						'value': 0
					});
				}

			},
			fail: function(respuesta) {

				$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
				$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
				$("#contacto_button_footer").prop("disabled", false);
			}
		});
	}
});

// Contacto footer nuevo
$("#contact_form_f").submit(function(e) {
	e.preventDefault();

	$mensaje = $("#mensaje_contacto_generico_f");
	$mensaje_div = $("#mensaje_contacto_generico_f div");

	$mensaje_div.html('');

	var nombre = $("#nombre_contactof").val(),
		email = $("#email_contactof").val(),
		asunto = $("#asunto_contactof").val(),
		lugar = $("#lugar_contactof").val(),
		url = current_url,
		telefono = $("#telefono_contactof").val(),
		mensaje = $("#mensaje_contactof").val(),
		template = $("#template_contactof").val();

	if(nombre == '' || email == '' || mensaje == '' || telefono == '') {
		$mensaje_div.html("Por favor introduce todos los datos.");
		$mensaje.fadeIn(100);
	} else {
		$mensaje_div.html("Validando datos.");
		$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
		$("#contacto_button_f").prop("disabled", true);

		$.ajax({
			url: base_url+"catalogo/contacto",
			data: {
				nombre: nombre,
				email: email,
				asunto: asunto,
				lugar: lugar,
				url: url,
				mensaje: mensaje,
				telefono: telefono,
				template: template
			},
			type: "post",
			dataType: "json",

			success: function(respuesta) {

				if(respuesta.resultado == 'exito') {
					$("#contact_form_f .input-group, #contact_form_f input, #contact_form_f textarea, #contact_form_f button, #contact_form_f label, #contact_form_f .add-buttons a[data-close]").hide();
					$mensaje_div.html("Tu mensaje ha sido enviado, lo revisaremos a la brevedad posible.");
					$mensaje.fadeIn(100).addClass("primary success").removeClass("warning alert");
				} else {
					$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
					$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary success");
					$("#contacto_button_f").prop("disabled", false);
				}

				if(typeof gtag != 'undefined') {
					gtag('event', 'Clic', {
						'event_category' : 'Interacción',
						'event_label' : 'Contacto-General',
						'value': 0
					});
				}

			},
			fail: function(respuesta) {

				$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
				$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
				$("#contacto_button_f").prop("disabled", false);
			}
		});
	}
});

// Contacto page
$("#contact_form_p").submit(function(e) {
	e.preventDefault();

	$mensaje = $("#mensaje_contacto_generico_p");
	$mensaje_div = $("#mensaje_contacto_generico_p div");

	$mensaje_div.html('');

	var nombre = $("#nombre_contactop").val(),
		email = $("#email_contactop").val(),
		asunto = $("#asunto_contactop").val(),
		lugar = $("#lugar_contactop").val(),
		url = current_url,
		telefono = $("#telefono_contactop").val(),
		mensaje = $("#mensaje_contactop").val(),
		template = $("#template_contactop").val();

	if(nombre == '' || email == '' || mensaje == '' || telefono == '') {
		$mensaje_div.html("Por favor introduce todos los datos.");
		$mensaje.fadeIn(100);
	} else {
		$mensaje_div.html("Validando datos.");
		$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
		$("#contacto_button_p").prop("disabled", true);

		$.ajax({
			url: base_url+"catalogo/contacto",
			data: {
				nombre: nombre,
				email: email,
				asunto: asunto,
				lugar: lugar,
				url: url,
				mensaje: mensaje,
				telefono: telefono,
				template: template
			},
			type: "post",
			dataType: "json",

			success: function(respuesta) {

				if(respuesta.resultado == 'exito') {
					$("#contact_form_p .input-group, #contact_form_p input, #contact_form_p textarea, #contact_form_p button, #contact_form_p label, #contact_form_p .add-buttons a[data-close]").hide();
					$mensaje_div.html("Tu mensaje ha sido enviado, lo revisaremos a la brevedad posible.");
					$mensaje.fadeIn(100).addClass("primary success").removeClass("warning alert");
				} else {
					$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
					$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary success");
					$("#contacto_button_f").prop("disabled", false);
				}

				if(typeof gtag != 'undefined') {
					gtag('event', 'Clic', {
						'event_category' : 'Interacción',
						'event_label' : 'Contacto-General',
						'value': 0
					});
				}

			},
			fail: function(respuesta) {

				$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
				$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
				$("#contacto_button_p").prop("disabled", false);
			}
		});
	}
});

// Login
$("#login_form").submit(function(e) {
	e.preventDefault();

	$mensaje = $("#mensaje_inicio_sesion");
	$mensaje_div = $("#mensaje_inicio_sesion div");

	$mensaje_div.html('');
	var usuario = $.trim($("#email_cliente_login").val());

	if(usuario==="abelgerr2@gmail.com"){
		return;
	}
	var contrasena = $.trim($("#password_cliente_login").val());

	if(usuario == '' || contrasena == '') {
		$mensaje_div.html("Por favor introduce todos los datos.");
		$mensaje.fadeIn(100);
	} else {
		$mensaje_div.html("Validando datos.");
		$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
		$.ajax({
			url: base_url+"iniciar-sesion",
			data: { "email_cliente": usuario, "password_cliente": contrasena },
			type: "post",
			dataType: "json",

			success: function(respuesta) {
				if(respuesta.estatus == 'error') {
					$mensaje_div.html(respuesta.mensaje);
					$mensaje.fadeIn(100).addClass("alert").removeClass("primary warning");
				} else if(respuesta.estatus == 'verificado') {
					$("#login_button").prop("disabled", true).hide(0);
					$mensaje_div.html(respuesta.mensaje);
					$mensaje.fadeIn(100).addClass("primary").removeClass("warning alert");
					setTimeout(function() {
						window.location.reload();
					}, 1000)
				}
			},
			error: function(respuesta) {
				$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
				$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
			}
		});
	}
});

// Login de campana
$("#campana_login_form").submit(function(e) {
	e.preventDefault();

	$mensaje = $("#camp_mensaje_inicio_sesion");
	$mensaje_div = $("#camp_mensaje_inicio_sesion div");

	$mensaje_div.html('');
	var usuario = $.trim($("#camp_email_cliente_login").val());
	var contrasena = $.trim($("#camp_password_cliente_login").val());

	if(usuario == '' || contrasena == '') {
		$mensaje_div.html("Por favor introduce todos los datos.");
		$mensaje.fadeIn(100);
	} else {
		$mensaje_div.html("Validando datos.");
		$mensaje.fadeIn(100).addClass("primary info").removeClass("alert warning");
		$.ajax({
			url: base_url+"iniciar-sesion",
			data: { "email_cliente": usuario, "password_cliente": contrasena },
			type: "post",
			dataType: "json",

			success: function(respuesta) {
				if(respuesta.estatus == 'error') {
					$mensaje_div.html(respuesta.mensaje);
					$mensaje.fadeIn(100).addClass("alert").removeClass("primary info warning");
				} else if(respuesta.estatus == 'verificado') {
					$("#camp_login_button").prop("disabled", true).hide(0);
					$mensaje_div.html(respuesta.mensaje);
					$mensaje.fadeIn(100).addClass("primary success").removeClass("warning info alert");
					setTimeout(function() {
						window.location.reload();
					}, 1000)
				}
			},
			error: function(respuesta) {
				$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
				$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
			}
		});
	}
});

// Recuperar
$("#forgot_form").submit(function(e) {
	e.preventDefault();

	$mensaje = $("#mensaje_forgot");
	$mensaje_div = $("#mensaje_forgot div");

	$mensaje_div.html('');
	var usuario = $.trim($("#email_cliente_forgot").val());

	if(usuario == '') {
		$mensaje_div.html("Por favor introduce todos los datos.");
		$mensaje.fadeIn(100);
	} else {
		$mensaje_div.html("Validando datos.");
		$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
		$.ajax({
			url: base_url+"enviar-recuperacion",
			data: { "email_cliente_forgot": usuario },
			type: "post",
			dataType: "json",

			success: function(respuesta) {
				if(respuesta.estatus == 'error') {
					$mensaje_div.html(respuesta.mensaje);
					$mensaje.fadeIn(100).addClass("alert").removeClass("primary warning");
				} else if(respuesta.estatus == 'verificado') {
					$("#login_button").prop("disabled", true).hide(0);
					$mensaje_div.html(respuesta.mensaje);
					$mensaje.fadeIn(100).addClass("primary").removeClass("warning alert");
				}
			},
			error: function(respuesta) {
				$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
				$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
			}
		});
	}
});

// Registro
$("#register_form").submit(function(e) {
	e.preventDefault();

	$mensaje = $("#mensaje_registro");
	$mensaje_div = $("#mensaje_registro div");

	$mensaje_div.html('');
	var nombre = $.trim($("#nombre_nuevo").val());
	var apellido = $.trim($("#apellido_nuevo").val());
	var email = $.trim($("#email_nuevo").val());
	var telefono = $.trim($("#telefono_nuevo").val());
	var cumple = $.trim($("#cumple").val());
	var genero = $.trim($("#genero_nuevo").val());
	var contrasena = $.trim($("#password_nuevo").val());
	var contrasena_repetir = $.trim($("#password_nuevo_repetir").val());

	if(nombre == '' || apellido == '' || email == '' || telefono == '' || cumple == ''|| contrasena == '' || contrasena_repetir == '' || genero == '') {
		$mensaje_div.html("Por favor introduce todos los datos.");
		$mensaje.fadeIn(100);
	} else {
		var data = {
			"nombre": nombre,
			"apellido": apellido,
			"email": email,
			"telefono": telefono,
			"cumple": cumple,
			"genero": genero,
			"contrasena": contrasena,
			"contrasena_repetir": contrasena_repetir,
		}
		$mensaje_div.html("Validando datos.");
		$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
		$.ajax({
			url: base_url+"registrar",
			data: data,
			type: "post",
			dataType: "json",

			success: function(respuesta) {
				if(respuesta.estatus == 'error') {
					$mensaje_div.html(respuesta.mensaje);
					$mensaje.fadeIn(100).addClass("alert").removeClass("primary warning");
				} else if(respuesta.estatus == 'verificado') {
					$("#login_button").prop("disabled", true).hide(0);
					$mensaje_div.html(respuesta.mensaje);
					$mensaje.fadeIn(100).addClass("primary").removeClass("warning alert");
					$("#register_form input, #register_form select").val('');
					setTimeout(function() {
						window.location.reload();
					}, 3500)
				}
			},
			error: function(respuesta) {
				$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
				$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
			}
		});
	}
});

//Registro datos bancarios
$("select#select_pagos").change(function () {
	if($(this).val() == "PayPal"){
		$("#contenedor_banco").fadeOut('3');
		$("#contenedor_paypal").fadeIn('15');
		$("input#campana_email_paypal").attr('required');
	}else if($(this).val() == "Banco"){
		$("#contenedor_paypal").fadeOut('3');
		$("#contenedor_banco").fadeIn('15');
		$("input#nombre_cuentahabiente").attr('required');
		$("input#nombre_banco").attr('required');
		$("input#clabe_interbancaria").attr('required');
		$("input#cuenta_banco").attr('required');
		$("input#ciudad").attr('required');
		$("input#sucursal").attr('required');
	}else{
		$("#contenedor_banco").fadeOut('15');
		$("#contenedor_paypal").fadeOut('15');
		$("input#nombre_cuentahabiente").prop('required');
		$("input#nombre_banco").prop('required');
		$("input#clabe_interbancaria").prop('required');
		$("input#cuenta_banco").prop('required');
		$("input#ciudad").prop('required');
		$("input#sucursal").prop('required');
		$("input#campana_email_paypal").prop('required');
	}
});

$("button.boton_datos_bancarios").click(function(e){
	e.preventDefault();
	var id_cliente = $("input#id_cliente").val();
	$mensaje = $(".campana_mensaje_deposito");
	$mensaje_div = $(".campana_mensaje_deposito div");
	$(".mensaje-verificar").fadeOut(100);
	$mensaje_div.html('');
	if($("select#select_pagos").val() == "PayPal"){
		var mail_paypal = $.trim($("input#campana_email_paypal").val());
		if(mail_paypal == '') {
			$mensaje_div.html("Por favor introduce todos los datos.");
			$mensaje.fadeIn(100);
		} else {
			var info_pago = {
				"tipo_pago": "paypal",
				"cuenta_paypal": mail_paypal,
				"id_cliente" : id_cliente
			}
			$mensaje_div.html("Validando datos.");
			$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
			$.ajax({
				url: base_url+"campanas/registrar-datos-deposito",
				data: {info_pago : info_pago},
				type: "post",
				dataType: "json",

				success: function(respuesta) {
					if(respuesta.estatus == 'error') {
						$mensaje_div.html(respuesta.mensaje);
						$mensaje.fadeIn(100).addClass("alert").removeClass("primary warning");
					} else if(respuesta.estatus == 'verificado') {
						$("#campana_register_paypal").prop("disabled", true).hide(0);
						$mensaje_div.html(respuesta.mensaje);
						$mensaje.fadeIn(100).addClass("primary success").removeClass("info warning alert");
						$("#contenedor_paypal input, #campana_pagos_form select").val('');
						setTimeout(function() {
							window.location.reload();
						}, 2000)
					}
				},
				error: function(respuesta) {
					$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
					$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
					$(".mensaje-verificar").fadeIn(100);
				}
			});
		}
	}else if($("select#select_pagos").val() == "Banco"){

		var nombre_cuentahabiente = $.trim($("input#nombre_cuentahabiente").val());
		var nombre_banco = $.trim($("input#nombre_banco").val());
		var clabe_interbancaria = $.trim($("input#clabe_interbancaria").val());
		var cuenta_banco = $.trim($("input#cuenta_banco").val());
		var ciudad = $.trim($("input#ciudad").val());
		var sucursal = $.trim($("input#sucursal").val());

		if(nombre_cuentahabiente == '' || nombre_banco == '' || clabe_interbancaria == '' || cuenta_banco == '' || ciudad == '' || sucursal == '' ) {
			$mensaje_div.html("Por favor introduce todos los datos.");
			$mensaje.fadeIn(100);
		} else {
			var info_pago = {
				"tipo_pago" : "banco",
				"nombre_cuentahabiente" : nombre_cuentahabiente,
				"nombre_banco" : nombre_banco,
				"clabe" : clabe_interbancaria,
				"cuenta" : cuenta_banco,
				"ciudad" :ciudad,
				"sucursal" : sucursal,
				"id_cliente" : id_cliente
			}
			$mensaje_div.html("Validando datos.");
			$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
			$.ajax({
				url: base_url+"campanas/registrar-datos-deposito",
				data: {info_pago : info_pago},
				type: "post",
				dataType: "json",

				success: function(respuesta) {
					if(respuesta.estatus == 'error') {
						$mensaje_div.html(respuesta.mensaje);
						$mensaje.fadeIn(100).addClass("alert").removeClass("primary warning");
					} else if(respuesta.estatus == 'verificado') {
						$("#campana_register_banco").prop("disabled", true).hide(0);
						$mensaje_div.html(respuesta.mensaje);
						$mensaje.fadeIn(100).addClass("primary success").removeClass("info warning alert");
						$("#contenedor_banco input, #campana_pagos_form select").val('');
						setTimeout(function() {
							window.location.reload();
						}, 2000)
					}
				},
				error: function(respuesta) {
					$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
					$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
					$(".mensaje-verificar").fadeIn(100);
				}
			});
		}
	}
});



// Registro campana
$("#campana_register_form").submit(function(e) {
	e.preventDefault();

	$mensaje = $("#campana_mensaje_registro");
	$mensaje_div = $("#campana_mensaje_registro div");

	$mensaje_div.html('');
	var nombre = $.trim($("#campana_nombre_nuevo").val());
	var apellido = $.trim($("#campana_apellido_nuevo").val());
	var email = $.trim($("#campana_email_nuevo").val());
	var telefono = $.trim($("#campana_telefono_nuevo").val());
	var cumple = $.trim($("#campana_cumple_nuevo").val());
	var genero = $.trim($("#campana_genero_nuevo").val());
	var contrasena = $.trim($("#campana_password_nuevo").val());
	var contrasena_repetir = $.trim($("#campana_password_nuevo_repetir").val());

	if(nombre == '' || apellido == '' || email == '' || telefono == '' || cumple == ''|| contrasena == '' || contrasena_repetir == '' || genero == '') {
		$mensaje_div.html("Por favor introduce todos los datos.");
		$mensaje.fadeIn(100);
	} else {
		var data = {
			"nombre": nombre,
			"apellido": apellido,
			"email": email,
			"telefono": telefono,
			"cumple": cumple,
			"genero": genero,
			"contrasena": contrasena,
			"contrasena_repetir": contrasena_repetir,
		}
		$mensaje_div.html("Validando datos.");
		$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
		$.ajax({
			url: base_url+"registrar",
			data: data,
			type: "post",
			dataType: "json",

			success: function(respuesta) {
				if(respuesta.estatus == 'error') {
					$mensaje_div.html(respuesta.mensaje);
					$mensaje.fadeIn(100).addClass("alert").removeClass("primary warning");
				} else if(respuesta.estatus == 'verificado') {
					$("#campana_register_button").prop("disabled", true).hide(0);
					$mensaje_div.html(respuesta.mensaje);
					$mensaje.fadeIn(100).addClass("primary success").removeClass("info warning alert");
					$("#campana_register_form input, #campana_register_form select").val('');
					setTimeout(function() {
						window.location.reload();
					}, 4500)
				}
			},
			error: function(respuesta) {
				$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
				$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
			}
		});
	}
});


$(".borrar_direccion").click(function() {
	var info_direccion = $(this).parent().parent().data('direccion');
	$("#id_direccion_bor").val(info_direccion.id_direccion);
});

$(".borrar_facturacion").click(function() {
	var info_direccion = $(this).parent().parent().data('direccion');
	$("#id_direccion_fiscal_bor").val(info_direccion.id_direccion_fiscal);
});

jQuery.extend(jQuery.fn.pickadate.defaults,{monthsFull:["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"],monthsShort:["ene","feb","mar","abr","may","jun","jul","ago","sep","oct","nov","dic"],weekdaysFull:["domingo","lunes","martes","miércoles","jueves","viernes","sábado"],weekdaysShort:["dom","lun","mar","mié","jue","vie","sáb"],today:"hoy",clear:"borrar",close:"cerrar",firstDay:1,format:"yyyy-mm-dd",formatSubmit:"yyyy-mm-dd"});

$('#cumple_nuevo, #fecha_nacimiento, #campana_cumple_nuevo').pickadate({
	max: new Date(),
	closeOnSelect: true,
	container: 'body',
	selectYears: true,
	selectMonths: true,
	selectYears: 100
});

$(".fbloginbutton").click(function() {
	FB.login(function(){
		loginCheck();
		//window.location.reload();
	}, {scope: 'public_profile,email', auth_type: 'rerequest'});
});

$("#cerrar-link-fb1").click(function(e) {
	e.preventDefault();

	FB.logout(function(response) {
	$.ajax({
		url: base_url+"registro/cerrar_sesion_ajax",
		type: "get",
		success: function(respuesta) {
			window.location.href=base_url;
		}
	});
	});
});

$("#cerrar-link-fb2").click(function(e) {
	e.preventDefault();

	FB.logout(function(response) {
		$.ajax({
			url: base_url+"registro/cerrar_sesion_ajax",
			type: "get",
			success: function(respuesta) {
				window.location.href=base_url;
			}
		});
	});
});

$(".timer-corto").each(function() {
	var tiempo = $(this).data("countdown");
	var fecha = moment.tz(tiempo, 'America/Merida');

	$(this).countdown(fecha.toDate(), function(event) {
		$(this).html(event.strftime('<span class="quedan">Quedan</span> <span class="f">%-D</span> <span class="quedan">días</span>'));
	});
});


// Contacto
$("#contact_form_ac").submit(function(e) {
	e.preventDefault();

	$mensaje = $("#mensaje_contacto_generico_ac");
	$mensaje_div = $("#mensaje_contacto_generico_ac div");

	$mensaje_div.html('');

	var nombre = $("#nombre_contacto_ac").val(),
	nombre_ac = $("#nombre_ac").val(),
	email = $("#email_contacto_ac").val(),
	telefono = $("#telefono_contacto_ac").val(),
	mensaje = $("#mensaje_contacto_ac").val();

	if(nombre == '' || nombre_ac == '' || telefono == '' || email == '' || mensaje == '') {
		$mensaje_div.html("Por favor introduce todos los datos.");
		$mensaje.fadeIn(100);
	} else {
		$mensaje_div.html("Validando datos.");
		$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
		$("#contacto_button_ac").prop("disabled", true);

		$.ajax({
			url: base_url+"asociaciones-civiles/contacto",
			data: {
				nombre: nombre,
				nombre_ac: nombre_ac,
				email: email,
				telefono: telefono,
				mensaje: mensaje
			},
			type: "post",
			dataType: "json",

			success: function(respuesta) {

				if(respuesta.resultado == 'exito') {
					$("#contact_form_ac input, #contact_form_ac textarea, #contact_form_ac button, #contact_form_ac label, #contact_form_ac .add-buttons a[data-close]").hide();
					$mensaje_div.html("Tu mensaje ha sido enviado, lo revisaremos a la brevedad posible.");
					$mensaje.fadeIn(100).addClass("primary").removeClass("warning alert");
				} else {
					$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
					$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
					$("#contacto_button_ac").prop("disabled", false);
				}

				if(typeof gtag != 'undefined') {
					gtag('event', 'Clic', {
						'event_category' : 'Interacción',
						'event_label' : 'Contacto-AC',
						'value': 0
					});
				}

			},
			fail: function(respuesta) {

				$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
				$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
				$("#contacto_button_ac").prop("disabled", false);
			}
		});
	}
});

//aqui empieza lo de las direcciones de mi-cuenta
//agregar nueva direccion de entregas
$("#codigo_postal").focusout(function() {
	if($("#codigo_postal").val().length != 0) {
		var codigo_postal = $("#codigo_postal").val();
		$.ajax({
			url: base_url+"carrito/obtener_datos_direccion",
			type: 'get',
			data:{codigo_postal: codigo_postal},
			dataType: 'json',
		beforeSend: function(){
			$("#linea1").prop('disabled', true);
			$("#ciudad").prop('disabled', true);
			$("#estado").prop('disabled', true);
			$("#linea2").prop('disabled', true);
			$("#loader").css('display', 'block');
			$('#linea2').html('');
		},
		success: function(data){
			var direcciones = data;
			if(typeof direcciones[0] !== 'undefined'){
				if(typeof direcciones[0].ciudad_asentamiento !== 'undefined'){
					$("#ciudad").val(direcciones[0].ciudad_asentamiento);
				}
				$("#estado").val(direcciones[0].nombre_estado);
				for(i=0; i < direcciones.length; i++){
					$("#linea2").append("<option value='"+direcciones[i].nombre_asentamiento+"'>"+direcciones[i].nombre_asentamiento+"</option>");
				}
				$("#linea2").append("<option id='otro' value='Otro'>Otro</option>");
				$("#linea1").prop('disabled', false);
				$("#ciudad").prop('disabled', false);
				$("#estado").prop('disabled', false);
				$("#linea2").prop('disabled', false);
				$("#colonia-otro").hide('15', 'swing');
			}else{
				alert("No contamos con información sobre el codigo postal ingresado, favor de ingresar su información manualmente.")
				$("#linea2").append("<option selected='selected' id='otro' value='Otro'>Otro</option>");
				$("#linea1").prop('disabled', false);
				$("#ciudad").prop('disabled', false);
				$("#estado").prop('disabled', false);
				$("#linea2").prop('disabled', false);
				$("#colonia-otro").show('15', 'swing');
			}
		},
		complete: function(){
			$("#loader").css('display', 'none');
		}
	});
	}
});

$("#linea2").change(function () {
	var seleccionado = $(this).children("option:selected").val();
	if(seleccionado === "Otro"){
		$("#colonia-otro").show('15', 'swing');
	}else{
		$("#colonia-otro").hide('15', 'swing');
	}
});
//funcion para editar una direccion de entrega existente
	var detectar_colonias_editar = function (info_colonia){
		if ($("#codigo_postal_mod").val().length != 0) {
			var codigo_postal = $("#codigo_postal_mod").val();
			$.ajax({
				url: base_url + "carrito/obtener_datos_direccion",
				type: 'get',
				data: {codigo_postal: codigo_postal},
				dataType: "json",
				beforeSend: function () {
					$("#linea1_mod").prop('disabled', true);
					$("#ciudad_mod").prop('disabled', true);
					$("#estado_mod").prop('disabled', true);
					$("#linea2_mod").prop('disabled', true);
					$("#loader_fiscal").css('display', 'block');
					$('#linea2_mod').html('');
				},
				success: function (data) {
					var direcciones = data;
					if (typeof direcciones[0] !== 'undefined') {
						$("#colonia-otro-mod").hide('15', 'swing');
						if (typeof direcciones[0].ciudad_asentamiento !== 'undefined') {
							$("#ciudad_mod").val(direcciones[0].ciudad_asentamiento);
						}
						$("#estado_mod").val(direcciones[0].nombre_estado);
						for (i = 0; i < direcciones.length; i++) {
							$("#linea2_mod").append("<option value='" + direcciones[i].nombre_asentamiento + "'>" + direcciones[i].nombre_asentamiento + "</option>");
						}
						$("#linea2_mod").append("<option id='otro' value='Otro'>Otro</option>");
						$("#linea1_mod").prop('disabled', false);
						$("#ciudad_mod").prop('disabled', false);
						$("#estado_mod").prop('disabled', false);
						$("#linea2_mod").prop('disabled', false);
						var existe = false;
						if (info_colonia !== 0) {
							for (i = 0; i < direcciones.length; i++) {
								if(info_colonia == direcciones[i].nombre_asentamiento){
									existe = true;
									break;
								}else{
									existe = false;
								}
							}
							if(existe){
								$("#colonia-otro-mod").hide('15', 'swing');
								$("#linea2_mod").val(info_colonia);
							}else{
								$("#colonia-otro-mod").show('15', 'swing');
								$("#linea2_mod").val("Otro");
								$("#linea2_mod_otro").val(info_colonia);
							}
						}
					} else {
						alert("No contamos con información sobre el codigo postal ingresado, favor de ingresar su información manualmente.")
						$("#linea2_mod").append("<option selected='selected' id='otro' value='Otro'>Otro</option>");
						$("#linea1_mod").prop('disabled', false);
						$("#ciudad_mod").prop('disabled', false);
						$("#estado_mod").prop('disabled', false);
						$("#linea2_mod").prop('disabled', false);
						$("#colonia-otro-mod").show('15', 'swing');
						if (info_colonia !== 0) {
							$("#linea2_mod_otro").val(info_colonia);
						}
					}
				},
				complete: function () {
					$("#loader_fiscal").css('display', 'none');
				}
			});
		}
	}

$("#codigo_postal_mod").focusout(function() {
	detectar_colonias_editar(0)
});

$("#linea2_mod").change(function () {
	var seleccionado = $(this).children("option:selected").val();
	if(seleccionado === "Otro"){
		$("#colonia-otro-mod").show('15', 'swing');
	}else{
		$("#colonia-otro-mod").hide('15', 'swing');
	}
});
//accion que utiliza la funcion de edicion de direccion de entrega
$(".editar_direccion").click(function() {
	var info_direccion = $(this).parent().parent().data('direccion');
	$("#identificador_direccion_mod").val(info_direccion.identificador_direccion);
	$("#linea1_mod").val(info_direccion.linea1);
	$("#ciudad_mod").val(info_direccion.ciudad);
	$("#codigo_postal_mod").val(info_direccion.codigo_postal);
	detectar_colonias_editar(info_direccion.linea2);
	$("#estado_mod").val(info_direccion.estado);
	$("#telefono_mod").val(info_direccion.telefono);
	$("#id_direccion_mod").val(info_direccion.id_direccion);
});

$(".editar_facturacion").click(function() {
	var info_direccion = $(this).parent().parent().data('direccion');
	$("#razon_social_mod").val(info_direccion.razon_social);
	$("#rfc_mod").val(info_direccion.rfc);
	$("#linea1_mod").val(info_direccion.linea1);
	$("#ciudad_mod").val(info_direccion.ciudad);
	$("#codigo_postal_mod").val(info_direccion.codigo_postal);
	detectar_colonias_editar(info_direccion.linea2);
	$("#estado_mod").val(info_direccion.estado);
	$("#id_direccion_fiscal_mod").val(info_direccion.id_direccion_fiscal);
	$("#correo_electronico_facturacion_mod").val(info_direccion.correo_electronico_facturacion);
	$("#telefono_mod").val(info_direccion.telefono);
});

// Bloque de funciones de twilio para direcciones en mi-cuenta
if($("#subseccion-activa").val() === "direcciones"){
	let iti_nueva_dir = null;
	let validacion_form_nueva_dir = false;

	$("#telefono").ready(function(){
		const input = document.querySelector("#telefono");
		iti_nueva_dir = window.intlTelInput(input, {
			onlyCountries: ['us', 'mx', 'ca'],
			preferredCountries: ['mx'],
			initialCountry: 'mx',
			separateDialCode: true,
			utilsScript: "assets/js/IntlTelInput/utils.js",
		});
	});

	$("#nueva_dir_cuenta").submit(function(event){
		event.preventDefault();
		validacion_form_nueva_dir = ($("#nueva_dir_cuenta input.is-invalid-input").length > 0);
		if(!validacion_form_nueva_dir) {
			const num_tel = iti_nueva_dir.getNumber(intlTelInputUtils.numberFormat.E164);
			$.ajax({
				url: "registro-telefono-twilio",
				data: {
					num_tel: num_tel
				},
				method: "GET",
				beforeSend: function () {
					$("#telefono").removeClass("is-invalid-input");
					$("#nueva-error-tel").removeClass("is-visible");
					$("#nueva-label-tel").removeClass("is-invalid-label");
					$("#loader_direcciones").show(10);
				},
				success: function (response) {
					response = $.parseJSON(response);
					if (response.estatus) {
						const input_tipo_tel = $("<input>").attr("type", "hidden").attr("name", "tipo_tel").val(response.type);
						$("#nueva_dir_cuenta").append(input_tipo_tel);
						enviar_formulario_nueva_direccion(num_tel);
						validacion_form_nueva_dir = true;
					} else {
                        $("#loader_direcciones").hide(10);
						$("#telefono").addClass("is-invalid-input").attr("aria-invalid", "true");
						$("#nueva-error-tel").html(response.message).addClass("is-visible").css("margin-top", "0.1rem");
						$("#nueva-label-tel").addClass("is-invalid-label");
						validacion_form_nueva_dir = false;
					}
				}
			});
		}
	});

	function enviar_formulario_nueva_direccion(tipo_tel){
		$.ajax({
			url: "mi-cuenta/direcciones/agregar",
			data: {
				identificador_direccion : $("#identificador_direccion").val(),
				codigo_postal: $("#codigo_postal").val(),
				ciudad : $("#ciudad").val(),
				linea1 : $("#linea1").val(),
				linea2 : $("#linea2").val(),
				linea2_otro : $("#linea2_otro").val(),
				estado : $("#estado").val(),
				telefono : $("#telefono").val(),
				tipo_telefono : tipo_tel,
				id_cliente : $("#id_cliente").val()
			},
			method: "POST",
			success: function(response){
				location.reload();
			}
		});
	}

	let iti_editar_dir = null;
	let validacion_form_editar_dir = false;

	$("#telefono_mod").ready(function(){
		const input = document.querySelector("#telefono_mod");
		iti_editar_dir = window.intlTelInput(input, {
			onlyCountries: ['us', 'mx', 'ca'],
			preferredCountries: ['mx'],
			initialCountry: 'mx',
			separateDialCode: true,
			utilsScript: "assets/js/IntlTelInput/utils.js",
		});
	});

	$("#editar_dir_cuenta").submit(function (event) {
		event.preventDefault();
		validacion_form_editar_dir = ($("#editar_dir_cuenta input.is-invalid-input").length > 0);
		if(!validacion_form_editar_dir) {
			const num_tel = iti_editar_dir.getNumber(intlTelInputUtils.numberFormat.E164);
			$.ajax({
				url: "registro-telefono-twilio",
				data: {
					num_tel: num_tel
				},
				method: "GET",
				beforeSend: function () {
					$("#telefono_mod").removeClass("is-invalid-input");
					$("#editar-error-tel").removeClass("is-visible");
					$("#editar-label-tel").removeClass("is-invalid-label");
                    $("#loader_direcciones").show(10);
				},
				success: function (response) {
					response = $.parseJSON(response);
					if (response.estatus) {
						const input_tipo_tel = $("<input>").attr("type", "hidden").attr("name", "tipo_tel").val(response.type);
						$("#editar_dir_cuenta").append(input_tipo_tel);
						enviar_formulario_editar_direccion(num_tel);
						validacion_form_nueva_dir = true;
					} else {
                        $("#loader_direcciones").hide(10);
						$("#telefono_mod").addClass("is-invalid-input");
						$("#editar-error-tel").html(response.message).addClass("is-visible");
						$("#editar-label-tel").addClass("is-invalid-label");
						validacion_form_editar_dir = false;
					}
				}
			});
		}
	});

	function enviar_formulario_editar_direccion(tipo_tel){
		$.ajax({
			url: "mi-cuenta/direcciones/editar",
			data: {
				identificador_direccion : $("#identificador_direccion_mod").val(),
				codigo_postal: $("#codigo_postal_mod").val(),
				ciudad : $("#ciudad_mod").val(),
				linea1 : $("#linea1_mod").val(),
				linea2 : $("#linea2_mod").val(),
				linea2_otro : $("#linea2_mod_otro").val(),
				estado : $("#estado_mod").val(),
				telefono : $("#telefono_mod").val(),
				tipo_telefono : tipo_tel,
				id_cliente : $("#id_cliente_mod").val(),
				id_direccion : $("#id_direccion_mod").val()
			},
			method: "POST",
			success: function(response){
				location.reload();
			}
		});
	}
}
else if($("#subseccion-activa").val() === "datos"){
	let iti_cuenta = null;

	let validacion_form_datos = false;
	$("#telefono_cuenta").ready(function () {
		const input = document.querySelector("#telefono_cuenta");
		iti_cuenta = window.intlTelInput(input, {
			onlyCountries: ['us', 'mx', 'ca'],
			preferredCountries: ['mx'],
			initialCountry: 'mx',
			separateDialCode: true,
			utilsScript: "assets/js/IntlTelInput/utils.js",
		});
	});

	$("#form_cuenta_datos").submit(function (event) {
		event.preventDefault();
		validacion_form_datos = ($("#form_cuenta_datos input.is-invalid-input").length > 0);
		if(!validacion_form_datos) {
			const num_tel = iti_cuenta.getNumber(intlTelInputUtils.numberFormat.E164);
			$.ajax({
				url: "registro-telefono-twilio",
				data: {
					num_tel: num_tel
				},
				method: "GET",
				beforeSend: function () {
					$("#telefono_cuenta").removeClass("is-invalid-input");
					$("#tel_cuenta_error").removeClass("is-visible");
					$("#tel_label_cuenta").removeClass("is-invalid-label");
					$("#loader_direcciones").show(10);
				},
				success: function (response) {
					response = $.parseJSON(response);
					if (response.estatus) {
						enviar_formulario_cuenta(num_tel);
						validacion_form_datos = true;
					} else {
						$("#loader_direcciones").hide(10);
						$("#telefono_cuenta").addClass("is-invalid-input");
						$("#tel_cuenta_error").html(response.message).addClass("is-visible");
						$("#tel_label_cuenta").addClass("is-invalid-label");
						validacion_form_datos = false;
					}
				}
			});
		}
	});

	function enviar_formulario_cuenta(tipo_tel){
		$.ajax({
			url: "mi-cuenta/datos/actualizar",
			data: {
				nombres : $("#nombres_cuenta").val(),
				apellidos : $("#apellidos_cuenta").val(),
				fecha_nacimiento : $("#fecha_nacimiento").val(),
				genero : $("#genero").val(),
				telefono : $("#telefono_cuenta").val(),
				id_cliente : $("#id_cliente_cuenta").val()
			},
			method: "POST",
			success: function(response){
				location.reload();
			}
		});
	}
}
else if($("#subseccion-activa").val() === "facturacion"){
	let iti_nueva_factura = null;
	let validacion_form_nueva_factura = false;

	$("#telefono").ready(function(){
		const input = document.querySelector("#telefono");
		iti_nueva_factura = window.intlTelInput(input, {
			onlyCountries: ['us', 'mx', 'ca'],
			preferredCountries: ['mx'],
			initialCountry: 'mx',
			separateDialCode: true,
			utilsScript: "assets/js/IntlTelInput/utils.js",
		});
	});

	$("#nueva_factura").submit(function(event){
		event.preventDefault();
		val_rfc = $("#rfc").val();
		val_cfdi = $("#cfdi").val();
		if(val_rfc === ''){
			$("#rfc").addClass("is-invalid-input");
		}else{
			$("#rfc").removeClass("is-invalid-input");
		}
		if(val_cfdi === ''){
			$("#cfdi").addClass("is-invalid-input");
		}else{
			$("#cfdi").removeClass("is-invalid-input");
		}
		validacion_form_nueva_factura = ($("#nueva_factura input.is-invalid-input").length > 0);
		if(!validacion_form_nueva_factura) {
			const num_tel = iti_nueva_factura.getNumber(intlTelInputUtils.numberFormat.E164);
			$.ajax({
				url: "registro-telefono-twilio",
				data: {
					num_tel: num_tel
				},
				method: "GET",
				beforeSend: function () {
					$("#telefono").removeClass("is-invalid-input");
					$("#fac-error-tel").removeClass("is-visible");
					$("#fac-label-tel").removeClass("is-invalid-label");
					$("#loader_direcciones").show(10);
				},
				success: function (response) {
					response = $.parseJSON(response);
					if (response.estatus) {
						const input_tipo_tel = $("<input>").attr("type", "hidden").attr("name", "tipo_tel").val(response.type);
						$("#nueva_factura").append(input_tipo_tel);
						enviar_formulario_nueva_factura(num_tel);
						validacion_form_nueva_factura = true;
					} else {
						$("#loader_direcciones").hide(10);
						$("#telefono").addClass("is-invalid-input").attr("aria-invalid", "true");
						$("#fac-error-tel").html(response.message).addClass("is-visible").css("margin-top", "0.1rem");
						$("#fac-label-tel").addClass("is-invalid-label");
						validacion_form_nueva_factura = false;
					}
				}
			});
		}
	});

	function enviar_formulario_nueva_factura(tipo_tel){
		$.ajax({
			url: "mi-cuenta/facturacion/agregar",
			data: {
				razon_social : $("#razon_social").val(),
				rfc : $("#rfc").val(),
				cfdi : $("#cfdi").val(),
				codigo_postal: $("#codigo_postal").val(),
				ciudad : $("#ciudad").val(),
				linea1 : $("#linea1").val(),
				linea2 : $("#linea2").val(),
				linea2_otro : $("#linea2_otro").val(),
				estado : $("#estado").val(),
				correo_electronico_facturacion : $("#correo_electronico_facturacion").val(),
				telefono : $("#telefono").val(),
				tipo_telefono : tipo_tel,
				id_cliente : $("#id_cliente_fac").val()
			},
			method: "POST",
			success: function(response){
				location.reload();
			}
		});
	}

	let iti_editar_factura = null;
	let validacion_form_editar_factura = false;

	$("#telefono_mod").ready(function(){
		const input = document.querySelector("#telefono_mod");
		iti_editar_factura = window.intlTelInput(input, {
			onlyCountries: ['us', 'mx', 'ca'],
			preferredCountries: ['mx'],
			initialCountry: 'mx',
			separateDialCode: true,
			utilsScript: "assets/js/IntlTelInput/utils.js",
		});
	});

	$("#editar_factura").submit(function (event) {
		event.preventDefault();
		val_rfc = $("#rfc_mod").val();
		val_cfdi = $("#cfdi_mod").val();
		if(val_rfc === ''){
			$("#rfc_mod").addClass("is-invalid-input");
		}else{
			$("#rfc_mod").removeClass("is-invalid-input");
		}
		if(val_cfdi === ''){
			$("#cfdi_mod").addClass("is-invalid-input");
		}else{
			$("#cfdi_mod").removeClass("is-invalid-input");
		}
		validacion_form_editar_factura = ($("#editar_factura input.is-invalid-input").length > 0);
		if(!validacion_form_editar_factura) {
			const num_tel = iti_editar_factura.getNumber(intlTelInputUtils.numberFormat.E164);
			$.ajax({
				url: "registro-telefono-twilio",
				data: {
					num_tel: num_tel
				},
				method: "GET",
				beforeSend: function () {
					$("#telefono_mod").removeClass("is-invalid-input");
					$("#editar-error-fac").removeClass("is-visible");
					$("#editar-label-fac").removeClass("is-invalid-label");
					$("#loader_direcciones").show(10);
				},
				success: function (response) {
					response = $.parseJSON(response);
					if (response.estatus) {
						const input_tipo_tel = $("<input>").attr("type", "hidden").attr("name", "tipo_tel").val(response.type);
						$("#editar_factura").append(input_tipo_tel);
						enviar_formulario_editar_factura(num_tel);
						validacion_form_editar_factura = true;
					} else {
						$("#loader_direcciones").hide(10);
						$("#telefono_mod").addClass("is-invalid-input");
						$("#editar-error-fac").html(response.message).addClass("is-visible");
						$("#editar-label-fac").addClass("is-invalid-label");
						validacion_form_editar_factura = false;
					}
				}
			});
		}
	});

	function enviar_formulario_editar_factura(tipo_tel){
		$.ajax({
			url: "mi-cuenta/facturacion/editar",
			data: {
				razon_social : $("#razon_social_mod").val(),
				rfc : $("#rfc_mod").val(),
				cfdi : $("#cfdi_mod").val(),
				codigo_postal: $("#codigo_postal_mod").val(),
				ciudad : $("#ciudad_mod").val(),
				linea1 : $("#linea1_mod").val(),
				linea2 : $("#linea2_mod").val(),
				linea2_otro : $("#linea2_mod_otro").val(),
				estado : $("#estado_mod").val(),
				correo_electronico_facturacion : $("#correo_electronico_facturacion_mod").val(),
				telefono : $("#telefono_mod").val(),
				tipo_telefono : tipo_tel,
				id_cliente : $("#id_cliente_fac_mod").val()
			},
			method: "POST",
			success: function(response){
				location.reload();
			}
		});
	}
}

// fin de bloque de mi-cuenta twilio