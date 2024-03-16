
		</div>
		<?php $this->load->view('tienda/menu_footer'); ?>

		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<?php if($_SERVER['CI_ENV'] == 'production'): ?>
		<!-- Hotjar Tracking Code for https://printome.mx -->
		<script>
			(function(h,o,t,j,a,r){
				h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
				h._hjSettings={hjid:457256,hjsv:5};
				a=o.getElementsByTagName('head')[0];
				r=o.createElement('script');r.async=1;
				r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
				a.appendChild(r);
			})(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
		</script>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-66337302-2', 'auto');
			ga('require', 'displayfeatures');
			ga('require', 'linkid', 'linkid.js');
			ga('require', 'ecommerce');
			ga('send', 'pageview');
<?php if($this->session->flashdata('producto_flash')): ?>
<?php $producto = $this->session->flashdata('producto_flash'); ?>
			ga('ecommerce:addItem', {
				'id': '<?php echo $producto->id_producto; ?>',
				'name': '<?php echo $producto->nombre_producto; ?>',
				'sku': '<?php echo $producto->id_producto; ?>',
				'category': 'Ropa',
				'price': '<?php echo $producto->precio; ?>',
				'quantity': '<?php echo $producto->numero_items; ?>',
				'currency': 'MXN'
			});
			ga('ecommerce:send');
<?php endif; ?>
<?php if($this->session->flashdata('productos_flash')): ?>
<?php foreach($this->session->flashdata('productos_flash') as $producto): ?>
			ga('ecommerce:addItem', {
				'id': '<?php echo $producto->id_producto; ?>',
				'name': '<?php echo $producto->nombre_producto; ?>',
				'sku': '<?php echo $producto->id_producto; ?>',
				'category': 'Ropa',
				'price': '<?php echo $producto->precio; ?>',
				'quantity': '<?php echo $producto->numero_items; ?>',
				'currency': 'MXN'
			});
			ga('ecommerce:send');
<?php endforeach; ?>
<?php endif; ?>
<?php if(substr($this->uri->uri_string(), 0, 25) == 'carrito/pedido-completado'): ?>
<?php if($this->session->flashdata('total_pedido')): ?>
			ga('ecommerce:addTransaction', {
				'id': '<?php echo $this->session->flashdata('tracking_id_pedido'); ?>',
				'affiliation': 'Printome',
				'revenue': '<?php echo $this->session->flashdata('total_pedido'); ?>',
				'shipping': '<?php echo $this->session->flashdata('tracking_shipping'); ?>',
				'tax': '<?php echo $this->session->flashdata('tracking_iva'); ?>',
				'currency': 'MXN'
			});
			ga('ecommerce:send');
<?php endif; ?>
<?php endif; ?>
		</script><?php endif; ?>

		<script>var base_url = '<?php echo base_url(); ?>';var current_url = '<?php echo current_url(); ?>';<?php if(isset($this->session->mostrar_tutorial_campana)) { if(!$this->session->mostrar_tutorial_campana) { ?>var mostrar_tutorial = false;<?php } else { ?>var mostrar_tutorial = true;<?php } } else { ?>var mostrar_tutorial = true;<?php } ?><?php if(!$this->session->has_userdata('cupon_solicitado') && !$this->session->has_userdata('login') && !$this->session->tempdata('ocultar_cupon_5_min')): ?>var mostrar_cupon = true;<?php else: ?>var mostrar_cupon = false;<?php endif; ?></script>
		<script src="<?php echo site_url('js/main.js?v='.time()); ?>"></script>
		<?php if(isset($scripts) && isset($script_datos)) {
			$this->load->view($scripts, $script_datos);
		} else if(isset($scripts)){
			$this->load->view($scripts);
		} ?>

	</body>
</html>
