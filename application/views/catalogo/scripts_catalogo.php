<script>


// Generar el contenedor de isotope
var $container = $('#contenedor-catalogo').imagesLoaded( function() {
	$container.isotope({
		itemSelector: '.producto',
		layoutMode: 'fitRows'
	});
});

// Slider de precios
$rango_normal = $("#rango");
$rango_movil = $("#rango_movil");

// Termina slider de precios

$('.filtro.color a').click(function() {

	// Funcion del click del filtro de color
	var item = $(this).data('filtro');

	if(!$(this).hasClass("initial")) {

		if($(this).hasClass("active")) {
			var index = filtro_color.indexOf(item);
			if (index > -1) filtro_color.splice(index, 1);
			$(this).removeClass('active');
			$(this).children().removeClass('fa-check-circle').addClass('fa-circle');
		} else {
			filtro_color.push($(this).data('filtro'));
			$(this).addClass('active');
			$(this).children().removeClass('fa-circle').addClass('fa-check-circle');
		}

	} else {
		$('.links-colores a').removeClass("active");
		$('.links-colores a').children().removeClass('fa-check-circle').addClass('fa-cricle');
		$(this).children().addClass('fa-check-circle-o').removeClass('fa-circle-o');
		filtro_color = [];
	}

	if(filtro_color.length == 0){
		$('.filtro.color a.initial').children().removeClass('fa-circle-o').addClass('fa-check-circle-o');
		$('.filtro.color a.initial').addClass("active");
		$('.links-colores a').removeClass("active");
		$('.links-colores a').children().removeClass('fa-check-circle').addClass('fa-circle');
	}else{
		$('.filtro.color a.initial').children().removeClass('fa-check-circle-o').addClass('fa-circle-o');
		$('.filtro.color a.initial').removeClass("active");
	}

	$container.isotope({ filter: filtro });
});

$('.filtro.talla a').click(function() {
	// Funcion del click del filtro de talla
	var item = $(this).data('filtro');

	if(!$(this).hasClass("initial")) {

		if($(this).hasClass("active")) {
			var index = filtro_talla.indexOf(item);
			if (index > -1) filtro_talla.splice(index, 1);
			$(this).removeClass('active');
		} else {
			filtro_talla.push($(this).data('filtro'));
			$(this).addClass('active');
		}

	} else {
		$('a.talla_f').removeClass("active");
		filtro_talla = [];
	}

	if(filtro_talla.length == 0){
		$('.filtro.talla a.initial').children().removeClass('fa-circle-o').addClass('fa-check-circle-o');
		$('.filtro.talla a.initial').addClass("active");
	}else{
		$('.filtro.talla a.initial').children().removeClass('fa-check-circle-o').addClass('fa-circle-o');
		$('.filtro.talla a.initial').removeClass("active");
	}

	$container.isotope({ filter: filtro });
});


// Inicializacion de filtros
var filtro_precio = false;
var precio_desde  = <?php echo intval($precios->minimo) ?>;
var precio_hasta  = <?php echo intval($precios->maximo) ?>;
var filtro_color  = new Array();
var filtro_marca  = new Array();
var filtro_talla  = new Array();
var filtro_categoria  = {}

var filtros = {}
filtros.precios = function (precio) {
	return (precio >= precio_desde) && (precio <= precio_hasta)
}

filtros.marca = function (marca) {
	var mostrar = false;
	for (var i = 0; i < filtro_marca.length; i++) {
		var marca_a_filtrar = filtro_marca[i];
		mostrar = (marca == marca_a_filtrar);
		if(mostrar) break;
	};
	return mostrar;
}

filtros.color = function (color) {
	var mostrar = false;
	for (var i = 0; i < filtro_color.length; i++) {
		var color_a_filtrar = filtro_color[i];
		mostrar = (color.indexOf(color_a_filtrar) != -1);
		if(mostrar) break;
	};
	return mostrar;
}

filtros.talla = function (talla) {
	var mostrar = false;
	for (var i = 0; i < filtro_talla.length; i++) {
		var talla_a_filtrar = filtro_talla[i];
		mostrar = (talla.indexOf(talla_a_filtrar) != -1);
		if(mostrar) break;
	};
	return mostrar;
}

