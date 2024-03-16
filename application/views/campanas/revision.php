<div class="fgc pscat" style="min-height:500px;">
	<div class="row">
		<div class="small-18 medium-14 large-12 xlarge-11 medium-centered columns" id="falta-poco">
			<h3 class="text-center azul">¡Estás a un paso de empezar a vender!</h3>
			<p class="text-justify aceptamos" style="color:#555;font-size: 1rem;">A continuación nuestro personal revisará la información y el contenido de tu diseño y si todo está en orden te enviaremos un correo con el vínculo de tu producto para que puedas comenzar a promocionarlo.</p>
			<p class="text-justify aceptamos" style="color:#555;font-size: 1rem;">En caso de que tu diseño no haya cumplido con los <a href="<?php echo site_url('terminos-y-condiciones'); ?>" target="_blank">términos y condiciones</a> de printome.mx, te enviaremos un correo con los motivos del rechazo.</p>
			<p class="text-justify aceptamos" style="color:#555;font-size: 1rem;">Serás redirigido al listado de tus productos automáticamente en <span id="timeme">30</span> segundos.</p>
		</div>
	</div>
</div>

<script>
	setTimeout(function(){
		window.location = "<?php echo site_url('mi-cuenta/productos'); ?>"
	}, 30000);
	
	var tiempo = 30;
	setInterval(function() {
		tiempo -= 1;
		document.getElementById("timeme").innerHTML = tiempo;
	}, 1000);
</script>
