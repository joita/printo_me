<?php echo doctype('html5'); ?>
<html class="no-js" lang="es" itemscope itemtype="https://schema.org/LocalBusiness">
	<head>
		<?php echo meta('charset', 'utf-8'); ?>
		<?php echo meta('viewport', 'width=device-width, initial-scale=1.0, user-scalable=no'); ?>

		<title><?php if(isset($meta['title'])) { echo $meta['title']; } else { echo 'Diseña tu playera on-line | printome.mx'; } ?></title>
		<?php echo meta('description', (isset($meta['description']) ? $meta['description'] : 'Diseña tu playera on-line | printome.mx')); ?>

		<meta property="fb:app_id" content="<?php echo $this->config->item('facebook_app_id'); ?>" />
		<meta property="og:title" content="<?php if(isset($meta['title'])) { echo $meta['title']; } else { echo 'Personalizar playeras en línea | printome.mx'; } ?>" />
		<meta property="og:description" content="<?php if(isset($meta['description'])) { echo $meta['description']; } else { echo 'Sube una imagen e imprime tu playera para uso personal o cualquier evento con la mejor calidad.'; } ?>" />
		<meta property="og:type" content="website" />
		<meta property="og:image" content="<?php echo ((isset($meta['imagen']) && $meta['imagen'] != '') ? site_url($meta['imagen']) : site_url('assets/images/gen-fb.png')); ?>" />
		<meta property="og:url" content="<?php echo current_url(); ?>" />
		<meta property="og:site_name" content="printome.mx" />
		<meta property="og:locale" content="es_MX" />

		<?php echo link_tag(array('href' => current_url(), 'rel' => 'canonical')); ?>
		<?php echo link_tag(array('href' => 'assets/images/icon.png', 'rel' => 'shortcut icon')); ?>

		<base href="<?php echo base_url(); ?>" />
		<style type="text/css"><?php echo file_get_contents('css_2/desbase.css'); ?></style>
        <link rel='stylesheet' type='text/css' href='assets/css/intlTelInput.min.css'>
        <link rel='stylesheet' type='text/css' href='assets/css/general.css'>
        <link rel="stylesheet" href="assets/css/nuevo_diseno/css/bootstrap.min.css" media="screen" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="assets/css/nuevo_diseno/css/slicknav.css" />
        <link rel="stylesheet" href="assets/css/nuevo_diseno/css/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/nuevo_diseno/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="assets/css/nuevo_diseno/style.css" />
		<link rel="stylesheet" href="assets/css/override.css"/>

        <!-- /css -->
        <!-- Js -->
        <script type="text/javascript" src="assets/css/nuevo_diseno/js/jquery-1.12.4.min.js"></script>
        <script type="text/javascript" src="assets/css/nuevo_diseno/js/modernizr-3.5.0.min.js"></script>
        <script type="text/javascript" src="assets/css/nuevo_diseno/js/jqueryUi.js"></script>
        <script type="text/javascript" src="assets/css/nuevo_diseno/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/css/nuevo_diseno/js/jquery.slicknav.min.js"></script>
        <script type="text/javascript" src="assets/css/nuevo_diseno/js/owl.carousel.min.js"></script>
        <script type="text/javascript" src="assets/css/nuevo_diseno/js/main.js"></script>

		<?php if($_SERVER['CI_ENV'] == 'production'): ?>
        <!-- Volley -->
        <!--<link rel="stylesheet" href="https://widget.meetvolley.com/static/css/widget.css"> <script type="text/javascript" data-widget="https://api.meetvolley.com/api/widgets/public/5907c69a-dcf3-47a9-9b81-b6ebdbf57d8a" src="https://widget.meetvolley.com/widget.js"></script>-->
        <!-- Fin Volley -->
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-W2PKFP4');</script>
		<!-- End Google Tag Manager -->
            <script src="https://www.googleoptimize.com/optimize.js?id=OPT-MTZCKCT"></script>
		<!-- Facebook Pixel Code -->
		<script>
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
		n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
		document,'script','https://connect.facebook.net/en_US/fbevents.js');

		fbq('init', '258875784506817');
		fbq('track', "PageView");
		</script>
		<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=258875784506817&ev=PageView&noscript=1" alt="" /></noscript>
		<!-- End Facebook Pixel Code -->

		<script type="text/javascript">
		var trackcmp_email = '<?php echo $this->session->login['email'] ?>';
		var trackcmp = document.createElement("script");
		trackcmp.async = true;
		trackcmp.type = 'text/javascript';
		trackcmp.src = '//trackcmp.net/visit?actid=609525036&e='+encodeURIComponent(trackcmp_email)+'&r='+encodeURIComponent(document.referrer)+'&u='+encodeURIComponent(window.location.href);
		var trackcmp_s = document.getElementsByTagName("script");
		if (trackcmp_s.length) {
			trackcmp_s[0].parentNode.appendChild(trackcmp);
		} else {
			var trackcmp_h = document.getElementsByTagName("head");
			trackcmp_h.length && trackcmp_h[0].appendChild(trackcmp);
		}
		</script>
		<?php endif; ?>
	</head>
	<body>
