<script>
// Timers de conteo

$(".timer-grande").each(function() {
	var tiempo = $(this).data("countdown");
	var fecha = moment.tz(tiempo, 'America/Merida');

	$(this).countdown(fecha.toDate(), function(event) {
		$(this).html(event.strftime('<span class="f"><span class="d_digit">%-D</span> <span class="d_text">días</span></span> <span class="f"><span class="d_digit">%-H</span> <span class="d_text">horas</span></span> <span class="f"><span class="d_digit">%-M</span> <span class="d_text">minutos</span></span> <span class="f"><span class="d_digit">%-S</span> <span class="d_text">segundos</span></span>'));
	});
});

$(".timer").each(function() {
	var tiempo = $(this).data("countdown");
	var fecha = moment.tz(tiempo, 'America/Merida');

	$(this).countdown(fecha.toDate(), function(event) {
		$(this).html(event.strftime('<span class="f"><span class="d_digit">%-D</span><span class="d_text">días</span></span><span class="f"><span class="d_digit">%-H</span><span class="d_text">hrs</span></span><span class="f"><span class="d_digit">%-M</span><span class="d_text">min</span></span><span class="f"><span class="d_digit">%-S</span><span class="d_text">seg</span></span>'));
	});
});

$('#profile_slider').imagesLoaded( function() {
	$(".profile_slider").slick({
		autoplay: false,
		autoplaySpeed: 4517,
		fade: false,
		speed: 350,
		pauseOnHover: false,
		arrows: false,
		draggable: false,
		swipe: false
	});
});

$('.profile_slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
	$("a[data-slide]").removeClass("active");
	$("a[data-slide='"+nextSlide+"']").addClass("active");
});

$(document).on("click", "a[data-slide]", function() {
	$("a[data-slide]").removeClass("active");
	$(this).addClass("active");

	$(".profile_slider").slick("slickGoTo", $(this).data("slide"));
});

$(window).load(function() {
	var h = window.location.hash;

	if(h != '') {
		if($("[data-color-click='"+h+"']").length > 0) {
			$("[data-color-click='"+h+"']").click();
		}
	}
});

$(document).on("click", "a.color-switcher", function() {
	$(".special.color-switcher").children("i").removeClass("fa-check-circle").addClass("fa-circle");
	$(this).children("i").addClass("fa-check-circle").removeClass("fa-circle");

	var data = $(this).data("info");
	var id_enhance = $(this).data("id_enhance");
	var i = -1;

	var input_controlador = '';
	var input_slider = '';

	window.location.hash = '#color_'+data.id_color;

	var input_tallas = '<option value="" selected disabled></option>';

	$.each(data.tallas_disponibles, function(indice_talla, info_talla) {
		input_tallas += '<option value="'+info_talla.id_sku+'" data-actual="'+info_talla.cantidad_inicial+'">'+info_talla.caracteristicas.talla+'</option>'
		//input_tallas += '<option value="'+info_talla.id_sku+'" data-actual="500">'+info_talla.caracteristicas.talla+'</option>'
	});

	$("input[name='id_enhance']").val(id_enhance);

	$("#talla_elegida").html(input_tallas);
	$("#cantidad_campana").html('');

	if(typeof data.front_image != 'undefined') {
		var thumb_front = "<?php echo base_url(); ?>image-tool/index.php?src=<?php echo base_url(); ?>"+data.front_image+"&w=150&h=150";
		var large_front = "<?php echo base_url(); ?>image-tool/index.php?src=<?php echo base_url(); ?>"+data.front_image+"&w=750&h=750";
		input_slider += '<div class="slide"><div class="zoomHolder"><img data-src="'+large_front+'" data-elem="pinchzoomer" alt="" /></div></div>';
		input_controlador += '<a data-slide="'+(i+=1)+'" class="active"><img src="'+thumb_front+'" alt=""></a>';
	}
	if(typeof data.back_image != 'undefined') {
		var thumb_back = "<?php echo base_url(); ?>image-tool/index.php?src=<?php echo base_url(); ?>"+data.back_image+"&w=150&h=150";
		var large_back = "<?php echo base_url(); ?>image-tool/index.php?src=<?php echo base_url(); ?>"+data.back_image+"&w=750&h=750";
		input_slider += '<div class="slide"><div class="zoomHolder"><img data-src="'+large_back+'" data-elem="pinchzoomer" alt="" /></div></div>';
		input_controlador += '<a data-slide="'+(i+=1)+'" class="active"><img src="'+thumb_back+'" alt=""></a>';
	}
	if(typeof data.left_image != 'undefined') {
		var thumb_left = "<?php echo base_url(); ?>image-tool/index.php?src=<?php echo base_url(); ?>"+data.left_image+"&w=150&h=150";
		var large_left = "<?php echo base_url(); ?>image-tool/index.php?src=<?php echo base_url(); ?>"+data.left_image+"&w=750&h=750";
		input_slider += '<div class="slide"><div class="zoomHolder"><img data-src="'+large_left+'" data-elem="pinchzoomer" alt="" /></div></div>';
		input_controlador += '<a data-slide="'+(i+=1)+'" class="active"><img src="'+thumb_left+'" alt=""></a>';
	}
	if(typeof data.right_image != 'undefined') {
		var thumb_right = "<?php echo base_url(); ?>image-tool/index.php?src=<?php echo base_url(); ?>"+data.right_image+"&w=150&h=150";
		var large_right = "<?php echo base_url(); ?>image-tool/index.php?src=<?php echo base_url(); ?>"+data.right_image+"&w=750&h=750";
		input_slider += '<div class="slide"><div class="zoomHolder"><img data-src="'+large_right+'" data-elem="pinchzoomer" alt="" /></div></div>';
		input_controlador += '<a data-slide="'+(i+=1)+'" class="active"><img src="'+thumb_right+'" alt=""></a>';
	}

	$(".profile_slider").slick('unslick');
	$(".profile_controller").html(input_controlador);
	$(".profile_slider").html(input_slider);
	$(".profile_slider").slick({
		autoplay: false,
		autoplaySpeed: 4500,
		fade: false,
		speed: 750,
		pauseOnHover: false,
		arrows: false
	});

	$(".zoomHolder [data-src]").each(function() {
		$(this).pinchzoomer();
	});
});

$(document).on("change", ".cat-change, .gen-change", function() {
	window.location.href = $(this).val();
});

</script>
