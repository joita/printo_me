<h2 class="seccionador show-for-medium text-left" style="color: #025573;font-weight: bold">Mis Direcciones</h2>
<br>
<div class="row">
	<div class="col-md-12">
	<?php if(sizeof($direcciones)>0): ?>
		<a data-open="nueva_direccion" class="button btn nomargin specialmargin" style="background: #F2560D; color:white; margin-left: 0; padding: 1rem 2rem; border-radius: 10px"> Agregar Dirección</a></p>
		<div class="row small-up-1 medium-up-1 large-up-3 xlarge-up-3" id="contenedor-direcciones" data-equalizer data-equalize-by-row="true">
		<?php foreach($direcciones as $direccion): ?>
			<div class="column" style="padding-left: 0">
				<div class="direccion form-cuenta" style="border: 2px solid #025573; margin-left: 0; border-radius: 10px">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="dir" data-equalizer-watch>
                                <span class="identi"><strong style="color: #F2560D"><?php echo $direccion->identificador_direccion; ?></strong></span>
                                <span class="linea1" style="color: #F2560D"><?php echo $direccion->linea1; ?></span>
                                <?php if($direccion->linea2 != ''): ?>
                                    <span class="linea2" style="color: #F2560D"><?php echo $direccion->linea2; ?></span>
                                <?php endif; ?>
                                <span class="codigo_postal" style="color: #F2560D">CP: <?php echo $direccion->codigo_postal; ?></span>
                                <span class="ciudad" style="color: #F2560D"><?php echo $direccion->ciudad; ?></span>, <span style="color: #F2560D" class="estado"><?php echo $direccion->estado; ?></span>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="row" data-direccion='<?php echo json_encode($direccion); ?>'>
                                <div class="col-md-12  text-right">
                                    <a style="border: 2px solid #025573; padding: 0.2rem 1rem; border-radius: 10px" data-open="editar_direccion" class="btn btn-info editar_direccion">Editar</a>
                                </div>
                            </div>
                            <br>
                            <div class="row" data-direccion='<?php echo json_encode($direccion); ?>'>
                                <div class="col-md-12  text-right">
                                    <a style="border: 2px solid #025573; padding: 0.2rem 1rem; border-radius: 10px" data-open="borrar_direccion" class="btn  btn-danger borrar_direccion">Borrar</a>
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
			<p>No has agregado direcciones a tu libro de direcciones.</p>
			<p><a data-open="nueva_direccion" class="button"><i class="fa fa-flag-o"></i> Agregar Dirección</a></p>
		</div>
	<?php endif; ?>
	</div>
</div>


<div class="small reveal" id="nueva_direccion" data-reveal>
	<form id="nueva_dir_cuenta" data-abide novalidate autocomplete="off" class="form_dir_cuenta">
		<div class="row">
			<div class="small-18 text-center columns logo-container">
				<img src="#" class="small-logo" data-interchange="[<?php echo site_url('assets/images/header-logo.png'); ?>, small], [<?php echo site_url('assets/images/header-logo-retina.png'); ?>, retina]" alt="Diseña tu playera on-line | printome.mx" width="300" height="87" />
				<h5 class="text-center">Nueva Dirección</h5>
			</div>
		</div>
		<div class="row">
			<div class="small-18 columns">
				<label>Identificador
					<input type="text" name="identificador_direccion" id="identificador_direccion" placeholder="Casa, Oficina, etc." required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
        <div class="row">
            <div class="small-18 medium-7 large-6 columns">
                <label title="Código Postal">C.P.
                    <input type="text" name="codigo_postal" id="codigo_postal" required />
                    <small class="form-error">Dato obligatorio.</small>
                </label>
            </div>
            <div class="small-18 medium-11 large-12 columns">
                <label>Ciudad (máximo 35 caracteres)
                    <input type="text" name="ciudad" id="ciudad" required pattern="^(.|\s){0,35}$" maxlength="35"/>
                    <small class="form-error">Dato obligatorio.</small>
                </label>
            </div>
        </div>
        <div id="contenedor-datos-direccion-mi-cuenta">
            <div id='loader'>
                <img class='float-center' alt='loader gif' src="<?php echo site_url('/assets/images/loading_32x32.gif');?>" width="auto" height="auto">
            </div>
            <div class="row">
                <div class="small-18 columns">
                    <label>Dirección línea 1 (máximo 35 caracteres)
                        <input type="text" name="linea1" id="linea1" placeholder="Calle, Número Ext., Número Int., Cruzamiento" required pattern="^(.|\s){0,35}$" maxlength="35" disabled/>
                        <small class="form-error">Dato obligatorio, máximo 35 caracteres.</small>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="small-18 columns">
                    <label>Dirección línea 2 (máximo 35 caracteres)
                        <select  name="linea2" id="linea2" required disabled>
                            <!--Cosas que se generan-->
                        </select>
                    </label>
                </div>
            </div>
            <div class="row" id="colonia-otro" style="display: none">
                <div class="small-18 columns">
                    <label>Dirección línea 2 (máximo 35 caracteres)
                        <input type="text" name="linea2_otro" id="linea2_otro" placeholder="Colonia, Delegación, etc." pattern="^(.|\s){0,35}$" maxlength="35" />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="small-18 columns">
                    <label>Estado
                        <select name="estado" id="estado" disabled required>
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
			<div class="small-18 medium-11 large-10 columns">
				<label id="nueva-label-tel">Teléfono
					<input type="tel" name="telefono" id="telefono" class="telephone" required minlength="10" maxlength="12"/>
					<small style="margin-top: 0;" id="nueva-error-tel" class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
		
		<div class="row add-buttons">
			<div class="small-9 columns">
				<button type="button" class="btn btn-danger button" data-close>Cancelar</button>
			</div>
			<div class="small-9 columns text-right">
				<input type="hidden" id="id_cliente" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
				<button type="submit" class="primary button btn btn-success" id="add_dir">Agregar</button>
			</div>
		</div>
	</form>

	<button class="close-button " data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>	
