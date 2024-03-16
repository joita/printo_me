<div class="address-area">
    <div class="row">
        <div class="small-18 columns">
            <h2 style="color: #FF4C00;font-weight: bold; border: none; border-bottom: 2px solid #025573;" class="text-center medium-text-left" data-equalizer-watch="titulo">Tus datos de envío</h2>
        </div>
    </div>
    <div class="row">
        <div class="small-18 medium-18 large-9 columns">
            <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
    			<span style="border-radius: 10px" class="input-group-label">
                    <i class="fa fa-tag"></i>
                </span>
                <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="text" name="direccion[identificador_direccion]" id="identificador_direccion"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['identificador_direccion'].'"' : ''); ?> placeholder="Casa, Oficina, etc." required />
                <small class="form-error">Dato obligatorio.</small>
    		</div>
        </div>
        <div class="small-18 medium-18 large-9 columns">
            <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
                <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="text" placeholder="Teléfono" name="direccion[telefono]" id="telefono"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['telefono'].'"' : ''); ?> minlength="10" maxlength="12" required/>
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
            <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
    			<span style="border-radius: 10px" class="input-group-label">
                    <i class="fa fa-map-signs"></i>
                </span>
                <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="text" name="direccion[codigo_postal]" id="codigo_postal" onblur="cambio_codigo_postal()"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['codigo_postal'].'"' : ''); ?> placeholder="Código Postal" required />
                <small class="form-error">Dato obligatorio.</small>
            </div>
        </div>
        <div class="small-18 medium-11 columns">
            <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
    			<span style="border-radius: 10px" class="input-group-label">
                    <i class="fa fa-building-o"></i>
                </span>
                <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="text" name="direccion[ciudad]" id="ciudad"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['ciudad'].'"' : ''); ?> placeholder="Ciudad (máximo 35 caracteres)" required pattern="^(.|\s){0,35}$" maxlength="35" />
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
                <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
                    <span style="border-radius: 10px" class="input-group-label">
                        <i class="fa fa-address-card-o"></i>
                    </span>
                    <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="text" name="direccion[linea1]" id="linea1"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['linea1'].'"' : ''); ?> placeholder="Dirección Línea 1: Calle, No. Ext., No. Int., Cruzamiento (máximo 35 caracteres)"  required pattern="^(.|\s){0,35}$" maxlength="35" />
                    <small class="form-error">Dato obligatorio, máximo 35 caracteres.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="small-18 columns">
                <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
                    <span style="border-radius: 10px" class="input-group-label">
                        <i class="fa fa-address-card-o"></i>
                    </span>
                    <select style="border-radius: 10px; color: #FF4C00; font-weight: bold;" name="direccion[linea2]" id="linea2" required disabled>
                        <!--Select de la colonia generado en script_direccion-->
                    </select>
                    <small class="form-error">Dato obligatorio.</small>
                </div>
            </div>
        </div>
        <div class="row" id="colonia-otro" style="display: none">
            <div class="small-18 columns">
                <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
                    <span style="border-radius: 10px" class="input-group-label">
                        <i class="fa fa-address-card-o"></i>
                    </span>
                    <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="text" name="direccion[linea2_otro]" id="linea2_otro"<?php echo ($this->session->direccion_temporal ? ' value="'.$this->session->direccion_temporal['linea2'].'"' : ''); ?> placeholder="Dirección Línea 2: Colonia (máximo 35 caracteres)" pattern="^(.|\s){0,35}$" maxlength="35" />
                    <small class="form-error">Dato obligatorio, máximo 35 caracteres.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="small-18 columns">
                <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
                    <select style="border-radius: 10px; color: #FF4C00; font-weight: bold;" name="direccion[estado]" id="estado" placeholder="Estado" required>
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

    <?php // para facturacion ?>
    <div id="hidden_fact"<?php if(!$this->session->direccion_fiscal_temporal) { echo ' style="display:none;"'; } ?>>
        <div class="row">
            <div class="small-18 columns" id="contenedor_fiscal">
                <?php if(sizeof($direcciones_fiscales) > 0) {
                    $this->load->view('nuevo_carrito/direcciones/listado_direcciones_fiscales_cliente');
                } else {
                    $dir_fiscal = array();
                    $dir_fiscal['secc_fiscal'] = "fiscal_cliente";
                    $this->load->view('nuevo_carrito/direcciones/datos_fiscales_cliente', $dir_fiscal);
                } ?>
            </div>
        </div>
    </div>
</div>
