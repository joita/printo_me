$(document).foundation();
moment.locale('es');
smoothScroll.init();

setInterval(function() {
	$("#gente_contador").html(Math.floor((Math.random() * 20) + 40))
	.animate({ opacity: 1 }, {
		step: function(now, fx) {
			$(this).css("-webkit-transform", "scale(1.4,1.4)");
			$(this).css("-moz-transform", "scale(1.4,1.4)");
			$(this).css("transform", "scale(1.4,1.4)");
		},
		duration: 200
	})
	.animate({ opacity: 1 }, {
		step: function(now, fx) {
			$(this).css("-webkit-transform", "scale(1,1)");
			$(this).css("-moz-transform", "scale(1,1)");
			$(this).css("transform", "scale(1,1)");
		},
		duration: 200
	});
}, 8000);

WebFontConfig = {
	google: {
		families: ['Lato:300,400,700']
	}
};

(function(d) {
  var wf = d.createElement('script'), s = d.scripts[0];
  wf.src = base_url+'bower_components/webfontloader/webfontloader.js';
  wf.async = true;
  s.parentNode.insertBefore(wf, s);
})(document);

var slider_inicio = $("#slider-inicio");
slider_inicio.on({
    'initialized.owl.carousel': function() {
        slider_inicio.find('.item').show();
    }
}).owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
    autoplayTimeout: 4500,
    smartSpeed: 1000
});

var slider_prods = $("#slider-prods");
slider_prods.on({
	'initialized.owl.carousel': function() {
		slider_prods.find('.item').show();
	}
}).owlCarousel({
	center: true,
	items:4,
	autoplay: true,
	autoplayTimeout: 4500,
	smartSpeed: 1000,
	loop:true,
	margin:10,
	responsive:{
		350:{
			items: 2
		},
		600:{
			items:3
		}
	}
});

var creadores_prods = $("#creadores-prods");
creadores_prods.on({
	'initialized.owl.carousel': function() {
		creadores_prods.find('.item').show();
	}
}).owlCarousel({
	center: true,
	items:3,
	autoplay: true,
	autoplayTimeout: 4500,
	smartSpeed: 1000,
	loop:true,
	margin:10,
	responsive:{
		350:{
			items: 2
		},
		600:{
			items:3
		}
	}
});

$('#codigo-cupon').on("keypress", function(e) {
    if (e.keyCode == 13) {
        $("#validar-cupon").click();
        return false;
    }
});

$("#validar-cupon").click(function(e) {
	e.preventDefault();

	$.post( base_url+"carrito/cupon", { cupon: $("#codigo-cupon").val() }, function (data) {
        if(data.exito == true) {
            $("#validar-cupon i").addClass("fa-check").removeClass("fa-times fa-plus-circle");
			setTimeout(function(){
				window.location.reload();
			}, 400);
        } else {
            $("#validar-cupon i").addClass("fa-times").removeClass("fa-check fa-plus-circle").css("color", "red");
            alert(data.error);
            $("#codigo-cupon").val('');
            $("#validar-cupon i").addClass("fa-plus-circle").removeClass("fa-check fa-times").attr("style", "");
        }
	}, "json");
});

$("#quitar-cupon").click(function(e) {
	e.preventDefault();

	$.post( base_url+"carrito/quitar_cupon", function() {
		window.location.reload();
	});
});

