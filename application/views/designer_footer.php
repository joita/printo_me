			</div>
		</div>
		<?php $this->load->view('nuevo_footer'); ?>


		<div id="walkthrough-content" class="hide">
			<div id="paso-1">
				<h1>¡Hola!</h1>
				<p>Conoce la manera en la que funciona nuestro personalizador.</p>
				<a class="no_quiero_tutorial" data-mostrar="<?php if(isset($this->session->mostrar_tutorial)) { if(!$this->session->mostrar_tutorial) { ?>si<?php } else { ?>no<?php } } else { ?>no<?php } ?>"><i class="fa fa-<?php if(isset($this->session->mostrar_tutorial)) { if(!$this->session->mostrar_tutorial) { ?>check-<?php } else { ?><?php } } else { ?><?php } ?>square-o"></i> No volver a mostrar</a>
			</div>
			<div id="paso-2">
				<h1>¡Elige tu playera!</h1>
				<p>Tenemos disponibles modelos y diferentes estilos para damas, caballeros, niños y adolescentes.</p>
			</div>
			<div id="paso-3">
				<h1>¡Elige tu color!</h1>
				<p>Elige el color de prenda que más te guste.</p>
			</div>
			<!--<div id="paso-3">
				<h1>¡Decide el color!</h1>
				<p>Escoge el color de prenda que te guste más.</p>
			</div>-->
			<div id="paso-4">
				<h1>¡Personalízala!</h1>
				<p>Agrega algún texto, sube una imagen o utiliza nuestros artes.</p>
                <p style="font-size: 0.7rem">Recuerda que la impresión no siempre será idéntica al color de la imagen digital. Dependerá de la calidad de la imagen proporcionada.</p>
			</div>
			<div id="paso-5">
				<h1>¡Cuidado!</h1>
				<p>Asegúrate que tu diseño se ajuste en el área de impresión. (Los bordes punteados de tu playera)</p>
                <p style="font-size: 0.7rem">La medida del área de impresión máxima es de 15 cm por 12 cm para niños y de 30 cm por 35 cm para adultos, sin embargo dependiendo del diseño podrían existir variaciones en las impresiones.</p>
			</div>
			<div id="paso-6">
				<h1>¿Ya está listo tu diseño?</h1>
				<p>¡Haz clic en siguiente! Escoge si deseas comprar o poner a la venta tu diseño.</p>
				<a class="no_quiero_tutorial" data-mostrar="<?php if(isset($this->session->mostrar_tutorial)) { if(!$this->session->mostrar_tutorial) { ?>no<?php } else { ?>si<?php } } else { ?>si<?php } ?>"><i class="fa fa-<?php if(isset($this->session->mostrar_tutorial)) { if(!$this->session->mostrar_tutorial) { ?>check-<?php } else { ?><?php } } else { ?><?php } ?>square-o"></i> No volver a mostrar</a>
			</div>
		</div>

		<div class="reveal large" data-reveal id="video-como">
			<div class="flex-video widescreen">
				<iframe width="853" height="480" src="https://www.youtube.com/embed/paIPziwo5yg?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
			</div>
			<button class="close-button" data-close aria-label="Cerrar" type="button">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>


		<?php if (isset($product->design)) {?>
		<script type="text/javascript">
		//var min_order = '<?php //echo $product->min_order; ?>';
		var min_order = '1';
		var product_id = '<?php echo $product->id_producto; ?>';
		//var print_type = '<?php //echo $product->print_type; ?>';
		var user_id = <?php echo ($this->session->login ? $this->session->login['id_cliente'] : 0); ?>;
		var uploadSize = [];
		uploadSize['max']  = '20';
		uploadSize['min']  = '0.5';
		var items = {};
		items['design'] = {};
		<?php
		$js = '';
		$elment = count($product->design->color_hex);
		for($i=0; $i<$elment; $i++)
		{
		  $js .= "items['design'][$i] = {};";
		  $js .= "items['design'][$i]['color'] = \"".$product->design->color_hex[$i]."\";";
		  $js .= "items['design'][$i]['title'] = \"".url_title($product->design->color_title[$i])."\";";
		  $postions = array('front', 'back', 'left', 'right');
		  foreach ($postions as $v)
		  {
			$view = $product->design->$v;
			if (count($view) > 0)
			{
			  if (isset($view[$i]) == true)
			  {
				$item = (string) $view[$i];
				$js .= "items['design'][".$i."]['".$v."']=\"".$item."\";";
			  }
			  else
			  {
				$js .= "items['design'][$i]['$v'] = '';";
			  }
			}
			else
			{
			  $js .= "items['design'][$i]['$v'] = '';";
			}
		  }
		}
		echo $js;
		?>
		items['area'] = {};
		items['area']['front']  = "<?php echo $product->design->area->front; ?>";
		items['area']['back']   = "<?php echo $product->design->area->back; ?>";
		items['area']['left']   = "<?php echo $product->design->area->left; ?>";
		items['area']['right']  = "<?php echo $product->design->area->right; ?>";
		items['params'] = [];
		items['params']['front']  = "<?php echo $product->design->params->front; ?>";
		items['params']['back'] = "<?php echo $product->design->params->back; ?>";
		items['params']['left'] = "<?php echo $product->design->params->left; ?>";
		items['params']['right']  = "<?php echo $product->design->params->right; ?>";

		</script>
		<?php } ?>

		<script>
			var base_url = '<?php echo base_url(); ?>';
			var current_url = '<?php echo current_url(); ?>';
			<?php if($id_color !== 0){ ?>
			var id_color='<?php echo $id_color; ?>';
			var productColor=true;
			<?php } else { ?>
			var id_color=0;
			var productColor=false;
			<?php } ?>

			<?php if($id_unico != ''){ ?>
			var id_unico='<?php echo $id_unico; ?>';
			var cargarDiseno=true;
			<?php } else { ?>
			var id_unico=0;
			var cargarDiseno=false;
			<?php } ?>

			<?php if(isset($this->session->mostrar_tutorial)) { if(!$this->session->mostrar_tutorial) { ?>
			var mostrar_tutorial = false;
			<?php } else { ?>
			var mostrar_tutorial = true;
			<?php } } else { ?>
			var mostrar_tutorial = true;
			<?php } ?>

			<?php if(isset($this->session->diseno_temp)): ?>
			var diseno_sesion = true;
			<?php else: ?>
			var diseno_sesion = false;
			<?php endif; ?>
		</script>
		<script src="<?php echo base_url('js/maindes.js?v='.time()); ?>" async defer></script>

		<?php if($_SERVER['CI_ENV'] == 'production'): ?>
		<?php /*
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
		*/ ?>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-66337302-2', 'auto');
			ga('require', 'displayfeatures');
			ga('send', 'pageview');

		</script>
		<?php endif; ?>
	</body>
</html>
