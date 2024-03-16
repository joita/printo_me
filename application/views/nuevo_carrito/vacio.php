<div class="fgc pscat">
	<div class="row small-collapse medium-uncollapse" id="cart-holder">
        <div class="small-18 medium-11 large-12 columns cart-area">
            <div class="address-area">
                <div class="row">
                    <div class="small-18 columns">
                        <h2 class="dosf text-center medium-text-left" style="margin-bottom:0;">Tu Carrito</h2>
                        <div class="row" id="sadface">
                            <div class="small-18 medium-18 large-6 columns text-center">
                                <img id="sf" src="<?php echo site_url('assets/nimages/sad.png'); ?>" alt="Triste" />
                            </div>
                            <div class="small-18 medium-18 large-12 columns" id="sfp">
                                <?php if($nombre_tienda_slug): ?>
                                    <p class="text-left medium-text-justify">Mira que otros productos ofrece esta tienda <a href="<?php echo site_url('tienda/'.$nombre_tienda_slug); ?>">aquí</a>.</p>
                                <?php else: ?>
                                    <p class="text-left medium-text-justify">Tu carrito está vacío. ¿Todavía no has <a href="<?php echo site_url('personalizar'); ?>">personalizado</a> algún producto?</p>
                                    <p class="text-left medium-text-justify">Recuerda que también puedes <a href="<?php echo site_url('compra'); ?>">comprar</a> los productos que han diseñado los demás.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-18 medium-7 large-6 columns sums-area" id="sums-area-top">
            <div>
                <div>
                    <?php $this->load->view('nuevo_carrito/mini_cart_excerpt'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
