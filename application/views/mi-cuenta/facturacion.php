<h2 class="seccionador show-for-medium text-left" style="color: #025573;font-weight: bold">Mis Datos de Facturacion</h2>
<br>
<div class="row">
	<div class="col-md-12">
	<?php if(sizeof($direcciones)>0): ?>
		<a data-open="nueva_direccion" class="button nomargin specialmargin" style="background: #F2560D; color:white; margin-left: 0; padding: 1rem 2rem; border-radius: 10px"> Agregar Datos de Facturación</a></p>
		<div class="row small-up-1 medium-up-1 large-up-3 xlarge-up-3" id="contenedor-direcciones" data-equalizer data-equalize-by-row="true">
		<?php foreach($direcciones as $direccion): ?>
			<div class="column" style="padding-left: 0">
				<div class="direccion form-cuenta" style="border: 2px solid #025573; margin-left: 0; border-radius: 10px">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="dir" data-equalizer-watch>
                                <span class="identi" style="color: #F2560D"><strong><?php echo $direccion->razon_social; ?><br /> (<?php echo $direccion->rfc; ?>)</strong></span>
                                <span class="linea1" style="color: #F2560D"><?php echo $direccion->cfdi; ?></span>
                                <span class="linea1" style="color: #F2560D"><?php echo $direccion->linea1; ?></span>
                                <?php if($direccion->linea2 != ''): ?>
                                    <span class="linea2" style="color: #F2560D"><?php echo $direccion->linea2; ?></span>
                                <?php endif; ?>
                                <span class="codigo_postal" style="color: #F2560D">CP: <?php echo $direccion->codigo_postal; ?></span>
                                <span class="ciudad" style="color: #F2560D"><?php echo $direccion->ciudad; ?></span>, <span style="color: #F2560D" class="estado"><?php echo $direccion->estado; ?></span>
                                <span class="codigo_postal" style="color: #F2560D">E-Mail: <?php echo $direccion->correo_electronico_facturacion; ?></span>
                                <span class="codigo_postal" style="color: #F2560D">Teléfono: <?php echo $direccion->telefono; ?></span>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="row " data-direccion='<?php echo json_encode($direccion); ?>'>
                                <div class="col-md-12  text-left">
                                    <a style="border: 2px solid #025573; padding: 0.2rem 1rem; border-radius: 10px" class="btn btn-success editar_facturacion" data-open="editar_direccion" >Editar</a>
                                </div>
                            </div>
                            <br>
                            <div class="row " data-direccion='<?php echo json_encode($direccion); ?>'>
                                <div class="col-md-12 text-right">
                                    <a style="border: 2px solid #025573; padding: 0.2rem 1rem; border-radius: 10px" class="btn btn-danger borrar_facturacion" data-open="borrar_direccion" >Borrar</a>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	<?php else: ?>
		<div class="form-cuenta text-center">
			<p>No has agregado datos de facturación a tu cuenta.</p>
			<p><a data-open="nueva_direccion" class="button btn btn-primary"><i class="fa fa-flag-o"></i> Agregar Datos de Facturación</a></p>
		</div>
	<?php endif; ?>
	</div>
</div>


<div class="small reveal" id="nueva_direccion" data-reveal>
	<form id="nueva_factura" data-abide novalidate>
		<div class="row">
			<div class="col-md-12 text-center logo-container">
				<img src="#" class="small-logo" data-interchange="[<?php echo site_url('assets/images/header-logo.png'); ?>, small], [<?php echo site_url('assets/images/header-logo-retina.png'); ?>, retina]" alt="Diseña tu playera on-line | printome.mx" width="300" height="87" />
				<h5 class="text-center">Nuevos Datos de Facturación</h5>
			</div>
		</div>
	
		<div class="row">
			<div class="col-md-12">
				<label>Razón Social / Nombre
					<input type="text" name="razon_social" id="razon_social" placeholder="" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<label>R.F.C.
					<input type="text" name="rfc" id="rfc" placeholder="" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
        <div class="row">
			<div class="col-md-12">
				<label>CFDI
					<input type="text" name="cfdi" id="cfdi" placeholder="" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <label title="Código Postal">C.P.
                    <input type="text" name="codigo_postal" id="codigo_postal" required />
                    <small class="form-error">Dato obligatorio.</small>
                </label>
            </div>
            <div class="col-xs-12 col-md-6">
                <label>Ciudad
                    <input type="text" name="ciudad" id="ciudad" required />
                    <small class="form-error">Dato obligatorio.</small>
                </label>
            </div>
        </div>
        <div id="contenedor-datos-direccion-mi-cuenta">
            <div id='loader'>
                <img class='float-center' alt='loader gif' src="<?php echo site_url('/assets/images/loading_32x32.gif');?>" width="auto" height="auto">
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Dirección línea 1
                        <input type="text" name="linea1" id="linea1" placeholder="Calle, Número Ext., Número Int., Cruzamiento" disabled required />
                        <small class="form-error">Dato obligatorio.</small>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Dirección línea 2
                        <select name="linea2" id="linea2" required disabled>
                            <!--Datos generados por jQuery-->
                        </select>
                    </label>
                </div>
            </div>
            <div class="row" id="colonia-otro" style="display: none">
                <div class="col-md-12">
                    <label>Dirección línea 2
                        <input type="text" name="linea2_otro" id="linea2_otro" placeholder="Colonia, Delegación, etc." />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Estado
                        <select name="estado" id="estado" required>
                            <option value=""></option>
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
                    </label>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="col-xs-12 col-md-6">
				<label>Correo electrónico
					<input type="email" name="correo_electronico_facturacion" id="correo_electronico_facturacion" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
			<div class="col-xs-12 col-md-6">
				<label id="fac-label-tel">Teléfono
					<input type="text" name="telefono" id="telefono" required minlength="10" maxlength="12"/>
					<small style="margin-top: 0;" id="fac-error-tel" class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
		
		<div class="row add-buttons">
			<div class="col-xs-12 col-md-6">
				<button type="button" class="btn btn-danger btn-completo button" data-close>Cancelar</button>
			</div>
			<div class="col-xs-12 col-md-6 text-right">
				<input type="hidden" id="id_cliente_fac" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
				<button type="submit" class="btn btn-success btn-completo button" id="add_dir">Agregar</button>
			</div>
		</div>
	</form>

	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>	
