<div class="row">
    <div class="small-18 columns">
        <h2 style="color: #FF4C00;font-weight: bold; border: none; border-bottom: 2px solid #025573;" class="text-center medium-text-left" data-equalizer-watch="titulo">Tus datos de facturación</h2>
    </div>
</div>
<div class="row">
    <div class="small-18 columns">
        <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
            <span style="border-radius: 10px" class="input-group-label">
                <i class="fa fa-bank"></i>
            </span>
            <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="text" name="direccion_fiscal[razon_social]" id="razon_social_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['razon_social'].'"' : ''); ?>  placeholder="Razón Social / Nombre" />
            <small class="form-error">Dato obligatorio.</small>
        </div>
    </div>
</div>
<div class="row">
    <div class="small-18 columns">
        <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
            <span style="border-radius: 10px" class="input-group-label">
                <i class="fa fa-tag"></i>
            </span>
            <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="text" name="direccion_fiscal[rfc]" id="rfc_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['rfc'].'"' : ''); ?>  placeholder="R.F.C." />
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
        <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
            <span style="border-radius: 10px" class="input-group-label">
                <i class="fa fa-map-signs"></i>
            </span>
            <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="text" name="direccion_fiscal[codigo_postal]" id="codigo_postal_limpia" onblur="cambio_codigo_postal_fiscal()" <?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['codigo_postal'].'"' : ''); ?> placeholder="Código Postal"  />
            <small class="form-error">Dato obligatorio.</small>
        </div>
    </div>
    <div class="small-18 medium-11 columns">
        <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
            <span style="border-radius: 10px" class="input-group-label">
                <i class="fa fa-building-o"></i>
            </span>
            <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="text" name="direccion_fiscal[ciudad]" id="ciudad_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['ciudad'].'"' : ''); ?> placeholder="Ciudad"/>
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
            <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
                <span style="border-radius: 10px" class="input-group-label">
                    <i class="fa fa-address-card-o"></i>
                </span>
                <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="text" name="direccion_fiscal[linea1]" id="linea1_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['linea1'].'"' : ''); ?> placeholder="Dirección Línea 1: Calle, No. Ext., No. Int., Cruzamiento"disabled/>
                <small class="form-error">Dato obligatorio.</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="small-18 columns">
            <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
                <span style="border-radius: 10px" class="input-group-label">
                    <i class="fa fa-address-card-o"></i>
                </span>
                <select style="border-radius: 10px; color: #FF4C00; font-weight: bold;" name="direccion_fiscal[linea2]" id="linea2_limpia" <?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['linea2'].'"' : ''); ?>>
                    <!--Select de la colonia fiscal generado en script_direccion-->
                </select>
                <small class="form-error">Dato obligatorio.</small>
            </div>
        </div>
    </div>
    <div class="row" id="colonia-otro-limpia" style="display: none">
        <div class="small-18 columns">
            <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
                <span style="border-radius: 10px" class="input-group-label">
                    <i class="fa fa-address-card-o"></i>
                </span>
                <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="text" name="direccion_fiscal[linea2_otro]" id="linea2_limpia_otro" placeholder="Dirección Línea 2: Colonia (máximo 35 caracteres)" pattern="^(.|\s){0,35}$" maxlength="35" />
                <small class="form-error">Dato obligatorio, máximo 35 caracteres.</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="small-18 columns">
            <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
                <select style="border-radius: 10px; color: #FF4C00; font-weight: bold;" name="direccion_fiscal[estado]" id="estado_limpia" placeholder="Estado"disabled>
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
        <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
            <span style="border-radius: 10px" class="input-group-label">
                <i class="fa fa-envelope-o"></i>
            </span>
            <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="email" placeholder="Correo electrónico" name="direccion_fiscal[correo_electronico_facturacion]" id="correo_electronico_facturacion_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['correo_electronico_facturacion'].'"' : ''); ?>  />
            <small class="form-error">Dato obligatorio.</small>
        </div>
    </div>
    <div class="small-18 medium-18 large-9 columns">
        <div style="box-shadow: none !important;border: 2px solid #025573 !important;border-radius: 10px !important; color:#FF4C00; font-weight: bold; background-color: white" class="input-group">
            <input style="border-radius: 10px; color: #FF4C00; font-weight: bold;" type="text" placeholder="Teléfono" name="direccion_fiscal[telefono]" id="telefono_limpia"<?php echo ($this->session->direccion_fiscal_temporal ? ' value="'.$this->session->direccion_fiscal_temporal['telefono'].'"' : ''); ?>  minlength="10" maxlength="12"/>
            <small style="margin-top: 0;" id="error-tel_limpia" class="form-error">Mínimo 10 dígitos.</small>
        </div>
    </div>
</div>
