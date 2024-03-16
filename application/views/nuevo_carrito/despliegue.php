<?php if($nombre_tienda_slug) {
    echo form_open('tienda/'.$nombre_tienda_slug.'/carrito/actualizar');
} else {
    echo form_open('carrito/actualizar');
} ?>
<div class="fgc pscat" style="background: white">
	<div class="row small-collapse medium-uncollapse" id="cart-holder">
        <div class="col-md-8 col-xs-12 cart-area">
            <div class="address-area">
                <h2 class="text-center medium-text-left" style="color: #FF4C00;font-weight: bold; border: none; border-bottom: 2px solid #025573;">Tu Carrito</h2>
            </div>
            <?php $i = 1;  ?>
            <?php foreach($this->cart->contents() as $items): ?>
            <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
            <input type="hidden" name="<?php echo $i; ?>[qty]" value="<?php echo $items['qty']; ?>" data-id_row="<?php echo $items['rowid']; ?>" class="qtyact" data-id="<?php echo $i; ?>" />
            <?php $options = $this->cart->product_options($items['rowid']); ?>
            <?php $info_color = array(); preg_match('/#([a-fA-F0-9]){3}(([a-fA-F0-9]){3})?\b/', $options['codigo_color'], $info_color); ?>
            <div style="border: 1px solid #025573; border-radius: 10px" class="row cart-entry<?php echo ($options['enhance'] ? ($options['tipo_enhance'] == 'limitado' ? ' enhance' : '') : ''); ?>" data-id_row="<?php echo $items['rowid']; ?>">
                <div class="col-md-2 cart-entry-img-holder">
                    <img src="<?php echo getCustomImage($options); ?>" alt="Fotografía del producto" class="cart-entry-img" />
                </div>
                <div class="col-md-6 cart-entry-middle-col">
                    <span style="color:#025573" class="cart-entry-title"><?php echo $items['name'].($options["enhance"] != 'enhance' ? ' personalizada' : ''); ?></span>
                    <?php if(isset($options['talla'])): ?>
                    <span style="color:#025573" class="cart-entry-info">Talla: <?php echo $options['talla']; ?>, Color: <i class="fa fa-circle" style="color:<?php echo $info_color[0]; ?>; text-shadow: 0px 0px 2px #025573;"></i></span>
                    <?php endif; ?>
                    <div style="color:#025573" class="cart-entry-links">
                        <?php if($options['enhance']): ?>
                        <?php if(!$nombre_tienda_slug): ?>
                        <a style="color:#025573; border: 2px solid #025573; border-radius: 10px" href="<?php echo $this->enhance_modelo->obtener_link_ehnance($options['id_enhance']); ?>" class="more-cantidad cart-entry-more-sizes" data-tipo="enhance"><i class="fa fa-plus-square"></i> Más<span> tallas</span></a>
                        <?php endif; ?>
                        <a style="color:#025573; border: 2px solid #025573; border-radius: 10px" href="<?php echo site_url('carrito/quitar/'.$items['rowid'].($nombre_tienda_slug ? '/'.$nombre_tienda_slug : '')); ?>" class="borrar-cantidad cart-entry-delete"><i class="fa fa-trash"></i><span>Eliminar</span></a>
                        <?php else: ?>
                        <a style="color:#025573; border: 2px solid #025573; border-radius: 10px" class="edit-diseno-custom cart-entry-edit-design" data-id_producto="<?php echo $items['id']; ?>" data-id_color="<?php $info_color = $this->catalogo_modelo->obtener_id_color_con_id_producto_y_hex($items['id'], $options['disenos']['color']); echo $info_color->id_color; ?>" data-id_diseno="<?php echo $options['id_diseno']; ?>"><i class="fa fa-image"></i><span> Editar diseño</span></a>
                        <a style="color:#ee4500; border: 2px solid #ee4500; border-radius: 10px" href="<?php echo site_url('carrito/borrar_custom_en_carrito/'.$items['rowid'].'/'.$options['id_diseno']); ?>" data-id_fila="<?php echo $items['rowid']; ?>" data-id_diseno="<?php echo $options['id_diseno']; ?>" class="borrar-cantidad-custom cart-entry-delete"><i class="fa fa-trash"></i><span> Eliminar</span></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4 cart-entry-last-col text-center">
                    <span class="cart-entry-whole-price">
                        <span class="cart-entry-multiplier"><?php echo $items['qty']; ?></span>
                        <span class="cart-entry-x"> x </span>
                        <span class="cart-entry-price" style="color: #FF4C00;font-weight: bold;">$<?php echo $this->cart->format_number(($items['price'])); ?></span>
                    </span>
                    <?php if($options['enhance']): ?>
                    <?php
                        $enhance = $this->enhance_modelo->obtener_enhance($options['id_enhance']);
                        $sku_info = $this->productos_modelo->obtener_skus_activos_por_color($enhance->id_color, $options['sku']);
                    ?>
                    <?php if($enhance->type == 'fijo'): ?>
                    <a style="color:#A6C662; border: 2px solid #A6C662; border-radius: 10px" class="cart-entry-edit-quantity edit-cantidad fija" data-id_row="<?php echo $items['rowid']; ?>" data-open="cantidades_campana" data-tipo="enhance" data-actual="<?php echo $sku_info[0]->cantidad_inicial/*'500'*/; ?>"><i class="fa fa-edit"></i> Editar<span class="show-for-medium"> cantidad</span></a>
                    <?php elseif($enhance->type == 'limitado'): ?>
                    <a style="color:#A6C662; border: 2px solid #A6C662; border-radius: 10px" class="cart-entry-edit-quantity edit-cantidad limitada" data-id_row="<?php echo $items['rowid']; ?>" data-open="cantidades_campana_limitada" data-tipo="enhance"><i class="fa fa-edit"></i> Editar<span class="show-for-medium"> cantidad</span></a>
                    <?php endif; ?>
                    <?php else: ?>
                    <a style="color:#A6C662; border: 2px solid #A6C662; border-radius: 10px" class="cart-entry-edit-quantity edit-cantidad-custom" data-id_row="<?php echo $items['rowid']; ?>" data-open="cantidades_custom" data-id_diseno="<?php echo $options['id_diseno']; ?>" data-tipo="custom"><i class="fa fa-edit"></i> Editar<span class="show-for-medium"> cantidad</span></a>
                    <?php endif; ?>
                    <?php if(check_team($options)): ?>
                        Playera de equipo
                    <?php endif; ?>
                </div>
            </div>
            <?php $i++; ?>
            <?php endforeach; ?>

            <div class="row" id="additional-button-holder">
                <div class="col-xs-12 col-md-8">
                    <?php /*<a href="<?php echo site_url('compra'); ?>" class="small button" id="agmas"><i class="fa fa-cart-plus"></i><span class="show-for-medium"> Agregar Productos</span></a>*/ ?>
                    <?php if($nombre_tienda_slug): ?>
                        <a style="color:#A6C662; border: 2px solid #A6C662; border-radius: 10px" href="<?php echo site_url('tienda/'.$nombre_tienda_slug); ?>" class="small button" id="agmas"><i class="fa fa-cart-plus"></i><span class="show-for-medium"> Agregar Productos</span></a>
                    <?php else: ?>
                        <a style="color:#A6C662; border: 2px solid #A6C662; border-radius: 10px" href="<?php echo site_url('compra'); ?>" class="small button" id="agmas"><i class="fa fa-cart-plus"></i><span class="show-for-medium"> Agregar Productos</span></a>
                        <a style="color:#025573; border: 2px solid #025573; border-radius: 10px" href="<?php echo site_url('personalizar'); ?>" class="small button" id="permas"><i class="fa fa-image"></i> <span class="show-for-medium"> Personalizar</span></a>
                    <?php endif; ?>
                    <button type="submit" id="actualizar_car" class="hide">Actualizar</button>
                </div>
                <div class="col-xs-12 col-md-4 text-right columns">
                    <?php if($nombre_tienda_slug): ?>
                        <a style="color:#ee4500; border: 2px solid #ee4500; border-radius: 10px" href="<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/vaciar'); ?>" class="small error button" id="vaciar"><i class="fa fa-trash"></i><span class="show-for-medium"> Vaciar</span></a>
                    <?php else: ?>
                        <a style="color:#ee4500; border: 2px solid #ee4500; border-radius: 10px" href="<?php echo site_url('carrito/vaciar'); ?>" class="small error button" id="vaciar" onclick="if(typeof gtag != 'undefined') { gtag('event', 'Clic', {'event_category' : 'Carrito', 'event_label' : 'Vaciar'}); }"><i class="fa fa-trash"></i><span class="show-for-medium"> Vaciar</span></a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4 sums-area" id="sums-area-top">
            <div data-sticky-container>
                <div class="sticky" data-sticky data-top-anchor="sums-area-top:top" data-btm-anchor="additional-button-holder:top">
                    <?php $this->load->view('nuevo_carrito/mini_cart_excerpt'); ?>

                    <div class="row ">
                        <div class="col-md-12">
                            <?php if($nombre_tienda_slug): ?>
                            <a style="background: #FF4C00 !important; color: white; border-radius: 10px" href="<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/seleccionar-direccion'); ?>" class="expanded btn-hover success btn-completo btn button big-next-button">Seleccionar dirección <i class="fa fa-long-arrow-right"></i></a>
                            <?php else: ?>
                            <a style="background: #FF4C00 !important; color: white; border-radius: 10px" href="<?php echo site_url('carrito/seleccionar-direccion'); ?>" class="expanded success button btn btn-completo btn-hover big-next-button">Seleccionar dirección <i class="fa fa-long-arrow-right"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row" id="info-adicional-cart">
                        <div class="col-md-12" >
                            <p style="color:#025573 !important;" id="texto-dhl"><i class="fa fa-truck"></i> Espera tus productos personalizados via <strong>DHL</strong> desde el <strong><?php

                                    //aqui para productos especiales
                                    $producto_no_especial = false;
                                    $producto_no_stock = false;
                                    foreach($this->cart->contents() as $rowid => $content){
                                        if($content['options']['id_enhance'] != 34924 && $content['options']['id_enhance'] != 34925){
                                            $producto_no_especial = true;
                                            break;
                                        }
                                        $producto_no_especial = false;
                                        if($content['options']['id_producto'] != 42){
                                            $producto_no_stock = true;
                                            break;
                                        }
                                        $producto_no_stock = false;
                                    }

                                    $paymentDate = date('Y-m-d');
                                    $paymentDate=date('Y-m-d', strtotime($paymentDate));
                                    $firstDateBegin = date('Y-m-d', strtotime("04/01/2020"));
                                    $firstDateEnd = date('Y-m-d', strtotime("05/31/2020"));
                                    $secondDateBegin = date('Y-m-d', strtotime("12/21/2019"));
                                    $secondDateEnd = date('Y-m-d', strtotime("01/07/2020"));
                                    if(!$producto_no_especial){
                                        fecha(date("Y-m-d H:i:s", strtotime("+2 days")));
                                    }else if (($paymentDate >= $firstDateBegin) && ($paymentDate <= $firstDateEnd)){
                                        //16-20
                                        fecha("06/15/2020");
                                    }else if(($paymentDate >= $secondDateBegin) && ($paymentDate <= $secondDateEnd)) {
                                        //21-7
                                        fecha("01/16/2019");
                                    }else{
                                        fecha($recibir);
                                    } ?></strong></p>
                            <p style="color:#A6C662;" id="texto-custom"><i class="fa fa-info-circle"></i> Los productos marcados en azul, pagan envío individual.</p>
                            <a style="font-size: 0.8rem" data-open="info-areas-diseno">¡Recuerda las medidas y colores de impresión!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>

