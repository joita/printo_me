<?php echo doctype('html5'); ?>
<html class="no-js" lang="es" itemscope itemtype="https://schema.org/LocalBusiness">
	<head<?php if(isset($meta['prefix'])) { echo $meta['prefix']; } ?>>
		<?php echo meta('charset', 'utf-8'); ?>
		<?php echo meta('viewport', 'width=device-width, initial-scale=1.0, user-scalable=no'); ?>
<?php if(isset($meta['noindex'])): ?>
<?php if($meta['noindex']): ?>
		<?php echo meta('robots', 'noindex, follow'); ?>
<?php endif; ?>
<?php endif; ?>
		<title><?php if(isset($meta['title'])) { echo $meta['title']; } else { echo 'Diseña tu playera on-line | printome.mx'; } ?></title>
		<?php echo meta('description', (isset($meta['description']) ? $meta['description'] : 'Diseña tu playera on-line | printome.mx')); ?>

		<meta property="fb:app_id" content="<?php echo $this->config->item('facebook_app_id'); ?>" />
		<meta property="og:title" content="<?php if(isset($meta['title'])) { echo $meta['title']; } else { echo 'Diseña tu playera on-line | printome.mx'; } ?>" />
		<meta property="og:description" content="<?php if(isset($meta['description'])) { echo $meta['description']; } else { echo 'Diseña tu playera on-line | printome.mx'; } ?>" />
		<meta property="og:type" content="<?php echo (isset($meta['type']) ? $meta['type'] : 'website'); ?>" />
		<meta property="og:image" content="<?php echo ((isset($meta['imagen']) && $meta['imagen'] != '') ? cdn_url($meta['imagen']) : cdn_url('assets/images/gen-fb.png')); ?>" />
<?php if($nombre_tienda_slug == '6815924531916e476.58236068'): ?>
		<meta property="og:image" content="<?php echo cdn_url('media/assets/uploaded/custom_meta/Prop_0Ads.png'); ?>" />
		<meta property="og:image" content="<?php echo cdn_url('media/assets/uploaded/custom_meta/Prop_1Ads.png'); ?>" />
		<meta property="og:image" content="<?php echo cdn_url('media/assets/uploaded/custom_meta/Prop_2Ads.png'); ?>" />
		<meta property="og:image" content="<?php echo cdn_url('media/assets/uploaded/custom_meta/Prop_3Ads.png'); ?>" />
<?php endif; ?>
		<meta property="og:url" content="<?php echo current_url(); ?>" />
		<meta property="og:site_name" content="printome.mx" />
		<meta property="og:locale" content="es_MX" />
<?php if(isset($meta['type'])): ?>
<?php if($meta['type'] == 'product'): ?>
		<meta property="product:price:amount" content="<?php echo $meta['producto_precio']; ?>" />
		<meta property="product:price:currency" content="MXN" />
		<meta property="product:shipping_cost:amount" content="99.00" />
		<meta property="product:shipping_cost:currency" content="MXN" />
		<meta property="product:product_link" content="<?php echo current_url(); ?>" />
		<meta property="product:condition" content="new" />
		<meta property="product:brand" content="printome" />
		<meta property="product:category" content="Producto personalizado" />
		<meta property="product:expiration_time" content="<?php echo $meta['expiracion']; ?>" />
<?php endif; ?>
<?php endif; ?>

		<base href="<?php echo base_url(); ?>" />
		<link rel='stylesheet' type='text/css' href='assets/css/intlTelInput.min.css'>
        <link rel='stylesheet' type='text/css' href='assets/css/general.css'>
        <link rel="stylesheet" href="assets/css/nuevo_diseno/css/bootstrap.min.css" media="screen" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="assets/css/nuevo_diseno/css/slicknav.css" />
        <link rel="stylesheet" href="assets/css/nuevo_diseno/css/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/nuevo_diseno/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="assets/css/nuevo_diseno/style.css" />
        <style type="text/css"><?php echo file_get_contents('css_2/app.css'); ?></style>
		<link rel="stylesheet" href="assets/css/override.css" />


        <script type="text/javascript" src="assets/css/nuevo_diseno/js/jquery-1.12.4.min.js"></script>
        <script type="text/javascript" src="assets/css/nuevo_diseno/js/modernizr-3.5.0.min.js"></script>
        <script type="text/javascript" src="assets/css/nuevo_diseno/js/jqueryUi.js"></script>
        <script type="text/javascript" src="assets/css/nuevo_diseno/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/css/nuevo_diseno/js/jquery.slicknav.min.js"></script>
        <script type="text/javascript" src="assets/css/nuevo_diseno/js/owl.carousel.min.js"></script>
        <script type="text/javascript" src="assets/css/nuevo_diseno/js/main.js"></script>
		<?php echo link_tag(array('href' => current_url(), 'rel' => 'canonical')); ?>
		<?php echo link_tag(array('href' => 'assets/images/icon.png', 'rel' => 'shortcut icon')); ?>

		<?php if($_SERVER['CI_ENV'] == 'production'): ?>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-W2PKFP4');</script>
		<!-- End Google Tag Manager -->

		<!-- Facebook Pixel Code -->
		<script>
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
		n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
		document,'script','https://connect.facebook.net/en_US/fbevents.js');

		fbq('init', '258875784506817');
		fbq('track', "PageView");
