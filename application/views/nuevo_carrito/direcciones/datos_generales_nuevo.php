<div class="address-area">
    <div class="row">
        <div class="small-18 columns">
            <h2 class="dosf text-center medium-text-left" data-equalizer-watch="titulo">Tus datos de envío</h2>
            <p class="aceptamos text-justify" id="login-p">¿Ya tienes una cuenta? <a data-open="login" id="smalllogin" class="tiny primary button">Inicia Sesión</a></p>
            <p class="aceptamos text-justify">Al realizar la compra, te crearemos una cuenta con los datos proporcionados para que puedas acceder y ver tus pedidos.</p>
        </div>
        <div class="small-18 medium-18 large-9 columns">
            <div class="input-group">
    			<span class="input-group-label">
                    <i class="fa fa-user"></i>
                </span>
                <input type="text" placeholder="Nombre(s)" name="direccion[nombre]" id="nombre"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['nombre'].'"' : ''); ?> required />
                <small class="form-error">Dato obligatorio.</small>
    		</div>
        </div>
        <div class="small-18 medium-18 large-9 columns">
            <div class="input-group">
    			<span class="input-group-label">
                    <i class="fa fa-user-o"></i>
                </span>
                <input type="text" placeholder="Apellido(s)" name="direccion[apellidos]" id="apellidos"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['apellidos'].'"' : ''); ?> required />
                <small class="form-error">Dato obligatorio.</small>
    		</div>
        </div>
    </div>
    <div class="row">
        <div class="small-18 medium-18 large-9 columns">
            <div class="input-group">
    			<span class="input-group-label">
                    <i class="fa fa-envelope-o"></i>
                </span>
                <input type="email" placeholder="Correo electrónico" name="direccion[email]" id="email"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['email'].'"' : ''); ?> required />
                <small class="form-error">Dato obligatorio.</small>
    		</div>
        </div>
        <div class="small-18 medium-18 large-9 columns">
            <div class="input-group">
                <input type="text" placeholder="Teléfono" name="direccion[telefono]" id="telefono"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['telefono'].'"' : ''); ?> maxlength="12" minlength="10" required  />
                <small style="margin-top: 0;" id="error-tel" class="form-error">Mínimo 10 dígitos.</small>
    		</div>
        </div>
    </div>
    <div class="row" style="padding-bottom: 0.5rem">
        <div class="small-18 columns">
            <div class="callout secondary">
                <span>
                    <i class="fa fa-info-circle"></i>
                </span>
                <p style="display: inline-block;">&nbsp&nbspPor favor ingrese primeramente su código postal.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="small-18 medium-7 columns end">
            <div class="input-group">
    			<span class="input-group-label">
                    <i class="fa fa-map-signs"></i>
                </span>
                <input maxlength="5" pattern="\d*" type="text" name="direccion[codigo_postal]" id="codigo_postal" onblur="cambio_codigo_postal()" <?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['codigo_postal'].'"' : ''); ?> placeholder="Código Postal" required />
                <small class="form-error">Dato obligatorio.</small>
            </div>
        </div>
        <div class="small-18 medium-11 columns">
            <div class="input-group">
    			<span class="input-group-label">
                    <i class="fa fa-building-o"></i>
                </span>
                <input type="text" name="direccion[ciudad]" id="ciudad"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['ciudad'].'"' : ''); ?> placeholder="Ciudad (máximo 35 caracteres)" required pattern="^(.|\s){0,35}$" maxlength="35" disabled />
                <small class="form-error">Dato obligatorio, máximo 35 caracteres.</small>
            </div>
        </div>
    </div>
    <div id="contenedor-datos-direccion">
        <div id='loader'>
            <img class='float-center' alt='loader gif' src="<?php echo site_url('/assets/images/loading_32x32.gif');?>" width="auto" height="auto">
        </div>
        <div class="row">
            <div class="small-18 columns">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-address-card-o"></i>
                    </span>
                    <input disabled type="text" name="direccion[linea1]" id="linea1"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['linea1'].'"' : ''); ?> placeholder="Dirección Línea 1: Calle, No. Ext., No. Int., Cruzamiento (máximo 35 caracteres)"  required pattern="^(.|\s){0,35}$" maxlength="35" />
                    <small class="form-error">Dato obligatorio, máximo 35 caracteres.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="small-18 columns">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-address-card-o"></i>
                    </span>
                    <select name="direccion[linea2]" id="linea2" required disabled>
                        <!--Select de la colonia generado en script_direccion-->
                    </select>
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
        </div>
        <div class="row" id="colonia-otro" style="display: none">
            <div class="small-18 columns">
                <div class="input-group">
                    <span class="input-group-label">
                        <i class="fa fa-address-card-o"></i>
                    </span>
                    <input type="text" name="direccion[linea2_otro]" id="linea2_otro"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['linea2'].'"' : ''); ?> placeholder="Dirección Línea 2: Colonia (máximo 35 caracteres)" pattern="^(.|\s){0,35}$" maxlength="35" />
                    <small class="form-error">Dato obligatorio, máximo 35 caracteres.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="small-18 columns">
                <div class="input-group">
                    <select name="direccion[estado]" id="estado" placeholder="Estado" required disabled>
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
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="factura-label-container">
        <div class="small-18 large-8 columns text-left">
            <div class="row collapse">
                <div class="small-5 columns">
                    <div class="switch">
                        <input class="switch-input" id="requiero_facturar" type="checkbox"<?php if($this->session->direccion_fiscal_temporal) { echo ' checked'; } ?> name="requiero_facturar">
                        <label class="switch-paddle" for="requiero_facturar">
                            <span class="show-for-sr">Requiero facturar</span>
                            <span class="switch-active" aria-hidden="true">Si</span>
                            <span class="switch-inactive" aria-hidden="true">No</span>
                        </label>
                    </div>
                </div>
                <div class="small-13 columns">
                    <label for="requiero_facturar" id="factura-label">
                        Requiero facturar
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!--Para facturacion-->
    <div id="hidden_fact"<?php if(!$this->session->direccion_fiscal_temporal) { echo ' style="display:none;"'; } ?>>
        <div class="row collapse">
            <div class="small-18 columns">
                <div class="row">
                    <div class="small-18 columns">
                        <h3 class="dosf text-center medium-text-left">Tus datos de facturación</h3>
                    </div>
                </div>
                <?php $direcciones_fiscales = $this->cuenta_modelo->obtener_direcciones_fiscales($this->session->login['id_cliente']); ?>
                <?php if(sizeof($direcciones_fiscales) > 0): ?>
                <div class="row">
                    <div class="small-18 columns">
                        <select name="id_direccion_fiscal" id="id_direccion_fiscal">
                            <option value="">Seleccionar datos de facturación</option>
                            <optgroup label="Mis datos de facturación">
                            <?php foreach($direcciones_fiscales as $direccion): ?>
                                <option value="<?php echo $direccion->id_direccion_fiscal; ?>" data-dircompleta='<?php echo json_encode($direccion); ?>'><?php echo $direccion->razon_social; ?> (<?php echo $direccion->rfc; ?>)</option>
                            <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Más opciones">
                                <option id="agregar_dinamico" value="" data-open="nueva_direccion">+ Agregar datos de facturación</option>
                            </optgroup>
                        </select>
                        <label class="clearfix direccion_pago" id="direccion_fiscal_seleccionada" data-dircompleta=''>
                            <span class="text-center">Por favor selecciona los datos de facturación para la factura.</span>
                        </label>
                    </div>
                </div>
                <?php else: ?>
                <div class="row">
                    <div class="small-18 columns">
                        <div class="input-group">
                			<span class="input-group-label">
                                <i class="fa fa-bank"></i>
                            </span>
                            <input type="text" name="direccion_fiscal[razon_social]" id="razon_social_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['razon_social'].'"' : ''); ?> placeholder="Razón Social / Nombre" />
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
                            <input type="text" name="direccion_fiscal[rfc]" id="rfc_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['rfc'].'"' : ''); ?> placeholder="R.F.C." />
                            <small class="form-error">Dato obligatorio.</small>
                		</div>
                    </div>
                </div>
                <div class="row" style="padding-bottom: 0.5rem">
                    <div class="small-18 columns">
                        <div class="callout secondary">
                            <span>
                                <i class="fa fa-info-circle"></i>
                            </span>
                            <p style="display: inline-block;">&nbsp&nbspPor favor ingrese primeramente su código postal.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="small-18 medium-7 columns end">
                        <div class="input-group">
                        <span class="input-group-label">
                            <i class="fa fa-map-signs"></i>
                        </span>
                            <input maxlength="5" pattern="\d*" type="text" name="direccion_fiscal[codigo_postal]" id="codigo_postal_limpia" onblur="cambio_codigo_postal_fiscal()"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['codigo_postal'].'"' : ''); ?> placeholder="Código Postal" />
                            <small class="form-error">Dato obligatorio.</small>
                        </div>
                    </div>
                    <div class="small-18 medium-11 columns">
                        <div class="input-group">
                        <span class="input-group-label">
                            <i class="fa fa-building-o"></i>
                        </span>
                            <input type="text" name="direccion_fiscal[ciudad]" id="ciudad_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['ciudad'].'"' : ''); ?> placeholder="Ciudad" disabled/>
                            <small class="form-error">Dato obligatorio.</small>
                        </div>
                    </div>
                </div>
                <div id="contenedor-datos-direccion-fiscal">
                    <div id='loader_fiscal'>
                        <img class='float-center' alt='loader gif' src="<?php echo site_url('/assets/images/loading_32x32.gif');?>" width="auto" height="auto">
                    </div>
                    <div class="row">
                        <div class="small-18 columns">
                            <div class="input-group">
                                <span class="input-group-label">
                                    <i class="fa fa-address-card-o"></i>
                                </span>
                                <input type="text" name="direccion_fiscal[linea1]" id="linea1_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['linea1'].'"' : ''); ?> placeholder="Dirección Línea 1: Calle, No. Ext., No. Int., Cruzamiento" disabled/>
                                <small class="form-error">Dato obligatorio.</small>
                            </div>
                        </div>
                    </div>
                    <!--Nuevo modulo de seleccion de colonia (fiscal)-->
                    <div class="row">
                        <div class="small-18 columns">
                            <div class="input-group">
                                <span class="input-group-label">
                                    <i class="fa fa-address-card-o"></i>
                                </span>
                                <select name="direccion_fiscal[linea2]" id="linea2_limpia" <?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['linea2'].'"' : ''); ?>disabled>
                                    <!--Select de la colonia fiscal generado en script_direccion-->
                                </select>
                                <small class="form-error">Dato obligatorio.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="colonia-otro-limpia" style="display: none">
                        <div class="small-18 columns">
                            <div class="input-group">
                                <span class="input-group-label">
                                    <i class="fa fa-address-card-o"></i>
                                </span>
                                <input type="text" name="direccion_fiscal[linea2_otro]" id="linea2_limpia_otro" placeholder="Dirección Línea 2: Colonia (máximo 35 caracteres)" <?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['linea2_otro'].'"' : ''); ?>pattern="^(.|\s){0,35}$" maxlength="35" />
                                <small class="form-error">Dato obligatorio, máximo 35 caracteres.</small>
                            </div>
                        </div>
                    </div>
                    <!--END modulo colonia (fiscal)-->
                    <div class="row">
                        <div class="small-18 columns">
                            <div class="input-group">
                                <select name="direccion_fiscal[estado]" id="estado_limpia" placeholder="Estado" disabled>
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
                    <div class="small-18 medium-18 large-9 columns">
                        <div class="input-group">
                			<span class="input-group-label">
                                <i class="fa fa-envelope-o"></i>
                            </span>
                            <input type="email" placeholder="Correo electrónico" name="direccion_fiscal[correo_electronico_facturacion]" id="correo_electronico_facturacion_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['correo_electronico_facturacion'].'"' : ''); ?> />
                            <small class="form-error">Dato obligatorio.</small>
                		</div>
                    </div>
                    <div class="small-18 medium-18 large-9 columns">
                        <div class="input-group">
                            <input type="text" minlength="10" maxlength="12" placeholder="Teléfono" name="direccion_fiscal[telefono]" id="telefono_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['telefono'].'"' : ''); ?> />
                            <small style="margin-top: 0;" id="error-tel_limpia" class="form-error">Mínimo 10 dígitos.</small>
                		</div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