<div class="small reveal" id="cantidades_campana" data-reveal>
	<form>
		<div class="row ">
			<div class="col-md-12">
				<label>Nueva cantidad
					<select id="nueva_cantidad_campana">
						<option value=""></option>
					</select>
				</label>
			</div>
		</div>

		<div class="row  add-buttons">
			<div class="col-md-6">
				<a data-close class="btn text-center btn-danger btn-completo  button">Cancelar</a>
			</div>
			<div class="small-9 columns text-right">
				<input type="hidden" id="data_id" value="" />
				<button type="button" class="primary button text-center btn btn-success btn-completo" id="actualizar_campana_button">Actualizar</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="small reveal" id="cantidades_campana_limitada" data-reveal>
	<form>
		<div class="row ">
			<div class="col-md-12">
				<label>Nueva cantidad
					<select id="nueva_cantidad_campana_limitada">
					<?php for($i=1;$i<101;$i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
				</label>
			</div>
		</div>

		<div class="row  add-buttons">
			<div class="col-md-6">
				<a data-close class="secondary button">Cancelar</a>
			</div>
			<div class="col-md-6 text-right">
				<input type="hidden" id="data_id_limitada" value="" />
				<button type="button" class="primary button" id="actualizar_campana_limitada_button">Actualizar</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="small reveal" id="cantidades_custom" data-reveal>
	<form>
		<div id="con">

		</div>
		<div class="row  add-buttons">
			<div class="col-md-6 ">
				<a data-close class="btn btn-danger btn-completo secondary button">Cancelar</a>
			</div>
			<div class="col-md-6 text-right">
				<input type="hidden" id="tallas_nuevas" value="" />
				<input type="hidden" id="design_id" value="" />
				<button type="button" class="btn btn-success btn-completo primary button" id="actualizar_custom_button" data-tipo="" disabled="disabled">Actualizar</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="small reveal" id="info-areas-diseno" data-reveal>
    <div class="row">
        <div class="col-md-12">
            <ul>
                <li><p>La medida del área de impresión máxima es de 15 cm por 12 cm para niños y de 30 cm por 35 cm para adultos, sin embargo dependiendo del diseño podrían existir variaciones en las impresiones.</p></li>
                <li><p>Recuerda que la impresión no siempre será idéntica al color de la imagen digital. Dependerá de la calidad de la imagen proporcionada.<br>*Si tienes dudas y/o aclaraciones sobre la calidad de tu imagen contáctanos. </p></li>
            </ul>
        </div>
    </div>

    <button class="close-button" data-close aria-label="Cerrar" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>