</div>

<div class="small reveal" id="editar_direccion" data-reveal>
	<form id="editar_factura" data-abide novalidate>
		<div class="row">
			<div class="col-md-12 text-center  logo-container">
				<img src="#" class="small-logo" data-interchange="[<?php echo site_url('assets/images/header-logo.png'); ?>, small], [<?php echo site_url('assets/images/header-logo-retina.png'); ?>, retina]" alt="Diseña tu playera on-line | printome.mx" width="300" height="87" />
				<h5 class="text-center">Editar Datos de Facturación</h5>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<label>Razón Social / Nombre
					<input type="text" name="razon_social" id="razon_social_mod" placeholder="" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<label>R.F.C.
					<input type="text" name="rfc" id="rfc_mod" placeholder="" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
        <div class="row">
			<div class="col-md-12">
				<label>CFDI
					<input type="text" name="cfdi" id="cfdi_mod" placeholder="" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
        <div id="contenedor-datos-direccion-mi-cuenta-fiscal">
            <div id='loader_fiscal'>
                <img class='float-center' alt='loader gif' src="<?php echo site_url('/assets/images/loading_32x32.gif');?>" width="auto" height="auto">
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <label title="Código Postal">C.P.
                        <input type="text" name="codigo_postal" id="codigo_postal_mod" required />
                        <small class="form-error">Dato obligatorio.</small>
                    </label>
                </div>
                <div class="col-xs-12 col-md-6">
                    <label>Ciudad
                        <input type="text" name="ciudad" id="ciudad_mod" required />
                        <small class="form-error">Dato obligatorio.</small>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Dirección línea 1
                        <input type="text" name="linea1" id="linea1_mod" placeholder="Calle, Número Ext., Número Int., Cruzamiento" required />
                        <small class="form-error">Dato obligatorio.</small>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Dirección línea 2
                        <select name="linea2" id="linea2_mod" >
                            <!--Generado por jQuery-->
                        </select>
                    </label>
                </div>
            </div>
            <div class="row" id="colonia-otro-mod" style="display: none">
                <div class="col-md-12">
                    <label>Dirección línea 2
                        <input type="text" name="linea2_otro" id="linea2_mod_otro" placeholder="Colonia, Delegación, etc." />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Estado
                        <select name="estado" id="estado_mod" required>
                            <option value=""></option>
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
                    </label>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="col-xs-12 col-md-6">
				<label>Correo electrónico
					<input type="email" name="correo_electronico_facturacion" id="correo_electronico_facturacion_mod" required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
			<div class="col-xs-12 col-md-6">
				<label id="editar-label-tel">Teléfono
					<input type="text" name="telefono" id="telefono_mod" required minlength="10" maxlength="12"/>
					<small style="margin-top: 0;" id="editar-error-fac" class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
		
		<div class="row add-buttons">
			<div class="col-xs-12 col-md-6">
				<button type="button" class="btn btn-completo btn-danger button" data-close>Cancelar</button>
			</div>
			<div class="col-xs-12 col-md-6 text-right">
				<input type="hidden" id="id_cliente_fac_mod" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
				<input type="hidden" name="id_direccion_fiscal" id="id_direccion_fiscal_mod" value="">
				<button type="submit" class="btn btn-success btn-completo button" id="mod_dir">Guardar Cambios</button>
			</div>
		</div>
	</form>
	
	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="small reveal" id="borrar_direccion" data-reveal>
	<form action="<?php echo site_url('mi-cuenta/facturacion/borrar'); ?>" method="post" data-abide novalidate>
		<div class="row">
			<div class="col-md-12 text-center logo-container">
				<img src="#" class="small-logo" data-interchange="[<?php echo site_url('assets/images/header-logo.png'); ?>, small], [<?php echo site_url('assets/images/header-logo-retina.png'); ?>, retina]" alt="Diseña tu playera on-line | printome.mx" width="300" height="87" />
				<h5 class="text-center">Borrar Datos de Facturación</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<label>¿Estás seguro de querer borrar estos datos de facturación? Esta acción no se puede deshacer.</label>
			</div>
		</div>
		<div class="row add-buttons">
			<div class="col-xs-12 col-md-6">
				<button type="button" class="btn btn-danger btn-completo button" data-close>Cancelar</button>
			</div>
			<div class="col-xs-12 col-md-6 text-right">
				<input type="hidden" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
				<input type="hidden" name="id_direccion_fiscal" id="id_direccion_fiscal_bor" value="">
				<button type="submit" class="btn btn-success btn-completo button" id="borr_dir">Borrar</button>
			</div>
		</div>
		
	</form>
	
	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

