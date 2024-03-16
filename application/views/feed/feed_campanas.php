        <item>
            <g:id><?php echo $campana->id_enhance; ?></g:id>
            <g:title><![CDATA[<?php echo trim(htmlspecialchars($campana->name)); ?>]]></g:title>
            <g:description><![CDATA[<?php echo trim(htmlspecialchars($campana->description)); ?>]]></g:description>
            <g:link><?php echo site_url($campana->vinculo_producto); ?></g:link>
            <g:image_link><?php echo site_url($campana->front_image); ?></g:image_link>
            <g:brand>Printome</g:brand>
            <g:condition>new</g:condition>
            <g:availability>in stock</g:availability>
			<g:price><?php echo $this->cart->format_number($campana->price); ?> MXN</g:price>
            <g:shipping>
                <g:country>MX</g:country>
                <g:service>DHL Express</g:service>
                <g:price>99.00 MXN</g:price>
            </g:shipping>

            <g:google_product_category>Apparel &amp; Accessories &gt; Clothing &gt; Shirts &amp; Tops</g:google_product_category>
        </item>
