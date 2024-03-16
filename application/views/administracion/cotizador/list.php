<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Cotizador</h2>
	</div>
</div>
<style type="text/css">
	.tabs-content {
		width: auto;
	}
	
	table tr.even input.change_data, table tr.alt input.change_data, table tr:nth-of-type(even) input.change_data {
	    /* border-color: #AAA; */
	    border-top: none;
	    border-bottom: none;
	    border-right: none;
	}
</style>
<div class="row">
	<div class="small-24 columns">
		<ul class="tabs" data-tab>
			<li class="tab-title active"><a href="#panel11">Estampado en frente y espalda</a></li>
			<li class="tab-title"><a href="#panel21">Estampado en mangas</a></li>
		</ul>
		<div class=" large-20 columns tabs-content">
			<div class="content active" id="panel11">
				<h5 class="text-center">Estampado en frente y espalda</h5>
				<?php foreach($obtener_tipo_estampado_1 as $row): ?>
				<table id="table_cotizador" data-idtipo_tinta="<?php echo $row->tipo_tinta?>" data-idtipo_estampado="<?php echo $row->tipo_estampado?>">
					<thead>
						<tr>
							<td colspan="8" class="text-center"><?php echo $row->titulo?></td>
						</tr>
					</thead>
					<thead>
						<tr>
							<th class="text-center">Cantidad MIN</th>
							<th class="text-center">Cantidad MAX</th>
							<th class="text-center">Costo Playera Blanca</th>
							<th class="text-center">Costo Playera Color</th>
							<th class="text-center">Tecnica</th>
							<th class="text-center">Mult. 1</th>
							<th class="text-center">Mult. 2</th>
							<th class="text-center">Opción</th>
						</tr>
					</thead>
					<tbody class="ajax_items" data-idtipo_tinta="<?php echo $row->tipo_tinta?>" data-idtipo_estampado="<?php echo $row->tipo_estampado?>">
						<?php foreach($row->data as $key => $data): ?>
						<tr data-id="<?php echo $data->id_cotizador; ?>">
							<td><input name="data[<?php echo $data->id_cotizador; ?>][cantidad_min]" class="change_data text-center" value="<?php echo $data->cantidad_min?>"></td>
							<td><input name="data[<?php echo $data->id_cotizador; ?>][cantidad_max]" class="change_data text-center" value="<?php echo $data->cantidad_max?>"></td>
							<td><input name="data[<?php echo $data->id_cotizador; ?>][costo_blanca]" class="change_data text-center" value="<?php echo $data->costo_blanca?>"></td>
							<td><input name="data[<?php echo $data->id_cotizador; ?>][costo_color]" class="change_data text-center" value="<?php echo $data->costo_color?>"></td>
							<td>
								<select name="data[<?php echo $data->id_cotizador; ?>][tecnica]" class="change_data text-center">
									<option value="TDG" <?php selected_opcion('TDG', $data->tecnica);?>>TDG</option>
									<option value="SERI" <?php selected_opcion('SERI', $data->tecnica);?>>SERI</option>
									<option value="VINIL" <?php selected_opcion('VINIL', $data->tecnica);?>>VINIL</option>
								</select>
							</td>
							<td><input name="data[<?php echo $data->id_cotizador; ?>][multiplicador_1]" class="change_data text-center" value="<?php echo $data->multiplicador_1?>"></td>
							<td><input name="data[<?php echo $data->id_cotizador; ?>][multiplicador_2]" class="change_data text-center" value="<?php echo $data->multiplicador_2?>"></td>
							<td data-key='<?php echo $key; ?>'>
								<ul class="btn-opcion-list clearfix">
								  <li><a class="delete-item delete-item-db"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
								</ul>
							</td>
						</tr>
						<?php endforeach; ?>
						<tr class="tr-new-item" data-newitem="0">
							<td><input name="data[0][cantidad_min]" class="new_data text-center" value=""></td>
							<td><input name="data[0][cantidad_max]" class="new_data text-center" value=""></td>
							<td><input name="data[0][costo_blanca]" class="new_data text-center" value=""></td>
							<td><input name="data[0][costo_color]" class="new_data text-center" value=""></td>
							<td>
								<select name="data[0][tecnica]" class="new_data text-center">
									<option value="TDG">TDG</option>
									<option value="SERI">SERI</option>
									<option value="VINIL">VINIL</option>
								</select>
							</td>
							<td><input name="data[0][multiplicador_1]" class="new_data text-center" value=""></td>
							<td>
								<input name="data[0][multiplicador_2]" class="new_data text-center" value="">
								<input name="data[0][tipo_tinta]" type="hidden" value="<?php echo $row->tipo_tinta?>">
								<input name="data[0][tipo_estampado]" type="hidden" value="<?php echo $row->tipo_estampado?>">
							</td>
							<td>
								<ul class="btn-opcion-list clearfix">
								  <li><a class="new-item"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
								</ul>
							</td>
						</tr>
					</tbody>
					<?php /*
					<tfoot>
						<tr>
							<td colspan="8" class="panel clearfix">
								<a class="button tiny right success safe_items">Guardar</a>
							</td>
						</tr>
					</tfoot>
					*/ ?>
				</table>
				<?php endforeach; ?>
			</div>
			<div class="content" id="panel21">
				<h5 class="text-center">Estampado en mangas</h5>
				<?php foreach($obtener_tipo_estampado_2 as $row): ?>
				<table id="table_cotizador" data-idtipo_tinta="<?php echo $row->tipo_tinta?>" data-idtipo_estampado="<?php echo $row->tipo_estampado?>">
					<thead>
						<tr>
							<td colspan="8" class="text-center"><?php echo $row->titulo?></td>
						</tr>
					</thead>
					<thead>
						<tr>
							<th class="text-center">Cantidad MIN</th>
							<th class="text-center">Cantidad MAX</th>
							<th class="text-center">Costo Playera Blanca</th>
							<th class="text-center">Costo Playera Color</th>
							<th class="text-center">Tecnica</th>
							<th class="text-center">Mult. 1</th>
							<th class="text-center">Mult. 2</th>
							<th class="text-center">Opción</th>
						</tr>
					</thead>
					<tbody class="ajax_items" data-idtipo_tinta="<?php echo $row->tipo_tinta?>" data-idtipo_estampado="<?php echo $row->tipo_estampado?>">
						<?php foreach($row->data as $key => $data): ?>
						<tr data-id="<?php echo $data->id_cotizador; ?>">
							<td><input name="data[<?php echo $data->id_cotizador; ?>][cantidad_min]" class="change_data text-center" value="<?php echo $data->cantidad_min?>"></td>
							<td><input name="data[<?php echo $data->id_cotizador; ?>][cantidad_max]" class="change_data text-center" value="<?php echo $data->cantidad_max?>"></td>
							<td><input name="data[<?php echo $data->id_cotizador; ?>][costo_blanca]" class="change_data text-center" value="<?php echo $data->costo_blanca?>"></td>
							<td><input name="data[<?php echo $data->id_cotizador; ?>][costo_color]" class="change_data text-center" value="<?php echo $data->costo_color?>"></td>
							<td>
								<select name="data[<?php echo $data->id_cotizador; ?>][tecnica]" class="change_data text-center">
									<option value="TDG" <?php selected_opcion('TDG', $data->tecnica);?>>TDG</option>
									<option value="SERI" <?php selected_opcion('SERI', $data->tecnica);?>>SERI</option>
									<option value="VINIL" <?php selected_opcion('VINIL', $data->tecnica);?>>VINIL</option>
								</select>
							</td>
							<td><input name="data[<?php echo $data->id_cotizador; ?>][multiplicador_1]" class="change_data text-center" value="<?php echo $data->multiplicador_1?>"></td>
							<td><input name="data[<?php echo $data->id_cotizador; ?>][multiplicador_2]" class="change_data text-center" value="<?php echo $data->multiplicador_2?>"></td>
							<td data-key='<?php echo $key; ?>'>
								<ul class="btn-opcion-list clearfix">
								  <li><a class="delete-item delete-item-db"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
								</ul>
							</td>
						</tr>
						<?php endforeach; ?>
						<tr class="tr-new-item" data-newitem="0">
							<td><input name="data[0][cantidad_min]" class="new_data text-center" value=""></td>
							<td><input name="data[0][cantidad_max]" class="new_data text-center" value=""></td>
							<td><input name="data[0][costo_blanca]" class="new_data text-center" value=""></td>
							<td><input name="data[0][costo_color]" class="new_data text-center" value=""></td>
							<td>
								<select name="data[0][tecnica]" class="new_data text-center">
									<option value="TDG">TDG</option>
									<option value="SERI">SERI</option>
									<option value="VINIL">VINIL</option>
								</select>
							</td>
							<td><input name="data[0][multiplicador_1]" class="new_data text-center" value=""></td>
							<td>
								<input name="data[0][multiplicador_2]" class="new_data text-center" value="">
								<input name="data[0][tipo_tinta]" type="hidden" value="<?php echo $row->tipo_tinta?>">
								<input name="data[0][tipo_estampado]" type="hidden" value="<?php echo $row->tipo_estampado?>">
							</td>
							<td>
								<ul class="btn-opcion-list clearfix">
								  <li><a class="new-item"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>