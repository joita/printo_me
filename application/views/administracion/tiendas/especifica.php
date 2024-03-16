<div class="small-24 columns">
	<h2 class="section-title"><a href="<?php echo site_url('administracion/tiendas'); ?>">« Regresar a Tiendas</a></h2>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="tab-menu">
			<li><a class="active"><i class="fa fa-building-o"></i> <?php echo $tienda->nombre_tienda; ?></a></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<div id="main-container">
			<div class="row">
				<div class="small-24 columns">
					<div class="row resumen-pedido">
						<div class="small-16 columns">
							<table class="campana_info">
								<tr>
									<th colspan="2" class="text-center">Datos de la tienda</th>
								</tr>
								<tr>
									<th width="35%">Nombre</th>
									<td width="65%"><?php echo $tienda->nombre_tienda; ?></td>
								</tr>
								<tr>
									<th>Descripción</th>
									<td><?php echo $tienda->descripcion_tienda; ?></td>
								</tr>
								<tr>
									<th>Vínculo</th>
									<td><a href="<?php echo site_url('tienda/1/'.$tienda->nombre_tienda_slug); ?>" target="_blank"><?php echo site_url('tienda/1/'.$tienda->nombre_tienda_slug); ?></a></td>
								</tr>
								<tr>
									<th>Dueño:</th>
									<td><?php echo $tienda->dueno->nombres.' '.$tienda->dueno->apellidos; ?></td>
								</tr>
								<tr>
									<th>Correo electrónico:</th>
									<td><a href="mailto:<?php echo $tienda->dueno->email; ?>"><?php echo $tienda->dueno->email; ?></a></td>
								</tr>
                                <tr>
                                    <th>Método de pago:</th>
                                    <td><select name="metodo_pago" id="metodo" class="inline" required>
                                            <option value="1" <?php if($tienda->tipo_pago ==1): ?>selected <?php endif ?>>Oxxo</option>
                                            <option value="2" <?php if($tienda->tipo_pago ==2): ?>selected <?php endif ?>>Tarjeta bancaria</option>
                                            <option value="3" <?php if($tienda->tipo_pago ==3): ?>selected <?php endif ?>>Spei</option>
                                        </select><button id="save-metodo" class="inline btn btn-success"><i class="fa fa-save"></i></button>
                                        <div class="msj-success">

                                        </div>
                                    </td>



                                </tr>
							</table>
						</div>
					</div>
					<hr class="dashed" style="margin-top:0;border-style:dashed;" />
                    <input type="hidden" value="<?php echo $tienda->id_tienda?>" id="id_tienda">
					<div class="row">
						<div class="small-24 columns">
							<ul class="tab-menu">
								<li><a href="<?php echo site_url('administracion/tiendas/'.$tienda->id_tienda.'/limitado'); ?>"<?php activar('limitado', $tipo_activo); ?>><i class="fa fa-clock-o"></i> Plazo definido</a></li>
								<li><a href="<?php echo site_url('administracion/tiendas/'.$tienda->id_tienda.'/fijo'); ?>"<?php activar('fijo', $tipo_activo); ?>><i class="fa fa-server"></i> Venta inmediata</a></li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="small-24 columns">
							<div id="main-container" style="padding: 1rem 1.2rem;">
								<?php $this->load->view('administracion/tiendas/productos/'.$tipo_activo); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>