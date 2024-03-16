        <item>
            <g:id><?php echo $producto->id_producto; ?></g:id>
            <g:title><?php echo $producto->nombre_producto; ?></g:title>
            <g:description><?php echo $producto->descripcion_producto; ?></g:description>
            <g:link><?php echo site_url($producto->vinculo_producto); ?></g:link>
            <g:image_link><?php echo site_url($producto->ubicacion_base.$producto->id_producto.'.jpg'); ?></g:image_link>
            <g:brand>Avanda</g:brand>
            <g:condition>new</g:condition>
            <g:availability>in stock</g:availability>
			<?php if ($producto->descuento_especifico > 0.00 || $producto->descuento_global): ?>
			<g:price><?php echo $this->cart->format_number(redondeo($producto->precio_descuento)); ?> MXN</g:price>
			<?php else: ?>
			<g:price><?php echo $this->cart->format_number(redondeo($producto->precio_producto)); ?> MXN</g:price>
			<?php endif; ?>
            <g:shipping>
                <g:country>MX</g:country>
                <g:service>Standard</g:service>
                <g:price><?php echo $this->cart->format_number($this->cart->obtener_costo_envio()); ?> MXN</g:price>
            </g:shipping>

            <g:google_product_category>Apparel &amp; Accessories &gt; Clothing &gt; Shirts &amp; Tops</g:google_product_category>
        </item>
