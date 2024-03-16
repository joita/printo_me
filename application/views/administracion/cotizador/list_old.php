<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Cotizador</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="divisor">
			<li>
				<div class="row">
					<div class="small-24 columns">
						<a href="#" data-reveal-id="nueva_cotizacion"><i class="fa fa-plus"></i> Agregar Nueva Cotización</a>
					</div>
				</div>	
			</li>
		</ul>
	</div>
	<div class="small-24 columns">
		<h5>Estampado en frente y espalda</h5>
		<table>
			<thead>
				<tr>
					<td colspan="7" class="text-center">Una Tinta</td>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>Cantidad</th>
					<th>Costo Playera Blanca</th>
					<th>Costo Playera Color</th>
					<th>Tecnica</th>
					<th>Multiplicador 1</th>
					<th>Multiplicador 2</th>
					<th class="text-center">Opción</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($una_tinta_1->result() as $row): ?>
				<tr>
					<td><?php echo $row->cantidad?></td>
					<td><?php echo $row->costo_blanca?></td>
					<td><?php echo $row->costo_color?></td>
					<td><?php echo $row->tecnica?></td>
					<td><?php echo $row->multiplicador_1?></td>
					<td><?php echo $row->multiplicador_2?></td>
					<td>
						<div class="button-bar">
							<ul class="button-group round" data-id="<?php echo $row->id_cotizador;?>">
							  <li><a href="#" class="tiny button edit-cotizador"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a></li>
							  <li><a href="#" class="tiny button alert delete-cotizador"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</a></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<table>
			<thead>
				<tr>
					<td colspan="7" class="text-center">Dos Tinta</td>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>Cantidad</th>
					<th>Costo Playera Blanca</th>
					<th>Costo Playera Color</th>
					<th>Tecnica</th>
					<th>Multiplicador 1</th>
					<th>Multiplicador 2</th>
					<th class="text-center">Opción</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($dos_tinta_1->result() as $row): ?>
				<tr data-id="<?php echo $row->id_cotizador; ?>">
					<td><?php echo $row->cantidad?></td>
					<td><?php echo $row->costo_blanca?></td>
					<td><?php echo $row->costo_color?></td>
					<td><?php echo $row->tecnica?></td>
					<td><?php echo $row->multiplicador_1?></td>
					<td><?php echo $row->multiplicador_2?></td>
					<td>
						<div class="button-bar">
							<ul class="button-group round" data-id="<?php echo $row->id_cotizador;?>">
							  <li><a href="#" class="tiny button edit-cotizador"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a></li>
							  <li><a href="#" class="tiny button alert delete-cotizador"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</a></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<table>
			<thead>
				<tr>
					<td colspan="7" class="text-center">Tres Tinta</td>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>Cantidad</th>
					<th>Costo Playera Blanca</th>
					<th>Costo Playera Color</th>
					<th>Tecnica</th>
					<th>Multiplicador 1</th>
					<th>Multiplicador 2</th>
					<th class="text-center">Opción</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($tres_tinta_1->result() as $row): ?>
				<tr data-id="<?php echo $row->id_cotizador; ?>">
					<td><?php echo $row->cantidad?></td>
					<td><?php echo $row->costo_blanca?></td>
					<td><?php echo $row->costo_color?></td>
					<td><?php echo $row->tecnica?></td>
					<td><?php echo $row->multiplicador_1?></td>
					<td><?php echo $row->multiplicador_2?></td>
					<td>
						<div class="button-bar">
							<ul class="button-group round" data-id="<?php echo $row->id_cotizador;?>">
							  <li><a href="#" class="tiny button edit-cotizador"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a></li>
							  <li><a href="#" class="tiny button alert delete-cotizador"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</a></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<table>
			<thead>
				<tr>
					<td colspan="7" class="text-center">Separacion Tinta</td>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>Cantidad</th>
					<th>Costo Playera Blanca</th>
					<th>Costo Playera Color</th>
					<th>Tecnica</th>
					<th>Multiplicador 1</th>
					<th>Multiplicador 2</th>
					<th class="text-center">Opción</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($separacion_tinta_1->result() as $row): ?>
				<tr data-id="<?php echo $row->id_cotizador; ?>">
					<td><?php echo $row->cantidad?></td>
					<td><?php echo $row->costo_blanca?></td>
					<td><?php echo $row->costo_color?></td>
					<td><?php echo $row->tecnica?></td>
					<td><?php echo $row->multiplicador_1?></td>
					<td><?php echo $row->multiplicador_2?></td>
					<td>
						<div class="button-bar">
							<ul class="button-group round" data-id="<?php echo $row->id_cotizador;?>">
							  <li><a href="#" class="tiny button edit-cotizador"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a></li>
							  <li><a href="#" class="tiny button alert delete-cotizador"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</a></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<h5>Estampado en mangas</h5>

		<table>
			<thead>
				<tr>
					<td colspan="7" class="text-center">Una Tinta</td>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>Cantidad</th>
					<th>Costo Playera Blanca</th>
					<th>Costo Playera Color</th>
					<th>Tecnica</th>
					<th>Multiplicador 1</th>
					<th>Multiplicador 2</th>
					<th class="text-center">Opción</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($una_tinta_2->result() as $row): ?>
				<tr data-id="<?php echo $row->id_cotizador; ?>">
					<td><?php echo $row->cantidad?></td>
					<td><?php echo $row->costo_blanca?></td>
					<td><?php echo $row->costo_color?></td>
					<td><?php echo $row->tecnica?></td>
					<td><?php echo $row->multiplicador_1?></td>
					<td><?php echo $row->multiplicador_2?></td>
					<td>
						<div class="button-bar">
							<ul class="button-group round" data-id="<?php echo $row->id_cotizador;?>">
							  <li><a href="#" class="tiny button edit-cotizador"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a></li>
							  <li><a href="#" class="tiny button alert delete-cotizador"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</a></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<table>
			<thead>
				<tr>
					<td colspan="7" class="text-center">Dos Tinta</td>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>Cantidad</th>
					<th>Costo Playera Blanca</th>
					<th>Costo Playera Color</th>
					<th>Tecnica</th>
					<th>Multiplicador 1</th>
					<th>Multiplicador 2</th>
					<th class="text-center">Opción</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($dos_tinta_2->result() as $row): ?>
				<tr data-id="<?php echo $row->id_cotizador; ?>">
					<td><?php echo $row->cantidad?></td>
					<td><?php echo $row->costo_blanca?></td>
					<td><?php echo $row->costo_color?></td>
					<td><?php echo $row->tecnica?></td>
					<td><?php echo $row->multiplicador_1?></td>
					<td><?php echo $row->multiplicador_2?></td>
					<td>
						<div class="button-bar">
							<ul class="button-group round" data-id="<?php echo $row->id_cotizador;?>">
							  <li><a href="#" class="tiny button edit-cotizador"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a></li>
							  <li><a href="#" class="tiny button alert delete-cotizador"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</a></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<table>
			<thead>
				<tr>
					<td colspan="7" class="text-center">Tres Tinta</td>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>Cantidad</th>
					<th>Costo Playera Blanca</th>
					<th>Costo Playera Color</th>
					<th>Tecnica</th>
					<th>Multiplicador 1</th>
					<th>Multiplicador 2</th>
					<th class="text-center">Opción</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($tres_tinta_2->result() as $row): ?>
				<tr data-id="<?php echo $row->id_cotizador; ?>">
					<td><?php echo $row->cantidad?></td>
					<td><?php echo $row->costo_blanca?></td>
					<td><?php echo $row->costo_color?></td>
					<td><?php echo $row->tecnica?></td>
					<td><?php echo $row->multiplicador_1?></td>
					<td><?php echo $row->multiplicador_2?></td>
					<td>
						<div class="button-bar">
							<ul class="button-group round" data-id="<?php echo $row->id_cotizador;?>">
							  <li><a href="#" class="tiny button edit-cotizador"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a></li>
							  <li><a href="#" class="tiny button alert delete-cotizador"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</a></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<table>
			<thead>
				<tr>
					<td colspan="7" class="text-center">Separacion Tinta</td>
				</tr>
			</thead>
			<thead>
				<tr>
					<th>Cantidad</th>
					<th>Costo Playera Blanca</th>
					<th>Costo Playera Color</th>
					<th>Tecnica</th>
					<th>Multiplicador 1</th>
					<th>Multiplicador 2</th>
					<th class="text-center">Opción</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($separacion_tinta_2->result() as $row): ?>
				<tr data-id="<?php echo $row->id_cotizador; ?>">
					<td><?php echo $row->cantidad?></td>
					<td><?php echo $row->costo_blanca?></td>
					<td><?php echo $row->costo_color?></td>
					<td><?php echo $row->tecnica?></td>
					<td><?php echo $row->multiplicador_1?></td>
					<td><?php echo $row->multiplicador_2?></td>
					<td>
						<div class="button-bar">
							<ul class="button-group round" data-id="<?php echo $row->id_cotizador;?>">
							  <li><a href="#" class="tiny button edit-cotizador"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a></li>
							  <li><a href="#" class="tiny button alert delete-cotizador"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</a></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>


