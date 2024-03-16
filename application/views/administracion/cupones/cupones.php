<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Cupones</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="tab-menu">
			<li><a class="active"><i class="fa fa-tags"></i> Cupones</a></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<div id="main-container">
			<div class="row" data-equalizer style="padding:0 1rem">
				<div class="small-24 end columns navholder" data-equalizer-watch>
					<a href="#" data-reveal-id="nueva_cupon" class="coollink"><i class="fa fa-plus"></i> Agregar nuevo cupón</a>
				</div>
			</div>
			<div class="row">
				<div class="small-24 columns">
					<ul class="divisor">
					<?php foreach($this->cupones_modelo->obtener_cupones_admin() as $cupon): ?>
						<li>
							<div class="row">
								<div class="small-12 columns">
									<span class="categoria-principal"><i class="fa fa-tag"></i> <?php echo $cupon->nombre; ?> - <?php echo $cupon->cupon; ?></span>
								</div>
								<div class="small-12 columns text-right function-links" data-id_cupon="<?php echo $cupon->id; ?>" data-nombre="<?php echo $cupon->nombre; ?>" data-cupon="<?php echo $cupon->cupon; ?>" data-descuento="<?php echo $cupon->descuento; ?>" data-cantidad="<?php echo $cupon->cantidad; ?>" data-expira="<?php echo $cupon->expira; ?>" data-monto_minimo="<?php echo $cupon->monto_minimo; ?>" data-tipo="<?php echo $cupon->tipo; ?>" data-estatus="<?php echo $cupon->estatus; ?>" data-nombre_tienda="<?php echo $cupon->nombre_tienda != 'NULL' ? $cupon->nombre_tienda : "" ; ?>" data-producto="<?php echo $cupon->flag_producto?>">
									<a href="#" class="edit-main-cat" data-reveal-id="editar_cupon"><i class="fa fa-edit"></i> Editar cupón</i></a>
									<?php if($cupon->estatus == 1): ?>
									<a href="#" class="enabled"><i class="fa fa-toggle-on"></i></a>
									<?php else: ?>
									<a href="#" class="disabled"><i class="fa fa-toggle-off"></i></a>
									<?php endif; ?>
									<a href="#" class="delete-main-cat" data-reveal-id="borrar_cupon"><i class="fa fa-times"></i></a>
								</div>
							</div>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="reveal-modal small" id="nueva_cupon" data-reveal>
	<form action="<?php echo site_url('administracion/cupones/agregar-cupon'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre del cupón
					<input type="text" name="nombre" id="nombre_add" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns">
				<label>Código del cupón (mayúsculas de preferencia)
					<input type="text" name="cupon" id="cupon_add" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns">
				<label>Descuento (de 0 a 1 es porcentual, arriba de 1 es por monto)
					<input type="number" name="descuento" id="descuento_add" />
				</label>
			</div>
		</div>
        <div class="row">
            <div class="small-24 columns">
                <label>Nombre Tienda (Opcional)
                    <input type="text" placeholder="Opcional" name="tienda" id="tienda_add" class="tiendas" />
                </label>
            </div>
        </div>
        <input type="hidden" class="id_cliente" name="id_cliente" value="">
		<div class="row">
			<div class="small-24 columns">
				<label>Monto mínimo subtotal
					<input type="number" name="monto_minimo" id="monto_minimo_add" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns">
				<label>Cantidad de cupones
					<input type="number" name="cantidad" id="cantidad_add" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns">
				<label>Expira
					<input type="date" name="expira" id="expira_add" />
				</label>
			</div>
		</div>
        <div class="row">
            <div class="small-24 columns">
                <label>El descuento se aplicará unicamente sobre pedidos de 1 producto
                    <input type="checkbox" name="producto" id="producto_add" />
                </label>
            </div>
        </div>
		<div class="row">
			<div class="small-24 columns">
				<label>Tipo
					<select name="tipo" id="tipo_add">
						<option value="1">Promoción</option>
						<option value="3">Descuento productos personalizados</option>
						<option value="2" style="display:none;">Referido</option>
                        <option value="4">Envio Gratis</option>
					</select>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<button type="submit">Agregar</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal small" id="editar_cupon" data-reveal>
	<form action="<?php echo site_url('administracion/cupones/editar-cupon'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label>Nombre del cupón
					<input type="text" name="nombre" id="nombre_mod" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns">
				<label>Código del cupón (mayúsculas de preferencia)
					<input type="text" name="cupon" id="cupon_mod" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns">
				<label>Descuento (de 0 a 1 es porcentual, arriba de 1 es por monto)
					<input type="number" name="descuento" id="descuento_mod" />
				</label>
			</div>
		</div>
        <div class="row">
            <div class="small-24 columns">
                <label>Nombre Tienda (Opcional)
                    <input type="text" placeholder="Opcional" name="tienda" id="tienda_mod" class="tiendas"/>
                </label>
            </div>
        </div>
        <input type="hidden" class="id_cliente" name="id_cliente" value="">
		<div class="row">
			<div class="small-24 columns">
				<label>Monto mínimo subtotal
					<input type="number" name="monto_minimo" id="monto_minimo_mod" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns">
				<label>Cantidad de cupones
					<input type="number" name="cantidad" id="cantidad_mod" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns">
				<label>Expira
					<input type="date" name="expira" id="expira_mod" />
				</label>
			</div>
		</div>
        <div class="row">
            <div class="small-24 columns">
                <label style="padding-bottom: 1rem; padding-top: 0.5rem">
                    <input type="checkbox" name="producto" id="producto_mod" />&nbsp; &nbsp; El cupón se aplicará unicamente sobre pedidos de 1 producto.
                </label>
            </div>
        </div>
		<div class="row">
			<div class="small-24 columns">
				<label>Tipo
					<select name="tipo" id="tipo_mod">
						<option value="1">Promoción</option>
						<option value="3">Descuento productos personalizados</option>
						<option value="2" style="display:none;">Referido</option>
                        <option value="4">Envio Gratis</option>
					</select>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_cupon" id="id_cupon_mod">
				<button type="submit">Guardar cambios</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>


<div class="reveal-modal small" id="borrar_cupon" data-reveal>
	<form action="<?php echo site_url('administracion/cupones/borrar-cupon'); ?>" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar este cupón?</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_cupon" id="id_cupon_bor">
				<button type="submit">Borrar cupon</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
