<form id="direccion-carrito" enctype="multipart/form-data" data-abide novalidate>
    <div class="fgc pscat" style="background: white">
    	<div class="row small-collapse medium-uncollapse">
            <div class="small-18 medium-11 large-12 columns">
                <?php
                $dir_carrito = array();
                if(!$is_client) {
                    $dir_carrito['secc'] = "generales_nuevo";
                    $this->load->view('nuevo_carrito/direcciones/datos_generales_nuevo', $dir_carrito);
                } else {
                    if(sizeof($direcciones) > 0) {
                        $dir_carrito['secc'] = "listado_login";
                        $this->load->view('nuevo_carrito/direcciones/listado_direcciones_cliente', $dir_carrito);
                    } else {
                        $dir_carrito['secc'] = "generales_login";
                        $this->load->view('nuevo_carrito/direcciones/datos_generales_cliente', $dir_carrito);
                    }
                } ?>
            </div>
            <div class="small-18 medium-7 large-6 columns sums-area" id="sums-area-top">
                <div data-sticky-container>
                    <div class="sticky" data-sticky data-top-anchor="sums-area-top:top" data-btm-anchor="hidden_fact:bottom">
                        <?php $this->load->view('nuevo_carrito/mini_cart_excerpt'); ?>

                        <div class="row ">
                            <div class="col-md-12">
                                <button style="background: #FF4C00 !important; color: white; border-radius: 10px" type="submit" class="btn btn-hover btn-completo expanded success button big-next-button">Método de pago <i class="fa fa-long-arrow-right"></i></button>
                            </div>
                        </div>

                        <div class="row " id="info-adicional-cart">
                            <div class="col-md-12">
                                <p id="texto-dhl" style="color:#025573 !important;"><i class="fa fa-truck"></i> Espera tus productos personalizados via <strong>DHL</strong> desde el <strong><?php
                                        $paymentDate = date('Y-m-d');
                                        $paymentDate=date('Y-m-d', strtotime($paymentDate));
                                        $firstDateBegin = date('Y-m-d', strtotime("04/01/2020"));
                                        $firstDateEnd = date('Y-m-d', strtotime("05/31/2020"));
                                        $secondDateBegin = date('Y-m-d', strtotime("12/21/2019"));
                                        $secondDateEnd = date('Y-m-d', strtotime("01/07/2020"));
                                        if (($paymentDate >= $firstDateBegin) && ($paymentDate <= $firstDateEnd)){
                                            //16-20
                                            fecha("06/15/2020");
                                        }else if(($paymentDate >= $secondDateBegin) && ($paymentDate <= $secondDateEnd)){
                                            //21-7
                                            fecha("01/16/2019");
                                        }else{
                                            fecha($recibir);
                                        } ?></strong>.</p>
                                <a style="font-size: 0.8rem" data-open="info-areas-diseno">¡Recuerda las medidas y colores de impresión!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="small reveal" id="nueva_direccion" data-reveal>
	<form id="form-listado-dir" action="<?php echo site_url('mi-cuenta/direcciones/agregar/pagar'.($nombre_tienda_slug ? '/'.$nombre_tienda_slug : '')); ?>" method="post" data-abide novalidate autocomplete="off">
		<div class="row">
			<div class="col-md-12 text-center logo-container">
				<h2 class=" text-center">Nueva Dirección</h2>
			</div>
		</div>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
        			<span class="input-group-label">
                        <i class="fa fa-tag"></i>
                    </span>
                    <input type="text" name="identificador_direccion" id="identificador_direccion_nuevo_reveal_carrito" placeholder="Casa, Oficina, etc." required />
                    <small class="form-error">*</small>
        		</div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <input type="text" placeholder="Teléfono" name="telefono" id="telefono_nuevo_reveal_carrito" required minlength="10" maxlength="12" required/>
                    <small style="margin-top: 0;" id="error-listado-dir" class="form-error">*</small>
        		</div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 1.5rem;">
            <div class="col-md-12">
                <div class="callout secondary">
                    <span><i class="fa fa-info-circle"></i></span>
                    <p style="display: inline-block;">&nbsp&nbspPor favor ingrese primeramente su código postal.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <div class="input-group">
        			<span class="input-group-label">
                        <i class="fa fa-map-signs"></i>
                    </span>
                    <input type="text" name="codigo_postal" onblur="cambio_codigo_postal_reveal()" id="codigo_postal_nuevo_reveal_carrito" placeholder="Código Postal" required />
                    <small class="form-error">*</small>
                </div>
            </div>
            <div class="col-md-8 col-xs-12 end">
                <div class="input-group">
        			<span class="input-group-label">
                        <i class="fa fa-building-o"></i>
                    </span>
                    <input type="text" name="ciudad" id="ciudad_nuevo_reveal_carrito" placeholder="Ciudad (máximo 35 caracteres)" required pattern="^(.|\s){0,35}$" maxlength="35" />
                    <small class="form-error">*</small>
                </div>
            </div>
        </div>
        <div id="contenedor-datos-direccion">
            <div id='loader'>
                <img class='float-center' alt='loader gif' src="<?php echo site_url('/assets/images/loading_32x32.gif');?>" width="auto" height="auto">
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-label">
                            <i class="fa fa-address-card-o"></i>
                        </span>
                        <input type="text" name="linea1" id="linea1_nuevo_reveal_carrito" placeholder="Dirección Línea 1: Calle, No. Ext., No. Int., Cruzamiento (máximo 35 caracteres)"  required pattern="^(.|\s){0,35}$" maxlength="35" />
                        <small class="form-error">*</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-address-card-o"></i>
                    </span>
                        <select name="linea2" id="linea2_nuevo_reveal_carrito" required disabled>
                            <!--Select de la colonia generado en script_direccion-->
                        </select>
                        <small class="form-error">Dato obligatorio.</small>
                    </div>
                </div>
            </div>
            <div class="row" id="colonia-otro" style="display: none">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-label">
                            <i class="fa fa-address-card-o"></i>
                        </span>
                        <input type="text" name="linea2_otro" id="linea2_nuevo_reveal_carrito_otro" placeholder="Dirección Línea 2: Colonia (máximo 35 caracteres)" pattern="^(.|\s){0,35}$" maxlength="35" />
                        <small class="form-error">*</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <select name="estado" id="estado_nuevo" placeholder="Estado" required>
                            <option value="" selected disabled>Estado</option>
                            <option value="Aguascalientes">Aguascalientes</option>
                            <option value="Baja California">Baja California</option>
                            <option value="Baja California Sur">Baja California Sur</option>
                            <option value="Campeche">Campeche</option>
                            <option value="Chiapas">Chiapas</option>
                            <option value="Chihuahua">Chihuahua</option>
                            <option value="Coahuila">Coahuila</option>
                            <option value="Colima">Colima</option>
                            <option value="Distrito Federal">Distrito Federal</option>
                            <option value="Durango">Durango</option>
                            <option value="Estado de México">Estado de México</option>
                            <option value="Guanajuato">Guanajuato</option>
                            <option value="Guerrero">Guerrero</option>
                            <option value="Hidalgo">Hidalgo</option>
                            <option value="Jalisco">Jalisco</option>
                            <option value="Michoacán">Michoacán</option>
                            <option value="Morelos">Morelos</option>
                            <option value="Nayarit">Nayarit</option>
                            <option value="Nuevo León">Nuevo León</option>
                            <option value="Oaxaca">Oaxaca</option>
                            <option value="Puebla">Puebla</option>
                            <option value="Querétaro">Querétaro</option>
                            <option value="Quintana Roo">Quintana Roo</option>
                            <option value="San Luis Potosí">San Luis Potosí</option>
                            <option value="Sinaloa">Sinaloa</option>
                            <option value="Sonora">Sonora</option>
                            <option value="Tabasco">Tabasco</option>
                            <option value="Tamaulipas">Tamaulipas</option>
                            <option value="Tlaxcala">Tlaxcala</option>
                            <option value="Veracruz">Veracruz</option>
                            <option value="Yucatán">Yucatán</option>
                            <option value="Zacatecas">Zacatecas</option>
                        </select>
                        <small class="form-error">*</small>
                    </div>
                </div>
            </div>
        </div>
		<div class="row add-buttons">
			<div class="col-md-6">
				<button type="button" class="btn btn-danger btn-completo button" data-close>Cancelar</button>
			</div>
			<div class="col-md-6 text-right">
				<input id="id_cliente_nuevo_reveal_carrito" type="hidden" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
				<button type="submit" class="btn btn-completo btn-success button" id="add_dir_1">Agregar Dirección</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="small reveal" id="nueva_facturacion" data-reveal>
	<form id="form-listado-fac" data-abide novalidate>
		<div class="row">
			<div class="col-md-12 text-center logo-container">
				<h5 class="text-center">Nuevos Datos de Facturación</h5>
			</div>
		</div>
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-bank"></i>
                    </span>
                    <input type="text" name="razon_social" id="razon_social" required placeholder="Razón Social / Nombre" />
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-tag"></i>
                    </span>
                    <input type="text" name="rfc" id="rfc" required placeholder="R.F.C." />
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 1.5rem;">
            <div class="col-md-12">
                <div class="callout secondary">
                    <span><i class="fa fa-info-circle"></i></span>
                    <p style="display: inline-block;">&nbsp&nbspPor favor ingrese primeramente su código postal.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12 end">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-map-signs"></i>
                    </span>
                    <input type="text" name="codigo_postal" onblur="cambio_codigo_postal_reveal_fiscal()" id="codigo_postal_fiscal" placeholder="Código Postal" required />
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-building-o"></i>
                    </span>
                    <input type="text" name="ciudad" id="ciudad_fiscal" placeholder="Ciudad" required />
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
        </div>
        <div id="contenedor-datos-direccion-fiscal">
            <div id='loader_fiscal'>
                <img class='float-center' alt='loader gif' src="<?php echo site_url('/assets/images/loading_32x32.gif');?>" width="auto" height="auto">
            </div>
            <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-address-card-o"></i>
                    </span>
                    <input type="text" name="linea1" id="linea1_fiscal" placeholder="Dirección Línea 1: Calle, No. Ext., No. Int., Cruzamiento" required />
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-address-card-o"></i>
                    </span>
                    <select name="linea2" id="linea2_fiscal" required disabled>
                        <!--Select de la colonia generado en script_direccion-->
                    </select>
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
        </div>
        <div class="row" id="colonia-otro-fiscal" style="display: none">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-address-card-o"></i>
                    </span>
                    <input type="text" name="linea2_otro" id="linea2_fiscal_otro" placeholder="Dirección Línea 2: Colonia"/>
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <select name="estado" id="estado_fiscal" placeholder="Estado" required>
                        <option value="" disabled selected>Estado</option>
                        <option value="Aguascalientes">Aguascalientes</option>
                        <option value="Baja California">Baja California</option>
                        <option value="Baja California Sur">Baja California Sur</option>
                        <option value="Campeche">Campeche</option>
                        <option value="Chiapas">Chiapas</option>
                        <option value="Chihuahua">Chihuahua</option>
                        <option value="Coahuila">Coahuila</option>
                        <option value="Colima">Colima</option>
                        <option value="Distrito Federal">Distrito Federal</option>
                        <option value="Durango">Durango</option>
                        <option value="Estado de México">Estado de México</option>
                        <option value="Guanajuato">Guanajuato</option>
                        <option value="Guerrero">Guerrero</option>
                        <option value="Hidalgo">Hidalgo</option>
                        <option value="Jalisco">Jalisco</option>
                        <option value="Michoacán">Michoacán</option>
                        <option value="Morelos">Morelos</option>
                        <option value="Nayarit">Nayarit</option>
                        <option value="Nuevo León">Nuevo León</option>
                        <option value="Oaxaca">Oaxaca</option>
                        <option value="Puebla">Puebla</option>
                        <option value="Querétaro">Querétaro</option>
                        <option value="Quintana Roo">Quintana Roo</option>
                        <option value="San Luis Potosí">San Luis Potosí</option>
                        <option value="Sinaloa">Sinaloa</option>
                        <option value="Sonora">Sonora</option>
                        <option value="Tabasco">Tabasco</option>
                        <option value="Tamaulipas">Tamaulipas</option>
                        <option value="Tlaxcala">Tlaxcala</option>
                        <option value="Veracruz">Veracruz</option>
                        <option value="Yucatán">Yucatán</option>
                        <option value="Zacatecas">Zacatecas</option>
                    </select>
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-envelope-o"></i>
                    </span>
                    <input type="email" placeholder="Correo electrónico" name="correo_electronico_facturacion" id="correo_electronico_facturacion" required />
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <input type="text" placeholder="Teléfono" name="telefono" id="telefono_fiscal" required minlength="10" maxlength="12"/>
                    <small style="margin-top: 0;" id="error_telefono_fiscal" class="form-error">Dato obligatorio, mínimo 10 dígitos.</small>
                </div>
            </div>
		</div>

		<div class="row add-buttons">
			<div class="col-md-6 col-xs-12">
				<button type="button" class="btn btn-danger btn-completo button" data-close>Cancelar</button>
			</div>
			<div class="col-md-6 col-xs-12 text-right">
				<input type="hidden" id="id_cliente_fiscal" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
				<button type="submit" class="btn btn-completo btn-success button" id="add_dir">Agregar</button>
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

<div class="loading" id="direcciones_load" style="display: none;position:fixed;top:0;left:0;right:0;bottom:0;z-index:1000000;opacity:0.9;">
    <span style="display:block;position:absolute;top: 50%;margin-top: 50px;width: 100%;text-align: center;padding: 0 1rem;font-weight: bold;color: #0e0e0e;" id="mensaje-carga">Estamos verificando tus datos, sólo tomará un momento.</span>
</div>