<?php if(isset($pixel_producto)): ?>
		fbq('track', 'ViewContent', {
			content_name: '<?php echo $pixel_producto->nombre_producto; ?>',
			content_category: 'Apparel > Accessories > Clothing',
			content_ids: ['<?php echo $pixel_producto->id_producto; ?>'],
			content_type: 'product',
			currency: 'MXN'
		});
<?php endif; ?>
<?php if(isset($pixel_campana)): ?>
		fbq('track', 'ViewContent', {
			content_name: '<?php echo $pixel_campana->name; ?>',
			content_category: 'Apparel > Accessories > Clothing',
			content_ids: ['<?php echo $pixel_campana->id_enhance; ?>'],
			content_type: 'product',
			value: <?php echo $pixel_campana->price; ?>,
			currency: 'MXN'
		});
<?php endif; ?>
<?php if($this->uri->uri_string() == 'carrito/pagar'): ?>
		fbq('track', 'InitiateCheckout', {
			value: '<?php echo $this->cart->format_number($this->cart->obtener_total()); ?>',
			currency: 'MXN',
			num_items: <?php echo $this->cart->total_items(); ?>
		});
<?php endif; ?>
<?php if(substr($this->uri->uri_string(), 0, 25) == 'carrito/pedido-completado'): ?>
<?php if($this->session->flashdata('total_pedido')): ?>
		fbq('track', 'Purchase', {
			value: '<?php echo $this->session->flashdata('total_pedido'); ?>',
			currency: 'MXN'
		});
<?php endif; ?>
<?php endif; ?>
<?php if($this->session->flashdata('producto_flash')): ?>
<?php $producto = $this->session->flashdata('producto_flash'); ?>
		fbq('track', 'AddToCart', {
			content_name: '<?php echo $producto->nombre_producto; ?>',
			content_category: 'Apparel > Accessories > Clothing',
			content_ids: ['<?php echo $producto->id_producto; ?>'],
			content_type: 'product',
			value: <?php echo $producto->precio; ?>,
			num_items: <?php echo $producto->numero_items; ?>,
			currency: 'MXN'
		});
<?php endif; ?>
<?php if($this->session->flashdata('productos_flash')): ?>
<?php foreach($this->session->flashdata('productos_flash') as $producto): ?>
		fbq('track', 'AddToCart', {
			content_name: '<?php echo $producto->nombre_producto; ?>',
			content_category: 'Apparel > Accessories > Clothing',
			content_ids: ['<?php echo $producto->id_producto; ?>'],
			content_type: 'product',
			value: <?php echo $producto->precio; ?>,
			num_items: <?php echo $producto->numero_items; ?>,
			currency: 'MXN'
		});
<?php endforeach; ?>
<?php endif; ?>

		</script>
		<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=258875784506817&ev=PageView&noscript=1" /></noscript>
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

<?php endif; ?></head>
	<body>
<?php if($_SERVER['CI_ENV'] == 'production'): ?>
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W2PKFP4" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);}gtag('js', new Date()); gtag('config', 'UA-66337302-2');</script>
<?php endif; ?>
		<div id="fb-root"></div>
		<script>
			// Check login status
			function statusCheck(response)
			{
				if (response.status === 'connected')
				{
					<?php if(!$this->session->login): ?>
					FB.api('/me?fields=first_name,last_name,email,birthday,id,gender', function(response) {

						if(!response.email) {
							alert('Requerimos de tu correo electrónico para enviarte avisos e información importante. Por favor vuelve a iniciar sesión con Facebook y proporciónanos tu correo para proceder con tu registro.');
							$('#login').foundation('open');
						} else {
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
						}
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
					version    : 'v2.5'
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
<script src="https://js.stripe.com/v3/"></script>
<script src="assets/js/IntlTelInput/intlTelInput.min.js"></script>

		<div id="main">