<?php if($_SERVER['CI_ENV'] == 'production'): ?>
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W2PKFP4" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php endif; ?>
		<script>
			// Check login status
			function statusCheck(response)
			{
				if (response.status === 'connected')
				{
					<?php if(!$this->session->login): ?>
					FB.api('/me?fields=first_name,last_name,email,birthday,id,gender', function(response) {
						$.post('<?php echo site_url('registro/facebook'); ?>', {
							id: response.id,
							first_name: response.first_name,
							last_name: response.last_name,
							email: response.email,
							gender: response.gender,
							birthday: response.birthday
						}).done(function() {
							window.location.reload();
						});
					});
					<?php endif; ?>
				}
				else if (response.status === 'not_authorized')
				{

				}
				else
				{

				}
			}

			// Get login status
			function loginCheck()
			{
				FB.getLoginStatus(function(response) {
					statusCheck(response);
				});
			}

			window.fbAsyncInit = function() {
				FB.init({
					appId      : '<?php echo $this->config->item('facebook_app_id'); ?>',
					xfbml      : true,
					version    : 'v2.12'
				});

				FB.getLoginStatus(function(response) {
					loginCheck(response);
				});
			};

			(function(d, s, id){
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/es_LA/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>

		<?php $this->load->view('menu'); ?>

		<script type="text/javascript">
			var baseURL = '<?php echo base_url(); ?>';
			var urlCase = '<?php echo site_url('image-tool/thumbs.php'); ?>';
			var edit_text_title = 'Editar Texto';
			var team_number_title = 'team_number';
			var confirm_reset_msg = '¿Deseas empezar tu diseño en limpio? Cualquier cambio que hayas realizado se borrará. Esta acción no se puede deshacer.';
			var add_qty_or_size_msg = 'No olvides agregar la cantidad de playeras que necesitas.';
			var minimum_qty_msg = 'Al menos debes ordenar: ';
			var please_add_qty_or_size_msg = 'Por favor agrega una cantidad de playeras.';
			var please_try_again_msg = 'Por favor vuelve a intentar.';
			var select_a_color_msg = 'Selecciona un color.';
			var tick_the_checkbox_msg = 'Es necesario aceptar los términos y condiciones.';
			var choose_a_file_upload_msg = 'Selecciona un archivo.';
			var myAccount = '';
			var logOut = '';
			var print_type = 'screen';

			<?php if ( isset($user['id']) ) { ?>
				var user_id = <?php echo $user['id']; ?>;
			<?php }else{ ?>
				var user_id = 0;
			<?php } ?>
		</script>

		<div class="fgc pscat" style="background: white">
			<div id="main" data-equalizer>
