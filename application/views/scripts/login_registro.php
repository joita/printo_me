
<script>
$(document).ready(function() {
	
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
		url = '<?php echo current_url(); ?>',
		mensaje = $("#mensaje_contacto").val(),
		template = $("#template_contacto").val();
		
		if(nombre == '' || email == '' || mensaje == '') {
			$mensaje_div.html("Por favor introduce todos los datos.");
			$mensaje.fadeIn(100);
		} else {
			$mensaje_div.html("Validando datos.");
			$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
			$("#contacto_button").prop("disabled", true);
			
			$.ajax({
				url: "<?php echo site_url('catalogo/contacto'); ?>",
				data: {
					nombre: nombre,
					email: email,
					asunto: asunto,
					lugar: lugar,
					url: url,
					mensaje: mensaje,
					template: template
				},
				type: "post",
				dataType: "json",

				success: function(respuesta) {
					
					if(respuesta.resultado == 'exito') {
						$("#contact_form input, #contact_form textarea, #contact_form button, label, .add-buttons a[data-close]").hide();
						$mensaje_div.html("Tu mensaje ha sido enviado, lo revisaremos a la brevedad posible.");
						$mensaje.fadeIn(100).addClass("primary").removeClass("warning alert");
					} else {
						$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
						$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
						$("#contacto_button").prop("disabled", false);
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
	
	// Login
	$("#login_form").submit(function(e) {
		e.preventDefault();
		
		$mensaje = $("#mensaje_inicio_sesion");
		$mensaje_div = $("#mensaje_inicio_sesion div");
		
		$mensaje_div.html('');
		var usuario = $.trim($("#email_cliente_login").val());
		var contrasena = $.trim($("#password_cliente_login").val());
		
		if(usuario == '' || contrasena == '') {
			$mensaje_div.html("Por favor introduce todos los datos.");
			$mensaje.fadeIn(100);
		} else {
			$mensaje_div.html("Validando datos.");
			$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
			$.ajax({
				url: "<?php echo site_url('iniciar-sesion'); ?>",
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
				url: "<?php echo site_url('iniciar-sesion'); ?>",
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
				url: "<?php echo site_url('enviar-recuperacion'); ?>",
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
		var cumple = $.trim($("#cumple").val());
		var genero = $.trim($("#genero_nuevo").val());
		var contrasena = $.trim($("#password_nuevo").val());
		var contrasena_repetir = $.trim($("#password_nuevo_repetir").val());
		
		if(nombre == '' || apellido == '' || email == '' || cumple == ''|| contrasena == '' || contrasena_repetir == '' || genero == '') {
			$mensaje_div.html("Por favor introduce todos los datos.");
			$mensaje.fadeIn(100);
		} else {
			var data = {
				"nombre": nombre,
				"apellido": apellido,
				"email": email,
				"cumple": cumple,
				"genero": genero,
				"contrasena": contrasena,
				"contrasena_repetir": contrasena_repetir,
			}
			$mensaje_div.html("Validando datos.");
			$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
			$.ajax({
				url: "<?php echo site_url('registrar'); ?>",
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

	// Registro campana
	$("#campana_register_form").submit(function(e) {
		e.preventDefault();
		
		$mensaje = $("#campana_mensaje_registro");
		$mensaje_div = $("#campana_mensaje_registro div");
		
		$mensaje_div.html('');
		var nombre = $.trim($("#campana_nombre_nuevo").val());
		var apellido = $.trim($("#campana_apellido_nuevo").val());
		var email = $.trim($("#campana_email_nuevo").val());
		var cumple = $.trim($("#campana_cumple_nuevo").val());
		var genero = $.trim($("#campana_genero_nuevo").val());
		var contrasena = $.trim($("#campana_password_nuevo").val());
		var contrasena_repetir = $.trim($("#campana_password_nuevo_repetir").val());
		
		if(nombre == '' || apellido == '' || email == '' || cumple == ''|| contrasena == '' || contrasena_repetir == '' || genero == '') {
			$mensaje_div.html("Por favor introduce todos los datos.");
			$mensaje.fadeIn(100);
		} else {
			var data = {
				"nombre": nombre,
				"apellido": apellido,
				"email": email,
				"cumple": cumple,
				"genero": genero,
				"contrasena": contrasena,
				"contrasena_repetir": contrasena_repetir,
			}
			$mensaje_div.html("Validando datos.");
			$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
			$.ajax({
				url: "<?php echo site_url('registrar'); ?>",
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
	
	$(".editar_direccion").click(function() {
		var info_direccion = $(this).parent().parent().data('direccion');
		$("#identificador_direccion_mod").val(info_direccion.identificador_direccion);
		$("#linea1_mod").val(info_direccion.linea1);
		$("#linea2_mod").val(info_direccion.linea2);
		$("#ciudad_mod").val(info_direccion.ciudad);
		$("#codigo_postal_mod").val(info_direccion.codigo_postal);
		$("#estado_mod").val(info_direccion.estado);
		$("#telefono_mod").val(info_direccion.telefono);
		$("#id_direccion_mod").val(info_direccion.id_direccion);
	});
	
	$(".borrar_direccion").click(function() {
		var info_direccion = $(this).parent().parent().data('direccion');
		$("#id_direccion_bor").val(info_direccion.id_direccion);
	});
	
	$(".editar_facturacion").click(function() {
		var info_direccion = $(this).parent().parent().data('direccion');
		$("#razon_social_mod").val(info_direccion.razon_social);
		$("#rfc_mod").val(info_direccion.rfc);
		$("#linea1_mod").val(info_direccion.linea1);
		$("#linea2_mod").val(info_direccion.linea2);
		$("#ciudad_mod").val(info_direccion.ciudad);
		$("#codigo_postal_mod").val(info_direccion.codigo_postal);
		$("#estado_mod").val(info_direccion.estado);
		$("#id_direccion_fiscal_mod").val(info_direccion.id_direccion_fiscal);
		$("#correo_electronico_facturacion_mod").val(info_direccion.correo_electronico_facturacion);
		$("#telefono_mod").val(info_direccion.telefono);
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
	

});


$(".fbloginbutton").click(function() {
	FB.login(function(){
		loginCheck();
		//window.location.reload();
	}, {scope: '<?php echo implode(",", $this->config->item('facebook_permissions')); ?>', auth_type: 'rerequest'});
});

$("#cerrar-link-fb").click(function(e) {
	e.preventDefault();
	
	//FB.logout(function(response) {
	$.ajax({
		url: "<?php echo site_url('registro/cerrar_sesion_ajax'); ?>",
		type: "get",
		success: function(respuesta) {
			window.location.href='<?php echo base_url(); ?>';
		}
	});
	//});
});
</script>