<form action="<?php echo site_url('carrito/procesar-direccion'); ?>" method="post" enctype="multipart/form-data" data-abide novalidate>
    <div class="fgc pscat">
    	<div class="row small-collapse medium-uncollapse">
            <div class="small-18 medium-11 large-12 columns">
                <?php if(!$is_client) {
                    $this->load->view('nuevo_carrito/direcciones/datos_generales_nuevo');
                } else {
                    if(sizeof($direcciones) > 0) {
                        $this->load->view('nuevo_carrito/direcciones/listado_direcciones_cliente');
                    } else {
                        $this->load->view('nuevo_carrito/direcciones/datos_generales_cliente');
                    }
                } ?>
            </div>
            <div class="small-18 medium-7 large-6 columns sums-area" id="sums-area-top">
                <div data-sticky-container>
                    <div class="sticky" data-sticky data-top-anchor="sums-area-top:top" data-btm-anchor="hidden_fact:bottom">
                        <?php $this->load->view('nuevo_carrito/mini_cart_excerpt'); ?>

                        <div class="row ">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-completo btn-hover expanded success button big-next-button">Método de pago <i class="fa fa-long-arrow-right"></i></button>
                            </div>
                        </div>

                        <div class="row " id="info-adicional-cart">
                            <div class="col-md-12">
                                <p id="texto-dhl"><i class="fa fa-truck"></i> Espera tus productos personalizados via <strong>DHL</strong> desde el <strong><?php fecha($recibir); ?></strong> (no aplica para productos de plazo definido).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="small reveal" id="nueva_direccion" data-reveal>
	<form action="<?php echo site_url('mi-cuenta/direcciones/agregar/pagar'); ?>" method="post" data-abide novalidate autocomplete="off">
		<div class="row">
			<div class="small-18 text-center columns logo-container">
				<h3 class="dosf text-center">Nueva Dirección</h3>
			</div>
		</div>

        <div class="row">
            <div class="small-18 medium-18 large-11 columns">
                <div class="input-group">
        			<span class="input-group-label">
                        <i class="fa fa-tag"></i>
                    </span>
                    <input type="text" name="identificador_direccion" id="identificador_direccion" placeholder="Casa, Oficina, etc." required />
                    <small class="form-error">*</small>
        		</div>
            </div>
            <div class="small-18 medium-18 large-7 columns">
                <div class="input-group">
        			<span class="input-group-label">
                        <i class="fa fa-phone"></i>
                    </span>
                    <input type="text" placeholder="Teléfono" name="telefono" id="telefono" required pattern="^\d{10}$"/>
                    <small class="form-error">*</small>
        		</div>
            </div>
        </div>
        <div class="row">
            <div class="small-18 columns">
                <div class="input-group">
        			<span class="input-group-label">
                        <i class="fa fa-address-card-o"></i>
                    </span>
                    <input type="text" name="linea1" id="linea1" placeholder="Dirección Línea 1: Calle, No. Ext., No. Int., Cruzamiento (máximo 35 caracteres)"  required pattern="^(.|\s){0,35}$" maxlength="35" />
                    <small class="form-error">*</small>
        		</div>
            </div>
        </div>
        <div class="row">
            <div class="small-18 columns">
                <div class="input-group">
        			<span class="input-group-label">
                        <i class="fa fa-address-card-o"></i>
                    </span>
                    <input type="text" name="linea2" id="linea2" placeholder="Dirección Línea 2: Colonia (máximo 35 caracteres)" pattern="^(.|\s){0,35}$" maxlength="35" />
                    <small class="form-error">*</small>
        		</div>
            </div>
        </div>
        <div class="row">
            <div class="small-18 medium-11 columns">
                <div class="input-group">
        			<span class="input-group-label">
                        <i class="fa fa-building-o"></i>
                    </span>
                    <input type="text" name="ciudad" id="ciudad" placeholder="Ciudad (máximo 35 caracteres)" required pattern="^(.|\s){0,35}$" maxlength="35" />
                    <small class="form-error">*</small>
        		</div>
            </div>
            <div class="small-18 medium-7 columns end">
                <div class="input-group">
        			<span class="input-group-label">
                        <i class="fa fa-map-signs"></i>
                    </span>
                    <input type="text" name="codigo_postal" id="codigo_postal" placeholder="Código Postal" required />
                    <small class="form-error">*</small>
        		</div>
            </div>
        </div>
        <div class="row">
            <div class="small-18 columns">
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

		<div class="row add-buttons">
			<div class="small-9 columns">
				<button type="button" class="secondary button" data-close>Cancelar</button>
			</div>
			<div class="small-9 columns text-right">
				<input type="hidden" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
				<button type="submit" class="primary button" id="add_dir">Agregar Dirección</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="small reveal" id="nueva_facturacion" data-reveal>
	<form action="<?php echo site_url('mi-cuenta/facturacion/agregar/pagar'); ?>" method="post" data-abide novalidate>
		<div class="row">
			<div class="small-18 text-center columns logo-container">
				<h5 class="text-center">Nuevos Datos de Facturación</h5>
			</div>
		</div>

        <div class="row">
            <div class="small-18 columns">
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
            <div class="small-18 columns">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-tag"></i>
                    </span>
                    <input type="text" name="rfc" id="rfc" required placeholder="R.F.C." />
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="small-18 columns">
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
            <div class="small-18 columns">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-address-card-o"></i>
                    </span>
                    <input type="text" name="linea2" id="linea2_fiscal" placeholder="Dirección Línea 2: Colonia" required />
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="small-18 medium-11 columns">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-building-o"></i>
                    </span>
                    <input type="text" name="ciudad" id="ciudad_fiscal" placeholder="Ciudad" required />
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
            <div class="small-18 medium-7 columns end">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-map-signs"></i>
                    </span>
                    <input type="text" name="codigo_postal" id="codigo_postal_fiscal" placeholder="Código Postal" required />
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="small-18 columns">
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
        <div class="row">
            <div class="small-18 medium-18 large-11 columns">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-envelope-o"></i>
                    </span>
                    <input type="email" placeholder="Correo electrónico" name="correo_electronico_facturacion" id="correo_electronico_facturacion" required />
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
            <div class="small-18 medium-18 large-7 columns">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-phone"></i>
                    </span>
                    <input type="text" placeholder="Teléfono" name="telefono" id="telefono_fiscal" required pattern="^\d{10}$"/>
                    <small class="form-error">Dato obligatorio, mínimo 10 dígitos.</small>
                </div>
            </div>
		</div>

		<div class="row add-buttons">
			<div class="small-9 columns">
				<button type="button" class="secondary button" data-close>Cancelar</button>
			</div>
			<div class="small-9 columns text-right">
				<input type="hidden" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
				<button type="submit" class="primary button" id="add_dir">Agregar</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
