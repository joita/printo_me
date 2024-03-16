<div class="row collapse" id="contenedor_video_ac">
	<div class="small-18 columns">
		<video id="video_serigrafia" width="1920" height="1080" poster="<?php echo site_url('assets/videos/ac.jpg'); ?>" muted loop autoplay>
			<source src="<?php echo site_url('assets/videos/ac.mp4'); ?>" type="video/mp4">
			<source src="<?php echo site_url('assets/videos/ac.webm'); ?>" type="video/webm">
			Tu navegador no soporta videos de HTML5.
		</video>
		
		<div id="fondo_rayas">
			<h1>¿Necesitas recaudar fondos<br> para una causa?</h1>
			
			<a id="link_abajo" data-scroll data-options='{"speed":1000}' href="<?php echo current_url(); ?>#info_pasos_vende">
				<span>Mira lo que Printome puede hacer por ti</span>
				<i class="fa fa-angle-down first animated infinite fadeIn"></i>
				<i class="fa fa-angle-down second animated infinite fadeIn"></i>
				<i class="fa fa-angle-down third animated infinite fadeIn"></i>
			</a>
		</div>
	</div>
</div>