filtros.caracteristica = function (caracteristica) {
	var mostrar = false;
	for (var k in filtro_categoria){
		categoria_parent = filtro_categoria[k];
		for (var i = 0; i < categoria_parent.length; i++) {
			var categoria_a_filtrar = categoria_parent[i];
			mostrar = (caracteristica.indexOf(categoria_a_filtrar) != -1);
			if(mostrar) break;
		};
		if(mostrar) break;
	}
	return mostrar;
}

function filtro() {
	var precio = parseInt($(this).find('.precio_oculto').text(), 10);

	var has_color = (filtro_color.length > 0);
	var has_marca = (filtro_marca.length > 0);
	var has_talla =  (filtro_talla.length > 0);
	var has_categoria = (Object.getOwnPropertyNames(filtro_categoria).length > 0);

	if (has_color && has_marca && has_talla && has_categoria) {
		var color = $(this).find('.color_oculto').text();
		var marca = $(this).find('.marca_oculta').text();
		var talla = $(this).find('.talla_oculta').text();
		var caracterisica = $(this).find('.caracteristica_oculta').text();
		return filtros.precios(precio) && filtros.color(color) && filtros.marca(marca) && filtros.talla(talla) && filtros.caracteristica(caracterisica);
	};

	if (has_color && has_marca && has_talla && !has_categoria) {
		var color = $(this).find('.color_oculto').text();
		var marca = $(this).find('.marca_oculta').text();
		var talla = $(this).find('.talla_oculta').text();
		return filtros.precios(precio) && filtros.color(color) && filtros.marca(marca) && filtros.talla(talla);
	};

	if (has_color && has_marca && !has_talla && has_categoria) {
		var color = $(this).find('.color_oculto').text();
		var marca = $(this).find('.marca_oculta').text();
		var caracterisica = $(this).find('.caracteristica_oculta').text();
		return filtros.precios(precio) && filtros.color(color) && filtros.marca(marca) && filtros.caracteristica(caracterisica);
	};

	if (has_color && has_marca && !has_talla && !has_categoria) {
		var color = $(this).find('.color_oculto').text();
		var marca = $(this).find('.marca_oculta').text();
		return filtros.precios(precio) && filtros.color(color) && filtros.marca(marca);
	};

	if (has_color && !has_marca && has_talla && has_categoria) {
		var color = $(this).find('.color_oculto').text();
		var talla = $(this).find('.talla_oculta').text();
		var caracterisica = $(this).find('.caracteristica_oculta').text();
		return filtros.precios(precio) && filtros.color(color) && filtros.talla(talla) && filtros.caracteristica(caracterisica);
	};

	if (has_color && !has_marca && has_talla && !has_categoria) {
		var color = $(this).find('.color_oculto').text();
		var talla = $(this).find('.talla_oculta').text();
		return filtros.precios(precio) && filtros.color(color) && filtros.talla(talla);
	};

	if (has_color && !has_marca && !has_talla && has_categoria) {
		var color = $(this).find('.color_oculto').text();
		var caracterisica = $(this).find('.caracteristica_oculta').text();
		return filtros.precios(precio) && filtros.color(color) && filtros.caracteristica(caracterisica);
	};

	if (has_color && !has_marca && !has_talla && !has_categoria) {
		var color = $(this).find('.color_oculto').text();
		return filtros.precios(precio) && filtros.color(color);
	};

	if (!has_color && has_marca && has_talla && has_categoria) {
		var marca = $(this).find('.marca_oculta').text();
		var talla = $(this).find('.talla_oculta').text();
		var caracterisica = $(this).find('.caracteristica_oculta').text();
		return filtros.precios(precio) && filtros.marca(marca) && filtros.talla(talla) && filtros.caracteristica(caracterisica);
	};

	if (!has_color && has_marca && has_talla && !has_categoria) {
		var marca = $(this).find('.marca_oculta').text();
		var talla = $(this).find('.talla_oculta').text();
		return filtros.precios(precio) && filtros.marca(marca) && filtros.talla(talla);
	};

	if (!has_color && has_marca && !has_talla && has_categoria) {
		var marca = $(this).find('.marca_oculta').text();
		var caracterisica = $(this).find('.caracteristica_oculta').text();
		return filtros.precios(precio) && filtros.marca(marca) && filtros.caracteristica(caracterisica);
	};

	if (!has_color && has_marca && !has_talla && !has_categoria) {
		var marca = $(this).find('.marca_oculta').text();
		return filtros.precios(precio) && filtros.marca(marca);
	};

	if (!has_color && !has_marca && has_talla && has_categoria) {
		var talla = $(this).find('.talla_oculta').text();
		var caracterisica = $(this).find('.caracteristica_oculta').text();
		return filtros.precios(precio) && filtros.talla(talla) && filtros.caracteristica(caracterisica);
	};

	if (!has_color && !has_marca && has_talla && !has_categoria) {
		var talla = $(this).find('.talla_oculta').text();
		return filtros.precios(precio) && filtros.talla(talla) ;
	};

	if (!has_color && !has_marca && !has_talla && has_categoria) {
		var caracterisica = $(this).find('.caracteristica_oculta').text();
		return filtros.precios(precio) && filtros.caracteristica(caracterisica);
	};

	if (!has_color && !has_marca && !has_talla && !has_categoria) {

		return filtros.precios(precio);
	};


}

