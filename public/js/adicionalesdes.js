jQuery(document).ready(function() {

	jQuery(".no-encuentras").click(function(e) {
		jQuery('#paynow_modal').modal('hide');
	});

	// Contacto
	jQuery("#contact_form").submit(function(e) {
		e.preventDefault();

		$mensaje = jQuery("#mensaje_contacto_generico");
		$mensaje_div = jQuery("#mensaje_contacto_generico div");

		$mensaje_div.html('');

		var nombre = jQuery("#nombre_contacto").val(),
		email = jQuery("#email_contacto").val(),
		asunto = jQuery("#asunto_contacto").val(),
		lugar = jQuery("#lugar_contacto").val(),
		url = current_url,
		mensaje = jQuery("#mensaje_contacto").val(),
		telefono = jQuery("#telefono_contacto").val(),
		template = $("#template_contacto").val();

		if(nombre == '' || email == '' || mensaje == '' || telefono == '') {
			$mensaje_div.html("Por favor introduce todos los datos.");
			$mensaje.fadeIn(100);
		} else {
			$mensaje_div.html("Validando datos.");
			$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
			jQuery("#contacto_button").prop("disabled", true);

			jQuery.ajax({
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
						jQuery("#contact_form input, #contact_form textarea, #contact_form button, #contact_form label, #contact_form .add-buttons a[data-close]").hide();
						$mensaje_div.html("Tu mensaje ha sido enviado, lo revisaremos a la brevedad posible.");
						$mensaje.fadeIn(100).addClass("primary").removeClass("warning alert");
					} else {
						$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
						$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
						jQuery("#contacto_button").prop("disabled", false);
					}

				},
				fail: function(respuesta) {

					$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
					$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
					jQuery("#contacto_button").prop("disabled", false);
				}
			});
		}
	});

	// Contacto
	jQuery("#contact_form_footer").submit(function(e) {
		e.preventDefault();

		$mensaje = jQuery("#mensaje_contacto_generico_footer");
		$mensaje_div = jQuery("#mensaje_contacto_generico_footer div");

		$mensaje_div.html('');

		var nombre = jQuery("#nombre_contacto_footer").val(),
		email = jQuery("#email_contacto_footer").val(),
		asunto = jQuery("#asunto_contacto_footer").val(),
		lugar = jQuery("#lugar_contacto_footer").val(),
		url = current_url,
		telefono = jQuery("#telefono_contacto_footer").val(),
		mensaje = jQuery("#mensaje_contacto_footer").val(),
		template = jQuery("#template_contacto_footer").val();

		if(nombre == '' || email == '' || mensaje == '' || telefono == '') {
			$mensaje_div.html("Por favor introduce todos los datos.");
			$mensaje.fadeIn(100);
		} else {
			$mensaje_div.html("Validando datos.");
			$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
			jQuery("#contacto_button_footer").prop("disabled", true);

			jQuery.ajax({
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
						jQuery("#contact_form_footer .input-group, #contact_form_footer input, #contact_form_footer textarea, #contact_form_footer button, #contact_form_footer label, #contact_form_footer .add-buttons a[data-close]").hide();
						$mensaje_div.html("Tu mensaje ha sido enviado, lo revisaremos a la brevedad posible.");
						$mensaje.fadeIn(100).addClass("primary success").removeClass("warning alert");
					} else {
						$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
						$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary success");
						jQuery("#contacto_button_footer").prop("disabled", false);
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
					jQuery("#contacto_button_footer").prop("disabled", false);
				}
			});
		}
	});

	// Login
	jQuery("#login_form").submit(function(e) {
		e.preventDefault();

		var mensaje = jQuery("#mensaje_inicio_sesion");
		var mensaje_div = jQuery("#mensaje_inicio_sesion div");

		mensaje_div.html('');
		var usuario = jQuery.trim(jQuery("#email_cliente_login").val());
		var contrasena = jQuery.trim(jQuery("#password_cliente_login").val());

		if(usuario == '' || contrasena == '') {
			mensaje_div.html("Por favor introduce todos los datos.");
			mensaje.fadeIn(100);
		} else {
			mensaje_div.html("Validando datos.");
			mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
			jQuery.ajax({
				url: base_url+"iniciar-sesion",
				data: { "email_cliente": usuario, "password_cliente": contrasena },
				type: "post",
				dataType: "json",

				success: function(respuesta) {
					if(respuesta.estatus == 'error') {
						mensaje_div.html(respuesta.mensaje);
						mensaje.fadeIn(100).addClass("alert").removeClass("primary warning");
					} else if(respuesta.estatus == 'verificado') {
						jQuery("#login_button").prop("disabled", true).hide(0);
						mensaje_div.html(respuesta.mensaje);
						mensaje.fadeIn(100).addClass("primary").removeClass("warning alert");
						setTimeout(function() {
							window.location.reload();
						}, 1000)
					}
				},
				error: function(respuesta) {
					mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
					mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
				}
			});
		}
	});

	// Recuperar
	jQuery("#forgot_form").submit(function(e) {
		e.preventDefault();

		var mensaje = jQuery("#mensaje_forgot");
		var mensaje_div = jQuery("#mensaje_forgot div");

		mensaje_div.html('');
		var usuario = jQuery.trim(jQuery("#email_cliente_forgot").val());

		if(usuario == '') {
			mensaje_div.html("Por favor introduce todos los datos.");
			mensaje.fadeIn(100);
		} else {
			mensaje_div.html("Validando datos.");
			mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
			jQuery.ajax({
				url: base_url+"enviar-recuperacion",
				data: { "email_cliente_forgot": usuario },
				type: "post",
				dataType: "json",

				success: function(respuesta) {
					if(respuesta.estatus == 'error') {
						mensaje_div.html(respuesta.mensaje);
						mensaje.fadeIn(100).addClass("alert").removeClass("primary warning");
					} else if(respuesta.estatus == 'verificado') {
						jQuery("#login_button").prop("disabled", true).hide(0);
						mensaje_div.html(respuesta.mensaje);
						mensaje.fadeIn(100).addClass("primary").removeClass("warning alert");
					}
				},
				error: function(respuesta) {
					mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
					mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
				}
			});
		}
	});

	// Registro
	jQuery("#register_form").submit(function(e) {
		e.preventDefault();

		var mensaje = jQuery("#mensaje_registro");
		var mensaje_div = jQuery("#mensaje_registro div");

		mensaje_div.html('');
		var nombre = jQuery.trim(jQuery("#nombre_nuevo").val());
		var apellido = jQuery.trim(jQuery("#apellido_nuevo").val());
		var email = jQuery.trim(jQuery("#email_nuevo").val());
		var telefono = jQuery.trim(jQuery("#telefono_nuevo").val());
		var cumple = jQuery.trim(jQuery("#cumple").val());
		var genero = jQuery.trim(jQuery("#genero_nuevo").val());
		var contrasena = jQuery.trim(jQuery("#password_nuevo").val());
		var contrasena_repetir = jQuery.trim(jQuery("#password_nuevo_repetir").val());

		if(nombre == '' || apellido == '' || email == '' || telefono == '' || cumple == ''|| contrasena == '' || contrasena_repetir == '' || genero == '') {
			mensaje_div.html("Por favor introduce todos los datos.");
			mensaje.fadeIn(100);
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
			mensaje_div.html("Validando datos.");
			mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
			jQuery.ajax({
				url: base_url+"registrar",
				data: data,
				type: "post",
				dataType: "json",

				success: function(respuesta) {
					if(respuesta.estatus == 'error') {
						mensaje_div.html(respuesta.mensaje);
						mensaje.fadeIn(100).addClass("alert").removeClass("primary warning");
					} else if(respuesta.estatus == 'verificado') {
						jQuery("#login_button").prop("disabled", true).hide(0);
						mensaje_div.html(respuesta.mensaje);
						mensaje.fadeIn(100).addClass("primary").removeClass("warning alert");
						jQuery("#register_form input, #register_form select").val('');
						setTimeout(function() {
							window.location.reload();
						}, 3500)
					}
				},
				error: function(respuesta) {
					mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
					mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
				}
			});
		}
	});

	jQuery(".editar_direccion").click(function() {
		var info_direccion = jQuery(this).parent().parent().data('direccion');
		jQuery("#identificador_direccion_mod").val(info_direccion.identificador_direccion);
		jQuery("#linea1_mod").val(info_direccion.linea1);
		jQuery("#linea2_mod").val(info_direccion.linea2);
		jQuery("#ciudad_mod").val(info_direccion.ciudad);
		jQuery("#codigo_postal_mod").val(info_direccion.codigo_postal);
		jQuery("#estado_mod").val(info_direccion.estado);
		jQuery("#telefono_mod").val(info_direccion.telefono);
		jQuery("#id_direccion_mod").val(info_direccion.id_direccion);
	});

	jQuery(".borrar_direccion").click(function() {
		var info_direccion = jQuery(this).parent().parent().data('direccion');
		jQuery("#id_direccion_bor").val(info_direccion.id_direccion);
	});

	jQuery(".editar_facturacion").click(function() {
		var info_direccion = jQuery(this).parent().parent().data('direccion');
		jQuery("#razon_social_mod").val(info_direccion.razon_social);
		jQuery("#rfc_mod").val(info_direccion.rfc);
		jQuery("#linea1_mod").val(info_direccion.linea1);
		jQuery("#linea2_mod").val(info_direccion.linea2);
		jQuery("#ciudad_mod").val(info_direccion.ciudad);
		jQuery("#codigo_postal_mod").val(info_direccion.codigo_postal);
		jQuery("#estado_mod").val(info_direccion.estado);
		jQuery("#id_direccion_fiscal_mod").val(info_direccion.id_direccion_fiscal);
		jQuery("#correo_electronico_facturacion_mod").val(info_direccion.correo_electronico_facturacion);
		jQuery("#telefono_mod").val(info_direccion.telefono);
	});

	jQuery(".borrar_facturacion").click(function() {
		var info_direccion = jQuery(this).parent().parent().data('direccion');
		jQuery("#id_direccion_fiscal_bor").val(info_direccion.id_direccion_fiscal);
	});

	jQuery.extend(jQuery.fn.pickadate.defaults,{monthsFull:["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"],monthsShort:["ene","feb","mar","abr","may","jun","jul","ago","sep","oct","nov","dic"],weekdaysFull:["domingo","lunes","martes","miércoles","jueves","viernes","sábado"],weekdaysShort:["dom","lun","mar","mié","jue","vie","sáb"],today:"hoy",clear:"borrar",close:"cerrar",firstDay:1,format:"yyyy-mm-dd",formatSubmit:"yyyy-mm-dd"});

	jQuery('#cumple_nuevo, #fecha_nacimiento').pickadate({
		max: new Date(),
		closeOnSelect: true,
		container: 'body',
		selectYears: true,
		selectMonths: true,
		selectYears: 100
	});


});

jQuery("#cerrar-link-fb1").click(function(e) {
	e.preventDefault();

	FB.logout(function(response) {
	jQuery.ajax({
		url: base_url+"registro/cerrar_sesion_ajax",
		type: "get",
		success: function(respuesta) {
			window.location.href=base_url;
		}
	});
	});
});

jQuery("#cerrar-link-fb2").click(function(e) {
	e.preventDefault();

	FB.logout(function(response) {
		jQuery.ajax({
			url: base_url+"registro/cerrar_sesion_ajax",
			type: "get",
			success: function(respuesta) {
				window.location.href=base_url;
			}
		});
	});
});

jQuery(".fbloginbutton").click(function() {
	FB.login(function(){
		loginCheck();
		//window.location.reload();
	}, {scope: 'public_profile,email', auth_type: 'rerequest'});
});
