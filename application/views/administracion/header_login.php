<?php echo doctype('html5'); ?> 
<html class="no-js" lang="es">
	<head>
		<?php echo meta('charset', 'utf-8'); ?>
		<?php echo meta('viewport', 'width=device-width, initial-scale=1.0'); ?>
		
		<title>Administración</title>
		<?php echo meta('description', 'Panel de administración de Print-o-Me .'); ?>
		
		<?php echo link_tag(array('href' => current_url(), 'rel' => 'canonical')); ?>
		
		<?php echo link_tag('assets/css/normalize.css'); ?>
		<?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css'); ?>
		<?php echo link_tag('assets/css/jquery.qtip.min.css'); ?>
		<?php echo link_tag('assets/css/foundation.css'); ?>
		<?php echo link_tag('assets/css/admin.css'); ?>
		<?php echo link_tag('assets/js/spectrum/spectrum.css'); ?>
		
		<?php echo link_tag(array('href' => 'assets/images/icon.png', 'rel' => 'shortcut icon')); ?>
		<script>
			var oldieCheck = Boolean(document.getElementsByTagName('html')[0].className.match(/\soldie\s/g));
			if(!oldieCheck) {
				document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"><\/script>');
					document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.2.1/jquery-migrate.min.js"><\/script>');
			} else {
				document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"><\/script>');
			}
		</script>
		<script>
			if(!window.jQuery) {
				if(!oldieCheck) {
					document.write('<script src="<?php echo site_url('assets/js/vendor/jquery/2.1.3/jquery.min.js'); ?>"><\/script>');
					document.write('<script src="<?php echo site_url('assets/js/vendor/jquery-migrate/1.2.1/jquery-migrate.min.js'); ?>"><\/script>');
				} else {
					document.write('<script src="<?php echo site_url('assets/js/vendor/jquery/1.11.2/jquery.min.js'); ?>"><\/script>');
				}
			}
		</script>
		<script src="<?php echo site_url('assets/js/vendor/modernizr.js'); ?>"></script>
		
		<style type="text/css">
		div#contenedor-login {
			background: #fefefe;
			border: solid 1px #0a749d;
			border-radius: 4px;
			margin-top: 3rem;
			box-shadow: 0px 1px 6px rgba(0,0,0,0.2);
		}
		</style>
		<!--[if lt IE 9]>
		<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
		<script src="//s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.5-min.js"></script>
		<script src="//html5base.googlecode.com/svn-history/r38/trunk/js/selectivizr-1.0.3b.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		
		<div class="row padded white" id="contenedor-galeria">
			<div class="small-18 medium-12 large-6 small-centered columns">
				<div id="contenedor-login">
					<div class="row">
						<div class="small-12 columns small-centered text-center" style="padding-top:2rem;">
							<img src="<?php echo site_url('assets/images/icon.png'); ?>" />
						</div>
					</div>
					
					<div class="row">
						<div class="small-20 columns small-centered" style="margin: 2.5rem auto 0.7rem">
							<form method="post" action="<?php echo site_url('administracion/login/login_proceso'); ?>">
								<div class="row">
									<div class="small-24 columns">
										<label>Usuarios
											<input class="width100" type="text" name="usuario" id="usuario" required />
										</label>
									</div>
								</div>
								<div class="row">
									<div class="small-24 columns">
										<label>Contraseña
											<input class="width100" type="password" name="password" id="password" required />
										</label>
									</div>
								</div>
								<div class="row">
									<div class="small-24 columns text-center">
										<button id="btn-inicia" type="submit" class="btn width100 button success">Iniciar sesión</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