$('.filtro.caracteristica a').click(function() {
	var $this = $(this);
	var item = $this.data('filtro');
	var abuelo = $this.closest(".filtro.caracteristica");
	var caracteristica_parent = abuelo.data("caracteristica");

	filtro_categoria[caracteristica_parent] = filtro_categoria[caracteristica_parent] || new Array();

	if ($this.hasClass("active") && !$this.hasClass("inicial")) {

		var index = filtro_categoria[caracteristica_parent].indexOf(item);
		if (index > -1) filtro_categoria[caracteristica_parent].splice(index, 1);
		$this.removeClass('active');
		$this.children().removeClass('fa-check-circle').addClass('fa-circle-o');
	}else if(!$this.hasClass("inicial")){
		filtro_categoria[caracteristica_parent].push($this.data('filtro'));
		$this.addClass('active');
		$this.children().removeClass('fa-circle-o').addClass('fa-check-circle');
	}else if($this.hasClass("inicial") && !$this.hasClass("active")){
		filtro_categoria[caracteristica_parent] = [];
		$this.addClass("active");
		$this.children().removeClass('fa-circle-o').addClass('fa-check-circle');
	}else{
		//do nothing
	};

	if(filtro_categoria[caracteristica_parent].length == 0){
		delete filtro_categoria[caracteristica_parent];
		abuelo.find('a').removeClass("active");
		abuelo.find('a').children().removeClass('fa-check-circle').removeClass('fa-check-circle-o').addClass('fa-circle-o');
		abuelo.find('a.inicial').children().removeClass('fa-circle-o').addClass('fa-check-circle');
		abuelo.find('a.inicial').addClass("active");
	}else{
		abuelo.find('a.inicial').children().removeClass('fa-check-circle').removeClass('fa-check-circle-o').addClass('fa-circle-o');
		abuelo.find('a.inicial').removeClass("active");
	}
	$container.isotope({ filter: filtro });
	$container_movil.isotope({ filter: filtro });
});



$(".filtro.marca a").click(function() {
	$(".filtro.marca a").children().removeClass('fa-check-circle-o').addClass('fa-circle-o');
	$(this).children().removeClass('fa-circle-o').addClass('fa-check-circle-o');
	filtro_marca = $(this).data('filtro');

	$container.isotope({ filter: filtro });
	$container_movil.isotope({ filter: filtro });
});

$('#profile_slider').imagesLoaded( function() {
	$(".profile_slider").slick({
		autoplay: false,
		autoplaySpeed: 4500,
		fade: false,
		speed: 350,
		pauseOnHover: false,
		arrows: false
	});

	/* if (Foundation.MediaQuery.atLeast('xlarge')) {
		$(".zoomme.slick-active").elevateZoom({
			scrollZoom : true,
			responsive: true,
			zoomType: 'window',
			zoomWindowWidth: 500,
			zoomWindowHeight: 500
		});
	}

	$(".profile_slider").on("beforeChange", function() {
		$(".zoomContainer").remove();
	});


	$(".profile_slider").on("afterChange", function() {
		if (Foundation.MediaQuery.atLeast('xlarge')) {
			$(".zoomme.slick-active").elevateZoom({
				scrollZoom : true,
				responsive: true,
				zoomType: 'window',
				zoomWindowWidth: 500,
				zoomWindowHeight: 500
			});
		}
	}); */
});