</div>

<div class="small reveal" id="editar_direccion" data-reveal>
	<form data-abide novalidate autocomplete="off" id="editar_dir_cuenta" class="form_dir_cuenta">
		<div class="row">
			<div class="small-18 text-center columns logo-container">
				<img src="#" class="small-logo" data-interchange="[<?php echo site_url('assets/images/header-logo.png'); ?>, small], [<?php echo site_url('assets/images/header-logo-retina.png'); ?>, retina]" alt="Diseña tu playera on-line | printome.mx" width="300" height="87" />
				<h5 class="text-center">Editar Dirección</h5>
			</div>
		</div>
		<div class="row">
			<div class="small-18 columns">
				<label>Identificador
					<input type="text" name="identificador_direccion" id="identificador_direccion_mod" placeholder="Casa, Oficina, etc." required />
					<small class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
        <div class="row">
            <div class="small-18 medium-7 large-6 columns">
                <label title="Código Postal">C.P.
                    <input type="text" name="codigo_postal" onblur="cambio_codigo_postal_editar()" id="codigo_postal_mod" required />
                    <small class="form-error">Dato obligatorio.</small>
                </label>
            </div>
            <div class="small-18 medium-11 large-12 columns">
                <label>Ciudad (máximo 35 caracteres)
                    <input type="text" name="ciudad" id="ciudad_mod" required pattern="^(.|\s){0,35}$" maxlength="35" />
                    <small class="form-error">Dato obligatorio.</small>
                </label>
            </div>
        </div>
        <div id="contenedor-datos-direccion-mi-cuenta-fiscal">
            <div id='loader_fiscal'>
                <img class='float-center' alt='loader gif' src="<?php echo site_url('/assets/images/loading_32x32.gif');?>" width="auto" height="auto">
            </div>
            <div class="row">
                <div class="small-18 columns">
                    <label>Dirección línea 1 (máximo 35 caracteres)
                        <input disabled type="text" name="linea1" id="linea1_mod" placeholder="Calle, Número Ext., Número Int., Cruzamiento" required pattern="^(.|\s){0,35}$" maxlength="35" />
                        <small class="form-error">Dato obligatorio, máximo 35 caracteres.</small>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="small-18 columns">
                    <label>Dirección línea 2 (máximo 35 caracteres)
                        <select type="text" name="linea2" id="linea2_mod" required>
                            <!--Cosas Generadas por scripts.php-->
                        </select>
                    </label>
                </div>
            </div>
            <div class="row" id="colonia-otro-mod" style="display: none;">
                <div class="small-18 columns">
                    <label>Dirección línea 2 (máximo 35 caracteres)
                        <input type="text" name="linea2_otro" id="linea2_mod_otro" placeholder="Colonia, Delegación, etc." pattern="^(.|\s){0,35}$" maxlength="35" />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="small-18 columns">
                    <label>Estado
                        <select name="estado" id="estado_mod" disabled required>
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
			<div class="small-18 medium-11 large-10 columns">
				<label id="editar-label-tel">Teléfono
					<input type="tel" name="telefono" id="telefono_mod" class="telephone" required minlength="10" maxlength="12"/>
					<small style="margin-top: 0;" id="editar-error-tel" class="form-error">Dato obligatorio.</small>
				</label>
			</div>
		</div>
		
		<div class="row  add-buttons">
			<div class="col-md-6 ">
				<button type="button" class="btn btn-danger button btn-completo" data-close>Cancelar</button>
			</div>
			<div class="col-md-6  text-right">
				<input type="hidden" name="id_cliente" id="id_cliente_mod" value="<?php echo $this->session->login['id_cliente']; ?>">
				<input type="hidden" name="id_direccion" id="id_direccion_mod" value="">
				<button type="submit" class=" button btn btn-success btn-completo" id="mod_dir">Guardar Cambios</button>
			</div>
		</div>
	</form>
	
	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="small reveal" id="borrar_direccion" data-reveal>
	<form action="<?php echo site_url('mi-cuenta/direcciones/borrar'); ?>" method="post" data-abide novalidate>
		<div class="row">
			<div class="small-18 text-center columns logo-container">
				<img src="#" class="small-logo" data-interchange="[<?php echo site_url('assets/images/header-logo.png'); ?>, small], [<?php echo site_url('assets/images/header-logo-retina.png'); ?>, retina]" alt="Diseña tu playera on-line | printome.mx" width="300" height="87" />
				<h5 class="text-center">Borrar Dirección</h5>
			</div>
		</div>
		<div class="row">
			<div class="small-18 columns">
				<label>¿Estás seguro de querer borrar esta dirección? Esta acción no se puede deshacer.</label>
			</div>
		</div>
		<div class="row add-buttons">
			<div class="col-md-6 ">
				<button type="button" class="btn btn-danger btn-completo button" data-close>Cancelar</button>
			</div>
			<div class="col-md-6  text-right">
				<input type="hidden" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
				<input type="hidden" name="id_direccion" id="id_direccion_bor" value="">
				<button type="submit" class="btn btn-success btn-completo button" id="borr_dir">Borrar Dirección</button>
			</div>
		</div>
		
	</form>
	
	<button class="close-button" data-close aria-label="Cerrar" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>