function update_price(id_llamador) {
	$("#costo,#precio_minimo").val('');
	$("#costo").parent().children(".pricey").html("$ -");
	$("#ganancia").html("$ -");

	var data = {
		quantity: $("#quantity").val(),
		costo: $("#costo").val(),
		price: $("#costo_playera").val(),
		name: $("#design_name").val(),
		description: $("#descripcion_campana").val(),
		etiquetas: $("#etiquetas_campana").val(),
		type: $("#tipo_campana option:selected").val(),
		id_clasificacion: $("#id_clasificacion option:selected").val(),
		days: $("#dias").val()
	};
	var precio_minimo = Number($("#precio_minimo").val());

	$.post( base_url+"campanas/precio", data, function( respuesta ) {

		var datos = $.parseJSON(respuesta);

		$("#costo,#precio_minimo").val(datos.costo_nuevo.replace("'","").replace('"',"").replace(',',""));
		$("#costo").parent().children(".pricey").html("$"+datos.costo_nuevo);

		$("#precio-recomendado").html("$"+datos.precio_recomendado);

		var $ganancia = $("#ganancia");
		$ganancia.val(datos.diferencia.replace(/"/g, '').replace("'","").replace('"',"").replace(',',""));

		precio = datos.diferencia.replace("'","");
		precio = precio.replace('"',"");
		precio = precio.replace(',',"");


		$(id_llamador).prop("disabled", false);


		if (parseFloat(precio) < 0) {
			$("#ganancia_contenedor").addClass("negativo");
			$(".enhance_now_button").attr('disabled', true);
		} else {
			$("#ganancia_contenedor").removeClass("negativo");
			$(".enhance_now_button").attr('disabled', false);
		}

		$ganancia.trigger("change");
	});
}

$("a[data-color-adder]").click(function() {
	var id_color = $(this).data("id_color");
	var id_producto = $(this).data("id_producto");
	$("#area-otros-colores-interna+.loading").show();
	if($(this).hasClass("already-added")) {
		$(this).removeClass("already-added");
		$(this).children("i").addClass("fa-square").removeClass("fa-check-square");
		var imagenes = $("[data-fila-id_color='"+id_color+"'] img");
		var borrar = [];
		$.each(imagenes, function(indice, imagen) {
			borrar.push(imagen.currentSrc.replace(base_url, ''));
		});
		$.ajax({
			type: "POST",
			url: base_url + "campanas/borrar_color_no_usado",
			data: { id_color: id_color, borrar: borrar }
		}).done(function() {
			$("[data-fila-id_color='"+id_color+"']").remove();
			$("#area-otros-colores-interna+.loading").hide();
		});
	} else {
		$(this).addClass("already-added");
		$(this).children("i").removeClass("fa-square").addClass("fa-check-square");

		$.ajax({
			type: "POST",
			url: base_url + "campanas/generar_otro_color",
			data: { id_color: id_color, id_producto: id_producto }
		}).done(function(resultado) {
			$("#area-otros-colores-variable").append(resultado);
			$("#area-otros-colores-interna+.loading").hide();
		});
	}

});

function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function des_but() {
	$(".enhance_now_button").prop("disabled", true);
}

function definir_venta()
{
	var tipo = $("#tipo_campana option:selected").val();

	if(tipo != '') {
		$("#info-adicional-venta").show(0);
	}

	if(tipo == 'limitado') {
		$("#quantity option[value='1'], #dias option[value='9999']").prop("disabled", true).hide();
		$("#quantity option:not([value='1']), #dias option:not([value='9999'])").prop("disabled", false).show();
		$("#info-temporal").show(0);
		$("#quantity").val(5);
		$("#gen").html('Ganancia estimada total neta');
		$("#exp_ganancia").html('<i class="fa fa-info"></i> ¡Recuerda! En la modalidad de Plazo definido solamente podrás recibir tus ganancias al término del plazo de días que escogiste anteriormente. Tu producto no pasa a producción hasta que se llegue a la meta de tiempo y números.');
	} else if(tipo == 'fijo') {
		$("#quantity option[value='1'], #dias option[value='9999']").prop("disabled", false).show();
		$("#quantity option:not([value='1']), #dias option:not([value='9999'])").prop("disabled", true).hide();
		$("#info-temporal").hide(0);
		$("#quantity").val(1);
		$("#gen").html('Ganancia estimada neta por <strong>venta unitaria</strong>');
		$("#exp_ganancia").html('<i class="fa fa-info"></i> En la modalidad de Venta inmediata recibirás tus ganancias de manera semanal. Cada viernes del mes te depositaremos las ganancias que hayas acumulado a lo largo de la semana.');
	}
	//$("#quantity, #dias").trigger("change");
	$("#tipo_campana").prop("disabled", true);
	update_price("#tipo_campana");
}

$(document).on("click", ".no_quiero_tutorial_campana", function() {
	var razon = $(this).data("mostrar");
	if(razon == 'no') {
		$(this).children("i").removeClass("fa-square-o").addClass("fa-check-square-o");
	} else if(razon == 'si') {
		$(this).children("i").addClass("fa-square-o").removeClass("fa-check-square-o");
	}
	$.ajax({
		type: "POST",
		url: base_url + "campanas/ocultar_tutorial/"+razon
	}).done(function(html) {
		$('body').pagewalkthrough('close');
	});
});

$("#etiquetas_campana").tagsInput({
    defaultText: 'Etiquetas descriptivas',
    width:'100%',
    height: '82px'
});

$("#tipo_campana").change(function(){
	definir_venta();
});

function countNombre(val) {
	var len = val.value.length;
	if(len < 1) {
		var texto = '<span style="color:red">Debe ingresar el nombre de su diseño</span>';
	} else {
		var texto = '';
	}
	$('#charNombre').html(texto);
}

function countChar(val) {
	var len = val.value.length;
	if(len < 50) {
		var span = '<span style="color:red">'+len+'</span>';
		var texto = '<span style="color:red">Deben ser mínimo 50 caracteres</span>';
	} else {
		var span = '<span style="color:green">'+len+'</span>';
		var texto = '';
	}
	$('#charNum').html(span);
	$('#charTotal').html(texto);
}

document.addEventListener("DOMContentLoaded", function(){
	document.getElementById("enhance_save").addEventListener('submit',validarCampos)
});

function validarCampos(evento){
	evento.preventDefault();
	var etiquetasCampana = document.getElementById('etiquetas_campana').value;
	if(etiquetasCampana.length==0){
		alert('Coloque al menos una etiqueta al producto');
		return;
	}
	this.submit();
}

var clickToUpdate;
$(document).ready(function() {
	$(".nicesel").niceSelect();

	if($("#tipo_campana").length > 0) {
		jQuery('body').pagewalkthrough({
			name: 'introduction',
			steps: [/* {
				popup: {
					content: '#paso-1',
					type: 'modal'
				}
			}, */{
				wrapper: '#wt-grupo-nombre',
				popup: {
					content: '#paso-2',
					type: 'tooltip',
					position: 'left'
				}
			}, {
				wrapper: '#wt-grupo-descripcion',
				popup: {
					content: '#paso-3',
					type: 'tooltip',
					position: 'left'
				}
			}, {
				wrapper: '#wt-grupo-clasificacion',
				popup: {
					content: '#paso-4',
					type: 'tooltip',
					position: 'left'
				}
			}, {
				wrapper: '#wt-grupo-tipo',
				popup: {
					content: '#paso-5',
					type: 'tooltip',
					position: 'left'
				}
			}, {
				wrapper: '#wt-grupo-tipo',
				popup: {
					content: '#paso-6',
					type: 'tooltip',
					position: 'left'
				}
			}]
		});

		definir_venta();

		if(mostrar_tutorial) {
			if (Foundation.MediaQuery.atLeast('medium')) {
				$('body').pagewalkthrough('show');
			}
		}
	}

	$(document).on("click", "#tut_camp", function() {
		if (Foundation.MediaQuery.atLeast('medium')) {
			$('body').pagewalkthrough('show');
		}
	});

	$(".unveil").unveil();

	$("#ganancia").on("change", function(e) { /*  input keyup paste */
		e.preventDefault();
		var valor = $(this).val();
		valor = $(this).val().replace("'","");
		valor = valor.replace('"',"");
		valor = valor.replace(',',"");

		if(parseFloat(valor) < 0) {
			var nuevo = parseFloat(valor)*(-1);
			$("#ganancia_display").html("-$"+numberWithCommas(nuevo));
		} else {
			$("#ganancia_display").html("$"+numberWithCommas(valor));
		}
	});

	$("#costo_playera").number( true, 2 );

	$("#costo_playera").on("change input", function(e) {
		e.preventDefault();
		var valor = $(this).val();
		$("#costo_playera_display").html(valor);
		$("#costo_playera_hidden").val(valor);
		update_price(".enhance_now_button");
	});

	if($("#quantity").length > 0) {
		//update_price();
	}

	$(document).on("change", "#quantity", function() {
		$("#quantity").prop("disabled", true);
		update_price("#quantity");
	});

	$("#design_name, #descripcion_campana, #id_clasificacion, #dias, #etiquetas_campana, #etiquetas_campana_tag").on("focusout", function(e) {
		update_price();
	});

	$('.enhance_now_button').click(function(e) {
		return ($(this).attr('disabled')) ? false : true;
	});

	var intervalId; // keep the ret val from setTimeout()

	$('[data-min], [data-max]').mousedown(function() {
		var self = this;
		intervalId = setInterval(function () {
			clickToUpdate(self);
		}, 250);
	}).bind('mouseup mouseleave', function() {
		clearInterval(intervalId);
	});
});

$(document).on("change", "#talla_elegida", function() {
	var info = parseInt($("#talla_elegida option:selected").data("actual"));
	var html_insert = '<option value=""></option>';
	for(var i=1;i<=info;i++) {
		html_insert += '<option value="'+i+'">'+i+'</option>';
	}
	$("#cantidad_campana").html(html_insert);
});

$("#tipo_pago").change(function() {
	if($(this).val() != '') {
		$("#pago_banco").show();
		if($(this).val() == 'banco') {
			$(".paypal-row").hide();
			$(".paypal-row input").prop("disabled", true);
			$(".paypal-row input").prop("required", false);

			$(".bank-row").show();
			$(".bank-row input").prop("disabled", false);
			$(".bank-row input").prop("required", true);

		} else if($(this).val() == 'paypal') {
			$(".bank-row").hide();
			$(".bank-row input").prop("disabled", true);
			$(".bank-row input").prop("required", false);

			$(".paypal-row").show();
			$(".paypal-row input").prop("disabled", false);
			$(".paypal-row input").prop("required", true);
		}
	} else {
		$("#pago_banco").hide();
	}
});

$(".edit-diseno-custom").click(function() {
	var id_diseno = $(this).data("id_diseno");
	var id_producto_original = $(".edit-diseno-custom[data-id_diseno='"+id_diseno+"']:eq(0)").data("id_producto");
	var id_color_original = $(".edit-diseno-custom[data-id_diseno='"+id_diseno+"']:eq(0)").data("id_color");
	//var diseno_original = $(".edit-diseno-custom[data-id_diseno='"+id_diseno+"']:eq(0)").data("diseno");

	r = confirm('Si decides editar este diseño, los modelos/tallas del diseño en cuestión que hayas agregado al carrito se van a remover por cuestiones de cálculo de precios, conteo de colores y generación de vistas previas.\n\rDe la misma manera, si tienes algún otro diseño en proceso, será reemplazado por el que quieres editar.\n\r¿Estás de acuerdo?');

	if(r) {
		sesion = {};
		sesion.id_color = id_color_original;
		sesion.product_id = id_producto_original;

		var filas = [];
		$(".borrar-cantidad-custom[data-id_diseno='"+id_diseno+"']").each(function() {
			filas.push($(this).data("id_fila"));
		});

		$.ajax({
			type: "POST",
			url: base_url + "carrito/obtener_vectores_por_fila/" + filas[0],
			data: { sesion: sesion, filas: filas }
		}).done(function() {
			window.location.href= base_url + 'personalizar/'+sesion.product_id+'/'+sesion.id_color;
		});

		/* $.ajax({
			type: "POST",
			dataType: "json",
			url: base_url + "carrito/limpiar_custom_especifico_de_carrito",
			data: { filas: filas }
		}); */

		/* $.ajax({
			type: "POST",
			dataType: "json",
			url: base_url + "designer/sesion_diseno_carrito",
			data: { sesion: sesion }
		}).done(function() {
			//window.location.href= base_url + 'personalizar/'+sesion.product_id+'/'+sesion.id_color;
		}); */
	}
});

$("#limpbus").click(function() {
	$("#buscador-catalogo").val('');
	$("#form-buscador-catalogo").submit();
});

$("#form-buscador-catalogo").submit(function(e) {
	e.preventDefault();
	var urs = $("#urstr-busc").val();
	var fil = $("#filtr-busc").val();
	var bus = $("#buscador-catalogo").val();
	var nuevo = '';

	if(fil == '') {
		nuevo += '?filtros=busqueda:'+bus;
	} else {
		var descomponer = fil.replace("?filtros=", "");
		descomponer = descomponer.split(',');
		var filtros = {};
		$.each(descomponer, function(index, desco) {
			var new_desco = desco.split(":");
			filtros[new_desco[0]] = new_desco[1];
		});

		if(typeof filtros.busqueda != 'undefined') {
			filtros.busqueda = bus;
		}

		if(bus == '') {
			delete filtros.busqueda;
		} else {
			filtros.busqueda = bus;
		}

		nuevo = '?filtros=';

		$.each(filtros, function(indice, valor) {
			nuevo += indice+':'+valor+',';
		});

		nuevo = nuevo.substr(0, nuevo.length-1);
	}

	window.location.href = urs + nuevo;
});


// Scroll AC
var scrolled_once = false;

if(mostrar_cupon) {
	$(window).scroll(function() {
	    if($(window).scrollTop() > $(document).height()*0.2 && !scrolled_once) {
	    	$("#cupon_printome").foundation("open");
			scrolled_once = true;
		}
	});
}

// Login
$("#cupon_form").submit(function(e) {
	e.preventDefault();

	$mensaje = $("#mensaje_cupon");
	$mensaje_div = $("#mensaje_cupon div");

	$mensaje_div.html('');
	var nombre = $.trim($("#nombre_cupon").val());
	var email = $.trim($("#email_cupon").val());

	if(nombre == '' || email == '') {
		$mensaje_div.html("Por favor introduce todos los datos.");
		$mensaje.fadeIn(100);
	} else {
		$mensaje_div.html("Validando datos.");
		$mensaje.fadeIn(100).addClass("primary").removeClass("alert warning");
		$("#cupon_boton").prop("disabled", true);
		$.ajax({
			url: base_url+"ac/cupon",
			data: { "nombre": nombre, "email": email },
			type: "post",
			dataType: "json",

			success: function(respuesta) {
				if(respuesta.estatus == 'error') {
					$mensaje_div.html(respuesta.mensaje);
					$mensaje.fadeIn(100).addClass("alert").removeClass("primary warning");
					$("#cupon_boton").prop("disabled", false);
				} else if(respuesta.estatus == 'exitoso') {
					$("#cupon_boton").prop("disabled", true).hide(0);
					$mensaje_div.html(respuesta.mensaje);
					$mensaje.fadeIn(100).addClass("primary").removeClass("warning alert");
					$("#nombre_cupon, #email_cupon").parent().hide();

					if(typeof ga != 'undefined') {
						ga('send', 'event', 'ActiveCampaign', 'Descarga-Clic', 'Cupon-Envio-Gratis', 0);
					}

					setTimeout(function() {
						$("#cupon_printome").foundation("close");
					}, 2500);
				}
			},
			error: function(respuesta) {
				$mensaje_div.html("Ha ocurrido algún error, por favor intenta nuevamente.");
				$mensaje.fadeIn(100).addClass("warning").removeClass("alert primary");
				$("#cupon_boton").prop("disabled", false);
			}
		});
	}
});

$("#cupon_printome").on('closed.zf.reveal', function() {
    $.ajax({
        url: base_url+"ac/ocultar_temporalmente_cupon",
        type: "post"
    });
});

$(function() {

    $('#rating-testimonio').barrating({
        theme: 'fontawesome-stars'
    });
});

$(document).ready(function() {
    $('#testimonios-grid').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'masonry'
    });

    $("#testimonios-area").owlCarousel({
        center: true,
        selector: 'grid-item',
        loop: true,
        dots: false,
        nav: false,
        autoplay: true,
        autoplayTimeout: 8500,
        responsive: {
            0: {
                items: 1
            },
            640: {
                items: 2
            },
            1200: {
                items: 3
            }
        }
    })
});

$("#periodo").change(function() {
    window.location.href = base_url+'mi-cuenta/pedidos/'+$(this).val();
});

$(".reordenar").click(function() {
    $(this).prop("disabled", true);
    $(this).children("i").addClass("fa-spinner fa-pulse fa-fw").removeClass("fa-cart-arrow-down");
});