<div class="reveal-modal small" id="nueva_cotizacion" data-reveal>
	<form action="<?php echo site_url('administracion/'.$class.'/agregar'); ?>" method="post" data-abide>
		<h5 class="text-center">Agregar cotizador</h5>
		<div class="row">
			<div class="small-24 columns">
				<label>Tipo de tinta
					<select name="tipo_tinta" id="tipo_tinta">
						<option value="1">Una tinta</option>
						<option value="2">Dos tintas</option>
						<option value="3">Tres tintas</option>
						<option value="4">Separacion de color</option>
					</select>
				</label>
			</div>
			<div class="small-24 columns">
				<label>Tipo de estampado
					<select name="tipo_estampado" id="tipo_estampado">
						<option value="1">Estampado en frente y espalda</option>
						<option value="2">Estampado en mangas</option>
					</select>
				</label>
			</div>
			<div class="small-24 columns">
				<label>Cantidad
					<input type="number" value="" name="cantidad">
				</label>
			</div>
			<div class="small-24 columns">
				<label>Costo de playera blanca
					<input type="number" value="" name="costo_blanca">
				</label>
			</div>
			<div class="small-24 columns">
				<label>Costo de playera color
					<input type="number" value="" name="costo_color">
				</label>
			</div>
			<div class="small-24 columns">
				<label>Tecnica
					<select name="tecnica" id="tecnica">
						<option value="TDG">TDG</option>
						<option value="SERI">SERI</option>
						<option value="VINIL">VINIL</option>
					</select>
				</label>
			</div>
			<div class="small-24 columns">
				<label>Multiplicador 1
					<input type="number" value="" name="multiplicador_1">
				</label>
			</div>
			<div class="small-24 columns">
				<label>Multiplicador 2
					<input type="number" value="" name="multiplicador_2">
				</label>
			</div>
			<div class="small-24 columns">
				<label>Estatus
					<select name="estatus" id="estatus">
						<option value="1">Activo</option>
						<option value="0">Inactivo</option>
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

