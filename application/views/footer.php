
		</div>
		<?php $this->load->view('nuevo_footer'); ?>
		<?php if($seccion_activa == 'productos' || $seccion_activa == 'compra'): ?>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		<?php endif; ?>
<?php if($_SERVER['CI_ENV'] == 'production'): ?>
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

        <!--CUENTAS DE GTAG VIEJAS-->
        <!--<script async src="https://www.googletagmanager.com/gtag/js?id=AW-870310843"></script>-->
        <!--<script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-870310843');</script>-->
        <!--END CUENTAS DE GTAG VIEJAS-->
        <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
<!--    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-66337302-2"></script>-->

        <!-- Global site tag (gtag.js) - Google Analytics END-->
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-66337302-2"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'UA-66337302-2');
<?php if(isset($pixel_campana)): ?>
            //ga('set', 'ecomm_prodid', '<?php //echo $pixel_campana->id_enhance; ?>//');
            //ga('set', 'ecomm_pagetype', 'product');
            //ga('set', 'ecomm_totalvalue', '<?php //echo $pixel_campana->price; ?>//');
            gtag('event', 'page_view', {'send_to': 'UA-66337302-2',
                'ecomm_prodid': '<?php echo $pixel_campana->id_enhance; ?>',
                'ecomm_pagetype': 'product',
                'ecomm_totalvalue': '<?php echo $pixel_campana->price; ?>'
            });
<?php endif; ?>
<?php //if($this->session->flashdata('producto_flash')): ?>
<?php //$producto = $this->session->flashdata('producto_flash'); ?>
//            gtag('event', 'add_to_cart', {
//                "items": [
//                    {
//                        "id": '<?php //echo $producto->id_producto; ?>//',
//                        "name": '<?php //echo $producto->nombre_producto; ?>//',
//                        "brand": 'Printome',
//                        "category": 'Apparel & Accessories > Clothing > Shirts & Tops',
//                        "quantity": <?php //echo $producto->numero_items; ?>//,
//                        "price": <?php //echo $producto->precio; ?>
//                    }
//                ]
//            });
<?php //endif; ?>
<?php if($this->session->tempdata('productos_flash') &&  !$this->session->tempdata('pedido_completado_metodo')): ?>

            gtag('event', 'add_to_cart', {
                "items": [<?php foreach($this->session->tempdata('productos_flash') as $producto): ?>
                    {
                        "id": '<?php echo $producto->id_producto; ?>',
                        "name": '<?php echo $producto->nombre_producto; ?>',
                        "brand": 'Printome',
                        "category": 'Apparel & Accessories > Clothing > Shirts & Tops',
                        "quantity": <?php echo $producto->numero_items; ?>,
                        "price": <?php echo $producto->precio; ?>
                    },
            <?php endforeach; ?>]
            });

<?php endif; ?>
<?php if($this->session->tempdata('pedido_completado_metodo')):?>
    <?php
    $total_pedido =  $this->session->tempdata('total_pedido');
    $trackin_id = $this->session->tempdata('tracking_id_pedido');
    ?>
    gtag('event', 'conversion', {
        'send_to': 'UA-66337302-2/conversion',
        'value': <?php echo $total_pedido ?>,
        'currency': 'MXN',
        'transaction_id': '<?php echo $trackin_id ?>'
    });
    gtag('event', 'purchase', {
        "transaction_id": '<?php echo $trackin_id; ?>',
        "affiliation": '<?php echo $this->session->tempdata('pedido_completado_metodo'); ?>',
        "value": <?php echo $total_pedido; ?>,
        "shipping": <?php echo $this->session->tempdata('tracking_shipping'); ?>,
        "currency": "MXN",
        "items": [
        <?php if($this->session->tempdata('productos_flash')): ?>
        <?php foreach($this->session->tempdata('productos_flash') as $producto): ?>
            {
                "id":'<?php echo $producto->id_producto; ?>',
                "name": '<?php echo $producto->nombre_producto; ?>',
                "brand": "Printome",
                "category": 'Apparel & Accessories > Clothing > Shirts & Tops',
                "quantity": <?php echo $producto->numero_items; ?>,
                "price": <?php echo $producto->precio; ?>
            },
        <?php endforeach; ?>
        <?php endif; ?>
        ]
    });
    <?php $this->session->unset_userdata("pedido_completado_metodo");?>
<?php endif; ?>
		</script>
<?php endif; ?>

		<script>var base_url = '<?php echo base_url(); ?>';var current_url = '<?php echo current_url(); ?>';<?php if(isset($this->session->mostrar_tutorial_campana)) { if(!$this->session->mostrar_tutorial_campana) { ?>var mostrar_tutorial = false;<?php } else { ?>var mostrar_tutorial = true;<?php } } else { ?>var mostrar_tutorial = true;<?php } ?><?php if(!$this->session->has_userdata('cupon_solicitado') && !$this->session->has_userdata('login') && !$this->session->tempdata('ocultar_cupon_5_min')): ?>var mostrar_cupon = true;<?php else: ?>var mostrar_cupon = false;<?php endif; ?></script>
		<script src="<?php echo site_url('js/main.js?v='.time()); ?>"<?php echo (isset($seccion_activa) ? ($seccion_activa == 'inicio' ? ' async defer' : '') : ''); ?>></script>
		<?php if(isset($scripts) && isset($script_datos)) {
			$this->load->view($scripts, $script_datos);
		} else if(isset($scripts)){
			$this->load->view($scripts);
		} ?>

	</body>
</html>
