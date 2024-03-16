<div class="reveal-modal small" id="nueva_direccion" data-reveal>
	<form action="<?php echo site_url('mi-cuenta/direcciones/agregar/pagar'); ?>" method="post" data-abide>
		<div class="row">
		  <div class="small-10 small-centered text-center columns" style="margin-bottom:1rem;padding-bottom:1rem;border-bottom:solid 1px #EEE;">
			<img src="<?php echo site_url('assets/images/header_logo_recortado.png'); ?>" data-interchange="[<?php echo site_url('assets/images/header_logo_recortado.png'); ?>,(default)],[<?php echo site_url('assets/images/header_logo_retina_recortado.png'); ?>,(retina)]" alt="Print-o-Me">
		  </div>
		</div>
		<h4 class="text-center">Agregar dirección</h4>
		<div class="row">
			<div class="small-24 columns">
				<label>Identificador
					<input type="text" name="identificador_direccion" id="identificador_direccion" placeholder="Casa, Oficina, etc." required />
				</label>
				<span class="form-error">Dato obligatorio.</span>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns">
				<label>Dirección línea 1
					<input type="text" name="linea1" id="linea1" placeholder="Calle, Número Ext., Número Int., Cruzamiento" required />
				</label>
				<span class="form-error">Dato obligatorio.</span>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns">
				<label>Dirección línea 2
					<input type="text" name="linea2" id="linea2" placeholder="Colonia" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 medium-15 columns">
				<label>Ciudad
					<input type="text" name="ciudad" id="ciudad" placeholder="Ciudad" required />
				</label>
				<span class="form-error">Dato obligatorio.</span>
			</div>
			<div class="small-24 medium-9 columns">
				<label>Código Postal
					<input type="text" name="codigo_postal" id="codigo_postal" placeholder="Ciudad" required />
				</label>
				<span class="form-error">Dato obligatorio.</span>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns">
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
				</label>
				<span class="form-error">Dato obligatorio.</span>
			</div>
		</div>
		<div class="row" style="border-top: dotted 1px #DDD;">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
				<button type="submit" class="left" id="add_dir"><i class="fa fa-plus"></i> Agregar Dirección</button>
				<button type="button" class=" right revealcloser">Cancelar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal">&#215;</a>
</div>