<div class="reveal-modal small" id="editar_cotizador" data-reveal>
	<form action="<?php echo site_url('administracion/'.$class.'/editar'); ?>" class="editar" method="post" data-abide>
		<h5 class="text-center">Editar cotizador</h5>
		<div class="row">
			<div class="small-24 columns">
				<label>Tipo de tinta
					<select name="tipo_tinta" id="tipo_tinta">
						<option value="1">Una tinta</option>
						<option value="2">Dos tintas</option>
						<option value="3">Tres tintas</option>
						<option value="4">Separacion de color</option>
					</select>
				</label>
			</div>
			<div class="small-24 columns">
				<label>Tipo de estampado
					<select name="tipo_estampado" id="tipo_estampado">
						<option value="1">Estampado en frente y espalda</option>
						<option value="2">Estampado en mangas</option>
					</select>
				</label>
			</div>
			<div class="small-24 columns">
				<label>Cantidad
					<input type="number" value="" name="cantidad">
				</label>
			</div>
			<div class="small-24 columns">
				<label>Costo de playera blanca
					<input type="number" value="" name="costo_blanca">
				</label>
			</div>
			<div class="small-24 columns">
				<label>Costo de playera color
					<input type="number" value="" name="costo_color">
				</label>
			</div>
			<div class="small-24 columns">
				<label>Tecnica
					<select name="tecnica" id="tecnica">
						<option value="TDG">TDG</option>
						<option value="SERI">SERI</option>
						<option value="VINIL">VINIL</option>
					</select>
				</label>
			</div>
			<div class="small-24 columns">
				<label>Multiplicador 1
					<input type="number" value="" name="multiplicador_1">
				</label>
			</div>
			<div class="small-24 columns">
				<label>Multiplicador 2
					<input type="number" value="" name="multiplicador_2">
				</label>
			</div>
			<div class="small-24 columns">
				<label>Estatus
					<select name="estatus" id="estatus">
						<option value="1">Activo</option>
						<option value="0">Inactivo</option>
					</select>
				</label>
			</div>
			<input type="hidden" value="" name="id_cotizador">
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id_categoria" id="id_categoria_mod">
				<button type="submit">Guardar cambios</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div class="reveal-modal small" id="borrar" data-reveal>
	<form action="<?php echo site_url('administracion/'.$class.'/borrar'); ?>" class="eliminar" method="post" data-abide>
		<div class="row">
			<div class="small-24 columns">
				<label style="margin-bottom:1.5rem;">¿Estás seguro de querer borrar esta cotizador? Se borrara permanentemente.</label>
			</div>
		</div>
		<div class="row">
			<div class="small-24 columns text-center">
				<input type="hidden" name="id">
				<button type="submit">Borrar cotizador</button>
			</div>
		</div>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>