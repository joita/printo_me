<h2 class="seccionador show-for-medium text-left" style="color: #025573;font-weight: bold">Venta Inmediata</h2>

<div class="row small-collapse medium-uncollapse">
    <input id="tipo" type="hidden" value="fijo">
	<div class="small-18 columns">
		<?php if(sizeof($campanas) > 0): ?>
		<table id="datos" class="campanas-cuenta nowrap" style="width:100%; border: 2px solid #025573; background: none; border-radius: 10px">
			<thead style="border: 2px solid #025573; background: none; border-radius: 10px">
				<tr>
                    <th style="color: #025573" class="text-center"></th>
					<th style="color: #025573" class="text-center" id="imagen-campana">Imagen</th>
					<th style="color: #025573" class="text-center" id="tiempo-restante">Campaña</th>
                    <th style="color: #025573" class="text-center" id="precio-campana">Precio</th>
                    <th style="color: #025573" class="text-center" id="ganancia-campana">Ganancia</th>
                    <th style="color: #025573" class="text-center" id="vendidos-campana">Vendidos</th>
                    <th style="color: #025573" class="text-center" id="ganancia-total">Ganancia Total</th>
                    <th style="color: #025573" class="text-center" id="avance-campana">Avance</th>
				</tr>
			</thead>
			<tbody>
            <!--GENERADO POR SERVERSIDE DATATABLES-->
			</tbody>
		</table>
		<?php else: ?>
		<div class="form-cuenta text-center">
			<p>No tienes productos activos.</p>
		</div>
		<?php endif; ?>
	</div>
</div>