$('.profile_slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
	$("a[data-slide]").removeClass("active");
	$("a[data-slide='"+nextSlide+"']").addClass("active");
});

$(document).on("click", "a[data-slide]", function() {

	$("a[data-slide]").removeClass("active");
	$(this).addClass("active");

	$(".profile_slider").slick("slickGoTo", $(this).data("slide"));

	/* $(".profile_slider").on("beforeChange", function() {
		$(".zoomContainer").remove();
	});

	$(".profile_slider").on("afterChange", function() {
		if (Foundation.MediaQuery.atLeast('xlarge')) {
			$(".zoomme.slick-active").elevateZoom({
				scrollZoom : true,
				responsive: true,
				zoomType: 'window',
				zoomWindowWidth: 500,
				zoomWindowHeight: 500
			});
		}
	});  */


});



$(".special.color-switcher").click(function() {

	$(".special.color-switcher").children("i").removeClass("fa-check-circle").addClass("fa-circle");
	$(this).children("i").addClass("fa-check-circle").removeClass("fa-circle");

	var fotos = $(this).data("json-fotografias");
	var tallas = $(this).data("json-tallas");

	var input_controlador = '';
	var input_slider = '';

	var input_tallas = '';

	$.each(fotos, function(i, foto) {
		var data_slide = i;
		var clase = '';
		if(i == 0) {
			clase = ' class="active"';
		}
		var fotografia_chica = "<?php echo base_url(); ?>"+foto.ubicacion_base+foto.fotografia_chica;
		var fotografia_mediana = "<?php echo base_url(); ?>"+foto.ubicacion_base+foto.fotografia_mediana;
		var fotografia_grande = "<?php echo base_url(); ?>"+foto.ubicacion_base+foto.fotografia_grande;

		input_slider += '<div class="slide"><div class="zoomHolder"><img data-src="'+fotografia_grande+'" data-elem="pinchzoomer" alt="" /></div></div>';

		input_controlador += '<a data-slide="'+i+'"'+clase+'><img src="'+fotografia_chica+'" alt=""></a>';

		//input_slider += '<img src="'+fotografia_mediana+'" class="zoomme" data-zoom-image="'+fotografia_grande+'" alt="">';
	});

	if(tallas != '') {
		$.each(tallas, function(i, talla) {
			input_tallas += '<a class="talla_f" href="#">'+talla.caracteristicas.talla+'</a>';
		});
		$(".temp-tallas").html(input_tallas);
	}

	$("#big-personalizar, #disena > a, .talla_f").attr("href", $(this).data("url-designer"));

	$(".profile_slider").slick('unslick');
	$(".profile_controller").html(input_controlador);
	$(".profile_slider").html(input_slider);
	$(".profile_slider").slick({
		autoplay: true,
		autoplaySpeed: 4500,
		fade: false,
		speed: 750,
		pauseOnHover: false,
		arrows: false
	});

	$(".zoomHolder [data-src]").each(function() {
		$(this).pinchzoomer();
	});

	/*
	if (Foundation.MediaQuery.atLeast('xlarge')) {
		$(".zoomme.slick-active").elevateZoom({
			scrollZoom : true,
			responsive: true,
			zoomType: 'window',
			zoomWindowWidth: 500,
			zoomWindowHeight: 500
		});
	}

	$(".profile_slider").on("beforeChange", function() {
		$(".zoomContainer").remove();
	});

	$(".profile_slider").on("afterChange", function() {
		if (Foundation.MediaQuery.atLeast('xlarge')) {
			$(".zoomme.slick-active").elevateZoom({
				scrollZoom : true,
				responsive: true,
				zoomType: 'window',
				zoomWindowWidth: 500,
				zoomWindowHeight: 500
			});
		}
	});  */
});

(function () {

	$("[data-sku]").change( function() {
		sku_id = $(this).data("sku");
		tallas = JSON.parse($("[data-tallas]").text());
		cantidad = tallas[$(this).children("option:selected").val()];
		html_text = "<option value='' selected>Seleccione</option>";
		for (var i = 1; i <= cantidad ; i++) {
			html_text += "<option>"+ i + "</option>";
		};
		$("[data-cantidad=" + sku_id + "]").html(html_text);
	});
})();


</script>
